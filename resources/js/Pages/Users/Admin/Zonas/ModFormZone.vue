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
                            min="0.5"
                            step="0.5"
                            @blur="formatDecimals"
                        />
                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>

                    <!-- Tiempo estimado -->
                    <div class="mt-4">
                        <InputLabel for="time" value="Tiempo Estimado" />
                        <TextInput
                            list="timeOptions"
                            id="time"
                            type="time"
                            class="mt-1 block w-full"
                            v-model="form.time"
                            autocomplete="time"
                        />
                        <datalist id="timeOptions">
                            <option value="00:30"></option>
                            <option value="01:00"></option>
                            <option value="01:30"></option>
                            <option value="02:00"></option>
                            <option value="02:30"></option>
                            <option value="03:00"></option>
                            <option value="03:30"></option>
                            <option value="04:00"></option>
                            <option value="04:30"></option>
                            <option value="05:00"></option>
                            <option value="05:30"></option>
                        </datalist>
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
import TextInput from "@/Components/breeze_components/TextInput.vue";
import { inject } from "vue";

const swal = inject("$swal");

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

//Funcion para redondear (0-5) los decimales del precio
function formatDecimals() {
    if (form.price % 1 !== 0) {
        const parteDecimal = form.price % 1;
        const redondearADecimalCercano = Math.round(parteDecimal * 2) / 2;
        const parteEntera = Math.floor(form.price);
        form.price= parteEntera + redondearADecimalCercano;
    }
}

function validateForm() {
    const errors = {};
    const nameRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;

    //Validacion nombre
    if (!form.name.trim()) {
        errors.name = "El nombre es obligatorio";
    } else {
        if (!nameRegex.test(form.name)) {
            errors.name = "El nombre sólo puede contener letras y espacios";
        }

        if (form.name.length > 255) {
            errors.name = "El nombre no puede superar los 255 carácteres";
        }
    }

    //Validar precio
    if (isNaN(form.price)) {
        errors.price = "El precio debe ser un número";
    } else {
        if (form.price < 0.5) {
            errors.price = "El precio no puede ser inferior a 0.5€";
        }

        if (form.price > 10000) {
            errors.price = "El precio no puede ser superior a 10000€";
        }
    }

    //Validación tiempo
    if (!form.time.trim()) {
        errors.time = "El tiempo estimado es obligatorio";
    } else {
        const minutes = parseInt(form.time.split(":")[1]);
        const hours = parseInt(form.time.split(":")[0]);

        if (minutes !== 0 && minutes !== 30) {
            errors.time = "Los minutos únicamente pueden ser 00 o 30";
        }
        if (hours < 0 || hours > 5) {
            errors.time = "Las horas deben estar entre 0 y 5";
        }
        if (hours <= 0 && minutes <= 0) {
            errors.time = "El tiempo estimado mínimo son 30 minutos";
        }
    }

    form.errors = errors;
    return Object.keys(errors).length === 0;
}

const submit = () => {
    if (validateForm()) {
        swal.fire({
            title: "Confirmar Envío",
            text: `¿Quieres modificar ${form.name}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Modificar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#3A2642",
            cancelButtonColor: "#d33",
            background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
            color: "#3A2642",
            iconColor: "#3A2642",
        }).then((result) => {
            if (result.isConfirmed) {
                form.post(route("admin.updateZona"));
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
