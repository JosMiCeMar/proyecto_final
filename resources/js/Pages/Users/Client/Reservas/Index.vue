<template>
    <Head title="Mis citas" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis citas"
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
        </ContentBox>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import { mdiPlusBox, mdiTableEdit  } from '@mdi/js';

const linksList = [
    {
        route: route("client.createCitas"),
        icon: mdiPlusBox,
        title: "Reservar cita",
        description:
            "Formulario para reservar tu próxima cita",
    },
    {
        route: route("client.tableCitas"),
        icon: mdiTableEdit,
        title: "Modificar o eliminar cita",
        description: "Menú para modificar o eliminar tus citas",
    },
];
</script>
