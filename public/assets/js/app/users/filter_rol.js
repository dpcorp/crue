const div_universities = document.querySelector('#div_universities');
const rol_input = document.querySelector('#rol-id');

$(document).ready(function () {
    if (document.querySelector('#id_user')) {
        filterUserPermission();
    }
});
const id_user = document.querySelector('#id_user');

function filterRol(data) {
    $("#user_id_permission").val("").trigger("change");
    if (!data.value == "") {
        document.getElementById("div_roles").removeAttribute("hidden");
        $.ajax({
            url: `${window.appConfig.baseUrl}admin/filter_roles/${data.value}`,
            type: "GET",
            success: function (response) {
                const groupsData = response.groups_data;
                const permissionsRol = response.permissions_rol;
                const traduccion = response.traduccion;

                // Llenar acordeón
                const accordion = document.getElementById("accordionExample");
                accordion.innerHTML = ""; // Limpiar acordeón antes de llenarlo

                for (const [key, group] of Object.entries(groupsData)) {
                    const counter = group.length;
                    // console.log(group);
                    const groupHtml = `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="${key.replaceAll(
                        " ",
                        ""
                    )}">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#${key.replaceAll(
                        " ",
                        ""
                    )}_collapse"
                                aria-expanded="false"
                                aria-controls="${key.replaceAll(
                        " ",
                        ""
                    )}_collapse">
                                <span class="badge rounded-pill text-bg-secondary mx-0">
                                ${Object.keys(group).length}
                                </span>
                                <div class="mx-1">${key}</div>
                            </button>
                        </h2>
                        <div id="${key.replaceAll(" ", "")}_collapse"
                            class="accordion-collapse collapse"
                            aria-labelledby="${key.replaceAll(" ", "")}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <div class="row border-bottom  py-2 border-end-0 border-start-0">
                            <div class="col-12 d-flex justify-content-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        onclick="toggleCheckboxes('${key.replaceAll(" ", "").toLowerCase()}')"
                                        id="${key.replaceAll(" ", "").toLowerCase()}_all" checked>
                                    <label class="form-check-label"
                                        for="${key.replaceAll(" ", "").toLowerCase()}_all">
                                        Seleccionar/Quitar todos los permisos
                                    </label>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                `;
                    accordion.insertAdjacentHTML("beforeend", groupHtml);

                    // Llenar permisos para este grupo
                    const groupAccordionBody = accordion.querySelector(
                        `#${key.replaceAll(" ", "")}_collapse .accordion-body`
                    );
                    for (const [key_2, permissions] of Object.entries(group)) {
                        const permissionHtml = `
                        <div class="row border-bottom py-2 border-end-0 border-start-0">
                            <div class="col-12 col-lg-5 col-xl-4 col-xxl-3 d-flex align-items-center mb-3 mb-md-0">
                                <b>${traduccion[key_2] || key}</b>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-8 col-xxl-9 d-flex justify-content-start">
                                <div class="row">
                                    ${permissions
                                .map(
                                    (permission) => `
                                        <div class="col-12 col-lg-5 col-xl-auto mb-lg-3 mb-xl-0">
                                            <div class="form-check">
                                                <input class="all_${key.replaceAll(" ", "").toLowerCase()} module_${key_2.toLowerCase()} form-check-input" type="checkbox" value="${permission.id
                                        }" id="${permission.name
                                        }" name="permissions[${permission.id
                                        }]" ${permissionsRol.includes(
                                            permission.id
                                        )
                                            ? "checked"
                                            : ""
                                        }>
                                                <label class="form-check-label" for="${permission.name
                                        }">
                                                    ${permission.description}
                                                </label>
                                            </div>
                                        </div>
                                    `
                                )
                                .join("")}
                                </div>
                            </div>
                        </div>
                    `;
                        groupAccordionBody.insertAdjacentHTML(
                            "beforeend",
                            permissionHtml
                        );
                    }
                }
            },
        });
    } else {
        document.getElementById("div_roles").setAttribute("hidden", true);
    }
}


