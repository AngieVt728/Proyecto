<script setup>
defineEmits(["update:modelValue", "blur"]);
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
        type: [String, Number, Boolean],
        required: true,
    },
    error: {
        type: String,
    },
    type: {
        type: String,
        default: "text",
    },
    placeholder: {
        type: String,
        default: " ",
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false,
    },
    min: {
        type: Number,
    },
    max: {
        type: Number,
    },
});
</script>

<template>
    <div class="relative w-full mb-3">
        <label :for="id" class="text-sm text-gray-700">
            {{ labelText }}
        </label>
        <div class="p-1 mb-1">
            <p class="text-sm text-red-500">
                {{ error }}
            </p>
        </div>
        <input
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="$emit('blur')"
            :id="id"
            :type="type"
            :placeholder="placeholder"
            class="block w-full mt-1 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
            :disabled="disabled"
            :min="min"
            :max="max"
        />
    </div>
</template>
