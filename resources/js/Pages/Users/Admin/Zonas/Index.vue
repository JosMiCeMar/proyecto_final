<template>
    <Head title="Zonas Tratamiento" />
    <AuthenticatedLayout>
        <ContentBox
            title="Zonas de tratamiento"
            description="Menú de gestión de zonas de tratamiento"
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
            <InputError
                v-if="$page.props.errors"
                :message="$page.props.errors[0]"
            />
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";

const linksList = [
    {
        route: route("admin.createZona"),
        icon: "img/icons/plus_lavender.svg",
        title: "Añadir Zona de Tratamiento",
        description:
            "Formulario de creación para una nueva zona de tratamiento",
    },
    {
        route: route("admin.listZona"),
        icon: "img/icons/mod_lavender.svg",
        title: "Modificar o Eliminar Zona de Tratamiento",
        description:
            "Menú para modificar zonas de tratamiento en la base de datos",
    },
];
</script>
