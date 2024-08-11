<template>
    <Head title="Asignar Día" />
    <AuthenticatedLayout>
        <ContentBox
            title="Asignar día a centro"
            description="Formulario para asignar día de trabajo a centro asociado"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent="submit"
                    class="m-4 bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!-- Nombre del Centro -->
                    <div>
                        <InputLabel for="day" value="Fecha Día de Trabajo" />
                        <TextInput
                            id="day"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.day"
                            autofocus
                            autocomplete="day"
                        />
                        <InputError class="mt-2" :message="form.errors.day" />
                    </div>

                    <!-- Select de centros asociados-->
                    <div  class="mt-4">
                        <InputLabel for="center" value="Centro Asociado" />
                        <select
                            id="center"
                            v-model="form.center"
                            class=" w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                        >
                        <option value="">Selecciona un centro asociado</option>
                            <option
                                v-for="(center, index) in centros"
                                :key="index"
                                :value="center.id"
                            >
                                {{ center.nombre }} - {{ center.localidad }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.center"
                        />
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Asignar Día
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import { inject } from "vue";
const swal = inject("$swal");

const props = defineProps({
    centros: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    day: "",
    center: "",
});

function validateForm() {
    const errors = {};

    form.errors = errors;
    return Object.keys(errors).length === 0;
}

const submit = () => {
    if (validateForm()) {
        swal.fire({
            title: "Confirmar Envío",
            text: `¿Quieres asignar a ${form.center} el dia ${form.day}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Enviar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#3A2642",
            cancelButtonColor: "#d33",
            background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
            color: "#3A2642",
            iconColor: "#3A2642",
        }).then((result) => {
            if (result.isConfirmed) {
                //form.post(route("admin.createDias"));
            }
        });
    } else {
        swal.fire({
            icon: "error",
            text: "Completa correctamente el formulario",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3A2642",
            background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
            color: "#3A2642",
            iconColor: "#3A2642",
        });
    }
};
</script>
