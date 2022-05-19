<?php

namespace App\Http\Requests\SubjectTeacherRequests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectTeacherRequest extends FormRequest
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
            'teacher_id' => 'required|numeric',
            'subject_ids' => 'required|array',
            "subject_ids.*"  => "required|string|distinct|numeric",
        ];
    }
}
