<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CardData from "@/Components/cards/CardData.vue";
import { Head } from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-select";
import "datatables.net-responsive";

defineProps(["users"]);
DataTable.use(DataTablesCore);

const columns = [
    { data: "first_name", title: "Nombres" },
    { data: "last_name", title: "Apellidos" },
    { data: "email", title: "Correo electronico" },
    { data: "ci", title: "Carnet de identidad" },
    { data: "phone_number", title: "Teléfono" },
    { data: "address", title: "Dirección" },
    { data: "created_at", title: "Fecha de creación" },
    { data: "updated_at", title: "Ultima modificación" },
];
</script>

<template>
    <Head title="Usuarios" />
    <AuthenticatedLayout>
        <card-data title="Usuarios">
            <DataTable
                :columns="columns"
                :data="users"
                class="py-4 overflow-x-auto"
            /> </card-data
    ></AuthenticatedLayout>
</template>
