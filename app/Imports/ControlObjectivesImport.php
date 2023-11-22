<?php

namespace App\Imports;

use App\Models\ControlObjective;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ControlObjectivesImport implements
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
            $objectiveName = $row[$this->columnsMapping['name']] ?? null;
            $existingObjective = ControlObjective::where('name', $objectiveName)->first();

            // Check if an control objective with the same name already exists
            if (!$existingObjective) {
                // Create a new control objective record in the database
                ControlObjective::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
    public function rules(): array /* WithValidation */
    {
        // Determine the column names or use defaults if not provided
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : 'name';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : 'description';
        return [
            $name => ['required', 'max:255', 'unique:control_objectives,name'],
            $description => ['required', 'max:500']
        ];
    }
}
