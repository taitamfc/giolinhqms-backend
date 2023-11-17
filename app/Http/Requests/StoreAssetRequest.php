<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
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
                'name' => 'required|unique:assets',
                'quantity' => 'required|numeric',
                'unit' => 'required',
                'price' => 'required|numeric',
                'device_type_id' => 'required',
                'department_id' => 'required',
        ];
    }
    public function messages()
    {

        return [
            'name.required' => 'Bạn không được để trống !',
            'name.unique' => 'Tên tài sản đã tồn tại !',
            'quantity.required' => 'Bạn không được để trống !',
            'quantity.numeric' => 'Số lượng phải là số !',
            'unit.required' => 'Bạn không được để trống !',
            'price.required' => 'Bạn không được để trống !',
            'price.numeric' => 'Giá tiền phải là số !',
            'device_type_id.required' => 'Bạn không được để trống !',
            'department_id.required' => 'Bạn không được để trống !',
        ];
    }
}