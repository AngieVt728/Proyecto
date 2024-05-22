<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ref, watch } from "vue";

const props = defineProps(["products"]);
console.log(props.products);
const form = useForm({});
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
    { key: "updated_at", label: "Fecha de actualización", date: true },
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
            form.get(route("products.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("products.destroy", { id: action.id }), {
                onSuccess: () => {
                    toast.success("Producto eliminado");
                    form.get(route("products.index"));
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
