<script setup>
defineEmits(["update:modelValue", "reset"]);
defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="flex flex-nowrap items-center justify-between content-center">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <v-icon class="w-5 h-5 text-gray-500" name="hi-solid-search" />
            </span>

            <input
                class="w-full pl-10 pr-4 text-indigo-600 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                id="search"
                name="search"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                type="text"
                autocomplete="off"
                placeholder="Buscar"
            />
        </div>

        <button
            class="ml-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500 text-sm"
            @click="$emit('reset')"
            type="button"
            aria-label="reset"
        >
            <v-icon name="hi-refresh" scale="1.5" />
        </button>
    </div>
</template>
