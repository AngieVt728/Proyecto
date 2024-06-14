<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps(["filters", "products"]);
const form = useForm({});
const columns = ref([
    { key: "image", label: "Imagen de referencia", img: true },
    { key: "name", label: "Nombre Producto", truncate: true },
    { key: "price", label: "Precio" },
    { key: "stock", label: "Stock" },
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
const addButton = reactive({ name: "Producto", route: "products" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            form.get(route("products.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("products.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar producto?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog) {
                return goodDialogs.cancelled("Se canceló la acción", {
                    confirmButtonText: "Aceptar",
                });
            }
            form.delete(route("products.destroy", { id: action.id }), {
                onSuccess: () => {
                    goodDialogs.createNotification("Producto eliminado con éxito", {
                        type: "success",
                    });
                    form.get(route("products.index"));
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
    <Head title="Productos" />
    <authenticated-layout>
        <base-card title="Productos">
            <data-table
                :columns="columns"
                :content="products"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
