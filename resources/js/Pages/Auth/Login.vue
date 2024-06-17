<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Input from "@/Components/Inputs/Input.vue";
import Checkbox from "@/Components/Inputs/Checkbox.vue";
import Logo from "@/Components/Branding/Logo.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    login: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <guest-layout>
        <Head title="Inicio de sesión" />

        <main class="w-full max-w-sm p-6 bg-white rounded-md shadow-md z-50">
            <Logo :is-login="true" />

            <form class="mt-4" @submit.prevent="submit">
                <Input
                    id="login"
                    label-text="Nombre de usuario o correo electrónico"
                    v-model="form.login"
                    :error="form.errors.login"
                    type="text"
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
