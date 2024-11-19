<template>
    <button
        :class="`inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-lavender-dark uppercase tracking-widest hover:bg-skyblue-vlight  focus:bg-skyblue-light active:bg-skyblue-vlight focus:outline-none focus:ring-2 focus:ring-lavender-light focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 `+bgColor()"
    >
        <slot />
    </button>
</template>
<script setup>

const props=defineProps({
    dark:{
        type:Boolean,
        default:false
    }
})

const bgColor=()=>{
    return props.dark?"bg-lavender-dark":"bg-lightyellow";
}

</script>
