<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { format } from "@formkit/tempo";
import Select from "@/Components/Inputs/Select.vue";
import { ref } from "vue";
import { goodDialogs } from "gooddialogs";

const props = defineProps<{ order: Object }>();
const form = useForm({
    deliver_date: "",
    status: "",
});
const statusArray = ref([
    { id: 1, name: "Por aceptar" },
    { id: 2, name: "En proceso" },
    { id: 3, name: "Entregado" },
]);

const handleSubmit = () => {
    form.patch(route("orders.update", { order: props.order }), {
        onSuccess: () =>
            goodDialogs.createNotification("Pedido actualizado con éxito", {
                type: "success",
            }),
        onError: (errors) =>
            goodDialogs.createNotification("No se pudo actualizar el pedido", {
                type: "error",
            }),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="order.deliver_date" />
        <Form
            title="Editar pedido"
            type-submit="update"
            @handle-submit="handleSubmit"
        >
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Datos de pedido
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8 py-10">
                <Input
                    id="deliver_date"
                    label-text="Fecha de entrega"
                    v-model="form.deliver_date"
                    :error="form.errors.deliver_date"
                    type="date"
                />
                <Select
                    id="roles"
                    label-text="Estado de pedido"
                    v-model="form.status"
                    :options="statusArray"
                    :error="form.errors.status"
                    name="name"
                />
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
