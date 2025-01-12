<template>

    <Head title="Códigos registros" />
    <AuthenticatedLayout>
        <ContentBox title="Códigos de registro" description="Menú de gestión de códigos de registro">
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
import { mdiPlusBox, mdiTableEye } from "@mdi/js";


const linksList = [
    {
        route: route('admin.genCode'),
        icon: mdiPlusBox,
        title: "Generar código de registro",
        description: "Formulario de creación de código para registrar un nuevo cliente"
    },
    {
        route: route('admin.delCode'),
        icon: mdiTableEye,
        title: "Visualizar códigos de registro",
        description: "Menú para visualizar códigos ya creados"
    }
]
</script>
