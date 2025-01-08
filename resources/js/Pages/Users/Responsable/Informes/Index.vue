<template>
    <Head title="Informes" />
    <AuthenticatedLayout>
        <ContentBox
            title="Informes"
            description="Sección donde se mostrará información sobre los tratamientos realizados"
        >
            <div
                class="m-5 flex flex-col gap-5 lg:justify-center"
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
import { mdiCalendarText, mdiFileChart, mdiFileEdit } from "@mdi/js";

//Información para las tarjetas
const linksList = [
    {
        route: route("respon.ultimoMesInforme"),
        icon: mdiCalendarText,
        title: "Informe último mes",
        description: "Datos y estadísticas del mes anterior",
    },
    {
        route: route("respon.informeGeneral"),
        icon: mdiFileChart,
        title: "Informe general",
        description: "Datos y estadísticas de toda la información almacenada",
    },
    {
        route: route("respon.personalizarInforme"),
        icon: mdiFileEdit,
        title: "Personalizar informe",
        description: "Personaliza un informe con los datos que desees",
    },
];
</script>
