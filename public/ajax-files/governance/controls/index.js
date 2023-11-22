// dataPickr custom for compliance
dateTimePickr = $('.flatpickr-date-time-compliance');
// Date & TIme
if (dateTimePickr.length) {
  dateTimePickr.flatpickr({
    enableTime: false,
    dateFormat: "Y-m-d",
  });
}

drawDatatable(
    // columnsData
    [
        { data: 'id' },
        { data: 'Actions' },
        { data: 'short_name' },
        { data: 'description' },
        { data: 'Frameworks', orderable: false },
        { data: 'family_with_parent', orderable: false },
        { data: 'family_name', orderable: false },
        { data: 'Actions' }
    ],
    // columnDefinitions
    [
        {
            // For Checkboxes
            targets: 1,
            // title: 'select',
            orderable: false,
            responsivePriority: 3,
            render: function (data, type, full, meta) {
                if (!full.isParent)
                    return (
                        '<div class="form-check"> <input class="form-check-input dt-checkboxes" name="audits[]" type="checkbox" value="' +
                        data +
                        '" id="checkbox" /><label class="form-check-label" for="checkbox"></label></div>'
                    );
                else
                    return '';
            },
            checkboxes: {
                selectAllRender: '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>'
            }
        },
        { width: '30%', targets: 3 },
        {
            // Actions
            targets: -1,
            orderable: false,
            render: function (data, type, full, meta) {
                let returnedString = '';
                let auditCreateString = '';
                let objectiveString = "";
                let editString = "";
                let deleteString = "";

                if (permission["audits.create"] && !full.isParent) {
                    auditCreateString +=
                        '<a  href="javascript:;" onclick="showModalCreateAudit(' +
                        data +
                        ')" class="item-edit dropdown-item ">' +
                        feather.icons["edit"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        `${lang['Audit']}</a>`;
                }

                if (permission["list_objectives"]) {
                    objectiveString +=
                        '<a  href="javascript:;" onclick="showControlObjectives(' +
                        data +
                        ')" class="item-edit dropdown-item btn-flat-warning">' +
                        feather.icons["list"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        `${lang['Objective']}</a>`;
                }
                if (permission["edit"]) {
                    editString +=
                        '<a  href="javascript:;" onclick="editControl(' +
                        data +
                        ')" class="item-edit dropdown-item ">' +
                        feather.icons["edit"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        `${lang['Edit']}</a>`;
                }

                if (permission["delete"]) {
                    deleteString +=
                        '<a  href="javascript:;" onclick="deleteControl(' +
                        data +
                        ')" class="dropdown-item  btn-flat-danger">' +
                        feather.icons["trash-2"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        `${lang['Delete']}</a>`;

                }

                return (
                    '<div class="d-inline-flex">' +
                    '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                    feather.icons["more-vertical"].toSvg({
                        class: "font-small-4",
                    }) +
                    "</a>" +
                    '<div class="dropdown-menu dropdown-menu-end">' +
                    auditCreateString +
                    editString +
                    objectiveString +
                    '<a  href="javascript:;" onclick="mapControl(' +
                    data +
                    ')" class="dropdown-item  btn-flat-success">' +
                    feather.icons["git-merge"].toSvg({
                        class: "font-small-4",
                    }) +
                    `${lang['Mapping']}</a>` +
                    deleteString +
                    "</div>" +
                    "</div>"
                );
            }

        }
    ],
    // detailsOfItem
    lang['DetailsOfItem'],
    // detailsOfItemKey
    'name'
);