const uploadButton = document.getElementById("uploadButton");
const Spinner = document.querySelector("#spinner");
const btnImport = document.querySelector("#btn-import");

const out_of_service_total = document.querySelector("#out_of_service_total");
const occupations_total = document.querySelector("#occupations_total");
const content = document.querySelector("#content");
const errorsList = document.querySelector("#errors_list");

let synchronize_data = [];
let synchronize_blockeds = [];
let synchronize_out_of_service = [];

uploadButton.addEventListener("click", loadFile);

btnImport.addEventListener("click", async (e) => {
    AddLoading();
    try {
        // Procesar ocupaciones
        await processBatches(
            `${window.appConfig.baseUrl}admin/occupations/insert_occupations`,
            synchronize_data
        );

        // Procesar bloqueados
        await processBatches(
            `${window.appConfig.baseUrl}admin/occupations/insert_blockeds`,
            synchronize_blockeds
        );

        // Procesar fuera de servicio
        await processBatches(
            `${window.appConfig.baseUrl}admin/occupations/insert_out_of_service`,
            synchronize_out_of_service
        );

        // Realizar calculos
        await generateMathematic(
            `${window.appConfig.baseUrl}admin/saturations/mathematic`
        );

        // Éxito al completar todos los procesos
        RemoveLoading();
        Swal.fire({
            icon: "success",
            title: "¡Información almacenada con éxito!",
            showConfirmButton: false,
            timer: 1500,
        });
    } catch (error) {
        RemoveLoading();
        Swal.fire({
            icon: "error",
            title: "Error al procesar los datos",
            text: error.message,
            showConfirmButton: true,
        });
        content.style.display = "none";
    }
});

function loadFile() {
    let formData = new FormData($("#uploadExcelForm")[0]);
    content.style.display = "none";
    Spinner.style.display = "";
    uploadButton.disabled = true;

    console.log(isFormDataEmpty(formData));
    console.log(formData);
    if (isFormDataEmpty(formData)) {
        Spinner.style.display = "none";
        uploadButton.disabled = false;
        return Swal.fire({
            icon: "error",
            title: "No se ha seleccionado ningun archivo",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    $.ajax({
        url: `${window.appConfig.baseUrl}admin/occupations/load_file`,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            Spinner.style.display = "none";
            uploadButton.disabled = false;
            if (response.status == 400) {
                return Swal.fire({
                    icon: "error",
                    title: "Error al cargar el archivo",
                    text: `${response.message}`,
                    showConfirmButton: true,
                });
            }

            occupations_total.innerHTML =
                response.synchronize_occupations.length;
            out_of_service_total.innerHTML =
                response.synchronize_out_of_service.length;
            content.style.display = "";

            synchronize_data = response.synchronize_occupations;
            synchronize_blockeds = response.blockeds_occupations;
            synchronize_out_of_service = response.synchronize_out_of_service;

            ListErrors(response.errors);

            Swal.fire({
                icon: "success",
                title: "¡Excel cargado con exito!",
                text: `${response.message}`,
                showConfirmButton: false,
                timer: 1500,
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Spinner.style.display = "none";
            uploadButton.disabled = false;
            content.style.display = "none";
        },
    });
}

async function processBatches(url, dataArray, batchSize = 25) {
    const batches = chunkArray(dataArray, batchSize);

    for (const batch of batches) {
        try {
            await $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: url,
                type: "POST",
                data: {
                    data: batch, // Nombre genérico para el payload
                },
            });
        } catch (error) {
            console.error("Error al enviar el lote:", error);
            throw new Error("Error al procesar los datos");
        }
    }
}

async function generateMathematic(url) {
    try {
        await $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            type: "POST",
        });
    } catch (error) {
        console.error("Error al enviar el lote:", error);
        throw new Error("Error al procesar los datos");
    }
}

function AddLoading() {
    btnImport.disabled = true;
    btnImport.innerHTML = `
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Sincronizando registros...
    `;
}

function RemoveLoading() {
    btnImport.innerHTML = "Alamacenar información cargada";
    btnImport.disabled = false;
}

function isFormDataEmpty(formData) {
    let fileSelected = false;

    for (let pair of formData.entries()) {
        if (pair[1] instanceof File && pair[1].name !== "") {
            fileSelected = true;
        }
    }

    return !fileSelected;
}

const chunkArray = (array, size) => {
    const chunks = [];
    for (let i = 0; i < array.length; i += size) {
        chunks.push(array.slice(i, i + size));
    }
    return chunks;
};

function ListErrors(Errors) {
    let tableErrors;

    if (Errors.length == 0) {
        errorsList.style.display = "none";
        return;
    }

    if ($.fn.DataTable.isDataTable("#TableErrors")) {
        $("#TableErrors").DataTable().clear();
        $("#TableErrors").DataTable().rows.add(Errors).draw();
    } else {
        tableErrors = $("#TableErrors").DataTable({
            responsive: true,
            data: Errors,
            columns: [
                { data: "name", title: "IPS" },
                {
                    data: "message",
                    title: "Error",
                    createdCell: function (cell, cellData) {
                        $(cell).css({
                            "word-break": "break-word",
                            "white-space": "normal",
                        });
                    },
                },
            ],
            language: {
                decimal: "",
                emptyTable: "No hay información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ errores",
                infoEmpty: "Mostrando 0 to 0 of 0 errores",
                infoFiltered: "(Filtrado de _MAX_ total errores)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_ errores",
                loadingRecords: "Cargando...",
                processing: "Procesando...",
                search: "Buscar:",
                zeroRecords: "Sin resultados encontrados",
                paginate: {
                    first: "Primero",
                    last: "Ultimo",
                    next: "Siguiente",
                    previous: "Anterior",
                },
            },
            error: function (xhr, error, thrown) {
                console.log("DataTables error:", error, thrown);
                console.log("Response:", xhr.responseText);
            },
        });
    }
}