function filterUserPermission() {

    if (!id_user.value == "") {
        document.getElementById("div_roles").removeAttribute("hidden");
        $.ajax({
            url: `${window.appConfig.baseUrl}admin/permissions_user/${id_user.value}`,
            type: "GET",
            success: function (response) {
                const groupsData = response.groups_data;
                const permissionsRol = response.permissions_rol;
                const traduccion = response.traduccion;

                // Llenar acordeón
                const accordion = document.getElementById("accordionExample");
                accordion.innerHTML = ""; // Limpiar acordeón antes de llenarlo

                for (const [key, group] of Object.entries(groupsData)) {
                    const counter = group.length;
                    // console.log(group);
                    const groupHtml = `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="${key.replaceAll(" ", "")}">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#${key.replaceAll(" ", "")}_collapse"
                                aria-expanded="false"
                                aria-controls="${key.replaceAll(" ", "")}_collapse">
                                    <span class="badge rounded-pill text-bg-secondary mx-0">
                                        ${Object.keys(group).length}
                                    </span>
                                    <div class="mx-1">${key}</div>
                            </button>
                        </h2>
                        <div id="${key.replaceAll(" ", "")}_collapse"
                            class="accordion-collapse collapse"
                            aria-labelledby="${key.replaceAll(" ", "")}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <div class="row border-bottom  py-2 border-end-0 border-start-0">
                            <div class="col-12 d-flex justify-content-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        onclick="toggleCheckboxes('${key.replaceAll(" ", "").toLowerCase()}')"
                                        id="${key.replaceAll(" ", "").toLowerCase()}_all" checked>
                                    <label class="form-check-label"
                                        for="${key.replaceAll(" ", "").toLowerCase()}_all">
                                        Seleccionar/Quitar todos los permisos
                                    </label>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                `;
                    accordion.insertAdjacentHTML("beforeend", groupHtml);

                    // Llenar permisos para este grupo
                    const groupAccordionBody = accordion.querySelector(
                        `#${key.replaceAll(" ", "")}_collapse .accordion-body`
                    );
                    for (const [key_2, permissions] of Object.entries(group)) {
                        const permissionHtml = `
                        <div class="row border-bottom py-2 border-end-0 border-start-0">
                            <div class="col-12 col-lg-5 col-xl-4 col-xxl-3 d-flex align-items-center mb-3 mb-md-0">
                                <b>${traduccion[key_2] || key}</b>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-8 col-xxl-9 d-flex justify-content-start">
                                <div class="row">
                                    ${permissions
                                .map(
                                    (permission) => `
                                        <div class="col-12 col-lg-5 col-xl-auto mb-lg-3 mb-xl-0">
                                            <div class="form-check">
                                                <input class="all_${key.replaceAll(" ", "").toLowerCase()} module_${key_2.toLowerCase()} form-check-input" type="checkbox" value="${permission.id}" id="${permission.name}" 
                                                name="permissions[${permission.id}]" ${permissionsRol.includes(permission.id) ? "checked" : ""}>
                                                <label class="form-check-label" for="${permission.name}">
                                                    ${permission.description}
                                                </label>
                                            </div>
                                        </div>
                                    `
                                )
                                .join("")}
                                </div>
                            </div>
                        </div>
                    `;
                        groupAccordionBody.insertAdjacentHTML(
                            "beforeend",
                            permissionHtml
                        );
                    }
                }
            },
        });
    } else {
        document.getElementById("div_roles").setAttribute("hidden", true);
    }
}

const toggleCheckboxes = (key) => {
    const checkboxes = document.querySelectorAll(`.all_${key}`);
    const masterCheckbox = document.querySelector(`#${key}_all`);
    const isChecked = masterCheckbox.checked;
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
    });
}