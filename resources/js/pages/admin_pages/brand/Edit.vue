<script setup lang="ts">
import { defineProps, onMounted } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Undo2, PenLine } from 'lucide-vue-next';

// Define props to accept the existing brand data
const props = defineProps({
  brand: {
    type: Object,
    required: true,
  },
})

// Define the form with preloaded data
const form = useForm({
  id: props.brand.id,
  name: props.brand.name,
  description: props.brand.description,
  logo: props.brand.logo,
  status: props.brand.status,
});

// Breadcrumbs for the page
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Edit Brand',
    href: '/brands',
  },
];

// Submit the updated brand data
const submit = () => {
  form.put(`/brands/${props.brand.slug}`);
};

// Set the title dynamically
onMounted(() => {
  document.title = `Edit ${props.brand.name}`;
});
</script>

<template>
  <Head :title="'Edit ' + props.brand.name" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 w-full mx-auto bg-gray-100 rounded shadow">
      <h1 class="text-2xl font-bold mb-6">Edit Brand: {{ props.brand.name }}</h1>

      <!-- Form for brand editing -->
      <form @submit.prevent="submit" class="space-y-5 bg-white p-4 shadow-xl rounded-2xl">
        <!-- Brand Name -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Name</label>
          <input v-model="form.name" type="text"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

        <!-- Brand Description -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Description</label>
          <textarea v-model="form.description" rows="4"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
          <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <!-- Brand Image URL -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Brand Image URL</label>
          <input v-model="form.logo" type="text" placeholder="https://example.com/image.jpg"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <p v-if="form.errors.logo" class="text-red-600 text-sm mt-1">{{ form.errors.logo }}</p>
        </div>

        <!-- Brand Status -->
        <div class="flex items-center">
          <input v-model="form.status" type="checkbox" class="mr-2" :checked="form.status" />
          <label class="text-gray-700">Active</label>
        </div>

        <!-- Submit and Back Buttons -->
        <div class="flex items-center gap-2">
          <button type="submit" class="bg-blue-600 text-white px-6 py-1 rounded hover:bg-blue-700" :disabled="form.processing">
            Save Changes
          </button>
          <Link href="/brands" class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
            <Undo2 class="w-4 h-4 mr-1" /> Back
          </Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>