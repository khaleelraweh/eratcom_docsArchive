<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class Coupon extends Model
{
    use HasFactory, HasTranslations, SearchableTrait;

    protected $guarded = [];
    public $translatable = ['code', 'description'];


    protected $dates = ['start_date', 'expire_date'];

    protected $searchable = [
        'columns' => [

            'coupons.code' => 10,
            'coupons.description' => 10,
        ]
    ];


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    protected $casts = [
        'publish_start_date' => 'datetime',
        'publish_end_date' => 'datetime',
    ];

    public function status()
    {
        return $this->status ? __('panel.status_active') : __('panel.status_inactive');
    }



    public function discount($total)
    {
        // dd($total);

        if (!$this->checkDate() || !$this->checkUsedTimes()) {
            return 0;
        }

        // if total sent is greater than this->greater_than in the table : do process will return the value of discount as number
        return $this->checkGreaterThan($total) ? $this->doProcess($total) : 0;
    }

    protected function checkDate()
    {
        //if expire_date is not null
        // return cabon::now()->between(the value of time now   is between start_date and expire_date , if there is return of true ) then true else false
        return $this->expire_date != '' ? (Carbon::now()->between($this->start_date, $this->expire_date, true) ? true : false) : true;
    }

    protected function checkUsedTimes()
    {
        // if use_times in database not null then (if use_times > used_times :means we dad not used all our chance in the coupon then true else false)
        return $this->use_times != '' ? (($this->use_times > $this->used_times) ? true : false)  :   true;
    }

    protected function checkGreaterThan($total)
    {
        // if greater_than in the database is not null then (if the total sent is >=  $this->greater_than in databae then true esle false):true
        return $this->greater_than != '' ? (($total   >= $this->greater_than) ? true : false) :  true;
    }

    protected function doProcess($total)
    {
        switch ($this->type) {

            case 'fixed':
                return $this->value;
                break;

            case 'percentage':
                return ($this->value / 100) * $total; // get value not as  percentage as but number using math logic
                break;

            default:
                return 0;
        }
    }
}
