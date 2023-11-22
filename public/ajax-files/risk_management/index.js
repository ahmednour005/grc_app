// Reset form
function resetFormData(form) {
  $('.error').empty();
  form.trigger("reset")
  form.find('input:not([name="_token"])').val('');
  form.find('select.multiple-select2 option[selected]').attr('selected', false);
  form.find('select.select2 option').attr('selected', false);
  form.find("select.select2").each(function (index) {
    $(this).find('option').first().attr('selected', true);
  });
  form.find('select').trigger('change');
}

$('.modal').on('hidden.bs.modal', function () {
  resetFormData($(this).find('form'));
})

// Show delete alert modal
function showModalDeleteRisk(id) {
  Swal.fire({
    title: lang['confirmDeleteMessage']
    , text: lang['revert']
    , icon: 'question'
    , showCancelButton: true
    , confirmButtonText: lang['confirmDelete']
    , cancelButtonText: lang['cancel']
    , customClass: {
      confirmButton: 'btn btn-relief-success ms-1'
      , cancelButton: 'btn btn-outline-danger ms-1'
    }
    , buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      DeleteRisk(id);
    }
  });
}

// Delete risk
function DeleteRisk(id) {
  let url = URLs['delete'];
  url = url.replace(':id', id);
  $.ajax({
    url: url
    , type: "DELETE"
    , headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    , success: function (data) {
      if (data.status) {
        makeAlert('success', data.message, lang['success']);
        $('.dtr-bs-modal').modal('hide');
        redrawDatatable();
      }
    }
    , error: function (response, data) {
      responseData = response.responseJSON;
      makeAlert('error', responseData.message, lang['error']);
    }
  });
}

$(document).ready(function () {
  $('.multiple-select2').select2();

  // Load controls of framework
  $("[name='framework_id']").on('change', function () {
    const frameworkControls = $(this).find('option:selected').data('controls');
    $("[name='control_id']").find('option:not(:first)').remove();
    $("[name='control_id']").find('option:first').attr('selected', true)
    if (frameworkControls)
      frameworkControls.forEach(frameworkControl => {
        $("[name='control_id']").append(`<option value="${frameworkControl.id}">${frameworkControl.short_name}</option>`);
      });
  });

  // Load Owner manager
  $("[name='owner_id']").on('change', function () {
    const ownerManger = $(this).find('option:selected').data('manager');
    $("[name='owner_manager_id']").find('option:not(:first)').remove();
    $("[name='owner_manager_id']").find('option:first').attr('selected', true)
    if (ownerManger)
      $("[name='owner_manager_id']").append(`<option value="${ownerManger.id}">${ownerManger.name}</option>`);
  });

  // Submit form for creating risk
  $('#add-new-risk form').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: URLs['create']
      , type: "POST"
      , data: formData
      , contentType: false
      , processData: false
      , success: function (data) {
        if (data.status) {
          makeAlert(data.alert ? 'warning' : 'success', data.alert ? `${data.alert}<br>${data.message}` : `${data.message}`, lang['success']);
          $('#add-new-risk').modal('hide');
          $("#advanced-search-datatable").load(location.href +
            " #advanced-search-datatable>*", "");
          if (data.redirect_to)
            window.location.href = data.redirect_to;
          // loadDatatable();
        } else {
          showError(data['errors']);
        }
      }
      , error: function (response, data) {
        responseData = response.responseJSON;
        makeAlert('error', responseData.message, lang['error']);
        showError(responseData.errors);
      }
    });
  });
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
    { data: 'status' },
    { data: 'subject' },
    { data: 'riskScoring' }, // inherent_risk_current
    { data: 'submission_date' },
    // { data: 'mitigation_planned' },
    // { data: 'management_review' },
    { data: 'Actions' }
  ],
  // columnDefinitions
  [
    {
      // Actions
      targets: -1,
      orderable: false,
      render: function (data, type, full, meta) {
        let url = URLs['show'];
        url = url.replace(':id', data);

        let returnedString = '';

        if (permission['show']) {
          returnedString += `<a  href="${url}" class="item-show">` +
            feather.icons['eye'].toSvg({ class: 'me-50 font-small-4' }) +
            '</a>';
        }
        if (permission['delete']) {
          returnedString += '<a  href="javascript:;" onclick="showModalDeleteRisk(' + data + ')" class="item-delete">' +
            feather.icons['trash-2'].toSvg({ class: 'me-50 font-small-4' }) +
            '</a>';
        }

        if (returnedString == '')
          returnedString = '------';

        return (
          returnedString
        );
      }
    },
    {
      // Label for tags
      targets: -3,
      render: function (data, type, full, meta) {
        return '<div class="risk-cell-holder" style="position:relative;">' + data[0] + '<span class="risk-color" style="background-color:' + data[1] + ';position: absolute;width: 20px;height: 20px;right: 10px;top: 50%;transform: translateY(-50%);border-radius: 2px;border: 1px solid;"></span></div>'
        // return '<span class="badge rounded-pill badge-light-success">' + data + '</span>';
      }
    }
  ],
  // detailsOfItem
  lang['DetailsOfItem'],
  // detailsOfItemKey
  'subject'
);
