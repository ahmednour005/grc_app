<?php

namespace App\Http\Controllers\admin\governance;

use App\Exports\FrameworksExport;
use App\Http\Controllers\Controller;
use App\Imports\FrameworksImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class FrameworkController extends Controller
{
    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworksExport, 'Frameworks.xlsx');
        else
            return 'Frameworks.pdf';
    }


    // This function is used to open the import form and send the required data for it
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Governance')],
            ['link' => route('admin.governance.index'), 'name' => __('locale.Frameworks')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in frameworks table'], 'example' => 'Framework1'],

            // Column: 'description'
            ['name' => 'description', 'rules' => ['required'], 'example' => 'some description'],

            // Column: 'domain'
            ['name' => 'domain', 'rules' => ['required', 'comma separated string containing domain names', 'must exist in domains table'], 'example' => 'domain1'],


            // Column: 'sub_domain'
            ['name' => 'sub_domain', 'rules' => ['required', 'comma separated string containing sub domain names', 'must exist in domains table', 'must be child of any of domains in domain field'], 'example' => 'sub_domain1'],

        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.governance.framework.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "FrameworksImport" class to import its data
    public function importData(Request $request)
    {
        // Validate the incoming request for the 'import_file' field
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'file', 'max:5000'],
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            // Prepare response with validation errors
            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Frameworks')])
                . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name', 'description', 'domain', 'sub_domain'];

                foreach ($columns as $column) {
                    if ($request->has($column)) {
                        $snakeCaseColumn = Str::snake($request->input($column));
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }

                // Extract values and filter out null values
                $values = array_values(array_filter($columnsMapping, function ($value) {
                    if ($value != null && $value != '') {
                        return $value;
                    }
                }));

                // Check for duplicate values
                if (count($values) !== count(array_unique($values))) {
                    $response = [
                        'status' => false,
                        'message' => __('locale.YouCantUseTheSameFileColumnForMoreThanOneDatabaseColumn'),
                    ];
                    return response()->json($response, 422);
                }

                // Import data using the specified columns mapping
                (new FrameworksImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();

                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Frameworks')]),
                ];
                return response()->json($response, 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Rollback the transaction in case of an exception
                DB::rollBack();

                // Handle validation exceptions and prepare error response
                $failures = $e->failures();
                $errors = [];
                foreach ($failures as $failure) {
                    if (!array_key_exists($failure->row(), $errors)) {
                        $errors[$failure->row()] = [];
                    }
                    $errors[$failure->row()][] = [
                        'attribute' => $failure->attribute(),
                        'value' =>  $failure->values()[$failure->attribute()] ?? '',
                        'error' => $failure->errors()[0]
                    ];
                }

                $response = [
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Frameworks')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
}
