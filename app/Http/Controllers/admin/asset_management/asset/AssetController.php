<?php

namespace App\Http\Controllers\admin\asset_management\asset;

use App\Exports\AssetsExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetValue;
use App\Models\Department;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Team;
use App\Models\Action;
use App\Models\User;
use App\Events\AssetCreated;
use App\Events\AssetUpdated;
use App\Events\AssetDeleted;
use App\Models\AssetCategory;
use App\Models\AssetValueCategory;
use App\Models\AssetValueLevel;
use App\Imports\AssetsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teams = Team::all();
        $locations = Location::all();
        $assetValues = AssetValue::all();
        $assetCategories = AssetCategory::all();
        $assetValueCategories = AssetValueCategory::all();
        $assetValueLevels = AssetValueLevel::all();
        $tags = Tag::all();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Asset Management')], ['name' => __('locale.Assets')]];

        $assetInQuery = request()->query('asset');

        return view('admin.content.asset_management.asset.index', compact('breadcrumbs', 'teams', 'assetValueLevels', 'locations', 'assetValueCategories', 'assetCategories', 'assetValues', 'tags', 'assetInQuery'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip' => ['nullable', 'ip', 'max:15'],
            'asset_value' => ['required'],
            'name' => ['required', 'max:200', 'unique:assets,name'],
            'location_id' => ['nullable', 'exists:locations,id'], // the location that asset belongs to
            // 'asset_value_id' => ['required', 'exists:asset_values,id'], // the asset that asset belongs to
            'asset_category_id' => ['required', 'exists:asset_categories,id'], //the category that asset belongs to
            'teams' => ['nullable', 'array'],
            'teams.*' => ['exists:teams,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'details' => ['nullable', 'string', 'max:4000000000'], // Max longtext is 4,294,967,295
            'start_date' => ['nullable', 'date'],
            'expiration_date' => ['nullable', 'date', 'after:start_date'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheAsset') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $asset = Asset::create([
                    'ip' => $request->ip,
                    'name' => $request->name,
                    'asset_value_id' => $request->asset_value_id,
                    'asset_value_level_id' => $request->asset_value,
                    'asset_category_id' => $request->asset_category_id,
                    'location_id' => $request->location_id ?? null,
                    'teams' => $request->teams ? implode(',', $request->teams) : null,
                    'details' => $request->details,
                    'start_date' => $request->start_date,
                    'expiration_date' => $request->expiration_date,
                    'verified' => $request->has('verified') ? true : false,
                    'alert_period' => $request->alert_period,
                ]);

                $allAssetTags = Tag::whereIn('id', $request->tags ?? [])->get();
                $asset->tags()->saveMany($allAssetTags);

                // Audit log
                $message = __('asset.An asset name') . ' "' . ($asset->name ?? __('locale.[No Name]')) . '" ' . __('asset.was added by username') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($asset->id, auth()->id(), $message, 'asset');

                DB::commit();
                event(new AssetCreated($asset));

                $response = array(
                    'status' => true,
                    'message' => __('asset.AssetWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Get specified resource data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $asset = Asset::find($id);
        if ($asset) {
            $data = $asset->toArray();
            $data['expiration_date'] = $asset->expiration_date ? $asset->expiration_date->format('Y-m-d') : '';
            $data['tags'] = $asset->tags()->pluck('id')->toArray();
            // $data['asset_value_id'] = null;
            // dd($data);
            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $asset = Asset::find($id);
        if ($asset) {
            $validator = Validator::make($request->all(), [
                'ip' => ['nullable', 'ip', 'max:15'],
                'name' => ['required', 'max:200', 'unique:assets,name,' . $asset->id],
                'location_id' => ['nullable', 'exists:locations,id'], // the location that asset belongs to
                // 'asset_value_id' => ['required', 'exists:asset_values,id'], // the location that asset belongs to
                'asset_value' => ['required'],
                'asset_category_id' => ['required', 'exists:asset_categories,id'], //the category that asset belongs to
                'teams' => ['nullable', 'array'],
                'teams.*' => ['exists:teams,id'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['exists:tags,id'],
                'details' => ['nullable', 'string', 'max:4000000000'], // Max longtext is 4,294,967,295
                'start_date' => ['nullable', 'date'],
                'expiration_date' => ['nullable', 'date', 'after:start_date'],
                'alert_period' => ['nullable', 'integer'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('asset.ThereWasAProblemUpdatingTheAsset') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {

                    $currentTags = $asset->tags()->pluck('id')->toArray();
                    $deletedTags = array_diff($currentTags ?? [], $request->tags ?? []);
                    $addedTags = array_diff($request->tags ?? [], $currentTags ?? []);

                    // Delete deleted tags
                    $asset->tags()->detach($deletedTags);

                    $allAssetTags = Tag::whereIn('id', $addedTags ?? [])->get();

                    // Logic for getting tags that aren't referenced by the junction table
                    $tagsFoundedForOtherRecords = Taggable::whereIn('tag_id', $currentTags)->pluck('tag_id')->toArray();
                    $deletedAssetTagIds = array_diff($currentTags, $tagsFoundedForOtherRecords);

                    // Clean up every tags that aren't referenced by the junction table
                    Tag::whereIn('id', $deletedAssetTagIds)->delete();

                    // Add added tags
                    $asset->tags()->saveMany($allAssetTags);

                    $asset->update([
                        'ip' => $request->ip,
                        'name' => $request->name,
                        'asset_value_id' => $request->asset_value_id,
                        'asset_value_level_id' => $request->asset_value,
                        'asset_category_id' => $request->asset_category_id,
                        'location_id' => $request->location_id ?? null,
                        'teams' => $request->teams ? implode(',', $request->teams) : null,
                        'details' => $request->details,
                        'start_date' => $request->start_date,
                        'expiration_date' => $request->expiration_date,
                        'alert_period' => $request->alert_period,
                        'verified' => $request->has('verified') ? true : false,
                    ]);

                    // Audit log
                    $message = __('asset.An asset name') . ' "' . ($asset->name ?? __('locale.[No Name]')) . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                    write_log($asset->id, auth()->id(), $message, 'asset');
                    DB::commit();
                    event(new Assetupdated($asset));

                    $response = array(
                        'status' => true,
                        'message' => __('asset.AssetWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return $th->getMessage();
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
        $assetName = $asset->name;
        $assetId = $asset->id;
        if ($asset) {
            DB::beginTransaction();
            try {
                $assetTagIds = $asset->tags()->pluck('id')->toArray();

                // Remove the entries from the junction table `taggables` that connected to the `tags`
                $asset->tags()->detach();

                // Logic for getting tags that aren't referenced by the junction table
                $tagsFoundedForOtherRecords = Taggable::whereIn('tag_id', $assetTagIds)->pluck('tag_id')->toArray();
                $deletedAssetTagIds = array_diff($assetTagIds, $tagsFoundedForOtherRecords);

                // Clean up every tags that aren't referenced by the junction table
                Tag::whereIn('id', $deletedAssetTagIds)->delete();

                $asset->delete();

                // Audit log
                $message = __('asset.An asset name') . ' "' . ($assetName ?? __('locale.[No Asset Name]')) . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No User Name]')) . '".';
                write_log($assetId, auth()->id(), $message, 'asset');

                DB::commit();
                event(new AssetDeleted($asset));

                $response = array(
                    'status' => true,
                    'message' => __('asset.AssetWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('asset.ThereWasAProblemDeletingTheAsset') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('asset.ThereWasAProblemDeletingTheAsset');
                }
                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {

        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['name', 'ip'],
            // 'relationships' => ['location', 'tags'],
            'relationships' => [
                [
                    // Column => 'relationshipName'
                    'tag' => 'tags',
                ],

                [
                    // Column => 'relationshipName'
                    'name' => 'location'
                ], [
                    // Column => 'relationshipName'
                    'name' => 'assetCategory'
                ]

            ],
            'other_global_filters' => ['details', 'start_date', 'expiration_date', 'alert_period', 'created'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            // 'assetValue',
            'assetValueLevel',
            'location',
            'assetCategory',
            'tags'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        $conditions = [];
        if (!auth()->user()->hasPermission('asset.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                if (!empty($departmentTeams)) {
                    $teamsAssetsIds = Asset::where(function ($query) use ($departmentTeams) {
                        foreach ($departmentTeams as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, teams)");
                        }
                    })->pluck('id')->toArray();
                } else {
                    $teamsAssetsIds = [];
                }
            } else {
                $teamIds = auth()->user()->teams()->pluck('id')->toArray();
                if (!empty($teamIds)) {
                    $teamsAssetsIds = Asset::where(function ($query) use ($teamIds) {
                        foreach ($teamIds as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, teams)");
                        }
                    })->pluck('id')->toArray();
                } else {
                    $teamsAssetsIds = [];
                }
            }
            $assetsIds = array_unique($teamsAssetsIds);

            $conditions = [
                'whereIn' => [
                    'id' => $assetsIds
                ]
            ];
            unset($teamsAssetsIds, $assetsIds);
        }
        // Getting total records count with and without apply global search
        DB::enableQueryLog();
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            Asset::class,
            $dataTableDetails,
            $customFilterFields,
            $conditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'assets',
            [
                'id',
                'ip',
                'name',
                // 'asset_value_id',
                'asset_value_level_id',
                'asset_category_id',
                'location_id',
                'teams',
                'details',
                'start_date',
                'expiration_date',
                'alert_period',
                'created',
                'verified'
            ]
        );

        // Getting records with apply global search */
        $assets = getDatatableFilterRecords(
            Asset::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $conditions
        );

        // Custom assets response data as needs
        $data_arr = [];
        foreach ($assets as $asset) {
            $data_arr[] = array(
                'id' =>  $asset->id,
                'ip' => $asset->ip,
                'name' => $asset->name,
                'location' => $asset->location->name ?? '',
                // 'value' => $asset->assetValue ? $asset->assetValue->min_value . ' - ' . $asset->assetValue->max_value : '',
                'value' => $asset->assetValueLevel ? $asset->assetValueLevel->name : '',
                'assetCategory' => $asset->assetCategory ? $asset->assetCategory->name : '',
                'teams' => $asset->teamsName(),
                'tags' => array_map(function ($element) {
                    return $element['tag'];
                }, $asset->tags->toArray()),
                'details' => $asset->details,
                'start_date' => $asset->start_date,
                'expiration_date' => $asset->expiration_date ? $asset->expiration_date->format('Y-m-d H:i:s') : '',
                'alert_period' => $asset->alert_period,
                'created' => $asset->created,
                'verified' => $asset->verified,
                'Actions' => $asset->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new AssetsExport, 'Assets.xlsx');
        else
            return 'Assets.pdf';
    }

    public function notificationsSettingsActiveAsset()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.asset_management.index'), 'name' => __('locale.Assets')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [47, 48, 49];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [75];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            47 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'Asset_Value_Min', 'Asset_Value_Max', 'Team'],
            48 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'Asset_Value_Min', 'Asset_Value_Max', 'Team'],
            49 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'Asset_Value_Min', 'Asset_Value_Max', 'Team'],
            75 => ['Name', 'Details', 'Start_Date', 'Expiration_Date', 'Alert_Period', 'Ip', 'Location', 'Asset_Value_Min', 'Asset_Value_Max', 'Team'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            47 => ['Team-teams' => __('asset.TeamsOfAsset')],
            48 => ['Team-teams' => __('asset.TeamsOfAsset')],
            49 => ['Team-teams' => __('asset.TeamsOfAsset')],
            75 => ['Team-teams' => __('asset.TeamsOfAsset')],
        ];
        $moduleActionsIdsAutoNotify = [75];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
            ]);
            $actionsWithSettingsAuto = Action::whereIn('actions.id', $moduleActionsIdsAutoNotify)
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }


    // This function is used to open the import form and send the required data for it 
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => 'javascript:void(0)', 'name' => __('locale.Asset Management')],
    ['link' => route('admin.asset_management.index'), 'name' => __('locale.Assets')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in assets table'], 'example' => 'John Doe'],

            // Column: 'ip'
            ['name' => 'ip', 'rules' => ['Can be empty', 'must be in IP form'], 'example' => '192.168.1.1'],

            // Column: 'teams'
            ['name' => 'teams', 'rules' => [
                'Can be empty', 'should be written as comma-separated text',
                'must exist in teams of the system. Teams not in the system will be removed'
            ], 'example' => 'Team1, Team2'],

            // Column: 'verified'
            ['name' => 'verified', 'rules' => [
                'required',
                'must have value 0 or 1',
                '0 for not verified, 1 for verified'
            ], 'example' => 1],

            // Column: 'details'
            ['name' => 'details', 'rules' => ['Can be empty'], 'example' => 'Some details'],

            // Column: 'start_date'
            ['name' => 'start_date', 'rules' => [
                'Can be empty',
                'must be date in this form: mm/dd/yy'
            ], 'example' => '12/01/21'],

            // Column: 'expiration_date'
            ['name' => 'expiration_date', 'rules' => [
                'can be empty',
                'must be date in this form: mm/dd/yy'
            ], 'example' => '12/01/21']
        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.asset_management.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "AssetsImport" class to import its data
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
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Assets')])
                . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name', 'ip', 'teams', 'verified', 'details', 'start_date', 'expiration_date'];

                foreach ($columns as $column) {
                    if ($request->has($column)) {
                        $snakeCaseColumn = Str::snake($request->input($column));
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }

                // Extract values and filter out null values
                $values = array_values(array_filter($columnsMapping, function ($value) {
                    if ($value != null && $value != '')
                    {
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
                (new AssetsImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();

                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.Assets')]),
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
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.Assets')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
}
