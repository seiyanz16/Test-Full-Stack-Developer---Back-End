<?php

namespace App\Http\Requests;

use App\Traits\ValidationResponsable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
        return [
            'date' => ['nullable', 'date'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0', 'lte:amount'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'date.date' => 'Date must be a valid date.',
            'amount.numeric' => 'Amount must be a number.',
            'amount.min' => 'Amount must be at least 0.',
            'discount.numeric' => 'Discount must be a number.',
            'discount.min' => 'Discount must be at least 0.',
            'discount.lte' => 'Discount cannot be greater than or equal to the amount.',
            'note.max' => 'Note must not exceed 500 characters.',
        ];
    }
}
