<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                    <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">
                            @if (auth()->user()->hasPermission('control-objective.create'))
                                <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#{{ $createModalID }}">
                                    {{ __('locale.AddANewControlObjective') }}
                                </button>
                                <a href="{{ route('admin.control_objectives.notificationsSettingsobjective') }}" class="dt-button btn btn-primary me-2"
                                target="_self">
                                {{ __('locale.NotificationsSettings') }}
                            </a>
                            @endif

                            <!-- Import and export container -->
                            <x-export-import name=" {{ __('locale.ControlObjective') }}" createPermissionKey='control-objective.create'
                                exportPermissionKey='control-objective.export' exportRouteKey='admin.control_objectives.ajax.export'
importRouteKey='admin.control_objectives.import' />
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Name') }}:</label>
                                <input class="form-control dt-input " name="filter_name" data-column="1"
                                    data-column-index="0" type="text">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table" aria-label="">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Name') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Name') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
