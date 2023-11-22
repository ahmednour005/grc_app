<?php

namespace App\Imports;

use App\Models\Risk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RisksImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation
{
    use Importable;

    /**
     * Mapping of columns from the import file to database columns.
     *
     * @var array
     */
    public $columnsMapping;

    /**
     * Constructor to set the columns mapping.
     *
     * @param array $columnsMapping
     */
    public function __construct($columnsMapping)
    {
        $this->columnsMapping = $columnsMapping;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $risk =  Risk::create([
                'subject' => $row[$this->columnsMapping['subject']] ?? null,
                'status'  => 'New',
                'risk_catalog_mapping' => "",
                'threat_catalog_mapping' => "",
                'template_group_id' => 0,
                'submitted_by' => auth()->id() ?? 1, // now to test without login
            ]);

            // Start Submit risk scoring
            $riskScoringMethodId = 1;
            submit_risk_scoring($risk->id, $riskScoringMethodId);
            // End Submit risk scoring

        }
    }

    public function rules(): array /* WithValidation */
    {
        $subject = !empty($this->columnsMapping['subject']) ? $this->columnsMapping['subject'] : 'subject';
        return [
            $subject => ['required'],
        ];
    }
}
