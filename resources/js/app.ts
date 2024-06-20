import "gooddialogs/dist/base.min.css";
import "vue3-toastify/dist/index.css";
import "../css/app.css";
import "../../node_modules/flowbite-vue/dist/index.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { DefineComponent, createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as HiIcons from "oh-vue-icons/icons/hi";
import Vue3Toasity from "vue3-toastify";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const Hi = Object.values({ ...HiIcons });
addIcons(...Hi);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Vue3Toasity, {
                autoClose: 3000,
                multiple: true,
                limit: 5,
            })
            .use(ZiggyVue)
            .component("v-icon", OhVueIcon)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
