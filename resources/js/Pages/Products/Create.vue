<script setup>
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import Select from "@/Components/inputs/Select.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const props = defineProps([
    "product",
    "raw_materials_product",
    "raw_materials",
]);
const rawMaterialsIdName = props.raw_materials_product
    ? ref(props.raw_materials_product)
    : ref([]);
const rawMaterialId = ref("");
const mpExist = ref(false);

const rawMaterialsId = () => {
    const array = ref([]);
    console.log(props.raw_materials_product);
    if (props.raw_materials_product)
        props.raw_materials_product.forEach((element) => {
            array.value.push(element.id);
        });
    return array.value;
};

const rawMaterialsPrice = (materials) => {
    let total = 0;
    materials.forEach((material) => (total += material.price));
    return total;
};

const totalPrice = ref(
    props.raw_materials_product
        ? rawMaterialsPrice(props.raw_materials_product)
        : 0
);

const form = useForm({
    name: props.product ? props.product.name : "",
    description: props.product ? props.product.description : "",
    price: props.product ? props.product.price : "",
    stock: props.product ? props.product.stock : "",
    rawMaterials: props.raw_materials_product ? rawMaterialsId() : [],
});

const handleSubmit = () => {
    if (props.product?.id)
        form.patch(route("products.update", { id: props.product.id }), {
            onFinish: () =>
                form.reset("name", "description", "precio", "stock"),
        });
    else
        form.post(route("products.store"), {
            onFinish: () =>
                form.reset("name", "description", "precio", "stock"),
        });
};

const addRawMaterialId = () => {
    if (
        rawMaterialId.value &&
        !form.rawMaterials.includes(rawMaterialId.value)
    ) {
        mpExist.value = false;
        form.rawMaterials.push(rawMaterialId.value);
        const id = rawMaterialId.value;
        const name = getMaterialName(rawMaterialId.value);
        const price = getPriceMP(rawMaterialId.value);
        totalPrice.value += price;
        rawMaterialsIdName.value.push({ id, name, price });
    } else {
        mpExist.value = true;
    }
};

const getMaterialName = (id) => {
    for (let key in props.raw_materials) {
        if (props.raw_materials[key].id == id)
            return props.raw_materials[key].name;
    }
};

const getPriceMP = (id) => {
    for (let key in props.raw_materials) {
        if (props.raw_materials[key].id == id)
            return parseFloat(props.raw_materials[key].price);
    }
};

onMounted(() => {
    rawMaterialsId();
});
</script>

<template>
    <Head title="Crear nuevo usuario" />
    <authenticated-layout>
        <Form title="Producto" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="name"
                    label-text="Nombre"
                    v-model="form.name"
                    :error="form.errors.name"
                    type="text"
                />
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    :error="form.errors.description"
                    type="text"
                />
                <Input
                    id="price"
                    label-text="Precio"
                    v-model="form.price"
                    :error="form.errors.price"
                    type="text"
                />
                <Input
                    id="stock"
                    label-text="Stock"
                    v-model="form.stock"
                    :error="form.errors.stock"
                    type="text"
                />
            </div>
            <div class="grid grid-cols-1 mt-4">
                <h2 class="font-semibold text-sm ml-4 uppercase text-gray-800">
                    Agregar materia prima para el producto
                    <span class="text-xs font-light lowercase"
                        >(selecciona toda la materia prima requerida)</span
                    >
                </h2>
                <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                    <div class="grid grid-cols-1">
                        <h2 class="text-sm text-gray-700 text-center -mb-2">
                            Materiales seleccionados
                        </h2>
                        <div
                            class="bg-gray-100 rounded-lg w-full h-72 mt-4 shadow-md ml-2"
                        >
                            <ul class="p-4 grid grid-cols-4 gap-3">
                                <p
                                    v-for="material in rawMaterialsIdName"
                                    class="text-xs text-left text-gray-800 bg-gray-300 rounded-lg p-2 uppercase"
                                >
                                    {{
                                        `${material.id}. ${material.name} Bs. ${material.price}`
                                    }}
                                </p>
                            </ul>
                        </div>
                        <div class="w-full flex justify-center mt-2">
                            <p v-show="mpExist" class="text-red-500 text-md">
                                Materia prima ya agregada
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <Select
                            id="rawMaterials"
                            label-text="Materia prima disponible"
                            v-model="rawMaterialId"
                            :options="raw_materials"
                            :error="form.errors.rawMaterials"
                        />
                        <div class="w-full align-middle -mt-4 lg:mt-9">
                            <button
                                class="flex justify-center items-center w-full px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:bg-green-500 overflow-hidden truncate"
                                @click="addRawMaterialId"
                                type="button"
                            >
                                <v-icon
                                    name="hi-solid-plus-circle"
                                    class="mr-1"
                                />
                                Agregar
                            </button>
                        </div>
                        <div class="font-semibold flex justify-center w-full">
                            <p class="text-center uppercase">
                                Precio total de MP:
                                <span class="text-blue-500">{{
                                    totalPrice
                                }}</span>
                                Bs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </Form>
    </authenticated-layout>
</template>
