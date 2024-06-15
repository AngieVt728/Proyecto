<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, defineProps } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps<{
    // Define cualquier prop que necesites aquí
}>();

const router = useRouter(); // Instancia del enrutador

const orders = ref([
  {
    id: 1,
    date: '2024-06-01',
    deliveryDate: '2024-06-07',
    products: [
      { id: 1, name: 'Producto 1', price: 10, quantity: 2 },
      { id: 3, name: 'Producto 3', price: 30, quantity: 1 }
    ],
    status: 'Pendiente'
  },
  // Puedes agregar más pedidos aquí
]);

// Función para agregar un nuevo pedido
const addNewOrder = () => {
  router.push({ name: 'user.neworder' }); // Redirige a la ruta de nuevo pedido
};
</script>

<template>
  <home-layout>
    <Head title="Pedidos" />
    <div class="p-6 max-w-5xl mx-auto bg-white rounded-lg shadow-md">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Pedidos</h2>
        <!-- Botón para agregar un nuevo pedido -->
        <!--<button @click="addNewOrder" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          Nuevo Pedido
        </button>-->
      </div>

      <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4 text-center">Lista de Pedidos</h3>
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200">Fecha de Pedido</th>
              <th class="py-2 px-4 border-b border-gray-200">Fecha de Entrega</th>
              <th class="py-2 px-4 border-b border-gray-200">Productos</th>
              <th class="py-2 px-4 border-b border-gray-200">Estado del Pedido</th>
              <th class="py-2 px-4 border-b border-gray-200">Precio Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id" class="border-b">
              <td class="py-2 px-4">{{ order.date }}</td>
              <td class="py-2 px-4">{{ order.deliveryDate }}</td>
              <td class="py-2 px-4">
                <ul>
                  <li v-for="product in order.products" :key="product.id">
                    {{ product.quantity }} x {{ product.name }} - ${{ product.price * product.quantity }}
                  </li>
                </ul>
              </td>
              <td class="py-2 px-4">
                <span :class="order.status === 'Pendiente' ? 'text-yellow-500' : 'text-green-500'">{{ order.status }}</span>
              </td>
              <td class="py-2 px-4">
                ${{ order.products.reduce((sum, product) => sum + product.price * product.quantity, 0) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </home-layout>
</template>

<style>
body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    margin: 20px; /* Añade margen para separar el contenedor de los bordes */
    padding: 20px; /* Añade relleno dentro del contenedor */
    border: 1px solid #ccc; /* Añade un borde alrededor del contenedor */
    border-radius: 10px; /* Opcional: redondea las esquinas del borde */
    background-color: #f9f9f9; /* Cambia el color de fondo del contenedor */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Añade una sombra para un mejor efecto visual */
}
</style>
