<template>
    <Head title="Shipping Address" />
    <AppLayout>
        <div class="min-h-screen bg-blue-100 py-10 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl p-10">
                <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">🚚 Shipping & Payment</h1>

                <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Shipping Info -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-blue-700 mb-4 flex items-center gap-2">
                            <span>📦</span> Shipping Address
                        </h2>

                        <div v-for="(field, key) in shippingFields" :key="key" class="relative">
                            <input
                                :type="field.type"
                                v-model="shipping[key]"
                                :id="key"
                                required
                                class="peer w-full border-b-2 border-gray-300 bg-transparent pt-6 pb-2 text-gray-900 placeholder-transparent focus:border-blue-500 focus:outline-none"
                                placeholder=" "
                            />
                            <label
                                :for="key"
                                class="absolute left-0 top-1 text-sm text-gray-500 transition-all peer-placeholder-shown:top-5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-sm peer-focus:text-blue-500"
                            >
                                {{ field.label }}
                            </label>
                        </div>
                    </div>

                    <!-- Payment & Summary -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-green-700 mb-4 flex items-center gap-2">
                            <span>💳</span> Payment Method
                        </h2>

                        <div class="space-y-3">
                            <div
                                v-for="method in paymentMethods"
                                :key="method.value"
                                class="flex items-center p-4 border rounded-lg hover:border-blue-500 cursor-pointer transition"
                                :class="{ 'border-blue-500 bg-blue-50': paymentMethod === method.value }"
                                @click="paymentMethod = method.value"
                            >
                                <span class="text-2xl mr-3">{{ method.icon }}</span>
                                <span class="text-gray-800 font-medium">{{ method.label }}</span>
                            </div>
                        </div>

                        <div class="pt-6 border-t">
                            <button
                                type="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 font-bold rounded-full transition transform hover:scale-105 shadow-lg"
                            >
                                ✅ Confirm & Place Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/layouts/ClientLayout.vue';
import { Head } from '@inertiajs/vue3';

const shipping = ref({
    name: '',
    email: '',
    address: '',
    phone: '',
});

const shippingFields = {
    name: { label: 'Full Name', type: 'text' },
    email: { label: 'Email Address', type: 'email' },
    address: { label: 'Street Address', type: 'text' },
    phone: { label: 'Phone Number', type: 'text' },
};

const paymentMethod = ref('');
const paymentMethods = [
    { value: 'cod', label: 'Cash on Delivery', icon: '💵' },
    { value: 'card', label: 'Credit / Debit Card', icon: '💳' },
    { value: 'bkash', label: 'bKash', icon: '📱' },
];

const submitForm = () => {
    if (
        !shipping.value.name ||
        !shipping.value.email ||
        !shipping.value.address ||
        !shipping.value.phone ||
        !paymentMethod.value
    ) {
        alert('⚠️ Please complete all fields before submitting.');
        return;
    }

    // Replace this with actual API call
    console.log('📦 Order Info:', {
        shipping: shipping.value,
        payment: paymentMethod.value,
    });

    alert('🎉 Order placed successfully!');
};
</script>
