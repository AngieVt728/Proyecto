<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps({ filters: Object, sales: Object });
const form = useForm({});
const columns = ref([
    { key: "quantity", label: "Cantidad" },
    { key: "total_price", label: "Precio total" },
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
const addButton = reactive({ name: "Venta", route: "sales" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            form.get(route("sales.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("sales.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar venta?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog) {
                return goodDialogs.cancelled("Se canceló la acción", {
                    confirmButtonText: "Aceptar",
                });
            }
            form.delete(route("sales.destroy", { id: action.id }), {
                onSuccess: () => {
                    goodDialogs.createNotification("Venta eliminada con éxito", {
                        type: "success",
                    });
                    form.get(route("sales.index"));
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
    <Head title="Ventas" />
    <authenticated-layout>
        <base-card title="Ventas">
            <data-table
                :columns="columns"
                :content="sales"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
