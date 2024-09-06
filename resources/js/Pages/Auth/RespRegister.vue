<template>
    <GuestLayout formName="datos del nuevo responsable">
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
                <p class="text-lavender-light text-xs">
                    *La contraseña debe tener almenos 8 caracteres, incluyendo mayúsculas, minúsculas, números y símbolos.
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
import CenterSelect from "@/Components/breeze_components/CenterSelect.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { incorrectForm } from "@/Utils/alerts";
import {
    validateName,
    validateLastname,
    validateEmail,
    validatePhone,
    validatePassword,
    validatePasswordConfirmation,
    validateCenter
} from "@/Utils/Validators/user_validator";

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

    errors.name = validateName(form.name);
    errors.lastname = validateLastname(form.lastname);
    errors.tel = validatePhone(form.tel);
    errors.email = validateEmail(form.email);
    errors.center = validateCenter(form.center, props.centers)
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
        form.post(route("responsable.create"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    } else {
        incorrectForm();
    }
};
</script>