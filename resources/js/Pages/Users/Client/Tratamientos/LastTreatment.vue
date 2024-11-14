<template>
    <Head title="Últimos Tratamientos" />
    <AuthenticatedLayout>
        <ContentBox
            title="Mis últimos Tratamientos"
            :description="`Resumen de tus últimos tratamientos realizados`"
            :returnLink="route('client.indexTratamientos')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.tratamientos.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No tienes tratamientos realizados actualmente</span
                        >
                    </p>
                </div>
            </template>

            <!--De lo contrario, muestra la tabla-->
            <template v-else>
                <!--Tabla de datos-->
                <div class="my-4">
                    <PaginatedTable
                        :items="props.tratamientos"
                        :headers="headers"
                        :controlsVisible="false"
                    >
                        <template
                            #default="{ item }"
                            class="text-lavender-dark"
                        >
                            <td
                                class="px-6 py-4 font-bold uppercase"
                            >
                                {{ item.zona_nombre }}
                            </td>
                            <td class="px-6 py-4">{{ item.zona_precio }}€</td>
                            <td class="px-6 py-4">
                                {{ item.centro_nombre }} ({{ item.centro_localidad }})
                            </td>
                            <td class="px-6 py-4">
                                {{ new Date(item.fecha).toLocaleDateString() }}
                            </td>
                        </template>
                    </PaginatedTable>
                    <div class="w-full flex justify-start">
                        <div
                            class="w-40 text-center shadow-md bg-gradient-to-t from-lavender-dark to-skyblue-dark rounded-bl-md text-white px-2 py-1"
                        >
                            Total:
                        </div>
                        <div class="w-40 text-center shadow-md text-lavender-dark font-semibold bg-white border-b border-r rounded-br-md border-skyblue-dark py-1 px-2">{{ getTotalPrice() }}€</div>
                    </div>
                </div>
            </template>
        </ContentBox>
        <p class="text-xs text-skyblue-dark ml-4 pb-4 text-center">
            <span class="font-bold">*A tener en cuenta: </span>Esto una tabla
            informativa, los precios, zonas y centros pueden verse modificados
            con el tiempo.
        </p>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    tratamientos: {
        type: Array,
        required: true,
    },
});

const headers = ["Zona", "Precio", "Centro", "Fecha"];

const getTotalPrice = () => {
    let totalPrice = 0;

    props.tratamientos.forEach((item) => {
        totalPrice += parseFloat(item.zona_precio);
    });

    return totalPrice;
};
</script>
