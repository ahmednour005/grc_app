<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\Action;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Task;
use App\Models\UserToTeam;

class TaskCreatedListener
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
     * @param  \App\Events\TaskCreated  $event
     * @return void
     */
    public function handle(TaskCreated $event)
    {
        // getting the action id of event
        $action1 = Action::where('name', 'Task_Add')->first();
        $actionId1 = $action1['id'];
        $action2 = Action::where('name', 'Task_Notify_Before_Last_Due_Date')->first();
        $actionId2 = $action2['id'];
        // getting the model of event
        $data = $event->data ?? null;
        $user = $event->user ?? null;
        $team = $event->team ?? null;
        $teamIds = [];
        
        if ($team !== null) {
            $teamIds = UserToTeam::where('team_id', $team->id)->pluck('team_id')->unique()->toArray();
        }
        
        $roles = [
            'Assignee' => [$user->id ?? null],
            'creator' => [$data->created_by_user->id ?? null],
            'Team-teams' => $teamIds ?? null,
        ];
        
        // to get the column in database appear in notification as string not int
        $data->Title = $data->title ?? null;
        $data->Team = $team->name ?? null;
        $data->Start_Date = optional($data->start_date)->format('Y-m-d') ?? null;
        $data->Due_Date = optional($data->due_date)->format('Y-m-d') ?? null;
        $data->Task_Priority = $data->priority ?? null;
        $data->Description = $data->description ?? null;
        $data->Assignee = $user->name ?? null;
        $task = Task::latest()->first();
        $modelId = $task->id;
        $proccess = "create";
        $modelType = "task";
        //   to get number od days
        $NumbersOfDays = DB::table('auto_notifies')
            ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
            ->where('actions.name', 'Task_Notify_Before_Last_Due_Date')
            ->select('auto_notifies.date')
            ->first();

        if ($NumbersOfDays) {
            // Decode the JSON string to an array of integers
            $datesArray = json_decode($NumbersOfDays->date, true);

            if (is_array($datesArray)) {
                $DateNotify = $data->due_date     ? $data->due_date     : null;
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
        $link = ['link' => route('admin.task.assigned_to_me')];
        if ($NumbersOfDays == null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $data, $roles, $nextDateNotify = null, $modelId, $modelType, $proccess);
        } else if ($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2, $link, $data, $roles, $nextDateNotify, $modelId, $modelType, $proccess);
        }
    }
}
