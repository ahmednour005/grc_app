# Security awareness Management

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/security_awareness/security_awareness.png "Figure 1-1")

### Tables
* security_awarenesses
* security_awareness_exams
* security_awareness_exam_answers
* security_awareness_exam_questions
* security_awareness_notes
* security_awareness_note_files
---
## Inputs
- Security awareness
    * Name
    * CVE
    * Assets
    * Team(s)
    * Severity 
    * Description
    * Recommendation
    * Plan
    * Status
---
## Routes
- routes/admin/security-awareness.php
---
## Views
- Security awareness

    ![Figure 1-1-1](/__OOAD/module_notes/security_awareness/security_awareness_list01.png "Figure 1-1-1")
    ![Figure 1-1-2](/__OOAD/module_notes/security_awareness/security_awareness_list02.png "Figure 1-1-2")

    ![Figure 1-2-1](/__OOAD/module_notes/security_awareness/security_awareness_create01.png "Figure 1-2-1")
    ![Figure 1-2-2](/__OOAD/module_notes/security_awareness/security_awareness_create02.png "Figure 1-2-2")
    ![Figure 1-2-3](/__OOAD/module_notes/security_awareness/security_awareness_create03.png "Figure 1-2-3")


    [Security awareness Live URL](https://advancedcontrols.sa/grc/public/admin/security-awareness)

- Security awareness exam
    ![Figure 1-4](/__OOAD/module_notes/security_awareness/security_awareness_exam_create.png "Figure 1-4")
    ![Figure 1-5](/__OOAD/module_notes/security_awareness/security_awareness_exam_show.png "Figure 1-5")
    ![Figure 1-6](/__OOAD/module_notes/security_awareness/security_awareness_exam_take.png "Figure 1-6")
    ![Figure 1-7-1](/__OOAD/module_notes/security_awareness/security_awareness_exam_result01.png "Figure 1-7-1")
    ![Figure 1-7-2](/__OOAD/module_notes/security_awareness/security_awareness_exam_result02.png "Figure 1-7-2")


---
## Files
- Security awareness
    * app/Http/Controllers/admin/security_awareness/SecurityAwarenessController.php
    * resources/views/admin/content/security_awareness/index.blade.php
    * public/ajax-files/security_awareness/index.js
    * public/ajax-files/security_awareness/app-chat.js
    * public/ajax-files/security_awareness/exam.js
    * app/View/Components/Admin/Content/Security_awareness/Search.php
    * resources/views/components/admin/content/security_awareness/search.blade.php
    * app/View/Components/Admin/Content/Security_awareness/Form.php
    * resources/views/components/admin/content/security_awareness/form.blade.php
    * app/Exports/SecurityAwarenessesExport.php

- Security awareness exam
    * app/Http/Controllers/admin/security_awareness/SecurityAwarenessExamController.php
## Requirments

- Security awareness
    > Only the employee who has the authority to take action on security awareness can do that for example (create, print, export, download)

    > Each security awareness has its separate chat for sharing messages between security awareness members after adding it

    > In creating or updating a security awareness depending on its status validation will be changed
    <br>* Draft
    <br>* In Review => reviewer will be required
    <br>* Approved => privacy and approval_date  will be required

    > In creating security awareness owner statuses 
    <br>* If the creator is an administrator then the owner can be selected and if isn't selected the owner by default will be  the creator
    <br>* If the creator isn't an administrator then the owner by default will be  the creator

    > In listing a security awareness 
    <br>* All security awareness show for `administrator` and its opened or closed is `opened`
    <br>* A security awareness shows for its `owner`
    <br>* A security awareness shows for its `creator` and its opened or closed is `opened`
    <br>* A security awareness shows for all users if its `status` is `Approved` and its `privacy` is `public`
    <br>* A security awareness shows for the reviewer if its `status` is `InReview` and the current user is the reviewer, in additional stakeholders user, or team members
    <br>* A security awareness shows for the reviewer if its `status` is `Approved` and its `privacy` is `private` and the current user is the reviewer, in additional stakeholders user, or team members

    > Security awareness actions
    <br> * Delete: allowed for owner
    <br> * Edit: allowed for owner

- Security awareness exam
    > Security awareness actions
    <br> * Create exam: allowed for owner
    <br> * Show exam: allowed for owner
    <br> * Edit exam: allowed for owner
    <br> * Take exam: allowed for a user isn't the owner, `status` is `Approved`, and this user doesn't take this exam before
    <br> * Show exam result: allowed for a user isn't the owner, and `status` is `Approved`, and this user take this exam before
 
