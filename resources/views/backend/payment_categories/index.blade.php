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
                        {{ __('panel.show_payment_categories') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_product_categories')
                    <a href="{{ route('admin.payment_categories.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_payment_category') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">

            {{-- filter form part  --}}
            @include('backend.payment_categories.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('panel.title') }}</th>
                            <th>{{ __('panel.author') }}</th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="d-none d-sm-table-cell"> {{ __('panel.published_on') }} </th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    {{-- <img src="{{asset('assets/product_categories/girls-s-electronies_16999441521.jpg')}}" alt="not found"> --}}
                                    {{ $category->title }}
                                </td>
                                <td>{{ $category->created_by }}</td>
                                <td><span
                                        class="btn btn-round  rounded-pill btn-success btn-xs">{{ $category->status() }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">{{ $category->published_on }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.payment_categories.edit', $category->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-product-category-{{ $category->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin.payment_categories.destroy', $category->id) }}"
                                        method="post" class="d-none" id="delete-product-category-{{ $category->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('panel.no_found_item') }}</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="float-right">
                                {!! $categories->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </div>

        </div>
    </div>

@endsection
