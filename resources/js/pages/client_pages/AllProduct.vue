<template>
    <Head title="All Products" />
    <AppLayout>
        <div class="mx-auto max-w-[1550px] px-4 py-10">
            <!-- Title -->
            <h1 class="mb-10 text-center text-4xl font-extrabold text-gray-900 drop-shadow-md">🛒 Browse Our Products</h1>

            <div class="flex flex-col gap-8 lg:flex-row">
                <!-- Sidebar Filters -->
                <aside class="w-full rounded-xl bg-white p-6 shadow-lg lg:w-1/4">
                    <h2 class="mb-4 text-xl font-bold text-gray-800">🔎 Filter Products</h2>

                    <!-- Search -->
                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-semibold">Search</label>
                        <input
                            v-model="filters.search"
                            @input="debouncedApplyFilters"
                            type="search"
                            placeholder="Search by name..."
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-semibold">Category</label>
                        <select
                            v-model="filters.category"
                            @change="applyFilters"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        >
                            <option value="">All Categories</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                {{ cat.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-semibold">Brand</label>
                        <select
                            v-model="filters.brand"
                            @change="applyFilters"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        >
                            <option value="">All Brands</option>
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Shop -->
                    <div class="mb-6">
                        <label class="mb-1 block text-sm font-semibold">Shop</label>
                        <select
                            v-model="filters.shop"
                            @change="applyFilters"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        >
                            <option value="">All Shops</option>
                            <option v-for="shop in shops" :key="shop.id" :value="shop.id">
                                {{ shop.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="mb-2 block text-sm font-semibold">Price Range (৳)</label>
                        <div class="flex gap-3">
                            <input
                                type="number"
                                v-model.number="filters.minPrice"
                                @input="debouncedApplyFilters"
                                placeholder="Min"
                                class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                            <input
                                type="number"
                                v-model.number="filters.maxPrice"
                                @input="debouncedApplyFilters"
                                placeholder="Max"
                                class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            />
                        </div>
                    </div>

                    <!-- Reset Filters -->
                    <button @click="resetFilters" class="w-full text-center text-sm font-semibold text-red-600 hover:underline">Reset Filters</button>
                </aside>

                <!-- Product Grid -->
                <section class="w-full lg:w-3/4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                        <transition-group name="fade" tag="div" class="contents">
                            <div
                                v-for="product in products"
                                :key="product.id"
                                class="group relative cursor-pointer overflow-hidden rounded-3xl bg-white shadow-lg"
                            >
                                <!-- Full Card Clickable -->
                                <Link :href="route('product_details.show', product.slug)" class="absolute inset-0 z-10" />

                                <!-- Image Section -->
                                <div class="relative h-72 w-full overflow-hidden">
                                    <img
                                        v-if="getFeaturedImage(product)"
                                        :src="getFeaturedImage(product).image_path"
                                        :alt="product.name"
                                        class="clip-custom h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        loading="lazy"
                                    />

                                    <button
                                        @click.stop="addToWhishList(product)"
                                        class="absolute top-4 right-4 z-20 rounded-full bg-white p-2 text-indigo-600 shadow-md transition duration-300 hover:bg-indigo-100 hover:shadow-lg"
                                        :aria-label="'Add ' + product.name + ' to cart'"
                                    >
                                        <svg
                                            v-if="isInWishlist(product)"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 fill-red-600 stroke-red-600"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 21.657l-8.828-8.829a4 4 0 010-5.656z"
                                            />
                                        </svg>

                                        <!-- Outline Heart -->
                                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 21.657l-8.828-8.829a4 4 0 010-5.656z"
                                            />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Info Section -->
                                <div class="relative rounded-b-3xl bg-indigo-600 px-6 py-5 text-white">
                                    <h3 class="truncate text-lg font-semibold" :title="product.name">
                                        {{ product.name }}
                                    </h3>
                                    <p class="mt-1 text-xl font-bold">{{ product.price - product.discount_price }} TK</p>

                                    <!-- Add to Cart Button -->
                                    <button
                                        @click.stop="addToCart(product)"
                                        class="absolute top-4 right-4 z-20 rounded-full bg-white p-2 text-indigo-600 shadow-md transition duration-300 hover:bg-indigo-100 hover:shadow-lg"
                                        :aria-label="'Add ' + product.name + ' to cart'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6H19m-9 0a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </transition-group>
                    </div>

                    <!-- Load More -->
                    <div v-if="pagination.hasMorePages" class="mt-10 text-center">
                        <button
                            @click="loadMore"
                            class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800"
                        >
                            See More
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>

                    <!-- No Products -->
                    <div v-if="!products.length" class="mt-20 text-center text-lg text-gray-500">No products found.</div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/ClientLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { ref } from 'vue';

const props = defineProps({
    products: Array,
    categories: Array,
    brands: Array,
    shops: Array,
    filters: Object,
    pagination: Object,
    auth: Object, // Ensure 'auth' is passed from the server
});

const brands = ref(props.brands);
const shops = ref(props.shops);
const products = ref([...props.products]);
const categories = ref(props.categories);
const pagination = ref(props.pagination);

const filters = ref({
    search: props.filters.search || '',
    category: props.filters.category || '',
    brand: props.filters.brand || '',
    shop: props.filters.shop || '',
    minPrice: props.filters.minPrice || '',
    maxPrice: props.filters.maxPrice || '',
});

const formatCurrency = (amount) => `${amount.toLocaleString()} TK`;

const applyFilters = () => {
    router.get(route('products.all'), filters.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            products.value = page.props.products;
            pagination.value = page.props.pagination;
        },
    });
};

const debouncedApplyFilters = debounce(() => applyFilters(), 500);

const resetFilters = () => {
    filters.value = {
        search: '',
        category: '',
        brand: '',
        shop: '',
        minPrice: '',
        maxPrice: '',
    };
    applyFilters();
};

const loadMore = () => {
    const nextPage = pagination.value.currentPage + 1;
    router.get(
        route('products.all'),
        { ...filters.value, page: nextPage },
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (page) => {
                products.value.push(...page.props.products);
                pagination.value = page.props.pagination;
            },
        },
    );
};

const wishlist = ref(new Set());

function toggleWishlist(product) {
    if (wishlist.value.has(product.id)) {
        wishlist.value.delete(product.id);
    } else {
        wishlist.value.add(product.id);
    }
}

function isInWishlist(product) {
    return wishlist.value.has(product.id);
}

function getFeaturedImage(product) {
    return product.images.find((img) => img.is_featured);
}

function addToCart(product) {
    if (!props.auth?.user) {
        router.visit(route('login'));
        return;
    }

    router.post(
        route('carts.store'),
        {
            product_id: product.id,
            quantity: 1,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                alert(`Added "${product.name}" to cart!`);
                router.reload({ only: ['cartCount'] });
            },
            onError: (errors) => {
                alert('Something went wrong while adding to cart.');
                console.error(errors);
            },
        },
    );
}

function addToWhishList(product) {
    if (!props.auth?.user) {
        router.visit(route('login'));
        return;
    }

    router.post(
        route('whishlists.store'),
        {
            product_id: product.id,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                alert(`Added "${product.name}" to wishlist!`);
            },
            onError: (errors) => {
                alert('Something went wrong while adding to wishlist.');
                console.error(errors);
            },
        },
    );
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
