<?php

namespace App\Http\Requests\MajorSubjectRequests;

use Illuminate\Foundation\Http\FormRequest;

class MajorSubjectRequest extends FormRequest
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
            'subject_id' => 'required|numeric',
            'major_ids' => 'required|array',
            "major_ids.*"  => "required|string|distinct|numeric",
        ];
    }
}
