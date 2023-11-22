<?php

namespace App\Exports;

use App\Models\ControlObjective;
use App\Traits\LaravelExportPropertiesTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class ControlObjectivesExport implements FromCollection, WithMapping, WithHeadings, WithProperties
{

    use LaravelExportPropertiesTrait; // This trait implement properties function required by (WithProperties)
    private $counter = 1;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ControlObjective::get();
    }

    /**
     * @var ControlObjective $controlObjective
     */
    public function map($controlObjective): array
    {
        return [
            $this->counter++,
            $controlObjective->name,
            $controlObjective->description,
            $controlObjective->created_at->format('Y-m-d H:i')
        ];
    }


    public function headings(): array
    {
        return [
            __('locale.#'),
            __('locale.Name'),
            __('locale.Description'),
            __('locale.CreatedDate')
        ];
    }
}
