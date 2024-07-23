<template>
    <Head title="Códigos Registros" />
    <AuthenticatedLayout>
        <ContentBox
            title="Añadir centro asociado"
            description="Formulario de creación de centro asociado"
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
                    <div class="mt-4">
                        <InputLabel for="location" value="Localización" />
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
import { inject } from "vue";
const swal = inject("$swal");

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

function validateFrom() {
    const errors = {};
    const ubicationRegex =/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s,]*)$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9]{9}$/;
    const webRegex = /^(https?:\/\/)?([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,}(\/[a-zA-Z0-9._-]*)*(\?[a-zA-Z0-9=&_]*)?(#[a-zA-Z0-9_-]*)?$/;

    //Validacion nombre
    if (!form.name.trim()) {
        errors.name = "El nombre es obligatorio";
    }

    //Validacion  ubicacion (CCAA, Provincia y Localidad)
    if (!form.province.trim() || !form.town.trim()) {
        errors.town = "La comunidad, provincia y localidad son obligatorias";
    } else {
        if (
            !ubicationRegex.test(form.province) ||
            !ubicationRegex.test(form.town)
        ) {
            errors.town =
                "El formato introducido en provincia o localidad no es correcto";
        }
    }

    //Validar direccion
    if (!form.address.trim()) {
        errors.address = "La dirección es obligatoria";
    }

    //Validación teléfono
    if (!phoneRegex.test(form.tel)) {
        errors.tel = "El teléfono debe tener 9 dígitos";
    }

    //Validación email
    if (form.email.trim()) {
        if (!emailRegex.test(form.email)) {
            errors.email = "El correo electrónico no es válido";
        }
    }

    //Validacion web
    if(form.web.trim()){
        if (!webRegex.test(form.web)) {
            errors.web = "La URL de la web no es válida";
        }
    }

    form.errors = errors;
    return Object.keys(errors).length === 0;
}

const submit = () => {
    if (validateFrom()) {
        form.post(route("admin.createCenter"));
    } else {
        swal({
            icon: "error",
            text: "Completa correctamente el formulario",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3A2642",
            background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
            color: "#3A2642",
            iconColor: "#3A2642",
        });
    }
};
</script>
