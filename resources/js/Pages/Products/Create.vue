<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    precio: "",
    stock: "",
});

const handleSubmit = () => {
    form.post(route("users.store"), {
        onFinish: () =>
            form.reset(
                "name",
                "description",
                "precio",
                "stock"
            ),
    });
};
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
                    type="text"
                />
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    type="text"
                />
                <Input
                    id="price"
                    label-text="Precio"
                    v-model="form.precio"
                    type="text"
                />
                <Input
                    id="stock"
                    label-text="Stock"
                    v-model="form.stock"
                    type="text"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
