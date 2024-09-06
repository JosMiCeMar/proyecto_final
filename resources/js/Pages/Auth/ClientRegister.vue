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
                    :upperLimit="getMinDate()"
                    :lowerLimit="getMaxDate()"
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
import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";
import { incorrectForm, medicalConditionAlert } from "@/Utils/alerts";
import {
    getMinDate,
    getMaxDate,
    validateName,
    validateLastname,
    validateEmail,
    validatePhone,
    validateDateOfBirth,
    validatePassword,
    validatePasswordConfirmation,
} from "@/Utils/Validators/user_validator";

const localLanguage = es;

const form = useForm({
    name: "",
    lastname: "",
    tel: "",
    email: "",
    fecha: getMinDate(),
    condicion: false,
    password: "",
    password_confirmation: "",
});

function validateForm() {
    const errors = {};

    errors.name = validateName(form.name);
    errors.lastname = validateLastname(form.lastname);
    errors.tel = validatePhone(form.tel);
    errors.email = validateEmail(form.email);
    errors.fecha = validateDateOfBirth(form.fecha);
    errors.password = validatePassword(form.password);
    errors.password_confirmation = validatePasswordConfirmation(
        form.password,
        form.password_confirmation
    );

    form.errors = errors;

    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        form.post(route("cliente.create"));
    } else {
        incorrectForm();
    }
};
</script>
