@extends('admin/layouts/contentLayoutMaster')

@section('title', __('risk.Submit Risk'))

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')

    <!-- Advanced Search -->
    <x-submit-risk-search id="advanced-search-datatable" createModalID="add-new-risk" />
    <!--/ Advanced Search -->

    <!-- Create Form -->
    @if (auth()->user()->hasPermission('riskmanagement.create'))
        <x-submit-risk-form id="add-new-risk" title="{{ __('risk.AddANewRisk') }}" :riskGroupings="$riskGroupings" :threatGroupings="$threatGroupings"
            :locations="$locations" :frameworks="$frameworks" :assets="$assets" :assetGroups="$assetGroups" :categories="$categories" :technologies="$technologies"
            :teams="$teams" :enabledUsers="$enabledUsers" :riskSources="$riskSources" :riskScoringMethods="$riskScoringMethods" :riskLikelihoods="$riskLikelihoods" :impacts="$impacts"
            :tags="$tags" :owners="$owners"/>
    @endif
    <!--/ Create Form -->

    <!-- Update Form -->
    {{-- <x-submit-risk-form id="edit-risk" title="{{ __('locale.EditRisk') }}" :riskGroupings = "$riskGroupings" :threatGroupings = "$threatGroupings" :locations = "$locations" :frameworks = "$frameworks" :categories = "$categories" :technologies = "$technologies" :teams = "$teams" :enabledUsers = "$enabledUsers" :riskSources = "$riskSources" :riskScoringMethods = "$riskScoringMethods" :riskLikelihoods = "$riskLikelihoods" :impacts = "$impacts" :tags = "$tags" /> --}}
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
        let URLs = [],
            lang = [];
        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['confirmDeleteMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.risk')]) }}";
        permission = [];
        permission['show'] = {{ auth()->user()->hasPermission('riskmanagement.view')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('riskmanagement.delete')? 1: 0 }};
        URLs['ajax_list'] = "{{ route('admin.risk_management.ajax.index') }}";
        URLs['show'] = "{{ route('admin.risk_management.show', ':id') }}";
        URLs['create'] = "{{ route('admin.risk_management.ajax.store') }}";
        URLs['delete'] = "{{ route('admin.risk_management.ajax.destroy', ':id') }}";
    </script>
    <script src="{{ asset('ajax-files/risk_management/index.js') }}"></script>

@endsection
