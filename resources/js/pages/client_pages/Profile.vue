<template>
  <Head title="User Profile" />
  <AppLayout>
    <div class="max-w-[1550px] mx-auto px-4 py-10">
      <!-- Toast Message -->
      <!-- <div v-if="$page.props.flash.success" class="mb-6 text-green-700 bg-green-100 border border-green-200 px-4 py-3 rounded">
        {{ $page.props.flash.success }}
      </div> -->

      <!-- Profile Header -->
      <div class="flex flex-col md:flex-row items-center justify-between mb-10">
        <div class="flex items-center gap-4">
          <img :src="form.avatarUrl" alt="User avatar" class="w-20 h-20 rounded-full shadow-md ring-2 ring-indigo-500" />
          <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ form.name }}</h2>
            <p class="text-sm text-gray-500">{{ form.email }}</p>
          </div>
        </div>
        <button
          @click="showEditForm = !showEditForm"
          class="mt-4 md:mt-0 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition"
        >
          ✏️ {{ showEditForm ? 'Cancel' : 'Edit Profile' }}
        </button>
      </div>

      <!-- Tabs -->
      <div class="mb-6 border-b border-gray-300">
        <nav class="flex flex-wrap gap-4 text-gray-600 font-semibold">
          <button
            v-for="tab in tabs"
            :key="tab.key"
            @click="activeTab = tab.key"
            :class="[
              'pb-2 border-b-2',
              activeTab === tab.key
                ? 'text-indigo-600 border-indigo-600'
                : 'border-transparent hover:text-indigo-600'
            ]"
          >
            {{ tab.label }}
          </button>
        </nav>
      </div>

      <!-- Tab: Profile Info -->
      <div v-if="activeTab === 'profile'">
        <h3 class="text-xl font-bold text-gray-800 mb-4">🙍 Profile Information</h3>

        <div v-if="!showEditForm" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
          <div><span class="font-medium">Full Name:</span> {{ form.name }}</div>
          <div><span class="font-medium">Email:</span> {{ form.email }}</div>
          <div><span class="font-medium">Phone:</span> {{ form.phone }}</div>
          <div><span class="font-medium">Gender:</span> {{ form.gender }}</div>
          <div><span class="font-medium">Date of Birth:</span> {{ form.dob }}</div>
          <div><span class="font-medium">Bio:</span> {{ form.bio }}</div>
        </div>

        <form
          v-else
          @submit.prevent="submit"
          class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg shadow mt-4"
        >
          <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input v-model="form.phone" type="text" class="w-full border rounded px-3 py-2" />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Gender</label>
            <select v-model="form.gender" class="w-full border rounded px-3 py-2">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="">Other</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Date of Birth</label>
            <input v-model="form.dob" type="date" class="w-full border rounded px-3 py-2" />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Profile Picture</label>
            <input type="file" @change="handleAvatarUpload" class="w-full border rounded px-3 py-2" />
          </div>

          <div class="col-span-2">
            <label class="block text-sm font-medium mb-1">Bio</label>
            <textarea v-model="form.bio" rows="4" class="w-full border rounded px-3 py-2"></textarea>
          </div>

          <div class="col-span-2 flex justify-end gap-4 mt-4">
            <button type="button" @click="showEditForm = false" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
              Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
              Save Changes
            </button>
          </div>
        </form>
      </div>

      <!-- Tab: Orders -->
      <div v-else-if="activeTab === 'orders'">
        <h3 class="text-xl font-bold text-gray-800 mb-4">📦 Order History</h3>
        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow">
            <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
              <tr>
                <th class="px-4 py-3">Order ID</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Items</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody class="text-gray-800 text-sm">
              <tr v-for="order in orders" :key="order.id" class="border-t">
                <td class="px-4 py-3">#{{ order.id }}</td>
                <td class="px-4 py-3">{{ order.date }}</td>
                <td class="px-4 py-3">{{ order.items }}</td>
                <td class="px-4 py-3">${{ order.total }}</td>
                <td class="px-4 py-3">
                  <span
                    :class="[
                      'px-2 py-1 rounded text-sm font-medium',
                      order.status === 'Delivered' ? 'bg-green-100 text-green-700' :
                      order.status === 'Processing' ? 'bg-yellow-100 text-yellow-700' :
                      'bg-red-100 text-red-700'
                    ]"
                  >
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-4 py-3">
                  <button class="text-indigo-600 hover:underline text-sm">View</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tab: Addresses -->
      <div v-else-if="activeTab === 'addresses'">
        <h3 class="text-xl font-bold text-gray-800 mb-4">📍 Saved Addresses</h3>
        <div class="space-y-4">
          <div class="p-4 border rounded-lg shadow-sm">
            <p class="font-medium">Home Address</p>
            <p>123 Green Road, Dhaka, Bangladesh</p>
          </div>
          <div class="p-4 border rounded-lg shadow-sm">
            <p class="font-medium">Work Address</p>
            <p>456 Tech Park, Dhanmondi, Dhaka</p>
          </div>
        </div>
      </div>

      <!-- Tab: Wishlist -->
      <div v-else-if="activeTab === 'wishlist'">
        <h3 class="text-xl font-bold text-gray-800 mb-4">💖 Wishlist</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <div
            v-for="item in wishlist"
            :key="item.id"
            class="bg-white rounded-lg shadow hover:shadow-md p-4 border"
          >
            <img :src="item.image" alt="" class="h-32 w-full object-cover rounded-md mb-3" />
            <h4 class="font-medium text-gray-800">{{ item.name }}</h4>
            <p class="text-sm text-gray-500 mb-2">${{ item.price }}</p>
            <button class="text-indigo-600 hover:underline text-sm">View Product</button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/ClientLayout.vue'

const activeTab = ref('profile')
const showEditForm = ref(false)

const tabs = [
  { key: 'orders', label: 'Orders' },
  { key: 'profile', label: 'Profile Info' },
  { key: 'addresses', label: 'Addresses' },
  { key: 'wishlist', label: 'Wishlist' },
]

const orders = [
  { id: 123456, date: '2025-06-12', items: '3 Items', total: '59.99', status: 'Delivered' },
  { id: 123457, date: '2025-06-10', items: '1 Item', total: '19.99', status: 'Processing' },
  { id: 123458, date: '2025-06-08', items: '2 Items', total: '29.99', status: 'Cancelled' },
]

const wishlist = [
  { id: 1, name: 'Wireless Headphones', price: '99.99', image: 'https://via.placeholder.com/200' },
  { id: 2, name: 'Smart Watch', price: '149.99', image: 'https://via.placeholder.com/200' },
  { id: 3, name: 'Bluetooth Speaker', price: '49.99', image: 'https://via.placeholder.com/200' },
]

// User form data
const form = useForm({
  name: 'Nadim Bhuiyan',
  email: 'nadim@example.com',
  phone: '+880-1234-567890',
  gender: 'Male',
  dob: '1999-01-15',
  bio: '',
  avatar: null,
  avatarUrl: 'https://i.pravatar.cc/150?img=5',
})

const handleAvatarUpload = (e) => {
  const file = e.target.files[0]
  if (file) {
    form.avatar = file
    form.avatarUrl = URL.createObjectURL(file)
  }
}

const submit = () => {
  form.post(route('profile.update'), {
    preserveScroll: true,
    onSuccess: () => {
      showEditForm.value = false
    },
  })
}
</script>
