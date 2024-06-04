<script setup>
import BaseCard from "@/Components/Cards/BaseCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Stock" />
    <authenticated-layout>
        <base-card title="Stock"> </base-card>
    </authenticated-layout>
</template>
