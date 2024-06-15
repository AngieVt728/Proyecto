<script setup lang="ts">
import Navbar from "@/Components/Navbars/Navbar.vue";
</script>

<template>
    <Navbar />
    <main>
        <section>
            <slot />
        </section>
    </main>
</template>
