<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(User $user): array
    {
        $tableName = $user->getTable();
        $id = request()->segment('3');
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique($tableName)->ignore($id)],
            'password' => 'nullable|min:5',
            'phone' => ['required', Rule::unique($tableName)->ignore($id)],
            'address' => 'required',
            'gender' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,webm,jpeg,gif',
        ];
    }
}
