<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\SiteSetting;
use App\Models\WebMenu;
use App\Services\CustomValidationRules;
use Carbon\Carbon;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Schema;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // make validation rule called min_words
        Validator::extend('min_words', [CustomValidationRules::class, 'minWords']);

        // Check if the 'site_settings' table exists
        if (Schema::hasTable('site_settings')) {
            // Site setting calling to cache in 5 hours refresh
            $siteSettings = Cache()->remember(
                'siteSettings',
                3600,
                fn () => SiteSetting::all()->keyBy('key')
            );
            View::share('siteSettings', $siteSettings);
        }

        // Check if the 'web_menus' table exists
        if (Schema::hasTable('web_menus')) {
            // web_menus in all pages 
            $web_menus = WebMenu::tree();
            View::share('web_menus', $web_menus);
        }

        // Check if the 'currencies' table exists
        if (Schema::hasTable('currencies')) {
            // Start check currency 
            currency_load();

            if (Session::has("system_default_currency_info")) {
                $currency_code = Session::get('system_default_currency_info')->currency_code;

                if (!Session::has('currency_symbol')) {
                    $currency = Currency::where('currency_code', $currency_code)->first();

                    if ($currency) {
                        Session::put('currency_code', $currency->currency_code);
                        Session::put('currency_symbol', $currency->currency_symbol);
                        Session::put('currency_name', $currency->currency_name);
                        Session::put('currency_exchange_rate', $currency->exchange_rate);
                    }
                }
            }
            // End check currency 
        }

        // Start check Locale language 
        $locale = config('locales.fallback_locale');
        App::setLocale($locale);
        Lang::setLocale($locale);
        Session::put('locale', $locale);
        Carbon::setLocale($locale);

        // End check locale language 

        Paginator::useBootstrap();
    }
}
