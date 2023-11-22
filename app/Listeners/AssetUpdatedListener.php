<?php

namespace App\Listeners;

use App\Events\AssetUpdated;
use App\Http\Traits\NotificationTeamTrait;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssetUpdatedListener
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
     * @param  \App\Events\AssetUpdated  $event
     * @return void
     */
    public function handle(AssetUpdated $event)
    {
       
              // getting the action id of event
      $action1 = Action::where('name', 'Asset_Update')->first();
      $actionId1 = $action1['id'];
      // getting the model of event
      $action2 = Action::where('name', 'Asset_Notify_Before_Last_End_Date')->first();
      $actionId2 = $action2['id'];
      $asset = $event->asset;

      $Teams =$asset->teams;
      $teams2 = [];
      $teamsNames = '';
      if (!empty($asset->teams)) {
          foreach ($Teams as $teamId) {
              array_push($teams2, $teamId);
              $team = Team::find($teamId);
              if ($team) {
                  $teamsNames .= $team->name . ', ';
              }
          }
          $teamsNames = rtrim($teamsNames, ', ');
          $teamsNames = '(' . $teamsNames . ')';
      }
      
      $roles = [
          'Team-teams' => $teams2 ?? null,
      ];
       // to get the column in database appear in notification as string not int
       $asset->Name = $asset->name ?? null;
       $asset->Details = $asset->details ?? null;
       $asset->Start_Date = $asset->start_date ?? null;
       $asset->Expiration_Date = $asset->Expiration_Date ?? null;
       $asset->Alert_Period = $asset->alert_period ?? null;
       $asset->Ip = $asset->ip ?? null;
       $asset->Location = $asset->location->name ?? null;
       $asset->Asset_Value_Min = $asset->assetValue->min_value ?? null;
       $asset->Asset_Value_Max = $asset->assetValue->max_value ?? null;
       $asset->Team = $teamsNames ?? null;
       $modelId = $asset->id;
       $proccess = "update";
       $modelType = "asset";
       //   to get number od days
       $NumbersOfDays = DB::table('auto_notifies')
           ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
           ->where('actions.name', 'Asset_Notify_Before_Last_End_Date')
           ->select('auto_notifies.date')
           ->first();

       if ($NumbersOfDays) {
           // Decode the JSON string to an array of integers
           $datesArray = json_decode($NumbersOfDays->date, true);

           if (is_array($datesArray)) {
               $DateNotify = $asset->expiration_date     ? $asset->expiration_date     : null;
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
           $this->sendNotificationForAction($actionId1, $actionId2, $link, $asset, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
       } else if ($NumbersOfDays !== null) {
           $this->sendNotificationForAction($actionId1, $actionId2, $link, $asset, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
       }
    }
}
