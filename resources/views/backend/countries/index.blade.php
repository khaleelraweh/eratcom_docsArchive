@extends('layouts.admin')



@section('content')

    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_residentail_site') }}
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
                        {{ __('panel.show_countries') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_countries')
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_country') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">
            {{-- filter form part  --}}
            @include('backend.countries.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="col-sm-2">{{ __('panel.country_name') }}</th>
                            <th class="d-none d-sm-table-cell"> {{ __('panel.state_count') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.emoji') }}</th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($countries as $country)
                            <tr>
                                <td class="col-sm-2">{{ $country->name_native }}</td>
                                <td class="d-none d-sm-table-cell">{{ $country->states->count() }}</td>
                                <td class="d-none d-sm-table-cell">{{ $country->emoji }}</td>
                                <td>{{ $country->status() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.countries.edit', $country->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-country-{{ $country->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin.countries.destroy', $country->id) }}" method="post"
                                        class="d-none" id="delete-country-{{ $country->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('panel.no_found_item') }}</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="float-right">
                                    {{-- {!! $countries->appends(request()->all())->onEachSide(0)->links() !!} --}}
                                    {!! $countries->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>

                </table>

            </div>

        </div>

    </div>
@endsection
