<template>
    <Head title="Mis Citas" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis Citas"
            description="Menú de gestión de tus citas"
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
          <!--Contenedores de mensaje para confirmaciones o errores-->
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
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import { mdiPlusBox, mdiTableEdit  } from '@mdi/js';

const linksList = [
    {
        route: route("client.createCitas"),
        icon: mdiPlusBox,
        title: "Reservar Cita",
        description:
            "Formulario para reservar tu próxima cita",
    },
    {
        route: route("client.tableCitas"),
        icon: mdiTableEdit,
        title: "Modificar o Eliminar Cita",
        description: "Menú para modificar o eliminar tus citas",
    },
];
</script>
