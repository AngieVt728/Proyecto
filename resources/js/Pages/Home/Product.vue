<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";
import { FwbCard } from "flowbite-vue";
import { ref } from "vue";

const props = defineProps<{ products: Object }>();
</script>

<template>
    <HomeLayout>
        <Head title="Productos" />
        <h2
            class="text-3xl my-8 font-semibold text-gray-700 text-center uppercase"
        >
            Todos nuestros productos
        </h2>
        <div class="flex flex-wrap justify-around items-center gap-6 px-10">
            <div v-for="product in products">
                <fwb-card :img-alt="product.name" :img-src="product.image">
                    <div class="p-4">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900"
                        >
                            {{ product.name }}
                        </h5>
                        <p class="font-normal text-xs text-gray-700">
                            {{ product.description }}
                        </p>
                        <div class="flex justify-end mt-2">
                            <span class="text-2xl font-semibold text-indigo-700"
                                >{{ product.price
                                }}<span class="text-lg"> Bs.</span></span
                            >
                        </div>
                    </div>
                </fwb-card>
            </div>
        </div>
    </HomeLayout>
</template>
