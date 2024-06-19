<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import InputFile from "@/Components/Inputs/InputFile.vue";
import Select from "@/Components/Inputs/Select.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";

const form = useForm({
    firstName: "",
    lastName: "",
    ci: "",
    contact: "",
    address: "",
    username: "",
    email: "",
    password: "",
    avatar: "",
});

const handleSubmit = () => {
    form.post(route("customers.store"), {
        onSuccess: () =>
            goodDialogs.createNotification("Cliente creado con éxito", {
                type: "success",
            }),
        onError: (errors) =>
            goodDialogs.createNotification("No se pudo crear el cliente", {
                type: "error",
            }),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Crear nuevo cliente" />
        <Form title="Cliente" @handle-submit="handleSubmit">
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Datos personales
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8">
                <Input
                    id="firstName"
                    label-text="Nombre/s"
                    v-model="form.firstName"
                    :error="form.errors.firstName"
                    type="text"
                />
                <Input
                    id="lastName"
                    label-text="Apellidos"
                    v-model="form.lastName"
                    :error="form.errors.lastName"
                    type="text"
                />
                <Input
                    id="ci"
                    label-text="Carnet de identidad"
                    v-model="form.ci"
                    :error="form.errors.ci"
                    type="text"
                />
                <InputFile
                    id="avatar"
                    label-text="Fotografía (max. 2 MB)"
                    v-model="form.avatar"
                    name="avatar"
                    :error="form.errors.avatar"
                    accept="jpg, png"
                />
            </div>
            <h2
                class="ml-4 mt-6 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Información de cuenta
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8">
                <Input
                    id="email"
                    label-text="Correo electrónico"
                    v-model="form.email"
                    :error="form.errors.email"
                    type="email"
                />
                <Input
                    id="username"
                    label-text="Nombre de usuario (dejar vació para asignar automáticamente)"
                    v-model="form.username"
                    :error="form.errors.username"
                    type="text"
                />
                <Input
                    id="password"
                    label-text="Contraseña (dejar vacio para asignar el CI)"
                    v-model="form.password"
                    :error="form.errors.password"
                    type="password"
                />
            </div>
            <h2
                class="ml-4 mt-6 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Información de contacto
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8 mb-4">
                <Input
                    id="contact"
                    label-text="Teléfono o celular"
                    v-model="form.contact"
                    :error="form.errors.contact"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    :error="form.errors.address"
                    type="text"
                />
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
