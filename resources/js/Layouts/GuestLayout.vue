<script setup>
const bgURL = "https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg";
</script>

<template>
    <div
        :class="`relative flex items-center justify-center h-screen bg-center bg-no-repeat bg-[url(${bgURL})] bg-gray-700 bg-blend-multiply`"
    >
        <div
            class="absolute w-full h-full bg-gradient-to-br from-purple-300 via-indigo-400 to-purple-300 opacity-15"
        ></div>
        <slot />
    </div>
</template>
