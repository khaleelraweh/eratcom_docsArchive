<div>
    <li class="nav-item border-0 px-0">
        <a href="#"
            class="nav-link d-flex px-3 px-md-4 position-relative {{ !request()->routeIs('frontend.index') ? 'text-secondary' : 'text-white-all' }} icon-xs"
            id="navbarDocumentation" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ri-notification-3-line"></i>
            <span class="badge badge-coral text-white rounded-circle fw-bold badge-float mt-n1 ms-n2 px-0 w-16"
                style="font-size: 8px;">{{ $unreadNotificationsCount }}</span>
        </a>

        <div class="dropdown-menu border-xl shadow-none dropdown-menu-md dropdown-menu-end p-0"
            aria-labelledby="page-header-notifications-dropdown" style="position: absolute"
            data-bs-auto-close="outside">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0">{{ __('panel.notifications') }}</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="small">{{ __('panel.settings') }}</a>
                    </div>
                </div>
            </div>


            <ul class="nav nav-tabs custom-nav-tabs justify-content-evenly" id="notificationTabs" role="tablist">
                <li class="nav-item border-top-0 py-0" style="flex: 1;display: flex;justify-content: center;"
                    role="presentation">
                    <button class="nav-link active w-100 pt-0 " id="instructor-tab" data-bs-toggle="tab"
                        data-bs-target="#instructor" type="button" role="tab" aria-controls="instructor"
                        aria-selected="true">{{ __('panel.instructor') }}</button>
                </li>
                <li class="nav-item border-top-0 py-0" style="flex:1;display: flex;justify-content: center;"
                    role="presentation">
                    <button class="nav-link w-100 pt-0" id="student-tab" data-bs-toggle="tab" data-bs-target="#student"
                        type="button" role="tab" aria-controls="student"
                        aria-selected="false">{{ __('panel.student') }}</button>
                </li>
            </ul>


            <div class="tab-content border tab-content-uniform-width" id="notificationTabsContent"
                style="max-height: 230px; overflow: auto">
                {{-- for instructor course status  --}}
                <div class="tab-pane fade show active" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                    @forelse ($unreadCoursesNotifications as $unreadNotification)
                        <a wire:click="markAsRead('{{ $unreadNotification->id }}')"
                            class="text-reset notification-item d-block p-2 {{ $loop->first ? '' : 'border-top' }}"
                            style="cursor: pointer">
                            <div class="d-flex">
                                <div class="avatar-lg me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="ri-shopping-cart-line"></i>
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">
                                            {{ __('panel.course') }} ( {{ $unreadNotification->data['course_title'] }})
                                            {{ __('panel.status_is') }}
                                            ({{ course_status($unreadNotification->data['last_transaction']) }})
                                        </p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                            {{ $unreadNotification->data['created_date'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-2">{{ __('panel.no_notification_found') }}</div>
                    @endforelse
                </div>

                {{-- for student order  --}}
                <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                    @forelse ($unreadOrdersNotifications as $unreadNotification)
                        <a wire:click="markAsRead('{{ $unreadNotification->id }}')"
                            class="text-reset notification-item d-block p-2 {{ $loop->first ? '' : 'border-top' }}"
                            style="cursor: pointer">
                            <div class="d-flex">
                                <div class="avatar-lg me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="ri-shopping-cart-line"></i>
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">
                                            {{ __('panel.order') }} #{{ $unreadNotification->data['order_ref'] }}
                                            {{ __('panel.status_is') }}
                                            ({{ order_status($unreadNotification->data['last_transaction']) }})
                                        </p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                            {{ $unreadNotification->data['created_date'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-2">{{ __('panel.no_notification_found') }}
                        </div>
                    @endforelse
                </div>
            </div>

            @if (count($unreadNotifications) > 3)
                <div class="p-2 border-top">
                    <div class="d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> {{ __('panel.view_more...') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </li>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownMenu = document.querySelector('[aria-labelledby="page-header-notifications-dropdown"]');
        dropdownMenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
</script>

<style>
    .custom-nav-tabs .nav-link {
        border: none;
        padding-bottom: 0.5rem;
        background-color: transparent;
        color: black !important;
    }

    .custom-nav-tabs .nav-link.active {
        border-bottom: 2px solid #007bff;
        /* Customize the border color */
        background-color: transparent;
    }

    .tab-content-uniform-width .tab-pane {
        width: 100%;
        /* Ensure all tab panes have the same width */
    }

    .dropdown-menu-md .tab-content-uniform-width {
        border-top: none;
        /* Remove top border from the tab content container */
    }
</style>
