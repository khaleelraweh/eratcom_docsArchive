<?php

namespace App\Http\Livewire\Documents;

use Livewire\Component;

class EditDocumentWizardComponent extends Component
{

    public $document_id;

    public function mount($document_id)
    {
        $this->document_id = $document_id;
    }

    public function render()
    {
        return view('livewire.documents.edit-document-wizard-component');
    }
}
