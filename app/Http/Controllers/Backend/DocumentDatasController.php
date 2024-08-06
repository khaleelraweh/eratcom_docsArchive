<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DocumentData;
use Illuminate\Http\Request;

class DocumentDatasController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_document_datas , show_document_datas')) {
            return redirect('admin/index');
        }

        $documenDatas = DocumentData::all();

        return view('backend.document_datas.index', compact('documenDatas'));
    }
}
