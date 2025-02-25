<template>
    <div class="pt-2 pb-3 space-y-1">
        <div class="px-4 text-center">
            <div class="font-medium text-base text-skyblue-vlight">
                {{ $page.props.auth.user.nombre }}
                {{ $page.props.auth.user.apellidos }}
            </div>
            <div class="font-medium text-sm text-lavender-vlight">
                {{ $page.props.auth.user.email }}
            </div>
        </div>
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de usuario
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('respon.indexCode')"
            :active="
                route().current('respon.indexCode') ||
                route().current('respon.createCode') ||
                route().current('respon.listCode')||
                ruta==='/respon_gen_codigo_registro'
            "
        >
            Códigos de registro
        </ResponsiveNavLink>
        <ResponsiveNavLink
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
        </ResponsiveNavLink>
        <ResponsiveNavLink
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
        </ResponsiveNavLink>
    </div>
    <div class="pt-2 pb-3 space-y-1 border-t border-skyblue-vlight">
        <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('home')">
                Volver al inicio
            </ResponsiveNavLink>
            <ResponsiveNavLink
                :href="route('respon.profileEdit')"
                :active="route().current('respon.profileEdit')"
            >
                Editar perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink @click.prevent="closeSession()">
                Desconectar
            </ResponsiveNavLink>
        </div>
    </div>
</template>
<script setup>
import ResponsiveNavLink from "@/Components/breeze_components/ResponsiveNavLink.vue";
import { closeSession } from "@/Utils/alerts";
import { usePage } from "@inertiajs/vue3";

//Constantes para obtener el nombre de la ruta POST y usarlo para mostrar activo su enlace
const page = usePage();
const ruta = page.url;
</script>
