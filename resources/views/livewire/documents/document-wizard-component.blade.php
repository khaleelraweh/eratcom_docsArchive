<div>
    <link rel="stylesheet" href="{{ asset('assets/css/mywizard.css') }}">

    <style>
        fieldset {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 15px;
        }

        legend {
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
            width: fit-content;
            padding: 0 0.7rem;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
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
                @if ($document_template)
                    @if (count($document_template->documentPages) > 0)
                        @foreach ($document_template->documentPages as $key => $documentPage)
                            <li role="tab" wire:click="directMoveToStep({{ $key + 2 }})"
                                class="disabled {{ $currentStep == $key + 2 ? 'current' : '' }}" aria-disabled="true">
                                <a id="wizard1-t-{{ $key + 2 }}" href="#wizard1-h-1"
                                    aria-controls="wizard1-p-{{ $key + 2 }}">
                                    <span class="number">{{ $key + 2 }}</span>
                                    <span class="title">

                                        {{-- {!! Str::limit($documentPage->doc_page_name, 10, ' ...') !!} --}}

                                        {!! Str::words($documentPage->doc_page_name, 3, ' ...') !!}

                                        {{-- {{ $documentPage->doc_page_name }} --}}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    @endif

                @endif

            </ul>
        </div>

        <!-- start mycontent -->
        <div class="mycontent">

            <!-- start step 1  -->
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
                        <div class="col-sm-12 col-md-12">

                            <div class="row">

                                <div class="col-sm-12 col-md-4   pt-3">
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

                                <div class="col-sm-12  col-md-4 pt-3">

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

                                <div class="col-sm-12  col-md-4 pt-3">
                                    <label for="document_template_id" class="text-small text-uppercase">
                                        {{ __('panel.document_template_name') }}
                                    </label>
                                    <select class="form-control form-control-lg" wire:model="document_template_id">
                                        <option value="">---</option>
                                        @forelse ($document_templates as $doc_template)
                                            <option value="{{ $doc_template->id }}">
                                                {{ $doc_template->doc_template_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('document_template_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>


                            <div class="row">

                                <div class="col-sm-12 col-md-9 pt-3">
                                    <label for="doc_name"> {{ __('panel.document_name') }} </label>
                                    <input type="text" id="doc_name" wire:model="doc_name" name="doc_name"
                                        value="{{ old('doc_name') }}" class="form-control" placeholder="">
                                    @error('doc_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="doc_type"> {{ __('panel.document_type') }} </label>
                                    <select name="doc_type" wire:model.defer="doc_type" class="form-control">
                                        <option value="">---</option>
                                        <option value="1" {{ old('doc_type') == '1' ? 'selected' : null }}>
                                            {{ __('panel.document_type_inner') }}
                                        </option>
                                        <option value="2" {{ old('doc_type') == '2' ? 'selected' : null }}>
                                            {{ __('panel.document_type_outer') }}
                                        </option>
                                    </select>
                                    @error('doc_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </div>
                </form>
            </section>
            <!-- end step 1  -->


            <!-- start dynimac steps   -->
            @if ($document_template)
                @if (count($document_template->documentPages) > 0)
                    @foreach ($document_template->documentPages as $key => $documentPage)
                        <h3 id="wizard1-h-0" tabindex="-1"
                            class="title {{ $currentStep == $key + 2 ? 'current' : '' }} ">

                            <div class="row align-items-end mb-4 mb-md-0">
                                <div class="col-md mb-4 mb-md-0">
                                    <h4>{{ $documentPage->doc_page_name }}</h4>
                                </div>
                                <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">
                                    <button wire:click="saveStep({{ $key + 2 }})" class="btn btn-primary">
                                        {{ __('panel.document_template_variables_save') }}
                                    </button>
                                </div>
                            </div>
                        </h3>
                        <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                            class="body {{ $currentStep == $key + 2 ? 'current' : '' }}  step"
                            aria-hidden="{{ $currentStep == $key + 2 ? 'false' : 'true' }}"
                            style="display: {{ $currentStep == $key + 2 ? 'block' : 'none' }}">

                            <form method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        @foreach ($documentPage->pageGroups as $pageGroup)
                                            <fieldset>
                                                <legend>{{ $pageGroup->pg_name }}</legend>

                                                @foreach ($pageGroup->pageVariables as $pageVariable)
                                                    <label
                                                        for="{{ $pageVariable->pv_name . $pageVariable->id }}">{{ $pageVariable->pv_name }}:</label>
                                                    <input type="{{ $pageVariable->pv_type() }}"
                                                        id="{{ $pageVariable->pv_name . $pageVariable->id }}"
                                                        name="docData[{{ $pageVariable->id }}]"
                                                        wire:model.defer="docData.{{ $pageVariable->id }}"
                                                        class="form-control" {{ $pageVariable->pv_required() }}>
                                                @endforeach


                                            </fieldset>
                                        @endforeach

                                    </div>
                                </div>
                            </form>

                        </section>
                    @endforeach
                @endif
            @endif

            <!-- end dynimac steps  -->

        </div>
        <!-- end mycontent -->

        <!-- start next and previous  -->
        <div class="actions clearfix">
            <ul role="menu" aria-label="Pagination">
                <li class="{{ $currentStep == 1 ? 'disabled' : '' }}"
                    aria-disabled="{{ $currentStep == 1 ? 'true' : 'false' }}">
                    <a href="#previous" style="display: {{ $currentStep == 1 ? 'none' : 'none' }} ;"
                        role="menuitem">
                        Previous
                    </a>
                    <a href="#previous" wire:click="previousStep"
                        style="display: {{ $currentStep == 1 ? 'none' : 'block' }};" role="menuitem">
                        {{ __('panel.previous') }}
                    </a>
                </li>

                <li aria-hidden="false" aria-disabled="false"
                    style="display: {{ $currentStep == $totalSteps ? 'none' : 'block' }}">
                    <a href="#next" wire:click="nextStep" role="menuitem">
                        التالي
                    </a>
                </li>

                <li aria-hidden="true" style="display: {{ $currentStep == $totalSteps ? 'block' : 'none' }}">
                    <a href="#finish" wire:click="finish" role="menuitem">
                        {{ __('panel.finish') }}
                    </a>
                </li>
            </ul>
        </div>
        <!-- end next and previous  -->

    </div>
</div>
