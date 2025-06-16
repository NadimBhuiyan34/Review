<template>
  <AppLayout>
    <div class="max-w-[1550px] mx-auto p-6 sm:p-10 bg-gray-50 min-h-screen">
      <!-- Order Header -->
      <header class="mb-8 text-center sm:text-left">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
          OrderId: <span class="text-indigo-600">{{ order.order_number}}</span>
        </h1>
        <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
          Placed on <time class="italic text-gray-400">{{ order.created_at }}</time>
        </p>
      </header>

      <!-- Info Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Shipping Info Card -->
        <section
          class="bg-white rounded-xl border border-gray-200 shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300"
        >
          <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2">
            Shipping Information
          </h2>
          <div class="space-y-3 text-gray-800 text-sm sm:text-base">
            <p><span class="font-semibold">Name:</span> {{ order.shipping_address.name }}</p>
            <p><span class="font-semibold">Phone:</span> {{ order.shipping_address.phone }}</p>
            <p><span class="font-semibold">Address:</span> {{ order.shipping_address.address }}</p>
            <p><span class="font-semibold">City:</span> {{ order.shipping_address.city }}</p>
            <p><span class="font-semibold">Postal Code:</span> {{ order.shipping_address.postal_code }}</p>
          </div>
        </section>

        <!-- Order Status & Payment -->
        <section
          class="bg-white rounded-xl border border-gray-200 shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300"
        >
          <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2">
            Order Status & Payment
          </h2>

          <!-- Status -->
          <div>
            <span
              :class="[
                'inline-block px-4 py-2 rounded-full font-semibold text-sm tracking-wide shadow-sm',
                status === 'Delivered' ? 'bg-green-100 text-green-800 shadow-green-300' : '',
                status === 'Processing' ? 'bg-yellow-100 text-yellow-800 shadow-yellow-300' : '',
                status === 'Cancelled' ? 'bg-red-100 text-red-800 shadow-red-300' : '',
                status === 'pending' ? 'bg-red-100 text-red-800 shadow-red-300' : '',
              ]"
            >
              {{ status }}
            </span>
          </div>

          <!-- Payment -->
          <div class="mt-6 text-sm space-y-1 text-gray-700">
            <p><span class="font-semibold">Method:</span> {{ order.payment_method || 'N/A' }}</p>
            <p><span class="font-semibold">Status:</span> {{ order.payment_status || 'N/A' }}</p>
          </div>

          <p class="mt-6 text-xs text-gray-400 font-mono select-text">
            Order ID: {{ order.order_number }}
          </p>
        </section>

        <!-- Price Summary Card -->
        <section
          class="bg-white rounded-xl border border-gray-200 shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
        >
          <h2 class="text-lg font-semibold text-gray-700 mb-5 border-b border-gray-100 pb-2">
            Price Summary
          </h2>
          <div class="text-gray-700 text-sm sm:text-base space-y-3">
            <div class="flex justify-between">
              <span>Subtotal</span>
              <span class="font-medium">{{ order.total_price.toLocaleString() }} TK</span>
            </div>
            <div class="flex justify-between">
              <span>Shipping Fee</span>
              <span class="font-medium">{{ shippingFee.toLocaleString() }} TK</span>
            </div>
            <div class="flex justify-between">
              <span>Tax (5%)</span>
              <span class="font-medium">{{ tax.toFixed(2) }} TK</span>
            </div>
            <div
              class="mt-5 border-t border-gray-300 pt-4 flex justify-between font-extrabold text-indigo-600 text-xl sm:text-2xl"
            >
              <span>Total</span>
              <span>{{ total.toFixed(2) }} TK</span>
            </div>
          </div>
        </section>
      </div>

      <!-- Products List Card -->
      <section
        class="bg-white rounded-xl border border-gray-200 shadow-lg p-6 overflow-hidden hover:shadow-xl transition-shadow duration-300"
      >
        <h2 class="text-lg font-semibold text-gray-700 mb-6 border-b border-gray-100 pb-3">
          Products Ordered
        </h2>
        <ul
          class="divide-y divide-gray-200 max-h-[360px] overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-400 scrollbar-track-gray-100"
        >
          <li
            v-for="(item, i) in order.order_items"
            :key="i"
            class="flex items-center py-4 space-x-5 hover:bg-indigo-50 transition-colors rounded-md cursor-pointer"
          >
            <img
              :src="item.product.image"
              alt="Product Image"
              class="w-16 h-16 rounded-lg object-cover border border-gray-300"
              loading="lazy"
            />
            <div class="flex-1 min-w-0">
              <p class="text-base font-semibold text-gray-900 truncate" :title="item.product.name">
                {{ item.product.name }}
              </p>
              <p class="text-xs text-gray-500 mt-1">Qty: {{ item.quantity }}</p>
            </div>
            <div class="text-right min-w-[110px]">
              <p class="text-base font-semibold text-indigo-600">
                {{
                  ((item.product.price - item.product.discount_price) * item.quantity).toLocaleString()
                }}
                TK
              </p>
              <p
                v-if="item.product.discount_price > 0"
                class="text-xs text-red-500 line-through mt-1"
              >
                {{ (item.product.price * item.quantity).toLocaleString() }} TK
              </p>
            </div>
          </li>
        </ul>
      </section>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/ClientLayout.vue';
import { computed, defineProps } from 'vue';

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
});

// Extract and prepare order data
const orderId = props.order.id;
const orderDate = new Date(props.order.created_at).toLocaleDateString();
const items = props.order.items ?? [];
 
const status = props.order.status ?? 'Pending';

// Optional: fallback if not stored
const shippingFee = 50;

// Calculations
const subtotal = computed(() =>
  items.reduce((sum, item) => {
    const price = item.product.price ?? 0;
    const discount = item.product.discount_price ?? 0;
    return sum + (price - discount) * item.quantity;
  }, 0)
);

const tax = computed(() => subtotal.value * 0.05);
const total = computed(() => subtotal.value + shippingFee + tax.value);
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
  width: 6px;
}
.scrollbar-thin::-webkit-scrollbar-track {
  background: #f3f4f6;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
  background-color: #6366f1;
  border-radius: 10px;
  border: 2px solid #f3f4f6;
}
.scrollbar-thin {
  scrollbar-width: thin;
  scrollbar-color: #6366f1 #f3f4f6;
}
</style>
