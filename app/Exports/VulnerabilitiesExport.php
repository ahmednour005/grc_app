<?php

namespace App\Exports;

use App\Models\TeamVulnerability;
use App\Models\Vulnerability;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class VulnerabilitiesExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $currentUser = auth()->user();
        if ($currentUser->role_id != 1) {
            $teamIds = $currentUser->teams()->pluck('id')->toArray();
            $vulnerabilitiesFromTeamIds = TeamVulnerability::whereIn('team_id', $teamIds)->pluck('vulnerability_id')->toArray();
            $vulnerabilitiesFromCurrentUserIds = Vulnerability::where('created_by', auth()->id())->pluck('id')->toArray();

            $allVulnerabilitiesId = array_merge($vulnerabilitiesFromTeamIds, $vulnerabilitiesFromCurrentUserIds);
            $vulnerabilities = Vulnerability::with('teams:name', 'assets:name')->whereIn('id', $allVulnerabilitiesId)->get();
            unset($vulnerabilitiesFromTeamIds, $vulnerabilitiesFromCurrentUserIds, $allVulnerabilitiesId);
        } else {
            $vulnerabilities = Vulnerability::with('teams:name', 'assets:name')->get();
        }

        return $vulnerabilities;
    }

    /**
     * @var Vulnerability $vulnerability
     */
    public function map($vulnerability): array
    {
        $teams = array_map(function ($team) {
            return $team['name'];
        }, $vulnerability->teams->toArray());

        $assets = array_map(function ($team) {
            return $team['name'];
        }, $vulnerability->assets->toArray());


        $vulnerabilityTeamNames = $teams;
        if (count($vulnerabilityTeamNames))
            // $vulnerabilityTeamNames =  "(" . implode('), (', $vulnerabilityTeamNames) . ")";
            $vulnerabilityTeamNames =  implode(', ', $vulnerabilityTeamNames);
        else
            $vulnerabilityTeamNames = '';

        $vulnerabilityAssetNames = $assets;
        if (count($vulnerabilityAssetNames))
            // $vulnerabilityAssetNames =  "(" . implode('), (', $vulnerabilityAssetNames) . ")";
            $vulnerabilityAssetNames =  implode(', ', $vulnerabilityAssetNames);
        else
            $vulnerabilityAssetNames = '';

        return [
            $this->counter++,
            $vulnerability->name,
            $vulnerability->cve,
            $vulnerabilityAssetNames,
            $vulnerabilityTeamNames,
            $vulnerability->severity,
            $vulnerability->status,
            $vulnerability->created_at->format('Y-m-d H:i'),
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.CVE'),
            __('locale.Assets'),
            __('locale.Teams'),
            __('locale.Severity'),
            __('locale.Status'),
            __('locale.CreatedDate')
        ];
    }
}
