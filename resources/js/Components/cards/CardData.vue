<script setup>
const props = defineProps({
    title: {
        type: String,
        default: "Title",
    },
});
</script>

<template>
    <div class="p-6 bg-white rounded-md shadow-md">
        <h2
            class="text-xl font-semibold leading-tight text-gray-700 capitalize"
        >
            {{ title }}
        </h2>
        <div class="flex flex-col mt-3 sm:flex-row">
            <slot name="filters"> </slot>
        </div>
        <slot> </slot>
    </div>
</template>
