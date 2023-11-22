# Risk Management

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/risk_management/risk_management.png "Figure 1-1")

[Download ERD PDF](/__OOAD/module_notes/risk_management/risk_management.pdf)

### Tables
* categories
* files
* framework_controls
* locations
* mitigations
* projects
* residual_risk_scoring_histories
* risks
* risks_to_assets
* risks_to_asset_groups
* risk_catalogs
* risk_scorings
* risk_scoring_histories
* risk_to_additional_stakeholders
* risk_to_locations
* risk_to_teams
* risk_to_technologies
* sources
* tags
* teams
* technologies
* threat_catalogs
* users
---
## Inputs
- Risk
    * Subject
    * Risk Mapping 
    * Threat Mapping
    * Category
    * Site/Location
    * External Reference ID
    * Control Regulation
    * Control Number
    * Affected Assets
    * Technology
    * Team 
    * Additional Stakeholders
    * Owner
    * Owner's Manager
    * Risk Source
    * Risk Scoring Method
    * Current Likelihood
    * Current Impact
    * Risk Assessment
    * Additional Notes
    * Supporting Documentation
    * Tags
---
## Routes
- routes/admin/risk-management.php
---
## Views
- Risk

    ![Risk listing](/__OOAD/module_notes/risk_management/risk_management_list.png "Risk listing")

    ![Create risk](/__OOAD/module_notes/risk_management/risk_management_create.png "Create risk")
    ![Edit risk](/__OOAD/module_notes/risk_management/risk_management_edit.png "Edit risk")
    ![Create risk mitigation for first time](/__OOAD/module_notes/risk_management/risk_management_mitigation_create.png "Create risk mitigation for first time")
    ![View risk mitigation when risk doesn't have mitigation](/__OOAD/module_notes/risk_management/risk_management_mitigation_view01.png "View risk mitigation when risk doesn't have mitigation")
    ![Edit risk mitigation](/__OOAD/module_notes/risk_management/risk_management_mitigation_edit.png "Edit risk mitigation")
    ![View risk mitigation when risk have mitigation](/__OOAD/module_notes/risk_management/risk_management_mitigation_view02.png "View risk mitigation when risk have mitigation")
    ![View risk review](/__OOAD/module_notes/risk_management/risk_management_review_show.png "View risk review")
    ![Create risk review](/__OOAD/module_notes/risk_management/risk_management_review_create.png "Create risk review")
    ![Change risk status](/__OOAD/module_notes/risk_management/risk_management_change_status.png "Change risk status")
    ![Add risk comment](/__OOAD/module_notes/risk_management/risk_management_add_comment.png "Add risk comment")

    [Risk Live URL](https://advancedcontrols.sa/grc/public/admin/risk-management)

---
## Files
- Risk
    * app/Http/Controllers/admin/risk_management/RiskManagementController.php
    * resources/views/admin/content/risk_management/index.blade.php
    * public/ajax-files/risk_management/index.js
    * resources/views/admin/content/risk_management/show.blade.php
    * public/js/scripts/highcharts.js
    * public/ajax-files/risk_management/edit.js
    * app/View/Components/Admin/Content/RiskManagement/SubmitRisk/Search.php
    * resources/views/components/admin/content/risk-management/submit-risk/search.blade.php
    * app/View/Components/Admin/Content/RiskManagement/SubmitRisk/Form.php
    * resources/views/components/admin/content/risk-management/submit-risk/form.blade.php
    * app/Exports/RisksExport.php

## Requirments

- Risk
    > Only the employee who has the authority to take action on the vulnerability management can do that for example (list, view, create, update, delete, print, export, AbleToCommentRiskManagement, AbleToCloseRisks)

    > Residual risk value = `round($risk['calculated_risk'] * (100 - $risk['mitigation_percent']) / 100, 2);` calculated_risk get from `risk_scorings` and mitigation_percent get from `mitigations`

    > Inherent Risk(Risk value), Residual Risk depends on `risk_levels` founded in (Dashboard/Configuration/Preparatory data) and risk level get from the value of `risk_scorings`

    > `residual_risk_scoring_histories` and `risk_scoring_histories` tables are used to track risk scoring history of the risk and used in the chart

    > `Classic Risk Scoring` depends on (Dashboard/Configuration/Risk Calculate) selected method


