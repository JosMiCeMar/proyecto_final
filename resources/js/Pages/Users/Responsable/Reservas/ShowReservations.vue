<template>
    <Head title="Mostrado de Reservas" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mostrado de Reservas"
            :description="`Reservas del día ${new Date(props.dia.fecha).toLocaleDateString()}`"
            :returnLink="route('respon.indexReservas')"
            :messageDown="false"
        >
            <TableDays
                :morningData="props.maniana"
                :afternoonData="props.tarde"
                :editable="props.editable"
                :idDay="parseInt(props.id_dia)"
                routeMod="respon.modReservas"
                routeDel="respon.delReservas"
            />
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import TableDays from "@/Components/dashboard_components/ReservationsTable.vue";
import { Head } from "@inertiajs/vue3";

//Propiedades - datos recibidos del back
const props = defineProps({
    dia: {
        type: Object,
        required: true,
    },
    maniana: {
        type: Array,
        required: true,
    },
    tarde: {
        type: Array,
        required: true,
    },
    editable:
    {
        type: Boolean,
        required: true,
    },
    id_dia:
    {
        type: String,
        required: true,
    }
});


</script>
