<template>
    <Head title="Mis Tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis Tratamientos"
            description="Sección donde podrás ver diferente información sobre tus tratamientos realizados"
        >
            <div class="m-5 flex flex-col gap-5">
                <LinkBox
                    v-for="box in linksList"
                    :route="box.route"
                    :icon="box.icon"
                    :title="box.title"
                    :description="box.description"
                />
                <!--Contenedores de mensaje para confirmaciones o errores-->
                <ConfirmMessage
                    v-if="$page.props.flash.msg"
                    :message="$page.props.flash.msg"
                />
                <InputError
                    v-if="$page.props.errors"
                    :message="$page.props.errors[0]"
                />
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import { Head } from "@inertiajs/vue3";
import { mdiFormatListNumbered  } from '@mdi/js';

//Propiedades - datos recibidos del back
const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    },
});

const linksList = [
    {
        route: route("dashboard"),
        icon: mdiFormatListNumbered ,
        title: "Mostrar ultimos tratamientos",
        description: "Se mostrarán tus últimos 5 tratamientos",
    },
];
</script>
