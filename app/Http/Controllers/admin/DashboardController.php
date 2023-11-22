<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Document;
use App\Models\DocumentTypes;
use App\Models\Risk;
use App\Models\FrameworkControlTestAudit;
use App\Models\AssetGroup;
use App\Models\Department;
use App\Models\Job;
use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    private $path="admin.content.dashboard";
    public function dashboard()
    {
        $breadcrumbs = [['name' => __('locale.Dashboard')]];
        $Frameworks=$this->FrameworksStatistics();
        $Controls=$this->ControlsStatistics();
        $Documents=$this->DocumentStatistics();
        $Risks=$this->RiskStatistics();
        $Audits=$this->AuditStatistics();
        $Assets=$this->AssetStatistics();
        $Teams=$this->TeamStatistics();
        $Users=$this->UserStatistics();
        $Departments=$this->DepartmentStatistics();
        $Jobs=$this->JobStatistics();
       return view($this->path,
       compact('breadcrumbs','Frameworks','Controls','Documents'
       ,'Risks','Audits','Assets','Teams','Users','Departments','Jobs'));
    }
    public function FrameworksStatistics()
    {
        return array(
            'count'=>Framework::all()->count(),
            'all'=>Framework::all()
        );
    }
    public function ControlsStatistics()
    {
        return array(
            'count'=>FrameworkControl::all()->count(),
            'active'=>FrameworkControl::Where('status',1)->get()->count(),
            'close'=>FrameworkControl::Where('status',0)->get()->count(),
            'all'=>FrameworkControl::all(),
        );
    }
    public function DocumentStatistics()
    {
        return array(
            'count'=>Document::all()->count(),
            'DocumentTypes'=>DocumentTypes::all(),

        );
    }
    public function RiskStatistics()
    {
        return array(
            'count'=>Risk::all()->count(),
            'Open'=>Risk::Where('status','!=','Closed')->get()->count(),
            'Close'=>Risk::Where('status','Closed')->get()->count(),

        );
    }
    public function AuditStatistics()
    {
        return array(
            'count'=>FrameworkControlTestAudit::all()->count(),
            'active'=>FrameworkControlTestAudit::where('status','!=',5)->get()->count(),
            'past'=>FrameworkControlTestAudit::where('status',5)->get()->count(),
        );
    }
    public function AssetStatistics()
    {
        return array(
            'count'=>Asset::all()->count(),
            'Groupcount'=>AssetGroup::all()->count(),
        );
    }
    public function TeamStatistics()
    {
        return array(
            'count'=>Team::all()->count(),
        );
    }
    public function UserStatistics()
    {
        return array(
            'count'=>User::all()->count(),
            'active'=>User::where('enabled',1)->get()->count(),
            'deactive'=>User::where('enabled',0)->get()->count(),
            'ldap'=>User::where('type','ldap')->get()->count(),
            'grc'=>User::where('type','grc')->get()->count(),
        );
    }
    public function DepartmentStatistics()
    {
        return array(
            'count'=>Department::all()->count(),
        );
    }
    public function JobStatistics()
    {
        return array(
            'count'=>Job::all()->count(),
        );
    }
}
