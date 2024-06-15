<script setup>
import Header from "@/Components/Headers/Header.vue";
import Sidebar from "@/Components/Sidebars/Sidebar.vue";
</script>

<template>
    <div class="flex h-screen bg-gray-200 font-roboto">
        <Sidebar />
        <div class="flex-1 flex flex-col overflow-hidden">
            <Header />
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container">
                    <slot />
                </div>
            </main>
        </div>
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
