<template>
    <Head title="Modificar o Eliminar Centros Asociados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Centros Asociados"
            description="Selecciona la opción del centro asociado"
        >
            <template v-if="props.centros.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No existen centros asociados actualmente</span
                        >
                    </p>
                </div>
            </template>
            <template v-else>
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable :items="centros" :headers="headers">
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td
                                    class="px-6 py-4 font-bold whitespace-nowrap"
                                >
                                    {{ item.nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.direccion }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.localidad }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.provincia }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.telefono }}
                                </td>
                                <td class="px-6 py-4 flex gap-2 flex-wrap justify-around">
                                    <ModButton
                                        @click.prevent="confirmDelete(item.id)"
                                    />
                                    <TrashButton
                                        @click.prevent="confirmDelete(item.id)"
                                    />
                                    
                                </td>
                            </template>
                        </PaginatedTable>
                    </form>
                </div>
            </template>
            <div class="flex sm:justify-end justify-center w-full">
                <ReturnLink
                    class="text-skyblue-dark font-bold sm:mx-8"
                    iconColor="#315D66"
                    :link="route('admin.indexCenter')"
                    value="Volver al menú"
                />
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import TrashButton from "@/Components/dashboard_components/TrashButton.vue";
import ModButton from "@/Components/dashboard_components/ModButton.vue";
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import ReturnLink from "@/Components/dashboard_components/ReturnLink.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { inject } from "vue";

const swal = inject("$swal");

const props = defineProps({
    centros: {
        type: Array,
        required: true,
    }
});

const form = useForm({
    id: "",
});

const headers = ["Nombre","Dirección", "Localidad", "Provincia", "Telefono", "Modificar - Eliminar"];


const confirmDelete = (itemId) => {
    swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            submit(itemId);
        }
    });
};

const submit = (itemId) => {
    form.id = itemId;
    form.post(route("admin.delCenter"));
};
</script>
