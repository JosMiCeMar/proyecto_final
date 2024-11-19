<template>
    <Head title="Informe de Tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Informe de Tratamientos"
            :description="`Informe completo de todos los tratamientos realizados`"
            :returnLink="route('client.indexTratamientos')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.tratamientos.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No tienes tratamientos realizados actualmente</span
                        >
                    </p>
                </div>
            </template>

            <!--De lo contrario, muestra los gráficos-->
            <template v-else>
                <div
                    class="my-4 lg:grid lg:grid-cols-2 flex flex-col gap-10 w-auto h-fit"
                >
                    <VerticalBarsChart
                        :jsonData="totalPricesByTreatment"
                        title="Gastos Totales por Zona de Tratamiento"
                        subfix="€"
                        class="bg-white p-4 shadow-md rounded-md"
                    />
                    <DoughnutChart
                        :jsonData="countTreatment"
                        title="Cantidad de Tratamientos Realizados por Zona"
                        class="bg-white p-4 shadow-md rounded-md"
                    />
                    <HorizontalBarsChart
                        :jsonData="countCenter"
                        title="Tratamientos Realizados por Centro"
                        class="bg-white p-4 shadow-md rounded-md"
                    />
                    <LineChart
                        :jsonData="lineData"
                        title="Gastos Totales por Año"
                        class="bg-white p-4 shadow-md rounded-md"
                    />
                </div>
            </template>
        </ContentBox>
        <p class="text-xs text-skyblue-dark ml-4 pb-4 text-center">
            <span class="font-bold">*A tener en cuenta: </span>Esto una tabla
            informativa, los precios, zonas y centros pueden verse modificados
            con el tiempo.
        </p>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";
import {
    getCountByColumnName,
    getTotalByColumnName,
} from "@/Utils/utilsFunctions";
import DoughnutChart from "@/Components/dashboard_components/Charts/DoughnutChart.vue";
import VerticalBarsChart from "@/Components/dashboard_components/Charts/VerticalBarsChart.vue";
import HorizontalBarsChart from "@/Components/dashboard_components/Charts/HorizontalBarsChart.vue";
import LineChart from "@/Components/dashboard_components/Charts/LineChart.vue";

const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    },
});

const lineData = [
    {label:"2020",value:120},
    {label:"2021",value:200},
    {label:"2022",value:70},
    {label:"2023",value:100},
    {label:"2024",value:120},
];



const totalPricesByTreatment = getTotalByColumnName(
    props.tratamientos,
    "zona_nombre",
    "zona_precio"
);

const countTreatment = getCountByColumnName(props.tratamientos, "zona_nombre");
const countCenter = getCountByColumnName(props.tratamientos, "centro_nombre");
</script>
