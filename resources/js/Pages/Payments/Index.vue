<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps({ filters: Object, payments: Object });
const form = useForm({});
const columns = ref([
    { key: "detail", label: "Detalle", truncate: true },
    { key: "payment_date", label: "Fecha del Pago" },
    { key: "payment_balance", label: "Balance del Pago" },
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
    // {
    //     id: "edit",
    //     name: "Actualizar",
    //     icon: "hi-solid-pencil",
    //     color: "text-blue-500",
    // },
    {
        id: "destroy",
        name: "Eliminar",
        icon: "hi-solid-exclamation",
        color: "text-red-500",
    },
]);
const addButton = reactive({ name: "Pago", route: "payments" });

const action = async (action) => {
    switch (action.action) {
        case "show":
            form.get(route("payments.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("payments.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm("¿Eliminar pago?", {
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            });
            if (!resDialog) {
                return goodDialogs.cancelled("Se canceló la acción", {
                    confirmButtonText: "Aceptar",
                });
            }
            form.delete(route("payments.destroy", { id: action.id }), {
                onSuccess: () => {
                    goodDialogs.createNotification("Pago eliminado con éxito", {
                        type: "success",
                    });
                    form.get(route("payments.index"));
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
    <Head title="Pagos" />
    <authenticated-layout>
        <base-card title="Pagos">
            <data-table
                :columns="columns"
                :content="payments"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
