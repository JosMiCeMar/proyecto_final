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
                <section class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No tienes tratamientos realizados actualmente</span
                        >
                    </p>
                </section>
            </template>

            <!--De lo contrario, muestra los gráficos-->
            <template v-else>
                <section
                    class="my-4 lg:grid lg:grid-cols-2 flex flex-col gap-10"
                >
                    <ChartContainer
                        title="Gastos Totales por Zona de Tratamiento"
                        :labels="totalByTreatment[0]"
                        :values="totalByTreatment[1]"
                        subfix="€"
                    >
                        <VerticalBarsChart
                            :labels="totalByTreatment[0]"
                            :values="totalByTreatment[1]"
                            subfix="€"
                            :stepSize="25"
                        />
                    </ChartContainer>
                    <ChartContainer
                        title="Gastos Totales por Año"
                        :labels="totalByYear[0]"
                        :values="totalByYear[1]"
                        subfix="€"
                    >
                        <LineChart
                            :labels="totalByYear[0]"
                            :values="totalByYear[1]"
                        />
                    </ChartContainer>
                    <ChartContainer
                        title="Tratamientos Totales por Zona"
                        :labels="countTreatment[0]"
                        :values="countTreatment[1]"
                    >
                        <DoughnutChart
                            :labels="countTreatment[0]"
                            :values="countTreatment[1]"
                            legendPosition="left"
                        />
                    </ChartContainer>
                    <ChartContainer
                        title="Tratamientos Totales por Centro"
                        :labels="countCenter[0]"
                        :values="countCenter[1]"
                    >
                        <HorizontalBarsChart
                            :labels="countCenter[0]"
                            :values="countCenter[1]"
                        />
                    </ChartContainer>
                </section>
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
    getTotalByYears,
} from "@/Utils/utilsFunctions";
import DoughnutChart from "@/Components/dashboard_components/Charts/DoughnutChart.vue";
import VerticalBarsChart from "@/Components/dashboard_components/Charts/VerticalBarsChart.vue";
import HorizontalBarsChart from "@/Components/dashboard_components/Charts/HorizontalBarsChart.vue";
import LineChart from "@/Components/dashboard_components/Charts/LineChart.vue";
import ChartContainer from "@/Components/dashboard_components/Charts/ChartContainer.vue";

const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    },
});

const totalByTreatment = getTotalByColumnName(
    props.tratamientos,
    "zona_nombre",
    "zona_precio"
);
const totalByYear = getTotalByYears(props.tratamientos, "fecha", "zona_precio");
const countTreatment = getCountByColumnName(props.tratamientos, "zona_nombre");
const countCenter = getCountByColumnName(props.tratamientos, "centro_nombre");
</script>
