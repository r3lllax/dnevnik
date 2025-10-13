<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $this */
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'surname'=>$this->surname,
            'patronymic'=>$this->patronymic,
            'birthdate'=>$this->birth_date,
            'img'=>$this->img_path,
            'phone'=>$this->phone_number,
            'head'=>$this->role->name==="Староста"?true:false,
        ];
    }
}
