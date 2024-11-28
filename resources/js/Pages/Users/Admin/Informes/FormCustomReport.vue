<template>
    <Head title="Formulario Informe Personalizado" />
    <AuthenticatedLayout>
        <ContentBox
            title="Formulario Informe Personalizado"
            description="Personaliza el informe con los datos que necesites"
            :returnLink="route('admin.indexInforme')"
            :messageDown="false"
        >
        </ContentBox>

    </AuthenticatedLayout>
</template>
<script setup>
//Importaciones de vue
import { Head } from "@inertiajs/vue3";
//Componentes
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";


const mes="Diciembre";
const anio="2024"

</script>
