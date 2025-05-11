<script setup lang="ts">
import Header from '@/components/client_side/layout/Header.vue'
import Footer from '@/components/client_side/layout/Footer.vue'
 

 
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <Header />

    <!-- Page Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>
