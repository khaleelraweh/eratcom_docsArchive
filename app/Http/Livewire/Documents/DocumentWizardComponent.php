<?php

namespace App\Http\Livewire\Documents;

use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentData;
use App\Models\DocumentPage;
use App\Models\DocumentType;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DocumentWizardComponent extends Component
{
    use LivewireAlert;

    public $currentStep = 1;
    public $totalSteps = 4;

    // -------- for document categories and types ---------//
    public $document_categories;
    public $document_types = [];
    public $document_templates = [];
    public $document_template; // only the selected documenttemplate when save step1

    //step1
    public $document_id;
    public $document_category_id;
    public $document_type_id;

    public $document_template_id;
    public $doc_name;
    public $doc_type;

    public $docData = [];



    //step2


    // step3 



    public $stepData = [
        'step1' => '',
        'step2' => '',
        'step3' => '',
        'step4' => '',
    ];

    public function mount($documentTemplateId = null) {}


    public function render()
    {
        // -------- for document categories and types ---------//
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];



        // Dynamically set total steps based on document pages
        if ($this->document_template) {
            $this->totalSteps = $this->document_template->documentPages()->count() + 1; // +1 for step 1
        } else {
            $this->totalSteps = 4; // default to 4 if no document template is selected
        }



        return view('livewire.documents.document-wizard-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
            'document_templates'    => $this->document_templates,


        ]);
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->saveStepData();
        $this->currentStep++;
    }

    public function finish()
    {
        $this->validateStep();
        $this->saveStepData();
        return redirect()->route('admin.document_templates.index');
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function directMoveToStep($choseStep)
    {
        if ($choseStep > $this->currentStep) {
            $this->validateStep();
        }

        $this->currentStep = $choseStep;
    }

    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'document_template_id'  => 'required|numeric',
                'doc_name'      => 'required|string',
                'doc_type'      => 'required|numeric',
            ]);
        } elseif ($this->currentStep == 2) {
            // $this->validate([

            // ]);
        } elseif ($this->currentStep == 3) {
            // Perform validation

        } elseif ($this->currentStep == 4) {
        }
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            if ($this->document_id) {
                $document = Document::updateOrCreate(
                    ['id' => $this->document_id],
                    [
                        'doc_name'                  => $this->doc_name,
                        'doc_type'                  => $this->doc_type,
                        'document_template_id'      => $this->document_template_id,

                    ]
                );
            } else {
                $document = Document::updateOrCreate(
                    [
                        'doc_name'                  => $this->doc_name,
                        'doc_type'                  => $this->doc_type,
                        'document_template_id'      => $this->document_template_id,
                    ]
                );
            }

            $this->document_id = $document->id;
            $this->document_template = $this->document_template_id ? DocumentTemplate::find($this->document_template_id) : null;

            $this->totalSteps = $this->document_template->documentPages()->count() + 1;

            $this->alert('success', __('panel.document_data_saved'));
        } elseif ($this->currentStep == 2) {
        } elseif ($this->currentStep == 3) {
        } elseif ($this->currentStep == 4) {
        }
    }

    public function saveStep($s)
    {

        dd($this->docData);
        DocumentData::create([
            'document_id' => 1, // Reference a seeded document
            'page_variable_id' => 1, // Reference a seeded page variable
            'value' => 'this is new '
        ]);

        $this->alert('success', __('panel.document_data_saved'));
    }
}
