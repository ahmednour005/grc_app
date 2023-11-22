<div class="row">
    <div class="card">
        <?php
            $risk_id = convert_id($risk->id);
            $status = $risk->status;
            $subject = $risk->subject;
            $calculated_risk = $risk->calculated_risk;
            // $color = get_risk_color($calculated_risk);
            $color = '';
            $assets=$risk->assets;
        ?>
        <div class="card-header">
            <div class="col-4 mt-1 text-center">
                <p class="card-text"><code>{{ __('report.RiskId') }} :</code>
                    {{ $risk_id ? $risk_id : '-' }}</p>
            </div>
            <div class="col-4 mt-1 text-center">
                <p class="card-text"><code>{{ __('locale.Subject') }} :</code>
                    {{ $subject ? $subject : '-' }}</p>
            </div>
            <div class="col-4 mt-1 text-center">
                <p class="card-text"><code>{{ __('report.InherentRisk') }} :</code>
                    {{ $calculated_risk ? $calculated_risk : '-' }}</p>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <div class="col-12 mt-1">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.ID') }}</th>
                                    <th>{{ __('report.AssetName') }}</th>
                                    <th>{{ __('report.AssetTags') }}</th>
                                    <th>{{ __('report.AssetValue') }}</th>
                                    <th>{{ __('report.AssetSiteLocation') }}</th>
                                    <th>{{ __('report.AssetTeams') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if(count($assets)>0)
                                    @foreach ($assets as $asset)
                                        <?php

                                        ?>
                                        <tr>
                                            <td>{{ $asset->id }}</td>
                                            <td>{{ $asset->name ? $asset->name : '-' }}</td>
                                            <td> {{ $asset->assetTags ? $asset->assetTags->pluck('tag') : '-' }}</td>
                                            <td>{{ $asset->asset_value_id ? get_asset_value_by_id($asset->asset_value_id) : '-' }}</td>
                                            <td> {{ $asset->location_id ? $asset->location->name : '-' }}</td>
                                            <td>{{ $asset->teamsName()??'-' }}</td>


                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan='6' class="text-center">{{ __('locale.NoDataAvailable') }}</td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
