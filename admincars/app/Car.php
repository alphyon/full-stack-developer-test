<?php
namespace App;

Use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Car extends Eloquent{
    protected $connection = 'mongodb';
    protected $collection='cars';
    protected $fillable=[
        'license',
        'model',
        'color' ,
        'owner',
        'park_id'
    ];

    public function park(){
        return $this->hasOne(Park::class,'park_id','park_id');
    }

}
