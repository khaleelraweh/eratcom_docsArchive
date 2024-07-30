<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MainSliderRequest;
use App\Models\Slider;
use App\Models\Tag;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MainSliderController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_main_sliders , show_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSliders = Slider::with('firstMedia')
            ->MainSliders()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);


        return view('backend.main_sliders.index', compact('mainSliders'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_main_sliders')) {
            return redirect('admin/index');
        }

        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.main_sliders.create', compact('tags'));
    }

    public function store(MainSliderRequest $request)
    {

        if (!auth()->user()->ability('admin', 'create_main_sliders')) {
            return redirect('admin/index');
        }

        $input['title']          =   $request->title;
        $input['description']        =   $request->description;
        $input['url']            =   $request->url;
        $input['target']         =   $request->target;
        $input['section']        =   1;

        $input['showInfo']            =   $request->showInfo;
        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $mainSlider = Slider::create($input);

        $mainSlider->tags()->attach($request->tags);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $image) {
                $file_name = $mainSlider->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/main_sliders/' . $file_name);

                // Image::make($image->getRealPath())->resize(500,null,function($constraint){
                //     $constraint->aspectRatio();
                // })->save($path,100);

                Image::make($image->getRealPath())->save($path);

                $mainSlider->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($mainSlider) {
            return redirect()->route('admin.main_sliders.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.main_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_sliders')) {
            return redirect('admin/index');
        }

        return view('backend.main_sliders.show');
    }


    public function edit($mainSlider)
    {
        if (!auth()->user()->ability('admin', 'update_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSlider =  Slider::where('id', $mainSlider)->first();
        $tags = Tag::whereStatus(1)->get(['id', 'name']);
        return view('backend.main_sliders.edit', compact('tags', 'mainSlider'));
    }

    public function update(MainSliderRequest $request,  $mainSlider)
    {
        if (!auth()->user()->ability('admin', 'update_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSlider = Slider::where('id', $mainSlider)->first();


        $input['title']          =   $request->title;
        $input['description']        =   $request->description;
        $input['url']            =   $request->url;
        $input['target']         =   $request->target;
        $input['section']        =   1;
        //  $input['start_date']        =   $request->start_date;
        //  $input['expire_date']       =   $request->expire_date;

        $input['showInfo']            =   $request->showInfo;
        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        $mainSlider->update($input);
        $mainSlider->tags()->sync($request->tags);

        if ($request->images && count($request->images) > 0) {

            $i = $mainSlider->photos->count() + 1;

            foreach ($request->images as $image) {

                $file_name = $mainSlider->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/main_sliders/' . $file_name);

                // Image::make($image->getRealPath())->resize(500,null,function($constraint){
                //     $constraint->aspectRatio();
                // })->save($path,100);

                Image::make($image->getRealPath())->save($path);
                $mainSlider->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($mainSlider) {
            return redirect()->route('admin.main_sliders.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.main_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($mainSlider)
    {
        if (!auth()->user()->ability('admin', 'delete_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSlider = Slider::where('id', $mainSlider)->first();


        if ($mainSlider->photos->count() > 0) {
            foreach ($mainSlider->photos as $photo) {
                if (File::exists('assets/main_sliders/' . $photo->file_name)) {
                    unlink('assets/main_sliders/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $mainSlider->delete();

        if ($mainSlider) {
            return redirect()->route('admin.main_sliders.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.main_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_main_sliders')) {
            return redirect('admin/index');
        }


        $slider = Slider::findOrFail($request->slider_id);

        $image = $slider->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/main_sliders/' . $image->file_name)) {
            unlink('assets/main_sliders/' . $image->file_name);
        }
        $image->delete();

        return true;
    }
}
