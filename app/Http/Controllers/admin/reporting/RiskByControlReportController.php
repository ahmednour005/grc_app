<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\Project;
use DB;
use App\Http\Traits\RiskControlTrait;
class RiskByControlReportController extends Controller
{
    use RiskControlTrait;

    private $path = "admin.content.reporting.";
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function GetRiskByControl()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.Risks and Controls')]];
        $types = array(
            '0' => __('report.RisksByControl'),
            '1' => __('report.ControlsByRisk'),
        );
        $currentType=request()->type?request()->type:0;
        $rows=$this->RiskControl($currentType);

        return view($this->path . 'risk-controls', compact('breadcrumbs', 'types','rows','currentType'));
    }


}
