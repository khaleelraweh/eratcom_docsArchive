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

    public $viewText;


    public function mount($documentTemplateId = null) {}


    public function render()
    {
        // -------- for document categories and types ---------//
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];
        $this->document_templates       = $this->document_type_id != '' ? DocumentTemplate::whereStatus(true)->whereDocumentTypeId($this->document_type_id)->get() : [];



        // Dynamically set total steps based on document pages
        if ($this->document_template) {
            $this->totalSteps = $this->document_template->documentPages()->count() + 2; // +1 for step 1
        } else {
            $this->totalSteps = 4; // default to 4 if no document template is selected
        }



        return view('livewire.documents.document-wizard-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
            'document_templates'    => $this->document_templates,
            'document_template_choosen'     => $this->document_template,
            'viewText'     => $this->viewText,


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
        return redirect()->route('admin.documents.index');
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function directMoveToStep($choseStep)
    {
        if ($choseStep > $this->currentStep) {
            $this->validateStep();
            $this->saveStepData();
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
        } else if ($this->currentStep > 1) {
            $this->validateStepDynamic();
        }
    }


    public function validateStepDynamic()
    {
        $rules = [];
        $messages = [];

        // Check if the current step has any data
        if (isset($this->docData[$this->currentStep]) && !empty($this->docData[$this->currentStep])) {
            foreach ($this->docData[$this->currentStep] as $pageVariableId => $valueData) {
                $type = $valueData['type'];
                $required = $valueData['required'];
                $pageVariable = PageVariable::find($pageVariableId);

                // Define validation rules based on field type and required status
                $fieldRules = [];
                if ($required) {
                    $fieldRules[] = 'required';
                }

                // Add type-specific validation rules
                switch ($type) {
                    case 'text':
                        $fieldRules[] = 'string';
                        break;
                    case 'number':
                        $fieldRules[] = 'numeric';
                        break;
                    case 'date':
                        $fieldRules[] = 'date';
                        break;
                        // Add other types as needed
                }

                // Add rules for the field
                $rules["docData.{$this->currentStep}.{$pageVariableId}.value"] = implode('|', $fieldRules);

                // Define custom messages
                $messages["docData.{$this->currentStep}.{$pageVariableId}.value.required"] = __("The :attribute field is required.", ['attribute' => $pageVariable->pv_name]);
                $messages["docData.{$this->currentStep}.{$pageVariableId}.value.string"] = __("The :attribute field must be a string.", ['attribute' => $pageVariable->pv_name]);
                $messages["docData.{$this->currentStep}.{$pageVariableId}.value.numeric"] = __("The :attribute field must be a number.", ['attribute' => $pageVariable->pv_name]);
                $messages["docData.{$this->currentStep}.{$pageVariableId}.value.date"] = __("The :attribute field must be a valid date.", ['attribute' => $pageVariable->pv_name]);
            }

            // Validate based on dynamic rules and custom messages
            $this->validate($rules, $messages);
        } else {
            // If there is no data for the current step, you might need to handle it accordingly
            // For example, you can add a rule that ensures at least one field is filled out
            $this->validate([
                "docData.{$this->currentStep}" => 'required'
            ]);
        }
    }


    public function saveStepData()
    {
        if ($this->currentStep == 1) {
            // Save or update the document information
            $document = Document::updateOrCreate(
                ['id' => $this->document_id],
                [
                    'doc_name' => $this->doc_name,
                    'doc_type' => $this->doc_type,
                    'document_template_id' => $this->document_template_id,
                ]
            );

            $this->document_id = $document->id;
            $this->document_template = $this->document_template_id ? DocumentTemplate::find($this->document_template_id) : null;

            $this->totalSteps = $this->document_template->documentPages()->count() + 2;

            $this->alert('success', __('panel.document_data_saved'));
        } elseif ($this->currentStep > 1 && $this->currentStep < $this->totalSteps) {
            // Loop through dynamic fields and save their values
            foreach ($this->docData[$this->currentStep] as $pageVariableId => $valueData) {
                $value = $valueData['value'];
                $type = $valueData['type'];
                $required = $valueData['required'];

                DocumentData::updateOrCreate(
                    [
                        'document_id' => $this->document_id,
                        'page_variable_id' => $pageVariableId,
                    ],
                    ['value' => $value]
                );
            }

            // If template text exists, process it
            if ($this->document_template->doc_template_text) {
                $this->viewText = $this->replacePlaceholders($this->document_template->doc_template_text);
            }

            $this->alert('success', __('panel.step_data_saved'));
        } else if ($this->currentStep == $this->totalSteps) {
            // Final step handling
        }
    }

    private function replacePlaceholders($text)
    {
        // Find all placeholders in the text
        preg_match_all('/{!-(\d+)-[^!]+!}/', $text, $matches);

        $forReplacement = [];

        // Map placeholders to values from docData
        foreach ($matches[1] as $index => $pageVariableId) {
            $step = $this->currentStep; // or the specific step you want to target
            if (isset($this->docData[$step][$pageVariableId])) {
                $forReplacement[$matches[0][$index]] = $this->docData[$step][$pageVariableId]['value'];
            }
        }

        // Replace placeholders with values
        foreach ($forReplacement as $placeholder => $replacement) {
            $text = str_replace($placeholder, $replacement, $text);
        }

        return $text;
    }



    public function saveStep($currentStep)
    {
        $this->validateStep();
        $this->saveStepData();
        // $this->currentStep++;
    }


    public function updateDocData($currentStep, $pageVariableId, $value, $type, $required)
    {
        $this->docData[$currentStep][$pageVariableId] = [
            'value' => $value,
            'type' => $type,
            'required' => $required,
        ];
    }
}
