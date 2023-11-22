# Control Objective

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/control/objective/objective.png "Figure 1-1")

### Tables
* control_objectives
---
## Inputs
- Control Objective
    * Name
    * Description
---
## Routes
- routes/admin/control-objective.php
---
## Views

- Control Objective

    ![Figure 1-2](/__OOAD/module_notes/control/objective/objective_list.png "Figure 1-2")

    ![Figure 1-3](/__OOAD/module_notes/control/objective/objective_create.png "Figure 1-3")
    ![Figure 1-4](/__OOAD/module_notes/control/objective/objective_edit.png "Figure 1-4")


    [Control Objective Live URL](https://advancedcontrols.sa/grc/public/admin/control-objectives)
---
## Files
- Control Objective
    * app/Http/Controllers/admin/control_objective/ControlObjectiveController.php
    * resources/views/admin/content/control_objective/index.blade.php
    * public/ajax-files/control_objectives/index.js
    * app/View/Components/Admin/Content/ControlObjective/Search.php
    * resources/views/components/admin/content/control-objective/search.blade.php
    * app/View/Components/Admin/Content/ControlObjective/Form.php
    * resources/views/components/admin/content/control-objective/form.blade.php
    * app/Exports/ControlObjectivesExport.php
    * app/Imports/ControlObjectivesImport.php
---
## Requirments
- Control Objective
    > Only the employee who has the authority to take action on the control objective can do that for example (list, view, add, edit, delete, print, export)