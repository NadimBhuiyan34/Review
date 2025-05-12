<script setup lang="ts">
import AppLayout from '@/layouts/ClientLayout.vue'
import { Head } from '@inertiajs/vue3'

import Slider from '@/components/client_side/layout/Slider.vue'
import FeaturedProduct from '@/components/client_side/home/FeaturedProduct.vue'
import Category from '@/components/client_side/home/Category.vue'
import NewArrivals from '@/components/client_side/home/NewArrivals.vue'
import FlashDeals from '@/components/client_side/home/FlashDeals.vue'
import WhyChooseUs from '@/components/client_side/home/ChooseUs.vue'
import Testimonials from '@/components/client_side/home/Testimonials.vue'
import NewsletterSignup from '@/components/client_side/home/NewsletterSignup.vue'

// Slider data
const dynamicProducts = [
  {
    name: 'Product 1',
    description: 'This is a great product',
    price: '$49.99',
    image: 'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/627ab1121502531.60c775945f4bf.png',
  },
  {
    name: 'Product 2',
    description: 'Another awesome product',
    price: '$69.99',
    image: 'https://img.freepik.com/free-psd/black-friday-super-sale-facebook-cover-banner-template_120329-5177.jpg?semt=ais_hybrid&w=740',
  },
  {
    name: 'Product 3',
    description: 'Will make your life easier',
    price: '$89.99',
    image: 'https://img.freepik.com/free-psd/black-friday-super-sale-web-banner-template_120329-3862.jpg?semt=ais_hybrid&w=740',
  },
]

const products = [
  {
    id: 1,
    name: 'Wireless Headphones',
    description: 'High-quality noise-canceling headphones.',
    price: '$199',
    image: 'https://d2v5dzhdg4zhx3.cloudfront.net/web-assets/images/storypages/primary/ProductShowcasesampleimages/JPEG/Product+Showcase-1.jpg',
    badge: 'New',
  },
  {
    id: 2,
    name: 'Smartwatch',
    description: 'Track activities, health, and more.',
    price: '$299',
    image: '/images/watch.jpg',
    badge: 'Sale',
  },
  {
    id: 3,
    name: 'Retro Sneakers',
    description: 'Comfortable and trendy sneakers.',
    price: '$89',
    image: '/images/sneakers.jpg',
    badge: '',
  },
]

const categories = [
  { name: 'Electronics', image: 'https://cdn-icons-png.flaticon.com/512/1555/1555401.png' },
  { name: 'Fashion', image: '/img/fashion.jpg' },
  { name: 'Home & Living', image: '/img/home.jpg' },
  { name: 'Books', image: '/img/books.jpg' },
  { name: 'Toys', image: '/img/toys.jpg' },
  { name: 'Beauty', image: '/img/beauty.jpg' },
  { name: 'Sports', image: '/img/sports.jpg' },
  { name: 'Groceries', image: '/img/grocery.jpg' },
]

const newArrivals = [
  {
    id: 1,
    name: 'Eco-Friendly Water Bottle',
    price: '$24.99',
    image: '/images/bottle.jpg',
  },
  {
    id: 2,
    name: 'Bluetooth Speaker',
    price: '$39.99',
    image: '/images/speaker.jpg',
  },
]

const flashDeals = [
  {
    id: 1,
    name: 'LED Lamp',
    description: 'Brighten your workspace.',
    price: '$14.99',
    image: '/images/lamp.jpg',
  },
  {
    id: 2,
    name: 'Gaming Mouse',
    description: 'Precision and comfort combined.',
    price: '$29.99',
    image: '/images/mouse.jpg',
  },
]

const features = [
  {
    icon: '🚚',
    title: 'Free Shipping',
    description: 'On all orders above $50.',
  },
  {
    icon: '💳',
    title: 'Secure Payments',
    description: '100% secure & encrypted.',
  },
  {
    icon: '⚡',
    title: 'Fast Delivery',
    description: 'We deliver within 48 hours.',
  },
]

const testimonials = [
  {
    name: 'Alice Smith',
    message: 'Amazing service and quick delivery!',
    role: 'Happy Customer',
  },
  {
    name: 'Bob Johnson',
    message: 'Great quality and affordable prices.',
    role: 'Verified Buyer',
  },
]
</script>

<template>
  <Head title="Home" />

  <AppLayout>
    <section class="max-w-7xl mx-auto ">
      <!-- Hero / Slider -->
      <Slider :sliders="dynamicProducts" />

      <!-- Featured Products -->
      <FeaturedProduct :products="products" />

      <!-- Product Categories -->
      <Category :categories="categories" />

      <!-- New Arrivals -->
      <NewArrivals :arrivals="newArrivals" />

      <!-- Flash Deals -->
      <FlashDeals :deals="flashDeals" />

      <!-- Why Choose Us -->
      <WhyChooseUs :features="features" />

      <!-- Testimonials -->
      <Testimonials :testimonials="testimonials" />

      <!-- Newsletter Signup -->
      <NewsletterSignup />
    </section>
  </AppLayout>
</template>
