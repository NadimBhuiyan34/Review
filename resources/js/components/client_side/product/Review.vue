<template>
  <div class="max-w-[1550px] mx-auto  mb-5">
    <div class="mx-auto shadow-lg space-y-10 px-6 py-10">

      <!-- Title -->
      <h1 class="text-3xl font-bold tracking-tight text-gray-800">Customer Reviews</h1>

      <!-- Give Review Button -->
      <div class="text-right">
        <button @click="showForm = !showForm"
          class="rounded-full bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
          {{ showForm ? 'Close Review Form' : 'Give Review' }}
        </button>
      </div>

      <!-- Review Form -->
      <div v-if="showForm" class="rounded-2xl bg-white p-6 shadow-md space-y-6">
        <h2 class="text-xl font-semibold text-gray-700">Write a Review</h2>
        <form @submit.prevent="submitReview" class="space-y-4">


          <div>
            <label class="block text-sm font-medium text-gray-700">Your Review</label>
            <textarea v-model="form.comment" rows="4"
              class="mt-1 w-full rounded-lg border border-gray-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              required></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
            <div class="flex items-center space-x-1">
              <template v-for="i in 5" :key="i">
                <svg @click="form.rating = i" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                  class="h-6 w-6 cursor-pointer transition hover:scale-110"
                  :class="form.rating >= i ? 'text-yellow-400' : 'text-gray-300'">
                  <path
                    d="M12 .587l3.668 7.57 8.332 1.151-6.064 5.818 1.432 8.274L12 18.896l-7.368 4.504 1.432-8.274-6.064-5.818 8.332-1.151z" />
                </svg>
              </template>
            </div>
          </div>

          <div>
            <button type="submit"
              class="inline-flex items-center rounded-full bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
              Submit Review
            </button>
          </div>
        </form>
      </div>

      <!-- Sentiment Summary -->
      <div class="space-y-4 rounded-2xl bg-white p-6 shadow-md">
        <h2 class="text-xl font-semibold text-gray-700">Sentiment Overview</h2>
        <div v-for="(value, label) in sentimentSummary" :key="label">
          <div class="mb-1 flex justify-between text-sm text-gray-500">
            <span>{{ label }} ({{ value }}%)</span>
            <span>{{ value }}%</span>
          </div>
          <div class="h-3 w-full overflow-hidden rounded-full" :class="{
            'bg-green-100': label === 'Good',
            'bg-yellow-100': label === 'Neutral',
            'bg-red-100': label === 'Bad',
          }">
            <div class="h-full rounded-full transition-all duration-500" :class="{
              'bg-green-500': label === 'Good',
              'bg-yellow-500': label === 'Neutral',
              'bg-red-500': label === 'Bad',
            }" :style="{ width: value + '%' }"></div>
          </div>
        </div>
      </div>

      <!-- Filter Buttons -->
      <div class="flex flex-wrap gap-3">
        <button v-for="option in filters" :key="option" @click="selectedFilter = option" :class="['flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition',
          selectedFilter === option
            ? 'bg-blue-600 text-white shadow'
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200']">
          <span :class="{
            'text-green-500': option === 'Good',
            'text-yellow-500': option === 'Neutral',
            'text-red-500': option === 'Bad',
            'text-blue-500': option === 'All',
          }">
            ●
          </span>
          {{ option }}
        </button>
      </div>

      <!-- Review List -->
      <div class="space-y-4 rounded-2xl bg-gray-100 p-6 shadow-md">
        <h2 class="text-xl font-semibold text-gray-700">
          Reviews
          <span class="text-sm text-gray-500">({{ selectedFilter }})</span>
        </h2>
        <div v-if="filteredReviews.length" class="grid gap-4 md:grid-cols-2">
          <div v-for="(review, index) in filteredReviews" :key="index"
            class="rounded-xl border border-gray-100 p-4 transition hover:shadow-md bg-white">
            <div class="mb-2 flex items-center justify-between">
              <span class="font-semibold text-gray-800">{{ review.user.name }}</span>
              <div>
                <span class="text-yellow-400">
                  <template v-for="i in 5" :key="i">
                    <span v-if="i <= review.rating">★</span>
                    <span v-else class="text-gray-300">★</span>
                  </template>
                </span>
                <span class="font-semibold text-gray-800">{{ review.rating }}</span>
              </div>

              <span :class="{
                'text-green-600': review.sentiment_type === 'Positive',
                'text-yellow-500': review.sentiment_type === 'Neutral',
                'text-red-600': review.sentiment_type === 'Negative',
              }" class="text-sm font-medium">
                {{ review.sentiment_type }}
              </span>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
              {{ review.comment }}
            </p>
          </div>
        </div>
        <div v-else class="text-center text-sm text-gray-400 py-6">
          No reviews found for this category.
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const props = defineProps({
  reviews: Array,
  product_id: String,
  product_slug: String
})

const showForm = ref(false)
const filters = ['All', 'Positive', 'Neutral', 'Negative']
const selectedFilter = ref('All')

// Reactive reviews list
const reviews = ref([...props.reviews])

const form = ref({

  product_id: props.product_id,
  slug: props.product_slug,
  comment: '',
  rating: 0
})

const submitReview = () => {
  if (!form.value.comment || form.value.rating === 0) return

  router.post(route('reviews.store'), form.value, {
    preserveScroll: true,
    onSuccess: () => {
      // Reload the full page after successful submission
      window.location.reload()
    }
  })
}


const filteredReviews = computed(() => {
  if (selectedFilter.value === 'All') return reviews.value
  return reviews.value.filter(r => r.sentiment_type === selectedFilter.value)
})

const sentimentSummary = computed(() => {
  const total = reviews.value.length
  const counts = {
    Good: reviews.value.filter(r => r.sentiment_type === 'Positive').length,
    Neutral: reviews.value.filter(r => r.sentiment_type === 'Neutral').length,
    Bad: reviews.value.filter(r => r.sentiment_type === 'Negative').length
  }

  return {
    Good: total ? Math.round((counts.Good / total) * 100) : 0,
    Neutral: total ? Math.round((counts.Neutral / total) * 100) : 0,
    Bad: total ? Math.round((counts.Bad / total) * 100) : 0
  }
})
</script>
