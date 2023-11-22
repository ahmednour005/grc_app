<?php

namespace App\Providers;

use App\View\Components\admin\content\assessments\assessmentsMng\search;
use App\View\Components\Admin\Content\Asset_management\Asset\Form as AssetForm;
use App\View\Components\Admin\Content\Asset_management\Asset\Form\CreateView;
use App\View\Components\Admin\Content\Asset_management\Asset\Form\EditView;
use App\View\Components\Admin\Content\Asset_management\Asset\Search as AssetSearch;
use App\View\Components\Admin\Content\Asset_management\Asset_group\Form as AssetGroupForm;
use App\View\Components\Admin\Content\Asset_management\Asset_group\Search as AssetGroupSearch;
use App\View\Components\Admin\Content\Change_request\Form as ChangeRequestForm;
use App\View\Components\Admin\Content\Change_request\Search as ChangeRequestSearch;
use App\View\Components\Admin\Content\Configure\Domain_management\Form as DomainManagementForm;
use App\View\Components\Admin\Content\Configure\Domain_management\Search as DomainManagementSearch;
use App\View\Components\Admin\Content\Hierarchy\Department\Form as DepartmentForm;
use App\View\Components\Admin\Content\Hierarchy\Department\Search as DepartmentSearch;
use App\View\Components\Admin\Content\Hierarchy\Job\Form as JobForm;
use App\View\Components\Admin\Content\Hierarchy\Job\Search as JobSearch;
use App\View\Components\Admin\Content\KPI\Assessment\Search as KPIAssessmentSearch;
use App\View\Components\Admin\Content\KPI\Form as KPIForm;
use App\View\Components\Admin\Content\KPI\Search as KPISearch;
use App\View\Components\Admin\Content\Reporting\AssetRiskDetail as AssetRiskDetail;
use App\View\Components\Admin\Content\Reporting\ControlRiskDetail as ControlRiskDetail;
use App\View\Components\Admin\Content\Reporting\RiskAssetDetail as RiskAssetDetail;
use App\View\Components\Admin\Content\Reporting\RiskControlDetail as RiskControlDetail;
use App\View\Components\Admin\Content\Reporting\Objective\Search as ObjectiveReportSearch;
use App\View\Components\Admin\Content\RiskManagement\SubmitRisk\Form as SubmitRiskForm;
use App\View\Components\Admin\Content\RiskManagement\SubmitRisk\Search as SubmitRiskSearch;
use App\View\Components\Admin\Content\Security_awareness\Form as SecurityAwarenessForm;

use App\View\Components\Admin\Content\Security_awareness\Search as SecurityAwarenessSearch;
use App\View\Components\Admin\Content\Vulnerability_management\Form as VulnerabilityManagementForm;
use App\View\Components\Admin\Content\Vulnerability_management\Search as VulnerabilityManagementSearch;


use App\View\Components\Admin\Notification_setting\SystemNotificationForm as SystemNotificationSettingForm;

use App\View\Components\Admin\Notification_setting\MailForm as MailSettingForm;
use App\View\Components\Admin\Notification_setting\SmsForm as SmsSettingForm;
use App\View\Components\Admin\Notification_setting\AutoNotify as AutoNotify;


use App\View\Components\Admin\Export_Import;
use App\View\Components\Admin\Content\ControlObjective\Search as ControlObjectiveSearch;
use App\View\Components\Admin\Content\ControlObjective\Form as ControlObjectiveForm;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Asset
        Blade::component('asset-create-form', CreateView::class);
        Blade::component('asset-edit-form', EditView::class);
        Blade::component('asset-search', AssetSearch::class);
        Blade::component('asset-form', AssetForm::class);


        // Asset Group
        Blade::component('asset-group-search', AssetGroupSearch::class);
        Blade::component('asset-group-form', AssetGroupForm::class);

        // Hierarchy department
        Blade::component('department-search', DepartmentSearch::class);
        Blade::component('department-form', DepartmentForm::class);

        // Hierarchy job
        Blade::component('job-search', JobSearch::class);
        Blade::component('job-form', JobForm::class);

        // Risk Management Submit Risk
        Blade::component('submit-risk-search', SubmitRiskSearch::class);
        Blade::component('submit-risk-form', SubmitRiskForm::class);

        Blade::component('risk-control-detail', RiskControlDetail::class);
        Blade::component('control-risk-detail', ControlRiskDetail::class);
        Blade::component('risk-asset-detail', RiskAssetDetail::class);
        Blade::component('asset-risk-detail', AssetRiskDetail::class);

        // Vulnerability Management
        Blade::component('vulnerability-management-search', VulnerabilityManagementSearch::class);
        Blade::component('vulnerability-management-form', VulnerabilityManagementForm::class);

        // Change Request
        Blade::component('change-request-search', ChangeRequestSearch::class);
        Blade::component('change-request-form', ChangeRequestForm::class);

        // KPI
        Blade::component('KPI-search', KPISearch::class);
        Blade::component('KPI-form', KPIForm::class);
        Blade::component('KPI-assessment-search', KPIAssessmentSearch::class);

        // Security Awareness
        Blade::component('security-awareness-search', SecurityAwarenessSearch::class);
        Blade::component('security-awareness-form', SecurityAwarenessForm::class);

        // Configure domain management
        Blade::component('domain-management-search', DomainManagementSearch::class);
        Blade::component('domain-management-form', DomainManagementForm::class);

        // Export Import
        Blade::component('export-import', Export_Import::class);


        // Control objective
        Blade::component('control-objective-search', ControlObjectiveSearch::class);
        Blade::component('control-objective-form', ControlObjectiveForm::class);

        //Notification settings
        Blade::component('system-notification-setting-form', SystemNotificationSettingForm::class);
        Blade::component('mail-setting-form', MailSettingForm::class);
        Blade::component('sms-setting-form', SmsSettingForm::class);
        Blade::component('AutoNotify-form', AutoNotify::class);

        //Objective 
        Blade::component('objective-report-search', ObjectiveReportSearch::class);


    }
}
