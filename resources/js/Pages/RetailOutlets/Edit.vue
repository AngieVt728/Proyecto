<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import InputFile from "@/Components/Inputs/InputFile.vue";
import Textarea from "@/Components/Inputs/Textarea.vue";
import Select from "@/Components/Inputs/Select.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";
import { useGeolocation } from "@/Composables/useGeolocation";
import { Loader } from "@googlemaps/js-api-loader";
import { computed, onMounted, ref } from "vue";

const props = defineProps<{ retailOutlet: Object; customers: Object }>();
const form = useForm({
    name: props.retailOutlet?.name,
    nit: props.retailOutlet?.nit,
    description: props.retailOutlet?.description,
    address: props.retailOutlet?.address,
    lat: props.retailOutlet?.lat,
    lng: props.retailOutlet?.lng,
});
const MAPS_API_KEY = import.meta.env.VITE_MAPS_API_KEY;
const { coords } = useGeolocation();
const currPos = computed(() => ({
    lat: coords.value.latitude,
    lng: coords.value.longitude,
}));
const roPos = computed(() => ({
    lat: parseFloat(props.retailOutlet?.lat),
    lng: parseFloat(props.retailOutlet?.lng),
}));
const loader = new Loader({
    apiKey: MAPS_API_KEY,
    version: "weekly",
});
const mapDiv = ref(null);

const handleSubmit = () => {
    form.patch(
        route("retail-outlets.update", { retail_outlet: props.retailOutlet }),
        {
            onSuccess: () =>
                goodDialogs.createNotification(
                    "Punto de venta actualizado con éxito",
                    {
                        type: "success",
                    }
                ),
            onError: (errors) =>
                goodDialogs.createNotification(
                    "No se pudo actualizar el punto de venta",
                    {
                        type: "error",
                    }
                ),
        }
    );
};

onMounted(async () => {
    const { Map, InfoWindow } = await loader.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    const map = new Map(mapDiv.value, {
        center: props.retailOutlet ? roPos.value : currPos.value,
        zoom: 15,
        mapId: "DEMO_MAP_ID",
    });
    const infoWindow = new InfoWindow();
    const draggableMarker = new AdvancedMarkerElement({
        map,
        position: props.retailOutlet ? roPos.value : currPos.value,
        gmpDraggable: true,
    });

    draggableMarker.addListener("dragend", (event) => {
        form.lat = event.latLng.lat();
        form.lng = event.latLng.lng();

        infoWindow.close();
        infoWindow.setContent(`Posición actual: ${form.lat}, ${form.lng}`);
        infoWindow.open(draggableMarker.map, draggableMarker);
    });
});
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="retailOutlet.name" />
        <Form
            title="Información de punto de venta"
            type-submit="update"
            @handle-submit="handleSubmit"
        >
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Datos del punto de venta
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8">
                <Select
                    id="user_id"
                    label-text="Propietario"
                    v-model="retailOutlet.user_id"
                    :options="customers"
                    name="full_name"
                    :disabled="true"
                />
                <Input
                    id="nit"
                    label-text="NIT"
                    v-model="form.nit"
                    :error="form.errors.nit"
                    type="text"
                />
                <Input
                    id="name"
                    label-text="Razón social"
                    v-model="form.name"
                    :error="form.errors.name"
                    type="text"
                />
            </div>
            <div class="grid grid-cols-1 gap-4 mx-8">
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    :error="form.errors.address"
                    type="text"
                />
            </div>
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Datos de ubicación
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mx-8">
                <div class="grid grid-cols-1 mt-4">
                    <Input
                        id="lat"
                        label-text="Latitud"
                        v-model="form.lat"
                        :error="form.errors.lat"
                        type="text"
                        disabled
                    />
                    <Input
                        id="lng"
                        label-text="Longitud"
                        v-model="form.lng"
                        :error="form.errors.lng"
                        type="text"
                        disabled
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
            <h2
                class="ml-4 mt-4 mb-2 font-semibold text-sm uppercase text-gray-500"
            >
                Punto en el mapa
            </h2>
            <div class="mb-4">
                <div ref="mapDiv" style="width: 100%; height: 400px" />
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
