<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import Search from "@/Components/inputs/Search.vue";
import DataTable from "@/Components/tables/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps(["users"]);
const items = ref(props.users);
const itemsDisplay = ref(props.users);
const searchQuery = ref("");

const columns = ref([
    { key: "id", label: "ID" },
    { key: "first_name", label: "Nombre/s" },
    { key: "last_name", label: "Apellidos" },
    { key: "email", label: "Correo electrónico" },
    { key: "ci", label: "CI" },
    { key: "role", label: "Rol" },
    { key: "address", label: "Dirección" },
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

function searchItems() {
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
}

const action = (action) => {
    switch (action.action) {
        case "edit":
            router.get(`/users/${action.id}/edit`);
            break;
        case "destroy":
            router.delete(`/users/${action.id}`);
            break;
        default:
            break;
    }
};
</script>

<template>
    <Head title="Usuarios" />
    <authenticated-layout>
        <card-data title="Usuarios">
            <template v-slot:filters>
                <div
                    class="flex flex-col justify-between md:flex-row gap-2 w-full"
                >
                    <Search v-model="searchQuery" />
                    <button-add :href="route('users.create')"
                        >Agregar Usuario</button-add
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
