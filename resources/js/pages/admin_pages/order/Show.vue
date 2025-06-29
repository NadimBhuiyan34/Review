<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { computed, defineProps } from 'vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
});

// Order status
const status = props.order.status ?? 'Pending';

// Constants
const shippingFee = 100;
const systemFee = 20;

// Subtotal
const subtotal = computed(() =>
    props.order.order_items.reduce((sum, item) => {
        const price = item.product.price ?? 0;
        const discount = item.product.discount_price ?? 0;
        return sum + (price - discount) * item.quantity;
    }, 0),
);

// Tax

// Final total = subtotal - shippingFee - systemFee + tax
const total = computed(() => subtotal.value + shippingFee + systemFee);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Orders', href: '/admin_orders' }];
</script>

<template>
    <Head title="Orders" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full space-y-6 bg-gray-100 p-4 sm:p-6">
            <!-- Header -->
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
                <div class="flex w-full flex-col items-center gap-3 sm:w-auto sm:flex-row"></div>
            </div>
            <div class="mx-auto  bg-white p-2 sm:p-10">
                <div class="flex items-center gap-4">
                    <img
                        src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?semt=ais_hybrid&w=740"
                        alt="User avatar"
                        class="h-20 w-20 rounded-full shadow-md ring-2 ring-indigo-500"
                    />
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ order.user.name }}</h2>
                        <p class="text-sm text-gray-500">{{ order.user.email }}</p>
                    </div>
                </div>
                <hr class="my-5" />
                <!-- Order Header -->
                <header class="mb-8 text-center sm:text-left">
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        Order ID: <span class="text-indigo-600">{{ order.order_number }}</span>
                    </h1>
                    <p class="mt-1 text-sm font-medium text-gray-500 sm:text-base">
                        Placed on <time class="text-gray-400 italic">{{ order.created_at }}</time>
                    </p>
                </header>

                <!-- Info Grid -->
                <div class="mb-10 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Shipping Info -->
                    <section
                        class="rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-slate-50 p-6 shadow-lg transition-all duration-300 hover:shadow-2xl sm:p-8"
                    >
                        <h2 class="mb-6 flex items-center gap-2 border-b border-gray-200 pb-3 text-xl font-bold text-gray-800">
                            📦 Shipping Information
                        </h2>
                        <div class="space-y-4 text-[15px] text-gray-800">
                            <p><span class="font-semibold">👤 Name:</span> {{ order.shipping_address.name }}</p>
                            <p><span class="font-semibold">📞 Phone:</span> {{ order.shipping_address.phone }}</p>
                            <p><span class="font-semibold">🏠 Address:</span> {{ order.shipping_address.address }}</p>
                            <p><span class="font-semibold">🏙️ City:</span> {{ order.shipping_address.city }}</p>
                            <p><span class="font-semibold">📮 Postal Code:</span> {{ order.shipping_address.postal_code }}</p>
                        </div>
                    </section>

                    <!-- Status & Payment -->
                    <section
                        class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-tr from-white via-gray-50 to-white p-6 shadow-lg transition-all duration-300 hover:shadow-2xl sm:p-8"
                    >
                        <h2 class="mb-6 flex items-center gap-2 border-b border-gray-200 pb-3 text-xl font-bold text-gray-800">
                            🧾 Order Status & Payment
                        </h2>

                        <!-- Status Badge -->
                        <div class="mb-6">
                            <span
                                :class="[
                                    'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold shadow-sm transition-all duration-300',
                                    status === 'Delivered'
                                        ? 'border border-green-300 bg-green-100 text-green-700'
                                        : status === 'Processing'
                                          ? 'border border-yellow-300 bg-yellow-100 text-yellow-700'
                                          : 'border border-red-300 bg-red-100 text-red-700',
                                ]"
                            >
                                <svg
                                    v-if="status === 'Delivered'"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg
                                    v-else-if="status === 'Processing'"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 animate-spin"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v4m0 8v4m8-8h-4M4 12H0m16.95-7.05l-2.83 2.83M7.05 16.95l-2.83 2.83M16.95 16.95l-2.83-2.83M7.05 7.05L4.22 4.22"
                                    />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ status }}
                            </span>
                        </div>

                        <!-- Payment Info -->
                        <div class="space-y-3 text-sm font-medium text-gray-700 sm:text-base">
                            <div class="flex justify-between">
                                <span>💳 Payment Method</span>
                                <span class="font-semibold text-gray-900">{{ order.payment_method || 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>📦 Payment Status</span>
                                <span class="font-semibold text-gray-900">{{ order.payment_status || 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Order ID -->
                        <div class="mt-6 border-t border-dashed pt-4 text-center font-mono text-xs text-gray-400 select-text">
                            Order ID: {{ order.order_number }}
                        </div>
                    </section>

                    <!-- Price Summary -->
                    <section
                        class="relative rounded-2xl border border-gray-200 bg-white p-6 shadow-lg transition duration-300 hover:shadow-2xl sm:p-8"
                    >
                        <h2 class="mb-6 flex items-center gap-2 border-b border-gray-100 pb-3 text-xl font-bold text-gray-800">💰 Price Summary</h2>
                        <div class="space-y-4 text-[15px] text-gray-700 sm:text-base">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-medium">{{ subtotal.toFixed(2) }} TK</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping Fee</span>
                                <span class="font-medium text-red-600">+{{ shippingFee.toFixed(2) }} TK</span>
                            </div>
                            <div class="flex justify-between">
                                <span>System Fee</span>
                                <span class="font-medium text-red-600">+{{ systemFee.toFixed(2) }} TK</span>
                            </div>
                        </div>

                        <div
                            class="mt-6 flex items-center justify-between border-t border-gray-200 pt-5 text-xl font-extrabold text-indigo-600 sm:text-2xl"
                        >
                            <span>Total</span>
                            <span>{{ total.toFixed(2) }} TK</span>
                        </div>
                    </section>
                </div>

                <!-- Product List -->
                <section
                    class="overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-50 p-6 shadow-xl transition-all duration-300 hover:shadow-2xl"
                >
                    <h2 class="mb-6 flex items-center gap-2 border-b border-dashed border-gray-300 pb-4 text-xl font-bold text-gray-800">
                        🛒 Products Ordered
                    </h2>

                    <ul
                        class="scrollbar-thin scrollbar-thumb-indigo-400 scrollbar-track-gray-100 max-h-[380px] divide-y divide-gray-200 overflow-y-auto pr-1"
                    >
                        <li v-for="(item, i) in order.order_items" :key="i" class="group transition-all">
                            <Link
                                :href="route('product_details.show', item.product.slug)"
                                class="flex items-center gap-4 rounded-xl px-2 py-4 transition-all duration-300 hover:bg-indigo-50 hover:shadow-sm"
                            >
                                <!-- Product Image -->
                                <div class="shrink-0">
                                    <img
                                        :src="`/storage/${item.product.images[0]?.image_path}`"
                                        alt="Product Image"
                                        class="h-16 w-16 rounded-lg border border-gray-300 object-cover shadow-sm transition group-hover:scale-[1.03]"
                                        loading="lazy"
                                    />
                                </div>

                                <!-- Product Info -->
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-base font-semibold text-gray-900 transition group-hover:text-indigo-700">
                                        {{ item.product.name }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">Qty: {{ item.quantity }}</p>
                                </div>

                                <!-- Price -->
                                <div class="min-w-[110px] text-right">
                                    <p class="text-base font-bold text-indigo-600 transition group-hover:text-indigo-800">
                                        {{ ((item.product.price - item.product.discount_price) * item.quantity).toLocaleString() }} TK
                                    </p>
                                </div>
                            </Link>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
