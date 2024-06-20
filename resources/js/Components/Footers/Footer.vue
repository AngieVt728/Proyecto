<script setup>
import {
    FwbFooter,
    FwbFooterCopyright,
    FwbFooterLink,
    FwbFooterLinkGroup,
} from "flowbite-vue";
</script>

<template>
    <fwb-footer footer-type="logo">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <hr
                class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"
            />
            <fwb-footer-copyright :href="route('user.home')" by="Imbae" />
        </div>
    </fwb-footer>
</template>
