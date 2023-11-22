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
    {
      data: 'id'
    },
    {
      data: 'name'
    },
    {
      data: 'code'
    },
    {
      data: 'description'
    },
    {
      data: 'employees'
    },
    {
      data: 'created_at'
    },
    {
      data: 'Actions'
    }
  ],
  // columnDefinitions
  [{
    // Actions
    targets: -1,
    orderable: false,
    searchable: false,
    render: function (data, type, full, meta) {
      let returnedString = '';

      if (permission['delete']) {
        if (full.employees.length == 0) {
          returnedString +=
            '<a  href="javascript:;" onclick="ShowModalDeleteJob(' + data +
            ')" class="item-delete">' +
            feather.icons['trash-2'].toSvg({
              class: 'me-50 font-small-4'
            }) +
            '</a>';
        }
      }

      if (permission['edit']) {
        returnedString += '<a  href="javascript:;" onclick="ShowModalEditJob(' +
          data + ')" class="item-edit">' +
          feather.icons['edit'].toSvg({
            class: 'font-small-4'
          }) +
          '</a>';
      }

      if (returnedString == '')
        returnedString = '------';

      return (
        returnedString
      );
    }
  }, {
    // Label for employee
    orderable: false,
    targets: -3,
    render: function (data, type, full, meta) {
      returnedData = '';
      data.forEach(element => {
        returnedData +=
          '<span class="badge rounded-pill badge-light-success">' +
          element +
          '</span>'
      });
      return returnedData;
    }
  }],
  // detailsOfItem
  lang['DetailsOfItem'],
  // detailsOfItemKey
  'name'
);
