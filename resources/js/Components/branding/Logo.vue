<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    isLogin: {
        type: Boolean,
        default: false,
        required: true,
    },
});

const imgClass = props.isLogin
    ? "w-[150px] drop-shadow-md"
    : "w-[150px] lg:w-[200px] mt-4";
const spanClass = props.isLogin
    ? "text-sm font-semibold text-gray-400"
    : "text-md font-semibold text-gray-400";
const spanText = props.isLogin
    ? "Ingresa tus credenciales para iniciar sesión"
    : "Panel de administración";
</script>

<template>
    <Link :href="route('dashboard')"
        ><div class="flex items-center justify-center flex-col">
            <img
                :class="imgClass"
                src="/images/logoimbae2.png"
                alt="logo imbae png"
            />
            <span :class="spanClass">{{ spanText }}</span>
        </div></Link
    >
</template>
