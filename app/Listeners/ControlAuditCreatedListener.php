<?php

namespace App\Listeners;

use App\Events\ControlAuditCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Framework;
use App\Models\FrameworkControlTestAudit;
use App\Models\FrameworkControlTest;
use App\Models\FrameworkControl;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControlAuditCreatedListener
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
     * @param  \App\Events\ControlAuditCreated  $event
     * @return void
     */
    public function handle(ControlAuditCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name', 'Audit_Add')->first();
        $actionId1 = $action1['id'];
        // Get the risk object from the event
        $audit = $event->audit;
        $frameworkControl = $event->frameworkControl;
        // dd($audit);
        // // dd($frameworkControl);

        // Define the roles array for notification
        $roles = [
            'Control-Owner' => [$frameworkControl->control_owner ?? null],
            'Control-Tester' => [$audit->UserTester->id ?? null],
        ];

        $link = ['link' => route('admin.governance.control.list')];

        // Set the properties of the risk object for notification message

        //   $control->control_owner=$control->owners ? $control->owners->name : null;

        $frameworkControl->Control_Owner = $frameworkControl->User ? $frameworkControl->User->name : null;
        $frameworkControl->Desired_Maturity = $frameworkControl->ControlDesiredMaturity ? $frameworkControl->ControlDesiredMaturity->name : null;
        $frameworkControl->Control_Priority = $frameworkControl->priority ? $frameworkControl->priority->name : null;
        $frameworkControl->Control_class = $frameworkControl->class ? $frameworkControl->class->name : null;
        $frameworkControl->Control_Maturity = $frameworkControl->ControlMaturity ? $frameworkControl->ControlMaturity->name : null;

        $frameworkControl->Control_Phase = $frameworkControl->ControlPhase ? $frameworkControl->ControlPhase->name : null;
        $frameworkControl->Control_Type = $frameworkControl->type ? $frameworkControl->type->name : null;
        $frameworkControl->Tester = $audit->UserTester ? $audit->UserTester->name : null;
        $frameworkControl->Test_Frequency = $audit->test_frequency ? $audit->test_frequency : null;
        $frameworkControl->Test_Name = $audit->name ? $audit->name : null;
        $frameworkControl->Test_Steps = $audit->test_steps ? $audit->test_steps : null;
        $frameworkControl->Approximate_Time = $audit->approximate_time ? $audit->approximate_time : null;
        $frameworkControl->Expected_Results = $audit->expected_results ? $audit->expected_results : null;
        $frameworkControl->Next_Date = $audit->next_date ? $audit->next_date : null;

            // defining the link we want the user to be redirected to after clicking the system notification
        $link = ['link' => route('admin.asset_management.index')];

        $actionId2=null;
        $nextDateNotify = null;
        $modelId=null;
        $modelType=null;
        $proccess=null;
        $this->sendNotificationForAction($actionId1, $actionId2=null,$link, $frameworkControl, $roles, $nextDateNotify = null, $modelId=null, $modelType=null,$proccess=null);

    }
}
