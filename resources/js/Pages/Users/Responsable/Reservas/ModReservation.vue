<template>
    <Head title="Reservar Cita" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar Reserva"
            description="Selecciona la hora para modificar la reserva seleccionada"
            :returnLink="route('respon.indexReservas')"
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
                                >Dia de trabajo:
                            </span>
                            {{ props.centro.nombre }} ({{
                                props.centro.localidad
                            }}) - {{ fechaFormateada }}
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Cliente:
                            </span>
                            {{ props.cliente.nombre }} {{ props.cliente.apellidos }}
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Zona de tratamiento:
                            </span>
                            <span class="uppercase">{{
                                props.zona.nombre
                            }}</span>
                        </p>
                        <p>
                            <span class="text-lavender-vlight"
                                >Hora de la reserva:
                            </span>
                            <span>
                                {{formatHour(props.reserva.hora_inicio)}} - {{ formatHour(props.reserva.hora_fin) }}
                            </span>
                        </p>
                    </div>

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
                        <!--Checkbox de notificacion-->
                        <div class="flex items-end justify-end mt-2">
                            <Checkbox
                                class="mx-1"
                                id="cbNot"
                                v-model:checked="form.notification"
                                name="condicion"
                            /><label for="cbNot" class="text-white text-xs"
                                >Mandar notificación</label
                            >
                        </div>
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
import Checkbox from "@/Components/breeze_components/Checkbox.vue";
import { incorrectForm, sendForm } from "@/Utils/alerts";
import { formatHour } from "@/Utils/utilsFunctions";
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
    reserva:{
        type: Object,
        required: true,
    },
    cliente:{
        type: Object,
        required: true,
    },
    horasDisponibles: {
        type: Array,
        required: true,
    },
});

const fechaFormateada = new Date(props.dia.fecha).toLocaleDateString();

const form = useForm({
    id: props.reserva.id,
    dia: props.dia.id,
    startHour: "",
    notification:true
});

function validateForm() {
    const errors = {};
    errors.startHour = validateTimeInList(
        form.startHour,
        props.horasDisponibles
    );
    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        sendForm(() => {
            form.post(route("respon.modHourReservas"));
        }, `¿Quieres modificar la reserva de ${props.cliente.nombre} a las ${form.startHour} para el tratamiento de ${props.zona.nombre}?`);
    } else {
        incorrectForm();
    }
};
</script>
