<template>
    <section>
        <header>
            <h2 class="text-lg font-bold text-lavender-dark">
                Actualizar contraseña
            </h2>

            <p class="mt-1 text-skyblue-dark">
                Formulario para actualizar su contraseña actual
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="current_password"
                    value="Contraseña actual"
                />

                <PasswordInput
                    id="current_password"
                    v-model="form.current_password"
                    class="mt-1 block w-full"
                    :autocomplete="'current-password'"
                />

                <InputError
                    :message="form.errors.current_password"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="password"
                    value="Nueva contraseña"
                />

                <PasswordInput
                    id="password"
                    v-model="form.password"
                    class="mt-1 block w-full"
                    :autocomplete="'new-password'"
                />
                <InputError :message="form.errors.password" class="mt-2" />
                <p class="text-skyblue-dark text-xs mt-2">
                    *Recuerda: La contraseña debe tener almenos 8 caracteres,
                    incluyendo mayúsculas, minúsculas, números y símbolos.
                </p>
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="password_confirmation"
                    value="Confirmar contraseña"
                />

                <PasswordInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="mt-1 block w-full"
                    :autocomplete="'new-password'"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
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
                    <p
                        v-if="form.recentlySuccessful"
                        class="bg-lime-700 text-sm text-white rounded-md py-1 px-2"
                    >
                        Contraseña modificada correctamente
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
<script setup>
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    validatePassword,
    validatePasswordConfirmation,
} from "@/Utils/Validators/user_validator";
import { incorrectForm } from "@/Utils/alerts";
import PasswordInput from "@/Components/breeze_components/PasswordInput.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

function validateForm() {
    const errors = {};

    errors.password = validatePassword(form.password);
    errors.password_confirmation = validatePasswordConfirmation(
        form.password,
        form.password_confirmation
    );

    form.errors = errors;

    return Object.keys(errors).every((key) => errors[key] === null);
}

const updatePassword = () => {
    if (validateForm()) {
        form.put(route("password.update"), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.password) {
                    form.reset("password", "password_confirmation");
                    passwordInput.value.focus();
                }
                if (form.errors.current_password) {
                    form.reset("current_password");
                    currentPasswordInput.value.focus();
                }
            },
        });
    } else {
        incorrectForm();
    }
};
</script>
