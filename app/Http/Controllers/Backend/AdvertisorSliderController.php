<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdvertisorSliderRequest;
use App\Models\Slider;
use App\Models\Tag;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdvertisorSliderController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_advertisor_sliders , show_advertisor_sliders')) {
            return redirect('admin/index');
        }

        $advertisorSliders = Slider::with('firstMedia')
            ->AdvertisorSliders()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);


        return view('backend.advertisor_sliders.index', compact('advertisorSliders'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_advertisor_sliders')) {
            return redirect('admin/index');
        }

        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.advertisor_sliders.create', compact('tags'));
    }

    public function store(AdvertisorSliderRequest $request)
    {

        if (!auth()->user()->ability('admin', 'create_advertisor_sliders')) {
            return redirect('admin/index');
        }

        $input['icon']         =   $request->icon;
        $input['title']          =   $request->title;
        $input['description']        =   $request->description;
        $input['url']            =   $request->url;
        $input['target']         =   $request->target;
        $input['section']        =   2;

        $input['showInfo']            =   $request->showInfo;
        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $advertisorSlider = Slider::create($input);

        $advertisorSlider->tags()->attach($request->tags);



        if ($advertisorSlider) {
            return redirect()->route('admin.advertisor_sliders.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.advertisor_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_sliders')) {
            return redirect('admin/index');
        }

        return view('backend.advertisor_sliders.show');
    }


    public function edit($advertisorSlider)
    {
        if (!auth()->user()->ability('admin', 'update_advertisor_sliders')) {
            return redirect('admin/index');
        }

        $advertisorSlider =  Slider::where('id', $advertisorSlider)->first();
        $tags = Tag::whereStatus(1)->get(['id', 'name']);
        return view('backend.advertisor_sliders.edit', compact('tags', 'advertisorSlider'));
    }

    public function update(AdvertisorSliderRequest $request,  $advertisorSlider)
    {
        if (!auth()->user()->ability('admin', 'update_advertisor_sliders')) {
            return redirect('admin/index');
        }

        $advertisorSlider = Slider::where('id', $advertisorSlider)->first();


        $input['icon']         =   $request->icon;
        $input['title']          =   $request->title;
        $input['description']        =   $request->description;
        $input['url']            =   $request->url;
        $input['target']         =   $request->target;
        $input['section']        =   2;

        $input['showInfo']            =   $request->showInfo;
        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        $advertisorSlider->update($input);
        $advertisorSlider->tags()->sync($request->tags);



        if ($advertisorSlider) {
            return redirect()->route('admin.advertisor_sliders.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.advertisor_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($advertisorSlider)
    {
        if (!auth()->user()->ability('admin', 'delete_advertisor_sliders')) {
            return redirect('admin/index');
        }

        $advertisorSlider = Slider::where('id', $advertisorSlider)->first();


        if ($advertisorSlider->photos->count() > 0) {
            foreach ($advertisorSlider->photos as $photo) {
                if (File::exists('assets/advertisor_sliders/' . $photo->file_name)) {
                    unlink('assets/advertisor_sliders/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $advertisorSlider->delete();

        if ($advertisorSlider) {
            return redirect()->route('admin.advertisor_sliders.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.advertisor_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_advertisor_sliders')) {
            return redirect('admin/index');
        }


        $slider = Slider::findOrFail($request->slider_id);

        $image = $slider->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/advertisor_sliders/' . $image->file_name)) {
            unlink('assets/advertisor_sliders/' . $image->file_name);
        }
        $image->delete();

        return true;
    }
}
