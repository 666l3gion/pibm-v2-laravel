<?php

namespace App\Http\Requests\StudentRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nis' => 'required|numeric|digits:10|unique:students',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'gender' => 'required|in:L,P'
        ];
    }
}
