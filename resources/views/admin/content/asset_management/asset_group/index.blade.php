@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.AssetGroups'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')

    <!-- Advanced Search -->
    <x-asset-group-search id="advanced-search-datatable" :assets="$assets" :assetGroups="$assetGroups"
        createModalID="add-new-asset-group" />
    <!--/ Advanced Search -->

    <!-- Create Form -->
    @if (auth()->user()->hasPermission('asset_group.create'))
        <x-asset-group-form id="add-new-asset-group" :assets="$assets" title="{{ __('asset.AssetGroupCreate') }}" />
    @endif
    <!--/ Create Form -->

    <!-- Update Form -->
    @if (auth()->user()->hasPermission('asset_group.update'))
        <x-asset-group-form id="edit-asset-group" :assets="$assets" title="{{ __('asset.AssetGroupUpdate') }}" />
    @endif
    <!--/ Update Form -->
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection


@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    {{-- Add Verification translation --}}
    <script>
        const verifiedTranslation = "{{ __('locale.Verified') }}",
            UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}";
        var permission = [],
            URLs = [],
            lang = [];
        permission['edit'] = {{ auth()->user()->hasPermission('asset_group.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('asset_group.delete')? 1: 0 }};
        URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.asset_group.index') }}";

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.department')]) }}";
    </script>
    <script src="{{ asset('ajax-files/asset_management/asset_group/index.js') }}"></script>
    <script>
        // Submit form for creating asset
        $('#add-new-asset-group form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#add-new-asset-group').modal('hide');
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
        $('#edit-asset-group form').submit(function(e) {
            e.preventDefault();
            const id = $(this).find('input[name="id"]').val();
            let url = "{{ route('admin.asset_management.ajax.asset_group.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "PUT",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#edit-asset-group form').trigger("reset");
                        $('#edit-asset-group').modal('hide');
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

        function DeleteAsset(id) {
            let url = "{{ route('admin.asset_management.ajax.asset_group.destroy', ':id') }}";
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
        function ShowModalEditAsset(id) {
            let url = "{{ route('admin.asset_management.ajax.asset_group.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        const editForm = $("#edit-asset-group form");

                        // Start Assign asset data to modal
                        editForm.find('input[name="id"]').val(id);
                        editForm.find("input[name='name']").val(response.data.name);
                        editForm.find("input[name='ip']").val(response.data.ip);
                        response.data.assets.forEach(tagId => {
                            editForm.find(`select[name='assets[]'] option[value='${tagId}']`).attr(
                                'selected', true).trigger('change');
                        });
                        // End Assign asset data to modal
                        $('.dtr-bs-modal').modal('hide');
                        $('#edit-asset-group').modal('show');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show delete alert modal
        function ShowModalDeleteAsset(id) {
            $('.dtr-bs-modal').modal('hide');
            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: '@lang('locale.YouWontBeAbleToRevertThis')',
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
                    DeleteAsset(id);
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
            form.find('select').trigger('change');
        }

        $('.modal').on('hidden.bs.modal', function() {
            resetFormData($(this).find('form'));
        })
    </script>
@endsection
