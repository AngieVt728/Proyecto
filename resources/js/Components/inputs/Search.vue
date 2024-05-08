<script setup>
const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <v-icon class="w-5 h-5 text-gray-500" name="hi-solid-search" />
        </span>

        <input
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            id="table-search"
            class="w-full pl-10 text-gray-600 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
            type="text"
            placeholder="Buscar"
        />
    </div>
</template>
