<template>
    <Head title="Reservar Cita" />
    <AuthenticatedLayout>
        <ContentBox
            title="Reservar Cita"
            description="Formulario para reservar tu cita"
            :returnLink="route('client.indexCitas')"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent="submit"
                    class="m-4 bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!-- Nombre del Centro -->
                    <div>
                        <InputLabel
                            for="center"
                            value="Selecciona el Centro Estético"
                        />
                        <CenterSelect
                            id="center"
                            class="w-full"
                            @change="form.date = ''"
                            v-model="form.center"
                            :centers="props.centros"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.center"
                        />
                    </div>

                    <!--Fechas disponibles para centro seleccionado-->
                    <!--Se mostrara si el centro seleccionado dispone de fechas-->
                    <div v-if="daysSelectedCenter.length !== 0" class="mt-2">
                        <InputLabel for="date" value="Selecciona la fecha:" />
                        <select
                            id="date"
                            class="w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                            v-model="form.date"
                        >
                            <option
                                v-for="date in daysSelectedCenter"
                                :key="date.id"
                                :value="date.id"
                            >
                                {{ new Date(date.fecha).toLocaleDateString() }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.date" />
                    </div>

                    <!--Si el centro seleccionado no dispone de fechas, mostrara un mensaje para indicarlo-->
                    <div
                        v-if="
                            form.center !== '' &&
                            daysSelectedCenter.length === 0
                        "
                    >
                        <InputError
                            class="mt-2"
                            message="El centro seleccionado no dispone de días asignados"
                        />
                    </div>

                    <!--Zonas de tratamiento-->
                    <!--Se mostraran si se ha seleccionado una fecha-->
                    <div v-if="form.date !== ''" class="mt-2">
                        <InputLabel
                            for="zone"
                            value="Selecciona la zona de tratamiento:"
                        />
                        <select
                            id="zone"
                            class="w-full uppercase border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                            v-model="form.zone"
                        >
                            <option
                                v-for="zone in props.zonas"
                                :key="zone.id"
                                :value="zone.id"
                            >
                                {{ zone.nombre }} - Precio: {{ zone.precio }}€
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.zone" />
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Seleccionar horario
                        </PrimaryButton>
                    </div>
                    <InputError
                        class="mt-4"
                        v-if="$page.props.errors"
                        :message="$page.props.errors[0]"
                    />
                    <p class="text-center text-lavender-light text-xs mt-4">
                        <span class="font-bold">* Recuerda:</span> Sólo puedes
                        reservar 3 tratamientos por día. Si necesitas un pack de
                        zonas personalizado, informa al responsable del centro.
                    </p>
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
import { incorrectForm, sendForm } from "@/Utils/alerts";
import CenterSelect from "@/Components/breeze_components/CenterSelect.vue";
import { computed } from "vue";
import { validateIdinList } from "@/Utils/Validators/citas_validator";

const props = defineProps({
    centros: {
        type: Array,
        required: true,
    },
    fechas: {
        type: Array,
        required: true,
    },
    zonas: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    center: "",
    date: "",
    zone: "",
});

const daysSelectedCenter = computed(() => {
    return props.fechas.filter((date) => date.centro_id === form.center);
});

function validateForm() {
    const errors = {};

    errors.center = validateIdinList(form.center, props.centros, "centro");
    errors.date = validateIdinList(form.date, daysSelectedCenter.value, "día");
    errors.zone = validateIdinList(form.zone, props.zonas, "zona");

    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        sendForm(() => {
            form.post(route("client.createHoraCitas"));
        }, `¿Quieres pasar a seleccionar la hora de la cita?`);
    } else {
        incorrectForm();
    }
};
</script>
