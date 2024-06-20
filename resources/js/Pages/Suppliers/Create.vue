<script setup>
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import Textarea from "@/Components/Inputs/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const props = defineProps(["supplier"]);
const form = useForm({
    name: props.supplier?.name ?? "",
    nit: props.supplier?.nit ?? "",
    description: props.supplier?.description ?? "",
    email: props.supplier?.email ?? "",
    phone_number: props.supplier?.phone_number ?? "",
    address: props.supplier?.address ?? "",
});

const handleSubmit = () => {
    if (props.supplier?.id)
        form.patch(route("suppliers.update", { id: props.supplier.id }), {
            onSuccess: () => toast.success("Proveedor actualizado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
    else
        form.post(route("suppliers.store"), {
            onSuccess: () => toast.success("Proveedor creado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
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
                    id="email"
                    label-text="Correo electrónico"
                    v-model="form.email"
                    :error="form.errors.email"
                    type="email"
                />
                <Textarea
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    :error="form.errors.description"
                    class="lg:row-span-2"
                />
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    :error="form.errors.address"
                    type="text"
                />
                <Input
                    id="phone_number"
                    label-text="Número de teléfono"
                    v-model="form.phone_number"
                    :error="form.errors.phone_number"
                    type="text"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
