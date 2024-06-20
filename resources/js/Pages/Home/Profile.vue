<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { FwbCard } from "flowbite-vue";
import { ref } from "vue";
import { getUser } from "@/Composables/usePage";
import { goodDialogs } from "gooddialogs";

const user = getUser();
</script>

<template>
    <HomeLayout>
        <Head title="Perfil de usuario" />
        <h2
            class="text-3xl my-8 font-semibold text-gray-700 text-center uppercase"
        >
            Información de perfil
        </h2>
        <div class="flex flex-wrap justify-around items-center gap-6 px-10">
            {{ user }}
            <Link
                class="flex items-center px-6 py-2 font-medium tracking-wide text-white transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
                :href="route('logout')"
                method="post"
                as="button"
            >
                <v-icon class="mr-2 h-5 w-5" name="hi-logout" />
                Cerrar sesión
            </Link>
        </div>
    </HomeLayout>
</template>
