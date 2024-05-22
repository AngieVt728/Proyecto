<script setup>
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import Textarea from "@/Components/inputs/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["rawMaterials", "product", "productRawMaterial"]);
const form = useForm({
    name: props.product?.name ?? "",
    description: props.product?.description ?? "",
    price: props.product?.price ?? "",
    rawMaterials:
        props.productRawMaterial?.length > 0 ? props.productRawMaterial : [],
});
const rawMaterialGroups = computed(() => {
    const groups = [];
    for (let i = 0; i < props.rawMaterials.length; i += 4) {
        groups.push(props.rawMaterials.slice(i, i + 4));
    }
    return groups;
});
props.rawMaterials.forEach((material) => {
    const materialFound = form.rawMaterials.find(
        (item) => item.id === material.id
    );
    if (materialFound) {
        material.quantity = materialFound.quantity;
        material.cost = materialFound.cost;
        material.selected = true;
    } else {
        material.quantity = 1;
        material.cost = material.price;
        material.selected = false;
    }
});

const updateRawMaterials = (rawMaterial, event) => {
    rawMaterial.selected = event.target.checked;
    if (rawMaterial.selected) {
        form.rawMaterials.push({
            id: rawMaterial.id,
            quantity: rawMaterial.quantity,
            cost: rawMaterial.cost,
        });
    } else {
        form.rawMaterials = form.rawMaterials.filter(
            (item) => item.id !== rawMaterial.id
        );
    }
};

const increaseQuantity = (rawMaterial) => {
    if (rawMaterial.quantity < rawMaterial.stock) {
        rawMaterial.quantity++;
        rawMaterial.cost = parseFloat(
            (rawMaterial.cost + rawMaterial.price).toFixed(2)
        );
    }
    updateMaterialQuantity(rawMaterial);
};

const decreaseQuantity = (rawMaterial) => {
    if (rawMaterial.quantity > 1) {
        rawMaterial.quantity--;
        rawMaterial.cost = parseFloat(
            (rawMaterial.cost - rawMaterial.price).toFixed(2)
        );
    }
    updateMaterialQuantity(rawMaterial);
};

const updateMaterialQuantity = (rawMaterial) => {
    if (rawMaterial.selected) {
        const material = form.rawMaterials.find(
            (item) => item.id === rawMaterial.id
        );
        if (material) {
            material.quantity = rawMaterial.quantity;
            material.cost = rawMaterial.cost;
        }
    }
};

const totalCost = computed(() => {
    return form.rawMaterials
        .reduce((acc, item) => acc + item.cost, 0)
        .toFixed(2);
});

