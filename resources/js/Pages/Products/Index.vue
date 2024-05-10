<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps(["products"]);
const items = ref(props.products);
const itemsDisplay = ref(props.products);
const searchQuery = ref("");
const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Nombre Producto" },
    { key: "description", label: "Descripción" },
    { key: "price", label: "Precio" },
    { key: "stock", label: "Stock" },
    { key: "created_at", label: "Fecha creación", date: true },
]);
const options = ref([
    { id: "edit", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "destroy", name: "Eliminar", icon: "hi-solid-exclamation" },
]);

watch(searchQuery, () => {
    searchItems();
});

const searchItems = () => {
    const filteredItems = items.value.filter((item) =>
        item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
    itemsDisplay.value = filteredItems;
};

const action = (action) => {
    switch (action.action) {
        case "edit":
            router.get(`/products/${action.id}/edit`);
            break;
        case "destroy":
            router.delete(`/products/${action.id}`);
            break;
        default:
            break;
    }
};
</script>

<template>
    <Head title="Productos" />
    <authenticated-layout>
        <card-data title="Productos">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('products.create')"
                        >Agregar Producto</button-add
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
