<?php

namespace App\Http\Requests\AdminRequest\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
             return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
            return [
            // Shipping address validation (nested fields)
            'shipping.name' => 'required|string|max:255',
            'shipping.address' => 'required|string|max:255',
            'shipping.city' => 'required|string|max:100',
            'shipping.postal_code' => 'required|string|max:20',
            'shipping.phone' => 'required|string|max:20',

            // Order status
            'status' => 'required|in:Pending,Confirmed,Processing,Shipped,Out for Delivery,Delivered,Returned,Cancelled,Failed',

            // Payment method validation
            'payment_method' => 'required|in:Cash on Delivery,Card,Bkash,Nagad,Rocket',

            // Payment status validation
            'payment_status' => 'required|in:Paid,Unpaid,Refunded',
        ];
    }
}
