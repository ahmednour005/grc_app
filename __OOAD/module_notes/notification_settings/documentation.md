### Here are the steps required to implement notification settings in your module: 
1. you will need to put a button in your view that will go to notification settings page, like this: 

![Figure 1-1](/__OOAD/module_notes/notification_settings/notificationSettingsButton.png "Figure 1-1")
```
<a href="{{ route('admin.vulnerability_management.notificationsSettings') }}" class="dt-button btn btn-primary me-2"
    target="_self">
    {{ __('locale.NotificationsSettings') }}
</a>
```
2. this button will redirect to a route in the route file of your module like this:
```
        Route::get('/notifications-settings', [VulnerabilityManagementController::class, 'notificationsSettings'])->name('notificationsSettings');

```
- "this piece of code exists in file 'routes/admin/vulnerability-management'"
- note that this route goes to function 'notificationSettings' in 'VulnerabilityManagementController'
3. you will create a function 'notificationSettings' in your module like this:

```
 public function notificationsSettings()
    {

        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => route('admin.vulnerability_management.index'), 'name' => __('locale.VulnerabilityManagement')], ['name' => __('locale.NotificationsSettings')]];
        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [1, 2, 3];   // defining ids of actions modules
        
        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            1 => ['name', 'cve', 'description', 'severity', 'recommendation', 'plan', 'status', 'teams', 'assets'],
            2 => ['name', 'cve', 'description', 'severity', 'status'],
            3 => ['name', 'teams', 'assets'],
        ];
                // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            1 => ['creator' => __('locale.VulnerabilityCreator'), 'Team-teams' => __('locale.TeamsOfVulnerability')],
            2 => ['creator' => __('locale.VulnerabilityCreator'), 'Team-teams' => __('locale.TeamsOfVulnerability')],
            // 3 => ['creator' => __('locale.VulnerabilityCreator'), 'Team-teams' => __('locale.TeamsOfVulnerability')],
        ];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles'));
    }
```

4. before understanding what is in this function , you will need to go to file 'ActionSeeder.php' and add events that may have notifications in your module like this: 
```
  Action::insert([
            ['id' => 1, 'name' => 'vulnerability_add'],
            ['id' => 2, 'name' => 'vulnerability_update'],
            ['id' => 3, 'name' => 'vulnerability_delete'],
        ]);
```
- define a unique id and name for each action and then run the seeder
5. Now lets retun to our 'notificationSettings' function in our module 

6. first part of function you will need to define links in breadcrumb like this:
```
// defining the breadcrumbs that will be shown in page
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => route('admin.vulnerability_management.index'), 'name' => __('locale.VulnerabilityManagement')], ['name' => __('locale.NotificationsSettings')]];
```
7. then you will define list of users that may recieve notifications like this:

```
 $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
```

8. now you will make an array of module Actions ids that you added in the seeder like this: 

```
$moduleActionsIds = [1, 2, 3];   // defining ids of actions modules
```

9. now you will need to define variables that may be attached to each event, so that user can put them in his message , define them in an array and each events actions will be and inner array with key equal to the id of action like this: 
```
     $actionsVariables = [
            1 => ['name', 'cve', 'description', 'severity', 'recommendation', 'plan', 'status', 'teams', 'assets'],
            2 => ['name', 'cve', 'description', 'severity', 'status'],
            3 => ['name', 'teams', 'assets'],
        ];
```
10. now you will need to define roles that may be attached to each event, so that user can choose them to send notification to, define them in an array and each events actions will be and inner array with key equal to the id of action like this: 
```
     $actionsRoles = [
            1 => ['creator' => __('locale.VulnerabilityCreator'), 'Team-teams' => __('locale.TeamsOfVulnerability')],
            2 => ['creator' => __('locale.VulnerabilityCreator'), 'Team-teams' => __('locale.TeamsOfVulnerability')],
            // 3 => ['creator' => __('locale.VulnerabilityCreator'), 'Team-teams' => __('locale.TeamsOfVulnerability')],
        ];
```
- note: if the role is a team its name MUST start with 'Team-' like this 'Team-teams' 

11. put the rest of function as it is like this: 
```
// getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles'))
```

11. after you have finished that , you will need to make an event and listener for each of the events of your module like this like this:
- in your terminal write those commands for each event:
```
php artisan make:event VulnerabilityCreated
```
```
php artisan make:listener VulnerabilityCreatedListener --event=VulnerabilityCreated
```

12. you then will need to register you event and listener in event service provider, you will add them to 'listen' function like this:
```
 VulnerabilityUpdated::class => [
            VulnerabilityUpdatedListener::class,
        ],
```
