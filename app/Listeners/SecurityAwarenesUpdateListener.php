<?php

namespace App\Listeners;

use App\Events\SecurityAwarenesUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Action;
use App\Http\Traits\NotificationHandlingTrait;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SecurityAwarenesUpdateListener
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

    /**SecurityAwarenesUpdate
     * Handle the event.
     *
     * @param  \App\Events\SecurityAwarenesUpdate  $event
     * @return void
     */
    public function handle(SecurityAwarenesUpdate $event)
    {
        $action1 = Action::where('name', 'securityAwareness_update')->first();
        $actionId1 = $action1['id'];
        $action2 = Action::where('name', 'Security_Awareness_Notify_Before_Last_Review_Date')->first();
        $actionId2 = $action2['id'];
        $securityAwareness = $event->securityAwareness;
        // dd( $securityAwareness);
        $Teams = $securityAwareness->team_ids ? explode(',', $securityAwareness->team_ids) : [];
        $teams2 = [];
        $teamsNames = '';
        foreach ($Teams as $teamId) {
            array_push($teams2, $teamId);
            $team = Team::find($teamId);
            $teamsNames .= $team->name . ', ';
        }
        $teamsNames = rtrim($teamsNames, ', ');
        $teamsNames = '(' . $teamsNames . ')';

        // stakeholder
        $stakeholder = $securityAwareness->additional_stakeholders ? explode(',', $securityAwareness->additional_stakeholders) : [];
        $stakeholders2 = [];
        $stakeholdersNames = '';
        foreach ($stakeholder as $stake) {
            array_push($stakeholders2, $stake);
            $stakehold = User::find($stake);
            $stakeholdersNames .= $stakehold->name . ', ';
        }
        $stakeholdersNames = rtrim($stakeholdersNames, ', ');
        $stakeholdersNames = '(' . $stakeholdersNames . ')';

        // reviewer
        $reviewer= explode(',', $securityAwareness->reviewer);
        $reviewer2=[];
        $reviewersNames='';

        foreach($reviewer as $review){
            array_push($reviewer2 , $review );

            $reviewer_person=User::find($stake);

            $reviewersNames.= $reviewer_person->name . ', ';

          }
          $reviewersNames= rtrim($reviewersNames, ', ');
          $reviewersNames = '(' . $reviewersNames . ')';


        // roles
        $roles = [
            'creator' => [$securityAwareness->created_by ?? null],
            'Team-teams' => $teams2 ?? null,
            'Stakeholder-teams' => $stakeholders2 ?? null,
            'reviewers-teams'=>$reviewer2 ?? null,
        ];


        $securityAwareness->Description=$securityAwareness->description ?? null;
        $securityAwareness->Title=$securityAwareness->title ?? null ;
        $securityAwareness->Status=$securityAwareness->securityAwarenessStatus->name ?? null;
        $securityAwareness->Created_By=$securityAwareness->created_by_user->name ?? null;
        $securityAwareness->Teams = $teamsNames ?? null;
        $securityAwareness->Additional_Stakeholders = $stakeholdersNames ?? null;
        $securityAwareness->Reviewer = $reviewersNames ?? null;

        $modelId = $securityAwareness->id;
        $proccess = "update";
            $modelType = "securityAwareness";
            //   to get number od days
            $NumbersOfDays = DB::table('auto_notifies')
                ->join('actions', 'auto_notifies.action_id', '=', 'actions.id')
                ->where('actions.name', 'Security_Awareness_Notify_Before_Last_Review_Date')
                ->select('auto_notifies.date')
                ->first();

                if ($NumbersOfDays) {
                    // Decode the JSON string to an array of integers
                    $datesArray = json_decode($NumbersOfDays->date, true);

                    if (is_array($datesArray)) {
                        $DateNotify = $securityAwareness->next_review_date	 ? $securityAwareness->next_review_date	 : null;
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


        $link = ['link' => route('admin.security_awareness.index')];
        // handling different kinds of notifications using the "sendNotificationForAction" function from the "NotificationHandlingTrait"
        if ($NumbersOfDays == null) {
            $this->sendNotificationForAction($actionId1, $actionId2,$link, $securityAwareness, $roles, $nextDateNotify = null, $modelId, $modelType,$proccess);
        } else if($NumbersOfDays !== null) {
            $this->sendNotificationForAction($actionId1, $actionId2,$link, $securityAwareness, $roles, $nextDateNotify , $modelId, $modelType,$proccess);
        }
    }
}
