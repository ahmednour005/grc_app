@extends('admin/layouts/contentLayoutMaster')

@section('title', __('compliance.ViewActiveAudits'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <style>
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: fit-content !important;
            }
        }

        .modal-add-new-role {
            margin-right: auto;
            margin-left: auto;
        }
    </style>
@endsection
@section('content')
    <section id="nav-filled">
        <div class="row match-height">
            <!-- Filled Tabs starts -->
            <div class="col-xl-12 col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link  active" id="audit-view-tab" data-bs-toggle="tab" href="#audit-view"
                                    role="tab" aria-controls="audit-view" aria-selected="true">
                                    <i data-feather="monitor"></i> {{ __('compliance.AuditResult') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="risks-tab-fill" data-bs-toggle="tab" href="#risks-fill"
                                    role="tab" aria-controls="risks-fill" aria-selected="false">
                                    <i data-feather="tool"></i> {{ __('compliance.Risks and Controls') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="comments-tab-fill" data-bs-toggle="tab" href="#comments-fill"
                                    role="tab" aria-controls="comments-fill" aria-selected="false">
                                    <i data-feather='message-circle'></i>{{ __('locale.Comments') }}
                                </a>
                            </li>
                            <li class="nav-item">

                                <a class="nav-link " id="AuditTrail" data-bs-toggle="tab" href="#AuditTrail-fill"
                                    role="tab" aria-controls="AuditTrail-fill" aria-selected="false">

                                    <i data-feather="list"></i> {{ __('compliance.AuditTrail') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="related-policy" data-bs-toggle="tab" href="#related-policy-fill"
                                    role="tab" aria-controls="related-policy-fill" aria-selected="false">
                                    <i data-feather="file"></i> {{ __('compliance.RelatedPolicy') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="objective-achievement" data-bs-toggle="tab" href="#objective-achievement-fill"
                                    role="tab" aria-controls="objective-achievement-fill" aria-selected="false">
                                    <i data-feather="file"></i> {{ __('compliance.ObjectiveAchievement') }}
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="audit-view" role="tabpanel" aria-labelledby="audit-view-tab">
                                <!-- edit audit -->
                                {{-- <x-Admin.Content.compliance.active-audit.edit :id="$id"
                                :auditStatusGroups="$auditStatusGroups"
                                :frameworkControlTestAudit="$frameworkControlTestAudit"
                                :testResultGroups="$testResultGroups"
                                :frameworkControlTestResult="$frameworkControlTestResult" :testers="$testers"
                                :teams="$teams" :testTeams="$testTeams" /> --}}

                                @include('admin.content.compliance.active-audit.edit')
                            </div>
                            <div class="tab-pane" id="risks-fill" role="tabpanel" aria-labelledby="risks-tab-fill">
                                <!--  audit risks -->

                                @include('admin.content.compliance.active-audit.risks')
                            </div>
                            <div class="tab-pane" id="comments-fill" role="tabpanel" aria-labelledby="comments-tab-fill">
                                <!--  audit comments -->
                                {{-- <x-Admin.Content.compliance.active-audit.comments :id="$id"
                                :comments="$FrameworkControlTestComments" /> --}}
                                @include('admin.content.compliance.active-audit.comments')
                            </div>
                            <div class="tab-pane" id="AuditTrail-fill" role="tabpanel" aria-labelledby="AuditTrail">
                                <!--  audit logs -->
                                {{-- <x-Admin.Content.compliance.active-audit.logs /> --}}
                                @include('admin.content.compliance.active-audit.logs')
                            </div>
                            <div class="tab-pane" id="related-policy-fill" role="tabpanel"
                                aria-labelledby="related-policy">
                                @include('admin.content.compliance.active-audit.related-policy')
                            </div>
                            <div class="tab-pane" id="objective-achievement-fill" role="tabpanel"
                                aria-labelledby="objective-achievement">
                                @include('admin.content.compliance.active-audit.objective-achievement')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filled Tabs ends -->


        </div>
    </section>

<!-- // List Evidences Modal -->

    <div class="modal fade" id="evidencesModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('compliance.Evidences') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div id="evidencesList">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/file-uploaders/dropzone.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('ajax-files/compliance/edit-active-audit.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/general-compliance.js') }}"></script>
    {{-- Risk scripts --}}
    <script>
        let riskAuditID = '{{ $id }}';
        // const createURL = "{{ route('admin.risk_management.ajax.store') }}",
        const createURL = "{{ route('admin.compliance.ajax.store-risk-with-audit') }}",
            lang = [];
        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        // Reset form
        function resetFormData(form) {
            $('.error').empty();
            form.trigger("reset")
            form.find('input:not([name="_token"])').val('');
            form.find('select.multiple-select2 option[selected]').attr('selected', false);
            form.find('select.select2 option').attr('selected', false);
            form.find("select.select2").each(function(index) {
                $(this).find('option').first().attr('selected', true);
            });
            form.find('select').trigger('change');
        }

        $('.modal').on('hidden.bs.modal', function() {
            resetFormData($(this).find('form'));
        })

        $(document).ready(function() {
            $('.multiple-select2').select2();

            // Load controls of framework
            $("[name='framework_id']").on('change', function() {
                const frameworkControls = $(this).find('option:selected').data('controls');
                $("[name='control_id']").find('option:not(:first)').remove();
                $("[name='control_id']").find('option:first').attr('selected', true)
                if (frameworkControls)
                    frameworkControls.forEach(frameworkControl => {
                        $("[name='control_id']").append(
                            `<option value="${frameworkControl.id}">${frameworkControl.short_name}</option>`
                        );
                    });
            });

            // Load Owner manager
            $("[name='owner_id']").on('change', function() {
                const ownerManger = $(this).find('option:selected').data('manager');
                $("[name='owner_manager_id']").find('option:not(:first)').remove();
                $("[name='owner_manager_id']").find('option:first').attr('selected', true)
                if (ownerManger)
                    $("[name='owner_manager_id']").append(
                        `<option value="${ownerManger.id}">${ownerManger.name}</option>`);
            });

            // Submit form for creating risk
            $('#add-new-risk form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('auditID', riskAuditID);
                let risks = $('#risk').val();

                risks.forEach(risk => {
                    formData.append('risks[]', risk);
                });

                $.ajax({
                    url: createURL,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status) {
                            makeAlert(data.alert ? 'warning' : 'success', data.alert ?
                                `${data.alert}<br>${data.message}` : `${data.message}`,
                                lang['success']);
                            $('#add-new-risk').modal('hide');
                            $("#advanced-search-datatable").load(location.href +
                                " #advanced-search-datatable>*", "");
                            if (data.redirect_to)
                                window.location.href = data.redirect_to;
                            // loadDatatable();
                        } else {
                            showError(data['errors']);
                        }
                    },
                    error: function(response, data) {
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
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

        // status [warning, success, error]
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>
    <script>
        function loadDatatable() {

            var id = '{{ $id }}';
            let url = "{{ route('admin.compliance.ajax.get-logs-audits', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {


                    createDatatable(data);
                },
                error: function() {
                    //
                }
            });
        }

        function createDatatable(JsonList) {
            var isRtl = $('html').attr('data-textdirection') === 'rtl';

            var dt_responsive_table = $('.dt-responsive');


            if ($('body').attr('data-framework') === 'laravel') {
                assetPath = $('body').attr('data-asset-path');
            }
            if (dt_responsive_table.length) {

                var dt_adv_filter = dt_responsive_table.DataTable({
                    data: JsonList,
                    columns: [{
                            data: 'responsive_id'
                        },
                        {
                            data: 'id'
                        },
                        {
                            data: 'user'
                        },
                        {
                            data: 'message'
                        },
                        {
                            data: 'created_at'
                        }
                    ],
                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }, {
                        // Label for verified
                        targets: -4,
                        render: function(data, type, full, meta) {
                            // return data ? `<pre>${JSON.stringify(data, null, '\t')}</pre>` : '';
                            return data ? JSON.stringify(data) : '';
                        }
                    }],
                    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    orderCellsTop: true,
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['name'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !== '' ?
                                        '<tr data-dt-row="' +
                                        col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');
                                return data ? $('<table class="table"/><tbody />').append(
                                    data) : false;
                            }
                        }
                    },
                    language: {
                        paginate: {
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });
            }
            // filter function after input keyup
            $('input.dt-input').on('keyup', function() {
                filterColumn($(this).attr('data-column'), $(this).val());
            });
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass(
                'form-control-sm');
        }
        loadDatatable();
    </script>
    <script>
        const filePath = "{{ asset('/uploads/compliance/') }}";
        // Dropzone FILES
        var id = "{{ $id }}";
        let deleteURL = "{{ route('admin.compliance.audit-file.destroy', ':id') }}";
        deleteURL = deleteURL.replace(':id', id);
        var url = "{{ route('admin.compliance.audit-file.store') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        Dropzone.options.dropzone = {
            maxFiles: 5,
            maxFilesize: 4,
            url: "{{ route('admin.compliance.audit-file.store') }}",
            //url:"{{ route('admin.governance.index') }}",
            /* success: function(file, response) {
                console.log(file);
                console.log(response);
                if (response != 0) {
                    // Download link
                    var anchorEl = document.createElement('a');
                    anchorEl.setAttribute('href', response);
                    anchorEl.setAttribute('target', '_blank');
                    anchorEl.innerHTML = "<br>Download";
                    file.previewTemplate.appendChild(anchorEl);
                }
            }*/
            method: 'POST',
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + "-" + file
                    .name; // to rename file name but i didn't use it. i renamed file with php in controller.
            },
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            params: {
                'id': id
            },
            init: function() {
                this.on("success", function(file, response) {
                    // $('#download-audit-file').append(`<a id="${response.unique_name.replace(/\./g, "-")}" style="padding: 7px 3px" class="btn btn-primary col-md-3 col-lg-2 col-12" href="${filePath}/${response.unique_name}" download><i style="margin: 0 5px" data-feather="file"></i>${response.name}</a>`);
                    location.reload();
                });

                var urlListImages = "{{ route('admin.compliance.audit-file.index') }}";
                // Get images
                var myDropzone = this;
                $.ajax({
                    url: urlListImages,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var file = {
                                unique_name: value.unique_name,
                                name: value.name,
                                size: value.size
                            };
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                            myDropzone.emit("complete", file);
                        });
                    }
                });
            },
            removedfile: function(file) {
                if (this.options.dictRemoveFile) {
                    return Dropzone.confirm("Are You Sure to " + this.options.dictRemoveFile, function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'DELETE',
                            url: deleteURL,
                            data: {
                                filename: file.unique_name
                            },
                            success: function(data) {
                                $('#' + file.unique_name.replace(/\./g, "-")).remove();
                                makeAlert('success', 'File has been successfully removed',
                                    "{{ __('locale.Success') }}");
                            },
                            error: function(e) {
                                makeAlert('error', "{{ __('locale.Error') }}",
                                    "{{ __('locale.Error') }}");
                            }
                        });
                        var fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                    });
                }
            },

            success: function(file, response) {
                file.previewElement.id = response.success;
                // set new images names in dropzone’s preview box.
                var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                file.previewElement.querySelector("img").alt = response.success;
                olddatadzname.innerHTML = response.success;
            },
            error: function(file, response) {
                if ($.type(response) === "string")
                    var message = response; //dropzone sends it's own error messages in string
                else
                    var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            }

        };
    </script>


    <script>
        $('#risk').on('change', function() {
            let risks = $(this).val();
            let auditID = '{{ $id }}';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('admin.compliance.ajax.risk-to-result') }}",
                data: {
                    risks: risks,
                    auditID: auditID
                },
                success: function(data) {
                    $('#risks-table-content').empty();
                    $('#risks-table-content').append(data);
                }
            });
        });

        /* Start related policy script */
        // Handle preview-policy-document click
        $('.preview-policy-document').on('click', function() {
            console.log($(this).data('document-id'));
            console.log('preview');
        })

        // Handle download-policy-document click
        $('.download-policy-document').on('click', function() {
            console.log($(this).data('document-id'));
            console.log('download');

            // Download note file start
            const form = $('#download-file-form');
            form.find('[name="document_id"').val($(this).data('document-id'));

            form.trigger('submit');
            // Download note file End
        })

        // Handle approve-policy-document click
        $('.approve-policy-document').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_policy_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('document-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-success">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-policy-document click
        $('.reject-policy-document').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_policy_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('document-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-danger">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
        /* End related policy script */


          // Handle approve-objective click
          $('.approve-objective').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_objective_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('objective-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="status-span badge rounded-pill badge-light-success" data-objective-id="${$(that).data('objective-id')}">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-objective click
        $('.reject-objective').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_objective_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('objective-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="status-span badge rounded-pill badge-light-danger" data-objective-id="${$(that).data('objective-id')}">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
        // Handle view-objective-evidences click
        $('.view-objective-evidences').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.view_objective_evidences') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    objective_id: $(that).data('objective-id'),
                    test_id: $(that).data('test-id'),
                    editable: $(that).data('editable'),
                },
                success: function(data) {
                    if (data.status) {
                        $('#evidencesList').html(data.html);
                        $('#evidencesModal').modal('show');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

            // Handle approve-evidence click
            $('.approve-evidence').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('evidence-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-success">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-evidence click
        $('.reject-evidence').on('click', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('evidence-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="badge rounded-pill badge-light-danger">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
    </script>
@endsection
