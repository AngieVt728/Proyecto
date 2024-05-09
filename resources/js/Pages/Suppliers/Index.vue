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
    { key: "legal_name", label: "Razón Social" },
    { key: "nit", label: "NIT" },
    { key: "description", label: "Descripción" },
    { key: "email", label: "Correo electrónico" },
    { key: "phone_number", label: "Número de Teléfono" },
    { key: "address", label: "Dirección" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);

const options = ref([
    { id: "update", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "delete", name: "Eliminar", icon: "hi-solid-exclamation" },
]);
</script>

<template>
    <Head title="Proveedores" />
    <authenticated-layout>
        <card-data title="Proveedores">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('users.create')"
                        >Agregar Proveedor</button-add
                    >
                </div> </template
            ><DataTable
                :columns="columns"
                :items="users"
                :options="options"
                @action="action"
            ></DataTable
        ></card-data>
    </authenticated-layout>
</template>
