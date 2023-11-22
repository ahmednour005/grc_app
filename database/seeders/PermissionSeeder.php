<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $mainPermissions = ['framework.', 'control.', 'document.', '', 'riskmanagement.', '', '', '', 'audits.', 'asset.', '', 'roles.', 'values.', 'logs.', 'hierarchy.', 'department.', 'job.', '', 'plan_mitigation.', 'perform_reviews.', 'asset_group.', 'category.', 'user_management.', 'settings.', 'classic_risk_formula.', 'import_and_export.', 'LDAP.', 'reporting.', 'task.', 'about.', 'vulnerability_management.', 'general-setting.', 'services-description.', 'email-setting.', 'change-request.', 'change-request-department.', 'KPI.', 'security-awareness.', 'awareness-survey.', 'control-objective.', 'templateAssessment.', 'assessment.', 'assessmentResult.', 'domain.'];

        $permissionStatuses = ['list', 'view', 'create', 'update', 'delete', 'print', 'export'];

        foreach ($mainPermissions as $mainKey => $mainPermission) {
            if ($mainPermission == '') // neglect ['Compliance', 'Tests]
                continue;
            if ($mainPermission == 'hierarchy.') { // Hierachy
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'view',
                    "subgroup_id" => 15
                ]);
                Permission::create([
                    "key" => $mainPermission . 'view',
                    "name" => 'view',
                    "subgroup_id" => 15
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 15
                ]);
            } else if ($mainPermission == 'task.') { // Task
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 29
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 29
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 29
                ]);
            } else if ($mainPermission == 'audits.') { // Audit
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 9
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 9
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => 9
                ]);
                Permission::create([
                    "key" => $mainPermission . 'result',
                    "name" => 'result',
                    "subgroup_id" => 9
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 9
                ]);
            } else if ($mainPermission == 'reporting.') { // Reporting
                Permission::create([
                    "key" => $mainPermission . 'Overview',
                    "name" => 'Overview',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Risk Dashboard',
                    "name" => 'Risk Dashboard',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Control Gap Analysis',
                    "name" => 'Control Gap Analysis',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Likelihood And Impact',
                    "name" => 'Likelihood And Impact',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'All Open Risks Assigne To Me',
                    "name" => 'All Open Risks Assigne To Me',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Dynamic Risk Report',
                    "name" => 'Dynamic Risk Report',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Risks and Controls',
                    "name" => 'Risks and Controls',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Risks and Assets',
                    "name" => 'Risks and Assets',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'framewrok_control_compliance_status',
                    "name" => 'Framewrok control compliance status',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'summary_of_results_for_evaluation_and_compliance',
                    "name" => 'Summary of results for evaluation and compliance',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'security-awareness-exam',
                    "name" => 'Security awareness exam',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'awareness-survey-info',
                    "name" => '	Awareness Survey',
                    "subgroup_id" => 28
                ]);
                Permission::create([
                    "key" => $mainPermission . 'objectives',
                    "name" => 'Objectives',
                    "subgroup_id" => 28
                ]);
            } else if ($mainPermission == 'LDAP.') { // LDAP
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 27
                ]);
                Permission::create([
                    "key" => $mainPermission . 'test',
                    "name" => 'test',
                    "subgroup_id" => 27
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 27
                ]);
            } else if ($mainPermission == 'plan_mitigation.') { // Plan Mitigation
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 19
                ]);
                Permission::create([
                    "key" => $mainPermission . 'accept',
                    "name" => 'accept',
                    "subgroup_id" => 19
                ]);
            } else if ($mainPermission == 'perform_reviews.') { // Perform Reviews
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 20
                ]);
                // Permission::create([
                //     "key" => $mainPermission . 'AbleToReviewInsignificantRisks',
                //     "name" => 'AbleToReviewInsignificantRisks',
                //     "subgroup_id" => 20
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'AbleToReviewLowRisks',
                //     "name" => 'AbleToReviewLowRisks',
                //     "subgroup_id" => 20
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'AbleToReviewMediumRisks',
                //     "name" => 'AbleToReviewMediumRisks',
                //     "subgroup_id" => 20
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'AbleToReviewHighRisks',
                //     "name" => 'AbleToReviewHighRisks',
                //     "subgroup_id" => 20
                // ]);
                // Permission::create([
                //     "key" => $mainPermission . 'AbleToReviewVeryHighRisks',
                //     "name" => 'AbleToReviewVeryHighRisks',
                //     "subgroup_id" => 20
                // ]);



            } else if ($mainPermission == 'import_and_export.') {
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 26
                ]);
                Permission::create([
                    "key" => $mainPermission . 'import',
                    "name" => 'import',
                    "subgroup_id" => 26
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 26
                ]);
            } else if ($mainPermission == 'about.') { // About
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 30
                ]);
            } else if ($mainPermission == 'general-setting.') { // general setting
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 32
                ]);
            } else if ($mainPermission == 'services-description.') { // services description
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 33
                ]);
            } else if ($mainPermission == 'email-setting.') { // services description
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 45
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 45
                ]);
            } else if ($mainPermission == 'change-request.') { // change request
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 34
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 34
                ]);
            } else if ($mainPermission == 'change-request-department.') { // change request department
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 35
                ]);
            } else if ($mainPermission == 'KPI.') { // KPI
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 36
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 36
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 36
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => 36
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Initiate assessment',
                    "name" => 'Initiate assessment',
                    "subgroup_id" => 36
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 36
                ]);
            } else if ($mainPermission == 'document.') { // document
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 3
                ]);
                // Permission::create([
                //     "key" => $mainPermission . 'view',
                //     "name" => 'view',
                //     "subgroup_id" => 3
                // ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 3
                ]);
                Permission::create([
                    "key" => $mainPermission . 'print',
                    "name" => 'print',
                    "subgroup_id" => 3
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 3
                ]);
                Permission::create([
                    "key" => $mainPermission . 'download',
                    "name" => 'download',
                    "subgroup_id" => 3
                ]);
            } else if ($mainPermission == 'security-awareness.') { // Security Awareness
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 37
                ]);
                // Permission::create([
                //     "key" => $mainPermission . 'view',
                //     "name" => 'view',
                //     "subgroup_id" => 37
                // ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 37
                ]);
                Permission::create([
                    "key" => $mainPermission . 'print',
                    "name" => 'print',
                    "subgroup_id" => 37
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 37
                ]);
                Permission::create([
                    "key" => $mainPermission . 'download',
                    "name" => 'download',
                    "subgroup_id" => 37
                ]);
            } else if ($mainPermission == 'awareness-survey.') { // Awareness Survey
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 44
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 44
                ]);
                Permission::create([
                    "key" => $mainPermission . 'edit',
                    "name" => 'edit',
                    "subgroup_id" => 44
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => 44
                ]);
                Permission::create([
                    "key" => $mainPermission . 'add_questions',
                    "name" => 'add question',
                    "subgroup_id" => 44
                ]);
                Permission::create([
                    "key" => $mainPermission . 'list_questions',
                    "name" => 'list questions',
                    "subgroup_id" => 44
                ]);
            } else if ($mainPermission == 'templateAssessment.') { // assessment question
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 39
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 39
                ]);
                Permission::create([
                    "key" => $mainPermission . 'edit',
                    "name" => 'edit',
                    "subgroup_id" => 39
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => 39
                ]);
                Permission::create([
                    "key" => $mainPermission . 'questionsAnswer',
                    "name" => 'questions Answer',
                    "subgroup_id" => 39
                ]);
                Permission::create([
                    "key" => $mainPermission . 'questionsEdit',
                    "name" => 'questions Edit',
                    "subgroup_id" => 39
                ]);
                Permission::create([
                    "key" => $mainPermission . 'questionsDelete',
                    "name" => 'questions Delete',
                    "subgroup_id" => 39
                ]);
            } else if ($mainPermission == 'assessment.') { // assessment question
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 40
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 40
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Edit',
                    "name" => 'Edit',
                    "subgroup_id" => 40
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Delete',
                    "name" => 'Delete',
                    "subgroup_id" => 40
                ]);
                Permission::create([
                    "key" => $mainPermission . 'Send',
                    "name" => 'Send',
                    "subgroup_id" => 40
                ]);
                Permission::create([
                    "key" => $mainPermission . 'showOption',
                    "name" => 'Show Option',
                    "subgroup_id" => 40
                ]);
            } else if ($mainPermission == 'assessmentResult.') { // assessment Result
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 41
                ]);
                Permission::create([
                    "key" => $mainPermission . 'assessmentResult',
                    "name" => 'Assessment Result',
                    "subgroup_id" => 41
                ]);
            } else if ($mainPermission == 'control-objective.') { // Control Objective
                Permission::create([
                    "key" => $mainPermission . 'list',
                    "name" => 'list',
                    "subgroup_id" => 43
                ]);
                Permission::create([
                    "key" => $mainPermission . 'view',
                    "name" => 'view',
                    "subgroup_id" => 43
                ]);
                Permission::create([
                    "key" => $mainPermission . 'create',
                    "name" => 'create',
                    "subgroup_id" => 43
                ]);
                Permission::create([
                    "key" => $mainPermission . 'delete',
                    "name" => 'delete',
                    "subgroup_id" => 43
                ]);
                Permission::create([
                    "key" => $mainPermission . 'update',
                    "name" => 'update',
                    "subgroup_id" => 43
                ]);

                Permission::create([
                    "key" => $mainPermission . 'print',
                    "name" => 'print',
                    "subgroup_id" => 43
                ]);
                Permission::create([
                    "key" => $mainPermission . 'export',
                    "name" => 'export',
                    "subgroup_id" => 43
                ]);
            } else {
                foreach ($permissionStatuses as $key => $permissionStatus) {
                    Permission::create([
                        "key" => $mainPermission . $permissionStatus,
                        "name" => $permissionStatus,
                        "subgroup_id" => $mainKey + 1
                    ]);
                }
                if ($mainKey == 4) { // Risk
                    Permission::create([
                        "key" => $mainPermission . 'AbleToCommentRiskManagement',
                        "name" => 'AbleToCommentRiskManagement',
                        "subgroup_id" => $mainKey + 1
                    ]);
                    Permission::create([
                        "key" => $mainPermission . 'AbleToCloseRisks',
                        "name" => 'AbleToCloseRisks',
                        "subgroup_id" => $mainKey + 1
                    ]);
                }
            }
        }
    }
}
