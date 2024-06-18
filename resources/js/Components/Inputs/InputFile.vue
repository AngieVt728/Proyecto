<script setup lang="ts">
defineEmits(["update:modelValue", "blur"]);
const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    name:{
        type:String,
        required:true
    },
    labelText: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number, Boolean,File],
        required: true,
    },
    error: {
        type: String,
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false,
    },
    accept: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="relative w-full">
        <label :for="id" class="text-sm text-gray-700">
            {{ labelText }}
        </label>
        <div class="p-1 mb-1">
            <p class="text-sm text-red-500">
                {{ error }}
            </p>
        </div>
        <input
            @input="$emit('update:modelValue', $event.target.files[0])"
            @blur="$emit('blur')"
            :id="id"
            :name="name"
            type="file"
            :accept="accept"
            class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 focus:outline-none file:cursor-pointer"
            :disabled="disabled"
        />
    </div>
</template>
