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

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
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
                    required
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
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
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
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-lavender-dark"
                    >
                        Actualizado
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
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.nombre,
    lastname: user.apellidos,
    tel:user.telefono,
    email: user.email,

});
</script>
