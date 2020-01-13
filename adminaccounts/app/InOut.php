<?php


namespace App;

Use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class InOut extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection='in_out';
    protected $fillable=[
        'account_id',
        'temp_license',
        'in',
        'out',
        'status'

    ];

    public function account(){
        return $this->belongsTo(Account::class);
    }
}
