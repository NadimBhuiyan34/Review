<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                  <Link :href="route('home')" class="flex flex-col items-center gap-1 group">
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
        <span class="text-lg font-bold">RH</span>
    </div>
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white tracking-wide">Review Hub</h1>
    <span class="sr-only">{{ title }}</span>
</Link>

                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
