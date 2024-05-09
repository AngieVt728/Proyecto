<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps(["supplier"]);

const form = useForm({
    name: props.supplier ? props.supplier.name : "",
    nit: props.supplier ? props.supplier.nit : "",
    description: props.supplier ? props.supplier.description : "",
    email: props.supplier ? props.supplier.email : "",
    phone_number: props.supplier ? props.supplier.phone_number : "",
    address: props.supplier ? props.supplier.address : "",
});

const handleSubmit = () => {
    if (props.supplier?.id)
        form.patch(route("suppliers.update", { id: props.supplier.id }), {
            onFinish: () =>
                form.reset(
                    "name",
                    "nit",
                    "description",
                    "email",
                    "phone_number",
                    "address"
                ),
        });
    else
        form.post(route("suppliers.store"), {
            onFinish: () =>
                form.reset(
                    "name",
                    "nit",
                    "description",
                    "email",
                    "phone_number",
                    "address"
                ),
        });
};
</script>

<template>
    <Head title="Crear nuevo proveedor" />
    <authenticated-layout>
        <Form title="Proveedor" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="name"
                    label-text="Razón Social"
                    v-model="form.name"
                    :error="form.errors.name"
                    type="text"
                />
                <Input
                    id="nit"
                    label-text="NIT"
                    v-model="form.nit"
                    :error="form.errors.nit"
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
                    id="email"
                    label-text="Correo electrónico"
                    v-model="form.email"
                    :error="form.errors.email"
                    type="email"
                />
                <Input
                    id="phone_number"
                    label-text="Número de Teléfono"
                    v-model="form.phone_number"
                    :error="form.errors.phone_number"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    :error="form.errors.address"
                    type="text"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
