@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.User Management'))

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
                            <h4 class="card-title">{{ __('configure.ManageUsers') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">
                                @if (auth()->user()->hasPermission('user_management.create'))
                                    @if (checkUsersCount(102))
                                        <a class="dt-button  btn btn-primary  me-2 waves-effect waves-float waves-light"
                                            href="{{ route('admin.configure.user.create') }}" type="button">
                                            {{ __('configure.AddUsers') }}
                                        </a>
                                    @endif
                                @endif



                                <x-export-import name=" {{ __('configure.User') }}"
                                    createPermissionKey='user_management.create'
                                    exportPermissionKey='user_management.export'
                                    exportRouteKey='admin.configure.user.ajax.export' importRouteKey='will-added-TODO' />

                            </div>
                        </div>

                    </div>

                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('configure.Type') }}</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_type"
                                        id="type" data-column="1" data-column-index="0">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        <option value="grc" data-id="grc">Grc</option>
                                        <option value="ldap" data-id="ldap">Ldap</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">{{ __('configure.Role') }}</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_role"
                                        data-column="5" data-column-index="4">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('configure.Department') }}</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_department"
                                        id="control" data-column="8" data-column-index="2">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('configure.Username') }}</label>
                                    <input class="form-control dt-input" name="filter_username" data-column="2"
                                        data-column-index="1" type="text">
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
                                    <th>{{ __('configure.Type') }}</th>
                                    <th>{{ __('configure.Username') }}</th>
                                    <th>{{ __('configure.Name') }}</th>
                                    <th>{{ __('configure.Email') }}</th>
                                    <th>{{ __('configure.Role') }}</th>
                                    <th>{{ __('locale.Admin') }}</th>
                                    <th>{{ __('locale.Active') }}</th>
                                    <th>{{ __('configure.Department') }}</th>
                                    <th>{{ __('locale.Actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('configure.Type') }}</th>
                                    <th>{{ __('configure.Username') }}</th>
                                    <th>{{ __('configure.Name') }}</th>
                                    <th>{{ __('configure.Email') }}</th>
                                    <th>{{ __('configure.Role') }}</th>
                                    <th>{{ __('locale.Admin') }}</th>
                                    <th>{{ __('locale.Active') }}</th>
                                    <th>{{ __('configure.Department') }}</th>
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
        const currentUser = {{ auth()->id() }};
        let permission = [],
            lang = [],
            URLs = [];
        permission['edit'] = {{ auth()->user()->hasPermission('user_management.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('user_management.delete')? 1: 0 }};

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.user')]) }}";

        URLs['ajax_list'] = "{{ route('admin.configure.user.ajax.get-users') }}";
    </script>
    <script src="{{ asset('ajax-files/user_management/index.js') }}"></script>

    <script>
        function UserEdit(id) {
            var url = "{{ route('admin.configure.user.edit', ':id') }}";
            url = url.replace(':id', id);
            window.location.href = url;
        }

        function ChangeAccountStutas(id) {
            let url = "{{ route('admin.configure.user.ajax.account-status', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    </script>
@endsection
