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
                :active="route().current('dashboard')"
            >
                Responsable
            </ResponsiveNavLink>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div
                    class="font-medium text-base text-gray-800 dark:text-gray-200"
                >
                    {{ $page.props.auth.user.nombre }}
                    {{ $page.props.auth.user.apellidos }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ $page.props.auth.user.email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <ResponsiveNavLink :href="route('profile.edit')">
                    Editar Perfil
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                >
                    Desconectar
                </ResponsiveNavLink>
            </div>
        </div>
</template>
<script setup>
import ResponsiveNavLink from '@/Components/breeze_components/ResponsiveNavLink.vue';
</script>
