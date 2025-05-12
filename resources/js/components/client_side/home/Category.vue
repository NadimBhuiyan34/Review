<template>
  <section class="py-20 px-6 bg-gradient-to-b from-white via-gray-50 to-white">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-14 tracking-tight">
        Shop by <span class="text-blue-600">Category</span>
      </h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-10">
        <div
          v-for="cat in categories"
          :key="cat.name"
          class="relative group rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl border border-gray-100 hover:border-blue-500 bg-white backdrop-blur-md transition-all duration-300"
        >
          <!-- Background Image -->
          <img
            :src="cat.image"
            :alt="cat.name"
            class="w-full h-48 object-cover rounded-3xl group-hover:scale-105 transition-transform duration-300"
          />

          <!-- Overlay Blur Effect -->
          <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition duration-300 rounded-3xl"></div>

          <!-- Category Name -->
          <div class="absolute inset-0 flex flex-col items-center justify-center z-10 text-center px-2">
            <h3
              class="text-white text-lg sm:text-xl font-semibold group-hover:scale-110 transition-transform"
            >
              {{ cat.name }}
            </h3>
            <span class="mt-1 text-sm text-gray-200 group-hover:text-white opacity-80">
              Explore Now →
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  categories: {
    type: Array,
    required: true,
  },
})
</script>
