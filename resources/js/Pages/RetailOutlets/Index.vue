<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["retail_outlets"]);
const items = ref(props.retail_outlets);
const itemsDisplay = ref(props.retail_outlets);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Nombre" },
    { key: "description", label: "Descripción" },
    { key: "address", label: "Dirección" },
    { key: "customer_id", label: "Nombre del Cliente" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);

const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Puntos de Venta" />
    <authenticated-layout>
        <card-data title="Puntos de Venta">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('retail-outlets.create')"
                        >Agregar Punto de Venta</button-add
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
