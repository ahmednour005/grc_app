<?php

namespace App\Http\Controllers\admin\reporting;

use App\Http\Controllers\Controller;
use App\Models\ControlControlObjective;
use App\Models\FrameworkControl;
use Illuminate\Http\Request;


class ObjectiveReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ],
            [
                'link' => 'javascript:void(0)',
                'name' => __('locale.Reporting')
            ],
            [
                'name' => __('locale.Objectives')
            ]
        ];
        $controls = FrameworkControl::all();

        return view('admin.content.reporting.objective', compact('breadcrumbs','controls'));
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
            'normal' => ['due_date'],
            'relationships' => ['objective'],
            'other_global_filters' => [],
        ];
        $relationshipsWithColumns = [
            'objective:id,name',
            'control:id,short_name',
            'responsibleUser:id,name',
            'responsibleTeam:id,name',
            'evidences'
        ];
        
        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */
        // Getting total records count with and without apply global search 
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            ControlControlObjective::class,
            $dataTableDetails,
            $customFilterFields
        );
        
        $mainTableColumns = getTableColumnsSelect(
            'controls_control_objectives',
            [
                'id',
                'objective_id',
                'control_id',
                'due_date',
                'responsible_id',
                'responsible_team_id'
                ]
            );
            // Getting records with apply global search */
            $ControlControlObjectives = getDatatableFilterRecords(
                ControlControlObjective::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );
        
        // Custom control_objectives response data as needs
        $dataArr = [];
        foreach ($ControlControlObjectives as $ControlControlObjective) {
            if (!empty($ControlControlObjective->ResponsibleUser) || !empty($ControlControlObjective->ResponsibleTeam)) {
                $responsible = $ControlControlObjective->ResponsibleUser->name ?? $ControlControlObjective->ResponsibleTeam->name;
            } else {
                $responsible = '';
            }
            $dataArr[] = array(
                'id' =>  $ControlControlObjective->id,
                'objective' => $ControlControlObjective->objective->name,
                'control' => $ControlControlObjective->control->short_name,
                'responsible' => $responsible,
                'evidences'  => $ControlControlObjective->evidences,
                'due_date' => $ControlControlObjective->due_date,
            );
        }
        
        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(
            intval($dataTableDetails['draw']),
            $totalRecords,
            $totalRecordswithFilter,
            $dataArr
        );
        
        return response()->json($response, 200);
    }
}
