<template>

    <Head title="Códigos Registros" />
    <AuthenticatedLayout>
        <ContentBox title="Códigos de Registro" description="Menú de gestión de Códigos de Registro">
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
import { mdiPlusBox, mdiDeleteSweep } from "@mdi/js";


const linksList = [
    {
        route: route('admin.genCode'),
        icon: mdiPlusBox,
        title: "Generar Código de Registro",
        description: "Formulario de creación de código para registrar un nuevo usuario"
    },
    {
        route: route('admin.delCode'),
        icon: mdiDeleteSweep,
        title: "Eliminar Códigos de Registro",
        description: "Menú para eliminar códigos ya creados"
    }
]
</script>
