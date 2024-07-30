<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class DocumentCategoriescontroller extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_document_categories , show_document_categories')) {
            return redirect('admin/index');
        }

        $documentCategories = DocumentCategory::all();

        return view('backend.document_categories.index', compact('documentCategories'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_categories')) {
            return redirect('admin/index');
        }

        return view('backend.document_categories.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_categories')) {
            return redirect('admin/index');
        }

        $input['doc_cat_name']      =   $request->doc_cat_name;
        $input['doc_cat_note']      =   $request->doc_cat_note;
        $input['created_by']        =   auth()->user()->full_name;
        $input['published_on']      =   $request->published_on;
        $input['status']            =   $request->status;

        $documentCategory = DocumentCategory::create($input);


        if ($documentCategory) {
            return redirect()->route('admin.document_categories.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function edit($documentCategory)
    {
        if (!auth()->user()->ability('admin', 'update_document_categories')) {
            return redirect('admin/index');
        }

        $documentCategory = DocumentCategory::where('id', $documentCategory)->first();

        return view('backend.document_categories.edit', compact('documentCategory'));
    }

    public function update(Request $request,  $documentCategory)
    {
        if (!auth()->user()->ability('admin', 'update_document_categories')) {
            return redirect('admin/index');
        }
        $documentCategory = DocumentCategory::where('id', $documentCategory)->first();

        $input['doc_cat_name']      =   $request->doc_cat_name;
        $input['doc_cat_note']      =   $request->doc_cat_note;
        $input['updated_by']        =   auth()->user()->full_name;
        $input['published_on']      =   $request->published_on;
        $input['status']            =   $request->status;

        $documentCategory->update($input);

        if ($documentCategory) {
            return redirect()->route('admin.document_categories.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($documentCategory)
    {

        if (!auth()->user()->ability('admin', 'delete_document_categories')) {
            return redirect('admin/index');
        }

        $documentCategory = DocumentCategory::where('id', $documentCategory)->first();




        $documentCategory->deleted_by = auth()->user()->full_name;
        $documentCategory->save();
        $documentCategory->delete();


        if ($documentCategory) {
            return redirect()->route('admin.document_categories.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
