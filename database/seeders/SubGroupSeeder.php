<?php

namespace Database\Seeders;

use App\Models\Subgroup;
use Illuminate\Database\Seeder;

class SubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subgroup::create([
            'name' => 'Frameworks',
            'permission_group_id' => 1,   //1
        ]);

        Subgroup::create([
            'name' => 'Controls',
            'permission_group_id' => 1, //2
        ]);

        Subgroup::create([
            'name' => 'Document',
            'permission_group_id' => 1,  //3
        ]);

        Subgroup::create([
            'name' => 'Exception',
            'permission_group_id' => 1, //4
        ]);

        Subgroup::create([
            'name' => 'Risks',
            'permission_group_id' => 2, //5
        ]);

        // Subgroup::create([
        //     'name' => 'Mitigations',
        //     'permission_group_id' => 2,
        // ]);

        // Subgroup::create([
        //     'name' => 'Insignificant Risks',
        //     'permission_group_id' => 2,
        // ]);

        Subgroup::create([
            'name' => 'Projects',
            'permission_group_id' => 2, //6
        ]);

        Subgroup::create([
            'name' => 'Compliance',
            'permission_group_id' => 3, //7
        ]);

        Subgroup::create([ // 11
            'name' => 'Tests',
            'permission_group_id' => 3, //8
        ]);

        Subgroup::create([
            'name' => 'Audits',
            'permission_group_id' => 3, //9
        ]);
        Subgroup::create([
            'name' => 'Assets',
            'permission_group_id' => 4, //10
        ]);
        Subgroup::create([
            'name' => 'Assessments',
            'permission_group_id' => 5, //11
        ]);
        Subgroup::create([
            'name' => 'RoleManagement',
            'permission_group_id' => 6, //12
        ]);

        Subgroup::create([
            'name' => 'Add Values',
            'permission_group_id' => 6, //13
        ]);
        Subgroup::create([
            'name' => 'Audit Logs',
            'permission_group_id' => 6, //14
        ]);

        Subgroup::create([
            "name" => 'Hierarchy',
            "permission_group_id" => 7 // 15
        ]);
        Subgroup::create([
            "name" => 'Department',
            "permission_group_id" => 7 // 16
        ]);
        Subgroup::create([
            "name" => 'Job',
            "permission_group_id" => 7 // 17
        ]);
        Subgroup::create([
            "name" => 'Employee',
            "permission_group_id" => 7 // 18
        ]);

        Subgroup::create([
            'name' => 'Plan Mitigation',
            'permission_group_id' => 2, // 19
        ]);

        Subgroup::create([
            'name' => 'Perform Reviews',
            'permission_group_id' => 2, // 20
        ]);
        Subgroup::create([
            'name' => 'AssetGroups',
            'permission_group_id' => 4, // 21
        ]);
        Subgroup::create([
            'name' => 'Categories',
            'permission_group_id' => 1, // 22
        ]);
        Subgroup::create([
            'name' => 'User Management',
            'permission_group_id' => 6, // 23
        ]);
        Subgroup::create([
            'name' => 'Settings',
            'permission_group_id' => 6, // 24
        ]);
        Subgroup::create([
            'name' => 'ClassicRiskFormula',
            'permission_group_id' => 6, // 25
        ]);
        Subgroup::create([
            'name' => 'Import And Export',
            'permission_group_id' => 6, // 26
        ]);
        Subgroup::create([
            'name' => 'LDAP',
            'permission_group_id' => 6, // 27
        ]);
        Subgroup::create([
            'name' => 'Reporting',
            'permission_group_id' => 8, // 28
        ]);
        Subgroup::create([
            'name' => 'Task',
            'permission_group_id' => 9, // 29
        ]);
        Subgroup::create([
            'name' => 'About',
            'permission_group_id' => 6, // 30
        ]);
        Subgroup::create([
            'name' => 'Vulnerability Management',
            'permission_group_id' => 10, // 31
        ]);
        Subgroup::create([
            'name' => 'General Setting',
            'permission_group_id' => 6, // 32
        ]);
        Subgroup::create([
            'name' => 'Services Description',
            'permission_group_id' => 6, // 33
        ]);
        Subgroup::create([
            'name' => 'Change Request',
            'permission_group_id' => 11, // 34
        ]);
        Subgroup::create([
            'name' => 'Change Request Department',
            'permission_group_id' => 6, // 35
        ]);
        Subgroup::create([
            'name' => 'KPI',
            'permission_group_id' => 12, // 36
        ]);
        Subgroup::create([
            "name" => 'Security Awareness',
            'permission_group_id' => 13, // 37
        ]);
        Subgroup::create([
            'name' => 'Domain',
            'permission_group_id' => 6, // 38
        ]);


        // assessments
        Subgroup::create([
            'name' => 'Templates',
            'permission_group_id' => 14, // 39
        ]);
        Subgroup::create([
            'name' => 'Assessments',
            'permission_group_id' => 14, // 40
        ]);
        Subgroup::create([
            'name' => 'Assessment Results',
            'permission_group_id' => 14, // 41
        ]);
        Subgroup::create([
            'name' => 'Questionnaires',
            'permission_group_id' => 14, // 42
        ]);
        Subgroup::create([
            'name' => 'Control Objectives',
            'permission_group_id' => 1, // 43

        ]);
        Subgroup::create([
            'name' => 'AwarenessSurvey',
            'permission_group_id' => 13, // 44

        ]);
        Subgroup::create([
            'name' => 'Email Setting',
            'permission_group_id' => 6, //45
        ]);
    }
}
