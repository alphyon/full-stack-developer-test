<?php


namespace App\Http\Resources;


use App\Http\Repositories\FeesRepository;
use App\Park;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResponse extends JsonResource
{
    public function toArray($request)
    {
//        $parkRe = new FeesRepository(new Park());
//        $park = $parkRe->find($this->park_id);
       return [
           'id'=>$this->id,
           'type'=>'accounts',
           'attributes'=>[
               'car_license'=>$this->car_license,
               'fee_id'=>$this->fee_id,
               'month_minutes'=>$this->month_minutes,
               'created_at'=>$this->created_at,
               'updated_at'=>$this->updated_at,
           ],
//           'relationship'=>
//           [
//               'ele'=>$this->park,
//               'id'=>$park->id,
//               'type'=>'parks',
//               'attributes'=>[
//                   'name'=>$park->name,
//                   'description'=>$park->description,
//                   'created_at'=>$park->created_at,
//                   'updated_at'=>$park->updated_at,
//               ]
//           ],


       ];
    }

}
