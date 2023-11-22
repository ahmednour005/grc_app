<?php

namespace App\Exports;

use App\Models\Framework;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class FrameworksExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;
    private $headings = [];
    private $frameworks = [];

    public function __construct()
    {
        $frameworks = Framework::with(['only_families', 'only_sub_families'])->get();

        $tempDomainsId = [];
        foreach ($frameworks as $framework) {
            $tempDomainsId = [];
            foreach ($framework->only_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_families = $tempDomainsId;

            $tempDomainsId = [];
            foreach ($framework->only_sub_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_sub_families = $tempDomainsId;
        }
        $index = 1;
        // dd($frameworks->toArray());
        $maxNumerOfDomains = max(array_map(function ($framework) {
            return count($framework['only_families']);
        }, $frameworks->toArray()));

        // dd($frameworks);

        $this->headings = [
            __('locale.#'),
            __('locale.Name'),
        ];

        for ($i = 1; $i <= $maxNumerOfDomains; $i++) {
            $this->headings[] = __('locale.DomainCount', ['count' => $i]);
            $this->headings[] = __('locale.SubDomainsCount', ['count' => $i]);
        }

        $this->frameworks = $frameworks;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->frameworks;
    }

    /**
     * @var Framework $framework
     */
    public function map($framework): array
    {
        $returnedData = [];
        $returnedData[] = $this->counter++;
        $returnedData[] = $framework->name;

        foreach ($framework->only_families as $domain) {
            $returnedData[] = $domain->name; // Set domain
            $domainSubDomains = [];

            foreach ($framework->only_sub_families as $subDomain) {
                if ($domain->id == $subDomain->parent_id) {
                    $domainSubDomains[] = $subDomain->name;
                }
            }

            if (count($domainSubDomains))
                // $domainSubDomains =  "(" . implode('), (', $domainSubDomains) . ")";
                $domainSubDomains =  implode(', ', $domainSubDomains);
            else
                $domainSubDomains = '';

            $returnedData[] = $domainSubDomains; // Set sub-domains
        }

        return $returnedData;
    }


    public function headings(): array
    {
        return $this->headings;
    }
}
