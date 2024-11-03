<template>
    <Head title="Modificar o Eliminar Días Asignados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Días Asignados"
            description="Selecciona la opción del día de trabajo"
            :returnLink="route('admin.indexDias')"
        >
           <!--Contenedor del mensaje a mostrar si se lleva a cabo la accion de eliminar o modificar correctamente-->
           <ConfirmMessage
                v-if="$page.props.flash.msg"
                :message="$page.props.flash.msg"
                position="center"
            />
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
                <!--Contenedor checkbox para mostrar dias anteriores al actual-->
                <div class="flex w-full gap-1 items-center justify-end px-4">
                    <InputLabel
                        class="text-skyblue-dark"
                        for="checkbox"
                        value="Mostrar días anteriores:"
                    />
                    <Checkbox id="checkbox" v-model="showAllDays" />
                </div>
                <!--Tabla de datos-->
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable
                            :items="displayedDays"
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
import { computed, ref } from "vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import Checkbox from "@/Components/breeze_components/Checkbox.vue";
import ConfirmMessage from "@/Components/dashboard_components/ConfirmMessage.vue";
import { deleteAlert, modAlert } from "@/Utils/alerts";
import { getToday } from "@/Utils/Validators/dias_validator";

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

const today = getToday();
const showAllDays = ref(false); //Constante para controlar el mostrado de datos en tabla
const headers = ["Centro", "Fecha", "Modificar", "Eliminar"]; //Cabeceras de la tabla

//Array con los dias asignados posteriores o iguales a la fecha actual
const filteredDays = computed(() => {
    return props.dias.filter((item) => {
        const itemDate = new Date(item.fecha);
        return itemDate >= today;
    });
});

//Constante que controla el mostrado de datos de la tabla
const displayedDays = computed(() => {
    //Si showAllDays es true, muestra todos dias devueltos por el back, con el false muestra los datos filtrados
    return showAllDays.value ? props.dias : filteredDays.value;
});

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
