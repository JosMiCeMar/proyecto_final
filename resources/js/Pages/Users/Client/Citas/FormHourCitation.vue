<template>

    <Head title="Reservar Cita" />
    <AuthenticatedLayout>
        <ContentBox title="Reservar Cita" description="Formulario para elegir la hora de la cita">
            <div class="flex items-center justify-center w-full">
                <form @submit.prevent="submit"
                    class="m-4 text-center bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md">
                    <!--Informacion de la reserva-->
                    <div class="text-white">
                        <p>
                            <span class="text-lavender-vlight">Centro Asociado: </span>
                            {{ props.centro.nombre }} ({{
                                props.centro.localidad
                            }})
                        </p>
                        <p>
                            <span class="text-lavender-vlight">Fecha seleccionada: </span>
                            {{ fechaFormateada }}
                        </p>
                        <p>
                            <span class="text-lavender-vlight">Zona de tratamiento: </span>
                            <span class="uppercase">{{
                                props.zona.nombre
                                }}</span>
                        </p>
                    </div>

                    <div class="mt-4 flex flex-col gap-1 items-center">
                        <InputLabel for="time" value="Horas disponibles:" class="text-xl" />
                        <select id="time" v-model="form.startHour" @change="
                            setEndHour(
                                form.startHour,
                                props.zona.tiempo_estimado
                            )
                            "
                            class="w-full text-lg font-bold lg:w-[50%] border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm">
                            <option v-for="(hour, index) in horasTrabajo" :key="index">
                                {{ hour }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.startHour" />
                    </div>
                    <!-- Botón de Enviar -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing" @click="submit">
                            Reservar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <!--Boton de retorno-->
            <div class="flex sm:justify-end justify-center w-full">
                <ReturnLink class="text-skyblue-dark font-bold sm:mx-8" iconColor="#315D66"
                    :link="route('client.indexCitas')" value="Volver al menú" />
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
import ReturnLink from "@/Components/dashboard_components/ReturnLink.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import { incorrectForm, sendForm } from "@/Utils/alerts";
import { addHours } from "@/Utils/utilsFunctions";
import { validateTimeInList } from "@/Utils/Validators/citas_validator";

const props = defineProps({
    centro: {
        type: Object,
        required: true,
    },
    dia: {
        type: Object,
        required: true,
    },
    zona: {
        type: Object,
        required: true,
    },
    horasTrabajo: {
        type: Array,
        required: true,
    },
});

const fechaFormateada = new Date(props.dia.fecha).toLocaleDateString();

const form = useForm({
    zone: props.zona.id,
    date: props.dia.id,
    startHour: "",
    endHour: "",
});

function setEndHour(startHour, zoneTime) {
    form.endHour = addHours(startHour, zoneTime);
}

function validateForm() {
    const errors = {};
    errors.startHour = validateTimeInList(form.startHour, props.horasTrabajo);
    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        sendForm(() => {
            form.post(route("client.storeHoraCitas"));
        }, `¿Quieres reservar a las ${form.startHour} para el tratamiento de ${props.zona.nombre} en ${props.centro.nombre} a fecha ${fechaFormateada}?`);
    } else {
        incorrectForm();
    }
};
</script>
