<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use PDF;


class DocumentsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_documents , show_documents')) {
            return redirect('admin/index');
        }

        $documents = Document::all();

        return view('backend.documents.index', compact('documents'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_documents')) {
            return redirect('admin/index');
        }
        return view('backend.documents.create');
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_documents')) {
            return redirect('admin/index');
        }
        $document = Document::findOrFail($id);
        return view('backend.documents.show', compact('document'));
    }


    public function print($id)
    {
        $document = Document::findOrFail($id);
        return view('backend.documents.print', compact('document'));
    }


    public function pdf($id)
    {
        $document = Document::findOrFail($id);

        // $data['doc_id']         =  $document->id;
        // $data['doc_no']         =  $document->doc_no;
        // $data['doc_name']       =  $document->doc_name;
        // $data['doc_content']    =  $document->doc_content;
        // $data['doc_type']       =  $document->doc_type;
        // $data['doc_status']     =  $document->doc_status;
        // $data['created_by']     =  $document->created_by;
        // $data['created_at']     =  $document->created_at;


        $data['doc_id']         =  'khaleel';

        // المكان الذي يوجد فيه ملف ال pdf.blade.php  
        // نقوم بارسال البيانات اليه من اجل عرضها في ذلك الملف 
        $pdf = PDF::loadView('backend.documents.pdf', $data);


        // لطباعة ملف البيدي اف باسم معين وفي المسار المعين 
        return $pdf->stream($document->id . '.pdf');



        return view('backend.documents.pdf', compact('document'));
    }
}
