<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string|min:3|max:5'
        ];
    }


    public function getSetCode(): string
    {
        return $this->input('code');
    }
}

