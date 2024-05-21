<script setup>
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const props = defineProps(["roles", "permissions", "user"]);
const form = useForm({
    first_name: props.user?.first_name ?? "",
    last_name: props.user?.last_name ?? "",
    ci: props.user?.ci ?? "",
    email: props.user?.email ?? "",
    phone_number: props.user?.phone_number ?? "",
    address: props.user?.address ?? "",
});

const handleSubmit = () => {
    if (props.user?.id)
        form.patch(route("users.update", { id: props.user.id }), {
            onSuccess: () => toast.success("Usuario actualizado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
    else
        form.post(route("users.store"), {
            onSuccess: () => toast.success("Usuario creado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
};
</script>

<template>
    <Head title="Crear nuevo usuario" />
    <authenticated-layout>
        <Form title="Empleado" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="first_name"
                    label-text="Nombre/s"
                    v-model="form.first_name"
                    :error="form.errors.first_name"
                    type="text"
                />
                <Input
                    id="last_name"
                    label-text="Apellidos"
                    v-model="form.last_name"
                    :error="form.errors.last_name"
                    type="text"
                />
                <Input
                    id="ci"
                    label-text="Carnet de identidad"
                    v-model="form.ci"
                    :error="form.errors.ci"
                    type="text"
                />
                <Input
                    id="email"
                    label-text="Correo electrónico"
                    :error="form.errors.email"
                    v-model="form.email"
                    type="email"
                />
                <Input
                    id="phone_number"
                    label-text="Numero teléfono celular"
                    v-model="form.phone_number"
                    :error="form.errors.phone_number"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección domicilio"
                    v-model="form.address"
                    :error="form.errors.address"
                    type="text"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
