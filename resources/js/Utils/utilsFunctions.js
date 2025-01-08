//Porcentaje de beneficios para el centro asociado * 20%
const percentOfBenefits = 20;

export function addHours(hour1, hour2) {
    // Separar horas y minutos de ambas horas
    const [h1, m1] = hour1.split(":").map(Number);
    const [h2, m2] = hour2.split(":").map(Number);

    // Convertir ambas horas a minutos totales
    const totalMin1 = h1 * 60 + m1;
    const totalMin2 = h2 * 60 + m2;

    // Sumar los minutos totales
    const minutosSumados = totalMin1 + totalMin2;

    // Convertir los minutos sumados de nuevo a horas y minutos
    const horasResultado = Math.floor(minutosSumados / 60);
    const minutosResultado = minutosSumados % 60;

    // Formatear el resultado a HH:MM
    const horasFormateadas = horasResultado.toString().padStart(2, "0");
    const minutosFormateados = minutosResultado.toString().padStart(2, "0");

    return `${horasFormateadas}:${minutosFormateados}`;
}

export function formatHour(hour) {
    const arrayHour = hour.split(":");
    return `${arrayHour[0]}:${arrayHour[1]}`;
}

export function capitalizeFirstChart(string) {
    if (string.length === 0) return string; // Si la cadena está vacía, devolvemos la cadena tal cual
    return string.charAt(0).toUpperCase() + string.slice(1);
}

//---------------------------FUNCIONES DE LOS INFORMES------------------------------------
/*
Salvo las funciones getIndexMaxValue, getSumByHours, getCenterProfit y getCompanyProfit, las demás devuelven un array 
donde los índices 0 son las etiquetas y los índices 1 los valores.
Se requiere este formato para los gráficos.
*/

//Función para sumar los valores de todas las columnas con el mismo nombre (valores numericos)
export function amountByColumnName(data, columnName) {
    let total = 0;

    data.forEach((item) => {
        total += parseFloat(item[columnName]);
    });

    return total;
}

//Función obtener el total de los precios por nombre de tratamiento (puede servir para otros casos)
export function getTotalByColumnName(
    data,
    columnName,
    columnNumber,
    isAdmin = true // Por defecto se calcula el beneficio de la empresa
) {
    const objectMap = {};

    data.forEach((treatment) => {
        const treatmentName = capitalizeFirstChart(treatment[columnName]);
        const price = isAdmin
            ? getCompanyProfit(parseFloat(treatment[columnNumber]))
            : getCenterProfit(parseFloat(treatment[columnNumber]));

        if (objectMap[treatmentName]) {
            objectMap[treatmentName] += price;
        } else {
            objectMap[treatmentName] = price;
        }
    });

    const labels = Object.keys(objectMap);
    const values = labels.map((label) => objectMap[label]);

    return [labels, values];
}

//Función para obtener el total de los precios por año (puede servir para otros casos)
export function getTotalByYears(
    data,
    columnDateName,
    columnNumber,
    isAdmin = true // Por defecto se calcula el beneficio de la empresa
) {
    const objectMap = {};

    data.forEach((treatment) => {
        const treatmentName = new Date(treatment[columnDateName]).getFullYear();
        const price = isAdmin
            ? getCompanyProfit(parseFloat(treatment[columnNumber]))
            : getCenterProfit(parseFloat(treatment[columnNumber]));

        if (objectMap[treatmentName]) {
            objectMap[treatmentName] += price;
        } else {
            objectMap[treatmentName] = price;
        }
    });

    const labels = Object.keys(objectMap);
    const values = labels.map((label) => objectMap[label]);

    return [labels, values];
}

//Función para obtener el total de los precios por mes (puede servir para otros casos)
export function getTotalByMonth(
    data,
    columnDateName,
    columnNumber,
    isAdmin = true // Por defecto se calcula el beneficio de la empresa
) {
    const pricesByMonth = {};
    const months = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];

    // Inicializa los meses con 0
    months.forEach((month) => {
        pricesByMonth[month] = 0;
    });

    // Calcula el total por mes
    data.forEach((treatment) => {
        const date = new Date(treatment[columnDateName]);
        const treatmentMonth = date.getMonth(); // Obtiene el índice del mes (0-11)
        const price = isAdmin
            ? getCompanyProfit(parseFloat(treatment[columnNumber]))
            : getCenterProfit(parseFloat(treatment[columnNumber]));

        // Verifica si el precio es válido
        if (!isNaN(price)) {
            pricesByMonth[months[treatmentMonth]] += price;
        }
    });

    // Filtra los meses con precios mayores que 0, para no incluirlos en los datos
    const labels = months.filter((month) => pricesByMonth[month] > 0);
    const values = labels.map((label) => pricesByMonth[label]);

    return [labels, values];
}

//Función para obtener la cantidad de registros iguales de una columna en concreto (se usa para obtener la cantidad de tratamientos)
export function getCountByColumnName(data, column_name) {
    const objectMap = {};

    data.forEach((treatment) => {
        const treatmentName = capitalizeFirstChart(treatment[column_name]);

        if (objectMap[treatmentName]) {
            objectMap[treatmentName]++;
        } else {
            objectMap[treatmentName] = 1;
        }
    });

    const labels = Object.keys(objectMap);
    const values = labels.map((label) => objectMap[label]);

    return [labels, values];
}

//Esta función sirve para retornar el índice del array con el mayor número, útil para el formato retornado en las funciones anteriores
export function getIndexOfMaxValue(data, indexOfNumbers) {
    //Valida el formato de entrada, array multiple
    if (
        !Array.isArray(data) ||
        data.length < 2 ||
        !Array.isArray(data[indexOfNumbers])
    ) {
        throw new Error("El formato del array no es válido");
    }
    // Encontrar el índice del número mayor en el segundo subarray
    return data[indexOfNumbers].indexOf(Math.max(...data[indexOfNumbers]));
}

//Suma de tiempo en formato 00:00:00
export function getSumByHours(data, time_column) {
    let totalSeconds = 0;

    //Se extraen los tiempos en formato sting, se pasan a numero, se combierten todos a segundos y se suman
    data.forEach((item) => {
        const timeString = item[time_column];
        const [hours, minutes, seconds] = timeString.split(":").map(Number);
        totalSeconds += hours * 3600 + minutes * 60 + seconds;
    });

    // Convertimos el total de segundos a horas y minutos
    const totalHours = Math.floor(totalSeconds / 3600);
    const totalMinutes = Math.floor((totalSeconds % 3600) / 60);

    return `${totalHours}:${totalMinutes.toString().padStart(2, "0")}`;
}

//Funcion para obtener las ganancias del centro asociado, siendo el porcentaje indicado al inicio sobre el total
export function getCenterProfit(total) {
    return parseFloat((total * (percentOfBenefits / 100)).toFixed(2));
}

// Función para obtener las ganancias de la empresa, el total menos el porcentaje indicado
export function getCompanyProfit(total) {
    const centerProfit = total * (percentOfBenefits / 100);
    return parseFloat((total - centerProfit).toFixed(2));
}
