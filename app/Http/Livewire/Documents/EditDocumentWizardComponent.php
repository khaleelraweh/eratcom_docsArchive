<?php

namespace App\Http\Livewire\Documents;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditDocumentWizardComponent extends Component
{
    use LivewireAlert;

    //global variables
    public $currentStep = 1;
    public $totalSteps = 4;

    public $document_id;
    public $document;

    public $document_categories;
    public $document_category_id;

    public $document_types = [];
    public $document_type_id;

    public $document_templates = [];
    public $document_template_id;

    public $chosen_template;
    public $chosen_template_id;

    public $doc_name;
    public $doc_type_id;




    public function mount($document_id)
    {
        $this->document_id = $document_id;

        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];
        $this->document = Document::find($this->document_id);

        $this->chosen_template = DocumentTemplate::find($this->document->document_template_id);
        $this->chosen_template_id = $this->document->document_template_id;

        if ($this->document) {
            $this->document_type_id = $this->document->documentTemplate->documentType->id;
            $this->document_template_id = $this->document->documentTemplate->id;
            $this->document_category_id = $this->document->documentTemplate->documentType->documentCategory->id;
            $this->doc_name = $this->document->doc_name;
            $this->doc_type_id = $this->document->doc_type;
        }
    }

    public function render()
    {
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];
        $this->document = Document::find($this->document_id);

        return view('livewire.documents.edit-document-wizard-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
            'document_templates'    => $this->document_templates,
            'document'              => $this->document,
        ]);
    }
}
