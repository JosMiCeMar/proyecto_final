<script setup>
import DangerButton from "@/Components/breeze_components/DangerButton.vue";
import InputError from "@/Components/breeze_components/InputError.vue";
import InputLabel from "@/Components/breeze_components/InputLabel.vue";
import Modal from "@/Components/breeze_components/Modal.vue";
import SecondaryButton from "@/Components/breeze_components/SecondaryButton.vue";
import PasswordInput from "@/Components/breeze_components/PasswordInput.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-bold text-lavender-dark">
                Eliminar Cuenta
            </h2>

            <p class="mt-1 text-skyblue-dark">
                Una vez que se elimine su cuenta, todos sus recursos y datos se
                eliminarán de forma permanente. Antes de eliminar su cuenta,
                descargue cualquier dato o información que desee conservar.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion"
            >Eliminar Cuenta</DangerButton
        >

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-white"
                >
                    ¿Estás seguro de que deseas eliminar la cuenta?
                </h2>

                <p class="mt-1 text-sm text-skyblue-vlight">
                    Una vez que se elimine su cuenta, todos sus recursos y datos
                    se eliminarán de forma permanente. Antes de eliminar su
                    cuenta, descargue cualquier dato o información que desee
                    conservar.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Contraseña"
                        class="sr-only"
                    />

                    <PasswordInput
                        :id="password"
                        v-model="form.password"
                        class="mt-1 block w-3/4"
                        :placeholder="'Contraseña'"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Eliminar Cuenta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
