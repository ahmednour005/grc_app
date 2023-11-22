<?php

namespace App\Imports;

use App\Models\ControlClass;
use App\Models\ControlMaturity;
use App\Models\ControlPhase;
use App\Models\ControlPriority;
use App\Models\ControlType;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\FrameworkControlTest;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FrameworkControlsImport implements
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
            $frameworkName = $row[$this->columnsMapping['framework']] ?? null;
            $frameworkId = Framework::where('name', $frameworkName)->pluck('id')->first();

            $parentName = $row[$this->columnsMapping['parent_id']] ?? null;
            $parent = FrameworkControl::where('short_name', $parentName)->first();

            if ($parent) {
                $parentId = $parent->id;
                $familyId = $parent->family;
            } else {
                $parentId = null;
                $familyName = $row[$this->columnsMapping['domain']] ?? null;
                $familyId = Family::where('name', $familyName)->pluck('id')->first();
            }

            $priorityName = $row[$this->columnsMapping['control_priority']] ?? null;
            $controlPriorityId = ControlPriority::where('name', $priorityName)->pluck('id')->first();


            $phaseName = $row[$this->columnsMapping['control_phase']] ?? null;
            $controlPhaseId = ControlPhase::where('name', $phaseName)->pluck('id')->first();

            $className = $row[$this->columnsMapping['control_class']] ?? null;
            $controlClassId = ControlClass::where('name', $className)->pluck('id')->first();

            $typeName = $row[$this->columnsMapping['control_type']] ?? null;
            $controlTypeId = ControlType::where('name', $typeName)->pluck('id')->first();

            $maturityName = $row[$this->columnsMapping['control_maturity']] ?? null;
            $controlMaturityId = ControlMaturity::where('name', $maturityName)->pluck('id')->first();

            $desiredMaturityName = $row[$this->columnsMapping['control_desired_maturity']] ?? null;
            $controlDesiredMaturityId = ControlMaturity::where('name', $desiredMaturityName)->pluck('id')->first();


            $ownerName = $row[$this->columnsMapping['owner']] ?? null;
            $ownerId = User::where('name', $ownerName)->pluck('id')->first();

            // Check if a department with the same name already exists
            if ($familyId) {
                $frameworkControl = FrameworkControl::create([
                    'short_name' => $row[$this->columnsMapping['name']] ?? null,
                    'long_name' => $row[$this->columnsMapping['name']] ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'control_number' => $row[$this->columnsMapping['control_number']] ?? null,
                    'supplemental_guidance' => $row[$this->columnsMapping['supplemental_guidance']] ?? null,
                    'mitigation_percent' => $row[$this->columnsMapping['mitigation_percent']] ?? null,
                    'parent_id'  => $parentId ?? null,
                    'family'  => $familyId ?? null,
                    'control_priority'  => $controlPriorityId ?? null,
                    'control_phase'  => $controlPhaseId ?? null,
                    'control_class'  => $controlClassId ?? null,
                    'control_type'  => $controlTypeId ?? null,
                    'control_maturity'  => $controlMaturityId ?? null,
                    'desired_maturity'  => $controlDesiredMaturityId ?? null,
                    'control_owner' => $ownerId ?? auth()->id(),
                ]);

                $testerName = $row[$this->columnsMapping['tester']] ?? null;
                $testerId = User::where('name', $testerName)->pluck('id')->first();


                FrameworkControlTest::create([
                    'tester' => $testerId ?? null,
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'test_steps' => $row[$this->columnsMapping['test_steps']] ?? null,
                    'approximate_time' => $row[$this->columnsMapping['approximate_time']] ?? null,
                    'framework_control_id' => $frameworkControl->id,
                    'expected_results' => $row[$this->columnsMapping['expected_results']] ?? null,
                    'test_frequency' => $row[$this->columnsMapping['test_frequency']] ?? 0,
                ]);

                $frameworkControl->Frameworks()->attach($frameworkId);
            }
        }
    }

    public function rules(): array /* WithValidation */
    {
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : 'name';
        $testFrequency = !empty($this->columnsMapping['test_frequency']) ? $this->columnsMapping['test_frequency'] : 'test_frequency';
        $framework = !empty($this->columnsMapping['framework']) ? $this->columnsMapping['framework'] : 'framework';
        $domain = !empty($this->columnsMapping['domain']) ? $this->columnsMapping['domain'] : 'domain';
        $parentId = !empty($this->columnsMapping['parent_id']) ? $this->columnsMapping['parent_id'] : 'parent_id';
        $tester = !empty($this->columnsMapping['tester']) ? $this->columnsMapping['tester'] : 'tester';
        return [
            $name => ['required', 'max:1000'],
            $testFrequency => ['required', 'integer'],
            $framework => ['required', 'exists:frameworks,name'],
            $parentId => ['nullable', 'exists:framework_controls,short_name'],
            $domain => ['nullable',  'exists:families,name'],
            $tester => ['required', 'exists:users,name'],
            $this->columnsMapping['owner'] => ['nullable', 'exists:users,name'],
            $this->columnsMapping['mitigation_percent'] => ['nullable', 'integer'],
            $this->columnsMapping['approximate_time'] => ['nullable', 'integer'],
            $this->columnsMapping['control_priority'] => ['nullable', 'exists:control_priorities,name'],
            $this->columnsMapping['control_phase'] => ['nullable', 'exists:control_phases,name'],
            $this->columnsMapping['control_class'] => ['nullable', 'exists:control_classes,name'],
            $this->columnsMapping['control_type'] => ['nullable', 'exists:control_types,name'],
            $this->columnsMapping['control_maturity'] => ['nullable', 'exists:control_maturities,name'],
            $this->columnsMapping['control_desired_maturity'] => ['nullable', 'exists:control_desired_maturities,name'],

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
