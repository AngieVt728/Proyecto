<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { format } from "@formkit/tempo";
import { ref } from "vue";
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";

const props = defineProps<{
    order: Object;
    orderProducts: Object;
    products: Object;
    totalPrice: float;
}>();

const formatOrder = ref(props.order);
formatOrder.value.created_at = format(
    formatOrder.created_at,
    "dddd, MMMM D, YYYY h:mm:ss a",
    "es"
);
formatOrder.value.deliver_date = format(
    formatOrder.deliver_date,
    "dddd, MMMM D, YYYY h:mm:ss a",
    "es"
);

const handleSubmit = () => {
    router.get(route("orders.edit", { order: props.order }));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="order.deliver_date" />
        <Form
            title="Información de pedido"
            type-submit="edit"
            @handle-submit="handleSubmit"
        >
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Datos de pedido
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mx-8">
                <Input
                    id="created_at"
                    label-text="Fecha de pedido"
                    v-model="formatOrder.created_at"
                    type="text"
                    :disabled="true"
                />
                <Input
                    id="deliver_date"
                    label-text="Fecha de entrega"
                    v-model="formatOrder.deliver_date"
                    type="text"
                    :disabled="true"
                />
                <Input
                    id="status"
                    label-text="Estado de pedido"
                    v-model="formatOrder.status"
                    type="text"
                    :disabled="true"
                />
            </div>
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Productos de pedido
            </h2>
            <div class="flex justify-center items-center my-4">
                <fwb-table class="w-[90%] lg:w-1/2">
                    <fwb-table-head>
                        <fwb-table-head-cell>Nombre</fwb-table-head-cell>
                        <fwb-table-head-cell>Precio</fwb-table-head-cell>

                        <fwb-table-head-cell>Cantidad</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(product, index) in products"
                            :key="product.id"
                        >
                            <fwb-table-cell>{{ product.name }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.price }}</fwb-table-cell>
                            <fwb-table-cell>{{
                                product.quantity
                            }}</fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
            </div>
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Precio total de pedido
            </h2>
            <div class="flex justify-center py-4">
                <p class="text-2xl font-bold text-gray-700">
                    {{ totalPrice }} Bs.
                </p>
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
