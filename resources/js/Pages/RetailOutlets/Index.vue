<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["retailOutlets"]);
const form = useForm({});
const items = ref(props.retailOutlets);
const itemsDisplay = ref(props.retailOutlets);
const searchQuery = ref("");
const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Nombre" },
    { key: "nit", label: "NIT" },
    { key: "description", label: "Descripción" },
    { key: "owner_name", label: "Nombre del Cliente Propietario" },
    { key: "address", label: "Dirección" },
    { key: "lat", label: "Latitud" },
    { key: "lng", label: "Longitud" },
    { key: "created_at", label: "Fecha creación", date: true },
    { key: "updated_at", label: "Fecha actualización", date: true },
]);
const options = ref([
    { id: "edit", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "destroy", name: "Eliminar", icon: "hi-solid-exclamation" },
]);

watch(searchQuery, () => {
    searchItems();
});

const searchItems = () => {
    const filteredItems = items.value.filter(
        (item) =>
            item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.address.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
    itemsDisplay.value = filteredItems;
};

const action = (action) => {
    switch (action.action) {
        case "edit":
            form.get(route("retail-outlets.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("retail-outlets.destroy", { id: action.id }), {
                onSuccess: () => {
                    toast.success("Puesto de venta eliminado");
                    form.get(route("retail-outlets.index"));
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
    <Head title="Puntos de Venta" />
    <authenticated-layout>
        <card-data title="Puntos de Venta">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('retail-outlets.create')"
                        >Agregar Punto de Venta</button-add
                    >
                </div> </template
            ><DataTable
                :columns="columns"
                :items="itemsDisplay"
                :options="options"
                @action="action"
            ></DataTable
        ></card-data>
    </authenticated-layout>
</template>
