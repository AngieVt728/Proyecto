<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps({ filters: Object, orders: Object });
const form = useForm({});
const columns = ref([
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "deliver_date", label: "Fecha de Entrega" },
    { key: "status", label: "Estado de pedido" },
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
const addButton = reactive({ name: "Pedido", route: "orders" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            form.get(route("orders.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("orders.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar pedido?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog) {
                return goodDialogs.cancelled("Se canceló la acción", {
                    confirmButtonText: "Aceptar",
                });
            }
            form.delete(route("orders.destroy", { id: action.id }), {
                onSuccess: () => {
                    goodDialogs.createNotification(
                        "Pedido eliminado con éxito",
                        {
                            type: "success",
                        }
                    );
                    form.get(route("orders.index"));
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
    <Head title="Pedidos" />
    <authenticated-layout>
        <base-card title="Pedidos">
            <data-table
                :columns="columns"
                :content="orders"
                :filters="filters"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
