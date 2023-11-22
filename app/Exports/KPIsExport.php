<?php

namespace App\Exports;

use App\Models\KPI;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class KPIsExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return KPI::with(['department:id,name', 'created_by_user:id,username'])->withCount('assessments')->get();
    }

    /**
     * @var KPI $KPI
     */
    public function map($KPI): array
    {
        return [
            $this->counter++,
            $KPI->title,
            $KPI->description,
            $KPI->value_type,
            $KPI->value,
            $KPI->period_of_assessment . ' ' . __('locale.Months'),
            $KPI->department ? $KPI->department->name : '',
            $KPI->created_at->format('Y-m-d H:i'),
            $KPI->created_by_user->username ?? '',
            $KPI->assessments_count
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Title'),
            __('locale.Description'),
            __('locale.Type'),
            __('locale.Value'),
            __('locale.Period'),
            __('locale.Department'),
            __('locale.CreatedBy'),
            __('locale.CreatedDate'),
            __('locale.KPIAssessmentCount')
        ];
    }
}
