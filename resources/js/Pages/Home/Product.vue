<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps<{
    products: {
        id: number;
        name: string;
        image: string;
        price: number;
        stock: number;
        description: string;
    };
}>();
</script>

<template>
    <home-layout>
        <Head title="Productos" />
    </home-layout>
</template>
