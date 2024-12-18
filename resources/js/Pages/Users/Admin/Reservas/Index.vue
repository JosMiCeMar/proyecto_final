<template>

    <Head title="Gestión de Reservas" />
    <AuthenticatedLayout>
        <ContentBox title="Gestión de Reservas" description="Menú de gestión de Reservas">
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
import { mdiHumanQueue } from "@mdi/js";


const linksList = [
    {
        route: route('admin.listReservas'),
        icon: mdiHumanQueue,
        title: "Mostrar y Gestionar Reservas",
        description: "Visualiza y gestiona las reservas de los clientes"
    }
]
</script>
