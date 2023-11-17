<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportDeviceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'importData' => 'required|mimes:xlsx,xls'
        ];
    }
    public function messages()
    {
        return  [
                'importData.required' => 'Vui lòng chọn file!',
                'importData.mimes' => 'Vui lòng chọn file có đuôi .xlsx hoặc xls!',
            ];
    }
}