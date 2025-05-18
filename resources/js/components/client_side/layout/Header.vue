<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { route } from 'ziggy-js';

// Heroicons (https://github.com/tailwindlabs/heroicons)
import {
    ChevronDownIcon,
    ChevronUpIcon,
    MagnifyingGlassIcon,
    ShoppingCartIcon,
    HeartIcon,
    Bars3Icon,
    XMarkIcon,
    UserCircleIcon,
    PowerIcon,
} from '@heroicons/vue/24/outline';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const cartCount = computed(() => page.props.cartCount ?? 0);

const mobileMenuOpen = ref(false);
const categoryOpen = ref(false);
const profileMenuOpen = ref(false);

// Close mobile panel after navigation
const closeMobile = () => {
    mobileMenuOpen.value = false;
};
</script>

<template>
    <header class="sticky top-0 z-40 w-full mx-auto  backdrop-blur bg-amber-50 max-w-[1400px]">
        <!-- Top bar -->
        <div class="container max-w-[1400px] mx-auto flex items-center justify-between px-4 py-3 lg:py-4">
            <!-- Logo -->
            <Link href="/" class="text-3xl font-extrabold tracking-tight" @click="closeMobile">
            <span class="bg-gradient-to-r from-blue-700 to-purple-500 bg-clip-text text-transparent">Review</span>
            <span class="text-red-500">Hub</span>
            </Link>

            <!-- Desktop search -->
            <div class="mx-8 hidden w-full max-w-lg lg:flex bg-white">
                <div
                    class="flex w-full overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-blue-500">
                    <input type="text" placeholder="Search for products, brands and more"
                        class="flex-1 px-4 py-2 outline-none" />
                    <button class="flex items-center px-4">
                        <MagnifyingGlassIcon class="h-6 w-6" />
                    </button>
                </div>
            </div>

            <!-- Desktop actions -->
            <div class="hidden items-center gap-6 lg:flex">
                <!-- Profile / auth -->
                <div class="relative">
                    <button v-if="user" @click="profileMenuOpen = !profileMenuOpen"
                        class="flex items-center gap-1 font-medium text-gray-700 hover:text-blue-600">
                        <span class="truncate max-w-[7rem]">{{ user.name }}</span>
                        <ChevronDownIcon v-if="!profileMenuOpen" class="h-4 w-4" />
                        <ChevronUpIcon v-else class="h-4 w-4" />
                    </button>

                    <template v-else>
                        <Link :href="route('login')" class="flex items-center gap-1 text-gray-700 hover:text-blue-600">
                        <UserCircleIcon class="h-5 w-5" />
                        Login
                        </Link>
                    </template>

                    <!-- Profile dropdown -->
                    <transition name="fade">
                        <div v-if="profileMenuOpen && user"
                            class="absolute right-0 mt-2 w-48 overflow-hidden rounded-lg border bg-white shadow-lg">
                            <Link href="/profile" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-50"
                                @click="profileMenuOpen = false">
                            <UserCircleIcon class="h-5 w-5" />
                            Profile
                            </Link>
                            <Link href="/logout" method="post" as="button"
                                class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm hover:bg-gray-50">
                            <PowerIcon class="h-5 w-5" />
                            Logout
                            </Link>
                        </div>
                    </transition>
                </div>

                <!-- Wishlist -->
                <Link href="#" class="relative hover:text-blue-600">
                <HeartIcon class="h-6 w-6" />
                <span
                    class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white">3</span>
                </Link>

                <!-- Cart -->
                <Link :href="route('carts.index')" class="relative hover:text-blue-600">
                <ShoppingCartIcon class="h-6 w-6" />
                <span
                    class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white">{{
                    cartCount }}</span>
                </Link>
            </div>

            <!-- Mobile hamburger -->
            <button class="lg:hidden" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu">
                <Bars3Icon v-if="!mobileMenuOpen" class="h-8 w-8 text-gray-700" />
                <XMarkIcon v-else class="h-8 w-8 text-gray-700" />
            </button>
        </div>

        <!-- Desktop navigation -->
        <nav class="hidden border-t bg-blue-700 lg:block max-w-[1400px] mx-auto  text-white">
            <div class="container mx-auto flex items-center gap-6 px-4 py-2 text-sm font-medium  max-w-[1400px] text-white">
                <Link href="/" class="hover:bg-blue-500 p-2 rounded-lg">Home</Link>
                <Link href="#" class="hover:bg-blue-500 p-2 rounded-lg">Shop</Link>
                <Link href="#" class="hover:bg-blue-500 p-2 rounded-lg">Deals</Link>
                <Link href="#" class="hover:bg-blue-500 p-2 rounded-lg">About</Link>

                <!-- Categories dropdown -->
                <div class="relative ml-2">
                    <button @click="categoryOpen = !categoryOpen" class="flex items-center gap-1 hover:bg-blue-500 p-2 rounded-lg">
                        Categories
                        <ChevronDownIcon v-if="!categoryOpen" class="h-4 w-4" />
                        <ChevronUpIcon v-else class="h-4 w-4" />
                    </button>

                    <transition name="fade">
                        <div v-if="categoryOpen"
                            class="absolute z-20 mt-2 w-56 overflow-hidden rounded-lg border bg-blue-700 shadow-lg">
                            <Link href="#" class="block px-4 py-2 hover:bg-blue-500">Electronics</Link>
                            <Link href="#" class="block px-4 py-2 hover:bg-blue-500">Home & Living</Link>
                            <Link href="#" class="block px-4 py-2 hover:bg-blue-500">Fashion</Link>
                            <Link href="#" class="block px-4 py-2 hover:bg-blue-500">Health & Beauty</Link>
                        </div>
                    </transition>
                </div>
            </div>
        </nav>

        <!-- Mobile panel -->
        <transition name="slide-down">
            <div v-if="mobileMenuOpen" class="lg:hidden">
                <div class="space-y-4 border-t bg-white p-4">
                    <div class="flex flex-col gap-2 text-base">
                        <Link href="/" class="hover:text-blue-600" @click="closeMobile">Home</Link>
                        <Link href="#" class="hover:text-blue-600">Shop</Link>
                        <Link href="#" class="hover:text-blue-600">Deals</Link>
                        <Link href="#" class="hover:text-blue-600">About</Link>

                        <!-- Mobile categories -->
                        <div class="pt-2">
                            <button @click="categoryOpen = !categoryOpen"
                                class="flex w-full items-center justify-between hover:text-blue-600">
                                <span>Categories</span>
                                <ChevronDownIcon v-if="!categoryOpen" class="h-4 w-4" />
                                <ChevronUpIcon v-else class="h-4 w-4" />
                            </button>
                            <transition name="fade">
                                <div v-if="categoryOpen" class="mt-2 flex flex-col gap-1 pl-3">
                                    <Link href="#" class="hover:text-blue-600">Electronics</Link>
                                    <Link href="#" class="hover:text-blue-600">Home & Living</Link>
                                    <Link href="#" class="hover:text-blue-600">Fashion</Link>
                                    <Link href="#" class="hover:text-blue-600">Beauty</Link>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- Auth & icons -->
                    <div class="flex items-center justify-between border-t pt-4">
                        <div>
                            <template v-if="user">
                                <p class="mb-1 font-medium text-gray-700">
                                    <UserCircleIcon class="mr-1 inline-block h-5 w-5" /> {{ user.name }}
                                </p>
                                <Link href="/profile" class="block text-sm hover:text-blue-600" @click="closeMobile">
                                Profile</Link>
                                <Link href="/logout" method="post" as="button"
                                    class="block text-left text-sm hover:text-blue-600">
                                Logout
                                </Link>
                            </template>
                            <template v-else>
                                <Link :href="route('login')" class="text-gray-700 hover:text-blue-600"
                                    @click="closeMobile">Login</Link>
                            </template>
                        </div>

                        <div class="flex gap-4">
                            <Link href="#" class="relative hover:text-blue-600">
                            <HeartIcon class="h-6 w-6" />
                            <span
                                class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white">3</span>
                            </Link>
                            <Link :href="route('carts.index')" class="relative hover:text-blue-600">
                            <ShoppingCartIcon class="h-6 w-6" />
                            <span
                                class="absolute -top-2 -right-3 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white">{{
                                cartCount }}</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-down-enter-active,
.slide-down-leave-active {
    transition: transform 0.25s ease, opacity 0.25s ease;
}

.slide-down-enter-from,
.slide-down-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
