<?php

namespace App\Http\Requests\ExamRequests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'subject_id' => 'required|numeric',
            'class_id' => 'required|numeric',
            'exam_type_id' => 'required|numeric',
            'name' => 'required',
            'total_question' => 'required|numeric',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'time' => 'required|numeric|max:2000',
        ];
    }
}
