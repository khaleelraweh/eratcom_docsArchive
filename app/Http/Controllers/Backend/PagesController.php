<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PageRequest;
use App\Models\Page;
use App\Models\WebMenu;
use DateTimeImmutable;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_pages , show_pages')) {
            return redirect('admin/index');
        }

        $pages = Page::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);



        return view('backend.pages.index', compact('pages'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }


        return view('backend.pages.create');
    }

    public function store(PageRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }



        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $page = Page::create($input);


        if ($page) {
            return redirect()->route('admin.pages.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_pages')) {
            return redirect('admin/index');
        }
        return view('backend.pages.show');
    }

    public function edit($page)
    {
        if (!auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin/index');
        }


        $page = Page::where('id', $page)->first();

        return view('backend.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, $page)
    {

        $page = Page::where('id', $page)->first();

        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $page->update($input);

        if ($page) {
            return redirect()->route('admin.pages.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function destroy($page)
    {
        if (!auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin/index');
        }

        $page = Page::where('id', $page)->first()->delete();

        if ($page) {
            return redirect()->route('admin.pages.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
