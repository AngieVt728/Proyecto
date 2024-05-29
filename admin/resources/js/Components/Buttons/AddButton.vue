<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        class="flex items-center px-2 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
        :href="href"
    >
        <v-icon name="hi-solid-plus" class="w-5 h-5 mx-1" />
        <span class="mx-1">
            <slot />
        </span>
    </Link>
</template>
