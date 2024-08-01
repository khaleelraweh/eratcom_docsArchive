<?php

use App\Http\Controllers\Backend\AdvertisorSliderController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CallActionsController;
use App\Http\Controllers\Backend\CardCategoriesController;
use App\Http\Controllers\Backend\CardCodeController;
use App\Http\Controllers\Backend\CardController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CommonQuestionController;
use App\Http\Controllers\Backend\CompanyMenuController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CourseCategoriesController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\CourseReviewController;
use App\Http\Controllers\Backend\CurrenciesController;
use App\Http\Controllers\Backend\CustomerAddressController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DocumentArchivesController;
use App\Http\Controllers\Backend\DocumentCategoriescontroller;
use App\Http\Controllers\Backend\DocumentTemplatesController;
use App\Http\Controllers\Backend\DocumentTypesController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\instructorsController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\MainSliderController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PaymentCategoriesController;
use App\Http\Controllers\Backend\PaymentMethodController;
use App\Http\Controllers\Backend\PaymentMethodOfflineController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\ProductCategoriesController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\ReviewsController;
use App\Http\Controllers\Backend\ShippingCompanyController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\SpecializationController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\SupportMenuController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TopicsMenuController;
use App\Http\Controllers\Backend\TracksMenuController;
use App\Http\Controllers\Backend\WebMenuController;
use App\Http\Controllers\Backend\WebMenuHelpController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CustomerController as FrontendCustomerController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Frontend\InstructorController as FrontendInstructorController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Models\News;
use Illuminate\Support\Facades\auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

// لايقاف الديباجر نضيف هذا الكود
app('debugbar')->disable();

// ######################################################### //
// ###################   Frontend Route   ################## //
// ######################################################### //


//Frontend 
Route::get('/',         [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/index',    [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/cart',     [FrontendController::class, 'cart'])->name('frontend.cart');
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('frontend.checkout');
Route::get('/detail',   [FrontendController::class, 'detail'])->name('frontend.detail');
Route::get('/shop',     [FrontendController::class, 'shop'])->name('frontend.shop');



Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/index', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/home', [FrontendController::class, 'home'])->name('frontend.home');

Route::get('/courses-list/{slug?}', [FrontendController::class, 'courses_list'])->name('frontend.courses');
Route::get('/course-single/{course?}', [FrontendController::class, 'course_single'])->name('frontend.course_single');

Route::get('/instructors-list/{instructor?}', [FrontendController::class, 'instructors_list'])->name('frontend.instructors_list');
Route::get('/instructors-single/{instructor?}', [FrontendController::class, 'instructors_single'])->name('frontend.instructors_single');

Route::get('/event-list/{event?}', [FrontendController::class, 'event_list'])->name('frontend.event_list');
Route::get('/event-single/{event?}', [FrontendController::class, 'event_single'])->name('frontend.event_single');

Route::get('/blog-list/{blog?}', [FrontendController::class, 'blog_list'])->name('frontend.blog_list');
Route::get('/blog-tag-list/{slug?}', [FrontendController::class, 'blog_tag_list'])->name('frontend.blog_tag_list');
Route::get('/blog-single/{blog?}', [FrontendController::class, 'blog_single'])->name('frontend.blog_single');

Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/contact-us', [FrontendController::class, 'contact_us'])->name('frontend.contact_us');

Route::get('/terms-of-service', [FrontendController::class, 'service'])->name('frontend.service');

Route::get('/cart', [FrontendController::class, 'cart'])->name('frontend.cart');
Route::get('/wishlist', [FrontendController::class, 'wishlist'])->name('frontend.wishlist');
Route::get('/shop-cart', [FrontendController::class, 'shop_cart'])->name('frontend.shop_cart');

Route::post('currency_load', [CurrenciesController::class, 'currencyLoad'])->name('currency.load');

Route::get('change_currency/{currency_code?}', [CurrenciesController::class, 'currencyLoad'])->name('change.currency');

