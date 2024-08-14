<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/admin/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/admin/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="main-logo dark-theme"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ url('/admin/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/admin/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/favicon-white.png') }}" class="logo-icon dark-theme"
                alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">

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


                    <img alt="user-img" class="avatar avatar-xl brround" src="{{ $user_img }}">

                    <span class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->full_name }}</h4>
                    <span class="mb-0 text-muted">
                        [
                        @foreach (auth()->user()->roles as $role)
                            {{ $role->name }}
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                        ]


                    </span>
                </div>
            </div>
        </div>
        <ul class="side-menu">

            @foreach ($admin_side_menu as $menu)
                @if (count($menu->appearedChildren) == 0)
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('admin.' . $menu->as) }}">
                            <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }} side-menu side-menu__icon"
                                style="font-size: 1rem;line-height: 150%"></i>
                            <span class="side-menu__label">{{ $menu->display_name }}</span>
                        </a>
                    </li>
                @else
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/admin/' . ($page = '#')) }}">
                            <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }} side-menu side-menu__icon"
                                style="font-size: 1rem;line-height: 150%"></i>
                            <span class="side-menu__label">{{ $menu->display_name }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>

                        <style>
                            .slide-item::before {
                                content: '' !important;
                            }
                        </style>

                        @if ($menu->appearedChildren !== null && count($menu->appearedChildren) > 0)
                            <ul class="slide-menu">
                                @foreach ($menu->appearedChildren as $sub_menu)
                                    <li>
                                        <a class="slide-item" href="{{ route('admin.' . $sub_menu->as) }}">
                                            <i class="{{ $sub_menu->icon != null ? $sub_menu->icon : 'fas fa-home' }} side-menu side-menu__icon my_custom_icon"
                                                style="font-size: 1rem;line-height: 150% ; "></i>
                                            {{ $sub_menu->display_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach

        </ul>
    </div>
</aside>
