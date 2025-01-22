const offcanvasContent = document.querySelector('#offcanvasContent');

const ShowRol = (rol_id) => {

    offcanvasContent.innerHTML = '';

    GetRol(rol_id).then((result) => {
        console.log(result);
        offcanvasContent.innerHTML = result;

        const offcanvasElement = document.getElementById('offcanvasRight');
        const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.show();
    });

}


function GetRol(rol_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `${window.appConfig.baseUrl}admin/roles/${rol_id}`,
            type: "GET",
            success: function (result) {
                resolve(result);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}