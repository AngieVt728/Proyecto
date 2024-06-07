<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
    },
    name: {
        type: String,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? "bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100"
        : "border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100"
);
</script>

<template>
    <Link
        :href="href"
        class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
        :class="classes"
        preserve-scroll
    >
        <v-icon :name="icon" class="w-5 h-5" />
        <span class="flex-1 ml-3 whitespace-nowrap">{{ name }}</span>
    </Link>
</template>
