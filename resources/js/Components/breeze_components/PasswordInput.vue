<template>
    <div
        class="border border-lavender-dark bg-blue-100 text-lavender-dark rounded-md shadow-sm flex items-center justify-between focus-within:border-lavender-light focus-within:ring-1 focus-within:ring-lavender-light"
    >
        <input
            :id="props.id"
            :type="passwordVisible ? 'text' : 'password'"
            class="bg-transparent outline-none border-none focus:outline-none focus:border-none appearance-none shadow-none w-full px-3 py-2"
            v-model="model"
            ref="input"
            :autocomplete="props.autocomplete"
            :placeholder="props.placeholder"
            style="outline: none !important; border: none !important; box-shadow: none !important;"
        />
        <button
            type="button"
            @click="togglePasswordVisibility()"
            class="px-3 fill-lavender-dark focus:outline-none"
        >
            <IconMdi :icon="passwordVisible ? mdiEye : mdiEyeOff"/>  
        </button>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import IconMdi from '@/Components/IconMdi.vue';
import { mdiEye, mdiEyeOff } from '@mdi/js';

const props=defineProps({
    id:{
        type:String,
        required:true
    },
    placeholder:{
        type:String,
        default:''
    },
    autocomplete:{
        type:String,
        default:'current-password'
    }
})

const model = defineModel({
    type: [String, Number],
    required: true,
});

const input = ref(null);
const passwordVisible = ref(false);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};
</script>
