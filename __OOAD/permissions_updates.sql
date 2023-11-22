/************************ START Abdelfattah 1/9/2023 **********************/
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
    (NULL, 'reporting.objectives', 'Objectives', '28', NULL, NULL);

INSERT INTO
    `role_responsibilities` (`id`, `role_id`, `permission_id`)
SELECT
    NULL,
    1,
    id
FROM
    `permissions`
WHERE
    `key` = 'reporting.objectives';

/************************ END Abdelfattah 1/9/2023 **********************/