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
    <!-- <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="login" value="Email" />

                <TextInput
                    id="login"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.login" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout> -->
</template>
