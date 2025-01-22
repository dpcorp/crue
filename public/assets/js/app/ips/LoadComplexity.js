const uploadButton = document.getElementById("uploadButton");
const Spinner = document.querySelector("#spinner");
const btnImport = document.querySelector("#btn-import");

const total_ips = document.querySelector("#total_ips");
const to_update = document.querySelector("#to_update");
const content = document.querySelector("#content");
const errorsList = document.querySelector("#errors_list");

let synchronize_data = [];

uploadButton.addEventListener("click", loadFile);
btnImport.addEventListener("click", UpsertIPS);

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
        url: `${window.appConfig.baseUrl}admin/ips/load_complexity`,
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

            total_ips.innerHTML = response.to_update;
            to_update.innerHTML = response.to_update;
            content.style.display = "";

            synchronize_data = response.data;
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

async function UpsertIPS() {
    AddLoading();
    const batchSize = 10; // Tamaño de cada lote
    const batches = chunkArray(synchronize_data, batchSize);

    for (const batch of batches) {
        try {
            await $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: `${window.appConfig.baseUrl}admin/ips/insert_complexity`,
                type: "POST",
                data: {
                    ips: batch,
                },
            });
        } catch (error) {
            console.error("Error al enviar el lote:", error);
            return Swal.fire({
                text: `Hubo un error al ingresar algunas IPS`,
                icon: "error",
                confirmButtonText: "Aceptar",
            });
        }
    }

    RemoveLoading();
    content.style.display = "none";
    return Swal.fire({
        text: `La complejidad de las IPS fueron actualizadas con exito`,
        icon: "success",
        confirmButtonText: "Aceptar",
    });
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
    console.log(Errors);
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
