<template>
    <Head title="Selección de día" />
    <AuthenticatedLayout>
        <ContentBox
            title="Selección de día"
            description="Selecciona el día para visualizar sus reservas"
            :returnLink="route('respon.indexReservas')"
            :messageDown="false"
        >
            <!-- Filtros -->
            <div class="m-4 text-sm flex flex-col justify-end gap-2 md:gap-6 md:flex-row">
                <div class="w-full md:w-fit flex justify-end gap-2 items-center">
                    <label
                        for="yearFilter"
                        class="text-lavender-dark font-bold"
                    >
                        Filtrar por año
                    </label>
                    <SelectInput
                        id="yearFilter"
                        v-model="selectedYear"
                        class="text-sm w-fit py-1"
                        :optionsArray="availableYears"
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
                            >No hay días de trabajo</span
                        >
                    </p>
                </div>
            </template>

            <!-- De lo contrario, muestra la tabla -->
            <template v-else>
                <!-- Tabla de datos -->
                <div>
                    <form @submit.prevent="submit">
                        <PaginatedTable
                            :items="filteredDias"
                            :headers="headers"
                        >
                            <template
                                #default="{ item }"
                                class="text-lavender-dark"
                            >
                                <td class="px-6 py-4 font-bold">
                                    {{
                                        new Date(
                                            item.fecha
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td>
                                    <EyeButton
                                        @click="
                                            confirmShow(
                                                item.id,
                                                item.fecha,
                                                item.centro_nombre
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
import PaginatedTable from "@/Components/dashboard_components/PaginatedTable.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { showAlert } from "@/Utils/alerts";
import { ref, computed } from "vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import EyeButton from "@/Components/dashboard_components/EyeButton.vue";
import SelectInput from "@/Components/breeze_components/SelectInput.vue";

// Propiedades - datos recibidos del back
const props = defineProps({
    dias: {
        type: Array,
        required: true,
    },
});

// Datos del formulario
const form = useForm({
    id: "",
});

// Cabeceras de la tabla
const headers = ["Fecha", "Mostrar"];

// Estado para los filtros
const selectedYear = ref("");

// Función para obtener los años disponibles
const availableYears = computed(() => {
    const years = props.dias.map((dia) => new Date(dia.fecha).getFullYear());
    return [...new Set(years)].sort((a, b) => b - a); // Orden descendente
});



// Filtrar los días según el año y el centro seleccionados
const filteredDias = computed(() => {
    return props.dias.filter((dia) => {
        // Extraer el año de la fecha del día
        const diaYear = new Date(dia.fecha).getFullYear();

        // Convertir ambos valores a cadenas para comparar
        const matchesYear =
            !selectedYear.value ||
            String(diaYear) === String(selectedYear.value);

        return matchesYear;
    });
});

// Función para confirmar la selección del día
const confirmShow = (itemId, day, center) => {
    const date = new Date(day).toLocaleDateString();
    const text = `¿Quieres mostrar las reservas del ${date}?`;
    showAlert(() => {
        showDay(itemId);
    }, text);
};

// Función que manda los datos al back para mostrar las reservas del día
const showDay = (itemId) => {
    router.get(route("respon.showPastReservas", { id: itemId }));
};
</script>
