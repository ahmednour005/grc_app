<?php

namespace App\Http\Controllers\admin\governance;

use App\Http\Controllers\Controller;
use App\Models\ControlAuditEvidence;
use App\Models\ControlAuditObjective;
use App\Models\ControlAuditPolicy;
use Illuminate\Http\Request;
use App\Models\Framework;
use App\Models\FrameworkControlMapping;
use App\Models\FrameworkControl;
use App\Models\User;
use App\Models\Family;
use App\Models\ControlPriority;
use App\Models\ControlPhase;
use App\Models\ControlType;
use App\Models\ControlMaturity;
use App\Models\ControlClass;
use App\Models\ControlControlObjective;
use App\Models\ControlDesiredMaturity;
use App\Models\ControlObjective;
use App\Models\Department;
use App\Models\Team;
use App\Models\FrameworkControlTest;
use App\Models\ItemsToTeam;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTestResult;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use App\Events\FrameworkCreated;
use App\Events\FrameworkUpdated;
use App\Events\FrameworkDeleted;
use App\Events\ControlCreated;
use App\Events\ControlUpdated;
use App\Events\ControlDeleted;
use App\Events\DocumentCreated;
use App\Events\DocumentUpdated;
use App\Events\DocumentDeleted;
use App\Events\ControlObjectiveCreated;
use App\Events\ControlEvidenceCreated;
use App\Events\ControlEvidenceUpdated;
use App\Events\ControlAuditCreated;
use App\Events\CateogryCreated;
use App\Events\CateogryUpdated;
//Document
use App\Models\Document;
use App\Models\DocumentTypes;
use App\Models\DocumentStatus;
use App\Models\File;
use App\Models\Privacy;
use App\Models\DocumentNote;
use App\Models\DocumentNoteFile;
use App\Models\Evidence;
use App\Models\Action;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;


