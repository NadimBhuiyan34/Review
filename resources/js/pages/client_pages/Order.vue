<template>
  <Head title="Checkout" />
  <AppLayout>
    <div class="px-4 py-10 sm:px-6 lg:px-8 max-w-[1400px] mx-auto my-5">
      <div class="mx-auto ">
        <!-- STEP 1: Order Summary -->
        <div v-if="step === 'summary'" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
          <!-- <h2 class="mb-5 text-center items-center gap-2 text-xl font-semibold text-green-700"></h2> -->
            <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
          🛒 Order Summary
        </h1>
          <div class="scrollbar-thin scrollbar-thumb-gray-300 max-h-64 space-y-4 overflow-y-auto pr-1">
            <div
              v-for="(item, index) in cartItems"
              :key="index"
              class="flex items-start justify-between border-b pb-3 last:border-b-0"
            >
              <div class="text-sm text-gray-700">
                <p class="font-medium">{{ item.product.name }}</p>
                <p class="text-xs text-gray-500">Qty: {{ item.quantity }}</p>
              </div>
              <p class="text-sm font-semibold text-gray-900">
                {{ (item.product.price - item.product.discount_price) * item.quantity }} TK
              </p>
            </div>
          </div>

          <div class="mt-6 flex justify-between border-t pt-4 text-base font-semibold text-gray-800">
            <span>Total:</span>
            <span class="text-red-600">{{ cartTotal }} TK</span>
          </div>
          <hr class="my-4">

          <div class="mt-6 text-right">
            <button
              @click="step = 'shipping'"
              class="mt-5 sm:mt-0 px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-full shadow-lg transition duration-300"
            >
              📝 Proceed to Shipping
            </button>
          </div>
        </div>

        <!-- STEP 2: Shipping Form -->
        <div v-else-if="step === 'shipping'" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
          <!-- <h2 class="mb-5 text-center items-center gap-2 text-xl font-semibold text-blue-700">📦 Shipping Information</h2> -->
              <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
          📦 Shipping Information
        </h1>
          
          <form @submit.prevent="placeOrder" class="space-y-5" novalidate>
            <!-- Full Name -->
            <div>
              <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Full Name</label>
              <input
                id="name"
                type="text"
                v-model="form.name"
                :aria-invalid="form.errors.name ? 'true' : 'false'"
                :aria-describedby="form.errors.name ? 'name-error' : null"
                class="w-full rounded-md border border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
              />
              <p v-if="form.errors.name" id="name-error" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <!-- Phone Number -->
            <div>
              <label for="phone" class="mb-1 block text-sm font-medium text-gray-700">Phone Number</label>
              <input
                id="phone"
                type="text"
                v-model="form.phone"
                :aria-invalid="form.errors.phone ? 'true' : 'false'"
                :aria-describedby="form.errors.phone ? 'phone-error' : null"
                class="w-full rounded-md border border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
              />
              <p v-if="form.errors.phone" id="phone-error" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</p>
            </div>

            <!-- City -->
            <div>
              <label for="city" class="mb-1 block text-sm font-medium text-gray-700">City</label>
              <input
                id="city"
                type="text"
                v-model="form.city"
                :aria-invalid="form.errors.city ? 'true' : 'false'"
                :aria-describedby="form.errors.city ? 'city-error' : null"
                class="w-full rounded-md border border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
              />
              <p v-if="form.errors.city" id="city-error" class="mt-1 text-sm text-red-600">{{ form.errors.city }}</p>
            </div>

            <!-- Postal Code -->
            <div>
              <label for="postal_code" class="mb-1 block text-sm font-medium text-gray-700">Postal Code</label>
              <input
                id="postal_code"
                type="text"
                v-model="form.postal_code"
                :aria-invalid="form.errors.postal_code ? 'true' : 'false'"
                :aria-describedby="form.errors.postal_code ? 'postal_code-error' : null"
                class="w-full rounded-md border border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
              />
              <p v-if="form.errors.postal_code" id="postal_code-error" class="mt-1 text-sm text-red-600">{{ form.errors.postal_code }}</p>
            </div>

            <!-- Shipping Address -->
            <div>
              <label for="address" class="mb-1 block text-sm font-medium text-gray-700">Shipping Address</label>
              <textarea
                id="address"
                rows="3"
                v-model="form.address"
                :aria-invalid="form.errors.address ? 'true' : 'false'"
                :aria-describedby="form.errors.address ? 'address-error' : null"
                class="w-full rounded-md border border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
              ></textarea>
              <p v-if="form.errors.address" id="address-error" class="mt-1 text-sm text-red-600">{{ form.errors.address }}</p>
            </div>

            <!-- Payment Method -->
            <div>
              <label for="payment_method" class="mb-1 block text-sm font-medium text-gray-700">💳 Payment Method</label>
              <select
                id="payment_method"
                v-model="form.payment_method"
                :aria-invalid="form.errors.payment_method ? 'true' : 'false'"
                :aria-describedby="form.errors.payment_method ? 'payment_method-error' : null"
                class="w-full rounded-md border border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
              >
                <option disabled value="">Select a payment method</option>
                <option value="cod">Cash on Delivery</option>
                <option value="card">Credit/Debit Card</option>
                <option value="bkash">bKash</option>
              </select>
              <p v-if="form.errors.payment_method" id="payment_method-error" class="mt-1 text-sm text-red-600">{{ form.errors.payment_method }}</p>
            </div>

            <div class="mt-6 flex items-center justify-between">
              <button
                @click.prevent="step = 'summary'"
                type="button"
                class="rounded-full border border-gray-400 px-6 py-3 font-semibold text-gray-700  hover:bg-gray-100"
              >
                ⬅️ Back to Summary
              </button>

              <button
                type="submit"
                class="mt-5 sm:mt-0 px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-full shadow-lg transition duration-300"
                :disabled="form.processing"
              >
                ✅ Place Order
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/ClientLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
  cartItems: Array,
  totalPrice: Number,
});

// Step state
const step = ref('summary'); // 'summary' or 'shipping'

// Form setup
const form = useForm({
  name: '',
  city: '',
  address: '',
  postal_code: '',
  phone: '',
  payment_method: '',
  cart: props.cartItems,
  total: props.totalPrice,
});

// Total calculation
const cartTotal = computed(() =>
  props.cartItems.reduce(
    (sum, item) =>
      sum + (item.product.price - item.product.discount_price) * item.quantity,
    0
  )
);

// Order submission
const placeOrder = () => {
  form.post(route('orders.store'), {
    onSuccess: () => {
      alert('Order placed!');
      form.reset();
      step.value = 'summary'; // or redirect as needed
    },
    onError: () => {
      
    },
  });
};
</script>

<style scoped>
/* Optional scrollbar style */
.scrollbar-thin::-webkit-scrollbar {
  width: 6px;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
  background-color: #d1d5db;
  border-radius: 3px;
}
</style>
