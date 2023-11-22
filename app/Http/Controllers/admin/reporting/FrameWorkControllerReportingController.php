<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Http\Traits\RiskAssetTrait;
use App\Models\Family;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrameWorkControllerReportingController extends Controller
{

    /**
     * Display framewrok control compliance status report
     *
     * @return String
     */
    public function framewrokControlComplianceStatus()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.framework_control_compliance_status')]];

        $frameworks = Framework::get();

        return view('admin.content.reporting.framewrok-control-compliance-status', compact('breadcrumbs', 'frameworks'));
    }

    /**
     * Get framewrok control compliance status report
     *
     * @return String
     */
    public function framewrokControlComplianceStatusInfo(Request $request)
    {
        $frameworkId = $request->framework_id;
        $tempFramework = Framework::find($frameworkId);

        if ($tempFramework) {
            $frameWorkDomainIds = $tempFramework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $tempFramework->only_sub_families()->pluck('families.id')->toArray();
            Family::$frameworkControlIds = $tempFramework->FrameworkControls()->pluck('framework_controls.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();
            $response = array(
                'status' => true,
                'data' => [
                    'domains' => $domains,
                    'control_status_colors' => TestResult::pluck('background_class', 'name'),
                    'dateTime' => date("Y/m/d h:i:s A")
                ],
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
     * Display summary of results for evaluation and compliance report
     *
     * @return String
     */
    public function summaryOfResultsForEvaluationAndCompliance()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.summary_of_results_for_evaluation_and_compliance')]];
        $statuses = TestResult::pluck('background_class', 'name');
        $frameworks = Framework::get();

        return view('admin.content.reporting.summary-of-results-for-evaluation-and-compliance', compact('breadcrumbs', 'statuses', 'frameworks'));
    }

    /**
     * Get summary of results for evaluation and compliance report
     *
     * @return String
     */
    public function summaryOfResultsForEvaluationAndComplianceInfo(Request $request)
    {
        $frameworkId = $request->framework_id;
        $tempFramework = Framework::find($frameworkId);

        if ($tempFramework) {
            // $data['total'] = $tempFramework->FrameworkControls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $data['total'] = $tempFramework->only_parent_controls()->groupBy('control_status')->select('control_status', DB::raw('count(*) as total'))->pluck('total', 'control_status')->toArray();
            $controlStatuses = ['Not Applicable', 'Not Implemented', 'Partially Implemented', 'Implemented'];

            foreach ($controlStatuses as $controlStatus) {
                if (!array_key_exists($controlStatus, $data['total'])) {
                    $data['total'][$controlStatus] = 0;
                }
            }
            unset($controlStatuses);

            // $data['all'] = $tempFramework->FrameworkControls()->count();
            $data['all'] = $tempFramework->only_parent_controls()->count();
            $frameWorkDomainIds = $tempFramework->only_families()->pluck('families.id')->toArray();
            $frameWorkSubDomainIds = $tempFramework->only_sub_families()->pluck('families.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["custom_families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            Family::$frameworkControlIds = $tempFramework->FrameworkControls()->pluck('framework_controls.id')->toArray();
            $domains = Family::whereIn('id', $frameWorkDomainIds)->orderBy('order')
                ->with(["families" => function ($q) use ($frameWorkSubDomainIds) {
                    $q->whereIn('id', $frameWorkSubDomainIds);
                }])->get();

            $domainsArray = [];
            foreach ($domains as $mainKey => $domain) {
                $domainsArray[$mainKey] = [];
                $domainsArray[$mainKey]['id'] = $domain['id'];
                $domainsArray[$mainKey]['name'] = $domain['name'];
                $domainsArray[$mainKey]["Partially Implemented"] = 0;
                $domainsArray[$mainKey]["Implemented"] = 0;
                $domainsArray[$mainKey]["Not Applicable"] = 0;
                $domainsArray[$mainKey]["Not Implemented"] = 0;
                $domainsArray[$mainKey]["total"] = 0;

                foreach ($domain->custom_families as $key => $subDomain) {
                    // dd($subDomain);
                    foreach ($subDomain->custom_frameworkControls as $key => $frameworkControl) {
                        // dd($frameworkControl);
                        $domainsArray[$mainKey][$frameworkControl['control_status']]++;
                        $domainsArray[$mainKey]['total']++;
                    }
                }
            }
            unset($domains);

            $response = array(
                'status' => true,
                'data' => [
                    'data' => $data,
                    'domains' => $domainsArray,
                    'dateTime' => date("Y/m/d h:i:s A")
                ]
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
}
