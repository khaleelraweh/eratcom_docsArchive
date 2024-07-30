<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypesController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_document_types , show_document_types')) {
            return redirect('admin/index');
        }

        $documentTypes = DocumentType::all();

        return view('backend.document_types.index', compact('documentTypes'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_types')) {
            return redirect('admin/index');
        }

        $documentCategories = DocumentCategory::whereStatus(1)->get(['id', 'doc_cat_name']);

        return view('backend.document_types.create', compact('documentCategories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_types')) {
            return redirect('admin/index');
        }

        $input['doc_type_name']             =   $request->doc_type_name;
        $input['doc_type_note']             =   $request->doc_type_note;
        $input['document_category_id']      =   $request->document_category_id;
        $input['created_by']                =   auth()->user()->full_name;
        $input['published_on']              =   $request->published_on;
        $input['status']                    =   $request->status;

        $documentType = DocumentType::create($input);


        if ($documentType) {
            return redirect()->route('admin.document_types.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_types.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function edit($documentType)
    {
        if (!auth()->user()->ability('admin', 'update_document_types')) {
            return redirect('admin/index');
        }

        $documentCategories = DocumentCategory::Active()->get(['id', 'doc_cat_name']);

        $documentType = DocumentType::where('id', $documentType)->first();

        return view('backend.document_types.edit', compact('documentCategories', 'documentType'));
    }

    public function update(Request $request,  $documentType)
    {
        if (!auth()->user()->ability('admin', 'update_document_types')) {
            return redirect('admin/index');
        }
        $documentType = DocumentType::where('id', $documentType)->first();

        $input['doc_type_name']      =   $request->doc_type_name;
        $input['doc_type_note']      =   $request->doc_type_note;
        $input['updated_by']        =   auth()->user()->full_name;
        $input['published_on']      =   $request->published_on;
        $input['status']            =   $request->status;

        $documentType->update($input);

        if ($documentType) {
            return redirect()->route('admin.document_types.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_types.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($documentType)
    {

        if (!auth()->user()->ability('admin', 'delete_document_types')) {
            return redirect('admin/index');
        }

        $documentType = DocumentType::where('id', $documentType)->first();

        $documentType->deleted_by = auth()->user()->full_name;
        $documentType->save();
        $documentType->delete();

        if ($documentType) {
            return redirect()->route('admin.document_types.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.document_types.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
