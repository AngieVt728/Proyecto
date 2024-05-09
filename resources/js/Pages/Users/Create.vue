<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps(["user"]);

console.log(props.user);

const form = useForm({
    first_name: props.user ? props.user.first_name : "",
    last_name: props.user ? props.user.last_name : "",
    ci: props.user ? props.user.ci : "",
    email: props.user ? props.user.email : "",
    phone_number: props.user ? props.user.phone_number : "",
    address: props.user ? props.user.address : "",
});

const handleSubmit = () => {
    if (props.user?.id)
        form.patch(route("users.update", { id: props.user.id }), {
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
    else
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
