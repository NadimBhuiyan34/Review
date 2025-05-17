<template>
  <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Customer Reviews</h2>

    <!-- Sentiment Summary -->
    <div class="flex justify-around mb-8">
      <div class="text-center">
        <p class="text-green-600 text-4xl font-extrabold">{{ sentimentCounts.good }}</p>
        <p class="text-green-600 font-semibold">Good</p>
      </div>
      <div class="text-center">
        <p class="text-yellow-500 text-4xl font-extrabold">{{ sentimentCounts.neutral }}</p>
        <p class="text-yellow-500 font-semibold">Neutral</p>
      </div>
      <div class="text-center">
        <p class="text-red-600 text-4xl font-extrabold">{{ sentimentCounts.bad }}</p>
        <p class="text-red-600 font-semibold">Bad</p>
      </div>
    </div>

    <!-- Sentiment Chart -->
    <div class="mb-10 space-y-4">
      <div v-for="(count, sentiment) in sentimentCounts" :key="sentiment" class="flex items-center space-x-3">
        <span
          :class="{
            'bg-green-500': sentiment === 'good',
            'bg-yellow-400': sentiment === 'neutral',
            'bg-red-500': sentiment === 'bad',
          }"
          class="w-6 h-6 rounded-full flex-shrink-0"
        ></span>
        <div class="flex-grow bg-gray-200 rounded-full h-6">
          <div
            :style="{ width: calculateWidth(count) + '%' }"
            :class="{
              'bg-green-500': sentiment === 'good',
              'bg-yellow-400': sentiment === 'neutral',
              'bg-red-500': sentiment === 'bad',
            }"
            class="h-6 rounded-full transition-width duration-500"
          ></div>
        </div>
        <span class="w-12 text-right font-semibold text-gray-700">{{ count }}</span>
      </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-6">
      <div
        v-for="(review, index) in reviews"
        :key="index"
        class="p-5 border rounded-lg shadow-sm hover:shadow-md transition"
      >
        <div class="flex justify-between items-center mb-2">
          <p class="font-semibold text-gray-900">{{ review.author }}</p>
          <span
            :class="{
              'bg-green-100 text-green-700': review.sentiment === 'good',
              'bg-yellow-100 text-yellow-700': review.sentiment === 'neutral',
              'bg-red-100 text-red-700': review.sentiment === 'bad',
            }"
            class="px-3 py-1 rounded-full font-semibold text-sm"
          >
            {{ review.sentiment.toUpperCase() }}
          </span>
        </div>
        <p class="text-gray-700">{{ review.text }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Example review data with sentiments
const reviews = ref([
  { author: 'Alice', sentiment: 'good', text: 'Excellent service and quality!' },
  { author: 'Bob', sentiment: 'neutral', text: 'It was okay, nothing special.' },
  { author: 'Carol', sentiment: 'bad', text: 'Not satisfied with the delivery time.' },
  { author: 'Dave', sentiment: 'good', text: 'Great experience, will order again!' },
  { author: 'Eve', sentiment: 'neutral', text: 'Product arrived as expected.' },
]);

// Count reviews by sentiment
const sentimentCounts = {
  good: reviews.value.filter(r => r.sentiment === 'good').length,
  neutral: reviews.value.filter(r => r.sentiment === 'neutral').length,
  bad: reviews.value.filter(r => r.sentiment === 'bad').length,
};

// Calculate chart bar width (%)
const totalReviews = reviews.value.length;
const calculateWidth = (count) => (totalReviews ? (count / totalReviews) * 100 : 0);
</script>

<style scoped>
.transition-width {
  transition-property: width;
}
</style>
