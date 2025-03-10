<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'property_type' => 'required|string',
            'transaction_type' => 'required|string',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
            'owner' => 'required|exists:users,id',
        ];
    }
}
