<template>
    <Head title="Días Asignados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Días Asignados"
            description="Menú de gestión de Asignación de Días"
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
        route: route("admin.createDias"),
        icon: mdiPlusBox,
        title: "Asignar Día a Centro Asociado",
        description:
            "Formulario de asignación de día de trabajo a un centro asociado",
    },
    {
        route: route("admin.listDias"),
        icon: mdiTableEdit,
        title: "Modificar o Eliminar Días Asignados",
        description: "Menú para modificar o eliminar días asignados",
    },
];
</script>
