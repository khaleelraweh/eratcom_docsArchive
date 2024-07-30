<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\DocumentArchive;
use App\Models\DocumentCategory;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class DocumentArchivesController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_document_archives , show_document_archives')) {
            return redirect('admin/index');
        }

        $documentArchives = DocumentArchive::all();

        return view('backend.document_archives.index', compact('documentArchives'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_archives')) {
            return redirect('admin/index');
        }

        $documentCategories = DocumentCategory::whereStatus(1)->get(['id', 'doc_cat_name']);
        $documentTypes = DocumentType::whereStatus(1)->get(['id', 'doc_type_name']);


        return view('backend.document_archives.create', compact('documentCategories', 'documentTypes'));
    }



    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_archives')) {
            return redirect('admin/index');
        }



        $validatedData = $request->validate([
            'document_category_id' => 'required|numeric',
            'document_type_id' => 'required|numeric',
            'doc_archive_name' => 'required|string',
            'published_on' => 'required|date',
            'doc_archive_attached_file' => 'nullable|file|mimes:pdf,docx|max:2048', // Validate each file

        ]);

        $data['document_category_id']      = $validatedData['document_category_id'];
        $data['document_type_id']          = $validatedData['document_type_id'];
        $data['doc_archive_name']          = $validatedData['doc_archive_name'];
        $data['published_on']              = $validatedData['published_on'];
        $data['created_by']                = auth()->user()->full_name;


        // Handle file uploads
        if ($file = $request->file('doc_archive_attached_file')) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('assets/document_archives');
            $file->move($filePath, $fileName); // Move image file
            $data['doc_archive_attached_file'] = $fileName;
        }

        $documentArchive = DocumentArchive::create($data);

        if ($documentArchive) {
            return redirect()->route('admin.document_archives.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_archives.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function edit($documentArchive)
    {
        if (!auth()->user()->ability('admin', 'update_document_archives')) {
            return redirect('admin/index');
        }

        $documentArchive = DocumentArchive::where('id', $documentArchive)->first();

        return view('backend.document_archives.edit', compact('documentArchive'));
    }

    public function update(Request $request,  $documentArchive)
    {
        if (!auth()->user()->ability('admin', 'update_document_archives')) {
            return redirect('admin/index');
        }
        $documentArchive = DocumentArchive::where('id', $documentArchive)->first();


        $validatedData = $request->validate([
            'document_category_id' => 'required|numeric',
            'document_type_id' => 'required|numeric',
            'doc_archive_name' => 'required|string',
            'published_on' => 'required|date',
            'doc_archive_attached_file' => 'nullable|file|mimes:pdf,docx|max:2048', // Validate each file

        ]);

        $data['document_category_id']       = $validatedData['document_category_id'];
        $data['document_type_id']           = $validatedData['document_type_id'];
        $data['doc_archive_name']           = $validatedData['doc_archive_name'];
        $data['published_on']               = $validatedData['published_on'];
        $data['updated_by']                 = auth()->user()->full_name;
        $data['status']                     = $request->status;


        // remove the file if exist 
        if (File::exists('assets/document_archives/' . $documentArchive->doc_archive_attached_file)) {
            unlink('assets/document_archives/' . $documentArchive->doc_archive_attached_file);
        }

        // Handle file uploads
        if ($file = $request->file('doc_archive_attached_file')) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('assets/document_archives');
            $file->move($filePath, $fileName); // Move image file
            $data['doc_archive_attached_file'] = $fileName;
        }

        $documentArchive->update($data);

        if ($documentArchive) {
            return redirect()->route('admin.document_archives.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_archives.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($documentArchive)
    {

        if (!auth()->user()->ability('admin', 'delete_document_archives')) {
            return redirect('admin/index');
        }

        $documentArchive = DocumentArchive::where('id', $documentArchive)->first();

        $documentArchive->deleted_by = auth()->user()->full_name;
        $documentArchive->save();
        $documentArchive->delete();

        if ($documentArchive) {
            return redirect()->route('admin.document_archives.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.document_archives.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
