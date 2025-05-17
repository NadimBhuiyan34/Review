<template>
<Head title="Cart" />
 <AppLayout>
  <div class="max-w-6xl mx-auto px-4 py-12 bg-gray-200 my-5">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
      🛍️ Your Shopping Cart
    </h1>

    <!-- Cart Items -->
    <div class="bg-white rounded-2xl shadow-md divide-y divide-gray-100 overflow-hidden">
      <div
        v-for="(item, index) in cartItems"
        :key="index"
        class="group flex flex-col sm:flex-row justify-between items-center p-6 hover:bg-gray-50 transition"
      >
        <!-- Product Info -->
        <div class="flex items-center gap-5 w-full sm:w-1/2">
          <img
            :src="item.image"
            :alt="item.name"
            class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm group-hover:scale-105 transition-transform duration-200"
          />
          <div>
            <h2 class="text-xl font-semibold text-gray-900">{{ item.name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Price: {{ formatCurrency(item.price) }}</p>
          </div>
        </div>

        <!-- Quantity Control -->
        <div class="flex items-center mt-5 sm:mt-0 gap-2">
          <button
            @click="decreaseQty(index)"
            class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-lg font-bold rounded-md"
          >-</button>
          <div class="px-4 py-1.5 bg-gray-100 text-center font-medium min-w-[40px] rounded-md">
            {{ item.quantity }}
          </div>
          <button
            @click="increaseQty(index)"
            class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-lg font-bold rounded-md"
          >+</button>
        </div>

        <!-- Subtotal -->
        <div class="text-right mt-4 sm:mt-0 text-lg font-bold text-gray-700 w-full sm:w-auto">
          {{ formatCurrency(item.price * item.quantity) }}
        </div>
      </div>
    </div>

    <!-- Summary & Checkout -->
    <div class="mt-10 bg-gradient-to-br from-gray-50 to-gray-100 p-8 rounded-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center">
      <div class="text-2xl font-extrabold text-gray-900">
        Total: {{ formatCurrency(cartTotal) }}
      </div>
      <Link href="/product_orders"
        class="mt-5 sm:mt-0 px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-full shadow-lg transition duration-300"
      >
        🧾 Proceed to Checkout
      </Link>
    </div>
  </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/ClientLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, defineProps, ref } from 'vue';

const cartItems = ref([
  {
    name: 'Wireless Headphones',
    price: 2500,
    quantity: 1,
    image: 'https://via.placeholder.com/120x120?text=Headphones',
  },
  {
    name: 'Smart Watch',
    price: 1800,
    quantity: 2,
    image: 'https://via.placeholder.com/120x120?text=Smart+Watch',
  },
])

const increaseQty = (index) => {
  cartItems.value[index].quantity++
}

const decreaseQty = (index) => {
  if (cartItems.value[index].quantity > 1) {
    cartItems.value[index].quantity--
  }
}

const cartTotal = computed(() =>
  cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

const formatCurrency = (amount) => {
  return `${amount.toLocaleString()} TK`
}
</script>

<style scoped>
/* Optional: Add smooth transition for images */
img {
  transition: transform 0.2s ease-in-out;
}
</style>
