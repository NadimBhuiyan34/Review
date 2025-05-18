 <template>
  <section class="bg-gray-100 px-6 py-20">
    <div class="mx-auto max-w-7xl">
      <!-- Section Heading -->
      <div class="mb-12 text-center">
        <h2 class="text-4xl font-extrabold text-gray-900">
          Explore <span class="text-indigo-600">Our Products</span>
        </h2>
        <div class="mx-auto mt-3 h-1 w-24 rounded-full bg-indigo-600"></div>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
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
              :src="`/storage/${getFeaturedImage(product).image_path}`"
              :alt="product.name"
              class="clip-custom h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
              loading="lazy"
            />

            <!-- Wishlist Button -->
            <button
              @click.stop="toggleWishlist(product)"
              class="absolute top-4 left-4 z-20 rounded-full bg-white p-2 text-gray-400 shadow-md transition duration-300 hover:text-red-600 hover:shadow-lg"
              :aria-label="'Add ' + product.name + ' to wishlist'"
            >
              <!-- Filled Heart -->
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
              <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 stroke-current"
                fill="none"
                viewBox="0 0 24 24"
              >
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
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
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
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref, defineProps } from 'vue'

// Props
const props = defineProps({
  products: {
    type: Array,
    required: true,
  },
  auth: {
    type: Object,
    required: true,
  },
})

// Wishlist state
const wishlist = ref(new Set())

// Toggle wishlist
function toggleWishlist(product) {
  if (wishlist.value.has(product.id)) {
    wishlist.value.delete(product.id)
  } else {
    wishlist.value.add(product.id)
  }
}

// Check if product is in wishlist
function isInWishlist(product) {
  return wishlist.value.has(product.id)
}

// Get featured image from product
function getFeaturedImage(product) {
  return product.images.find((img) => img.is_featured)
}

// Add to cart function
function addToCart(product) {
  if (!props.auth?.user) {
    router.visit(route('login'))
    return
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
        alert(`Added "${product.name}" to cart!`)
        router.reload({ only: ['cartCount'] });
      },
      onError: (errors) => {
        alert('Something went wrong while adding to cart.')
        console.error(errors)
      },
    }
  )
}
</script>

<style scoped>
.clip-custom {
  clip-path: polygon(0 0, 100% 0, 100% 75%, 0% 100%);
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.group:hover .clip-custom {
  transform: scale(1.1);
}
</style>
