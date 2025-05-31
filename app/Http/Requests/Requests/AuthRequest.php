<?php

namespace App\Http\Requests\Requests;

use App\Traits\ValidationResponsable;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    use ValidationResponsable;
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
    public function rules(): array
    {
        return $this->isRegisterRoute()
            ? $this->registerRules()
            : $this->loginRules();
    }

    public function messages(): array
    {
        return $this->isRegisterRoute()
            ? $this->registerMessages()
            : $this->loginMessages();
    }

    private function isRegisterRoute(): bool
    {
        return $this->routeIs('register') && $this->isMethod('post');
    }

    private function loginRules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    private function registerRules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    private function loginMessages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
        ];
    }

    private function registerMessages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be valid.',
            'email.unique' => 'Email is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least :min characters.',
        ];
    }
}
