<template>
    <Head title="Mis Tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis Tratamientos"
            description="Sección donde podrás ver diferente información sobre tus tratamientos realizados"
        >
            <div
                class="m-5 flex flex-wrap gap-6 items-center lg:justify-center"
            >
                <LinkBox
                    v-for="box in linksList"
                    :route="box.route"
                    :icon="box.icon"
                    :title="box.title"
                    :description="box.description"
                />
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import { Head } from "@inertiajs/vue3";
import { mdiFileChart, mdiFileEdit, mdiFormatListNumbered } from "@mdi/js";

const linksList = [
    {
        route: route("client.ultimosTratamientos"),
        icon: mdiFormatListNumbered,
        title: "Mostrar Últimos Tratamientos",
        description: "Detalles de tus últimos tratamientos",
    },
    {
        route: route("client.resumenTratamientos"),
        icon: mdiFileChart,
        title: "Informe de Tratamientos",
        description: "Resumen de todos los tratamientos realizados",
    },
    {
        route: route("dashboard"),
        icon: mdiFileEdit,
        title: "Personalizar Informe",
        description: "Personaliza un informe con los datos que desees",
    },
];
</script>
