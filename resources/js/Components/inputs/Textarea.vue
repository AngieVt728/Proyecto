<script setup>
defineEmits(["update:modelValue", "blur"]);
defineProps({
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
    placeholder: {
        type: String,
        default: " ",
    },
    rows: {
        type: Number,
        default: 4,
    },
    cols: {
        type: Number,
        default: 50,
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
        <textarea
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="$emit('blur')"
            :id="id"
            :rows="rows"
            :cols="cols"
            maxlength="300"
            :placeholder="placeholder"
            class="block p-4 w-full mt-1 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
        ></textarea>
    </div>
</template>
