<template>
    <Head title="Mis tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis tratamientos"
            description="Sección donde podrás ver diferente información sobre tus tratamientos realizados"
        >
            <div
                class="m-5 flex flex-col gap-6 justify-center"
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
//Importaciones de vue
import { Head } from "@inertiajs/vue3";
//Componentes
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
//Iconos
import { mdiFileChart, mdiFileEdit, mdiFormatListNumbered } from "@mdi/js";

//Información para las tarjetas
const linksList = [
    {
        route: route("client.ultimosTratamientos"),
        icon: mdiFormatListNumbered,
        title: "Últimos tratamientos",
        description: "Detalles de tus últimos tratamientos",
    },
    {
        route: route("client.informeTratamientos"),
        icon: mdiFileChart,
        title: "Informe de tratamientos",
        description: "Resumen de todos los tratamientos realizados",
    },
    {
        route: route("client.personalizarInforme"),
        icon: mdiFileEdit,
        title: "Personalizar informe",
        description: "Personaliza un informe con los datos que desees",
    },
];
</script>
