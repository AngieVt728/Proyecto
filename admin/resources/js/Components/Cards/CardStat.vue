<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    title: {
        type: String,
        default: "Title",
    },
    quantity: {
        type: Number,
        default: 8282,
    },
    iconBg: {
        type: String,
        default: "bg-indigo-600",
    },
    iconName: {
        type: String,
        default: "hi-solid-exclamation-circle",
    },
    route: {
        type: String,
        default: route("dashboard"),
    },
});
</script>
<template>
    <Link :href="route">
        <div
            class="flex items-center px-5 mb-4 break-words xl:mb-0 py-6 bg-white rounded-md shadow-sm shadow-gray-300"
        >
            <div
                class="text-white bg-opacity-75 p-3 text-center inline-flex items-center justify-center w-12 h-12 rounded-full"
                :class="iconBg"
            >
                <v-icon :name="iconName" />
            </div>
            <div class="mx-5">
                <h4 class="text-2xl font-semibold text-gray-700">
                    {{ quantity }}
                </h4>
                <div class="text-gray-500 text-sm">{{ title }}</div>
            </div>
        </div>
    </Link>
</template>
