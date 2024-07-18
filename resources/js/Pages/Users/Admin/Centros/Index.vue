<template>

    <Head title="Códigos Registros" />
    <AuthenticatedLayout>
        <ContentBox title="Centros Asociados" description="Menú de gestión de Centros Asociados">
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

const linksList = [
    {
        route: route('admin.genCode'),
        icon: 'img/icons/plus_lavender.svg',
        title: "Añadir Centro Asociado",
        description: "Formulario de creación para un nuevo centro asociado"
    },
    {
        route: route('admin.delCode'),
        icon: 'img/icons/mod_lavender.svg',
        title: "Modificar Centro Asociado",
        description: "Menú para modificar centros existentes en la base de datos"
    },
    {
        route: route('admin.delCode'),
        icon: 'img/icons/delete_lavender.svg',
        title: "Eliminar Centro Asociado",
        description: "Menú para eliminar centros existentes en la base de datos"
    }
]
</script>
