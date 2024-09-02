<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateAdminProfileInformationForm from "./Partials/UpdateAdminProfileInformationForm.vue";
import UpdateClientProfileInformationForm from "./Partials/UpdateClientProfileInformationForm.vue";
import UpdateRespProfileInformationForm from "./Partials/UpdateRespProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Editar Perfil" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl sm:mx-auto sm:px-6 lg:px-8 pb-3 ml-3">
                <h3 class="text-2xl font-bold text-lavender-dark uppercase">
                    Editar Perfil
                </h3>
                <p class="font-bold text-skyblue-dark">
                    Formularios para actualizar tus datos
                </p>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 textura_fondo shadow-md sm:rounded-lg">
                    <UpdateClientProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>
                <!--Formulario para actualizar contraseña-->
                <div class="p-4 sm:p-8 textura_fondo shadow-md sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>
                <!-- Formulario para eliminar usuario -->
                <div class="p-4 sm:p-8 textura_fondo shadow-md sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
