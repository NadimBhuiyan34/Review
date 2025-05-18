<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { route } from 'ziggy-js';

const page = usePage();

const cartCount = computed(() => page.props.cartCount ?? 0);

const mobileMenuOpen = ref(false);
const categoryOpen = ref(false);
</script>

<template>
    <header class="sticky top-0 z-50 border-b bg-white shadow">
        <div class="container mx-auto flex items-center justify-between px-4 py-3">
            <!-- Logo -->
            <Link href="/" class="text-3xl font-extrabold tracking-tight text-blue-600">
                <span class="bg-gradient-to-r from-blue-700 to-purple-500 bg-clip-text text-transparent">Review</span
                ><span class="text-red-500">Hub</span>
            </Link>

            <!-- Search (centered in desktop) -->
            <div class="mx-8 hidden max-w-2xl flex-1 lg:flex">
                <input
                    type="text"
                    placeholder="Search for products, brands and more"
                    class="w-full rounded-l-md border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <button class="rounded-r-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">🔍</button>
            </div>

            <!-- Icons -->
            <div class="hidden items-center gap-6 md:flex">
                <Link :href="route('login')" class="text-gray-600 hover:text-blue-600">Login</Link>
                <Link href="#" class="relative hover:text-blue-600">
                    ❤️
                    <span class="absolute -top-2 -right-2 rounded-full bg-red-500 px-1 text-xs text-white">3</span>
                </Link>
                <Link :href="route('carts.index')" class="relative hover:text-blue-600">
                    🛒
                    <span class="absolute -top-2 -right-2 rounded-full bg-red-500 px-1 text-xs text-white">{{ cartCount }}</span>
                </Link>
            </div>

            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-2xl text-gray-600 md:hidden">☰</button>
        </div>

        <!-- Navigation -->
        <nav class="hidden border-t bg-gray-50 md:block">
            <div class="container mx-auto flex items-center gap-6 px-4 py-2 text-sm font-medium text-gray-700">
                <Link href="/" class="hover:text-blue-600">Home</Link>
                <Link href="#" class="hover:text-blue-600">Shop</Link>
                <Link href="#" class="hover:text-blue-600">Deals</Link>
                <Link href="#" class="hover:text-blue-600">About</Link>

                <!-- Categories Dropdown -->
                <div class="group relative">
                    <button class="hover:text-blue-600">Categories ▼</button>
                    <div class="absolute z-10 mt-2 hidden w-48 border bg-white shadow-lg group-hover:block">
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
            <div v-if="mobileMenuOpen" class="space-y-3 border-t bg-white p-4 md:hidden">
                <div class="flex flex-col space-y-2">
                    <Link href="#" class="text-gray-700 hover:text-blue-600">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-blue-600">Shop</Link>
                    <Link href="#" class="text-gray-700 hover:text-blue-600">Deals</Link>
                    <Link href="#" class="text-gray-700 hover:text-blue-600">About</Link>

                    <!-- Categories (Toggle) -->
                    <div>
                        <button @click="categoryOpen = !categoryOpen" class="w-full text-left text-gray-700 hover:text-blue-600">Categories ▼</button>
                        <div v-if="categoryOpen" class="mt-2 ml-3 space-y-1">
                            <Link href="#" class="block text-gray-600 hover:text-blue-500">Electronics</Link>
                            <Link href="#" class="block text-gray-600 hover:text-blue-500">Home & Living</Link>
                            <Link href="#" class="block text-gray-600 hover:text-blue-500">Fashion</Link>
                            <Link href="#" class="block text-gray-600 hover:text-blue-500">Beauty</Link>
                        </div>
                    </div>
                </div>

                <!-- Icons in mobile -->
                <div class="flex items-center justify-between pt-4">
                    <Link :href="route('login')" class="text-gray-600 hover:text-blue-600">Login</Link>
                    <div class="flex gap-4">
                        <Link href="#" class="relative hover:text-blue-600"
                            >❤️<span class="absolute -top-2 -right-2 rounded-full bg-red-500 px-1 text-xs text-white">3</span></Link
                        >
                        <Link :href="route('carts.index')" class="relative hover:text-blue-600">
                            🛒
                            <span class="absolute -top-2 -right-2 rounded-full bg-red-500 px-1 text-xs text-white">{{ cartCount }}</span>
                        </Link>
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
