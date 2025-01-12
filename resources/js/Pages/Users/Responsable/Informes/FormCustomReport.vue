<template>
    <Head title="Formulario informe personalizado" />
    <AuthenticatedLayout>
        <ContentBox
            title="Formulario informe personalizado"
            description="Personaliza el informe con los datos que necesites"
            :returnLink="route('respon.indexInforme')"
            :messageDown="false"
        >
            <div class="my-4 flex flex-col justify-center items-center">
                <form
                    @submit.prevent="submit"
                    class="m-4 bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!--Selector de rango de fechas-->
                    <div>
                        <p class="text-white">Rango de fechas</p>
                        <div class="w-full h-1 rounded-xl bg-skyblue-logo" />
                        <div class="flex flex-col sm:flex-row gap-4 p-2">
                            <div class="flex-1">
                                <InputLabel value="Desde:" for="start" />
                                <Datepicker
                                    id="start"
                                    class="w-full border border-gray-300 bg-blue-100 text-lavender-dark focus:border-lavender-vlight focus:ring-lavender-vlight rounded-md shadow-sm transition duration-200"
                                    v-model="form.dateStart"
                                    inputFormat="dd-MM-yyyy"
                                    :locale="localLanguage"
                                    :upperLimit="today"
                                    :lowerLimit="lastDay"
                                    placeholder="Introduce la fecha de inicio"
                                />
                            </div>
                            <div class="flex-1">
                                <InputLabel value="Hasta:" for="end" />
                                <Datepicker
                                    id="end"
                                    class="w-full border border-gray-300 bg-blue-100 text-lavender-dark focus:border-lavender-vlight focus:ring-lavender-vlight rounded-md shadow-sm transition duration-200"
                                    v-model="form.dateEnd"
                                    inputFormat="dd-MM-yyyy"
                                    :locale="localLanguage"
                                    :upperLimit="today"
                                    :lowerLimit="
                                        form.dateStart === null
                                            ? lastDay
                                            : form.dateStart
                                    "
                                    placeholder="Introduce la fecha final"
                                />
                            </div>
                        </div>
                        <div class="flex justify-center items-center">
                            <InputError :message="form.errors.dates" />
                            <!--Estos InputError muestra los posibles errores en la validación del back-->
                            <InputError :message="form.errors.dateStart" />
                            <InputError :message="form.errors.dateEnd" />
                        </div>
                    </div>
                    <!--Selector de zonas de tratamiento-->
                    <div class="mt-3">
                        <p class="text-white flex justify-between">
                            <span>Zonas de tratamiento:</span>
                            <button
                                @click="toggleAllZones"
                                type="button"
                                class="cursor-pointer text-xs text-lavender-vlight underline hover:text-skyblue-vlight transition"
                            >
                                {{
                                    areAllZonesSelected
                                        ? "Desmarcar todos"
                                        : "Marcar todos"
                                }}
                            </button>
                        </p>
                        <div class="w-full h-1 rounded-xl bg-skyblue-logo" />
                        <div class="flex flex-wrap justify-center gap-3 p-4">
                            <label
                                v-for="(zone, index) in props.zonas"
                                :key="index"
                                class="flex text-center items-center justify-center cursor-pointer group transition-all duration-200"
                            >
                                <input
                                    :id="index"
                                    type="checkbox"
                                    :value="zone.id"
                                    v-model="form.zones"
                                    class="hidden peer"
                                />
                                <span
                                    class="w-full h-full px-2 py-1 text-sm font-bold border-2 border-lavender-dark rounded-md text-lavender-dark bg-blue-100 peer-checked:bg-lavender-light peer-checked:border-lavender-light shadow-sm transition-all duration-300 hover:bg-skyblue-light hover:border-lavender-light"
                                >
                                    {{ capitalizeFirstChart(zone.nombre) }}
                                </span>
                            </label>
                        </div>
                        <div class="flex justify-center items-center">
                            <InputError :message="form.errors.zones" />
                            <!--Este InputError muestra los posibles errores en la validación del back-->
                            <InputError
                                v-for="(messages, field) in form.errors"
                                :key="field"
                                :message="
                                    field.startsWith('zones.') ? messages : null
                                "
                            />
                        </div>
                    </div>
                    <!--Selector de resumen por tiempo-->
                    <div class="mt-3">
                        <p class="text-white">Mostrar por periodos de tiempo</p>
                        <div class="w-full h-1 rounded-xl bg-skyblue-logo" />
                        <div class="flex flex-wrap justify-center gap-3 p-4">
                            <label
                                key="meses"
                                class="flex text-center items-center justify-center cursor-pointer group transition-all duration-200"
                            >
                                <input
                                    id="rMes"
                                    type="radio"
                                    :value="true"
                                    v-model="form.period"
                                    class="hidden peer"
                                />
                                <span
                                    class="w-full h-full px-2 py-1 text-sm font-bold border-2 border-lavender-dark rounded-md text-lavender-dark bg-blue-100 peer-checked:bg-lavender-light peer-checked:border-lavender-light shadow-sm transition-all duration-300 hover:bg-skyblue-light hover:border-lavender-light"
                                >
                                    Por Meses
                                </span>
                            </label>
                            <label
                                key="anios"
                                class="flex text-center items-center justify-center cursor-pointer group transition-all duration-200"
                            >
                                <input
                                    id="rAnio"
                                    type="radio"
                                    :value="false"
                                    v-model="form.period"
                                    class="hidden peer"
                                />
                                <span
                                    class="w-full h-full px-2 py-1 text-sm font-bold border-2 border-lavender-dark rounded-md text-lavender-dark bg-blue-100 peer-checked:bg-lavender-light peer-checked:border-lavender-light shadow-sm transition-all duration-300 hover:bg-skyblue-light hover:border-lavender-light"
                                >
                                    Por Años
                                </span>
                            </label>
                        </div>
                        <div class="flex justify-center items-center">
                            <InputError :message="form.errors.period" />
                        </div>
                    </div>
                    <!--Botón enviar-->
                    <div class="flex justify-center mt-3">
                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Mostrar Informe
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
//Importaciones de vue
import { Head, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
//Componentes
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import Datepicker from "vue3-datepicker";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
//Utilidades
import { incorrectForm, sendForm } from "@/Utils/alerts";
import { getToday } from "@/Utils/Validators/dias_validator";
import { capitalizeFirstChart } from "@/Utils/utilsFunctions";
import { es } from "date-fns/locale";
import {
    validateDateRange,
    validateIdsInList,
    validatePeriod,
} from "@/Utils/Validators/reports_validator";

//Constantes para DatePicker
const today = getToday();
const lastDay = new Date("2015-01-01");
const localLanguage = es;

//Datos del backend 
const props = defineProps({
    zonas: {
        type: Array,
        required: true,
    }
});

//Campos del formulario
const form = useForm({
    dateStart: null,
    dateEnd: null,
    zones: [],
    period: null,
});

//Validaciones del formulario
function validateForm() {
    const errors = {};
    errors.zones = validateIdsInList(form.zones, props.zonas, "zona");
    errors.period = validatePeriod(form.period, "periodo de tiempo");
    errors.dates = validateDateRange(form.dateStart, form.dateEnd);
    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

//Envío del formulario
const submit = () => {
    if (validateForm()) {
        sendForm(() => {
            form.post(route("respon.mostrarInforme"));
        }, `¿Quieres mostrar el informe personalizado?`);
    } else {
        incorrectForm();
    }
};

//Funciones para comprobar, marcar o desmarcar todas las zonas y centros
const areAllZonesSelected = computed(
    () => form.zones.length === props.zonas.length
);

const toggleAllZones = () => {
    if (areAllZonesSelected.value) {
        form.zones = [];
    } else {
        form.zones = props.zonas.map((zone) => zone.id);
    }
};

</script>
