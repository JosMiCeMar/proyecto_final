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
    jsonData: {
        type: Array,
        required: true,
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
        default:["#58A1C7"]
    },
});
  
 // Adaptar los datos JSON al formato de Chart.js
const chartData = {
    labels: props.jsonData.map((item) => item.label),
    datasets: [
        {
            data: props.jsonData.map((item) => item.value),
            borderColor:"#3A2642",
            backgroundColor: props.itemColors,
            tension: 0.4,
            pointRadius:5,
            pointHoverRadius:7
        },
    ],
};

const options = {
    responsive: true,
    plugins: {
        legend:{
            display:false
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
  