<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'First_name'=>$this->f_name,
            'Last_name'=>$this->l_name,
            'email'=>$this->email,
            'dob'=>$this->password,
            'bio'=>$this->bio,
            'national_id'=>$this->national_id,
            'Profile_photo'=>$this->getFilePath,

        ];
    }
}
