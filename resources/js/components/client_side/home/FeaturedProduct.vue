<template>
  <section class="bg-gradient-to-b from-white to-gray-50 py-20 px-6">
    <div class="max-w-7xl mx-auto">
      <!-- Section Heading -->
      <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold text-gray-800">
         Featured <span class="text-blue-600">Products</span>
        </h2>
        <p class="mt-2 text-gray-500 text-sm sm:text-base">
          Discover our best picks tailored for you
        </p>
        <div class="mt-4 w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
      </div>

      <!-- Product Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <div
          v-for="product in products"
          :key="product.id"
          class="relative bg-white rounded-3xl border border-gray-200 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden"
        >
          <!-- Image Container -->
          <div class="relative w-full h-48 overflow-hidden">
            <img
              :src="`/storage/${product.images.image_path}`"
              :alt="product.name"
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
            <!-- Optional Badge -->
            <span
              v-if="product.badge"
              class="absolute top-3 right-3 bg-red-600 text-white text-xs px-2 py-1 rounded-full shadow-md z-10"
            >
              {{ product.badge }}
            </span>
          </div>

          <!-- Product Name Header -->
          <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 font-semibold text-sm tracking-wide">
            {{ product.name }}
          </div>

          <!-- Product Info -->
          <div class="p-4 space-y-3">
            <p class="text-sm text-gray-600 line-clamp-2 min-h-[40px]">
              {{ product.description }}
            </p>
            <div class="flex items-center justify-between pt-2">
              <span class="text-lg font-bold text-blue-600">{{ product.price }}</span>
              <button
                class="flex items-center gap-1 bg-blue-600 text-white text-xs sm:text-sm px-4 py-2 rounded-full hover:bg-blue-700 transition-all shadow"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6H19m-9 0a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z" />
                </svg>
                Buy
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  products: {
    type: Array,
    required: true,
  },
})
</script>
