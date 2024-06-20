<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";
import { FwbCarousel, FwbCard } from "flowbite-vue";
import { ref } from "vue";

const props = defineProps<{ products: Object }>();
const pictures = ref([]);

props.products.forEach((product) => {
    const picture = { src: product.image, alt: product.name };
    pictures.value.push(picture);
});
</script>

<template>
    <HomeLayout>
        <Head title="Inicio" />
        <div>
            <fwb-carousel :pictures="pictures" slide />
        </div>
        <h2
            class="text-2xl my-8 font-semibold text-gray-700 text-center uppercase"
        >
            Detalles de los últimos productos agregados
        </h2>
        <div class="flex flex-wrap justify-around gap-6 items-center px-10">
            <div v-for="product in products">
                <fwb-card
                    :img-alt="product.name"
                    :img-src="product.image"
                    variant="horizontal"
                >
                    <div class="p-4">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900"
                        >
                            {{ product.name }}
                        </h5>
                        <p
                            class="font-normal text-xs text-gray-700 truncate text-wrap max-h-8"
                        >
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
