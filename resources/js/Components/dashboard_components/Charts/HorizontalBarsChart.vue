<template>
    <BarChart :chartData="chartData" :options="options" />
</template>

<script setup>
import { BarChart } from "vue-chart-3";
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
    subfix: {
        type: String,
        required: false,
        default: "",
    },
    title: {
        type: String,
        default: "",
    },
    titleColor: {
        type: String,
        default: "#3A2642",
    },
    xLabel: {
        type: String,
        required: false
    },
    yLabel: {
        type: String,
        required: false
    },
    labelColor: {
        type: String,
        default: "#315D66"
    },
    barsColors: {
        type: Array,
        default: () => ["#3A2642", "#315D66"],
    },
    stepSize:{
        type:Number,
        default:1
    }
});

const chartData = {
    labels: props.jsonData.map((item) => item.label), // Labels en eje Y
    datasets: [
        {
            data: props.jsonData.map((item) => item.value), // Valores en eje X
            backgroundColor: props.barsColors,
        },
    ],
};

const options = {
    indexAxis: "y", // Esto hace que el gráfico sea horizontal
    responsive: true,
    plugins: {
        legend: {
            display: false, // Ocultar la leyenda si no se necesita
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
    scales: {
        x: {
            title: {
                display: props.xLabel ? true : false,
                text: props.xLabel,
            },
            ticks: {
                color: props.labelColor,
                callback: function (value) {
                    return `${value} ${props.subfix}`; // Añadir sufijo en valores
                },
                stepSize:props.stepSize
            },
        },
        y: {
            title: {
                display: props.yLabel ? true : false,
                text: props.yLabel,
            },
            ticks: {
                color: props.labelColor,
            },
        },
    },
};
</script>
