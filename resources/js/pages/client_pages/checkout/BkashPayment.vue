<template>
  <AppLayout>
    <Head title="bKash Payment" />

    <div class="min-h-screen max-w-[1550px] mx-auto flex items-center justify-center bg-gradient-to-r from-pink-300 via-pink-400 to-pink-500 px-4">
      <div
        class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 space-y-6"
      >
        <h1 class="text-4xl font-extrabold text-pink-600 flex items-center justify-center gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.1 0-2 .9-2 2 0 .72.38 1.35.95 1.7v1.1a2 2 0 11-1 0v-1.1a2.99 2.99 0 110-3.4v-.2a1 1 0 012 0v.2z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12h.01M12 18a6 6 0 100-12 6 6 0 000 12z" />
          </svg>
          Pay with bKash
        </h1>

        <p class="text-center text-gray-600 font-medium">
          Please complete your payment by sending the amount to the number below.
        </p>

        <!-- bKash Number Card -->
        <div class="bg-pink-50 border border-pink-300 rounded-xl p-5 text-center">
          <p class="text-lg font-semibold text-pink-700 mb-1">Send Payment To</p>
          <p class="text-2xl font-extrabold tracking-wide text-pink-800">+880 1711 123456</p>
          <p class="text-sm text-pink-600 mt-2 italic">bKash Personal Number</p>
        </div>

        <form @submit.prevent="submitPayment" class="space-y-5 mt-6">
          <div>
            <label for="bkashNumber" class="block text-gray-700 font-semibold mb-1">Your bKash Number</label>
            <input
              v-model="bkashNumber"
              id="bkashNumber"
              type="tel"
              placeholder="e.g. 017XXXXXXXX"
              required
              class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
            />
          </div>

          <div>
            <label for="transactionId" class="block text-gray-700 font-semibold mb-1">Transaction ID</label>
            <input
              v-model="transactionId"
              id="transactionId"
              type="text"
              placeholder="Enter your payment transaction ID"
              required
              class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
            />
          </div>

          <button
            type="submit"
            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-full shadow-lg transition"
          >
            Confirm Payment
          </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
          After payment, please keep the transaction ID safe for verification.
        </p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/ClientLayout.vue';

const bkashNumber = ref('');
const transactionId = ref('');

function submitPayment() {
  if (!bkashNumber.value || !transactionId.value) {
    alert('Please fill in all fields.');
    return;
  }

  // Simulate form submission or add your backend call here
  alert(`Payment submitted!\nNumber: ${bkashNumber.value}\nTransaction ID: ${transactionId.value}`);

  // Reset form
  bkashNumber.value = '';
  transactionId.value = '';
}
</script>
