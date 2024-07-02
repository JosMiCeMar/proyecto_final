<script>
export default {
  props: {
    datos: String,
    hash: String,
    verificar:Boolean
  }
};
</script>

<template>

    <div class="bg-gradient-to-t from-skyblue-vlight via-lavender-vlight to-white min-h-screen min-w-screen">

        <p>{{ datos }}</p>
        <p>{{ hash }}</p>
        <p>{{ verificar }}</p>
    </div>

</template>