<?php

use App\Models\Currency;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

function getParentShowOf($param)
{
    $route = str_replace('admin.', '', $param); // احذف كلمة admin. واستبدل بدالها بالفراغ من الراوت المرسل كبرامتر 
    $permission = collect(Cache::get('admin_side_menu')->pluck('children')->flatten())->where('as', $route)->flatten()->first();
    return $permission ? $permission['parent_show'] : null;
}

function getParentOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = collect(Cache::get('admin_side_menu')->pluck('children')->flatten())->where('as', $route)->flatten()->first();
    return $permission ? $permission['parent'] : null;
}

function getParentIdOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = collect(Cache::get('admin_side_menu')->pluck('children')->flatten())->where('as', $route)->flatten()->first();
    return $permission ? $permission['id'] : null;
}


function currency_load()
{
    if (session()->has('system_default_currency_info') == false) {
        session()->put('system_default_currency_info', Currency::find(1));
    }
}

function currency_converter($amount)
{
    // return convert_price($amount);

    return format_price(convert_price($amount));
}


function convert_price($price)
{
    currency_load();

    $system_default_currency_info = session('system_default_currency_info');

    $price = floatval($price) / floatval($system_default_currency_info->exchange_rate);

    if (Session()->has('currency_exchange_rate')) {
        $exchange = session('currency_exchange_rate');
    } else {
        $exchange = $system_default_currency_info->exchange_rate;
    }

    $price = floatval($price)  * floatval($exchange);

    return $price;
}


//currency symbol 
function currency_symbol()
{
    currency_load();
    if (session()->has('currency_symbol')) {
        $symbol = session('currency_symbol');
    } else {
        $system_default_currency_info = session('system_default_currency_info');
        $symbol = $system_default_currency_info->currency_symbol;
    }

    return $symbol;
}


//format price 
function format_price($price)
{
    // return currency_symbol() . " " . number_format($price, 2);
    return  number_format($price, 2) . " " . currency_symbol();
}

// scale number to percentage 
function scaleToPercentage($number, $maxInput)
{
    return round((($number / $maxInput) * 100), 2);
}
