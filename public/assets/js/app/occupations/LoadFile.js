const uploadButton = document.getElementById("uploadButton");
const Spinner = document.querySelector("#spinner");
const btnImport = document.querySelector("#btn-import");

const out_of_service_total = document.querySelector("#out_of_service_total");
const occupations_total = document.querySelector("#occupations_total");
const content = document.querySelector("#content");

let synchronize_data = [];
let synchronize_out_of_service = [];

uploadButton.addEventListener("click", loadFile);
btnImport.addEventListener("click", (e) => {
    AddLoading();
    InsertOccupations()
        .then((e) => {
            InsertOutOfService()
                .then((e) => {
                    RemoveLoading();
                    Swal.fire({
                        icon: "success",
                        title: "¡Información almacenada con exito!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                })
                .catch((e) => {
                    RemoveLoading();
                    Swal.fire({
                        icon: "error",
                        title: "Error al cargar los registros fuera de servicio",
                        text: `${e.message}`,
                        showConfirmButton: true,
                    });
                    content.style.display = "none";
                });
        })
        .catch((e) => {
            RemoveLoading();
            Swal.fire({
                icon: "error",
                title: "Error al cargar las ocupaciones",
                text: `${e.message}`,
                showConfirmButton: true,
            });
            content.style.display = "none";
        });
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
            synchronize_out_of_service = response.synchronize_out_of_service;

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

async function InsertOccupations() {
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
                url: `${window.appConfig.baseUrl}admin/occupations/insert_occupations`,
                type: "POST",
                data: {
                    occupations: batch,
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
}

async function InsertOutOfService() {
    const batchSize = 10; // Tamaño de cada lote
    const batches = chunkArray(synchronize_out_of_service, batchSize);

    for (const batch of batches) {
        try {
            await $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: `${window.appConfig.baseUrl}admin/occupations/insert_out_of_service`,
                type: "POST",
                data: {
                    out_of_service: batch,
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
