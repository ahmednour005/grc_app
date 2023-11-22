<?php

namespace App\Exports;

use App\Models\Asset;
use App\Traits\LaravelExportPropertiesTrait;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class AssetsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{
    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)

    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Asset::with('location', 'assetValue','assetCategory')->get();
    }

    /**
     * @var Asset $asset
     */
    public function map($asset): array
    {
        $assetTeamNames = $asset->teamsName();
        if (count($assetTeamNames))
            $assetTeamNames =  "(" . implode('), (', $assetTeamNames->toArray()) . ")";
        else
            $assetTeamNames = '';

        $assetTagsNames = $asset->tags()->pluck('tag');
        if (count($assetTagsNames))
            $assetTagsNames =  "(" . implode('), (', $assetTagsNames->toArray()) . ")";

        else
            $assetTagsNames = '';

        return [
            $this->counter++,
            $asset->name,
            $asset->ip,
            $asset->assetValue ? ($asset->assetValue->min_value . ' - ' . $asset->assetValue->max_value) : '',
            $asset->assetCategory ?  $asset->assetCategory->name : '',
            $asset->location->name ?? '',
            $assetTeamNames,
            $assetTagsNames,
            $asset->details,
            $asset->start_date ? Carbon::parse($asset->start_date)->format('Y-m-d') : '',
            $asset->expiration_date ? Carbon::parse($asset->expiration_date)->format('Y-m-d') : '',
            $asset->alert_period,
            $asset->created ? Carbon::parse($asset->created)->format('Y-m-d') : '',
            $asset->verified ? '✔' : '✘',
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.AssetName'),
            __('locale.IPAddress'),
            __('locale.AssetValue'),
            __('locale.Category'),
            __('locale.AssetSiteLocation'),
            __('locale.Teams'),
            __('locale.Tags'),
            __('locale.AssetDetails'),
            __('locale.StartDate'),
            __('locale.EndDate'),
            __('locale.alert_period') . "(" . __('locale.days') . ")",
            __('locale.CreatedDate'),
            __('locale.VerifiedAssets'),
        ];
    }
}
