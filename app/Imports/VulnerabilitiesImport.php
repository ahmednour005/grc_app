<?php

namespace App\Imports;

use App\Models\Vulnerability;
use App\Models\Asset;
use App\Models\Team;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VulnerabilitiesImport implements
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
            $assetsString = $row[$this->columnsMapping['teams']] ?? null;
            $assetIds = $this->processAssets($assetsString);

            $vulnerabilityName = $row[$this->columnsMapping['name']] ?? null;
            $existingVulnerabiliy = Vulnerability::where('name', $vulnerabilityName)->first();

            // Check if an vulnerability with the same name already exists
            if (!$existingVulnerabiliy) {
                // Create a new Vulnerability record in the database
                $vulnerability =  Vulnerability::create([
                    'name' => $row[$this->columnsMapping['name']] ?? null,
                    'cve' => $row[$this->columnsMapping['cve']] ?? null,
                    'severity' => $row[$this->columnsMapping['severity']] ?? null,
                    'description' => $row[$this->columnsMapping['description']] ?? null,
                    'recommendation' => $row[$this->columnsMapping['recommendation']] ?? null,
                    'plan' => $row[$this->columnsMapping['plan']] ?? null,
                    'status' => $row[$this->columnsMapping['status']] ?? null,
                    'created_by' => auth()->id(),
                ]);

                // Store vulnerability teams
                $allVulnerabilityTeams = Team::whereIn('id', $teamIds ?? [])->get();
                $vulnerability->teams()->saveMany($allVulnerabilityTeams);

                // Store vulnerability assets
                $allVulnerabilityAssets = Asset::whereIn('id', $assetIds ?? [])->get();
                $vulnerability->assets()->saveMany($allVulnerabilityAssets);
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
        $cve = !empty($this->columnsMapping['cve']) ? $this->columnsMapping['cve'] : 'cve';
        $assets = !empty($this->columnsMapping['assets']) ? $this->columnsMapping['assets'] : 'assets';
        $teams = !empty($this->columnsMapping['teams']) ? $this->columnsMapping['teams'] : 'teams';
        $severity = !empty($this->columnsMapping['severity']) ? $this->columnsMapping['severity'] : 'severity';
        $description = !empty($this->columnsMapping['description']) ? $this->columnsMapping['description'] : 'description';
        $recommendation = !empty($this->columnsMapping['recommendation']) ? $this->columnsMapping['recommendation'] : 'recommendation';
        $plan = !empty($this->columnsMapping['plan']) ? $this->columnsMapping['plan'] : 'plan';
        $status = !empty($this->columnsMapping['status']) ? $this->columnsMapping['status'] : 'status';

        return [
            $name => ['required', 'max:255'],
            $cve  => ['required', 'max:255'],
            $assets => ['required', 'string'],
            $teams => ['required', 'string'],
            $severity => ['required', 'in:Critical,High,Medium,Low,Informational'],
            $description => ['required', 'string'],
            $recommendation => ['required', 'string'],
            $plan => ['required', 'string'],
            $status => ['required', 'in:Open,In Progress,Closed'],
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
     * Process 'teams' data as needed.
     *
     * @param  string  $teamsString
     * @return array
     */
    private function processAssets($assetssString)
    {
        // Split the comma-separated asset names
        $assetsNames = explode(',', $assetssString);
        // Initialize an array to store asset IDs
        $assetIds = [];

        // Loop through each asset name
        foreach ($assetsNames as $assetName) {
            // Trim the asset name to remove any leading or trailing whitespace
            $assetName = trim($assetName);

            // Attempt to find the asset by name in the 'assets' table
            $asset = Asset::where('name', $assetName)->first();

            // If the asset exists, add its ID to the array
            if ($asset) {
                $assetIds[] = $asset->id;
            }
        }

        return array_unique($assetIds);
    }
}
