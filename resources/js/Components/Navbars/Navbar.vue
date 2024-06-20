<script setup>
import {
    FwbNavbar,
    FwbNavbarCollapse,
    FwbNavbarLink,
    FwbNavbarLogo,
} from "flowbite-vue";
</script>

<template>
    <fwb-navbar>
        <template #logo>
            <fwb-navbar-logo
                alt="Imbae logo"
                image-url="/images/logoimbae2.png"
                :link="route('user.home')"
            >
            </fwb-navbar-logo>
        </template>
        <template #default="{ isShowMenu }">
            <fwb-navbar-collapse :is-show-menu="isShowMenu">
                <fwb-navbar-link is-active :link="route('user.home')">
                    Inicio
                </fwb-navbar-link>
                <fwb-navbar-link :link="route('user.products')">
                    Productos
                </fwb-navbar-link>
                <fwb-navbar-link :link="route('user.orders')">
                    Pedidos
                </fwb-navbar-link>
                <fwb-navbar-link :link="route('user.profile')">
                    Mi cuenta
                </fwb-navbar-link>
            </fwb-navbar-collapse>
        </template>
    </fwb-navbar>
</template>
