<script setup>
import AuthenticatedLayout from '@/Layouts/breeze_layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Tu Perfil" />

    <AuthenticatedLayout>
   
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="0 overflow-hidden shadow-md border border-lavender-logo rounded-sm">
                    <div class="p-6 bold text-lavender-dark">Estos son tus datos</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
