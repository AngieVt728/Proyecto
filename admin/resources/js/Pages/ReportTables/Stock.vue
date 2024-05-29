<script setup>
import ButtonAdd from "@/Components/Buttons/AddButton.vue";
import CardData from "@/Components/cards/BaseCard.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["users"]);
const form = useForm({});
const items = ref(props.users);
const itemsDisplay = ref(props.users);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Nombre Producto" },
    { key: "description", label: "Descripción" },
    { key: "ingreso", label: "Unidades ingresadas" },
    { key: "fecha_ingreso", label: "Fecha de Ingreso", date: true },
    { key: "created_at", label: "Fecha de Creación", date: true },
    { key: "updated_at", label: "Fecha de Actualización", date: true },
]);
const options = ref([
    { id: "show", name: "Ver", icon: "hi-solid-eye" },
    { id: "edit", name: "Actualizar", icon: "hi-solid-pencil" },
    { id: "destroy", name: "Eliminar", icon: "hi-solid-exclamation" },
]);

watch(searchQuery, () => {
    searchItems();
});

const searchItems = () => {
    const filteredItems = items.value.filter(
        (item) =>
            item.first_name
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            item.last_name
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            item.ci.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
    itemsDisplay.value = filteredItems;
};

const action = (action) => {
    switch (action.action) {
        case "show":
            console.log(action);
            form.get(route("users.show", { id: action.id }));
            break;
        case "edit":
            form.get(route("users.edit", { id: action.id }));
            break;
        case "destroy":
            form.delete(route("users.destroy", { id: action.id }), {
                onSuccess: () => toast.success("Usuario eliminado"),
                onError: () => toast.error("Error al eliminar usuario"),
            });
            break;
        default:
            break;
    }
};
</script>

<template>
    <Head title="Stock" />
    <authenticated-layout>
        <card-data title="Stock">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
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
