<script setup>
import GuestLayout from '@/Layouts/breeze_layouts/GuestLayout.vue';
import InputError from '@/Components/breeze_components/InputError.vue';
import InputLabel from '@/Components/breeze_components/InputLabel.vue';
import PrimaryButton from '@/Components/breeze_components/PrimaryButton.vue';
import TextInput from '@/Components/breeze_components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/breeze_components/Checkbox.vue';

const form = useForm({
    name: '',
    lastname: '',
    tel: '',
    email: '',
    fecha: '',
    condicion:false,
    password: '',
    password_confirmation: '',
});

function edadMinima() {
    const hoy = new Date();
    const anio = hoy.getFullYear() - 13;
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const dia = String(hoy.getDate()).padStart(2, '0');
    return `${anio}-${mes}-${dia}`;
}

const submit = () => {
    form.post(route('cliente.create'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Registro de Clientes" />
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" placeholder="Introduce tu nombre" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="lastname" value="Apellidos" />

                <TextInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required
                    autocomplete="name" placeholder="Introduce tus apellidos" />
                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

            <div class="mt-4">
                <InputLabel for="tel" value="Teléfono" />

                <TextInput id="tel" type="tel" class="mt-1 block w-full" v-model="form.tel" maxlength="9" required
                    autocomplete="tel" placeholder="Introduce tu número de teléfono" />

                <InputError class="mt-2" :message="form.errors.tel" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="email" placeholder="Introduce tu correo electrónico" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="fecha" value="Fecha Nacimiento" />
                <TextInput id="fecha" type="date" class="mt-1 block w-full" v-model="form.fecha" :max="edadMinima()"
                    required />
                <InputError class="mt-2" :message="form.errors.fecha" />
            </div>

            <div class="mt-4">
                <InputLabel class="inline" for="condicion" value="Posees una condición médica especial:" />
                <Checkbox class="mx-4" id="condicion" v-model:checked="form.condicion" name="condicion" />
                <p class="text-lavender-light text-sm">*Consulta la
                    <a class="text-skyblue-light underline hover:text-skyblue-vlight" :href="route('home')" target="_blank"
                       >lista</a> de condiciones médicas especiales.
                </p>
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" placeholder="Introduce la contraseña" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password"
                    placeholder="Vuelve a introducir la contraseña" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
