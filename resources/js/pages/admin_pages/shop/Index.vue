<script setup lang="ts">
import { defineProps, ref, watch } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Trash2, PenLine } from 'lucide-vue-next';

interface Shop {
  id: string;
  name: string;
  slug: string;
  status: boolean;
}

const props = defineProps<{
  shops: {
    data: Shop[];
    current_page: number;
    last_page: number;
    total: number;
    from: number;
    to: number;
  };
  filters: { search?: string };
}>();

const search = ref(props.filters?.search || '');
const isLoading = ref(false);

watch(search, async (value) => {
  isLoading.value = true;
  await router.get('/shops', { search: value }, {
    preserveState: true,
    replace: true,
    onFinish: () => isLoading.value = false
  });
}, { immediate: true });

const handlePaginate = (page: number) => {
  router.get('/shops', { search: search.value, page }, {
    preserveState: true,
    replace: true,
  });
};

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Shop', href: '/shops' },
];
</script>

<template>
  <Head title="Shops" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 sm:p-6 w-full mx-auto space-y-6 bg-gray-100">
      
      <!-- Header -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Shops</h1>
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
          <input
            v-model="search"
            type="text"
            placeholder="Search by name..."
            class="w-full sm:w-64 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
          />
          <Link
            href="/shops/create"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium"
          >
            + Add New Shop
          </Link>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
          <thead class="bg-blue-100">
            <tr>
              <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
              <th class="px-4 py-3 font-semibold text-right text-gray-600">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="shop in props.shops.data" :key="shop.id" class="hover:bg-gray-50 transition">
              <td class="px-4 py-3">{{ shop.name }}</td>
              <td class="px-4 py-3">
                <span :class="shop.status ? 'text-green-600' : 'text-red-500'" class="font-medium">
                  {{ shop.status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-4 py-3 text-right flex justify-end gap-2">
                <Link
                  :href="`/shops/${shop.slug}/edit`"
                  class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition"
                >
                  <PenLine class="w-4 h-4 mr-1" />
                  <span class="hidden sm:inline">Edit</span>
                </Link>
                <Link
                  :href="`/shops/${shop.slug}`"
                  method="delete"
                  as="button"
                  class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition"
                >
                  <Trash2 class="w-4 h-4 mr-1" />
                  <span class="hidden sm:inline">Delete</span>
                </Link>
              </td>
            </tr>
            <tr v-if="props.shops.data.length === 0">
              <td colspan="5" class="text-center py-6 text-gray-500">No shops found.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="props.shops.last_page > 1" class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4">
        <div class="text-sm text-gray-500">
          Showing {{ props.shops.from }} to {{ props.shops.to }} of {{ props.shops.total }} results
        </div>
        <div class="flex flex-wrap gap-1">
          <button
            v-if="props.shops.current_page > 1"
            @click="handlePaginate(props.shops.current_page - 1)"
            class="px-3 py-1 border rounded text-sm hover:bg-gray-200 transition"
          >
            Prev
          </button>

          <button
            v-for="page in props.shops.last_page"
            :key="page"
            @click="handlePaginate(page)"
            :class="[
              'px-3 py-1 border rounded text-sm',
              page === props.shops.current_page
                ? 'bg-blue-600 text-white'
                : 'hover:bg-gray-100 text-gray-700'
            ]"
          >
            {{ page }}
          </button>

          <button
            v-if="props.shops.current_page < props.shops.last_page"
            @click="handlePaginate(props.shops.current_page + 1)"
            class="px-3 py-1 border rounded text-sm hover:bg-gray-200 transition"
          >
            Next
          </button>
        </div>
      </div>

      <!-- Loading Spinner -->
      <div v-if="isLoading" class="flex justify-center items-center py-4">
        <span class="text-gray-500">Loading...</span>
      </div>
    </div>
  </AppLayout>
</template>
