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
                "legal_name",
                "nit",
                "description",
                "email",
                "phone_number",
                "address"
            ),
    });
};

</script>

<template>
    <Head title="Crear nuevo proveedor" />
    <authenticated-layout>
        <Form title="Proveedor" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="legal_name"
                    label-text="Razón Social"
                    v-model="form.legal_name"
                    type="text"
                />
                <Input
                    id="nit"
                    label-text="NIT"
                    v-model="form.nit"
                    type="text"
                />
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    type="text"
                />
                <Input
                    id="email"
                    label-text="Correo electrónico"
                    v-model="form.email"
                    type="email"
                />
                <Input
                    id="phone_number"
                    label-text="Número de Teléfono"
                    v-model="form.phone_number"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    type="text"
                />

            </div>
        </Form>
    </authenticated-layout>
</template>
