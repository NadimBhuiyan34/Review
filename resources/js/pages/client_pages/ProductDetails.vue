 <template>
 <div class="bg-white py-12 px-6 sm:px-8 lg:px-20">
  <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-10">
    
    <!-- Product Image -->
    <div class="w-full lg:w-1/2">
      <img src="https://d2v5dzhdg4zhx3.cloudfront.net/web-assets/images/storypages/primary/ProductShowcasesampleimages/JPEG/Product+Showcase-1.jpg" alt="Product Image" class="rounded-xl shadow-lg w-full">
      <div class="flex gap-4 mt-4">
        <img src="https://via.placeholder.com/100x100" class="w-20 h-20 object-cover rounded-md border">
        <img src="https://via.placeholder.com/100x100/0000FF" class="w-20 h-20 object-cover rounded-md border">
        <img src="https://via.placeholder.com/100x100/FF0000" class="w-20 h-20 object-cover rounded-md border">
      </div>
    </div>

    <!-- Product Info -->
    <div class="w-full lg:w-1/2 space-y-6">
      <h1 class="text-4xl font-bold text-gray-900">Product Name</h1>
      <p class="text-lg text-gray-700">Category: <span class="font-medium">Men's Fashion</span></p>
      <p class="text-lg text-gray-700">Brand: <span class="font-medium">Awesome Brand</span></p>

      <div class="flex items-center gap-4 text-2xl mt-2">
        <span class="text-green-600 font-bold">$100.00</span>
        <span class="text-gray-500 line-through">$120.00</span>
      </div>

      <div class="flex flex-wrap gap-2 mt-4">
        <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">New</span>
        <span class="bg-red-100 text-red-700 text-sm px-3 py-1 rounded-full">Sale</span>
        <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">Summer</span>
      </div>

      <p class="text-gray-700 leading-relaxed mt-4">
        This is the long product description. It explains the product's features, usage, quality, and benefits in detail.
      </p>

      <div class="border-t pt-6 mt-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Specifications</h3>
        <ul class="text-gray-600 space-y-1">
          <li><strong>Color:</strong> Red</li>
          <li><strong>Material:</strong> Cotton</li>
          <li><strong>Weight:</strong> 1.2 kg</li>
          <li><strong>Dimensions:</strong> 10 x 5 x 3 (L x W x H)</li>
        </ul>
      </div>

      <div class="mt-6">
        <button class="bg-indigo-600 text-white px-6 py-3 rounded-md text-lg font-medium hover:bg-indigo-700 transition">
          Add to Cart
        </button>
        <p class="text-sm text-gray-500 mt-2">In stock: 20</p>
      </div>
    </div>

  </div>
</div>

</template>

<script>
export default {
  data() {
    return {
      // Static data (no dynamic functionality here)
      product: {
        name: "Product Name",
        price: 100.00,
        discount_price: 120.00,
        short_description: "Short description of the product.",
        description: "Detailed description of the product.",
        specifications: {
          Color: "Red",
          Size: "Medium",
          Material: "Cotton"
        },
        image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4QaRqKWxfrGdQ9r5U5mWg-RWItNxzmphX-Q&s",
        images: [
          "https://via.placeholder.com/600x600",
          "https://via.placeholder.com/600x600/0000FF",
          "https://via.placeholder.com/600x600/FF0000"
        ]
      }
    };
  }
};
</script>

<style scoped>
/* Add additional custom styling if needed */
</style>
