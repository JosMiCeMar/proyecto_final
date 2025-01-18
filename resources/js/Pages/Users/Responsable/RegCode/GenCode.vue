<template>
    <Head title="Generar código" />

    <AuthenticatedLayout>
        <ContentBox
            title="Generar código de registro"
            description="Genera un código de registro para un nuevo cliente"
            class="text-center"
            :returnLink="route('respon.indexCode')"
        >
            <div class="flex items-center justify-center mt-6">
                <Button @click="submit">Generar Código</Button>
            </div>
            <p class="text-xs text-center mt-4 text-lavender-dark">
                *Recuerda: Sólo puedes almacenar 10 códigos de usuario sin usar.
            </p>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head, router } from "@inertiajs/vue3";
import Button from "@/Components/dashboard_components/Button.vue";
import { sendForm } from "@/Utils/alerts";

const submit = () => {
    sendForm(() => {
        router.post(route("respon.storeCode"));
    }, "¿Quieres generar un nuevo código de registro?");
};
</script>
