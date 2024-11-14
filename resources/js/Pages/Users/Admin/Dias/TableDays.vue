<template>
    <Head title="Modificar o Eliminar Días Asignados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Días Asignados"
            description="Selecciona la opción del día de trabajo"
            :returnLink="route('admin.indexDias')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.dias.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No existen días asignados actualmente</span
                        >
                    </p>
                </div>
            </template>

            <!--De lo contrario, muestra la tabla-->
            <template v-else>
                <!--Tabla de datos-->
                <div class="m-4">
                    <form @submit.prevent="submit">
                        <PaginatedTable
                            :items="props.dias"
                            :headers="headers"
                        >
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td
                                    class="px-6 py-4 font-bold whitespace-nowrap"
                                >
                                    {{ item.nombre }} ({{ item.localidad }})
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        new Date(
                                            item.fecha
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    <ModButton
                                        @click.prevent="
                                            confirmMod(
                                                item.id,
                                                item.fecha,
                                                item.nombre
                                            )
                                        "
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <TrashButton
                                        @click.prevent="
                                            confirmDelete(
                                                item.id,
                                                item.fecha,
                                                item.nombre
                                            )
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
import { Head, router, useForm } from "@inertiajs/vue3";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import { deleteAlert, modAlert } from "@/Utils/alerts";

//Propiedades - datos recibidos del back
const props = defineProps({
    dias: {
        type: Array,
        required: true,
    },
});

//Datos formulario
const form = useForm({
    id: "",
});

//Cabeceras de la tabla
const headers=['Centro','Fecha','Modificar','Eliminar'];

//Funcion para confirmar el borrado
const confirmDelete = (itemId, day, name) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Seguro que quieres eliminar la fecha ${date}, asignada a ${name}?`
    deleteAlert(()=>{deleteCenter(itemId)}, text);
};

//Funcion para confirmar la modificacion
const confirmMod = (itemId, day, name) => {
    const date = new Date(day).toLocaleDateString();
    const text =  `¿Vas a modificar la fecha ${date} asignada al centro ${name}?`;
    modAlert(()=>{modCenter(itemId)},text);
};

//Funcion que manda los datos al back para su borrado
const deleteCenter = (itemId) => {
    form.id = itemId;
    form.post(route("admin.delDias"));
};

//Funcion que manda los datos al back para mostrar el formulario de modificacion
const modCenter = (itemId) => {
    router.get(route("admin.modDias", { id: itemId }));
};
</script>