Route::get('/change-language/{locale}',     [LocaleController::class, 'switch'])->name('change.language');


// Route::get('/pages/{slug?}', [FrontendController::class, 'pages'])->name('frontend.pages');
Route::get('/pages/{slug}', [FrontendController::class, 'pages'])->name('frontend.pages');




// ######################################################### //
// ###############   Customer Authed Route   ############### //
// ######################################################### //
Route::group(['middleware' => ['roles', 'role:customer|supervisor', 'verified']], function () {

    // ==============  Customer Profile Setting   ==============  //
    Route::get('/dashboard', [FrontendCustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/profile', [FrontendCustomerController::class, 'profile'])->name('customer.profile');
    Route::patch('/profile/update', [FrontendCustomerController::class, 'update_profile'])->name('customer.update_profile');
    Route::get('/profile/remove-image', [FrontendCustomerController::class, 'remove_profile_image'])->name('customer.remove_profile_image');


    // ==============  Customer Address Setting   ==============  //
    Route::get('/addresses', [FrontendCustomerController::class, 'addresses'])->name('customer.addresses');


    // ==============  Customer Orders Setting   ==============  //
    Route::get('/orders', [FrontendCustomerController::class, 'orders'])->name('customer.orders');

    // ==============  Customer Teach on jats   ==============  //
    Route::get('/Teach-on-jats', [FrontendCustomerController::class, 'Teach_on_jats'])->name('customer.teach_on_jats');


    // ==============  Customer Bought Courses and Lessons ======  //
    Route::get('/student-courses-list/{slug?}', [FrontendCustomerController::class, 'student_courses_list'])->name('customer.courses');
    Route::get('/lesson-single/{course?}', [FrontendCustomerController::class, 'lesson_single'])->name('customer.lesson_single');


    // ##############  Customer Checkout  Routes   ############# //
    Route::group(['middleware' => 'check_cart'], function () {

        // ==============  Customer checkout Page  ==============  //
        Route::get('/shop-checkout', [FrontendController::class, 'shop_checkout'])->name('frontend.shop_checkout');


        // ==============  Customer Completed Page  ==============  //
        Route::get('/shop-order-completed', [FrontendController::class, 'shop_order_completed'])->name('frontend.shop_order_completed');


        // ==============  Customer Paypal Pay Routes  ==============  //
        // Route::get('/checkout', [PaymentController::class, 'checkout'])->name('frontend.checkout');
        Route::post('/checkout/payment', [PaymentController::class, 'checkout_now'])->name('checkout.payment');
        Route::get('/checkout/{order_id}/cancelled', [PaymentController::class, 'cancelled'])->name('checkout.cancel');
        Route::get('/checkout/{order_id}/completed', [PaymentController::class, 'completed'])->name('checkout.complete');
        Route::get('/checkout/webhook/{order?}/{env?}', [PaymentController::class, 'webhook'])->name('checkout.webhook.ipn');


        // ==============  Customer PayTabs Pay Routes  ==============  //
        Route::get('/checkout/{order_id}/completed_by_paytabs', [PaymentController::class, 'completed_paytabs'])->name('checkout.complete_by_paytabs');
    });
});



// ######################################################### //
// ###################   Backend Routes   ################## //
// ######################################################### //
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // #################   Guest Access Pages   ################ //
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/', [BackendController::class, 'login'])->name('login');
        Route::get('/login', [BackendController::class, 'login'])->name('login');
        Route::get('/register', [BackendController::class, 'register'])->name('register');
        Route::get('/lock-screen', [BackendController::class, 'lock_screen'])->name('lock-screen');
        Route::get('/recover-password', [BackendController::class, 'recover_password'])->name('recover-password');
    });

    // ==============   Theme Icon To Style Website Ready ==============  //
    Route::post('/cookie/create/update', [BackendController::class, 'create_update_theme'])->name('create_update_theme');


    // ###############    Authenticated Routes    ############### //
    Route::group(['middleware' => ['roles', 'role:admin|supervisor']], function () {

        // ==============   Admin Index Access   ==============  //
        // Route::get('/', [BackendController::class, 'index'])->name('index2');
        Route::get('/index', [BackendController::class, 'index'])->name('index');


        // ==============   Admin Acount Tab   ==============  //
        Route::get('account_settings', [BackendController::class, 'account_settings'])->name('account_settings');
        Route::post('admin/remove-image', [BackendController::class, 'remove_image'])->name('remove_image');
        Route::patch('account_settings', [BackendController::class, 'update_account_settings'])->name('update_account_settings');


        Route::get('profile', [BackendController::class, 'profile'])->name('profile');
        Route::patch('update-profile', [BackendController::class, 'update_profile'])->name('update_profile');

        Route::get('edit-profile', [BackendController::class, 'edit_profile'])->name('edit_profile');
        Route::patch('update-edit-profile', [BackendController::class, 'update_edit_profile'])->name('update_edit_profile');



        // ==============   Menus Tab   ==============  //
        Route::resource('web_menus', WebMenuController::class);
        Route::resource('company_menus', CompanyMenuController::class);
        Route::resource('topics_menus', TopicsMenuController::class);
        Route::resource('tracks_menus', TracksMenuController::class);
        Route::resource('support_menus', SupportMenuController::class);

        // ==============   Pages Tab   ==============  //
        Route::resource('pages', PagesController::class);


        // ==============   Sliders Tab   ==============  //
        Route::post('main_sliders/remove-image', [MainSliderController::class, 'remove_image'])->name('main_sliders.remove_image');
        Route::resource('main_sliders', MainSliderController::class);

        Route::post('advertisor_sliders/remove-image', [AdvertisorSliderController::class, 'remove_image'])->name('advertisor_sliders.remove_image');
        Route::resource('advertisor_sliders', AdvertisorSliderController::class);


        // ==============   Document  Tab   ==============  //
        Route::resource('document_categories', DocumentCategoriescontroller::class);
        Route::resource('document_types', DocumentTypesController::class);
        Route::resource('document_templates', DocumentTemplatesController::class);

        Route::resource('document_archives', DocumentArchivesController::class);



        // ==============   Courses Tab   ==============  //
        Route::post('course_categories/remove-image', [CourseCategoriesController::class, 'remove_image'])->name('course_categories.remove_image');
        Route::resource('course_categories', CourseCategoriesController::class);

        Route::post('courses/remove-image', [CourseController::class, 'remove_image'])->name('courses.remove_image');
        Route::resource('courses', CourseController::class);

        Route::match(['put', 'patch'], 'admin/courses/{course}/status', [CourseController::class, 'updateStatus'])
            ->name('courses.update_course_status');

        Route::post('events/remove-image', [EventController::class, 'remove_image'])->name('events.remove_image');
        Route::resource('events', EventController::class);

        // ==============   Call Actions Tab   ==============  //
        Route::post('call_actions/remove-image', [CallActionsController::class, 'remove_image'])->name('call_actions.remove_image');
        Route::resource('call_actions', CallActionsController::class);


        // ==============   Users Tab   ==============  //
        Route::post('customers/remove-image', [CustomerController::class, 'remove_image'])->name('customers.remove_image');
        Route::get('customers/get_customers', [CustomerController::class, 'get_customers'])->name('customers.get_customers');
        Route::resource('customers', CustomerController::class);

        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::resource('supervisors', SupervisorController::class);

        Route::post('instructor/remove-image', [InstructorController::class, 'remove_image'])->name('instructors.remove_image');
        Route::resource('instructors', InstructorController::class);

        Route::resource('specializations', SpecializationController::class);

        Route::resource('customer_addresses', CustomerAddressController::class);


        // ==============   Reviews Tab   ==============  //
        Route::resource('reviews', ReviewsController::class);


        // ==============   Tags Tab   ==============  //
        Route::resource('tags', TagController::class);


        // ==============   Coupons Tab   ==============  //
        Route::resource('coupons', CouponController::class);


        // ==============   Countries Tab   ==============  //
        Route::resource('countries', CountryController::class);

        Route::get('states/get_states', [StateController::class, 'get_states'])->name('states.get_states');
        Route::resource('states', StateController::class);

        Route::get('cities/get_cities', [CityController::class, 'get_cities'])->name('cities.get_cities');
        Route::resource('cities', CityController::class);


        // ==============   Orders Tab   ==============  //
        Route::resource('orders', OrderController::class);


        // ==============   Blog/Posts Tab   ==============  //
        Route::post('posts/remove-image', [PostController::class, 'remove_image'])->name('posts.remove_image');
        Route::resource('posts', PostController::class);

        // ==============   Site Setting  Tab   ==============  //
        Route::get('site_setting/site_infos', [SiteSettingsController::class, 'show_main_informations'])->name('settings.site_main_infos.show');
        Route::post('site_setting/update_site_info/{id?}', [SiteSettingsController::class, 'update_main_informations'])->name('settings.site_main_infos.update');
        Route::post('site_setting/site_infos/remove-image', [SiteSettingsController::class, 'remove_image'])->name('site_infos.remove_image');

        Route::get('site_setting/site_contacts', [SiteSettingsController::class, 'show_contact_informations'])->name('settings.site_contacts.show');
        Route::post('site_setting/update_site_contact/{id?}', [SiteSettingsController::class, 'update_contact_informations'])->name('settings.site_contacts.update');

        Route::get('site_setting/site_socials', [SiteSettingsController::class, 'show_socail_informations'])->name('settings.site_socials.show');
        Route::post('site_setting/update_site_social/{id?}', [SiteSettingsController::class, 'update_social_informations'])->name('settings.site_socials.update');

        Route::get('site_setting/site_metas', [SiteSettingsController::class, 'show_meta_informations'])->name('settings.site_meta.show');
        Route::post('site_setting/update_site_meta/{id?}', [SiteSettingsController::class, 'update_meta_informations'])->name('settings.site_meta.update');

        Route::get('site_setting/site_payment_methods', [SiteSettingsController::class, 'show_payment_method_informations'])->name('settings.site_payment_methods.show');
        Route::post('site_setting/update_site_payment_method/{id?}', [SiteSettingsController::class, 'update_payment_method_informations'])->name('settings.site_payment_methods.update');

        Route::get('site_setting/site_counters', [SiteSettingsController::class, 'show_site_counter_informations'])->name('settings.site_counters.show');
        Route::post('site_setting/update_site_counter/{id?}', [SiteSettingsController::class, 'update_site_counter_informations'])->name('settings.site_counters.update');

        Route::resource('currencies', CurrenciesController::class);
        Route::post('update-currency-status', [CurrenciesController::class, 'updateCurrencyStatus'])->name('currencies.update_currency_status');



        // ######################################################### //
        // ###################    Working on      ################## //

        Route::resource('shipping_companies', ShippingCompanyController::class);

        Route::post('payment_categories/remove-image', [PaymentCategoriesController::class, 'remove_image'])->name('payment_categories.remove_image');
        Route::resource('payment_categories', PaymentCategoriesController::class);

        Route::post('payment_methods/remove-image', [PaymentMethodController::class, 'remove_image'])->name('payment_methods.remove_image');
        Route::resource('payment_methods', PaymentMethodController::class);

        Route::post('payment_method_offlines/remove-image', [PaymentMethodOfflineController::class, 'remove_image'])->name('payment_method_offlines.remove_image');
        Route::resource('payment_method_offlines', PaymentMethodOfflineController::class);


        // Route::group(['middleware' => 'web'], function (){
        // });
    });
});
