<template>
    <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de usuario
        </NavLink>
        <NavLink
            :href="route('respon.indexCode')"
            :active="
                route().current('respon.indexCode') ||
                route().current('respon.createCode') ||
                route().current('respon.listCode')||
                ruta==='/respon_gen_codigo_registro'
            "
        >
            Códigos de registro
        </NavLink>
        <NavLink
            :href="route('respon.indexInforme')"
            :active="
                route().current('respon.indexInforme') ||
                route().current('respon.ultimoMesInforme') ||
                route().current('respon.informeGeneral') ||
                route().current('respon.personalizarInforme') ||
                ruta === '/informe_personalizado'
            "
        >
            Informes
        </NavLink>
        <NavLink
            :href="route('respon.indexReservas')"
            :active="
                route().current('respon.indexReservas') ||
                route().current('respon.listReservas') ||
                route().current('respon.formReservas') ||
                route().current('respon.showReservas') ||
                route().current('respon.modReservas')
            "
        >
            Reservas
        </NavLink>
    </div>
</template>
<script setup>
import NavLink from "@/Components/breeze_components/NavLink.vue";
import { usePage } from "@inertiajs/vue3";

//Constantes para obtener el nombre de la ruta POST y usarlo para mostrar activo su enlace
const page = usePage();
const ruta = page.url;
</script>
