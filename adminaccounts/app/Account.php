<?php


namespace App;

Use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Account extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection='accounts';
    protected $fillable=[
        'car_license',
        'fee_id',
        'month_minutes' ,

    ];

    public function fee(){
        return $this->hasOne(Fee::class);
    }

    public function inOut(){
        return $this->hasOne(InOut::class);
    }


}
