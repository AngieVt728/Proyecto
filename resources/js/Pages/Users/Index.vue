<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";
import { reactive, ref } from "vue";

const props = defineProps(["filters", "users"]);
const columns = ref([
    { key: "image_url", label: "Avatar", img: true },
    { key: "username", label: "Nombre se usuario", truncate: true },
    { key: "first_name", label: "Nombres", truncate: true },
    { key: "last_name", label: "Apellidos", truncate: true },
    { key: "ci", label: "Carnet de identidad" },
    { key: "email", label: "Correo electrónico", truncate: true },
    { key: "contact", label: "Teléfono o celular", truncate: true },
    { key: "role", label: "Rol" },
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
const addButton = reactive({ name: "Usuario", route: "users" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            router.get(route("users.show", { id: action.id }));
            break;
        case "edit":
            router.get(route("users.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar usuario?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog)
                return goodDialogs.cancelled("Se cancelo la acción", {
                    confirmButtonText: "Aceptar",
                });
            router.delete(route("users.destroy", { id: action.id }), {
                onSuccess: () =>
                    goodDialogs.createNotification(
                        "Usuario eliminado con éxito",
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
    <Head title="Usuarios" />
    <authenticated-layout>
        <base-card title="Usuarios">
            <data-table
                :columns="columns"
                :content="users"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
