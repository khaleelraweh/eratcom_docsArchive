@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_payments') }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            <i class="fa fa-solid fa-chevron-left chevron"></i>
                        @else
                            <i class="fa fa-solid fa-chevron-right chevron"></i>
                        @endif
                    </li>
                    <li>
                        {{ __('panel.show_payment_method') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_payment_method_offlines')
                    <a href="{{ route('admin.payment_method_offlines.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_payment_method') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">
            {{-- filter form part  --}}
            @include('backend.payment_method_offlines.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('panel.image') }}</th>
                            <th>{{ __('panel.title') }}</th>
                            <th>{{ __('panel.author') }}</th>
                            <th>{{ __('panel.published_on') }}</th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payment_method_offlines as $payment_offline)
                            <tr>

                                {{-- To make code better by making laravel cal only first media using relation shap to low querys --}}
                                <td>
                                    @if ($payment_offline->firstMedia)
                                        <img src="{{ asset('assets/payment_method_offlines/' . $payment_offline->firstMedia->file_name) }}"
                                            width="60" height="60" alt="{{ $payment_offline->name }}">
                                    @else
                                        <img src="{{ asset('assets/No-Image-Found.png') }}" width="60" height="60"
                                            alt="{{ $payment_offline->name }}">
                                    @endif

                                </td>
                                <td>{{ $payment_offline->title }}</td>
                                <td>{{ $payment_offline->created_by }}</td>
                                <td>{{ $payment_offline->published_on }}</td>
                                <td>{{ $payment_offline->status() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.payment_method_offlines.edit', $payment_offline->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('Are you sure to delete this record?') ){document.getElementById('delete-product-{{ $payment_offline->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <form
                                        action="{{ route('admin.payment_method_offlines.destroy', $payment_offline->id) }}"
                                        method="post" class="d-none" id="delete-product-{{ $payment_offline->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="float-right">
                                    {!! $payment_method_offlines->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>
@endsection
