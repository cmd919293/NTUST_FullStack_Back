<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonsterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            "id" => $this['id'],
            "name" => '',
            "attribute" => [],
            "imgNum" => $this['imgNum'],
            "HP" => $this['HP'],
            "ATTACK" => $this['ATTACK'],
            "DEFENSE" => $this['DEFENSE'],
            "SP_ATTACK" => $this['SP_ATTACK'],
            "SP_DEFENSE" => $this['SP_DEFENSE'],
            "SPEED" => $this['SPEED'],
            "sold" => $this['sold'],
            "discount" => $this['discount'],
            "price" => $this['price'],
            "description" => $this['description'],
            "createdAt" => $this['created_at']
        ];
    }

}
