import Swal from "sweetalert2";

// Función para mostrar la alerta de las condiciones médicas
export function medicalConditionAlert() {
    Swal.fire({
        icon: "question",
        html:
            "<p><b>Te mostraremos una lista donde podrás ver bajo qué condiciones deberás marcar esta casilla</b></p>" +
            "<ul>" +
            "</br><li><b>Diabetes:</b> Las personas con diabetes pueden tener una cicatrización más lenta, lo que podría aumentar el riesgo de infecciones o complicaciones post-tratamiento.</li>" +
            "</br><li><b>Epilepsia:</b> La luz del láser podría desencadenar convulsiones en personas con epilepsia fotosensible.</li>" +
            "</br><li><b>Enfermedades autoinmunes:</b> Algunas enfermedades autoinmunes, como el lupus, pueden hacer que la piel sea más sensible al láser y aumentar el riesgo de efectos secundarios.</li>" +
            "</br><li><b>Várices o problemas de circulación:</b> Las personas con problemas de circulación, como várices, deben consultar a un médico antes de realizarse la depilación láser, ya que podría no ser seguro en esas áreas.</li>" +
            "</br><li><b>Desórdenes hormonales:</b> Condiciones como el síndrome de ovario poliquístico (SOP) pueden causar crecimiento excesivo de vello, lo que podría requerir más sesiones de láser o un enfoque específico.</li>" +
            "</br><li><b>Enfermedades de la piel:</b> Condiciones como la psoriasis, el eccema o el vitiligo pueden ser exacerbadas por el tratamiento con láser.</li>" +
            "</br><li><b>Ante cualquier duda:</b> Si no conoces con seguridad si tu problema puede verse afectado por el tratamiento.</li>" +
            "</ul>",
        footer: "*Este dato solo hará saber al operario que debe preguntar al cliente, no almacenaremos ninguna información al respecto.",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    });
}

// Función para mostrar la alerta del envio de formulario
export function sendForm(executeMethod, message) {
    Swal.fire({
        title: "Confirmar Envío",
        text: message,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        cancelButtonColor: "#d33",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            executeMethod();
        }
    });
}


// Función para mostrar la alerta de formulario incorrecto
export function incorrectForm() {
    Swal.fire({
        icon: "error",
        title: "Error en el formulario",
        text: "Introduzca los datos correctamente según las indicaciones.",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#DC2626",
    });
}

// Función para mostrar la alerta de cerrado de sesión
export function closeSession() {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¿Deseas cerrar sesión?",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        cancelButtonColor: "#d33",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = route("logout");
        }
    });
}

export function showAlert(executeMethod, text) {
    Swal.fire({
        title: text,
        text: "Se redigirá a una nueva página para mostrar la información",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, mostrarlo",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            executeMethod();
        }
    });
}

// Función para mostrar la alerta de eliminación
export function deleteAlert(executeMethod, text) {
    Swal.fire({
        title: text,
        text: "No podrás revertir esto",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            executeMethod();
        }
    });
}

// Función para mostrar la alerta de modificación
export function modAlert(executeMethod, text) {
    Swal.fire({
        title: text,
        text: "Se mostrará un formulario donde cambiar los datos",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, modificarlo",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            executeMethod();
        }
    });
}


// Función para mostrar la alerta de seleccion vacía
export function emptySelectionAlert() {
    Swal.fire({
        icon: "error",
        text: "Debes seleccionar una de las opciones",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#3A2642",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
        iconColor: "#DC2626",
    });
}
//Funcion para copiar texto al portapapeles y mostrar una alerta
export function copyText(event) {
    const texto = event.target.innerText;
    navigator.clipboard
        .writeText(texto)
        .then(() => {
            swal({
                icon: "success",
                text: "Código copiado al portapapeles.",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3A2642",
                background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
                color: "#3A2642",
                iconColor: "#3A2642",
            });
        })
        .catch((err) => {
            swal({
                icon: "error",
                text: "El código no puedo ser copiado al portapapeles: " + err,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3A2642",
                background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
                color: "#3A2642",
                iconColor: "#3A2642",
            });
        });
}
