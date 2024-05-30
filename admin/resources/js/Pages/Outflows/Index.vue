<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps({ filters: Object, outflows: Object });
const form = useForm({});
const columns = ref([
    { key: "outflow_date", label: "Fecha de Salida" },
    { key: "quantity", label: "Cantidad" },
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
const addButton = reactive({
    create: "Salida",
    route: route("outflows.create"),
});

const action = (action) => {
    switch (action.action) {
        case "show":
            form.get(route("outflows.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("outflows.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("outflows.destroy", { id: action.id }), {
                onSuccess: () => {
                    toast.success("Salida eliminada");
                    form.get(route("outflows.index"));
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
    <Head title="Salidas" />
    <authenticated-layout>
        <base-card title="Salidas">
            <data-table
                :columns="columns"
                :content="outflows"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
