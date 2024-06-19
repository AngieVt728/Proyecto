<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";

const props = defineProps<{ user }>();

const handleSubmit = () => {
    router.get(route("customers.edit", { id: props.user.id }));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="user.username" />
        <Form
            title="Información de cliente"
            type-submit="edit"
            @handle-submit="handleSubmit"
        >
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Datos personales
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8">
                <div class="flex justify-center items-center my-4">
                    <img
                        class="rounded-full w-72 h-72 object-cover"
                        :src="user.image_url"
                        :alt="`${user.username} profile`"
                    />
                </div>
                <div class="flex flex-wrap justify-around gap-4">
                    <Input
                        id="firstName"
                        label-text="Nombre/s"
                        v-model="user.first_name"
                        type="text"
                        :disabled="true"
                    />
                    <Input
                        id="lastName"
                        label-text="Apellidos"
                        v-model="user.last_name"
                        type="text"
                        :disabled="true"
                    />
                    <Input
                        id="ci"
                        label-text="Carnet de identidad"
                        v-model="user.ci"
                        type="text"
                        :disabled="true"
                    />
                </div>
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
                    v-model="user.email"
                    type="email"
                    :disabled="true"
                />
                <Input
                    id="username"
                    label-text="Nombre de usuario"
                    v-model="user.username"
                    type="text"
                    :disabled="true"
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
                    v-model="user.contact"
                    type="text"
                    :disabled="true"
                />
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="user.address"
                    type="text"
                    :disabled="true"
                />
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
