<?php

namespace App\Http\Requests\Api\User;

use App\Enums\FamilyPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestoreFamilyMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'patient';
    }

    public function rules(): array
    {
        return [
            'permissions' => ['required', 'array', 'min:1',],
            'permissions.*' => [
                'required',
                'string',
                Rule::enum(FamilyPermission::class),
            ],
        ];
    }
}
