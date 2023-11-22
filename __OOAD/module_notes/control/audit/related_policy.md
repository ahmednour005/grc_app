# Related policy

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/control/audit/related_policy.png "Figure 1-1")

### Tables
* control_audit_policies
* documents
* framework_control_test_audits

---
## Routes
- routes/admin/compliance.php
```php
Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `ajax` group routes
                'middleware' => [], // Middlewares applied on all `ajax` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::patch('take-audit-policy-action', [AuditCompliancePolicyController::class, 'takeAuditPolicyAction'])->name('take_audit_policy_action');
                Route::post('/download-file', [AuditCompliancePolicyController::class, 'downloadFile'])->name('download_file');
            }
        );
```
---
## Views
- Related policy

    ![Related policy list](/__OOAD/module_notes/control/audit/related_policy_list.png "Related policy list")

## Path
- Dashboard/Compliance/Active Audits

---
## Files
- Related policy
    * resources/views/admin/content/compliance/active-audit/related-policy.blade.php

## Requirments

- Related policy
    > If the document is assigned to control then the active audit `Test Result` values will be available as that
    <br> * All policies are approved then all statuses are available ( `Not Applicable`, `Not Implemented`, `Partially Implemented`, `Implemented` )
    <br> * All policies are rejected then all statuses are available ( `Not Applicable`, `Not Implemented` )
    <br> * some policies are approved and the others rejected then all statuses are available ( `Not Applicable`, `Not Implemented`, `Partially Implemented` )
    <br> * All policies status don't set then all statuses are available ( `Not Applicable` )
