<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    first_name: "",
    last_name: "",
    ci: "",
    email: "",
    phone_number: "",
    address: "",
});

const handleSubmit = () => {
    form.post(route("users.store"), {
        onFinish: () =>
            form.reset(
                "first_name",
                "last_name",
                "ci",
                "email",
                "phone_number",
                "address"
            ),
    });
};
</script>

<template>
    <Head title="Crear nuevo cliente" />
    <authenticated-layout>
        <Form title="Cliente" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="first_name"
                    label-text="Nombre/s"
                    v-model="form.first_name"
                    type="text"
                />
                <Input
                    id="last_name"
                    label-text="Apellidos"
                    v-model="form.last_name"
                    type="text"
                />
                <Input
                    id="ci"
                    label-text="Carnet de identidad"
                    v-model="form.ci"
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
                    label-text="Numero teléfono celular"
                    v-model="form.phone_number"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección domicilio"
                    v-model="form.address"
                    type="text"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
