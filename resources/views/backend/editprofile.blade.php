@extends('layouts.admin')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('panel.pages') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('panel.edit_profile') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
            </div>
            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate"
                        data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                @php
                                    if (auth()->user()->user_image != null) {
                                        $user_img = asset('assets/users/' . auth()->user()->user_image);

                                        if (!file_exists(public_path('assets/users/' . auth()->user()->user_image))) {
                                            $user_img = asset('image/not_found/avator2.webp');
                                        }
                                    } else {
                                        $user_img = asset('image/not_found/avator2.webp');
                                    }
                                @endphp
                                <img alt="" src="{{ $user_img }}"><a class="fas fa-camera profile-edit"
                                    href="JavaScript:void(0);"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ auth()->user()->full_name }}</h5>
                                    <p class="main-profile-name-text">
                                        [
                                        @foreach (auth()->user()->roles as $role)
                                            {{ $role->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                        ]
                                    </p>
                                </div>
                            </div>
                            <h6>{{ __('panel.Bio') }}</h6>
                            <div class="main-profile-bio">
                                {{ auth()->user()->biography }}
                                <a href="">{{ __('panel.more') }}</a>
                            </div><!-- main-profile-bio -->
                            <div class="row">
                                <div class="col-md-4 col mb20">
                                    <h5>947</h5>
                                    <h6 class="text-small text-muted mb-0">Followers</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>583</h5>
                                    <h6 class="text-small text-muted mb-0">Tweets</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>48</h5>
                                    <h6 class="text-small text-muted mb-0">Posts</h6>
                                </div>
                            </div>
                            <hr class="mg-y-30">
                            <label class="main-content-label tx-13 mg-b-20">{{ __('panel.social') }}</label>
                            <div class="main-profile-social-list">
                                <div class="media">
                                    <div class="media-icon bg-primary-transparent text-primary">
                                        <i class="icon ion-logo-github"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>{{ __('panel.github') }}</span>
                                        @if (auth()->user()->github)
                                            <a href="github.com/{{ auth()->user()->github }}">
                                                github.com/{{ auth()->user()->github }}
                                            </a>
                                        @else
                                            -----
                                        @endif
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-success-transparent text-success">
                                        <i class="icon ion-logo-twitter"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>{{ __('panel.twitter') }}</span>
                                        @if (auth()->user()->twitter)
                                            <a href="twitter.com/{{ auth()->user()->twitter }}">
                                                twitter.com/{{ auth()->user()->twitter }}
                                            </a>
                                        @else
                                            -----
                                        @endif
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-info-transparent text-info">
                                        <i class="icon ion-logo-linkedin"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>{{ __('panel.linkedin') }}</span>
                                        @if (auth()->user()->linkedin)
                                            <a href="linkedin.com/in/{{ auth()->user()->linkedin }}">
                                                linkedin.com/in/{{ auth()->user()->linkedin }}
                                            </a>
                                        @else
                                            -----
                                        @endif
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-danger-transparent text-danger">
                                        <i class="icon ion-md-link"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>{{ __('panel.my_portfolio') }}</span>
                                        @if (auth()->user()->website)
                                            <a href="{{ auth()->user()->website }}">
                                                auth()->user()->website
                                            </a>
                                        @else
                                            -----
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr class="mg-y-30">
                            <h6>{{ __('panel.skills') }}</h6>
                            <div class="skill-bar mb-4 clearfix mt-3">
                                <span>HTML5 / CSS3</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-primary-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 85%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                            <div class="skill-bar mb-4 clearfix">
                                <span>Javascript</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-danger-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 89%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                            <div class="skill-bar mb-4 clearfix">
                                <span>Bootstrap</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-success-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                            <div class="skill-bar clearfix">
                                <span>Coffee</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-info-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 95%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label tx-13 mg-b-25">
                        {{ __('panel.contact') }}
                    </div>
                    <div class="main-profile-contact-list">
                        <div class="media">
                            <div class="media-icon bg-primary-transparent text-primary">
                                <i class="icon ion-md-phone-portrait"></i>
                            </div>
                            <div class="media-body">
                                <span>{{ __('panel.mobile') }}</span>
                                <div>
                                    {{ auth()->user()->mobile }}
                                </div>
                            </div>
                        </div>

                        <div class="media">
                            <div class="media-icon bg-info-transparent text-info">
                                <i class="icon ion-md-locate"></i>
                            </div>
                            <div class="media-body">
                                <span> {{ __('panel.current_address') }}</span>
                                <div>

                                    @if (auth()->user()->addresses->isNotEmpty())
                                        {{ auth()->user()->addresses->first()->address_title }}
                                    @else
                                        {{ __('panel.no_address_available') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!-- main-profile-contact-list -->
                </div>
            </div>
        </div>

        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">{{ __('panel.personal_inforamtion') }}</div>
                    <form class="form-horizontal">
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.language') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control select2">
                                        <option>Us English</option>
                                        <option>Arabic</option>
                                        <option>Korean</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">{{ __('panel.name') }}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.username') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="username" class="form-control" placeholder="User Name"
                                        value="{{ auth()->user()->username }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.first_name') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="First Name" value="{{ auth()->user()->first_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.last_name') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        value="{{ auth()->user()->last_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Nick Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Nick Name" value="Petey">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Designation</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Designation"
                                        value="Web Designer">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">{{ __('panel.contact_info') }}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label
                                        class="form-label">{{ __('panel.email') }}<i>({{ __('panel.required') }})</i></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="email" class="form-control" placeholder="Email"
                                        value="{{ auth()->user()->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.website') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="website" class="form-control" placeholder="Website"
                                        value="{{ auth()->user()->website }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.mobile') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="mobile" class="form-control" placeholder="phone number"
                                        value="{{ auth()->user()->mobile }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.current_address') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="example-textarea-input" rows="2" placeholder="Address">
@if (auth()->user()->addresses->isNotEmpty())
{{ auth()->user()->addresses->first()->address_title }}@else{{ __('panel.no_address_available') }}
@endif
</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">{{ __('panel.social_info') }}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.twitter') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="twitter" class="form-control" placeholder="twitter"
                                        value="twitter.com/{{ auth()->user()->twitter }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.facebook') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="facebook" class="form-control" placeholder="facebook"
                                        value="https://www.facebook.com/{{ auth()->user()->facebook }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.google_plus') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="google_plus" class="form-control" placeholder="google"
                                        value="{{ auth()->user()->google_plus }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.linkedin') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="linkedin" class="form-control" placeholder="linkedin"
                                        value="linkedin.com/in/{{ auth()->user()->linkedin }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.github') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="github" class="form-control" placeholder="github"
                                        value="github.com/{{ auth()->user()->github }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">{{ __('panel.about_yourself') }}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.biographical_info') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="biography" rows="4" placeholder="">{!! auth()->user()->biography !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">{{ __('panel.email_preferences') }}</div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('panel.verified_user') }}</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="custom-controls-stacked">
                                        <label class="ckbox mg-b-10"><input checked="" type="checkbox"><span>
                                                {{ __('panel.accept_to_receive_post_or_page_notification_emails') }}
                                            </span></label>
                                        <label class="ckbox"><input checked="" type="checkbox"><span>
                                                {{ __('panel.Accept_to_receive_email_sent_to_multiple_recipients') }}
                                            </span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-left">
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light">{{ __('panel.update_profile') }}</button>
                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
