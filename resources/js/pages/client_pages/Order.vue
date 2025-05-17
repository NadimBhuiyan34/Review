<template>
    <Head title="Checkout" />
    <AppLayout>
        <div class="mx-auto max-w-6xl px-6 py-12 bg-gray-100 my-5">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold text-gray-800">🧾 Checkout</h1>
                <p class="mt-2 text-gray-500">Complete your purchase by providing the information below.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Shipping Info -->
                <div class="rounded-2xl bg-white p-8 shadow-lg transition hover:shadow-2xl">
                    <h2 class="mb-6 text-2xl font-semibold text-blue-700 flex items-center gap-2">
                        <span>📦</span> Shipping Information
                    </h2>
                    <form @submit.prevent="placeOrder" class="space-y-6">
                        <div v-for="(field, key) in shippingFields" :key="key">
                            <label :for="key" class="block mb-1 text-sm font-medium text-gray-700">
                                {{ field.label }}
                            </label>
                            <component
                                :is="field.type === 'textarea' ? 'textarea' : 'input'"
                                :type="field.type !== 'textarea' ? field.type : undefined"
                                v-model="shipping[key]"
                                :id="key"
                                class="w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :rows="field.type === 'textarea' ? 3 : undefined"
                                required
                            />
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="rounded-2xl bg-white p-8 shadow-lg transition hover:shadow-2xl">
                    <h2 class="mb-6 text-2xl font-semibold text-green-700 flex items-center gap-2">
                        <span>🛒</span> Order Summary
                    </h2>

                    <div class="space-y-4 max-h-64 overflow-y-auto">
                        <div
                            v-for="(item, index) in cartItems"
                            :key="index"
                            class="flex justify-between items-center border-b pb-3"
                        >
                            <div>
                                <p class="font-semibold text-gray-800">{{ item.name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                            </div>
                            <p class="font-bold text-gray-700">{{ formatCurrency(item.price * item.quantity) }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between border-t pt-4 text-lg font-semibold text-gray-800">
                        <span>Total</span>
                        <span class="text-green-600">{{ formatCurrency(cartTotal) }}</span>
                    </div>

                    <div class="mt-6">
                        <label class="block mb-1 text-sm font-medium text-gray-700">💳 Payment Method</label>
                        <select
                            v-model="paymentMethod"
                            class="w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option disabled value="">Select a payment method</option>
                            <option value="cod">Cash on Delivery</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="bkash">bKash</option>
                        </select>
                    </div>

                    <button
                        @click="placeOrder"
                        class="mt-8 w-full rounded-full bg-gradient-to-r from-green-500 to-emerald-600 py-3 text-white font-bold shadow-lg transition hover:opacity-90"
                    >
                        ✅ Confirm & Place Order
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/ClientLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const cartItems = ref([
    { name: 'Wireless Headphones', price: 2500, quantity: 1 },
    { name: 'Smart Watch', price: 1800, quantity: 2 },
]);

const shipping = ref({
    name: '',
    email: '',
    address: '',
    phone: '',
});

const shippingFields = {
    name: { label: 'Full Name', type: 'text' },
    email: { label: 'Email Address', type: 'email' },
    address: { label: 'Shipping Address', type: 'textarea' },
    phone: { label: 'Phone Number', type: 'text' },
};

const paymentMethod = ref('');
const cartTotal = computed(() => cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0));

const formatCurrency = (amount) => `${amount.toLocaleString()} TK`;

const placeOrder = () => {
    if (!shipping.value.name || !shipping.value.email || !shipping.value.address || !shipping.value.phone || !paymentMethod.value) {
        alert('⚠️ Please fill in all fields.');
        return;
    }

    console.log('✅ Order placed with:', {
        shipping: shipping.value,
        payment: paymentMethod.value,
        items: cartItems.value,
        total: cartTotal.value,
    });

    alert('🎉 Order placed successfully!');
};
</script>
