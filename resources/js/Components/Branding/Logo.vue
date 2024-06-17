<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
    subtitle: {
        type: String,
        required: false,
    },
    imgClass: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <Link :href="route('login')">
        <div class="flex items-center justify-center flex-col">
            <img
                class="w-[150px]"
                :class="imgClass"
                src="/images/logoimbae2.png"
                alt="logo imbae png"
            />
            <p class="font-semibold text-xs text-gray-500">{{ subtitle }}</p>
        </div>
    </Link>
</template>
