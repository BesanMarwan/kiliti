<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class FoodAssistantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->patient !== null;
    }

    public function rules(): array
    {
        return [
            'search' => ['required', 'string', 'min:2', 'max:500'],
        ];
    }
}
