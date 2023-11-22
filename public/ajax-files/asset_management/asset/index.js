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
    { data: 'name' },
    { data: 'ip' },
    { data: 'value', orderable: false, },
    { data: 'assetCategory', orderable: false, },
    { data: 'location', orderable: false, },
    { data: 'teams' },
    { data: 'tags' },
    { data: 'details' },
    { data: 'start_date' },
    { data: 'expiration_date' },
    { data: 'alert_period' },
    { data: 'created' },
    { data: 'verified' },
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
          returnedString += '<a  href="javascript:;" onclick="ShowModalDeleteAsset(' + data + ')" class="item-edit">' +
            feather.icons['trash-2'].toSvg({ class: 'me-50 font-small-4' }) +
            '</a>';
        }

        if (permission['edit']) {
          returnedString += `<a id="asset-${data}"  href="javascript:;" onclick="ShowModalEditAsset(${data})" class="item-edit">` +
            feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
            '</a>';
        }
        if (returnedString == '')
          returnedString = '------';

        return (
          returnedString
        );
      }
    }, {
      // Label for verified
      targets: -2,
      render: function (data, type, full, meta) {
        return `<span class="badge rounded-pill badge-light-${data ? 'success' : 'danger'}">${data ? verifiedTranslation : UnverifiedAssetsTranslation}</span>`;
      }
    }, {
      // Label for alert_period
      targets: -4,
      render: function (data, type, full, meta) {
        return data ? data : '';
      }
    }, {
    }, {
      // Label for tags
      targets: -8,
      orderable: false,
      render: function (data, type, full, meta) {
        returnedData = '';
        data.forEach(element => {
          returnedData += '<span class="badge rounded-pill badge-light-success">' +
            element +
            '</span>'
        });
        return returnedData;
      }
    }, {
      // Label for teams
      targets: -9,
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
  ],
  // detailsOfItem
  lang['DetailsOfItem'],
  // detailsOfItemKey
  'name'
);
