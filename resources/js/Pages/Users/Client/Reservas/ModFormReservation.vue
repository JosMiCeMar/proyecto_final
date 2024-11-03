<template>
    <Head title="Modificar Cita" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar Hora de Cita"
            description="Formulario para modificar horario de cita"
            :returnLink="route('client.indexCitas')"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent=""
                    class="m-4 text-center bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!--Informacion de la reserva-->
                    <div class="text-white text-sm">
                        <p class="text-lg">Tu cita:</p>
                        <p>
                            <span class="text-lavender-vlight">Centro: </span
                            >{{ props.cita.centro_nombre }}({{
                                props.cita.centro_localidad
                            }})
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Zona tratamiento: </span
                            ><span class="uppercase">{{
                                props.cita.zona_nombre
                            }}</span>
                        </p>
                        <p>
                            <span class="text-lavender-vlight">Fecha: </span
                            >{{
                                new Date(props.cita.fecha).toLocaleDateString()
                            }}
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Hora inicio: </span
                            >{{ formatHour(props.cita.hora_inicio) }}
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Hora fin (estimado): </span
                            >{{ formatHour(props.cita.hora_fin) }}
                        </p>
                    </div>
                    <!--Si hay horas disponibles se mostraran junto con el boton de enviar-->
                    <div
                        v-if="props.horasDisponibles.length > 0"
                        class="mt-4 flex flex-col gap-2 items-center"
                    >
                        <p class="text-xl text-white">Horas disponibles:</p>

                        <div
                            class="flex flex-wrap justify-center gap-3 p-4 border-2 border-lavender-vlight rounded-lg shadow-md"
                        >
                            <label
                                v-for="(hour, index) in props.horasDisponibles"
                                :key="index"
                                class="flex items-center cursor-pointer group transition-all duration-200"
                            >
                                <input
                                    type="radio"
                                    :value="hour"
                                    v-model="form.startHour"
                                    @change="
                                        setEndHour(
                                            form.startHour,
                                            props.cita.tiempo_estimado
                                        )
                                    "
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
                                Modificar
                            </PrimaryButton>
                        </div>
                    </div>
                    <!--Si no hay horas disponibles, muestra un mensaje indicándolo-->
                    <div v-else class="mt-4 flex flex-col gap-2 items-center">
                        <p class="text-white">
                            Lo sentimos, no hay horas disponibles para modificar
                            tu cita.
                        </p>
                    </div>
                    <InputError
                        v-if="$page.props.errors"
                        :message="$page.props.errors[0]"
                    />
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
import { validateTimeInList } from "@/Utils/Validators/citas_validator";
import { addHours } from "@/Utils/utilsFunctions";
import { incorrectForm, sendForm } from "@/Utils/alerts";

const props = defineProps({
    cita: {
        type: Object,
        required: true,
    },
    horasDisponibles: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    id: props.cita.id,
    startHour: "",
    endHour: "",
});

function setEndHour(startHour, zoneTime) {
    form.endHour = addHours(startHour, zoneTime);
}

function validateForm() {
    const errors = {};
    errors.startHour = validateTimeInList(
        form.startHour,
        props.horasDisponibles
    );
    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const formatHour = (hour) => {
    const arrayHour = hour.split(":");
    return `${arrayHour[0]}:${arrayHour[1]}`;
};

const submit = () => {
    if (validateForm()) {
        sendForm(() => {
            form.post(route("client.modHoraReser"));
        }, `¿Quieres modificar tu cita a las ${form.startHour} para el tratamiento de ${props.cita.zona_nombre}?`);
    } else {
        incorrectForm();
    }
};
</script>
