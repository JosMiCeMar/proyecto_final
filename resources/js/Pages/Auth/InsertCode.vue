<script setup>
import GuestLayout from '@/Layouts/breeze_layouts/GuestLayout.vue';
import InputError from '@/Components/breeze_components/InputError.vue';
import InputLabel from '@/Components/breeze_components/InputLabel.vue';
import PrimaryButton from '@/Components/breeze_components/PrimaryButton.vue';
import TextInput from '@/Components/breeze_components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


const form = useForm({
    code: ''
});


const submit = () => {
    form.post(route('cod_registro.check'), {
        onFinish: () => form.reset('code'),
    });
};


</script>

<template>
    <GuestLayout>

        <Head title="Registrarse" />
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="code" value="Código:" />

                <TextInput id="code" type="text" class="mt-1 block w-full text-center" v-model="form.code" required autofocus
                    placeholder="Introduce el código de registro"  maxlength="8"/>

                <InputError class="mt-2" :message="form.errors.code" />
                <InputError v-if="$page.props.errors.error" class="mt-2" :message="$page.props.errors.error[0]" />
            </div>
            <div class="mt-4 flex justify-between">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    ¿Ya estás registrad@?
                </Link>
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Usar Código
                </PrimaryButton>
            </div>

        </form>

        <div class=" text-xs">
            <p class="text-center mt-4 text-lavender-vlight">
                *El código te ha debido ser proporcionado por el responsable del centro o empleado de Mímate.<br>
                Consta de 8 caracteres alfanuméricos<br>
                Ejemplo: AbCd1234
            </p>
            <p class="mt-4 text-end text-skyblue-vlight hover:text-skyblue-light hover:underline">
                <Link  :href="route('home')">
                    Volver a página principal
                </Link>
            </p>
        </div>
    </GuestLayout>
</template>