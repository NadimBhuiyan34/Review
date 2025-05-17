<template>
  <AppLayout>
    <Head title="Card Payment" />

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-600 px-4">
      <div
        class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 space-y-6"
      >
        <h1 class="text-3xl font-extrabold text-indigo-700 text-center mb-6">
          💳 Credit / Debit Card Payment
        </h1>

        <form @submit.prevent="submitPayment" class="space-y-5">
          <!-- Cardholder Name -->
          <div>
            <label for="cardName" class="block text-gray-700 font-semibold mb-1">Cardholder Name</label>
            <input
              v-model="cardName"
              id="cardName"
              type="text"
              placeholder="John Doe"
              required
              class="w-full px-4 py-3 border border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
            />
          </div>

          <!-- Card Number -->
          <div>
            <label for="cardNumber" class="block text-gray-700 font-semibold mb-1">Card Number</label>
            <input
              v-model="cardNumber"
              id="cardNumber"
              type="text"
              placeholder="1234 5678 9012 3456"
              maxlength="19"
              @input="formatCardNumber"
              required
              class="w-full px-4 py-3 border border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
            />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <!-- Expiry Date -->
            <div>
              <label for="expiryDate" class="block text-gray-700 font-semibold mb-1">Expiry Date</label>
              <input
                v-model="expiryDate"
                id="expiryDate"
                type="text"
                placeholder="MM/YY"
                maxlength="5"
                @input="formatExpiryDate"
                required
                class="w-full px-4 py-3 border border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
              />
            </div>

            <!-- CVV -->
            <div>
              <label for="cvv" class="block text-gray-700 font-semibold mb-1">CVV</label>
              <input
                v-model="cvv"
                id="cvv"
                type="password"
                placeholder="123"
                maxlength="4"
                required
                class="w-full px-4 py-3 border border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
              />
            </div>
          </div>

          <button
            type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-full shadow-lg transition"
          >
            Pay Now
          </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-4">
          Your payment information is processed securely.
        </p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/ClientLayout.vue';

const cardName = ref('');
const cardNumber = ref('');
const expiryDate = ref('');
const cvv = ref('');

// Format card number as "1234 5678 9012 3456"
function formatCardNumber() {
  let digits = cardNumber.value.replace(/\D/g, '').substring(0, 16);
  let formatted = digits.match(/.{1,4}/g)?.join(' ') || '';
  cardNumber.value = formatted;
}

// Format expiry date as "MM/YY"
function formatExpiryDate() {
  let digits = expiryDate.value.replace(/\D/g, '').substring(0, 4);
  if (digits.length >= 3) {
    expiryDate.value = digits.substring(0, 2) + '/' + digits.substring(2);
  } else {
    expiryDate.value = digits;
  }
}

function submitPayment() {
  if (!cardName.value || !cardNumber.value || !expiryDate.value || !cvv.value) {
    alert('Please fill in all fields.');
    return;
  }

  // Basic validation example: length check
  if (cardNumber.value.replace(/\s/g, '').length !== 16) {
    alert('Invalid card number.');
    return;
  }
  if (!/^\d{2}\/\d{2}$/.test(expiryDate.value)) {
    alert('Expiry date must be in MM/YY format.');
    return;
  }
  if (cvv.value.length < 3 || cvv.value.length > 4) {
    alert('CVV must be 3 or 4 digits.');
    return;
  }

  alert(`Payment successful!\nCardholder: ${cardName.value}`);
  // Reset form
  cardName.value = '';
  cardNumber.value = '';
  expiryDate.value = '';
  cvv.value = '';
}
</script>
