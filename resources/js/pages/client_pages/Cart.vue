<template>
    <Head title="Cart" />
    <AppLayout>
        <div class="mx-auto my-5 max-w-[1400px]">
            <div class="px-10 py-12">
                <h1 class="mb-10 text-center text-4xl font-extrabold text-gray-800">🛍️ Your Shopping Cart</h1>

                <!-- Cart Items -->
                <div v-if="cartItems.length" class="divide-y divide-gray-100 overflow-hidden rounded-2xl bg-gray-100 shadow-md">
                    <div
                        v-for="(item, index) in cartItems"
                        :key="item.id"
                        class="group flex flex-col items-center justify-between p-6 transition hover:bg-gray-50 sm:flex-row"
                    >
                        <!-- Product Info -->
                        <div class="flex w-full items-center gap-5 sm:w-1/2">
                            <img
                                :src="`/storage/${item.image}`"
                                :alt="item.name"
                                class="h-24 w-24 rounded-xl border border-gray-200 object-cover shadow-sm transition-transform duration-200 group-hover:scale-105"
                            />
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ item.name }}</h2>
                                <p class="mt-1 text-sm text-gray-500">Price: {{ formatCurrency(item.price - item.discount_price) }}</p>
                            </div>
                        </div>

                        <!-- Quantity Control -->
                        <div class="mt-5 flex items-center gap-3 sm:mt-0">
                            <!-- Minus Button -->
                            <button
                                @click="updateQuantity(item.id, item.quantity - 1, index)"
                                :disabled="item.quantity <= 1 || loading[index]"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white shadow-md transition duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span class="text-xl leading-none">−</span>
                            </button>

                            <!-- Quantity Display -->
                            <div
                                class="flex h-10 min-w-[48px] items-center justify-center rounded-md bg-gray-100 text-lg font-semibold text-gray-800 shadow-inner"
                            >
                                {{ item.quantity }}
                            </div>

                            <!-- Plus Button -->
                            <button
                                @click="updateQuantity(item.id, item.quantity + 1, index)"
                                :disabled="loading[index]"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white shadow-md transition duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span class="text-xl leading-none">+</span>
                            </button>
                        </div>

                        <!-- Subtotal -->
                        <div class="mt-4 w-full text-right text-lg font-bold text-gray-700 sm:mt-0 sm:w-auto">
                            {{ formatCurrency((item.price - item.discount_price) * item.quantity) }}
                        </div>

                        <!-- Delete Button -->
                        <button
                            @click="deleteItem(item.id, index)"
                            :disabled="loading[index]"
                            class="mt-4 ml-4 text-sm font-bold text-red-600 hover:text-red-800 sm:mt-0 sm:text-base"
                            title="Remove item"
                        >
                            🗑️ Remove
                        </button>
                    </div>
                </div>

                <!-- Empty Cart Message -->
                <div v-else class="rounded-xl bg-white p-10 text-center text-xl font-semibold text-gray-500 shadow-sm">🛒 Your cart is empty!</div>

                <!-- Summary & Checkout -->
                <div
                    v-if="cartItems.length"
                    class="mt-10 flex flex-col items-center justify-between rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 p-8 shadow-sm sm:flex-row"
                >
                    <div class="text-2xl font-extrabold text-gray-900">Total: {{ formatCurrency(cartTotal) }}</div>
                    <Link
                        :href="route('orders.index')"
                        class="mt-5 rounded-full bg-gradient-to-r from-green-500 to-green-600 px-8 py-3 font-bold text-white shadow-lg transition duration-300 hover:from-green-600 hover:to-green-700 sm:mt-0"
                    >
                        🧾 Proceed to Checkout
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/ClientLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, defineProps, ref, watch } from 'vue';

const props = defineProps({
    cartItems: Array,
    totalPrice: Number,
});

// Use computed for cart items (readonly from props)
const cartItems = computed(() => props.cartItems);

// Local loading state per item
const loading = ref(props.cartItems.map(() => false));

// Reinitialize loading array if cartItems change
watch(
    () => props.cartItems,
    (newItems) => {
        loading.value = newItems.map(() => false);
    },
);

// Format currency (e.g., "1,000 TK")
const formatCurrency = (amount) => `${amount.toLocaleString()} TK`;

// Compute total cart price
const cartTotal = computed(() => cartItems.value.reduce((sum, item) => sum + (item.price - item.discount_price) * item.quantity, 0));

// Update quantity (Inertia PUT request)
const updateQuantity = (cartId, newQty, index) => {
    if (newQty < 1 || loading.value[index]) return;

    loading.value[index] = true;

    router.put(
        route('carts.update', cartId),
        { quantity: newQty },
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                loading.value[index] = false;
            },
            onError: () => {
                loading.value[index] = false;
            },
        },
    );
};

// Delete item (Inertia DELETE request)
const deleteItem = (cartId, index) => {
    if (!confirm('Are you sure you want to remove this item from your cart?')) return;

    loading.value[index] = true;

    router.delete(route('carts.destroy', cartId), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // Wait for prop rehydration from server (no need to manually remove)
        },
        onError: () => {
            loading.value[index] = false;
        },
    });
};
</script>
