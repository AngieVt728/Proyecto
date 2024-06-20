<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { getRole } from "@/Composables/usePage";

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
const role = getRole();
</script>

<template>
    <GuestLayout>
        <Head title="Pagina de bienvenida" />

        <main class="w-full h-full z-50">
            <div
                class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-52"
            >
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl"
                >
                    Sistema Imbae
                </h1>
                <p
                    class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48"
                >
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Magnam, vero fuga. Est officiis qui quasi aliquid molestiae
                    ad animi ex sint, voluptas harum alias officia, illum minima
                    id nulla voluptatum?
                </p>
                <div
                    class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0"
                >
                    <div v-if="canLogin">
                        <div v-if="role != 'user'">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white bg-indigo-600 rounded-md focus:outline-none hover:bg-indigo-500"
                            >
                                Ir al panel de control<v-icon
                                    class="ml-1 font-medium"
                                    name="hi-arrow-right"
                                />
                            </Link>
                        </div>
                        <div v-else>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('user.home')"
                                class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white bg-indigo-600 rounded-md focus:outline-none hover:bg-indigo-500"
                            >
                                Ir al inicio<v-icon
                                    class="ml-1 font-medium"
                                    name="hi-arrow-right"
                                />
                            </Link>
                        </div>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white bg-indigo-600 rounded-md focus:outline-none hover:bg-indigo-500 mr-4 lg:mr-0"
                            >
                                Ir a inicio de sesión
                                <v-icon
                                    class="ml-1 font-medium"
                                    name="hi-arrow-right"
                                />
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400"
                            >
                                Registrarse
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </main>
    </GuestLayout>
</template>
