<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Category;
use App\Models\Framework;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Location;
use App\Models\Risk;
use App\Models\RiskGrouping;
use App\Models\ScoringMethod;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Team;
use App\Models\Technology;
use App\Models\ThreatGrouping;
use App\Models\User;
use App\Models\RiskLevel;
use App\Traits\AssetTrait;
class dynamicRiskReportController extends Controller
{
    use AssetTrait;
    private $path = "admin.content.reporting.";
    /**
     * Display a view for dynamic Risk Report
     *
     * @return String
     */
    public function dynamicRiskReport()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Reporting')], ['name' => __('locale.DynamicRiskReport')]];
        return view($this->path . 'dynamic-risk', compact('breadcrumbs'));
    }
    /**
     * Return a listing of risks
     *
     * @return \Illuminate\Http\Response
     */
    public function GetListRisk()
    {
        $risks = Risk::get()->map(function ($risk) {
            $calculatedRisk = $risk->riskScoring()->select('calculated_risk')->first()->calculated_risk;
            return (object) [
                'responsive_id' => $risk->id,
                // 'id' =>  $risk->id,
                'status' => $risk->status,
                'subject' => $risk->subject,
                'inherent_risk_current' => [$calculatedRisk, $this->riskScoringColor($calculatedRisk)],
                'created_at' => $risk->created_at->format(get_default_date_format()),
                'closure_date' =>  ($risk->closure)?$risk->closure->closure_date:'',
                'risk_catalog_mapping' =>  $risk->risk_catalog_mapping,
                'threat_catalog_mapping' =>  $risk->threat_catalog_mapping,
                'submitted_by' =>  $risk->submitted_by,
                'source_id' =>  $risk->source_id,
                'category_id' =>  $risk->category_id,
                'Actions' => $risk->id,
            ];
        });
        return response()->json($risks, 200);
    }
    protected function riskScoringColor($riskScoring){
        return RiskLevel::orderBy('value', 'desc')->where('value', '<=', $riskScoring)->first()->color;
    }
}
