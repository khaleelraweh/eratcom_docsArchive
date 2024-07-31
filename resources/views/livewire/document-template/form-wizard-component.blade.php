<div>
    <link rel="stylesheet" href="{{ asset('frontend/css/mywizard.css') }}">
    <style>
        .ck.ck-editor__main>.ck-editor__editable {
            height: 200px !important;
        }
    </style>
    <div class="mywizard">
        <div class="steps clearfix">
            <ul role="tablist">
                <li role="tab" wire:click="directMoveToStep(1)" class="first {{ $currentStep == 1 ? 'current' : '' }}"
                    aria-disabled="false" aria-selected="true">
                    <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                        <span class="current-info audible">current step:
                        </span>
                        <span class="number">1</span>
                        <span class="title">
                            {{ __('panel.document_template_data') }}
                        </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(2)"
                    class="disabled {{ $currentStep == 2 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-1" href="#wizard1-h-1" aria-controls="wizard1-p-1">
                        <span class="number">2</span>
                        <span class="title"> {{ __('panel.document_template_text') }} </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(3)"
                    class="disabled {{ $currentStep == 3 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-1" href="#wizard1-h-1" aria-controls="wizard1-p-1">
                        <span class="number">3</span>
                        <span class="title"> {{ __('panel.document_template_variables') }} </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(4)"
                    class="disabled last {{ $currentStep == 4 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-2" href="#wizard1-h-2" aria-controls="wizard1-p-2"><span class="number">4</span>
                        <span class="title">
                            {{ __('panel.document_and_template_formatting') }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="mycontent">

            {{-- step 1 : بيانات نموذج الوثيقة --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 1 ? 'current' : '' }} ">
                {{ __('panel.document_template_data') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 1 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 1 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 1 ? 'block' : 'none' }}">


                <form action="{{ route('admin.document_templates.store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-sm-12 col-md-9">

                            <!-- document category -->
                            <div class="row">

                                <div class="col-sm-12 col-md-6   pt-3">
                                    <label for="document_category_id" class="text-small text-uppercase">
                                        {{ __('panel.document_category_name') }} </label>
                                    <select class="form-control form-control-lg" wire:model="document_category_id">
                                        <option value="">---</option>
                                        @forelse ($document_categories as $document_category)
                                            <option value="{{ $document_category->id }}">
                                                {{ $document_category->doc_cat_name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('document_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12  col-md-6 pt-3">

                                    <label for="document_type_id" class="text-small text-uppercase">
                                        {{ __('panel.document_type_name') }}
                                    </label>
                                    <select class="form-control form-control-lg" wire:model="document_type_id">
                                        <option value="">---</option>
                                        @forelse ($document_types as $document_type)
                                            <option value="{{ $document_type->id }}">
                                                {{ $document_type->doc_type_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('document_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <label for="doc_template_name"> {{ __('panel.document_template_name') }} </label>
                                    <input type="text" id="doc_template_name" wire:model="doc_template_name"
                                        name="doc_template_name" value="{{ old('doc_template_name') }}"
                                        class="form-control" placeholder="">
                                    @error('doc_template_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="language"> {{ __('panel.language') }} </label>
                                    <select name="language" wire:model.defer="language" class="form-control">
                                        <option value="">---</option>
                                        <option value="1" {{ old('language') == '1' ? 'selected' : null }}>
                                            {{ __('panel.language_ar') }}
                                        </option>
                                        <option value="2" {{ old('language') == '2' ? 'selected' : null }}>
                                            {{ __('panel.language_en') }}
                                        </option>
                                        <option value="3" {{ old('language') == '3' ? 'selected' : null }}>
                                            {{ __('panel.language_both') }}
                                        </option>

                                    </select>
                                    @error('language')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">

                            {{-- publish_start publish time field --}}
                            <div class="row">
                                <div class="col-sm-12 col-md-12 pt-3">
                                    <label for="published_on"> {{ __('panel.published_date') }} </label>
                                    <input type="text" id="published_on" wire:model.defer="published_on"
                                        name="published_on"
                                        value="{{ old('published_on', now()->format('Y-m-d H:i A')) }}"
                                        class="form-control flatpickr_publihsed_on">
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 pt-3">
                                    <label for="status">{{ __('panel.status') }}</label>
                                    <div class="main-toggle-group-demo">
                                        <div class="main-toggle main-toggle-success {{ $status == 1 ? 'on' : '' }}"
                                            id="main-toggler" wire:click="toggleStatus">
                                            <span></span>
                                        </div>
                                    </div>
                                    <input type="hidden" wire:model.defer="status" name="status" id="status"
                                        value="{{ $status }}">
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </section>

            {{-- step 2 : نص نموذج الوثيقة  --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 2 ? 'current' : '' }} ">
                {{ __('panel.document_template_text') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 2 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 2 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 2 ? 'block' : 'none' }}">

                <textarea name="doc_template_text" wire:model="doc_template_text" rows="10" class="form-control summernote">{!! old('doc_template_text') !!}</textarea>
                @error('doc_template_text')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </section>

            {{-- step 3 : متغيرات نموذج الوثيقة  --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 3 ? 'current' : '' }} ">

                <div class="row align-items-end mb-4 mb-md-0">
                    <div class="col-md mb-4 mb-md-0">
                        <h4>{{ __('panel.document_template_variables') }}</h4>
                    </div>
                    <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">
                        <button wire:click="saveStepThreeDataUsingBtn" class="btn btn-primary">
                            {{ __('panel.document_template_variables_save') }}
                        </button>
                    </div>
                </div>
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 3 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 3 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 3 ? 'block' : 'none' }}">

                <div class="row">
                    <div class="col-sm-12 col-md-2 pt-3">
                        <h2>صفحات النموذج</h2>
                        <ul style="list-style: none;margin:0;padding:0;">
                            @foreach ($pages as $index => $page)
                                <li class="w-100 mb-1 d-flex justify-content-between"
                                    style="background-color: {{ $currentPageIndex == $index ? '#0162e8' : '#b9c2d8' }} ; border-width: 0;">
                                    <a class="d-block" wire:click="setActivePage({{ $index }})"
                                        href="#" style="padding: 9px 20px;line-height: 1.538;color:#fff;">
                                        {{ $page['doc_page_name'] }} </a>

                                    <a href="" wire:click.prevent="removePage({{ $currentPageIndex }})"
                                        class="d-block pt-2" style="padding: 9px 20px;line-height: 1.538;color:#fff;">
                                        <i
                                            class="fas fa-trash-alt {{ $currentPageIndex == $index ? 'text-white' : 'text-danger' }}  me-3"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between" style="">
                            <!-- Button to add a new section -->
                            <a wire:click.prevent="addPage()" class="d-block pt-2" style="cursor: pointer;">
                                <i class="fas fa-plus-square text-primary me-3"></i> {{ __('panel.add_page') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-10 pt-3">
                        @if (isset($pages[$currentPageIndex]))
                            <div class="card">
                                <div class="card-header mb-0 pb-0">
                                    <h2> <i class="far fa-edit" style="color: #0162e8"></i> {{ __('panel.page') }}
                                        {{ $currentPageIndex + 1 }}</h2>
                                </div>
                                <div class="card-body mt-0 pt-0">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 pt-3">
                                            <label
                                                for="{{ $pages[$currentPageIndex]['doc_page_name'] }}">{{ __('panel.page_title') }}</label>

                                            <input type="text" class="form-control"
                                                id="pages.{{ $index }}.doc_page_name"
                                                wire:model.defer="pages.{{ $currentPageIndex }}.doc_page_name">

                                            @error('pages.' . $currentPageIndex . '.doc_page_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-8 pt-3">
                                            <label for="{{ $pages[$currentPageIndex]['doc_page_description'] }}">
                                                {{ __('panel.page_description') }}
                                            </label>

                                            <input type="text" class="form-control"
                                                id="{{ $pages[$currentPageIndex]['doc_page_description'] }}"
                                                wire:model.defer="pages.{{ $currentPageIndex }}.doc_page_description">

                                            @error('pages.' . $currentPageIndex . '.doc_page_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 pt-5">
                                            <div class="row align-items-end mb-4 mb-md-0">
                                                <div class="col-md mb-4 mb-md-0">
                                                    <h4>{{ __('panel.groups') }}</h4>
                                                </div>
                                                <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">
                                                    <a href=""
                                                        wire:click.prevent="addGroup({{ $currentPageIndex }})">
                                                        <i class="fas fa-plus-circle me-2"></i>
                                                        <span>
                                                            {{ __('panel.add_group') }}
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            @foreach ($pages[$currentPageIndex]['groups'] as $groupIndex => $group)
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <div class="input-group p-2 "
                                                            style="background: {{ $groupIndex == $activeGroupIndex ? '#0162e8' : '#DDE2EF' }}  !important;">
                                                            <span
                                                                class="input-group-text {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }}"
                                                                style="border:none;">
                                                                <span>
                                                                    {{ __('panel.group') }}
                                                                    {{ $groupIndex + 1 }}
                                                                </span>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.pg_name"
                                                                aria-label="{{ __('transf.Enter a Group Name') }}">

                                                            <a class="input-group-text {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }}"
                                                                style="border:none; cursor: pointer;"
                                                                wire:click.prevent="removeGroup({{ $currentPageIndex }}, {{ $groupIndex }})">
                                                                <i
                                                                    class="fas fa-trash-alt {{ $groupIndex == $activeGroupIndex ? 'text-white' : 'text-danger' }} "></i>
                                                            </a>

                                                            <a class="input-group-text p-1 {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }}"
                                                                style="border:none; cursor: pointer;"
                                                                wire:click="setActiveGroup({{ $currentPageIndex }}, {{ $groupIndex }})">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    @error('pages.' . $currentPageIndex . '.groups.' . $groupIndex .
                                                        '.pg_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-sm-12 col-md-8 pt-5">
                                            @foreach ($pages[$currentPageIndex]['groups'] as $groupIndex => $group)
                                                {{-- variables  --}}
                                                @if ($groupIndex == $activeGroupIndex)
                                                    <div class="row align-items-end mb-4 mb-md-0">
                                                        <div class="col-md mb-4 mb-md-0">
                                                            <h4>{{ __('panel.variables') }}</h4>
                                                        </div>
                                                        <div class="col-md-auto aos-init aos-animate"
                                                            data-aos="fade-start">
                                                            <a href=""
                                                                wire:click.prevent="addVariable({{ $currentPageIndex }}, {{ $groupIndex }})">
                                                                <i class="fas fa-plus-circle me-2"></i>
                                                                <span>
                                                                    {{ __('panel.add_variable') }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    {{-- @foreach ($group['variables'] as $variableIndex => $variable) --}}
                                                    @foreach ($pages[$currentPageIndex]['groups'][$activeGroupIndex]['variables'] as $variableIndex => $variable)
                                                        <div class="card">
                                                            <div class="card-header mb-0">
                                                                <div class="input-group mb-0"
                                                                    style="background: transparent;">
                                                                    <div class="d-flex align-items-center">
                                                                        <h3 class="mb-0 "
                                                                            style="border:none;background:transparent">
                                                                            <span>{{ __('panel.variable') }}</span>
                                                                            <span><small>{{ $variableIndex + 1 }}</small>
                                                                            </span>
                                                                        </h3>
                                                                        <a class="d-block mx-2"
                                                                            style="background: none;border:none;cursor: pointer;"
                                                                            wire:click.prevent="removeVariable({{ $currentPageIndex }}, {{ $groupIndex }}, {{ $variableIndex }})">
                                                                            <i
                                                                                class="fas fa-trash-alt text-danger"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body mt-0">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="pv_name">{{ __('panel.pv_name') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_name">
                                                                            @error('pages.' . $currentPageIndex .
                                                                                '.groups.' . $groupIndex . '.variables.' .
                                                                                $variableIndex . '.pv_name')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="pv_question">{{ __('panel.pv_question') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_question">
                                                                            @error('pages.' . $currentPageIndex .
                                                                                '.groups.' . $groupIndex . '.variables.' .
                                                                                $variableIndex . '.pv_question')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-6 pt-3">
                                                                        <label
                                                                            for="pv_type">{{ __('panel.pv_type') }}</label>
                                                                        <select name="pv_type" class="form-control"
                                                                            wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_type">
                                                                            <option value="1"
                                                                                {{ old('pv_type') == '1' ? 'selected' : null }}>
                                                                                {{ __('panel.pv_type_text') }}
                                                                            </option>
                                                                            <option value="2"
                                                                                {{ old('pv_type') == '2' ? 'selected' : null }}>
                                                                                {{ __('panel.pv_type_number') }}
                                                                            </option>
                                                                        </select>
                                                                        @error('pages.' . $currentPageIndex . '.groups.'
                                                                            . $groupIndex . '.variables.' . $variableIndex .
                                                                            '.pv_type')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6 pt-3">
                                                                        <label
                                                                            for="pv_required">{{ __('panel.pv_required') }}</label>
                                                                        <select name="pv_required"
                                                                            class="form-control"
                                                                            wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_required">
                                                                            <option value="1"
                                                                                {{ old('pv_required') == '1' ? 'selected' : null }}>
                                                                                {{ __('panel.yes') }}
                                                                            </option>
                                                                            <option value="0"
                                                                                {{ old('pv_required') == '0' ? 'selected' : null }}>
                                                                                {{ __('panel.no') }}
                                                                            </option>
                                                                        </select>
                                                                        @error('pages.' . $currentPageIndex . '.groups.'
                                                                            . $groupIndex . '.variables.' . $variableIndex .
                                                                            '.pv_required')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                {{--  pv_details field --}}
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12 pt-3">
                                                                        <label for="pv_details">
                                                                            {{ __('panel.pv_details') }}
                                                                        </label>
                                                                        <textarea name="pv_details" rows="10" class="form-control summernote"
                                                                            wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_details">
                                                                            {!! old('pv_details') !!}
                                                                        </textarea>
                                                                        @error('pages.' . $currentPageIndex . '.groups.'
                                                                            . $groupIndex . '.variables.' . $variableIndex .
                                                                            '.pv_details')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- step 4 :   تنسيق الوثيقة والمستند  --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 4 ? 'current' : '' }} ">
                {{ __('panel.document_and_template_formatting') }}
            </h3>
            <section id="wizard1-p-3" role="tabpanel" aria-labelledby="wizard1-h-3"
                class="body {{ $currentStep == 4 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 4 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 4 ? 'block' : 'none' }}">

                <div class="row">
                    <div class="col-sm-12 col-md-4 pt-3">
                        <label for="pv_name">{{ __('panel.select_pv_name') }}</label>
                        <select name="pv_name" class="form-control">
                            {{-- <option value="">select varaible</option> --}}
                            @if ($documentTemplate)
                                @if ($documentTemplate->documentPages->isNotEmpty())
                                    @foreach ($documentTemplate->documentPages as $page)
                                        @foreach ($page->pageGroups as $group)
                                            @foreach ($group->pageVariables as $variable)
                                                {{-- <option value="{!{{ $variable->id }}!}">{{ $variable->pv_name }}
                                                </option> --}}
                                                <option value="{{ $variable->id }}">
                                                    {{ $variable->pv_name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @else
                                    <option value="">No pages available</option>
                                @endif
                            @else
                                <p>No document template found.</p>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-8 pt-3" wire:ignore>
                        <textarea name="" id="khaleel3" class="form-control">{{ $doc_template_text }}</textarea>
                    </div>
                </div>

            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let editorInstance;

                    ClassicEditor
                        .create(document.querySelector('#khaleel3'), {
                            language: 'ar', // Example setting
                            // Other editor configurations
                        })
                        .then(editor => {
                            editorInstance = editor;

                            // Set the initial text from Livewire
                            @this.on('updateDocTemplateText', (text) => {
                                editorInstance.setData(text);
                            });

                            // Handle select changes
                            document.querySelector('select[name="pv_name"]').addEventListener('change', function() {
                                const selectedValue = this.value.split('-')[0];
                                const selectedText = this.options[this.selectedIndex].text;

                                if (editorInstance) {
                                    editorInstance.model.change(writer => {
                                        writer.insertText("{!-" + selectedValue + '-' + selectedText +
                                            "!}",
                                            editorInstance.model
                                            .document
                                            .selection.getFirstPosition());
                                    });
                                }
                            });

                            // Sync CKEditor data with Livewire
                            editor.model.document.on('change:data', () => {
                                @this.set('doc_template_text', editor.getData());
                            });
                        })
                        .catch(error => {
                            console.error('Error initializing CKEditor:', error);
                        });
                });

                Livewire.on('updateDocTemplateText', text => {
                    if (editorInstance) {
                        editorInstance.setData(text);
                    }
                });
            </script>



        </div>

        <div class="actions clearfix">
            <ul role="menu" aria-label="Pagination">
                <li class="{{ $currentStep == 1 ? 'disabled' : '' }}"
                    aria-disabled="{{ $currentStep == 1 ? 'true' : 'false' }} ">
                    <a href="#previous" style="display: {{ $currentStep == 1 ? 'none' : 'none' }} ;"
                        role="menuitem">
                        Previous
                    </a>
                    <a href="#previous" wire:click="previousStep"
                        style="display: {{ $currentStep == 1 ? 'none' : 'block' }} ;" role="menuitem">
                        {{ __('panel.previous') }}
                    </a>
                </li>
                <li aria-hidden="false" aria-disabled="false"
                    style="display: {{ $currentStep == 4 ? 'none' : 'block' }}">
                    <a href="#next" wire:click="nextStep" role="menuitem">
                        {{-- Next --}}
                        @if ($currentStep == 1)
                            {{ __('panel.document_template_text') }} >>
                        @else
                            @if ($currentStep == 2)
                                {{ __('panel.document_template_variables') }} >>
                            @else
                                {{ __('panel.document_and_template_formatting') }} >>
                            @endif
                        @endif
                    </a>
                </li>
                <li aria-hidden="true" style="display: {{ $currentStep == 4 ? 'block' : 'none' }}"><a
                        href="#finish" wire:click="finish" role="menuitem">{{ __('panel.finish') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
