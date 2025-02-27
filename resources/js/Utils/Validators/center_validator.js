//Validacion nombre
export function validateName(name) {
    const nameRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s]*)$/;

    if (!name.trim()) {
        return "El nombre es obligatorio";
    }

    if (!nameRegex.test(name)) {
        return "El nombre sólo puede contener letras, números y espacios";
    }

    if (name.length > 255) {
        return "El nombre no puede superar los 255 caracteres";
    }

    return null;
}

//Validacion direccion
export function validateAddress(address) {
    const addressRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9]+(?:[-/'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s]*)$/;

    if (!address.trim()) {
        return "La dirección es obligatoria";
    }

    if (!addressRegex.test(address)) {
        return "La dirección sólo puede contener letras, números y espacios";
    }

    return null;
}

//Validacion  ubicacion (Provincia y Localidad)
export function validateLocalization(province, town) {
    const localizationRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s,/]*)$/;

    if (!province.trim() || !town.trim()) {
        return "La comunidad, provincia y localidad son obligatorias";
    }

    if (!localizationRegex.test(province) || !localizationRegex.test(town)) {
        return "El formato introducido en provincia o localidad no es correcto";
    }

    return null;
}

//Validacion para comprobar que un objeto tenga una propiedad con x valor en una lista
export function validatePropInList(name, prop, list, dataName) {

    if(name===''){
        return `El campo ${dataName} es obligatorio`;
    }

    if (!list || typeof list !== "object" || Object.keys(list).length === 0) {
        return "La lista está vacía o no es válida.";
    }

    if (list.value.find(item => item && item[prop] === name)) {
        return null;
    }

    return `El nombre "${name}" no se encuentra en la lista.`; // Si no se encuentra
}

//Validacion para pagina telefono
export function validatePhone(phone) {
    const phoneRegex = /^[0-9]{9}$/;
    if (!phone.trim()) {
        return "El teléfono es obligatorio";
    }

    if (!phoneRegex.test(phone)) {
        return "El teléfono debe tener 9 dígitos";
    }

    return null;
}

//Validacion para pagina email - NO OBLIGATORIO
export function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email.trim()) {
        if (!emailRegex.test(email)) {
            return "El correo electrónico no es válido";
        }
    }

    return null;
}

//Validacion para pagina web - NO OBLIGATORIA
export function validateWeb(web) {
    const webRegex =
        /^(https?:\/\/)?([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,}(\/[a-zA-Z0-9._-]*)*(\?[a-zA-Z0-9=&_]*)?(#[a-zA-Z0-9_-]*)?$/;

    if (web.trim()) {
        if (!webRegex.test(web)) {
            return "La URL de la web no es válida";
        }
    }

    return null;
}

//Validacion para ubicacion en google maps - NO OBLIGATORIA
export function validateUbication(url) {
    const ubicationRegex =
        /^https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]+$/;
    if (url.trim()) {
        if (!ubicationRegex.test(url)) {
            return "La URL de la localización no es válida";
        }
    }
    return null;
}
