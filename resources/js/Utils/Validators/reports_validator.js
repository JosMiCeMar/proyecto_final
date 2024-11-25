//Función para valida que una lista de id se encuentre en otra lista de referencia
export function validateIdsInList(ids, array, nameOfData) {
    
    if (ids.length === 0) {
        return `El campo ${nameOfData} es obligatorio`;
    }

    if (!Array.isArray(ids)) {
        return `El dato recibido no es una lista`;
    }

    const invalidIds = ids.filter((id) => isNaN(parseInt(id)));
    if (invalidIds.length > 0) {
        return `Se ha recibido algún tipo de dato inválido`;
    }

    // Comprobar que todos los IDs existan en la lista de referencia
    const missingIds = ids.filter((id) => !array.some((item) => item.id === id));
    if (missingIds.length > 0) {
        return `Se ha recibido algún dato que no se encuentra en la lista`;
    }

    // Si todo es válido, devolver null
    return null;
}

//Funcion para comprobar que el campo periodo de tiempo es un booleano (meses-true, años-false)
export function validatePeriod(value, nameOfData) {
    if (typeof value !== "boolean") {
        return `El campo ${nameOfData} es obligatorio.`;
    }

    return null;
}

//Funcion para validar el rango de fechas
export function validateDateRange(startDate, endDate) {
    if (startDate === null || endDate === null) {
        return `Ambas fechas son obligatorias.`;
    }

    const start = new Date(startDate);
    start.setHours(0,0,0,0);
    const end = new Date(endDate);
    end.setHours(0,0,0,0);
    const today=new Date();

    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
        return `Ambas fechas deben ser válidas.`;
    }

    if(start.getFullYear()<2015||end.getFullYear()<2015){
        return `El año no puede ser inferior a 2015`;
    }

    if(start>today||end>today){
        return `Las fechas no pueden superar el día de hoy`;
    }

    if (start >= end) {
        return `La fecha de inicio no puede ser igual o posterior a la fecha final`;
    }

    return null;
}
