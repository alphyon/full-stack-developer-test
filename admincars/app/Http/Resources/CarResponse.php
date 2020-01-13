<?php


namespace App\Http\Resources;


use App\Http\Repositories\ParksRepository;
use App\Park;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResponse extends JsonResource
{
    public function toArray($request)
    {
        $parkRe = new ParksRepository(new Park());
        $park = $parkRe->find($this->park_id);
       return [
           'id'=>$this->id,
           'type'=>'cars',
           'attributes'=>[
               'owner'=>$this->owner,
               'license'=>$this->license,
               'model'=>$this->model,
               'color'=>$this->color,
               'type'=>$this->type,
               'created_at'=>$this->created_at,
               'updated_at'=>$this->updated_at,
           ],
           'relationship'=>
           [
               'ele'=>$this->park,
               'id'=>$park->id,
               'type'=>'parks',
               'attributes'=>[
                   'name'=>$park->name,
                   'description'=>$park->description,
                   'created_at'=>$park->created_at,
                   'updated_at'=>$park->updated_at,
               ]
           ],


       ];
    }

}
