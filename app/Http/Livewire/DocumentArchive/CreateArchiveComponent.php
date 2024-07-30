<?php

namespace App\Http\Livewire\DocumentArchive;

use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentPage;
use App\Models\DocumentType;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class CreateArchiveComponent extends Component
{
    use LivewireAlert;

    public $document_categories;
    public $document_types = [];

    public $document_category_id;
    public $document_type_id;
    public $doc_archive_name;

    public $published_on;
    public $status = 1; // Default status value

    public function render()
    {
        // -------- for document categories and types ---------//
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];

        return view('livewire.document-archive.create-archive-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
        ]);
    }


    public function create()
    {
        $this->validate([
            'document_category_id'  => 'required|numeric',
            'document_type_id'      => 'required|numeric',
            'doc_template_name'     => 'required|string',
            'language'              => 'required|numeric',
            'published_on'          => 'required|date',
        ]);

        $documentTemplate = DocumentTemplate::updateOrCreate(
            [
                'document_category_id'  => $this->document_category_id,
                'document_type_id'      => $this->document_type_id,
                'doc_template_name'     => $this->doc_template_name,
                'language'              => $this->language,
                'published_on'          => $this->published_on,
                'status'                => $this->status,
            ]
        );

        $this->alert('success', __('panel.document_template_data_saved'));
    }

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
    }
}
