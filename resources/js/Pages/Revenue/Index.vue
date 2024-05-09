<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps(["users"]);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "description", label: "Descripción" },
    { key: "revenue_date", label: "Fecha de Ingreso", date: true },
    { key: "quantity", label: "Cantidad" },
    { key: "product_id", label: "ID del Producto" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);

const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Ingresos" />
    <authenticated-layout>
        <card-data title="Ingresos">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('ingresos.create')"
                        >Agregar Ingreso</button-add
                    >
                </div> </template
            ><DataTable
                :columns="columns"
                :items="incomes"
                :options="options"
                @action="action"
            ></DataTable
        ></card-data>
    </authenticated-layout>
</template>
