@extends('layouts.admin')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    {{-- flat picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">


    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    <a
                        href="{{ route('admin.document_templates.index') }}">{{ __('panel.manage_document_templates') }}</a>

                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    /
                    {{ __('panel.add_new_document_template') }}
                </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">


            <div class="pr-1 mb-3 mb-xl-0">
                {{-- <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button> --}}
                <a href="{{ route('admin.document_templates.create') }}" class="btn btn-warning  btn-icon ml-2">
                    <i class="mdi mdi-refresh"></i>
                </a>
            </div>


        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">
                            <i class="fa fa-plus-square me-3 " style="font-size: 20px;"></i>
                            {{ __('panel.add_new_document_template') }}
                        </h4>
                        {{-- <a href="{{ route('admin.document_templates.index') }}" class="btn btn-primary">
                            <span class="icon text-white-50">
                                <i class="far fa-eye"></i>
                            </span>
                            <span class="text">{{ __('panel.show_document_templates') }}</span>
                        </a> --}}

                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    {{-- erorrs show is exists --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.document_templates.store') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <div class="row">
                                    <div class="col-sm-12  pt-3">
                                        <label for="document_category_id">{{ __('panel.document_category_name') }} </label>
                                        <select name="document_category_id" class="form-control">
                                            <option value="">---</option>
                                            @forelse ($documentCategories as $documentCatgegory)
                                                <option value="{{ $documentCatgegory->id }}"
                                                    {{ old('document_category_id') == $documentCatgegory->id ? 'selected' : null }}>
                                                    {{ $documentCatgegory->doc_cat_name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('document_category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- row part in content   --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <label for="doc_template_name">{{ __('panel.document_template_name') }}</label>
                                        <input type="text" id="doc_template_name" name="doc_template_name"
                                            value="{{ old('doc_template_name') }}" class="form-control" placeholder="">
                                        @error('doc_template_name')
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
                                        <input type="text" id="published_on" name="published_on"
                                            value="{{ old('published_on', now()->format('Y-m-d H:i K')) }}"
                                            class="form-control flatpickr_publihsed_on">
                                        @error('published_on')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 pt-3">
                                        <label for="published_on"> {{ __('panel.status') }} </label>
                                        <div class="main-toggle-group-demo ">
                                            <div class="main-toggle main-toggle-success on" id="main-toggler">
                                                <span></span>
                                            </div>
                                        </div>

                                        <input type="hidden" name="status" id="status" value="1">

                                    </div>
                                </div>

                            </div>
                        </div>



                        {{-- submit button  --}}
                        <div class="form-group pt-4">
                            <button type="submit" name="submit" class="btn btn-primary">
                                {{ __('panel.save_data') }}</button>
                        </div>



                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>


    <!-- Include the Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>



    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>


    <script>
        $(document).ready(function() {
            // Initialize the toggle switch based on the hidden input value
            var statusInput = $('#status');
            var mainToggler = $('#main-toggler');

            // Handle toggle switch click
            mainToggler.click(function() {

                if ($(this).hasClass('on')) {
                    statusInput.val(1); // Set status to active
                } else {
                    statusInput.val(0); // Set status to inactive
                }
            });
        });
    </script>

    <script>
        $(function() {

            // for offer ends
            flatpickr('.flatpickr_publihsed_on', {
                enableTime: true,
                dateFormat: "Y-m-d H:i K",
                minDate: "today"

            });

        });
    </script>
@endsection
