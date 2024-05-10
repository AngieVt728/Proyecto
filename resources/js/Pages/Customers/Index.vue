<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["customers"]);
const items = ref(props.customers);
const itemsDisplay = ref(props.customers);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "first_name", label: "Nombre/s" },
    { key: "last_name", label: "Apellidos" },
    { key: "email", label: "Correo electrónico" },
    { key: "ci", label: "CI" },
    { key: "created_at", label: "Fecha creación", date: true },
    { key: "updated_at", label: "Fecha actualización", date: true },
]);
const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Clientes" />
    <authenticated-layout>
        <card-data title="Clientes">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('customers.create')"
                        >Agregar Cliente</button-add
                    >
                </div></template
            ><DataTable
                :columns="columns"
                :items="itemsDisplay"
                :options="options"
                @action="action"
            ></DataTable
        ></card-data>
    </authenticated-layout>
</template>
