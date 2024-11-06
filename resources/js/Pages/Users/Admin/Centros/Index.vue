<template>
    <Head title="Centros Asociados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Centros Asociados"
            description="Menú de gestión de Centros Asociados"
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
            <!--Contenedor del mensaje a mostrar si se lleva a cabo la accion de eliminar o modificar correctamente-->
            <ConfirmMessage
                v-if="$page.props.flash.msg"
                :message="$page.props.flash.msg"
            />
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import { mdiPlusBox, mdiTableEdit } from "@mdi/js";

const linksList = [
    {
        route: route("admin.createCenter"),
        icon: mdiPlusBox,
        title: "Añadir Centro Asociado",
        description: "Formulario de creación para un nuevo centro asociado",
    },
    {
        route: route("admin.listCenter"),
        icon: mdiTableEdit,
        title: "Modificar o Eliminar Centro Asociado",
        description:
            "Menú para modificar centros existentes en la base de datos",
    },
];
</script>
