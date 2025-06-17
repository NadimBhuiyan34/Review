<template>
    <Head title="User Profile" />
    <AppLayout>
        <div class="mx-auto max-w-[1550px] px-4 py-10">
            <!-- Toast Message -->
            <!-- <div v-if="$page.props.flash.success" class="mb-6 text-green-700 bg-green-100 border border-green-200 px-4 py-3 rounded">
        {{ $page.props.flash.success }}
      </div> -->

            <!-- Profile Header -->
            <div class="mb-10 flex flex-col items-center justify-between md:flex-row">
                <div class="flex items-center gap-4">
                    <img :src="avatarPreview" alt="User avatar" class="h-20 w-20 rounded-full shadow-md ring-2 ring-indigo-500" />
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ form.name }}</h2>
                        <p class="text-sm text-gray-500">{{ form.email }}</p>
                    </div>
                </div>
                <button
                    @click="showEditForm = !showEditForm"
                    class="mt-4 rounded-lg bg-indigo-600 px-4 py-2 text-white shadow transition hover:bg-indigo-700 md:mt-0"
                >
                    ✏️ {{ showEditForm ? 'Cancel' : 'Edit Profile' }}
                </button>
            </div>

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-300">
                <nav class="flex flex-wrap gap-4 font-semibold text-gray-600">
                    <button
                        v-for="tab in tabs"
                        :key="tab.key"
                        @click="activeTab = tab.key"
                        :class="[
                            'border-b-2 pb-2',
                            activeTab === tab.key ? 'border-indigo-600 text-indigo-600' : 'border-transparent hover:text-indigo-600',
                        ]"
                    >
                        {{ tab.label }}
                    </button>
                </nav>
            </div>

            <!-- Tab: Profile Info -->
            <div v-if="activeTab === 'profile'">
                <h3 class="mb-4 text-xl font-bold text-gray-800">🙍 Profile Information</h3>

                <div v-if="!showEditForm" class="grid grid-cols-1 gap-6 text-sm text-gray-700 md:grid-cols-2">
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
                    class="mt-4 grid grid-cols-1 gap-6 rounded-lg bg-gray-50 p-6 shadow md:grid-cols-2"
                    enctype="multipart/form-data"
                >
                    <div>
                        <label class="mb-1 block text-sm font-medium">Full Name</label>
                        <input v-model="form.name" type="text" class="w-full rounded border px-3 py-2" />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">Email</label>
                        <input v-model="form.email" type="email" class="w-full rounded border px-3 py-2" />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">Phone</label>
                        <input v-model="form.phone" type="text" class="w-full rounded border px-3 py-2" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Address</label>
                        <input v-model="form.address" type="text" class="w-full rounded border px-3 py-2" />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">Gender</label>
                        <select v-model="form.gender" class="w-full rounded border px-3 py-2">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">Date of Birth</label>
                        <input v-model="form.dob" type="date" class="w-full rounded border px-3 py-2" />
                    </div>

                    <!-- <div>
            <label class="block text-sm font-medium mb-1">Profile Picture</label>
            <input type="file" @change="handleAvatarUpload" class="w-full border rounded px-3 py-2" />
          </div> -->

                    <div class="col-span-2">
                        <label class="mb-1 block text-sm font-medium">Bio</label>
                        <textarea v-model="form.bio" rows="4" class="w-full rounded border px-3 py-2"></textarea>
                    </div>

                    <div class="col-span-2 mt-4 flex justify-end gap-4">
                        <button type="button" @click="showEditForm = false" class="rounded border px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Tab: Orders -->
            <div v-else-if="activeTab === 'orders'">
                <h3 class="mb-4 text-xl font-bold text-gray-800">📦 Order History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full rounded-lg border border-gray-200 bg-white shadow">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="px-4 py-3">Order ID</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Items</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Payment Status</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            <tr v-for="order in orders" :key="order.id" class="border-t">
                                <td class="px-4 py-3">{{ order.order_number }}</td>
                                <td class="px-4 py-3">{{ formatDate(order.created_at) }}</td>
                                <td class="px-4 py-3">{{ order.order_items_count }}</td>
                                <td class="px-4 py-3">${{ order.total_price }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        :class="[
                                            'rounded px-2 py-1 text-sm font-medium',
                                            order.status === 'Delivered'
                                                ? 'bg-green-100 text-green-700'
                                                : order.status === 'Processing'
                                                  ? 'bg-yellow-100 text-yellow-700'
                                                  : 'bg-red-100 text-red-700',
                                        ]"
                                    >
                                        {{ order.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        :class="[
                                            'rounded px-2 py-1 text-sm font-medium',
                                            order.payment_status === 'Paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700',
                                        ]"
                                    >
                                        {{ order.payment_status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <Link
                                        :href="route('orders.show', order.id)"
                                        class="text-indigo-600 hover:text-indigo-800"
                                        title="View Order Details"
                                    >
                                   
                                        <!-- Magnifying glass SVG icon -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="inline-block h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"
                                            />
                                        </svg>
                                        View
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab: Addresses -->
            <div v-else-if="activeTab === 'addresse'">
                <h3 class="mb-4 text-xl font-bold text-gray-800">📍 Saved Addresses</h3>
                <div class="space-y-4">
                    <div class="rounded-lg border p-4 shadow-sm">
                        <p class="font-medium">Home Address</p>
                        <p>{{ user.profile.address }}</p>
                    </div>
                </div>
            </div>

           
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/ClientLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
});

const activeTab = ref('profile');
const showEditForm = ref(false);

const tabs = [
    { key: 'orders', label: 'Orders' },
    { key: 'profile', label: 'Profile Info' },
    { key: 'addresse', label: 'Addresse' },
];

const wishlist = [
    { id: 1, name: 'Wireless Headphones', price: '99.99', image: 'https://via.placeholder.com/200' },
    { id: 2, name: 'Smart Watch', price: '149.99', image: 'https://via.placeholder.com/200' },
    { id: 3, name: 'Bluetooth Speaker', price: '49.99', image: 'https://via.placeholder.com/200' },
];

// Initialize form with user data; avatar is null initially (file input)
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.profile.phone,
    address: props.user.profile.address,
    gender: props.user.profile.gender,
    dob: props.user.profile.dob,
    bio: props.user.profile.bio,
    avatar: null, // file to upload
});

// Separate ref for avatar preview URL (string)
const avatarPreview = ref(
    props.user.profile.avatar
        ? `/storage/${props.user.profile.avatar}`
        : 'https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?semt=ais_hybrid&w=740',
);

// Handle file input change
// const handleAvatarUpload = (e) => {
//   const file = e.target.files[0]
//   if (file) {
//     form.avatar = file
//     avatarPreview.value = URL.createObjectURL(file)
//   }
// }

// Submit form with Inertia
const submit = () => {
    form.put(route('profiles.update', props.user.profile.id), {
        preserveScroll: true,
        onSuccess: () => {
            showEditForm.value = false;
        },
    });
};

// Date formatter utility
function formatDate(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
}
</script>
