<script setup>
import ButtonAdd from "@/Components/Buttons/AddButton.vue";
import CardData from "@/Components/cards/BaseCard.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["orders"]);
const items = ref(props.orders);
const itemsDisplay = ref(props.orders);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "detail", label: "Detalle" },
    { key: "order_date", label: "Fecha del Pedido" },
    { key: "delivery_deadline", label: "Fecha de Entrega" },
    { key: "customer_id", label: "ID del Cliente" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);

const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Pedidos" />
    <authenticated-layout>
        <card-data title="Pedidos">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('orders.create')"
                        >Agregar Nuevo Pedido</button-add
                    >
                </div> </template
            ><DataTable
                :columns="columns"
                :items="itemsDisplay"
                :options="options"
                @action="action"
            ></DataTable
        ></card-data>
    </authenticated-layout>
</template>
