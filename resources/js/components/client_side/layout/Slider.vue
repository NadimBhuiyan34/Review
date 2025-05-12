<template>
  <div class="relative w-full" id="default-carousel" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
      <!-- Dynamically rendered carousel items -->
      <div
        v-for="(product, index) in sliders"
        :key="index"
        class="duration-700 ease-in-out transition-all"
        :class="{ 'block': index === activeIndex, 'hidden': index !== activeIndex }"
        data-carousel-item
      >
        <img
          :src="product.image"
          class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
          alt="Product Image"
        />
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-center text-white">
          <h3 class="text-xl font-semibold">{{ product.name }}</h3>
          <p class="text-lg">{{ product.description }}</p>
          <span class="text-lg">{{ product.price }}</span>
        </div>
      </div>
    </div>

    <!-- Slider Indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
      <button
        v-for="(product, index) in sliders"
        :key="index"
        class="w-3 h-3 rounded-full bg-white/70"
        :class="{ 'bg-blue-500': index === activeIndex }"
        @click="goToSlide(index)"
        aria-label="'Slide ' + (index + 1)"
      />
    </div>

    <!-- Previous and Next buttons -->
    <button
      type="button"
      class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      @click="prevSlide"
    >
      <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50">
        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10">
          <path d="M5 1 1 5l4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        </svg>
        <span class="sr-only">Previous</span>
      </span>
    </button>

    <button
      type="button"
      class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      @click="nextSlide"
    >
      <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50">
        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10">
          <path d="m1 9 4-4-4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        </svg>
        <span class="sr-only">Next</span>
      </span>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  sliders: {
    type: Array,
    required: true,
  },
})

const activeIndex = ref(0)

let slideInterval = null

// Go to the next slide
function nextSlide() {
  activeIndex.value = (activeIndex.value + 1) % props.sliders.length
}

// Go to the previous slide
function prevSlide() {
  activeIndex.value = (activeIndex.value - 1 + props.sliders.length) % props.sliders.length
}

// Go to a specific slide
function goToSlide(index) {
  activeIndex.value = index
}

// Start the auto-slide functionality
function startAutoSlide() {
  slideInterval = setInterval(() => {
    nextSlide()
  }, 3000) // Change slide every 3 seconds
}

// Stop the auto-slide when the component is unmounted
onBeforeUnmount(() => {
  if (slideInterval) {
    clearInterval(slideInterval)
  }
})

// Start auto-sliding once the component is mounted
onMounted(() => {
  startAutoSlide()
})
</script>
