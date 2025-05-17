<script setup lang="ts">
import { ref, defineProps } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps<{
  product: {
    id: string
    name: string
    images: []
  }
}>()

const selectedFile = ref<File | null>(null)
const previewUrl = ref<string | null>(null)
const isFeatured = ref(false)
const isSubmitting = ref(false)

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files.length > 0) {
    selectedFile.value = target.files[0]
    previewUrl.value = URL.createObjectURL(selectedFile.value)
  } else {
    selectedFile.value = null
    previewUrl.value = null
  }
}

const submitForm = () => {
  if (!selectedFile.value) {
    alert('Please select an image')
    return
  }

  isSubmitting.value = true

  const formData = new FormData()
  formData.append('image', selectedFile.value)
  formData.append('is_featured', isFeatured.value ? '1' : '0')
  formData.append('product_id', props.product.id)  // Important!

  router.post('/product_images', formData, {
    forceFormData: true,
    onFinish: () => {
      isSubmitting.value = false
      selectedFile.value = null
      previewUrl.value = null
      isFeatured.value = false
      // Optionally reload or fetch images here
    },
  })
}

const deleteImage = (id: string) => {
  if (!confirm('Are you sure you want to delete this image?')) {
    return
  }

  router.delete(`/product_images/${id}`, {
    onSuccess: () => {

    },
    onError: (errors) => {
      alert('Failed to delete image.')
      console.error(errors)
    }
  })
}

</script>

<template>

  <Head :title="`Upload Image • ${props.product.name}`" />
  <AppLayout :breadcrumbs="[{ title: 'Products', href: '/products' }, { title: 'Upload Image', href: '#' }]">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8 mt-12">
      <h2 class="text-center text-2xl font-semibold text-gray-800 mb-8">
        Upload Image for <span class="text-indigo-600 font-bold">{{ props.product.name }}</span>
      </h2>

      <form @submit.prevent="submitForm" class="space-y-6">
        <div>
          <label for="image" class="block text-gray-700 font-medium mb-2">Choose Image</label>
          <input type="file" id="image" accept="image/*" @change="handleFileChange" class="block w-full text-gray-700"
            required />
          <div v-if="previewUrl" class="mt-4 border rounded-md overflow-hidden max-h-64">
            <img :src="previewUrl" alt="Image preview" class="object-contain w-full h-full" />
          </div>
        </div>

        <div class="flex items-center space-x-3">
          <input type="checkbox" id="featured" v-model="isFeatured"
            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
          <label for="featured" class="text-gray-700 font-medium cursor-pointer select-none">
            Set as featured image
          </label>
        </div>

        <button type="submit" :disabled="isSubmitting" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-lg font-semibold
                 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1
                 disabled:bg-indigo-300 disabled:cursor-not-allowed transition-colors duration-200">
          {{ isSubmitting ? 'Uploading...' : 'Upload Image' }}
        </button>
      </form>
    </div>

     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-10">
    <div
      v-for="image in props.product.images"
      :key="image.id"
      class="group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300"
    >
      <!-- Image -->
      <div class="relative">
        <img
  :src="`/storage/${product.images[0]?.image_path}`"
  :alt="product.name"
  class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
/>

        <!-- Overlay -->
        <div
          class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-t-xl"
        ></div>

        <!-- Featured Badge -->
        <div
          v-if="image.is_featured"
          class="absolute top-3 left-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs px-3 py-1 rounded-full shadow-md select-none pointer-events-none"
        >
          🌟 Featured
        </div>

        <!-- Delete Button -->
        <Link
          as="button"
          :href="`/product_images/${image.id}`"
          class="absolute top-3 right-3 bg-white/90 hover:bg-white text-red-600 hover:text-red-800 rounded-full p-2 shadow-md transition duration-200 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-red-500"
          title="Delete Image"
          @click.prevent="deleteImage(image.id)"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span class="sr-only">Delete Image</span>
        </Link>
      </div>

      
    </div>
  </div>


  </AppLayout>
</template>
