<?php
namespace App;

Use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Park extends Eloquent{
    protected $connection = 'mongodb';
    protected $collection='parks';
    protected $fillable=[
        'name',
        'description',
    ];

    public function car(){
        return $this->belongsTo(Car::class);
    }

}
