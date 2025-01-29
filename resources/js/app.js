import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import axios from "axios";

//Libreria SweetAlert
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

const appName = import.meta.env.VITE_APP_NAME || "Mimate";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        
        // Interceptor de axios, muestra un alerta cuando se alcance el límite de solicitudes
        axios.interceptors.response.use(
            (response) => response,
            (error) => {
                if (error.response && error.response.status === 429) {
                    alert(
                        "Has alcanzado el límite de solicitudes. Por favor, espera un momento y vuelve a intentarlo."
                    );
                }
                return Promise.reject(error); // Se rechaza la promesa después de manejar el error
            }
        );

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueSweetalert2);
        app.mount(el);
        return app;
    },
    progress: {
        color: "#4B5563",
    },
});
