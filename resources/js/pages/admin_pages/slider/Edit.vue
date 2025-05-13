<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Undo2 } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

const props = defineProps({
  slider: {
    type: Object,
    required: true,
  },
})

const form = useForm({
  name: props.slider.name,
  description: props.slider.description,
  image: props.slider.image,
  status: props.slider.status,
})

const submit = () => {
  form.put(`/sliders/${props.slider.slug}`)
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Sliders', href: '/sliders' },
  { title: 'Edit Slider', href: '#' },
]
</script>

<template>
  <Head title="Edit Slider" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 w-full mx-auto bg-gray-100 rounded shadow">
      <h1 class="text-2xl font-bold mb-6">Edit Slider</h1>

      <form @submit.prevent="submit" class="space-y-5 bg-white p-4 shadow-xl rounded-2xl">
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
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            rows="4"
          ></textarea>
          <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <!-- Image URL -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Image URL</label>
          <input
            v-model="form.image"
            type="text"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="https://example.com/image.jpg"
          />
          <p v-if="form.errors.image" class="text-red-600 text-sm mt-1">{{ form.errors.image }}</p>
        </div>

        <!-- Status -->
        <div class="flex items-center">
          <input v-model="form.status" type="checkbox" class="mr-2" />
          <label class="text-gray-700">Active</label>
        </div>

        <!-- Submit & Back -->
        <div class="flex items-center gap-2">
          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-1 rounded hover:bg-blue-700"
            :disabled="form.processing"
          >
            Update
          </button>
          <Link
            href="/sliders"
            class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition"
          >
            <Undo2 class="w-4 h-4 mr-1" />
            Back
          </Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
