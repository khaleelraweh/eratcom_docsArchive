<div>
    <header class="d-flex justify-content-end">
        <div class="completed-section-badge">
            @if ($databaseDataValid || ($formSubmitted && !$errors->any()))
                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
            @endif
        </div>
    </header>
    <p class="h6 py-3 text-muted">{{ __('transf.intended_description') }} </p>

    <form wire:submit.prevent="storeIntended">

        {{-- Objectives --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h4>{{ __('transf.what_will_students_learn_in_your_course?') }}</h4>
                    <h6>{{ __('transf.what_will_students_learn_tips') }}</h6>
                    <!-- Display validation errors -->
                    @if ($errors->has('objectives'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->get('objectives') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div>
                    @if ($objectivesValid || ($formSubmitted && !$errors->any()))
                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="products_table">
                    <thead>
                        <tr>
                            <th>{{ __('transf.objective') }} </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($objectives as $index => $objective)
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="objectives[{{ $index }}][title]"
                                            class="form-control" wire:model="objectives.{{ $index }}.title"
                                            placeholder="{{ __('transf.example:define_the_roles_and_responsibilities_of_a_project_manager') }}" />
                                        <span
                                            class="input-group-text">{{ 160 - strlen($objectives[$index]['title']) }}</span>
                                    </div>

                                    <!-- Display validation error for current objective -->
                                    @error('objectives.' . $index . '.title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <a href="#"
                                        wire:click.prevent="removeObjective({{ $index }})">{{ __('transf.delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-secondary" wire:click.prevent="addObjective">
                            + {{ __('transf.add_another_objective') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Requirements --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h4>{{ __('transf.what_are_the_requirements_or_prerequisites_for_taking_your_course?') }}</h4>
                    <h6>{{ __('transf.what_are_the_requirements_tips') }}</h6>
                    <!-- Display validation errors -->
                    @if ($errors->has('requirements'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->get('requirements') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div>
                    @if ($requirementsValid || ($formSubmitted && !$errors->any()))
                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                    @endif
                </div>
            </div>

            <div class="card-body">

                <table class="table" id="products_table">
                    <thead>
                        <tr>
                            <th>{{ __('transf.requirement') }} </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requirements as $index => $requirement)
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="requirements[{{ $index }}][title]"
                                            class="form-control" wire:model="requirements.{{ $index }}.title"
                                            placeholder="{{ __('transf.example:no_programming_experience_needed.you_will_learn_everything_you_need_to_know') }}" />
                                        <span
                                            class="input-group-text">{{ 160 - strlen($requirements[$index]['title']) }}</span>
                                    </div>


                                    <!-- Display validation error for current requirement -->
                                    @error('requirements.' . $index . '.title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </td>
                                <td>
                                    <a href="#"
                                        wire:click.prevent="removeRequirement({{ $index }})">{{ __('transf.delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-secondary" wire:click.prevent="addRequirement">
                            + {{ __('transf.add_another_requirement') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Intended Learnerss --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h4>{{ __('transf.who_is_this_course_for?') }}</h4>
                    <h6>{{ __('transf.who_is_this_course_for_tips') }}</h6>

                    <!-- Display validation errors -->
                    @if ($errors->has('intendeds'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->get('intendeds') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div>
                    @if ($intendedsValid || ($formSubmitted && !$errors->any()))
                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                    @endif
                </div>
            </div>

            <div class="card-body">

                <table class="table" id="products_table">
                    <thead>
                        <tr>
                            <th>{{ __('transf.intended_learner') }} </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($intendeds as $index => $intended)
                            <tr>
                                <td>

                                    <div class="input-group">
                                        <input type="text" name="intendeds[{{ $index }}][title]"
                                            class="form-control" wire:model="intendeds.{{ $index }}.title"
                                            placeholder="{{ __('transf.example:beginner_python_developers_curious_about_data_science') }}" />
                                        <span
                                            class="input-group-text">{{ 160 - strlen($intendeds[$index]['title']) }}</span>
                                    </div>


                                    <!-- Display validation error for current intended -->
                                    @error('intendeds.' . $index . '.title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </td>
                                <td>
                                    <a href="#"
                                        wire:click.prevent="removeIntended({{ $index }})">{{ __('transf.delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-secondary" wire:click.prevent="addIntended">
                            + {{ __('transf.add_more_to_your_response') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <div class="">
            <input class="btn btn-primary" type="submit" value="{{ __('transf.save') }}">
        </div>
    </form>
</div>
