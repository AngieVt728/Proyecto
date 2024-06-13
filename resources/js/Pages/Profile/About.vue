<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Input from "@/Components/Inputs/Input.vue";
import { Head } from "@inertiajs/vue3";

defineProps({ user: Object });
</script>

<template>
    <Head title="Perfil de usuario" />
    <authenticated-layout>
        <div class="m-4 p-6 bg-white rounded-md shadow-md">
            <img
                class="w-[250px] h-[250px] rounded-full"
                :src="user.avatar"
                :alt="`${user.first_name} ${user.last_name} avatar`"
            />
            <Input
                id="firstName"
                label-text="Nombres"
                v-model="user.first_name"
                :error="''"
                :disabled="true"
            />
            <Input
                id="lastName"
                label-text="Apellidos"
                v-model="user.last_name"
                :error="''"
                :disabled="true"
            />
            <Input
                id="ci"
                label-text="Cédula de identidad"
                v-model="user.ci"
                :error="''"
                :disabled="true"
            />
            <Input
                id="email"
                label-text="Correo electrónico"
                v-model="user.email"
                :error="''"
                :disabled="true"
            />
            <Input
                id="phoneNumber"
                label-text="Numero de teléfono o celular"
                v-model="user.phone_number"
                :error="''"
                :disabled="true"
            />
            <Input
                id="address"
                label-text="Dirección"
                v-model="user.address"
                :error="''"
                :disabled="true"
            />
            <Input
                id="role"
                label-text="Rol en el sistema"
                v-model="user.roles[0].name"
                :error="''"
                :disabled="true"
            />
            <ul
                v-for="(permission, index) in user.roles[0].permissions"
                :key="index"
            >
                <li>{{ permission }}</li>
            </ul>
        </div>
    </authenticated-layout>
</template>
