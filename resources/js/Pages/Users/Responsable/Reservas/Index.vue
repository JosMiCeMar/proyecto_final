<template>

    <Head title="Reservas" />
    <AuthenticatedLayout>
        <ContentBox title="Reservas" description="Menú de gestión de reservas">
            <div class="m-5 flex flex-col gap-5">
                <LinkBox v-for="box in linksList" :route="box.route" :icon="box.icon" :title="box.title"
                    :description="box.description" />
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import { mdiArchiveEye, mdiHumanQueue } from "@mdi/js";


const linksList = [
    {
        route: route('respon.listReservas'),
        icon: mdiHumanQueue,
        title: "Mostrar y gestionar reservas",
        description: "Visualiza y gestiona las reservas actuales"
    },
    {
        route: route('respon.listPastReservas'),
        icon: mdiArchiveEye,
        title: "Mostrar historial",
        description: "Visualiza el historial de reservas anteriores"
    }
]
</script>
