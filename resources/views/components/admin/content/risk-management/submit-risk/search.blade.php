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
                            @if (auth()->user()->hasPermission('riskmanagement.create'))
                                <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#{{ $createModalID }}">
                                    {{ __('locale.AddANewRisk') }}
                                </button>
                                <a href="{{ route('admin.risk_management.notificationsSettingsRisk') }}"
                                    class="dt-button btn btn-primary me-2" target="_self">
                                    {{ __('locale.NotificationsSettings') }}
                                </a>
                            @endif

                            <!-- Import and export container -->
                            <x-export-import name=" {{ __('risk.Risk') }}" createPermissionKey='riskmanagement.create'
                                exportPermissionKey='riskmanagement.export'
                                exportRouteKey='admin.risk_management.ajax.export'
                                 importRouteKey='admin.risk_management.import' />
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Status') }}:</label>
                                <input class="form-control dt-input" data-column="1" name="filter_status"
                                    data-column-index="0" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Subject') }}:</label>
                                <input class="form-control dt-input" data-column="2" name="filter_subject"
                                    data-column-index="1" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('risk.InherentRiskCurrent') }}:</label>
                                <input class="form-control dt-input" data-column="3" name="filter_riskScoring"
                                    data-column-index="2" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.SubmissionDate') }}:</label>
                                <input class="form-control dt-input" data-column="4" name="filter_submission_date"
                                    data-column-index="3" type="text">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Subject') }}</th>
                            <th>{{ __('risk.InherentRiskCurrent') }}</th>
                            <th>{{ __('locale.SubmissionDate') }}</th>
                            {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                            {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Subject') }}</th>
                            <th>{{ __('risk.InherentRiskCurrent') }}</th>
                            <th>{{ __('locale.SubmissionDate') }}</th>
                            {{-- <th>{{ __('locale.MitigationPlanned') }}</th> --}}
                            {{-- <th>{{ __('locale.ManagementReview') }}</th> --}}
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
