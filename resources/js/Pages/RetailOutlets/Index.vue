<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import DataTable from "@/Components/Tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";
import { reactive, ref } from "vue";

const props = defineProps(["filters", "retailOutlets"]);
const columns = ref([
    { key: "image", label: "Imagen de referencia", img: true },
    { key: "name", label: "Nombre", truncate: true },
    { key: "nit", label: "NIT" },
    { key: "owner_name", label: "Nombre del Cliente Propietario" },
    { key: "address", label: "Dirección", truncate: true },
    { key: "description", label: "Descripción", truncate: true },
    { key: "created_at", label: "Fecha creación", date: true },
    { key: "updated_at", label: "Fecha actualización", date: true },
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
    name: "Puesto de venta",
    route: "retail-outlets",
});

// const action = (action) => {
//     switch (action.action) {
//         case "show":
//             form.get(route("retail-outlets.show", { id: action.id }));
//             break;
//         case "edit":
//             form.get(route("retail-outlets.edit", { id: action.id }));
//             break;
//         case "destroy":
//             form.delete(route("retail-outlets.destroy", { id: action.id }), {
//                 onSuccess: () => {
//                     toast.success("Puesto de venta eliminado");
//                     form.get(route("retail-outlets.index"));
//                 },
//                 onError: (errors) =>
//                     Object.values(errors).forEach((message) => {
//                         toast.error(message);
//                     }),
//             });
//             break;
//         default:
//             break;
//     }
// };

const action = async (action) => {
    switch (action.action) {
        case "show":
            router.get(route("retail-outlets.show", { id: action.id }));
            break;
        case "edit":
            router.get(route("retail-outlets.edit", { id: action.id }));
            break;
        case "destroy":
            const resDialog = await goodDialogs.confirm(
                "¿Eliminar puesto de venta?",
                {
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                }
            );
            if (!resDialog)
                return goodDialogs.cancelled("Se cancelo la acción", {
                    confirmButtonText: "Aceptar",
                });
            router.delete(route("retail-outlets.destroy", { id: action.id }), {
                onSuccess: () =>
                    goodDialogs.createNotification(
                        "Puesto de venta eliminado con éxito",
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
    <Head title="Puestos de venta" />
    <authenticated-layout>
        <base-card title="Puestos de venta">
            <data-table
                :columns="columns"
                :content="retailOutlets"
                :filters="filters"
                :add="addButton"
                :options="options"
                @action="action"
            />
        </base-card>
    </authenticated-layout>
</template>
