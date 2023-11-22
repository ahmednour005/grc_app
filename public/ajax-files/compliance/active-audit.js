
//select2 class
$('select.multiple-select2').select2();
$('select.select2').select2();

// function to show error validation
function showError(data, formId) {
  $('#' + formId + ' .error').empty();
  $.each(data, function (key, value) {
    $('#' + formId + ' .error-' + key).empty();
    $('#' + formId + ' .error-' + key).append(value);
  });
}

//alert function
function makeAlert($status, message, title) {
  // On load Toast
  toastr[$status](message, title,
    {
      closeButton: true,
      tapToDismiss: false,
    }
  );
}

drawDatatable(
  // columnsData
  [
    { data: 'id' },
    { data: 'framework' },
    { data: 'FrameworkControlWithFramworks' },
    { data: 'name' },
    { data: 'UserTester' },
    { data: 'created_at'},
    { data: 'last_date' },
    { data: 'next_date' },
    { data: 'Actions' },
  ],
  // columnDefinitions
  [
    {
      // Actions
      targets: -1,
      orderable: false,
      render: function (data, type, full, meta) {
        let returnedString = '';
        // if (permission['delete']) {
        //   returnedString +=  '<a  href="javascript:;" onclick="ShowModalDeleteAudit('+data+')" class="dropdown-item  btn-flat-danger">' +
        //   feather.icons['trash-2'].toSvg({ class: 'me-50 font-small-4' }) +
        //   'Delete</a>';
        // }

        if (permission['result']) {
          returnedString += '<a  href="javascript:;" onclick="showResultAudit(' + data + ')" class="dropdown-item  btn-flat-primary">' +
            // returnedString += '<a  href="javascript:;" onclick="showResultAudit('+data+')" class=" '+ 'dropdown-item  btn-flat-primary' + (full.editable? '' : ' bg-dark') + '">' +
            feather.icons['file'].toSvg({ class: 'me-50 font-small-4' }) +
            'result</a>';
        }

        if (returnedString == '')
          return ('------');
        else
          return (
            // '<div class="d-inline-flex">' +
            '<div class=" ' + 'dropdown-item  btn-flat-primary' + (full.editable ? '' : ' bg-dark rounded') + '">' +
            '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
            feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
            '</a>' +
            '<div class="dropdown-menu dropdown-menu-end">' +
            returnedString
            +
            '</div>' +
            '</div>'
          );
      }
    },
  ],
  // detailsOfItem
  lang['DetailsOfItem'],
  // detailsOfItemKey
  'name'
);