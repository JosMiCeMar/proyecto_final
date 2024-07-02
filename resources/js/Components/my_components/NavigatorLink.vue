<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? "inline-flex items-center rounded-t-lg text-lavender-dark font-bold bg-gradient-to-b from-lightyellow to-skyblue-vlight transition duration-150 ease-in-out"
        : "inline-flex items-center rounded-t-lg  text-skyblue-dark font-bold bg-gradient-to-b from-gray-200 to-gray-400 hover:underline transition duration-150 ease-in-out"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <div class="textura_fondo w-full h-full px-10 py-2 rounded-t-lg">
            <slot />
        </div>
    </Link>
</template>
<style scope>
.textura_fondo {
    background-image: url("/img/bg.png");
    background-repeat: repeat;
}
</style>
