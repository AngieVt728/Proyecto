<script setup>
defineEmits(["update:modelValue"]);
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
        type: Boolean,
        default: false,
    },
    errors: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="relative w-full mb-3 my-auto">
        <div class="p-1 mb-1" v-for="(error, index) of errors" :key="index">
            <p class="text-sm text-red-500">
                {{ error.$message }}
            </p>
        </div>
        <div class="flex items-center pl-4 border border-gray-200 rounded">
            <input
                :id="id"
                type="checkbox"
                :checked="modelValue"
                @click="$emit('update:modelValue', $event.target.checked)"
                class="text-indigo-600 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
            />
            <label :for="id" class="w-full py-3 ml-2 text-sm text-gray-700">
                {{ labelText }}
            </label>
        </div>
    </div>
</template>
