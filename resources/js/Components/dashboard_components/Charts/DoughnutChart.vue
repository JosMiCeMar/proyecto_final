<template>
    <DoughnutChart :chartData="chartData" :options="options" />
</template>

<script setup>
import { DoughnutChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

const props = defineProps({
    jsonData: {
        type: Array,
        required: true,
    },
    legendPosition: {
        type: String,
        default: "bottom",
    },
    title: {
        type: String,
        default: "",
    },
    titleColor: {
        type: String,
        default: "#3A2642",
    },
    itemColors: {
        type: Array,
        default: [
            "#9A4BD4", 
            "#58A1C7", 
            "#D777E4", 
            "#2A3D42", 
            "#D1A1E0", 
            "#A5C4FF",
            "#4A1F32",
        ],
    },
});

// Adaptar los datos JSON al formato de Chart.js
const chartData = {
    labels: props.jsonData.map((item) => item.label),
    datasets: [
        {
            data: props.jsonData.map((item) => item.value),
            backgroundColor: props.itemColors,
        },
    ],
};

const options = {
    responsive: true,
    plugins: {
        legend: {
            position: props.legendPosition,
            labels: {
                font: {
                    size: 15,
                },
                color: "#315D66",
            },
        },
        title: {
            display: true,
            text: props.title,
            color: props.titleColor,
            font: {
                size: 18,
            },
        },
    },
    cutout: "0%",
};
</script>
