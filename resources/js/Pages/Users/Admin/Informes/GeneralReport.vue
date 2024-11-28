<template>
    <Head title="Informe Último Mes" />
    <AuthenticatedLayout>
        <ContentBox
            title="Informe General"
            description="Resumen de todos los datos almacenados"
            :returnLink="route('admin.indexInforme')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.tratamientos.length === 0">
                <section class="m-4 my-20">
                    <p class="text-center p-2 bg-red-300 rounded-lg">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No hay datos</span
                        >
                    </p>
                </section>
            </template>

            <!--De lo contrario, muestra la información-->
            <template v-else>
                <section
                    class="rounded-md font-semibold text-skyblue-dark bg-gradient-to-b from-white via-blue-100 to-pink-100 shadow-md p-4 grid grid-cols-1 gap-5 sm:flex sm:flex-col md:grid md:grid-cols-2 md:gap-6 justify-center items-center"
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
                            amountByColumnName(
                                props.tratamientos,
                                "precio_zona"
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
                            :icon="mdiCashRegister"
                            class="fill-lavender-dark"
                        />
                        <span class="text-lavender-dark">
                            Centro con más ingresos:
                        </span>
                        {{ totalTreatmentByCenters[0][indexMaxBenefits] }} -
                        {{ totalTreatmentByCenters[1][indexMaxBenefits] }}€
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <IconMdi
                            :icon="mdiStorePlus"
                            class="fill-lavender-dark"
                        />
                        <span class="text-lavender-dark">
                            Centro con más tratamientos:
                        </span>
                        {{ countTreatmentByCenters[0][indexMaxTreatment] }} -
                        {{ countTreatmentByCenters[1][indexMaxTreatment] }}
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
                        title="Igresos Totales por Centro Asociado"
                        :labels="totalTreatmentByCenters[0]"
                        :values="totalTreatmentByCenters[1]"
                        subfix="€"
                    >
                        <VerticalBarsChart
                            :labels="totalTreatmentByCenters[0]"
                            :values="totalTreatmentByCenters[1]"
                            subfix="€"
                            :stepSize="50"
                        />
                    </ChartContainer>
                    <ChartContainer
                        title="Igresos Totales por Zona de Tratamiento"
                        :labels="totalTreatmentByZone[0]"
                        :values="totalTreatmentByZone[1]"
                        subfix="€"
                    >
                        <VerticalBarsChart
                            :labels="totalTreatmentByZone[0]"
                            :values="totalTreatmentByZone[1]"
                            subfix="€"
                            :stepSize="50"
                        />
                    </ChartContainer>
                    <ChartContainer
                        title="Tratamientos Totales por Centro"
                        :labels="countTreatmentByCenters[0]"
                        :values="countTreatmentByCenters[1]"
                    >
                        <DoughnutChart
                            :labels="countTreatmentByCenters[0]"
                            :values="countTreatmentByCenters[1]"
                        />
                    </ChartContainer>
                    <ChartContainer
                        title="Tratamientos Totales por Zona"
                        :labels="countTreatmentByZone[0]"
                        :values="countTreatmentByZone[1]"
                    >
                        <DoughnutChart
                            :labels="countTreatmentByZone[0]"
                            :values="countTreatmentByZone[1]"
                        />
                    </ChartContainer>
                </section>
            </template>
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
//Importaciones de vue
import { Head } from "@inertiajs/vue3";
//Componentes
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import IconMdi from "@/Components/IconMdi.vue";
import {
    mdiBadgeAccount,
    mdiCashMultiple,
    mdiCashRegister,
    mdiClipboardTextClock,
    mdiCounter,
    mdiStorePlus,
} from "@mdi/js";
import ChartContainer from "@/Components/dashboard_components/Charts/ChartContainer.vue";
import VerticalBarsChart from "@/Components/dashboard_components/Charts/VerticalBarsChart.vue";
import DoughnutChart from "@/Components/dashboard_components/Charts/DoughnutChart.vue";
//Utilidades
import {
    capitalizeFirstChart,
    amountByColumnName,
    getCountByColumnName,
    getIndexOfMaxValue,
    getTotalByColumnName,
    getSumByHours,
} from "@/Utils/utilsFunctions";

const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    }
});

const countTreatmentByCenters = getCountByColumnName(
    props.tratamientos,
    "nombre_centro"
);
const totalTreatmentByCenters = getTotalByColumnName(
    props.tratamientos,
    "nombre_centro",
    "precio_zona"
);

const totalTreatmentByZone = getTotalByColumnName(
    props.tratamientos,
    "nombre_zona",
    "precio_zona"
);
const countTreatmentByZone = getCountByColumnName(
    props.tratamientos,
    "nombre_zona"
);

const countTreatmentByDay= getCountByColumnName(
    props.tratamientos,
    "dias"
);

const totalHours=getSumByHours(props.tratamientos, "tiempo_zona")
const indexMaxTreatment = getIndexOfMaxValue(countTreatmentByCenters, 1);
const indexMaxBenefits = getIndexOfMaxValue(totalTreatmentByCenters, 1);
</script>
