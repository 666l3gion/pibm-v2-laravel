<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // $this->route() is route binding to get data user
        $user = $this->route('user');

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email',
        ];

        if (!$user->isSuperadmin() || $user->id !== auth()->user()->id) {
            $rules['role'] = 'required|in:' . join(',', $user->avalaibleRoles());
            $rules['is_active'] = 'required|in:1,0';
        }

        if (request()->email !== $user->email)
            $rules['email'] .= '|unique:users';

        return $rules;
    }
}
