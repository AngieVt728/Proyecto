<script setup>
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { format } from "@formkit/tempo";

const props = defineProps(["products"]);
const form = useForm({
    detail: "", // Aquí se almacenará el detalle como una cadena JSON
    order_date: new Date(),
    deliver_date: new Date(),
});
const orders = ref([]);
const selectedProduct = ref("");

const addProduct = () => {
    const product = props.products.find(
        (p) => p.id === parseInt(selectedProduct.value)
    );
    if (product) {
        orders.value.push(product);
    }
    selectedProduct.value = ""; // Limpiar la selección
};

const handleSubmit = () => {
    // Convertir orders a cadena JSON y asignarlo a form.detail
    orders.value.forEach((product) => {
        form.detail += " " + product.id;
    });
    // form.detail = JSON.stringify(orders.value);
    // Enviar el formulario usando Inertia.js
    form.order_date = format(form.order_date, "YYYY-MM-DD");
    form.delivery_date = format(form.order_date, "YYYY-MM-DD");
    form.post(route("user.order-store"), {
        onSuccess: () => {
            // Limpiar el formulario y cualquier otro estado necesario
            orders.value = [];
            form.detail = "";
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};

console.log(props.products);
</script>

<template>
    <home-layout>
        <Head title="Nuevo pedido" />
        <div class="p-6 max-w-3xl mx-auto bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Nuevo Pedido</h2>
            <form class="space-y-6" @submit.prevent="handleSubmit">
                <div class="flex justify-between items-center">
                    <label class="font-semibold text-sm" for="delivery_date">
                        Fecha de entrega estimada
                    </label>
                    <input
                        class="w-full mt-4 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                        type="date"
                        name="delivery_date"
                        id="delivery_date"
                        v-model="form.deliver_date"
                    />
                </div>
                <div class="flex justify-between items-center">
                    <select
                        v-model="selectedProduct"
                        class="mt-4 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    >
                        <option disabled value="">
                            Seleccionar una opción
                        </option>
                        <option
                            v-for="product in products"
                            :key="product.id"
                            :value="product.id"
                        >
                            {{ product.name }}
                        </option>
                    </select>
                    <button
                        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        type="button"
                        @click="addProduct"
                    >
                        Agregar producto
                    </button>
                </div>
                <div>
                    <h2>Productos agregados</h2>
                    <ul>
                        <li v-for="order in orders" :key="order.id">
                            {{ order.name }}
                        </li>
                    </ul>
                </div>
                <button
                    class="w-full mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    type="submit"
                >
                    Hacer pedido
                </button>
            </form>
        </div>
    </home-layout>
</template>

<!-- <template>
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
</style> -->
