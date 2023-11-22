# Service description

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/service_description/service_description.png "Figure 1-1")

### Tables
* service_descriptions
---
## Inputs
- Service description
    * Description
---
## Routes
- routes/admin/configure.php
---
## Views
- Service description

    ![Figure 1-2](/__OOAD/module_notes/service_description/service_description_list.png "Figure 1-2")

    [Service description Live URL](https://advancedcontrols.sa/grc/public/admin/configure/service-description/edit)

---
## Files
- Service description
    * app/Http/Controllers/admin/configure/ServiceDescriptionController.php
    * resources/views/admin/content/configure/service_description/edit.blade.php

## Requirments

- Service description
    > Only the employee who has the authority to take action on the service description can do that for example (update)

    > Service description depends on registered routes (index route for each feature in the system) and gets its description

    > If the Service description value isn't empty circle question icon will be shown before the service name in the breadcrumb
