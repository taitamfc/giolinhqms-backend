<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users',
            'address' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'group_id' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn không được để trống !',
            'email.required' => 'Bạn không được để trống !',
            'password.required' => 'Bạn không được để trống !',
            'address.required' => 'Bạn không được để trống !',
            'phone.required' => 'Bạn không được để trống !',
            'gender.required' => 'Bạn không được để trống !',
            'birthday.required' => 'Bạn không được để trống !',
            'group_id.required' => 'Bạn không được để trống !',
            'email.unique' => 'Tên email đã tồn tại !',

        ];
    }
}
