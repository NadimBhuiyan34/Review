<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const mobileMenuOpen = ref(false)
const categoryOpen = ref(false)
</script>

<template>
  <header class="bg-white shadow sticky top-0 z-50 border-b">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Logo -->
      <Link href="/" class="text-3xl font-extrabold text-blue-600 tracking-tight">
        <span class="bg-gradient-to-r from-blue-700 to-purple-500 bg-clip-text text-transparent">Review</span><span class="text-red-500">Hub</span>
      </Link>

      <!-- Search (centered in desktop) -->
      <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
        <input
          type="text"
          placeholder="Search for products, brands and more"
          class="w-full px-4 py-2 rounded-l-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        />
        <button class="bg-blue-600 px-4 py-2 rounded-r-md text-white hover:bg-blue-700">
          🔍
        </button>
      </div>

      <!-- Icons -->
      <div class="hidden md:flex items-center gap-6">
        <Link :href="route('login')" class="text-gray-600 hover:text-blue-600">Login</Link>
        <Link href="#" class="relative hover:text-blue-600">
          ❤️
          <span class="absolute -top-2 -right-2 text-xs bg-red-500 text-white px-1 rounded-full">3</span>
        </Link>
        <Link href="#" class="relative hover:text-blue-600">
          🛒
          <span class="absolute -top-2 -right-2 text-xs bg-red-500 text-white px-1 rounded-full">2</span>
        </Link>
      </div>

      <!-- Mobile menu button -->
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-2xl text-gray-600">
        ☰
      </button>
    </div>

    <!-- Navigation -->
    <nav class="bg-gray-50 border-t hidden md:block">
      <div class="container mx-auto px-4 py-2 flex items-center gap-6 text-sm font-medium text-gray-700">
        <Link href="#" class="hover:text-blue-600">Home</Link>
        <Link href="#" class="hover:text-blue-600">Shop</Link>
        <Link href="#" class="hover:text-blue-600">Deals</Link>
        <Link href="#" class="hover:text-blue-600">About</Link>

        <!-- Categories Dropdown -->
        <div class="relative group">
          <button class="hover:text-blue-600">Categories ▼</button>
          <div class="absolute hidden group-hover:block bg-white border mt-2 w-48 shadow-lg z-10">
            <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Electronics</Link>
            <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Home & Living</Link>
            <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Fashion</Link>
            <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Health & Beauty</Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Mobile Menu -->
    <transition name="slide-fade">
      <div v-if="mobileMenuOpen" class="md:hidden bg-white border-t p-4 space-y-3">
        <div class="flex flex-col space-y-2">
          <Link href="#" class="text-gray-700 hover:text-blue-600">Home</Link>
          <Link href="#" class="text-gray-700 hover:text-blue-600">Shop</Link>
          <Link href="#" class="text-gray-700 hover:text-blue-600">Deals</Link>
          <Link href="#" class="text-gray-700 hover:text-blue-600">About</Link>

          <!-- Categories (Toggle) -->
          <div>
            <button @click="categoryOpen = !categoryOpen" class="text-gray-700 hover:text-blue-600 w-full text-left">Categories ▼</button>
            <div v-if="categoryOpen" class="mt-2 ml-3 space-y-1">
              <Link href="#" class="block text-gray-600 hover:text-blue-500">Electronics</Link>
              <Link href="#" class="block text-gray-600 hover:text-blue-500">Home & Living</Link>
              <Link href="#" class="block text-gray-600 hover:text-blue-500">Fashion</Link>
              <Link href="#" class="block text-gray-600 hover:text-blue-500">Beauty</Link>
            </div>
          </div>
        </div>

        <!-- Icons in mobile -->
        <div class="pt-4 flex items-center justify-between">
          <Link :href="route('login')" class="text-gray-600 hover:text-blue-600">Login</Link>
          <div class="flex gap-4">
            <Link href="#" class="relative hover:text-blue-600">❤️<span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">3</span></Link>
            <Link href="#" class="relative hover:text-blue-600">🛒<span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">2</span></Link>
          </div>
        </div>
      </div>
    </transition>
  </header>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-10px);
  opacity: 0;
}
</style>
