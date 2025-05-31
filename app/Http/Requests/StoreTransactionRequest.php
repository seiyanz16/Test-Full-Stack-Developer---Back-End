<?php

namespace App\Http\Requests;

use App\Traits\ValidationResponsable;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0', 'lte:amount'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Date is required.',
            'amount.required' => 'Amount is required.',
            'discount.numeric' => 'Discount must be a number.',
            'discount.min' => 'Discount must be at least 0.',
            'discount.lte' => 'Discount cannot be greater than or equal to the amount.',
            'note.max' => 'Note must not exceed 500 characters.',
        ];
    }
}
