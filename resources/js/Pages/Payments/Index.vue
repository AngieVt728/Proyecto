<script setup>
import ButtonAdd from "@/Components/Buttons/AddButton.vue";
import CardData from "@/Components/cards/BaseCard.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["payments"]);
const items = ref(props.payments);
const itemsDisplay = ref(props.payments);
const searchQuery = ref("");

const columnsPayments = ref([
    { key: "id", label: "ID" },
    { key: "payment_date", label: "Fecha del Pago" },
    { key: "payment_balance", label: "Balance del Pago" },
    { key: "details", label: "Detalles" },
    { key: "order_id", label: "ID del Pedido" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);

const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Pagos" />
    <authenticated-layout>
        <card-data title="Pagos">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('payments.create')"
                        >Agregar Pago</button-add
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
