<template>
    <Head title="Informe de personalizado" />
    <AuthenticatedLayout>
        <ContentBox
            title="Informe personalizado"
            description="Informe con los filtros aplicados en el formulario"
            :returnLink="route('respon.indexInforme')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.tratamientos.length === 0">
                <section class="m-4 my-20">
                    <p class="text-center p-2 bg-red-300 rounded-lg">
                        <span class="text-lavender-dark font-bold sm:text-xl">
                            No se encontraron tratamientos con los filtros
                            indicados
                        </span>
                    </p>
                    <p class="text-center mt-2">
                        <Link
                            :href="route('respon.personalizarInforme')"
                            class="text-md font-semibold underline text-lavender-dark hover:text-skyblue-dark"
                            >Vuelva a intentarlo</Link
                        >
                    </p>
                </section>
            </template>

            <!--De lo contrario, muestra los gráficos-->
            <template v-else>
                <section
                    class="rounded-md font-semibold text-skyblue-dark bg-white shadow-md p-4 grid grid-cols-1 gap-5 sm:flex sm:flex-col md:grid md:grid-cols-2 md:gap-6 justify-center items-center"
                >
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi
                            :icon="mdiCashMultiple"
                            class="fill-lavender-dark"
                        />
                        <span class="text-lavender-dark"
                            >Ingresos totales:</span
                        >
                        {{
                            getCenterProfit(
                                amountByColumnName(
                                    props.tratamientos,
                                    "zona_precio"
                                )
                            )
                        }}€
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi
                            :icon="mdiCounter"
                            class="fill-lavender-dark"
                        />
                        <span class="text-lavender-dark">
                            Tratamientos totales:
                        </span>
                        {{ props.tratamientos.length }}
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi
                            :icon="mdiBadgeAccount"
                            class="fill-lavender-dark"
                        />
                        <span class="text-lavender-dark">
                            Días trabajados:
                        </span>
                        {{ countTreatmentByDay[0].length }}
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi
                            :icon="mdiClipboardTextClock"
                            class="fill-lavender-dark"
                        />
                        <span class="text-lavender-dark">
                            Tiempo estimado total:
                        </span>
                        {{ totalHours }}
                    </div>
                </section>
                <section
                    class="my-4 lg:grid lg:grid-cols-2 flex flex-col gap-10"
                >
                    <ChartContainer
                        title="Ingresos Totales por Zona de Tratamiento"
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
                        :title="`Ingresos Totales por ${
                            props.periodo ? 'Meses' : 'Años'
                        }`"
                        :labels="totalByPeriod[0]"
                        :values="totalByPeriod[1]"
                        subfix="€"
                    >
                        <LineChart
                            :labels="totalByPeriod[0]"
                            :values="totalByPeriod[1]"
                            subfix="€"
                            :stepSize="100"
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
                </section>
            </template>
        </ContentBox>
        <ReportsAdv/>
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
import LineChart from "@/Components/dashboard_components/Charts/LineChart.vue";
import ChartContainer from "@/Components/dashboard_components/Charts/ChartContainer.vue";
import ReportsAdv from "@/Components/dashboard_components/ReportsAdv.vue";
//Utilidades
import {
    amountByColumnName,
    getCountByColumnName,
    getTotalByColumnName,
    getTotalByMonth,
    getTotalByYears,
    getSumByHours,
    getCenterProfit,
} from "@/Utils/utilsFunctions";
import IconMdi from "@/Components/IconMdi.vue";
import {
    mdiBadgeAccount,
    mdiCashMultiple,
    mdiClipboardTextClock,
    mdiCounter,
} from "@mdi/js";

//Datos del backend
const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    },
    periodo: {
        type: Boolean,
        required: true,
    },
});

//Funciones para obtener los datos en formato para las gráficas
const totalByTreatment = getTotalByColumnName(
    props.tratamientos,
    "zona_nombre",
    "zona_precio",
    false
);

const totalByPeriod = props.periodo
    ? getTotalByMonth(props.tratamientos, "fecha", "zona_precio",false)
    : getTotalByYears(props.tratamientos, "fecha", "zona_precio",false);
const countTreatment = getCountByColumnName(props.tratamientos, "zona_nombre");
const countTreatmentByDay = getCountByColumnName(props.tratamientos, "fecha");

//Suma de horas trabajadas (estimación)
const totalHours = getSumByHours(props.tratamientos, "zona_tiempo");

</script>