const handleSubmit = () => {
    if (props.product?.id) {
        form.patch(route("products.update", { id: props.product.id }), {
            onSuccess: () => toast.success("Producto actualizado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
    } else {
        form.post(route("products.store"), {
            onSuccess: () => toast.success("Producto creado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
    }
};
</script>

<template>
    <Head title="Crear nuevo producto" />
    <authenticated-layout>
        <Form title="Producto" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <div class="grid grid-cols-1 mt-4">
                    <Input
                        id="name"
                        label-text="Nombre"
                        v-model="form.name"
                        :error="form.errors.name"
                        type="text"
                    />
                    <Input
                        id="price"
                        label-text="Precio"
                        v-model="form.price"
                        :error="form.errors.price"
                        type="text"
                    />
                </div>
                <div class="grid grid-cols-1 -mt-2 lg:mt-4">
                    <Textarea
                        id="description"
                        label-text="Descripción"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </div>
            </div>

            <div class="mt-4">
                <h2 class="font-semibold ml-4 text-gray-700">
                    Lista de materia prima
                </h2>
                <div class="grid grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(group, groupIndex) in rawMaterialGroups"
                        :key="groupIndex"
                    >
                        <ul
                            class="p-2"
                            v-for="rawMaterial in group"
                            :key="rawMaterial.id"
                        >
                            <li class="rounded-lg border-2 shadow-md p-2">
                                <div class="flex">
                                    <div class="flex items-center h-5">
                                        <input
                                            class="text-indigo-600 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                                            :id="rawMaterial.id"
                                            @change="
                                                updateRawMaterials(
                                                    rawMaterial,
                                                    $event
                                                )
                                            "
                                            type="checkbox"
                                            :disabled="
                                                rawMaterial.stock == 0 &&
                                                !rawMaterial.selected
                                                    ? true
                                                    : false
                                            "
                                            :checked="rawMaterial.selected"
                                        />
                                    </div>
                                    <div class="ms-2 text-sm">
                                        <label
                                            :for="rawMaterial.id"
                                            :class="
                                                rawMaterial.stock == 0
                                                    ? 'font-medium text-gray-700 line-through'
                                                    : 'font-medium text-gray-700'
                                            "
                                        >
                                            {{ rawMaterial.name }}
                                        </label>
                                        <p
                                            id="helper-checkbox-text"
                                            class="text-xs font-normal text-gray-600"
                                        >
                                            Precio:
                                            <span class="font-semibold">
                                                ${{ rawMaterial.price }}
                                            </span>
                                            - En stock:
                                            <span class="font-semibold">
                                                {{ rawMaterial.stock }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div
                                    v-if="rawMaterial.selected"
                                    class="flex justify-center items-center mt-2"
                                >
                                    <div>
                                        <label
                                            :for="rawMaterial.quantity"
                                            class="block text-xs text-center font-medium text-gray-700"
                                            >Cantidad:</label
                                        >
                                        <div class="relative flex items-center">
                                            <button
                                                class="flex-shrink-0 bg-red-500 hover:bg-red-600 inline-flex items-center justify-center border border-red-600 rounded-md h-5 w-5 focus:ring-red-600 focus:ring-2 focus:outline-none"
                                                @click="
                                                    decreaseQuantity(
                                                        rawMaterial
                                                    )
                                                "
                                                type="button"
                                            >
                                                <svg
                                                    class="w-2.5 h-2.5 text-gray-50"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 18 2"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M1 1h16"
                                                    />
                                                </svg>
                                            </button>
                                            <input
                                                class="flex-shrink-0 text-gray-700 border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-16 text-center"
                                                :id="rawMaterial.quantity"
                                                v-model="rawMaterial.quantity"
                                                type="text"
                                            />
                                            <button
                                                class="flex-shrink-0 bg-green-500 hover:bg-green-600 inline-flex items-center justify-center border border-green-600 rounded-md h-5 w-5 focus:ring-green-600 focus:ring-2 focus:outline-none"
                                                @click="
                                                    increaseQuantity(
                                                        rawMaterial
                                                    )
                                                "
                                                type="button"
                                            >
                                                <svg
                                                    class="w-2.5 h-2.5 text-gray-50"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 18 18"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 1v16M1 9h16"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex justify-end items-center m-4">
                    <div
                        class="py-6 px-4 lg:px-24 border-2 rounded-lg shadow-lg"
                    >
                        <h2
                            class="font-semibold text-center text-md uppercase text-gray-700 mb-2"
                        >
                            Total costo de producción
                        </h2>
                        <p
                            class="text-xs lg:text-sm text-gray-800 font-medium flex justify-between items-center"
                        >
                            Cantidad materia prima seleccionada:
                            <span class="font-bold text-lg text-indigo-600">{{
                                form.rawMaterials.length
                            }}</span>
                        </p>
                        <p
                            class="text-xs lg:text-sm text-gray-800 font-medium flex justify-between items-center"
                        >
                            Costo total materia prima seleccionada: $<span
                                class="font-bold text-lg text-indigo-600"
                                >{{ totalCost }}</span
                            >
                        </p>
                    </div>
                </div>
            </div>
        </Form>
    </authenticated-layout>
</template>
