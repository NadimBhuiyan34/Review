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
    description: '',
    status: true
})

const submit = () => {
    form.post('/categories')
}


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category Create',
        href: '/categories',
    },
];
</script>

<template>

    <Head title="Category-Create" />
<!-- create page -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 w-full mx-auto bg-gray-100 rounded shadow">
            <h1 class="text-2xl font-bold mb-6">Create New Category</h1>

      <form @submit.prevent="submit" class="space-y-5 bg-white p-6 rounded-xl shadow-md max-w-lg mx-auto">
        <!-- Name -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Name</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          />
          <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

        <!-- Description -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Description</label>
          <textarea
            v-model="form.description"
            rows="4"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          ></textarea>
          <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <!-- Status -->
        <div class="flex items-center">
          <input v-model="form.status" type="checkbox" class="mr-2" />
          <label class="text-gray-700">Active</label>
        </div>

        <!-- Submit & Back Buttons -->
        <div class="flex items-center gap-3">
          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
            :disabled="form.processing"
          >
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save</span>
          </button>

          <Link
            href="/categories"
            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-md transition"
          >
            Back
          </Link>
        </div>
      </form>
    </div>
            
        
    </AppLayout>
</template>
