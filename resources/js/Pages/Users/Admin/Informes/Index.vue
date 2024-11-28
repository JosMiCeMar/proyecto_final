<template>
    <Head title="Informes" />
    <AuthenticatedLayout>
        <ContentBox
            title="Informes"
            description="Sección donde se mostrará información sobre los tratamientos realizados"
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
        route: route("admin.ultimoMesInforme"),
        icon: mdiCalendarText,
        title: "Informe Último Mes",
        description: "Datos y estadísticas del mes anterior",
    },
    {
        route: route("admin.informeGeneral"),
        icon: mdiFileChart,
        title: "Informe General",
        description: "Datos y estadísticas de toda la información almacenada",
    },
    {
        route: route("admin.personalizarInforme"),
        icon: mdiFileEdit,
        title: "Personalizar Informe",
        description: "Personaliza un informe con los datos que desees",
    },
];
</script>
