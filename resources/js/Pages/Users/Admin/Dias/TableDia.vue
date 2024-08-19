<template>
    <Head title="Modificar o Eliminar Días Asignados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar o Eliminar Días Asignados"
            description="Selecciona la opción del día de trabajo"
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
                <!--Contenedor checkbox para mostrar dias anteriores al actual-->
                <div class="flex w-full gap-1 items-center justify-end px-4">
                    <InputLabel
                        class="text-skyblue-dark"
                        for="checkbox"
                        value="Mostrar días anteriores:"
                    />
                    <Checkbox id="checkbox" v-model="showAllDays"/>
                </div>
                <!--Tabla de datos-->
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable :items="displayedDays" :headers="headers">
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
            <!--Boton de retorno-->
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
import { Head, router, useForm } from "@inertiajs/vue3";
import { inject, computed, ref } from "vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import Checkbox from "@/Components/breeze_components/Checkbox.vue";

//Propiedades - datos recibidos del back
const props = defineProps({
    dias: {
        type: Array,
        required: true,
    },
});

//Datos formulario
const form = useForm({
    id: ""
});


const swal = inject("$swal");//Constante del sweetalert2
const today = new Date();
today.setHours(0, 0, 0, 0);
const showAllDays = ref(false);//Constante para controlar el mostrado de datos en tabla
const headers = ["Centro", "Fecha", "Modificar", "Eliminar"];//Cabeceras de la tabla

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
    swal.fire({
        title: `¿Seguro que quieres eliminar la fecha ${date}, asignada a ${name}?`,
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
            deleteCenter(itemId);
        }
    });
};

//Funcion para confirmar la modificacion
const confirmMod = (itemId, day, name) => {
    const date = new Date(day).toLocaleDateString();
    swal.fire({
        title: `¿Vas a modificar la fecha ${date} asignada al centro ${name}?`,
        text: "Se mostrará un formulario donde cambiar los datos",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, modificar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            modCenter(itemId);
        }
    });
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
