<div>
    <!-- BLOG LIST V1 -->
    <div class="container mb-11">


        <div class="row">
            <div class="col-md-7 col-lg-8 col-xl-9 mb-5 mb-md-0">
                <!-- Blog Post -->
                @foreach ($posts as $post)
                    <div class="row mb-6 align-items-center">
                        <div class="col-lg-6 col-xl-5 mb-6 mb-lg-0">
                            <a href="{{ route('frontend.blog_single', $post->slug) }}"
                                class="d-block sk-thumbnail img-ratio-4 rounded lift">
                                @php
                                    if ($post->photos->first() != null && $post->photos->first()->file_name != null) {
                                        $post_img = asset('assets/posts/' . $post->photos->first()->file_name);

                                        if (
                                            !file_exists(
                                                public_path('assets/posts/' . $post->photos->first()->file_name),
                                            )
                                        ) {
                                            $post_img = asset('image/not_found/item_image_not_found.webp');
                                        }
                                    } else {
                                        $post_img = asset('image/not_found/item_image_not_found.webp');
                                    }
                                @endphp
                                <img src="{{ $post_img }}" alt="{{ $post->title }}" class="rounded img-fluid">
                            </a>
                        </div>

                        <div class="col-lg-6 col-xl-7">
                            <a href="{{ route('frontend.blog_list', $post->courseCategory->slug) }}"
                                class="d-inline-block">
                                <h5 class="text-blue">{{ $post->courseCategory->title }}</h5>
                            </a>

                            <a href="{{ route('frontend.blog_single', $post->slug) }}" class="d-block me-xl-12">
                                <h3 class="">
                                    {{ $post->title }}
                                </h3>
                            </a>

                            <p class="line-clamp-3 mb-6 mb-xl-8 me-xl-6">
                                {{ $post->description }}
                            </p>


                            <div class="d-md-flex align-items-center">
                                <div class="border rounded-circle d-inline-block mb-4 mb-md-0 me-4">
                                    <div class="p-1">
                                        @php
                                            if ($post->users->first()->user_image != null) {
                                                $user_img = asset('assets/users/' . $post->users->first()->user_image);

                                                if (
                                                    !file_exists(
                                                        public_path(
                                                            'assets/users/' . $post->users->first()->user_image,
                                                        ),
                                                    )
                                                ) {
                                                    $user_img = asset('image/not_found/avator1.webp');
                                                }
                                            } else {
                                                $user_img = asset('image/not_found/avator1.webp');
                                            }
                                        @endphp
                                        <img src="{{ $user_img }}" alt="{{ $post->users->first()->first_name }}"
                                            class="rounded-circle" width="52" height="52">
                                    </div>
                                </div>

                                <div class="mb-4 mb-md-0">
                                    <a href="{{ route('frontend.blog_single', $post->slug) }}" class="d-block">
                                        <h6 class="mb-0">{{ $post->users->first()->full_name }}</h6>
                                    </a>
                                    <span
                                        class="font-size-sm">{{ $post->created_at ? \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F Y') : null }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- PAGINATION -->
                <nav class="mb-11" aria-label="Page navigationa">
                    <ul class="pagination justify-content-center">
                        {!! $posts->appends(request()->all())->onEachSide(3)->links() !!}
                    </ul>
                </nav>

            </div>



            <div class="col-md-5 col-lg-4 col-xl-3">
                <!-- BLOG SIDEBAR -->
                <div class="">
                    <div class="border rounded mb-6">
                        <div class="input-group">
                            <input wire:model="searchQuery" class="form-control form-control-sm border-0 pe-0"
                                type="search" placeholder="{{ __('transf.search') }}" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sm my-2 my-sm-0 text-secondary icon-uxs" type="submit">
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
                    </div>

                    <div class="border rounded mb-6 p-5 py-md-6 ps-md-6 pe-md-4">
                        <h4 class="mb-5">{{ __('transf.categories') }}</h4>
                        <div class="nav flex-column nav-vertical">
                            <a href="{{ route('frontend.blog_list') }}" class="nav-link py-2">
                                {{ __('transf.all') }}
                                ({{ $total_Posts }})
                            </a>
                            @foreach ($categories_menu as $item)
                                <a href="{{ route('frontend.blog_list', $item->slug) }}"
                                    class="nav-link py-2">{{ $item->title }}
                                    ({{ $item->posts_count }})
                                </a>
                            @endforeach

                        </div>
                    </div>

                    <div class="border rounded mb-6 p-5 py-md-6 ps-md-6 pe-md-4">
                        <h4 class="mb-5">{{ __('transf.recent_posts') }}</h4>
                        <ul class="list-unstyled mb-0 recent-posts">
                            @foreach ($recent_posts as $recent_post)
                                <li class="media mb-6 d-flex">
                                    <a href="{{ route('frontend.blog_single', $recent_post->slug) }}"
                                        class="mw-70p d-block me-sm-8 me-md-4">
                                        @php
                                            if (
                                                $recent_post->photos->first() != null &&
                                                $recent_post->photos->first()->file_name != null
                                            ) {
                                                $recent_post_img = asset(
                                                    'assets/posts/' . $recent_post->photos->first()->file_name,
                                                );

                                                if (
                                                    !file_exists(
                                                        public_path(
                                                            'assets/posts/' . $recent_post->photos->first()->file_name,
                                                        ),
                                                    )
                                                ) {
                                                    $recent_post_img = asset(
                                                        'image/not_found/item_image_not_found.webp',
                                                    );
                                                }
                                            } else {
                                                $recent_post_img = asset('image/not_found/item_image_not_found.webp');
                                            }
                                        @endphp
                                        <img src="{{ $recent_post_img }}" alt="..."
                                            class="avatar-img rounded-lg h-70p o-f-c">
                                    </a>
                                    <div class="media-body flex-shrink-1">
                                        <a href="{{ route('frontend.blog_single', $recent_post->slug) }}"
                                            class="d-block">
                                            <h6 class="line-clamp-2 mb-1 fw-normal">
                                                {{ $recent_post->title }}
                                            </h6>
                                        </a>
                                        <span>{{ $recent_post->created_at ? \Carbon\Carbon::parse($recent_post->created_at)->translatedFormat('d F Y') : null }}</span>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>

                    <div class="border rounded mb-6 p-5 py-md-6 ps-md-6 pe-md-4">
                        <h4 class="mb-5">{{ __('transf.tags') }}</h4>
                        @foreach ($tags as $tag)
                            <a href="{{ route('frontend.blog_tag_list', $tag->slug) }}"
                                class="btn btn-sm btn-light text-gray-800 px-5 fw-normal me-1 mb-2">
                                {{ $tag->name }}
                            </a>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
