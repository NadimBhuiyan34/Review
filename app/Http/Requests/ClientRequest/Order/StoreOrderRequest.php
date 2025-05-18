<?php

namespace App\Http\Requests\ClientRequest\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        // Shipping address validation
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'phone' => 'required|string|max:20',

        // Order & cart
        'payment_method' => 'required|in:cod,card,bkash',
        'cart' => 'required|array|min:1',
        'cart.*.product.id' => 'required|exists:products,id',
        'cart.*.quantity' => 'required|integer|min:1',
        'cart.*.product.price' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        ];
    }
}
