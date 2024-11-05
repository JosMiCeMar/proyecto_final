<template>
    <Head title="Reservar Cita" />
    <AuthenticatedLayout>
        <ContentBox
            title="Reservar Cita"
            description="Formulario para elegir la hora de la cita"
            :returnLink="route('client.indexCitas')"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent="submit"
                    class="m-4 text-center bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!--Informacion de la reserva-->
                    <div class="text-white">
                        <p>
                            <span class="text-lavender-vlight"
                                >Centro Asociado:
                            </span>
                            {{ props.centro.nombre }} ({{
                                props.centro.localidad
                            }})
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Fecha seleccionada:
                            </span>
                            {{ fechaFormateada }}
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Zona de tratamiento:
                            </span>
                            <span class="uppercase">{{
                                props.zona.nombre
                            }}</span>
                        </p>
                    </div>

                    <div
                        v-if="props.horasTrabajo.length > 0"
                        class="mt-4 flex flex-col gap-2 items-center"
                    >
                        <p class="text-xl text-white">Horas disponibles:</p>

                        <div
                            class="flex flex-wrap justify-center gap-3 p-4 border-2 border-lavender-vlight rounded-lg shadow-md"
                        >
                            <label
                                v-for="(hour, index) in props.horasTrabajo"
                                :key="index"
                                class="flex items-center cursor-pointer group transition-all duration-200"
                            >
                                <input
                                    :id="index"
                                    type="radio"
                                    :value="hour"
                                    v-model="form.startHour"
                                    class="hidden peer"
                                />
                                <span
                                    class="w-24 px-4 py-2 text-lg font-bold border-2 border-lavender-dark rounded-md text-lavender-dark bg-blue-100 peer-checked:bg-lavender-light peer-checked:border-lavender-light shadow-sm transition-all duration-300 hover:bg-skyblue-light hover:border-lavender-light"
                                >
                                    {{ hour }}
                                </span>
                            </label>
                        </div>
                        <InputError
                            class="mt-2"
                            :message="form.errors.startHour"
                        />
                        <!-- Botón de Enviar -->
                        <div class="flex items-center justify-center mt-4">
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="submit"
                            >
                                Reservar
                            </PrimaryButton>
                        </div>
                    </div>
                    <div v-else class="mt-4 flex flex-col gap-2 items-center">
                        <p class="text-xl text-white">
                            Lo sentimos, no hay horas disponibles para ese
                            tratamiento.
                        </p>
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
