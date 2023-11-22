/* *********************** Start Ahmed Fawzy (14/11/2022) *********************** */
-- Alter families.order to be int to get sorting successfully
ALTER TABLE `families` CHANGE `order` `order` INT NOT NULL;

-- Delete duplicated mapping between framework and control
DELETE FROM framework_control_mappings WHERE id IN( 
    SELECT id FROM (SELECT id, framework_control_id, framework_id, ROW_NUMBER()   
    OVER (PARTITION BY framework_control_id,framework_id  ORDER BY framework_control_id,framework_id ) AS row_num   
    FROM framework_control_mappings) AS temp_table WHERE row_num>1
);
/* *********************** END Ahmed Fawzy (14/11/2022) *********************** */

/* *********************** Start Ahmed Fawzy (30/11/2022) *********************** */
UPDATE `framework_control_tests` SET `tester`= 1 WHERE `tester` IS NULL;
ALTER TABLE `framework_control_tests` CHANGE `tester` `tester` BIGINT UNSIGNED NOT NULL;
ALTER TABLE `framework_control_tests` ADD CONSTRAINT `FK_framework_control_test_tester` FOREIGN KEY (`tester`) REFERENCES `users` (`id`);
/* *********************** END Ahmed Fawzy (30/11/2022) *********************** */

/* *********************** END Ahmed Fawzy (1/12/2022) *********************** */
UPDATE `framework_control_test_audits` SET `tester`= 1 WHERE `tester` IS NULL;
ALTER TABLE `framework_control_test_audits` CHANGE `tester` `tester` BIGINT UNSIGNED NOT NULL;
ALTER TABLE `framework_control_test_audits` ADD CONSTRAINT `FK_framework_control_test_audit_tester` FOREIGN KEY (`tester`) REFERENCES `users` (`id`);
/* *********************** END Ahmed Fawzy (1/12/2022) *********************** */

/* *********************** Start Ahmed Fawzy (4/12/2022) *********************** */
INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (162, 'KPI.export', 'export', '36', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '162');
/* *********************** END Ahmed Fawzy (4/12/2022) *********************** */

/* *********************** Start Ahmed Fawzy (5/12/2022) *********************** */
INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (163, 'change-request.export', 'export', '34', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '163');
/* *********************** END Ahmed Fawzy (5/12/2022) *********************** */

/* *********************** Start Ahmed Fawzy (6/12/2022) *********************** */
INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (164, 'audits.export', 'export', '9', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '164');

INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES (165, 'task.export', 'export', '29', NULL, NULL);
INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '165');
/* *********************** END Ahmed Fawzy (6/12/2022) *********************** */

/* *********************** Start Ahmed Fawzy (6/12/2022) *********************** */

--
-- Table structure for table `control_audit_policies`
--

CREATE TABLE IF NOT EXISTS `control_audit_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `framework_control_test_audit_id` bigint UNSIGNED NOT NULL,
  `document_audit_status` enum('no_action','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/* *********************** Start Ahmed Fawzy (6/12/2022) *********************** */


/* *********************** Start Ahmed Fawzy (8/2/2023) *********************** */
DROP TABLE `control_audit_policies`;

-- --------------------------------------------------------

--
-- Table structure for table `control_audit_policies`
--

CREATE TABLE `control_audit_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `framework_control_test_audit_id` bigint UNSIGNED NOT NULL,
  `document_audit_status` enum('no_action','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `control_audit_policies`
--
ALTER TABLE `control_audit_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_audit_policies_document_id_foreign` (`document_id`),
  ADD KEY `control_audit_policies_framework_control_test_audit_id_foreign` (`framework_control_test_audit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `control_audit_policies`
--
ALTER TABLE `control_audit_policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `control_audit_policies`
--
ALTER TABLE `control_audit_policies`
  ADD CONSTRAINT `control_audit_policies_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `control_audit_policies_framework_control_test_audit_id_foreign` FOREIGN KEY (`framework_control_test_audit_id`) REFERENCES `framework_control_test_audits` (`id`);
COMMIT;

/* *********************** End Ahmed Fawzy (8/2/2023) *********************** */
