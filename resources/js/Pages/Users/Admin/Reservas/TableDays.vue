<template>
    <Head title="Selección de día" />
    <AuthenticatedLayout>
        <ContentBox
            title="Selección de día"
            description="Selecciona el día para modificar o visualizar sus reservas"
            :returnLink="route('admin.indexReservas')"
            :messageDown="false"
        >
            <!-- Filtros -->
            <div class="m-4 text-sm flex flex-col justify-end gap-2 md:gap-6 md:flex-row">
                <div class="w-full md:w-fit flex justify-end gap-2 items-center">
                    <label
                        for="centerFilter"
                        class="text-lavender-dark font-bold"
                    >
                        Filtrar por centro
                    </label>
                    <SelectInput
                        id="centerFilter"
                        v-model="selectedCenter"
                        class="text-sm w-fit py-1"
                        :optionsArray="availableCenters"
                        placeholder="Todos"
                        :disabledPlaceholder="false"
                    />
                </div>
            </div>

            <!-- Si el array recibido del back está vacío, muestra el mensaje -->
            <template v-if="filteredDias.length === 0">
                <div class="m-4 my-20">
                    <p class="text-center">
                        <span
                            class="text-lavender-dark font-bold sm:text-xl p-2 bg-red-300 rounded-lg"
                            >No hay días asignados</span
                        >
                    </p>
                </div>
            </template>

            <!--De lo contrario, muestra la tabla-->
            <template v-else>
                <!--Tabla de datos-->
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable :items="filteredDias" :headers="headers">
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
                                <td class="px-6 py-4">
                                    <ModButton
                                        @click="confirmMod(
                                            item.id,
                                            item.fecha,
                                            item.centro_nombre
                                        )"
                                    />
                                </td>
                                <td>
                                    <EyeButton
                                    @click="confirmShow(
                                            item.id,
                                            item.fecha,
                                            item.centro_nombre
                                        )"/>
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
import ModButton from "@/Components/dashboard_components/ModButton.vue";
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { modAlert, showAlert } from "@/Utils/alerts";
import { ref, computed } from "vue";	
import InputError from "@/Components/breeze_components/InputError.vue";
import EyeButton from "@/Components/dashboard_components/EyeButton.vue";
import SelectInput from "@/Components/breeze_components/SelectInput.vue";

//Propiedades - datos recibidos del back
const props = defineProps({
    dias: {
        type: Array,
        required: true,
    }
});

//Datos formulario
const form = useForm({
    id: "",
});

//Cabeceras de la tabla
const headers = [
    "Centro",
    "Fecha",
    "Modificar",
    "Mostrar",
];

// Estado para los filtros
const selectedCenter = ref("");

// Función para obtener los centros disponibles
const availableCenters = computed(() => {
    const centers = props.dias.map((dia) => dia.centro_nombre);
    return [...new Set(centers)].sort();
});

// Filtrar los días según el año y el centro seleccionados
const filteredDias = computed(() => {
    return props.dias.filter((dia) => {
        // Filtrar por centro si se seleccionó uno
        const matchesCenter =
            !selectedCenter.value || dia.centro_nombre === selectedCenter.value;

        return matchesCenter;
    });
});


//Función para confirmar la selección del día
const confirmShow = (itemId, day, center) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Quieres mostrar las reservas del ${date} en el centro ${center}?`;
    showAlert(() => {
        showDay(itemId);
    }, text);
};

//Función para confirmar la selección del día
const confirmMod = (itemId, day, center) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Quieres modificar las reservas del ${date} en el centro ${center}?`;
    modAlert(() => {
        modDay(itemId);
    }, text);
};

//Funcion que manda los datos al back para mostrar el formulario de modificacion
const modDay = (itemId) => {
    router.get(route("admin.formReservas", { id: itemId }));
};

//Funcion que manda los datos al back para mostrar las reservas del día
const showDay = (itemId) => {
    router.get(route("admin.showReservas", { id: itemId }));
};
</script>
