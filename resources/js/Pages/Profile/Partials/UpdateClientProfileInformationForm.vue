<template>
    <section>
        <header>
            <h2 class="text-lg font-bold text-lavender-dark">
                Actualizar Tus Datos 
            </h2>

            <p class="mt-1 text-skyblue-dark">
                Formulario para actualizar sus datos de usuario
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
        <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="name"
                    value="Nombre"
                />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="lastname"
                    value="Apellidos"
                />

                <TextInput
                    id="lastname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lastname"
                    required
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="tel"
                    value="Teléfono"
                />

                <TextInput
                    id="tel"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                    required
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.tel" />
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="email"
                    value="Email"
                />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold inline"
                    for="condition"
                    value="Condición especial"
                />

                <Checkbox
                    class="mx-4"
                    id="condition"
                    v-model:checked="form.condicion"
                    name="condicion"
                />
                <p class="text-lavender-dark text-sm">
                    *Consulta la
                    <span
                        class="text-skyblue-dark underline hover:text-skyblue-vlight"
                        @click="medicalConditionAlert"
                        >lista</span
                    >
                    de condiciones médicas especiales.
                </p>
            </div>

            <div>
                <InputLabel
                    class="text-lavender-dark font-semibold"
                    for="date"
                    value="Fecha Nacimiento"
                />
                <Datepicker
                    id="date"
                    v-model="form.fecha"
                    inputFormat="dd-MM-yyyy"
                    :upperLimit="minDate"
                    :lowerLimit="maxDate"
                    :locale="localLanguage"
                    class="w-full border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
                />
                <InputError class="mt-2" :message="form.errors.fecha" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Tu cuenta no está verificada, revisa la bandeja de entrada
                    de tu correo electrónico.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click aquí para volver a enviar el mail de verificación.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    Un nuevo email de verificación ha sido enviado.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton
                    :disabled="form.processing"
                    class="bg-lavender-dark text-skyblue-vlight hover:text-lavender-dark hover:border-lavender-dark"
                    >Guardar cambios</PrimaryButton
                >

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-lavender-dark"
                    >
                        Actualizado
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
<script setup>
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import PrimaryButton from "@/Components/breeze_components/PrimaryButton.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import TextInput from "@/Components/breeze_components/TextInput.vue";
import Checkbox from "@/Components/breeze_components/Checkbox.vue";
import { inject } from "vue";
import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";

//Fecha minima de nacimiento (13 años)
const minDate = new Date();
minDate.setHours(0,0,0,0);
minDate.setFullYear(minDate.getFullYear()-13);


//Fecha maxima de nacimiento (120 años)
const maxDate= new Date();
maxDate.setHours(0,0,0,0);
maxDate.setFullYear(maxDate.getFullYear()-120);

const localLanguage = es;

const swal = inject("$swal");

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const userExtraDates = usePage().props.auth.datos;

const form = useForm({
    name: user.nombre,
    lastname: user.apellidos,
    tel:user.telefono,
    email: user.email,
    fecha: new Date(userExtraDates.fecha_nac),
    condicion: Boolean(userExtraDates.condicion),
});

const medicalConditionAlert = () => {
    swal({
        icon: "question",
        html:
            "<p><b>Te mostraremos una lista donde podrás ver bajo que condiciones deberás marcar esta casilla</b></p></,.?~->" +
            "<ul>" +
            "<li><b>Diabetes:</b> Las personas con diabetes pueden tener una cicatrización más lenta, lo que podría aumentar el riesgo de infecciones o complicaciones post-tratamiento.</li>" +
            "</br><li><b>Epilepsia:</b> La luz del láser podría desencadenar convulsiones en personas con epilepsia fotosensible.</li>" +
            "</br><li><b>Enfermedades autoinmunes:</b> Algunas enfermedades autoinmunes, como el lupus, pueden hacer que la piel sea más sensible al láser y aumentar el riesgo de efectos secundarios.</li>" +
            "</br><li><b>Várices o problemas de circulación:</b> Las personas con problemas de circulación, como várices, deben consultar a un médico antes de realizarse la depilación láser, ya que podría no ser seguro en esas áreas.</li>" +
            "</br><li><b>Desórdenes hormonales:</b> Condiciones como el síndrome de ovario poliquístico (SOP) pueden causar crecimiento excesivo de vello, lo que podría requerir más sesiones de láser o un enfoque específico.</li>" +
            "</br><li><b>Enfermedades de la piel:</b> Condiciones como la psoriasis, el eccema o el vitiligo pueden ser exacerbadas por el tratamiento con láser.</li>" +
            "</ul>",
        footer: "*Este dato solo hará saber al operario que debe preguntar al cliente, no almacenaremos ninguna información al respecto.",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    });
};
</script>
