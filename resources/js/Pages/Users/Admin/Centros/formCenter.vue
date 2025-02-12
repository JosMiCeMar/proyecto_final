<template>
    <Head title="Crear Centro Asociado" />
    <AuthenticatedLayout>
        <ContentBox
            title="Añadir centro asociado"
            description="Formulario de creación de centro asociado"
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
                            placeholder="Introduce el nombre del centro"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Componente CcaaSelect -->
                    <CcaaSelect
                        class="mt-4"
                        @updateProvince="updateProvince"
                        @updateTown="updateTown"
                    />
                    <InputError class="mt-2" :message="form.errors.town" />

                    <!-- Dirección -->
                    <div class="mt-4">
                        <InputLabel for="address" value="Dirección" />
                        <TextInput
                            id="address"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.address"
                            autocomplete="address"
                            placeholder="Introduce la dirección"
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
                            placeholder="Introduce el número de teléfono"
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
                            placeholder="Introduce el correo electrónico"
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
                            placeholder="Introduce la web del centro"
                        />
                        <p class="text-lavender-light text-xs">*Opcional</p>
                        <InputError class="mt-2" :message="form.errors.web" />
                    </div>

                    <!-- Localización -->
                    <div class="mt-2">
                        <InputLabel for="location">
                            <div class="flex justify-between items-end">
                                <span>Localización</span>
                                <div class="relative inline-block">
                                    <button
                                        @click.prevent="cleanLocationFormat"
                                        @mouseenter="showTooltip = true"
                                        @mouseleave="showTooltip = false"
                                        class="bg-lime-700 rounded-md shadow-md hover:bg-lime-500 fill-white p-1"
                                    >
                                        <IconMdi
                                            :icon="mdiAutoFix"
                                            :size="28"
                                        />
                                    </button>
                                    <!--Mensaje de ayuda-->
                                    <div
                                        v-if="showTooltip"
                                        class="absolute right-0 bottom-full mb-2 w-max px-3 py-1 bg-lavender-dark text-white text-sm rounded-lg shadow-md border border-skyblue-logo"
                                    >
                                        Pulsar para limpiar formato de Google maps
                                    </div>
                                </div>
                            </div>
                        </InputLabel>
                        <TextInput
                            id="location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.location"
                            autocomplete="location"
                            placeholder="Introduce la localización del centro"
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
                            Agregar Centro
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
import CcaaSelect from "@/Components/centros_components/CcaaSelect.vue";
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
import IconMdi from "@/Components/IconMdi.vue";
import { mdiAutoFix } from "@mdi/js";
import { ref } from "vue";

const showTooltip = ref(false);

const form = useForm({
    name: "",
    address: "",
    tel: "",
    email: "",
    province: "",
    town: "",
    web: "",
    location: "",
});

const updateProvince = (value) => {
    form.province = value;
};

const updateTown = (value) => {
    form.town = value;
};

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
            form.post(route("admin.createCenter"));
        }, `¿Deseas agregar a ${form.name} como nuevo centro asociado?`);
    } else {
        incorrectForm();
    }
};
</script>
