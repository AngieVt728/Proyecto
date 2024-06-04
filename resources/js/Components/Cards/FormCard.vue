<script setup>
import ButtonReturn from "@/Components/Buttons/ButtonReturn.vue";
import ButtonSave from "@/Components/Buttons/ButtonSave.vue";

const emit = defineEmits(["handleSubmit"]);
const props = defineProps({
    title: {
        type: String,
        default: "",
    },
    description: {
        type: String,
        default: "",
    },
});

function handleSubmit(e) {
    if (e) e.preventDefault();
    emit("handleSubmit");
}
</script>

<template>
    <div class="m-4 p-6 bg-white rounded-md shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 capitalize">
            {{ title }}
        </h2>
        <form :onSubmit="handleSubmit">
            <slot></slot>
            <div class="flex items-center justify-between">
                <div class="flex justify-start mt-4">
                    <ButtonReturn />
                </div>
                <div class="flex justify-end mt-4">
                    <ButtonSave />
                </div>
            </div>
        </form>
    </div>
</template>
