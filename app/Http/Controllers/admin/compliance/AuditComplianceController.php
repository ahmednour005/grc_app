<?php

namespace App\Http\Controllers\admin\compliance;

use App\Exports\FrameworkControlTestAuditsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTestResult;
use App\Models\User;
use App\Models\Framework;
use App\Models\Family;
use App\Models\Team;
use App\Models\FrameworkControl;
use App\Models\TestStatus;
use App\Models\TestResult;
use App\Models\Risk;
use App\Models\FrameworkControlTestResultsToRisk;
use Carbon\Carbon;
use App\Http\Traits\ItemTeamTrait;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Category;
use App\Models\ControlAuditPolicy;
use App\Models\Department;
use App\Models\Document;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Location;
use App\Models\RiskGrouping;
use App\Models\ScoringMethod;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Events\AuditResultCreated;
use App\Models\File;
use App\Models\RiskToAdditionalStakeholder;
use App\Models\RiskToLocation;
use App\Models\RiskToTeam;
use App\Models\RiskToTechnology;
use App\Models\Setting;
use App\Traits\AssetTrait;
use App\Events\AuditRiskCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\PseudoTypes\False_;
use SplFileInfo;
use App\Models\Action;

class AuditComplianceController extends Controller
{
    use AssetTrait;
    use ItemTeamTrait;
    private $path = 'admin.content.compliance.active-audit';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Compliance')], ['name' => __('locale.Active Audits')]];

        $testers = User::all();
        $controls = FrameworkControl::all();
        $frameworks = Framework::all();
        $families = Family::has('parentFamily')->get();
        $teams = Team::all();

