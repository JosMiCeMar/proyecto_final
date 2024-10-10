<template>
    <Head title="Mis Tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis Tratamientos"
            description="Tabla donde podrás ver un resumen de tus tratamientos realizados"
        >
            <div class="m-5 flex flex-col gap-5">
               
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";


</script>
