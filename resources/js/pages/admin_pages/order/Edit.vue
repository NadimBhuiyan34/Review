<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Undo2 } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
})

const form = useForm({
  status: props.order.status ?? 'pending',
  payment_method: props.order.payment_method ?? 'bkash',
  payment_status: props.order.payment_status ?? '',
  shipping: {
    name: props.order.shipping_address.name ?? '',
    phone: props.order.shipping_address.phone ?? '',
    address: props.order.shipping_address.address ?? '',
    city: props.order.shipping_address.city ?? '',
    postal_code: props.order.shipping_address.postal_code ?? '',
  },
})

const submit = () => {
  form.put(`/admin_orders/${props.order.id}`)
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Orders', href: '/admin_orders' },
  { title: 'Edit Order', href: '#' },
]
</script>

<template>
  <Head title="Edit Order" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 w-full mx-auto bg-gray-100 rounded shadow">
      <h1 class="text-2xl font-bold mb-6">Edit Order #{{ order.order_number }}</h1>

      <form @submit.prevent="submit" class="space-y-5 bg-white p-4 shadow-xl rounded-2xl">
        <!-- Status -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Order Status</label>
          <select
            v-model="form.status"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          >
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Processing">Processing</option>
                <option value="Shipped">Shipped</option>
                <option value="Out for Delivery">Out for Delivery</option>
                <option value="Delivered">Delivered</option>
                <option value="Returned">Returned</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Failed">Failed</option>
          </select>
          <p v-if="form.errors.status" class="text-red-600 text-sm mt-1">{{ form.errors.status }}</p>
        </div>

        <!-- Payment Method (select) -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Payment Method</label>
          <select
            v-model="form.payment_method"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          >
            <option value="">Select method</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Bkash">Bkash</option>
            <option value="Nagad">Nagad</option>
            <option value="Rocket">Rocket</option>
            <option value="Card">Card</option>
          </select>
          <p v-if="form.errors.payment_method" class="text-red-600 text-sm mt-1">{{ form.errors.payment_method }}</p>
        </div>

        <!-- Payment Status (select) -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Payment Status</label>
          <select
            v-model="form.payment_status"
            class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
          >
            <option value="">Select status</option>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
            <option value="Refunded">Refunded</option>
          </select>
          <p v-if="form.errors.payment_status" class="text-red-600 text-sm mt-1">{{ form.errors.payment_status }}</p>
        </div>

        <!-- Shipping Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1">Shipping Name</label>
            <input
              v-model="form.shipping.name"
              type="text"
              class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Phone</label>
            <input
              v-model="form.shipping.phone"
              type="text"
              class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>
          <div class="md:col-span-2">
            <label class="block text-gray-700 font-medium mb-1">Address</label>
            <input
              v-model="form.shipping.address"
              type="text"
              class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">City</label>
            <input
              v-model="form.shipping.city"
              type="text"
              class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Postal Code</label>
            <input
              v-model="form.shipping.postal_code"
              type="text"
              class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
          </div>
        </div>

        <!-- Submit & Back -->
        <div class="flex items-center gap-2 pt-4">
          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-1 rounded hover:bg-blue-700"
            :disabled="form.processing"
          >
            Update Order
          </button>
          <Link
            href="/admin_orders"
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
