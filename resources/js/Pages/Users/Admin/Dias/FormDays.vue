<template>
    <Head title="Asignar Día" />
    <AuthenticatedLayout>
        <ContentBox
            title="Asignar día a centro"
            description="Formulario para asignar día de trabajo a centro asociado"
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
                            :lowerLimit="today"
                            :upperLimit="lastDay"
                            :locale="localLanguage"
                            :disabledDates="{ dates: disabledDates() }"
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
                            <option value="">
                                Selecciona un centro asociado
                            </option>
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
                            Asignar Día
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
import { inject } from "vue";
import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";

const swal = inject("$swal");

const props = defineProps({
    centros: {
        type: Array,
        required: true,
    },
    fechas: {
        type: Array,
        required: true,
    },
});

//Fechas limite para el calendario y lenguaje de este
const today = new Date();
today.setHours(0, 0, 0, 0);
const lastDay = new Date(today);
lastDay.setFullYear(today.getFullYear() + 1);
lastDay.setHours(0, 0, 0, 0);
const localLanguage = es;

//Funcion que recibe las fechas ocupadas del back y las pasa a objetos Date de js, devolviendo una lista de estas
const disabledDates = () => {
    let dates = [];

    props.fechas.forEach((day) => {
        dates.push(new Date(day.fecha));
    });

    //Algoritmo para añadir los domingos a la lista de dias deshabilitados 
    let currentDate = new Date(today);
    while (currentDate <= lastDay) {
        if (currentDate.getDay() === 0) { // 0 representa el domingo
            dates.push(new Date(currentDate));
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return dates;
};

const form = useForm({
    day: today,
    center: "",
});

function validateForm() {
    const errors = {};

    //Validacion de la fecha, comprueba que la fecha introducida sea valida (limites introducidos y disponibilidad)
    if (isNaN(form.day.getTime())) {
        errors.day = "La fecha es obligatoria";
    } else {
        if (form.day < today || form.day > lastDay) {
            errors.day =
                "La fecha no puede ser inferior al día de hoy o superior a más de un año";
        } else {
            const invalidDates = disabledDates();
            if (
                invalidDates.some((fecha) => {
                    // Compara solo la fecha, ignorando la hora
                    return (
                        fecha.getFullYear() === form.day.getFullYear() &&
                        fecha.getMonth() === form.day.getMonth() &&
                        fecha.getDate() === form.day.getDate()
                    );
                })
            ) {
                errors.day = "La fecha seleccionada no se encuentra disponible";
            }
        }
    }

    //Validacion del centro (id), comprueba que sea un numero entero y que se encuentre en la lista de centros recibida
    if (isNaN(parseInt(form.center))) {
        errors.center = "El centro es obligatorio";
    } else {
        const arrayIds = [];
        props.centros.forEach((center) => {
            arrayIds.push(center.id);
        });
        if (!arrayIds.includes(form.center)) {
            errors.center =
                "El identificador del centro no se encuentra en la lista";
        }
    }

    form.errors = errors;
    return Object.keys(errors).length === 0;
}

const submit = () => {
    if (validateForm()) {
        swal.fire({
            title: "Confirmar Envío",
            text: `¿Quieres asignar el dia ${form.day.toLocaleDateString()}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Enviar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#3A2642",
            cancelButtonColor: "#d33",
            background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
            color: "#3A2642",
            iconColor: "#3A2642",
        }).then((result) => {
            if (result.isConfirmed) {
                form.post(route("admin.createDias"));
            }
        });
    } else {
        swal.fire({
            icon: "error",
            text: "Completa correctamente el formulario",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3A2642",
            background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
            color: "#3A2642",
            iconColor: "#3A2642",
        });
    }
};
</script>
