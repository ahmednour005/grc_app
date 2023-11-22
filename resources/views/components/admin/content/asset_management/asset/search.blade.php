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
                            @if (auth()->user()->hasPermission('asset.create'))
                            <button class="dt-button btn btn-primary me-1" type="button" data-bs-toggle="modal"
                                data-bs-target="#{{ $createModalID }}">
                                {{ __('asset.AddANewAsset') }}
                            </button>
                            <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                class="dt-button btn btn-primary me-2" target="_self">
                                {{ __('locale.NotificationsSettings') }}
                            </a>
                            @endif

                            <!-- Import and export container -->
                            <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                exportPermissionKey='asset.export' exportRouteKey='admin.asset_management.ajax.export'
                                importRouteKey='admin.asset_management.import' />
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.AssetName') }}:</label>
                                <input class="form-control dt-input" name="filter_name" data-column="1"
                                    data-column-index="0" type="text">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.IPAddress') }}:</label>
                                <input class="form-control dt-input" name="filter_ip" data-column="2"
                                    data-column-index="1" type="text">
                            </div>
                            {{-- This input for allow global search without custom advanced column search --}}
                            <input hidden name="filter_tags">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.AssetSiteLocation') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_location"
                                    id="AssetSiteLocation" data-column="5" data-column-index="3">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($locations as $location)
                                    <option value="{{ $location->name }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('locale.AssetCategory') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_assetCategory"
                                    id="AssetCategory" data-column="4" data-column-index="4">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($assetCategories as $assetCategory)
                                    <option value="{{ $assetCategory->id }}">{{ $assetCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                            <th>{{ __('asset.AssetName') }}</th>
                            <th>{{ __('locale.IPAddress') }}</th>
                            <th>{{ __('locale.AssetValue') }}</th>
                            <th>{{ __('locale.AssetCategory') }}</th>
                            <th>{{ __('locale.AssetSiteLocation') }}</th>
                            <th>{{ __('locale.Teams') }}</th>
                            <th>{{ __('locale.Tags') }}</th>
                            <th>{{ __('asset.AssetDetails') }}</th>
                            <th>{{ __('locale.StartDate') }}</th>
                            <th>{{ __('locale.EndDate') }}</th>
                            <th>{{ __('locale.alert_period') }} ({{ __('locale.Days') }})</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.VerifiedAssets') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('asset.AssetName') }}</th>
                            <th>{{ __('locale.IPAddress') }}</th>
                            <th>{{ __('locale.AssetValue') }}</th>
                            <th>{{ __('locale.AssetCategory') }}</th>
                            <th>{{ __('locale.AssetSiteLocation') }}</th>
                            <th>{{ __('locale.Teams') }}</th>
                            <th>{{ __('locale.Tags') }}</th>
                            <th>{{ __('asset.AssetDetails') }}</th>
                            <th>{{ __('locale.StartDate') }}</th>
                            <th>{{ __('locale.EndDate') }}</th>
                            <th>{{ __('locale.alert_period') }} ({{ __('locale.Days') }})</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.VerifiedAssets') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>