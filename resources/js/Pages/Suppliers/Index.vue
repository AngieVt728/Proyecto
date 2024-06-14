<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps(["filters", "suppliers"]);
const form = useForm({});
const columns = ref([
    { key: "name", label: "Razón Social", truncate: true },
    { key: "nit", label: "NIT" },
    { key: "email", label: "Correo electrónico", truncate: true },
    { key: "phone_number", label: "Número de Teléfono", truncate: true },
    { key: "address", label: "Dirección", truncate: true },
    { key: "description", label: "Descripción", truncate: true },
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
const addButton = reactive({ name: "Proveedor", route: "suppliers" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            form.get(route("suppliers.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("suppliers.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar proveedor?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog) {
                return goodDialogs.cancelled("Se canceló la acción", {
                    confirmButtonText: "Aceptar",
                });
            }
            form.delete(route("suppliers.destroy", { id: action.id }), {
                onSuccess: () => {
                    goodDialogs.createNotification("Proveedor eliminado con éxito", {
                        type: "success",
                    });
                    form.get(route("suppliers.index"));
                },
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
    <Head title="Proveedores" />
    <authenticated-layout>
        <base-card title="Proveedores">
            <data-table
                :columns="columns"
                :content="suppliers"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
