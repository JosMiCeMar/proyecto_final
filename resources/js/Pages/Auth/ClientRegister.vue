<template>
    <GuestLayout formName="datos del nuevo cliente">
        <Head title="Registro de Clientes" />
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autofocus
                    autocomplete="name"
                    placeholder="Introduce tu nombre"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="lastname" value="Apellidos" />

                <TextInput
                    id="lastname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lastname"
                    autocomplete="name"
                    placeholder="Introduce tus apellidos"
                />
                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

            <div class="mt-4">
                <InputLabel for="tel" value="Teléfono" />

                <TextInput
                    id="tel"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                    maxlength="9"
                    autocomplete="tel"
                    placeholder="Introduce tu número de teléfono"
                />

                <InputError class="mt-2" :message="form.errors.tel" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autocomplete="email"
                    placeholder="Introduce tu correo electrónico"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="fecha" value="Fecha Nacimiento" />
                <Datepicker
                    id="fecha"
                    v-model="form.fecha"
                    inputFormat="dd-MM-yyyy"
                    :upperLimit="minDate"
                    :lowerLimit="maxDate"
                    :locale="localLanguage"
                    class="w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                />
                <InputError class="mt-2" :message="form.errors.fecha" />
            </div>

            <div class="mt-4">
                <InputLabel
                    class="inline"
                    for="condicion"
                    value="Posees una condición médica especial:"
                />
                <Checkbox
                    class="mx-4"
                    id="condicion"
                    v-model:checked="form.condicion"
                    name="condicion"
                />
                <p class="text-lavender-light text-sm">
                    *Consulta la
                    <span
                        class="text-skyblue-light underline hover:text-skyblue-vlight"
                        @click="medicalConditionAlert"
                        >lista</span
                    >
                    de condiciones médicas especiales.
                </p>
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    autocomplete="new-password"
                    placeholder="Introduce la contraseña"
                />
                <p class="text-lavender-light text-xs">
                    *La contraseña debe tener almenos 8 caracteres, incluyendo
                    mayúsculas, minúsculas, números y símbolos.
                </p>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    placeholder="Vuelve a introducir la contraseña"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-center mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrarse
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<script setup>
import GuestLayout from "@/Layouts/breeze_layouts/GuestLayout.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Checkbox from "@/Components/breeze_components/Checkbox.vue";
import { inject } from "vue";
import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";
import { medicalConditionAlert } from "@/Utils/alerts"; 



const localLanguage = es;

const swal = inject("$swal");

const form = useForm({
    name: "",
    lastname: "",
    tel: "",
    email: "",
    fecha: minDate,
    condicion: false,
    password: "",
    password_confirmation: "",
});

//Fecha minima de nacimiento (13 años)
const minDate = new Date();
minDate.setHours(0,0,0,0);
minDate.setFullYear(minDate.getFullYear()-13);


//Fecha maxima de nacimiento (120 años)
const maxDate= new Date();
maxDate.setHours(0,0,0,0);
maxDate.setFullYear(maxDate.getFullYear()-120);

function validateForm() {
    const errors = {};
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9]{9}$/;
    const nameRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;

    //Validacion nombre
    if (!form.name.trim()) {
        errors.name = "El nombre es obligatorio";
    } else {
        if (!nameRegex.test(form.name)) {
            errors.name = "El nombre sólo puede contener letras y espacios";
        }
    }

    //Validación apellidos
    if (!form.lastname.trim()) {
        errors.lastname = "Los apellidos son obligatorios";
    } else {
        if (!nameRegex.test(form.lastname)) {
            errors.lastname =
                "El apellido sólo puede contener letras y espacios";
        }
    }

    //Validación teléfono
    if (!phoneRegex.test(form.tel)) {
        errors.tel = "El teléfono debe tener 9 dígitos";
    }

    //Validación email
    if (!emailRegex.test(form.email)) {
        errors.email = "El correo electrónico no es válido";
    }

    //Validación fecha nacimiento
    if (isNaN(form.fecha.getTime())) {
        errors.fecha = "La fecha de nacimiento es obligatoria";
    } else {
        if (form.fecha > minDate) {
            errors.fecha = "Debes tener al menos 13 años";
        }

        if(form.fecha< maxDate){
            errors.fecha = "La edad máxima son 120 años";
        }
    }

    //Validación contraseña
    if (!form.password) {
        errors.password = "La contraseña es obligatoria";
    } else {
        // Validar longitud mínima de 8 caracteres
        if (form.password.length < 8) {
            errors.password = "La contraseña debe tener mínimo 8 caracteres";
        }
        //Validar longitud máxima de 250 caracteres
        else if (form.password.length > 250) {
            errors.password = "La contraseña debe tener máximo 250 caracteres";
        }
        // Validar al menos una letra minúscula
        else if (!/[a-z]/.test(form.password)) {
            errors.password =
                "La contraseña debe contener al menos una letra minúscula";
        }
        // Validar al menos una letra mayúscula
        else if (!/[A-Z]/.test(form.password)) {
            errors.password =
                "La contraseña debe contener al menos una letra mayúscula";
        }
        // Validar al menos un número
        else if (!/\d/.test(form.password)) {
            errors.password = "La contraseña debe contener al menos un número";
        }
        // Validar al menos un caracter especial
        else if (!/[!@#$%^&*()_+={}\[\]:;,.?~-]/.test(form.password)) {
            errors.password =
                "La contraseña debe contener al menos un carácter especial";
        }
    }

    //Validación confirmar contraseña
    if (form.password !== form.password_confirmation) {
        errors.password_confirmation = "Las contraseñas no coinciden";
    }

    form.errors = errors;

    return Object.keys(errors).length === 0;
}

const submit = () => {
    if (validateForm()) {
        form.post(route("cliente.create"));
    } else {
        swal({
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

