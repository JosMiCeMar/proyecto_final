<template>
    <button
        :class="`inline-flex items-center px-4 py-2 border border-transparent rounded-md text-xs uppercase focus:outline-none focus:ring-2 focus:ring-lavender-light focus:ring-offset-2 transition ease-in-out duration-150 `+bgColor()"
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
    return props.dark?"bg-lavender-dark text-white hover:bg-skyblue-dark":"bg-lightyellow text-lavender-dark hover:bg-skyblue-vlight font-bold";
}

</script>
