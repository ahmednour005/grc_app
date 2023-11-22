<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;

use App\Http\Traits\RiskAssetTrait;
class RiskByAssetReportController extends Controller
{
    use RiskAssetTrait;

    private $path = "admin.content.reporting.";
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function GetRiskByAsset()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.Risks and Assets')]];
        $types = array(
            '0' => __('report.RisksByAsset'),
            '1' => __('report.AssetsByRisk')
        );
        $currentType=request()->type?request()->type:0;
        $rows=$this->RiskAsset($currentType);

        return view($this->path . 'risk-assets', compact('breadcrumbs', 'types','rows','currentType'));
    }


}
