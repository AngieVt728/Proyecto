<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted, watch } from 'vue';
import Carousel from '@/Components/Customer/Carousel.vue';
import Card from '@/Components/Customer/Card.vue';
import Footer from '@/Components/Customer/Footer.vue';


const products = ref([]);

onMounted(async () => {
  try {
    const res = await getProductsRequest();
    products.value = res.data;
    console.log(products.value);
  } catch (error) {
    console.log(error);
  }
});

const pictures = ref([]);

watch(products, () => {
  pictures.value = products.value.map(product => ({ src: product.image, alt: product.name }));
});
</script>

<template>
  <home-layout>
    <Head title="Inicio" />
    <div class="container mx-auto px-4">
      <h2 class="text-2xl font-bold mb-4">PRODUCTOS DISPONIBLES</h2>
      <Carousel :pictures="pictures" />

      <h2 class="text-2xl font-bold my-4">Aquí se visualiza la info de los productos</h2>
      <div class="flex flex-wrap">
        <Card
          v-for="product in products"
          :key="product.id"
          :image="product.image"
          :title="product.name"
          :description="product.description"
          class="m-4"
        />
      </div>

      <Footer />
    </div>
  </home-layout>
</template>

<style>
/* Añade aquí cualquier estilo adicional si es necesario */
</style>
