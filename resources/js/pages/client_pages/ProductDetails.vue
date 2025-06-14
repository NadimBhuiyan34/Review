<script setup>
import Review from '@/components/client_side/product/Review.vue';
import AppLayout from '@/layouts/ClientLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, defineProps, ref } from 'vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    reviews: {
        type: Array,
        required: true,
    },
});

const page = usePage();
const user = computed(() => page.props.auth?.user);

function getFeaturedImage(product) {
    return product.images.find((img) => img.is_featured) || product.images[0];
}

const mainImage = ref(getFeaturedImage(props.product));

function changeMainImage(img) {
    mainImage.value = img;
}

function addToCart(product) {
    if (!user.value) {
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

const tagList = computed(() => props.product.tags.split(',').map((tag) => tag.trim()));
</script>


<template>
    <Head :title="product.name" />

    <AppLayout>
        <div
            class="flex max-w-[1400px] mx-auto"
        >
            <div class="flex w-full flex-col gap-12 my-5  bg-white p-10 text-gray-900 shadow-lg lg:flex-row">
                <!-- Left: Images -->
                <div class="flex flex-col gap-6 lg:w-1/2">
                    <div class="cursor-pointer overflow-hidden rounded-2xl border border-gray-200 transition-shadow duration-400 hover:shadow-md">
                        <img
                            :src="`/storage/${mainImage.image_path}`"
                            alt="Main Product Image"
                            class="h-[520px] w-full rounded-2xl object-cover transition-transform duration-300 hover:scale-105"
                        />
                    </div>

                    <div class="flex flex-wrap justify-center gap-4 lg:justify-start">
                        <button
                            v-for="(img, idx) in product.images"
                            :key="idx"
                            @click="changeMainImage(img)"
                            :class="[
                                'h-20 w-20 overflow-hidden rounded-lg border border-gray-300 bg-gray-100 transition-all duration-200',
                                mainImage.image_path === img.image_path ? 'scale-105 border-gray-800' : '',
                            ]"
                        >
                            <img :src="`/storage/${img.image_path}`" alt="Thumbnail" class="h-full w-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Right: Product Info -->
                <div class="flex flex-col justify-between lg:w-1/2">
                    <div>
                        <h1 class="mb-4 text-4xl font-bold">
                            {{ product.name }}
                        </h1>

                        <p class="mb-3 text-sm font-medium tracking-wider text-gray-500 uppercase">
                            {{ product.category.name }} • {{ product.brand.name }}
                        </p>

                        <div class="mb-5 flex items-center gap-4 text-2xl font-semibold">
                            <span class="text-gray-900">{{ product.price - product.discount_price }} TK</span>
                            <span class="text-lg font-normal text-gray-400 line-through"> {{ product.price.toFixed(2) }} TK </span>
                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                Save {{ Math.round((product.discount_price / product.price) * 100) }}%
                            </span>
                        </div>

                        <div class="mb-6 flex flex-wrap gap-2">
                            <span
                                v-for="(tag, index) in tagList"
                                :key="index"
                                class="rounded-full bg-blue-200 px-3 py-1 text-xs font-medium text-gray-700 uppercase"
                            >
                                {{ tag.trim() }}
                            </span>
                        </div>

                        <p class="mb-8 text-justify text-base leading-relaxed text-gray-700">
                            {{ product.description }}
                        </p>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="mb-4 text-lg font-semibold">Specifications</h3>
                            <ul class="grid grid-cols-1 gap-x-8 gap-y-3 text-sm text-gray-600 sm:grid-cols-2">
                                <li><strong class="text-gray-800">Weight:</strong> {{ product.weight }}</li>
                                <li><strong class="text-gray-800">Length:</strong> {{ product.length }}</li>
                                <li><strong class="text-gray-800">Width:</strong> {{ product.width }}</li>
                                <li><strong class="text-gray-800">Height:</strong> {{ product.height }}</li>
                                <li><strong class="text-gray-800">Specifications:</strong> {{ product.specifications }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row">
                        <!-- <button
                            class="w-full rounded-lg bg-gray-900 px-8 py-3 font-semibold text-white transition-colors duration-200 hover:bg-gray-800 sm:w-auto"
                        >
                            Add to Cart
                        </button> -->
                        <button
                            @click="addToCart(product)"
                            class="flex w-full items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700 sm:w-auto"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6H19m-9 0a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z"
                                />
                            </svg>
                            Add to Cart
                        </button>

                        <p class="text-sm text-gray-600 select-none"><span class="font-medium text-gray-800">In stock:</span> 20</p>
                    </div>
                </div>
            </div>
        </div>

        <Review :reviews = "reviews" :product_id = "product.id" :product_slug = "product.slug" />
    </AppLayout>
</template>
