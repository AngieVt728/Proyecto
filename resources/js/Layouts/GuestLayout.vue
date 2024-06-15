<template>
    <div
        class="relative flex items-center justify-center h-screen bg-center bg-no-repeat bg-[url(https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg)] bg-gray-700 bg-blend-multiply"
    >
        <div
            class="absolute w-full h-full bg-gradient-to-br from-purple-300 via-indigo-400 to-purple-300 opacity-15"
        ></div>
        <slot />
    </div>
</template>

<style scoped>
::-webkit-scrollbar {
    width: 7px;
}

::-webkit-scrollbar-track {
    background: #2d3748;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e0;
}

::-webkit-scrollbar-thumb:hover {
    background: #718096;
}
</style>
