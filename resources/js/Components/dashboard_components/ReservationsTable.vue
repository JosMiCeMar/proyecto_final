<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col md:flex-row justify-center gap-8 py-8">
            <!-- Tabla de la mañana -->
            <div class="flex w-full">
                <table class="w-full text-center h-fit">
                    <thead
                        class="bg-gradient-to-t from-lavender-dark to-skyblue-dark text-white"
                    >
                        <tr>
                            <td
                                :colspan="props.editable ? '4' : '2'"
                                class="p-2"
                            >
                                <span
                                    class="flex gap-2 items-center justify-center h-full text-lg"
                                >
                                    <IconMdi
                                        :icon="mdiWeatherSunny"
                                        class="fill-yellow-400"
                                    />
                                    <span>Mañana</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2">Hora</td>
                            <td class="p-2">Reserva</td>
                            <td v-show="props.editable" class="p-2">
                                Modificar
                            </td>
                            <td v-show="props.editable" class="p-2">
                                Eliminar
                            </td>
                        </tr>
                    </thead>
                    <tbody class="text-lavender-dark bg-white">
                        <tr
                            v-for="(item, index) in props.morningData"
                            :key="index"
                            :class="`border-b border-lavender-logo ${
                                typeof item === 'object'
                                    ? 'bg-fuchsia-200'
                                    : 'bg-white'
                            } hover:bg-blue-100 transition-all ease-in-out duration-500`"
                        >
                            <template v-if="typeof item === 'object'">
                                <td class="p-2">
                                    {{ formatHour(item.hora_inicio) }} -
                                    {{ formatHour(item.hora_fin) }}
                                </td>
                                <td class="p-2 text-sm">
                                    <div class="flex flex-col w-full">
                                        <span class="font-semibold"
                                            >{{ item.cliente_nombre }}
                                            {{ item.cliente_apellidos }}</span
                                        >
                                        <span>{{
                                            capitalizeFirstChart(
                                                item.zona_nombre
                                            )
                                        }}</span>
                                        <span class="flex gap-1 items-center justify-center"><IconMdi :icon="mdiPhone" :size="15"/>{{ item.cliente_telefono }}</span>
                                    </div>
                                </td>
                                <td v-show="props.editable">
                                    <div
                                        class="flex justify-center items-center"
                                    >
                                        <ModButton
                                            @click.prevent="
                                                confirmMod(
                                                    item.id,
                                                    item.cliente_nombre,
                                                    item.zona_nombre
                                                )
                                            "
                                        />
                                    </div>
                                </td>
                                <td v-show="props.editable">
                                    <div
                                        class="flex justify-center items-center"
                                    >
                                        <TrashButton
                                            @click.prevent="
                                                confirmDelete(
                                                    item.id,
                                                    item.cliente_nombre,
                                                    item.zona_nombre
                                                )
                                            "
                                        />
                                    </div>
                                </td>
                            </template>
                            <template v-else>
                                <td class="p-4">
                                    {{ item }}
                                </td>
                                <td class="p-4">Sin reserva</td>
                                <td v-show="props.editable" colspan="2"></td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Tabla de la tarde -->
            <div class="flex w-full h-fit">
                <table class="w-full text-center">
                    <thead
                        class="bg-gradient-to-t from-lavender-dark to-skyblue-dark text-white"
                    >
                        <tr>
                            <td
                                :colspan="props.editable ? '4' : '2'"
                                class="p-2"
                            >
                                <span
                                    class="flex gap-2 items-center justify-center h-full text-lg"
                                >
                                    <IconMdi
                                        :icon="mdiWeatherSunset"
                                        class="fill-orange-400 inline justify-center items-center"
                                    />
                                    <span>Tarde</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2">Hora</td>
                            <td class="p-2">Reserva</td>
                            <td v-show="props.editable" class="p-2">
                                Modificar
                            </td>
                            <td v-show="props.editable" class="p-2">
                                Eliminar
                            </td>
                        </tr>
                    </thead>
                    <tbody class="text-lavender-dark bg-white">
                        <tr
                            v-for="(item, index) in props.afternoonData"
                            :key="index"
                            :class="`border-b border-lavender-logo ${
                                typeof item === 'object'
                                    ? 'bg-fuchsia-200'
                                    : 'bg-white'
                            } hover:bg-blue-100 transition-all ease-in-out duration-500`"
                        >
                            <template v-if="typeof item === 'object'">
                                <td class="p-2">
                                    {{ formatHour(item.hora_inicio) }} -
                                    {{ formatHour(item.hora_fin) }}
                                </td>
                                <td class="p-2">
                                    <div class="flex flex-col w-full">
                                        <span class="font-semibold"
                                            >{{ item.cliente_nombre }}
                                            {{ item.cliente_apellidos }}</span
                                        >
                                        <span>{{
                                            capitalizeFirstChart(
                                                item.zona_nombre
                                            )
                                        }}</span>
                                    </div>
                                </td>
                                <td v-show="props.editable">
                                    <div
                                        class="flex justify-center items-center"
                                    >
                                        <ModButton
                                            @click.prevent="
                                                confirmMod(
                                                    item.id,
                                                    item.cliente_nombre,
                                                    item.zona_nombre
                                                )
                                            "
                                        />
                                    </div>
                                </td>
                                <td v-show="props.editable">
                                    <div
                                        class="flex justify-center items-center"
                                    >
                                        <TrashButton
                                            @click.prevent="
                                                confirmDelete(
                                                    item.id,
                                                    item.cliente_nombre,
                                                    item.zona_nombre
                                                )
                                            "
                                        />
                                    </div>
                                </td>
                            </template>
                            <template v-else>
                                <td class="p-4">
                                    {{ item }}
                                </td>
                                <td class="p-4">Sin reserva</td>
                                <td v-show="props.editable" colspan="2"></td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            v-show="form.errors.id"
            class="bg-red-500 rounded-md text-center text-white font-bold text-lg"
        >
            <p>{{ form.errors.id }}</p>
        </div>
    </form>
</template>

<script setup>
import IconMdi from "@/Components/IconMdi.vue";
import { mdiPhone, mdiWeatherSunny, mdiWeatherSunset } from "@mdi/js";
import { formatHour, capitalizeFirstChart } from "@/Utils/utilsFunctions";
import ModButton from "@/Components/dashboard_components/ModButton.vue";
import TrashButton from "@/Components/dashboard_components/TrashButton.vue";
import { router, useForm } from "@inertiajs/vue3";
import { deleteAlert, modAlert } from "@/Utils/alerts";

const props = defineProps({
    morningData: {
        type: Array,
        required: true,
    },
    afternoonData: {
        type: Array,
        required: true,
    },
    editable: {
        type: Boolean,
        default: false,
    },
    idDay: {
        type: Number,
        required: true,
    },
    routeMod: {
        type: String,
        required: false,
    },
    routeDel: {
        type: String,
        required: false,
    },
});

//Datos formulario
const form = useForm({
    id_reservation: "",
    id_day: props.idDay,
});

//Funcion para confirmar el borrado
const confirmDelete = (itemId, client, zone) => {
    const zoneCapitalized = capitalizeFirstChart(zone);
    const text = `¿Seguro que quieres eliminar la reserva de ${client} para la zona ${zoneCapitalized}?`;

    deleteAlert(() => {
        deleteReservation(itemId);
    }, text);
};

//Funcion para confirmar la modificacion
const confirmMod = (itemId, client, zone) => {
    const zoneCapitalized = capitalizeFirstChart(zone);
    const text = `¿Seguro que quieres modificar la reserva de ${client} para la zona ${zoneCapitalized}?`;
    modAlert(() => {
        modReservation(itemId);
    }, text);
};

//Funcion que manda los datos al back para su borrado
const deleteReservation = (itemId) => {
    form.id_reservation = itemId;
    form.post(route(props.routeDel));
};

//Funcion que manda los datos al back para mostrar el formulario de modificacion
const modReservation = (itemId) => {
    router.get(
        route(props.routeMod, { id_dia: form.id_day, id_reserva: itemId })
    );
};
</script>
