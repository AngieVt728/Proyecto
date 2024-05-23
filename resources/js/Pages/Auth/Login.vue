<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Input from "@/Components/inputs/Input.vue";
import Checkbox from "@/Components/inputs/Checkbox.vue";
import Logo from "@/Components/branding/Logo.vue";
import ButtonSubmit from "@/Components/buttons/ButtonSubmit.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

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
    <guest-layout>
        <Head title="Inicio de sesión" />

        <div class="flex items-center justify-center h-screen px-6 bg-gray-200">
            <div class="w-full max-w-sm p-6 bg-white rounded-md shadow-md">
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
                        <div>
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="block text-sm text-indigo-700 font-medium hover:underline"
                            >
                                ¿Olvidaste tu contraseña?
                            </Link>
                        </div>
                    </div>

                    <div class="mt-6">
                        <ButtonSubmit>Iniciar sesión</ButtonSubmit>
                    </div>
                </form>
            </div>
        </div></guest-layout
    >
</template>
