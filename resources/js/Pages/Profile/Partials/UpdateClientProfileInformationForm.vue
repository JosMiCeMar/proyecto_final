<template>
    <section>
        <header>
            <h2 class="text-lg font-bold text-lavender-dark">
                Actualizar Tus Datos
            </h2>

            <p class="mt-1 text-skyblue-dark">
                Formulario para actualizar sus datos de usuario
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="name"
                    value="Nombre"
                />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="lastname"
                    value="Apellidos"
                />

                <TextInput
                    id="lastname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lastname"
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="tel"
                    value="Teléfono"
                />

                <TextInput
                    id="tel"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.tel" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="email"
                    value="Email"
                />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold inline"
                    for="condition"
                    value="Condición especial"
                />

                <Checkbox
                    class="mx-4"
                    id="condition"
                    v-model:checked="form.condition"
                    name="condicion"
                />
                <p class="text-lavender-dark text-sm">
                    *Consulta la
                    <span
                        class="text-skyblue-dark underline hover:text-skyblue-vlight"
                        @click="medicalConditionAlert"
                        >lista</span
                    >
                    de condiciones médicas especiales.
                </p>
            </div>
            <InputError class="mt-2" :message="form.errors.condition" />
            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="date"
                    value="Fecha Nacimiento"
                />
                <Datepicker
                    id="date"
                    v-model="form.date"
                    inputFormat="dd-MM-yyyy"
                    :upperLimit="getMinDate()"
                    :lowerLimit="getMaxDate()"
                    :locale="localLanguage"
                    class="w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                />
                <InputError class="mt-2" :message="form.errors.date" />
            </div>
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-lavender-dark font-bold">
                    Tu correo electrónico aún no se encuentra verificado.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm font-thin text-skyblue-dark hover:font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800"
                    >
                        Haga click aquí para volver a enviar el mail de
                        verificación.
                    </Link>
                </p>

                <InputCorrect
                    v-show="status === 'verification-link-sent'"
                    message="Mail de verificación enviado"
                    class="w-fit"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton
                    :disabled="form.processing"
                    class="bg-lavender-dark text-skyblue-vlight hover:text-lavender-dark hover:border-lavender-dark"
                    >Guardar cambios</PrimaryButton
                >

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <InputCorrect
                        v-if="form.recentlySuccessful"
                        message="Perfil Actualizado Correctamente"
                    />
                </Transition>
            </div>
        </form>
    </section>
</template>
<script setup>
import InputError from "@/Components/breeze_components/InputError.vue";
import InputCorrect from "@/Components/breeze_components/InputCorrect.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import TextInput from "@/Components/breeze_components/TextInput.vue";
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
} from "@/Utils/Validators/user_validator";

const localLanguage = es;

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const userExtraDates = usePage().props.auth.datos;

const form = useForm({
    name: user.nombre,
    lastname: user.apellidos,
    tel: user.telefono,
    email: user.email,
    date: new Date(userExtraDates.fecha_nac),
    condition: Boolean(userExtraDates.condicion),
});

function validateForm() {
    const errors = {};

    errors.name = validateName(form.name);
    errors.lastname = validateLastname(form.lastname);
    errors.tel = validatePhone(form.tel);
    errors.email = validateEmail(form.email);
    errors.date = validateDateOfBirth(form.date);

    form.errors = errors;

    return Object.keys(errors).every((key) => errors[key] === null); // Verifica si todos los campos están válidos
}

const submit = () => {
    if (validateForm()) {
        form.patch(route("client.profileUpdate"));
    } else {
        incorrectForm();
    }
};
</script>
