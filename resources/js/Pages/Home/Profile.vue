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
        <h2 class="text-3xl my-8 font-semibold text-gray-700 text-center uppercase">
            Información de perfil
        </h2>
        <div class="flex justify-center">
            <FwbCard class="max-w-lg w-full p-6 space-y-4 bg-white shadow-md rounded-lg">
                <div class="flex flex-col items-center">
                    <img
                        class="w-24 h-24 rounded-full"
                        :src="user.image_url"
                        alt="Imagen de perfil"
                    />
                    <h3 class="text-xl font-bold text-gray-700 mt-4">
                        {{ user.first_name }} {{ user.last_name }}
                    </h3>
                    <p class="text-gray-600">{{ user.username }}</p>
                </div>
                <form class="space-y-4">
                    <div class="flex flex-col">
                        <label for="email" class="font-medium text-gray-700">Email:</label>
                        <input id="email" type="text" v-model="user.email" readonly class="input" />
                    </div>
                    <div class="flex flex-col">
                        <label for="contact" class="font-medium text-gray-700">Teléfono:</label>
                        <input id="contact" type="text" v-model="user.contact" readonly class="input" />
                    </div>
                    <div class="flex flex-col">
                        <label for="address" class="font-medium text-gray-700">Dirección:</label>
                        <input id="address" type="text" v-model="user.address" readonly class="input" />
                    </div>
                    <div class="flex flex-col">
                        <label for="email_verified_at" class="font-medium text-gray-700">Verificado:</label>
                        <input id="email_verified_at" type="text" :value="user.email_verified_at ? 'Sí' : 'No'" readonly class="input" />
                    </div>
                    <div class="flex flex-col">
                        <label for="role" class="font-medium text-gray-700">Rol:</label>
                        <input id="role" type="text" v-model="user.roles[0].name" readonly class="input" />
                    </div>
                </form>
                <br>
                <div class="text-center">
                    <Link
                        class="flex items-center justify-center px-6 py-2 font-medium tracking-wide text-white transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >

                        <v-icon class="mr-2 h-5 w-5" name="hi-logout" />
                        Cerrar sesión
                    </Link>
                </div>
            </FwbCard>
        </div>
    </HomeLayout>
</template>
