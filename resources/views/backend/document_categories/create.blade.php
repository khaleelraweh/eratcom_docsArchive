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
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    <a
                        href="{{ route('admin.document_categories.index') }}">{{ __('panel.manage_document_categories') }}</a>
                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    /
                    {{ __('panel.add_new_document_category') }}
                </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">


            <div class="pr-1 mb-3 mb-xl-0">
                {{-- <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button> --}}
                <a href="{{ route('admin.document_categories.create') }}" class="btn btn-warning  btn-icon ml-2">
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
                            {{ __('panel.add_new_document_category') }}
                        </h4>
                        {{-- <a href="{{ route('admin.document_categories.index') }}" class="btn btn-primary">
                            <span class="icon text-white-50">
                                <i class="far fa-eye"></i>
                            </span>
                            <span class="text">{{ __('panel.show_document_categories') }}</span>
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

                    <form action="{{ route('admin.document_categories.store') }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-8">
                                {{-- row part in content   --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <div class="form-group">
                                            <label for="doc_cat_name">{{ __('panel.document_category_name') }}</label>
                                            <input type="text" id="doc_cat_name" name="doc_cat_name"
                                                value="{{ old('doc_cat_name') }}" class="form-control" placeholder="">
                                            @error('doc_cat_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <div class="form-group">
                                            <label for="doc_cat_note">{{ __('panel.document_category_note') }}</label>
                                            <input type="text" id="doc_cat_note" name="doc_cat_note"
                                                value="{{ old('doc_cat_note') }}" class="form-control" placeholder="">
                                            @error('doc_cat_note')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-4">
                                {{-- publish date  field --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12  pt-3">
                                        <div class="form-group ">
                                            <label for="published_on"> {{ __('panel.published_date') }} </label>
                                            <input type="text" id="published_on" name="published_on"
                                                value="{{ old('published_on', now()->format('Y-m-d H:i K')) }}"
                                                class="form-control flatpickr_publihsed_on">
                                            @error('published_on')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <label for="status"> {{ __('panel.status') }} </label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : null }}>
                                                {{ __('panel.status_active') }}
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : null }}>
                                                {{ __('panel.status_inactive') }}
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
