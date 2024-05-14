<script setup>
import CardData from "@/Components/cards/CardData.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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

const barData = {
    labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ],
    datasets: [
        {
            label: "Data One",
            backgroundColor: "#f87979",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
        },
    ],
};

const lineData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "Data One",
            backgroundColor: "#f87979",
            data: [40, 39, 10, 40, 39, 80, 40],
        },
    ],
};

const doughnutData = {
    labels: ["VueJs", "EmberJs", "ReactJs", "AngularJs"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
            data: [40, 20, 80, 10],
        },
    ],
};

const pieData = {
    labels: ["VueJs", "EmberJs", "ReactJs", "AngularJs"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
            data: [40, 20, 80, 10],
        },
    ],
};

const options = {
    responsive: true,
};
</script>

<template>
    <Head title="Panel de control" />

    <authenticated-layout>
        <card-data title="Panel de control">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="w-full">
                    <Bar id="my-chart-id" :options="options" :data="barData" />
                </div>
                <div class="w-full">
                    <Line :data="lineData" :options="options" />
                </div>
                <div class="w-full">
                    <Doughnut :data="doughnutData" :options="options" />
                </div>
                <div class="w-full">
                    <Pie :data="pieData" :options="options" />
                </div>
            </div>
        </card-data>
    </authenticated-layout>
</template>
