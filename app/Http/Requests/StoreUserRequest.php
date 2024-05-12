<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required','max:255'],
            'second_name' => ['required','max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Поле Имя обязательно для заполнения',
            'second_name.required' => 'Поле Email обязательно для заполнения',
            'email.email' => 'Поле Email должно быть корректным email-адресом',
            'password.required' => 'Поле Пароль обязательно для заполнения',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'Имя',
            'email' => 'Email',
            'password' => 'Сообщение',
        ];
    }
}
