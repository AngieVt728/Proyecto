<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Input from "@/Components/Inputs/Input.vue";
import Checkbox from "@/Components/Inputs/Checkbox.vue";
import Logo from "@/Components/Branding/Logo.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Inicio de sesión" />

    <guest-layout>
        <main class="w-full max-w-sm p-6 bg-white rounded-md shadow-md z-50">
            <Logo :is-login="true" />

            <form class="mt-4" @submit.prevent="submit">
                <Input
                    id="email"
                    label-text="Correo electrónico"
                    v-model="form.email"
                    :error="form.errors.email"
                    type="email"
                />
                <Input
                    id="password"
                    label-text="Contraseña"
                    v-model="form.password"
                    :error="form.errors.password"
                    type="password"
                />
                <div class="flex items-center justify-between mt-4">
                    <div>
                        <Checkbox
                            id="remember"
                            label-text="Recuérdame"
                            v-model:checked="form.remember"
                        />
                    </div>
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full px-4 py-2 text-sm text-center text-white bg-indigo-600 rounded-md focus:outline-none hover:bg-indigo-500"
                    >
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </main>
    </guest-layout>
</template>
