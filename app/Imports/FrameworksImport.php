<?php

namespace App\Imports;

use App\Models\Family;
use App\Models\Framework;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FrameworksImport implements
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
            $departmentName = $row[$this->columnsMapping['name']] ?? null;
            $existingFrameworkWithTheSameName = Framework::where('name', $departmentName)->first();

            // Extract data from the row and perform necessary transformations
            $familiesString = $row[$this->columnsMapping['domain']] ?? null;
            $familiesIds = $this->processFamilies($familiesString);

            // Extract data from the row and perform necessary transformations
            $subFamiliesString = $row[$this->columnsMapping['sub_domain']] ?? null;
            $subFamiliesIds = $this->processFamilies($subFamiliesString);
            // Check if a department with the same name already exists
            if (!$existingFrameworkWithTheSameName) {
                $framework = Framework::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'icon' => 'fa-ban',
                ]);

                $framework->families()->attach($familiesIds); // attach domains to framewrok

                $subDomains = [];

                foreach ($subFamiliesIds as $subFamily) {
                    $parentDomainId = Family::where('id', $subFamily)->pluck('parent_id')->first();
                    if(!in_array($parentDomainId,$familiesIds)){
                        continue;
                    }
                    $subDomains[$subFamily] = ['parent_family_id' => $parentDomainId];
                }

                $framework->families()->attach($subDomains); // attach sub-domains to framework
            }
        }
    }

    public function rules(): array /* WithValidation */
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : 'name';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : 'description';
        $domain = !empty($this->columnsMapping['domain']) ? $this->columnsMapping['domain'] : 'domain';
        $subDomain = !empty($this->columnsMapping['sub_domain']) ? $this->columnsMapping['sub_domain'] : 'sub_domain';
        return [
            $name => ['required', 'max:100', 'unique:departments,name'],
            $description => ['required', 'string'],
            $domain => ['required', 'string'],
            $subDomain => ['required', 'string'],

        ];
    }

    private function processFamilies($familiesString)
    {
        // Split the comma-separated team names
        $familiesNames = explode(',', $familiesString);
        // Initialize an array to store team IDs
        $familieIds = [];

        // Loop through each team name
        foreach ($familiesNames as $familyName) {
            // Trim the team name to remove any leading or trailing whitespace
            $familyName = trim($familyName);

            // Attempt to find the team by name in the 'teams' table
            $team = Family::where('name', $familyName)->first();

            // If the team exists, add its ID to the array
            if ($team) {
                $familieIds[] = $team->id;
            }
        }

        return array_unique($familieIds);
    }
}
