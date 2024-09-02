<template>
    <section>
        <header>
            <h2 class="text-lg font-bold text-lavender-dark">
                Actualizar Contraseña
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
                    value="Contraseña Actual"
                />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
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
                    value="Nueva Contraseña"
                />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton
                    :disabled="form.processing"
                    class="bg-lavender-dark text-skyblue-vlight hover:text-lavender-dark hover:border-lavender-dark"
                    >Guardar Cambios</PrimaryButton
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
import TextInput from "@/Components/breeze_components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { inject } from "vue";

const swal = inject("$swal");

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

function validateForm() {
    const errors = {};

    //Validación contraseña
    if (!form.password) {
        errors.password = "Introduce la nueva contraseña";
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
