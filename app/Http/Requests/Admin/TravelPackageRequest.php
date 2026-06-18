<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TravelPackageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST': {
                return [
                    'name'        => 'required|string|max:255',
                    'category_id' => 'nullable|exists:categories,id',
                    'district'    => 'required|string|max:255',
                    'best_for'    => 'nullable|string|max:255',
                    'price'       => 'required|numeric|min:0',
                    'description' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'        => 'required|string|max:255',
                    'category_id' => 'nullable|exists:categories,id',
                    'district'    => 'required|string|max:255',
                    'best_for'    => 'nullable|string|max:255',
                    'price'       => 'required|numeric|min:0',
                    'description' => 'required',
                ];
            }
        }
    }
}
