<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ParkResponse extends JsonResource
{
    public function toArray($request)
    {
       return [
           'id'=>$this->id,
           'type'=>'park',
           'attributes'=>[
               'name'=>$this->name,
               'description'=>$this->description,
               'created_at'=>$this->created_at,
               'updated_at'=>$this->updated_at,
           ],

       ];
    }

}
