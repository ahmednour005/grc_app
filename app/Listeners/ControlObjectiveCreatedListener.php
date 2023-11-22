<?php

namespace App\Listeners;

use App\Events\ControlObjectiveCreated;
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
use App\Models\ControlControlObjective;


class ControlObjectiveCreatedListener
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
     * @param  \App\Events\ControlObjectiveCreated  $event
     * @return void
     */
    public function handle(ControlObjectiveCreated $event)
    {
        
              // Get the action ID for Risk_Add
              $action1 = Action::where('name','Objective_Add')->first();
              $actionId1 = $action1['id'];
              
              // Get the risk object from the event
              $ControlControlObjective = $event->ControlControlObjective;
              $control = $event->control;
            
              // Define the roles array for notification

              $roles = [
                  'Control-Owner' => [$control->control_owner ?? null],
                  'Responsible_Person' => [$ControlControlObjective->responsible->id ?? null],
                  'Control-Tester' => [$control->FrameworkControlTest->UserTester->id ?? null]
              ];
           
              $link = ['link' => route('admin.governance.control.list')];

              // Set the properties of the risk object for notification message
              
            //   $control->control_owner=$control->owners ? $control->owners->name : null;

            $control->Control_Owner =$control->User ? $control->User->name : null;
            $control->Control_Name =$control->short_name ? $control->short_name : null;
            $control->Control_Description =$control->description ? $control->description : null;
            $control->Objective =$ControlControlObjective->objective ? $ControlControlObjective->objective->name : null;
            $control->Responsible =$ControlControlObjective->responsible ? $ControlControlObjective->responsible->name : null;


          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $control, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
