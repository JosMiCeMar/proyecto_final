<template>
    <Head title="Modificar o Eliminar Citas" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Citas"
            description="Selecciona la opción de la cita"
            :returnLink="route('client.indexCitas')"
            :messageDown="false"
        >
            <!--Si el array recibido del back esta vacio, muestra el mensaje-->
            <template v-if="props.citas.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No tienes citas actualmente</span
                        >
                    </p>
                </div>
            </template>

            <!--De lo contrario, muestra la tabla-->
            <template v-else>
                <!--Tabla de datos-->
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable :items="props.citas" :headers="headers">
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td
                                    class="px-6 py-4 font-bold whitespace-nowrap"
                                >
                                    {{ item.centro_nombre }} ({{
                                        item.centro_localidad
                                    }})
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        new Date(
                                            item.fecha
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-6 py-4 uppercase">
                                    {{ item.zona_nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.hora_inicio }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.hora_fin }}
                                </td>
                                <td class="px-6 py-4">
                                    <ModButton
                                        @click.prevent="
                                            confirmMod(
                                                item.id,
                                                item.fecha,
                                                item.zona_nombre,
                                                item.centro_nombre
                                            )
                                        "
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <TrashButton
                                        @click.prevent="
                                            confirmDelete(
                                                item.id,
                                                item.zona_nombre,
                                                item.fecha
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
                        <InputError
                            v-if="$page.props.errors"
                            :message="$page.props.errors[0]"
                        />
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
import { deleteAlert, modAlert } from "@/Utils/alerts";
import InputError from "@/Components/breeze_components/InputError.vue";

//Propiedades - datos recibidos del back
const props = defineProps({
    citas: {
        type: Array,
        required: true,
    },
});

//Datos formulario
const form = useForm({
    id: "",
});

//Cabeceras de la tabla
const headers = [
    "Centro",
    "Fecha",
    "Zona",
    "Hora Cita",
    "Hora Fin (Estimación)",
    "Modificar Hora",
    "Eliminar",
]; 

//Funcion para confirmar el borrado
const confirmDelete = (itemId, zone, day) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Seguro que quieres eliminar la cita del tratamiento de ${zone} del día ${date}?`;
    deleteAlert(() => {
        deleteCitation(itemId);
    }, text);
};

//Funcion para confirmar la modificacion
const confirmMod = (itemId, day, zone, center) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Quieres modificar la hora del tratamiento de ${zone} del ${date} en el centro ${center}?`;
    modAlert(() => {
        modCitation(itemId);
    }, text);
};

//Funcion que manda los datos al back para su borrado
const deleteCitation = (itemId) => {
    form.id = itemId;
    form.post(route("client.delReser"));
};

//Funcion que manda los datos al back para mostrar el formulario de modificacion
const modCitation = (itemId) => {
    router.get(route("client.modReser", { id: itemId }));
};
</script>
