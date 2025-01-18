<template>
    <Head title="Generar código" />

    <AuthenticatedLayout>
        <ContentBox
            title="Generar código de usuario"
            description="Formulario para la creación de códigos de registro para nuevos usuarios"
            class="text-center"
            :returnLink="route('admin.indexCode')"
        >
            <form
                @submit.prevent="submit"
                class="flex flex-col align-items-center justify-center w-100 mt-4 text-lavender-dark text-lg"
            >
                <p class="text-center font-bold mb-4">
                    Selecciona el rol del nuevo usuario:
                </p>

                <div class="flex items-center justify-center gap-2">
                    <label
                        for="responsable"
                        class="uppercase font-bold hover:underline"
                        >Responsable:</label
                    >
                    <input
                        id="responsable"
                        class="form-radio text-lavender-logo focus:outline-lavender-logo h-5 w-5"
                        type="radio"
                        v-model="form.type"
                        name="type"
                        value="0"
                    />
                </div>
                <p class="text-xs text-center mb-4">
                    *Recuerda crear el nuevo centro asociado antes de
                    proporcionar el código al responsable
                </p>

                <div class="flex items-center justify-center gap-2">
                    <label
                        for="cliente"
                        class="uppercase font-bold hover:underline"
                        >Cliente:</label
                    >
                    <input
                        id="cliente"
                        class="form-radio text-lavender-logo focus:outline-lavender-logo h-5 w-5"
                        type="radio"
                        v-model="form.type"
                        name="type"
                        value="1"
                    />
                </div>
                <InputError
                    class="font-bold text-center"
                    :message="form.errors.type"
                />
                <div class="flex items-center justify-center mt-6">
                    <Button>Generar Código</Button>
                </div>
            </form>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Button from "@/Components/dashboard_components/Button.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import { emptySelectionAlert } from "@/Utils/alerts";

const form = useForm({
    type: "",
});

const submit = () => {
    if (!form.type) {
        emptySelectionAlert();
    } else {
        form.post(route("admin.genCode"));
    }
};
</script>
