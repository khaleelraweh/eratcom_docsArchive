<div>
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-notification-3-line"></i>
        {{-- <span class="noti-dot"></span> --}}
        <span class="noti-dot" style="width: 12px;height:12px;font-size:10px;">{{ $unreadNotificationsCount }}</span>
    </button>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> {{ __('panel.notifications') }}</h6>
                </div>
                <div class="col-auto">
                    <a href="#!" class="small"> {{ __('panel.settings') }}</a>
                </div>
            </div>
        </div>

        <div data-simplebar style="max-height: 230px;">
            @forelse ($unreadNotifications as $unreadNotification)
                <a wire:click="markAsRead('{{ $unreadNotification->id }}')" class="text-reset notification-item"
                    style="cursor: pointer">
                    <div class="d-flex">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                <i class="ri-shopping-cart-line"></i>
                            </span>
                        </div>
                        @if (isset($unreadNotification->data['order_id']))
                            <div class="flex-1">
                                <h6 class="mb-1">{{ __('panel.from_customer') }}
                                    {{ $unreadNotification->data['customer_name'] }}</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1">{{ __('panel.a_new_order_with_amount') }}
                                        ({{ currency_converter($unreadNotification->data['amount']) }})
                                        {{ __('panel.from_customer') }}
                                        ({{ $unreadNotification->data['customer_name'] }})
                                    </p>
                                    {{-- <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p> --}}
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                        {{ $unreadNotification->data['created_date'] }}</p>
                                </div>
                            </div>
                        @else
                            {{-- with instructors notifications  --}}
                            @if (isset($unreadNotification->data['course_id']))
                                <div class="flex-1">
                                    <h6 class="mb-1">{{ __('panel.from_instructor') }}
                                        {{-- {{ $unreadNotification->data['customer_name'] }}</h6> --}}
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">
                                                {{ __('panel.a_new_course_with_title') }}
                                                ( {{ $unreadNotification->data['course_title'] }})
                                                {{ __('panel.need_to_be_review_for_publish') }}
                                            </p>
                                            {{-- <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p> --}}
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                {{ $unreadNotification->data['created_date'] }}</p>
                                        </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </a>
            @empty
                <div class="dropdown-item text-center">{{ __('panel.no_notification_found') }}</div>
            @endforelse



        </div>

        <div class="p-2 border-top">
            <div class="d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> {{ __('panel.view_more...') }}
                </a>
            </div>
        </div>
    </div>

</div>
