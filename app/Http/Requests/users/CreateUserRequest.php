<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'rol' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El campo de Nombre es requerido',
            'email.required' => 'El campo de Correo electrónico es requerido',
            'email.email' => 'El campo de Correo electrónico debe ser una dirección de correo electrónico válida',
            'email.unique' => 'El Correo electrónico se encuentra en uso',
            'email.max' => 'El campo de Correo electrónico no puede tener más de 255 caracteres',
            'password.required' => 'El campo de Contraseña es requerido',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password_confirmation.required' => 'El campo de Confirmación de contraseña es requerido',
            'rol.required' => 'El campo Rol es requerido',
        ];
    }
}
