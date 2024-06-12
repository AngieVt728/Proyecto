<script setup>
import Logo from "@/Components/Branding/Logo.vue";
import ButtonSubmit from "@/Components/Buttons/ButtonSubmit.vue";
import Input from "@/Components/Inputs/Input.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <guest-layout>
        <Head title="¿Olvidaste tu contraseña?" />

        <div
            class="flex items-center justify-center bg-gradient-to-br from-purple-300 via-indigo-400 to-purple-300 h-screen px-6"
        >
            <div
                class="w-full max-w-screen-sm p-6 bg-white rounded-md shadow-md"
            >
                <Logo :is-login="true" :is-custom="true" />

                <div class="mt-2 text-sm text-gray-400">
                    ¿Olvidaste tu contraseña? Ningún problema. Simplemente
                    háganos saber su dirección de correo electrónico y le
                    enviaremos un correo electrónico para restablecer su
                    contraseña. enlace que le permitirá elegir uno nuevo.
                </div>

                <div
                    v-if="status"
                    class="mt-4 font-medium text-center text-sm text-green-600"
                >
                    {{ status }}
                </div>

                <form class="mt-4" @submit.prevent="submit">
                    <Input
                        id="email"
                        label-text="Correo electrónico"
                        v-model="form.email"
                        :error="form.errors.email"
                        type="email"
                    />

                    <div class="mt-6">
                        <ButtonSubmit>Enviar enlace</ButtonSubmit>
                    </div>
                </form>
            </div>
        </div></guest-layout
    >
</template>
