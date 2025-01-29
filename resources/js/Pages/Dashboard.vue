<template>
    <Head title="Panel de Usuario" />

    <AuthenticatedLayout>
        <ContentBox
            title="Panel de usuario"
            :description="`Bienvenid@ ${user.nombre}`"
        >
            <p
                v-show="!verified"
                class="bg-red-600 p-2 m-2 text-center text-white text-sm rounded-md shadow-md"
            >
                <span class="font-bold">IMPORTANTE:</span> Tu perfil aún no se
                ha verificado, si no encuentras el mensaje de verificación en tu
                bandeja, pulsa
                <Link
                    :href="route('verification.notice')"
                    class="font-bold underline hover:text-skyblue-vlight transition-all"
                    >AQUÍ</Link
                >
            </p>
            <section v-show="verified">
                <NotificationTable :items="props.notificaciones" />
            </section>
        </ContentBox>

        {{ $page.props }}
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import { Head, usePage, Link } from "@inertiajs/vue3";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import NotificationTable from "@/Components/dashboard_components/NotificationTable.vue";

const user = usePage().props.auth.user;
const verified = user.email_verified_at !== null;

const props = defineProps({
    notificaciones: {
        type: Array,
        required: false,
    },
});
</script>
