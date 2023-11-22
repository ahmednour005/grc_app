UPDATE `framework_control_tests` SET  `last_date` = '2023-02-07';
DELETE FROM `framework_control_test_audits`;
UPDATE `documents` SET `document_status` = 1, `approval_date` = NULL, `creation_date` = '2023-02-07', `last_review_date` = '2023-02-07', `next_review_date` = '2023-08-06';
DELETE FROM `role_responsibilities` WHERE `permission_id` IN(96, 115, 116, 117, 118, 119, 120, 142);
DELETE FROM `permissions` WHERE `id` IN(96, 115, 116, 117, 118, 119, 120, 142);

/* *********************** START Ahmed Fawzy (8/2/2023) *********************** */
DELETE FROM `security_awareness_exam_questions`;
DELETE FROM `security_awareness_exam_answers`;
DELETE FROM `security_awareness_exams`;
DELETE FROM `security_awareness_notes`;
DELETE FROM `security_awarenesses`;

DELETE FROM `framework_control_test_audits`;
DELETE FROM `compliance_files`;
/* *********************** End Ahmed Fawzy (8/2/2023) *********************** */
