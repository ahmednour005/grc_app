# Asset Management

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/asset_management/asset_management.png "Figure 1-1")

### Tables
* assets
* asset_values
* asset_groups
* asset_asset_groups
---
## Inputs
- Asset
    * Asset Name
    * IP Address
    * Asset Value
    * Asset Site/Location
    * Team(s)
    * Tags 
    * Start Date
    * End Date
    * Alert period (days)
    * Asset Details
    * Verified Assets
- Asset Group
    * Name
    * Assets
---
## Routes
- routes/admin/asset-management.php
---
## Views
- Asset

    ![Figure 1-2](/__OOAD/module_notes/asset_management/asset_management_asset_list.png "Figure 1-2")

    ![Figure 1-3](/__OOAD/module_notes/asset_management/asset_management_asset_create.png "Figure 1-3")
    ![Figure 1-4](/__OOAD/module_notes/asset_management/asset_management_asset_edit.png "Figure 1-4")


    [Asset Live URL](https://advancedcontrols.sa/grc/public/admin/asset-management)

- Asset Group

    ![Figure 1-5](/__OOAD/module_notes/asset_management/asset_management_asset_group_list.png "Figure 1-5")

    ![Figure 1-6](/__OOAD/module_notes/asset_management/asset_management_asset_group_create.png "Figure 1-6")
    ![Figure 1-7](/__OOAD/module_notes/asset_management/asset_management_asset_group_edit.png "Figure 1-7")
    
    [Asset Group Live URL](https://advancedcontrols.sa/grc/public/admin/asset-management/asset-group)

---
## Files
- Asset
    * app/Http/Controllers/admin/asset_management/asset/AssetController.php
    * resources/views/admin/content/asset_management/asset/index.blade.php
    * public/ajax-files/asset_management/asset/index.js
    * app/View/Components/Admin/Content/Asset_management/Asset/Search.php
    * resources/views/components/admin/content/asset_management/asset/search.blade.php
    * app/View/Components/Admin/Content/Asset_management/Asset/Form.php
    * resources/views/components/admin/content/asset_management/asset/form.blade.php
    * app/Exports/AssetsExport.php
- Asset Group
    * app/Http/Controllers/admin/asset_management/asset/AssetGroupController.php
    * resources/views/admin/content/asset_management/index.blade.php
    * public/ajax-files/asset_management/asset_group/index.js
    * app/View/Components/Admin/Content/Asset_management/Asset_group/Search.php
    * resources/views/components/admin/content/asset_management/asset_group/search.blade.php
    * app/View/Components/Admin/Content/Asset_management/Asset_group/Form.php
    * resources/views/components/admin/content/asset_management/asset_group/form.blade.php
    * app/Exports/AssetGroupsExport.php
---
## Requirments

- Asset
    > Only the employee who has the authority to take action on the asset can do that for example (add, edit, delete, export)
- Asset Group
    > Only the employee who has the authority to take action on the asset group can do that for example (add, edit, delete, export)
