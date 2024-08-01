<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CurrenciesController;
use App\Http\Controllers\Backend\CustomerAddressController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DocumentArchivesController;
use App\Http\Controllers\Backend\DocumentCategoriescontroller;
use App\Http\Controllers\Backend\DocumentTemplatesController;
use App\Http\Controllers\Backend\DocumentTypesController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\SupervisorController;
use Illuminate\Support\Facades\auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

// لايقاف الديباجر نضيف هذا الكود
app('debugbar')->disable();

// ######################################################### //
// ###################   Frontend Route   ################## //
// ######################################################### //


Route::get('/', function () {
    if (!auth()->check()) {
        return view('backend.admin-login');
    } else {
        return view('backend.index');
    }
});

Route::get('/index', function () {
    if (!auth()->check()) {
        return view('backend.admin-login');
    } else {
        return view('backend.index');
    }
});

Route::post('currency_load', [CurrenciesController::class, 'currencyLoad'])->name('currency.load');
Route::get('change_currency/{currency_code?}', [CurrenciesController::class, 'currencyLoad'])->name('change.currency');
Route::get('/change-language/{locale}',     [LocaleController::class, 'switch'])->name('change.language');


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
        Route::get('/index', [BackendController::class, 'index'])->name('index');

        // ==============   Admin Acount Tab   ==============  //
        Route::get('account_settings', [BackendController::class, 'account_settings'])->name('account_settings');
        Route::post('admin/remove-image', [BackendController::class, 'remove_image'])->name('remove_image');
        Route::patch('account_settings', [BackendController::class, 'update_account_settings'])->name('update_account_settings');

        Route::get('profile', [BackendController::class, 'profile'])->name('profile');
        Route::patch('update-profile', [BackendController::class, 'update_profile'])->name('update_profile');

        Route::get('edit-profile', [BackendController::class, 'edit_profile'])->name('edit_profile');
        Route::patch('update-edit-profile', [BackendController::class, 'update_edit_profile'])->name('update_edit_profile');


        // ==============   Document  Tab   ==============  //
        Route::resource('document_categories', DocumentCategoriescontroller::class);
        Route::resource('document_types', DocumentTypesController::class);
        Route::resource('document_templates', DocumentTemplatesController::class);
        Route::resource('document_archives', DocumentArchivesController::class);



        // ==============   Users Tab   ==============  //
        Route::post('customers/remove-image', [CustomerController::class, 'remove_image'])->name('customers.remove_image');
        Route::get('customers/get_customers', [CustomerController::class, 'get_customers'])->name('customers.get_customers');
        Route::resource('customers', CustomerController::class);

        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::resource('supervisors', SupervisorController::class);

        Route::resource('customer_addresses', CustomerAddressController::class);


        // ==============   Countries Tab   ==============  //
        Route::resource('countries', CountryController::class);

        Route::get('states/get_states', [StateController::class, 'get_states'])->name('states.get_states');
        Route::resource('states', StateController::class);

        Route::get('cities/get_cities', [CityController::class, 'get_cities'])->name('cities.get_cities');
        Route::resource('cities', CityController::class);

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
    });
});
