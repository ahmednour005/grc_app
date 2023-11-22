@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.SetKPIAssessment'))

@section('vendor-style')
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
    <x-KPI-assessment-search id="advanced-search-datatable" :departments="$departments" :kpis="$KPIs" createModalID="add-new-KPI" />
    <!--/ Advanced Search -->

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
    <script>
        permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('KPI.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('KPI.delete')? 1: 0 }};
        permission['InitiateAssessment'] = {{ auth()->user()->hasPermission('KPI.Initiate assessment')? 1: 0 }};

        const lang = []
        URLs = [];
        lang['user'] = "{{ __('locale.User') }}";

        URLs['ajax_list'] = "{{ route('admin.KPI.ajax.assessment.all') }}";
        URLs['set_assessment'] = "{{ route('admin.KPI.ajax.assessment.set') }}";

        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['SetKPIAssessment'] = "{{ __('hierarchy.SetKPIAssessment') }}";
        lang['ListKPIAssessments'] = "{{ __('hierarchy.ListKPIAssessments') }}";
    </script>
    <script src="{{ asset('ajax-files/KPI/assessment/index.js') }}"></script>
@endsection
