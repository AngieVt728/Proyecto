<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps({ filters: Object, revenues: Object });
const form = useForm({});
const columns = ref([
    { key: "revenue_date", label: "Fecha de Ingreso" },
    { key: "quantity", label: "Cantidad" },
    { key: "description", label: "Descripción", truncate: true },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
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
const addButton = reactive({ name: "Ingreso", route: "revenues" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            form.get(route("revenues.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("revenues.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar ingreso?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog) {
                return goodDialogs.cancelled("Se canceló la acción", {
                    confirmButtonText: "Aceptar",
                });
            }
            form.delete(route("revenues.destroy", { id: action.id }), {
                onSuccess: () => {
                    goodDialogs.createNotification("Ingreso eliminado con éxito", {
                        type: "success",
                    });
                    form.get(route("revenues.index"));
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
    <Head title="Ingresos" />
    <authenticated-layout>
        <base-card title="Ingresos">
            <data-table
                :columns="columns"
                :content="revenues"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
