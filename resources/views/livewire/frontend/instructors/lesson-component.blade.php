<div>
    <header class="d-flex justify-content-end">
        <div class="completed-section-badge">
            @if ($databaseDataValid && !$errors->any())
                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
            @endif
        </div>
    </header>
    <p class="h6 py-2 text-muted mb-1">
        {{ __('transf.curriculum_description') }}

    </p>


    <span class="d-inline-block text-muted">{{ __('transf.curriculum_need') }}</span>
    <ul class="h6 pb-3 text-muted ">

        <li>{{ __('transf.curriculum_need_lessons') }} </li>
        <li>{{ __('transf.curriculum_need_video_records') }} </li>
    </ul>

    <form wire:submit.prevent="storeSections">
        {{-- <form> --}}

        {{-- Sections --}}
        @if (!empty($sections))

            @foreach ($sections as $index => $section)
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div>
                            <!-- Input field for section title -->
                            @if ($editSectionTitleIndex !== $index)
                                @if (isset($section['sectionId']) && $section['sectionId'] == -1)
                                    <input type="text" class="form-control"
                                        wire:model="sections.{{ $index }}.title"
                                        placeholder="{{ __('transf.Enter a Section Title') }}">
                                @else
                                    <span>{{ $section['title'] }}</span>
                                @endif
                            @else
                                <input type="text" class="form-control"
                                    wire:model="sections.{{ $index }}.title">
                            @endif
                        </div>
                        <div class="d-flex">
                            <div class="me-2">
                                <!-- Button to toggle edit state -->
                                @if ($editSectionTitleIndex !== $index)
                                    @if (isset($section['sectionId']) && $section['sectionId'] == -1)
                                        <button class="btn btn-sm btn-primary"
                                            wire:click.prevent="saveSection({{ $index }})">
                                            {{ __('transf.Save Section') }}
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-primary"
                                            wire:click.prevent="toggleEditSectionTitle({{ $index }})">
                                            {{ __('transf.Edit Section') }}
                                        </button>
                                    @endif
                                @else
                                    <!-- Button to save section title -->
                                    <button class="btn btn-sm btn-primary"
                                        wire:click.prevent="saveSection({{ $index }})">
                                        {{ __('transf.Save Section') }}
                                    </button>
                                @endif
                            </div>
                            <button class="btn btn-sm btn-danger"
                                wire:click.prevent="removeSection({{ $index }})">
                                {{ __('transf.Remove Section') }}
                            </button>
                        </div>
                    </div>

                    @if ($section['saved'])
                        <div class="card-body">
                            {{-- Lessons for this section --}}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('transf.Lesson Title') }}</th>
                                        <th>{{ __('transf.Url') }}</th>
                                        <th>{{ __('transf.Duration') }}</th>
                                        <th>{{ __('transf.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($section['lessons'] as $lessonIndex => $lesson)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control"
                                                    wire:model="sections.{{ $index }}.lessons.{{ $lessonIndex }}.title"
                                                    placeholder="{{ __('transf.Enter a Lesson Title') }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    wire:model="sections.{{ $index }}.lessons.{{ $lessonIndex }}.url"
                                                    placeholder="{{ __('transf.Enter a Youtube Lesson Url') }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    wire:model="sections.{{ $index }}.lessons.{{ $lessonIndex }}.duration_minutes"
                                                    placeholder="{{ __('transf.Enter a Lesson  Duration in Minutes') }}">
                                            </td>
                                            <td>
                                                <!-- Button to remove lesson -->
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click.prevent="removeLesson({{ $index }}, {{ $lessonIndex }})">
                                                    {{ __('transf.Remove') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex">
                                <!-- Button to add a new lesson for this section -->
                                <button class="btn btn-sm btn-secondary me-2"
                                    wire:click.prevent="addLesson({{ $index }})">
                                    + {{ __('transf.Add Lesson') }}
                                </button>
                                <!-- Button to save lessons for this section -->
                                <button class="btn btn-sm btn-success"
                                    wire:click.prevent="saveLessonsInSection({{ $index }})">
                                    {{ __('transf.Save Lessons') }}
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif


        <div class="d-flex justify-content-between" style="">
            <!-- Button to add a new section -->
            <button class="btn btn-primary" wire:click.prevent="addSection()">
                + {{ __('transf.Add Section') }}
            </button>

            <div>
                <input class="btn btn-primary" type="submit" value="{{ __('transf.save_in_one_click') }}">
            </div>
        </div>
    </form>
</div>
