<script setup>
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import Textarea from "@/Components/inputs/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["rawMaterials"]);
const form = useForm({
    name: "",
    description: "",
    price: "",
    rawMaterials: [],
});
const itemsPerColumn = ref(4);
const rawMaterialGroups = computed(() => {
    const groups = [];
    for (let i = 0; i < props.rawMaterials.length; i += itemsPerColumn.value) {
        groups.push(props.rawMaterials.slice(i, i + itemsPerColumn.value));
    }
    return groups;
});
props.rawMaterials.forEach((material) => {
    material.quantity = 1;
    material.selected = false;
});

const updateRawMaterials = (rawMaterial, event) => {
    rawMaterial.selected = event.target.checked;
    if (rawMaterial.selected) {
        form.rawMaterials.push({
            id: rawMaterial.id,
            quantity: rawMaterial.quantity,
        });
    } else {
        form.rawMaterials = form.rawMaterials.filter(
            (item) => item.id !== rawMaterial.id
        );
    }
    console.log(form.rawMaterials);
};

const increaseQuantity = (rawMaterial) => {
    rawMaterial.quantity++;
    updateMaterialQuantity(rawMaterial);
};

const decreaseQuantity = (rawMaterial) => {
    if (rawMaterial.quantity > 1) {
        rawMaterial.quantity--;
        updateMaterialQuantity(rawMaterial);
    }
};

const updateMaterialQuantity = (rawMaterial) => {
    if (rawMaterial.selected) {
        const material = form.rawMaterials.find(
            (item) => item.id === rawMaterial.id
        );
        if (material) {
            material.quantity = rawMaterial.quantity;
        }
    }
};

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
                <h2 class="w-full font-semibold text-gray-700">
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
                            <li class="rounded-lg shadow-md p-2">
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
                                                rawMaterial.stock == 0
                                                    ? true
                                                    : false
                                            "
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
            </div>
        </Form>
    </authenticated-layout>
</template>
