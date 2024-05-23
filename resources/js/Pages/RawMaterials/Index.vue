<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["rawMaterials"]);
const form = useForm({});
const items = ref(props.rawMaterials);
const itemsDisplay = ref(props.rawMaterials);
const searchQuery = ref("");
const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Nombre" },
    { key: "price", label: "Precio" },
    { key: "stock", label: "Stock" },
    { key: "description", label: "Descripción" },
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
            item.price.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
    itemsDisplay.value = filteredItems;
}

const action = (action) => {
    switch (action.action) {
        case "edit":
            form.get(route("raw-materials.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("raw-materials.destroy", { id: action.id }), {
                onSuccess: () => {
                    toast.success("Materia prima eliminada");
                    form.get(route("raw-materials.index"));
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
    <Head title="Productos de Materia Prima" />
    <authenticated-layout>
        <card-data title="Productos de Materia Prima">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('raw-materials.create')">
                        Registrar Producto de Materia Prima
                    </button-add>
                </div>
            </template>
            <DataTable
                :columns="columns"
                :items="itemsDisplay"
                :options="options"
                @action="action"
            />
        </card-data>
    </authenticated-layout>
</template>
