//select2 class
$(document).ready(function () {
  $('.multiple-select2').select2();
});

// function to show error validation 
function showError(data) {
  $('.error').empty();
  $.each(data, function (key, value) {
    $('.error-' + key).empty();
    $('.error-' + key).append(value);
  });
}

// status [warning, success, error]
function makeAlert($status, message, title) {
  // On load Toast
  if (title == 'Success')
    title = '👋' + title;
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
    { data: 'name' },
    { data: 'code' },
    { data: 'parentDepartment' },
    { data: 'departments' },
    { data: 'required_num_emplyees' },
    { data: 'actual_num_emplyees' },
    { data: 'manager' },
    { data: 'created_at' },
    { data: 'Actions' }
  ],
  // columnDefinitions
  [
    {
      // Actions
      targets: -1,
      orderable: false,
      render: function (data, type, full, meta) {
        let returnedString = '';

        if (permission['show']) {
          returnedString += '<a  href="javascript:;" onclick="ShowModalShowDepartment(' + data + ')" class="item-show">' +
            feather.icons['eye'].toSvg({ class: 'me-50 font-small-4' }) +
            '</a>';
        }
        if (permission['delete']) {
          returnedString += '<a  href="javascript:;" onclick="ShowModalDeleteDepartment(' + data + ')" class="item-delete">' +
            feather.icons['trash-2'].toSvg({ class: 'me-50 font-small-4' }) +
            '</a>';
        }

        if (permission['edit']) {
          returnedString += '<a  href="javascript:;" onclick="ShowModalEditDepartment(' + data + ')" class="item-edit">' +
            feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
            '</a>';
        }

        if (returnedString == '')
          returnedString = '------';

        return (
          returnedString
        );
      }
    }
    , {
      // manager
      targets: -3,
      orderable: false,
    }
    , {
      // actual number of employees
      targets: -4,
      orderable: false,
    }
    , {
      // Label for child departments
      targets: -6,
      orderable: false,
      render: function (data, type, full, meta) {
        returnedData = '';
        data.forEach(element => {
          returnedData += '<span class="badge rounded-pill badge-light-primary">' +
            element +
            '</span>'
        });
        return returnedData;
      }
    }
    , {
      // Label for parent department
      targets: -7,
      orderable: false,
      render: function (data, type, full, meta) {
        return '<span class="badge rounded-pill badge-light-success">' + data + '</span>';
      }
    }
  ],
  // detailsOfItem
  lang['DetailsOfItem'],
  // detailsOfItemKey
  'name'
);