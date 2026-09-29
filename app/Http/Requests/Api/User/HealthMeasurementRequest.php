<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "HealthMeasurementRequest",
    title: "Health Measurement Request",
    description: "Request for recording a health measurement.",
    type: "object",
    required: [
        "type",
        "value",
        "measured_at"
    ],
    properties: [
        new OA\Property(
            property: "type",
            type: "string",
            description: "Type of health measurement.",
            enum: [
                "weight",
                "blood_pressure",
                "heart_rate",
                "temperature",
                "blood_sugar"
            ],
            example: "blood_pressure"
        ),

        new OA\Property(
            property: "value",
            type: "number",
            format: "float",
            description: "Primary measurement value. For blood pressure, this represents systolic pressure.",
            example: 128
        ),

        new OA\Property(
            property: "value_secondary",
            type: "number",
            format: "float",
            nullable: true,
            description: "Secondary measurement value. Required for blood pressure and represents diastolic pressure.",
            example: 82
        ),

//        new OA\Property(
//            property: "unit",
//            type: "string",
//            nullable: true,
//            description: "Measurement unit. The backend determines the correct unit based on the measurement type.",
//            example: "mmHg"
//        ),

        new OA\Property(
            property: "measured_at",
            type: "string",
            format: "date-time",
            description: "Date and time when the measurement was taken.",
            example: "2026-09-24 09:30:00"
        ),

        new OA\Property(
            property: "notes",
            type: "string",
            nullable: true,
            description: "Optional notes about the measurement.",
            example: "Measured before dialysis."
        ),
    ]
)]
class HealthMeasurementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'type'            => ['required', Rule::in(['weight', 'blood_pressure', 'heart_rate', 'temperature', 'blood_sugar',]),],
            'value'           => ['required', 'numeric', 'min:0',],
            'value_secondary' => ['nullable', 'numeric', 'min:0', 'required_if:type,blood_pressure',],
            'unit'            => ['nullable', 'string', 'max:20',],
            'measured_at'     => ['required', 'date', 'date_format:Y-m-d H:i:s',],
            'notes'           => ['nullable', 'string', 'max:1000',],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Measurement type is required.',
            'type.in' => 'Invalid measurement type.',

            'value.required' => 'Measurement value is required.',
            'value.numeric' => 'Measurement value must be numeric.',
            'value.min' => 'Measurement value must be greater than or equal to 0.',

            'value_secondary.required_if' =>
                'The secondary value is required for blood pressure.',

            'value_secondary.numeric' =>
                'The secondary value must be numeric.',

            'measured_at.required' =>
                'Measurement date and time are required.',

            'measured_at.date_format' =>
                'Measurement date must use Y-m-d H:i:s format.',
        ];
    }
}
