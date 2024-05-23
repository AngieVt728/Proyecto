<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["suppliers"]);
const form = useForm({});
const items = ref(props.suppliers);
const itemsDisplay = ref(props.suppliers);
const searchQuery = ref("");
const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Razón Social" },
    { key: "nit", label: "NIT" },
    { key: "description", label: "Descripción" },
    { key: "email", label: "Correo electrónico" },
    { key: "phone_number", label: "Número de Teléfono" },
    { key: "address", label: "Dirección" },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);
const options = ref([
    { id: "edit", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "destroy", name: "Eliminar", icon: "hi-solid-exclamation" },
]);

watch(searchQuery, () => {
    searchItems();
});

function searchItems() {
    const filteredItems = items.value.filter(
        (item) =>
            item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.description
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            item.email
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            item.phone_number
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase())
    );
    itemsDisplay.value = filteredItems;
}

const action = (action) => {
    switch (action.action) {
        case "edit":
            form.get(route("suppliers.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("suppliers.destroy", { id: action.id }), {
                onSuccess: () => {
                    toast.success("Proveedor eliminado");
                    form.get(route("suppliers.index"));
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
    <Head title="Proveedores" />
    <authenticated-layout>
        <card-data title="Proveedores">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('suppliers.create')"
                        >Agregar Proveedor</button-add
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
