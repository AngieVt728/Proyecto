<script setup>
function returnButton() {
    window.history.back();
}
</script>

<template>
    <button
        class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
        @click="returnButton"
        type="button"
    >
        <v-icon name="hi-solid-arrow-circle-left" class="mr-2" />
        Regresar
    </button>
</template>
