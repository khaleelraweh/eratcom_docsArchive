<?php

namespace App\Http\Controllers\Frontend\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Instructor\CourseRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_courses , show_courses')) {
            return redirect('admin/index');
        }

        $courses = Course::with('courseCategory', 'tags', 'firstMedia')
            ->ActiveCourseCategory()
            ->Course()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.courses.index', compact('courses'));
    }

    public function create()
    {
        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);
        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        // Get active instructor
        $instructors = User::WhereHasRoles('instructor')->active()->get(['id', 'first_name', 'last_name']);


        return view('frontend.instructor.courses.create', compact('course_categories', 'tags', 'instructors'));
    }

    public function store(CourseRequest $request)
    {

        $input['title']                         =   $request->title;
        $input['subtitle']                      =   $request->subtitle;
        $input['course_category_id']            =   $request->course_category_id;
        $input['created_by']                    =   auth()->user()->full_name;
        $course                                 =   Course::create($input);

        $loggedInUser = Auth::user();
        $course->users()->sync([$loggedInUser->id]);


        if ($course) {
            return redirect()->route('instructor.dashboard')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('instructor.dashboard')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_courses')) {
            return redirect('admin/index');
        }

        return view('backend.courses.show');
    }

    public function edit($course)
    {

        $course = Course::where('id', $course)->first();

        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);

        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        // Get active instructor
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->active()->get(['id', 'first_name', 'last_name']);


        $courseinstructors = $course->users->pluck(['id'])->toArray();


        return view('frontend.instructor.courses.edit', compact('course_categories', 'tags', 'course', 'instructors', 'courseinstructors'));
    }

    public function update(CourseRequest $request,  $course)
    {
        if (!auth()->user()->ability('admin', 'update_courses')) {
            return redirect('admin/index');
        }


        $course = Course::where('id', $course)->first();


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

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $course->update($input);

        $course->tags()->sync($request->tags);

        // Update instructors
        if (isset($request->instructors) && count($request->instructors) > 0) {
            $course->users()->sync($request->instructors);
        } else {
            // If $request->instructors is not set or empty, assign the currently logged-in user as the instructor
            $loggedInUser = Auth::user();
            $course->users()->sync([$loggedInUser->id]);
        }

        // course topics start 
        $course->topics()->delete();

        if ($request->course_topic != null) {
            $topics_list = [];
            for ($i = 0; $i < count($request->course_topic); $i++) {
                $topics_list[$i]['title'] = $request->course_topic[$i];
            }
            // dd($topics_list);
            $topics = $course->topics()->createMany($topics_list);
        }
        // course topics start 


        // course requirement start 
        $course->requirements()->delete();
        if ($request->course_requirement != null) {
            $requirements_list = [];
            for ($i = 0; $i < count($request->course_requirement); $i++) {
                $requirements_list[$i]['title'] = $request->course_requirement[$i];
            }
            // dd($requirements_list);
            $requirements = $course->requirements()->createMany($requirements_list);
        }

        // course topics start 


        if ($request->images && count($request->images) > 0) {

            $i = $course->photos->count() + 1;

            foreach ($request->images as $image) {

                $file_name = $course->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/courses/' . $file_name);

                Image::make($image->getRealPath())->save($path);

                $course->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($course) {
            return redirect()->route('admin.courses.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.courses.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($course)
    {
        if (!auth()->user()->ability('admin', 'delete_courses')) {
            return redirect('admin/index');
        }

        $course = Course::where('id', $course)->first();


        if ($course->photos->count() > 0) {
            foreach ($course->photos as $photo) {
                if (File::exists('assets/courses/' . $photo->file_name)) {
                    unlink('assets/courses/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $course->delete();

        if ($course) {
            return redirect()->route('admin.courses.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.courses.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_courses')) {
            return redirect('admin/index');
        }

        $course = Course::findOrFail($request->course_id);

        $image = $course->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/courses/' . $image->file_name)) {
            unlink('assets/courses/' . $image->file_name);
        }
        $image->delete();

        return true;
    }
}
