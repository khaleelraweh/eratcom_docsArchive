@extends('layouts.admin')

@section('style')
    <style>
        .picker__select--month,
        .picker__select--year {
            padding: 0 !important;
        }

        .picker__list {
            list-style-type: none;
        }

        .note-editor.note-airframe,
        .note-editor.note-frame {
            margin-bottom: 0 !important;
        }
    </style>
@endsection

@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_country') }}
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
                        <a href="{{ route('admin.countries.index') }}">
                            {{ __('panel.show_countries') }}
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

            <form action="{{ route('admin.countries.update', $country->id) }}" method="post">
                @csrf
                @method('PATCH')

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab"
                            aria-controls="content" aria-selected="true">البيانات الاساسية </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="publish-tab" data-toggle="tab" href="#publish" role="tab"
                            aria-controls="publish" aria-selected="false">بيانات النشر</a>
                    </li>
                </ul>


                <div class="tab-content" id="myTabContent">

                    {{-- content tab without image   --}}
                    <div class="tab-pane fade active show" id="content" role="tabpanel" aria-labelledby="content-tab">

                        {{-- row part in content   --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="name">إسم الدولة</label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $country->name) }}" class="form-control" placeholder="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="name_native">إسم الدولة native</label>
                                    <input type="text" id="name" name="name_native"
                                        value="{{ old('name_native', $country->name_native) }}" class="form-control"
                                        placeholder="">
                                    @error('name_native')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- row part in content   --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="country_code">كود الايزوا للدولة</label>
                                    <input type="text" id="name" name="country_code"
                                        value="{{ old('country_code', $country->country_code) }}" class="form-control"
                                        placeholder="">
                                    @error('country_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="phone_code">مفتاح الدولة</label>
                                    <input type="text" id="name" name="phone_code"
                                        value="{{ old('phone_code', $country->phone_code) }}" class="form-control"
                                        placeholder="">
                                    @error('phone_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- row part in content   --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-3 pt-4">
                                <div class="form-group">
                                    <label for="currency_name">اسم العملة en</label>
                                    <input type="text" id="name" name="currency_name"
                                        value="{{ old('currency_name', $country->currency_name) }}" class="form-control"
                                        placeholder="">
                                    @error('currency_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 pt-4">
                                <div class="form-group">
                                    <label for="currency_name_native">اسم العملة native</label>
                                    <input type="text" id="name" name="currency_name_native"
                                        value="{{ old('currency_name_native', $country->currency_name_native) }}"
                                        class="form-control" placeholder="">
                                    @error('currency_name_native')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 pt-4">
                                <div class="form-group">
                                    <label for="currency">رمز العملة en iso3 </label>
                                    <input type="text" id="name" name="currency"
                                        value="{{ old('currency', $country->currency) }}" class="form-control"
                                        placeholder="">
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 pt-4">
                                <div class="form-group">
                                    <label for="currency_symbol"> رمز العملة symbol native </label>
                                    <input type="text" id="name" name="currency_symbol"
                                        value="{{ old('currency_symbol', $country->currency_symbol) }}"
                                        class="form-control" placeholder="">
                                    @error('currency_symbol')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        {{-- row part in content   --}}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="capital">عاصمة الدولة </label>
                                    <input type="text" id="name" name="capital"
                                        value="{{ old('capital', $country->capital) }}" class="form-control"
                                        placeholder="">
                                    @error('capital')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 pt-4">
                                <label for="region">القارة </label>
                                <select name="region" class="form-control">
                                    <option value="Asia"
                                        {{ old('region', $country->region) == 'Asia' ? 'selected' : null }}>آسيا</option>
                                    <option value="Americas"
                                        {{ old('region', $country->region) == 'Americas' ? 'selected' : null }}>امريكا
                                    </option>
                                    <option value="Europe"
                                        {{ old('region', $country->region) == 'Europe' ? 'selected' : null }}>اوروبا
                                    </option>
                                    <option value="Africa"
                                        {{ old('region', $country->region) == 'Africa' ? 'selected' : null }}>افريقيا
                                    </option>
                                    <option value="Oceania"
                                        {{ old('region', $country->region) == 'Oceania' ? 'selected' : null }}>استراليا
                                    </option>
                                </select>
                                @error('region')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        {{-- row part in content   --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="nationality"> الجنسية</label>
                                    <input type="text" id="name" name="nationality"
                                        value="{{ old('nationality', $country->nationality) }}" class="form-control"
                                        placeholder="">
                                    @error('nationality')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="nationality_native"> الجنسية native</label>
                                    <input type="text" id="name" name="nationality_native"
                                        value="{{ old('nationality_native', $country->nationality_native) }}"
                                        class="form-control" placeholder="">
                                    @error('nationality_native')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        {{-- row part in content   --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="translations"> الترجمة</label>
                                    <input type="text" id="name" name="translations"
                                        value="{{ old('translations') }}" class="form-control" placeholder="">
                                    @error('translations')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="emoji"> علم الدولة</label>
                                    <input type="text" id="name" name="emoji"
                                        value="{{ old('emoji', $country->emoji) }}" class="form-control" placeholder="">
                                    @error('emoji')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Publish Tab --}}
                    <div class="tab-pane fade" id="publish" role="tabpanel" aria-labelledby="publish-tab">


                        {{-- published_on and published_on_time  --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="published_on">تاريخ النشر</label>
                                    <input type="text" id="published_on" name="published_on"
                                        value="{{ old('published_on', \Carbon\Carbon::parse($country->published_on)->Format('Y-m-d')) }}"
                                        class="form-control">
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="published_on_time">وقت النشر</label>
                                    <input type="text" id="published_on_time" name="published_on_time"
                                        value="{{ old('published_on_time', \Carbon\Carbon::parse($country->published_on)->Format('h:i A')) }}"
                                        class="form-control">
                                    @error('published_on_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <label for="status">الحالة </label>
                                <select name="status" class="form-control">
                                    <option value="1"
                                        {{ old('status', $country->status) == '1' ? 'selected' : null }}>مفعل</option>
                                    <option value="0"
                                        {{ old('status', $country->status) == '0' ? 'selected' : null }}>غير مفعل</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- submit button  --}}
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

            // This is only for start dant and expire date of country 
            // ======= start pickadate codeing ===========
            $('#start_date').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true, // Creates a dropdown to control month
                selectYears: true, // creates a dropdown to control years
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close Upon Selecting a date
            });

            $('#expire_date').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true, // Creates a dropdoen to control month
                selectYears: true, // Creates a dropdown to control month 
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close upon selecting a date ,
            });

            var startdate = $('#start_date').pickadate(
                'picker'); // set startdate in the picker to the start date in the #start_date elemet
            var enddate = $('#expire_date').pickadate('picker');

            // when change date 
            $('#start_date').change(function() {
                selected_ci_date = "";
                selected_ci_date = $('#start_date')
                    .val(); // make selected start date in picker = start_date value
                if (selected_ci_date != null) {
                    var cidate = new Date(
                        selected_ci_date
                    ); // make cidate(start date ) = current date you selected in selected ci date (selected start date )
                    min_codate = "";
                    min_codate = new Date();
                    min_codate.setDate(cidate.getDate() +
                        1); // minimum selected date to be expired shoud be current date plus one 
                    enddate.set('min', min_codate);
                }

            });

            // This is for publish this country =========================
            // ======= start pickadate codeing ===========

            $('#published_on').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true, // Creates a dropdown to control month
                selectYears: true, // creates a dropdown to control years
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close Upon Selecting a date
            });


            var publishedOn = $('#published_on').pickadate(
                'picker'); // set startdate in the picker to the start date in the #start_date elemet

            // when change date 
            $('#published_on').change(function() {
                selected_ci_date = "";
                selected_ci_date = now() // make selected start date in picker = start_date value  

            });

            $('#published_on_time').pickatime({
                clear: ''
            });

            // ======= End pickadate codeing ===========



            $('.summernote').summernote({
                tabSize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


        });
    </script>
@endsection
