<template>
  <div class="w-full relative">
    <!-- Desktop vertical slider -->
    <div class="hidden sm:flex max-h-[40rem] swiper-container overflow-hidden">
      <Swiper
        :modules="modules"
        :direction="'vertical'"
        :loop="true"
        :autoplay="{ delay: 5000, disableOnInteraction: false }"
        :navigation="{
          prevEl: `.custom-prev-${id}`,
          nextEl: `.custom-next-${id}`
        }"
        :slides-per-view="1"
        class="w-full rounded-xl"
      >
        <SwiperSlide v-for="(slide, index) in slides" :key="index">
          <HeroCarouselCard :slide="slide" />
        </SwiperSlide>
      </Swiper>
    </div>

    <!-- Mobile horizontal slider -->
    <div class="sm:hidden h-[60vh] swiper-container overflow-hidden">
      <Swiper
        :modules="modules"
        :loop="true"
        :autoplay="{ delay: 5000, disableOnInteraction: false }"
        :navigation="{
          prevEl: `.custom-prev-${id}`,
          nextEl: `.custom-next-${id}`
        }"
        :slides-per-view="1"
        class="w-full"
      >
        <SwiperSlide v-for="(slide, index) in slides" :key="index">
          <HeroCarouselCard :slide="slide" />
        </SwiperSlide>
      </Swiper>
    </div>

    <!-- Overlay Content -->
    <div class="absolute top-0 left-0 w-full h-full z-30 flex flex-col justify-center">
      <div class="sm:w-4/5 p-6 sm:px-24 bg-gradient-to-r from-black/40 to-transparent text-white">
        <h1 class="text-3xl sm:text-5xl font-bold">Department of {{ dept_name }}</h1>
        <p class="mt-2 text-lg sm:text-xl">Explore more about our department</p>
        <div class="mt-4">
          <button class="bg-white text-black px-4 py-2 rounded shadow">Learn More</button>
        </div>
      </div>
    </div>

    <!-- Navigation Arrows -->
    <div class="hidden sm:flex flex-col absolute top-0 right-10 h-full justify-between py-36 z-30">
      <button :class="`custom-prev-${id} p-2 bg-white/30 rounded-full`">
        <ChevronDownIcon class="w-6 h-6 rotate-180 text-white" />
      </button>
      <button :class="`custom-next-${id} p-2 bg-white/30 rounded-full`">
        <ChevronDownIcon class="w-6 h-6 text-white" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

// import HeroCarouselCard from './HeroCarouselCard.vue';
import HeroCarouselCard from '@/components/client_side/layout/SliderCard.vue';
import { ChevronDownIcon } from '@heroicons/vue/24/outline';

const modules = [Autoplay, Pagination, Navigation];
const id = Math.random().toString(36).substring(2, 9);

defineProps({
  dept_name: {
    type: String,
    required: true
  },
  slides: {
    type: Array,
    required: true
  }
});
</script>

<style scoped>
.swiper-button-prev,
.swiper-button-next {
  color: white;
}
</style>
