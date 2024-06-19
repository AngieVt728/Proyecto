<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import Select from "@/Components/Inputs/Select.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { getRole } from "@/Composables/usePage";
import { goodDialogs } from "gooddialogs";

const role = getRole();
const props = defineProps<{ user?: Object; roles?: Object }>();
const form = useForm({
    firstName: props.user?.first_name,
    lastName: props.user?.last_name,
    ci: props.user?.ci,
    contact: props.user?.contact ?? "",
    address: props.user?.address ?? "",
    username: props.user?.username,
    email: props.user?.email,
    role: props.user?.role,
});

const handleSubmit = () => {
    form.patch(route("users.update", { user: props.user }), {
        forceFormData: false,
        onSuccess: () =>
            goodDialogs.createNotification("Usuario actualizado con éxito", {
                type: "success",
            }),
        onError: (errors) =>
            goodDialogs.createNotification("No se pudo actualizar el usuario", {
                type: "error",
            }),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="user.username" />
        <Form
            title="Editar usuario"
            type-submit="update"
            @handle-submit="handleSubmit"
        >
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
                <Select
                    v-if="role === 'super-admin' || role === 'admin'"
                    id="role"
                    label-text="Elegir el rol del usuario"
                    v-model="form.role"
                    :options="roles"
                    :error="form.errors.role || ''"
                    name="name"
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
