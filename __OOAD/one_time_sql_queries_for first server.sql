DELETE FROM `permission_to_users` WHERE `permission_id` IN (162 ,164);
DELETE FROM `role_responsibilities` WHERE `permission_id` IN (162 ,164);
DELETE FROM `permissions` WHERE `permissions`.`id` = 162;
DELETE FROM `permissions` WHERE `permissions`.`id` = 164;

/* ******** Start Ahmed Fawzy (4/12/2022) ******** */
INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (162, 'KPI.export', 'export', '36', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '162');
/* ******** END Ahmed Fawzy (4/12/2022) ******** */

/* ******** Start Ahmed Fawzy (5/12/2022) ******** */
INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (163, 'change-request.export', 'export', '34', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '163');
/* ******** END Ahmed Fawzy (5/12/2022) ******** */

/* ******** Start Ahmed Fawzy (6/12/2022) ******** */
INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (164, 'audits.export', 'export', '9', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '164');

INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (165, 'task.export', 'export', '29', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '165');
/* ******** END Ahmed Fawzy (6/12/2022) ******** */