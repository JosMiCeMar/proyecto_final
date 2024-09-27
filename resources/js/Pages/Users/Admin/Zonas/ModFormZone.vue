<template>
    <Head title="Modificar Zona Tratamiento" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar Zona Tratamiento"
            description="Formulario de modificación de zona de tratamiento"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent="submit"
                    class="m-4 bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!-- Nombre de la zona -->
                    <div>
                        <InputLabel for="name" value="Nombre de la Zona" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            autofocus
                            autocomplete="name"
                            placeholder="Introduce el nombre de la zona"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Precio -->
                    <div class="mt-4">
                        <InputLabel for="price" value="Precio (€)" />
                        <input
                            id="price"
                            type="number"
                            class="mt-1 block w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                            v-model="form.price"
                            min="0"
                            step="0.01"
                            @blur="roundPrice"
                        />
                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>

                    <!-- Tiempo estimado -->
                    <div class="mt-4">
                        <InputLabel for="time" value="Tiempo Estimado" />
                        <VueTimepicker
                            v-model="form.time"
                            class="time_picker"
                            input-class="mt-1 block w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                            :hour-range="hoursRange"
                            :minute-range="minutesRange"
                            hide-disabled-items
                            close-on-complete
                            auto-scroll
                            advanced-keyboard
                        />
                        <InputError class="mt-2" :message="form.errors.time" />
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Modificar Zona
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <div class="flex sm:justify-end justify-center w-full">
                <ReturnLink
                    class="text-skyblue-dark font-bold sm:mx-8"
                    iconColor="#315D66"
                    :link="route('admin.indexZona')"
                    value="Volver al menú"
                />
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
import VueTimepicker from "vue3-timepicker/src/VueTimepicker.vue";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import ReturnLink from "@/Components/dashboard_components/ReturnLink.vue";
import { incorrectForm, sendForm } from "@/Utils/alerts";
import {
    getHoursRange,
    getMinutesRange,
    validateName,
    validatePrice,
    validateTime,
} from "@/Utils/Validators/zonas_validator";

const props = defineProps({
    datos:{
        type:Object,
        required:true
    }
})

const splitTime = props.datos.tiempo_estimado.split(':');
const formatTime=`${splitTime[0]}:${splitTime[1]}`;

const form = useForm({
    id:props.datos.id,
    name: props.datos.nombre,
    price: props.datos.precio,
    time: formatTime,
});

function roundPrice() {
    // Verifica si el valor existe y es un número
    if (form.price !== null && !isNaN(form.price)) {
        // Redondea a 2 decimales
        form.price = parseFloat(form.price).toFixed(2);
    }
}

const hoursRange=getHoursRange();
const minutesRange=getMinutesRange();

function validateForm() {
    const errors = {};

    errors.name = validateName(form.name);
    errors.price = validatePrice(form.price);
    errors.time = validateTime(form.time);

    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        sendForm(()=>{form.post(route("admin.updateZona"));}, `¿Quieres modificar ${form.name}?`);
    } else {
       incorrectForm();
    }
};
</script>
