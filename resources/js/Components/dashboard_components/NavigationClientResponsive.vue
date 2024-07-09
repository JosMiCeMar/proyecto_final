<template>

    <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('home')"
        >
            Cliente
        </ResponsiveNavLink>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-skyblue-vlight">
        <div class="px-4">
            <div
                class="font-medium text-base text-white"
            >
                {{ $page.props.auth.user.nombre }}
                {{ $page.props.auth.user.apellidos }}
            </div>
            <div class="font-medium text-sm text-lavender-vlight">
                {{ $page.props.auth.user.email }}
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('profile.edit')"  :active="route().current('profile.edit')">
                Editar Perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink
                :href="route('logout')">
                Desconectar
            </ResponsiveNavLink>
        </div>
    </div>
</template>
<script setup>
import ResponsiveNavLink from '@/Components/breeze_components/ResponsiveNavLink.vue';
</script>
