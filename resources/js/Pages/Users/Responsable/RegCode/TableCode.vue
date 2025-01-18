<template>
    <Head title="Eliminar Código" />
    <AuthenticatedLayout>
        <ContentBox
            title="Ver Códigos de Registro"
            description="Tabla con los códigos de registro que has generado"
            :returnLink="route('respon.indexCode')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.codigos.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No existen códigos de registro actualmente</span
                        >
                    </p>
                </div>
            </template>
            <template v-else>
                <div>
                    <PaginatedTable :items="codigos" :headers="headers">
                        <template
                            #default="{ item }"
                            class="text-lavender-dark"
                        >
                            <td class="px-6 py-4 font-bold whitespace-nowrap">
                                {{ item.codigo }}
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="item.usado">SI</span>
                                <span v-else>NO</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ formatDateTime(item.created_at) }}
                            </td>
                        </template>
                    </PaginatedTable>
                </div>
            </template>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import { Head } from "@inertiajs/vue3";
import { formatDateTime } from "@/Utils/utilsFunctions";

const props = defineProps({
    codigos: {
        type: Array,
        required: true,
    },
});

const headers = ["Código", "Usado", "Fecha Generado"];
</script>
