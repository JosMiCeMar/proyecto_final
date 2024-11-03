<template>
    <Head title="Generar Código" />
    <AuthenticatedLayout>
        <ContentBox
            title="Generar Código de Registro"
            description="Este es el código generado para el registro del nuevo usuario"
            :returnLink="route('admin.indexCode')"
            class="text-center"
        >
            <div>
                <p class="text-center my-7">
                    <span
                        ref="texto"
                        @click="copyText"
                        class="justify-center items-center hover:text-skyblue-dark hover:cursor-pointer text-3xl bold text-lavender-dark p-4 bg-gradient-to-t from-lavender-vlight to-white transition ease-in-out duration-300 shadow-md rounded-md"
                    >
                        {{ codigo.codigo }}
                    </span>
                </p>
                <p class="text-xs text-lavender-dark mb-3">
                    *Haz click en el código para copiarlo al portapapeles
                </p>
                <p class="text-lavender-dark text-center">
                    Recuerda, este código es para un nuevo
                    <span v-if="tipo" class="uppercase font-bold">cliente</span>
                    <span v-else class="uppercase font-bold">responsable</span>
                </p>
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head } from "@inertiajs/vue3";
import { inject } from "vue";

const swal = inject("$swal");

const props = defineProps({
    codigo: {
        type: Object,
        required: true,
    },
    tipo: {
        type: Boolean,
        required: true,
    },
});

const copyText = (event) => {
    const texto = event.target.innerText;
    navigator.clipboard
        .writeText(texto)
        .then(() => {
            swal({
                icon: "success",
                text: "Código copiado al portapapeles.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3A2642",
                background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
                color: "#3A2642",
                iconColor: "#3A2642",
            });
        })
        .catch((err) => {
            swal({
                icon: "error",
                text: "El código no puedo ser copiado al portapapeles: " + err,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3A2642",
                background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
                color: "#3A2642",
                iconColor: "#3A2642",
            });
        });
};
</script>
