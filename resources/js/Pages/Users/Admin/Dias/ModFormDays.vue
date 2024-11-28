<template>
    <Head title="Asignar Día" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar día asignado"
            description="Formulario para modificar día de trabajo a centro asociado"
            :returnLink="route('admin.indexDias')"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent="submit"
                    class="m-4 bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!-- Nombre del Centro -->
                    <div>
                        <InputLabel for="day" value="Fecha Día de Trabajo" />
                        <Datepicker
                            id="day"
                            v-model="form.day"
                            inputFormat="dd-MM-yyyy"
                            :lowerLimit="tomorrow"
                            :upperLimit="lastDay"
                            :locale="localLanguage"
                            :disabledDates="{ dates: invalidDates }"
                            class="w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                        />
                        <InputError class="mt-2" :message="form.errors.day" />
                    </div>

                    <!-- Select de centros asociados-->
                    <div class="mt-4">
                        <InputLabel for="center" value="Centro Asociado" />
                        <select
                            id="center"
                            v-model="form.center"
                            class="w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light checked:bg-lavender-dark rounded-md shadow-sm"
                        >
                            <option
                                class="checked:bg-lavender-dark checked:text-white"
                                v-for="center in centros"
                                :key="center.id"
                                :value="center.id"
                            >
                                {{ center.nombre }} - {{ center.localidad }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.center"
                        />
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Modificar Día
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";
import { incorrectForm, sendForm } from "@/Utils/alerts";
import {
    getLastDate,
    disabledDates,
    validateDates,
    validateCenter,
    getTomorrow
} from "@/Utils/Validators/dias_validator";


const props = defineProps({
    datos:{
        type:Object,
        required:true
    },
    centros: {
        type: Array,
        required: true,
    },
    fechas: {
        type: Array,
        required: true,
    },
});

//Lenguaje del calendario
const localLanguage = es;

//Obtencion de las fechas limite y deshabilitadas
const tomorrow = getTomorrow();
const lastDay = getLastDate();
const invalidDates = disabledDates(props.fechas);

const form = useForm({
    id: props.datos.id,
    day: new Date(props.datos.fecha),
    center: props.datos.centro_id,
});

function validateForm() {
    const errors = {};

    errors.day= validateDates(form.day, tomorrow, lastDay, invalidDates);

    errors.center = validateCenter(form.center, props.centros);

    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        sendForm(()=>{form.post(route("admin.updateDias"))}, `¿Quieres modificar el dia ${form.day.toLocaleDateString()}?`);
    } else {
        incorrectForm();
    }
};
</script>
