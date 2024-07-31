<?php

namespace App\Http\Livewire\DocumentTemplate;

use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;
use App\Models\DocumentPage;
use App\Models\DocumentType;
use App\Models\PageGroup;
use App\Models\PageVariable;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditFormWizardComponent extends Component
{
    use LivewireAlert;

    public $currentStep = 1;
    public $totalSteps = 4;

    // -------- for document categories and types ---------//
    public $document_categories;
    public $document_types = [];
    public $documentTemplate;

    // this is for sending data to document template table 
    //step1
    public $document_category_id;
    public $document_type_id;
    public $doc_template_name;
    public $language;
    public $published_on;
    public $status = 1; // Default status value

    //step2
    public $documentTemplateId;
    public $doc_template_text;

    // step3 
    public $pages = [];
    public $count = 1;
    public $currentPageIndex = 0; // Track the currently active page
    public $activeGroupIndex = 0; // Track the currently active group within a page



    public $stepData = [
        'step1' => '',
        'step2' => '',
        'step3' => '',
        'step4' => '',
    ];

    public function mount($documentTemplateId = null)
    {
        $this->currentPageIndex = 0;

        if ($this->documentTemplate) {
            $this->document_category_id =   $this->documentTemplate->document_category_id;
            $this->document_type_id     =   $this->documentTemplate->document_type_id;
            $this->doc_template_name    =   $this->documentTemplate->doc_template_name;
            $this->language             =   $this->documentTemplate->language;
            $this->published_on         =   $this->documentTemplate->published_on;
            $this->status               =   $this->documentTemplate->status;
            $this->doc_template_text    =   $this->documentTemplate->doc_template_text;

            // Initialize the pages array from the documentPages relationship
            // $this->pages = $this->documentTemplate->documentPages->map(function ($page) {
            //     return [
            //         'pageId' => $page->id,
            //         'doc_page_name' => $page->doc_page_name,
            //         'doc_page_description' => $page->doc_page_description,
            //         'groups' => [], // Assuming you'll populate groups separately if needed
            //         'saved' => true,
            //     ];
            // })->toArray();

            // Initialize the pages array from the documentPages relationship
            $this->pages = $this->documentTemplate->documentPages->map(function ($page) {
                return [
                    'pageId' => $page->id,
                    'doc_page_name' => $page->doc_page_name,
                    'doc_page_description' => $page->doc_page_description,
                    'groups' => $page->pageGroups->map(function ($group) {
                        return [
                            'pg_name' => $group->pg_name,
                            'variables' => $group->pageVariables->map(function ($variable) {
                                return [
                                    'pv_name' => $variable->pv_name,
                                    'pv_question' => $variable->pv_question,
                                    'pv_type' => $variable->pv_type,
                                    'pv_required' => $variable->pv_required,
                                    'pv_details' => $variable->pv_details,
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                    'saved' => true,
                ];
            })->toArray();
        } else {
            $this->pages = [
                [
                    'pageId' => 1,
                    'doc_page_name' => __('panel.page') . ' 1',
                    'doc_page_description' => 'Page Description 1',
                    'groups' => [
                        [
                            'pg_name' =>  '',
                            'variables' => [
                                [
                                    'pv_name'               =>  '',
                                    'pv_question'           =>  '',
                                    'pv_type'               =>   1,
                                    'pv_required'           =>   1,
                                    'pv_details'            =>  '',
                                ],
                            ],

                        ],

                    ],
                    'saved' => false, // Initialize saved as false
                ]
            ];
        }

        // Initialize count based on existing pages
        $this->count = count($this->pages);
    }


    public function render()
    {
        // -------- for document categories and types ---------//
        $this->document_categories  = DocumentCategory::whereStatus(true)->get();
        $this->document_types       = $this->document_category_id != '' ? DocumentType::whereStatus(true)->whereDocumentCategoryId($this->document_category_id)->get() : [];

        // Fetch the DocumentTemplate instance
        $documentTemplate = $this->documentTemplateId ? DocumentTemplate::find($this->documentTemplateId) : null;

        return view('livewire.document-template.edit-form-wizard-component', [
            'document_categories'   => $this->document_categories,
            'document_types'        => $this->document_types,
            'documentTemplateId'    => $this->documentTemplateId,
            'documentTemplate'      => $documentTemplate, // Pass the DocumentTemplate instance
            'doc_template_text'     => $this->doc_template_text, // Pass the doc_template_text to the view

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
                'document_category_id'  => 'required|numeric',
                'document_type_id'      => 'required|numeric',
                'doc_template_name'     => 'required|string',
                'language'              => 'required|numeric',
                'published_on'          => 'required|date',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'doc_template_text' => 'required',
            ]);
        } elseif ($this->currentStep == 3) {
            // Perform validation
            $this->validateStepThree();
        } elseif ($this->currentStep == 4) {
            $this->validate([
                'doc_template_text' => 'required', // Validation rule for textarea
            ]);
        }
    }

    public function saveStepData()
    {
        if ($this->currentStep == 1) {
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

            $this->documentTemplateId = $documentTemplate->id;
            $this->alert('success', __('panel.document_template_data_saved'));
        } elseif ($this->currentStep == 2) {
            DocumentTemplate::updateOrCreate(
                ['id' => $this->documentTemplateId],
                [
                    'doc_template_text'     => $this->doc_template_text,
                ]
            );
            $this->alert('success', __('panel.document_template_text_saved'));
            $this->emit('updateDocTemplateText', $this->doc_template_text); // Emit event to update CKEditor
        } elseif ($this->currentStep == 3) {
            $this->saveStepThree();
            $this->alert('success', __('panel.document_template_variables_saved'));
        } elseif ($this->currentStep == 4) {
            DocumentTemplate::updateOrCreate(
                ['id' => $this->documentTemplateId],
                [
                    'doc_template_text' => $this->doc_template_text,
                ]
            );
            $this->alert('success', __('panel.document_and_template_formatting_saved'));
        }
    }


    public function submitForm()
    {
        $this->validateStep();
        $this->saveStepData();
        // Handle final form submission, e.g., redirect or show a success message
    }

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
    }


    // ===================== for step 3 making page  =================//

    // Method to add a new page
    public function addPage()
    {
        $this->count++;

        $this->pages[] = [
            'pageId'                => $this->count,
            'doc_page_name'         => __('panel.page') . ' ' . $this->count,
            'doc_page_description'  => 'Page description ' . $this->count,
            'groups' => [
                [
                    'pg_name'   =>  '',
                    'variables' => [
                        [
                            'pv_name'       =>  '',
                            'pv_question'   =>  '',
                            'pv_type'       =>   1,
                            'pv_required'   =>   1,
                            'pv_details'    =>  '',
                        ],
                    ],
                ],
            ],
            'saved' => false, // Initialize saved as false
        ];

        // Set the current page index to the new page
        $this->currentPageIndex = count($this->pages) - 1;

        $this->setActivePage($this->currentPageIndex);
    }


    public function addGroup($pageIndex)
    {

        $this->pages[$pageIndex]['groups'][] = [
            'pg_name'   => '',
            'variables' => [
                [
                    'pv_name'           =>  '',
                    'pv_question'       =>  '',
                    'pv_type'           =>  1,
                    'pv_required'       =>  1,
                    'pv_details'        =>  '',
                ],
            ]
        ];

        // Set the new group as the active group
        $this->activeGroupIndex = count($this->pages[$pageIndex]['groups']) - 1;
    }

    public function addVariable($pageIndex, $groupIndex)
    {
        $this->pages[$pageIndex]['groups'][$groupIndex]['variables'][] = [
            'pv_name'           =>  '',
            'pv_question'       =>  '',
            'pv_type'           =>  1,
            'pv_required'       =>  1,
            'pv_details'        =>  '',
        ];
    }

    public function setActivePage($index)
    {
        // Ensure the index is within bounds
        if ($index >= 0 && $index < count($this->pages)) {
            $this->currentPageIndex = $index;
            $this->activeGroupIndex = 0; // Reset the active group index

        }
    }

    public function setActiveGroup($pageIndex, $groupIndex)
    {
        // Ensure the indexes are within bounds
        if (
            $pageIndex >= 0 && $pageIndex < count($this->pages) &&
            $groupIndex >= 0 && $groupIndex < count($this->pages[$pageIndex]['groups'])
        ) {
            $this->currentPageIndex = $pageIndex;
            $this->activeGroupIndex = $groupIndex;
        }
    }


    // Method to remove a page
    public function removePage($pageIndex)
    {
        if (isset($this->pages[$pageIndex])) {
            array_splice($this->pages, $pageIndex, 1);
            $this->count--;

            // Adjust the currentPageIndex if necessary
            if ($this->currentPageIndex >= count($this->pages)) {
                $this->currentPageIndex = count($this->pages) - 1;
            }

            if ($this->currentPageIndex < 0) {
                $this->currentPageIndex = 0;
            }
        }
    }


    // Method to remove a group
    public function removeGroup($pageIndex, $groupIndex)
    {
        if (isset($this->pages[$pageIndex]['groups'][$groupIndex])) {
            array_splice($this->pages[$pageIndex]['groups'], $groupIndex, 1);

            // Adjust the activeGroupIndex if necessary
            if ($this->activeGroupIndex >= count($this->pages[$pageIndex]['groups'])) {
                $this->activeGroupIndex = count($this->pages[$pageIndex]['groups']) - 1;
            }

            if ($this->activeGroupIndex < 0) {
                $this->activeGroupIndex = 0;
            }
        }
    }

    // Method to remove a variable
    public function removeVariable($pageIndex, $groupIndex, $variableIndex)
    {
        if (isset($this->pages[$pageIndex]['groups'][$groupIndex]['variables'][$variableIndex])) {
            array_splice($this->pages[$pageIndex]['groups'][$groupIndex]['variables'], $variableIndex, 1);
        }
    }


    public function validateStepThree()
    {
        $this->validate([
            'pages.*.doc_page_name'                     => 'required|string',
            'pages.*.doc_page_description'              => 'required|string',
            'pages.*.groups.*.pg_name'                  => 'required|string',
            'pages.*.groups.*.variables.*.pv_name'      => 'required|string',
            'pages.*.groups.*.variables.*.pv_question'  => 'required|string',
            'pages.*.groups.*.variables.*.pv_type'      => 'required|numeric',
            'pages.*.groups.*.variables.*.pv_required'  => 'required|boolean',
            'pages.*.groups.*.variables.*.pv_details'   => 'required|string',
        ]);
    }


    public function saveStepThree()
    {
        // // Perform validation
        $this->validateStepThree();

        // Save the data to the database
        foreach ($this->pages as $page) {
            $pageData = [
                'doc_page_name'         => $page['doc_page_name'],
                'doc_page_description'  => $page['doc_page_description'],
                'document_template_id'  => $this->documentTemplateId,
            ];

            $pageModel = DocumentPage::updateOrCreate($pageData);

            foreach ($page['groups'] as $group) {
                $groupData = [
                    'pg_name'           => $group['pg_name'],
                    'document_page_id'  => $pageModel->id,
                ];

                $groupModel = PageGroup::updateOrCreate($groupData);

                foreach ($group['variables'] as $variable) {

                    $variableData = [
                        'pv_name'       => $variable['pv_name'],
                        'pv_question'   => $variable['pv_question'],
                        'pv_type'       => $variable['pv_type'],
                        'pv_required'   => $variable['pv_required'],
                        'pv_details'    => $variable['pv_details'],
                        'page_group_id' => $groupModel->id,
                    ];

                    PageVariable::updateOrCreate($variableData);
                }
            }
        }

        // Indicate that step three data is saved
        $this->stepData['step3'] = 'saved';
    }

    // for saving step3 using btn 
    public function saveStepThreeDataUsingBtn()
    {
        $this->saveStepThree();
        $this->currentStep++;
    }
}
