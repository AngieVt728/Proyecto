<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const props = defineProps(["customer"]);
const form = useForm({
    first_name: props.customer ? props.customer.first_name : "",
    last_name: props.customer ? props.customer.last_name : "",
    ci: props.customer ? props.customer.ci : "",
    email: props.customer ? props.customer.email : "",
    phone_number: props.customer ? props.customer.phone_number : "",
    address: props.customer ? props.customer.address : "",
});

const handleSubmit = () => {
    if (props.customer?.id)
        form.patch(route("customers.update", { customer: props.customer }), {
            onSuccess: () => toast.success("Cliente actualizado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
    else
        form.post(route("customers.store"), {
            onSuccess: () => toast.success("Cliente creado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
};
</script>

<template>
    <Head title="Crear nuevo cliente" />
    <authenticated-layout>
        <Form title="Cliente" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="first_name"
                    label-text="Nombre/s"
                    v-model="form.first_name"
                    type="text"
                />
                <Input
                    id="last_name"
                    label-text="Apellidos"
                    v-model="form.last_name"
                    type="text"
                />
                <Input
                    id="ci"
                    label-text="Carnet de identidad"
                    v-model="form.ci"
                    type="text"
                />
                <Input
                    id="email"
                    label-text="Correo electrónico"
                    v-model="form.email"
                    type="email"
                />
                <Input
                    id="phone_number"
                    label-text="Numero teléfono celular"
                    v-model="form.phone_number"
                    type="text"
                />
                <Input
                    id="address"
                    label-text="Dirección domicilio"
                    v-model="form.address"
                    type="text"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
