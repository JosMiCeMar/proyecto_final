<template>
    <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexCode')"
            :active="
                route().current('admin.indexCode') ||
                route().current('admin.genCode') ||
                route().current('admin.delCode')
            "
        >
            Códigos de Registro
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexCenter')"
            :active="
                route().current('admin.indexCenter') ||
                route().current('admin.createCenter') ||
                route().current('admin.listCenter') ||
                route().current('admin.modCenter')
            "
        >
            Centros Asociados
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexZona')"
            :active="
                route().current('admin.indexZona') ||
                route().current('admin.createZona') ||
                route().current('admin.listZona') ||
                route().current('admin.modZona')
            "
        >
            Zonas Tratamiento
        </ResponsiveNavLink>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-skyblue-vlight">
        <div class="px-4">
            <div class="font-medium text-base text-gray-300">
                {{ $page.props.auth.user.nombre }}
                {{ $page.props.auth.user.apellidos }}
            </div>
            <div class="font-medium text-sm text-lavender-vlight">
                {{ $page.props.auth.user.email }}
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('home')">
                Volver al Inicio
            </ResponsiveNavLink>
            <ResponsiveNavLink
                :href="route('profile.edit')"
                :active="route().current('profile.edit')"
            >
                Editar Perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink  @click.prevent="closeSessionAlert" href="#">
                Desconectar
            </ResponsiveNavLink>
        </div>
    </div>
</template>
<script setup>
import ResponsiveNavLink from "@/Components/breeze_components/ResponsiveNavLink.vue";
import { inject } from "vue";
const swal = inject("$swal");

const closeSessionAlert = () => {
    swal.fire({
        title: "¿Estás seguro?",
        text: "¿Deseas cerrar sesión?",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        cancelButtonColor: "#d33",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = route('logout');
        }
    });
};
</script>
