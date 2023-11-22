@extends('admin/layouts/contentLayoutMaster')

@section('title', __('compliance.Past Audits'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')

    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('compliance.Past Audits') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">
                                <!-- Import and export container -->
                                <x-export-import name=" {{ __('compliance.Past Audits') }}" createPermissionKey='_'
                                    exportPermissionKey='audits.export'
                                    exportRouteKey='admin.compliance.audit.ajax.past.export'
                                    importRouteKey='will-added-TODO' />
                                <!--/ Import and export container -->
                            </div>
                        </div>
                    </div>
                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('compliance.framework') }}</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_framework"
                                        id="framework" data-column="1" data-column-index="0">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($frameworks as $framework)
                                            <option value="{{ $framework->name }}" data-id="{{ $framework->id }}">
                                                {{ $framework->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('compliance.sub_domain') }}</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_family"
                                        data-column="2" data-column-index="1">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($families as $family)
                                            <option value="{{ $family->name }}">{{ $family->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('compliance.Control') }}</label>
                                    <select class="form-control dt-input dt-select select2"
                                        name="filter_FrameworkControlWithFramworks" id="control" data-column="3"
                                        data-column-index="2">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($controls as $control)
                                            <option value="{{ $control->short_name }}">{{ $control->short_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.TestName') }}</label>
                                    <input class="form-control dt-input" name="filter_name" data-column="4"
                                        data-column-index="3" type="text">

                                </div>

                            </div>
                        </form>
                    </div>
                    <hr class="my-0" />

                    <div class="card-datatable">
                        <table class="dt-advanced-server-search table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('compliance.framework') }}</th>
                                    <th>{{ __('compliance.sub_domain') }}</th>
                                    <th>{{ __('compliance.Control') }}</th>
                                    <th>{{ __('compliance.test-name') }}</th>
                                    <th>{{ __('compliance.tester') }}</th>
                                    <th>{{ __('compliance.last-test') }}</th>
                                    <th>{{ __('compliance.next-test') }}</th>
                                    <th>{{ __('locale.Actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('compliance.framework') }}</th>
                                    <th>{{ __('compliance.sub_domain') }}</th>
                                    <th>{{ __('compliance.Control') }}</th>
                                    <th>{{ __('compliance.test-name') }}</th>
                                    <th>{{ __('compliance.tester') }}</th>
                                    <th>{{ __('compliance.last-test') }}</th>
                                    <th>{{ __('compliance.next-test') }}</th>
                                    <th>{{ __('locale.Actions') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Advanced Search -->
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        var permission = [],
            URLs = [],
            lang = [];
        permission['delete'] = {{ auth()->user()->hasPermission('audits.delete')? 1: 0 }};
        permission['result'] = {{ auth()->user()->hasPermission('audits.result')? 1: 0 }};
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('compliance.ActiveAudit')]) }}";
        URLs['ajax_list'] = "{{ route('admin.compliance.ajax.get-past-audits') }}";
    </script>
    <script src="{{ asset('ajax-files/compliance/active-audit.js') }}"></script>

    <script>
        function showResultAudit(id) {
            var url = "{{ route('admin.compliance.audit.edit', ':id') }}";
            url = url.replace(':id', id);
            window.location.href = url;
        }
    </script>
@endsection
