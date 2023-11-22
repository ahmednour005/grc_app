<?php

namespace App\Providers;

use App\Models\Review;
use App\Models\Risk;
use App\Observers\ReviewObserver;
use App\Observers\RiskObserver;
use App\Observers\TaskObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\DepartmentCreated;
use App\Events\DepartmentUpdated;
use App\Events\DepartementDeleted;
use App\Events\initiateAssessmentCreated;
use App\Listeners\initiateAssessmentCreatedListener;
use App\Listeners\DepartementUpdatedListener;
use App\Listeners\DepartementDeletedListener;
use App\Listeners\DepartmentCreatedListener;
use App\Events\ControlCreated;
use App\Events\ControlUpdated;
use App\Events\ControlDeleted;
use App\Events\ControlObjectiveCreated;
use App\Listeners\ControlCreatedListener;
use App\Listeners\ControlUpdatedListener;
use App\Listeners\ControlDeletedListener;
use App\Listeners\ControlObjectiveCreatedListener;
use App\Events\AssetCreated;
use App\Events\AssetUpdated;
use App\Events\AssetDeleted;
use App\Events\AssetsGroupCreated;
use App\Events\AssetGroupUpdated;
use App\Events\AssetGroupDeleted;
use App\Events\CateogryCreated;
use App\Events\CateogryUpdated;
use App\Events\CateogryDeleted;
use App\Events\QuestionnaireCreated;
use App\Events\QuestionnaireUpdated;
use App\Events\QuestionnaireDeleted;
use App\Listeners\QuestionnaireCreatedListener;
use App\Listeners\QuestionnaireUpdatedListener;
use App\Listeners\QuestionnaireDeletedListener;
use App\Listeners\CateogryCreatedListener;
use App\Listeners\CateogryUpdatedListener;
use App\Listeners\CateogryDeletedListener;
use App\Listeners\AssetsGroupCreatedListener;
use App\Listeners\AssetGroupUpdatedListener;
use App\Listeners\AssetGroupDeletedListener;
use App\Listeners\AssetCreatedListener;
use App\Listeners\AssetUpdatedListener;
use App\Listeners\AssetDeletedListener;
use App\Listeners\RiskUpdatedListener;
use App\Events\AuditCreated;
use App\Listeners\AuditCreatedListener;
use App\Listeners\ObjectiveAchievementListener;
use App\Events\ObjectiveAchievement;
use App\Events\MgmtreviewCreated;
use App\Events\RiskReopen;
use App\Listeners\MgmtreviewCreatedListener;
use App\Events\mitigationTeamCreated;
use App\Listeners\mitigationTeamCreatedCreatedListener;
use App\Events\RiskCreated;
use App\Listeners\RiskCreatedListener;
use App\Listeners\RiskMitigationCreatedListener;
use App\Events\RiskTeamCreated;
use App\Events\RiskResetMitigation;
use App\Events\RiskMitigationUpdated;
use App\Events\VulnerabilityCreated;
use App\Events\VulnerabilityUpdated;
use App\Events\VulnerabilityDeleted;
use App\Listeners\VulnerabilityCreatedListener;
use App\Listeners\VulnerabilityUpdatedListener;
use App\Listeners\VulnerabilityDeletedListener;
use App\Listeners\RiskResetMitigationListener;
use App\Listeners\RiskMitigationUpdatedListener;
use App\Listeners\RiskReopenListener;
use App\Listeners\RiskDeleteListener;
use App\Models\Document;
use App\Models\SecurityAwareness;
use App\Models\Task;
use App\Observers\DocumentObserver;
use App\Observers\SecurityAwarenessObserver;
use App\Models\AwarenessSurvey;
use App\Events\FrameworkCreated;
use App\Events\FrameworkUpdated;
use App\Events\FrameworkDeleted;
use App\Events\SurveyCreated;
use App\Events\RiskResetReviews;
use App\Events\JobCreated;
use App\Events\JobUpdated;
use App\Events\JobDeleted;
use App\Events\KpiCreated;
use App\Events\KpiUpdated;
use App\Events\KpiDeleted;
use App\Events\ControlEvidenceCreated;
use App\Events\ControlEvidenceUpdated;
use App\Events\ControlAuditCreated;
use App\Events\AuditRiskCreated;
use App\Events\DocumentCreated;
use App\Events\DocumentUpdated;
use App\Events\DocumentDeleted;
use App\Listeners\DocumentCreatedListener;
use App\Listeners\DocumentUpdatedListener;
use App\Listeners\DocumentDeletedListener;
use App\Listeners\AuditRiskListener;
use App\Listeners\ControlAuditCreatedListener;
use App\Listeners\ControlEvidenceCreatedListener;
use App\Listeners\ControlEvidenceUpdatedListener;
use App\Listeners\KpiCreatedListener;
use App\Listeners\FrameworkCreatedListener;
use App\Listeners\FrameworkUpdatedListener;
use App\Listeners\FrameworkDeletedListener;
use App\Listeners\KpiUpdatedListener;
use App\Listeners\KpiDeletedListener;
use App\Listeners\JobCreatedListener;
use App\Listeners\JobUpdatedListener;
use App\Listeners\JobDeletedListener;
use App\Listeners\RiskResetReviewsListener;
use App\Listeners\SurveyCreatedListener;
use App\Listeners\RiskStatusListener;
use App\Listeners\RiskUpdateSubjectListener;
use App\Listeners\RiskCloseListener;
use App\Events\SurveyUpdated;
use App\Events\SurveyDeleted;
use App\Events\AuditCommentCreated;
use App\Events\ControlObjectivesMainCreated;
use App\Events\ControlObjectivesMainUpdated;
use App\Events\ControlObjectivesMainDeleted;
use App\Events\AuditResultCreated;
use App\Events\AduitPolicyCreated;
use App\Events\AssessmentCreated;
use App\Events\AssessmentUpdated;
use App\Events\AssessmentDeleted;
use App\Events\QuestionCreated;
use App\Events\QuestionUpdated;
use App\Events\QuestionDeleted;
use App\Events\DepartementMovingToAnother;
use App\Events\DepartementMovingEmployee;
use App\Events\EmployeeChangeStatus;
use App\Listeners\DepartementMovingEmployeeListener;
use App\Listeners\DepartementMovingToAnotherListener;
use App\Listeners\AduitPolicyCreatedListener;
use App\Listeners\QuestionCreatedListener;
use App\Listeners\QuestionUpdatedListener;
use App\Listeners\QuestionDeletedListener;
use App\Listeners\AssessmentCreatedListener;
use App\Listeners\AssessmentUpdatedListener;
use App\Listeners\AssessmentDeletedListener;
use App\Listeners\AuditCommentCreatedListener;
use App\Listeners\AuditResultCreatedListener;
use App\Listeners\ControlObjectivesMainCreatedListener;
use App\Listeners\ControlObjectivesMainUpdatedListener;
use App\Listeners\ControlObjectivesMainDeletedListener;
use App\Listeners\SurveyUpdatedListener;
use App\Listeners\SurveyDeletedListener;
use App\Listeners\SecurityAwarenesAddListener;
use App\Listeners\SecurityAwarenesDeletedListener;
use App\Listeners\SecurityAwarenesUpdateListener;
use App\Events\SecurityAwarenesAdd;
use App\Events\SecurityAwarenesDeleted;
use App\Events\SecurityAwarenesUpdate;
use App\Events\RiskUpdated;
use App\Events\RiskStatus;
use App\Events\RiskClose;
use App\Events\RiskDelete;
use App\Events\RiskUpdateSubject;
use App\Events\RiskMitigationCreated;
use App\Events\TaskCreated;
use App\Events\TaskDelated;
use App\Events\TaskUpdated;
use App\Listeners\EmployeeChangeStatusListener;
use App\Listeners\TaskCreatedListener;
use App\Listeners\TaskDeletedListener;
use App\Listeners\TaskUpdatedListener;
use App\Models\ControlObjective;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CateogryCreated::class => [
            CateogryCreatedListener::class,
        ],
        CateogryUpdated::class => [
            CateogryUpdatedListener::class,
        ], ObjectiveAchievement::class => [
            ObjectiveAchievementListener::class,
        ],

        CateogryDeleted::class => [
            CateogryDeletedListener::class,
        ],
        AssessmentCreated::class => [
            AssessmentCreatedListener::class,
        ],
        AssessmentUpdated::class => [
            AssessmentUpdatedListener::class,
        ],
        AssessmentDeleted::class => [
            AssessmentDeletedListener::class,
        ],
        TaskCreated::class => [
            TaskCreatedListener::class,
        ],
        TaskUpdated::class => [
            TaskUpdatedListener::class,
        ],
        TaskDelated::class => [
            TaskDeletedListener::class,
        ],
        EmployeeChangeStatus::class => [
            EmployeeChangeStatusListener::class ,
        ],
        QuestionnaireCreated::class => [
            QuestionnaireCreatedListener::class,
        ],
        QuestionnaireUpdated::class => [
            QuestionnaireUpdatedListener::class,
        ],
        QuestionnaireDeleted::class => [
            QuestionnaireDeletedListener::class,
        ],
        QuestionCreated::class => [
            QuestionCreatedListener::class,
        ],
        QuestionUpdated::class => [
            QuestionUpdatedListener::class,
        ],
        QuestionDeleted::class => [
            QuestionDeletedListener::class,
        ],
        DocumentCreated::class => [
            DocumentCreatedListener::class,
        ],
        DocumentUpdated::class => [
            DocumentUpdatedListener::class,
        ],
        DocumentDeleted::class => [
            DocumentDeletedListener::class,
        ],
        AuditResultCreated::class => [
            AuditResultCreatedListener::class,
        ],
        AduitPolicyCreated::class => [
            AduitPolicyCreatedListener::class,
        ],
        AuditCommentCreated::class => [
            AuditCommentCreatedListener::class,
        ],
        AuditRiskCreated::class => [
            AuditRiskListener::class,
        ],
        ControlCreated::class => [
            ControlCreatedListener::class,
        ],
        ControlUpdated::class => [
            ControlUpdatedListener::class,
        ],
        ControlDeleted::class => [
            ControlDeletedListener::class,
        ],
        ControlObjectiveCreated::class => [
            ControlObjectiveCreatedListener::class,
        ],        ControlObjectiveCreated::class => [
            ControlObjectiveCreatedListener::class,
        ],
        ControlEvidenceCreated::class => [
            ControlEvidenceCreatedListener::class,
        ],
        ControlAuditCreated::class => [
            ControlAuditCreatedListener::class,
        ],
        ControlEvidenceUpdated::class => [
            ControlEvidenceUpdatedListener::class,
        ],
        ControlObjectivesMainCreated::class => [
            ControlObjectivesMainCreatedListener::class,
        ],
        ControlObjectivesMainUpdated::class => [
            ControlObjectivesMainUpdatedListener::class,
        ],
        ControlObjectivesMainDeleted::class => [
            ControlObjectivesMainDeletedListener::class,
        ],
        DepartmentCreated::class => [
            DepartmentCreatedListener::class,
        ],
        DepartmentUpdated::class => [
            DepartementUpdatedListener::class,
        ],
        DepartementDeleted::class => [
            DepartementDeletedListener::class,
        ], initiateAssessmentCreated::class => [
            initiateAssessmentCreatedListener::class,
        ],
        AssetCreated::class => [
            AssetCreatedListener::class,
        ],
        AssetUpdated::class => [
            AssetUpdatedListener::class,
        ],
        AssetDeleted::class => [
            AssetDeletedListener::class,
        ],
        AssetsGroupCreated::class => [
            AssetsGroupCreatedListener::class,
        ],
        AssetGroupUpdated::class => [
            AssetGroupUpdatedListener::class,
        ],
        AssetGroupDeleted::class => [
            AssetGroupDeletedListener::class,
        ],
        AuditCreated::class => [
            AuditCreatedListener::class,
        ],
        MgmtreviewCreated::class => [
            MgmtreviewCreatedListener::class,
        ],
        RiskStatus::class => [
            RiskStatusListener::class,
        ],
        mitigationTeamCreated::class => [
            mitigationTeamCreatedCreatedListener::class,
        ],
        FrameworkCreated::class => [
            FrameworkCreatedListener::class,
        ],
        FrameworkUpdated::class => [
            FrameworkUpdatedListener::class,
        ],
        FrameworkDeleted::class => [
            FrameworkDeletedListener::class,
        ],
        RiskCreated::class => [
            RiskCreatedListener::class,
        ],
        RiskDelete::class => [
            RiskDeleteListener::class,
        ],
        RiskUpdated::class => [
            RiskUpdatedListener::class,
        ],
        RiskResetReviews::class => [
            RiskResetReviewsListener::class,
        ],
        RiskReopen::class => [
            RiskReopenListener::class,
        ],
        RiskResetMitigation::class => [
            RiskResetMitigationListener::class,
        ],
        RiskMitigationUpdated::class => [
            RiskMitigationUpdatedListener::class,
        ], RiskUpdateSubject::class => [
            RiskUpdateSubjectListener::class,
        ],
        RiskClose::class => [
            RiskCloseListener::class,
        ],
        RiskMitigationCreated::class => [
            RiskMitigationCreatedListener::class,
        ],
        DepartementMovingToAnother::class => [
            DepartementMovingToAnotherListener::class,
        ],
        DepartementMovingEmployee::class => [
            DepartementMovingEmployeeListener::class,
        ],
        JobCreated::class => [
            JobCreatedListener::class,
        ],
        JobUpdated::class => [
            JobUpdatedListener::class,
        ],
        JobDeleted::class => [
            JobDeletedListener::class,
        ],
        KpiCreated::class => [
            KpiCreatedListener::class,
        ], KpiUpdated::class => [
            KpiUpdatedListener::class,
        ], KpiDeleted::class => [
            KpiDeletedListener::class,
        ],
        VulnerabilityCreated::class => [
            VulnerabilityCreatedListener::class,
        ],
        VulnerabilityCreated::class => [
            VulnerabilityCreatedListener::class,
        ],
        VulnerabilityCreated::class => [
            VulnerabilityCreatedListener::class,
        ],
        VulnerabilityUpdated::class => [
            VulnerabilityUpdatedListener::class,
        ],
        VulnerabilityDeleted::class => [
            VulnerabilityDeletedListener::class,
        ], SurveyCreated::class => [
            SurveyCreatedListener::class,
        ], SurveyUpdated::class => [
            SurveyUpdatedListener::class,
        ], SurveyDeleted::class => [
            SurveyDeletedListener::class,
        ], SecurityAwarenesAdd::class => [
            SecurityAwarenesAddListener::class,
        ], SecurityAwarenesDeleted::class => [
            SecurityAwarenesDeletedListener::class,
        ], SecurityAwarenesUpdate::class => [
            SecurityAwarenesUpdateListener::class,
        ],

    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Review::observe(ReviewObserver::class);
        // Risk::observe(RiskObserver::class);
        // Task::observe(TaskObserver::class);
        // Document::observe(DocumentObserver::class);
        // SecurityAwareness::observe(SecurityAwarenessObserver::class);
    }
}
