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
