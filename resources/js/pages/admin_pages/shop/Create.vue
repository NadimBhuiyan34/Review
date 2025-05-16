<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { Undo2, PenLine } from 'lucide-vue-next'
const form = useForm({
    name: '',
    status: true
})

const submit = () => {
    form.post('/shops')
}


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shop Create',
        href: '/shops',
    },
];
</script>

<template>

    <Head title="Shop-Create" />
<!-- create page -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 w-full mx-auto bg-gray-100 rounded shadow">
            <h1 class="text-2xl font-bold mb-6">Create New Shop</h1>

            <form @submit.prevent="submit" class="space-y-5 bg-white p-4 shadow-xl rounded-2xl">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input v-model="form.name" type="text"
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input v-model="form.status" type="checkbox" class="mr-2" :checked="form.status" />
                    <label class="text-gray-700">Active</label>
                </div>

                <!-- Submit -->
                <div class="flex items-center gap-2 ">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-1 rounded hover:bg-blue-700"
                        :disabled="form.processing">
                        Save
                    </button>
                    <Link href="/sliders" class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">  <Undo2 class="w-4 h-4 mr-1" /> Back</Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
