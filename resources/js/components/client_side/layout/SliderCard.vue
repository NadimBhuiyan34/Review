<template>
  <div class="w-full h-full bg-cover bg-center relative" :style="{ backgroundImage: `url(${slide.image})` }">
    <div class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-white text-center px-4">
      <h2 class="text-2xl sm:text-4xl font-bold mb-2">{{ slide.title }}</h2>
      <p class="text-base sm:text-lg">{{ slide.content }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  slide: {
    type: Object,
    required: true
  }
});
</script>
