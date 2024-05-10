<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["sales"]);
const items = ref(props.sales);
const itemsDisplay = ref(props.sales);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "description", label: "Descripción" },
    { key: "quantity", label: "Cantidad" },
    { key: "product_id", label: "Nombre del Producto" },
    { key: "price", label: "Precio Total" },
    { key: "retail_outlet_id", label: "Punto de Venta" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);

const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Ventas" />
    <authenticated-layout>
        <card-data title="Ventas">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('sales.create')"
                        >Agregar Nueva Venta</button-add
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
