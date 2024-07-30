<div>
    <header class="d-flex justify-content-end">
        <div class="completed-section-badge">
            @if ($databaseDataValid || ($formSubmitted && !$errors->any()))
                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
            @endif
        </div>
    </header>
    <p class="h6 py-3 text-muted">{{ __('transf.Course Landing Page Description') }} </p>

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.Course Landing Page') }}
                </h3>
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


            <form wire:submit.prevent="updateCourse" id="my_form_id" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="course_content-tab" data-bs-toggle="tab"
                            data-bs-target="#course_content" type="button" role="tab"
                            aria-controls="course_content" aria-selected="true">{{ __('transf.course_content_tab') }}
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="course_info-tab" data-bs-toggle="tab" data-bs-target="#course_info"
                            type="button" role="tab" aria-controls="course_info"
                            aria-selected="true">{{ __('transf.course_info_tab') }}
                        </button>
                    </li>


                </ul>

                {{-- contents of links tabs  --}}
                <div class="tab-content" id="myTabContent">


                    {{-- Course info --}}
                    <div class="tab-pane fade show active" id="course_content" role="tabpanel"
                        aria-labelledby="course_content-tab">

                        <div class="row">
                            {{-- البيانات الاساسية --}}
                            <div class="col-md-12 col-sm-12 ">
                                {{-- course name field --}}
                                <div class="row ">
                                    <div class="col-sm-12 pt-3">
                                        <div class="form-group">
                                            <label for="title">
                                                {{ __('transf.course_title') }}
                                            </label>

                                            <div class="input-group">
                                                <input type="text" name="title" id="title" wire:model="title"
                                                    value="{{ old('title', $course->title) }}" class="form-control"
                                                    placeholder="{{ __('transf.Insert your course title.') }}"
                                                    style="height: 45px;">
                                                <span class="input-group-text">{{ 60 - strlen($title) }}</span>
                                            </div>
                                            <span class="text-muted d-inline-block mt-1">
                                                <small>
                                                    {{ __('transf.Insert your course title tip.') }}
                                                </small>
                                            </span>
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- course subtitle field --}}
                                <div class="row ">
                                    <div class="col-sm-12 pt-3">
                                        <div class="form-group">
                                            <label for="subtitle">
                                                {{ __('transf.Course subtitle') }}

                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="subtitle" id="subtitle"
                                                    wire:model="subtitle"
                                                    value="{{ old('subtitle', $course->subtitle) }}"
                                                    class="form-control"
                                                    placeholder="{{ __('transf.Insert your course subtitle.') }}"
                                                    style="height: 45px;">
                                                <span class="input-group-text">{{ 120 - strlen($subtitle) }}</span>
                                            </div>


                                            <span class="text-muted d-inline-block mt-1">
                                                <small>
                                                    {{ __('transf.Course subtitle tip.') }}
                                                </small>
                                            </span>
                                            @error('subtitle')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{--  description field --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-4">
                                        <label for="description">{{ __('transf.Course description') }}</label>
                                        <textarea name="description" id="descriptionTextarea" rows="10" class="form-control" wire:model.defer="description"
                                            placeholder="{{ __('transf.Insert your course description.') }}"></textarea>

                                        <div class=" d-flex justify-content-between">
                                            <div class="card-naving">
                                                <small>
                                                    {{ __('transf.Course description tip.') }}
                                                </small>
                                                <small>
                                                    {{ __('transf.Remaining words to reach the minimum number of words for the description field') }}
                                                    {{ $remainingWords }}
                                                </small>

                                            </div>
                                            <div class="card-naving">
                                                <small>
                                                    <span id="wordCount">
                                                        {{ $wordCount }}
                                                    </span>
                                                    {{ __('transf.words') }}
                                                </small>
                                            </div>
                                        </div>

                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 col-sm-12 ">

                                <div class="row">
                                    <div class="col-12 pt-4">
                                        <label for="images">{{ __('transf.Course Image') }}</label>

                                        <img src="{{ $currentImage }}" style="display: block;width:100%;height:200px;"
                                            alt="{{ $course->title }}">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-12 pt-5">
                                <p>
                                    {{ __('transf.Course Image tip.') }}
                                </p>
                                <input type="file" wire:model="images" id="images" class="form-control"
                                    multiple style="height: 39px !important;">
                                @error('images.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        {{-- video promo   --}}
                        <div class="row ">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <label for="video_promo">{{ __('transf.Promotional video') }}</label>
                                <input type="text" name="video_promo" wire:model.defer="video_promo"
                                    id="video_promo" value="{{ old('video_promo', $course->video_promo) }}"
                                    class="form-control"
                                    placeholder="{{ __('transf.Insert the link to your YouTube promotional video.') }}">
                                @error('video_promo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-sm-12 col-md-6 pt-4">
                                {{ __('transf.Promotional video tip.') }}
                            </div>

                        </div>

                        {{-- video description   --}}
                        <div class="row ">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <label for="video_description">{{ __('transf.Descriptional video') }}</label>
                                <input type="text" name="video_description" wire:model.defer="video_description"
                                    id="video_description"
                                    value="{{ old('video_description', $course->video_description) }}"
                                    class="form-control"
                                    placeholder="{{ __('transf.Insert the link to your YouTube Descriptional video.') }}">
                                @error('video_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-sm-12 col-md-6 pt-4">
                                {{ __('transf.Descriptional video tip.') }}
                            </div>

                        </div>

                    </div>

                    {{-- Course basic info --}}
                    <div class="tab-pane fade" id="course_info" role="tabpanel" aria-labelledby="course_info-tab">



                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-3">
                                <label for="language">{{ __('transf.Course Language') }}</label>
                                <select name="language" wire:model.defer="language" class="form-control">
                                    <option value="1"
                                        {{ old($language, $course->language) == '1' ? 'selected' : null }}>
                                        {{ __('transf.lang_ar') }}
                                    </option>
                                    <option value="2"
                                        {{ old($language, $course->language) == '2' ? 'selected' : null }}>
                                        {{ __('transf.lang_en') }}
                                    </option>

                                </select>
                                @error('language')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-sm-12 col-md-6 pt-3">
                                <label for="skill_level">{{ __('transf.Course Level') }}</label>
                                <select name="skill_level" wire:model.defer="skill_level" class="form-control">
                                    <option value=""> -- {{ __('transf.Select Level') }} --
                                    <option value="1"
                                        {{ old($skill_level, $course->skill_level) == '1' ? 'selected' : null }}>
                                        {{ __('transf.Beginner Level') }}
                                    </option>
                                    <option value="2"
                                        {{ old($skill_level, $course->skill_level) == '2' ? 'selected' : null }}>
                                        {{ __('transf.Intermediate Level') }}
                                    </option>
                                    <option value="3"
                                        {{ old($skill_level, $course->skill_level) == '3' ? 'selected' : null }}>
                                        {{ __('transf.Advance Level') }}
                                    </option>
                                    <option value="4"
                                        {{ old($skill_level, $course->skill_level) == '4' ? 'selected' : null }}>
                                        {{ __('transf.All Levels') }}
                                    </option>
                                </select>
                                @error('skill_level')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>


                        <div class="row ">
                            <div class="col-sm-12 col-md-6 pt-3">
                                <label for="course_type">{{ __('transf.Course type') }}</label>
                                <select name="course_type" id="course_type" class="form-control"
                                    wire:model.defer="course_type">
                                    <option value="1"
                                        {{ old($course_type, $course->course_type) == '1' ? 'selected' : null }}>
                                        {{ __('transf.Course presence') }}
                                    </option>
                                    <option value="2"
                                        {{ old($course_type, $course->course_type) == '2' ? 'selected' : null }}>
                                        {{ __('transf.Course enrolled') }}
                                    </option>
                                </select>
                                @error('course_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-sm-12 col-md-6 pt-3">
                                <label for="category_id"> {{ __('transf.course_category_title') }}</label>
                                <select name="course_category_id" wire:model.defer="course_category_id"
                                    class="form-control" style="height: 45px;">
                                    <option value=""> -- {{ __('transf.Select Category') }} --
                                    </option>
                                    @forelse ($course_categories as $course_category)
                                        <option value="{{ $course_category->id }}"
                                            {{ old('course_category_id', $course->course_category_id) == $course_category->id ? 'selected' : null }}>
                                            {{ $course_category->title }} </option>
                                    @empty
                                    @endforelse
                                </select>


                            </div>


                        </div>









                        {{-- course   certificate --}}
                        <div class="row ">

                            <div class="col-sm-12 col-md-6 pt-3">

                                <div class="form-group">
                                    <label for="certificate">{{ __('transf.certificate') }}</label>
                                    <input style="width: 100%" type="checkbox" wire:model.defer="certificate"
                                        id="certificate" class="form-check-input">
                                    <span class="text-muted d-inline-block mt-1">
                                        <small>{{ __('transf.certificate_tip') }}</small>
                                    </span>
                                    @error('certificate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div id="deadline-field" style="display: none" wire:ignore class="col-md-6  pt-3">
                                <div class="form-group">
                                    <label for="deadline">{{ __('transf.deadline_of_the_course') }}</label>
                                    <input type="text" name="deadline" wire:model.defer="deadline"
                                        value="{{ old('deadline', \Carbon\Carbon::parse($course->deadline)->translatedFormat('Y-m-d h:i A')) }}"
                                        class="form-control flatpickr_deadLine">

                                    @error('deadline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>



                    </div>




                    <div class="form-group pt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            {{ __('transf.Update Data') }}
                        </button>
                    </div>


                </div>

            </form>
        </div>






    </div>
</div>


<script>
    document.addEventListener('livewire:load', function() {
        // Get the textarea element
        var textarea = document.getElementById('descriptionTextarea');
        // Get the word count element
        var wordCountElement = document.getElementById('wordCount');

        // Event listener for input changes in the textarea
        textarea.addEventListener('input', function() {
            // Get the current text in the textarea
            var text = textarea.value;
            // Split the text into words
            var words = text.match(/\S+/g) || [];
            // Get the current word count
            var wordCount = words.length;

            // Emit Livewire event to update word count
            Livewire.emit('updateWordCount', wordCount);
        });
    });
</script>
