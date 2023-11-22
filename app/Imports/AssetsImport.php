<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Team;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetsImport implements
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

    /**
     * Process each row of the collection during the import.
     *
     * @param  \Illuminate\Support\Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Extract data from the row and perform necessary transformations
            $teamsString = $row[$this->columnsMapping['teams']] ?? null;
            $teamIds = $this->processTeams($teamsString);

            $startDate = $row[$this->columnsMapping['start_date']] ?? null;
            $formattedStartDate = $startDate ? $this->convertExcelDateToStandard($startDate) : null;

            $expirationDate = $row[$this->columnsMapping['expiration_date']] ?? null;
            $formattedExpirationDate = $expirationDate ? $this->convertExcelDateToStandard($expirationDate) : null;

            $assetName = $row[$this->columnsMapping['name']] ?? null;
            $existingAsset = Asset::where('name', $assetName)->first();

            // Check if an asset with the same name already exists
            if (!$existingAsset) {
                // Create a new Asset record in the database
                Asset::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'ip' => $row[$this->columnsMapping['ip']] ?? null,
                    'asset_value_id' => 1,
                    'verified' => $row[$this->columnsMapping['verified']] ?? 0,
                    'created' => date('Y-m-d H:i:s'),
                    'details' => $row[$this->columnsMapping['details']] ?? null,
                    'start_date' => $formattedStartDate,
                    'expiration_date' => $formattedExpirationDate,
                    'teams' => implode(',', $teamIds) ?? null,
                ]);
            }
        }
    }

    /**
     * Define validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        // Determine the column names or use defaults if not provided
        $name = !empty($this->columnsMapping['name']) ? $this->columnsMapping['name'] : 'name';
        $verified = !empty($this->columnsMapping['verified']) ? $this->columnsMapping['verified'] : 'verified';

        // Define validation rules for each column
        return [
            $this->columnsMapping['ip'] => ['nullable', 'ip', 'max:15'],
            $name => ['required', 'max:200', 'unique:assets,name'],
            $this->columnsMapping['details'] => ['nullable', 'string', 'max:4000000000'],
            $this->columnsMapping['start_date'] => ['nullable'],
            $this->columnsMapping['expiration_date'] => ['nullable'],
            $verified => ['required', 'in:0,1'],
        ];
    }

    /**
     * Specify the batch size for importing.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 1000; // Adjust the batch size according to your needs
    }

    /**
     * Process 'teams' data as needed.
     *
     * @param  string  $teamsString
     * @return array
     */
    private function processTeams($teamsString)
    {
        // Split the comma-separated team names
        $teamNames = explode(',', $teamsString);
        // Initialize an array to store team IDs
        $teamIds = [];

        // Loop through each team name
        foreach ($teamNames as $teamName) {
            // Trim the team name to remove any leading or trailing whitespace
            $teamName = trim($teamName);

            // Attempt to find the team by name in the 'teams' table
            $team = Team::where('name', $teamName)->first();

            // If the team exists, add its ID to the array
            if ($team) {
                $teamIds[] = $team->id;
            }
        }

        return array_unique($teamIds);
    }

    /**
     * Convert Excel date to standard date format.
     *
     * @param  mixed  $excelDate
     * @return string|null
     */
    private function convertExcelDateToStandard($excelDate)
    {
        // Excel date starts from January 1, 1900
        $excelBaseDate = strtotime('1900-01-01');
        return date('Y-m-d', $excelBaseDate + ($excelDate - 1) * 86400);
    }
}
