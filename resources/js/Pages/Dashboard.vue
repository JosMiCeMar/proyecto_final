<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import { Head, usePage, Link } from "@inertiajs/vue3";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";


const user = usePage().props.auth.user;
const verified = user.email_verified_at !== null;
</script>

<template>
    <Head title="Panel de Usuario" />

    <AuthenticatedLayout>
        <ContentBox
            :title="'Bienvenid@ ' + user.nombre"
            description="Estos son los datos a tener en cuenta hoy"
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

        </ContentBox>

        {{ $page.props }}
    </AuthenticatedLayout>
</template>
