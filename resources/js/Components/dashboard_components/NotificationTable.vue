<template>
    <template v-if="props.items.length > 0">
        <form @submit.prevent="submit">
            <div
                class="flex gap-2 justify-center items-center bg-skyblue-dark p-1 rounded-t-md"
            >
                <IconMdi :icon="mdiMessageAlert" class="fill-white" />
                <span class="text-lg text-white">Tus notificaciones</span>
            </div>
            <div class="border border-skyblue-dark rounded-b-md">
                <table class="w-full text-lavender-dark">
                    <thead>
                        <tr>
                            <td class="font-bold text-sm px-2">Enviado por</td>
                            <td class="font-bold text-sm">el día</td>
                            <td colspan="2">
                                <div class="flex justify-end">
                                    <button
                                    type="button" 
                                        :disabled="form.checkboxes.length === 0"
                                        class="flex text-sm shadow-sm rounded w-fit gap-1 py-1 px-2 m-1 bg-red-600 items-center cursor-pointer fill-white text-white hover:fill-lavender-vlight hover:text-lavender-vlight disabled:bg-neutral-400 disabled:cursor-not-allowed"
                                        @click="submit"
                                    >
                                        <IconMdi
                                            :icon="mdiDeleteCircle"
                                            :size="20"
                                        />
                                        <span>Borrar</span>
                                    </button>
                                    <button
                                    type="button" 
                                        class="flex text-sm shadow-sm rounded w-fit gap-1 py-1 px-2 m-1 bg-lavender-dark items-center cursor-pointer fill-white text-white hover:fill-skyblue-vlight hover:text-skyblue-vlight"
                                        @click="checkAll()"
                                    >
                                        <IconMdi
                                            :icon="
                                                checkAllButtonValue
                                                    ? mdiCheckboxBlank
                                                    : mdiCheckboxMarked
                                            "
                                            :size="20"
                                        />
                                        <span>
                                            {{
                                                checkAllButtonValue
                                                    ? "Desmarcar todas"
                                                    : "Marcar todas"
                                            }}
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in paginatedItems"
                            :key="item.id"
                            @click="checkThis(item.id)"
                            class="border-b border-lavender-logo hover:bg-purple-300 transition-all ease-in-out duration-500"
                        >
                            <td class="w-fit md:text-nowrap px-2">
                                {{ item.origen }}
                            </td>
                            <td class="w-fit md:text-nowrap px-2">
                                {{ formatDateTime(item.created_at) }}
                            </td>
                            <td class="w-full px-2 py-1">
                                {{ item.mensaje }}
                            </td>
                            <td class="w-fit text-center px-2">
                                <input
                                    type="checkbox"
                                    class="rounded bg-skyblue-light border-lavender-dark text-skyblue-dark shadow-sm focus:ring-lavender-vlight"
                                    :id="'checkbox' + item.id"
                                    :value="item.id"
                                    v-model="form.checkboxes"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Manejo de paginación -->
                <div :class="`flex justify-between items-center p-2`">
                    <button
                        @click="previousPage"
                        type="button"
                        :disabled="currentPage === 1"
                        class="p-1 bg-lavender-dark shadow-md enabled:hover:fill-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded"
                    >
                        <IconMdi
                            :icon="mdiMenuLeft"
                            :size="20"
                            class="fill-white"
                        />
                    </button>
                    <div class="flex space-x-2">
                        <span
                            v-for="page in totalPages"
                            :key="page"
                            @click="currentPage = page"
                            class="w-2 h-2 rounded-full cursor-pointer"
                            :class="
                                currentPage === page
                                    ? 'bg-lavender-dark'
                                    : 'bg-lavender-light'
                            "
                        ></span>
                    </div>
                    <button
                        @click="nextPage"
                        type="button"
                        :disabled="
                            currentPage === totalPages || totalPages === 0
                        "
                        class="p-1 bg-lavender-dark shadow-md enabled:hover:fill-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded"
                    >
                        <IconMdi
                            :icon="mdiMenuRight"
                            :size="20"
                            class="fill-white"
                        />
                    </button>
                </div>
            </div>
            <div class="flex justify-center items-center m-2">
                <InputError :message="form.errors.checkboxes" />
            </div>
        </form>
    </template>
    <template v-else>
        <div class="flex gap-2 justify-center items-center">
            <IconMdi :icon="mdiMessageAlert" class="fill-lavender-dark" />
            <span class="text-lg font-bold text-lavender-dark"
                >No tienes notificaciones</span
            >
        </div>
    </template>
</template>
<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import IconMdi from "../IconMdi.vue";
import {
    mdiMessageAlert,
    mdiMenuLeft,
    mdiMenuRight,
    mdiCheckboxMarked,
    mdiCheckboxBlank,
    mdiDeleteCircle,
} from "@mdi/js";
import { formatDateTime } from "@/Utils/utilsFunctions";
import { validateIdsInList } from "@/Utils/Validators/reports_validator";
import { incorrectForm, deleteAlert } from "@/Utils/alerts";
import InputError from "@/Components/breeze_components/InputError.vue";

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    itemsPerPage: {
        type: Number,
        default: 10,
    },
});

const form = useForm({
    checkboxes: [],
});

//Validaciones del formulario
function validateForm() {
    const errors = {};
    errors.checkboxes = validateIdsInList(form.checkboxes, props.items, "id");
    form.errors = errors;
    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        const text = "¿Quieres borrar las notificaciones seleccionadas?";
        deleteAlert(() => {
            form.post(route("notificaciones.eliminar"), {
                preserveScroll: true,
                onSuccess: () => {
                    form.checkboxes = [];
                },
            });
        }, text);
    } else {
        incorrectForm();
    }
};

// Método para marcar o desmarcar un checkbox
const checkThis = (id) => {
    const index = form.checkboxes.indexOf(id);
    if (index === -1) {
        form.checkboxes.push(id);
    } else {
        form.checkboxes.splice(index, 1);
    }
};

// Computed para saber si se deben marcar o desmarcar todas
const checkAllButtonValue = computed(() => {
    const currentIds = paginatedItems.value.map((item) => item.id);
    return currentIds.every((id) => form.checkboxes.includes(id));
});

const checkAll = () => {
    const currentIds = paginatedItems.value.map((item) => item.id);
    if (checkAllButtonValue.value) {
        form.checkboxes = form.checkboxes.filter(
            (id) => !currentIds.includes(id)
        );
    } else {
        form.checkboxes = [...new Set([...form.checkboxes, ...currentIds])];
    }
};
// Estado para paginación
const currentPage = ref(1);

// Propiedad computada para obtener los items paginados
const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * props.itemsPerPage;
    const end = start + props.itemsPerPage;
    return props.items.slice(start, end);
});

// Propiedad computada para obtener el total de páginas
const totalPages = computed(() => {
    return Math.ceil(props.items.length / props.itemsPerPage);
});

// Métodos para manejar la paginación
const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};
const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};
</script>
