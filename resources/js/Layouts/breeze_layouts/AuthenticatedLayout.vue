<template>
    <div>
        <div class="min-h-screen bg-gradient-to-tl from-lavender-vlight via-skyblue-vlight to-white">
            <!-- Navegador -->
            <nav class="bg-gradient-to-b from-lavender-dark to-skyblue-dark border-b border-lavender-dark shadow-md">
              <UserNav />
            </nav>

            <!-- Cabecera -->
            <header class="bg-skyblue-dark shadow-md" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Contenido -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
<script setup>
import UserNav from '@/Components/breeze_components/UserNav.vue';
</script>