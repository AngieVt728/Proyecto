<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import CardStat from "@/Components/cards/CardStat.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useGeolocation } from "@/Composables/useGeolocation";
import { Head } from "@inertiajs/vue3";
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    Title,
    Tooltip,
} from "chart.js";
import { Bar, Doughnut, Line, Pie } from "vue-chartjs";
import { Loader } from "@googlemaps/js-api-loader";
import { onMounted, computed, ref } from "vue";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    PointElement,
    LineElement
);

const props = defineProps([
    "rawMaterials",
    "products",
    "totalProducts",
    "totalOrders",
    "totalSales",
    "retailOutlets",
]);

const MAPS_API_KEY = import.meta.env.VITE_MAPS_API_KEY;
const { coords } = useGeolocation();
const currPos = computed(() => ({
    lat: coords.value.latitude,
    lng: coords.value.longitude,
}));
const loader = new Loader({
    apiKey: MAPS_API_KEY,
    version: "weekly",
});
const mapDiv = ref(null);

const options = {
    responsive: true,
    plugins: {
        legend: {
            display: false,
        },
    },
};
const rawMaterialData = {
    labels: props.rawMaterials.map((rawMaterial) => rawMaterial.name),
    datasets: [
        {
            label: "MATERIA PRIMA",
            backgroundColor: props.rawMaterials.map(
                (rawMaterial) => rawMaterial.color
            ),
            data: props.rawMaterials.map((rawMaterial) => rawMaterial.stock),
        },
    ],
};
const productsData = {
    labels: props.products.map((product) => product.name),
    datasets: [
        {
            backgroundColor: props.products.map((product) => product.color),
            data: props.products.map((product) => product.stock),
        },
    ],
};

onMounted(async () => {
    const { Map, InfoWindow } = await loader.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } =
        await google.maps.importLibrary("marker");

    const map = new Map(mapDiv.value, {
        center: props.retailOutlet ? roPos.value : currPos.value,
        zoom: 15,
        mapId: "DEMO_MAP_ID",
    });
    const infoWindow = new InfoWindow();

    props.retailOutlets.forEach(({ position, name }, i) => {
        const pinElement = new PinElement({
            glyph: `${i + 1}`,
        });
        const marker = new AdvancedMarkerElement({
            position,
            map,
            title: `${i + 1}. ${name}`,
            content: pinElement.element,
        });

        marker.addListener("click", ({ domEvent, latLng }) => {
            const { target } = domEvent;

            infoWindow.close();
            infoWindow.setContent(marker.title);
            infoWindow.open(marker.map, marker);
        });
    });
});
</script>

<template>
    <Head title="Panel de control" />

    <authenticated-layout>
        <card-data title="Panel de control">
            <div class="flex flex-wrap -mx-6">
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Productos en stock"
                        :quantity="totalProducts"
                        :icon-bg="'bg-indigo-600'"
                        :icon-name="'hi-inbox'"
                        :route="route('products.index')"
                    />
                </div>
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Pedidos registrados hoy"
                        :quantity="totalOrders"
                        :icon-bg="'bg-blue-600'"
                        :icon-name="'hi-solid-hand'"
                        :route="route('orders.index')"
                    />
                </div>
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Ventas registradas hoy"
                        :quantity="totalSales"
                        :icon-bg="'bg-pink-600'"
                        :icon-name="'hi-solid-clipboard-check'"
                        :route="route('sales.index')"
                    />
                </div>
            </div>

            <div class="mt-4">
                <h2
                    class="font-semibold uppercase text-sm text-gray-600 py-4 ml-4"
                >
                    Puntos de venta registrados
                </h2>
                <div ref="mapDiv" style="width: 100%; height: 400px" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 mt-4 gap-4">
                <div class="rounded-lg shadow-lg border border-gray-100 p-2">
                    <h2
                        class="font-semibold uppercase text-sm text-gray-600 py-4 ml-4"
                    >
                        Materia Prima Disponible
                    </h2>
                    <div
                        class="flex justify-center content-center items-center"
                    >
                        <Bar
                            id="my-chart-id"
                            :options="options"
                            :data="rawMaterialData"
                        />
                    </div>
                </div>
                <div class="rounded-lg shadow-lg border border-gray-100 p-2">
                    <h2
                        class="font-semibold uppercase text-sm text-gray-600 py-4 ml-4"
                    >
                        Productos Disponibles
                    </h2>
                    <div
                        class="flex justify-center content-center items-center h-[300px] lg:h-[230px]"
                    >
                        <Pie :data="productsData" :options="options" />
                    </div>
                </div>
            </div>
        </card-data>
    </authenticated-layout>
</template>
