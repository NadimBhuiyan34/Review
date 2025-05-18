<template>

  <Head title="Cart" />
  <AppLayout>
    <div class="max-w-[1400px] mx-auto my-5 bg-gray-50">


      <div class="px-10 py-12 bg-red-50 ">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
          🛍️ Your Shopping Cart
        </h1>

        <!-- Cart Items -->
        <div v-if="cartItems.length" class="bg-white rounded-2xl shadow-md divide-y divide-gray-100 overflow-hidden">
          <div v-for="(item, index) in cartItems" :key="item.id"
            class="group flex flex-col sm:flex-row justify-between items-center p-6 hover:bg-gray-50 transition">
            <!-- Product Info -->
            <div class="flex items-center gap-5 w-full sm:w-1/2">
              <img :src="`/storage/${item.image}`" :alt="item.name"
                class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm group-hover:scale-105 transition-transform duration-200" />
              <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ item.name }}</h2>
                <p class="text-sm text-gray-500 mt-1">Price: {{ formatCurrency((item.price - item.discount_price)) }}
                </p>
              </div>
            </div>

            <!-- Quantity Control -->
            <div class="flex items-center mt-5 sm:mt-0 gap-2">
              <button @click="updateQuantity(item.id, item.quantity - 1, index)"
                :disabled="item.quantity <= 1 || loading[index]"
                class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-lg font-bold rounded-md disabled:opacity-50">-</button>
              <div class="px-4 py-1.5 bg-gray-100 text-center font-medium min-w-[40px] rounded-md">
                {{ item.quantity }}
              </div>
              <button @click="updateQuantity(item.id, item.quantity + 1, index)" :disabled="loading[index]"
                class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-lg font-bold rounded-md disabled:opacity-50">+</button>
            </div>

            <!-- Subtotal -->
            <div class="text-right mt-4 sm:mt-0 text-lg font-bold text-gray-700 w-full sm:w-auto">
              {{ formatCurrency((item.price - item.discount_price) * item.quantity) }}

            </div>

            <!-- Delete Button -->
            <button @click="deleteItem(item.id, index)" :disabled="loading[index]"
              class="mt-4 sm:mt-0 ml-4 text-red-600 hover:text-red-800 font-bold text-sm sm:text-base"
              title="Remove item">
              🗑️ Remove
            </button>
          </div>
        </div>

        <!-- Empty Cart Message -->
        <div v-else class="bg-white p-10 text-center rounded-xl shadow-sm text-gray-500 text-xl font-semibold">
          🛒 Your cart is empty!
        </div>

        <!-- Summary & Checkout -->
        <div v-if="cartItems.length"
          class="mt-10 bg-gradient-to-br from-gray-50 to-gray-100 p-8 rounded-2xl shadow-sm flex flex-col sm:flex-row justify-between items-center">
          <div class="text-2xl font-extrabold text-gray-900">
            Total: {{ formatCurrency(cartTotal) }}
          </div>
          <Link :href="route('orders.index')"
            class="mt-5 sm:mt-0 px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-full shadow-lg transition duration-300">
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
import { ref, computed, defineProps, watch } from 'vue';

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
  }
);

// Format currency (e.g., "1,000 TK")
const formatCurrency = (amount) => `${amount.toLocaleString()} TK`;

// Compute total cart price
const cartTotal = computed(() =>
  cartItems.value.reduce(
    (sum, item) => sum + (item.price - item.discount_price) * item.quantity,
    0
  )
);


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
    }
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
