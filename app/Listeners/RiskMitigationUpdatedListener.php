<?php

namespace App\Listeners;

use App\Events\RiskMitigationUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Risk;
use App\Models\Mitigation;

class RiskMitigationUpdatedListener
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
     * @param  \App\Events\RiskMitigationUpdated  $event
     * @return void
     */
    public function handle(RiskMitigationUpdated $event)
    {
         // Get the action ID for Risk_Add
         $action1 = Action::where('name', 'Risk_Mitigation_Update')->first();
         $actionId1 = $action1['id'];
         
         // Get the risk object from the event
         $risk = $event->risk;
         $mitigation = $event->mitigation;


         // Define the roles array for notification
         $roles = [
             'creator' => [$risk->owner_id ?? null],
             'Team-teams' => $risk->teams->pluck('id') ?? null,
             'Stakeholder-teams' => $risk->additionalStakeholders->pluck('user_id') ?? null,
         ];

         
         // Define teams in the desired format for notification message
         $teams = $mitigation->teams;
         $teamsNames = '';
         if (!empty($teams)) {
             foreach ($teams as $team) {
                 $teamsNames .= $team->name . ', ';
             }
             $teamsNames = rtrim($teamsNames, ', ');
             $teamsNames = '(' . $teamsNames . ')';
         }
         // Assign teamsNames to vulnerability "each variable MUST be assigned to model like this to show it in the message properly"
         $mitigation->teams = $teamsNames;

         // Define additional stakeholders in the desired format for notification message
         $additionalStakeholderss = $risk->additionalStakeholders;
         $additionalStakeholdersNames = '';
         if (!empty($additionalStakeholderss)) {
             foreach ($additionalStakeholderss as $additionalStakeholder) {
                 $addational=User::find($additionalStakeholder->user_id);
                 $additionalStakeholdersNames .= $addational->name . ', ';
             }
             $additionalStakeholdersNames = rtrim($additionalStakeholdersNames, ', ');
             $additionalStakeholdersNames = '(' . $additionalStakeholdersNames . ')';
         }
         // Assign additionalStakeholdersNames to vulnerability "each variable MUST be assigned to model like this to show it in the message properly"
         $risk->additionalStakeholders = $additionalStakeholdersNames;
 
         $id = $risk->id;
         // Define the link for redirection after clicking the system notification
         $link = ['link' => route('admin.risk_management.show', ['id' => $id])];
     
        // Set the properties of the risk object for notification message
        $risk->Additional_Stakeholder = $additionalStakeholdersNames;
        $risk->Owner = $risk->owner ? $risk->owner->name : null;
        $risk->Team = $teamsNames ?? null;

        $mitigation->planning_strategy=$mitigation->planningStrategies ? $mitigation->planningStrategies->name : null;
        $mitigation->mitigation_effort=$mitigation->mitigationEfforts ? $mitigation->mitigationEfforts->name : null;
        $risk->Plan=$mitigation->planningStrategies ? $mitigation->planningStrategies->name : null;
        $risk->Effort=$mitigation->mitigationEfforts ? $mitigation->mitigationEfforts->name : null;

        $risk->Current_Solution=$mitigation->current_solution ? $mitigation->current_solution : null;
        $risk->Mitigation_Coast=$mitigation->mitigation_cost ? $mitigation->mitigation_cost : null;
   
         // Call the function to handle different kinds of notifications
          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $risk, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);         }
}
