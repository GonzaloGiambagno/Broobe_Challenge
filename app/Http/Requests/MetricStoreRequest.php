<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetricStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => 'required|string|min:2',
            'accessibility_metric' => 'nullable|numeric|between:0,1',
            'best_practices_metric' => 'nullable|numeric|between:0,1',
            'performance_metric' => 'nullable|numeric|between:0,1',
            'pwa_metric' => 'nullable|numeric|between:0,1',
            'seo_metric' => 'nullable|numeric|between:0,1',
            'strategy_id' => 'required|numeric',
        ];
    }
}
