<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class DialysisSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'from' => ['nullable', 'date', 'date_format:Y-m-d'],

            'to' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:from'],
        ];
    }

    public function from(): string
    {
        return $this->input('from', now('Asia/Gaza')->format('Y-m-d'));
    }

    public function to(): string
    {
        return $this->input('to', now('Asia/Gaza')->addDays(30)->format('Y-m-d'));
    }
}
