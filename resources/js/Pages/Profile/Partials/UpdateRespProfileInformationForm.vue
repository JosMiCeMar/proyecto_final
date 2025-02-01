<template>
    <section>
        <header>
            <h2 class="text-lg font-bold text-lavender-dark">
                Actualizar Tus Datos
            </h2>

            <p class="mt-1 text-skyblue-dark">
                Formulario para actualizar sus datos de responsable
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
                    required
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
                    required
                    autocomplete="lastname"
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
                    required
                    autocomplete="tel"
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
                    required
                    autocomplete="email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
                <p class="text-lavender-dark text-sm">
                    *Recuerda volver a verificar tu email si lo modificas
                </p>
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="center"
                    value="Centro Asociado"
                />

                <CenterSelect
                    id="center"
                    class="mt-1 block w-full"
                    v-model="form.center"
                    :centers="props.centers"
                    :selected="userExtraInfo.centro"
                />
                <InputError class="mt-2" :message="form.errors.center" />
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
                <PrimaryButton :disabled="form.processing" :dark="true"
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
import TextInput from "@/Components/breeze_components/TextInput.vue";
import CenterSelect from "@/Components/breeze_components/CenterSelect.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { incorrectForm } from "@/Utils/alerts";
import {
    validateName,
    validateLastname,
    validateEmail,
    validatePhone,
    validateCenter,
} from "@/Utils/Validators/user_validator";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    centers: {
        type: Array,
    },
});

const user = usePage().props.auth.user;
const userExtraInfo = usePage().props.auth.datos;

const form = useForm({
    name: user.nombre,
    lastname: user.apellidos,
    tel: user.telefono,
    email: user.email,
    center: userExtraInfo.centro,
});

function validateForm() {
    const errors = {};

    errors.name = validateName(form.name);
    errors.lastname = validateLastname(form.lastname);
    errors.tel = validatePhone(form.tel);
    errors.email = validateEmail(form.email);
    errors.center = validateCenter(form.center, props.centers);

    form.errors = errors;

    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        form.patch(route("respon.profileUpdate"));
    } else {
        incorrectForm();
    }
};
</script>
