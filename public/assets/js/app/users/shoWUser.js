const offcanvasContent = document.querySelector('#offcanvasContent');

const ShowUser = (user_id) => {

    offcanvasContent.innerHTML = '';

    GetUser(user_id).then((result) => {
        console.log(result);
        offcanvasContent.innerHTML = result;
        
        const offcanvasElement = document.getElementById('offcanvasRight');
        const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.show();
    });

}


function GetUser(user_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `${window.appConfig.baseUrl}admin/users/${user_id}`,
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