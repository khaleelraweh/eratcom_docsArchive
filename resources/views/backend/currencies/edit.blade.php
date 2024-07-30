@extends('layouts.admin')

@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_currency') }}
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
                        <a href="{{ route('admin.currencies.index') }}">
                            {{ __('panel.show_currencies') }}
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- body part  --}}
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

            {{-- enctype used cause we will save images  --}}
            <form action="{{ route('admin.currencies.update', $currency->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach (config('locales.languages') as $key => $val)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->index == 0 ? 'active' : '' }}" id="{{ $key }}-tab"
                                data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab"
                                aria-controls="{{ $key }}" aria-selected="true">
                                {{ __('panel.name_symbol_tab') }} ({{ $key }})
                            </button>
                        </li>
                    @endforeach

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button"
                            role="tab" aria-controls="url" aria-selected="true">{{ __('panel.code_rate_tab') }}
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="published-tab" data-bs-toggle="tab" data-bs-target="#published"
                            type="button" role="tab" aria-controls="published"
                            aria-selected="false">{{ __('panel.published_tab') }}
                        </button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">

                    {{-- Content Tab --}}
                    @foreach (config('locales.languages') as $key => $val)
                        <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $key }}"
                            role="tabpanel" aria-labelledby="{{ $key }}">

                            {{--  currency_name field --}}
                            <div class="row ">
                                <div class="col-12 pt-4">
                                    <div class="form-group">
                                        <label for="currency_name[{{ $key }}]">
                                            {{ __('panel.currency_name') }}
                                            {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                        </label>
                                        <input type="text" id="currency_name[{{ $key }}]"
                                            name="currency_name[{{ $key }}]"
                                            value="{{ old('currency_name.' . $key, $currency->getTranslation('currency_name', $key)) }}"
                                            class="form-control">
                                        @error('currency_name.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{--  currency_symbol field --}}
                            <div class="row">
                                <div class="col-sm-12 col-md-12 pt-3">
                                    <div class="form-group">
                                        <label for="currency_symbol[{{ $key }}]">
                                            {{ __('panel.currency_symbol') }}
                                            {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                        </label>
                                        <input type="text" id="currency_symbol[{{ $key }}]"
                                            name="currency_symbol[{{ $key }}]"
                                            value="{{ old('currency_symbol.' . $key, $currency->getTranslation('currency_symbol', $key)) }}"
                                            class="form-control">
                                        @error('currency_symbol.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach

                    {{-- Code and Rate  Tab --}}
                    <div class="tab-pane fade" id="url" role="tabpanel" aria-labelledby="url-tab">


                        {{--  currency_code field --}}
                        <div class="row ">
                            <div class="col-12 pt-4">
                                <div class="form-group">
                                    <label for="currency_code">رمز العملة</label>
                                    <input type="text" id="currency_code" name="currency_code"
                                        value="{{ old('currency_code', $currency->currency_code) }}" class="form-control">
                                    @error('currency_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{--  exchange_rate field --}}
                        <div class="row ">
                            <div class="col-12 pt-4">
                                <div class="form-group">
                                    <label for="exchange_rate">سعر الصرف</label>
                                    <input type="text" id="exchange_rate" name="exchange_rate"
                                        value="{{ old('exchange_rate', $currency->exchange_rate) }}" class="form-control">
                                    @error('exchange_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Published Tab --}}
                    <div class="tab-pane fade" id="published" role="tabpanel" aria-labelledby="published-tab">

                        {{-- published_on and published_on_time  --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on"> {{ __('panel.published_date') }}</label>
                                    <input type="text" id="published_on" name="published_on"
                                        value="{{ old('published_on', \Carbon\Carbon::parse($currency->published_on)->Format('Y-m-d')) }}"
                                        class="form-control">
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on_time">{{ __('panel.published_time') }}</label>
                                    <input type="text" id="published_on_time" name="published_on_time"
                                        value="{{ old('published_on_time', \Carbon\Carbon::parse($currency->published_on)->Format('h:i A')) }}"
                                        class="form-control">
                                    @error('published_on_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 pt-3">
                                <label for="status" class="control-label col-md-2 col-sm-12 ">
                                    <span>{{ __('panel.status') }}</span>
                                </label>
                                <select name="status" class="form-control">
                                    <option value="1"
                                        {{ old('status', $currency->status) == '1' ? 'selected' : null }}>
                                        {{ __('panel.status_active') }}
                                    </option>
                                    <option value="0"
                                        {{ old('status', $currency->status) == '0' ? 'selected' : null }}>
                                        {{ __('panel.status_inactive') }}
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-group pt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            {{ __('panel.update_data') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection

@section('script')
    <script>
        $(function() {


            // ======= start pickadate codeing  for start and end date ===========

            $('#published_on').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true,
                selectYears: true,
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true
            });
            var publishedOn = $('#published_on').pickadate(
                'picker');
            $('#published_on').change(function() {
                selected_ci_date = "";
                selected_ci_date = now()

            });

            $('#published_on_time').pickatime({
                clear: ''
            });

            // ======= End pickadate codeing for publish start and end date  ===========

        });
    </script>
@endsection
