@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Dashboard'))

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
<style>
    .feather {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

</style>
@endsection
@section('content')

<section>

    {{-- single card --}}
    <div class="row dashboard">
        @if(auth()->user()->hasPermission('framework.list'))
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div>
                        <h2 class="fw-bolder mb-0">{{ $Frameworks['count'] }}</h2>
                        <p class="card-text">{{ __('locale.Frameworks') }}</p>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="size-18" data-feather='layers'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('asset.list'))
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <div>
                        <h2 class="fw-bolder mb-0">{{ $Assets['count'] }}</h2>
                        <p class="card-text">{{ __('locale.Assets') }}</p>
                    </div>
                    <div class="avatar bg-light-dark p-50 m-0">
                        <div class="avatar-content">
                            <i class="size-18" data-feather='file'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('asset_group.list'))
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header bg-success">
                    <div>
                        <h2 class="fw-bolder mb-0">{{ $Assets['Groupcount'] }}</h2>
                        <p class="card-text">{{ __('locale.AssetGroups') }}</p>
                    </div>
                    <div class="avatar bg-light-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="size-18" data-feather='cpu'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('user_management.list'))
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <div>
                        <h2 class="fw-bolder mb-0">{{ $Teams['count'] }}</h2>
                        <p class="card-text">{{ __('locale.Teams') }}</p>
                    </div>
                    <div class="avatar bg-light-danger p-50 m-0">
                        <div class="avatar-content">
                            <i class="size-18" data-feather='users'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('department.list'))
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <div>
                        <h2 class="fw-bolder mb-0">{{ $Departments['count'] }}</h2>
                        <p class="card-text">{{ __('locale.Departments') }}</p>
                    </div>
                    <div class="avatar bg-light-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="size-18" data-feather='clipboard'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('job.list'))
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <div>
                        <h2 class="fw-bolder mb-0">{{ $Jobs['count'] }}</h2>
                        <p class="card-text">{{ __('locale.Jobs') }}</p>
                    </div>
                    <div class="avatar bg-light-info p-50 m-0">
                        <div class="avatar-content">
                            <i class="size-18" data-feather='circle'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- multi card --}}
    <div class="row dashboard">

        @if(auth()->user()->hasPermission('user_management.list'))
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Users') }}</h4>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='users'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Users['count'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.Users') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='users'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Users['active'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.UsersActive') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='users'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Users['deactive'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.UsersDeactivate') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='users'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Users['grc'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.GrcUsers') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='users'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Users['ldap'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.LdapUsers') }}</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('control.list'))
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Controls') }}</h4>

                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='clipboard'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Controls['count'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.Controls') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='clipboard'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Controls['active'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.ControlsActive') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class="item d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <i class="size-18" data-feather='clipboard'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Controls['close'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.ControlsClose') }}</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('document.list'))
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Documentation') }}</h4>

                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                {{-- <div class="avatar bg-light-warning me-2">
                                    <div class="avatar-content">
                                        <i data-feather='file-text'></i>
                                    </div>
                                </div> --}}
                                <a href="{{ route('admin.governance.category') }}" class="avatar bg-light-warning me-2">
                                    <div class="avatar-content">
                                        <i data-feather='file-text'></i>
                                    </div>
                                </a>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Documents['count'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.Documents') }}</p>
                                </div>
                            </div>
                        </div>
                        @foreach ($Documents['DocumentTypes'] as $DocumentType)
                        <div class="col-md-3 col-sm-6 col-12 mb-2 mt-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                {{-- <div class="avatar bg-light-warning me-2">
                                    <div class="avatar-content">
                                        <i data-feather='file-text'></i>
                                    </div>
                                </div> --}}
                                <a href="{{ route('admin.governance.category') }}?doc_type={{ $DocumentType->id }}" class="avatar bg-light-warning me-2">
                                    <div class="avatar-content">
                                        <i data-feather='file-text'></i>
                                    </div>
                                </a>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $DocumentType->documents->count() }}</h4>
                                    <p class="card-text font-small-3 mb-0">
                                        {{ $DocumentType->name . ' ' . __('locale.Type') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasPermission('riskmanagement.list'))
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.RiskManagement') }}</h4>

                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                <div class="avatar bg-light-danger me-2">
                                    <div class="avatar-content">
                                        <i data-feather='compass'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Risks['count'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.RisksCount') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                <div class="avatar bg-light-danger me-2">
                                    <div class="avatar-content">
                                        <i data-feather='compass'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Risks['Open'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.RisksOpen') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                <div class="avatar bg-light-danger me-2">
                                    <div class="avatar-content">
                                        <i data-feather='compass'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Risks['Close'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.RisksClose') }}</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('audits.list'))
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Compliance') }}</h4>

                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <i data-feather='shield'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Audits['count'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.Audits') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <i data-feather='shield'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Audits['active'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.ActiveAudits') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mt-2 mb-2 mb-md-0">
                            <div class=" item d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <i data-feather='shield'></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $Audits['past'] }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('locale.PastAudits') }}</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- table card --}}
    <div class="row" id="table-bordered">
        @if(auth()->user()->hasPermission('framework.list'))
        <div class="col-6">
            <div class="card p-1">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Count Controls Of Framework') }}</h4>
                </div>
                <div class="table-responsive">
                    <table class="dt-advanced-search table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.Frameworks') }}</th>
                                <th>{{ __('locale.Count Controls Of Framework') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Frameworks['all'] as $Framework)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $Framework->name }}
                                </td>
                                <td>
                                    {{ $Framework->FrameworkControls->count() }}
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.Frameworks') }}</th>
                                <th>{{ __('locale.Count Controls Of Framework') }}</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->hasPermission('control.list'))
        <div class="col-6">
            <div class="card p-1">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Count Audits Of Control') }}</h4>
                </div>
                <div class="table-responsive">
                    <table class="dt-advanced-search table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.Control') }}</th>
                                <th>{{ __('locale.Count Audits Of Control') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Controls['all'] as $Control)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{-- {{ $Control->short_name }} --}}
                                     @php
                                            $controlName = $Control->short_name;
                                        if ($Control->Frameworks()->count()) {
                                            $controlName .= ' (' . implode(', ', $Control->Frameworks()->pluck('name')->toArray()) . ')';
                                        }
                                    @endphp
                                    {{ $controlName }}
                                </td>
                                <td>
                                    {{ $Control->frameworkControlTestAudits->count() }}
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>{{ __('locale.Control') }}</th>
                                <th>{{ __('locale.Count Audits Of Control') }}</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

</section>





@endsection
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
@endsection

@section('page-script')


<script>
    $(document).ready(function() {
        $('.table').DataTable({
            dom: 'Bfrtip'
            , responsive: true
            , autoWidth: true
            , searching: true
            , columnDefs: [{
                    title: '#'
                    , className: 'index'
                    , orderable: false
                    , responsivePriority: 0
                    , targets: 0
                }

            ]
            , buttons: [{
                extend: 'colvis'
                , columns: ':not(.noVis)'
            }]
            , orderCellsTop: true
            , language: {
                paginate: {
                    previous: '&nbsp;'
                    , next: '&nbsp;'
                }
            }
            , responsive: {
                details: {

                    type: 'column'
                    , renderer: function(api, rowIdx, columns) {
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

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }
        , });
    });

</script>



@endsection
