<script setup>
import GuestLayout from "@/Layouts/breeze_layouts/GuestLayout.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Contraseña olvidada" />

        <div class="mb-4 text-sm text-skyblue-vlight">
            ¿Olvidaste tu contraseña? No hay problema. Solo háznoslo saber,
            proporciona tu dirección de correo electrónico y te enviaremos un
            enlace para restablecer la contraseña que te permitirá elegir una
            nueva
        </div>

        <div
            v-if="status"
            class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                Restablecer la Contraseña
                </PrimaryButton>
            </div>
        </form>
        <p class="mt-4 text-end text-xs text-skyblue-vlight  hover:text-skyblue-light hover:underline">
            <Link :href="route('home')">
            Volver a página principal
            </Link>
        </p>
    </GuestLayout>
</template>
