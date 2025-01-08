<template>
    <Head title="Centros asociados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Centros asociados"
            description="Menú de gestión de centros asociados"
        >
            <div class="m-5 flex flex-col gap-5">
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
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import { mdiPlusBox, mdiTableEdit } from "@mdi/js";

const linksList = [
    {
        route: route("admin.createCenter"),
        icon: mdiPlusBox,
        title: "Añadir centro asociado",
        description: "Formulario de creación para un nuevo centro asociado",
    },
    {
        route: route("admin.listCenter"),
        icon: mdiTableEdit,
        title: "Modificar o eliminar centro asociado",
        description:
            "Menú para modificar centros existentes en la base de datos",
    },
];
</script>
