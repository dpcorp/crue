function generateMathematic() {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: `${window.appConfig.baseUrl}admin/saturations/mathematic`,
        type: "POST",
        success: function (response) {
            console.log(response);
        },
    });
}
