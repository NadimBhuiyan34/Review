<template>
    <Head title="My Wishlist" />
    <AppLayout>
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <h1 class="mb-8 text-center text-3xl font-bold text-gray-800">My Wishlist</h1>

            <!-- Empty State -->
            <div v-if="wishlist.length === 0" class="py-20 text-center text-gray-500">
                <ShoppingBag class="mx-auto mb-4 h-16 w-16 text-gray-400" />
                <p class="text-xl font-medium">Your wishlist is currently empty.</p>
                <p class="mt-2">Start exploring and add items you love!</p>
            </div>

            <!-- Wishlist Items -->
            <div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <div
                    v-for="(item, index) in wishlist"
                    :key="item.id"
                    class="rounded-xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:shadow-md"
                >
                    <img
                        :src="item.product.images[0]?.image_path ? `/storage/${item.product.images[0].image_path}` : '/images/placeholder.jpg'"
                        :alt="item.product.name"
                        class="h-48 w-full rounded-t-xl object-cover"
                    />
                    <div class="space-y-2 p-4">
                        <h2 class="truncate text-lg font-semibold text-gray-800">{{ item.product.name }}</h2>

                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-lg font-bold text-gray-900">
                                ${{ (item.product.price - (item.product.discount_price ?? 0)).toFixed(2) }}
                            </span>
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-2">
                            <button
                                @click="addToCart(item.product, item.id)"
                                class="flex-1 rounded-lg bg-blue-600 px-3 py-2 text-sm text-white transition hover:bg-blue-700"
                            >
                                Move to Cart
                            </button>
                            <button
                                @click="deleteItem(item.id, index)"
                                class="text-red-500 transition hover:text-red-600"
                                title="Remove"
                                :disabled="loading[index]"
                            >
                                <Trash2 class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/ClientLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ShoppingBag, Trash2 } from 'lucide-vue-next'
import { defineProps, ref } from 'vue'

const props = defineProps({
    wishlist: {
        type: Array,
        default: () => [],
    },
})

const wishlist = ref([...props.wishlist])
const loading = ref([])

// Delete item and update local UI immediately
const deleteItem = (wishlistId, index) => {
    if (!confirm('Are you sure you want to remove this item from your wishlist?')) return;

    loading.value[index] = true;

    router.delete(route('whishlists.destroy', wishlistId), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // Remove from local wishlist immediately
            wishlist.value.splice(index, 1)
            loading.value[index] = false
        },
        onError: () => {
            loading.value[index] = false
            alert('Failed to remove item from wishlist.')
        },
    });
};

// Add to cart and remove from wishlist locally as well
const addToCart = (product, wishlistId) => {
    router.post(
        route('carts.store'),
        {
            product_id: product.id,
            quantity: 1,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                // Find item index by wishlistId
                const index = wishlist.value.findIndex(item => item.id === wishlistId)
                if (index !== -1) {
                    deleteItem(wishlistId, index)
                }
            },
            onError: (errors) => {
                alert('Error adding to cart.')
                console.error(errors)
            },
        }
    )
}
</script>
