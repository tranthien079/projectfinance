<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
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
            'title' =>'required' ,
            'amount' => 'required|numeric',
            'account' => 'required',
            'category' => 'required',
            'income_date' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Bạn chưa nhập vào email.',
            'amount.required' => 'Bạn chưa nhập tiền',
            'amount.numeric' => 'Vui lòng nhập số nguyên dương!',
            'account.required' => 'Bạn chưa chọn tài khoản',
            'category.required' => 'Bạn chưa chọn hạng mục',
            'income_date.required' => 'Bạn chưa nhập ngày',
        ];
    }
}
