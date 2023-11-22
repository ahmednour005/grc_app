<?php

namespace App\Listeners;

use App\Events\KpiCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notific;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\User;
use App\Models\Department;

class KpiCreatedListener
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
     * @param  \App\Events\KpiCreated  $event
     * @return void
     */
    public function handle(KpiCreated $event)
    {

        // Get the action ID for Risk_Add
        $action1 = Action::where('name','Kpi_Add')->first();
        $actionId1 = $action1['id'];
        
        // Get the risk object from the event
        $kpi = $event->kpi;
        
        // Define the roles array for notification
        $roles = [
            'manager' => [$kpi->Department->manager->id ?? null],
            'creator'=>[$kpi->created_by_user->id ?? null],
          ];

          
          // Define teams in the desired format for notification message
         
          // Define the link for redirection after clicking the system notification
          $link = ['link' => route('admin.KPI.index')];
      
          // Set the properties of the risk object for notification message
      
          $kpi->Created_by = $kpi->created_by_user ? $kpi->created_by_user->name : null;
          $kpi->Departement_Owner = $kpi->Department->manager ? $kpi->Department->manager->name: null;

          // Call the function to handle different kinds of notifications
          $actionId2 = null;
          $nextDateNotify = null;
          $modelId = null;
          $modelType = null;
          $proccess = null;
          // handling different kinds of notifications using  "sendNotificationForAction" function from "NotificationHandlingTrait"
          $this->sendNotificationForAction($actionId1, $actionId2 = null, $link, $kpi, $roles, $nextDateNotify = null, $modelId = null, $modelType = null, $proccess = null);
    }
}
