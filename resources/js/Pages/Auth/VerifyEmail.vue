<script setup>
import { computed } from "vue";
import GuestLayout from "@/Layouts/breeze_layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <GuestLayout>
        <Head title="Email de Verificación" />

        <div class="mb-4 flex flex-col text-center gap-4 text-skyblue-vlight">
            <p class="text-white">Hemos enviado un email de verificación a la dirección indicada.</p>
            <p class="text-sm">
                ¿Aún no has recibido tu correo de verificación?
                <br />
                No te preocupes, le enviaremos otro.
            </p>
            <p class="text-xs text-skyblue-vlight">
                *Recuerda revisar en la bandeja de spam
            </p>
        </div>

        <div
            class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
            v-if="verificationLinkSent"
        >
            Se ha enviado un nuevo enlace de verificación a la dirección de
            correo electrónico que proporcionaste durante el registro
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reenviar Email de Verificación
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="get"
                    as="button"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >Desconectar</Link
                >
            </div>
        </form>
        <p
            class="mt-4 text-end text-xs text-skyblue-vlight hover:text-skyblue-light hover:underline"
        >
            <Link :href="route('home')"> Volver a página principal </Link>
        </p>
    </GuestLayout>
</template>
