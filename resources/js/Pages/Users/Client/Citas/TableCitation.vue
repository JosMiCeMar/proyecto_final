<template>
    <Head title="Modificar o Eliminar Citas" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Citas"
            description="Selecciona la opción de la cita"
        >
           <!--Contenedor del mensaje a mostrar si se lleva a cabo la accion de eliminar o modificar correctamente-->
           <ConfirmMessage
                v-if="$page.props.flash.msg"
                :message="$page.props.flash.msg"
                position="center"
            />
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
                        <PaginatedTable
                            :items="props.citas"
                            :headers="headers"
                        >
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td
                                    class="px-6 py-4 font-bold whitespace-nowrap"
                                >
                                    {{ item.centro_nombre }} ({{ item.centro_localidad }})
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        new Date(
                                            item.fecha
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-6 py-4 uppercase">
                                    {{item.zona_nombre}}
                                </td>
                                <td class="px-6 py-4">
                                    {{item.hora_inicio}}
                                </td>
                                <td class="px-6 py-4">
                                    {{item.hora_fin}}
                                </td>
                                <td class="px-6 py-4">
                                    <ModButton
                                        @click.prevent=""
                                    />
                                </td>
                                <td class="px-6 py-4">
                                    <TrashButton
                                        @click.prevent=""
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
            <!--Boton de retorno-->
            <div class="flex sm:justify-end justify-center w-full">
                <ReturnLink
                    class="text-skyblue-dark font-bold sm:mx-8"
                    iconColor="#315D66"
                    :link="route('client.indexCitas')"
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
import { Head, router, useForm } from "@inertiajs/vue3";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import { deleteAlert, modAlert } from "@/Utils/alerts";

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

const headers = ["Centro", "Fecha","Zona","Hora Cita","Hora Fin (Estimación)", "Modificar Hora", "Eliminar"]; //Cabeceras de la tabla


//Funcion para confirmar el borrado
const confirmDelete = (itemId, day) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Seguro que quieres eliminar la cita del día ${date}?`
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
