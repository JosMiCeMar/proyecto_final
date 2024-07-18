<script setup>
import { defineProps } from "vue";
import GuestLayout from "@/Layouts/breeze_layouts/GuestLayout.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import CenterSelect from "@/Components/breeze_components/CenterSelect.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { inject } from "vue";
const swal = inject("$swal");


const props = defineProps({
    centers: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    lastname: "",
    tel: "",
    email: "",
    center: "",
    password: "",
    password_confirmation: "",
});

function validateForm() {
    const errors = {};
    const nameRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9]{9}$/;

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

    // Validación centro asociado
    if (form.center==='') {
        errors.center = "El centro es obligatorio";
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
        else if (!/[!@#$%^&*()_+={}\[\]:;<>,.?~-]/.test(form.password)) {
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
        form.post(route("responsable.create"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
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

<template>
    <GuestLayout>
        <Head title="Registro de Responsables" />

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
                <InputLabel for="center" value="Selecciona tu centro" />
                <CenterSelect
                    id="center"
                    class="mt-1 block w-full"
                    v-model="form.center"
                    :centers="props.centers"
                />

                <InputError class="mt-2" :message="form.errors.center" />
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
