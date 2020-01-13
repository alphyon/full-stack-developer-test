<?php


namespace App;
Use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Fee extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection='fees';
    protected $fillable=[
        'type_park',
        'value',
        'name',

    ];

    public function account(){
        return $this->belongsTo(Account::class);
    }

}
