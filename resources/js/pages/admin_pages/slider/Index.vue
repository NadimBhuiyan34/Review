<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import { defineProps, ref, watch } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { Trash2, PenLine } from 'lucide-vue-next'

const props = defineProps({
  sliders: Array,
  filters: Object,
})

const search = ref(props.filters?.search || '')

watch(search, (value) => {
  router.get('/sliders', { search: value }, { preserveState: true, replace: true })
})

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Slider',
    href: '/sliders',
  },
];
</script>

<template>

  <Head title="Slider" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 sm:p-6 w-full mx-auto space-y-6 bg-gray-100">
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Sliders</h1>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
          <input v-model="search" type="text" placeholder="Search by name..."
            class="w-full sm:w-64 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" />
          <Link href="/sliders/create"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
          + Add New Slider
          </Link>
        </div>
      </div>

      <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
          <thead class="bg-blue-100">
            <tr>
              <th class="px-4 py-3 font-semibold text-gray-600">Image</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Description</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
              <th class="px-4 py-3 font-semibold text-right text-gray-600">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="slider in sliders" :key="slider.id" class="hover:bg-gray-50 transition">
              <td class="px-4 py-3">
                <img :src="slider.image" alt="Slider Image" class="w-20 h-14 object-cover rounded shadow-sm" />
              </td>
              <td class="px-4 py-3">{{ slider.name }}</td>
              <td class="px-4 py-3">{{ slider.description }}</td>
              <td class="px-4 py-3">
                <span :class="slider.status ? 'text-green-600' : 'text-red-500'" class="font-medium">
                  {{ slider.status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-4 py-3 text-right flex justify-end gap-2">
                <!-- Edit Button -->
                <Link :href="`/sliders/${slider.slug}/edit`"
                  class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition">
                <PenLine class="w-4 h-4 mr-1" />
                <span class="hidden sm:inline">Edit</span>
                </Link>

                <!-- Delete Button -->
                <Link :href="`/sliders/${slider.slug}`" method="delete" as="button"
                  class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
                <Trash2 class="w-4 h-4 mr-1" />
                <span class="hidden sm:inline">Delete</span>
                </Link>
              </td>
            </tr>

            <tr v-if="sliders.length === 0">
              <td colspan="5" class="text-center py-6 text-gray-500">
                No sliders found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>