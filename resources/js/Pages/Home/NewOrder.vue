<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";
import { ref, reactive } from "vue";
import { getUser } from "@/Composables/usePage";
import { goodDialogs } from "gooddialogs";

const user = getUser();
const props = defineProps<{ products: Object }>();
const form = useForm({
    deliver_date: "",
    products: reactive(
        props.products.map((product) => ({
            product_id: product.id,
            quantity: 1,
        }))
    ),
});

const handleSubmit = () => {
    console.log(form);
    console.log("Hacer pedido");
    if (form.products.some((p) => p.quantity < 1)) {
        goodDialogs.createNotification(
            "La cantidad no puede ser negativa o cero.",
            {
                type: "error",
            }
        );
        return;
    }
    form.post(route("user.store-order"), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () =>
            goodDialogs.createNotification("Pedido realizado con éxito", {
                type: "success",
            }),
        onError: (errors) =>
            Object.values(errors).forEach((message) => {
                goodDialogs.createNotification(message, {
                    type: "error",
                });
            }),
    });
};
</script>

<template>
    <HomeLayout>
        <Head title="Nuevo pedido" />
        <h2 class="text-2xl my-8 font-semibold text-gray-700 text-center">
            Productos a pedir
        </h2>
        <form @submit.prevent="handleSubmit">
            <div class="flex justify-around items-center flex-wrap my-4">
                <div class="grid grid-cols-1 gap-1">
                    <label
                        class="text-xs text-center text-gray-700"
                        for="deliver_date"
                        >Fecha estimada de entrega</label
                    >
                    <input
                        class="border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                        v-model="form.deliver_date"
                        type="date"
                        name="deliver_date"
                        id="deliver_date"
                    />
                </div>
                <button
                    class="flex items-center px-6 py-2 font-medium tracking-wide text-white transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
                    type="submit"
                >
                    Hacer pedido
                </button>
            </div>
            <div class="flex justify-center items-center">
                <fwb-table class="w-[90%] lg:w-1/2">
                    <fwb-table-head>
                        <fwb-table-head-cell
                            >Nombre del producto</fwb-table-head-cell
                        >
                        <fwb-table-head-cell>Descripción</fwb-table-head-cell>

                        <fwb-table-head-cell>Precio Bs.</fwb-table-head-cell>
                        <fwb-table-head-cell>Cantidad</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(product, index) in props.products"
                            :key="product.id"
                        >
                            <fwb-table-cell>{{ product.name }}</fwb-table-cell>
                            <fwb-table-cell>{{
                                product.description
                            }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.price }}</fwb-table-cell>
                            <fwb-table-cell>
                                <input
                                    v-model.number="
                                        form.products[index].quantity
                                    "
                                    class="w-24 text-center border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                                    type="number"
                                    min="1"
                                    required
                                />
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
            </div>
        </form>
    </HomeLayout>
</template>
