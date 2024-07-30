@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_currencies') }}
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
                        {{ __('panel.show_currencies') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_currencies')
                    <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_currency') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">
            {{-- filter form part  --}}
            @include('backend.currencies.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th> {{ __('panel.currency_name') }} </th>
                            <th> {{ __('panel.currency_symbol') }}</th>
                            <th> {{ __('panel.currency_code') }} </th>
                            <th> {{ __('panel.currency_exchange_rate') }} </th>
                            <th class="d-none d-sm-table-cell"> {{ __('panel.author') }} </th>
                            <th class="d-none d-sm-table-cell"> {{ __('panel.created_at') }} </th>
                            {{-- <th>الحالة</th> --}}
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($currencies as $currency)
                            <tr>
                                <td>{{ $currency->currency_name }}
                                    @if ($loop->first)
                                        <span> <small class="btn btn-round  rounded-pill btn-success btn-xs"
                                                style="font-size: 9px">{{ __('panel.default_currency') }}
                                            </small></span>
                                    @endif
                                </td>
                                <td>{{ $currency->currency_symbol }}</td>
                                <td>{{ $currency->currency_code }}</td>
                                <td>{{ $currency->exchange_rate }}</td>
                                <td class="d-none d-sm-table-cell">{{ $currency->created_by }}</td>
                                <td class="d-none d-sm-table-cell">{{ $currency->created_at }}</td>
                                {{-- <td>{{ $currency->status() }}</td> --}}
                                <td>

                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.currencies.edit', $currency->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-product-{{ $currency->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        @if ($currency->status == 1)
                                            <a href="javascript:void(0);" class="updateCurrencyStatus btn"
                                                id="currency-{{ $currency->id }}" currency_id="{{ $currency->id }}">
                                                <i class="fas fa-toggle-on fa-lg text-primary" aria-hidden="true"
                                                    status="Active"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0);" class="updateCurrencyStatus btn  "
                                                id="currency-{{ $currency->id }}" currency_id="{{ $currency->id }}">
                                                <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true"
                                                    status="Inactive"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="post"
                                        class="d-none" id="delete-product-{{ $currency->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center"> {{ __('panel.no_found_item') }} </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="float-right">
                                    {!! $currencies->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>
@endsection
