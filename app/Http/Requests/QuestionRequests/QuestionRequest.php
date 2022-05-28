<?php

namespace App\Http\Requests\QuestionRequests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'exam_type_id' => 'required|numeric',
            'image' => 'sometimes|image|file|max:1024',
            'question' => 'required|max:1000',
            'option_a' => 'required|max:256',
            'option_b' => 'required|max:256',
            'option_c' => 'required|max:256',
            'option_d' => 'required|max:256',
            'option_e' => 'required|max:256',
            'right_option' => 'required|in:a,b,c,d,e'
        ];
    }
}
