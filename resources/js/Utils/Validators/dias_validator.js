//Funciones para obtener las fechas limite del calendario de dias

const plusYears = 1;

export function getToday() {
    const date = new Date();
    date.setHours(0, 0, 0, 0);

    return date;
}

export function getLastDate() {
    const date = new Date();
    date.setHours(0, 0, 0, 0);

    date.setFullYear(date.getFullYear() + plusYears);

    return date;
}

//Funcion para obtener las fechas no válidas del calendario
export function disabledDates(listDates) {
    let dates = [];

    listDates.forEach((day) => {
        dates.push(new Date(day.fecha));
    });

    //Algoritmo para añadir los sábados y domingos a la lista de dias deshabilitados
    let currentDate = new Date();
    while (currentDate <= getLastDate()) {
        if (currentDate.getDay() === 0 || currentDate.getDay() === 6) {
            // 0 representa el domingo
            dates.push(new Date(currentDate));
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return dates;
}

//Validacion de la fecha, comprueba que la fecha introducida sea valida (limites introducidos y disponibilidad)
export function validateDates(date, lowerLimit, upperLimit, disabledDates) {
    if (isNaN(date.getTime())) {
        return "La fecha es obligatoria";
    } else {
        if (date < lowerLimit) {
            return "La fecha no puede ser inferior al día de hoy";
        }

        if (date > upperLimit) {
            return `La fecha no puede ser superior a más de ${plusYears} año`;
        }

        if (
            disabledDates.some((fecha) => {
                // Compara solo la fecha, ignorando la hora
                return (
                    fecha.getFullYear() === date.getFullYear() &&
                    fecha.getMonth() === date.getMonth() &&
                    fecha.getDate() === date.getDate()
                );
            })
        ) {
            return "La fecha seleccionada no se encuentra disponible";
        }
    }

    return null;
}


//Validacion del centro (id), comprueba que sea un numero entero y que se encuentre en la lista de centros recibida
export function validateCenter(centerId, centerList){
    if (isNaN(parseInt(centerId))) {
       return "El centro es obligatorio";
    } else {
        const arrayIds = [];
        centerList.forEach((center) => {
            arrayIds.push(center.id);
        });
        if (!arrayIds.includes(centerId)) {
            return "El identificador del centro no se encuentra en la lista";
        }
    }

    return null;

}

