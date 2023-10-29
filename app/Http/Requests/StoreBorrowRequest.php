<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowRequest extends FormRequest
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
            'user_id' => 'required',
            'borrow_date' => 'required',
            'devices' => 'required',
    ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'Bạn không được để trống !',
            'borrow_date.required' => 'Bạn không được để trống !',
            'devices.required' => 'Vui lòng chọn thiết bị !',
        ];
    }
    
}
