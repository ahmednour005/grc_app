# Task

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/task/task.png "Figure 1-1")

### Tables
* tasks
* file_tasks
* task_notes
* task_note_files
* users
---
## Inputs
- Task
    * Task title
    * Assignee type (Employee, Team)
    * Assignee
    * Start Date
    * Due Date
    * Task priority
    * Description
    * Supporting Documentation
    * Task status (Accepted, Closed)

- Task assigned to me
    * Task status (In Progress, Completed)
---
## Routes
- routes/admin/task.php
---
## Views
- Task

    ![Task list](/__OOAD/module_notes/task/task_list.png "Task list")

    ![Task create](/__OOAD/module_notes/task/task_create.png "Task create")
    ![Task edit](/__OOAD/module_notes/task/task_edit.png "Task edit")

    [Task Live URL](https://advancedcontrols.sa/grc/public/admin/task)

- Task assigned to me

    ![Task list](/__OOAD/module_notes/task/task_assigned_to_me_list.png "Task list")

    ![Task edit](/__OOAD/module_notes/task/task_assigned_to_me_edit.png "Task edit")

    [My Task Live URL](https://advancedcontrols.sa/grc/public/admin/task/assigned-to-me)
---
## Files
- Task
    * app/Http/Controllers/admin/task/TaskController.php
    * resources/views/admin/content/task/index.blade.php
    * resources/views/admin/content/task/calendar.blade.php
    * public/ajax-files/task/app-todo.js
    * public/ajax-files/task/app-chat.js
    * public/ajax-files/task/app-calendar.js
    * public/ajax-files/task/app-calendar-events.js

    * public/ajax-files/task/index.js
    * app/View/Components/Admin/Content/task/Search.php
    * resources/views/components/admin/content/task/search.blade.php
    * app/View/Components/Admin/Content/task/Form.php
    * resources/views/components/admin/content/task/form.blade.php
    * app/Exports/VulnerabilitiesExport.php

## Requirments

- Task
    > Only the employee who has the authority to take action on the task can do that for example (list, create, export)

    > By default task status after creating is `Open`

    > Show task created by the currently logged user

    > Available users to assign the task are users in the same teams and users in the same department or the child departments

    > Creator can update status to `Accepted` or `Closed`

- Task assigned to me
    > Show task that assignable is currently logged user

    > Assignee can update status to `In Progress` or `Completed`