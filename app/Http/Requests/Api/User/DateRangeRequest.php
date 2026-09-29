<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "DateRangeRequest",
    title: "Health DateRangeRequest",
    description: "Date range used to filter health measurements.",
    type: "object",
    properties: [
        new OA\Property(
            property: "from",
            type: "string",
            format: "date",
            nullable: true,
            example: "2026-09-01",
            description: "Start date of the requested range."
        ),
        new OA\Property(
            property: "to",
            type: "string",
            format: "date",
            nullable: true,
            example: "2026-09-30",
            description: "End date of the requested range."
        ),
    ]
)]
class DateRangeRequest extends FormRequest
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
