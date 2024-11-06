<script setup>
import GuestLayout from '@/Layouts/breeze_layouts/GuestLayout.vue';
import InputError from '@/Components/breeze_components/InputError.vue';
import InputLabel from '@/Components/breeze_components/InputLabel.vue';
import PrimaryButton from '@/Components/breeze_components/PrimaryButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import PasswordInput from '@/Components/breeze_components/PasswordInput.vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirmar Contraseña" />

        <div class="mb-4 text-sm text-skyblue-vlight">
            Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Password" />
                <PasswordInput
                    :id="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    :autocomplete="'current-password'"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirmar
                </PrimaryButton>
            </div>
        </form>
        <p class="mt-4 text-end text-xs text-skyblue-vlight  hover:text-skyblue-light hover:underline">
            <Link :href="route('home')">
            Volver a página principal
            </Link>
        </p>
    </GuestLayout>
</template>