class GovernanceController extends Controller
{
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {

        //Frameworks
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Governance')],
            ['name' => __('governance.Define Control Frameworks')]
        ];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $frameworks = Framework::with('FrameworkControls', 'families')->get();
        $families = Family::whereNull('parent_id')->select('id', 'name')->with('custom_families_framework:id,name,parent_id')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        $owners = User::all();
        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->with('Frameworks')->get();
        $category1 = DB::select('SELECT parent  , framework_control_mappings.id  ,frameworks.id as value,
    framework_id ,frameworks.description, short_name , name FROM frameworks ,framework_control_mappings , framework_controls where frameworks.id = framework_id and framework_control_mappings.framework_control_id  = framework_controls.id GROUP BY name ,short_name;
        ');

        $category2 = DB::select('SELECT * FROM frameworks;');
        $category2 = Framework::with(['only_families', 'only_sub_families'])->get();

        $tempDomainsId = [];
        foreach ($category2 as $framework) {
            $tempDomainsId = [];
            foreach ($framework->only_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_families = $tempDomainsId;

            $tempDomainsId = [];
            foreach ($framework->only_sub_families as $family) {
                array_push($tempDomainsId, $family->id);
            }
            $framework->_only_sub_families = $tempDomainsId;
        }
        $group = array();
        // dd($category2->toArray());

        foreach ($category1 as $value) {
            $group[$value->name][] = $value;
        }

        return view('admin.content.governance.index', ['pageConfigs' => $pageConfigs], compact('teams', 'testers', 'group', 'frameworks', 'breadcrumbs', 'category2', 'families', 'priorities', 'owners', 'phases', 'types', 'maturities', 'classes', 'owners', 'desiredMaturities', 'parentControls'));
    }

    public function ajaxGetListTest(Request $request, $id)
    {

        $tests = FrameworkControlMapping::with('FrameworkControl')->where('framework_id', $id)->get()->map(function ($test) {
            // parentFamily
            if ($test->FrameworkControl[0]) {
                $controlName = $test->FrameworkControl[0]->short_name;
                if ($test->FrameworkControl[0]->Frameworks()->count()) {
                    $controlName .= ' (' . implode(', ', $test->FrameworkControl[0]->Frameworks()->pluck('name')->toArray()) . ')';
                }
            } else {
                $controlName = "";
            }

            return (object)[
                'responsive_id' => '',
                'id' => $test->FrameworkControl[0]->id,
                'control' => $controlName,
                'description' => $test->FrameworkControl[0]->description,
                // 'control_number' => $test->FrameworkControl[0]->control_number,
                // 'role' => $test->FrameworkControl[0]->id,
                'map_id' => $test->id,

                // 'owner_name' => $test->FrameworkControl[0]->User->name,
                'family_name' => $test->FrameworkControl[0]->Family->name,
                'parent_family_name' => $test->FrameworkControl[0]->Family->parentFamily->name,
                // 'class_name' => $test->FrameworkControl[0]->classes->pluck('name'),
                // 'phases_name' => $test->FrameworkControl[0]->phases->pluck('name'),
                // 'prio_name' => $test->FrameworkControl[0]->priorities->pluck('name'),
                // 'mat_name' => $test->FrameworkControl[0]->maturities->pluck('name'),
                // 'desired_name' => $test->FrameworkControl[0]->desiredMaturities->pluck('name'),
            ];
        });


        return response()->json($tests, 200);
    }

    public function ajaxGetListMap(Request $request, $id)
    {

        $controls = DB::select('select * from framework_controls where id not
    in ( SELECT framework_control_id FROM frameworks ,framework_control_mappings ,
                                          framework_controls where frameworks.id = framework_id and framework_id = "' . $id . '" and framework_control_mappings.framework_control_id = framework_controls.id ) ;
        ');


        $html = "";
        if (!empty($controls)) {
            foreach ($controls as $control) {
                $FrameworkControl = FrameworkControl::find($control->id);

                if ($FrameworkControl) {
                    $controlName = $FrameworkControl->short_name;
                    if ($FrameworkControl->Frameworks()->count()) {
                        $controlName .= ' (' . implode(', ', $FrameworkControl->Frameworks()->pluck('name')->toArray()) . ')';
                    }
                } else {
                    $controlName = "";
                }

                $html .= "<input type= checkbox  id= control  name= control[]  value=" . $control->id . ">";
                $html .= "<label class = gov_check for=control>" . $controlName . "</label><br>";
            }
            $html .= "<input type= hidden  id= control  name= frame_id  value=" . $id . ">";
            $html .= "  <button type= submit  class= gov_btn> mapping </button>";
        } else {
            $html .= "<h3 class=gov_err> no controls for mapping </h3><br>";
        }
        echo $html;
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:255', 'unique:frameworks,name'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'family' => ['required', 'array'],
            'family.*' => ['required', 'exists:families,id'],
            'sub_family' => ['required', 'array'],
            'sub_family.*' => ['required', 'exists:families,id'],
        ];
        // Validation rules
        $validator = Validator::make($request->all(), $rules);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {
                // Start adding framework data
                $framework = Framework::create([
                    "name" => $request->name,
                    "description" => $request->description,
                    "icon" => $request->icon
                ]); // End adding framework data


                $framework->families()->attach($request->family); // attach domains to framewrok

                $subDomains = [];

                foreach ($request->sub_family as $subFamily) {
                    $parentDomainId = Family::where('id', $subFamily)->pluck('parent_id')->first();
                    $subDomains[$subFamily] = ['parent_family_id' => $parentDomainId];
                }

                $framework->families()->attach($subDomains); // attach sub-domains to framewrok

                DB::commit();
                event(new FrameworkCreated($framework));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddingSuccessfully'),
                );

                $message = __('governance.A New Framework Created by name') . ' "' . ($framework->name ?? __('locale.[No FrameWork Name]')) . '" '
                    . __('governance.and the Description of it is') . ' "' . ($framework->description ?? __('locale.[No Description]')) . '" '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($framework->id, auth()->id(), $message, 'Creating Framework');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $framework = Framework::find($id);
        if ($framework) {
            $rules = [
                'name' => ['required', 'max:255', 'unique:frameworks,name,' . $framework->id],
                'description' => ['required', 'string'],
                'icon' => ['required', 'string'],
                'family' => ['required', 'array'],
                'family.*' => ['required', 'exists:families,id'],
                'sub_family' => ['required', 'array'],
                'sub_family.*' => ['required', 'exists:families,id'],
            ];

            // Validation rules
            $validator = Validator::make($request->all(), $rules);
            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemUpdatingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // to get the old data of department to use it in log
                    $frameworkOldDetAils = Framework::find($id);
                    // Start updating framework data
                    $framework->update([
                        "name" => $request->name,
                        "description" => $request->description,
                        "icon" => $request->icon
                    ]); // End updating framework data

                    $subDomains = $framework->families()->whereNotNull('parent_family_id')->pluck('family_id')->toArray();

                    // Start saving domains and  sub-domains
                    $currentDomains = $framework->families()->whereNull('parent_family_id')->pluck('family_id')->toArray();
                    $deletedDomains = array_diff($currentDomains ?? [], $request->family ?? []);
                    $addedDomains = array_diff($request->family ?? [], $currentDomains ?? []);

                    $currentSubDomains = $framework->families()->whereNotNull('parent_family_id')->pluck('family_id')->toArray();
                    $deletedSubDomains = array_diff($currentSubDomains ?? [], $request->sub_family ?? []);
                    $addedSubDomains = array_diff($request->sub_family ?? [], $currentSubDomains ?? []);

                    $frameControls = $framework->FrameworkControls()->pluck('family')->toArray();
                    if (count(array_intersect($frameControls, $deletedSubDomains))) {
                        DB::rollBack();
                        $response = array(
                            'status' => false,
                            'reload' => false,
                            'message' => __('governance.ThereWasAProblemUpdatingTheFrameworkControl') . "<br>" . __('governance.FrameworkDeletedDomainsOrSubDomainsFoundedInItsControls'),
                        );
                        return response()->json($response, 502);
                    }

                    // Delete deleted domains
                    $framework->families()->detach($deletedDomains);

                    // Add added domains
                    $framework->families()->attach($addedDomains); // attach domains to framewrok


                    // Delete deleted sub-domains
                    $framework->families()->detach($deletedSubDomains);

                    $subDomains = [];
                    // Add added sub-domains
                    foreach ($addedSubDomains as $subFamily) {
                        $parentDomainId = Family::where('id', $subFamily)->pluck('parent_id')->first();
                        $subDomains[$subFamily] = ['parent_family_id' => $parentDomainId];
                    }

                    $framework->families()->attach($subDomains); // attach sub-domains to framewrok
                    // End saving domains and  sub-domains

                    DB::commit();
                    event(new FrameworkUpdated($framework));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.FrameworkControlWasUpdatedSuccessfully'),
                    );
                    $message = __('governance.A Framework that name is') . ' "' . ($framework->name ?? __('locale.[No Name]')) . '"';

                    if ($framework->name != $frameworkOldDetAils->name) {
                        $message .= ' ' . __('governance.changed to') . ' "' . ($framework->name ?? __('locale.[No Name]')) . '"';
                    } else {
                        $message .= ' ' . __('governance.and the description of it') . ' "' . ($frameworkOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    if ($framework->description != $frameworkOldDetAils->description) {
                        $message .= ' ' . __('governance.And the description changed from') . ' "' . ($frameworkOldDetAils->description ?? __('locale.[No Description]')) . '"';
                    }

                    $message .= ' ' . __('governance.to') . ' "' . ($framework->description ?? __('locale.[No Description]')) . '"';
                    $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';


                    write_log($framework->id, auth()->id(), $message, 'Updating Framework');
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();

                    $response = array(
                        'status' => false,
                        'errors' => [],
                        'message' => __('locale.Error')
                        // 'message' => $th->getMessage()
                    );
                    return response()->json($response, 502);
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

    public function destroy(Request $request, $id)
    {
        $framework = Framework::find($id);

        if ($framework) {
            DB::beginTransaction();
            try {
                //Delete Related Mapping Controls
                DB::table('framework_control_mappings')->where('framework_id', $id)->delete();
                $framework->delete();

                DB::commit();
                // event(new FrameworkDeleted($framework));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl') . "<br>" . __('governance.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl');
                }
                $response = array(
                    'status' => false,
                    'reload' => false,
                    'message' => $errorMessage,
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'reload' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    public function frameMap(Request $request)
    {
        foreach ($request->get("control") as $subject) {
            $frames = new FrameworkControlMapping();
            $frames->framework_control_id = $subject;
            $frames->framework_id = $request->get("frame_id");
            $frames->save();
        }
        return redirect()->back();
    }

    public function unMapControl(Request $request, $id)
    {

        DB::table('framework_control_mappings')->where('id', $id)->delete();
        // return redirect()->back();

    }

    public function editControl(Request $request, $id)
    {
        $isParent = FrameworkControl::find($id)->frameworkControls()->count();
        $isChild = FrameworkControl::find($id)->parentFrameworkControl()->exists();

        $controls = DB::select('select * from framework_controls where id = "' . $id . '"  ');
        $_control = FrameworkControl::with('Frameworks:id')->find($id);
        // dd($_control->toArray());
        $family = Family::where('id', $controls[0]->family)->with('parentFamily')->first();
        $parentFamily = $family->parentFamily;
        $subFamilies = $parentFamily->families;
        $parentControls = [];

        if ($isParent == 0) {
            $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->where('id', '<>', $id)->get();
        }

        $families = Family::whereNull('parent_id')->with('families')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        // $owners=ControlOwner::all();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::whereHas('role.rolePermissions', function ($query) {
            $query->where('key', 'audits.result');
        })->get();
        $test_name = FrameworkControlTest::where('framework_control_id', $id)->first();

        $_frameworks = Framework::select('id', 'name')->with(['only_families:id,name', 'only_sub_families:id,name,parent_id', 'FrameworkControlsFrameworks:id,short_name'])->get();
        $frameworks = [];
        foreach ($_frameworks as $framework) {
            $tempFramework = [
                'id' => $framework->id,
                'name' => $framework->name,
                'domains' => [],
                'controls' => array_map(function ($control) {
                    return [
                        "id" => $control['id'],
                        // "short_name" => $control['short_name'],
                        "name" => $control['short_name'] . ' (' . implode(', ', array_map(
                            function ($framework) {
                                return $framework['name'];
                            },
                            $control['frameworks']
                        )) . ')'
                    ];
                }, $framework->FrameworkControlsFrameworks->toArray()),
            ];
            $frameworkDomains = [];
            foreach ($framework->only_families as $family) {
                $frameworkDomains = [
                    'id' => $family->id,
                    'name' => $family->name,
                ];

                $frameworkDomainSunDomains = [];
                foreach ($framework->only_sub_families as $sub_family) {
                    if ($family->id == $sub_family->parent_id) {
                        array_push($frameworkDomainSunDomains, [
                            'id' => $sub_family->id,
                            'name' => $sub_family->name,
                        ]);
                    }
                }
                $frameworkDomains['sub_domains'] = $frameworkDomainSunDomains;
                array_push($tempFramework['domains'], $frameworkDomains);
            }
            array_push($frameworks, $tempFramework);
        }

        unset($_frameworks);

        $html = "";
        foreach ($controls as $control) {
            // id
            $html .= "<input type='hidden' name='id' value='$control->id' />";

            //name
            $html .= "<div class='mb-1'>
                    <label for='title' class='form-label'>name</label>
                    <input type='text' name='name' class=' form-control' placeholder='' required value='$control->short_name' />
                    <span class='error error-name '></span>
                </div>";


            //description
            $html .= "<div class='mb-1'>
                  <label for='desc' class='form-label'>Description</label>
                  <textarea   class='form-control'  name='description' >$control->description</textarea>
                  <span class='error error-description ' ></span>

                </div>";
            // control number
            $html .= "<div class='mb-1'>
                  <label for='title' class='form-label'>Control number</label>
                  <input type='text' name='number' class=' form-control' placeholder='' value='$control->control_number' />
                </div>";

            //long_name
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='long_name'>  long name </label>
                <input class ='form-control'  type= 'text'    name='long_name' value='$control->long_name' />
              </div>";

            // framework
            $html .= "<div class='mb-1 framework-container'>
       <label class = 'form-label' for='family'>" . __('locale.Framework') . "</label>
       <select class='select2 form-select  add-control-framework-select' name='framework' required " . ($isParent ? 'disabled' : '') . ">
       <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            $controlFramework = null;

            foreach ($frameworks as $framework) {

                if (isset($_control['frameworks']) && @$_control['frameworks'][0]->id == $framework['id'])
                    $controlFramework = $framework;

                if ($isParent)
                    if (isset($_control['frameworks']) && @$_control['frameworks'][0]->id != $framework['id'])
                        continue;
                $html .= "<option value='" . @$framework['id'] . "' data-domains='" . json_encode(@$framework['domains']) . "' data-controls='" . json_encode(@$framework['controls']) . "'  " . (@$_control['frameworks'][0]->id == $framework['id'] ? 'selected' : '') . ">" . $framework['name'] . "</option>";
            }

            $html .= "</select>
        <span class='error error-framework'></span>
       </div>";

            // domain
            $html .= "<div class='mb-1 family-container'>
       <label class = 'form-label' for='family'>  Control domain </label>
       <select class='select2 form-select domain_select' name='family' " . ($isChild ? 'disabled' : '') . ">
       <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            $controDomains = null;
            if (isset($controlFramework['domains'])) {
                foreach ($controlFramework['domains'] as $domain) {
                    if ($parentFamily->id == $domain['id'])
                        $controDomains = $domain;
                    $html .= "<option value='" . $domain['id'] . "' " . ($parentFamily->id == $domain['id'] ? 'selected' : '') . " data-families='" . json_encode($domain['sub_domains']) . "'>" . $domain['name'] . "</option>";
                }
            }

            $html .= "</select>
        <span class='error error-family'></span>
       </div>";

            // sub domain
            $html .= "<div class='mb-1'>
      <label class = 'form-label' for='family'>" . __('locale.control_sub_domain') . "</label>
      <select class='select2 form-select' name='sub_family' " . ($isChild ? 'disabled' : '') . ">
      <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            if (isset($controDomains['sub_domains'])) {
                foreach ($controDomains['sub_domains'] as $subDomain) {
                    $html .= "<option value='" . $subDomain['id'] . "' " . ($control->family == $subDomain['id'] ? 'selected' : '') . ">" . $subDomain['name'] . "</option>";
                }
            }

            $html .= "</select>
      <span class='error error-sub_family'></span>
      </div>";

            // Parent control
            $html .= "<div class='mb-1'>
      <label class = 'form-label' for='family'>" . __('governance.ParentControlFramework') . "</label>
      <select class='select2 form-select' name='parent_id' " . ($isParent ? 'disabled' : '') . ">
        <option  value=''>" . __('locale.select-option') . "</option>";
            foreach ($parentControls as $parentControl) {
                $controlName = $parentControl->short_name;
                if ($parentControl->Frameworks()->count()) {
                    $controlName .= ' (' . implode(', ', $parentControl->Frameworks()->pluck('name')->toArray()) . ')';
                }
                $html .= "<option value='$parentControl->id' " . ($parentControl->id == $control->parent_id ? 'selected' : '') . ">$controlName</option>";
            }
            $html .= "</select>
      <span class='error error-parent_id'></span>
      </div>";

            // mitigation_guidance
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='mitigation_percent'>  mitigation percent  </label>
                <input class ='form-control'  type= 'text'    name='mitigation_percent' value='$control->mitigation_percent' />
              </div>";

            // supplemental_guidance
            $html .= "<div class='mb-1'>
                  <label class = 'form-label' for='supplemental_guidance'>  supplemental guidance  </label>
                  <input class ='form-control'  type= 'text'    name='supplemental_guidance' value='$control->supplemental_guidance' />
                </div>";
            // priority
            $html .= "<div class='mb-1'>
                  <label class = 'form-label' for='priority'>  Control priority </label>
                  <select class='select2 form-select' name='priority'>
                    <option  value=''> select priority</option>";
            foreach ($priorities as $priority) {
                $html .= "<option value='$priority->id' " . ($control->control_priority == $priority->id ? 'selected' : '') . "> $priority->name</option>";
            }
            $html .= "</select>
                </div>";

            // phase
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='phase'>  Control Phase </label>
                <select class='select2 form-select' name='phase'>
                  <option  value=''> select phase</option>";
            foreach ($phases as $phase) {
                $html .= "<option value='$phase->id' " . ($control->control_phase == $phase->id ? 'selected' : '') . "> $phase->name</option>";
            }
            $html .= "</select>
          </div>";


            // type
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='type'>  Control type </label>
                <select class='select2 form-select' name='type'>
                  <option  value=''> select type</option>";
            foreach ($types as $type) {
                $html .= "<option value='$type->id' " . ($control->control_type == $type->id ? 'selected' : '') . "> $type->name</option>";
            }
            $html .= "</select>
              </div>";

            // maturity
            $html .= "<div class='mb-1'>
                <label class = 'form-label' for='maturity'>  Control Maturity </label>
                <select class='select2 form-select' name='maturity'>
                  <option  value=''> select maturity</option>";
            foreach ($maturities as $maturity) {
                $html .= "<option value='$maturity->id' " . ($control->control_maturity == $maturity->id ? 'selected' : '') . "> $maturity->name</option>";
            }
            $html .= "</select>
                </div>";

            // class
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='class'>  Control class </label>
              <select class='select2 form-select' name='class'>
                <option  value=''> select class</option>";
            foreach ($classes as $class) {
                $html .= "<option value='$class->id' " . ($control->control_class == $class->id ? 'selected' : '') . "> $class->name</option>";
            }
            $html .= "</select>
              </div>";

            // Desired  Maturity
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='desired_maturity'>  Control desired maturity </label>
              <select class='select2 form-select' name='desired_maturity'>
                <option  value=''> select desired maturity</option>";
            foreach ($desiredMaturities as $desiredMaturity) {
                $html .= "<option value='$desiredMaturity->id' " . ($control->desired_maturity == $desiredMaturity->id ? 'selected' : '') . "> $desiredMaturity->name</option>";
            }
            $html .= "</select>
              </div>";

            $testResultBackgroundClass = TestResult::where('name', $control->control_status)->select('background_class')->first()->background_class;

            // Status
            $html .= "<div class='mb-1'>
                <label for='title' class='form-label'>" . "Control Status" . "</label>
                <input type='text'  class=' form-control' disabled value='$control->control_status' style='background-color:" . $testResultBackgroundClass . "' />
            </div>";

            // $html .= "<div class='mb-1'>
            //         <label class = 'form-label' for='Status'>  Control Status</label>
            //         <select class='select2 form-select' name='Status'>
            //         <option  value=''> select Status</option>
            //         <option  value='1' " . ($control->control_status == 1 ? 'selected' : '') . "> Pass</option>
            //           <option  value='0' " . ($control->control_status == 0 ? 'selected' : '') . " > Failed</option>
            //       </select>
            //     </div>";


            // owner
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='owner'>  Control owner</label>
              <select class='select2 form-select' name='owner'>
                <option  value=''> select desired maturity</option>";
            foreach ($owners as $owner) {
                $html .= "<option value='$owner->id' " . ($control->control_owner == $owner->id ? 'selected' : '') . "> $owner->name</option>";
            }
            $html .= "</select>
              </div>";

            //  tester
            $html .= "<div class='mb-1'>
              <label class = 'form-label' for='tester'>" . __('governance.Tester') . "</label>
              <select class='select2 form-select' name='tester'>
                <option value='' disabled selected>" . __('locale.select-option') . "</option>";
            foreach ($testers as $tester) {
                $html .= "<option value='$tester->id' " . ($test_name->tester == $tester->id ? 'selected' : '') . "> $tester->name</option>";
            }
            $html .= "</select>
              </div>";

            // test name
            //     $html .= "<div class='mb-1'>
            //       <label for='title' class='form-label'>" . __('locale.TestName') . "</label>
            //       <input type='text'  class=' form-control' disabled value='$test_name->name' />
            //   </div>";

            // test frequency
            $html .= "<div class='mb-1'>
              <label for='title' class='form-label'>" . __('governance.TestFrequency') . "(" . __('locale.days') . ")" . "</label>
              <input type='text'  class=' form-control' name='test_frequency' value='$test_name->test_frequency' />
          </div>";

            // latest test date
            //     $html .= "<div class='mb-1'>
            //       <label for='title' class='form-label'>" . __('locale.LastTestDate') . "</label>
            //       <input type='text'  class=' form-control js-datepicker' name='last_date' placeholder='YYYY-MM-DD' value='$test_name->last_date' />
            //   </div>";

            // test step
            $html .= "<div class='mb-1'>
                <label class='form-label' for='exampleFormControlTextarea1'>" . __('governance.TestSteps') . "</label>
                <textarea
                  class='form-control'
                  name='test_steps'
                  id='exampleFormControlTextarea1'
                  rows='3'
                >$test_name->test_steps</textarea>
                <span class='error error-test_steps ' ></span>
              </div>";

            // approximate time
            $html .= "<div class='mb-1'>
                  <label class='form-label' for='normalMultiSelect1'> " . __('locale.ApproximateTime') . "(" . __('locale.minutes') . ")</label>
                  <input name='approximate_time' type='number' id='basic-icon-default-post' class='form-control dt-post' aria-label='Web Developer' value='$test_name->approximate_time' />
                  <span class='error error-approximate_time ' ></span>
                </div>";

            // expected results
            $html .= "<div class='mb-1'>
                <label class='form-label' for='exampleFormControlTextarea1'>" . __('locale.ExpectedResults') . "</label>
                <textarea
                  class='form-control'
                  name='expected_results'
                  id='exampleFormControlTextarea1'
                  rows='3'
                >$test_name->expected_results</textarea>
                <span class='error error-expected_results' ></span>
              </div>";

            // Submit button
            $html .= "</div>
                <div class='my-1'>
                  <button type='submit' class='btn btn-primary   add-todo-item me-1'>update</button>
                  <button type='button' class='btn btn-outline-secondary add-todo-item ' data-bs-dismiss='modal'>
                    Cancel
                  </button>
                </div>
              </div>";

            //mitigation_percent
            // $html .= "<label class = gov_check for=mitigation_percent>  Mitigation Percent </label><br>";
            // $html .= "<input class =form-control  type= number    name=mitigation_percent  value=" . $control->mitigation_percent . ">";

        }
        // $html .= "<input type= hidden  id= control  name=id  value=" . $control->id . ">";
        // $html .= "<button type= submit  class= gov_btn> update </button>";

        echo $html;
    }

    public function updateControl(Request $request)
    {
        $isParent = FrameworkControl::find($request->id)->frameworkControls()->count();

        $rules = [
            'name' => ['required', 'max:1000'],
            'parent_id' => ['nullable', 'exists:framework_controls,id'], // the parent framework_control for this framework_control
        ];

        $hasParent = !is_null($request->parent_id);
        if (!$hasParent) {
            $rules['sub_family'] = ['required', 'exists:families,id'];
            $rules['family'] = ['required', 'exists:families,id'];
        }

        if (!$isParent) {
            $rules['framework'] = ['required', 'exists:frameworks,id']; // the framework that this control belongs to
        }

        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemUpdatingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $data["status"] = "success";
                $id = $request->id;

                // Set family as parent family
                if ($hasParent) {
                    $parentControl = FrameworkControl::find($request->parent_id);
                    $request->sub_family = $parentControl->family;
                }

                // Get framework control old parent
                $frameControlOldParent = FrameworkControl::find($id)->parent_id;

                $updatedData = [
                    'short_name' => $request->get("name"),
                    'description' => $request->get("description"),
                    'control_number' => $request->get("number"),
                    // 'family'  => $request->sub_family,
                    'control_class' => $request->get("class"),
                    'control_type' => $request->get("type"),
                    'control_maturity' => $request->get("maturity"),
                    'control_phase' => $request->get("phase"),
                    'control_priority' => $request->get("priority"),
                    'long_name' => $request->get("long_name"),
                    'supplemental_guidance' => $request->get("supplemental_guidance"),
                    'mitigation_percent' => $request->get("mitigation_percent"),
                    'desired_maturity' => $request->get("desired_maturity"),
                    // 'control_status'  => $request->get("control_status"),
                    'control_owner' => $request->get("owner"),
                    'parent_id' => $request->get("parent_id")
                ];

                $currentControl = FrameworkControl::find($id);
                $frameworksIdArray = $currentControl->Frameworks->pluck('id')->toArray();

                // Update sub-domain (family)

                if ($isParent) { // If is parent
                    if (!($request->has('framework')) || in_array($request->framework, $frameworksIdArray)) { // and change domains or sub-domain in the same framework
                        $updatedData['family'] = $request->sub_family;
                        // Set family for its children as its family
                        FrameworkControl::find($request->id)->frameworkControls()->update([
                            'family' => $request->sub_family
                        ]);
                    } else { // and changes in framework
                        $response = array(
                            'status' => false,
                            'errors' => [
                                "framework" =>
                                [__('governance.CanNotUpdateParentControlFramework')]
                            ],
                            'message' => __('governance.CanNotUpdateParentControlFramework') . "<br>" . __('locale.Validation error'),
                        );
                        return response()->json($response, 422);
                    }
                } else if (!$hasParent && !$isParent) { /* Isn't parent and isn't child */
                    $updatedData['family'] = $request->sub_family;
                } else if ($request->has("parent_id")) { // parent_id is passed (is child)
                    $updatedData['family'] = $request->sub_family;
                }
                // to get the data to write log
                $framesGetOldData = FrameworkControl::where('id', $id)->find($id);
                $frames = FrameworkControl::where('id', $id)->find($id);
                $frames = $frames->update($updatedData);

                // dd($frames);
                // $frames = DB::table('framework_controls')->where('id', $id)->update($updatedData);

                if ($frameControlOldParent != $request->parent_id) {
                    // from null to has parent
                    if (is_null($frameControlOldParent) && $request->get("parent_id")) {
                        // Update parent framweork control status
                        if ($request->parent_id) { // framework control has parent
                            $parentFrameworkControl = FrameworkControl::find($request->parent_id);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            // detach frameworks
                            $currentControl->Frameworks()->detach($frameworksIdArray);
                            // Attach frameworks
                            $currentControl->Frameworks()->attach($parentFrameworkControl->Frameworks->pluck('id')->toArray()); // attach frameworks to control

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
                    } // from has parent to null
                    else if ($frameControlOldParent && is_null($request->get("parent_id"))) {
                        // Update old parent framwork control status
                        if ($frameControlOldParent) { // framework control has parent
                            $parentFrameworkControl = FrameworkControl::find($frameControlOldParent);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            if (count($frameworkControlChildren) == 0) { // old parent now has no children (get framework control status from last audit test result)
                                $lastTestAudit = $parentFrameworkControl->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
                                if ($lastTestAudit) {
                                    $lastTestAuditResultStatus = $lastTestAudit->FrameworkControlTestResult->testResult->name ?? null;
                                    if ($lastTestAuditResultStatus) {
                                        $newFrameWorkControlStatus = $lastTestAuditResultStatus;
                                    } else {
                                        $newFrameWorkControlStatus = 'Not Applicable';
                                    }
                                    $parentFrameworkControl->update([
                                        'control_status' => $newFrameWorkControlStatus
                                    ]);
                                }
                            } else { // old parent now has children (recalculated framework control status from its children)
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
                    } // from has parent to another parent
                    else {
                        $frameControlNewParent = $request->parent_id;

                        $parentFrameworkControl = FrameworkControl::find($request->parent_id);
                        $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                        // detach frameworks
                        $currentControl->Frameworks()->detach($frameworksIdArray);
                        // Attach frameworks
                        $currentControl->Frameworks()->attach($parentFrameworkControl->Frameworks->pluck('id')->toArray()); // attach frameworks to control

                        // Update old parent framwork control status
                        if ($frameControlOldParent) { // framework control has parent
                            $parentFrameworkControl = FrameworkControl::find($frameControlOldParent);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            if (count($frameworkControlChildren) == 0) { // old parent now has no children (get framework control status from last audit test result)
                                $lastTestAudit = $parentFrameworkControl->FrameworkControlTest->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
                                if ($lastTestAudit) {
                                    $lastTestAuditResultStatus = $lastTestAudit->FrameworkControlTestResult->testResult->name ?? null;
                                    if ($lastTestAuditResultStatus) {
                                        $newFrameWorkControlStatus = $lastTestAuditResultStatus;
                                    } else {
                                        $newFrameWorkControlStatus = 'Not Implemented';
                                    }
                                    $parentFrameworkControl->update([
                                        'control_status' => $newFrameWorkControlStatus
                                    ]);
                                }
                            } else { // old parent now has children (recalculated framework control status from its children)
                                $statuses = ['Not Implemented' => 0, 'Partially Implemented' => 0, 'Implemented' => 0];
                                $frameworkControlChildrenStatuses = $frameworkControlChildren->where('control_status', '<>', 'Not Applicable')->pluck('control_status')->toArray();

                                // If all statuses == 'Not Applicable'
                                if (count($frameworkControlChildrenStatuses) == 0) {
                                    $parentFrameworkControl->update([
                                        'control_status' => 'Not Implemented'
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

                        // Update new parent framwork control status
                        if ($frameControlNewParent) {
                            $parentFrameworkControl = FrameworkControl::find($frameControlNewParent);
                            $frameworkControlChildren = $parentFrameworkControl->frameworkControls;

                            $statuses = ['Not Implemented' => 0, 'Partially Implemented' => 0, 'Implemented' => 0];
                            $frameworkControlChildrenStatuses = $frameworkControlChildren->where('control_status', '<>', 'Not Applicable')->pluck('control_status')->toArray();

                            // If all statuses == 'Not Applicable'
                            if (count($frameworkControlChildrenStatuses) == 0) {
                                $parentFrameworkControl->update([
                                    'control_status' => 'Not Implemented'
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
                }
                // get old data of FrameworkControlTest to use it in write log
                $frameworkControlTestoldData = FrameworkControlTest::where('framework_control_id', $id)->first();
                $frameworkControlTest = FrameworkControlTest::where('framework_control_id', $id)->first();
                $frameworkControlTest->update([
                    'tester' => $request->tester,
                    // 'last_date' =>$request->last_date,
                    // 'next_date' => $next_date,
                    // 'name' => $request->test_name,
                    'test_steps' => $request->test_steps,
                    // 'approximate_time' =>$request->approximate_time ,
                    // 'framework_control_id' =>$request->framework_control_id ,
                    // 'expected_results' =>$request->expected_results ,
                    // 'test_frequency' =>$request->test_frequency ,
                    'test_frequency' => $request->test_frequency ?? 0,


                    //'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
                ]);


                if ($request->teams != "") {
                    $this->UpdateTeamsOfItem($id, 'test', $request->teams);
                }

                if (!$hasParent && !$isParent) { // Isn't parent and isn't child
                    if (!in_array($request->framework, $frameworksIdArray)) {
                        // detach frameworks
                        $currentControl->Frameworks()->detach($frameworksIdArray);
                        // Attach frameworks
                        $currentControl->Frameworks()->attach([$request->framework]); // attach frameworks to control
                    }
                }
                $updatedFrames = FrameworkControl::find($id);
                DB::commit();
                event(new ControlUpdated($updatedFrames, $frameworkControlTest));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasUpdatedSuccessfully'),
                );

                $message = __('governance.A Control that name is') . ' "' . ($framesGetOldData->short_name ?? __('locale.[No Name]')) . '"';

                if ($framesGetOldData->short_name != $updatedFrames->short_name) {
                    $message .= ' ' . __('locale.Updated to') . ' "' . ($updatedFrames->short_name ?? __('locale.[No Name]')) . '"';
                }

                $message .= ' ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';

                write_log($updatedFrames->id, auth()->id(), $message, 'Updating Control');

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

    public function storeControl(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'max:1000'],
            'test_name' => ['required'],
            'parent_id' => ['nullable', 'exists:framework_controls,id'], // the parent framework_control for this framework_control
            'tester' => ['required', 'exists:users,id'], // the manager for department
        ];

        $hasParent = !is_null($request->parent_id);
        if (!$hasParent) {
            $rules['family'] = ['required', 'exists:families,id'];
            $rules['sub_family'] = ['required', 'exists:families,id'];
        }

        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {

                // Set family as parent family
                $parentControl = null;
                if ($hasParent) {
                    $parentControl = FrameworkControl::find($request->parent_id);
                    $request->sub_family = $parentControl->family;
                }

                $data["status"] = "success";
                //add in control
                $frameControl = new FrameworkControl();
                $frameControl->short_name = $request->name;
                $frameControl->description = $request->description;
                $frameControl->control_number = $request->number;
                $frameControl->control_type = $request->type;
                $frameControl->family = $request->sub_family;
                $frameControl->control_class = $request->class;
                $frameControl->control_maturity = $request->maturity;
                $frameControl->control_phase = $request->phase;
                $frameControl->control_priority = $request->priority;
                $frameControl->long_name = $request->long_name;
                $frameControl->supplemental_guidance = $request->supplemental_guidance;
                $frameControl->mitigation_percent = $request->mitigation_percent;
                $frameControl->desired_maturity = $request->desired_maturity;
                // $frameControl->control_status =  $request->control_status;
                $frameControl->parent_id = $request->parent_id;

                if ($request->owner != "") {
                    $frameControl->control_owner = $request->owner;
                } else {
                    $frameControl->control_owner = auth()->user()->id;
                }
                $frameControl->save();
                //add in mapp

                $control_id = DB::getPdo()->lastInsertId();
                $frame_map = new FrameworkControlMapping();
                $frame_map->framework_control_id = $control_id;
                $frame_map->framework_id = $id;
                $frame_map->save();
                $request->last_date = $request->last_date ?? date('Y-m-d');

                //add test*
                // calc  next_date form last date * test_frequency
                $next_date = date('Y-m-d', strtotime($request->last_date) + ($request->test_frequency ?? 0) * 24 * 60 * 60);
                // add new test to database
                $frameworkControlTest = FrameworkControlTest::create([
                    'tester' => $request->tester,
                    'last_date' => $request->last_date,
                    'next_date' => $next_date,
                    'name' => $request->test_name,
                    'test_steps' => $request->test_steps,
                    'approximate_time' => $request->approximate_time,
                    'framework_control_id' => $control_id,
                    'expected_results' => $request->expected_results,
                    'test_frequency' => $request->test_frequency ?? 0,
                    // 'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
                ]);

                $test_id = DB::getPdo()->lastInsertId();

                $audit = FrameworkControlTestAudit::create([
                    'test_id' => $test_id,
                    'tester' => $request->tester,
                    'name' => $request->test_name . "(1)",
                    'framework_control_id' => $control_id,
                    'last_date' => $request->last_date,
                    'next_date' => $next_date,
                    'test_frequency' => $request->test_frequency ?? 0,
                ]);


                //
                FrameworkControlTestResult::create([
                    'test_audit_id' => $audit->id
                ]);


                // $this->AddTeamsOfItem($frameworkControlTest->id,'test',$request->teams);

                // Update parent framweork control status
                if ($request->parent_id) { // framework control has parent
                    $parentFrameworkControl = FrameworkControl::find($request->parent_id);
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
                //end test

                // Map to parent control framework
                if ($hasParent) {
                    foreach ($parentControl->Frameworks()->select('framework_id')->get() as $framework) {
                        $frames = new FrameworkControlMapping();
                        $frames->framework_control_id = $control_id;
                        $frames->framework_id = $framework->framework_id;
                        $frames->save();
                    }
                }

                DB::commit();

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddedSuccessfully'),
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

    public function listControl()
    {

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Governance')],
            ['name' => __('governance.Define Control Frameworks')]
        ];

        $controls = FrameworkControl::all();
        // $parentControls = FrameworkControl::doesntHave('parentFrameworkControl')->get();
        $families = Family::whereNull('parent_id')->with('families')->get();
        $priorities = ControlPriority::all();
        $phases = ControlPhase::all();
        $types = ControlType::all();
        $maturities = ControlMaturity::all();
        $classes = ControlClass::all();
        // $owners=ControlOwner::all();
        $departmentManagersIds = Department::pluck('manager_id')->toArray();
        $owners = User::whereIn('id', $departmentManagersIds)->get();

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::whereHas('role.rolePermissions', function ($query) {
            $query->where('key', 'audits.result');
        })->get();
        $teams = Team::all();

        // $_frameworks = Framework::select('id', 'name')->with(['only_families:id,name', 'only_sub_families:id,name,parent_id', 'FrameworkControls:id,short_name'])->get();
        $_frameworks = Framework::select('id', 'name')->with(['only_families:id,name', 'only_sub_families:id,name,parent_id', 'FrameworkControlsFrameworks:id,short_name'])->get();

        // Add logic to get to framework with custom structure
        /*
          "id" => 3
          "name" => "NCA-CCC – 1: 2020"
          "domains" => []
          "controls" => array:1 [▼
            0 => array:2 [▼
              "id" => 1
              "name" => "c1 (NCA-SMACC, NCA-CCC – 1: 2020)"
            ]
          ]
        */
        $frameworks = [];
        foreach ($_frameworks as $framework) {
            $tempFramework = [
                'id' => $framework->id,
                'name' => $framework->name,
                'domains' => [],
                'controls' => array_map(function ($control) {
                    return [
                        "id" => $control['id'],
                        // "short_name" => $control['short_name'],
                        "name" => $control['short_name'] . ' (' . implode(', ', array_map(
                            function ($framework) {
                                return $framework['name'];
                            },
                            $control['frameworks']
                        )) . ')'
                    ];
                }, $framework->FrameworkControlsFrameworks->toArray()),
            ];
            $frameworkDomains = [];
            foreach ($framework->only_families as $family) {
                $frameworkDomains = [
                    'id' => $family->id,
                    'name' => $family->name,
                ];

                $frameworkDomainSunDomains = [];
                foreach ($framework->only_sub_families as $sub_family) {
                    if ($family->id == $sub_family->parent_id) {
                        array_push($frameworkDomainSunDomains, [
                            'id' => $sub_family->id,
                            'name' => $sub_family->name,
                        ]);
                    }
                }
                $frameworkDomains['sub_domains'] = $frameworkDomainSunDomains;
                array_push($tempFramework['domains'], $frameworkDomains);
            }
            array_push($frameworks, $tempFramework);
        }

        unset($_frameworks);

        return view("admin.content.governance.control_list", compact('teams', 'testers', 'frameworks', 'controls', 'families', 'priorities', 'phases', 'types', 'maturities', 'classes', 'owners', 'desiredMaturities', 'breadcrumbs'));
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetListControl(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['short_name'],
            'relationships' => ['Frameworks', 'family_with_parent'],
            'other_global_filters' => ['description'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'Frameworks:id,name',
            'family_with_parent:id,name,parent_id'
        ];

        $relationshipsCount = [
            // 'relationshipName'
            'frameworkControls',
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        $parentFamilyFilter = $request->columns[6]['search']['value'] ?? '';
        $subFamilyIds = [];
        if ($parentFamilyFilter && !$dataTableDetails['search']['family_with_parent']) {
            $family = Family::where('name', $parentFamilyFilter)->first();
            $subFamilyIds = $family->families()->pluck('id')->toArray();
        }
        $customConditions = [];
        if (count($subFamilyIds)) {
            $customConditions['whereIn']['family'] =  $subFamilyIds;
        }
        if (!auth()->user()->hasPermission('control.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $ownedControlsIds = FrameworkControl::whereIn('control_owner', $departmentMembersIds)->pluck('id')->toArray();
                $testControlsIds =  FrameworkControlTest::whereIn('tester', $departmentMembersIds)->pluck('framework_control_id')->toarray();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                $objectivesControlsIds =  ControlControlObjective::whereIn('responsible_id', $departmentMembersIds)->orWhereIn('responsible_team_id', $departmentTeams)->pluck('control_id')->toarray();
                $controlsIds = array_unique(array_merge($ownedControlsIds, $testControlsIds, $objectivesControlsIds));
            } else {
                $ownedControlsIds = FrameworkControl::where('control_owner', auth()->id())->pluck('id')->toArray();
                $testControlsIds =  FrameworkControlTest::where('tester', auth()->id())->pluck('framework_control_id')->toarray();
                $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
                $objectivesControlsIds =  ControlControlObjective::where('responsible_id', auth()->id())->orWhereIn('responsible_team_id', $loggedUserTeams)->pluck('control_id')->toarray();
                $controlsIds = array_unique(array_merge($ownedControlsIds, $testControlsIds, $objectivesControlsIds));
            }
            $customConditions['whereIn']['id'] =  $controlsIds;
        }



        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            FrameworkControl::class,
            $dataTableDetails,
            $customFilterFields,
            $customConditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'framework_controls',
            [
                'id',
                'short_name',
                'description',
                'family',
                'created_at'
            ]
        );

        // Getting records with apply global search */
        $frameworkControls = getDatatableFilterRecords(
            FrameworkControl::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $customConditions,
            $relationshipsCount
        );

        // Custom frameworkControls response data as needs
        $data_arr = [];
        foreach ($frameworkControls as $frameworkControl) {

            $data_arr[] = array(
                'id' => $frameworkControl->id,
                'short_name' => $frameworkControl->short_name,
                'description' => $frameworkControl->description,
                // 'control_number' => $frameworkControl->control_number,
                // 'owner_name' => $frameworkControl->owners->pluck('name'),
                // 'owner_name' => $frameworkControl->User->name,
                'family_name' => $frameworkControl->family_with_parent->name,
                'family_with_parent' => $frameworkControl->family_with_parent->parentFamily->name,
                // 'class_name' => $frameworkControl->classes->pluck('name'),
                // 'phases_name' => $frameworkControl->phases->pluck('name'),
                // 'prio_name' => $frameworkControl->priorities->pluck('name'),
                // 'mat_name' => $frameworkControl->maturities->pluck('name'),
                // 'desired_name' => $frameworkControl->desiredMaturities->pluck('name'),
                'Frameworks' => $frameworkControl->Frameworks->pluck('name'),
                // 'parent' => $frameworkControl->parentFrameworkControl->short_name ?? '',
                'isParent' => $frameworkControl->framework_controls_count ? true : false,

                'Actions' => $frameworkControl->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    public function storeControl2(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:1000'],
            // 'test_name' => ['required'],
            'test_frequency' => ['required'],
            'parent_id' => ['nullable', 'exists:framework_controls,id'], // the parent framework_control for this framework_control
            'framework' => ['required', 'exists:frameworks,id'], // the framework that this control belongs to
            'tester' => ['required', 'exists:users,id'], // the manager for department
        ];

        $hasParent = !is_null($request->parent_id);
        if (!$hasParent) {
            $rules['family'] = ['required', 'exists:families,id'];
            $rules['sub_family'] = ['required', 'exists:families,id'];
        }

        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {

                // Set family as parent family
                $parentControl = null;
                if ($hasParent) {
                    $parentControl = FrameworkControl::find($request->parent_id);
                    $request->sub_family = $parentControl->family;
                }

                $data["status"] = "success";
                //add in control
                $control = new FrameworkControl();
                $control->short_name = $request->name;
                $control->description = $request->description;
                $control->control_number = $request->number;
                $control->control_type = $request->type;
                $control->family = $request->sub_family;
                $control->control_class = $request->class;
                $control->control_maturity = $request->maturity;
                $control->control_phase = $request->phase;
                $control->control_priority = $request->priority;
                $control->long_name = $request->long_name;
                $control->supplemental_guidance = $request->supplemental_guidance;
                $control->mitigation_percent = $request->mitigation_percent;
                $control->desired_maturity = $request->desired_maturity;
                // $control->control_status =  $request->control_status;
                $control->parent_id = $request->parent_id;

                if ($request->owner != "") {
                    $control->control_owner = $request->owner;
                } else {
                    $control->control_owner = auth()->user()->id;
                }

                $control->save();

                //add test
                // $request->last_date = $request->last_date ?? date('Y-m-d');
                $request->last_date = null;
                $control_id = DB::getPdo()->lastInsertId();
                // calc  next_date form last date * test_frequency
                // $next_date = date('Y-m-d', strtotime($request->last_date) + ($request->test_frequency ?? 0) * 24 * 60 * 60);
                $next_date = null;
                // add new test to database
                $frameworkControlTest = FrameworkControlTest::create([
                    'tester' => $request->tester,
                    'last_date' => $request->last_date,
                    'next_date' => $next_date,
                    'name' => $request->name,
                    'test_steps' => $request->test_steps,
                    'approximate_time' => $request->approximate_time,
                    'framework_control_id' => $control_id,
                    'expected_results' => $request->expected_results,
                    'test_frequency' => $request->test_frequency ?? 0,
                    // 'additional_stakeholders' =>implode(",", $request->additional_stakeholders),
                ]);

                $test_id = DB::getPdo()->lastInsertId();

                // $audit = FrameworkControlTestAudit::create([
                //     'test_id' => $test_id,
                //     'tester' => $request->tester,
                //     'name' => $request->name . "(1)",
                //     'framework_control_id' => $control_id,
                //     'last_date' => $request->last_date,
                //     'next_date' => $next_date,
                //     'test_frequency' => $request->test_frequency ?? 0,

                // ]);
                //
                // FrameworkControlTestResult::create([
                //     'test_audit_id' => $audit->id
                // ]);

                // Update parent framweork control status
                if ($request->parent_id) { // framework control has parent
                    $parentFrameworkControl = FrameworkControl::find($request->parent_id);
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
                //end test

                // Map to parent control framework
                if ($hasParent) {
                    foreach ($parentControl->Frameworks()->select('framework_id')->get() as $framework) {
                        $frames = new FrameworkControlMapping();
                        $frames->framework_control_id = $control_id;
                        $frames->framework_id = $framework->framework_id;
                        $frames->save();
                    }
                } else {
                    $_control = FrameworkControl::find($control_id);
                    $_control->Frameworks()->attach($request->framework); // attach the framework to the control
                }

                DB::commit();
                event(new ControlCreated($frameworkControlTest, $control));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.FrameworkControlWasAddedSuccessfully'),
                );

                $message = __('governance.A New Control created with name') . ' "' . ($control->short_name ?? __('locale.[No Name]')) . '". '
                    . __('governance.The owner of control is') . ' "' . ($control->User->name ?? __('locale.[No User Name]')) . '" '
                    . __('governance.and the tester is') . ' "' . ($frameworkControlTest->UserTester->name ?? __('locale.[No User Tester Name]')) . '" '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($control->id, auth()->id(), $message, 'Creating Control');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

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

    public function destroyControl(Request $request, $id)
    {
        $frameworkControl = FrameworkControl::find($id);
        $documentframeworkControlIds = [];
        foreach (Document::pluck('control_ids') as $control_ids) {
            $documentframeworkControlIds = array_merge($documentframeworkControlIds, explode(',', $control_ids));
        }
        $documentframeworkControlIds = array_unique($documentframeworkControlIds);
        if ($frameworkControl) {
            DB::beginTransaction();
            try {
                if (in_array($id, $documentframeworkControlIds)) {
                    throw new Exception("", 23000);
                }

                $getTester = FrameworkControlTest::where('framework_control_id', $id)->first();

                $frameworkControl->delete();
                DB::commit();
                event(new ControlDeleted($frameworkControl, $getTester));
                $response = array(
                    'status' => true,
                    'message' => __('governance.FrameworkControlWasDeletedSuccessfully'),
                );
                $message = __('governance.A Control with name') . ' "' . ($frameworkControl->short_name ??  __('locale.[No FrameWork Name]')) . '" ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($frameworkControl->id, auth()->id(), $message, 'Deleting Control');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                if ($th->getCode() == 23000 || $th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl') . "<br>" . __('governance.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheFrameworkControl');
                }
                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
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

    public function ajaxGetListControlMap(Request $request, $id)
    {

        $controls = DB::select('SELECT framework_control_id , framework_controls.id, short_name ,framework_id , name FROM frameworks ,framework_control_mappings , framework_controls where frameworks.id = framework_id and framework_control_id = "' . $id . '"   and framework_control_mappings.framework_control_id = framework_controls.id ');

        $html = "";

        if (!empty($controls)) {

            $html .= "<table width=100% class=table >";
            $html .= "<tbody><tr> ";
            $html .= "<th>Framework</th> ";
            $html .= "<th>Control</th> ";
            $html .= "</tr>";

            foreach ($controls as $control) {

                $html .= "<tr>";
                $html .= "<td>" . $control->name . "</td>";
                $html .= "<td>" . $control->short_name . "</td> ";
                $html .= "</tr>";
            }
        } else {
            $html .= "</tbody></table>";
            $html .= "<h3 class=gov_err> no frameworks mapped </h3><br>";
        }
        echo $html;
    }

    public function AddTeamsOfItem($item_id, $type, $teams = [])
    {

        foreach ($teams as $team) {
            ItemsToTeam::create([
                'item_id' => $item_id,
                'type' => $type,
                'team_id' => $team
            ]);
        }
        return true;
    }

    public function storeAudit(Request $request)
    {
        $ListTestIds = explode(',', $request->id);
        $ListTestIds = array_filter($ListTestIds, 'strlen');

        foreach ($ListTestIds as $id) {

            // $control = FrameworkControl::find($id) ;
            // $test= $control->FrameworkControlTest;

            $test = FrameworkControlTest::where('framework_control_id', $id)->first();
            $frameworkControl = $test->FrameworkControl()->withCount('frameworkControls')->first();
            if ($frameworkControl->framework_controls_count) {
                continue;
            }
            // Last test result audit on control
            $lastTestLog = $test->FrameworkControlTestAudits()->orderBy('id', 'desc')->first() ?? null;
            $lastTestResult = $lastTestLog->FrameworkControlTestResult->test_result ?? null;
            $lastDate = null;
            $nextDate = null;
            $auditCreatedAt = date("Y-m-d H:i:s");
            // if ($lastTestLog) {
            //     $lastDate = $lastTestLog->next_date;
            //     $nextDate = date('Y-m-d', strtotime($auditCreatedAt) + ($test->test_frequency ?? 0) * 24 * 60 * 60);
            // } else {
            //     $lastDate = null;
            //     $nextDate = date('Y-m-d', strtotime($auditCreatedAt) + ($test->test_frequency ?? 0) * 24 * 60 * 60);
            // }
            $lastDate = null;
            $nextDate = date('Y-m-d', strtotime($auditCreatedAt) + ($test->test_frequency ?? 0) * 24 * 60 * 60);

            $countAudit = $test->FrameworkControlTestAudits->count() + 1;
            // $auditName=$test->name.'-('.$countAudit.')';
            // $auditName = "Control" . $test->framework_control_id . " Audit(" . $test->framework_control_id . ')-(' . $countAudit . ')';

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
                'test_frequency' => $test->test_frequency ?? 0,
                'created_at'  => $auditCreatedAt
            ]);

            FrameworkControlTestResult::create([
                'test_audit_id' => $audit->id,
                'test_result' => $lastTestResult
            ]);

            // Store related policy
            $controlDocumentIds = getControlDocuments($test->framework_control_id); // Get documents related to control
            foreach ($controlDocumentIds as $controlDocumentId) {
                ControlAuditPolicy::create([
                    'document_id' => $controlDocumentId,
                    'framework_control_test_audit_id' => $audit->id
                ]);
            }


            // Store related objectives and evidences
            $objectivesIds = ControlControlObjective::where('control_id', $test->framework_control_id)->pluck('id')->toArray(); // Get objectives related to control
            $evidencesIds = Evidence::whereIn('control_control_objective_id', $objectivesIds)->pluck('id')->toArray(); // Get evidences related to control

            foreach ($objectivesIds as $objectiveId) {
                ControlAuditObjective::create([
                    'control_control_objective_id' => $objectiveId,
                    'framework_control_test_audit_id' => $audit->id
                ]);
            }

            foreach ($evidencesIds as $evidenceId) {
                ControlAuditEvidence::create([
                    'evidence_id' => $evidenceId,
                    'framework_control_test_audit_id' => $audit->id
                ]);
            }

            event(new ControlAuditCreated($audit, $frameworkControl));
            $message = __(
                'governance.NotifyAuditCreated',
                [
                    'user' => auth()->user()->name
                ]
            );
            $message = __('governance.A Control with name') . ' "' . ($frameworkControl->short_name ??  __('locale.[No Name]')) . '". '
                . __('governance.Added to Aduit') . ' "' . $audit->name . '" '
                . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
            write_log($audit->id, auth()->id(), $message, 'Creating Aduit');
            // write_log($audit->id, auth()->id(), $message, FrameworkControlTestAudit::class);
        }
        return response()->json($ListTestIds, 200);
    }

    //document
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:250', 'unique:document_types,name'],
            'icon' => ['required', 'max:250'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheCategory') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $documentType = DocumentTypes::create([
                    'name' => $request->name,
                    'icon' => $request->icon,
                ]);

                DB::commit();
                event(new CateogryCreated($documentType));
                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.CategoryWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 502);
            }
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $documentType = DocumentTypes::find($id);
        if ($documentType) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:250', 'unique:document_types,name,' . $documentType->id],
                'icon' => ['required', 'max:250'],
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemUpdatingTheCategory') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $documentType->update([
                        'name' => $request->name,
                        'icon' => $request->icon,
                    ]);

                    DB::commit();
                    event(new CateogryUpdated($documentType));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.CategoryWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $response = array(
                        'status' => false,
                        'message' => __('locale.Error'),
                        // 'message' => $th->getMessage(),
                    );
                    return response()->json($response, 404);
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

    public function destroyCategory(Request $request, $id)
    {
        $documentType = DocumentTypes::find($id);
        if ($documentType) {
            DB::beginTransaction();
            try {
                $documentType->delete();

                DB::commit();

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.CategoryWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheCategory') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheCategory');
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

    public function listCategory()
    {
        //Documents
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Governance')],
            ['name' => __('locale.Documentation')]
        ];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $documents = Document::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        // $owners=ControlOwner::all();
        $owners = User::all();

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $controls = FrameworkControl::all();
        $category2 = DB::select('SELECT * FROM document_types;');
        $status = DocumentStatus::all();
        $privacies = Privacy::all();

        $activeDocumentType = request()->query('doc_type');

        if (!DocumentTypes::where('id', $activeDocumentType)->exists())
            $activeDocumentType = null;

        if (!$activeDocumentType) {
            $activeDocumentType = $category2[0]->id ?? null;
        }


        return view('admin.content.governance.category', ['pageConfigs' => $pageConfigs], compact('breadcrumbs', 'controls', 'testers', 'teams', 'documents', 'frameworks', 'owners', 'desiredMaturities', 'category2', 'status', 'privacies', 'activeDocumentType'));
    }

    public function storeDocument(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'framework_ids' => ['nullable', 'array'],
            'framework_ids.*' => ['exists:frameworks,id'],
            'control_ids' => ['nullable', 'array'],
            'control_ids.*' => ['exists:framework_controls,id'],
            'additional_stakeholders' => ['nullable', 'array'],
            'additional_stakeholders.*' => ['exists:users,id'],
            'owner' => ['nullable', 'exists:users,id'],
            'team_ids' => ['nullable', 'array'],
            'team_ids.*' => ['exists:teams,id'],
            'creation_date' => ['required', 'date'],
            'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
            'review_frequency' => ['required', 'integer'],
            // 'next_review_date' => ['nullable', 'date', 'after:last_review_date'],
            // 'approval_date' => ['nullable', 'date'],
            'status' => ['nullable', 'exists:document_statuses,id'],
            // 'reviewer' => ['nullable', 'exists:users,id'],
            // 'privacy' => ['nullable', 'exists:privacies,id'],
            'file' => ['required', 'file'],
        ];

        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($request->status == 2) {
            $rules['reviewer'] = ['required', 'exists:users,id'];
        } else {
            $rules['reviewer'] = ['nullable', 'exists:users,id'];
        }

        if ($request->status == 3) {
            $rules['privacy'] = ['required', 'exists:privacies,id'];
            $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
        } else {
            $rules['privacy'] = ['nullable', 'exists:privacies,id'];
            $rules['approval_date'] = ['nullable', 'date'];
        }

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheDocument') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            $owner = null;
            if (auth()->user()->role_id == 1) { // current user is administrator
                $owner = $request->owner ?? auth()->id();
            } else {
                $owner = auth()->id();
            }

            $document = null;
            try {
                $document = Document::create([
                    'document_name' => $request->name,
                    'framework_ids' => implode(',', $request->framework_ids ?? []),
                    'control_ids' => implode(',', $request->control_ids ?? []),
                    'additional_stakeholders' => implode(',', $request->additional_stakeholders ?? []),
                    'team_ids' => implode(',', $request->team_ids ?? []),
                    'document_owner' => $owner,
                    'document_reviewer' => $request->reviewer,
                    'creation_date' => date('Y-m-d', strtotime($request->creation_date)),
                    'last_review_date' => date('Y-m-d', strtotime($request->last_review_date)),
                    'review_frequency' => $request->review_frequency,
                    'next_review_date' => date('Y-m-d', strtotime($request->last_review_date) + $request->review_frequency * 24 * 60 * 60),
                    'approval_date' => $request->approval_date,
                    'document_type' => $id,
                    'document_status' => $request->status ?? 1,
                    'privacy' => $request->privacy,
                    'created_by' => auth()->id()
                ]);

                if ($request->hasFile('file')) {
                    $fileId = null;
                    /////////////////
                    if ($request->file('file')->isValid()) {
                        $path = $request->file('file')->store('docs/' . $document->id);
                        $fileId = File::create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'unique_name' => $path
                        ]);
                    } else {
                        Storage::deleteDirectory('docs/' . $document->id);
                        $response = array(
                            'status' => false,
                            'errors' => ['file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheDocument') . "<br>" . __('locale.Validation error'),
                        );
                    }

                    $document->update([
                        'file_id' => $fileId->id
                    ]);
                }

                DB::commit();
                event(new DocumentCreated($document));

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.DocumentWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                Storage::deleteDirectory('docs/' . ($document->id ?? ''));
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    'message' => $th->getMessage(),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Update the specified resource (documnets) in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateDocument(Request $request)
    {
        $document = Document::find($request->id);

        if ($document) {
            $rules = [
                'name' => ['required', 'max:255'],
                'framework_ids' => ['nullable', 'array'],
                'framework_ids.*' => ['exists:frameworks,id'],
                'control_ids' => ['nullable', 'array'],
                'control_ids.*' => ['exists:framework_controls,id'],
                'additional_stakeholders' => ['nullable', 'array'],
                'additional_stakeholders.*' => ['exists:users,id'],
                'owner' => ['nullable', 'exists:users,id'],
                'team_ids' => ['nullable', 'array'],
                'team_ids.*' => ['exists:teams,id'],
                // 'creation_date' => ['nullable', 'date'],
                'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
                'review_frequency' => ['required', 'integer'],
                // 'next_review_date' => ['nullable', 'date', 'after:last_review_date'],
                // 'approval_date' => ['nullable', 'date'],
                // 'status' => ['nullable', 'exists:document_statuses,id'],
                'reviewer' => ['nullable', 'exists:users,id'],
                // 'privacy' => ['nullable', 'exists:privacies,id'],
                'file' => ['nullable', 'file'],
            ];

            // [1 => Draft],[2=> InReview, [3 => Approved]
            if ($request->status == 2) {
                $rules['reviewer'] = ['required', 'exists:users,id'];
            } else {
                $rules['reviewer'] = ['nullable', 'exists:users,id'];
            }

            if ($request->status == 3) {
                $rules['privacy'] = ['required', 'exists:privacies,id'];
                $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
            } else {
                $rules['privacy'] = ['nullable', 'exists:privacies,id'];
                $rules['approval_date'] = ['nullable', 'date'];
            }
            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemUpdatingTheDocument') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                $uploadfilePath = null;
                try {

                    $owner = null;
                    if (auth()->user()->role_id == 1) { // current user is administrator
                        $owner = $request->owner ?? auth()->id();
                    } else {
                        $owner = auth()->id();
                    }

                    // Start updating document data
                    $document->update([
                        // 'document_type' => $request->title,
                        'privacy' => $request->privacy,
                        'document_name' => $request->name,
                        // 'parent' => $request->parent,
                        'document_status' => $request->status ?? 1,
                        // 'file_id' => $request->title,
                        // // 'creation_date' => $request->creation_date,
                        'last_review_date' => date('Y-m-d', strtotime($request->last_review_date)),
                        'review_frequency' => $request->review_frequency,
                        'next_review_date' => date('Y-m-d', strtotime($request->last_review_date) + $request->review_frequency * 24 * 60 * 60),
                        'approval_date' => $request->approval_date,
                        'control_ids' => implode(',', $request->control_ids ?? []),
                        'framework_ids' => implode(',', $request->framework_ids ?? []),
                        'document_owner' => $owner,
                        'document_reviewer' => $request->reviewer,
                        'additional_stakeholders' => implode(',', $request->additional_stakeholders ?? []),
                        // // 'approver' => $request->title,
                        'team_ids' => implode(',', $request->team_ids ?? []),
                    ]);

                    // File upload Start
                    if ($request->hasFile('file')) {
                        if ($request->file('file')->isValid()) {

                            // Store New file
                            $path = $request->file('file')->store('docs/' . $document->id);
                            $file = File::create([
                                'name' => $request->file->getClientOriginalName(),
                                'unique_name' => $path
                            ]);

                            $uploadfilePath = $path;

                            // Delete old file
                            $oldFile = File::find($document->file_id);
                            if ($oldFile) {
                                Storage::delete($oldFile->unique_name);
                                $oldFile->delete();
                            }

                            $document->update([
                                'file_id' => $file->id,
                            ]);
                        } else {
                            DB::rollBack();
                            if ($uploadfilePath)
                                Storage::delete($uploadfilePath);

                            $response = array(
                                'status' => false,
                                'errors' => ['file' => ['There were problems uploading the files']],
                                'message' => __('governance.ThereWasAProblemUpdatingTheDocument') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                    // File upload End

                    // End updating task data

                    DB::commit();
                    event(new DocumentUpdated($document));

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.TaskWasUpdatedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    Storage::delete($uploadfilePath);
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getMessage()
                        'message' => __('locale.Error'),
                    );
                    return response()->json($response, 502);
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

    public function download(Request $request, $id)
    {
        $file = Document::where('id', $id)->first()->file ?? null;
        if ($file) {
            $pathToFile = storage_path('app/docs/' . $file->name);
            return Response::download($pathToFile);
        } else {
            return redirect()->route('admin.governance.category');
        }
    }

    public function ajaxGetListDocument(Request $request, $id)
    {
        $currentUserId = auth()->id();
        $_documents = Document::where('document_type', $id)->get();

        $statuses = [];
        $statuses[1] = "Draft";
        $statuses[2] = "InReview";
        $statuses[3] = "Approved";

        // Filter if current user is adminstator, owner, creator or has ability to view document depending on document status and privacy
        $filteredDocuments = $_documents->filter(function ($document) use ($currentUserId) {
            return (auth()->user()->role_id == 1) || ($currentUserId == $document->document_owner) || ($currentUserId == $document->created_by) || $this->getUserHaveAbilityToViewDocument($document, $currentUserId);
        })->values();

        $documents = $filteredDocuments->map(function ($document) use ($currentUserId, $statuses) {
            return (object)[
                'id' => $document->id,
                'responsive_id' => $document->id,
                'document_name' => $document->document_name,
                // 'framework_ids' => $document->framework_ids,
                'framework_name' => Framework::whereIn('id', explode(',', $document->framework_ids))->pluck('name'),
                // 'control_ids' => $document->control_ids,
                'control' => FrameworkControl::whereIn('id', explode(',', $document->control_ids))->pluck('short_name'),
                'creation_date' => $document->creation_date,
                'approval_date' => $document->approval_date,
                'status' => $statuses[$document->document_status],
                'deletable' => ($currentUserId == $document->document_owner) ? true : false,
                'editable' => ($currentUserId == $document->document_owner) ? true : false,
            ];
        });

        return response()->json($documents, 200);
    }

    public function editDocument(Request $request, $id)
    {
        $document = Document::find($id);

        if ($document->document_owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($document) {
            $data['id'] = $document->id;
            $data['document_type'] = $document->document_type;
            $data['privacy'] = $document->privacy;
            $data['document_name'] = $document->document_name;
            $data['parent'] = $document->parent;
            $data['document_status'] = $document->document_status;
            $data['document_status_name'] = $document->documentStatus->name ?? '';
            $data['file_id'] = $document->file_id;
            $data['creation_date'] = $document->creation_date;
            $data['last_review_date'] = $document->last_review_date;
            $data['review_frequency'] = $document->review_frequency;
            $data['next_review_date'] = $document->next_review_date;
            $data['approval_date'] = $document->approval_date;
            // $data['control_ids'] = $document->control_ids;
            $data['control_ids'] = ($document->control_ids) ? explode(',', $document->control_ids) : [];
            // $data['framework_ids'] = $document->framework_ids;
            $data['framework_ids'] = ($document->framework_ids) ? explode(',', $document->framework_ids) : [];
            // $data['frameworks'] = $document->Frameworks;
            $data['document_owner'] = $document->document_owner;
            // $data['owner'] = $document->owner;
            $data['document_reviewer'] = $document->document_reviewer;
            // $data['additional_stakeholders'] = $document->additional_stakeholders;
            $data['additional_stakeholders'] = ($document->additional_stakeholders) ? explode(',', $document->additional_stakeholders) : [];
            $data['approver'] = $document->approver;
            // $data['team_ids'] = $document->team_ids;
            $data['team_ids'] = ($document->team_ids) ? explode(',', $document->team_ids) : [];
            $notes = $document->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $document->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            // $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);

            $response = array(
                'status' => true,
                // 'data' => $data,
                'data' => mb_convert_encoding($data, "UTF-8", "auto")
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

    public function showDocument(Request $request, $id)
    {
        $document = Document::find($id);

        if ($document) {
            $data['id'] = $document->id;
            $data['document_type'] = $document->document_type;
            $data['privacy'] = $document->privacy;
            $data['document_name'] = $document->document_name;
            $data['parent'] = $document->parent;
            $data['document_status'] = $document->document_status;
            $data['document_status_name'] = $document->documentStatus->name ?? '';
            $data['file_id'] = $document->file_id;
            $data['creation_date'] = $document->creation_date;
            $data['last_review_date'] = $document->last_review_date;
            $data['review_frequency'] = $document->review_frequency;
            $data['next_review_date'] = $document->next_review_date;
            $data['approval_date'] = $document->approval_date;
            $data['controls'] = FrameworkControl::whereIn('id', ($document->control_ids) ? explode(',', $document->control_ids) : [])->pluck('short_name')->toArray();
            $data['frameworks'] = Framework::whereIn('id', ($document->framework_ids) ? explode(',', $document->framework_ids) : [])->pluck('name')->toArray();
            $data['additional_stakeholders'] = User::whereIn('id', ($document->additional_stakeholders) ? explode(',', $document->additional_stakeholders) : [])->pluck('name')->toArray();
            $data['document_owner'] = User::where('id', $document->document_owner)->pluck('name')->first();
            $data['teams'] = Team::whereIn('id', ($document->team_ids) ? explode(',', $document->team_ids) : [])->pluck('name')->toArray();
            $data['document_reviewer'] = User::where('id', $document->document_reviewer)->pluck('name')->first() ?? '';


            // $data['owner'] = $document->owner;
            // $data['additional_stakeholders'] = $document->additional_stakeholders;
            $data['approver'] = $document->approver;
            // $data['team_ids'] = $document->team_ids;
            $notes = $document->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $document->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            // $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);

            $response = array(
                'status' => true,
                // 'data' => $data,
                'data' => mb_convert_encoding($data, "UTF-8", "auto")
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

    public function destroyDocument($id)
    {
        $document = Document::find($id);

        if ($document->document_owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($document) {
            DB::beginTransaction();
            $document_id = $document->id;
            try {
                // Remove file
                $oldFile = File::find($document->file_id);
                $oldFile->delete();

                // Remove the document
                $document->delete(); // documents

                Storage::deleteDirectory('docs/' . $document_id);
                DB::commit();
                event(new DocumentDeleted($document));


                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('governance.DocumentWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheDocument') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('governance.ThereWasAProblemDeletingTheDocument');
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

    public function ajaxGetListFrameControl($ids)
    {
        $var = explode(",", $ids);

        $var2 = implode(" OR   framework_id =", $var);

        $controls = DB::select("select  DISTINCT  framework_controls.id , short_name from framework_control_mappings , framework_controls where  framework_control_mappings.framework_control_id = framework_controls.id  and (framework_id =  $var2)   ");


        $html = "";
        if (!empty($controls)) {

            $html .= '<option value="" > select controls </option>';

            foreach ($controls as $control) {
                $html .= '<option value="' . $control->id . '"> ' . $control->short_name . ' </option>';
            }
        } else {
            $html .= '<option selected value=""> no controls </option>';
        }

        // var_dump( $id );


        echo $html;
    }

    public function ajaxAddNextReviewToFrequency($test_frequency, $last_date = null)
    {
        $next_date = date('Y-m-d', strtotime($last_date) + ($test_frequency ?? 0) * 24 * 60 * 60);

        return $next_date;
    }

    //note
    public function send_note(Request $request)
    {
        $rules = [
            'document_id' => ['required', 'exists:documents,id'],
            'note' => ['required', 'string'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheDocumentNote') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {
                $note = DocumentNote::create([
                    'user_id' => auth()->id(),
                    'document_id' => $request->document_id,
                    'note' => $request->note,
                ]);

                $note = DocumentNote::find($note->id);

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' => __('governance.DocumentNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $note,
                        'document' => $note->document
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('governance.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    public function send_note_file(Request $request)
    {
        $rules = [
            'note_file' => ['file'],
            'document_id' => ['required', 'exists:documents,id'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheDocumentNote') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {

                $fileName = '';
                $path = '';
                // File upload Start
                if ($request->hasFile('note_file')) {
                    $note_file = $request->file('note_file');
                    $path = '';
                    if ($note_file->isValid()) {
                        $path = $note_file->store('document/' . $request->document_id . '/notes');
                        $fileName = pathinfo($note_file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                    } else {
                        if ($path)
                            Storage::delete($path);
                        $response = array(
                            'status' => false,
                            'errors' => ['note_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheDocumentNote') . "<br>" . __('locale.Validation error'),
                        );

                        return response()->json($response, 422);
                    }
                }

                $documentFile = DocumentNoteFile::create([
                    'user_id' => auth()->id(),
                    'document_id' => $request->document_id,
                    'display_name' => $fileName,
                    'unique_name' => $path
                ]);
                // File upload End

                DB::commit();
                $documentFile = DocumentNoteFile::find($documentFile->id);

                $response = array(
                    'status' => true,
                    'message' => __('governance.DocumentNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $documentFile,
                        'document' => $documentFile->document
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                if ($path)
                    Storage::delete($path);
                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    public function downloadNoteFile(Request $request)
    {
        $file = Document::where('id', $request->document_id)->first()->note_files()->where('id', $request->id)->first() ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name);
        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->display_name);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Download the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $file = Document::where('id', $request->document_id)->first()->file ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name ?? '');

        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->name);
        } else {
            return redirect()->route('admin.governance.category');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request, $id)
    {
        $framework = Framework::find($request->id);

        if ($framework) {
            $rules = [
                'name' => ['required', 'max:255', 'unique:frameworks,name'],
                'description' => ['required', 'string'],
                'icon' => ['required', 'string'],
            ];

            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('governance.ThereWasAProblemCopyingTheFrameworkControl') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();

                try {
                    // Start coping framework data
                    $copyedFramework = Framework::create([
                        "name" => $request->name,
                        "description" => $request->description,
                        "icon" => $request->icon
                    ]);

                    $copyedControlData = [
                        "short_name" => null,
                        "long_name" => null,
                        "description" => null,
                        "control_number" => null,
                        "family" => null,
                        "parent_id" => null
                    ];
                    $copyedControlTestName = null;

                    // Get framework controls that doesn't have parent with framework control test
                    $onlyNotChildControls = $framework->FrameworkControls()->doesntHave('parentFrameworkControl')->with('FrameworkControlTest:framework_control_id,name')->get();
                    foreach ($onlyNotChildControls as $onlyNotChildControl) {

                        $copyedControlData["short_name"] = $onlyNotChildControl->short_name;
                        $copyedControlData["long_name"] = $onlyNotChildControl->long_name;
                        $copyedControlData["description"] = $onlyNotChildControl->description;
                        $copyedControlData["control_number"] = $onlyNotChildControl->control_number;
                        $copyedControlData["family"] = $onlyNotChildControl->family;
                        $copyedControlData["parent_id"] = null;
                        $copyedControlTestName = $onlyNotChildControl->FrameworkControlTest->name;
                        $controlId = $this->copyControl($copyedControlData, $copyedControlTestName, $copyedFramework->id);

                        // Reset templte control data
                        $this->resetControl($copyedControlData, $copyedControlTestName);

                        // Set parent for all children
                        $copyedControlData["parent_id"] = $controlId;

                        // Store children of control
                        foreach ($onlyNotChildControl->frameworkControls()->with('FrameworkControlTest:framework_control_id,name')->get() as $childrenFrameworkControl) {
                            $copyedControlData["short_name"] = $childrenFrameworkControl->short_name;
                            $copyedControlData["long_name"] = $childrenFrameworkControl->long_name;
                            $copyedControlData["description"] = $childrenFrameworkControl->description;
                            $copyedControlData["control_number"] = $childrenFrameworkControl->control_number;
                            $copyedControlData["family"] = $childrenFrameworkControl->family;
                            $copyedControlTestName = $childrenFrameworkControl->FrameworkControlTest->name;
                            $this->copyControl($copyedControlData, $copyedControlTestName, $copyedFramework->id);
                        }
                    }
                    // End coping framework data

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('governance.FrameworkControlWasCopyedSuccessfully'),
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();

                    $response = array(
                        'status' => false,
                        'errors' => [],
                        'message' => $th->getMessage()
                        //            'message' => __('locale.Error'),
                    );
                    return response()->json($response, 502);
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
     * Copy the specified resource in storage.
     *
     * @param \Array $control
     * @param \String $test_name
     * @return \integer $contol_id
     */
    public function copyControl($control, $test_name, $framework_id)
    {
        //add in control
        $frameControl = new FrameworkControl();
        $frameControl->short_name = $control['short_name'];
        $frameControl->long_name = $control['long_name'];
        $frameControl->description = $control['description'];
        $frameControl->control_number = $control['control_number'];
        $frameControl->family = $control['family'];
        $frameControl->parent_id = $control['parent_id'];

        if (($control['owner'] ?? null) != "") {
            $frameControl->control_owner = $control['owner'];
        } else {
            $frameControl->control_owner = auth()->user()->id;
        }

        $frameControl->save();
        //add in mapp

        $control_id = DB::getPdo()->lastInsertId();
        $frame_map = new FrameworkControlMapping();
        $frame_map->framework_control_id = $control_id;
        $frame_map->framework_id = $framework_id;
        $frame_map->save();
        $control['last_date'] = $control['last_date'] ?? date('Y-m-d');

        //add test*
        // calc  next_date form last date * test_frequency
        $next_date = date('Y-m-d', strtotime($control['last_date']) + ($control['test_frequency'] ?? 0) * 24 * 60 * 60);
        // add new test to database
        $frameworkControlTest = FrameworkControlTest::create([
            'tester' => $control['tester'] ?? null,
            'last_date' => $control['last_date'],
            'next_date' => $next_date,
            'name' => $test_name,
            'test_steps' => $control['test_steps'] ?? null,
            'approximate_time' => $control['approximate_time'] ?? null,
            'framework_control_id' => $control_id,
            'expected_results' => $control['expected_results'] ?? null,
            'test_frequency' => $control['test_frequency'] ?? 0,
            // 'additional_stakeholders' =>implode(",", $control['additional_stakeholders']),
        ]);

        $test_id = DB::getPdo()->lastInsertId();

        $audit = FrameworkControlTestAudit::create([
            'test_id' => $test_id,
            'tester' => $control['tester'] ?? null,
            'name' => $test_name . "(1)",
            'framework_control_id' => $control_id,
            'last_date' => $control['last_date'],
            'next_date' => $next_date,
            'test_frequency' => $control['test_frequency'] ?? 0,
        ]);

        FrameworkControlTestResult::create([
            'test_audit_id' => $audit->id
        ]);

        return $control_id;
    }

    public function resetControl(&$control, &$testName)
    {
        foreach ($control as $key => $value) {
            $control[$key] = null;
        }
        $testName = null;
    }

    protected function getUserHaveAbilityToViewDocument($document, $currentUserId)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($document->document_status == 3 /*Approved*/ && $document->privacy == 2 /*public*/) {
            return true;
        } else if (($document->document_status == 2 /*InReview*/) || ($document->document_status == 3 /*Approved*/ && $document->privacy == 1 /*private*/)) {
            if (
                $currentUserId == $document->document_reviewer // current user is reviewer
            ) {
                return true;
            }

            // Get users from stockholders
            $additionalStakeholders = explode(',', $document->additional_stakeholders);

            if (in_array($currentUserId, $additionalStakeholders)) {
                return true;
            }
            unset($additionalStakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $document->team_ids))->get();
            foreach ($teams as $team) {
                foreach ($team->users as $user) {
                    array_push($usersInTeams, $user->id);
                }
            }
            unset($teams);
            if (in_array($currentUserId, $usersInTeams)) {
                return true;
            }

            return false;
        }
    }

    public function getControlObjectives($id)
    {
        $control = FrameworkControl::with('objectives')->where('id', $id)->with('FrameworkControlTest')->first();
        $allObjectives = $control->objectives;
        $loggedUserId = auth()->id();
        $objectives = [];
        foreach ($allObjectives as &$objective) {
            $objectiveRemoved = false;
            if ($objective->pivot->responsible_type == 'team') {
                $responsible = Team::where('id', $objective->pivot->responsible_team_id)->first(['id', 'name']);
                $loggedUser = User::with('teams')->find($loggedUserId);
                $loggedUserTeams = $loggedUser->teams->pluck('id')->toArray();
                if (in_array($objective->pivot->responsible_team_id, $loggedUserTeams)) {
                    $objective->canAddEvidence = true;
                } else {
                    if (!auth()->user()->hasPermission('control.all')) {
                        if ($control->control_owner != $loggedUserId && $control->FrameworkControlTest->tester != $loggedUserId) {
                            $objectiveRemoved = true;
                        }
                    }
                }
            } else {
                $responsible = User::where('id', $objective->pivot->responsible_id)->first(['id', 'name']);
                if ($objective->pivot->responsible_id == $loggedUserId) {
                    $objective->canAddEvidence = true;
                    if ($objective->pivot->responsible_type == 'manager') {
                        $objective->manager = true;
                    }
                } else {
                    if (!auth()->user()->hasPermission('control.all')) {
                        if ($control->control_owner != $loggedUserId && $control->FrameworkControlTest->tester != $loggedUserId) {
                            $objectiveRemoved = true;
                        }
                    }
                }
            }

            if ($responsible) {
                $objective->responsible = $responsible->name;
            } else {
                $objective->responsible = 'Unset Yet';
            }
            $objective->due_date = $objective->pivot->due_date;

            if (!$objectiveRemoved) {
                $objectives[] = $objective;
            }
        }
        // dd($objectives);
        return [
            'control' => $control,
            'objectives' => $objectives
        ];
    }

    public function getAllObjectives($id)
    {
        $objectives =  ControlObjective::all();
        $control = FrameworkControl::with('objectives')->where('id', $id)->first();
        $controlObjectivesIds = $control->objectives->pluck('id')->toArray();
        // dd($controlObjectivesIds);
        if (!empty($controlObjectivesIds)) {
            $objectives->each(function (&$objective) use ($controlObjectivesIds) {
                $objective->disabled = in_array($objective->id, $controlObjectivesIds);
            });
        }
        $managersIds = Department::with('manager:id,name')->whereNotNull('manager_id')->get()->pluck('manager')->pluck('id')->toArray();
        $users = User::whereNotIn('id', $managersIds)->get(['id', 'name']);
        return [
            'objectives' => $objectives,
            'users' => $users
        ];
    }

    public function getResponsibles(Request $request)
    {
        $managers = Department::with('manager:id,name')->whereNotNull('manager_id')->get()->pluck('manager');
        if ($request->responsible_type == 'user') {
            $managersIds = $managers->pluck('id')->toArray();
            $responsibles = User::whereNotIn('id', $managersIds)->get(['id', 'name']);
        } elseif ($request->responsible_type == 'manager') {
            $responsibles = $managers;
        } elseif ($request->responsible_type == 'team') {
            $responsibles = Team::all();
        }
        return $responsibles;
    }

    public function getDepartmentMembers($controlControlObjectiveId)
    {
        $managerId = (ControlControlObjective::find($controlControlObjectiveId))->responsible_id;
        $departmentId = (Department::where('manager_id', $managerId)->first())->id;
        return User::where('department_id', $departmentId)->where('id', '!=', $managerId)->get();
    }

    public function addObjectiveToControl(Request $request)
    {
        if ($request->objective_adding_type == 'new') {
            $rules = [
                'control_id' => ['required', 'exists:framework_controls,id'],
                'objective_name' => ['required', 'max:100', 'unique:control_objectives,name'],
                'objective_description' => ['required', 'max:500'],
                'due_date' => ['required', 'date_format:Y-m-d'],

            ];
        } else {
            $rules = [
                'control_id' => ['required', 'exists:framework_controls,id'],
                'objective_id' => [
                    'required', 'exists:control_objectives,id',
                    Rule::unique('controls_control_objectives')->where(function ($query) use ($request) {
                        return $query->where('control_id', $request->control_id);
                    })
                ],
                'due_date' => ['required', 'date_format:Y-m-d'],
            ];
        }
        if ($request->responsible_type == 'team') {
            $rules['responsible_id'] = ['nullable', 'exists:teams,id'];
        } else {
            $rules['responsible_id'] = ['nullable', 'exists:users,id'];
        }

        $customAttributes = [
            'control_id' => 'control',
            'objective_id' => 'objective',
            'responsible_id' => 'responsible'
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheObjectiveToControl') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {
                if ($request->objective_adding_type == 'new') {
                    $objective = ControlObjective::create([
                        'name' => $request->objective_name,
                        'description' => $request->objective_description,
                    ]);
                    $objectiveId = $objective->id;
                } else {
                    $objectiveId = $request->objective_id;
                }

                if ($request->responsible_id) {
                    $responsibleType = $request->responsible_type;
                    if ($responsibleType == 'team') {
                        $resposibleId = null;
                        $responsibleTeamId = $request->responsible_id;
                    } else {
                        $resposibleId = $request->responsible_id;
                        $responsibleTeamId = null;
                    }
                } else {
                    $responsibleType = 'user';
                    $control = FrameworkControl::where('id', $request->control_id)->first(['control_owner']);
                    $resposibleId = $control->control_owner;
                    $responsibleTeamId = null;
                }


                // Start adding data
                $ControlControlObjective = ControlControlObjective::create([
                    "control_id" => $request->control_id,
                    "objective_id" => $objectiveId,
                    "responsible_type" => $responsibleType,
                    "responsible_id" => $resposibleId,
                    "responsible_team_id" => $responsibleTeamId,
                    'due_date' => $request->due_date
                ]); // End adding data
                // get to write log
                $control = FrameworkControl::with('objectives')->where('id', $request->control_id)->first();

                DB::commit();
                event(new ControlObjectiveCreated($ControlControlObjective, $control));

                $objectives =  ($this->getControlObjectives($request->control_id))['objectives'];
                $response = array(
                    'status' => true,
                    'data'  => $objectives,
                    'message' => __('governance.ObjectiveWasAddedToControlSuccessfully'),
                );

                $message = __('governance.A Control that name is') . ' "' . ($control->short_name ??  __('locale.[No Name]')) . '". '
                    . __('governance.Add objective to it') . ' "' . ($ControlControlObjective->objective->name ??  __('locale.[No Objective Name]')) . '". '
                    . __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($ControlControlObjective->id, auth()->id(), $message, 'Creating objective');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => __('locale.Error'),
                    'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function updateObjectiveResponsible(Request $request)
    {

        $rules = [
            'control_control_objective_id' => ['required', 'exists:controls_control_objectives,id'],
            'responsible_member_id' => ['required', 'exists:users,id'],
        ];

        $customAttributes = [
            'control_control_objective_id' => 'control objective',
            'responsible_member_id' => 'responsible'
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemUpdatingTheResponsible') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {


                $controlControlObjective = ControlControlObjective::find($request->control_control_objective_id);
                // Start adding data
                $controlControlObjective->update([
                    "responsible_type" => 'user',
                    "responsible_id" => $request->responsible_member_id,
                    "responsible_team_id" => null,
                ]); // End adding data

                DB::commit();
                $controlId = $controlControlObjective->control_id;
                $objectives =  ($this->getControlObjectives($controlId))['objectives'];
                $response = array(
                    'status' => true,
                    'data'  => $objectives,
                    'message' => __('governance.ResponsibleWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => __('locale.Error'),
                    'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }


    public function storeEvidence(Request $request)
    {
        $rules = [
            'control_control_objective_id' => ['required', 'exists:controls_control_objectives,id'],
            'evidence_description' => ['required', 'max:500'],
            'evidence_file' => ['nullable', 'file', 'max:5000'],
        ];
        $customAttributes = [
            'control_control_objective_id' => 'Control Objective',
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemAddingTheEvidence') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                DB::beginTransaction();



                if ($request->hasFile('evidence_file')) {
                    if ($request->file('evidence_file')->isValid()) {
                        $fileName = $request->file('evidence_file')->getClientOriginalName();
                        $fileUniqueName = $request->file('evidence_file')->store('evidences/' . $request->control_control_objective_id);
                    } else {
                        $fileName = null;
                        $fileUniqueName = null;
                        $response = array(
                            'status'  => false,
                            'errors'  => ['evidence_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheEvidence')
                                . "<br>" . __('locale.Validation error'),
                        );
                    }
                } else {
                    $fileName = null;
                    $fileUniqueName = null;
                }
                //Start addin data
                $Evidence = Evidence::create([
                    "control_control_objective_id" => $request->control_control_objective_id,
                    "description"                  => $request->evidence_description,
                    "creator_id"                   => auth()->id(),
                    'file_name'                    => $fileName,
                    'file_unique_name'             => $fileUniqueName,
                ]);
                // End adding data
                DB::commit();
                event(new ControlEvidenceCreated($Evidence));
                $response = array(
                    'status' => true,
                    'message' => __('governance.EvidenceWasAddedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {

                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function getEvidences($id)
    {
        $controlControlObjective = ControlControlObjective::with('evidences')->where('id', $id)->first();
        $controlName = $controlControlObjective->control->short_name;
        $objectiveName = $controlControlObjective->objective->name;
        $canEditEvidences = false;
        $loggedUserId = auth()->id();
        if ($controlControlObjective->responsible_type == 'team') {
            $loggedUser = User::with('teams')->find($loggedUserId);
            $loggedUserTeams = $loggedUser->teams->pluck('id')->toArray();
            if (in_array($controlControlObjective->responsible_team_id, $loggedUserTeams)) {
                $canEditEvidences = true;
            }
        } else {
            if ($controlControlObjective->responsible_id == $loggedUserId) {
                $canEditEvidences = true;
            }
        }

        $evidences = $controlControlObjective->evidences;
        foreach ($evidences as &$evidence) {
            $evidence->created_by =   $evidence->creator->name;
            $evidence->created_at =   $evidence->created_at->format('Y-m-d');
        }

        return [
            'control_name' => $controlName,
            'objective_name' => $objectiveName,
            'can_edit_evidences' => $canEditEvidences,
            'evidences' => $evidences
        ];
    }

    public function getEvidence($evidenceId)
    {
        $evidence = Evidence::where('id', $evidenceId)->first();
        $evidence->created_by =   $evidence->creator->name;
        $evidence->created_at =   $evidence->created_at->format('Y-m-d');
        return $evidence;
    }

    public function updateEvidence(Request $request)
    {
        $rules = [
            'evidence_id' => ['required', 'exists:evidences,id'],
            'edited_evidence_description' => ['required', 'max:500'],
            'edited_evidence_file' => ['nullable', 'file', 'max:5000'],
        ];
        $customAttributes = [
            'evidence_id' => 'Evidence',
        ];


        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customAttributes);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('governance.ThereWasAProblemUpdatingTheEvidence') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                DB::beginTransaction();

                $evidence = Evidence::where('id', $request->evidence_id)->first();
                $existingFileName = $evidence->file_name;
                $existingFileUniqueName = $evidence->file_unique_name;
                if ($request->hasFile('edited_evidence_file')) {
                    if ($request->file('edited_evidence_file')->isValid()) {
                        $fileName = $request->file('edited_evidence_file')->getClientOriginalName();
                        $fileUniqueName = $request->file('edited_evidence_file')->store('evidences/' . $evidence->control_control_objective_id);
                        if ($existingFileUniqueName) {
                            Storage::delete($existingFileUniqueName);
                        }
                    } else {
                        $fileName = $existingFileName;
                        $fileUniqueName = $existingFileUniqueName;
                        $response = array(
                            'status'  => false,
                            'errors'  => ['edited_evidence_file' => ['There were problems uploading the files']],
                            'message' => __('governance.ThereWasAProblemAddingTheEvidence')
                                . "<br>" . __('locale.Validation error'),
                        );
                    }
                } else {
                    $fileName = $existingFileName;
                    $fileUniqueName = $existingFileUniqueName;
                }
                //Start addin data
                $evidence->update([
                    "description"                  => $request->edited_evidence_description,
                    'file_name'                    => $fileName,
                    'file_unique_name'             => $fileUniqueName,
                ]);
                // End adding data
                DB::commit();
                event(new ControlEvidenceUpdated($evidence));

                $response = array(
                    'status' => true,
                    'message' => __('governance.EvidenceWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {

                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage()
                );
                return response()->json($response, 502);
            }
        }
    }

    public function downloadEvidenceFile($evidenceId)
    {
        try {
            $evidence = Evidence::where('id', $evidenceId)->first();
            $exists = Storage::disk('local')->exists($evidence->file_unique_name);
            if ($evidence->file_unique_name && $exists) {
                $filePath = storage_path('app/' . $evidence->file_unique_name);
                $fileName = $evidence->file_name;
                return response()->download($filePath, $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.ErrorFileNotFound'),
                ], 502);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => [],
                // 'message' => __('locale.Error'),
                'message' => $th->getMessage(),

            ], 502);
        }
    }
    public function notificationsSettingsFramework()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.index'), 'name' => __('locale.Framework')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [31, 32, 33];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            31 => ['name', 'description'],
            32 => ['name', 'description'],
            33 => ['name', 'description'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [];
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


        $actionsWithSettingsAuto = [];
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
    public function notificationsSettingscontrol()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.control.list'), 'name' => __('locale.Governance')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [34, 35, 36, 37, 38, 39, 40];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            34 => ['short_name', 'long_name', 'description', 'control_number', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            35 => ['short_name', 'long_name', 'description', 'control_number', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
            36 => ['name', 'description'],
            37 => ['Control_Owner', 'Control_Name', 'Control_Description', 'Objective', 'Responsible'],
            38 => ['Control_Owner', 'Control_Tester', 'Evidence_Creator', 'Control_Objective', 'Control_Objective_Responsible', 'description', 'Control_Name'],
            39 => ['Control_Owner', 'Control_Tester', 'Evidence_Creator', 'Control_Objective', 'Control_Objective_Responsible', 'description', 'Control_Name'],
            40 => ['short_name', 'long_name', 'description', 'control_number', 'Control_Owner', 'Desired_Maturity', 'Control_Priority', 'Control_class', 'Control_Maturity', 'Control_Phase', 'Control_Type', 'Tester', 'Test_Frequency', 'Test_Name', 'Test_Steps', 'Approximate_Time', 'Expected_Results'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            34 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            35 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            36 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],
            37 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester')],
            38 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Evidence-Creator' => __('locale.EvidenceCreator')],
            39 => ['Control-Owner' => __('locale.ControlOwner'), 'Responsible_Person' => __('locale.Responsible_Person'), 'Control-Tester' => __('locale.ControlTester'), 'Evidence-Creator' => __('locale.EvidenceCreator')],
            40 => ['Control-Owner' => __('locale.ControlOwner'), 'Control-Tester' => __('locale.ControlTester')],

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

        $actionsWithSettingsAuto = [];

        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
    // public function notificationsSettingsCateogry()
    // {
    //     // defining the breadcrumbs that will be shown in page

    //     $breadcrumbs = [
    //         ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
    //         ['link' => route('admin.governance.category'), 'name' => __('locale.Category')],
    //         ['name' => __('locale.NotificationsSettings')]
    //     ];

    //     $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
    //     $moduleActionsIds = [53, 54, 55];   // defining ids of actions modules
    //     $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

    //     // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
    //     $actionsVariables = [
    //         53 => ['Name'],
    //         54 => ['Name'],
    //         55 => ['Name'],
    //     ];
    //     // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
    //     $actionsRoles = [];
    //     // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
    //     $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
    //         ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
    //         ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
    //         ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
    //         ->get([
    //             'actions.id as action_id',
    //             'actions.name as action_name',
    //             'system_notifications_settings.id as system_notification_setting_id',
    //             'system_notifications_settings.status as system_notification_setting_status',
    //             'mail_settings.id as mail_setting_id',
    //             'mail_settings.status as mail_setting_status',
    //             'sms_settings.id as sms_setting_id',
    //             'sms_settings.status as sms_setting_status',
    //         ]);

    //     $actionsWithSettingsAuto = [];
    //     return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    // }
    public function notificationsSettingsDocumentation()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.governance.category'), 'name' => __('locale.Documents')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [53, 54, 55, 56, 57, 58];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [76];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            53 => ['Name'],
            54 => ['Name'],
            55 => ['Name'],
            56 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Created_By'],
            57 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Approval_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Reviewer', 'Created_By'],
            58 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Approval_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Reviewer', 'Created_By'],
            76 => ['Document_Type', 'Status', 'Document_Name', 'Last_Review_Date', 'Next_Review_Date', 'Approval_Date', 'Controls', 'Teams', 'Stakeholders', 'Frameworks', 'Reviewer', 'Created_By'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            56 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator')],
            57 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'reviewers-teams' => __('governance.ReviewersOfDocument')],
            58 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'reviewers-teams' => __('governance.ReviewersOfDocument')],
            76 => ['Document-Owner' => __('governance.DocumentOwner'), 'Team-teams' => __('governance.TeamsOfDocument'), 'Stakeholder-teams' => __('governance.StakeholderOfDocument'), 'Document-Creator' => __('governance.DocumentCreator'), 'reviewers-teams' => __('governance.ReviewersOfDocument')],
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



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteObjective($id)
    {
        $controlControlObjective = ControlControlObjective::with('evidences')->find($id);
        if ($controlControlObjective) {
            DB::beginTransaction();
            try {
                $objectiveEvidences = $controlControlObjective->evidences;
                if (!$objectiveEvidences->isEmpty()) {
                    $response = array(
                        'status' => false,
                        'message' => __('locale.YouCantDeleteTheObjectiveAsItHasEvidencesAttachedToIt'),
                    );
                    return response()->json($response, 404);
                }
                $controlId = $controlControlObjective->control_id;
                $auditObjectives = ControlAuditObjective::where('control_control_objective_id', $id)->get();
                foreach ($auditObjectives as $auditObjective) {
                    $auditObjective->delete();
                }

                $controlControlObjective->delete();
                $objectives =   $this->getControlObjectives($controlId)['objectives'];
                DB::commit();

                $response = array(
                    'status' => true,
                    'objectives' => $objectives,
                    'message' => __('locale.ObjectiveWasDeletedSuccessfully'),
                );
                // $message = __('locale.An evidence that name is') . ' "' . $evidence->name .  __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                // write_log($evidence->id, auth()->id(), $message, 'Deleting Evidence');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheObjective')
                    . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheObjective');
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

    public function deleteEvidence($id)
    {
        $evidence = Evidence::find($id);
        if ($evidence) {
            DB::beginTransaction();
            try {
                $controlControlObjectiveId = $evidence->control_control_objective_id;
                $existingFileUniqueName = $evidence->file_unique_name;
                $auditEvidences = ControlAuditEvidence::where('evidence_id', $id)->get();
                foreach ($auditEvidences as $auditEvidence) {
                    $auditEvidence->delete();
                }

                $evidence->delete();
                if ($existingFileUniqueName) {
                    Storage::delete($existingFileUniqueName);
                }
                $gettingEvidences =   $this->getEvidences($controlControlObjectiveId);
                $evidences = $gettingEvidences['evidences'];
                $canEditEvidences = $gettingEvidences['can_edit_evidences'];
                DB::commit();

                $response = array(
                    'status' => true,
                    'evidences' => $evidences,
                    'can_edit_evidences' => $canEditEvidences,
                    'message' => __('locale.EvidenceWasDeletedSuccessfully'),
                );
                $message = __('locale.An evidence that name is') . ' "' . $evidence->name .  __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($evidence->id, auth()->id(), $message, 'Deleting Evidence');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEvidence')
                    . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEvidence');
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
}