        return view($this->path . '.index', compact('frameworks', 'families', 'controls', 'testers', 'breadcrumbs', 'teams'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PastAudits()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Compliance')], ['name' => __('locale.Past Audits')]];

        $testers = User::all();
        $controls = FrameworkControl::all();
        $frameworks = Framework::all();
        $families = Family::all();
        $teams = Team::all();

        return view($this->path . '.past-audits', compact('frameworks', 'families', 'controls', 'testers', 'breadcrumbs', 'teams'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ListTestIds = explode(',', $request->id);
        $ListTestIds = array_filter($ListTestIds, 'strlen');
        foreach ($ListTestIds as $id) {


            $test = FrameworkControlTest::find($id);

            $lastTestLog = $test->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
            $lastDate = null;
            $nextDate = null;

            if ($lastTestLog) {
                $lastDate = $lastTestLog->next_date;
                $nextDate = date('Y-m-d', strtotime($lastDate) + ($test->test_frequency ?? 0) * 24 * 60 * 60);
            } else {
                $lastDate = $test->last_date;
                $nextDate = date('Y-m-d', strtotime($lastDate) + ($test->test_frequency ?? 0) * 24 * 60 * 60);
            }

            $countAudit = $test->FrameworkControlTestAudits->count() + 1;
            $auditName = $test->name . "(" . $countAudit . ")";

            $audit = FrameworkControlTestAudit::create([
                'test_id' => $test->id,
                'tester' => $test->tester,
                'last_date' => $lastDate,
                'next_date' => $nextDate,
                'name' => $auditName,
                'test_steps' => $test->test_steps,
                'status' => 1,
                'approximate_time' => $test->approximate_time,
                'framework_control_id' => $test->framework_control_id,
                'expected_results' => $test->expected_results,
                'desired_frequency' => $test->desired_frequency,
                'test_frequency' => $test->test_frequency,
            ]);
            FrameworkControlTestResult::create([
                'test_audit_id' => $audit->id
            ]);

            $message =  __(
                'compliance.NotifyAuditCreated',
                [
                    'user' => auth()->user()->name
                ]
            );
            write_log($audit->id, auth()->id(), $message, FrameworkControlTestAudit::class);
        }
        return response()->json($ListTestIds, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], 
        ['link' => route('admin.compliance.audit.index'), 'name' => __('locale.Compliance')],['name' => __('locale.ViewActiveAudits')]];
        $frameworkControlTestAudit = FrameworkControlTestAudit::with('compliance_files:ref_id,name,unique_name', 'UserTester:id,name', 'ControlAuditPolicies', 'controlAuditObjectives')->findOrFail($id);
        if (!auth()->user()->hasPermission('audits.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembersIds =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->pluck('id')->toArray();
                if (!in_array($frameworkControlTestAudit['tester'], $departmentMembersIds)) {
                    abort(403, 'Unauthorized');
                }
            } elseif (!$frameworkControlTestAudit['tester'] == auth()->id()) {
                abort(403, 'Unauthorized');
            }
        }
        $editable = true;
        // Check if the framework control has many audits and this audit isn't last audit
        if (!$this->isLastAudit($frameworkControlTestAudit)) {
            $editable = false;
            // return redirect()->route('admin.compliance.audit.index');
        }
        // dd($frameworkControlTestAudit->controlAuditObjectives);

        $frameworkControlTestResult = $frameworkControlTestAudit->FrameworkControlTestResult;
        $auditStatusGroups = TestStatus::all();
        // Set test results depending on control audit policies
        $testResultGroups = [];
        if (count($frameworkControlTestAudit->ControlAuditPolicies) == 0 && count($frameworkControlTestAudit->ControlAuditObjectives) == 0) // There is no control audit policies or Objectives
            $testResultGroups = TestResult::all();
        else { // There are control audit policies or objectives
            $controlAuditPolicyAndObjectiveActions = [];
            $controlAuditPolicyAndObjectiveActions['no_action'] = 0;
            $controlAuditPolicyAndObjectiveActions['approved'] = 0;
            $controlAuditPolicyAndObjectiveActions['rejected'] = 0;
            if($frameworkControlTestAudit->ControlAuditPolicies){
            foreach ($frameworkControlTestAudit->ControlAuditPolicies as $controlAuditPolicy) {
                $controlAuditPolicyAndObjectiveActions[$controlAuditPolicy->document_audit_status]++;
            }
        }
        if($frameworkControlTestAudit->ControlAuditObjectives)
        {
            foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective) {
                $controlAuditPolicyAndObjectiveActions[$controlAuditObjective->objective_audit_status]++;
            }
        }
            /* Values of test results */
            /*
                "1" => 'Not Applicable',
                "2" => 'Not Implemented',
                "3" => 'Partially Implemented',
                "4" => 'Implemented',
            */

            $testResultIds = [];
            $testResultIds[] = 1; // Append 'Not Applicable'
            $testResultIds[] = 2; // Append 'Not Implemented'
            if ($controlAuditPolicyAndObjectiveActions['no_action'] == 0) { // All control audit policies has action
                if ($controlAuditPolicyAndObjectiveActions['approved'] == (count($frameworkControlTestAudit->ControlAuditPolicies) + count($frameworkControlTestAudit->ControlAuditObjectives))) // All control audit policies and objectives approved
                    $testResultIds = [1, 2, 3, 4]; // 'Not Applicable', 'Not Implemented', 'Partially Implemented', and 'Implemented'
                else if ($controlAuditPolicyAndObjectiveActions['approved'] > 0)
                    $testResultIds = [1, 2, 3]; // 'Not Applicable', 'Not Implemented', and 'Partially Implemented'
                else
                    $testResultIds = [1, 2]; // 'Not Applicable', and 'Not Implemented'
            } else {
                $testResultIds = [1,2]; // 'Not Applicable , Not Implemented'
            }

            $testResultGroups = TestResult::whereIn('id', $testResultIds)->get();
        }

        $testers = User::all();
        $teams = Team::all();
        $testTeams = $this->GetTeamsOfItem($frameworkControlTestAudit->test_id, 'test');
        $testTeamsNames = Team::whereIn('id', $testTeams)->pluck('name')->toArray();

        $comments = $frameworkControlTestAudit->FrameworkControlTestComments;
        $SelectedRiskIds = FrameworkControlTestResultsToRisk::where('test_results_id', $frameworkControlTestResult->id)->pluck('risk_id')->toArray();
        $resultRisks = Risk::whereIn('id', $SelectedRiskIds)->get();
        $risks = Risk::all();

        $riskGroupings = RiskGrouping::with('RiskCatalogs:id,number,name,risk_grouping_id')->get();
        $threatGroupings = ThreatGrouping::with('ThreatCatalogs:id,number,name,threat_grouping_id')->get();
        $categories = Category::all();
        $locations = Location::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        $assets = Asset::select('id', 'name')->orderBy('id')->get();
        $assetGroups = AssetGroup::all();
        $technologies = Technology::all();
        $enabledUsers = User::where('enabled', true)->with('manager:id,name,manager_id')->get();
        $tags = Tag::all();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }
        $riskSources = Source::all();
        $riskScoringMethods = ScoringMethod::all();
        $riskLikelihoods = Likelihood::all();
        $impacts = Impact::all();

        // return count($resultRisks);
        return view($this->path . '.view', compact('auditStatusGroups', 'testResultGroups', 'frameworkControlTestAudit', 'frameworkControlTestResult', 'testers', 'teams', 'breadcrumbs', 'id', 'testTeams', 'comments', 'risks', 'SelectedRiskIds', 'resultRisks', 'riskGroupings', 'threatGroupings', 'locations', 'frameworks', 'assets', 'assetGroups', 'categories', 'technologies', 'enabledUsers', 'riskSources', 'riskScoringMethods', 'riskLikelihoods', 'impacts', 'tags', 'editable', 'testTeamsNames', 'owners'));
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
        // dd($request->all());
        $data = array(
            'status' => 1,
            'errors' => [],
            'reload' => true,
        );

        // Get framewrok control test result
        $FrameworkControlTestResult = FrameworkControlTestResult::where('test_audit_id', $id)->first();
        // Get framewrok control test audit
        $frameworkControlTestAudit = $FrameworkControlTestResult->FrameworkControlTestAudit;

        // Check if the framework control has many audits and this audit isn't last audit
        if (!$this->isLastAudit($frameworkControlTestAudit)) {
            $response = array(
                'status' => false,
                'message' => __('compliance.ThereWasAProblemUpdatingTheAuditResultIsNotLastResult'),
            );
            return response()->json($response, 403);
        }

        // validation rules
        $validator = Validator::make($request->all(), [
            'test_result' => 'required|integer',
            'summary' => 'required',
            'test_date' => 'required|after_or_equal:today',
            // 'tester' => 'required',
            'status' => 'required',
            'teams' => 'required'
        ]);

        // check  rules valid or not
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data = array(
                'status' => 0,
                'errors' => $errors,
                'message' => __('compliance.ThereWasAProblemUpdatingTheAuditResult') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($data, 200);
        } else {
            $FrameworkControlTestResultOldArray = $FrameworkControlTestResult->toArray();

            $FrameworkControlTestResult->update([
                'test_result' => $request->test_result,
                'summary' =>  $request->summary,
                'test_date' =>  $request->test_date,
                // 'submitted_by' => 1,  //auth()->user()->id,
                'submission_date' =>  Carbon::now()->format('Y-m-d'),
                // 'last_updated' =>  Carbon::now() // tttttttttttttttttttttttttttttttttttttttttttttttttt
            ]);

            $FrameworkControlTestAudit = FrameworkControlTestAudit::where('id', $id)->first();
            $FrameworkControlTestAuditOldArray = $FrameworkControlTestAudit->toArray();

            $frameworkControl = $FrameworkControlTestAudit->frameworkControl;
            $frameworkControlChildrenCount = $frameworkControl->frameworkControls()->count();

            $FrameworkControlTestAudit->update([
                'status' => $request->status,
                'last_date' =>  $request->test_date,
            ]);

            // If framework control doesn't have children
            if ($frameworkControlChildrenCount == 0) {
                $frameworkControl->update([
                    'control_status' => $FrameworkControlTestResult->testResult->name
                ]);

                $parentFrameworkControl = $frameworkControl->parentFrameworkControl;

                // framework control hasn't child & has parent
                if ($parentFrameworkControl) {
                    $frameworkControlChildren = $parentFrameworkControl->frameworkControls;
                    $statuses = ['Not Implemented' => 0, 'Partially Implemented' => 0, 'Implemented' => 0];
                    $frameworkControlChildrenStatuses = $frameworkControlChildren->where('control_status', '<>', 'Not Applicable')->pluck('control_status')->toArray();

                    // If all statuses == 'Not Applicable'
                    if (count($frameworkControlChildrenStatuses) == 0) {
                        $parentFrameworkControl->update([
                            'control_status' => 'Not Applicable'
                        ]);
                    } else {
                        foreach ($frameworkControlChildrenStatuses as $frameworkControlChildrenStatus) {
                            if (array_key_exists($frameworkControlChildrenStatus, $statuses)) {
                                $statuses[$frameworkControlChildrenStatus]++;
                            }
                        }

                        foreach ($statuses as $key => $value) {
                            if ($statuses[$key] == 0)
                                unset($statuses[$key]);
                        }

                        // All status are matched one status
                        if (count($statuses) == 1) {
                            $parentFrameworkControl->update([
                                'control_status' => array_keys($statuses)[0]
                            ]);
                        } else { // has mix of statuses
                            $parentFrameworkControl->update([
                                'control_status' => 'Partially Implemented'
                            ]);
                        }
                    }
                }
            }
            // If framework control has children its status will depend on children status (neglect status)

            $testID = FrameworkControlTestAudit::find($id)->test_id;
            $this->UpdateTeamsOfItem($testID, 'test', $request->teams);


            $changes = [];
            if ($FrameworkControlTestResultOldArray) {
                if ($FrameworkControlTestResultOldArray['test_result'] != $FrameworkControlTestResult['test_result']) {
                    $changes[] = "`test result` (`" .
                        ($FrameworkControlTestResultOldArray['test_result'] ? (TestResult::where('id', $FrameworkControlTestResultOldArray['test_result'])->pluck('name')[0]) : '') . "`=>`" .
                        (TestResult::where('id', $FrameworkControlTestResult['test_result'])->pluck('name')[0]) . "`)";
                }

                if ($FrameworkControlTestResultOldArray['summary'] != $FrameworkControlTestResult['summary']) {
                    $changes[] = "`summary` (`" .
                        ($FrameworkControlTestResultOldArray['summary']) . "`=>`" .
                        ($FrameworkControlTestResult['summary']) . "`)";
                }

                if ($FrameworkControlTestResultOldArray['test_date'] != $FrameworkControlTestResult['test_date']) {
                    $changes[] = "`test date` (`" .
                        ($FrameworkControlTestResultOldArray['test_date']) . "`=>`" .
                        ($FrameworkControlTestResult['test_date']) . "`)";
                }
            }

            if ($FrameworkControlTestAuditOldArray) {
                if ($FrameworkControlTestAuditOldArray['status'] != $FrameworkControlTestAudit['status']) {
                    $changes[] = "`status` (`" .
                        (TestStatus::where('id', $FrameworkControlTestAuditOldArray['status'])->pluck('name')[0]) . "`=>`" .
                        (TestStatus::where('id', $FrameworkControlTestAudit['status'])->pluck('name')[0]) . "`)";
                }

                if ($FrameworkControlTestAuditOldArray['tester'] != $FrameworkControlTestAudit['tester']) {
                    $changes[] = "`test result` (`" .
                        (User::where('id', $FrameworkControlTestAuditOldArray['tester'])->pluck('username')[0]) . "`=>`" .
                        (User::where('id', $FrameworkControlTestAudit['tester'])->pluck('username')[0]) . "`)";
                }
            }

            $message =  __(
                'compliance.NotifyAuditUpdated',
                [
                    'user' => auth()->user()->name,
                    'changes' => implode(', ', $changes)
                ]
            );
            write_log($FrameworkControlTestAudit->id, auth()->id(), $message, FrameworkControlTestAudit::class);

            DB::commit();
            event(new AuditResultCreated($FrameworkControlTestResult));


            $response = array(
                'status' => true,
                'reload' => true,
                'message' => __('compliance.AuditResultWasUpdatedSuccessfully'),
            );
            return response()->json($response, 200);
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
        $frameworkControlTestAudit = FrameworkControlTestAudit::find($id);
        $frameworkControlTestResult = FrameworkControlTestResult::where('test_audit_id', $id)->delete();
        $frameworkControlTestAudit->delete();
        return response()->json($id, 200);
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    private function getAudit($request, $statusArray)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['name'],
            'relationships' => ['FrameworkControlWithFramworks', 'UserTester'],
            // 'other_global_filters' => [],
            'other_global_filters' => ['last_date', 'next_date'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'FrameworkControlWithFramworks:id,short_name,family',
            'UserTester:id,name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Custom condition for filter controls
        $customConditions = [
            'whereIn' => [
                'status' => $statusArray
            ]
        ];

        if (!auth()->user()->hasPermission('audits.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembersIds =  User::with('teams')->where(
                    'department_id',
                    $departmentId
                )->orWhere('id', auth()->id())->pluck('id')->toArray();
                $customConditions['whereIn']['tester'] =  $departmentMembersIds;
            } else {
                $customConditions['where']['tester'] =  auth()->id();
            }
        }
        // Start filter via advanced search
        // framework
        $controlFrameworkFilter = $request->columns[1]['search']['value'] ?? '';
        $frameworkControlIdsAdvancedSearch = [];
        if ($controlFrameworkFilter) {
            $framework = Framework::where('name', $controlFrameworkFilter)->first();
            $frameworkControlIdsAdvancedSearch = $framework->FrameworkControls()->pluck('framework_controls.id')->toArray();
        }

        // family
        $controlFamilyFilter = $request->columns[2]['search']['value'] ?? '';
        $familyControlIdsAdvancedSearch = [];
        if ($controlFamilyFilter) {
            $family = Family::where('name', $controlFamilyFilter)->first();
            $familyControlIdsAdvancedSearch = $family->frameworkControls()->pluck('framework_controls.id')->toArray();
        }

        $advancedSearchControlIds = [];
        if (count($frameworkControlIdsAdvancedSearch) && count($familyControlIdsAdvancedSearch)) {
            $advancedSearchControlIds = array_intersect(
                $frameworkControlIdsAdvancedSearch,
                $familyControlIdsAdvancedSearch
            );
        } else {
            if (count($frameworkControlIdsAdvancedSearch)) {
                $advancedSearchControlIds = $frameworkControlIdsAdvancedSearch;
            } else if (count($familyControlIdsAdvancedSearch)) {
                $advancedSearchControlIds = $familyControlIdsAdvancedSearch;
            }
        }
        // End filter via advanced search

        // Start filter via global search
        $frameworkControlIdsGlobalSearch = [];
        $familyControlIdsGlobalSearch = [];
        if ($dataTableDetails['search']['global']) {
            // framework
            $frameworks = Framework::where('name', 'like', '%' . $dataTableDetails['search']['global'] . '%')->get();
            foreach ($frameworks as $framework) {
                $frameworkControlIdsGlobalSearch = array_unique(array_merge(
                    $frameworkControlIdsGlobalSearch,
                    $framework->FrameworkControls()->pluck('framework_controls.id')->toArray()
                ), SORT_REGULAR);
            }

            // family
            $families = Family::where('name', 'like', '%' . $dataTableDetails['search']['global'] . '%')->get();
            foreach ($families as $family) {
                $familyControlIdsGlobalSearch = array_unique(array_merge(
                    $familyControlIdsGlobalSearch,
                    $family->frameworkControls()->pluck('framework_controls.id')->toArray()
                ), SORT_REGULAR);
            }
        }
        $globalSearchControlIds = [];
        if (count($frameworkControlIdsGlobalSearch) && count($familyControlIdsGlobalSearch)) {
            $globalSearchControlIds = array_unique(array_merge(
                $frameworkControlIdsGlobalSearch,
                $familyControlIdsGlobalSearch
            ), SORT_REGULAR);
        } else {
            if (count($frameworkControlIdsGlobalSearch)) {
                $globalSearchControlIds = $frameworkControlIdsGlobalSearch;
            } else if (count($familyControlIdsGlobalSearch)) {
                $globalSearchControlIds = $familyControlIdsGlobalSearch;
            }
        }
        // End filter via global search

        if ($controlFrameworkFilter || $controlFamilyFilter) {
            $customConditions['whereIn']['framework_control_id'] = $advancedSearchControlIds;
        }
        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            FrameworkControlTestAudit::class,
            $dataTableDetails,
            $customFilterFields,
            $customConditions,
            [
                'whereIn' => [
                    'framework_control_id' => $globalSearchControlIds
                ]
            ]
        );

        $mainTableColumns = getTableColumnsSelect(
            'framework_control_test_audits',
            [
                'id',
                'test_id',
                'tester',
                'last_date',
                'next_date',
                'created_at',
                'name',
                'framework_control_id'
            ]
        );

        // Getting records with apply global search */
        $customConditions["orderBy"] = [
            "created_at" => "desc"
        ];
        $activeAudits = getDatatableFilterRecords(
            FrameworkControlTestAudit::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $customConditions,
            [],
            [
                'whereIn' => [
                    'framework_control_id' => $globalSearchControlIds
                ]
            ]
        );

        // Custom activeAudits response data as needs
        $data_arr = [];
        foreach ($activeAudits as $activeAudit) {
            if ($activeAudit->FrameworkControlWithFramworks) {
                $frameworkNames = '';
                if (count($activeAudit->FrameworkControlWithFramworks->Frameworks)) {
                    $frameworkNames .= implode(
                        ', ',
                        array_map(function ($element) {
                            return $element['name'];
                        }, $activeAudit->FrameworkControlWithFramworks->Frameworks->toArray())
                    );
                }

                $familyNames = '';
                if (count($activeAudit->FrameworkControlWithFramworks->Families)) {
                    $familyNames .= implode(
                        ', ',
                        array_map(function ($element) {
                            return $element['name'];
                        }, $activeAudit->FrameworkControlWithFramworks->Families->toArray())
                    );
                }
            } else {
                $frameworkNames = "";
                $familyNames = "";
            }

            $data_arr[] = array(
                'id' =>  $activeAudit->id,
                'framework' => $frameworkNames,
                'FrameworkControlWithFramworks' => $activeAudit->FrameworkControlWithFramworks->short_name ?? '',
                'name' => $activeAudit->name,
                'UserTester' => ($activeAudit->UserTester) ? $activeAudit->UserTester->name : '',
                'created_at' => $activeAudit->created_at,
                'last_date' => $activeAudit->last_date,
                'next_date' => $activeAudit->next_date,
                'editable' => $this->isLastAudit($activeAudit),
                'Actions' => $activeAudit->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAudits(Request $request)
    {
        return $this->getAudit($request, [1, 2, 3, 4]);
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function GetPastAudits(Request $request)
    {
        return $this->getAudit($request, [5]);
    }

    public function GetLogsAudits($id)
    {

        $logs = FrameworkControlTestAudit::itemLogs($id);
        // return $logs;
        $counter = 1;
        $groupLogs = $logs->map(function ($log) use ($counter) {
            return (object)[
                'responsive_id' =>  $counter,
                'id' => $counter++,
                'message' => $log->message,
                'subject_id' => $log->message,
                'subject_type' => $log->message,
                'user' => $log->user->name ?? '',
                'properties' => $log->message,
                'host' => $log->message,
                'created_at' => $log->timestamp->toDateTimeString(),
                'updated_at' => $log->timestamp->toDateTimeString(),

                // 'Actions' => $test->id,
            ];
        });

        return response()->json($groupLogs, 200);
    }
    public function RiskToResult(Request $request)
    {

        $risks = $request->risks;
        $auditID = $request->auditID;
        $resultID = FrameworkControlTestAudit::find($auditID)->FrameworkControlTestResult->id;
        FrameworkControlTestResultsToRisk::where('test_results_id', $resultID)->delete();
        if ($risks) {
            foreach ($risks as $risk) {
                FrameworkControlTestResultsToRisk::create([
                    'risk_id' => $risk,
                    'test_results_id' => $resultID
                ]);
            }
        }
        $SelectedRiskIds = FrameworkControlTestResultsToRisk::where('test_results_id', $resultID)->pluck('risk_id')->toArray();
        $resultRisks = Risk::whereIn('id', $SelectedRiskIds)->get();
        $html = '';
        foreach ($resultRisks as  $key => $resultRisk) {
            $html .= "<tr>";
            $html .= "<td>";
            $html .= $key + 1;
            $html .= "</td>";
            $html .= "<td>";
            $html .= $resultRisk->status;
            $html .= "</td>";
            $html .= "<td>";
            $html .= $resultRisk->subject;
            $html .= "</td>";
            $html .= "<td>";
            $html .= $resultRisk->created_at->format('d/m/Y');
            $html .= "</td>";
            $html .= "</tr>";
        }
        return response()->json($html, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRiskWithAudit(Request $request)
    {
        $risk = [];
        // Validation rules
        $validator = Validator::make($request->all(), [
            'subject' => ['required'],
            'reference_id' => ['nullable', 'max:20'],
            'framework_id' => ['nullable', 'exists:frameworks,id'],
            'control_id' => ['nullable', 'exists:framework_controls,id'],
            'location_id' => ['nullable', 'array'],
            'location_id.*' => ['exists:locations,id'],
            'affected_asset_id' => ['nullable', 'array'],
            'affected_asset_id.*' => ['exists:assets,id'],
            'risk_source_id' => ['nullable', 'exists:sources,id'],
            'risk_scoring_method_id' => ['nullable', 'exists:scoring_methods,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'owner_id' => ['nullable', 'exists:users,id'],
            'owner_manager_id' => ['nullable', 'exists:users,id'],
            'assessment' => ['nullable'],
            'notes' => ['nullable'],
            'review_date' => ['nullable'],
            'mitigation_id' => ['nullable', 'exists:mitigations,id'],
            'mgmt_review' => ['nullable'],
            'project_id' => ['nullable'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'close_id' => ['nullable'],
            'risk_catalog_mapping_id' => ['nullable', 'array'],
            'risk_catalog_mapping_id.*' => ['exists:risk_catalogs,id'],
            'threat_catalog_mapping_id' => ['nullable', 'array'],
            'threat_catalog_mapping_id.*' => ['exists:threat_catalogs,id'],
            'template_group_id' => ['nullable'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'team_id' => ['nullable', 'array'],
            'team_id.*' => ['exists:teams,id'],
            'technology_id' => ['nullable', 'exists:technologies,id'],
            'additional_stakeholder_id' => ['nullable', 'array'],
            'additional_stakeholder_id.*' => ['exists:users,id'],
            'current_likelihood_id' => ['nullable', 'exists:likelihoods,id'],
            'current_impact_id' => ['nullable', 'exists:impacts,id'],
            'risk_assessment' => ['nullable', 'string'],
            'additional_notes' => ['nullable', 'string'],
            'supporting_documentation' => ['nullable', 'array'],
            'supporting_documentation.*' => ['nullable', 'file'],
            'auditID' => ['required', 'exists:framework_control_test_results,id'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('compliance.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            // Limit the subject's length
            $alert = false;
            $maxlength = Setting::where('name', 'maximum_risk_subject_length')->first()['value'];
            if (strlen($request->subject) > $maxlength) {
                $alert = __('locale.RiskSubjectTruncated', ['limit' => $maxlength]);
                $request->subject = substr($request->subject, 0, $maxlength);
            }
            DB::beginTransaction();
            try {
                // Start submitting basic risk data
                $risk = Risk::create([
                    'status' => 'New',
                    'subject' => $request->subject,
                    'reference_id' => $request->reference_id,
                    'regulation' => $request->framework_id,
                    'control_id' => $request->control_id, // control_number
                    'source_id' => $request->risk_source_id,
                    'category_id' => $request->category_id,
                    'owner_id' => $request->owner_id,
                    'manager_id' => $request->owner_manager_id,
                    'assessment' => $request->risk_assessment, // try_encrypt customization_extra
                    'notes' => $request->additional_notes, // try_encrypt customization_extra
                    'project_id' => $request->project_id,
                    'submitted_by' => auth()->id() ?? 1, // now to test without login
                    'risk_catalog_mapping' => $request->has('risk_catalog_mapping_id') ? implode(",", $request->risk_catalog_mapping_id) : "",
                    'threat_catalog_mapping' => $request->has('threat_catalog_mapping_id') ? implode(",", $request->threat_catalog_mapping_id) : "",
                    'template_group_id' => $request->template_group_id ?? 0, // customization_extra
                ]);

                // Save locations
                foreach ($request->location_id ?? [] as $location_id) {
                    RiskToLocation::create([
                        'risk_id' => $risk->id,
                        'location_id' => $location_id,
                    ]);
                }
                // Save teams
                foreach ($request->team_id ?? [] as $team_id) {
                    RiskToTeam::create([
                        'risk_id' => $risk->id,
                        'team_id' => $team_id,
                    ]);
                }
                // Save technologies
                foreach ($request->technology_id ?? [] as $technology_id) {
                    RiskToTechnology::create([
                        'risk_id' => $risk->id,
                        'technology_id' => $technology_id,
                    ]);
                }
                // Save additional stakeholders
                foreach ($request->additional_stakeholder_id ?? [] as $additional_stakeholder_id) {
                    RiskToAdditionalStakeholder::create([
                        'risk_id' => $risk->id,
                        'user_id' => $additional_stakeholder_id,
                    ]);
                }
                // End submitting basic risk data

                // Start Submit risk scoring
                $riskScoringMethodId = $request->risk_scoring_method_id;
                if (!$riskScoringMethodId) { // If the scoring method is not passed (If the scoring method is invalid then go with the defaults)
                    submit_risk_scoring($risk->id);
                } else { // If the scoring method is passed (If there's a valid scoring method use the provided values)
                    submit_risk_scoring($risk->id, $riskScoringMethodId, $request->current_likelihood_id, $request->current_impact_id);
                }
                // End Submit risk scoring

                // Start Process the data from the Affected Assets widget
                if ($request->has('affected_asset_id')) {
                    $this->processSelectedAssetsAssetGroupsOfType($risk->id, $request->affected_asset_id, 'risk');
                }
                // End Process the data from the Affected Assets widget

                // Store tags for risk
                $allAssetTags = Tag::whereIn('id', $request->tags ?? [])->get();
                $risk->tags()->saveMany($allAssetTags);

                // File upload Start
                if ($request->hasFile('supporting_documentation')) {
                    foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                        if ($supporting_documentation->isValid()) {
                            $path = $supporting_documentation->store('risk/' . $risk->id);
                            $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                            $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                            File::create([
                                'risk_id' => $risk->id,
                                'view_type' => 1,
                                'name' => $fileName,
                                'unique_name' => $path,
                                'type' => $supporting_documentation->getClientMimeType(),
                                'size' => $supporting_documentation->getSize(),
                                'user' => auth()->id()
                            ]);
                        } else {
                            DB::rollBack();
                            Storage::deleteDirectory('risk/' . $risk->id);
                            $response = array(
                                'status' => false,
                                'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                'message' => __('compliance.ThereWasAProblemAddingTheRisk') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                }
                // File upload End

                $FrameworkControlTestResultsToRisk = FrameworkControlTestResultsToRisk::create([
                    'risk_id' => $risk->id,
                    'test_results_id' => $request->auditID
                ]);

                DB::commit();
                event(new AuditRiskCreated($risk, $FrameworkControlTestResultsToRisk));
                $response = array(
                    'status' => true,
                    'alert' => $alert,
                    // 'message' => __('locale.RiskWasAddedSuccessfully'),
                    'redirect_to' => route('admin.compliance.audit.edit', $request->auditID),

                    'message' => __('compliance.RiskSubmitSuccess', ["subject" => $request->subject]),

                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                Storage::deleteDirectory('risk/' . $risk->id);

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Get last audit
     *
     * @param  FrameworkControlTestAudit $frameworkControlTestAudit
     * @return Boolean
     */
    protected function isLastAudit($frameworkControlTestAudit)
    {
        // Get the framework control last audit
        $lastAudit = $frameworkControlTestAudit->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first();

        // Check if the framework control has many audits and this audit isn't last audit
        if (($lastAudit->id ?? null) != $frameworkControlTestAudit->id) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxActiveExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworkControlTestAuditsExport('active'), 'Active_audits.xlsx');
        else
            return 'Active_audits.pdf';
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxPastExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new FrameworkControlTestAuditsExport('past'), 'Past_audits.xlsx');
        else
            return 'Past_audits.pdf';
    }
    public function notificationsSettingsActiveAduit()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.compliance.audit.index'), 'name' => __('locale.ViewActiveAudits')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [44, 45, 46, 19,73];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [72];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            44 => ['Summary', 'Test_Date', 'Test_Name', 'Test_Tester', 'Test_Result', 'Control_Owner', 'Submission_Date'],
            45 => ['Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results', 'Source', 'Category', 'Regulation', 'Additional_Stakeholder', 'Teams', 'Owner_Risk'],
            46 => ['comment', 'Comment_By', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            19 => ['Document_Audit_Status', 'Test_Tester', 'Control_Owner', 'Control_Name', 'Document_Name', 'Document_Owner'],
            73 => ['Control_Name', 'Control_Owner', 'Control_Tester', 'Objective_Audit_status', 'Control_Objective_Name'],
            72 => ['Control_Name','Summary', 'Test_Date', 'Test_Name', 'Test_Tester', 'Test_Result', 'Control_Owner', 'Submission_Date'],

        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            44 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            45 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'), 'creator' => __('locale.RiskCreator'), 'Team-teams' => __('locale.TeamsOfRisk'), 'Stakeholder-teams' => __('locale.StakeholdersOfRisk')],
            46 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            19 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'), 'Document-Owner' => __('locale.DocumentOwner'), 'Document-Stakeholder' => __('locale.DocumentStakeholder'), 'Document-Teams' => __('locale.DocumentTeams'), 'Document-reviewers' => __('locale.DocumentReviewers'), 'Document-Creator' => __('locale.DocumentCreator')],
            73 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester'),'Responsible_Person' => __('locale.Responsible_Person')],
            72 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],

        ];
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
}
