<template>
    <Head title="Eliminar Código" />
    <AuthenticatedLayout>
        <ContentBox
            title="Eliminar Códigos de Registro"
            description="Selecciona los códigos de registro que vas a eliminar"
            :returnLink="route('admin.indexCode')"
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
                    <form @submit.prevent="submit">
                        <div
                            v-if="usados"
                            class="flex text-lg items-center justify-end"
                        >
                            <div
                                class="flex items-center gap-4 mx-6 p-2 rounded-md"
                            >
                                <span
                                    class="font-bold text-lavender-dark uppercase"
                                    >Eliminar todos los códigos usados</span
                                >
                                <TrashButton
                                    @click.prevent="confirmDelete(0)"
                                />
                            </div>
                        </div>
                        <PaginatedTable :items="codigos" :headers="headers">
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td
                                    class="px-6 py-4 font-bold whitespace-nowrap"
                                >
                                    {{ item.codigo }}
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="item.para_cliente"
                                        >Cliente</span
                                    >
                                    <span v-else>Responsable</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="item.usado">SI</span>
                                    <span v-else>NO</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ formatDate(item.created_at) }}
                                </td>
                                <td class="px-6 py-4">
                                    <TrashButton
                                        @click.prevent="confirmDelete(item.id)"
                                    />
                                </td>
                            </template>
                        </PaginatedTable>
                    </form>
                </div>
            </template>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import TrashButton from "@/Components/dashboard_components/TrashButton.vue";
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { inject } from "vue";

const swal = inject("$swal");

const props = defineProps({
    codigos: {
        type: Array,
        required: true,
    },
    usados: {
        type: Boolean,
        required: true,
    },
});

const form = useForm({
    id: "",
});

const headers = ["Código", "Rol", "Usado", "Fecha Generado", "Eliminar"];

const formatDate = (fecha) => {
    const fechaRecibida = fecha.split("T")[0];
    const objDate = new Date(fechaRecibida);
    return objDate.toLocaleDateString();
};

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
    form.post(route("admin.delCode"));
};
</script>
