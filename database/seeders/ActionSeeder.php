<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::truncate();

        Action::insert([
            ['id' => 1, 'name' => 'vulnerability_add'],
            ['id' => 2, 'name' => 'vulnerability_update'],
            ['id' => 3, 'name' => 'vulnerability_delete'],
        ]);
        Action::insert([
            ['id' => 4, 'name' => 'survey_add'],
            ['id' => 5, 'name' => 'survey_update'],
            ['id' => 6, 'name' => 'survey_delete'],
        ]);
        Action::insert([
            ['id' => 7, 'name' => 'securityAwareness_add'],
            ['id' => 8, 'name' => 'securityAwareness_update'],
            ['id' => 9, 'name' => 'securityAwareness_delete'],
        ]);
        Action::insert([
            ['id' => 10, 'name' => 'Risk_Add'],
            ['id' => 11, 'name' => 'Risk_Update'],
            ['id' => 12, 'name' => 'MgmtReview_Add'],
            ['id' => 13, 'name' => 'Risk_Close'],
            ['id' => 14, 'name' => 'Risk_Status'],
            ['id' => 15, 'name' => 'Risk_Mitigation'],
            ['id' => 16, 'name' => 'Risk_Delete'],
            ['id' => 17, 'name' => 'Risk_Reset_Reviews'],
            ['id' => 18, 'name' => 'Risk_Reset_Mitigations'],
            // ['id' => 19, 'name' => 'Risk_Mitigation_Update'],
            ['id' => 20, 'name' => 'Risk_Reopen'],
            ['id' => 21, 'name' => 'Risk_Update_Subject'],
        ]);
        Action::insert([
            ['id' => 22, 'name' => 'Departement_Add'],
            ['id' => 23, 'name' => 'Departement_Update'],
            ['id' => 24, 'name' => 'Departement_Delete'],
        ]);
        Action::insert([
            ['id' => 25, 'name' => 'Job_Add'],
            ['id' => 26, 'name' => 'Job_Update'],
            ['id' => 27, 'name' => 'Job_Delete'],

        ]);
        Action::insert([
            ['id' => 28, 'name' => 'Kpi_Add'],
            ['id' => 29, 'name' => 'Kpi_Update'],
            ['id' => 30, 'name' => 'Kpi_Delete'],

        ]);
        Action::insert([
            ['id' => 31, 'name' => 'Framework_Add'],
            ['id' => 32, 'name' => 'Framework_Update'],
            ['id' => 33, 'name' => 'Framework_Delete'],
        ]);
        Action::insert([
            ['id' => 34, 'name' => 'Control_Add'],
            ['id' => 35, 'name' => 'Control_Update'],
            ['id' => 36, 'name' => 'Control_Delete'],
            ['id' => 37, 'name' => 'Objective_Add'],
            ['id' => 38, 'name' => 'Evidence_Add'],
            ['id' => 39, 'name' => 'Evidence_Update'],
            ['id' => 40, 'name' => 'Audit_Add'],
        ]);
        Action::insert([
            ['id' => 41, 'name' => 'Control_Objectives_Add'],
            ['id' => 42, 'name' => 'Control_Objectives_Update'],
            ['id' => 43, 'name' => 'Control_Objectives_Delete'],
        ]);
        Action::insert([
            ['id' => 44, 'name' => 'Audit_Main_Add'],
            ['id' => 45, 'name' => 'Audit_Risk_Add'],
            ['id' => 46, 'name' => 'Aduit_Comment_Add'],
            ['id' => 19, 'name' => 'Aduit_Policy_Add'],

        ]);
        Action::insert([
            ['id' => 47, 'name' => 'Asset_Add'],
            ['id' => 48, 'name' => 'Asset_Update'],
            ['id' => 49, 'name' => 'Asset_Delete'],
        ]);
        Action::insert([
            ['id' => 50, 'name' => 'Asset_Group_Add'],
            ['id' => 51, 'name' => 'Asset_Group_Update'],
            ['id' => 52, 'name' => 'Asset_Group_Delete'],
        ]);
        Action::insert([
            ['id' => 53, 'name' => 'Cateogry_Add'],
            ['id' => 54, 'name' => 'Cateogry_Update'],
            ['id' => 55, 'name' => 'Cateogry_Delete'],
        ]);
        Action::insert([
            ['id' => 56, 'name' => 'Document_Add'],
            ['id' => 57, 'name' => 'Document_Update'],
            ['id' => 58, 'name' => 'Document_Delete'],
        ]);
        Action::insert([
            ['id' => 59, 'name' => 'Assessment_Add'],
            ['id' => 60, 'name' => 'Assessment_Update'],
            ['id' => 61, 'name' => 'Assessment_Delete'],
        ]);
        Action::insert([
            ['id' => 62, 'name' => 'Question_Add'],
            ['id' => 63, 'name' => 'Question_Update'],
            ['id' => 64, 'name' => 'Question_Delete'],
        ]);
        Action::insert([
            ['id' => 65, 'name' => 'Questionnaire_Add'],
            ['id' => 66, 'name' => 'Questionnaire_Update'],
            ['id' => 67, 'name' => 'Questionnaire_Delete'],
        ]);
        Action::insert([
            ['id' => 68, 'name' => 'Departement_Moving'],
            ['id' => 69, 'name' => 'Departement_Moving_Employee'],
         ]);
         Action::insert([
            ['id' => 70, 'name' => 'Survey_Notify_Before_Last_Review_Date'],
         ]);

         Action::insert([
            ['id' => 71, 'name' => 'Security_Awareness_Notify_Before_Last_Review_Date'],
         ]);
         Action::insert([
            ['id' => 72, 'name' => 'Control_Notify_Before_Last_Test_Date'],
         ]);
         Action::insert([
            ['id' => 73, 'name' => 'Objective_Achievement'],
         ]);
         Action::insert([
            ['id' => 74, 'name' => 'initiate_Assessment'],
         ]);
         Action::insert([
            ['id' => 75, 'name' => 'Asset_Notify_Before_Last_End_Date'],
         ]);
         Action::insert([
            ['id' => 76, 'name' => 'Documentation_Notify_Before_Last_End_Date'],
         ]);
         Action::insert([
            ['id' => 77, 'name' => 'Task_Add'],
            ['id' => 78, 'name' => 'Task_Update'],
            ['id' => 79, 'name' => 'Task_Delete'],
            ['id' => 80, 'name' => 'Task_Notify_Before_Last_Due_Date'],
            ['id' => 81, 'name' => 'Task_Employee_Change_Status']
         ]);
         Action::insert([
            ['id' => 82, 'name' => 'Risk_Review_Notify_Before_Last_End_Date'],
         ]);
    }
}
