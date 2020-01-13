<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class InOutResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'in-out',
            'attributes' => [
                'account_id' => $this->account_id,
                'temp_license' => $this->temp_license,
                'in' => $this->in,
                'out' => $this->out,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],

        ];
    }

}
