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
    { data: 'order' },
    { data: 'parentFamily' },
    { data: 'familiesOlny' },
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

        if (permission['delete']) {
          returnedString += '<a  href="javascript:;" onclick="ShowModalDeleteDomain(' + data + ')" class="item-delete">' +
            feather.icons['trash-2'].toSvg({ class: 'me-50 font-small-4' }) +
            '</a>';
        }

        if (permission['edit']) {
          returnedString += '<a  href="javascript:;" onclick="ShowModalEditDomain(' + data + ')" class="item-edit">' +
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
      // Label for parent
      targets: -3,
      orderable: false,
      render: function (data, type, full, meta) {
        return '<span class="badge rounded-pill badge-light-success">' + data + '</span>';
      }
    }
    , {
      // Label for sub-domains
      targets: -2,
      orderable: false,
      render: function (data, type, full, meta) {
        returnedData = '';
        data.forEach(element => {
          returnedData += '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' +
            element +
            '</span>'
        });
        return returnedData;
      }
    }
  ],
  // detailsOfItem
  lang['DetailsOfItem'],
  // detailsOfItemKey
  'name'
);
