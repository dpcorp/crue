"use strict";

// Setting Color

$(window).resize(function () {
    $(window).width();
});

getCheckmark();

$(".changeBodyBackgroundFullColor").on("click", function () {
    if ($(this).attr("data-color") == "default") {
        $("body").removeAttr("data-background-full");
    } else {
        $("body").attr("data-background-full", $(this).attr("data-color"));
    }

    $(this)
        .parent()
        .find(".changeBodyBackgroundFullColor")
        .removeClass("selected");
    $(this).addClass("selected");
    layoutsColors();
    getCheckmark();
});

$(".changeLogoHeaderColor").on("click", function () {
    if ($(this).attr("data-color") == "default") {
        $(".logo-header").removeAttr("data-background-color");
    } else {
        $(".logo-header").attr(
            "data-background-color",
            $(this).attr("data-color")
        );
    }

    $(this).parent().find(".changeLogoHeaderColor").removeClass("selected");
    $(this).addClass("selected");
    customCheckColor();
    layoutsColors();
    getCheckmark();
    ChangeSettings("logo", $(this).attr("data-color")).then((result) => {
        console.log("Componente modificado");
    });
});

$(".changeTopBarColor").on("click", function () {
    if ($(this).attr("data-color") == "default") {
        $(".main-header .navbar-header").removeAttr("data-background-color");
    } else {
        $(".main-header .navbar-header").attr(
            "data-background-color",
            $(this).attr("data-color")
        );
    }
    $(this).parent().find(".changeTopBarColor").removeClass("selected");
    $(this).addClass("selected");
    layoutsColors();
    getCheckmark();

    ChangeSettings("navbar", $(this).attr("data-color")).then((result) => {
        console.log("Componente modificado");
    });
});

$(".changeSideBarColor").on("click", function () {
    if ($(this).attr("data-color") == "default") {
        $(".sidebar").removeAttr("data-background-color");
    } else {
        $(".sidebar").attr("data-background-color", $(this).attr("data-color"));
    }

    $(this).parent().find(".changeSideBarColor").removeClass("selected");
    $(this).addClass("selected");
    layoutsColors();
    getCheckmark();
    ChangeSettings("sidebar", $(this).attr("data-color")).then((result) => {
        console.log("Componente modificado");
    });
});

$(".changeBackgroundColor").on("click", function () {
    $("body").removeAttr("data-background-color");
    $("body").attr("data-background-color", $(this).attr("data-color"));
    $(this).parent().find(".changeBackgroundColor").removeClass("selected");
    $(this).addClass("selected");
    getCheckmark();
});

function customCheckColor() {
    var logoHeader = $(".logo-header").attr("data-background-color");
    // if (logoHeader !== "white") {
    //   $(".logo-header .navbar-brand").attr("src", `${window.appConfig.baseUrl}assets/images/app/udea_minimalist_white_big.png`);
    // } else {
    //   $(".logo-header .navbar-brand").attr("src", `${window.appConfig.baseUrl}assets/images/app/udea_minimalist_green_big.png`);
    // }
}

var toggle_customSidebar = false,
    custom_open = 0;

if (!toggle_customSidebar) {
    var toggle = $(".custom-template .custom-toggle");

    const toggle_paint = document.querySelector("#custom-toggle-btn");

    toggle_paint.addEventListener("click", (e) => {
        if (custom_open == 1) {
            $(".custom-template").removeClass("open");
            toggle.removeClass("toggled");
            custom_open = 0;
        } else {
            $(".custom-template").addClass("open");
            toggle.addClass("toggled");
            custom_open = 1;
        }
    });
    // toggle.on("click", function () {
    //   console.log("toggle");
    //   if (custom_open == 1) {
    //     $(".custom-template").removeClass("open");
    //     toggle.removeClass("toggled");
    //     custom_open = 0;
    //   } else {
    //     $(".custom-template").addClass("open");
    //     toggle.addClass("toggled");
    //     custom_open = 1;
    //   }
    // });
    toggle_customSidebar = true;
}

function getCheckmark() {
    var checkmark = `<i class="gg-check"></i>`;
    $(".btnSwitch").find("button").empty();
    $(".btnSwitch").find("button.selected").append(checkmark);
}

function ChangeSettings(component, color) {
    return new Promise((resolve, reject) => {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: `${window.appConfig.baseUrl}admin/color_settings/save`,
            type: "POST",
            data: {
                component: component,
                color: color,
            },
            success: function (result) {
                resolve(result);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
}
