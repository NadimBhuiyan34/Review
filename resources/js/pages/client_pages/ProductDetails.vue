<script setup>
import AppLayout from '@/layouts/ClientLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const mainImage = ref(props.product.image || props.product.images[0])

function changeMainImage(img) {
  mainImage.value = img
}
</script>

<template>
  <Head :title="product.name" />

  <AppLayout>
    <div
      class="min-h-screen bg-gradient-to-tr from-gray-100 via-gray-200 to-gray-100 py-16 px-6 sm:px-12 lg:px-24 flex justify-center items-center">
      <div class="max-w-6xl w-full bg-white rounded-3xl shadow-xl p-10 flex flex-col lg:flex-row gap-12 text-gray-900">
        <!-- Left: Images -->
        <div class="lg:w-1/2 flex flex-col gap-6">
          <div
            class="rounded-2xl overflow-hidden border border-gray-200 transition-shadow duration-400 cursor-pointer hover:shadow-md">
            <img :src="mainImage" alt="Main Product Image"
              class="w-full h-[520px] object-cover rounded-2xl transition-transform duration-300 hover:scale-105" />
          </div>

          <div class="flex gap-4 justify-center lg:justify-start">
            <button v-for="(img, idx) in product.images" :key="idx" @click="changeMainImage(img)" :class="[ 
              'w-20 h-20 rounded-lg bg-gray-100 border border-gray-300 transition-all duration-200 overflow-hidden',
              mainImage === img ? 'border-gray-800 scale-105' : '' 
            ]">
              <img :src="img" alt="Thumbnail" class="w-full h-full object-cover" />
            </button>
          </div>
        </div>

        <!-- Right: Product Info -->
        <div class="lg:w-1/2 flex flex-col justify-between">
          <div>
            <h1 class="text-4xl font-bold mb-4">
              {{ product.name }}
            </h1>

            <p class="text-sm text-gray-500 font-medium uppercase tracking-wider mb-3">
              Men's Fashion • Awesome Brand
            </p>

            <div class="flex items-center gap-4 text-2xl font-semibold mb-5">
              <span class="text-gray-900">${{ product.price.toFixed(2) }}</span>
              <span class="line-through text-gray-400 text-lg font-normal">${{ product.discount_price.toFixed(2) }}</span>
              <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">
                Save {{ Math.round((1 - product.price / product.discount_price) * 100) }}%
              </span>
            </div>

            <div class="flex gap-2 mb-6 flex-wrap">
              <span class="bg-gray-200 text-gray-700 text-xs font-medium px-3 py-1 rounded-full uppercase">
                New Arrival
              </span>
              <span class="bg-red-100 text-red-700 text-xs font-medium px-3 py-1 rounded-full uppercase">
                Sale
              </span>
              <span class="bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 rounded-full uppercase">
                Summer Collection
              </span>
            </div>

            <p class="text-gray-700 leading-relaxed text-base mb-8">
              {{ product.description }}
            </p>

            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-semibold mb-4">Specifications</h3>
              <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3 text-sm text-gray-600">
                <li><strong class="text-gray-800">Color:</strong> {{ product.specifications.Color }}</li>
                <li><strong class="text-gray-800">Size:</strong> {{ product.specifications.Size }}</li>
                <li><strong class="text-gray-800">Material:</strong> {{ product.specifications.Material }}</li>
                <li><strong class="text-gray-800">Weight:</strong> 1.2 kg</li>
                <li><strong class="text-gray-800">Dimensions:</strong> 10 x 5 x 3 (L x W x H)</li>
              </ul>
            </div>
          </div>

          <div class="mt-10 flex flex-col sm:flex-row items-center gap-4">
            <button
              class="bg-gray-900 hover:bg-gray-800 text-white font-semibold px-8 py-3 rounded-lg transition-colors duration-200 w-full sm:w-auto">
              Add to Cart
            </button>
            <p class="text-sm text-gray-600 select-none">
              <span class="font-medium text-gray-800">In stock:</span> 20
            </p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
