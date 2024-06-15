<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue'; // Importa las funciones onMounted y ref de Vue
import Card from '@/Components/Customer/Card.vue'; // Importa el componente de tarjeta personalizado

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

// // Crea una referencia reactiva para almacenar los productos
// const products = ref(props.products);

// // Productos de ejemplo para mostrar mientras no se usa la API
// const exampleProducts = [
//   {
//     id: 1,
//     image: 'https://via.placeholder.com/150',
//     name: 'Producto 1',
//     description: 'Descripción del producto 1',
//   },
//   {
//     id: 2,
//     image: 'https://via.placeholder.com/150',
//     name: 'Producto 2',
//     description: 'Descripción del producto 2',
//   },
//   // Agrega más productos de ejemplo según sea necesario
// ];

// products.value = exampleProducts;
</script>

<template>
    <home-layout>
        <Head title="Productos" />
        <div class="flex justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Itera sobre cada producto en la lista de productos -->
                <div v-for="product in products" :key="product.id">
                    <!-- Renderiza una tarjeta para cada producto -->
                    <Card :image="product.image" :imgAlt="product.name" :title="product.name" :description="product.description" />
                </div>
            </div>
        </div>
    </home-layout>
</template>

