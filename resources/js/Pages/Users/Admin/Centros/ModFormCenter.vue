<template>
    <Head title="Centros Asociados" />
    <AuthenticatedLayout>
        <ContentBox
            title="Modificar centro asociado"
            description="Formulario para modificar un centro asociado"
            :returnLink="route('admin.indexCenter')"
        >
            <div class="flex items-center justify-center w-full">
                <form
                    @submit.prevent="submit"
                    class="m-4 bg-gradient-to-t w-full lg:w-[75%] from-lavender-dark to-skyblue-dark rounded-md p-6 shadow-md"
                >
                    <!-- Nombre del Centro -->
                    <div>
                        <InputLabel for="name" value="Nombre del Centro" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!--Provincia-->
                    <div class="mt-4">
                        <InputLabel for="province" value="Provincia" />
                        <TextInput
                            id="province"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.province"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.province"
                        />
                    </div>

                    <!--Localidad-->
                    <div class="mt-4">
                        <InputLabel for="town" value="Localidad" />
                        <TextInput
                            id="town"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.town"
                        />
                        <InputError class="mt-2" :message="form.errors.town" />
                    </div>

                    <!-- Dirección -->
                    <div class="mt-4">
                        <InputLabel for="address" value="Dirección" />
                        <TextInput
                            id="address"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.address"
                            autocomplete="address"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.address"
                        />
                    </div>

                    <!-- Teléfono -->
                    <div class="mt-4">
                        <InputLabel for="tel" value="Teléfono" />
                        <TextInput
                            id="tel"
                            type="tel"
                            class="mt-1 block w-full"
                            v-model="form.tel"
                            maxlength="9"
                            autocomplete="tel"
                        />
                        <InputError class="mt-2" :message="form.errors.tel" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            autocomplete="email"
                        />
                        <p class="text-lavender-light text-xs">*Opcional</p>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Web -->
                    <div class="mt-4">
                        <InputLabel for="web" value="Web" />
                        <TextInput
                            id="web"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.web"
                            autocomplete="web"
                        />
                        <p class="text-lavender-light text-xs">*Opcional</p>
                        <InputError class="mt-2" :message="form.errors.web" />
                    </div>

                    <!-- Localización -->
                    <div class="mt-4">
                        <InputLabel for="location">
                            <div class="flex justify-between items-end">
                                <span>Localización</span>
                                <button
                                    @click.prevent="cleanLocationFormat"
                                    class="bg-lime-700 rounded-md shadow-md hover:bg-lime-500 p-2"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 576 512"
                                        class="fill-white w-4"
                                    >
                                        <path
                                            d="M566.6 54.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192-34.7-34.7c-4.2-4.2-10-6.6-16-6.6c-12.5 0-22.6 10.1-22.6 22.6l0 29.1L364.3 320l29.1 0c12.5 0 22.6-10.1 22.6-22.6c0-6-2.4-11.8-6.6-16l-34.7-34.7 192-192zM341.1 353.4L222.6 234.9c-42.7-3.7-85.2 11.7-115.8 42.3l-8 8C76.5 307.5 64 337.7 64 369.2c0 6.8 7.1 11.2 13.2 8.2l51.1-25.5c5-2.5 9.5 4.1 5.4 7.9L7.3 473.4C2.7 477.6 0 483.6 0 489.9C0 502.1 9.9 512 22.1 512l173.3 0c38.8 0 75.9-15.4 103.4-42.8c30.6-30.6 45.9-73.1 42.3-115.8z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </InputLabel>
                        <TextInput
                            id="location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.location"
                            autocomplete="location"
                        />
                        <p class="text-lavender-light text-xs">*Opcional</p>
                        <InputError
                            class="mt-2"
                            :message="form.errors.location"
                        />
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Modificar Centro
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </ContentBox>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import ContentBox from "@/Components/dashboard_components/ContentBox.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import { incorrectForm, sendForm } from "@/Utils/alerts";
import {
    validateName,
    validateEmail,
    validateLocalization,
    validateAddress,
    validatePhone,
    validateUbication,
    validateWeb,
} from "@/Utils/Validators/center_validator";

const props = defineProps({
    datos: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    id: props.datos.id,
    name: props.datos.nombre,
    address: props.datos.direccion,
    tel: String(props.datos.telefono),
    email: props.datos.email !== null ? props.datos.email : "",
    province: props.datos.provincia || "",
    town: props.datos.localidad || "",
    web: props.datos.web !== null ? props.datos.web : "",
    location: props.datos.ubicacion !== null ? props.datos.ubicacion : "",
});

const cleanLocationFormat = () => {
    if (form.location.trim()) {
        const srcMatch = form.location.match(/src="([^"]+)"/);
        if (srcMatch && srcMatch[1]) {
            form.location = srcMatch[1];
        }
    }
};

function validateForm() {
    const errors = {};

    errors.name = validateName(form.name);
    errors.address = validateAddress(form.address);
    errors.town = validateLocalization(form.province, form.town);
    errors.email = validateEmail(form.email);
    errors.tel = validatePhone(form.tel);
    errors.web = validateWeb(form.web);
    errors.location = validateUbication(form.location);

    form.errors = errors;

    return Object.keys(errors).every((key) => errors[key] === null);
}

const submit = () => {
    if (validateForm()) {
        sendForm(() => {
            form.post(route("admin.updateCenter"));
        }, `¿Quieres modificar los datos de ${form.name}?`);
    } else {
        incorrectForm();
    }
};
</script>
