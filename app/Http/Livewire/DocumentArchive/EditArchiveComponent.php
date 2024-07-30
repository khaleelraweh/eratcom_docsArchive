<?php

namespace App\Http\Livewire\DocumentArchive;

use App\Models\DocumentCategory;
use App\Models\DocumentType;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditArchiveComponent extends Component
{
    use LivewireAlert;

    public $document_categories;
    public $document_types = [];

    public $document_category_id;
    public $document_type_id;
    public $doc_archive_name;

    public $published_on;
    public $status = 1; // Default status value

    public $documentArchive;

    public function mount()
    {
        $this->document_category_id = $this->documentArchive->documentType->documentCategory->id;
        $this->document_type_id = $this->documentArchive->documentType->id;
        $this->published_on = Carbon::parse($this->documentArchive->published_on)->Format('Y-m-d H:i K');
        $this->doc_archive_name = $this->documentArchive->doc_archive_name;
    }

    public function render()
    {
        // -------- for document categories and types ---------//
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];

        return view('livewire.document-archive.edit-archive-component', [
            'document_categories'   =>  $this->document_categories,
            'document_types'        =>  $this->document_types,
            'documentArchive'       =>  $this->documentArchive
        ]);
    }
}
