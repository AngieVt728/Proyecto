<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { GoogleMap, Marker } from "vue3-google-map";

const mapsApiKey = import.meta.env.VITE_MAPS_API_KEY;
const center = { lat: -16.5005293, lng: -68.1277223 };
const form = useForm({
    legal_name: "",
    nit: "",
    description: "",
    email: "",
    phone_number: "",
    address: "",
});

const handleSubmit = () => {
    form.post(route("proveedores.store"), {
        onFinish: () =>
            form.reset("name", "description", "address", "name_costumer"),
    });
};
</script>

<template>
    <Head title="Crear nuevo punto de venta" />
    <authenticated-layout>
        <Form title="Punto de Venta" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="name"
                    label-text="Nombre"
                    v-model="form.name"
                    type="text"
                />
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    type="text"
                />
                <Input
                    id="id_customer"
                    label-text="Nombre del Cliente"
                    v-model="form.id_customer"
                    type="text"
                />
            </div>

            <div class="p-4">
                <h2 class="font-semibold mb-4 text-gray-700">
                    Busque la ubicación del punto de venta
                </h2>
                <div class="mx-24">
                    <GoogleMap
                        :api-key="mapsApiKey"
                        style="width: 100%; height: 400px"
                        :center="center"
                        :zoom="15"
                    >
                        <Marker :options="{ position: center }" />
                    </GoogleMap>
                </div>
            </div>
        </Form>
    </authenticated-layout>
</template>
