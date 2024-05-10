<script setup>
const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    labelText: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        required: true,
    },
    error: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
    name: {
        type: String,
        default: "name",
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false,
    },
});
</script>

<template>
    <div class="relative w-full mb-3">
        <label class="text-sm text-gray-700">
            {{ labelText }}
        </label>
        <div class="p-1 mb-1">
            <p class="text-sm text-red-500">
                {{ error }}
            </p>
        </div>
        <select
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            :id="id"
            class="block w-full mt-1 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
            :disabled="disabled"
        >
            <option disabled value="">Seleccionar una opción</option>
            <option v-for="item in options" :value="item.id" :key="item.id">
                {{ item[name] }}
            </option>
        </select>
    </div>
</template>
