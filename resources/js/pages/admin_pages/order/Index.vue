<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, Link } from '@inertiajs/vue3';
import { defineProps, ref, watch } from 'vue';
import { PenLine, Trash2, Eye } from 'lucide-vue-next';

interface Profile {
  phone: string;
}

interface User {
  name: string;
  profile: Profile;
}

interface Order {
  id: string;
  order_number: string;
  total_price: number;
  status: string;
  payment_method: string;
  payment_status: string;
  user: User;
}

const props = defineProps<{
  orders: {
    data: Order[];
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
  await router.get('/admin_orders', { search: value }, {
    preserveState: true,
    replace: true,
    onFinish: () => isLoading.value = false
  });
}, { immediate: true });

const handlePaginate = (page: number) => {
  router.get('/admin_orders', { search: search.value, page }, {
    preserveState: true,
    replace: true,
  });
};

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Orders', href: '/admin_orders' },
];
</script>

<template>
  <Head title="Orders" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 sm:p-6 w-full mx-auto space-y-6 bg-gray-100">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
          <input v-model="search" type="text" placeholder="Search by order number..."
            class="w-full sm:w-64 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
          <thead class="bg-blue-100">
            <tr>
              <th class="px-4 py-3 font-semibold text-gray-600">Order #</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Mobile</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Total Price</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Payment Status</th>
              <th class="px-4 py-3 font-semibold text-gray-600">Order Status</th>
              <th class="px-4 py-3 font-semibold text-right text-gray-600">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="order in props.orders.data" :key="order.id" class="hover:bg-gray-50 transition">
              <td class="px-4 py-3 font-medium text-gray-700">{{ order.order_number }}</td>
               <td class="px-4 py-3">{{ order.user.name }}</td>
               <td class="px-4 py-3">{{ order.user.profile.phone }}</td>
              <td class="px-4 py-3">৳{{ order.total_price}}</td>
              <td class="px-4 py-3">
                <span :class="order.payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600'" class="font-medium">
                  {{ order.payment_status }}
                </span>
              </td>
              <td class="px-4 py-3">
                <span :class="order.status" class="font-medium">
                  {{ order.status }}
                </span>
              </td>
              <td class="px-4 py-3 text-right flex justify-end gap-2">
                <Link :href="`/admin_orders/${order.id}`"
                  class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition">
                  <Eye class="w-4 h-4 mr-1" />
                  <span class="hidden sm:inline">Show</span>
                </Link>
                <Link :href="`/admin_orders/${order.id}/edit`"
                  class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition">
                  <PenLine class="w-4 h-4 mr-1" />
                  <span class="hidden sm:inline">Edit</span>
                </Link>
                <Link :href="`/admin_orders/${order.id}`" method="delete" as="button"
                  class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition">
                  <Trash2 class="w-4 h-4 mr-1" />
                  <span class="hidden sm:inline">Delete</span>
                </Link>
              </td>
            </tr>

            <tr v-if="orders.data.length === 0">
              <td colspan="6" class="text-center py-6 text-gray-500">
                No orders found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center items-center space-x-2 pt-4">
        <button
          v-if="props.orders.current_page > 1"
          @click="handlePaginate(props.orders.current_page - 1)"
          class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
        >
          Previous
        </button>
        <button
          v-if="props.orders.current_page < props.orders.last_page"
          @click="handlePaginate(props.orders.current_page + 1)"
          class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
        >
          Next
        </button>
      </div>
    </div>
  </AppLayout>
</template>
