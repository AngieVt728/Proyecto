<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const dropdownOpen = ref(false);
</script>

<template>
    <div class="relative mx-4">
        <button
            class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none"
            @click="dropdownOpen = !dropdownOpen"
        >
            <img
                class="w-8 h-8 rounded-full"
                :src="$page.props.auth.user.avatar"
                alt="user avatar"
            />
        </button>
        <div
            v-show="dropdownOpen"
            class="fixed inset-0 z-10 w-full h-full"
            @click="dropdownOpen = false"
        />
        <transition
            enter-active-class="transition duration-150 ease-out transform"
            enter-from-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition duration-150 ease-in transform"
            leave-from-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <div
                v-show="dropdownOpen"
                class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl"
            >
                <div class="px-4 py-2 text-sm md:hidden text-gray-700 border-b">
                    Bienvenido:
                    <span class="block text-xs font-semibold">{{
                        $page.props.auth.user.first_name +
                        " " +
                        $page.props.auth.user.last_name
                    }}</span>
                </div>
                <span
                    class="px-4 py-2 text-sm text-center font-semibold text-gray-700 border-b hidden md:block"
                    >Acciones</span
                >
                <Link
                    :href="route('dashboard')"
                    as="button"
                    class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-indigo-600 hover:text-white"
                >
                    <v-icon name="hi-solid-information-circle" /><span
                        class="ml-1"
                        >Mi información</span
                    >
                </Link>
                <Link
                    :href="route('dashboard')"
                    as="button"
                    class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-indigo-600 hover:text-white"
                >
                    <v-icon name="hi-solid-key" /><span class="ml-1"
                        >Actualizar contraseña</span
                    >
                </Link>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-indigo-600 hover:text-white"
                >
                    <v-icon name="hi-solid-logout" /><span class="ml-1"
                        >Desconectarse</span
                    >
                </Link>
            </div>
        </transition>
    </div>
</template>
