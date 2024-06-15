<template>
    <div class="p-6 max-w-3xl mx-auto bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Nuevo Pedido</h2>
        <form class="space-y-6">
            <div>
                <label for="customerName" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                <input type="text" id="customerName" v-model="customerName" disabled class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Dirección del Punto de Venta</label>
                <input type="text" id="address" v-model="address" disabled class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="orderDate" class="block text-sm font-medium text-gray-700">Fecha de Pedido</label>
                <input type="date" id="orderDate" v-model="orderForm.orderDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="deliveryDate" class="block text-sm font-medium text-gray-700">Fecha de Entrega</label>
                <input type="date" id="deliveryDate" v-model="orderForm.deliveryDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-700">Productos</h3>
                <div v-for="(product, index) in orderForm.products" :key="index" class="mt-4 space-y-2">
                    <div class="flex items-center space-x-4">
                        <input type="text" v-model="product.name" placeholder="Nombre del Producto" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        <input type="number" v-model="product.quantity" min="1" placeholder="Cantidad" class="w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        <input type="number" v-model="product.price" min="0" step="0.01" placeholder="Precio" class="w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        <button type="button" @click="removeProduct(index)" class="text-red-600 hover:text-red-800 focus:outline-none">
                            &times;
                        </button>
                    </div>
                </div>
                <button type="button" @click="addProduct" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Agregar Producto
                </button>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Estado del Pedido</label>
                <select id="status" v-model="orderForm.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option>Pendiente</option>
                    <option>Entregado</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Guardar Pedido
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const customerName = ref('Juan Pérez');
const address = ref('Calle Falsa 123, Ciudad Ejemplo');

const orderForm = ref({
    orderDate: '',
    deliveryDate: '',
    products: [{ name: '', quantity: 1, price: 0 }],
    status: 'Pendiente'
});

const addProduct = () => {
    orderForm.value.products.push({ name: '', quantity: 1, price: 0 });
};

const removeProduct = (index) => {
    orderForm.value.products.splice(index, 1);
};
</script>

<style>
body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    margin: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
