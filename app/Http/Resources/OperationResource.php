<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['id'=>$this->id,
            'amount'=>$this->amount,
            'remark'=>$this->remark,
            'category_id'=>$this->category_id,
            'account_id'=>$this->account_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,];
    }
}
