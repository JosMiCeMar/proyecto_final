<template>
    <div class="pt-4 pb-2 border-b border-skyblue-vlight">
        <div class="px-4 text-center">
            <div class="font-medium text-base text-white">
                {{ $page.props.auth.user.nombre }}
                {{ $page.props.auth.user.apellidos }}
            </div>
            <div class="font-medium text-sm text-lavender-vlight">
                {{ $page.props.auth.user.email }}
            </div>
        </div>
    </div>

    <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('client.indexCitas')"
            :active="
                route().current('client.indexCitas') ||
                route().current('client.createCitas') ||
                route().current('client.createHoraCitas') ||
                route().current('client.storeHoraCitas') ||
                route().current('client.tableCitas') ||
                route().current('client.modReser') ||
                route().current('client.modHoraReser')
            "
        >
            Mis Citas
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('client.indexTratamientos')"
            :active="
                route().current('client.indexTratamientos') ||
                route().current('client.ultimosTratamientos') ||
                route().current('client.informeTratamientos') ||
                route().current('client.personalizarInforme') ||
                route().current('client.mostrarInforme')
            "
        >
            Mis Tratamientos
        </ResponsiveNavLink>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-1 pb-1 border-t border-skyblue-vlight">
        <div class="mt-3 space-y-1">
            <ResponsiveNavLink
                :href="route('client.profileEdit')"
                :active="route().current('client.profileEdit')"
            >
                Editar Perfil
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
</script>
