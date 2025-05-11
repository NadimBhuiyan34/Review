<script setup lang="ts">
import AppLayout from '@/layouts/client_layout/AppLayout.vue';
import { Head } from "@inertiajs/vue3";
import Slider from '@/components/client_side/layout/Slider.vue';

// Example slider data (dynamically loaded or static for now)
const dynamicProducts = [
  {
    name: 'Product 1',
    description: 'This is a great product',
    price: '$49.99',
    image: 'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/627ab1121502531.60c775945f4bf.png',
  },
  {
    name: 'Product 2',
    description: 'Another awesome product',
    price: '$69.99',
    image: 'https://via.placeholder.com/800x400?text=Product+2',
  },
  {
    name: 'Product 3',
    description: 'Will make your life easier',
    price: '$89.99',
    image: 'https://via.placeholder.com/800x400?text=Product+3',
  },
];
</script>

<template>
  <Head title="Home" />

  <AppLayout>
    <section class="max-w-7xl mx-auto py-8 px-4">
      <!-- Product Slider -->
      <Slider :sliders="dynamicProducts" />
    </section>
  </AppLayout>
</template>
