<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps(["raw_materials"]);
const items = ref(props.raw_materials);
const itemsDisplay = ref(props.raw_materials);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Nombre" },
    { key: "price", label: "Precio" },
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
            router.get(`/raw-materials/${action.id}/edit`);
            break;
        case "destroy":
            router.delete(`/raw-materials/${action.id}`);
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
                    <button-add :href="route('raw-materials.create')"
                        >Registrar Producto de Materia Prima</button-add
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
