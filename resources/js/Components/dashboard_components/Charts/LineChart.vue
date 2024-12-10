<template>
    <div>
        <LineChart :chartData="chartData" :options="options" />
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import { LineChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

const props = defineProps({
    labels: {
        type: Array,
        required: true,
    },
    values: {
        type: Array,
        required: true,
    },
    displayTitle: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: "",
    },
    subfix: {
        type: String,
        required: false,
        default: "",
    },
    titleColor: {
        type: String,
        default: "#3A2642",
    },
    itemColors: {
        type: Array,
        default: ["#58A1C7"],
    },
    lineColor: {
        type: String,
        default: "#3A2642",
    },
    stepSize: {
        type: Number,
        default: 1,
    },
});

const chartData = {
    labels: props.labels,
    datasets: [
        {
            data: props.values,
            borderColor: props.lineColor,
            backgroundColor: props.itemColors,
            pointRadius: 5,
            pointHoverRadius: 7,
        },
    ],
};

const options = {
    responsive: false,
    plugins: {
        legend: {
            display: false,
        },
        title: {
            display: props.displayTitle,
            text: props.title,
            color: props.titleColor,
            font: {
                size: 18,
            },
        },
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                stepSize: 40,
                callback: function (value) {
                    return `${value} ${props.subfix}`;
                },
                stepSize:props.stepSize
            },
        },
    },
};
</script>
