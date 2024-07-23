<script setup>
import ApplicationLogo from '@/Components/IconMarca.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    formName:{
        type:String,
        required:false
    }
})
</script>

<template>
    <div class="min-h-screen pb-10 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-tl from-lavender-vlight via-skyblue-vlight to-white">
        <div class="pt-10">
            <Link :href="route('home')">
                <ApplicationLogo class="w-20 h-20 fill-skyblue-dark hover:fill-lavender-logo transition-colors ease-in-out" />
            </Link>
        </div>
        <h3 v-if="formName" class="text-center uppercase text-lg text-lavender-dark mt-6 mb-2">{{ formName }}</h3>
        <div
            class="w-full sm:max-w-md px-6 py-4 bg-gradient-to-t from-lavender-dark to-skyblue-dark  shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
