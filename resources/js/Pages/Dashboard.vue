<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import { Head, usePage, Link } from "@inertiajs/vue3";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import DragClientList from "@/Components/DragDropList/DragClientList.vue";
import { ref } from "vue";

const user = usePage().props.auth.user;
const verified = user.email_verified_at !== null;


const lista =ref({
    "9:00": true,
    "9:15": false,
    "9:30": { nombre: 'Ana', apellidos: 'Martínez', zona: 'Brazos', hora:'9:30' },
    "9:45": false,
    "10:00": false,
    "10:15": true,
    "10:30": { nombre: 'Carlos', apellidos: 'Hernández', zona: 'Espalda', hora:'10:30' },
    "10:45": true,
    "11:00": false,
    "11:15": { nombre: 'Lucía', apellidos: 'Gómez', zona: 'Pecho', hora:'11:15' },
    "11:30": true,
    "11:45": false,
    "12:00": { nombre: 'José', apellidos: 'López', zona: 'Abdomen', hora:'12:00' },
    "12:15": true,
    "12:30": false,
    "12:45": { nombre: 'Elena', apellidos: 'Sánchez', zona: 'Piernas', hora:'12:45' },
    "13:00": true,
    "13:15": false,
    "13:30": { nombre: 'Pedro', apellidos: 'Rodríguez', zona: 'Espalda', hora:'13:30' },
    "13:45": false,
    "15:45": true,
    "16:00": { nombre: 'Sara', apellidos: 'Morales', zona: 'Brazos', hora:'16:00' },
    "16:15": false,
    "16:30": true,
    "16:45": { nombre: 'Juan', apellidos: 'Fernández', zona: 'Abdomen', hora:'16:45' },
    "17:00": false,
    "17:15": { nombre: 'Carmen', apellidos: 'García', zona: 'Piernas', hora:'17:15' },
    "17:30": true,
    "17:45": false,
    "18:00": { nombre: 'Luis', apellidos: 'Pérez', zona: 'Pecho', hora:'18:00' },
    "18:15": true,
    "18:30": false,
    "18:45": { nombre: 'Laura', apellidos: 'Díaz', zona: 'Espalda', hora:'18:45' },
    "19:00": true,
    "19:15": false,
    "19:30": { nombre: 'Antonio', apellidos: 'Ramos', zona: 'Abdomen', hora:'19:30' }
});



const actualizarLista = (nuevaLista) => {
    lista.value = nuevaLista;
};
</script>

<template>
    <Head title="Panel de Usuario" />

    <AuthenticatedLayout>
        <ContentBox
            :title="'Bienvenid@ ' + user.nombre"
            description="Estos son los datos a tener en cuenta hoy"
        >
            <p
                v-show="!verified"
                class="bg-red-600 p-2 m-2 text-center text-white text-sm rounded-md shadow-md"
            >
                <span class="font-bold">IMPORTANTE:</span> Tu perfil aún no se
                ha verificado, si no encuentras el mensaje de verificación en tu
                bandeja, pulsa
                <Link
                    :href="route('verification.notice')"
                    class="font-bold underline hover:text-skyblue-vlight transition-all"
                    >AQUÍ</Link
                >
            </p>

            <DragClientList
                :list="lista"
                @mod_list="actualizarLista"
            />
        </ContentBox>

        {{ $page.props }}
    </AuthenticatedLayout>
</template>
