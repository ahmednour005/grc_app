@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.Domains Management'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')

    <!-- Advanced Search -->
    <x-domain-management-search id="advanced-search-datatable" :domains="$domains" :subDomains="$subDomains"
        createModalID="add-new-domain" />
    <!--/ Advanced Search -->

    <!-- Create Form -->
    @if (auth()->user()->hasPermission('domain.create'))
        <x-domain-management-form id="add-new-domain" title="{{ __('configure.AddANewDomain') }}" :domains="$domains" />
    @endif
    <!--/ Create Form -->

    <!-- Update Form -->
    @if (auth()->user()->hasPermission('domain.update'))
        <x-domain-management-form id="edit-domain" title="{{ __('configure.EditDomain') }}" :domains="$domains" />
    @endif
    <!--/ Update Form -->

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        var permission = [],
            lang = [],
            URLs = [];
        permission['show'] = {{ auth()->user()->hasPermission('domain.view')? 1: 0 }};
        permission['edit'] = {{ auth()->user()->hasPermission('domain.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('domain.delete')? 1: 0 }};

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('configure.domain')]) }}";
        URLs['ajax_list'] = "{{ route('admin.configure.domain_management.ajax.index') }}";
    </script>
    <script src="{{ asset('ajax-files/configure/domain_management/index.js') }}"></script>
    <script>
        // Submit form for creating asset
        $('#add-new-domain form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#add-new-domain').modal('hide');
                        redrawDatatable();
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });

        // Submit form for editing asset
        $('#edit-domain form').submit(function(e) {
            e.preventDefault();
            const id = $(this).find('input[name="id"]').val();
            let url = "{{ route('admin.configure.domain_management.ajax.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "PUT",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#edit-domain form').trigger("reset");
                        $('#edit-domain').modal('hide');
                        redrawDatatable();
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });

        function DeleteDomain(id) {
            let url = "{{ route('admin.configure.domain_management.ajax.destroy', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        redrawDatatable();
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show modal for editing
        function ShowModalEditDomain(id) {
            let url = "{{ route('admin.configure.domain_management.ajax.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        const editForm = $("#edit-domain form");

                        // Start Assign domain data to modal
                        editForm.find('input[name="id"]').val(id);
                        editForm.find("input[name='name']").val(response.data.name);
                        editForm.find(`select[name='parent_id'] option[value='${response.data.parent_id}']`)
                            .attr('selected', true).trigger('change');
                        editForm.find("input[name='order']").val(response.data.order);
                        // End Assign domain data to modal

                        $('.dtr-bs-modal').modal('hide');
                        $('#edit-domain').modal('show');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show delete alert modal
        function ShowModalDeleteDomain(id) {
            $('.dtr-bs-modal').modal('hide');
            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: "{{ __('locale.YouWontBeAbleToRevertThis') }}",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    DeleteDomain(id);
                }
            });
        }

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
            form.find('textarea').text('');

            form.find('select').trigger('change');
        }

        $('.modal').on('hidden.bs.modal', function() {
            resetFormData($(this).find('form'));
        })
    </script>

@endsection
