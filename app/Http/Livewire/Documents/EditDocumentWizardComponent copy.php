<?php

namespace App\Http\Livewire\Documents;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentData;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use App\Models\PageVariable;
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

    public $docData = [];




    public function mount($document_id)
    {
        $this->document_id = $document_id;

        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];
        $this->document = Document::find($this->document_id);


        if ($this->document) {
            $this->document_type_id = $this->document->documentTemplate->documentType->id;
            $this->document_template_id = $this->document->documentTemplate->id;
            $this->document_category_id = $this->document->documentTemplate->documentType->documentCategory->id;
            $this->doc_name = $this->document->doc_name;
            $this->doc_type_id = $this->document->doc_type;

            $this->chosen_template = DocumentTemplate::find($this->document->document_template_id);
            $this->chosen_template_id = $this->document->document_template_id;

            $this->totalSteps = $this->chosen_template->documentPages()->count() + 2;
        }

        if ($this->document->documentData) {

            $this->docData = $this->chosen_template->documentPages->map(function ($page) {
                return [
                    'pageId' => $page->id,
                    'doc_page_name' => $page->doc_page_name,
                    'doc_page_description' => $page->doc_page_description,
                    'groups' => $page->pageGroups->map(function ($group) {
                        return [
                            'pg_id'     =>  $group->id,
                            'pg_name' => $group->pg_name,
                            'variables' => $group->pageVariables->map(function ($variable) {
                                return [
                                    'pv_id'     =>  $variable->id,
                                    'pv_name' => $variable->pv_name,
                                    'pv_question' => $variable->pv_question,
                                    'pv_type' => $variable->pv_type,
                                    'pv_required' => $variable->pv_required,
                                    'pv_details' => $variable->pv_details,
                                    'pv_value'  =>  DocumentData::find($variable->id)->value,
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                    'saved' => true,
                ];
            })->toArray();
        }
    }

    public function render()
    {
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];
        $this->document = Document::find($this->document_id);

        // To update chosen template status in the frontend 
        $this->chosen_template = DocumentTemplate::find($this->document->document_template_id);
        $this->chosen_template_id = $this->document->document_template_id;
        $this->totalSteps = $this->chosen_template->documentPages()->count() + 2;
        // end to update chosen template status in the frontend 

        // To update docData array with data
        // if ($this->document->documentData) {

        //     foreach ($this->document->documentData as $doc_Data) {

        //         $pageVariable = PageVariable::find($doc_Data->page_variable_id);

        //         $currentStep = $pageVariable->pageGroup->documentPage->id;
        //         $pageVariableId = $doc_Data->page_variable_id;
        //         $value = $doc_Data->value;
        //         $type = $pageVariable->pv_type;
        //         $required = $pageVariable->pv_required;

        //         self::updateDocData($currentStep, $pageVariableId, $value, $type, $required);
        //     }
        // }
        // end To update docData array with data

        return view('livewire.documents.edit-document-wizard-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
            'document_templates'    => $this->document_templates,
            'document'              => $this->document,
        ]);
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function nextStep()
    {
        // $this->validateStep();
        $this->saveStepData();
        $this->currentStep++;
        dd($this->docData);
    }

    public function finish()
    {
        // $this->validateStep();
        // $this->saveStepData();
        return redirect()->route('admin.documents.show', $this->document_id);
    }

    public function directMoveToStep($choseStep)
    {
        // if ($choseStep > $this->currentStep) {
        //     $this->validateStep();
        //     $this->saveStepData();
        // }

        $this->currentStep = $choseStep;
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            // Save or update the document information
            $document = Document::updateOrCreate(
                ['id' => $this->document_id],
                [
                    'doc_name' => $this->doc_name,
                    'doc_type' => $this->doc_type_id,
                    'doc_status' => 0,
                    'document_template_id' => $this->document_template_id,
                ]
            );


            $this->document = $document;
            $this->document_id = $document->id;



            // $this->document_template = $this->document_template_id ? DocumentTemplate::find($this->document_template_id) : null;

            // $this->totalSteps = $this->document_template->documentPages()->count() + 2;

            $this->alert('success', __('panel.document_data_saved'));
        }
    }

    public function updateDocData($currentStep, $pageVariableId, $value, $type, $required)
    {

        $this->docData[] = [
            $currentStep =>
            [
                $pageVariableId => [
                    'value'     =>  $value,
                    'type'      =>  $type,
                    'required'  =>  $required
                ]
            ]
        ];
        // $this->docData[$currentStep][$pageVariableId] = [
        //     'value' => $value,
        //     'type' => $type,
        //     'required' => $required,
        // ];
        dd($this->docData);
    }
}
