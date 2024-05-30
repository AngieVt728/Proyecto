<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["filters", "customers"]);
const form = useForm({});
const columns = ref([
    { key: "first_name", label: "Nombres", trucate: true },
    { key: "last_name", label: "Apellidos", trucate: true },
    { key: "ci", label: "Carnet de identidad" },
    {
        key: "email",
        label: "Correo electrónico",
        verify: "email_verified_at",
        truncate: true,
    },
    { key: "phone_number", label: "Teléfono o celular", truncate: true },
    { key: "address", label: "Dirección", truncate: true },
    { key: "created_at", label: "Fecha de creación", date: true },
    { key: "updated_at", label: "Ultima actualización", date: true },
]);
const options = ref([
    {
        id: "show",
        name: "Ver",
        icon: "hi-solid-eye",
        color: "text-green-500",
    },
    {
        id: "edit",
        name: "Actualizar",
        icon: "hi-solid-pencil",
        color: "text-blue-500",
    },
    {
        id: "destroy",
        name: "Eliminar",
        icon: "hi-solid-exclamation",
        color: "text-red-500",
    },
]);
const addButton = reactive({
    create: "Clientes",
    route: route("customers.create"),
});

const action = (action) => {
    switch (action.action) {
        case "show":
            form.get(route("customers.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("customers.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("customers.destroy", { id: action.id }), {
                onSuccess: () => {
                    toast.success("Cliente eliminado");
                    form.get(route("customers.index"));
                },
                onError: (errors) =>
                    Object.values(errors).forEach((message) => {
                        toast.error(message);
                    }),
            });
            break;
        default:
            break;
    }
};
</script>

<template>
    <Head title="Clientes" />
    <authenticated-layout>
        <base-card title="Clientes">
            <data-table
                :columns="columns"
                :content="customers"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
