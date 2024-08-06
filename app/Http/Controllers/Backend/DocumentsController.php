<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

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
}
