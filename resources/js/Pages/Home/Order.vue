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
import { goodDialogs } from "gooddialogs";
import { format } from "@formkit/tempo";

const props = defineProps<{ orders: Object }>();
console.log(props.orders);
</script>

<template>
    <HomeLayout>
        <Head title="Nuevo pedido" />
        <h2 class="text-2xl my-8 font-semibold text-gray-700 text-center">
            Todos sus pedidos
        </h2>
        <div class="flex justify-center items-center">
            <fwb-table class="w-[90%] lg:w-1/2">
                <fwb-table-head>
                    <fwb-table-head-cell>Fecha de pedido</fwb-table-head-cell>
                    <fwb-table-head-cell>Fecha de entrega</fwb-table-head-cell>

                    <fwb-table-head-cell>Estado</fwb-table-head-cell>
                </fwb-table-head>
                <fwb-table-body>
                    <fwb-table-row
                        v-for="(order, index) in props.orders"
                        :key="order.id"
                    >
                        <fwb-table-cell>{{
                            format(order.created_at)
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            format(order.deliver_date)
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{ order.status }}</fwb-table-cell>
                    </fwb-table-row>
                </fwb-table-body>
            </fwb-table>
        </div>
    </HomeLayout>
</template>
