<?php

namespace Database\Seeders;

use App\Models\TestStatus;
use Illuminate\Database\Seeder;

class TestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestStatus::create([
            "id" => 1,
            "name" =>  'Pending Evidence from Control Owner'
        ]);
        TestStatus::create([
            "id" => 2,
            "name" =>  'Evidence Submitted / Pending Review'
        ]);
        TestStatus::create([
            "id" => 3,
            "name" =>  'Passed Internal QA'
        ]);
        TestStatus::create([
            "id" => 4,
            "name" =>  'Remediation Required'
        ]);
        TestStatus::create([
            "id" => 5,
            "name" =>  'Closed'
        ]);
    }
}
