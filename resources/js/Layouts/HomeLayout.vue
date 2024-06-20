<script setup lang="ts">
import Navbar from "@/Components/Navbars/Navbar.vue";
import Footer from "@/Components/Footers/Footer.vue";
</script>

<template>
    <Navbar />
    <main>
        <section>
            <slot />
        </section>
    </main>
    <Footer />
</template>
