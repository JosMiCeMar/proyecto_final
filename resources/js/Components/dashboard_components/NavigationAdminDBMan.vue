<template>
    <div class="hidden sm:flex sm:gap-4 shadow-md bg-skyblue-dark px-10 ">
        <DropNavLink class="mx-2 py-2"
            :href="route('admin.indexCode')"
            :active="
                route().current('admin.indexCode') ||
                route().current('admin.genCode') ||
                route().current('admin.delCode')
            "
        >
            Códigos de registro
        </DropNavLink>
        <DropNavLink class="mx-2 py-2"
            :href="route('admin.indexCenter')"
            :active="
                route().current('admin.indexCenter') ||
                route().current('admin.createCenter') ||
                route().current('admin.listCenter') ||
                route().current('admin.modCenter')
            "
        >
            Centros asociados
        </DropNavLink>
        <DropNavLink class="mx-2 py-2"
        :href="route('admin.indexZona')"
        :active="route().current('admin.indexZona')||
                route().current('admin.createZona') ||
                route().current('admin.listZona') ||
                route().current('admin.modZona')">
            Zonas tratamiento
        </DropNavLink>
        <DropNavLink class="mx-2 py-2"
        :href="route('admin.indexDias')"
        :active="route().current('admin.indexDias')||
                route().current('admin.createDias') ||
                route().current('admin.listDias') ||
                route().current('admin.modDiass')">
            Días asignados
        </DropNavLink>
    </div>
</template>
<script setup>
import DropNavLink from '@/Components/breeze_components/DropNavLink.vue';

</script>
