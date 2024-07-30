<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseCategoryRequest;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use DateTimeImmutable;

class CourseCategoriesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_course_categories , show_course_categories')) {
            return redirect('admin/index');
        }

        $categories = CourseCategory::withCount('courses')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.course_categories.index', compact('categories'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_course_categories')) {
            return redirect('admin/index');
        }

        return view('backend.course_categories.create');
    }

    public function store(CourseCategoryRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_course_categories')) {
            return redirect('admin/index');
        }



        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['icon']     = $request->icon;
        $input['created_by'] = auth()->user()->full_name;
        $input['featured'] = $request->featured;

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $courseCategory = CourseCategory::create($input);

        // add images to media db and to path : public/assets/products
        if ($request->images && count($request->images) > 0) {

            $i = 1; // $i is used for making sort to image 

            foreach ($request->images as $image) {

                // $file_name = Str::slug($request->name).".".$image->getClientOriginalExtension(); // will not used because product already created to db and slug is there by steps upove
                $file_name = $courseCategory->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/course_categories/' . $file_name);

                Image::make($image->getRealPath())->save($path);

                // add this media to db using media relational function
                $courseCategory->photo()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++; // step ahead by one for sort new image 
            }
        }

        if ($courseCategory) {
            return redirect()->route('admin.course_categories.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.course_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_course_categories')) {
            return redirect('admin/index');
        }
        return view('backend.course_categories.show');
    }


    public function edit($courseCategory)
    {
        if (!auth()->user()->ability('admin', 'update_course_categories')) {
            return redirect('admin/index');
        }

        $courseCategory = CourseCategory::where('id', $courseCategory)->first();

        return view('backend.course_categories.edit', compact('courseCategory'));
    }

    public function update(CourseCategoryRequest $request,  $courseCategory)
    {
        if (!auth()->user()->ability('admin', 'update_course_categories')) {
            return redirect('admin/index');
        }


        $courseCategory = CourseCategory::where('id', $courseCategory)->first();


        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['icon'] = $request->icon;
        $input['updated_by'] = auth()->user()->full_name;
        $input['featured'] = $request->featured;

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $courseCategory->update($input);



        // edit images in media db and in path : public/assets/products
        if ($request->images && count($request->images) > 0) {

            $i = $courseCategory->photo()->count() + 1; // $i is used for making sort to image 

            foreach ($request->images as $image) {

                // $file_name = Str::slug($request->name).".".$image->getClientOriginalExtension(); // will not used because product already created to db and slug is there by steps upove
                $file_name = $courseCategory->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/course_categories/' . $file_name);

                Image::make($image->getRealPath())->save($path);

                // add this media to db using media relational function
                $courseCategory->photo()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++; // step ahead by one for sort new image 
            }
        }


        if ($courseCategory) {
            return redirect()->route('admin.course_categories.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.course_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($courseCategory)
    {

        if (!auth()->user()->ability('admin', 'delete_course_categories')) {
            return redirect('admin/index');
        }

        $courseCategory = CourseCategory::where('id', $courseCategory)->first();


        if ($courseCategory->photo()->count() > 0) {
            foreach ($courseCategory->photo() as $photo) {

                if (File::exists('assets/course_categories/' . $photo->file_name)) {
                    unlink('assets/course_categories/' . $photo->file_name);
                }

                $photo->delete();
            }
        }

        $courseCategory->deleted_by = auth()->user()->full_name;
        $courseCategory->save();
        $courseCategory->delete();


        if ($courseCategory) {
            return redirect()->route('admin.course_categories.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.course_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_course_categories')) {
            return redirect('admin/index');
        }

        // dd($request);

        $courseCategory = CourseCategory::findOrFail($request->course_category_id);

        //find media image from media table 
        $image = $courseCategory->photo()->whereId($request->image_id)->first();

        if (File::exists('assets/course_categories/' . $image->file_name)) {
            unlink('assets/course_categories/' . $image->file_name);
        }

        $image->delete();

        return true;
    }
}
