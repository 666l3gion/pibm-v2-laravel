<?php

namespace App\Http\Requests\ClassTeacherRequests;

use Illuminate\Foundation\Http\FormRequest;

class ClassTeacherRequest extends FormRequest
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
        // that regex to validation only number in string, untuk memvalidasi hanya number didalam string "123"
        return [
            'teacher_id' => 'required|numeric',
            'class_ids' => 'required|array',
            "class_ids.*"  => "required|string|distinct|numeric",
        ];
    }
}
