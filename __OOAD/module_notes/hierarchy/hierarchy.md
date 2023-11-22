# Hierarchy

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/hierarchy/hierarchy.png "Figure 1-1")

### Tables
* users
* jobs
* departments
* department_colors
* change_requests
* KPIs
* kpi_assessments
---
## Inputs
- Job
    * Name
    * Code
    * Description
- Department
    * Name
    * Code
    * Department color
    * Manager
    * Parent department
    * Required number of employees
    * Vision
    * Message
    * Mission
    * Objectives
    * Responsibilities
- KPI
    * Title
    * Description
    * Department
    * Type (Time/Percentage/Number)
    * Value
    * Period (3/6/9/12) Months
- Change Request
    * Title
    * Description
    * File
---
## Routes
- routes/admin/hierarchy.php
- routes/admin/KPI.php
- routes/admin/change-request.php
---
## Views
- Hierarchy

    ![Figure 1-1-1](/__OOAD/module_notes/hierarchy/hierarchy01.png "Figure 1-1-1")

    [Hierarchy Live URL](https://advancedcontrols.sa/grc/public/admin/hierarchy)

    ![Figure 1-1-2](/__OOAD/module_notes/hierarchy/hierarchy02.png "Figure 1-1-2")

    [Organization Chart Live URL](https://advancedcontrols.sa/grc/public/admin/hierarchy/org-chart)

- Job

    ![Figure 1-2](/__OOAD/module_notes/hierarchy/hierarchy_job_list.png "Figure 1-2")

    ![Figure 1-3](/__OOAD/module_notes/hierarchy/hierarchy_job_create.png "Figure 1-3")
    ![Figure 1-4](/__OOAD/module_notes/hierarchy/hierarchy_job_edit.png "Figure 1-4")


    [Job Live URL](https://advancedcontrols.sa/grc/public/admin/hierarchy/job)

- Department

    ![Figure 1-2](/__OOAD/module_notes/hierarchy/hierarchy_department_list.png "Figure 1-2")

    ![Figure 1-3](/__OOAD/module_notes/hierarchy/hierarchy_department_create.png "Figure 1-3")
    ![Figure 1-4](/__OOAD/module_notes/hierarchy/hierarchy_department_edit.png "Figure 1-4")

    
    [Department Live URL](https://advancedcontrols.sa/grc/public/admin/hierarchy/department)

- KPI

    ![Figure 2-1](/__OOAD/module_notes/hierarchy/KPI_list.png "Figure 2-1")
    
    ![Figure 2-2](/__OOAD/module_notes/hierarchy/KPI_create.png "Figure 2-2")
    ![Figure 2-3](/__OOAD/module_notes/hierarchy/KPI_edit.png "Figure 2-3")

    ![Figure 2-4](/__OOAD/module_notes/hierarchy/KPI_assessment_list.png "Figure 2-4")

    ![Figure 2-5](/__OOAD/module_notes/hierarchy/KPI_assessment_set.png "Figure 2-5")

    
    [KPI Live URL](https://advancedcontrols.sa/grc/public/admin/KPI)

- Change Request

    ![Figure 3-1](/__OOAD/module_notes/hierarchy/change_request_list.png "Figure 3-1")
    
    ![Figure 3-2](/__OOAD/module_notes/hierarchy/change_request_create.png "Figure 3-2")
    ![Figure 3-3](/__OOAD/module_notes/hierarchy/change_request_edit.png "Figure 3-3")

    ![Figure 3-4](/__OOAD/module_notes/hierarchy/change_request_list02.png "Figure 3-4")

    ![Figure 3-5](/__OOAD/module_notes/hierarchy/change_request_status.png "Figure 3-5")

    ![Figure 3-6](/__OOAD/module_notes/hierarchy/change_request_list03.png "Figure 3-6")

    ![Figure 3-7](/__OOAD/module_notes/hierarchy/change_request_list04.png "Figure 3-7")

    
    [Change requests Live URL](https://advancedcontrols.sa/grc/public/admin/change-request)

---
## Files
- Hierarchy
    * app/Http/Controllers/admin/hierarchy/HierarchyController.php
    * resources/views/admin/content/hierarchy/index.blade.php
    * public/vendors/js/extensions/jstree.min.js
    * resources/views/admin/content/hierarchy/org_chart.blade.php
    * public/js/scripts/orgchart.js
- Job
    * app/Http/Controllers/admin/hierarchy/JobController.php
    * resources/views/admin/content/hierarchy/job/index.blade.php
    * public/ajax-files/hierarchy/job/index.js
    * app/View/Components/Admin/Content/Hierarchy/Job/Search.php
    * resources/views/components/admin/content/hierarchy/job/search.blade.php
    * app/View/Components/Admin/Content/Hierarchy/Job/Form.php
    * resources/views/components/admin/content/hierarchy/job/form.blade.php
    * app/Exports/JobsExport.php
    * app/Imports/JobsImport.php

- Department
    * app/Http/Controllers/admin/hierarchy/DepartmentController.php
    * resources/views/admin/content/hierarchy/department/index.blade.php
    * public/ajax-files/hierarchy/department/index.js
    * app/View/Components/Admin/Content/Hierarchy/Department/Search.php
    * resources/views/components/admin/content/hierarchy/department/search.blade.php
    * app/View/Components/Admin/Content/Hierarchy/Department/Form.php
    * resources/views/components/admin/content/hierarchy/department/form.blade.php
    * app/Exports/DepartmentsExport.php
- KPI
    * app/Http/Controllers/admin/KPI/KPIController.php
    * resources/views/admin/content/KPI/index.blade.php
    * public/ajax-files/KPI/index.js
    * app/View/Components/Admin/Content/KPI/Search.php
    * resources/views/components/admin/content/KPI/search.blade.php
    * app/View/Components/Admin/Content/KPI/Form.php
    * resources/views/components/admin/content/KPI/form.blade.php
    * app/Exports/KPIsExport.php

- Change Request
    * app/Http/Controllers/admin/change_request/ChangeRequestController.php
    * resources/views/admin/content/change_request/index.blade.php
    * public/ajax-files/change_request/index.js
    * app/View/Components/Admin/Content/Change_request/Search.php
    * resources/views/components/admin/content/change_request/search.blade.php
    * app/View/Components/Admin/Content/Change_request/Form.php
    * resources/views/components/admin/content/change_request/form.blade.php
    * app/Exports/ChangeRequestsExport.php
---
## Requirments

- Hierarchy
    > `Hierarchy` Draw the hierarchy of the organization with jstree javascript with drag and drop for employees and departments to change or move parent department or employee department

    > Only the employee who has the authority to take action on the hierarchy can do that for example (view, update)

    > `Organization Chart` Draw the hierarchy of the organization with orgchart javascript

    > Only the employee who has the authority to take action on the organization chart can do that for example (view)

- Job
    > Only the employee who has the authority to take action on the job can do that for example (list, view, add, edit, delete, export)
- Department
    > Only the employee who has the authority to take action on the department can do that for example (list, view, add, edit, delete, export)
- KPI
    > Only the employee who has the authority to take action on the key performance indicators (KPI) can do that for example (list, add, edit, delete, initiate assessment, export)

    > Only the department manager can set an initiated assessment for any KPI belonging to his/her departments
- Change Request
    > Change request responsible department must be set to allow a user to create a change request and the employee belongs to a department

    > Change request created from any user and continue in the approval cycle

    > Change request approval cycle depending on the creator of it, if the creator is a `normal employee (isn't manager)` then the cycle action will be taken by `employee's department manager` then if the department manager approves it the next cycle will be taken by the `change requests responsible department` else if the creator is a `department manager` then the cycle action will be taken by `change requests responsible department`

    > If the action is `approved` the request will continue to the next step else if the action is `rejected` the request will be stopped