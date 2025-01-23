const tabMoreThantHundred = document.getElementById("tab-more-than-hundred");
const tabMoreLessHundred = document.getElementById("tab-less-than-hundred");
const tabCompartmentSaturation = document.getElementById(
    "tab-compartment-saturation"
);

const btnFilter = document.querySelector("#btn-filter");

const ips = document.querySelector("#ips");
const complexity = document.querySelector("#complexity");
const services = document.querySelector("#services");
const groups = document.querySelector("#groups");
const date_start = document.querySelector("#date_start");
const date_end = document.querySelector("#date_end");

let chartInstance = null;

tabMoreThantHundred.addEventListener("click", () => {
    generateMathematicMoreThantHundred();
    btnFilter.setAttribute("attr-filter", "more_than_hundred");
});
tabMoreLessHundred.addEventListener("click", () => {
    btnFilter.setAttribute("attr-filter", "less_than_hundred");
    generateMathematicLessThanHundred();
});
tabCompartmentSaturation.addEventListener("click", () => {
    btnFilter.setAttribute("attr-filter", "compartment_saturation");
    generateMathematicCompartmentSaturation();
});

btnFilter.addEventListener("click", () => {
    if (btnFilter.getAttribute("attr-filter") == "more_than_hundred") {
        generateMathematicMoreThantHundred();
    } else if (btnFilter.getAttribute("attr-filter") == "less_than_hundred") {
        generateMathematicLessThanHundred();
    } else if (
        btnFilter.getAttribute("attr-filter") == "compartment_saturation"
    ) {
        generateMathematicCompartmentSaturation();
    }
});

generateMathematicMoreThantHundred();

function generateMathematicMoreThantHundred() {
    var selectedIps = $("#ips").val(); // Valor de los IPS seleccionados
    var selectedComplexity = $("#complexity").val(); // Valor de complejidad
    var selectedServices = $("#services").val(); // Valor de servicios
    var selectedGroups = $("#groups").val(); // Valor de grupos

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: `${window.appConfig.baseUrl}admin/indicators/mathematic_more_thant_hundred`,
        type: "GET",
        data: {
            ips: selectedIps,
            complexity: selectedComplexity,
            services: selectedServices,
            groups: selectedGroups,
            date_start: date_start.value,
            date_end: date_end.value,
        },
        success: function (response) {
            console.log(response);
            const labels = response.data_labels;
            const percentages = response.data_percentage;

            renderChart(labels, percentages, "chartMathematic");
        },
    });
}

function generateMathematicLessThanHundred() {
    var selectedIps = $("#ips").val(); // Valor de los IPS seleccionados
    var selectedComplexity = $("#complexity").val(); // Valor de complejidad
    var selectedServices = $("#services").val(); // Valor de servicios
    var selectedGroups = $("#groups").val(); // Valor de grupos

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: `${window.appConfig.baseUrl}admin/indicators/mathematic_less_thant_hundred`,
        type: "GET",
        data: {
            ips: selectedIps,
            complexity: selectedComplexity,
            services: selectedServices,
            groups: selectedGroups,
            date_start: date_start.value,
            date_end: date_end.value,
        },
        success: function (response) {
            console.log(response);
            const labels = response.data_labels;
            const percentages = response.data_percentage;

            // Renderizamos la gráfica
            renderChart(labels, percentages, "chartMathematicLess");
        },
    });
}

function generateMathematicCompartmentSaturation() {
    renderChartLine();
}

