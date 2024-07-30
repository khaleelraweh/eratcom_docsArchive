<div>


    <div class="container mb-6 mb-xl-8 z-index-2">
        <div class="d-xl-flex align-items-center">
            <p class="mb-xl-0">{{ __('transf.txt_we_found') }} <span class="text-dark">{{ count($events) }}
                    {{ __('transf.events') }}</span>
                {{ __('transf.txt_available_for_you') }}
            </p>
            <div class="ms-xl-auto d-md-flex flex-wrap">

                <div class="mb-4 mb-lg-0 me-2">
                    <!-- Search -->
                    <form class="">
                        <div class="input-group input-group-filter">
                            <input wire:model="searchQuery"
                                class="form-control form-control-sm placeholder-dark border-end-0 shadow-none"
                                type="search" placeholder="{{ __('transf.search') }}" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-outline-white border-start-0 bg-transparent text-dark"
                                    type="submit">
                                    <!-- Icon -->
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z"
                                            fill="currentColor" />
                                        <path
                                            d="M19.762 18.6121L15.1007 13.9509C14.7831 13.6332 14.2687 13.6332 13.9511 13.9509C13.6335 14.2682 13.6335 14.7831 13.9511 15.1005L18.6124 19.7617C18.7712 19.9205 18.9791 19.9999 19.1872 19.9999C19.395 19.9999 19.6032 19.9205 19.762 19.7617C20.0796 19.4444 20.0796 18.9295 19.762 18.6121Z"
                                            fill="currentColor" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mb-4 mb-lg-0 me-2">
                    <div class="border rounded d-flex align-items-center choices-label h-50p">
                        <span class="ps-5">{{ __('transf.type') }}:</span>
                        <select wire:model="categoryInputs"
                            class="form-select form-select-sm ps-5 text-primary shadow fw-medium">
                            <option value="">{{ __('transf.chose_categories') }}</option>
                            @foreach ($categories_menu as $category_item)
                                <option value="{{ $category_item->id }}">{{ $category_item->title }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="mb-4 mb-lg-0">
                    <div wire:ignore class="border rounded d-flex align-items-center choices-label h-50p">
                        <span class="ps-5">{{ __('transf.by') }}:</span>
                        <select wire:ignore wire:model="sortingBy"
                            class="form-select form-select-sm ps-5 text-primary shadow fw-medium">
                            <option value="default">{{ __('transf.sort_default') }}</option>
                            <option value="new-events">{{ __('transf.sort_new_events') }}</option>
                            <option value="new-old">{{ __('transf.sort_time_new_to_old') }}</option>
                            <option value="old-new">{{ __('transf.sort_time_old_to_new') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>





    {{-- {{ dd($events) }} --}}
    <!-- EVENT -->
    <div class="container pb-4 pb-xl-7">
        <div class="row row-cols-md-2 row-cols-lg-3 mb-4">

            @foreach ($events->take($amount) as $event)
                <div class="col-md mb-6">
                    <!-- Card -->
                    <div class="card border shadow p-2 lift sk-fade">
                        <!-- Image -->
                        @php
                            if ($event->photos->first() != null && $event->photos->first()->file_name != null) {
                                $event_img = asset('assets/events/' . $event->photos->first()->file_name);

                                if (!file_exists(public_path('assets/events/' . $event->photos->first()->file_name))) {
                                    $event_img = asset('image/not_found/item_image_not_found.webp');
                                }
                            } else {
                                $event_img = asset('image/not_found/item_image_not_found.webp');
                            }
                        @endphp
                        <div class="card-zoom position-relative">
                            <a href="{{ route('frontend.event_single', $event->slug) }}"
                                class="card-img d-block sk-thumbnail img-ratio-3 card-hover-overlay">
                                <img class="rounded shadow-light-lg img-fluid" src="{{ $event_img }}"
                                    alt="...">
                            </a>
                            <a href="{{ route('frontend.event_single', $event->slug) }}"
                                class="text-underline text-white card-text-overlay position-absolute h5 mb-0 center">
                                {{ __('transf.get_ticket') }}
                            </a>
                            <a href="{{ route('frontend.event_single', $event->slug) }}"
                                class="badge sk-fade-bottom badge-lg badge-orange badge-pill badge-float bottom-0 left-0 mb-4 ms-4 px-5 me-4">
                                <span
                                    class="text-white fw-normal font-size-sm">{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') : null }}</span>
                            </a>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer px-2 pb-2 pt-4">
                            <!-- Heading -->
                            <a href="{{ route('frontend.event_single', $event->slug) }}" class="d-block">
                                <h5 class="line-clamp-2 h-48 h-lg-52 mb-2">
                                    {{ $event->title }}
                                </h5>
                            </a>

                            <ul class="nav mx-n3 d-block d-md-flex">
                                <li class="nav-item px-3 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 d-flex text-secondary icon-uxs">
                                            <!-- Icon -->
                                            <svg width="16" height="16" viewBox="0 0 16 16"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.3164 4.20996C13.985 4.37028 13.8464 4.76904 14.0067 5.10026C14.4447 6.00505 14.6667 6.98031 14.6667 8C14.6667 11.6759 11.6759 14.6667 8 14.6667C4.32406 14.6667 1.33333 11.6759 1.33333 8C1.33333 4.32406 4.32406 1.33333 8 1.33333C9.52328 1.33333 10.9543 1.83073 12.1387 2.77165C12.4259 3.00098 12.846 2.95296 13.0754 2.66471C13.3047 2.37663 13.2567 1.95703 12.9683 1.72803C11.5661 0.613607 9.8016 0 8 0C3.58903 0 0 3.58903 0 8C0 12.411 3.58903 16 8 16C12.411 16 16 12.411 16 8C16 6.77767 15.7331 5.60628 15.2067 4.51969C15.0467 4.18766 14.6466 4.04932 14.3164 4.20996Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M7.99967 2.66663C7.63167 2.66663 7.33301 2.96529 7.33301 3.33329V7.99996C7.33301 8.36796 7.63167 8.66663 7.99967 8.66663H11.333C11.701 8.66663 11.9997 8.36796 11.9997 7.99996C11.9997 7.63196 11.701 7.33329 11.333 7.33329H8.66634V3.33329C8.66634 2.96529 8.36768 2.66663 7.99967 2.66663Z"
                                                    fill="currentColor" />
                                            </svg>

                                        </div>
                                        <div class="font-size-sm">
                                            {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->translatedFormat('h:i A') : null }}
                                            -
                                            {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->translatedFormat('h:i A') : null }}
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item px-3 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 d-flex text-secondary icon-uxs">
                                            <!-- Icon -->
                                            <svg width="18" height="18" viewBox="0 0 18 18"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.9748 3.12964C13.6007 1.14086 11.4229 0 9.0002 0C6.57754 0 4.39972 1.14086 3.02557 3.12964C1.65816 5.10838 1.34243 7.61351 2.17929 9.82677C2.40313 10.4312 2.75894 11.0184 3.23433 11.5687L8.52105 17.7784C8.64062 17.919 8.8158 18 9.0002 18C9.18459 18 9.35978 17.919 9.47934 17.7784L14.7646 11.5703C15.2421 11.0169 15.5974 10.4303 15.8194 9.83078C16.658 7.61351 16.3422 5.10838 14.9748 3.12964ZM14.6408 9.38999C14.4697 9.85257 14.1902 10.3099 13.8107 10.7498C13.8096 10.7509 13.8086 10.7519 13.8077 10.7532L9.0002 16.3999L4.1897 10.7497C3.8104 10.3101 3.53094 9.85282 3.35808 9.38581C2.66599 7.55539 2.92864 5.48413 4.06088 3.84546C5.19668 2.20155 6.9971 1.25873 9.0002 1.25873C11.0033 1.25873 12.8035 2.20152 13.9393 3.84546C15.0718 5.48413 15.3346 7.55539 14.6408 9.38999Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M9.00019 3.73438C7.0569 3.73438 5.47571 5.31535 5.47571 7.25886C5.47571 9.20237 7.05668 10.7833 9.00019 10.7833C10.9437 10.7833 12.5247 9.20237 12.5247 7.25886C12.5247 5.31556 10.9435 3.73438 9.00019 3.73438ZM9.00019 9.52457C7.75088 9.52457 6.73444 8.50814 6.73444 7.25882C6.73444 6.00951 7.75088 4.99307 9.00019 4.99307C10.2495 4.99307 11.2659 6.00951 11.2659 7.25882C11.2659 8.50814 10.2495 9.52457 9.00019 9.52457Z"
                                                    fill="currentColor" />
                                            </svg>

                                        </div>
                                        <div class="font-size-sm">{{ $event->address }}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div id="loadcollapseExample" class="collapse row row-cols-md-2 row-cols-lg-3 mb-4">


        </div>

        <div class="text-center mb-9">
            <a class="btn btn-outline-primary mw-300p d-flex mx-auto read-more {{ $showMoreBtn ? 'collapsed' : null }}"
                data-bs-toggle="collapse" wire:click="{{ $showMoreBtn ? 'load_more' : 'load_less' }}" role="button"
                aria-expanded="{{ $showMoreBtn ? 'false' : 'true' }}" aria-controls="loadcollapseExample">
                <span class="d-inline-flex mx-auto align-items-center more">
                    <!-- Icon -->
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.76026 17.0396C5.16013 17.0396 4.65015 17.2495 4.23011 17.6695C3.81023 18.0899 3.60014 18.5998 3.60014 19.1999C3.60014 19.8001 3.81008 20.31 4.23011 20.7303C4.65031 21.1503 5.16029 21.3603 5.76026 21.3603C6.35031 21.3603 6.85772 21.1503 7.2828 20.7303C7.70772 20.3105 7.92018 19.8001 7.92018 19.1999C7.92018 18.5998 7.70777 18.0902 7.2828 17.6695C6.85766 17.2499 6.35031 17.0396 5.76026 17.0396Z"
                            fill="currentColor" />
                        <path
                            d="M5.28028 12.4799C5.28028 11.8199 5.04538 11.2551 4.57533 10.7847C4.10533 10.3147 3.54024 10.0797 2.88026 10.0797C2.22023 10.0797 1.65524 10.3147 1.18519 10.7847C0.715245 11.2547 0.480297 11.8197 0.480297 12.4799C0.480297 13.1398 0.715192 13.7045 1.18519 14.1746C1.65524 14.6448 2.22023 14.8798 2.88026 14.8798C3.54024 14.8798 4.10533 14.6448 4.57533 14.1746C5.04538 13.7048 5.28028 13.1398 5.28028 12.4799Z"
                            fill="currentColor" />
                        <path
                            d="M19.2 6.96016C19.5297 6.96016 19.8127 6.84247 20.0474 6.60758C20.2824 6.37248 20.4001 6.08988 20.4001 5.75994C20.4001 5.42985 20.2824 5.14746 20.0474 4.91251C19.8126 4.67741 19.5297 4.55994 19.2 4.55994C18.8699 4.55994 18.5873 4.67762 18.3523 4.91251C18.1174 5.14751 17.9999 5.42985 17.9999 5.75994C17.9999 6.09003 18.1174 6.37248 18.3523 6.60758C18.5873 6.84268 18.8699 6.96016 19.2 6.96016Z"
                            fill="currentColor" />
                        <path
                            d="M5.76041 3.12012C5.0303 3.12012 4.40784 3.37766 3.89281 3.89258C3.37773 4.4075 3.12035 5.03001 3.12035 5.75997C3.12035 6.49019 3.37773 7.11244 3.89281 7.62757C4.40799 8.14265 5.03046 8.40013 5.76041 8.40013C6.49037 8.40013 7.11288 8.14249 7.6278 7.62757C8.14272 7.11244 8.40026 6.49003 8.40026 5.75997C8.40026 5.03001 8.14272 4.4075 7.6278 3.89258C7.11288 3.37766 6.49037 3.12012 5.76041 3.12012Z"
                            fill="currentColor" />
                        <path
                            d="M23.0999 11.4597C22.82 11.1796 22.48 11.0398 22.0801 11.0398C21.6799 11.0398 21.3399 11.1796 21.06 11.4597C20.7802 11.7397 20.6404 12.0798 20.6404 12.48C20.6404 12.8798 20.7802 13.2204 21.06 13.4998C21.3401 13.7799 21.6799 13.9197 22.0801 13.9197C22.48 13.9197 22.8202 13.7799 23.0999 13.4998C23.38 13.22 23.5197 12.8798 23.5197 12.48C23.5197 12.08 23.3802 11.7399 23.0999 11.4597Z"
                            fill="currentColor" />
                        <path
                            d="M19.2 17.5198C18.7397 17.5198 18.3448 17.6846 18.0147 18.0147C17.6849 18.3445 17.5199 18.7396 17.5199 19.1999C17.5199 19.6598 17.6849 20.055 18.0147 20.3852C18.3448 20.7152 18.7398 20.8799 19.2 20.8799C19.6599 20.8799 20.0549 20.7149 20.385 20.3852C20.7151 20.0551 20.88 19.66 20.88 19.1999C20.88 18.7396 20.7151 18.3449 20.385 18.0147C20.055 17.6846 19.6599 17.5198 19.2 17.5198Z"
                            fill="currentColor" />
                        <path
                            d="M12.4801 20.1595C11.9501 20.1595 11.4976 20.3474 11.1223 20.7225C10.7475 21.0975 10.5599 21.5498 10.5599 22.0799C10.5599 22.6099 10.7473 23.0623 11.1223 23.4373C11.4976 23.8124 11.9499 24.0001 12.4801 24.0001C13.0102 24.0001 13.4625 23.8124 13.8376 23.4373C14.2126 23.0623 14.4001 22.6099 14.4001 22.0799C14.4001 21.5498 14.2126 21.0975 13.8376 20.7225C13.4625 20.3474 13.0102 20.1595 12.4801 20.1595Z"
                            fill="currentColor" />
                        <path
                            d="M12.4801 0C11.6802 0 10.9999 0.279867 10.4399 0.839864C9.87998 1.39991 9.60001 2.08006 9.60001 2.88C9.60001 3.67999 9.87988 4.35982 10.4399 4.91992C10.9999 5.47981 11.6801 5.75984 12.4801 5.75984C13.2804 5.75984 13.9602 5.47997 14.52 4.91992C15.0799 4.36008 15.3598 3.67999 15.3598 2.88C15.3598 2.08012 15.0799 1.40012 14.52 0.839864C13.9602 0.280025 13.2804 0 12.4801 0Z"
                            fill="currentColor" />
                    </svg>

                    <span class="ms-2">{{ __('transf.load_more') }}</span>
                </span>

                <span class="less mx-auto">
                    {{ __('transf.load_less') }}
                </span>
            </a>


        </div>
    </div>
</div>
