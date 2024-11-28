<template>
    <Head title="Informe de Tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Informe Personalizado"
            description="Informe con los filtros aplicados en el formulario"
            :returnLink="route('client.indexTratamientos')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.tratamientos.length === 0">
                <section class="m-4 my-20">
                    <p class="text-center p-2 bg-red-300 rounded-lg">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl "
                        >
                            No se encontraron tratamientos con los filtros
                            indicados
                        </span>
                    </p>
                    <p class="text-center mt-2">
                        <Link
                            :href="route('client.personalizarInforme')"
                            class="text-md font-semibold underline text-lavender-dark hover:text-skyblue-dark"
                            >Vuelva a intentarlo</Link
                        >
                    </p>
                </section>
            </template>

            <!--De lo contrario, muestra los gráficos-->
            <template v-else>
                <section
                    class="rounded-md font-semibold text-skyblue-dark bg-white shadow-md flex flex-col sm:flex-row sm:justify-around justify-center items-center p-4"
                >
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi :icon="mdiCashMultiple" class="fill-lavender-dark"/>
                        <span class="text-lavender-dark">Gastos totales:</span>
                        {{
                            amountByColumnName(
                                props.tratamientos,
                                "zona_precio"
                            )
                        }}€
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi :icon="mdiCounter" class="fill-lavender-dark"/>
                        <span class="text-lavender-dark">
                            Tratamientos totales:
                        </span>
                        {{ props.tratamientos.length }}
                    </div>
                </section>
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
                        :title="`Gastos Totales por ${props.periodo?'Meses':'Años'}`"
                        :labels="totalByPeriod[0]"
                        :values="totalByPeriod[1]"
                        subfix="€"
                    >
                        <LineChart
                            :labels="totalByPeriod[0]"
                            :values="totalByPeriod[1]"
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
//Importaciones de vue
import { Head, Link } from "@inertiajs/vue3";
//Componentes
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import DoughnutChart from "@/Components/dashboard_components/Charts/DoughnutChart.vue";
import VerticalBarsChart from "@/Components/dashboard_components/Charts/VerticalBarsChart.vue";
import HorizontalBarsChart from "@/Components/dashboard_components/Charts/HorizontalBarsChart.vue";
import LineChart from "@/Components/dashboard_components/Charts/LineChart.vue";
import ChartContainer from "@/Components/dashboard_components/Charts/ChartContainer.vue";
//Utilidades
import {
    amountByColumnName,
    getCountByColumnName,
    getTotalByColumnName,
    getTotalByMonth,
    getTotalByYears,
} from "@/Utils/utilsFunctions";
import IconMdi from "@/Components/IconMdi.vue";
import { mdiCashMultiple, mdiCounter } from "@mdi/js";

//Datos del backend
const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    },
    periodo:{
        type:Boolean,
        required:true
    }
});

//Funciones para obtener los datos en formato para las gráficas
const totalByTreatment = getTotalByColumnName(
    props.tratamientos,
    "zona_nombre",
    "zona_precio"
);



const totalByPeriod =props.periodo?getTotalByMonth(props.tratamientos, "fecha", "zona_precio"):getTotalByYears(props.tratamientos, "fecha", "zona_precio");
const countTreatment = getCountByColumnName(props.tratamientos, "zona_nombre");
const countCenter = getCountByColumnName(props.tratamientos, "centro_nombre");
</script>
