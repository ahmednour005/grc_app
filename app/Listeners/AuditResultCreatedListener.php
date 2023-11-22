<?php

namespace App\Listeners;

use App\Events\AuditResultCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\FrameworkControlTestResult;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;
use App\Models\ControlControlObjective;
use App\Models\NotifyAtDateModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuditResultCreatedListener
{
    use NotificationHandlingTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AuditResultCreated  $event
     * @return void
     */
    public function handle(AuditResultCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name','Audit_Main_Add')->first();
        $actionId1 = $action1['id'];

        $action2 = Action::where('name', 'Control_Notify_Before_Last_Test_Date')->first();
        $actionId2 = $action2['id'];
        // Get the risk object from the event
        $FrameworkControlTestResult = $event->FrameworkControlTestResult;
        // Eager load the teamsForRisk relationship
        // $risk->load('teamsForRisk');
        // Define the roles array for notification
        $roles = [
            'Control-Owner' => [$FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->control_owner],
            'Control-Tester' => [$FrameworkControlTestResult->FrameworkControlTestAudit->UserTester->id],
        ];
        // dd($roles);

        // Define the link for redirection after clicking the system notification
        $link = ['link' => route('admin.compliance.audit.index')];

        $FrameworkControlTestResult->Summary= $FrameworkControlTestResult->summary ? $FrameworkControlTestResult->summary : null;
        $FrameworkControlTestResult->Test_Date= $FrameworkControlTestResult->test_date ? $FrameworkControlTestResult->test_date : null;
        $FrameworkControlTestResult->Test_Name= $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->name : null;
        $FrameworkControlTestResult->Test_Tester= $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->UserTester->name : null;
        $FrameworkControlTestResult->Test_Result= $FrameworkControlTestResult->testResult ? $FrameworkControlTestResult->testResult->name : null;
        $FrameworkControlTestResult->Control_Owner = $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->owner->name : null;
        $FrameworkControlTestResult->Control_Name = $FrameworkControlTestResult->FrameworkControlTestAudit ? $FrameworkControlTestResult->FrameworkControlTestAudit->FrameworkControl->short_name : null;
        $FrameworkControlTestResult->Submission_Date= $FrameworkControlTestResult->submission_date ? $FrameworkControlTestResult->submission_date : null;
        $FrameworkControlTestResult->Aduit_Status=  $FrameworkControlTestResult->FrameworkControlTestAudit->TestStatus->name ?? null ;

        $riskTestResult = NotifyAtDateModel::where('model_type', 'controlAduit')
        ->where('model_id', $FrameworkControlTestResult->FrameworkControlTestAudit->test_id)
        ->delete();

         // defining the link we want the user to be redirected to after clicking the system notification
         $modelId = $FrameworkControlTestResult->FrameworkControlTestAudit->test_id;
         $proccess = "create";
         $modelType = "controlAduit";
         //   to get number od days
         $NumbersOfDays = DB::table('auto_notifies')
             ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
             ->where('actions.name', 'Control_Notify_Before_Last_Test_Date')
             ->select('auto_notifies.date')
             ->first();
 
         if ($NumbersOfDays) {
             // Decode the JSON string to an array of integers
             $datesArray = json_decode($NumbersOfDays->date, true);
 
             if (is_array($datesArray)) {
                 $DateNotify = $FrameworkControlTestResult->test_date ? $FrameworkControlTestResult->test_date     : null;
                 $nextDateNotify = [];
 
                 foreach ($datesArray as $days) {
                     // Convert days to an integer and subtract from DateNotify
                     $numberOfDaysToSubtract = (int) $days;
 
                     $carbonDate = Carbon::parse($DateNotify);
                     $nextDate = $carbonDate->subDays($numberOfDaysToSubtract);
                     $nextDateNotify[] = $nextDate->format('Y-m-d');
                 }
 
                 // $nextDateNotifyArray now contains the results of subtracting each day from DateNotify.
                 // You can use this array as needed.
             }
         }
 
 
         // defining the link we want the user to be redirected to after clicking the system notification
         $link = ['link' => route('admin.asset_management.index')];
 
         if ($NumbersOfDays == null) {
             $this->sendNotificationForAction($actionId1, $actionId2, $link, $FrameworkControlTestResult, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
         } else if ($NumbersOfDays !== null) {
             $this->sendNotificationForAction($actionId1, $actionId2, $link, $FrameworkControlTestResult, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
         }

    }
}
