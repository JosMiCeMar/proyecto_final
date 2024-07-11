<template>

    <Head title="Códigos Registros" />
    <AuthenticatedLayout>
        <ContentBox title="Códigos de Registro" description="Menú de gestión de Códigos de Registro">
            <div class="m-5 flex flex-col gap-5">
                <LinkBox v-for="box in linksList" :route="box.route" :icon="box.icon" :title="box.title"
                    :description="box.description" />
            </div>
        </ContentBox>
        {{ props.usuario }}
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import { defineProps } from "vue";

const props=defineProps({
    usuario:{
        required:true
    }
})

const linksList = [
    {
        route: route('genCode'),
        icon: 'img/icons/plus_person_lavender.svg',
        title: "Generar Código de Registro",
        description: "Formulario de creación de código para registrar un nuevo usuario"
    },
    {
        route: route('delCode'),
        icon: 'img/icons/delete_lavender.svg',
        title: "Eliminar Códigos de Registro",
        description: "Menú para eliminar códigos ya creados"
    }
]
</script>
