@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.framework_control_compliance_status'))
@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<section class="basic-select2">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('report.Report') }}:
                            {{ __('report.framework_control_compliance_status') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="form-label">{{ __('report.Framework') }}:</label>
                            <select class="form-control select2 " name="framework_id" id="framework">
                                <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                @foreach ($frameworks as $framework)
                                <option value="{{ $framework->id }}">{{ $framework->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="error error-framework_id"></span>
                        </div>
                        <div id="report-table-container" class="pt-2" style="display: none">
                            <button data-filename = "{{ __('report.framework_control_compliance_status') }} {{ __('report.Report') }}" type="button" class="btn btn-outline-primary export-pdf-btn">
                                <i data-feather="file-text" class="me-25"></i>
                                <span>{{ __('locale.Export') }} PDF</span>
                            </button>
                            <div class="row" id="exported-part-container" class="exported-part-container">
                            </div>
                        </div>
                        <!-- START Test htnl2pdf -->
                        <!-- END Test htnl2pdf -->
                        <div class="demo-spacing-0 mt-2" style="display: none" id="report-table-container-empty">
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-body text-center">
                                    {{ __('locale.ThereIsNoData') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('js/scripts/html2pdf_v0.10.1_.bundle.min.js') }}"></script>

<script>
    const reportName = "{{ __('report.framework_control_compliance_status') }} {{ __('report.Report') }}";
    $('#framework').on('change', function(e) {
        const framework = $(this).val();
        $.ajax({
            url: "{{ route('admin.reporting.framewrok_control_compliance_status_info') }}"
            , type: "POST"
            , data: {
                framework_id: framework
                , _token: $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(response) {
                if (response.status) {
                    if (response.data.domains.length) {
                        $('#report-table-container .row').html(''); // Remove old content
                            $('#report-table-container .row').append(`<h1 class="text-center" style="font-size: 1.5rem;"><span class="badge rounded-pill badge-glow bg-primary" style="font-size: 1.5rem; padding: 0.5rem 1.5rem; line-height: unset;">${reportName}</span></h1><p class="text-center">${response.data.dateTime}</p>`);

                        response.data.domains.forEach((domain, domainIndex) => {
                            let content = '';

                            $('#report-table-container .row').append(`<h3>${domainIndex+1} - ${domain.name}</h3>`);

                            // Get all sub-domains of domain
                            domain.families.forEach((subDomain, subDomainIndex) => {
                                content = `<div class="table-responsive mb-2"><table class="table"><thead><tr><th style="vertical-align: center;">${domainIndex+1}-${subDomainIndex+1}</th><th colspan="3">${subDomain.name}</th></tr></thead>`;
                                if (subDomain.framework_controls.length) {
                                    content += `<tbody><tr><td style="" rowspan="2">رقم الضابط اﻷساسى</td><td style="" rowspan="2">رقم الضابط الفرعى</td><td style="" colspan="2" class="text-center">مستوى اﻹلتزام</td></tr><tr><td style="">الضابط اﻷساسى</td><td style="">الضابط الفرعى</td></tr>`;

                                    // Get parent controls of sub-domain
                                    subDomain.framework_controls.forEach((frameworkControl) => {
                                        content += `<tr><td style="">${frameworkControl.control_number ?? ''}</td><td style="text-align:center;">-</td><td style=" background-color: ${response.data.control_status_colors[frameworkControl.control_status]}">${frameworkControl.control_status }</td><td style="text-align:center;">-</td></tr>`;

                                        // Get child controls of parent control
                                        frameworkControl.framework_controls.forEach((subFrameworkControl) => {
                                            content += `<tr><td style="">-</td><td style="">${subFrameworkControl.control_number ?? ''}</td><td style="text-align:center;">-</td><td style="" style="background-color: ${response.data.control_status_colors[subFrameworkControl.control_status]}">${subFrameworkControl.control_status}</td></tr>`;
                                        });
                                    });
                                    content += `</tbody>`;
                                }
                                content += `</table></div>`;
                                $('#report-table-container .row').append(content);
                                content = '';
                            });
                            $('#report-table-container .row').append('<hr>');
                        });
                        $('#report-table-container-empty').slideUp();
                        $('#report-table-container').slideDown();

                        // var newWin = open('url','windowName','height=300,width=300');
                        // newWin.document.write($('#report-table-container').html());
                    } else {
                        $('#report-table-container-empty').slideDown();
                        $('#report-table-container').slideUp();
                    }

                    makeAlert('success', response.message, '@lang("locale.Success")');
                } else {
                    $('#report-table-container-empty').slideDown();
                    $('#report-table-container').slideUp();
                    showError(response.errors);
                }
            }
            , error: function(response, data) {
                $('#report-table-container-empty').slideDown();
                $('#report-table-container').slideUp();
                const responseData = response.responseJSON;
                makeAlert('error', responseData.message, '@lang("locale.Error")');
                showError(responseData.errors);
            }
        });
    });

    // status [warning, success, error]
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true
            , tapToDismiss: false
        , });
    }

    // function to show error validation 
    function showError(data) {
        $('.error').empty();
        $.each(data, function(key, value) {
            $('.error-' + key).empty();
            $('.error-' + key).append(value);
        });
    }

</script>
@endsection
