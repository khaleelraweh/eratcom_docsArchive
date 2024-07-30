<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EventRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Tag;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_events , show_events')) {
            return redirect('admin/index');
        }

        $events = Course::with('courseCategory', 'tags')
            ->ActiveCourseCategory()
            ->Event()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.events.index', compact('events'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_events')) {
            return redirect('admin/index');
        }

        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);
        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        // Get active instructor
        $instructors = User::WhereHasRoles('instructor')->active()->get(['id', 'first_name', 'last_name']);

        return view('backend.events.create', compact('course_categories', 'tags', 'instructors'));
    }

    public function store(EventRequest $request)
    {

        if (!auth()->user()->ability('admin', 'create_events')) {
            return redirect('admin/index');
        }

        // dd($request);

        $input['title']                         =   $request->title;
        $input['subtitle']                      =   $request->subtitle;
        $input['description']                   =   $request->description;

        $input['skill_level']                   =   $request->skill_level;
        $input['language']                      =   $request->language;
        $input['evaluation']                    =   $request->evaluation;
        $input['lecture_numbers']               =   $request->lecture_numbers;
        $input['course_duration']               =   $request->course_duration;

        // by alyemeni
        $input['video_promo']                   =  $request->video_promo;
        $input['video_description']             =  $request->video_description;
        $input['course_type']                   =  $request->course_type;

        $input['deadline']                      =  $request->deadline;
        $input['certificate']                   =  $request->certificate;

        $input['price']                         =   $request->price;
        $input['offer_price']                   =   $request->offer_price;
        $input['offer_ends']                    =   $request->offer_ends;

        $input['course_category_id']            =   $request->course_category_id;
        $input['featured']                      =   $request->featured;
        $input['section']                       =   2;

        $input['start_date']                    =  $request->start_date;
        $input['end_date']                      =  $request->end_date;
        $input['start_time']                    =  $request->start_time;
        $input['end_time']                      =  $request->end_time;
        $input['address']                       =  $request->address;

        $input['status']                        =   $request->status;
        $input['created_by']                    =   auth()->user()->full_name;

        $published_on                           =   $request->published_on . ' ' . $request->published_on_time;
        $published_on                           =   new DateTimeImmutable($published_on);
        $input['published_on']                  =   $published_on;

        $event                                 =   Course::create($input);

        $event->tags()->attach($request->tags);

        //add instructors
        if (isset($request->instructors) && count($request->instructors) > 0) {
            $event->users()->sync($request->instructors);
        } else {
            // If $request->instructors is not set or empty, assign the currently logged-in user as the instructor
            $loggedInUser = Auth::user();
            $event->users()->sync([$loggedInUser->id]);
        }

        // course topics start 
        if ($request->course_topic != null) {
            $topics_list = [];
            for ($i = 0; $i < count($request->course_topic); $i++) {
                $topics_list[$i]['title'] = $request->course_topic[$i];
            }

            // dd($topics_list);
            $topics = $event->topics()->createMany($topics_list);
        }
        // course topics start 


        // course requirement start 
        if ($request->course_requirement != null) {
            $requirements_list = [];
            for ($i = 0; $i < count($request->course_requirement); $i++) {
                $requirements_list[$i]['title'] = $request->course_requirement[$i];
            }
            // dd($requirements_list);
            $requirements = $event->requirements()->createMany($requirements_list);
        }
        // course topics start 



        if ($request->images && count($request->images) > 0) {

            $i = 1;

            foreach ($request->images as $image) {

                $file_name = $event->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/courses/' . $file_name);

                Image::make($image->getRealPath())->save($path);

                $event->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($event) {
            return redirect()->route('admin.events.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.events.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_events')) {
            return redirect('admin/index');
        }

        return view('backend.events.show');
    }

    public function edit($event)
    {

        if (!auth()->user()->ability('admin', 'update_events')) {
            return redirect('admin/index');
        }


        $event = Course::where('id', $event)->first();

        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);

        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        // Get active instructor
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->active()->get(['id', 'first_name', 'last_name']);


        $courseinstructors = $event->users->pluck(['id'])->toArray();

        return view('backend.events.edit', compact('course_categories', 'tags', 'event', 'instructors', 'courseinstructors'));
    }

    public function update(EventRequest $request,  $event)
    {
        if (!auth()->user()->ability('admin', 'update_events')) {
            return redirect('admin/index');
        }


        $event = Course::where('id', $event)->first();


        // get Input from create.blade.php form request using CourseRequest to validate fields
        $input['title']                   =   $request->title;
        $input['subtitle']                  =   $request->subtitle;
        $input['description']                   =   $request->description;

        $input['skill_level']                      =   $request->skill_level;
        $input['language']                       =   $request->language;
        $input['evaluation']                 =   $request->evaluation;
        $input['lecture_numbers']             =   $request->lecture_numbers;
        $input['course_duration']               =   $request->course_duration;

        $input['video_promo']           =  $request->video_promo;
        $input['video_description']           =  $request->video_description;
        $input['course_type']           =  $request->course_type;

        $input['deadline']           =  $request->deadline;
        $input['certificate']           =  $request->certificate;

        $input['price']                 =   $request->price;
        $input['offer_price']           =   $request->offer_price;
        $input['offer_ends']            =   $request->offer_ends;


        $input['course_category_id']   =   $request->course_category_id;
        $input['featured']              =   $request->featured;

        $input['start_date']                    =  $request->start_date;
        $input['end_date']                      =  $request->end_date;
        $input['start_time']                    =  $request->start_time;
        $input['end_time']                      =  $request->end_time;
        $input['address']                       =  $request->address;

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $event->update($input);

        $event->tags()->sync($request->tags);

        // Update instructors
        if (isset($request->instructors) && count($request->instructors) > 0) {
            $event->users()->sync($request->instructors);
        } else {
            // If $request->instructors is not set or empty, assign the currently logged-in user as the instructor
            $loggedInUser = Auth::user();
            $event->users()->sync([$loggedInUser->id]);
        }

        // course topics start 
        $event->topics()->delete();

        if ($request->course_topic != null) {
            $topics_list = [];
            for ($i = 0; $i < count($request->course_topic); $i++) {
                $topics_list[$i]['title'] = $request->course_topic[$i];
            }
            // dd($topics_list);
            $topics = $event->topics()->createMany($topics_list);
        }
        // course topics start 


        // course requirement start 
        $event->requirements()->delete();
        if ($request->course_requirement != null) {
            $requirements_list = [];
            for ($i = 0; $i < count($request->course_requirement); $i++) {
                $requirements_list[$i]['title'] = $request->course_requirement[$i];
            }
            // dd($requirements_list);
            $requirements = $event->requirements()->createMany($requirements_list);
        }

        // course topics start 


        if ($request->images && count($request->images) > 0) {

            $i = $event->photos->count() + 1;

            foreach ($request->images as $image) {

                $file_name = $event->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/courses/' . $file_name);

                Image::make($image->getRealPath())->save($path);

                $event->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($event) {
            return redirect()->route('admin.events.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.events.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($event)
    {
        if (!auth()->user()->ability('admin', 'delete_events')) {
            return redirect('admin/index');
        }

        $event = Course::where('id', $event)->first();


        if ($event->photos->count() > 0) {
            foreach ($event->photos as $photo) {
                if (File::exists('assets/courses/' . $photo->file_name)) {
                    unlink('assets/courses/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $event->delete();

        if ($event) {
            return redirect()->route('admin.events.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.events.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_events')) {
            return redirect('admin/index');
        }

        $event = Course::findOrFail($request->course_id);

        $image = $event->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/courses/' . $image->file_name)) {
            unlink('assets/courses/' . $image->file_name);
        }
        $image->delete();

        return true;
    }
}
