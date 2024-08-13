<div>
    <link rel="stylesheet" href="{{ asset('assets/css/mywizard.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
        }

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
                <li role="tab" wire:click="directMoveToStep(1)"
                    class="first {{ $currentStep == 1 ? 'current' : '' }}" aria-disabled="false" aria-selected="true">
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

                @if ($document_template)
                    @if (count($document_template->documentPages) > 0)
                        <li role="tab" wire:click="directMoveToStep({{ $totalSteps }})"
                            class="first {{ $currentStep == $totalSteps ? 'current' : '' }}" aria-disabled="false"
                            aria-selected="true">
                            <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                                <span class="current-info audible">current step:
                                </span>
                                <span class="number">{{ $totalSteps }}</span>
                                <span class="title">
                                    {{ __('panel.document_review') }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
        </div>
    </div>

</div>
