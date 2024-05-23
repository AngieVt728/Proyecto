<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Textarea from "@/Components/inputs/Textarea.vue";
import { toast } from "vue3-toastify";

const props = defineProps(["rawMaterial"]);
const form = useForm({
    name: props.rawMaterial?.name ?? "",
    price: props.rawMaterial?.price ?? "",
    description: props.rawMaterial?.description ?? "",
});

const handleSubmit = () => {
    if (props.rawMaterial?.id) {
        form.patch(
            route("raw-materials.update", { id: props.rawMaterial.id }),
            {
                onSuccess: () => toast.success("Materia prima actualizada"),
                onError: (errors) =>
                    Object.values(errors).forEach((message) => {
                        toast.error(message);
                    }),
            }
        );
    } else {
        form.post(route("raw-materials.store"), {
            onSuccess: () => toast.success("Materia prima creada"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
    }
};
</script>

<template>
    <Head title="Crear nueva materia prima" />
    <authenticated-layout>
        <Form title="Materia Prima" @handle-submit="handleSubmit">
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
        </Form>
    </authenticated-layout>
</template>
