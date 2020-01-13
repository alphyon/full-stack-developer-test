<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class FeeResponse extends JsonResource
{
    public function toArray($request)
    {
       return [
           'id'=>$this->id,
           'type'=>'fees',
           'attributes'=>[
               'name'=>$this->name,
               'type_park'=>$this->type_park,
               'value'=>$this->value,
               'created_at'=>$this->created_at,
               'updated_at'=>$this->updated_at,
           ],

       ];
    }

}
