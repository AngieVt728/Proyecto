<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps(["user"]);
</script>

<template>
    <Head title="Usuario" />
    <authenticated-layout> </authenticated-layout>
</template>
