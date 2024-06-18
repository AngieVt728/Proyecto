<template>
    <home-layout>
      <Head title="Inicio" />
      <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">PRODUCTOS DISPONIBLES</h2>
        <Carousel :pictures="pictures" />


        <!-- Mostrar las cards de productos con Card2.vue -->
        <h2 class="text-2xl font-bold my-4">Descripción de Productos </h2>
        <div class="flex flex-wrap">
          <Card2
            v-for="product in products"
            :key="product.id"
            :title="product.name"
            :description="product.description"
            class="m-4"
          />
        </div>

        <!-- Añadir el footer -->
        <Footer />
      </div>
    </home-layout>
  </template>

  <script setup lang="ts">
  import HomeLayout from "@/Layouts/HomeLayout.vue";
  import { Head } from "@inertiajs/vue3";
  import { ref } from "vue";
  import Carousel from "@/Components/Customer/Carousel.vue";
  import Card from "@/Components/Customer/Card.vue"; // Importa el componente Card.vue
  import Card2 from "@/Components/Customer/Card2.vue"; // Importa el componente Card2.vue
  import Footer from "@/Components/Customer/Footer.vue"; // Importa el componente Footer.vue

  const props = defineProps<{
    products: {
      id: number;
      name: string;
      image: string;
      price: number;
      stock: number;
      description: string;
    }[];
  }>();

  const pictures = ref(props.products.map(product => ({ src: product.image, alt: product.name })));
  </script>

  <style>
  /* Añade aquí cualquier estilo adicional si es necesario */
  </style>
