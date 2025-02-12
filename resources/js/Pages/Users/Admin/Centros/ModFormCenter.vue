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
                        <SelectInput
                            id="province"
                            class="mt-1 block w-full"
                            :optionsArray="provinces"
                            :optionNameProp="'label'"
                            :optionValueProp="'label'"
                            @change="form.town=''"
                            :selected="props.datos.provincia"
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
                        <SelectInput
                            id="town"
                            class="mt-1 block w-full"
                            :optionsArray="towns"
                            :optionNameProp="'label'"
                            :optionValueProp="'label'"
                            :selected="props.datos.localidad"
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
import CcaaService from "@/Services/CcaaService";
import { incorrectForm, sendForm } from "@/Utils/alerts";
import {
    validateName,
    validateEmail,
    validateAddress,
    validatePhone,
    validateUbication,
    validateWeb,
    validatePropInList,
} from "@/Utils/Validators/center_validator";
import SelectInput from "@/Components/breeze_components/SelectInput.vue";
import { onMounted, computed, ref } from "vue";
import IconMdi from "@/Components/IconMdi.vue";
import { mdiAutoFix } from "@mdi/js";

const showTooltip = ref(false);

const props = defineProps({
    datos: {
        type: Object,
        required: true,
    },
});

//Obtención de las pronvincias
const ccaaService = new CcaaService();
const provinces = ccaaService.getProvinces();


const getAllProvinces = async () => {
    await ccaaService.fetchAllProvinces();
};

//Al montar el componente, ejecuta la funcion asíncrona
onMounted(getAllProvinces);



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

const towns = computed(() => {
  // Encuentra la provincia que coincide con el nombre seleccionado
  const province = provinces.value.find(p => p.label === form.province);
  // Retorna los pueblos de la provincia encontrada o un array vacío si no hay coincidencia
  return province ? province.towns : [];
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
    errors.province=validatePropInList(form.province, 'label', provinces, 'provincia');
    errors.town = validatePropInList(form.town, 'label', towns, 'localidad')
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
