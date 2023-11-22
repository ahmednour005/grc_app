@extends('admin/layouts/contentLayoutMaster')

@section('title', __('asset.Assets'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection
@section('content')

    <!-- Advanced Search -->
    <x-asset-search id="advanced-search-datatable" :assetValues="$assetValues" :assetCategories="$assetCategories" :locations="$locations"
        createModalID="add-new-asset" />
    <!--/ Advanced Search -->

    <!-- Create Form -->
    @if (auth()->user()->hasPermission('asset.create'))
        <x-asset-form id="add-new-asset" title="{{ __('locale.AddANewAsset') }}" :assetValues="$assetValues" :assetCategories="$assetCategories"
            :locations="$locations" :teams="$teams" :tags="$tags" />
    @endif
    <!--/ Create Form -->

    <!-- Update Form -->
    @if (auth()->user()->hasPermission('asset.update'))
        <x-asset-form id="edit-asset" title="{{ __('locale.Edit Assets') }}" :assetValues="$assetValues" :assetCategories="$assetCategories"
            :locations="$locations" :teams="$teams" :tags="$tags" />
    @endif
    <!--/ Update Form -->


    <div class="modal fade" id="exampleModalLong" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modal-body">

                        <section class="modern-horizontal-wizard">
                            <div class="bs-stepper wizard-modern modern-wizard-example">
                                <div class="bs-stepper-header">
                                    @foreach ($assetValueCategories as $category)
                                        <div class="step" data-target="#asset-value-{{ $category->id }}" role="tab"
                                            id="asset-value-{{ $category->id }}-trigger">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">
                                                    <i data-feather="file-text" class="font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">{{ $category->name }}</span>

                                                </span>
                                            </button>
                                        </div>

                                        @if (!$loop->last)
                                            <div class="line">
                                                <i data-feather="chevron-right" class="font-medium-2"></i>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                                <div class="bs-stepper-content">

                                    @foreach ($assetValueCategories as $category)
                                        <div id="asset-value-{{ $category->id }}"
                                            class="content category-content @if ($category->type == 1) category-avg-content @endif"
                                            role="tabpanel" aria-labelledby="asset-value-{{ $category->id }}-trigger">
                                            <div class="content-header">
                                                <h5 class="mb-0">{{ $category->name }}</h5>

                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    @foreach ($category->questions as $question)
                                                    <div class="row category-row">
                                                         <div class="mb-1 col-md-5">
                                                            <input type="text" class="form-control" value="{{ $question->question }}" id="" readonly>
                                                            </div>
                                                            @if ($category->type == 0)
                                                                <div class="mb-1 col-md-5">
                                                                    <select class="select2 w-100 select-item">
                                                                        <option value="0">{{ __('locale.No') }}
                                                                        </option>
                                                                        <option value="1">{{ __('locale.Yes') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-1 col-md-1">
                                                                    <input type="text"
                                                                        class="form-control select-item-value"
                                                                        value="0" readonly>
                                                                </div>
                                                            @else
                                                                <div class="mb-1 col-md-6">
                                                                    <select class="select2 w-100 select-item">
                                                                        @foreach (json_decode($question->answers, true) as $answer)
                                                                            <option value="{{ $answer['value'] }}">
                                                                                {{ $answer['answer'] }}</option>
                                                                            @if ($loop->first)
                                                                                @php
                                                                                    $firstValue = $answer['value'];
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="mb-1 col-md-1">
                                                                    <input type="text"
                                                                        class="form-control select-item-value"
                                                                        value="{{ $firstValue }}" readonly>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-7">
                                                    <input type="hidden" class="total-category-input-number">
                                                    <div class="alert alert-primary p-2 total-category-number"
                                                        role="alert">
                                                        {{ __('locale.Total') }} ( {{ $category->name }} )
                                                        {{ __('locale.Number') }} : <span> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($loop->last)
                                                <div class="row">
                                                    <div class="col-7">
                                                        <input type="hidden" class="return-total-impact-input-number">
                                                        <div class="alert alert-primary p-2 total-impact-input-number"
                                                            role="alert">
                                                            {{ __('locale.businessImpactAnalysis') }} : <span> ( 0 )
                                                            </span>
                                                        </div>
                                                        <div class="alert alert-danger p-2 check-valid-impact d-none"
                                                            role="alert">
                                                            <span> {{ __('locale.not_invaild_value_please_check_again') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            <div class="d-flex justify-content-between">
                                                @if ($loop->first)
                                                    <button class="btn btn-outline-secondary btn-prev" disabled>
                                                        <i data-feather="arrow-left"
                                                            class="align-middle me-sm-25 me-0"></i>
                                                        <span class="align-middle d-sm-inline-block d-none">{{ __('locale.Previous') }} </span>
                                                    </button>
                                                @else
                                                    <button class="btn btn-primary btn-prev">
                                                        <i data-feather="arrow-left"
                                                            class="align-middle me-sm-25 me-0"></i>
                                                        <span class="align-middle d-sm-inline-block d-none">{{ __('locale.Previous') }} </span>
                                                    </button>
                                                @endif
                                                @if ($loop->last)
                                                    <button class="btn btn-primary  category-impact-submit">{{ __('locale.Save') }} </button>
                                                @else
                                                    <button class="btn btn-primary btn-next">
                                                        <span class="align-middle d-sm-inline-block d-none">{{ __('locale.Next') }} </span>
                                                        <i data-feather="arrow-right"
                                                            class="align-middle ms-sm-25 ms-0"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        </section>

                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection

@section('vendor-script')
    <script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script>
        var assetValueLevels = {!! json_encode($assetValueLevels->toArray()) !!};

        $(document).on('change', '.select-item', function() {
            $(this).parents('.category-row').find('.select-item-value').val($(this).val());
            updateCategoryTotalNumber($(this));
            totalImpactNumber();
        });

        function totalImpactNumber() {
            var maxVal = 0;
            $('.total-category-input-number').each(function(index, element) {
                var currentVal = parseInt($(this).val()) || 0;
                if (currentVal > maxVal) {
                    maxVal = currentVal;
                }
            });
            var correspondingObject = assetValueLevels.find(function(obj) {
                return obj.level == maxVal;
            });

            if (correspondingObject) {
                var correspondingName = correspondingObject.name;
                var correspondingId = correspondingObject.id;

                $('.total-impact-input-number span').text(' ( ' + maxVal + ' ) - ( ' + correspondingName + ' ) ');
                $('.asset_value_impact').val(' ( ' + maxVal + ' ) - ( ' + correspondingName + ' ) ');
                $('.return-total-impact-input-number').val(correspondingId);
                $('.check-valid-impact').addClass('d-none');
            } else {
                $('.asset_value_impact').val('');
                $('.total-impact-input-number span').text(maxVal);
                $('.return-total-impact-input-number').val('');

            }

        }

        function updateCategoryTotalNumber(_that) {
            var totalElement = _that.parents('.category-content').find('.total-category-number span');
            var inputElement = _that.parents('.category-content').find('.total-category-input-number');

            var isAvgContent = _that.parents('.category-content').hasClass('category-avg-content');

            var values = _that.parents('.category-content').find('.category-row .select-item-value');
            var total = 0;

            values.each(function() {
                total += parseInt($(this).val());
            });

            if (isAvgContent) {
                var average = total / values.length;
                var roundedAverage = Math.round(average);
                totalElement.text(' (  ' + roundedAverage + ' ) ');
                inputElement.val(roundedAverage);
            } else {
                totalElement.text(' ( ' + total + ' ) ');
                inputElement.val(total);
            }
        }

        $(document).on('click', '.category-impact-submit', function() {

            valId = $('.return-total-impact-input-number').val();

            if (valId != '') {
                $('.check-valid-impact').addClass('d-none');
                totalImpactNumber();
                $('.asset_value_impact_level').val(valId);
                $('#exampleModalLong').modal('hide');

            } else {
                $('.check-valid-impact').removeClass('d-none');

            }


        });

        // Example of calling the function
        // Pass the element that triggered the update (e.g., a button or select)
        var buttonElement = $('.example-button');
        updateCategoryTotalNumber(buttonElement);




        {{--  $('.select-item').trigger('change');  --}}
    </script>
    {{-- Add Verification translation --}}
    <script>
        const verifiedTranslation = "{{ __('locale.Verified') }}",
            UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}",
            customDay = "{{ trans_choice('locale.custom_days', 1) }}",
            customDays = "{{ trans_choice('locale.custom_days', 3) }}",
            assetInQuery = "{{ $assetInQuery }}";

        var permission = [],
            lang = [],
            URLs = [];
        permission['edit'] = {{ auth()->user()->hasPermission('asset.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('asset.delete')? 1: 0 }};

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.asset')]) }}";

        URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.index') }}";
    </script>

    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

    <script>
        // Submit form for creating asset
        $('#add-new-asset form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#add-new-asset').modal('hide');
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
        $('#edit-asset form').submit(function(e) {
            e.preventDefault();
            const id = $(this).find('input[name="id"]').val();
            let url = "{{ route('admin.asset_management.ajax.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "PUT",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#edit-asset form').trigger("reset");
                        $('#edit-asset').modal('hide');
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
            let url = "{{ route('admin.asset_management.ajax.destroy', ':id') }}";
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
            let url = "{{ route('admin.asset_management.ajax.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        const editForm = $("#edit-asset form");

                        // Start Assign asset data to modal
                        editForm.find('input[name="id"]').val(id);
                        editForm.find("input[name='name']").val(response.data.name);
                        editForm.find("input[name='ip']").val(response.data.ip);
                        editForm.find(
                                `select[name='asset_value_id'] option[value='${response.data.asset_value_id}']`)
                            .attr('selected', true).trigger('change');
                        editForm.find(
                                `select[name='asset_category_id'] option[value='${response.data.asset_category_id}']`
                            )
                            .attr('selected', true).trigger('change');
                        editForm.find(`select[name='location_id'] option[value='${response.data.location_id}']`)
                            .attr('selected', true).trigger('change');
                        response.data.teams.forEach(teamId => {
                            editForm.find(`select[name='teams[]'] option[value='${teamId}']`).attr(
                                'selected', true).trigger('change');
                        });
                        response.data.tags.forEach(tagId => {
                            editForm.find(`select[name='tags[]'] option[value='${tagId}']`).attr(
                                'selected', true).trigger('change');
                        });

                        editForm.find("input[name='expiration_date']").val(response.data.expiration_date);
                        editForm.find("input[name='start_date']").val(response.data.start_date);
                        editForm.find("input[name='alert_period']").val(response.data.alert_period);
                        editForm.find("textarea[name='details']").val(response.data.details);
                        editForm.find("input[name='verified']").attr('checked', response.data.verified);
                        if (response.data.verified) {
                            editForm.find("input[name='verified']").attr('checked', true);
                        } else {
                            editForm.find("input[name='verified']").attr('checked', false);
                        }
                        var correspondingObject = assetValueLevels.find(function(obj) {
                            return obj.id == response.data.asset_value_level_id;
                        });

                        if (correspondingObject) {
                            var correspondingName = correspondingObject.name;
                            var correspondingLevel = correspondingObject.level;
                            editForm.find(".asset_value_impact").val(' ( ' + correspondingLevel + ' ) - ( ' +
                                correspondingName + ' ) ');
                        } else {
                            editForm.find(".asset_value_impact").val('');
                        }
                        editForm.find("input[name='asset_value']").val(response.data.asset_value_level_id);

                        // End Assign asset data to modal
                        $('.dtr-bs-modal').modal('hide');
                        $('#edit-asset').modal('show');
                    }
                    // alert(1);
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
