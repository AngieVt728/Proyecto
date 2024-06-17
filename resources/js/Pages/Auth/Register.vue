<script setup lang="ts">
import Logo from "@/Components/Branding/Logo.vue";
import Input from "@/Components/Inputs/Input.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    password_confirmation: "",
    contact: "",
    address: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Registro de usuarios" />

        <main
            class="w-full max-w-[500px] my-8 mx-8 lg:mx-0 pt-2 pb-6 px-6 bg-white rounded-md shadow-md z-50"
        >
            <Logo
                subtitle="Llena todos los campos obligatorios (*)"
                shadow="drop-shadow-md"
            />
            <form class="mt-4" @submit.prevent="submit">
                <Input
                    id="firstName"
                    label-text="Nombres *"
                    v-model="form.firstName"
                    :error="form.errors.firstName"
                    type="text"
                />
                <Input
                    id="lastName"
                    label-text="Apellidos *"
                    v-model="form.lastName"
                    :error="form.errors.lastName"
                    type="text"
                />
                <Input
                    id="email"
                    label-text="Correo electrónico *"
                    v-model="form.email"
                    :error="form.errors.email"
                    type="email"
                />
                <Input
                    id="password"
                    label-text="Contraseña *"
                    v-model="form.password"
                    :error="form.errors.password"
                    type="password"
                />
                <Input
                    id="password_confirmation"
                    label-text="Confirmar contraseña *"
                    v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation"
                    type="password"
                />
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

                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-right"
                >
                    ¿Ya estas registrado?
                </Link>

                <button
                    type="submit"
                    class="w-full mt-4 px-4 py-2 text-sm text-center text-white bg-indigo-600 rounded-md focus:outline-none hover:bg-indigo-500"
                >
                    Registrarse
                </button>
            </form>
        </main>
    </GuestLayout>
</template>
