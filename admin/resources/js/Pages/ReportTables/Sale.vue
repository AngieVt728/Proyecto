<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Ventas" />
    <authenticated-layout>
        <base-card title="Ventas"> </base-card>
    </authenticated-layout>
</template>