function renderChart(labels, data, chartId) {
    // const ctx = document.getElementById("chartMathematic").getContext("2d");
    const ctx = document.getElementById(chartId).getContext("2d");

    // Si ya existe una gráfica, la destruimos antes de crear una nueva
    if (chartInstance) {
        chartInstance.destroy();
    }

    if (labels.length > 0 && data.length <= 6) {
        document.getElementById("chart-container").style.height = `400px`;

        document.getElementById(chartId).style.height = `400px`;
    } else if (data.length > 6) {
        // Calculamos la altura en función del número de registros
        const numberOfRecords = labels.length; // Cantidad de registros
        const chartHeight = numberOfRecords * 40; // Establecemos la altura según la cantidad de registros, 40px por barra

        // Establecemos la altura del contenedor en el DOM
        document.getElementById(
            "chart-container"
        ).style.height = `${chartHeight}px`;

        // Establecemos la altura del canvas en el DOM
        document.getElementById(chartId).style.height = `${chartHeight}px`;
    }

    // Creamos la nueva gráfica
    chartInstance = new Chart(ctx, {
        type: "bar", // Gráfica de barras
        data: {
            labels: labels, // Asignamos las etiquetas correctamente
            datasets: [
                {
                    label: "Porcentaje de Saturación",
                    data: data, // Valores a mostrar en las barras
                    backgroundColor: "rgba(54, 162, 235, 0.6)", // Color de las barras
                    borderColor: "rgba(54, 162, 235, 1)", // Color de los bordes de las barras
                    borderWidth: 2, // Grosor de las barras
                    barThickness: 25, // Grosor de cada barra
                },
            ],
        },
        options: {
            responsive: true, // Adaptabilidad al tamaño de la pantalla
            maintainAspectRatio: false, // Permitimos que el tamaño cambie
            indexAxis: "y", // Hace que las barras sean horizontales
            plugins: {
                legend: {
                    display: true,
                    position: "top",
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.dataset.label}: ${context.raw}%`; // Formato del tooltip
                        },
                    },
                },
                datalabels: {
                    anchor: "center", // Centra el valor dentro de la barra
                    align: "center", // Alinea el texto al centro de la barra
                    color: "black", // Color blanco para asegurar visibilidad dentro de la barra
                    formatter: function (value, context) {
                        return `${value}%`;
                    },
                    font: {
                        weight: "bold",
                        size: 14, // Tamaño de fuente ajustado según sea necesario
                    },
                },
            },
            scales: {
                x: {
                    beginAtZero: true, // Inicia en 0
                    ticks: {
                        callback: function (value) {
                            return `${value}%`; // Formato para el porcentaje en el eje X
                        },
                    },
                },
                y: {
                    position: "left", // Aseguramos que las etiquetas se alineen a la izquierda
                    grid: {
                        display: false, // Muestra las líneas de la cuadrícula
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        autoSkip: false, // No omite ninguna etiqueta
                        callback: function (value, index, ticks) {
                            let label = labels[index]; // Obtenemos el label correspondiente
                            if (label.length > 10) {
                                label = `${label}`; // Elipsis para truncar
                            }
                            return label; // Devuelve el label truncado si es necesario
                        },
                    },
                },
            },
            layout: {
                padding: {
                    top: 10,
                    left: 10,
                    right: 10,
                    bottom: 10,
                },
            },
            barPercentage: 0.9,
            categoryPercentage: 0.8,
        },
        plugins: [ChartDataLabels],
    });
}

//chart por borrar

// Función para generar un array de días de un mes
function generateDaysInMonth() {
    const daysInMonth = [];
    const currentDate = new Date();
    currentDate.setDate(1); // Comenzamos el 1 del mes

    const month = currentDate.getMonth();

    // Creamos labels para los días del mes (de 1 a 31)
    while (currentDate.getMonth() === month) {
        daysInMonth.push(
            currentDate.toLocaleDateString("en-GB", { day: "2-digit" })
        );
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return daysInMonth;
}

// Función para generar datos aleatorios
function generateRandomData(num) {
    const data = [];
    for (let i = 0; i < num; i++) {
        data.push(Math.floor(Math.random() * 100)); // Datos aleatorios entre 0 y 100
    }
    return data;
}

function renderChartLine() {
    const ctx = document.getElementById("myChart").getContext("2d");

    // Si ya existe un gráfico, lo destruimos antes de crear uno nuevo
    if (window.chartInstance) {
        window.chartInstance.destroy();
    }

    const labels = generateDaysInMonth(); // Etiquetas con los días del mes
    const data = generateRandomData(labels.length); // Datos aleatorios para cada día del mes

    // Crear un nuevo gráfico de línea
    window.chartInstance = new Chart(ctx, {
        type: "line", // Tipo de gráfico
        data: {
            labels: labels, // Etiquetas (días del mes)
            datasets: [
                {
                    data: data, // Datos
                    borderColor: "rgba(255, 99, 132, 0.2)",
                    backgroundColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 7,
                    pointRadius: 10,
                    pointHoverRadius: 16,
                },
            ],
        },
        options: {
            responsive: true, // Adaptabilidad
            tension: 0.45,
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Días del Mes",
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Valor",
                    },
                },
            },
            plugins: {
                legend: {
                    position: "top",
                },
                // Plugin para mostrar los valores en cada punto
                datalabels: {
                    display: true, // Activamos la visualización de los valores
                    align: "top", // Alineación de los valores (puedes usar 'top', 'bottom', 'center')
                    anchor: "end", // Anclaje de las etiquetas
                    color: "black", // Color blanco para asegurar visibilidad dentro de la barra
                    formatter: function (value, context) {
                        return `${value}%`;
                    },
                    font: {
                        weight: "bold",
                        size: 14, // Tamaño de fuente ajustado según sea necesario
                    },
                },
            },
        },
    });
}
