<script setup>
const props = defineProps({
    title: {
        type: String,
        default: "Title",
    },
});
</script>

<template>
    <div class="px-6 py-8 transparent">
        <h2 class="text-2xl font-black text-gray-700 mb-2 capitalize">
            {{ title }}
        </h2>
        <slot />
    </div>
</template>
