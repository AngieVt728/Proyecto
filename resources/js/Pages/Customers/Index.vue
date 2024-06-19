<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";
import { reactive, ref } from "vue";

const props = defineProps(["filters", "customers"]);
const columns = ref([
    { key: "image_url", label: "Avatar", img: true },
    { key: "username", label: "Nombre de usuario", truncate: true },
    { key: "first_name", label: "Nombres", truncate: true },
    { key: "last_name", label: "Apellidos", truncate: true },
    { key: "ci", label: "Carnet de identidad" },
    { key: "email", label: "Correo electrónico", truncate: true },
    { key: "contact", label: "Teléfono o celular", truncate: true },
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
const addButton = reactive({ name: "Clientes", route: "customers" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            router.get(route("customers.show", { id: action.id }));
            break;
        case "edit":
            router.get(route("customers.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar cliente?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog)
                return goodDialogs.cancelled("Se cancelo la acción", {
                    confirmButtonText: "Aceptar",
                });
            router.delete(route("customers.destroy", { id: action.id }), {
                onSuccess: () =>
                    goodDialogs.createNotification(
                        "Cliente eliminado con éxito",
                        { type: "success" }
                    ),
                onError: (errors) =>
                    Object.values(errors).forEach((message) => {
                        goodDialogs.createNotification(message, {
                            type: "error",
                        });
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
