<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

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
            form.reset(
                "name",
                "description",
                "address",
                "name_costumer",
            ),
    });
};

import { GoogleMap, Marker } from 'vue3-google-map'

const center = { lat: 40.689247, lng: -74.044502 }

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
                <GoogleMap
                api-key="YOUR_API_KEY"
                style="width: 100%; height: 500px"
                :center="center"
                :zoom="15"
                >
                    <Marker :options="{ position: center }" />
                </GoogleMap>

            </div>
        </Form>
    </authenticated-layout>
</template>
