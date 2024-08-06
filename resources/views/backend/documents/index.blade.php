@extends('layouts.admin')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('panel.manage_document_templates') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    /
                    {{ __('panel.show_document_templates') }}
                </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">


            <div class="pr-1 mb-3 mb-xl-0">
                {{-- <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button> --}}
                <a href="{{ route('admin.document_templates.index') }}" class="btn btn-warning  btn-icon ml-2"><i
                        class="mdi mdi-refresh"></i></a>
            </div>

            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate"
                        data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
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
                            <span class="icon">
                                <i class="far fa-eye me-3"></i>
                            </span>
                            <span class="text">{{ __('panel.show_document_templates') }}</span>
                        </h4>
                        {{-- <i class="mdi mdi-dots-horizontal text-gray"></i> --}}
                        @ability('admin', 'create_document_templates')
                            <a href="{{ route('admin.document_templates.create') }}" class="btn btn-primary">
                                <span class="icon text-white-50">
                                    <i class="fa fa-plus-square"></i>
                                </span>
                                <span class="text">{{ __('panel.add_new_document_type') }}</span>
                            </a>
                        @endability

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.document_template_name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.document_category_name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.document_type_name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.published_on') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.published_by') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.status') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('panel.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($documentTemplates as $docTemplate)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" name="checkfilter"
                                                value="{{ $docTemplate->id }}"></td>
                                        <td>{{ $docTemplate->doc_template_name }}</td>
                                        {{-- <td>{{ $docTemplate->documentCategory->doc_cat_name }}</td> --}}
                                        <td>{{ $docTemplate->documentType->documentCategory->doc_cat_name }}</td>
                                        <td>{{ $docTemplate->documentType->doc_type_name }}</td>
                                        <td>{{ $docTemplate->created_at->format('Y-m-d ') }}</td>
                                        <td>{{ $docTemplate->created_by }}</td>
                                        <td>{{ $docTemplate->status() }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.document_templates.edit', $docTemplate->id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-document-templates-{{ $docTemplate->id }}').submit();}else{return false;}"
                                                    class="btn btn-danger">
                                                    <i class="fa fa-trash "></i>
                                                </a>
                                            </div>
                                            <form
                                                action="{{ route('admin.document_templates.destroy', $docTemplate->id) }}"
                                                method="post" class="d-none"
                                                id="delete-document-templates-{{ $docTemplate->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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
@endsection
