INSERT INTO
    `subgroups` (
        `id`,
        `name`,
        `permission_group_id`,
        `created_at`,
        `updated_at`
    )
VALUES
    (NULL, 'AwarenessSurvey', '13', NULL, NULL);

INSERT INTO
    `permissions` (
        `id`,
        `key`,
        `name`,
        `subgroup_id`,
        `created_at`,
        `updated_at`
    )
VALUES
    (
        NULL,
        'awareness-survey.list',
        'list',
        '44',
        NULL,
        NULL
    ),
    (
        NULL,
        'awareness-survey.create',
        'create',
        '44',
        NULL,
        NULL
    ),
    (
        NULL,
        'awareness-survey.edit',
        'edit',
        '44',
        NULL,
        NULL
    ),
    (
        NULL,
        'awareness-survey.delete',
        'delete',
        '44',
        NULL,
        NULL
    ),
    (
        NULL,
        'awareness-survey.add_questions',
        'add questions',
        '44',
        NULL,
        NULL
    ),
    (
        NULL,
        'awareness-survey.list_questions',
        'list_questions',
        '44',
        NULL,
        NULL
    );

INSERT INTO
    `permissions` (
        `id`,
        `key`,
        `name`,
        `subgroup_id`,
        `created_at`,
        `updated_at`
    )
VALUES
    (
        NULL,
        'reporting.awareness-survey-info',
        'Awareness Survey',
        '28',
        NULL,
        NULL
    );

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'reporting.awareness-survey-info';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.list';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.create';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.edit';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.delete';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.add_questions';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.list_questions';

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    2,
    id
FROM
    `permissions`
WHERE
    `key` = 'awareness-survey.list';

INSERT INTO
    `actions` (`id`, `name`)
VALUES
    (46, 'Aduit_Comment_Add'),
    (19, 'Aduit_Policy_Add'),
    (59, 'Assessment_Add'),
    (61, 'Assessment_Delete'),
    (60, 'Assessment_Update'),
    (47, 'Asset_Add'),
    (49, 'Asset_Delete'),
    (50, 'Asset_Group_Add'),
    (52, 'Asset_Group_Delete'),
    (51, 'Asset_Group_Update'),
    (48, 'Asset_Update'),
    (40, 'Audit_Add'),
    (44, 'Audit_Main_Add'),
    (45, 'Audit_Risk_Add'),
    (53, 'Cateogry_Add'),
    (55, 'Cateogry_Delete'),
    (54, 'Cateogry_Update'),
    (34, 'Control_Add'),
    (36, 'Control_Delete'),
    (41, 'Control_Objectives_Add'),
    (43, 'Control_Objectives_Delete'),
    (42, 'Control_Objectives_Update'),
    (35, 'Control_Update'),
    (22, 'Departement_Add'),
    (24, 'Departement_Delete'),
    (23, 'Departement_Update'),
    (56, 'Document_Add'),
    (58, 'Document_Delete'),
    (57, 'Document_Update'),
    (38, 'Evidence_Add'),
    (39, 'Evidence_Update'),
    (31, 'Framework_Add'),
    (33, 'Framework_Delete'),
    (32, 'Framework_Update'),
    (25, 'Job_Add'),
    (27, 'Job_Delete'),
    (26, 'Job_Update'),
    (28, 'Kpi_Add'),
    (30, 'Kpi_Delete'),
    (29, 'Kpi_Update'),
    (12, 'MgmtReview_Add'),
    (37, 'Objective_Add'),
    (62, 'Question_Add'),
    (64, 'Question_Delete'),
    (63, 'Question_Update'),
    (65, 'Questionnaire_Add'),
    (67, 'Questionnaire_Delete'),
    (66, 'Questionnaire_Update'),
    (10, 'Risk_Add'),
    (13, 'Risk_Close'),
    (16, 'Risk_Delete'),
    (15, 'Risk_Mitigation'),
    (20, 'Risk_Reopen'),
    (18, 'Risk_Reset_Mitigations'),
    (17, 'Risk_Reset_Reviews'),
    (14, 'Risk_Status'),
    (11, 'Risk_Update'),
    (21, 'Risk_Update_Subject'),
    (7, 'securityAwareness_add'),
    (9, 'securityAwareness_delete'),
    (8, 'securityAwareness_update'),
    (4, 'survey_add'),
    (6, 'survey_delete'),
    (5, 'survey_update');

ALTER TABLE
    framework_control_test_comments
MODIFY
    COLUMN `user` BIGINT(20) UNSIGNED;

ALTER TABLE
    framework_control_test_comments
ADD
    CONSTRAINT `fk_user` FOREIGN KEY (`user`) REFERENCES users (`id`) ON DELETE CASCADE;