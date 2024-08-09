<template>
    <div class="flex gap-4">
        <DropNavLink
            :href="route('admin.indexCode')"
            :active="
                route().current('admin.indexCode') ||
                route().current('admin.genCode') ||
                route().current('admin.delCode')
            "
        >
            Códigos de Registro
        </DropNavLink>
        <DropNavLink
            :href="route('admin.indexCenter')"
            :active="
                route().current('admin.indexCenter') ||
                route().current('admin.createCenter') ||
                route().current('admin.listCenter') ||
                route().current('admin.modCenter')
            "
        >
            Centros Asociados
        </DropNavLink>
        <DropNavLink
        :href="route('admin.indexZona')"
        :active="route().current('admin.indexZona')||
                route().current('admin.createZona') ||
                route().current('admin.listZona') ||
                route().current('admin.modZona')">
            Zonas Tratamiento
        </DropNavLink>
    </div>
</template>
<script setup>
import DropNavLink from '@/Components/breeze_components/DropNavLink.vue';

</script>
