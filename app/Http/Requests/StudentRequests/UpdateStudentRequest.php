<?php

namespace App\Http\Requests\StudentRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $rules = [
            'nis' => 'required|numeric|digits:10',
            'name' => 'required|max:255',
            'email' => 'required|email',
            'gender' => 'required|in:L,P'
        ];

        // $this->route() is route binding to get data student
        $student = $this->route('student');

        if (request()->nis !== $student->nis)
            $rules['nis'] .= '|unique:students';
        if (request()->email !== $student->email)
            $rules['email'] .= '|unique:students';

        return $rules;
    }
}
