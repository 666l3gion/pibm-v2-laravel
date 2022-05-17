<?php

namespace App\Http\Requests\TeacherRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'nip' => 'required|numeric|digits:18',
            'name' => 'required|max:255',
            'email' => 'required|email',
        ];

        // $this->route() is route binding to get data teacher
        $teacher = $this->route('teacher');

        if (request()->nip !== $teacher->nip)
            $rules['nip'] .= '|unique:teachers';
        if (request()->email !== $teacher->email)
            $rules['email'] .= '|unique:teachers';

        return $rules;
    }
}
