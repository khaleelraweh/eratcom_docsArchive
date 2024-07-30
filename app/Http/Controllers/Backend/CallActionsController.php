<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CallActionRequest;
use App\Models\CallAction;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CallActionsController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_call_actions , show_call_actions')) {
            return redirect('admin/index');
        }

        $callActions = CallAction::with('firstMedia')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);


        return view('backend.call_actions.index', compact('callActions'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_call_actions')) {
            return redirect('admin/index');
        }

        return view('backend.call_actions.create');
    }

    public function store(CallActionRequest $request)
    {


        if (!auth()->user()->ability('admin', 'create_call_actions')) {
            return redirect('admin/index');
        }

        $input['title']                 =   $request->title;
        $input['description']           =   $request->description;
        $input['btn_name']              =   $request->btn_name;
        $input['btn_link']              =   $request->btn_link;
        $input['target']                =   $request->target;
        $input['section']               =   1;

        $input['showInfo']              =   $request->showInfo;
        $input['status']                =   $request->status;
        $input['created_by']            =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $callAction = CallAction::create($input);


        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $image) {
                $file_name = $callAction->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/call_actions/' . $file_name);

                Image::make($image->getRealPath())->save($path);

                $callAction->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($callAction) {
            return redirect()->route('admin.call_actions.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.call_actions.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_sliders')) {
            return redirect('admin/index');
        }

        return view('backend.call_actions.show');
    }


    public function edit($callAction)
    {
        if (!auth()->user()->ability('admin', 'update_call_actions')) {
            return redirect('admin/index');
        }

        $callAction =  CallAction::where('id', $callAction)->first();
        return view('backend.call_actions.edit', compact('callAction'));
    }

    public function update(CallActionRequest $request,  $callAction)
    {
        if (!auth()->user()->ability('admin', 'update_call_actions')) {
            return redirect('admin/index');
        }

        $callAction = CallAction::where('id', $callAction)->first();


        $input['title']          =   $request->title;
        $input['description']        =   $request->description;
        $input['btn_name']            =   $request->btn_name;
        $input['btn_link']            =   $request->btn_link;
        $input['target']         =   $request->target;
        $input['section']        =   1;


        $input['showInfo']            =   $request->showInfo;
        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        $callAction->update($input);

        if ($request->images && count($request->images) > 0) {

            $i = $callAction->photos->count() + 1;

            foreach ($request->images as $image) {

                $file_name = $callAction->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/call_actions/' . $file_name);



                Image::make($image->getRealPath())->save($path);
                $callAction->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($callAction) {
            return redirect()->route('admin.call_actions.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.call_actions.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($callAction)
    {
        if (!auth()->user()->ability('admin', 'delete_call_actions')) {
            return redirect('admin/index');
        }

        $callAction = CallAction::where('id', $callAction)->first();


        if ($callAction->photos->count() > 0) {
            foreach ($callAction->photos as $photo) {
                if (File::exists('assets/call_actions/' . $photo->file_name)) {
                    unlink('assets/call_actions/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $callAction->delete();

        if ($callAction) {
            return redirect()->route('admin.call_actions.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.call_actions.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_call_actions')) {
            return redirect('admin/index');
        }


        $callAction = CallAction::findOrFail($request->call_action_id);

        $image = $callAction->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/call_actions/' . $image->file_name)) {
            unlink('assets/call_actions/' . $image->file_name);
        }
        $image->delete();

        return true;
    }
}
