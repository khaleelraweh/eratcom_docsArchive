@extends('layouts.admin')


@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_payment_category') }}
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
                        <a href="{{ route('admin.payment_categories.index') }}">
                            {{ __('panel.show_payment_categories') }}
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- body part  --}}
        <div class="card-body">
            <form action="{{ route('admin.payment_categories.update', $paymentCategory->id) }}" method="post"
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
                                {{ __('panel.content_tab') }}({{ $key }})
                            </button>
                        </li>
                    @endforeach

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="published-tab" data-bs-toggle="tab" data-bs-target="#published"
                            type="button" role="tab" aria-controls="published"
                            aria-selected="false">{{ __('panel.published_tab') }}
                        </button>
                    </li>

                </ul>

                {{-- contents of links tabs  --}}
                <div class="tab-content" id="myTabContent">

                    @foreach (config('locales.languages') as $key => $val)
                        <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $key }}"
                            role="tabpanel" aria-labelledby="{{ $key }}">

                            <div class="row">

                                {{-- البيانات الاساسية --}}
                                <div class=" {{ $loop->index == 0 ? 'col-md-7' : '' }} col-sm-12 ">

                                    {{-- slider title field --}}
                                    <div class="row ">
                                        <div class="col-sm-12 pt-3">
                                            <div class="form-group">
                                                <label for="title[{{ $key }}]">
                                                    {{ __('panel.title') }}
                                                    {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                                </label>
                                                <input type="text" name="title[{{ $key }}]"
                                                    id="title[{{ $key }}]"
                                                    value="{{ old('title.' . $key, $paymentCategory->getTranslation('title', $key)) }}"
                                                    class="form-control">
                                                @error('title.' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{--  description field --}}
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 pt-4">
                                            <label for="description[{{ $key }}]">
                                                {{ __('panel.description') }}
                                                {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                            </label>
                                            <textarea name="description[{{ $key }}]" rows="10" class="form-control summernote">
                                            {!! old('description.' . $key, $paymentCategory->getTranslation('description', $key)) !!}
                                        </textarea>
                                        </div>
                                    </div>

                                </div>

                                {{-- مرفق الصورة --}}
                                <div class=" {{ $loop->index == 0 ? 'col-md-5' : 'd-none' }}  col-sm-12 ">

                                    {{-- الصورة  --}}
                                    <div class="row">

                                        <div class="col-sm-12 pt-4">

                                            <label for="images" class="control-label col-md-3 col-sm-12 ">
                                                {{ __('panel.image') }}
                                            </label>

                                            <div class="file-loading">
                                                <input type="file" name="images[]" id="product_images"
                                                    class="file-input-overview" multiple="multiple">
                                            </div>
                                            @error('images')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                    {{-- Published Tab --}}
                    <div class="tab-pane fade" id="published" role="tabpanel" aria-labelledby="published-tab">

                        {{-- published_on and published_on_time  --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on"> {{ __('panel.published_date') }}</label>
                                    <input type="text" id="published_on" name="published_on"
                                        value="{{ old('published_on', \Carbon\Carbon::parse($paymentCategory->published_on)->Format('Y-m-d')) }}"
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
                                        value="{{ old('published_on_time', \Carbon\Carbon::parse($paymentCategory->published_on)->Format('h:i A')) }}"
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
                                        {{ old('status', $paymentCategory->status) == '1' ? 'selected' : null }}>
                                        {{ __('panel.status_active') }}
                                    </option>
                                    <option value="0"
                                        {{ old('status', $paymentCategory->status) == '0' ? 'selected' : null }}>
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
    {{-- pickadate calling js --}}

    <script src="{{ asset('backend/vendor/datepicker/picker.js') }}"></script>
    <script src="{{ asset('backend/vendor/datepicker/picker.date.js') }}"></script>
    <script src="{{ asset('backend/vendor/datepicker/picker.time.js') }}"></script>
    <script>
        $(function() {



            $("#product_images").fileinput({
                theme: "fa5",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                // اضافات للتعامل مع الصورة عند التعديل علي احد اقسام المنتجات
                // delete images from photos and assets/products 
                // because there are maybe more than one image we will go for each image and show them in the edit page 
                initialPreview: [
                    @if ($paymentCategory->photos()->count() > 0)
                        @foreach ($paymentCategory->photos as $media)
                            "{{ asset('assets/payment_categories/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($paymentCategory->photos()->count() > 0)
                        @foreach ($paymentCategory->photos as $media)
                            {
                                caption: "{{ $media->file_name }}",
                                size: '{{ $media->file_size }}',
                                width: "120px",
                                // url : الراوت المستخدم لحذف الصورة
                                url: "{{ route('admin.payment_categories.remove_image', ['image_id' => $media->id, 'payment_category_id' => $paymentCategory->id, '_token' => csrf_token()]) }}",
                                key: {{ $media->id }}
                            },
                        @endforeach
                    @endif

                ]
            }).on('filesorted', function(event, params) {
                console.log(params.previewId, params.oldIndex, params.newIndex, params.stack);
            });



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


            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
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
