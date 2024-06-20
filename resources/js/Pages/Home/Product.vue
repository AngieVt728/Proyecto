<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { FwbCard } from "flowbite-vue";
import { ref } from "vue";
import { getUser } from "@/Composables/usePage";
import { goodDialogs } from "gooddialogs";

const user = getUser();
const props = defineProps<{ products: Object; bags: Object }>();
const form = useForm({
    user_id: user.id,
    product_id: "",
});

const isProductInBag = (product_id: string) => {
    return props.bags.some((bag) => bag.product_id == product_id);
};

const getBagId = (product_id: string) => {
    const bag = props.bags.find((bag) => bag.product_id == product_id);
    return bag ? bag.id : null;
};

const handleSubmit = (
    product_id: string,
    action: string,
    bag_id: string | null = null
) => {
    form.product_id = product_id;
    switch (action) {
        case "store":
            form.post(route("bags.store"), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () =>
                    goodDialogs.createNotification("Agregado a pedidos", {
                        type: "success",
                    }),
                onError: (errors) =>
                    goodDialogs.createNotification("No se pudo agregar", {
                        type: "error",
                    }),
            });
            break;
        case "destroy":
            form.delete(route("bags.destroy", { id: bag_id }), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () =>
                    goodDialogs.createNotification("Quitado de pedidos", {
                        type: "warning",
                    }),
                onError: (errors) =>
                    goodDialogs.createNotification("No se pudo quitar", {
                        type: "error",
                    }),
            });
            break;
        default:
            break;
    }
};
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
                        <div class="flex justify-around mt-2">
                            <form
                                v-if="!isProductInBag(product.id)"
                                @submit.prevent="
                                    handleSubmit(product.id, 'store')
                                "
                            >
                                <input
                                    v-model="form.product_id"
                                    v-show="false"
                                    id="product_id"
                                    name="product_id"
                                    type="text"
                                />
                                <button
                                    class="flex items-center px-6 py-2 font-medium tracking-wide text-white transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
                                    type="submit"
                                >
                                    <v-icon
                                        name="hi-shopping-cart"
                                        class="w-5 h-5 mx-1"
                                    />
                                    Agregar a pedidos
                                </button>
                            </form>
                            <form
                                v-else
                                @submit.prevent="
                                    handleSubmit(
                                        product.id,
                                        'destroy',
                                        getBagId(product.id)
                                    )
                                "
                            >
                                <input
                                    v-model="form.product_id"
                                    v-show="false"
                                    id="product_id"
                                    name="product_id"
                                    type="text"
                                />
                                <button
                                    class="flex items-center px-6 py-2 font-medium tracking-wide text-white transition-colors duration-200 transform bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:bg-red-500"
                                    type="submit"
                                >
                                    <v-icon
                                        name="hi-shopping-cart"
                                        class="w-5 h-5 mx-1"
                                    />
                                    Quitar de pedidos
                                </button>
                            </form>
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
