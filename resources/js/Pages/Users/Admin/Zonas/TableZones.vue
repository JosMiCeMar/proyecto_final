<template>
    <Head title="Modificar o Eliminar Zonas Tratamiento" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Zonas Tratamiento"
            description="Selecciona la opción de la zona de tratamiento"
            :returnLink="route('admin.indexZona')"
        >
            <!--Contenedor del mensaje a mostrar si se lleva a cabo la accion de eliminar o modificar correctamente-->
            <ConfirmMessage
                v-if="$page.props.flash.msg"
                :message="$page.props.flash.msg"
                position="center"
            />
            <template v-if="zonas.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No existen zonas de tratamiento actualmente</span
                        >
                    </p>
                </div>
            </template>
            <template v-else>
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable :items="zonas" :headers="headers">
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td
                                    class="px-6 py-4 font-bold whitespace-nowrap"
                                >
                                    {{ item.nombre.toUpperCase() }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.precio + "€" }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.tiempo_estimado }}
                                </td>
                                <td class="px-6 py-4">
                                    <ModButton
                                        @click.prevent="
                                            confirmMod(item.id, item.nombre)
                                        "
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <TrashButton
                                        @click.prevent="
                                            confirmDelete(item.id, item.nombre)
                                        "
                                    />
                                </td>
                            </template>
                        </PaginatedTable>
                        <div
                            v-show="form.errors.id"
                            class="bg-red-500 rounded-md text-center text-white font-bold text-lg"
                        >
                            <p>{{ form.errors.id }}</p>
                        </div>
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
import ModButton from "@/Components/dashboard_components/ModButton.vue";
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import ReturnLink from "@/Components/dashboard_components/ReturnLink.vue";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { inject } from "vue";
import { deleteAlert, modAlert } from "@/Utils/alerts";

const swal = inject("$swal");

const props = defineProps({
    zonas: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    id: "",
});

const headers = [
    "Nombre",
    "Precio",
    "Tiempo Estimado",
    "Modificar",
    "Eliminar",
];

const confirmDelete = (itemId, name) => {
    deleteAlert(()=>{deleteZone(itemId);},`¿Seguro que quieres eliminar la zona: ${name.toUpperCase()}?`)
};

const confirmMod = (itemId, name) => {
    modAlert(()=>{ modZone(itemId);},`¿Vas a modificar la zona ${name.toUpperCase()}?`);
};

const deleteZone = (itemId) => {
    form.id = itemId;
    form.post(route("admin.delZona"));
};

const modZone = (itemId) => {
    router.get(route("admin.modZona", { id: itemId }));
};
</script>
