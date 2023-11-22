-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 07, 2023 at 02:07 PM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GRC_06_02_2023_test2`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers`
--

CREATE TABLE `assessment_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_id` bigint UNSIGNED NOT NULL,
  `question_id` int NOT NULL,
  `answer` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_risk` tinyint(1) NOT NULL DEFAULT '0',
  `risk_subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_score` double(8,2) NOT NULL,
  `assessment_scoring_id` bigint UNSIGNED NOT NULL,
  `risk_owner` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '999999'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers_to_assets`
--

CREATE TABLE `assessment_answers_to_assets` (
  `assessment_answer_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers_to_asset_groups`
--

CREATE TABLE `assessment_answers_to_asset_groups` (
  `assessment_answer_id` bigint UNSIGNED NOT NULL,
  `asset_group_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_questions`
--

CREATE TABLE `assessment_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_id` bigint UNSIGNED NOT NULL,
  `question` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '999999'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scorings`
--

CREATE TABLE `assessment_scorings` (
  `id` bigint UNSIGNED NOT NULL,
  `scoring_method` int NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `CLASSIC_likelihood` double(8,2) NOT NULL DEFAULT '5.00',
  `CLASSIC_impact` double(8,2) NOT NULL DEFAULT '5.00',
  `CVSS_AccessVector` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_AccessComplexity` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `CVSS_Authentication` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_ConfImpact` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_IntegImpact` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_AvailImpact` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_Exploitability` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_RemediationLevel` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ReportConfidence` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_CollateralDamagePotential` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_TargetDistribution` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ConfidentialityRequirement` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_IntegrityRequirement` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_AvailabilityRequirement` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `DREAD_DamagePotential` int NOT NULL DEFAULT '10',
  `DREAD_Reproducibility` int NOT NULL DEFAULT '10',
  `DREAD_Exploitability` int NOT NULL DEFAULT '10',
  `DREAD_AffectedUsers` int NOT NULL DEFAULT '10',
  `DREAD_Discoverability` int NOT NULL DEFAULT '10',
  `OWASP_SkillLevel` int NOT NULL DEFAULT '10',
  `OWASP_Motive` int NOT NULL DEFAULT '10',
  `OWASP_Opportunity` int NOT NULL DEFAULT '10',
  `OWASP_Size` int NOT NULL DEFAULT '10',
  `OWASP_EaseOfDiscovery` int NOT NULL DEFAULT '10',
  `OWASP_EaseOfExploit` int NOT NULL DEFAULT '10',
  `OWASP_Awareness` int NOT NULL DEFAULT '10',
  `OWASP_IntrusionDetection` int NOT NULL DEFAULT '10',
  `OWASP_LossOfConfidentiality` int NOT NULL DEFAULT '10',
  `OWASP_LossOfIntegrity` int NOT NULL DEFAULT '10',
  `OWASP_LossOfAvailability` int NOT NULL DEFAULT '10',
  `OWASP_LossOfAccountability` int NOT NULL DEFAULT '10',
  `OWASP_FinancialDamage` int NOT NULL DEFAULT '10',
  `OWASP_ReputationDamage` int NOT NULL DEFAULT '10',
  `OWASP_NonCompliance` int NOT NULL DEFAULT '10',
  `OWASP_PrivacyViolation` int NOT NULL DEFAULT '10',
  `Custom` double(8,2) NOT NULL DEFAULT '10.00',
  `Contributing_Likelihood` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scoring_contributing_impacts`
--

CREATE TABLE `assessment_scoring_contributing_impacts` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_scoring_id` bigint UNSIGNED NOT NULL,
  `contributing_risk_id` bigint UNSIGNED NOT NULL,
  `impact` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_value_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `teams` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` tinyint NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `alert_period` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_asset_groups`
--

CREATE TABLE `assets_asset_groups` (
  `asset_id` bigint UNSIGNED NOT NULL,
  `asset_group_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_asset_groups`
--

CREATE TABLE `asset_asset_groups` (
  `asset_id` bigint UNSIGNED NOT NULL,
  `asset_group_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_groups`
--

CREATE TABLE `asset_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_values`
--

CREATE TABLE `asset_values` (
  `id` bigint UNSIGNED NOT NULL,
  `min_value` int NOT NULL,
  `max_value` int DEFAULT NULL,
  `valuation_level_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_values`
--

INSERT INTO `asset_values` (`id`, `min_value`, `max_value`, `valuation_level_name`) VALUES
(1, 0, 100000, ''),
(2, 100001, 200000, ''),
(3, 200001, 300000, ''),
(4, 300001, 400000, ''),
(5, 400001, 500000, ''),
(6, 500001, 600000, ''),
(7, 600001, 700000, ''),
(8, 700001, 800000, ''),
(9, 800001, 900000, ''),
(10, 900001, 1000000, ''),
(11, 7617, 487550, 'est'),
(12, 6240, 763085, 'accusantium'),
(13, 3911, 127984, 'voluptatibus'),
(14, 8542, 199368, 'ipsum'),
(15, 2783, 493785, 'aliquam'),
(16, 8229, 420299, 'voluptas'),
(17, 4541, 895449, 'saepe'),
(18, 8029, 803877, 'temporibus'),
(19, 4681, 139746, 'natus'),
(20, 3917, 144480, 'deserunt');

-- --------------------------------------------------------

--
-- Table structure for table `asset_vulnerabilities`
--

CREATE TABLE `asset_vulnerabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `vulnerability_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `risk_id` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'This is table name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` bigint UNSIGNED NOT NULL,
  `random_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `app_zip_file_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_zip_file_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'tec'),
(2, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `change_requests`
--

CREATE TABLE `change_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_file_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_file_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Department-Manager-In-Review','Department-Manager-Rejected','Responsible-Department-In-Review','Responsible-Department-Accepted','Responsible-Department-Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_cycle` enum('Department-Manager-Review','Responsible-Department-Review') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_review_cycle` enum('Department-Manager-Review','Responsible-Department-Review') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rejection_reason` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `close_reasons`
--

CREATE TABLE `close_reasons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `close_reasons`
--

INSERT INTO `close_reasons` (`id`, `name`) VALUES
(1, 'Rejected'),
(2, 'Fully Mitigated'),
(3, 'System Retired'),
(4, 'Cancelled'),
(5, 'Too Insignificant');

-- --------------------------------------------------------

--
-- Table structure for table `closures`
--

CREATE TABLE `closures` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `closure_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `close_reason` int DEFAULT NULL,
  `note` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int NOT NULL,
  `comment` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_files`
--

CREATE TABLE `compliance_files` (
  `id` bigint UNSIGNED NOT NULL,
  `ref_id` int NOT NULL,
  `ref_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int NOT NULL,
  `content` longblob NOT NULL,
  `version` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks`
--

CREATE TABLE `contributing_risks` (
  `id` bigint UNSIGNED NOT NULL,
  `subject` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks_impacts`
--

CREATE TABLE `contributing_risks_impacts` (
  `id` bigint UNSIGNED NOT NULL,
  `contributing_risks_id` bigint UNSIGNED NOT NULL,
  `value` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks_likelihoods`
--

CREATE TABLE `contributing_risks_likelihoods` (
  `id` bigint UNSIGNED NOT NULL,
  `value` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_audit_policies`
--

CREATE TABLE `control_audit_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `framework_control_test_audit_id` bigint UNSIGNED NOT NULL,
  `document_audit_status` enum('no_action','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_classes`
--

CREATE TABLE `control_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_classes`
--

INSERT INTO `control_classes` (`id`, `name`) VALUES
(1, 'Technical'),
(2, 'Operational'),
(3, 'Management');

-- --------------------------------------------------------

--
-- Table structure for table `control_desired_maturities`
--

CREATE TABLE `control_desired_maturities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_desired_maturities`
--

INSERT INTO `control_desired_maturities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Not Performed', '2022-11-07 18:00:36', '2022-11-07 18:00:36'),
(2, 'Performed', '2022-11-07 18:00:36', '2022-11-07 18:00:36'),
(3, 'Documented', '2022-11-07 18:00:36', '2022-11-07 18:00:36'),
(4, 'Managed', '2022-11-07 18:00:36', '2022-11-07 18:00:36'),
(5, 'Reviewed', '2022-11-07 18:00:36', '2022-11-07 18:00:36'),
(6, 'Optimizing', '2022-11-07 18:00:36', '2022-11-07 18:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `control_maturities`
--

CREATE TABLE `control_maturities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_maturities`
--

INSERT INTO `control_maturities` (`id`, `name`) VALUES
(1, 'Not Performed'),
(2, 'Performed'),
(3, 'Documented'),
(4, 'Managed'),
(5, 'Reviewed'),
(6, 'Optimizing');

-- --------------------------------------------------------

--
-- Table structure for table `control_owners`
--

CREATE TABLE `control_owners` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_phases`
--

CREATE TABLE `control_phases` (
  `id` bigint UNSIGNED NOT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_phases`
--

INSERT INTO `control_phases` (`id`, `name`) VALUES
(1, 'Physical'),
(2, 'Procedural'),
(3, 'Technical'),
(4, 'Legal and Regulatory or Compliance');

-- --------------------------------------------------------

--
-- Table structure for table `control_priorities`
--

CREATE TABLE `control_priorities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_priorities`
--

INSERT INTO `control_priorities` (`id`, `name`) VALUES
(1, 'P0'),
(2, 'P1'),
(3, 'P2'),
(4, 'P3');

-- --------------------------------------------------------

--
-- Table structure for table `control_types`
--

CREATE TABLE `control_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_types`
--

INSERT INTO `control_types` (`id`, `name`) VALUES
(1, 'Standalone'),
(2, 'Project'),
(3, 'Enterprise');

-- --------------------------------------------------------

--
-- Table structure for table `custom_risk_model_values`
--

CREATE TABLE `custom_risk_model_values` (
  `impact_id` bigint UNSIGNED NOT NULL,
  `likelihood_id` bigint UNSIGNED NOT NULL,
  `value` double(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cvss_scorings`
--

CREATE TABLE `cvss_scorings` (
  `id` bigint UNSIGNED NOT NULL,
  `metric_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrv_metric_name` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metric_value` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrv_metric_value` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeric_value` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_classifications`
--

CREATE TABLE `data_classifications` (
  `id` bigint UNSIGNED NOT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_classifications`
--

INSERT INTO `data_classifications` (`id`, `name`, `order`) VALUES
(1, 'Public', 1),
(2, 'Internal', 2),
(3, 'Confidential', 3),
(4, 'Restricted', 4);

-- --------------------------------------------------------

--
-- Table structure for table `date_formats`
--

CREATE TABLE `date_formats` (
  `value` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `date_formats`
--

INSERT INTO `date_formats` (`value`) VALUES
('DD MM YYYY'),
('DD-MM-YYYY'),
('DD.MM.YYYY'),
('DD/MM/YYYY'),
('MM DD YYYY'),
('MM-DD-YYYY'),
('MM.DD.YYYY'),
('MM/DD/YYYY'),
('YYYY DD MM'),
('YYYY MM DD'),
('YYYY-DD-MM'),
('YYYY-MM-DD'),
('YYYY.DD.MM'),
('YYYY.MM.DD'),
('YYYY/DD/MM'),
('YYYY/MM/DD');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `required_num_emplyees` int DEFAULT NULL,
  `color_id` bigint UNSIGNED NOT NULL,
  `vision` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mission` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `objectives` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `responsibilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_colors`
--

CREATE TABLE `department_colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_colors`
--

INSERT INTO `department_colors` (`id`, `name`, `value`) VALUES
(2, 'المستوى الثاني', '#11b4d4'),
(3, 'المستوى الثالث', '#5667bd'),
(4, 'المكتب اﻹدارى', '#E5EFC1'),
(5, 'الحوكمة والمخاطر والالتزام', '#46244C'),
(6, 'المراقبة اﻷمنية والاستجابة والتحليل', '#C74B50'),
(7, 'إدارة الحلول اﻷمنية', '#D49B54'),
(8, 'المعمارية والتخطيط', '#712B75'),
(9, 'الحوكمة', '#332FD0'),
(10, 'المخاطر', '#F0A500'),
(11, 'الالتزام', '#874356'),
(12, 'المراقبة اﻷمنية', '#019267'),
(13, 'التحليل الرقمى والاستجابة للحوادث', '#9ADCFF'),
(14, 'المعلومات الاستخباراتية والتهديدات', '#008E89'),
(15, 'تحليل التهديدات والثغرات', '#313552'),
(16, 'إدارة الضوابط التقنية اﻷمنية', '#FF5959'),
(17, 'تطوير واختبار الحلول اﻷمنية', '#161853'),
(18, 'إدارة الهويات والصلاحيات', '#544179'),
(19, 'التخطيط والتطوير', '#125C13'),
(20, 'المعمارية اﻷمنية', '#557B83'),
(21, 'المستوى الاول', '#158e60'),
(22, 'المستوى الرابع', '#b18d0b');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint UNSIGNED NOT NULL,
  `document_type` bigint UNSIGNED NOT NULL,
  `privacy` bigint UNSIGNED DEFAULT NULL,
  `document_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parent` int DEFAULT NULL,
  `document_status` int NOT NULL DEFAULT '1' COMMENT '[1 => Draft],[2=> InReview, [3 => Approved]',
  `file_id` int NOT NULL,
  `creation_date` date DEFAULT NULL,
  `last_review_date` date DEFAULT NULL,
  `review_frequency` int DEFAULT NULL,
  `next_review_date` date DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `control_ids` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework_ids` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_owner` bigint UNSIGNED NOT NULL,
  `document_reviewer` bigint UNSIGNED DEFAULT NULL,
  `additional_stakeholders` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver` int DEFAULT NULL,
  `team_ids` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `document_type`, `privacy`, `document_name`, `parent`, `document_status`, `file_id`, `creation_date`, `last_review_date`, `review_frequency`, `next_review_date`, `approval_date`, `control_ids`, `framework_ids`, `document_owner`, `document_reviewer`, `additional_stakeholders`, `approver`, `team_ids`, `created_by`) VALUES
(2, 2, 2, 'السياسة العامة للأمن السيبراني', NULL, 3, 2, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '11', '1', 1, NULL, '', NULL, '', 1),
(3, 2, 2, 'سياسة الالتزام بتشريعات وتنظيمات الأمن السيبراني', NULL, 3, 3, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '35', '1', 1, NULL, '', NULL, '', 1),
(4, 2, 2, 'سياسة الإعدادات والتحصين', NULL, 3, 4, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '28,34', '1', 1, NULL, '', NULL, '', 1),
(5, 2, 2, 'سياسة الحماية من البرمجيات الضارة', NULL, 3, 5, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '76', '1', 1, NULL, '', NULL, '', 1),
(6, 2, 2, 'سياسة أمن الخوادم', NULL, 3, 6, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '76,125', '1', 1, NULL, '', NULL, '', 1),
(7, 2, 2, 'سياسة أمن الشبكات', NULL, 3, 7, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '93,96,103', '1', 1, NULL, '', NULL, '', 1),
(8, 2, 2, 'سياسة أمن البريد الإلكتروني', NULL, 3, 8, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '84', '1', 1, NULL, '', NULL, '', 1),
(9, 2, 2, 'سياسة أمن أجهزة المستخدمين والأجهزة المحمولة والأجهزة الشخصية', NULL, 3, 9, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '76,105', '1', 1, NULL, '', NULL, '', 1),
(10, 2, 2, 'سياسة الاستخدام المقبول للأصول', NULL, 3, 10, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '63', '1', 1, NULL, '', NULL, '', 1),
(11, 2, 2, 'سياسة مراجعة وتدقيق الأمن السيبراني', NULL, 3, 11, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '37', '1', 1, NULL, '', NULL, '', 1),
(12, 2, 2, 'سياسة إدارة هويات الدخول والصلاحيات', NULL, 3, 12, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '67', '1', 1, NULL, '', NULL, '', 1),
(13, 2, 2, 'سياسة الأمن السيبراني للموارد البشرية', NULL, 3, 13, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '40', '1', 1, NULL, '', NULL, '', 1),
(14, 2, 2, 'سياسة إدارة سجلات الأحداث ومراقبة الأمن السيبراني', NULL, 3, 14, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '149', '1', 1, NULL, '', NULL, '', 1),
(15, 2, 2, 'سياسة إدارة حزم التحديثات والإصلاحات', NULL, 3, 15, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '81', '1', 1, NULL, '', NULL, '', 1),
(16, 2, 2, 'سياسة الأمن السيبراني المتعلّق بالأطراف الخارجية', NULL, 3, 16, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '192,199', '1', 1, NULL, '', NULL, '', 1),
(17, 2, 2, 'أدوار ومسؤوليات الأمن السيبراني', NULL, 3, 17, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '15,40', '1', 1, NULL, '', NULL, '', 1),
(18, 2, 2, 'الوثيقة المنظمة للجنة الإشرافية للأمن السيبراني', NULL, 3, 18, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '10', '1', 1, NULL, '', NULL, '', 1),
(19, 2, 2, 'سياسة اختبار الاختراق', NULL, 3, 19, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '61,143,148', '1', 1, NULL, '', NULL, '', 1),
(20, 2, 2, 'سياسة إدارة الثغرات', NULL, 3, 20, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '134,137,141', '1', 1, NULL, '', NULL, '', 1),
(21, 2, 2, 'سياسة إدارة حوادث وتهديدات الأمن السيبراني', NULL, 3, 21, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '157,158,161,162,163,164,165', '1', 1, NULL, '', NULL, '', 1),
(22, 2, 2, 'سياسة أمن قواعد البيانات', NULL, 3, 22, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '12,82', '1', 1, NULL, '', NULL, '', 1),
(23, 2, 2, 'سياسة حماية تطبيقات الويب', NULL, 3, 23, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '100,176,179,180,182,184', '1', 1, NULL, '', NULL, '', 1),
(24, 2, 2, 'استراتيجية الأمن السيبراني', NULL, 3, 24, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '5', '1', 1, NULL, '', NULL, '', 1),
(25, 2, 2, 'الهيكل التنظيمي للأمن السيبراني', NULL, 3, 25, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '8', '1', 1, NULL, '', NULL, '', 1),
(26, 2, 2, 'سياسة الأمن السيبراني لأنظمة التحكم الصناعي', NULL, 3, 26, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '208,212,213,215,217,218,221', '1', 1, NULL, '', NULL, '', 1),
(27, 2, 2, 'سياسة التشفير', NULL, 3, 27, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '120,121,123,126', '1', 1, NULL, '', NULL, '', 1),
(31, 2, 2, 'سياسة إدارة مخاطر الأمن السيبراني', NULL, 3, 31, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '17', '1', 1, NULL, '', NULL, '', 1),
(32, 2, 2, 'سياسة الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة', NULL, 3, 32, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '201,204,205,206', '1', 1, NULL, '', NULL, '', 1),
(33, 2, 2, 'سياسة الأمن السيبراني ضمن استمرارية الأعمال', NULL, 3, 33, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '185', '1', 1, NULL, '', NULL, '', 1),
(34, 2, 2, 'سياسة الأمن السيبراني المتعلق بالأمن المادي', NULL, 3, 34, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '167', '1', 1, NULL, '', NULL, '', 1),
(35, 3, 2, 'معيار أمن الشبكات', NULL, 3, 35, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '93', '1', 1, NULL, '', NULL, '', 1),
(36, 3, 2, 'معيار حماية البريد الإلكتروني', NULL, 3, 36, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '13,84', '1', 1, NULL, '', NULL, '', 1),
(37, 3, 2, 'معيار إدارة سجلات الأحداث ومراقبة الأمن السيبراني', NULL, 3, 37, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '13,149', '1', 1, NULL, '', NULL, '', 1),
(38, 3, 2, 'معيار الحماية من البرمجيات الضارة', NULL, 3, 38, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '79', '1', 1, NULL, '', NULL, '', 1),
(39, 3, 2, 'معيار أمن أجهزة المستخدمين', NULL, 3, 39, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '76', '1', 1, NULL, '', NULL, '', 1),
(40, 3, 2, 'معيار أمن الأجهزة المحمولة', NULL, 3, 40, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '13,105', '1', 1, NULL, '', NULL, '', 1),
(41, 3, 2, 'معيار أمن الخوادم', NULL, 3, 41, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '76', '1', 1, NULL, '', NULL, '', 1),
(42, 3, 2, 'معيار أمن قواعد البيانات', NULL, 3, 42, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '76', '1', 1, NULL, '', NULL, '', 1),
(43, 3, 2, 'معيار إدارة الثغرات', NULL, 3, 43, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '134', '1', 1, NULL, '', NULL, '', 1),
(44, 3, 2, 'معيار إدارة حوادث وتهديدات الأمن السيبراني', NULL, 3, 44, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '158', '1', 1, NULL, '', NULL, '', 1),
(45, 3, 2, 'معيار اختبار الاختراق', NULL, 3, 45, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '143', '1', 1, NULL, '', NULL, '', 1),
(46, 3, 2, 'معيار التطوير الآمن للتطبيقات', NULL, 3, 46, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '30', '1', 1, NULL, '', NULL, '', 1),
(47, 3, 2, 'معيار حماية تطبيقات الويب', NULL, 3, 47, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '176', '1', 1, NULL, '', NULL, '', 1),
(48, 3, 2, 'معيار التشفير', NULL, 3, 48, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '120', '1', 1, NULL, '', NULL, '', 1),
(49, 3, 2, 'معيار أمن الشبكات اللاسلكية', NULL, 3, 49, '2022-11-08', '2022-11-08', 180, '2023-05-07', '2022-11-08', '93', '1', 1, NULL, '', NULL, '', 1),
(54, 8, 1, 'لوائح صمود الامن السيبراني', NULL, 3, 65, '2023-01-31', '2023-01-31', 30, '2023-03-02', '2023-01-31', '138', '1', 1, NULL, '3,5', NULL, '1,4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `document_exceptions`
--

CREATE TABLE `document_exceptions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_document_id` int DEFAULT NULL,
  `control_framework_id` int DEFAULT NULL,
  `owner` int DEFAULT NULL,
  `additional_stakeholders` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL DEFAULT '0000-00-00',
  `review_frequency` int NOT NULL DEFAULT '0',
  `next_review_date` date NOT NULL DEFAULT '0000-00-00',
  `approval_date` date NOT NULL DEFAULT '0000-00-00',
  `approver` int DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `justification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_id` int NOT NULL,
  `associated_risks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_exceptions_statuses`
--

CREATE TABLE `document_exceptions_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_notes`
--

CREATE TABLE `document_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `note` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_note_files`
--

CREATE TABLE `document_note_files` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `display_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_statuses`
--

CREATE TABLE `document_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_statuses`
--

INSERT INTO `document_statuses` (`id`, `name`) VALUES
(1, 'Draft'),
(2, 'In Review'),
(3, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(2, 'نماذج سياسات الأمن السيبراني', 'fas  fa-lock', '2022-11-08 10:26:19', '2022-11-08 10:26:19'),
(3, 'معايير الأمن السيبراني', 'fas  fa-lock', '2022-11-08 10:53:28', '2022-11-08 10:53:28'),
(4, 'الاجراءات', 'fas fa-bug', '2022-11-08 16:56:33', '2022-11-16 13:22:24'),
(8, 'صمود الأمن السيبراني', 'fa-unlink', '2023-01-31 11:43:48', '2023-01-31 11:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_saved_selections`
--

CREATE TABLE `dynamic_saved_selections` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` enum('private','public') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_display_settings` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_selection_settings` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_column_filters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_login_attempts`
--

CREATE TABLE `failed_login_attempts` (
  `id` bigint UNSIGNED NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `name`, `order`, `parent_id`) VALUES
(1, 'حوكمة الأمن السيبراني CyberSecurity Governance', 1, NULL),
(2, 'تعزيز الأمن السيبراني CyberSecurity Defense', 2, NULL),
(3, 'صمود الأمن السيبراني CyberSecurity Resilience', 3, NULL),
(4, 'الأمن السيبراني المتعلق باﻷطراف الخارجية والحوسبة السحابية Third-Party and Cloud Computing CyberSecurity', 4, NULL),
(5, 'الأمن السيبراني ﻷنظمة التحكم الصناعي ICS CyberSecurity', 5, NULL),
(6, 'Cyber Security Leadership and Governance', 6, NULL),
(7, 'Cyber Security Risk Management and Compliance', 7, NULL),
(8, 'Cyber Security Operations and Technology', 8, NULL),
(9, 'Third Party Cyber Security', 9, NULL),
(10, 'Annex A.5 – Information Security Policies', 10, NULL),
(11, 'Annex A.6 – Organisation of Information Security', 11, NULL),
(12, 'Annex A.7 – Human Resource Security', 12, NULL),
(13, 'Annex A.8 – Asset Management', 13, NULL),
(14, 'Annex A.9 – Access Control', 14, NULL),
(15, 'Annex A.10  – Cryptography', 15, NULL),
(16, 'Annex A.11 – Physical & Environmental Security', 16, NULL),
(17, 'Annex A.12 – Operations Security', 17, NULL),
(18, 'Annex A.13 – Communications Security', 18, NULL),
(19, 'Annex A.14 – System Acquisition, Development & Maintenance', 19, NULL),
(20, 'Annex A.15 – Supplier Relationships', 20, NULL),
(21, 'Annex A.16 – Information Security Incident Management', 21, NULL),
(22, 'Annex A.17 – Information Security Aspects of Business Continuity Management', 22, NULL),
(23, 'Annex A.18 – Compliance', 23, NULL),
(24, 'إستراتيجية الأمن السيبراني CyberSecurity Strategy', 1, 1),
(25, 'إدارة الأمن السيبراني CyberSecurity Management', 2, 1),
(26, 'سياسات وإجراءات الأمن السيبراني CyberSecurity Policies and Procedures', 3, 1),
(27, 'أدارة ومسئوليات الأمن السيبراني CyberSecurity Role and Responsibilities', 4, 1),
(28, 'إدارة مخاطر الأمن السيبراني CyberSecurity Risk Management', 5, 1),
(29, 'الأمن السيبراني ضمن إدارة المشاريع المعلوماتية والتقنية CyberSecurity in Information Technology Projects', 6, 1),
(30, 'اﻹلتزام بتشريعات وتنظيمات ومعايير الأمن السيبراني CyberSecurity Regulatory Compliance', 7, 1),
(31, 'المراجعة والتدقيق الدورى للأمن السيبراني CyberSecurity Periodical Assessment and Audit', 8, 1),
(32, 'الأمن السيبراني المتعلق بالموارد البشرية CyberSecurity in Human Resources', 9, 1),
(33, 'برنامج التوعية والتدريب بالأمن السيبراني CyberSecurity Awareness and Training Program', 10, 1),
(34, 'إدارة اﻷصول Asset Management', 1, 2),
(35, 'إدارة هويات الدخول والصلاحيات Identity and Access Management', 2, 2),
(36, 'حماية اﻷنظمة وأجهزة معالجة المعلومات Information System and Processing Facilities Protection', 3, 2),
(37, 'حماية البريد اﻹلكترونى Email Protection', 4, 2),
(38, 'إدارة أمن الشبكات Networks Security Management', 5, 2),
(39, 'أمن اﻷجهزة المحمولة Mobile Devices Security', 6, 2),
(40, 'حماية البيانات والمعلومات Data and Information Protection', 7, 2),
(41, 'التشفير Cryptography', 8, 2),
(42, 'إدارة النسخ الاحتياطية Backup and Recovery Management', 9, 2),
(43, 'إدارة الثغرات Vulnerabilities Management', 10, 2),
(44, 'إختبار الاختراق Penetration Testing', 11, 2),
(45, 'إدارة سجلات اﻷحداث ومراقبة اﻷمن السيبرانى CyberSecurity Event Logs and Monitoring Management', 12, 2),
(46, 'إدارة حوادث وتهديدات  اﻷمن السيبراني CyberSecurity Incident and Threat Management', 13, 2),
(47, 'اﻷمن المادى Physical Security', 14, 2),
(48, 'حماية تطبيقات الويب Web Application Security', 15, 2),
(49, 'جوانب صمود اﻷمن السيبراني فى إدارة استمرارية اﻷعمال CyberSecurity Resilience aspects of Business Continuity Management (BCM)', 1, 3),
(50, 'الأمن السيبراني المتعلق باﻷطراف الخارجية Third-Party CyberSecurity', 1, 4),
(51, 'الأمن السيبراني المتعلق بالحوسبة السحابية والاستضافة Cloud Computing and hosting CyberSecurity', 2, 4),
(52, 'حماية أجمزة وأنظمة التحكم الصناعي Industrial Control Systems (ICS) Protection', 1, 5),
(53, 'Cyber Security Governance', 1, 6),
(54, 'Cyber Security Strategy', 2, 6),
(55, 'Cyber Security Policy', 3, 6),
(56, 'Cyber Security Roles and Responsibilities', 4, 6),
(57, 'Cyber Security in Project Management', 5, 6),
(58, 'Cyber Security Awareness', 6, 6),
(59, 'Cyber Security Training', 7, 6),
(60, 'Cyber Security Risk Management', 1, 7),
(61, 'Regulatory Compliance', 2, 7),
(62, 'Compliance with (inter)national industry standards', 3, 7),
(63, 'Cyber Security Review', 4, 7),
(64, 'Cyber Security Audits', 5, 7),
(65, 'Human Resources', 1, 8),
(66, 'Physical Security', 2, 8),
(67, 'Asset Management', 3, 8),
(68, 'Cyber Security Architecture', 4, 8),
(69, 'Identity and Access Management', 5, 8),
(70, 'Application Security', 6, 8),
(71, 'Change Management', 7, 8),
(72, 'Infrastructure Security', 8, 8),
(73, 'Cryptography', 9, 8),
(74, 'Bring Your Own Device (BYOD)', 10, 8),
(75, 'Secure Disposal of Information Assets', 11, 8),
(76, 'Payment Systems', 12, 8),
(77, 'Electronic Banking Services', 13, 8),
(78, 'Cyber Security Event Management', 14, 8),
(79, 'Cyber Security Incident Management', 15, 8),
(80, 'Threat Management', 16, 8),
(81, 'Vulnerability Management', 17, 8),
(82, 'Contract and Vendor Management', 1, 9),
(83, 'Outsourcing', 2, 9),
(84, 'Cloud Computing', 3, 9),
(85, 'Management direction for information\n                Security', 1, 10),
(86, 'Internal organization', 1, 11),
(87, 'Mobile devices and teleworking', 2, 11),
(88, 'Prior to employment', 1, 12),
(89, 'During employment', 2, 12),
(90, 'Termination and change of employment', 3, 12),
(91, 'Responsibility for assets', 1, 13),
(92, 'Information classification', 2, 13),
(93, 'Media Handling', 3, 13),
(94, 'Business requirements of access\n                Control', 1, 14),
(95, 'User access Management', 2, 14),
(96, 'User responsibilities', 3, 14),
(97, 'System and application access Control', 4, 14),
(98, 'Cryptographic Controls', 1, 15),
(99, 'Ensuring Secure Physical and Environmental Areas', 1, 16),
(100, 'Equipment', 2, 16),
(101, 'Operational Procedures and Responsibilities', 1, 17),
(102, 'Protection From Malware', 2, 17),
(103, 'Backup', 3, 17),
(104, 'Logging and Monitoring', 4, 17),
(105, 'Control of Operational Software', 5, 17),
(106, 'Technical Vulnerability Management', 6, 17),
(107, 'Information Systems and Audit Considerations', 7, 17),
(108, 'Network Security Management', 1, 18),
(109, 'Information Transfer', 2, 18),
(110, 'Security Requirements of Information Systems', 1, 19),
(111, 'Security in Development and Support Processes', 2, 19),
(112, 'Test data', 3, 19),
(113, 'Information Security in Supplier Relationships', 1, 20),
(114, 'Supplier Service Delivery Management', 2, 20),
(115, 'Management of Information Security incidents, events and Weaknesses', 1, 21),
(116, 'Information Security Continuity', 1, 22),
(117, 'Redundancies', 2, 22),
(118, 'Compliance with legal and Contractual Requirements', 1, 23),
(119, 'Information Security Reviews', 2, 23),
(120, 'األمن السيرباين ضمن إدارة التغير  Management Change in Cybersecurity', 11, 1),
(121, 'إدارة المفاتيح Key management', 16, 2),
(122, 'حماية التطبيقات  Application Security', 17, 2),
(123, 'أمن تطوير الأنظمة  System Development Security', 18, 2),
(124, 'أمن وسائط التخزين  Storage Media Security', 19, 2),
(125, 'حمايه المنظم ومرافق المعالجة Facility Processing and System Protection', 20, 2),
(126, 'الإتلاف الآمن للبيانات secure Data Disposal', 21, 2),
(127, 'الأمن السيبراني للطابعات و الماسحات الضوئيه وآللات التصوير  Cybersecurity for printers,scanners and Copy machines', 22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED DEFAULT NULL,
  `view_type` int NOT NULL DEFAULT '1',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `risk_id`, `view_type`, `name`, `unique_name`, `type`, `size`, `timestamp`, `user`) VALUES
(2, NULL, 1, 'corporate_cybersecurity_policy_template_v1.0-ar.docx', 'docs/2/gpfUZXKmTPgyPgPLUurW5XbuoOzeVbYeD3MbPzpx.zip', NULL, 0, '2022-11-08 07:27:11', 0),
(3, NULL, 1, 'compliance_with_cybersecurity_legislation_and_regulations_policy_template_v1.0-ar.docx', 'docs/3/i4PsW92lpB6iNhIvdEq05lK0izmVtj5Q9jxfmyGD.zip', NULL, 0, '2022-11-08 07:28:18', 0),
(4, NULL, 1, 'configuration_and_hardening_policy_template_v1.0-ar.docx', 'docs/4/NAiyTd2JTB5z4kMfwxQmoFtxydsE7jxIVXUwHDDL.zip', NULL, 0, '2022-11-08 07:29:06', 0),
(5, NULL, 1, 'anti-malware_policy_template_v1.0-ar.docx', 'docs/5/wDOOqKY2Gd57u5gjd67d6i5BXsOaSrHyxRB4j8F4.docx', NULL, 0, '2022-11-08 07:29:54', 0),
(6, NULL, 1, 'servers_security_policy_template_v1.0-ar.docx', 'docs/6/ylYOsVEySK6dIcPzC0Y7f5NJ8CKhyaerSwR3wGTX.docx', NULL, 0, '2022-11-08 07:30:43', 0),
(7, NULL, 1, 'network_security_policy_template_v1.0-ar.docx', 'docs/7/VS3nZTQtitzpcbHrHvXs9USnmr9h8z5mT4T89ucy.zip', NULL, 0, '2022-11-08 07:31:21', 0),
(8, NULL, 1, 'email_security_policy_template_v1.0-ar.docx', 'docs/8/e2vEz3CP5TYeFv5aNuCDB6tKfqykWLkWCwdVkkaf.zip', NULL, 0, '2022-11-08 07:32:00', 0),
(9, NULL, 1, 'workstations_and_mobile_devices_and_byod_security_policy_template_v1.0-ar.docx', 'docs/9/IcAOJ9F0a9WvMWil4dYfcL9S8GkZJdwbffLHozLT.docx', NULL, 0, '2022-11-08 07:32:36', 0),
(10, NULL, 1, 'assets_acceptable_use_policy_template_v1.0-ar.docx', 'docs/10/lcGLN56hBfDA1s7g9FyvRXu5lFDqqZKFruz8z1Ge.zip', NULL, 0, '2022-11-08 07:33:16', 0),
(11, NULL, 1, 'نموذج-سياسة-مراجعة-وتدقيق-الأمن-السيبراني.docx', 'docs/11/DuIzaNJvQjKDp8hvV0i6OfJ3CV3pxu4ha3H773Wp.docx', NULL, 0, '2022-11-08 07:33:57', 0),
(12, NULL, 1, 'نموذج-سياسة-إدارة-هويات-الدخول-والصلاحيات.docx', 'docs/12/ouFHK9HShBxaUM2ngAGH6cTHpytbaxyK13MZeg1A.docx', NULL, 0, '2022-11-08 07:34:33', 0),
(13, NULL, 1, 'cybersecurity_policy_for_human_resources_template_v1.0-ar.docx', 'docs/13/1xYwicDEnbgDvRabz09JMjvd8WOGKwEHWLfeWLav.zip', NULL, 0, '2022-11-08 07:35:13', 0),
(14, NULL, 1, 'cybersecurity_event_logs_and_monitoring_management_policy_template_v1.0-ar.docx', 'docs/14/yIeLWtW3bmAdaGIFK25VVkaefkP8O2cAtl4Q7uoZ.zip', NULL, 0, '2022-11-08 07:35:47', 0),
(15, NULL, 1, 'patch_management_policy_template_v1.0-ar.docx', 'docs/15/Lk89D07i2SM1zzAmV1esEowGYJmvPjullX5WYcjQ.docx', NULL, 0, '2022-11-08 07:36:22', 0),
(16, NULL, 1, 'third-party_cybersecurity_policy_template_v1.0-ar.docx', 'docs/16/2OH31zIumJQ4l1FfG7zzEBQSk0PuOtVS77sYzrBE.docx', NULL, 0, '2022-11-08 07:37:05', 0),
(17, NULL, 1, 'Cybersecurity_Roles_and_Responsibilities_Template_v1.0.docx', 'docs/17/T2MoxHjcsXVZpG3AgrkpOymJ3dX4t6mUJtMXkrqP.docx', NULL, 0, '2022-11-08 07:38:17', 0),
(18, NULL, 1, 'Cybersecurity_Steering_Committee_Regulating_Document_Template_v1.0.docx', 'docs/18/OoLCE1Bg3R3iPDwiszK0sIJCOGzI0ajBGKHLmRk6.docx', NULL, 0, '2022-11-08 07:38:58', 0),
(19, NULL, 1, 'Penetration_Testing_Policy_Template_v1.0.docx', 'docs/19/5Nl24wr6ue4pgEIYPjicIcK8acIug5xXXbzCgurV.docx', NULL, 0, '2022-11-08 07:39:39', 0),
(20, NULL, 1, 'Vulnerabilities_Management_Policy_Template_v1.0.docx', 'docs/20/iam5KL85CvOxKHxHGcRpEi3n821z4tjgspR630De.zip', NULL, 0, '2022-11-08 07:40:23', 0),
(21, NULL, 1, 'Cybersecurity_Incident_and_Threat_Management_Policy_Template_v1.0.docx', 'docs/21/eRclQtEl2ffoOVBxzeYSn25qCnOAj6e3gEUcHUh6.zip', NULL, 0, '2022-11-08 07:41:49', 0),
(22, NULL, 1, 'Databases_Security_Policy_Template_v1.0.docx', 'docs/22/GFr1ktn60QiKNpBelsBR501OxaUEcyAlX5J7ZCeG.zip', NULL, 0, '2022-11-08 07:42:59', 0),
(23, NULL, 1, 'Web_Applications_Protection_Template_v1.0.docx', 'docs/23/9gYcdphJgl4tT7sIW3WeMIKVGHPLKswkLLWgwy9S.docx', NULL, 0, '2022-11-08 07:44:00', 0),
(24, NULL, 1, 'cybersecurity_strategy_template_v1.0.docx', 'docs/24/Xfbg7u52IIOufYzuYanbEAcjTStWxgr2X4KI4TMF.docx', NULL, 0, '2022-11-08 07:44:47', 0),
(25, NULL, 1, 'cybersecurity_organizational_structure_template_v1.0.docx', 'docs/25/g5eID9oqdLO94jUSuOv0qay6im0YVVq4ueDoLO6u.docx', NULL, 0, '2022-11-08 07:45:43', 0),
(26, NULL, 1, 'cybersecurity_industrial_controls_systems_policy_template_v1.0.docx', 'docs/26/dVvuROxEGUB5iEkcByenp8iks1vranf4Ml54oW2V.docx', NULL, 0, '2022-11-08 07:46:16', 0),
(27, NULL, 1, 'cryptography_policy_template_v1.0.docx', 'docs/27/nzz9t1zU8NzdUqwabbv7WAruXhJbgRpuKmIYYhp3.zip', NULL, 0, '2022-11-08 07:46:58', 0),
(31, NULL, 1, 'cybersecurity_risk_management_policy_template_v1.0.docx', 'docs/31/WHdo7lEMd7QyjlVa4HFTtUUJBuvYKVCQtBq07evV.docx', NULL, 0, '2022-11-08 07:51:14', 0),
(32, NULL, 1, 'cloud_computing_and_hosting_cybersecurity_policy_template_v1.0.docx', 'docs/32/zyq1XkLNIRRzvH57A9UPvlZSvFpwhvhTDUEfbtuX.zip', NULL, 0, '2022-11-08 07:51:50', 0),
(33, NULL, 1, 'cybersecurity_policy_for_business_continuity_template_v1.0.docx', 'docs/33/GGyXoPbqXXErZDKD6att5A64RQIuSd4VMLBm6oeg.zip', NULL, 0, '2022-11-08 07:52:29', 0),
(34, NULL, 1, 'cybersecurity_policy_for_physical_security_template_v1.0.docx', 'docs/34/pjHD1Q02ZCU1ETvXDYADHKhfGU9k2RScWLsDNlSe.zip', NULL, 0, '2022-11-08 07:53:05', 0),
(35, NULL, 1, 'networks_security_standard_template_v2.0.docx', 'docs/35/iLGIRdQTycAQ3VWm6Qi28EiY99mw0iKRvLNS7HkZ.docx', NULL, 0, '2022-11-08 07:56:02', 0),
(36, NULL, 1, 'email_protection_standard_template_v1.0.docx', 'docs/36/GR4KvHfGHXFGTHebNlivQKyt8viV2Q1rObdUi4AR.docx', NULL, 0, '2022-11-08 07:56:33', 0),
(37, NULL, 1, 'cybersecurity_event_logs_and_monitoring_management_standard_template_v1.0.docx', 'docs/37/JuzsIB39Jbgy9NLGdWEkOmsYFPVSJBKkHszIqQ8S.docx', NULL, 0, '2022-11-08 07:57:05', 0),
(38, NULL, 1, 'malware_protection_standard_template_v1.0.docx', 'docs/38/yOo49ViCbcIOmfSsbag3GWlkIQ0SnoOAYJFFRTXu.docx', NULL, 0, '2022-11-08 07:57:45', 0),
(39, NULL, 1, 'workstations_security_standard_template_v1.0.docx', 'docs/39/iSi83b1mFLxTcDYJNmvMm59pc5JbfALhCOFzS1bD.docx', NULL, 0, '2022-11-08 07:58:46', 0),
(40, NULL, 1, 'mobile_devices_security_standard_template_v2.0.docx', 'docs/40/KVvz05TuWPM2PXPVraOwHuI5ug5GnLVQeybFPg0r.docx', NULL, 0, '2022-11-08 08:01:03', 0),
(41, NULL, 1, 'servers_security_standard_template_v1.0.docx', 'docs/41/iW9VfnkpJqp3eb8zhi1RpBZNRCSyjqca6QDJBP3n.docx', NULL, 0, '2022-11-08 08:01:33', 0),
(42, NULL, 1, 'databases_security_standard_template_v1.0.docx', 'docs/42/8XbLd5iFJSTPzj4uwCKT3CEU5I5e99dS1P6rK1u1.docx', NULL, 0, '2022-11-08 08:02:58', 0),
(43, NULL, 1, 'vulnerabilities_management_standard_template_v1.0.docx', 'docs/43/nFQ2BO2PnF1pUyxaxAPJSRAsIYsfePFdIdLBWsk6.zip', NULL, 0, '2022-11-08 08:04:02', 0),
(44, NULL, 1, 'cybersecurity_incident_and_threat_management_standard_template_v1.0.docx', 'docs/44/1DtqkIqOnEFTAbyaXOF906N4UfD5rFGiAb1No3Sq.zip', NULL, 0, '2022-11-08 08:05:22', 0),
(45, NULL, 1, 'نموذج-معيار-اختبار-الاختراق.docx', 'docs/45/LC00om0aSw9tZA9Wsiiw2Yt5CUakqRVboheGHhbw.docx', NULL, 0, '2022-11-08 08:05:55', 0),
(46, NULL, 1, 'secure_coding_standard_template_v1.0.docx', 'docs/46/xjWyd9aEhgMWdNEcXTWvib1h6jZuz6xJMPpBCTyf.zip', NULL, 0, '2022-11-08 08:06:29', 0),
(47, NULL, 1, 'web_applications_protection_standard_template_v1.0.docx', 'docs/47/DVXOPiZ8bWb37y6DSmekKihCWcSefJbhSCJqlCUh.zip', NULL, 0, '2022-11-08 08:07:04', 0),
(48, NULL, 1, 'cryptography_standard_template_v1.0.docx', 'docs/48/aGLro0oWaCSb5GClTrnm4kz5v2sDQ0dsgVIsozo0.zip', NULL, 0, '2022-11-08 08:07:45', 0),
(49, NULL, 1, 'نموذج-معيار-أمن-الشبكات-اللاسلكية(002).docx', 'docs/49/kzEI7kx7fhlkKmsRJRHNNCBLAnm5oJdLDMhGv91Q.docx', NULL, 0, '2022-11-08 08:08:25', 0),
(50, NULL, 1, 'color.pdf', 'security_awareness/1/Or3r6vM15p6SqfkFAybMvMwEj7X0O4kf42Atc9TK.pdf', NULL, 0, '2022-11-09 20:33:47', 0),
(51, NULL, 1, 'color.pdf', 'security_awareness/2/7xz3kWM7NV4HYQGgYHdmvLLTgdgbKrtrla9kit7k.pdf', NULL, 0, '2022-11-09 20:42:37', 0),
(52, NULL, 1, 'Mustafa_Software_Tester.pdf', 'security_awareness/3/KJx7ME7bgbjo7f5hjHnQadSVTfOCvKzZ5mXUIijn.pdf', NULL, 0, '2022-11-09 21:10:03', 0),
(53, NULL, 1, 'بروشور سايبر مود out.pdf', 'security_awareness/4/yrXpHqMrEJpyUhgQPg9opxMdpYGoTLfIoQlmDPEd.pdf', NULL, 0, '2022-11-13 10:22:40', 0),
(58, NULL, 1, 'cscc-ar.pdf', 'security_awareness/5/V1L6vhtBQngUVSsljV9GmxCp8Wdw6B0RnipVEVjA.pdf', NULL, 0, '2022-11-20 12:07:17', 0),
(59, NULL, 1, 'Summary of results for evaluation and compliance report.pdf', 'security_awareness/6/jyx6aDsdLVhZZx1vDTGnKOKmCfpnOh3hdQWiMf2y.pdf', NULL, 0, '2022-12-01 13:42:02', 0),
(64, NULL, 1, 'test.php', 'docs/53/zawgCQSPAhzptmVjgxWlW0jLUTHxWsBjK6riTQWL.txt', NULL, 0, '2023-01-05 07:46:18', 0),
(65, NULL, 1, 'Screenshot 2022-12-10 at 5.41.04 PM.png', 'docs/54/743gd6BucjUjTaFxFxC32YMvAND6pY3iA7O2PpGG.png', NULL, 0, '2023-01-31 08:51:50', 0),
(66, NULL, 1, 'تقرير ارشيف القبول.pdf', 'security_awareness/7/QHK02YoOsSEITeNbKBKbqooOB8fteUiRbzHJrxaj.pdf', NULL, 0, '2023-01-31 14:42:33', 0),
(68, NULL, 1, '1.png', 'docs/55/ltxTuMR2Kd3iKQq0emHsFPiNq2TLqpvAQOmgnfrI.png', NULL, 0, '2023-01-31 14:55:23', 0),
(69, NULL, 1, 'تقرير ارشيف القبول.pdf', 'security_awareness/8/NPWuARtN5J4oFSSgSzMKYediJk0ds9vxjIwPgA9O.pdf', NULL, 0, '2023-01-31 14:57:08', 0),
(70, NULL, 1, 'ICDL Health Information Systems Usage Syllabus Version PDF Free Download.pdf', 'security_awareness/9/nrCfL2I0euFSatH9od9ScICsdH3cZOdZef2LMylH.pdf', NULL, 0, '2023-02-05 09:47:38', 0),
(71, NULL, 1, 'DigitalOcean Payment Receipt #98268813.pdf', 'security_awareness/10/qmp8XglRGXJ2tPZy9bCnYGccL6hpEMlYl3leRA2e.pdf', NULL, 0, '2023-02-05 09:52:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `file_tasks`
--

CREATE TABLE `file_tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `display_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_types`
--

CREATE TABLE `file_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_types`
--

INSERT INTO `file_types` (`id`, `name`) VALUES
(21, 'application/csv'),
(18, 'application/force-download'),
(16, 'application/msword'),
(11, 'application/octet-stream'),
(19, 'application/pdf'),
(15, 'application/vnd.ms-excel'),
(8, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
(7, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
(17, 'application/x-gzip'),
(6, 'application/x-pdf'),
(9, 'application/zip'),
(1, 'image/gif'),
(5, 'image/jpeg'),
(2, 'image/jpg'),
(3, 'image/png'),
(4, 'image/x-png'),
(14, 'text/comma-separated-values'),
(20, 'text/csv'),
(12, 'text/plain'),
(10, 'text/rtf'),
(13, 'text/xml');

-- --------------------------------------------------------

--
-- Table structure for table `file_type_extensions`
--

CREATE TABLE `file_type_extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_type_extensions`
--

INSERT INTO `file_type_extensions` (`id`, `name`) VALUES
(12, 'csv'),
(14, 'doc'),
(16, 'dot'),
(6, 'dotx'),
(1, 'gif'),
(15, 'gz'),
(4, 'jpeg'),
(2, 'jpg'),
(5, 'pdf'),
(3, 'png'),
(9, 'rtf'),
(10, 'txt'),
(18, 'xla'),
(13, 'xls'),
(7, 'xlsx'),
(17, 'xlt'),
(11, 'xml'),
(8, 'zip');

-- --------------------------------------------------------

--
-- Table structure for table `frameworks`
--

CREATE TABLE `frameworks` (
  `id` bigint UNSIGNED NOT NULL,
  `parent` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `order` int DEFAULT NULL,
  `last_audit_date` date DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `desired_frequency` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frameworks`
--

INSERT INTO `frameworks` (`id`, `parent`, `name`, `description`, `icon`, `status`, `order`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `created_at`, `updated_at`) VALUES
(1, NULL, 'NCA-ECC – 1: 2018', 'The National Cybersecurity Authority “NCA” has developed the Essential Cybersecurity Controls (ECC – 1: 2018) to set the minimum cybersecurity requirements based on best practices and standards to minimize the cybersecurity risks to the information and technical assets of organizations that originate from internal and external threats. The Essential Cybersecurity Controls consist of 114 main controls, divided into five main domains.', 'fa-universal-access', 1, NULL, NULL, NULL, NULL, '2022-11-07 18:00:36', '2022-11-07 18:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `framework_controls`
--

CREATE TABLE `framework_controls` (
  `id` bigint UNSIGNED NOT NULL,
  `short_name` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supplemental_guidance` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `control_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control_status` enum('Not Applicable','Not Implemented','Partially Implemented','Implemented') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Applicable',
  `family` bigint UNSIGNED NOT NULL,
  `control_owner` bigint UNSIGNED DEFAULT NULL,
  `desired_maturity` bigint UNSIGNED DEFAULT NULL,
  `control_priority` bigint UNSIGNED DEFAULT NULL,
  `control_class` bigint UNSIGNED DEFAULT NULL,
  `control_maturity` bigint UNSIGNED DEFAULT '1',
  `control_phase` bigint UNSIGNED DEFAULT NULL,
  `control_type` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_audit_date` date DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `desired_frequency` int DEFAULT NULL,
  `mitigation_percent` int DEFAULT '0',
  `status` int DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_controls`
--

INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(5, 'ECC 1-1-1', 'ECC 1-1-1', 'يجب تحديد وتوثيق واعتماد إستراتيجية الامـن السيبراني للجهة ودعمها من قبل رئيس الجهة أو من\r\nينيبه ويشار له في هذه الضوابط بـاسم »صاحب الصلاحية« وأن تتماشى الاهداف الاستراتيجية للامن\r\nالسيبراني للجهة مع المتطلبات التشريعية والتنظيمية ذات العلاقة', NULL, 'ECC 1-1-1', 'Not Applicable', 24, 1, 3, NULL, NULL, 6, NULL, NULL, NULL, '2022-11-08 11:37:38', NULL, NULL, NULL, 50, 1, 0, NULL, NULL),
(6, 'ECC 1-1-2', 'ECC 1-1-2', 'يجب العمل على تنفيذ خطة عمل لتطبيق إستراتيجية الامن السيبراني من قبل الجهة', NULL, 'ECC 1-1-2', 'Partially Implemented', 24, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 11:38:55', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(7, 'ECC 1-1-3', 'ECC 1-1-3', 'يجب مراجعة إستراتيجية الامن السيبراني على فترات زمنية مخطط لها أو في حالة حدوث تغييرات في\r\nالمتطلبات التشريعية والتنظيمية ذات العلاقة', NULL, 'ECC 1-1-3', 'Not Applicable', 24, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 11:55:33', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(8, 'ECC 1-2-1', 'ECC 1-2-1', 'يجب إنشاء إدارة معنية بالامن السيبراني في الجهة مستقلة عن إدارة تقنية المعلومات والاتصالات وفقا للأمر السامي الكريم  رقم 37140  وتاريخ 14 / 8 / 1438 هـ. ويفضل ارتباطها مباشرة برئيس (ICT/ IT)\r\n وفقا للجهة أو من ينيبه، مع الاخذ بالاعتبار عدم تعارض المصالح.', NULL, 'ECC 1-2-1', 'Not Applicable', 25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 11:56:54', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(9, 'ECC 1-2-2', 'ECC 1-2-2', 'يجب أن يشغل رئاسة الادارة المعنية بالامن السيبراني والوظائف الاشرافية والحساسة بها مواطنون\r\n متفرغون وذو كفاءة عالية في مجال الامن السيبراني.', NULL, 'ECC 1-2-2', 'Not Applicable', 25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 11:58:03', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(10, 'ECC 1-2-3', 'ECC 1-2-3', 'يجب إنشاء لجنة إشرافية للامن السيبراني بتوجيه من صاحب الصلاحية للجهة لضمان التزام ودعم ومتابعة\r\nتطبيق برامج وتشريعات الامن السيبراني، ويتم تحديد وتوثيق واعتماد أعضاء اللجنة ومسؤولياتها وإطار\r\nحوكمة أعمالها على أن يكون رئيس الادارة المعنية بالامن السيبراني أحد أعضائها. ويفضل ارتباطها مباشرة\r\nبرئيس الجهة أو من ينيبه، مع الاخذ بالاعتبار عدم تعارض المصالح', NULL, 'ECC 1-2-3', 'Not Applicable', 25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 11:59:13', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(11, 'ECC 1-3-1', 'ECC 1-3-1', 'يجب على الادارة المعنية بالامن السيبراني في الجهة تحديد سياسات وإجـراءات الامن السيبراني وما\r\nتشمله من ضوابط ومتطلبات الامن السيبراني، وتوثيقها واعتمادها من قبل صاحب الصلاحية في الجهة،\r\nكما يجب نشرها إلى ذوي العلاقة من العاملين في الجهة والاطراف المعنية بها.', NULL, 'ECC 1-3-1', 'Not Applicable', 26, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:05:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(12, 'ECC 1-3-2', 'ECC 1-3-2', 'يجب على الادارة المعنية بالامن السيبراني ضمان تطبيق سياسات وإجراءات الامن السيبراني في الجهة\r\nوما تشمله من ضوابط ومتطلبات.', NULL, 'ECC 1-3-2', 'Not Applicable', 26, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:05:56', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(13, 'ECC 1-3-3', 'ECC 1-3-3', 'يجب أن تكون سياسات وإجراءات الامن السيبراني مدعومة بمعايير تقنية أمنية )على سبيل المثال: المعايير\r\n التقنية المنية لجدار الحماية وقواعد البيانات، وأنظمة التشغيل، إلخ(', NULL, 'ECC 1-3-3', 'Not Applicable', 26, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:06:55', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(14, 'ECC 1-3-4', 'ECC 1-3-4', 'يجب مراجعة سياسات وإجــراءات ومعايير الامـن السيبراني وتحديثها على فترات زمنية مخطط لها )أو\r\nفي حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية والمعايير ذات العلاقة(، كما يجب توثيق\r\nالتغييرات واعتمادها.', NULL, 'ECC 1-3-4', 'Not Applicable', 26, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:07:43', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(15, 'ECC 1-4-1', 'ECC 1-4-1', 'يجب على صاحب الصلاحية تحديد وتوثيق واعتماد الهيكل التنظيمي للحوكمة والادوار والمسؤوليات\r\nالخاصة بالامن السيبراني للجهة، وتكليف الاشخاص المعنيين بها، كما يجب تقديم الدعم اللزم لنفاذ\r\nذلك، مع الاخذ بالاعتبار عدم تعارض المصالح', NULL, 'ECC 1-4-1', 'Not Applicable', 27, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:08:42', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(16, 'ECC 1-4-2', 'ECC 1-4-2', 'يجب مراجعة أدوار ومسؤوليات الامن السيبراني في الجهة وتحديثها على فترات زمنية مخطط لها )أو في\r\n حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية ذات العلقة(.', NULL, 'ECC 1-4-2', 'Not Applicable', 27, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:09:35', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(17, 'ECC 1-5-1', 'ECC 1-5-1', 'يجب على الادارة المعنية بالامن السيبراني في الجهة تحديد وتوثيق واعتماد منهجية وإجـراءات إدارة\r\nمخاطر الامن السيبراني في الجهة. وذلك وفقاً لعتبارات السرية وتوافر وسلامة الاصول المعلوماتية\r\nوالتقنية', NULL, 'ECC 1-5-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:11:19', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(18, 'ECC 1-5-2', 'ECC 1-5-2', 'يجب على الادارة المعنية بالامن السيبراني تطبيق منهجية وإجـراءات إدارة مخاطر الامن السيبراني في\r\nالجهة', NULL, 'ECC 1-5-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:12:19', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(19, 'ECC 1-5-3', 'ECC 1-5-3', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني', NULL, 'ECC 1-5-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:13:09', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(20, 'ECC 1-5-3-1', 'ECC 1-5-3-1', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني في مرحلة مبكرة من المشاريع التقنية', NULL, 'ECC 1-5-3-1', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, 19, '2022-11-08 12:16:48', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(21, 'ECC 1-5-3-2', 'ECC 1-5-3-2', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني   قبل إجراء تغيير جوهري في البنية التقنية', NULL, 'ECC 1-5-3-2', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, 19, '2022-11-08 12:18:33', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(22, 'ECC 1-5-3-3', 'ECC 1-5-3-3', 'يجب تنفيذ إجراءات تقييم مخاطر الامن السيبراني عند التخطيط للحصول على خدمات طرف خارجي', NULL, 'ECC 1-5-3-3', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, 19, '2022-11-08 12:19:42', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(23, 'ECC 1-5-3-4', 'ECC 1-5-3-4', 'يجب تنفيذ إجراءات تقييم مخاطر الأمن السيبراني  عند التخطيط وقبل إطلق منتجات وخدمات تقنية جديدة.', NULL, 'ECC 1-5-3-4', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, 19, '2022-11-08 12:21:04', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(24, 'ECC 1-5-4', 'ECC 1-5-4', 'يجب مراجعة منهجية وإجراءات إدارة مخاطر الامن السيبراني وتحديثها على فترات زمنية مخطط لها )أو\r\nفي حالة حدوث تغييرات في المتطلبات التشريعية والتنظيمية والمعايير ذات العلاقة(، كما يجب توثيق\r\nالتغييرات واعتمادها.', NULL, 'ECC 1-5-4', 'Not Applicable', 28, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:27:02', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(25, 'ECC 1-6-1', 'ECC 1-6-1', 'يجب تضمين متطلبات الامـن السيبراني في منهجية وإجــراءات إدارة المشاريع وفي إدارة التغيير على\r\nالاصول المعلوماتية والتقنية في الجهة لضمان تحديد مخاطر الامن السيبراني ومعالجتها كجزء من دورة\r\nحياة المشروع التقني، وأن تكون متطلبات الامن السيبراني جزء أساسي من متطلبات المشاريع التقنية.', NULL, 'ECC 1-6-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:33:59', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(26, 'ECC 1-6-2', 'ECC 1-6-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع والتغييرات على الاصول المعلوماتية والتقنية\r\nللجهة', NULL, 'ECC 1-6-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:35:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(27, 'ECC 1-6-2-1', 'ECC 1-6-2-1', 'يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع \r\n والتغييرات على الاصول المعلوماتية والتقنية  تقييم الثغرات ومعالجتها', NULL, 'ECC 1-6-2-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2022-11-08 12:39:58', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(28, 'ECC 1-6-2-2', 'ECC 1-6-2-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة المشاريع والتغييرات على الاصول المعلوماتية والتقنية\r\nللجهة  وحـزم( Secure Confguration and Hardening( والتحصين لـإعـدادات مراجعة اجــراء \r\nالتحديثات قبل إطلق وتدشين المشاريع والتغييرات.', NULL, 'ECC 1-6-2-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2022-11-08 12:41:45', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(29, 'ECC 1-6-3', 'ECC 1-6-3', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة', NULL, 'ECC 1-6-3', 'Not Implemented', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 12:47:26', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(30, 'ECC 1-6-3-1', 'ECC 1-6-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى )Secure Coding Standards( للتطبيقات الامن التطوير معايير ا', NULL, 'ECC 1-6-3-1', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 29, '2022-11-08 12:48:40', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(31, 'ECC 1-6-3-2', 'ECC 1-6-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى استخدام مصادر مرخصة وموثوقة لادوات تطوير التطبيقات والمكتبات الخاصة بها )Libraries.)', NULL, 'ECC 1-6-3-2', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 29, '2022-11-08 12:49:58', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(32, 'ECC 1-6-3-3', 'ECC 1-6-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى اجراء اختبار للتحقق من مدى استيفاء التطبيقات للمتطلبات الامنية السيبرانية للجهة.', NULL, 'ECC 1-6-3-3', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 29, '2022-11-08 12:51:01', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(33, 'ECC 1-6-3-4', 'ECC 1-6-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى  التطبيقات بين( Integration( التكامل أم', NULL, 'ECC 1-6-3-4', 'Not Implemented', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 29, '2022-11-08 12:53:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(34, 'ECC 1-6-3-5', 'ECC 1-6-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لمشاريع تطوير التطبيقات والبرمجيات الخاصة للجهة بحد أدنى وحـزم( Secure Confguration and Hardening( والتحصين لـإعـدادات مراجعة اج التحديثات قبل إطلق وتدشين التطبيقات', NULL, 'ECC 1-6-3-5', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, 29, '2022-11-08 12:54:17', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(35, 'ECC 1-7-1', 'ECC 1-7-1', 'يجب على الجهة الالتزام بالمتطلبات التشريعية والتنظيمية الوطنية المتعلقة بالامن السيبراني', NULL, 'ECC 1-7-1', 'Not Applicable', 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:15:10', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(36, 'ECC 1-7-2', 'ECC 1-7-2', 'في حال وجود اتفاقيات أو إلتزامات دولية معتمدة محلياً تتضمن متطلبات خاصة بالامن السيبراني، فيجب\r\nعلى الجهة الالتزام بتلك المتطلبات.', NULL, 'ECC 1-7-2', 'Not Applicable', 30, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:18:33', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(37, 'ECC 1-8-1', 'ECC 1-8-1', 'يجب على الادارة المعنية بالامن السيبراني في الجهة مراجعة تطبيق ضوابط الامن السيبراني دورياً.', NULL, 'ECC 1-8-1', 'Not Applicable', 31, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:22:23', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(38, 'ECC 1-8-2', 'ECC 1-8-2', 'يجب مراجعة وتدقيق تطبيق ضوابط الامن السيبراني في الجهة، من قبل أطراف مستقلة عن الادارة\r\nالمعنية بالمن السيبراني )مثل الادارة المعنية بالمراجعة في الجهة(. على أن تتم المراجعة والتدقيق\r\nبشكل مستقل يراعى فيه مبدأ عدم تعارض المصالح، وذلك وفقاً للمعايير العامة المقبولة للمراجعة\r\nوالتدقيق والمتطلبات التشريعية والتنظيمية ذات العلاقة.', NULL, 'ECC 1-8-2', 'Not Applicable', 31, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:23:14', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(39, 'ECC 1-8-3', 'ECC 1-8-3', 'يجب توثيق نتائج مراجعة وتدقيق الامـن السيبراني، وعرضها على اللجنة الشرافية للامن السيبراني\r\nوصاحب الصلاحية. كما يجب أن تشتمل النتائج على نطاق المراجعة والتدقيق، والملاحظات المكتشفة،\r\nوالتوصيات والجراءات التصحيحية، وخطة معالجة الملاحظات.', NULL, 'ECC 1-8-3', 'Not Applicable', 31, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:24:15', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(40, 'ECC 1-9-1', 'ECC 1-9-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني المتعلقة بالعاملين قبل توظيفهم وأثناء عملهم\r\nوعند انتهاء/إنهاء عملهم في الجهة', NULL, 'ECC 1-9-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:25:32', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(41, 'ECC 1-9-2', 'ECC 1-9-2', 'يجب تطبيق متطلبات الامن السيبراني المتعلقة بالعاملين في الجهة.', NULL, 'ECC 1-9-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:26:31', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(42, 'ECC 1-9-3', 'ECC 1-9-3', 'يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة', NULL, 'ECC 1-9-3', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:27:29', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(43, 'ECC 1-9-3-1', 'ECC 1-9-3-1', 'يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة تـضـمـيـن مــســؤولــيــات الامـــــن الــســيــبــرانــي وبـــنـــود الــمــحــافــظــة عــلــى ســريــة الـمـعـلـومـات\r\n)Clauses Disclosure-Non )في عقود العاملين في الجهة )لتشمل خلال وبعد انتهاء/إنهاء\r\nالعلقة الوظيفية مع الجهة(', NULL, 'ECC 1-9-3-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, 42, '2022-11-08 13:29:20', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(44, 'ECC 1-9-3-2', 'ECC 1-9-3-2', 'يجب أن تغطي متطلبات الامن السيبراني قبل بدء علاقة العاملين المهنية بالجهة   إجراء المسح الامني )Vetting or Screening )للعاملين في وظائف الامن السيبراني والوظائف\r\nالتقنية ذات الصلاحيات الهامة والحساسة', NULL, 'ECC 1-9-3-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, 42, '2022-11-08 13:30:29', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(45, 'ECC 1-9-4', 'ECC 1-9-4', 'يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة', NULL, 'ECC 1-9-4', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:31:31', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(46, 'ECC 1-9-4-1', 'ECC 1-9-4-1', 'يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة  التوعية بالامن السيبراني )عند بداية المهنة الوظيفية وخلالها(.', NULL, 'ECC 1-9-4-1', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, 45, '2022-11-08 13:33:03', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(47, 'ECC 1-9-4-2', 'ECC 1-9-4-2', 'يجب أن تغطي متطلبات الامن السيبراني خلل علاقة العاملين المهنية بالجهة  تطبيق متطلبات الامـن السيبراني والالـتـزام بها وفقاً لسياسات وإجـــراءات وعمليات الامن\r\nالسيبراني للجهة', NULL, 'ECC 1-9-4-2', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, 45, '2022-11-08 13:34:21', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(48, 'ECC 1-9-5', 'ECC 1-9-5', 'يجب مراجعة وإلغاء الصلاحيات للعاملين مباشرة بعد انتهاء/إنهاء الخدمة المهنية لهم بالجهة.', NULL, 'ECC 1-9-5', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:37:25', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(49, 'ECC 1-9-6', 'ECC 1-9-6', 'يجب مراجعة متطلبات الامن السيبراني المتعلقة بالعاملين في الجهة دوري', NULL, 'ECC 1-9-6', 'Not Applicable', 32, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:38:20', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(50, 'ECC 1-10-1', 'ECC 1-10-1', 'يجب تطوير واعتماد برنامج للتوعية بالامن السيبراني في الجهة من خلل قنوات متعددة دورياً، وذلك لتعزيز الوعي بالامن السيبراني وتهديداته ومخاطره، وبناء ثقافة إيجابية للامن السيبراني.', NULL, 'ECC 1-10-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:39:36', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(51, 'ECC 1-10-2', 'ECC 1-10-2', 'يجب تطبيق البرنامج المعتمد للتوعية بالامن السيبراني في الجهة', NULL, 'ECC 1-10-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:40:26', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(52, 'ECC 1-10-3', 'ECC 1-10-3', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها', NULL, 'ECC 1-10-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:41:35', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(53, 'ECC 1-10-3-1', 'ECC 1-10-3-1', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها بما في ذلك: التعامل الامن مع خدمات البريد اللكتروني خصوصاً مع رسائل التصيد الالكتروني', NULL, 'ECC 1-10-3-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, 52, '2022-11-08 13:42:58', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(54, 'ECC 1-10-3-2', 'ECC 1-10-3-2', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها، بما في ذلك التعامل الامن مع الجهزة المحمولة ووسائط التخزين.', NULL, 'ECC 1-10-3-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, 52, '2022-11-08 13:44:04', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(55, 'ECC 1-10-3-4', 'ECC 1-10-3-4', 'يجب أن يغطي برنامج التوعية بالامن السيبراني كيفية حماية الجهة من أهم المخاطر والتهديدات السيبرانية\r\nوما يستجد منها، بما في ذلك التعامل الامن مع وسائل التواصل الاجتماعي.', NULL, 'ECC 1-10-3-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, 52, '2022-11-08 13:44:57', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(56, 'ECC 1-10-4', 'ECC 1-10-4', 'يجب توفير المهارات المتخصصة والتدريب الازم للعاملين في المجلالت الوظيفية ذات العلاقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني', NULL, 'ECC 1-10-4', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:46:04', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(57, 'ECC 1-10-4-1', 'ECC 1-10-4-1', 'يجب توفير المهارات المتخصصة والتدريب اللزم للعاملين في المجالت الوظيفية ذات العلقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك  موظفو الادارة المعنية بالامن السيبراني', NULL, 'ECC 1-10-4-1', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, 56, '2022-11-08 13:48:07', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(58, 'ECC 1-10-4-3', 'ECC 1-10-4-3', 'جب توفير المهارات المتخصصة والتدريب الازم للعاملين في المجلالت الوظيفية ذات العلقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك الاشرافية الوظائف', NULL, 'ECC 1-10-4-3', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, 56, '2022-11-08 13:50:06', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(59, 'ECC 1-10-4-2', 'ECC 1-10-4-2', 'يجب توفير المهارات المتخصصة والتدريب اللازم للعاملين في المجالت الوظيفية ذات العلاقة المباشرة\r\nبالامن السيبراني في الجهة، وتصنيفها بما يتماشى مع مسؤولياتهم الوظيفية فيما يتعلق بالامن\r\nالسيبراني، بما في ذلك الموظفون العاملون في تطوير البرامج والتطبيقات والموظفون المشغلون للاصول المعلوماتية\r\nوالتقنية للجهة', NULL, 'ECC 1-10-4-2', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, 56, '2022-11-08 13:51:12', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(60, 'ECC 1-10-5', 'ECC 1-10-5', 'يجب مراجعة تطبيق برنامج التوعية بالامن السيبراني في الجهة دوريا', NULL, 'ECC 1-10-5', 'Not Applicable', 33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:53:24', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(61, 'ECC 2-1-1', 'ECC 2-1-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني الادارة الاصول المعلوماتية والتقنية للجهة.', NULL, 'ECC 2-1-1', 'Not Applicable', 34, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:54:46', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(62, 'ECC 2-1-2', 'ECC 2-1-2', 'يجب تطبيق متطلبات الامن السيبراني الادارة الاصول المعلوماتية والتقنية للجهة', NULL, 'ECC 2-1-2', 'Not Applicable', 34, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:56:04', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(63, 'ECC 2-1-3', 'ECC 2-1-3', 'يجب تحديد وتوثيق واعتماد ونشر سياسة الستخدام المقبول للاصول المعلوماتية والتقنية للجهة', NULL, 'ECC 2-1-3', 'Not Applicable', 34, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:56:46', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(64, 'ECC 2-1-4', 'ECC 2-1-4', 'يجب تطبيق سياسة الاستخدام المقبول للاصول المعلوماتية والتقنية للجهة', NULL, 'ECC 2-1-4', 'Not Applicable', 34, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:57:53', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(65, 'ECC 2-1-5', 'ECC 2-1-5', 'يجب تصنيف الاصول المعلوماتية والتقنية للجهة وترميزها )Labeling )والتعامل معها وفقاً للمتطلبات\r\nالتشريعية والتنظيمية ذات العلاقة', NULL, 'ECC 2-1-5', 'Not Applicable', 34, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:58:47', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(66, 'ECC 2-1-6', 'ECC 2-1-6', 'يجب مراجعة متطلبات الامن السيبراني لادارة الاصول المعلوماتية والتقنية للجهة دورياً', NULL, 'ECC 2-1-6', 'Not Applicable', 34, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 13:59:18', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(67, 'ECC 2-2-1', 'ECC 2-2-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة', NULL, 'ECC 2-2-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:05:49', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(68, 'ECC 2-2-2', 'ECC 2-2-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة', NULL, 'ECC 2-2-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:06:48', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(69, 'ECC 2-2-3', 'ECC 2-2-3', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة', NULL, 'ECC 2-2-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:07:45', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(70, 'ECC 2-2-3-1', 'ECC 2-2-3-1', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  بناء( User Authentication( المستخدم هوية من ا  على إدارة تسجيل المستخدم وإدارة كلمة المرور', NULL, 'ECC 2-2-3-1', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, 69, '2022-11-08 14:09:36', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(71, 'ECC 2-2-3-2', 'ECC 2-2-3-2', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  التحقق من الهوية متعدد العناصر )Authentication Factor-Multi )لعمليات الدخول عن بعد', NULL, 'ECC 2-2-3-2', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, 69, '2022-11-08 14:10:41', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(72, 'ECC 2-2-3-3', 'ECC 2-2-3-3', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى   إدارة تصاريح وصلاحيات المستخدمين )Authorization )بناء على مبادئ التحكم بالدخول ،\"Need-to-know and Need-to-use\" والستخدام المعرفة إلى الحاجة مبدأ )و  ومـبـدأ الحد الادنــى مـن الصلاحيات والامـتـيـازات \"Privilege Least ،\"ومـبـدأ فصل المهام  .)\"Segregation of Duties\"', NULL, 'ECC 2-2-3-3', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, 69, '2022-11-08 14:13:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(73, 'ECC 2-2-3-4', 'ECC 2-2-3-4', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  .)Privileged Access Management( والحساسة الهامة الاصلاحى  .)Privileged Access Management( والحساسة الهامة الصلاحيايات الإدارة', NULL, 'ECC 2-2-3-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, 69, '2022-11-08 14:14:23', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(74, 'ECC 2-2-3-5', 'ECC 2-2-3-5', 'يجب أن تغطي متطلبات الامن السيبراني المتعلقة بـإدارة هويات الدخول والصلاحيات في الجهة بحد\r\nأدنى  المراجعة الدورية لهويات الدخول والصلاحيات', NULL, 'ECC 2-2-3-5', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, 69, '2022-11-08 14:17:12', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(75, 'ECC 2-2-4', 'ECC 2-2-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة هويات الدخول والصلاحيات في الجهة دورياً', NULL, 'ECC 2-2-4', 'Not Applicable', 35, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:18:21', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(76, 'ECC 2-3-1', 'ECC 2-3-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة', NULL, 'ECC 2-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:41:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(77, 'ECC 2-3-2', 'ECC 2-3-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة.', NULL, 'ECC 2-3-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:42:46', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(78, 'ECC 2-3-3', 'ECC 2-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة', NULL, 'ECC 2-3-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 14:43:34', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(79, 'ECC 2-3-3-1', 'ECC 2-3-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  الحماية من الفيروسات والبرامج والنشطة المشبوهة والبرمجيات الضارة )Malware )على\r\nأجهزة المستخدمين والخوادم باستخدام تقنيات وآليات الحماية الحديثة والمتقدمة، وإدارتها\r\nبشكل آمن', NULL, 'ECC 2-3-3-1', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, 78, '2022-11-08 15:01:14', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(80, 'ECC 2-3-3-2', 'ECC 2-3-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  التقييد الحازم لستخدام أجهزة وسائط التخزين الخارجية والامن المتعلق بها.', NULL, 'ECC 2-3-3-2', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, 78, '2022-11-08 15:02:30', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(81, 'ECC 2-3-3-3', 'ECC 2-3-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى إدارة حزم التحديثات والصلاحات للمنظمة والتطبيقات والاجهزة )Management Patch.', NULL, 'ECC 2-3-3-3', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, 78, '2022-11-08 15:03:21', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(82, 'ECC 2-3-3-4', 'ECC 2-3-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة بحد أدنى  مزامنة التوقيت )Synchronization Clock )مركزياً ومن مصدر دقيق وموثوق، ومن هذه\r\nالمصادر ما توفره الهيئة السعودية للمواصفات والمقاييس والجودة.', NULL, 'ECC 2-3-3-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, 78, '2022-11-08 15:04:08', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(83, 'ECC 2-3-4', 'ECC 2-3-4', 'يجب مراجعة متطلبات الامن السيبراني لحماية المنظمة وأجهزة معالجة المعلومات للجهة دورياً', NULL, 'ECC 2-3-4', 'Not Applicable', 36, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-08 15:05:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(84, 'ECC 2-4-1', 'ECC 2-4-1', 'جب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة.', NULL, 'ECC 2-4-1', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:03:26', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(85, 'ECC 2-4-2', 'ECC 2-4-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة', NULL, 'ECC 2-4-2', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:04:13', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(86, 'ECC 2-4-3', 'ECC 2-4-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة', NULL, 'ECC 2-4-3', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:10:21', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(87, 'ECC 2-4-3-1', 'ECC 2-4-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى  تحليل وتصفية )Filtering ) ّ رسـائـل البريد الالكتروني )وخـصـوصـاً رسـائـل التصيد الالكتروني\r\n»Emails Phishing »والرسائل القتحامية »Emails Spam )»باستخدام تقنيات وآليات\r\nالحماية الحديثة والمتقدمة للبريد الالكتروني.', NULL, 'ECC 2-4-3-1', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, 86, '2022-11-09 08:11:53', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(88, 'ECC 2-4-3-2', 'ECC 2-4-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى التحقق من الهوية متعدد العناصر )Authentication Factor-Multi )للدخول عن بعد والدخول\r\nعن طريق صفحة موقع البريد الالكتروني )Webmail.', NULL, 'ECC 2-4-3-2', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, 86, '2022-11-09 08:18:46', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(89, 'ECC 2-4-3-3', 'ECC 2-4-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى النسخ الاحتياطي والرشفة للبريد الالكتروني.', NULL, 'ECC 2-4-3-3', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, 86, '2022-11-09 08:20:24', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(90, 'ECC 2-4-3-4', 'ECC 2-4-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى لحماية من التهديدات المتقدمة المستمرة )Protection APT ،)التي تستخدم عادة الفيروسات\r\nوالبرمجيات الضارة غير المعروفة مسبقاً )Malware Day-Zero ،)وإدارتها بشكل آمن', NULL, 'ECC 2-4-3-4', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, 86, '2022-11-09 08:21:41', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(91, 'ECC 2-4-3-5', 'ECC 2-4-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البريد الالكتروني للجهة بحد أدنى توثيق مجال البريد الالكتروني للجهة بالطرق التقنية، مثل طريقة إطار سياسة المرسل )Sender\r\n.)Policy Framework', NULL, 'ECC 2-4-3-5', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, 86, '2022-11-09 08:26:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(92, 'ECC 2-4-4', 'ECC 2-4-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني الخاصة بحماية البريد الالكتروني للجهة دورياً.', NULL, 'ECC 2-4-4', 'Not Applicable', 37, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:26:59', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(93, 'ECC 2-5-1', 'ECC 2-5-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة أمن شبكات الجهة.', NULL, 'ECC 2-5-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:44:42', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(94, 'ECC 2-5-2', 'ECC 2-5-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة أمن شبكات الجهة.', NULL, 'ECC 2-5-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:45:57', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(95, 'ECC 2-5-3', 'ECC 2-5-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة', NULL, 'ECC 2-5-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 08:47:08', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(96, 'ECC 2-5-3-1', 'ECC 2-5-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى العزل والتقسيم المادي أو المنطقي لجزاء الشبكات بشكل آمن، والالزم للسيطرة على مخاطر\r\nالامن السيبراني ذات العلاقة، باستخدام جدار الحماية )Firewall )ومبدأ الدفاع الامني متعدد\r\n.)Defense-in-Depth( الامر', NULL, 'ECC 2-5-3-1', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:48:36', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(97, 'ECC 2-5-3-2', 'ECC 2-5-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى  عزل شبكة بيئة النتاج عن شبكات بيئات التطوير والاختبار', NULL, 'ECC 2-5-3-2', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:50:25', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(98, 'ECC 2-5-3-3', 'ECC 2-5-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى أمن التصفح والاتصال بالانترنت، ويشمل ذلك التقييد الحازم للمواقع الالكترونية المشبوهة،\r\nومواقع مشاركة وتخزين الملفات، ومواقع الدخول عن بعد', NULL, 'ECC 2-5-3-3', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:51:15', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(99, 'ECC 2-5-3-4', 'ECC 2-5-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى أمن الشبكات الالسلكية وحمايتها باستخدام وسائل آمنة للتحقق من الهوية والتشفير، وعدم\r\nً على دراسة متكاملة للمخاطر المترتبة\r\nربط الشبكات الالسلكية بشبكة الجهة الداخلية إل بناء\r\nعلى ذلك والتعامل معها بما يضمن حماية الاصول التقنية للجهة', NULL, 'ECC 2-5-3-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:52:15', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(100, 'ECC 2-5-3-5', 'ECC 2-5-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى قيود وإدارة منافذ وبروتوكولت وخدمات الشبكة', NULL, 'ECC 2-5-3-5', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:53:28', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(101, 'ECC 2-5-3-6', 'ECC 2-5-3-6', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى )Intrusion Prevention Systems( الختراقات ومنع لكتشاف المتقدمة الحماية أ', NULL, 'ECC 2-5-3-6', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:54:15', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(102, 'ECC 2-5-3-7', 'ECC 2-5-3-7', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى .)DNS( النطاقات أسماء نظام أ', NULL, 'ECC 2-5-3-7', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:55:13', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(103, 'ECC 2-5-3-8', 'ECC 2-5-3-8', 'يجب أن تغطي متطلبات الامن السيبراني لادارة أمن شبكات الجهة بحد أدنى حماية قناة تصفح الانترنت من التهديدات المتقدمة المستمرة )Protection APT ،)التي\r\nتستخدم عادة الفيروسات والبرمجيات الضارة غير المعروفة مسبقاً )Malware Day-Zero ،)\r\nوإدارتها بشكل آمن.', NULL, 'ECC 2-5-3-8', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, 95, '2022-11-09 08:56:08', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(104, 'ECC 2-5-4', 'ECC 2-5-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة أمن شبكات الجهة دورياً.', NULL, 'ECC 2-5-4', 'Not Applicable', 38, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 09:34:41', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(105, 'ECC 2-6-1', 'ECC 2-6-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني الخاصة بأمن الجهزة المحمولة والاجهزة الشخصية\r\n للعاملين )BYOD )عند ارتباطها بشبكة الجهة.', NULL, 'ECC 2-6-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 09:35:53', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(106, 'ECC 2-6-2', 'ECC 2-6-2', 'يجب تطبيق متطلبات الامن السيبراني الخاصة بأمن الجهزة المحمولة وأجهزة )BYOD )للجهة.', NULL, 'ECC 2-6-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 09:41:09', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(107, 'ECC 2-6-3', 'ECC 2-6-3', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة', NULL, 'ECC 2-6-3', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 09:42:10', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(108, 'ECC 2-6-3-1', 'ECC 2-6-3-1', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى فصل وتشفير البيانات والمعلومات )الخاصة بالجهة( المخزنة على الجهزة المحمولة وأجهزة\r\n.)BYOD(', NULL, 'ECC 2-6-3-1', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, 107, '2022-11-09 09:43:14', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(109, 'ECC 2-6-3-2', 'ECC 2-6-3-2', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى  الستخدام المحدد والمقيد بناء  على ما تتطلبه مصلحة أعمال الجهة', NULL, 'ECC 2-6-3-2', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, 107, '2022-11-09 09:45:22', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(110, 'ECC 2-6-3-3', 'ECC 2-6-3-3', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى حذف البيانات والمعلومات )الخاصة بالجهة( المخزنة على الجهزة المحمولة وأجهزة )BYOD )\r\nعند فقدان الجهزة أو بعد انتهاء/إنهاء العلقة الوظيفية مع الجهة.', NULL, 'ECC 2-6-3-3', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, 107, '2022-11-09 09:54:37', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(111, 'ECC 2-6-3-4', 'ECC 2-6-3-4', 'يجب أن تغطي متطلبات الامن السيبراني الخاصة بأمن الاجهزة المحمولة وأجهزة )BYOD )للجهة بحد\r\nأدنى  لمستخدمين الامنية ا', NULL, 'ECC 2-6-3-4', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, 107, '2022-11-09 09:57:58', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(112, 'ECC 2-6-4', 'ECC 2-6-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني الخاصة لامن الاجهزة المحمولة وأجهزة )BYOD )للجهة\r\n.ًدوري', NULL, 'ECC 2-6-4', 'Not Applicable', 39, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 09:58:50', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(113, 'ECC 2-7-1', 'ECC 2-7-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة، والتعامل معها\r\n وفقاً للمتطلبات التشريعية والتنظيمية ذات العلاقة.', NULL, 'ECC 2-7-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:01:47', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(114, 'ECC 2-7-2', 'ECC 2-7-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة.', NULL, 'ECC 2-7-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:03:06', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(115, 'ECC 2-7-3', 'ECC 2-7-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات', NULL, 'ECC 2-7-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:09:19', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(116, 'ECC 2-7-3-1', 'ECC 2-7-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى .والمعلومات البيانات ملكية', NULL, 'ECC 2-7-3-1', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, 115, '2022-11-09 10:10:30', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(117, 'ECC 2-7-3-2', 'ECC 2-7-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى )Classifcation and Labeling Mechanisms( ترميزها وآلية والمعلومات البيانات ت', NULL, 'ECC 2-7-3-2', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, 115, '2022-11-09 10:21:19', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(118, 'ECC 2-7-3-3', 'ECC 2-7-3-3', 'جب أن تغطي متطلبات الامن السيبراني لحماية البيانات والمعلومات بحد أدنى والمعلومات البيانات خصوصية', NULL, 'ECC 2-7-3-3', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, 115, '2022-11-09 10:24:36', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(119, 'ECC 2-7-4', 'ECC 2-7-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لحماية بيانات ومعلومات الجهة دورياً.', NULL, 'ECC 2-7-4', 'Not Applicable', 40, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:29:18', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(120, 'ECC 2-8-1', 'ECC 2-8-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني للتشفير في الجهة.', NULL, 'ECC 2-8-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:29:55', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(121, 'ECC 2-8-2', 'ECC 2-8-2', 'يجب تطبيق متطلبات الامن السيبراني للتشفير في الجهة', NULL, 'ECC 2-8-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:30:37', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(122, 'ECC 2-8-3', 'ECC 2-8-3', 'جب أن تغطي متطلبات الامن السيبراني للتشفير', NULL, 'ECC 2-8-3', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:31:29', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(123, 'ECC 2-8-3-1', 'ECC 2-8-3-1', 'يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى معايير حلول التشفير المعتمدة والقيود المطبقة عليها )تقنياً وتنظيمياً(.', NULL, 'ECC 2-8-3-1', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, 122, '2022-11-09 10:32:11', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(124, 'ECC 2-8-3-2', 'ECC 2-8-3-2', 'يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى الادارة الامنة لمفاتيح التشفير خلل عمليات دورة حياتها.', NULL, 'ECC 2-8-3-2', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, 122, '2022-11-09 10:32:54', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(125, 'ECC 2-8-3-3', 'ECC 2-8-3-3', 'يجب أن تغطي متطلبات الامن السيبراني للتشفير بحد أدنى  تشفير البيانات أثناء النقل والتخزين بناء على تصنيفها وحسب المتطلبات التشريعية والتنظيمية\r\nذات العلاقة', NULL, 'ECC 2-8-3-3', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, 122, '2022-11-09 10:35:49', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(126, 'ECC 2-8-4', 'ECC 2-8-4', 'جب مراجعة تطبيق متطلبات الامن السيبراني للتشفير في الجهة دورياً.', NULL, 'ECC 2-8-4', 'Not Applicable', 41, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:47:56', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(127, 'ECC 2-9-1', 'ECC 2-9-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة', NULL, 'ECC 2-9-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:53:42', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(128, 'ECC 2-9-2', 'ECC 2-9-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة.', NULL, 'ECC 2-9-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 10:56:22', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(129, 'ECC 2-9-3', 'ECC 2-9-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية', NULL, 'ECC 2-9-3', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:03:16', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(130, 'ECC 2-9-3-1', 'ECC 2-9-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى  1 نطاق النسخ الااحتياطية وشموليتها للصول المعلوماتية والتقنية الحساسة.', NULL, 'ECC 2-9-3-1', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, 129, '2022-11-09 11:04:26', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(131, 'ECC 2-9-3-2', 'ECC 2-9-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى  القدرة السريعة على استعادة البيانات والانظمة بعد التعرض لحوادث الامن السيبراني', NULL, 'ECC 2-9-3-2', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, 129, '2022-11-09 11:05:30', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(132, 'ECC 2-9-3-3', 'ECC 2-9-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة النسخ الاحتياطية بحد أدنى إجراء فحص دوري لمدى فعالية استعادة النسخ الاحتياطية.', NULL, 'ECC 2-9-3-3', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, 129, '2022-11-09 11:08:58', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(133, 'ECC 2-9-4', 'ECC 2-9-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة النسخ الاحتياطية للجهة.', NULL, 'ECC 2-9-4', 'Not Applicable', 42, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:09:41', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(134, 'ECC 2-10-1', 'ECC 2-10-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة.', NULL, 'ECC 2-10-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:13:29', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(135, 'ECC 2-10-2', 'ECC 2-10-2', 'يجب تطبيق متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة.', NULL, 'ECC 2-10-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:15:49', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(136, 'ECC 2-10-3', 'ECC 2-10-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات', NULL, 'ECC 2-10-3', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:16:48', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(137, 'ECC 2-10-3-1', 'ECC 2-10-3-1', 'يجب أن تغطي متطلبات المن السيبراني لدارة الثغرات بحد أدنى  فحص واكتشاف الثغرات دورياً.', NULL, 'ECC 2-10-3-1', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, 136, '2022-11-09 11:17:30', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(138, 'ECC 2-10-3-2', 'ECC 2-10-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى تصنيف الثغرات حسب خطورتها', NULL, 'ECC 2-10-3-2', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, 136, '2022-11-09 11:18:28', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(139, 'ECC 2-10-3-3', 'ECC 2-10-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى على تصنيفها والمخاطر السيبرانية المترتبة عليها.\r\nبناء الثغرات م', NULL, 'ECC 2-10-3-3', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, 136, '2022-11-09 11:20:24', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(140, 'ECC 2-10-3-4', 'ECC 2-10-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى   إدارة حزم التحديثات والصلاحيات الامنية لمعالجة الثغرات', NULL, 'ECC 2-10-3-4', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, 136, '2022-11-09 11:22:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(141, 'ECC 2-10-3-5', 'ECC 2-10-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لادارة الثغرات بحد أدنى  التواصل والاشتراك مع مصادر موثوقة فيما يتعلق بالتنبيهات المتعلقة بالثغرات الجديدة\r\nوالمحدثة.', NULL, 'ECC 2-10-3-5', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, 136, '2022-11-09 11:22:54', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(142, 'ECC 2-10-4', 'ECC 2-10-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لادارة الثغرات التقنية للجهة دورياً.', NULL, 'ECC 2-10-4', 'Not Applicable', 43, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:23:57', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(143, 'ECC 2-11-1', 'ECC 2-11-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لعمليات اختبار الاختراق في الجهة', NULL, 'ECC 2-11-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:24:45', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(144, 'ECC 2-11-2', 'ECC 2-11-2', 'يجب تنفيذ عمليات اختبار الاختراق في الجهة', NULL, 'ECC 2-11-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:25:29', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(145, 'ECC 2-11-3', 'ECC 2-11-3', 'يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق', NULL, 'ECC 2-11-3', 'Not Applicable', 44, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:26:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(146, 'ECC 2-11-3-1', 'ECC 2-11-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق بحد أدنى نطاق عمل اختبار الاخـتـراق، ليشمل جميع الخدمات المقدمة خارجياً )عـن طريق الانترنت(\r\nومكوناتها التقنية، ومنها: البنية التحتية، المواقع الالكترونية، تطبيقات الويب، تطبيقات الهواتف\r\nالذكية والاوحية، البريد الالكتروني والدخول عن بعد.', NULL, 'ECC 2-11-3-1', 'Not Applicable', 44, 1, NULL, NULL, NULL, NULL, NULL, NULL, 145, '2022-11-09 11:26:48', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(147, 'ECC 2-11-3-2', 'ECC 2-11-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لختبار الاختراق بحد أدنى عمل اختبار الاختراق دورياً', NULL, 'ECC 2-11-3-2', 'Not Applicable', 44, 1, NULL, NULL, NULL, NULL, NULL, NULL, 145, '2022-11-09 11:27:30', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(148, 'ECC 2-11-4', 'ECC 2-11-4', 'يجب مراجعة تطبيق متطلبات الامن السيبراني لعمليات اختبار الاختراق في الجهة دورياً.', NULL, 'ECC 2-11-4', 'Not Applicable', 44, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:28:09', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(149, 'ECC 2-12-1', 'ECC 2-12-1', 'يجب تحديد وتوثيق واعتماد متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني للجهة.', NULL, 'ECC 2-12-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:57:33', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(150, 'ECC 2-12-2', 'ECC 2-12-2', 'يجب تطبيق متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني للجهة.', NULL, 'ECC 2-12-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 11:59:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(151, 'ECC 2-12-3', 'ECC 2-12-3', 'يجب أن تغطي متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني', NULL, 'ECC 2-12-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:00:55', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(152, 'ECC 2-12-3-1', 'ECC 2-12-3-1', 'يجب أن تغطي متطلبات إدارة سجلت الأحداث ومراقبة الامن السيبراني بحد أدنى', NULL, 'ECC 2-12-3-1', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, 151, '2022-11-09 12:06:38', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(153, 'ECC 2-12-3-2', 'ECC 2-12-3-2', 'يجب أن تغطي متطلبات إدارة سجلت الاحداث ومراقبة الامن السيبراني بحد أدنى تفعيل سجلت الاحـداث الخاصة بالحسابات ذات الصلاحيات الهامة والحساسة على الاصول\r\nالمعلوماتية وأحداث عمليات الدخول عن بعد لدى الجهة', NULL, 'ECC 2-12-3-2', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, 151, '2022-11-09 12:08:38', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(154, 'ECC 2-12-3-3', 'ECC 2-12-3-3', 'يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى تحديد التقنيات الازمة )SIEM )لجمع سجلات الاحداث الخاصة بالامن السيبراني', NULL, 'ECC 2-12-3-3', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, 151, '2022-11-09 12:10:07', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(155, 'ECC 2-12-3-4', 'ECC 2-12-3-4', 'يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى المراقبة المستمرة لسجلات الاحداث الخاصة بالامن السيبراني.', NULL, 'ECC 2-12-3-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, 151, '2022-11-09 12:11:25', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(156, 'ECC 2-12-3-5', 'ECC 2-12-3-5', 'يجب أن تغطي متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني بحد أدنى مدة الاحتفاظ بسجلات الاحداث الخاصة بالامن السيبراني )على أل تقل عن 12 شهر(.', NULL, 'ECC 2-12-3-5', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, 151, '2022-11-09 12:12:31', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL);
INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `control_type`, `parent_id`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(157, 'ECC 2-12-4', 'ECC 2-12-4', 'يجب مراجعة تطبيق متطلبات إدارة سجلات الاحداث ومراقبة الامن السيبراني في الجهة دورياً.', NULL, 'ECC 2-12-4', 'Not Applicable', 45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:16:44', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(158, 'ECC 2-13-1', 'ECC 2-13-1', 'يجب تحديد وتوثيق واعتماد متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة', NULL, 'ECC 2-13-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:17:47', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(159, 'ECC 2-13-2', 'ECC 2-13-2', 'يجب تطبيق متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة.', NULL, 'ECC 2-13-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:19:06', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(160, 'ECC 2-13-3', 'ECC 2-13-3', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني', NULL, 'ECC 2-13-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:21:14', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(161, 'ECC 2-13-3-1', 'ECC 2-13-3-1', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى  وضع خطط الاستجابة للحوادث الامنية وآليات التصعيد.', NULL, 'ECC 2-13-3-1', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, 160, '2022-11-09 12:26:06', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(162, 'ECC 2-13-3-2', 'ECC 2-13-3-2', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى تصنيف حوادث الامن السيبراني', NULL, 'ECC 2-13-3-2', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, 160, '2022-11-09 12:27:32', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(163, 'ECC 2-13-3-3', 'ECC 2-13-3-3', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى  تبليغ الهيئة عند حدوث حادثة أمن سيبراني', NULL, 'ECC 2-13-3-3', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, 160, '2022-11-09 12:29:26', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(164, 'ECC 2-13-3-4', 'ECC 2-13-3-4', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى مشاركة التنبيهات والمعلومات الستباقية ومؤشرات الاختراق وتقارير حوادث الامن السيبراني\r\nمع الهيئة', NULL, 'ECC 2-13-3-4', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, 160, '2022-11-09 12:30:31', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(165, 'ECC 2-13-3-5', 'ECC 2-13-3-5', 'يجب أن تغطي متطلبات إدارة حوادث وتهديدات الامن السيبراني بحد أدنى الحصول على المعلومات الاستباقية )Intelligence Threat )والتعامل معها.', NULL, 'ECC 2-13-3-5', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, 160, '2022-11-09 12:31:42', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(166, 'ECC 2-13-4', 'ECC 2-13-4', 'يجب مراجعة تطبيق متطلبات إدارة حوادث وتهديدات الامن السيبراني في الجهة دورياً.', NULL, 'ECC 2-13-4', 'Not Applicable', 46, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:32:31', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(167, 'ECC 2-14-1', 'ECC 2-14-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من\r\nالوصول المادي غير المصرح به والفقدان والسرقة والتخريب.', NULL, 'ECC 2-14-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:33:32', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(168, 'ECC 2-14-2', 'ECC 2-14-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب', NULL, 'ECC 2-14-2', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:34:22', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(169, 'ECC 2-14-3', 'ECC 2-14-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب', NULL, 'ECC 2-14-3', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:35:47', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(170, 'ECC 2-14-3-1', 'ECC 2-14-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  الدخول المصرح به للاماكن الحساسة في الجهة )مثل: مركز بيانات الجهة، مركز التعافي من\r\nالكوارث، أماكن معالجة المعلومات الحساسة، مركز المراقبة المنية، غرف اتصالات الشبكة،\r\nمناطق المداد الخاصة بالجهزة والاعداد التقنية، وغيرها(.', NULL, 'ECC 2-14-3-1', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, 169, '2022-11-09 12:36:40', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(171, 'ECC 2-14-3-2', 'ECC 2-14-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  .)CCTV( والمراقبة الدخول س', NULL, 'ECC 2-14-3-2', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, 169, '2022-11-09 12:37:39', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(172, 'ECC 2-14-3-3', 'ECC 2-14-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  حماية معلومات سجلات الدخول والمراقبة', NULL, 'ECC 2-14-3-3', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, 169, '2022-11-09 12:38:53', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(173, 'ECC 2-14-3-4', 'ECC 2-14-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى  أمن إتلف وإعادة استخدام الاصول المادية التي تحوي معلومات مصنفة )وتشمل: الوثائق\r\nالورقية ووسائط الحفظ والتخزين(.', NULL, 'ECC 2-14-3-4', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, 169, '2022-11-09 12:39:45', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(174, 'ECC 2-14-3-5', 'ECC 2-14-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\nغير المصرح به والفقدان والسرقة والتخريب بحد أدنى أمن الجهزة والمعدات داخل مباني الجهة وخارجها.', NULL, 'ECC 2-14-3-5', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, 169, '2022-11-09 12:40:49', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(175, 'ECC 2-14-4', 'ECC 2-14-4', 'جب مراجعة متطلبات الامن السيبراني لحماية الاصول المعلوماتية والتقنية للجهة من الوصول المادي\r\n غير المصرح به والفقدان والسرقة والتخريب دوريا', NULL, 'ECC 2-14-4', 'Not Applicable', 47, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 12:56:23', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(176, 'ECC 2-15-1', 'ECC 2-15-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة من المخاطر\r\nالسيبرانية', NULL, 'ECC 2-15-1', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:07:10', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(177, 'ECC 2-15-2', 'ECC 2-15-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة.', NULL, 'ECC 2-15-2', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:14:52', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(178, 'ECC 2-15-3', 'ECC 2-15-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة', NULL, 'ECC 2-15-3', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:19:02', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(179, 'ECC 2-15-3-1', 'ECC 2-15-3-1', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى .)Web Application Firewall( الويب لتطبيقات الحماية جدار ا', NULL, 'ECC 2-15-3-1', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, 178, '2022-11-09 13:24:13', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(180, 'ECC 2-15-3-2', 'ECC 2-15-3-2', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى .)Multi-tier Architecture( المستويات متعددة المعمارية مبدأ ا', NULL, 'ECC 2-15-3-2', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, 178, '2022-11-09 13:25:01', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(181, 'ECC 2-15-3-3', 'ECC 2-15-3-3', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى  استخدام بروتوكولات آمنة )مثل بروتوكول HTTPS.', NULL, 'ECC 2-15-3-3', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, 178, '2022-11-09 13:25:56', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(182, 'ECC 2-15-3-4', 'ECC 2-15-3-4', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى توضيح سياسة الاستخدام الامن للمستخدمين.', NULL, 'ECC 2-15-3-4', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, 178, '2022-11-09 13:26:58', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(183, 'ECC 2-15-3-5', 'ECC 2-15-3-5', 'يجب أن تغطي متطلبات الامن السيبراني لحماية تطبيقات الويب الخارجية للجهة بحد أدنى التحقق مـن الهوية متعدد العناصر )Authentication Factor-Multi )لعمليات دخـول\r\nالمستخدمين', NULL, 'ECC 2-15-3-5', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, 178, '2022-11-09 13:28:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(184, 'ECC 2-15-4', 'ECC 2-15-4', 'يجب مراجعة متطلبات الامن السيبراني لحماية تطبيقات الويب للجهة من المخاطر السيبرانية دوريا', NULL, 'ECC 2-15-4', 'Not Applicable', 48, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:29:03', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(185, 'ECC 3-1-1', 'ECC 3-1-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة', NULL, 'ECC 3-1-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:30:08', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(186, 'ECC 3-1-2', 'ECC 3-1-2', 'يجب تطبيق متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة', NULL, 'ECC 3-1-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:30:42', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(187, 'ECC 3-1-3', 'ECC 3-1-3', 'يجب أن تغطي إدارة استمرارية العمال في الجهة', NULL, 'ECC 3-1-3', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:31:15', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(188, 'ECC 3-1-3-1', 'ECC 3-1-3-1', 'يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى التأكد من استمرارية الانظمة والجراءات المتعلقة بالامن السيبراني.', NULL, 'ECC 3-1-3-1', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, 187, '2022-11-09 13:31:56', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(189, 'ECC 3-1-3-2', 'ECC 3-1-3-2', 'يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى وضع خطط الستجابة لحوداث الامن السيبراني التي قد تؤثر على استمرارية أعمال الجهة.', NULL, 'ECC 3-1-3-2', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, 187, '2022-11-09 13:32:44', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(190, 'ECC 3-1-3-3', 'ECC 3-1-3-3', 'يجب أن تغطي إدارة استمرارية العمال في الجهة بحد أدنى .)Disaster Recovery Plan( الكوارث من التعافي خطط و', NULL, 'ECC 3-1-3-3', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, 187, '2022-11-09 13:34:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(191, 'ECC 3-1-4', 'ECC 3-1-4', 'يجب مراجعة متطلبات الامن السيبراني ضمن إدارة استمرارية أعمال الجهة دورياً.', NULL, 'ECC 3-1-4', 'Not Applicable', 49, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:34:29', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(192, 'ECC 4-1-1', 'ECC 4-1-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامن السيبراني ضمن العقود والتفاقيات مع الاطـراف الخارجية\r\nللجهة.', NULL, 'ECC 4-1-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:36:07', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(193, 'ECC 4-1-2', 'ECC 4-1-2', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة له', NULL, 'ECC 4-1-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:36:45', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(194, 'ECC 4-1-2-1', 'ECC 4-1-2-1', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   بنود المحافظة على سرية المعلومات )Clauses Disclosure-Non ) َ و الحذف الامن من قِ بل\r\nالطرف الخارجي لبيانات الجهة عند انتهاء الخدمة', NULL, 'ECC 4-1-2-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, 193, '2022-11-09 13:38:05', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(195, 'ECC 4-1-2-2', 'ECC 4-1-2-2', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   إجراءات التواصل في حال حدوث حادثة أمن سيبراني.', NULL, 'ECC 4-1-2-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, 193, '2022-11-09 13:39:11', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(196, 'ECC 4-1-2-3', 'ECC 4-1-2-3', 'يجب أن تغطي متطلبات الامن السيبراني ضمن العقود والتفاقيات )مثل اتفاقية مستوى الخدمة SLA )مع\r\nالاطراف الخارجية التي قد تتأثر بإصابتها بيانات الجهة أو الخدمات المقدمة لها بحد أدنى   إلزام الطرف الخارجي بتطبيق متطلبات وسياسات الامن السيبراني للجهة والمتطلبات التشريعية\r\nوالاتنظيمية ذات العلاقة', NULL, 'ECC 4-1-2-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, 193, '2022-11-09 13:39:59', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(197, 'ECC 4-1-3', 'ECC 4-1-3', 'يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة', NULL, 'ECC 4-1-3', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:41:09', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(198, 'ECC 4-1-3-1', 'ECC 4-1-3-1', 'يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة بحد أدنى  إجراء تقييم لمخاطر الامن السيبراني، والتأكد من وجود مايضمن السيطرة على تلك المخاطر، قبل\r\nتوقيع العقود والتفاقيات أو عند تغيير المتطلبات التشريعية والاتنظيمية ذات العلاقة.', NULL, 'ECC 4-1-3-1', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, 197, '2022-11-09 13:42:02', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(199, 'ECC 4-1-3-2', 'ECC 4-1-3-2', 'يجب أن تغطي متطلبات الامن السيبراني مع الاطراف الخارجية التي تقدم خدمات إسناد لتقنية المعلومات،\r\nأو خدمات مدارة بحد أدنى  أن تكون مراكز عمليات خدمات الامن السيبراني المدارة للتشغيل والمراقبة، والتي تستخدم طريقة\r\nالوصول عن بعد، موجودة بالكامل داخل المملكة.', NULL, 'ECC 4-1-3-2', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, 197, '2022-11-09 13:43:06', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(200, 'ECC 4-1-4', 'ECC 4-1-4', 'يجب مراجعة متطلبات الامن السيبراني مع الاطراف الخارجية دورياً.', NULL, 'ECC 4-1-4', 'Not Applicable', 50, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:43:51', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(201, 'ECC 4-2-1', 'ECC 4-2-1', 'يجب تحديد وتوثيق واعتماد متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة.', NULL, 'ECC 4-2-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:44:38', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(202, 'ECC 4-2-2', 'ECC 4-2-2', 'يجب تطبيق متطلبات الامن السيبراني الخاصة بخدمات الحوسبة السحابية والاستضافة للجهة.', NULL, 'ECC 4-2-2', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:45:10', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(203, 'ECC 4-2-3', 'ECC 4-2-3', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العالقة، وبالضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة', NULL, 'ECC 4-2-3', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:45:57', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(204, 'ECC 4-2-3-1', 'ECC 4-2-3-1', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالستضافة بحد أدنى   تصنيف البيانات قبل استضافتها لدى مقدمي خدمات الحوسبة السحابية والستضافة، وإعادتها\r\nللجهة )بصيغة قابلة للستخدام( عند إنتهاء الخدمة', NULL, 'ECC 4-2-3-1', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, 203, '2022-11-09 13:47:45', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(205, 'ECC 4-2-3-2', 'ECC 4-2-3-2', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالاضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة بحد أدنى  فصل البيئة الخاصة بالجهة )وخصوصاً الخوادم الفتراضية( عن غيرها من البيئات التابعة لجهات\r\nأخرى في خدمات الحوسبة السحابية', NULL, 'ECC 4-2-3-2', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, 203, '2022-11-09 13:49:14', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(206, 'ECC 4-2-3-3', 'ECC 4-2-3-3', 'بما يتوافق مع المتطلبات التشريعية والاتنظيمية ذات العلاقة، وبالاضافة إلى ما ينطبق من الضوابط ضمن\r\nالمكونات الرئيسية رقم )1 )و )2 )و )3 )والمكون الفرعي رقم )4-1 )الضرورية لحماية بيانات الجهة أو الخدمات\r\nالمقدمة لها، يجب أن تغطي متطلبات الامـن السيبراني الخاصة باستخدام خدمات الحوسبة السحابية\r\nوالاستضافة بحد أدنى  موقع استضافة وتخزين معلومات الجهة يجب أن يكون داخل المملكة.', NULL, 'ECC 4-2-3-3', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, 203, '2022-11-09 13:50:07', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(207, 'ECC 4-2-4', 'ECC 4-2-4', 'يجب مراجعة متطلبات الامن السيبراني الخاصة بخدمات الحوسبة السحابية والاستضافة دورياً.', NULL, 'ECC 4-2-4', 'Not Applicable', 51, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:50:59', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(208, 'ECC 5-1-1', 'ECC 5-1-1', 'يجب تحديد وتـوثـيـق واعـتـمـاد متطلبات الامــن السيبراني لحماية أجـهـزة وأنـظـمـة التحكم الصناعي\r\n.للجهة( OT/ICS(', NULL, 'ECC 5-1-1', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:52:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(209, 'ECC 5-1-2', 'ECC 5-1-2', 'يجب تطبيق متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي )ICS/OT )للجهة.', NULL, 'ECC 5-1-2', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:52:49', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(210, 'ECC 5-1-3', 'ECC 5-1-3', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/O', NULL, 'ECC 5-1-3', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 13:54:07', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(211, 'ECC 5-1-3-1', 'ECC 5-1-3-1', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى  1 الـتـقـيـيـد الــحــازم والـتـقـسـيـم الــمــادي والـمـنـطـقـي عــنــد ربــــط شــبــكــات النــتــاج الـصـنـاعـيـة\r\n)ICS/OT )مــع الـشـبـكـات الخــــرى الـتـابـعـة لـلـجـهـة، مـثـل: شبكة الاعــمــال الـداخـلـيـة للجهة\r\n.\"Corporate Network\"', NULL, 'ECC 5-1-3-1', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 13:55:03', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(212, 'ECC 5-1-3-2', 'ECC 5-1-3-2', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى  التقييد الحازم والتقسيم المادي والمنطقي عند ربط الانظمة أو الشبكات الصناعية مع شبكات\r\nخارجية، مثل: الانترنت أو الدخول عن بعد أو الاتصال الاسلكي', NULL, 'ECC 5-1-3-2', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 13:56:23', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(213, 'ECC 5-1-3-3', 'ECC 5-1-3-3', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى  تفعيل سجلات الاحداث )logs Event )الخاصة بالامن السيبراني للشبكة الصناعية والاتصالت\r\nالمرتبطة بها ما أمكن ذلك، والمراقبة المستمرة لها.', NULL, 'ECC 5-1-3-3', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 13:58:06', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(214, 'ECC 5-1-3-4', 'ECC 5-1-3-4', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى  .)Safety Instrumented System “SIS”( السلمة معدات أنظمة ع', NULL, 'ECC 5-1-3-4', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 13:58:50', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(215, 'ECC 5-1-3-5', 'ECC 5-1-3-5', 'بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى  التقييد الحازم لستخدام وسائط التخزين الخارجية', NULL, 'ECC 5-1-3-5', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 14:00:04', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(216, 'ECC 5-1-3-6', 'ECC 5-1-3-6', 'الضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى   التقييد الحازم لتوصيل الجهزة المحمولة على شبكة النتاج الصناعية.', NULL, 'ECC 5-1-3-6', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 14:00:43', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(217, 'ECC 5-1-3-7', 'ECC 5-1-3-7', 'بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى   مراجعة إعدادات وتحصين النظمة الصناعية، وأنظمة الدعم والاجهزة اللية الصناعية )Secure\r\n.ًدوريا( Confguration and Hardening', NULL, 'ECC 5-1-3-7', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 14:02:52', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(218, 'ECC 5-1-3-8', 'ECC 5-1-3-8', 'بالاضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى   )OT/ICS Vulnerability Management( الصناعية اللانظمة ثغرات إدارة', NULL, 'ECC 5-1-3-8', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 14:04:44', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(219, 'ECC 5-1-3-9', 'ECC 5-1-3-9', 'بالضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى  إدارة حــــــــــزم الـــــتـــــحـــــديـــــثـــــات والصــــــــــــلحــــــــــــات المــــــنــــــيــــــة لـــــانـــــظـــــمـــــة الــــصــــنــــاعــــيــــة\r\n.)OT/ICS Patch Management(', NULL, 'ECC 5-1-3-9', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 14:31:37', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(220, 'ECC 5-1-3-10', 'ECC 5-1-3-10', 'الضافة إلى ما يمكن تطبيقه من الضوابط ضمن المكونات الرئيسية رقم )1 )و )2 )و )3 )و )4 )الضرورية\r\nلحماية بيانات الجهة وخدماتها، فإن متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي\r\n)ICS/OT )يجب أن تغطي بحد أدنى   إدارة البرامج الخاصة بالامن السيبراني الصناعي للحماية من الفيروسات والبرمجيات المشبوهة\r\nوالضارة.', NULL, 'ECC 5-1-3-10', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, 210, '2022-11-09 14:33:37', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(221, 'ECC 5-1-4', 'ECC 5-1-4', 'يجب مراجعة متطلبات الامن السيبراني لحماية أجهزة وأنظمة التحكم الصناعي )ICS/OT )للجهة دورياً.', NULL, 'ECC 5-1-4', 'Not Applicable', 52, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-09 14:34:35', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
(897, 'ECC 1-6-4', 'ECC 1-6-4', 'يجب مراجعة متطلبات الأمن السيبراني في إدارة المشاريع في الجهة دوريًا', NULL, 'ECC 1-6-4', 'Not Applicable', 29, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-14 13:46:55', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_mappings`
--

CREATE TABLE `framework_control_mappings` (
  `id` bigint UNSIGNED NOT NULL,
  `framework_control_id` bigint UNSIGNED NOT NULL,
  `framework_id` bigint UNSIGNED NOT NULL,
  `reference_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_mappings`
--

INSERT INTO `framework_control_mappings` (`id`, `framework_control_id`, `framework_id`, `reference_name`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '', NULL, NULL),
(2, 6, 1, '', NULL, NULL),
(3, 7, 1, '', NULL, NULL),
(4, 8, 1, '', NULL, NULL),
(5, 9, 1, '', NULL, NULL),
(6, 10, 1, '', NULL, NULL),
(7, 11, 1, '', NULL, NULL),
(8, 12, 1, '', NULL, NULL),
(9, 13, 1, '', NULL, NULL),
(10, 14, 1, '', NULL, NULL),
(11, 15, 1, '', NULL, NULL),
(12, 16, 1, '', NULL, NULL),
(13, 17, 1, '', NULL, NULL),
(14, 18, 1, '', NULL, NULL),
(15, 19, 1, '', NULL, NULL),
(16, 20, 1, '', NULL, NULL),
(19, 21, 1, '', NULL, NULL),
(20, 22, 1, '', NULL, NULL),
(22, 23, 1, '', NULL, NULL),
(24, 24, 1, '', NULL, NULL),
(25, 25, 1, '', NULL, NULL),
(26, 26, 1, '', NULL, NULL),
(27, 27, 1, '', NULL, NULL),
(29, 28, 1, '', NULL, NULL),
(31, 29, 1, '', NULL, NULL),
(32, 30, 1, '', NULL, NULL),
(34, 31, 1, '', NULL, NULL),
(36, 32, 1, '', NULL, NULL),
(38, 33, 1, '', NULL, NULL),
(40, 34, 1, '', NULL, NULL),
(42, 35, 1, '', NULL, NULL),
(43, 36, 1, '', NULL, NULL),
(44, 37, 1, '', NULL, NULL),
(45, 38, 1, '', NULL, NULL),
(46, 39, 1, '', NULL, NULL),
(47, 40, 1, '', NULL, NULL),
(48, 41, 1, '', NULL, NULL),
(49, 42, 1, '', NULL, NULL),
(51, 43, 1, '', NULL, NULL),
(52, 44, 1, '', NULL, NULL),
(54, 45, 1, '', NULL, NULL),
(55, 46, 1, '', NULL, NULL),
(58, 47, 1, '', NULL, NULL),
(59, 48, 1, '', NULL, NULL),
(60, 49, 1, '', NULL, NULL),
(61, 50, 1, '', NULL, NULL),
(62, 51, 1, '', NULL, NULL),
(63, 52, 1, '', NULL, NULL),
(64, 53, 1, '', NULL, NULL),
(66, 54, 1, '', NULL, NULL),
(68, 55, 1, '', NULL, NULL),
(70, 56, 1, '', NULL, NULL),
(71, 57, 1, '', NULL, NULL),
(73, 58, 1, '', NULL, NULL),
(75, 59, 1, '', NULL, NULL),
(77, 60, 1, '', NULL, NULL),
(78, 61, 1, '', NULL, NULL),
(79, 62, 1, '', NULL, NULL),
(80, 63, 1, '', NULL, NULL),
(81, 64, 1, '', NULL, NULL),
(82, 65, 1, '', NULL, NULL),
(83, 66, 1, '', NULL, NULL),
(84, 67, 1, '', NULL, NULL),
(85, 68, 1, '', NULL, NULL),
(86, 69, 1, '', NULL, NULL),
(87, 70, 1, '', NULL, NULL),
(90, 71, 1, '', NULL, NULL),
(91, 72, 1, '', NULL, NULL),
(93, 73, 1, '', NULL, NULL),
(96, 74, 1, '', NULL, NULL),
(97, 75, 1, '', NULL, NULL),
(98, 76, 1, '', NULL, NULL),
(99, 77, 1, '', NULL, NULL),
(100, 78, 1, '', NULL, NULL),
(102, 79, 1, '', NULL, NULL),
(103, 80, 1, '', NULL, NULL),
(105, 81, 1, '', NULL, NULL),
(107, 82, 1, '', NULL, NULL),
(109, 83, 1, '', NULL, NULL),
(110, 84, 1, '', NULL, NULL),
(111, 85, 1, '', NULL, NULL),
(112, 86, 1, '', NULL, NULL),
(113, 87, 1, '', NULL, NULL),
(115, 88, 1, '', NULL, NULL),
(117, 89, 1, '', NULL, NULL),
(119, 90, 1, '', NULL, NULL),
(122, 91, 1, '', NULL, NULL),
(123, 92, 1, '', NULL, NULL),
(124, 93, 1, '', NULL, NULL),
(125, 94, 1, '', NULL, NULL),
(126, 95, 1, '', NULL, NULL),
(128, 96, 1, '', NULL, NULL),
(129, 97, 1, '', NULL, NULL),
(131, 98, 1, '', NULL, NULL),
(134, 99, 1, '', NULL, NULL),
(135, 100, 1, '', NULL, NULL),
(137, 101, 1, '', NULL, NULL),
(139, 102, 1, '', NULL, NULL),
(141, 103, 1, '', NULL, NULL),
(143, 104, 1, '', NULL, NULL),
(144, 105, 1, '', NULL, NULL),
(145, 106, 1, '', NULL, NULL),
(146, 107, 1, '', NULL, NULL),
(147, 108, 1, '', NULL, NULL),
(149, 109, 1, '', NULL, NULL),
(151, 110, 1, '', NULL, NULL),
(154, 111, 1, '', NULL, NULL),
(155, 112, 1, '', NULL, NULL),
(156, 113, 1, '', NULL, NULL),
(157, 114, 1, '', NULL, NULL),
(158, 115, 1, '', NULL, NULL),
(160, 116, 1, '', NULL, NULL),
(161, 117, 1, '', NULL, NULL),
(163, 118, 1, '', NULL, NULL),
(165, 119, 1, '', NULL, NULL),
(166, 120, 1, '', NULL, NULL),
(167, 121, 1, '', NULL, NULL),
(168, 122, 1, '', NULL, NULL),
(169, 123, 1, '', NULL, NULL),
(171, 124, 1, '', NULL, NULL),
(173, 125, 1, '', NULL, NULL),
(175, 126, 1, '', NULL, NULL),
(176, 127, 1, '', NULL, NULL),
(177, 128, 1, '', NULL, NULL),
(178, 129, 1, '', NULL, NULL),
(179, 130, 1, '', NULL, NULL),
(181, 131, 1, '', NULL, NULL),
(183, 132, 1, '', NULL, NULL),
(185, 133, 1, '', NULL, NULL),
(186, 134, 1, '', NULL, NULL),
(187, 135, 1, '', NULL, NULL),
(188, 136, 1, '', NULL, NULL),
(189, 137, 1, '', NULL, NULL),
(192, 138, 1, '', NULL, NULL),
(193, 139, 1, '', NULL, NULL),
(195, 140, 1, '', NULL, NULL),
(198, 141, 1, '', NULL, NULL),
(199, 142, 1, '', NULL, NULL),
(200, 143, 1, '', NULL, NULL),
(201, 144, 1, '', NULL, NULL),
(202, 145, 1, '', NULL, NULL),
(203, 146, 1, '', NULL, NULL),
(205, 147, 1, '', NULL, NULL),
(207, 148, 1, '', NULL, NULL),
(208, 149, 1, '', NULL, NULL),
(209, 150, 1, '', NULL, NULL),
(210, 151, 1, '', NULL, NULL),
(211, 152, 1, '', NULL, NULL),
(213, 153, 1, '', NULL, NULL),
(215, 154, 1, '', NULL, NULL),
(218, 155, 1, '', NULL, NULL),
(219, 156, 1, '', NULL, NULL),
(221, 157, 1, '', NULL, NULL),
(222, 158, 1, '', NULL, NULL),
(223, 159, 1, '', NULL, NULL),
(224, 160, 1, '', NULL, NULL),
(225, 161, 1, '', NULL, NULL),
(227, 162, 1, '', NULL, NULL),
(230, 163, 1, '', NULL, NULL),
(231, 164, 1, '', NULL, NULL),
(233, 165, 1, '', NULL, NULL),
(235, 166, 1, '', NULL, NULL),
(236, 167, 1, '', NULL, NULL),
(237, 168, 1, '', NULL, NULL),
(238, 169, 1, '', NULL, NULL),
(239, 170, 1, '', NULL, NULL),
(241, 171, 1, '', NULL, NULL),
(243, 172, 1, '', NULL, NULL),
(245, 173, 1, '', NULL, NULL),
(247, 174, 1, '', NULL, NULL),
(249, 175, 1, '', NULL, NULL),
(250, 176, 1, '', NULL, NULL),
(251, 177, 1, '', NULL, NULL),
(252, 178, 1, '', NULL, NULL),
(253, 179, 1, '', NULL, NULL),
(256, 180, 1, '', NULL, NULL),
(257, 181, 1, '', NULL, NULL),
(259, 182, 1, '', NULL, NULL),
(262, 183, 1, '', NULL, NULL),
(263, 184, 1, '', NULL, NULL),
(264, 185, 1, '', NULL, NULL),
(265, 186, 1, '', NULL, NULL),
(266, 187, 1, '', NULL, NULL),
(267, 188, 1, '', NULL, NULL),
(269, 189, 1, '', NULL, NULL),
(271, 190, 1, '', NULL, NULL),
(273, 191, 1, '', NULL, NULL),
(274, 192, 1, '', NULL, NULL),
(275, 193, 1, '', NULL, NULL),
(276, 194, 1, '', NULL, NULL),
(278, 195, 1, '', NULL, NULL),
(280, 196, 1, '', NULL, NULL),
(282, 197, 1, '', NULL, NULL),
(283, 198, 1, '', NULL, NULL),
(285, 199, 1, '', NULL, NULL),
(287, 200, 1, '', NULL, NULL),
(288, 201, 1, '', NULL, NULL),
(289, 202, 1, '', NULL, NULL),
(290, 203, 1, '', NULL, NULL),
(291, 204, 1, '', NULL, NULL),
(294, 205, 1, '', NULL, NULL),
(295, 206, 1, '', NULL, NULL),
(297, 207, 1, '', NULL, NULL),
(298, 208, 1, '', NULL, NULL),
(299, 209, 1, '', NULL, NULL),
(300, 210, 1, '', NULL, NULL),
(301, 211, 1, '', NULL, NULL),
(303, 212, 1, '', NULL, NULL),
(305, 213, 1, '', NULL, NULL),
(307, 214, 1, '', NULL, NULL),
(309, 215, 1, '', NULL, NULL),
(311, 216, 1, '', NULL, NULL),
(314, 217, 1, '', NULL, NULL),
(315, 218, 1, '', NULL, NULL),
(317, 219, 1, '', NULL, NULL),
(320, 220, 1, '', NULL, NULL),
(321, 221, 1, '', NULL, NULL),
(1001, 897, 1, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_tests`
--

CREATE TABLE `framework_control_tests` (
  `id` bigint UNSIGNED NOT NULL,
  `tester` bigint UNSIGNED NOT NULL,
  `test_frequency` int DEFAULT '0',
  `last_date` date DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `objective` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `test_steps` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approximate_time` int DEFAULT NULL,
  `expected_results` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `framework_control_id` bigint UNSIGNED DEFAULT NULL,
  `desired_frequency` int DEFAULT NULL,
  `status` int DEFAULT '1',
  `additional_stakeholders` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_tests`
--

INSERT INTO `framework_control_tests` (`id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `additional_stakeholders`, `created_at`, `updated_at`) VALUES
(5, 1, 50, '2022-11-09', '2022-11-09', 'ECC 1-1-1', NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL),
(6, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-1-2', NULL, NULL, NULL, NULL, 6, NULL, 1, NULL, NULL, NULL),
(7, 1, 0, '2022-11-19', '2022-11-19', 'ECC 1-1-3', NULL, NULL, NULL, NULL, 7, NULL, 1, NULL, NULL, NULL),
(8, 1, 0, '2022-11-12', '2022-11-12', 'ECC 1-2-1', NULL, NULL, NULL, NULL, 8, NULL, 1, NULL, NULL, NULL),
(9, 1, 0, '2022-11-26', '2022-11-26', 'ECC 1-2-2', NULL, NULL, NULL, NULL, 9, NULL, 1, NULL, NULL, NULL),
(10, 1, 0, '2022-11-26', '2022-11-26', 'ECC 1-2-3', NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL),
(11, 1, 0, '2022-11-19', '2022-11-19', 'ECC 1-3-1', NULL, NULL, NULL, NULL, 11, NULL, 1, NULL, NULL, NULL),
(12, 1, 0, '2022-11-25', '2022-11-25', 'ECC 1-3-2', NULL, NULL, NULL, NULL, 12, NULL, 1, NULL, NULL, NULL),
(13, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-3-3', NULL, NULL, NULL, NULL, 13, NULL, 1, NULL, NULL, NULL),
(14, 1, 0, '2022-11-18', '2022-11-18', 'ECC 1-3-4', NULL, NULL, NULL, NULL, 14, NULL, 1, NULL, NULL, NULL),
(15, 1, 0, '2022-11-18', '2022-11-18', 'ECC 1-4-1', NULL, NULL, NULL, NULL, 15, NULL, 1, NULL, NULL, NULL),
(16, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-4-2', NULL, NULL, NULL, NULL, 16, NULL, 1, NULL, NULL, NULL),
(17, 1, 0, '2022-11-16', '2022-11-16', 'ECC 1-5-1', NULL, NULL, NULL, NULL, 17, NULL, 1, NULL, NULL, NULL),
(18, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-5-2', NULL, NULL, NULL, NULL, 18, NULL, 1, NULL, NULL, NULL),
(19, 1, 0, '2022-11-16', '2022-11-16', 'ECC 1-5-3', NULL, NULL, NULL, NULL, 19, NULL, 1, NULL, NULL, NULL),
(20, 1, 0, '2022-11-11', '2022-11-11', 'ECC 1-5-3-1', NULL, NULL, NULL, NULL, 20, NULL, 1, NULL, NULL, NULL),
(21, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-5-3-2', NULL, NULL, NULL, NULL, 21, NULL, 1, NULL, NULL, NULL),
(22, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-5-3-3', NULL, NULL, NULL, NULL, 22, NULL, 1, NULL, NULL, NULL),
(23, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-5-3-4', NULL, NULL, NULL, NULL, 23, NULL, 1, NULL, NULL, NULL),
(24, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-5-4', NULL, NULL, NULL, NULL, 24, NULL, 1, NULL, NULL, NULL),
(25, 1, 0, '2022-11-16', '2022-11-16', 'ECC 1-6-1', NULL, NULL, NULL, NULL, 25, NULL, 1, NULL, NULL, NULL),
(26, 1, 0, '2022-11-16', '2022-11-16', 'ECC 1-6-2', NULL, NULL, NULL, NULL, 26, NULL, 1, NULL, NULL, NULL),
(27, 1, 0, '2022-11-23', '2022-11-23', 'ECC 1-6-2-1', NULL, NULL, NULL, NULL, 27, NULL, 1, NULL, NULL, NULL),
(28, 1, 0, '2022-11-15', '2022-11-15', 'ECC 1-6-2-2', NULL, NULL, NULL, NULL, 28, NULL, 1, NULL, NULL, NULL),
(29, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-6-3', NULL, NULL, NULL, NULL, 29, NULL, 1, NULL, NULL, NULL),
(30, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-6-3-1', NULL, NULL, NULL, NULL, 30, NULL, 1, NULL, NULL, NULL),
(31, 1, 0, '2022-11-18', '2022-11-18', 'ECC 1-6-3-2', NULL, NULL, NULL, NULL, 31, NULL, 1, NULL, NULL, NULL),
(32, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-6-3-3', NULL, NULL, NULL, NULL, 32, NULL, 1, NULL, NULL, NULL),
(33, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-6-3-4', NULL, NULL, NULL, NULL, 33, NULL, 1, NULL, NULL, NULL),
(34, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-6-3-5', NULL, NULL, NULL, NULL, 34, NULL, 1, NULL, NULL, NULL),
(35, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-7-1', NULL, NULL, NULL, NULL, 35, NULL, 1, NULL, NULL, NULL),
(36, 1, 0, '2022-11-23', '2022-11-23', 'ECC 1-7-2', NULL, NULL, NULL, NULL, 36, NULL, 1, NULL, NULL, NULL),
(37, 1, 0, '2022-11-25', '2022-11-25', 'ECC 1-8-1', NULL, NULL, NULL, NULL, 37, NULL, 1, NULL, NULL, NULL),
(38, 1, 0, '2022-11-22', '2022-11-22', 'ECC 1-8-2', NULL, NULL, NULL, NULL, 38, NULL, 1, NULL, NULL, NULL),
(39, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-8-3', NULL, NULL, NULL, NULL, 39, NULL, 1, NULL, NULL, NULL),
(40, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-9-1', NULL, NULL, NULL, NULL, 40, NULL, 1, NULL, NULL, NULL),
(41, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-9-2', NULL, NULL, NULL, NULL, 41, NULL, 1, NULL, NULL, NULL),
(42, 1, 0, '2022-11-18', '2022-11-18', 'ECC 1-9-3', NULL, NULL, NULL, NULL, 42, NULL, 1, NULL, NULL, NULL),
(43, 1, 0, '2022-11-09', '2022-11-09', 'ECC 1-9-3-1', NULL, NULL, NULL, NULL, 43, NULL, 1, NULL, NULL, NULL),
(44, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-9-3-2', NULL, NULL, NULL, NULL, 44, NULL, 1, NULL, NULL, NULL),
(45, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-9-4', NULL, NULL, NULL, NULL, 45, NULL, 1, NULL, NULL, NULL),
(46, 1, 0, '2022-11-09', '2022-11-09', 'ECC 1-9-4-1', NULL, NULL, NULL, NULL, 46, NULL, 1, NULL, NULL, NULL),
(47, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-9-4-2', NULL, NULL, NULL, NULL, 47, NULL, 1, NULL, NULL, NULL),
(48, 1, 0, '2022-11-09', '2022-11-09', 'ECC 1-9-5', NULL, NULL, NULL, NULL, 48, NULL, 1, NULL, NULL, NULL),
(49, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-9-6', NULL, NULL, NULL, NULL, 49, NULL, 1, NULL, NULL, NULL),
(50, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-10-1', NULL, NULL, NULL, NULL, 50, NULL, 1, NULL, NULL, NULL),
(51, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-10-2', NULL, NULL, NULL, NULL, 51, NULL, 1, NULL, NULL, NULL),
(52, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-10-3', NULL, NULL, NULL, NULL, 52, NULL, 1, NULL, NULL, NULL),
(53, 1, 0, '2022-11-16', '2022-11-16', 'ECC 1-10-3-1', NULL, NULL, NULL, NULL, 53, NULL, 1, NULL, NULL, NULL),
(54, 1, 0, '2022-11-09', '2022-11-09', 'ECC 1-10-3-2', NULL, NULL, NULL, NULL, 54, NULL, 1, NULL, NULL, NULL),
(55, 1, 0, '2022-11-18', '2022-11-18', 'ECC 1-10-3-4', NULL, NULL, NULL, NULL, 55, NULL, 1, NULL, NULL, NULL),
(56, 1, 0, '2022-11-10', '2022-11-10', 'ECC 1-10-4', NULL, NULL, NULL, NULL, 56, NULL, 1, NULL, NULL, NULL),
(57, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-10-4-1', NULL, NULL, NULL, NULL, 57, NULL, 1, NULL, NULL, NULL),
(58, 1, 0, '2022-11-17', '2022-11-17', 'ECC 1-10-4-3', NULL, NULL, NULL, NULL, 58, NULL, 1, NULL, NULL, NULL),
(59, 1, 0, '2022-11-08', '2022-11-08', 'ECC 1-10-4-2', NULL, NULL, NULL, NULL, 59, NULL, 1, NULL, NULL, NULL),
(60, 1, 0, '2022-11-24', '2022-11-24', 'ECC 1-10-5', NULL, NULL, NULL, NULL, 60, NULL, 1, NULL, NULL, NULL),
(61, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-1-1', NULL, NULL, NULL, NULL, 61, NULL, 1, NULL, NULL, NULL),
(62, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-1-2', NULL, NULL, NULL, NULL, 62, NULL, 1, NULL, NULL, NULL),
(63, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-1-3', NULL, NULL, NULL, NULL, 63, NULL, 1, NULL, NULL, NULL),
(64, 1, 0, '2022-11-25', '2022-11-25', 'ECC 2-1-4', NULL, NULL, NULL, NULL, 64, NULL, 1, NULL, NULL, NULL),
(65, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-1-5', NULL, NULL, NULL, NULL, 65, NULL, 1, NULL, NULL, NULL),
(66, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-1-6', NULL, NULL, NULL, NULL, 66, NULL, 1, NULL, NULL, NULL),
(67, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-2-1', NULL, NULL, NULL, NULL, 67, NULL, 1, NULL, NULL, NULL),
(68, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-2-2', NULL, NULL, NULL, NULL, 68, NULL, 1, NULL, NULL, NULL),
(69, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-2-3', NULL, NULL, NULL, NULL, 69, NULL, 1, NULL, NULL, NULL),
(70, 1, 0, '2022-11-19', '2022-11-19', 'ECC 2-2-3-1', NULL, NULL, NULL, NULL, 70, NULL, 1, NULL, NULL, NULL),
(71, 1, 0, '2022-11-16', '2022-11-16', 'ECC 2-2-3-2', NULL, NULL, NULL, NULL, 71, NULL, 1, NULL, NULL, NULL),
(72, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-2-3-3', NULL, NULL, NULL, NULL, 72, NULL, 1, NULL, NULL, NULL),
(73, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-2-3-4', NULL, NULL, NULL, NULL, 73, NULL, 1, NULL, NULL, NULL),
(74, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-2-3-5', NULL, NULL, NULL, NULL, 74, NULL, 1, NULL, NULL, NULL),
(75, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-2-4', NULL, NULL, NULL, NULL, 75, NULL, 1, NULL, NULL, NULL),
(76, 1, 0, '2022-11-19', '2022-11-19', 'EEC 2-3-1', NULL, NULL, NULL, NULL, 76, NULL, 1, NULL, NULL, NULL),
(77, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-3-2', NULL, NULL, NULL, NULL, 77, NULL, 1, NULL, NULL, NULL),
(78, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-3-3', NULL, NULL, NULL, NULL, 78, NULL, 1, NULL, NULL, NULL),
(79, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-3-3-1', NULL, NULL, NULL, NULL, 79, NULL, 1, NULL, NULL, NULL),
(80, 1, 0, '2022-11-24', '2022-11-24', 'ECC 2-3-3-2', NULL, NULL, NULL, NULL, 80, NULL, 1, NULL, NULL, NULL),
(81, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-3-3-3', NULL, NULL, NULL, NULL, 81, NULL, 1, NULL, NULL, NULL),
(82, 1, 0, '2022-11-16', '2022-11-16', 'ECC 2-3-3-4', NULL, NULL, NULL, NULL, 82, NULL, 1, NULL, NULL, NULL),
(83, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-3-4', NULL, NULL, NULL, NULL, 83, NULL, 1, NULL, NULL, NULL),
(84, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-4-1', NULL, NULL, NULL, NULL, 84, NULL, 1, NULL, NULL, NULL),
(85, 1, 0, '2022-11-11', '2022-11-11', 'ECC 2-4-2', NULL, NULL, NULL, NULL, 85, NULL, 1, NULL, NULL, NULL),
(86, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-4-3', NULL, NULL, NULL, NULL, 86, NULL, 1, NULL, NULL, NULL),
(87, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-4-3-1', NULL, NULL, NULL, NULL, 87, NULL, 1, NULL, NULL, NULL),
(88, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-4-3-2', NULL, NULL, NULL, NULL, 88, NULL, 1, NULL, NULL, NULL),
(89, 1, 0, '2022-11-18', '2022-11-18', 'ECC 2-4-3-3', NULL, NULL, NULL, NULL, 89, NULL, 1, NULL, NULL, NULL),
(90, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-4-3-4', NULL, NULL, NULL, NULL, 90, NULL, 1, NULL, NULL, NULL),
(91, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-4-3-5', NULL, NULL, NULL, NULL, 91, NULL, 1, NULL, NULL, NULL),
(92, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-4-4', NULL, NULL, NULL, NULL, 92, NULL, 1, NULL, NULL, NULL),
(93, 1, 0, '2022-11-10', '2022-11-10', 'ECC 2-5-1', NULL, NULL, NULL, NULL, 93, NULL, 1, NULL, NULL, NULL),
(94, 1, 0, '2022-11-12', '2022-11-12', 'ECC 2-5-2', NULL, NULL, NULL, NULL, 94, NULL, 1, NULL, NULL, NULL),
(95, 1, 0, '2022-11-17', '2022-11-17', 'ECC 2-5-3', NULL, NULL, NULL, NULL, 95, NULL, 1, NULL, NULL, NULL),
(96, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-1', NULL, NULL, NULL, NULL, 96, NULL, 1, NULL, NULL, NULL),
(97, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-2', NULL, NULL, NULL, NULL, 97, NULL, 1, NULL, NULL, NULL),
(98, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-3', NULL, NULL, NULL, NULL, 98, NULL, 1, NULL, NULL, NULL),
(99, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-4', NULL, NULL, NULL, NULL, 99, NULL, 1, NULL, NULL, NULL),
(100, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-5', NULL, NULL, NULL, NULL, 100, NULL, 1, NULL, NULL, NULL),
(101, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-6', NULL, NULL, NULL, NULL, 101, NULL, 1, NULL, NULL, NULL),
(102, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-7', NULL, NULL, NULL, NULL, 102, NULL, 1, NULL, NULL, NULL),
(103, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-3-8', NULL, NULL, NULL, NULL, 103, NULL, 1, NULL, NULL, NULL),
(104, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-5-4', NULL, NULL, NULL, NULL, 104, NULL, 1, NULL, NULL, NULL),
(105, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-1', NULL, NULL, NULL, NULL, 105, NULL, 1, NULL, NULL, NULL),
(106, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-2', NULL, NULL, NULL, NULL, 106, NULL, 1, NULL, NULL, NULL),
(107, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-3', NULL, NULL, NULL, NULL, 107, NULL, 1, NULL, NULL, NULL),
(108, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-3-1', NULL, NULL, NULL, NULL, 108, NULL, 1, NULL, NULL, NULL),
(109, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-3-2', NULL, NULL, NULL, NULL, 109, NULL, 1, NULL, NULL, NULL),
(110, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-3-3', NULL, NULL, NULL, NULL, 110, NULL, 1, NULL, NULL, NULL),
(111, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-3-4', NULL, NULL, NULL, NULL, 111, NULL, 1, NULL, NULL, NULL),
(112, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-6-4', NULL, NULL, NULL, NULL, 112, NULL, 1, NULL, NULL, NULL),
(113, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-1', NULL, NULL, NULL, NULL, 113, NULL, 1, NULL, NULL, NULL),
(114, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-2', NULL, NULL, NULL, NULL, 114, NULL, 1, NULL, NULL, NULL),
(115, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-3', NULL, NULL, NULL, NULL, 115, NULL, 1, NULL, NULL, NULL),
(116, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-3-1', NULL, NULL, NULL, NULL, 116, NULL, 1, NULL, NULL, NULL),
(117, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-3-2', NULL, NULL, NULL, NULL, 117, NULL, 1, NULL, NULL, NULL),
(118, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-3-3', NULL, NULL, NULL, NULL, 118, NULL, 1, NULL, NULL, NULL),
(119, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-7-4', NULL, NULL, NULL, NULL, 119, NULL, 1, NULL, NULL, NULL),
(120, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-1', NULL, NULL, NULL, NULL, 120, NULL, 1, NULL, NULL, NULL),
(121, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-2', NULL, NULL, NULL, NULL, 121, NULL, 1, NULL, NULL, NULL),
(122, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-3', NULL, NULL, NULL, NULL, 122, NULL, 1, NULL, NULL, NULL),
(123, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-3-1', NULL, NULL, NULL, NULL, 123, NULL, 1, NULL, NULL, NULL),
(124, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-3-2', NULL, NULL, NULL, NULL, 124, NULL, 1, NULL, NULL, NULL),
(125, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-3-3', NULL, NULL, NULL, NULL, 125, NULL, 1, NULL, NULL, NULL),
(126, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-8-4', NULL, NULL, NULL, NULL, 126, NULL, 1, NULL, NULL, NULL),
(127, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-1', NULL, NULL, NULL, NULL, 127, NULL, 1, NULL, NULL, NULL),
(128, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-2', NULL, NULL, NULL, NULL, 128, NULL, 1, NULL, NULL, NULL),
(129, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-3', NULL, NULL, NULL, NULL, 129, NULL, 1, NULL, NULL, NULL),
(130, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-3-1', NULL, NULL, NULL, NULL, 130, NULL, 1, NULL, NULL, NULL),
(131, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-3-2', NULL, NULL, NULL, NULL, 131, NULL, 1, NULL, NULL, NULL),
(132, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-3-3', NULL, NULL, NULL, NULL, 132, NULL, 1, NULL, NULL, NULL),
(133, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-9-4', NULL, NULL, NULL, NULL, 133, NULL, 1, NULL, NULL, NULL),
(134, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-1', NULL, NULL, NULL, NULL, 134, NULL, 1, NULL, NULL, NULL),
(135, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-2', NULL, NULL, NULL, NULL, 135, NULL, 1, NULL, NULL, NULL),
(136, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-3', NULL, NULL, NULL, NULL, 136, NULL, 1, NULL, NULL, NULL),
(137, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-3-1', NULL, NULL, NULL, NULL, 137, NULL, 1, NULL, NULL, NULL),
(138, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-3-2', NULL, NULL, NULL, NULL, 138, NULL, 1, NULL, NULL, NULL),
(139, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-3-3', NULL, NULL, NULL, NULL, 139, NULL, 1, NULL, NULL, NULL),
(140, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-3-4', NULL, NULL, NULL, NULL, 140, NULL, 1, NULL, NULL, NULL),
(141, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-3-5', NULL, NULL, NULL, NULL, 141, NULL, 1, NULL, NULL, NULL),
(142, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-10-4', NULL, NULL, NULL, NULL, 142, NULL, 1, NULL, NULL, NULL),
(143, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-11-1', NULL, NULL, NULL, NULL, 143, NULL, 1, NULL, NULL, NULL),
(144, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-11-2', NULL, NULL, NULL, NULL, 144, NULL, 1, NULL, NULL, NULL),
(145, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-11-3', NULL, NULL, NULL, NULL, 145, NULL, 1, NULL, NULL, NULL),
(146, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-11-3-1', NULL, NULL, NULL, NULL, 146, NULL, 1, NULL, NULL, NULL),
(147, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-11-3-2', NULL, NULL, NULL, NULL, 147, NULL, 1, NULL, NULL, NULL),
(148, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-11-4', NULL, NULL, NULL, NULL, 148, NULL, 1, NULL, NULL, NULL),
(149, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-1', NULL, NULL, NULL, NULL, 149, NULL, 1, NULL, NULL, NULL),
(150, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-2', NULL, NULL, NULL, NULL, 150, NULL, 1, NULL, NULL, NULL),
(151, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-3', NULL, NULL, NULL, NULL, 151, NULL, 1, NULL, NULL, NULL),
(152, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-3-1', NULL, NULL, NULL, NULL, 152, NULL, 1, NULL, NULL, NULL),
(153, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-3-2', NULL, NULL, NULL, NULL, 153, NULL, 1, NULL, NULL, NULL),
(154, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-3-3', NULL, NULL, NULL, NULL, 154, NULL, 1, NULL, NULL, NULL),
(155, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-3-4', NULL, NULL, NULL, NULL, 155, NULL, 1, NULL, NULL, NULL),
(156, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-3-5', NULL, NULL, NULL, NULL, 156, NULL, 1, NULL, NULL, NULL),
(157, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-12-4', NULL, NULL, NULL, NULL, 157, NULL, 1, NULL, NULL, NULL),
(158, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-1', NULL, NULL, NULL, NULL, 158, NULL, 1, NULL, NULL, NULL),
(159, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-2', NULL, NULL, NULL, NULL, 159, NULL, 1, NULL, NULL, NULL),
(160, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-3', NULL, NULL, NULL, NULL, 160, NULL, 1, NULL, NULL, NULL),
(161, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-3-1', NULL, NULL, NULL, NULL, 161, NULL, 1, NULL, NULL, NULL),
(162, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-3-2', NULL, NULL, NULL, NULL, 162, NULL, 1, NULL, NULL, NULL),
(163, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-3-3', NULL, NULL, NULL, NULL, 163, NULL, 1, NULL, NULL, NULL),
(164, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-3-4', NULL, NULL, NULL, NULL, 164, NULL, 1, NULL, NULL, NULL),
(165, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-3-5', NULL, NULL, NULL, NULL, 165, NULL, 1, NULL, NULL, NULL),
(166, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-13-4', NULL, NULL, NULL, NULL, 166, NULL, 1, NULL, NULL, NULL),
(167, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-1', NULL, NULL, NULL, NULL, 167, NULL, 1, NULL, NULL, NULL),
(168, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-2', NULL, NULL, NULL, NULL, 168, NULL, 1, NULL, NULL, NULL),
(169, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-3', NULL, NULL, NULL, NULL, 169, NULL, 1, NULL, NULL, NULL),
(170, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-3-1', NULL, NULL, NULL, NULL, 170, NULL, 1, NULL, NULL, NULL),
(171, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-3-2', NULL, NULL, NULL, NULL, 171, NULL, 1, NULL, NULL, NULL),
(172, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-3-3', NULL, NULL, NULL, NULL, 172, NULL, 1, NULL, NULL, NULL),
(173, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-3-4', NULL, NULL, NULL, NULL, 173, NULL, 1, NULL, NULL, NULL),
(174, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-3-5', NULL, NULL, NULL, NULL, 174, NULL, 1, NULL, NULL, NULL),
(175, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-14-4', NULL, NULL, NULL, NULL, 175, NULL, 1, NULL, NULL, NULL),
(176, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-1', NULL, NULL, NULL, NULL, 176, NULL, 1, NULL, NULL, NULL),
(177, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-2', NULL, NULL, NULL, NULL, 177, NULL, 1, NULL, NULL, NULL),
(178, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-3', NULL, NULL, NULL, NULL, 178, NULL, 1, NULL, NULL, NULL),
(179, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-3-1', NULL, NULL, NULL, NULL, 179, NULL, 1, NULL, NULL, NULL),
(180, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-3-2', NULL, NULL, NULL, NULL, 180, NULL, 1, NULL, NULL, NULL),
(181, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-3-3', NULL, NULL, NULL, NULL, 181, NULL, 1, NULL, NULL, NULL),
(182, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-3-4', NULL, NULL, NULL, NULL, 182, NULL, 1, NULL, NULL, NULL),
(183, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-3-5', NULL, NULL, NULL, NULL, 183, NULL, 1, NULL, NULL, NULL),
(184, 1, 0, '2022-11-09', '2022-11-09', 'ECC 2-15-4', NULL, NULL, NULL, NULL, 184, NULL, 1, NULL, NULL, NULL),
(185, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-1', NULL, NULL, NULL, NULL, 185, NULL, 1, NULL, NULL, NULL),
(186, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-2', NULL, NULL, NULL, NULL, 186, NULL, 1, NULL, NULL, NULL),
(187, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-3', NULL, NULL, NULL, NULL, 187, NULL, 1, NULL, NULL, NULL),
(188, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-3-1', NULL, NULL, NULL, NULL, 188, NULL, 1, NULL, NULL, NULL),
(189, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-3-2', NULL, NULL, NULL, NULL, 189, NULL, 1, NULL, NULL, NULL),
(190, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-3-3', NULL, NULL, NULL, NULL, 190, NULL, 1, NULL, NULL, NULL),
(191, 1, 0, '2022-11-09', '2022-11-09', 'ECC 3-1-4', NULL, NULL, NULL, NULL, 191, NULL, 1, NULL, NULL, NULL),
(192, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-1', NULL, NULL, NULL, NULL, 192, NULL, 1, NULL, NULL, NULL),
(193, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-2', NULL, NULL, NULL, NULL, 193, NULL, 1, NULL, NULL, NULL),
(194, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-2-1', NULL, NULL, NULL, NULL, 194, NULL, 1, NULL, NULL, NULL),
(195, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-2-2', NULL, NULL, NULL, NULL, 195, NULL, 1, NULL, NULL, NULL),
(196, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-2-3', NULL, NULL, NULL, NULL, 196, NULL, 1, NULL, NULL, NULL),
(197, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-3', NULL, NULL, NULL, NULL, 197, NULL, 1, NULL, NULL, NULL),
(198, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-3-1', NULL, NULL, NULL, NULL, 198, NULL, 1, NULL, NULL, NULL),
(199, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-3-2', NULL, NULL, NULL, NULL, 199, NULL, 1, NULL, NULL, NULL),
(200, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-1-4', NULL, NULL, NULL, NULL, 200, NULL, 1, NULL, NULL, NULL),
(201, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-1', NULL, NULL, NULL, NULL, 201, NULL, 1, NULL, NULL, NULL),
(202, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-2', NULL, NULL, NULL, NULL, 202, NULL, 1, NULL, NULL, NULL),
(203, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-3', NULL, NULL, NULL, NULL, 203, NULL, 1, NULL, NULL, NULL),
(204, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-3-1', NULL, NULL, NULL, NULL, 204, NULL, 1, NULL, NULL, NULL),
(205, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-3-2', NULL, NULL, NULL, NULL, 205, NULL, 1, NULL, NULL, NULL),
(206, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-3-3', NULL, NULL, NULL, NULL, 206, NULL, 1, NULL, NULL, NULL),
(207, 1, 0, '2022-11-09', '2022-11-09', 'ECC 4-2-4', NULL, NULL, NULL, NULL, 207, NULL, 1, NULL, NULL, NULL),
(208, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-1', NULL, NULL, NULL, NULL, 208, NULL, 1, NULL, NULL, NULL),
(209, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-2', NULL, NULL, NULL, NULL, 209, NULL, 1, NULL, NULL, NULL),
(210, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3', NULL, NULL, NULL, NULL, 210, NULL, 1, NULL, NULL, NULL),
(211, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-1', NULL, NULL, NULL, NULL, 211, NULL, 1, NULL, NULL, NULL),
(212, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-2', NULL, NULL, NULL, NULL, 212, NULL, 1, NULL, NULL, NULL),
(213, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-3', NULL, NULL, NULL, NULL, 213, NULL, 1, NULL, NULL, NULL),
(214, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-4', NULL, NULL, NULL, NULL, 214, NULL, 1, NULL, NULL, NULL),
(215, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-5', NULL, NULL, NULL, NULL, 215, NULL, 1, NULL, NULL, NULL),
(216, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-6', NULL, NULL, NULL, NULL, 216, NULL, 1, NULL, NULL, NULL),
(217, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-7', NULL, NULL, NULL, NULL, 217, NULL, 1, NULL, NULL, NULL),
(218, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-8', NULL, NULL, NULL, NULL, 218, NULL, 1, NULL, NULL, NULL),
(219, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-9', NULL, NULL, NULL, NULL, 219, NULL, 1, NULL, NULL, NULL),
(220, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-3-10', NULL, NULL, NULL, NULL, 220, NULL, 1, NULL, NULL, NULL),
(221, 1, 0, '2022-11-09', '2022-11-09', 'ECC 5-1-4', NULL, NULL, NULL, NULL, 221, NULL, 1, NULL, NULL, NULL),
(897, 1, 0, '2022-11-14', '2022-11-14', 'ECC 1-6-4', NULL, NULL, NULL, NULL, 897, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_audits`
--

CREATE TABLE `framework_control_test_audits` (
  `id` bigint UNSIGNED NOT NULL,
  `test_id` bigint UNSIGNED NOT NULL,
  `tester` bigint UNSIGNED NOT NULL,
  `test_frequency` int DEFAULT '0',
  `last_date` date DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `objective` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `test_steps` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approximate_time` int DEFAULT NULL,
  `expected_results` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `framework_control_id` bigint UNSIGNED DEFAULT NULL,
  `desired_frequency` int DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_comments`
--

CREATE TABLE `framework_control_test_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `test_audit_id` bigint UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int NOT NULL,
  `comment` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_results`
--

CREATE TABLE `framework_control_test_results` (
  `id` bigint UNSIGNED NOT NULL,
  `test_audit_id` bigint UNSIGNED NOT NULL,
  `test_result` bigint UNSIGNED DEFAULT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_date` date NOT NULL,
  `submitted_by` int NOT NULL,
  `submission_date` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_results_to_risks`
--

CREATE TABLE `framework_control_test_results_to_risks` (
  `id` bigint UNSIGNED NOT NULL,
  `test_results_id` bigint UNSIGNED DEFAULT NULL,
  `risk_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_to_frameworks`
--

CREATE TABLE `framework_control_to_frameworks` (
  `control_id` bigint UNSIGNED NOT NULL,
  `framework_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_type_mappings`
--

CREATE TABLE `framework_control_type_mappings` (
  `id` bigint UNSIGNED NOT NULL,
  `control_id` bigint UNSIGNED NOT NULL,
  `control_type_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_families`
--

CREATE TABLE `framework_families` (
  `id` bigint UNSIGNED NOT NULL,
  `framework_id` bigint UNSIGNED NOT NULL,
  `family_id` bigint UNSIGNED NOT NULL,
  `parent_family_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_families`
--

INSERT INTO `framework_families` (`id`, `framework_id`, `family_id`, `parent_family_id`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL),
(5, 1, 5, NULL),
(6, 1, 24, 1),
(7, 1, 25, 1),
(8, 1, 26, 1),
(9, 1, 27, 1),
(10, 1, 28, 1),
(11, 1, 29, 1),
(12, 1, 30, 1),
(13, 1, 31, 1),
(14, 1, 32, 1),
(15, 1, 33, 1),
(16, 1, 34, 2),
(17, 1, 35, 2),
(18, 1, 36, 2),
(19, 1, 37, 2),
(20, 1, 38, 2),
(21, 1, 39, 2),
(22, 1, 40, 2),
(23, 1, 41, 2),
(24, 1, 42, 2),
(25, 1, 43, 2),
(26, 1, 44, 2),
(27, 1, 45, 2),
(28, 1, 46, 2),
(29, 1, 47, 2),
(30, 1, 48, 2),
(31, 1, 49, 3),
(32, 1, 50, 4),
(33, 1, 51, 4),
(34, 1, 52, 5);

-- --------------------------------------------------------

--
-- Table structure for table `framework_icons`
--

CREATE TABLE `framework_icons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `impacts`
--

CREATE TABLE `impacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `impacts`
--

INSERT INTO `impacts` (`id`, `name`) VALUES
(1, 'Insignificant'),
(2, 'Minor'),
(3, 'Moderate'),
(4, 'Major'),
(5, 'Extreme/Catastrophic');

-- --------------------------------------------------------

--
-- Table structure for table `items_to_teams`
--

CREATE TABLE `items_to_teams` (
  `item_id` int NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kpis`
--

CREATE TABLE `kpis` (
  `id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_type` enum('Time','Percentage','Number') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_of_assessment` enum('3','6','9','12') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Period in months',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_assessments`
--

CREATE TABLE `kpi_assessments` (
  `id` bigint UNSIGNED NOT NULL,
  `kpi_id` bigint UNSIGNED NOT NULL,
  `assessment_value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `action_by` bigint UNSIGNED DEFAULT NULL,
  `assessment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `full`) VALUES
(1, 'en', 'English'),
(4, 'ar', 'Arabic');

-- --------------------------------------------------------

--
-- Table structure for table `likelihoods`
--

CREATE TABLE `likelihoods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likelihoods`
--

INSERT INTO `likelihoods` (`id`, `name`) VALUES
(1, 'Remote'),
(2, 'Unlikely'),
(3, 'Credible'),
(4, 'Likely'),
(5, 'Almost Certain');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'B1F3R002'),
(2, 'Location 2'),
(3, 'Location 3'),
(4, 'Location 4'),
(5, 'Location 5'),
(6, 'Location 6'),
(7, 'Location 7'),
(8, 'Location 8'),
(9, 'Location 9'),
(10, 'Location 10'),
(11, 'Location 11'),
(12, 'Location 12'),
(13, 'Location 13'),
(14, 'Location 14'),
(15, 'Location 15'),
(16, 'Location 16'),
(17, 'Location 17'),
(18, 'Location 18'),
(19, 'Location 19'),
(20, 'Location 20');

-- --------------------------------------------------------

--
-- Table structure for table `mgmt_reviews`
--

CREATE TABLE `mgmt_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review` bigint UNSIGNED DEFAULT NULL,
  `reviewer` bigint UNSIGNED DEFAULT NULL,
  `next_step_id` bigint UNSIGNED DEFAULT NULL,
  `comments` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `next_review` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_04_04_122425_create_notifications_table', 1),
(2, '2021_04_04_122525_create_user_notifications_table', 1),
(3, '2022_02_16_001499_create_permission_groups_table', 1),
(4, '2022_02_16_001500_create_subgroups_table', 1),
(5, '2022_02_16_001501_create_permissions_table', 1),
(6, '2022_02_16_001503_create_permission_to_permission_groups_table', 1),
(7, '2022_02_16_001504_create_permission_to_users_table', 1),
(8, '2022_02_16_001509_create_roles_table', 1),
(9, '2022_02_16_001510_create_role_responsibilities_table', 1),
(10, '2022_02_16_001601_create_department_colors_table', 1),
(11, '2022_02_16_001602_create_departments_table', 1),
(12, '2022_02_16_001603_create_jobs_table', 1),
(13, '2022_02_16_001700_create_users_table', 1),
(14, '2022_02_16_001702_add_manager_id_to_departments', 1),
(15, '2022_02_16_001703_add_user_id_to_permission_to_users', 1),
(16, '2022_02_16_001800_create_assessments_table', 1),
(17, '2022_02_16_001810_create_assessment_questions_table', 1),
(18, '2022_02_16_001811_create_contributing_risks_likelihood_table', 1),
(19, '2022_02_16_001812_create_scoring_methods_table', 1),
(20, '2022_02_16_001819_create_assessment_scorings_table', 1),
(21, '2022_02_16_001820_create_assessment_answers_table', 1),
(22, '2022_02_16_001830_create_asset_groups_table', 1),
(23, '2022_02_16_001840_create_assessment_answers_to_asset_groups_table', 1),
(24, '2022_02_16_001840_create_asset_values_table', 1),
(25, '2022_02_16_001840_create_locations_table', 1),
(26, '2022_02_16_001841_create_assets_table', 1),
(27, '2022_02_16_001850_create_assessment_answers_to_assets_table', 1),
(28, '2022_02_16_001851_create_contributing_risks_table', 1),
(29, '2022_02_16_001860_create_assessment_scoring_contributing_impacts_table', 1),
(30, '2022_02_16_091810_create_asset_asset_groups_table', 1),
(31, '2022_02_16_091810_create_assets_asset_groups_table', 1),
(32, '2022_02_16_091811_create_projects_table', 1),
(33, '2022_02_16_091812_create_close_reasons_table', 1),
(34, '2022_02_16_091813_create_sources_table', 1),
(35, '2022_02_16_091814_create_categories_table', 1),
(36, '2022_02_16_091815_create_mitigation_efforts_table', 1),
(37, '2022_02_16_091815_create_planning_strategies_table', 1),
(38, '2022_02_16_091816_create_mitigations_table', 1),
(39, '2022_02_16_091820_create_audit_logs_table', 1),
(40, '2022_02_16_091830_create_backups_table', 1),
(41, '2022_02_16_091880_create_compliance_files_table', 1),
(42, '2022_02_16_091890_create_contributing_risks_impact_table', 1),
(43, '2022_02_16_091905_create_control_classes_table', 1),
(44, '2022_02_16_091906_create_control_maturities_table', 1),
(45, '2022_02_16_091907_create_control_phases_table', 1),
(46, '2022_02_16_091908_create_control_priorities_table', 1),
(47, '2022_02_16_091909_create_impacts_table', 1),
(48, '2022_02_16_091909_create_likelihoods_table', 1),
(49, '2022_02_16_091910_create_custom_risk_model_values_table', 1),
(50, '2022_02_16_091911_create_cvss_scorings_table', 1),
(51, '2022_02_16_091912_create_data_classifications_table', 1),
(52, '2022_02_16_091913_create_date_formats_table', 1),
(53, '2022_02_16_091914_create_document_exceptions_table', 1),
(54, '2022_02_16_091915_create_document_exceptions_statuses_table', 1),
(55, '2022_02_16_091916_create_document_statuses_table', 1),
(56, '2022_02_16_091916_create_document_types_table', 1),
(57, '2022_02_16_091918_create_dynamic_saved_selections_table', 1),
(58, '2022_02_16_091919_create_failed_login_attempts_table', 1),
(59, '2022_02_16_091920_create_families_table', 1),
(60, '2022_02_16_091921_create_fields_table', 1),
(61, '2022_02_16_091922_create_file_type_extensions_table', 1),
(62, '2022_02_16_091923_create_control_desired_maturities_table', 1),
(63, '2022_02_16_091923_create_control_owners_table', 1),
(64, '2022_02_16_091923_create_control_types_table', 1),
(65, '2022_02_16_091923_create_file_types_table', 1),
(66, '2022_02_16_091924_create_framework_controls_table', 1),
(67, '2022_02_16_091924_create_frameworks_table', 1),
(68, '2022_02_16_091925_create_framework_control_mappings_table', 1),
(69, '2022_02_16_091925_create_framework_control_tests_table', 1),
(70, '2022_02_16_091925_create_risks_table', 1),
(71, '2022_02_16_091926_add_risk_id_to_mitigations_table', 1),
(72, '2022_02_16_091926_create_closures_table', 1),
(73, '2022_02_16_091926_create_comments_table', 1),
(74, '2022_02_16_091926_create_files_table', 1),
(75, '2022_02_16_091926_create_framework_control_test_audits_table', 1),
(76, '2022_02_16_091926_create_privacies_table', 1),
(77, '2022_02_16_091927_create_documents_table', 1),
(78, '2022_02_16_091927_create_framework_control_test_comments_table', 1),
(79, '2022_02_16_091927_create_test_results_table', 1),
(80, '2022_02_16_091928_create_framework_control_test_results_table', 1),
(81, '2022_02_16_091929_create_framework_control_test_results_to_risks_table', 1),
(82, '2022_02_16_091931_create_framework_control_to_frameworks_table', 1),
(83, '2022_02_16_091932_create_framework_control_type_mappings_table', 1),
(84, '2022_02_16_091935_create_teams_table', 1),
(85, '2022_02_16_091936_create_items_to_teams_table', 1),
(86, '2022_02_16_091937_create_languages_table', 1),
(87, '2022_02_16_091939_create_next_steps_table', 1),
(88, '2022_02_16_091939_create_reviews_table', 1),
(89, '2022_02_16_091940_create_mgmt_reviews_table', 1),
(90, '2022_02_16_091941_create_mitigation_accept_users_table', 1),
(91, '2022_02_16_091943_create_mitigation_to_controls_table', 1),
(92, '2022_02_16_091944_create_mitigation_to_teams_table', 1),
(93, '2022_02_16_091947_create_password_resets_table', 1),
(94, '2022_02_16_091948_create_pending_risks_table', 1),
(95, '2022_02_16_091955_create_questionnaire_pending_risks_table', 1),
(96, '2022_02_16_091956_create_regulations_table', 1),
(97, '2022_02_16_091957_create_residual_risk_scoring_histories_table', 1),
(98, '2022_02_16_091959_create_review_levels_table', 1),
(99, '2022_02_16_092000_create_risk_functions_table', 1),
(100, '2022_02_16_092001_create_risk_groupings_table', 1),
(101, '2022_02_16_092002_create_risk_catalogs_table', 1),
(102, '2022_02_16_092003_create_risk_levels_table', 1),
(103, '2022_02_16_092004_create_risk_models_table', 1),
(104, '2022_02_16_092005_create_risk_scorings_table', 1),
(105, '2022_02_16_092006_create_risk_scoring_contributing_impacts_table', 1),
(106, '2022_02_16_092007_create_risk_scoring_histories_table', 1),
(107, '2022_02_16_092008_create_risk_to_additional_stakeholders_table', 1),
(108, '2022_02_16_092009_create_risk_to_locations_table', 1),
(109, '2022_02_16_092010_create_risk_to_teams_table', 1),
(110, '2022_02_16_092010_create_technologies_table', 1),
(111, '2022_02_16_092011_create_risk_to_technologies_table', 1),
(112, '2022_02_16_092013_create_risks_to_asset_groups_table', 1),
(113, '2022_02_16_092014_create_risks_to_assets_table', 1),
(114, '2022_02_16_092018_create_sessions_table', 1),
(115, '2022_02_16_092019_create_settings_table', 1),
(116, '2022_02_16_092021_create_statuses_table', 1),
(117, '2022_02_16_092022_create_tags_table', 1),
(118, '2022_02_16_092023_create_taggables_table', 1),
(119, '2022_02_16_092027_create_test_statuses_table', 1),
(120, '2022_02_16_092027_create_threat_groupings_table', 1),
(121, '2022_02_16_092028_create_threat_catalogs_table', 1),
(122, '2022_02_16_092031_create_user_pass_histories_table', 1),
(123, '2022_02_16_092032_create_user_pass_reuse_histories_table', 1),
(124, '2022_02_16_092033_create_user_to_teams_table', 1),
(125, '2022_02_16_092034_create_validation_files_table', 1),
(126, '2022_03_13_065913_create_tests_table', 1),
(127, '2022_05_17_122632_create_framework_icons_table', 1),
(128, '2022_06_16_123929_create_tasks_table', 1),
(129, '2022_06_16_132507_create_file_tasks_table', 1),
(130, '2022_07_26_145432_create_document_notes_table', 1),
(131, '2022_07_26_145432_create_task_notes_table', 1),
(132, '2022_07_28_105734_create_document_note_files_table', 1),
(133, '2022_07_28_105734_create_task_note_files_table', 1),
(134, '2022_09_22_111859_create_vulnerabilities_table', 1),
(135, '2022_09_22_113422_create_asset_vulnerabilities_table', 1),
(136, '2022_09_22_113907_create_team_vulnerabilities_table', 1),
(137, '2022_09_22_163247_create_service_descriptions_table', 1),
(138, '2022_09_25_134316_create_change_requests_table', 1),
(139, '2022_09_27_113124_create_kpis_table', 1),
(140, '2022_09_28_092653_create_kpi_assessments_table', 1),
(141, '2022_10_10_135818_create_security_awarenesses_table', 1),
(142, '2022_10_10_135953_create_security_awareness_exams_table', 1),
(143, '2022_10_10_141920_create_security_awareness_note_files_table', 1),
(144, '2022_10_10_141931_create_security_awareness_notes_table', 1),
(145, '2022_10_12_124510_create_security_awareness_exam_questions_table', 1),
(146, '2022_10_12_143854_create_security_awareness_exam_answers_table', 1),
(147, '2022_11_07_085943_create_framework_families_table', 1),
(148, '2022_12_01_072257_create_control_audit_policies_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mitigations`
--

CREATE TABLE `mitigations` (
  `id` bigint UNSIGNED NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` timestamp NULL DEFAULT NULL,
  `planning_strategy` bigint UNSIGNED DEFAULT NULL,
  `mitigation_effort` bigint UNSIGNED DEFAULT NULL,
  `mitigation_cost` int DEFAULT NULL,
  `mitigation_owner` bigint UNSIGNED DEFAULT NULL,
  `current_solution` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `security_requirements` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `security_recommendations` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `submitted_by` int NOT NULL DEFAULT '1',
  `planning_date` date NOT NULL,
  `mitigation_percent` int NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_accept_users`
--

CREATE TABLE `mitigation_accept_users` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_efforts`
--

CREATE TABLE `mitigation_efforts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mitigation_efforts`
--

INSERT INTO `mitigation_efforts` (`id`, `name`) VALUES
(1, 'Insignificante'),
(2, 'Menor'),
(3, 'Considerable'),
(4, 'Significante'),
(5, 'Excepcional');

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_to_controls`
--

CREATE TABLE `mitigation_to_controls` (
  `mitigation_id` bigint UNSIGNED NOT NULL,
  `control_id` bigint UNSIGNED NOT NULL,
  `validation_details` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `validation_owner` int NOT NULL,
  `validation_mitigation_percent` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_to_teams`
--

CREATE TABLE `mitigation_to_teams` (
  `mitigation_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `next_steps`
--

CREATE TABLE `next_steps` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `next_steps`
--

INSERT INTO `next_steps` (`id`, `name`) VALUES
(1, 'Accept Until Next Review'),
(3, 'Submit as a Production Issue');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` int NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_risks`
--

CREATE TABLE `pending_risks` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_id` bigint UNSIGNED NOT NULL,
  `assessment_answer_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` double(8,2) NOT NULL,
  `owner` int DEFAULT NULL,
  `affected_assets` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `comment` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subgroup_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `name`, `subgroup_id`, `created_at`, `updated_at`) VALUES
(1, 'framework.list', 'list', 1, NULL, NULL),
(2, 'framework.view', 'view', 1, NULL, NULL),
(3, 'framework.create', 'create', 1, NULL, NULL),
(4, 'framework.update', 'update', 1, NULL, NULL),
(5, 'framework.delete', 'delete', 1, NULL, NULL),
(6, 'framework.print', 'print', 1, NULL, NULL),
(7, 'framework.export', 'export', 1, NULL, NULL),
(8, 'control.list', 'list', 2, NULL, NULL),
(9, 'control.view', 'view', 2, NULL, NULL),
(10, 'control.create', 'create', 2, NULL, NULL),
(11, 'control.update', 'update', 2, NULL, NULL),
(12, 'control.delete', 'delete', 2, NULL, NULL),
(13, 'control.print', 'print', 2, NULL, NULL),
(14, 'control.export', 'export', 2, NULL, NULL),
(15, 'document.create', 'create', 3, NULL, NULL),
(16, 'document.print', 'print', 3, NULL, NULL),
(17, 'document.export', 'export', 3, NULL, NULL),
(18, 'document.download', 'download', 3, NULL, NULL),
(19, 'riskmanagement.list', 'list', 5, NULL, NULL),
(20, 'riskmanagement.view', 'view', 5, NULL, NULL),
(21, 'riskmanagement.create', 'create', 5, NULL, NULL),
(22, 'riskmanagement.update', 'update', 5, NULL, NULL),
(23, 'riskmanagement.delete', 'delete', 5, NULL, NULL),
(24, 'riskmanagement.print', 'print', 5, NULL, NULL),
(25, 'riskmanagement.export', 'export', 5, NULL, NULL),
(26, 'riskmanagement.AbleToCommentRiskManagement', 'AbleToCommentRiskManagement', 5, NULL, NULL),
(27, 'riskmanagement.AbleToCloseRisks', 'AbleToCloseRisks', 5, NULL, NULL),
(28, 'audits.list', 'list', 9, NULL, NULL),
(29, 'audits.create', 'create', 9, NULL, NULL),
(30, 'audits.delete', 'delete', 9, NULL, NULL),
(31, 'audits.result', 'result', 9, NULL, NULL),
(32, 'asset.list', 'list', 10, NULL, NULL),
(33, 'asset.view', 'view', 10, NULL, NULL),
(34, 'asset.create', 'create', 10, NULL, NULL),
(35, 'asset.update', 'update', 10, NULL, NULL),
(36, 'asset.delete', 'delete', 10, NULL, NULL),
(37, 'asset.print', 'print', 10, NULL, NULL),
(38, 'asset.export', 'export', 10, NULL, NULL),
(39, 'roles.list', 'list', 12, NULL, NULL),
(40, 'roles.view', 'view', 12, NULL, NULL),
(41, 'roles.create', 'create', 12, NULL, NULL),
(42, 'roles.update', 'update', 12, NULL, NULL),
(43, 'roles.delete', 'delete', 12, NULL, NULL),
(44, 'roles.print', 'print', 12, NULL, NULL),
(45, 'roles.export', 'export', 12, NULL, NULL),
(46, 'values.list', 'list', 13, NULL, NULL),
(47, 'values.view', 'view', 13, NULL, NULL),
(48, 'values.create', 'create', 13, NULL, NULL),
(49, 'values.update', 'update', 13, NULL, NULL),
(50, 'values.delete', 'delete', 13, NULL, NULL),
(51, 'values.print', 'print', 13, NULL, NULL),
(52, 'values.export', 'export', 13, NULL, NULL),
(53, 'logs.list', 'list', 14, NULL, NULL),
(54, 'logs.view', 'view', 14, NULL, NULL),
(55, 'logs.create', 'create', 14, NULL, NULL),
(56, 'logs.update', 'update', 14, NULL, NULL),
(57, 'logs.delete', 'delete', 14, NULL, NULL),
(58, 'logs.print', 'print', 14, NULL, NULL),
(59, 'logs.export', 'export', 14, NULL, NULL),
(60, 'hierarchy.list', 'view', 15, NULL, NULL),
(61, 'hierarchy.view', 'view', 15, NULL, NULL),
(62, 'hierarchy.update', 'update', 15, NULL, NULL),
(63, 'department.list', 'list', 16, NULL, NULL),
(64, 'department.view', 'view', 16, NULL, NULL),
(65, 'department.create', 'create', 16, NULL, NULL),
(66, 'department.update', 'update', 16, NULL, NULL),
(67, 'department.delete', 'delete', 16, NULL, NULL),
(68, 'department.print', 'print', 16, NULL, NULL),
(69, 'department.export', 'export', 16, NULL, NULL),
(70, 'job.list', 'list', 17, NULL, NULL),
(71, 'job.view', 'view', 17, NULL, NULL),
(72, 'job.create', 'create', 17, NULL, NULL),
(73, 'job.update', 'update', 17, NULL, NULL),
(74, 'job.delete', 'delete', 17, NULL, NULL),
(75, 'job.print', 'print', 17, NULL, NULL),
(76, 'job.export', 'export', 17, NULL, NULL),
(77, 'plan_mitigation.create', 'create', 19, NULL, NULL),
(78, 'plan_mitigation.accept', 'accept', 19, NULL, NULL),
(79, 'perform_reviews.create', 'create', 20, NULL, NULL),
(80, 'asset_group.list', 'list', 21, NULL, NULL),
(81, 'asset_group.view', 'view', 21, NULL, NULL),
(82, 'asset_group.create', 'create', 21, NULL, NULL),
(83, 'asset_group.update', 'update', 21, NULL, NULL),
(84, 'asset_group.delete', 'delete', 21, NULL, NULL),
(85, 'asset_group.print', 'print', 21, NULL, NULL),
(86, 'asset_group.export', 'export', 21, NULL, NULL),
(87, 'category.list', 'list', 22, NULL, NULL),
(88, 'category.view', 'view', 22, NULL, NULL),
(89, 'category.create', 'create', 22, NULL, NULL),
(90, 'category.update', 'update', 22, NULL, NULL),
(91, 'category.delete', 'delete', 22, NULL, NULL),
(92, 'category.print', 'print', 22, NULL, NULL),
(93, 'category.export', 'export', 22, NULL, NULL),
(94, 'user_management.list', 'list', 23, NULL, NULL),
(95, 'user_management.view', 'view', 23, NULL, NULL),
(96, 'user_management.create', 'create', 23, NULL, NULL),
(97, 'user_management.update', 'update', 23, NULL, NULL),
(98, 'user_management.delete', 'delete', 23, NULL, NULL),
(99, 'user_management.print', 'print', 23, NULL, NULL),
(100, 'user_management.export', 'export', 23, NULL, NULL),
(101, 'settings.list', 'list', 24, NULL, NULL),
(102, 'settings.view', 'view', 24, NULL, NULL),
(103, 'settings.create', 'create', 24, NULL, NULL),
(104, 'settings.update', 'update', 24, NULL, NULL),
(105, 'settings.delete', 'delete', 24, NULL, NULL),
(106, 'settings.print', 'print', 24, NULL, NULL),
(107, 'settings.export', 'export', 24, NULL, NULL),
(108, 'classic_risk_formula.list', 'list', 25, NULL, NULL),
(109, 'classic_risk_formula.view', 'view', 25, NULL, NULL),
(110, 'classic_risk_formula.create', 'create', 25, NULL, NULL),
(111, 'classic_risk_formula.update', 'update', 25, NULL, NULL),
(112, 'classic_risk_formula.delete', 'delete', 25, NULL, NULL),
(113, 'classic_risk_formula.print', 'print', 25, NULL, NULL),
(114, 'classic_risk_formula.export', 'export', 25, NULL, NULL),
(115, 'import_and_export.list', 'list', 26, NULL, NULL),
(116, 'import_and_export.import', 'import', 26, NULL, NULL),
(117, 'import_and_export.export', 'export', 26, NULL, NULL),
(118, 'LDAP.list', 'list', 27, NULL, NULL),
(119, 'LDAP.test', 'test', 27, NULL, NULL),
(120, 'LDAP.update', 'update', 27, NULL, NULL),
(121, 'reporting.Overview', 'Overview', 28, NULL, NULL),
(122, 'reporting.Risk Dashboard', 'Risk Dashboard', 28, NULL, NULL),
(123, 'reporting.Control Gap Analysis', 'Control Gap Analysis', 28, NULL, NULL),
(124, 'reporting.Likelihood And Impact', 'Likelihood And Impact', 28, NULL, NULL),
(125, 'reporting.All Open Risks Assigne To Me', 'All Open Risks Assigne To Me', 28, NULL, NULL),
(126, 'reporting.Dynamic Risk Report', 'Dynamic Risk Report', 28, NULL, NULL),
(127, 'reporting.Risks and Controls', 'Risks and Controls', 28, NULL, NULL),
(128, 'reporting.Risks and Assets', 'Risks and Assets', 28, NULL, NULL),
(129, 'reporting.framewrok_control_compliance_status', 'Framewrok control compliance status', 28, NULL, NULL),
(130, 'reporting.summary_of_results_for_evaluation_and_compliance', 'Summary of results for evaluation and compliance', 28, NULL, NULL),
(131, 'reporting.security-awareness-exam', 'Security awareness exam', 28, NULL, NULL),
(132, 'task.list', 'list', 29, NULL, NULL),
(133, 'task.create', 'create', 29, NULL, NULL),
(134, 'about.update', 'update', 30, NULL, NULL),
(135, 'vulnerability_management.list', 'list', 31, NULL, NULL),
(136, 'vulnerability_management.view', 'view', 31, NULL, NULL),
(137, 'vulnerability_management.create', 'create', 31, NULL, NULL),
(138, 'vulnerability_management.update', 'update', 31, NULL, NULL),
(139, 'vulnerability_management.delete', 'delete', 31, NULL, NULL),
(140, 'vulnerability_management.print', 'print', 31, NULL, NULL),
(141, 'vulnerability_management.export', 'export', 31, NULL, NULL),
(142, 'general-setting.update', 'update', 32, NULL, NULL),
(143, 'services-description.update', 'update', 33, NULL, NULL),
(144, 'change-request.create', 'create', 34, NULL, NULL),
(145, 'change-request-department.update', 'update', 35, NULL, NULL),
(146, 'KPI.list', 'list', 36, NULL, NULL),
(147, 'KPI.create', 'create', 36, NULL, NULL),
(148, 'KPI.update', 'update', 36, NULL, NULL),
(149, 'KPI.delete', 'delete', 36, NULL, NULL),
(150, 'KPI.Initiate assessment', 'Initiate assessment', 36, NULL, NULL),
(151, 'security-awareness.create', 'create', 37, NULL, NULL),
(152, 'security-awareness.print', 'print', 37, NULL, NULL),
(153, 'security-awareness.export', 'export', 37, NULL, NULL),
(154, 'security-awareness.download', 'download', 37, NULL, NULL),
(155, 'domain.list', 'list', 38, NULL, NULL),
(156, 'domain.view', 'view', 38, NULL, NULL),
(157, 'domain.create', 'create', 38, NULL, NULL),
(158, 'domain.update', 'update', 38, NULL, NULL),
(159, 'domain.delete', 'delete', 38, NULL, NULL),
(160, 'domain.print', 'print', 38, NULL, NULL),
(161, 'domain.export', 'export', 38, NULL, NULL),
(162, 'KPI.export', 'export', 36, NULL, NULL),
(163, 'change-request.export', 'export', 34, NULL, NULL),
(164, 'audits.export', 'export', 9, NULL, NULL),
(165, 'task.export', 'export', 29, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `name`, `description`, `order`) VALUES
(1, 'Governance', '', 1),
(2, 'Risk Management', '', 2),
(3, 'Compliance', '', 3),
(4, 'Asset Management', '', 4),
(5, 'Assessments', '', 5),
(6, 'Configure', '', 6),
(7, 'Hierarchy', '', 7),
(8, 'Reporting', '', 8),
(9, 'Task', '', 9),
(10, 'Vulnerability Management', '', 10),
(11, 'Change Request', '', 11),
(12, 'KPI', '', 12),
(13, 'Security Awareness', '', 13);

-- --------------------------------------------------------

--
-- Table structure for table `permission_to_permission_groups`
--

CREATE TABLE `permission_to_permission_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `permission_group_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_to_permission_groups`
--

INSERT INTO `permission_to_permission_groups` (`id`, `permission_id`, `permission_group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 2),
(17, 17, 2),
(18, 18, 2),
(19, 19, 2),
(20, 20, 2),
(21, 21, 2),
(22, 22, 2),
(23, 23, 2),
(24, 24, 2),
(25, 25, 2),
(26, 26, 2),
(27, 27, 2),
(28, 28, 2),
(29, 29, 2),
(30, 30, 2),
(31, 31, 3),
(32, 32, 3),
(33, 33, 3),
(34, 34, 3),
(35, 35, 3),
(36, 36, 3),
(37, 37, 3),
(38, 38, 3),
(39, 39, 3),
(40, 40, 4),
(41, 41, 5);

-- --------------------------------------------------------

--
-- Table structure for table `permission_to_users`
--

CREATE TABLE `permission_to_users` (
  `id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `planning_strategies`
--

CREATE TABLE `planning_strategies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `planning_strategies`
--

INSERT INTO `planning_strategies` (`id`, `name`) VALUES
(1, 'Investigar'),
(2, 'Acceptado'),
(3, 'Mitigado'),
(4, 'Ver'),
(5, 'Transferencia');

-- --------------------------------------------------------

--
-- Table structure for table `privacies`
--

CREATE TABLE `privacies` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacies`
--

INSERT INTO `privacies` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Private', '2022-11-07 18:00:36', '2022-11-07 18:00:36'),
(2, 'Public', '2022-11-07 18:00:36', '2022-11-07 18:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `consultant` int DEFAULT NULL,
  `business_owner` int DEFAULT NULL,
  `data_classification` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '999999',
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_pending_risks`
--

CREATE TABLE `questionnaire_pending_risks` (
  `id` bigint UNSIGNED NOT NULL,
  `questionnaire_tracking_id` int NOT NULL,
  `questionnaire_scoring_id` int NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` int DEFAULT NULL,
  `asset` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regulations`
--

CREATE TABLE `regulations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residual_risk_scoring_histories`
--

CREATE TABLE `residual_risk_scoring_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL,
  `residual_risk` double(8,2) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`) VALUES
(1, 'Approve Risk'),
(2, 'Reject Risk and Close');

-- --------------------------------------------------------

--
-- Table structure for table `review_levels`
--

CREATE TABLE `review_levels` (
  `id` bigint UNSIGNED NOT NULL,
  `value` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_levels`
--

INSERT INTO `review_levels` (`id`, `value`, `name`) VALUES
(1, 360, 'Insignificant'),
(2, 360, 'Low'),
(3, 180, 'Medium'),
(4, 90, 'High'),
(5, 90, 'Very High');

-- --------------------------------------------------------

--
-- Table structure for table `risks`
--

CREATE TABLE `risks` (
  `id` bigint UNSIGNED NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `subject` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regulation` int DEFAULT NULL,
  `control_id` bigint UNSIGNED DEFAULT NULL,
  `source_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `owner_id` bigint UNSIGNED DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  `assessment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `review_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mitigation_id` bigint UNSIGNED DEFAULT NULL,
  `mgmt_review` int DEFAULT NULL,
  `project_id` bigint UNSIGNED DEFAULT NULL,
  `close_id` int DEFAULT NULL,
  `submitted_by` int NOT NULL DEFAULT '1',
  `risk_catalog_mapping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threat_catalog_mapping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_group_id` int NOT NULL DEFAULT '1',
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risks_to_assets`
--

CREATE TABLE `risks_to_assets` (
  `risk_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risks_to_asset_groups`
--

CREATE TABLE `risks_to_asset_groups` (
  `risk_id` bigint UNSIGNED NOT NULL,
  `asset_group_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_catalogs`
--

CREATE TABLE `risk_catalogs` (
  `id` bigint UNSIGNED NOT NULL,
  `number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_grouping_id` bigint UNSIGNED NOT NULL,
  `name` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_function_id` bigint UNSIGNED NOT NULL,
  `order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_catalogs`
--

INSERT INTO `risk_catalogs` (`id`, `number`, `risk_grouping_id`, `name`, `description`, `risk_function_id`, `order`) VALUES
(1, 'R-AC-1', 1, 'Inability to maintain individual accountability', 'There is a failure to maintain asset ownership and it is not possible to have non-repudiation of actions or inactions.', 2, 1),
(2, 'R-AC-2', 1, 'Improper assignment of privileged risk_function_ids', 'There is a failure to implement least privileges.', 2, 2),
(3, 'R-AC-3', 1, 'Privilege escalation', 'Access to privileged risk_function_ids is inadequate or cannot be controlled.', 2, 3),
(4, 'R-AC-4', 1, 'Unauthorized access', 'Access is granted to unauthorized individuals, groups or services.', 2, 4),
(5, 'R-AM-1', 2, 'Lost, damaged or stolen asset(s)', 'Asset(s) is/are lost, damaged or stolen.', 2, 5),
(6, 'R-AM-2', 2, 'Loss of integrity through unauthorized changes ', 'Unauthorized changes corrupt the integrity of the system / application / service.', 2, 6),
(7, 'R-BC-1', 3, 'Business interruption ', 'There is increased latency or a service outage that negatively impacts business operations.', 5, 7),
(8, 'R-BC-2', 3, 'Data loss / corruption ', 'There is a failure to maintain the confidentiality of the data (compromise) or data is corrupted (loss).', 5, 8),
(12, 'R-BC-3', 3, 'Reduction in productivity', 'User productivity is negatively affected by the incident.', 2, 12),
(13, 'R-EX-1', 4, 'Loss of revenue ', 'A financial loss occures from either a loss of clients or inability to generate future revenue.', 5, 13),
(14, 'R-EX-2', 4, 'Cancelled contract', 'A contract is cancelled due to a violation of a contract clause.', 5, 14),
(15, 'R-EX-3', 4, 'Diminished competitive advantage', 'The competitive advantage of the organization is jeapordized.', 5, 15),
(16, 'R-EX-4', 4, 'Diminished reputation ', 'Negative publicity tarnishes the organization\'s reputation.', 5, 16),
(17, 'R-EX-5', 4, 'Fines and judgements', 'Legal and/or financial damages result from statutory / regulatory / contractual non-compliance.', 5, 17),
(18, 'R-EX-6', 4, 'Unmitigated vulnerabilities', 'Umitigated technical vulnerabilities exist without compensating controls or other mitigation actions.', 2, 18),
(19, 'R-EX-7', 4, 'System compromise', 'System / application / service is compromised affects its confidentiality, integrity,  availability and/or safety.', 2, 19),
(20, 'R-BC-4', 3, 'Information loss / corruption or system compromise due to technical attack', 'Malware, phishing, hacking or other technical attacks compromise data, systems, applications or services.', 2, 20),
(21, 'R-BC-5', 3, 'Information loss / corruption or system compromise due to non‐technical attack ', 'Social engineering, sabotage or other non-technical attack compromises data, systems, applications or services.', 2, 21),
(22, 'R-GV-1', 5, 'Inability to support business processes', 'Implemented security /privacy practices are insufficient to support the organization\'s secure technologies & processes requirements.', 2, 1),
(24, 'R-GV-4', 5, 'Inadequate internal practices ', 'Internal practices do not exist or are inadequate. Procedures fail to meet \\\"reasonable practices\\\" expected by industry standards.', 2, 4),
(25, 'R-GV-5', 5, 'Inadequate third-party practices', 'Third-party practices do not exist or are inadequate. Procedures fail to meet \\\"reasonable practices\\\" expected by industry standards.', 2, 5),
(26, 'R-GV-3', 5, 'Lack of roles & responsibilities', 'Documented security / privacy roles & responsibilities do not exist or are inadequate.', 1, 3),
(27, 'R-GV-2', 5, 'Incorrect controls scoping', 'There is incorrect or inadequate controls scoping, which leads to a potential gap or lapse in security / privacy controls coverage.', 1, 2),
(28, 'R-GV-8', 5, 'Illegal content or abusive action', 'There is abusive content / harmful speech / threats of violence / illegal content that negatively affect business operations.', 1, 8),
(29, 'R-SA-1', 6, 'Inability to maintain situational awareness', 'There is an inability to detect incidents.', 3, 29),
(30, 'R-SA-2', 6, 'Lack of a security-minded workforce', 'The workforce lacks user-level understanding about security & privacy principles.', 2, 30),
(31, 'R-GV-6', 5, 'Lack of oversight of internal controls', 'There is a lack of due diligence / due care in overseeing the organization\'s internal security / privacy controls.', 1, 6),
(32, 'R-GV-7', 5, 'Lack of oversight of third-party controls', 'There is a lack of due diligence / due care in overseeing security / privacy controls operated by third-party service providers.', 1, 7),
(33, 'R-IR-1', 7, 'Inability to investigate / prosecute incidents', 'Response actions either corrupt evidence or impede the ability to prosecute incidents.', 4, 1),
(34, 'R-IR-2', 7, 'Improper response to incidents', 'Response actions fail to act appropriately in a timely manner to properly address the incident.', 4, 2),
(35, 'R-IR-3', 7, 'Ineffective remediation actions', 'There is no oversight to ensure remediation actions are correct and/or effective.', 2, 3),
(36, 'R-IR-4', 7, 'Expense associated with managing a loss event', 'There are financial repercussions from responding to an incident or loss.', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `risk_functions`
--

CREATE TABLE `risk_functions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_functions`
--

INSERT INTO `risk_functions` (`id`, `name`) VALUES
(1, 'Identify'),
(2, 'Protect'),
(3, 'Detect'),
(4, 'Respond'),
(5, 'Recover');

-- --------------------------------------------------------

--
-- Table structure for table `risk_groupings`
--

CREATE TABLE `risk_groupings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_groupings`
--

INSERT INTO `risk_groupings` (`id`, `name`) VALUES
(1, 'Access Control'),
(2, 'Asset Management'),
(3, 'Business Continuity'),
(4, 'Exposure'),
(5, 'Governance'),
(6, 'Situational Awareness'),
(7, 'Incident Response');

-- --------------------------------------------------------

--
-- Table structure for table `risk_levels`
--

CREATE TABLE `risk_levels` (
  `id` bigint UNSIGNED NOT NULL,
  `value` decimal(3,1) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_level_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_levels`
--

INSERT INTO `risk_levels` (`id`, `value`, `name`, `color`, `display_name`, `review_level_id`) VALUES
(1, '0.0', 'Low', '#32b335', 'Low', 2),
(2, '4.0', 'Medium', '#ffa500', 'Medium', 3),
(3, '7.0', 'High', '#252322', 'High', 4),
(4, '10.1', 'Very High', '#ff0000', 'Very High', 5);

-- --------------------------------------------------------

--
-- Table structure for table `risk_models`
--

CREATE TABLE `risk_models` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_models`
--

INSERT INTO `risk_models` (`id`, `name`) VALUES
(1, 'Likelihood x Impact + 2(Impact)'),
(2, 'Likelihood x Impact + Impact'),
(3, 'Likelihood x Impact'),
(4, 'Likelihood x Impact + Likelihood'),
(5, 'Likelihood x Impact + 2(Likelihood)');

-- --------------------------------------------------------

--
-- Table structure for table `risk_scorings`
--

CREATE TABLE `risk_scorings` (
  `id` bigint UNSIGNED NOT NULL,
  `scoring_method` int NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `CLASSIC_likelihood` double(8,2) NOT NULL DEFAULT '5.00',
  `CLASSIC_impact` double(8,2) NOT NULL DEFAULT '5.00',
  `CVSS_AccessVector` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_AccessComplexity` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `CVSS_Authentication` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_ConfImpact` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_IntegImpact` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_AvailImpact` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_Exploitability` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_RemediationLevel` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ReportConfidence` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_CollateralDamagePotential` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_TargetDistribution` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ConfidentialityRequirement` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_IntegrityRequirement` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_AvailabilityRequirement` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `DREAD_DamagePotential` int NOT NULL DEFAULT '10',
  `DREAD_Reproducibility` int NOT NULL DEFAULT '10',
  `DREAD_Exploitability` int NOT NULL DEFAULT '10',
  `DREAD_AffectedUsers` int NOT NULL DEFAULT '10',
  `DREAD_Discoverability` int NOT NULL DEFAULT '10',
  `OWASP_SkillLevel` int NOT NULL DEFAULT '10',
  `OWASP_Motive` int NOT NULL DEFAULT '10',
  `OWASP_Opportunity` int NOT NULL DEFAULT '10',
  `OWASP_Size` int NOT NULL DEFAULT '10',
  `OWASP_EaseOfDiscovery` int NOT NULL DEFAULT '10',
  `OWASP_EaseOfExploit` int NOT NULL DEFAULT '10',
  `OWASP_Awareness` int NOT NULL DEFAULT '10',
  `OWASP_IntrusionDetection` int NOT NULL DEFAULT '10',
  `OWASP_LossOfConfidentiality` int NOT NULL DEFAULT '10',
  `OWASP_LossOfIntegrity` int NOT NULL DEFAULT '10',
  `OWASP_LossOfAvailability` int NOT NULL DEFAULT '10',
  `OWASP_LossOfAccountability` int NOT NULL DEFAULT '10',
  `OWASP_FinancialDamage` int NOT NULL DEFAULT '10',
  `OWASP_ReputationDamage` int NOT NULL DEFAULT '10',
  `OWASP_NonCompliance` int NOT NULL DEFAULT '10',
  `OWASP_PrivacyViolation` int NOT NULL DEFAULT '10',
  `Custom` double(8,2) NOT NULL DEFAULT '10.00',
  `Contributing_Likelihood` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_scoring_contributing_impacts`
--

CREATE TABLE `risk_scoring_contributing_impacts` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_scoring_id` bigint UNSIGNED NOT NULL,
  `contributing_risk_id` bigint UNSIGNED NOT NULL,
  `impact` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_scoring_histories`
--

CREATE TABLE `risk_scoring_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_id` bigint UNSIGNED NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_additional_stakeholders`
--

CREATE TABLE `risk_to_additional_stakeholders` (
  `risk_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_locations`
--

CREATE TABLE `risk_to_locations` (
  `risk_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_teams`
--

CREATE TABLE `risk_to_teams` (
  `risk_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_technologies`
--

CREATE TABLE `risk_to_technologies` (
  `risk_id` bigint UNSIGNED NOT NULL,
  `technology_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `role_responsibilities`
--

CREATE TABLE `role_responsibilities` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_responsibilities`
--

INSERT INTO `role_responsibilities` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 1, 34),
(35, 1, 35),
(36, 1, 36),
(37, 1, 37),
(38, 1, 38),
(39, 1, 39),
(40, 1, 40),
(41, 1, 41),
(42, 1, 42),
(43, 1, 43),
(44, 1, 44),
(45, 1, 45),
(46, 1, 46),
(47, 1, 47),
(48, 1, 48),
(49, 1, 49),
(50, 1, 50),
(51, 1, 51),
(52, 1, 52),
(53, 1, 53),
(54, 1, 54),
(55, 1, 55),
(56, 1, 56),
(57, 1, 57),
(58, 1, 58),
(59, 1, 59),
(60, 1, 60),
(61, 1, 61),
(62, 1, 62),
(63, 1, 63),
(64, 1, 64),
(65, 1, 65),
(66, 1, 66),
(67, 1, 67),
(68, 1, 68),
(69, 1, 69),
(70, 1, 70),
(71, 1, 71),
(72, 1, 72),
(73, 1, 73),
(74, 1, 74),
(75, 1, 75),
(76, 1, 76),
(77, 1, 77),
(78, 1, 78),
(79, 1, 79),
(80, 1, 80),
(81, 1, 81),
(82, 1, 82),
(83, 1, 83),
(84, 1, 84),
(85, 1, 85),
(86, 1, 86),
(87, 1, 87),
(88, 1, 88),
(89, 1, 89),
(90, 1, 90),
(91, 1, 91),
(92, 1, 92),
(93, 1, 93),
(94, 1, 94),
(95, 1, 95),
(96, 1, 96),
(97, 1, 97),
(98, 1, 98),
(99, 1, 99),
(100, 1, 100),
(101, 1, 101),
(102, 1, 102),
(103, 1, 103),
(104, 1, 104),
(105, 1, 105),
(106, 1, 106),
(107, 1, 107),
(108, 1, 108),
(109, 1, 109),
(110, 1, 110),
(111, 1, 111),
(112, 1, 112),
(113, 1, 113),
(114, 1, 114),
(115, 1, 115),
(116, 1, 116),
(117, 1, 117),
(118, 1, 118),
(119, 1, 119),
(120, 1, 120),
(121, 1, 121),
(122, 1, 122),
(123, 1, 123),
(124, 1, 124),
(125, 1, 125),
(126, 1, 126),
(127, 1, 127),
(128, 1, 128),
(129, 1, 129),
(130, 1, 130),
(131, 1, 131),
(132, 1, 132),
(133, 1, 133),
(134, 1, 134),
(135, 1, 135),
(136, 1, 136),
(137, 1, 137),
(138, 1, 138),
(139, 1, 139),
(140, 1, 140),
(141, 1, 141),
(142, 1, 142),
(143, 1, 143),
(144, 1, 144),
(145, 1, 145),
(146, 1, 146),
(147, 1, 147),
(148, 1, 148),
(149, 1, 149),
(150, 1, 150),
(151, 1, 151),
(152, 1, 152),
(153, 1, 153),
(154, 1, 154),
(155, 1, 155),
(156, 1, 156),
(157, 1, 157),
(158, 1, 158),
(159, 1, 159),
(160, 1, 160),
(161, 1, 161),
(212, 1, 162),
(213, 1, 163),
(214, 1, 164),
(215, 1, 165);

-- --------------------------------------------------------

--
-- Table structure for table `scoring_methods`
--

CREATE TABLE `scoring_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scoring_methods`
--

INSERT INTO `scoring_methods` (`id`, `name`) VALUES
(1, 'Classic');

-- --------------------------------------------------------

--
-- Table structure for table `security_awarenesses`
--

CREATE TABLE `security_awarenesses` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_ids` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_stakeholders` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy` bigint UNSIGNED DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '[1 => Draft],[2=> InReview, [3 => Approved]',
  `file_id` bigint UNSIGNED DEFAULT NULL,
  `last_review_date` date DEFAULT NULL,
  `review_frequency` int DEFAULT NULL,
  `next_review_date` date DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `owner` bigint UNSIGNED NOT NULL,
  `reviewer` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `opened` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_exams`
--

CREATE TABLE `security_awareness_exams` (
  `id` bigint UNSIGNED NOT NULL,
  `security_awareness_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_exam_answers`
--

CREATE TABLE `security_awareness_exam_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `security_awareness_exams_id` bigint UNSIGNED NOT NULL,
  `examinee` bigint UNSIGNED DEFAULT NULL,
  `success_answers` tinyint NOT NULL,
  `fail_answers` tinyint NOT NULL,
  `uniqid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_exam_questions`
--

CREATE TABLE `security_awareness_exam_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `security_awareness_exams_id` bigint UNSIGNED NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_e` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` enum('A','B','C','D','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_notes`
--

CREATE TABLE `security_awareness_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `security_awareness_id` bigint UNSIGNED NOT NULL,
  `note` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_awareness_note_files`
--

CREATE TABLE `security_awareness_note_files` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `security_awareness_id` bigint UNSIGNED NOT NULL,
  `display_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_descriptions`
--

CREATE TABLE `service_descriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `route` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_key` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_descriptions`
--

INSERT INTO `service_descriptions` (`id`, `route`, `key`, `name_key`, `description`) VALUES
(1, 'admin.governance.index', 'admin_governance_index', 'Define Control Frameworks', '{\"ops\":[{\"insert\":\"Frameworks\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(2, 'admin.governance.control.list', 'admin_governance_control_list', 'Define Controls', '{\"ops\":[{\"insert\":\"Controls\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(3, 'admin.governance.category', 'admin_governance_category', 'Navbar Document Program', '{\"ops\":[{\"insert\":\"Documentation\\n\"}]}'),
(4, 'admin.risk_management.index', 'admin_risk_management_index', 'Navbar Risk Management', '{\"ops\":[{\"insert\":\"Risk Management\\n\"}]}'),
(5, 'admin.compliance.audit.index', 'admin_compliance_audit_index', 'Active Audits', '{\"ops\":[{\"insert\":\"Active Audits\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(6, 'admin.compliance.past-audits', 'admin_compliance_past-audits', 'Past Audits', '{\"ops\":[{\"insert\":\"Past Audits\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(7, 'admin.asset_management.index', 'admin_asset_management_index', 'Assets', '{\"ops\":[{\"insert\":\"Assets Management\\n\"}]}'),
(8, 'admin.asset_management.asset_group.index', 'admin_asset_management_asset_group_index', 'AssetGroups', '{\"ops\":[{\"insert\":\"Asset Groups\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(9, 'admin.reporting.overviewReport', 'admin_reporting_overviewReport', 'Overview', '{\"ops\":[{\"insert\":\"Overview\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(10, 'admin.reporting.riskDashboardReport', 'admin_reporting_riskDashboardReport', 'Risk Dashboard', '{\"ops\":[{\"insert\":\"Risk Dashboard\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(11, 'admin.reporting.controlGapAnalysis', 'admin_reporting_controlGapAnalysis', 'Control Gap Analysis', '{\"ops\":[{\"insert\":\"Gap Analysis\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(12, 'admin.reporting.likelhoodImpactReport', 'admin_reporting_likelhoodImpactReport', 'Likelihood And Impact', '{\"ops\":[{\"insert\":\"Likelihood And Impact\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(13, 'admin.reporting.MyopenRiskReport', 'admin_reporting_MyopenRiskReport', 'All Open Risks Assigned to Me', '{\"ops\":[{\"insert\":\"All Open Risks Assigned to Me\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(14, 'admin.reporting.dynamicRiskReport', 'admin_reporting_dynamicRiskReport', 'Dynamic Risk Report', '{\"ops\":[{\"insert\":\"Dynamic Risk Report\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(15, 'admin.reporting.GetRiskByControl', 'admin_reporting_GetRiskByControl', 'Risks and Controls', '{\"ops\":[{\"insert\":\"Risks and Controls\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(16, 'admin.reporting.GetRiskByAsset', 'admin_reporting_GetRiskByAsset', 'Risks and Assets', '{\"ops\":[{\"insert\":\"Risks and Assets\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(17, 'admin.reporting.framewrok_control_compliance_status', 'admin_reporting_framewrok_control_compliance_status', 'framewrok_control_compliance_status', '{\"ops\":[{\"insert\":\"Framework control compliance status\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(18, 'admin.reporting.summary_of_results_for_evaluation_and_compliance', 'admin_reporting_summary_of_results_for_evaluation_and_compliance', 'summary_of_results_for_evaluation_and_compliance', '{\"ops\":[{\"insert\":\"Summary of results for evaluation and compliance\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(19, 'admin.reporting.security_awareness_exam', 'admin_reporting_security_awareness_exam', 'SecurityAwarenessExam', '{\"ops\":[{\"insert\":\"Security awareness exam\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(20, 'admin.configure.user.index', 'admin_configure_user_index', 'Navbar User Management', '{\"ops\":[{\"insert\":\"User Mgmt\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(21, 'admin.configure.add_values', 'admin_configure_add_values', 'Add and Remove Values', '{\"ops\":[{\"insert\":\"Add and Remove Values\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(22, 'admin.configure.roles.index', 'admin_configure_roles_index', 'Navbar Role Management', '{\"ops\":[{\"insert\":\"Role Mgmt\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(23, 'admin.configure.riskmodels.show', 'admin_configure_riskmodels_show', 'ClassicRiskFormula', '{\"ops\":[{\"insert\":\"Classic Risk Formula\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(24, 'admin.configure.logs.index', 'admin_configure_logs_index', 'Audit Trail', '{\"ops\":[{\"insert\":\"Audit Trail\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(25, 'admin.configure.import.index', 'admin_configure_import_index', 'Import/Export', '{\"ops\":[{\"insert\":\"Import/Export\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(26, 'admin.configure.extras.LDAP-Configuration', 'admin_configure_extras_LDAP-Configuration', 'LDAP Authentication', '{\"ops\":[{\"insert\":\"LDAP Authentication\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(27, 'admin.configure.about.edit', 'admin_configure_about_edit', 'About', '{\"ops\":[{\"insert\":\"About\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(28, 'admin.configure.general_setting.edit', 'admin_configure_general_setting_edit', 'GeneralSettings', '{\"ops\":[{\"insert\":\"General Settings\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(29, 'admin.configure.service_description.edit', 'admin_configure_service_description_edit', 'ServicesDescription', '{\"ops\":[{\"insert\":\"Services Description...\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(30, 'admin.configure.change_request_department.edit', 'admin_configure_change_request_department_edit', 'ChangeRequestsResponsibleDepartment', '{\"ops\":[{\"insert\":\"Change requests responsible department\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(31, 'admin.hierarchy.index', 'admin_hierarchy_index', 'Hierarchy', '{\"ops\":[{\"insert\":\"Hierarchy....\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(32, 'admin.hierarchy.org_chart', 'admin_hierarchy_org_chart', 'Organization Chart', '{\"ops\":[{\"insert\":\"Organization Chart\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(33, 'admin.hierarchy.department.index', 'admin_hierarchy_department_index', 'Department', '{\"ops\":[{\"insert\":\"Department\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(34, 'admin.hierarchy.job.index', 'admin_hierarchy_job_index', 'Job', '{\"ops\":[{\"insert\":\"Job\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(35, 'admin.task.index', 'admin_task_index', 'CreatedTasks', '{\"ops\":[{\"insert\":\"Created tasks\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(36, 'admin.task.assigned_to_me', 'admin_task_assigned_to_me', 'MyTasks', '{\"ops\":[{\"insert\":\"My tasks\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(37, 'admin.vulnerability_management.index', 'admin_vulnerability_management_index', 'Navbar Vulnerability Management', '{\"ops\":[{\"insert\":\"Vulnerability Mgmt\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(38, 'admin.change_request.index', 'admin_change_request_index', 'ChangeRequest', '{\"ops\":[{\"insert\":\"Change request\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(39, 'admin.KPI.index', 'admin_KPI_index', 'KPI', '{\"ops\":[{\"insert\":\"key performance indicator\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}'),
(40, 'admin.security_awareness.index', 'admin_security_awareness_index', 'SecurityAwareness', '{\"ops\":[{\"insert\":\"Security awareness\"},{\"attributes\":{\"header\":3},\"insert\":\"\\n\"}]}');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int UNSIGNED DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'alert_timeout', '5'),
(2, 'allow_ownermanager_to_risk', '1'),
(3, 'allow_owner_to_risk', '1'),
(4, 'allow_stakeholder_to_risk', '1'),
(5, 'allow_submitter_to_risk', '1'),
(6, 'allow_team_member_to_risk', '1'),
(7, 'auto_verify_new_assets', '0'),
(8, 'backup_auto', 'true'),
(9, 'backup_remove', '1'),
(10, 'backup_schedule', 'daily'),
(11, 'bootstrap_delivery_method', 'cdn'),
(12, 'closed_audit_status', '5'),
(13, 'content_security_policy', '0'),
(14, 'currency', '$'),
(15, 'db_version', '20211115-001'),
(16, 'debug_logging', '0'),
(17, 'debug_log_file', '/tmp/debug_log'),
(18, 'default_asset_valuation', '5'),
(19, 'default_current_maturity', '0'),
(20, 'default_date_format', 'MM/DD/YYYY'),
(21, 'default_desired_maturity', '3'),
(22, 'default_language', 'en'),
(23, 'default_risk_score', '10'),
(24, 'default_timezone', 'Asia/Riyadh'),
(25, 'highcharts_delivery_method', 'cdn'),
(26, 'instance_id', 'WtrZ7UYyt7XdoRsTKftzHI9uv5mdXFKPCRcZf83ZoUYRu0pxXZ'),
(27, 'jquery_delivery_method', 'cdn'),
(28, 'maximum_risk_subject_length', '300'),
(29, 'max_upload_size', '5120000'),
(30, 'next_review_date_uses', 'InherentRisk'),
(31, 'NOTIFY_ADDITIONAL_STAKEHOLDERS', 'true'),
(32, 'pass_policy_alpha_required', '1'),
(33, 'pass_policy_attempt_lockout', '0'),
(34, 'pass_policy_attempt_lockout_time', '10'),
(35, 'pass_policy_digits_required', '1'),
(36, 'pass_policy_enabled', '1'),
(37, 'pass_policy_lower_required', '1'),
(38, 'pass_policy_max_age', '0'),
(39, 'pass_policy_min_age', '0'),
(40, 'pass_policy_min_chars', '8'),
(41, 'pass_policy_reuse_limit', '0'),
(42, 'pass_policy_re_use_tracking', '0'),
(43, 'pass_policy_special_required', '1'),
(44, 'pass_policy_upper_required', '1'),
(45, 'phpmailer_from_email', 'noreply@simplerisk.it'),
(46, 'phpmailer_from_name', 'SimpleRisk'),
(47, 'phpmailer_host', 'smtp1.example.com'),
(48, 'phpmailer_password', 'secret'),
(49, 'phpmailer_port', '587'),
(50, 'phpmailer_prepend', '[SIMPLERISK]'),
(51, 'phpmailer_replyto_email', 'noreply@simplerisk.it'),
(52, 'phpmailer_replyto_name', 'SimpleRisk'),
(53, 'phpmailer_smtpauth', 'false'),
(54, 'phpmailer_smtpautotls', 'true'),
(55, 'phpmailer_smtpsecure', 'none'),
(56, 'phpmailer_transport', 'sendmail'),
(57, 'phpmailer_username', 'user@example.com'),
(58, 'plan_projects_show_all', '0'),
(59, 'registration_registered', '0'),
(60, 'risk_appetite', '0'),
(61, 'risk_mapping_required', '0'),
(62, 'risk_model', '2'),
(63, 'session_absolute_timeout', '28800'),
(64, 'session_activity_timeout', '3600'),
(65, 'simplerisk_base_url', 'http://localhost:8000'),
(66, 'strict_user_validation', '1'),
(67, 'LDAP_DEFAULT_HOSTS', 'www.zflexldap.com'),
(68, 'LDAP_DEFAULT_PORT', '389'),
(69, 'LDAP_DEFAULT_BASE_DN', 'dc=zflexsoftware,dc=com'),
(70, 'LDAP_DEFAULT_USERNAME', 'cn=ro_admin,ou=sysadmins,dc=zflexsoftware,dc=com'),
(71, 'LDAP_USER_FLITER', ''),
(72, 'LDAP_DEFAULT_PASSWORD', 'zflexpass'),
(73, 'LDAP_DEFAULT_SSL', 'false'),
(74, 'LDAP_DEFAULT_TLS', 'false'),
(75, 'LDAP_DEFAULT_VSERSION', '3'),
(76, 'LDAP_DEFAULT_TIMEOUT', '5'),
(77, 'LDAP_DEFAULT_Follow', 'false'),
(78, 'LDAP_name', ''),
(79, 'LDAP_email', ''),
(80, 'LDAP_username', ''),
(81, 'LDAP_password', ''),
(82, 'LDAP_dapartment', ''),
(83, 'APP_NAME', 'Cyber Mode'),
(84, 'APP_AUTHOR_EN', 'Cyber Mode'),
(85, 'APP_AUTHOR_AR', 'Cyber Mode'),
(86, 'APP_AUTHOR_ABBR_EN', 'Cyber Mode'),
(87, 'APP_AUTHOR_ABBR_AR', 'Cyber Mode'),
(88, 'APP_AUTHOR_WEBSITE', 'https://www.advancedcontrols.com'),
(89, 'APP_OWNER_EN', 'Cyber Mode'),
(90, 'APP_OWNER_AR', 'Cyber Mode'),
(91, 'APP_LOGO', 'images/logo/1667651514.png'),
(92, 'APP_FAVICON', 'images/ico/favicon.ico'),
(93, 'change_requests_responsible_department_id', '25');

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE `sources` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`) VALUES
(1, 'People'),
(2, 'Process'),
(3, 'System'),
(4, 'External');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'New'),
(2, 'Mitigation Planned'),
(3, 'Mgmt Reviewed'),
(4, 'Closed'),
(5, 'Reopened'),
(6, 'Untreated'),
(7, 'Treated');

-- --------------------------------------------------------

--
-- Table structure for table `subgroups`
--

CREATE TABLE `subgroups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_group_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subgroups`
--

INSERT INTO `subgroups` (`id`, `name`, `permission_group_id`, `created_at`, `updated_at`) VALUES
(1, 'Frameworks', 1, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(2, 'Controls', 1, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(3, 'Document', 1, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(4, 'Exception', 1, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(5, 'Risks', 2, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(6, 'Projects', 2, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(7, 'Compliance', 3, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(8, 'Tests', 3, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(9, 'Audits', 3, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(10, 'Assets', 4, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(11, 'Assessments', 5, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(12, 'RoleManagement', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(13, 'Add Values', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(14, 'Audit Logs', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(15, 'Hierarchy', 7, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(16, 'Department', 7, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(17, 'Job', 7, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(18, 'Employee', 7, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(19, 'Plan Mitigation', 2, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(20, 'Perform Reviews', 2, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(21, 'AssetGroups', 4, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(22, 'Categories', 1, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(23, 'User Management', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(24, 'Settings', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(25, 'ClassicRiskFormula', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(26, 'Import And Export', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(27, 'LDAP', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(28, 'Reporting', 8, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(29, 'Task', 9, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(30, 'About', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(31, 'Vulnerability Management', 10, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(32, 'General Setting', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(33, 'Services Description', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(34, 'Change Request', 11, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(35, 'Change Request Department', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(36, 'KPI', 12, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(37, 'Security Awareness', 13, '2022-11-07 18:00:31', '2022-11-07 18:00:31'),
(38, 'Domain', 6, '2022-11-07 18:00:31', '2022-11-07 18:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `tag_id` bigint UNSIGNED NOT NULL,
  `taggable_id` bigint UNSIGNED NOT NULL,
  `taggable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `tag` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('Urgent','High','Normal','Low','No Priority') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Open','In Progress','Completed','Accepted','Closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `completed_date` timestamp NULL DEFAULT NULL,
  `accepted_date` timestamp NULL DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `assignable_id` bigint UNSIGNED NOT NULL,
  `assignable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `action_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_notes`
--

CREATE TABLE `task_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `note` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_note_files`
--

CREATE TABLE `task_note_files` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `display_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_vulnerabilities`
--

CREATE TABLE `team_vulnerabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `vulnerability_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `name`) VALUES
(1, 'Todos'),
(2, 'Anti-Virus'),
(3, 'Backups'),
(4, 'Blackberry'),
(5, 'Citrix'),
(6, 'Datacenter'),
(7, 'Mail Routing'),
(8, 'Live Collaboration'),
(9, 'Mesajeria'),
(10, 'Mobile'),
(11, 'Network'),
(12, 'Power'),
(13, 'Remote Access'),
(14, 'SAN'),
(15, 'Telecom'),
(16, 'Unix'),
(17, 'VMWare'),
(18, 'Web'),
(19, 'Windows');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_class` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `name`, `background_class`) VALUES
(1, 'Not Applicable', '#d0d0d0'),
(2, 'Not Implemented', '#FFA1A1'),
(3, 'Partially Implemented', '#ffe700'),
(4, 'Implemented', '#00d4bd');

-- --------------------------------------------------------

--
-- Table structure for table `test_statuses`
--

CREATE TABLE `test_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_statuses`
--

INSERT INTO `test_statuses` (`id`, `name`) VALUES
(1, 'Pending Evidence from Control Owner'),
(2, 'Evidence Submitted / Pending Review'),
(3, 'Passed Internal QA'),
(4, 'Remediation Required'),
(5, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `threat_catalogs`
--

CREATE TABLE `threat_catalogs` (
  `id` bigint UNSIGNED NOT NULL,
  `number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `threat_grouping_id` bigint UNSIGNED NOT NULL,
  `name` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `threat_catalogs`
--

INSERT INTO `threat_catalogs` (`id`, `number`, `threat_grouping_id`, `name`, `description`, `order`) VALUES
(1, 'NT-1', 1, 'Drought & Water Shortage', 'Regardless of geographic location, periods of reduced rainfall are expected. For non-agricultural industries, drought may not be impactful to operations until it reaches the extent of water rationing.', 1),
(2, 'NT-2', 1, 'Earthquakes', 'Earthquakes are sudden rolling or shaking events caused by movement under the earth’s surface. Although earthquakes usually last less than one minute, the scope of devastation can be widespread and have long-lasting impact.', 2),
(3, 'NT-3', 1, 'Fire & Wildfires', 'Regardless of geographic location or even building material, fire is a concern for every business. When thinking of a fire in a building, envision a total loss to all technology hardware, including backup tapes, and all paper files being consumed in the fire.', 3),
(4, 'NT-4', 1, 'Floods', 'Flooding is the most common of natural hazards and requires an understanding of the local environment, including floodplains and the frequency of flooding events. Location of critical technologies should be considered (e.g., server room is in the basement or first floor of the facility).', 4),
(5, 'NT-5', 1, 'Hurricanes & Tropical Storms', 'Hurricanes and tropical storms are among the most powerful natural disasters because of their size and destructive potential. In addition to high winds, regional flooding and infrastructure damage should be considered when assessing hurricanes and tropical storms.', 5),
(6, 'NT-6', 1, 'Landslides & Debris Flow', 'Landslides occur throughout the world and can be caused by a variety of factors including earthquakes, storms, volcanic eruptions, fire, and by human modification of land. Landslides can occur quickly, often with little notice. Location of critical technologies should be considered (e.g., server room is in the basement or first floor of the facility).', 6),
(7, 'NT-7', 1, 'Pandemic (Disease) Outbreaks', 'Due to the wide variety of possible scenarios, consideration should be given both to the magnitude of what can reasonably happen during a pandemic outbreak (e.g., COVID-19, Influenza, SARS, Ebola, etc.) and what actions the business can be taken to help lessen the impact of a  pandemic on operations.', 7),
(8, 'NT-8', 1, 'Severe Weather', 'Severe weather is a broad category of meteorological events that include events that range from damaging winds to hail.', 8),
(9, 'NT-9', 1, 'Space Weather', 'Space weather includes natural events in space that can affect the near-earth environment and satellites. Most commonly, this is associated with solar flares from the Sun, so an understanding of how solar flares may impact the business is of critical importance in assessing this threat.', 9),
(10, 'NT-10', 1, 'Thunderstorms & Lightning', 'Thunderstorms are most prevalent in the spring and summer months and generally occur during the afternoon and evening hours, but they can occur year-round and at all hours. Many hazardous weather events are associated with thunderstorms. Under the right conditions, rainfall from thunderstorms causes flash flooding and lightning is responsible for equipment damage, fires and fatalities.', 10),
(11, 'NT-11', 1, 'Tornadoes', 'Tornadoes occur in many parts of the world, including the US, Australia, Europe, Africa, Asia, and South America. Tornadoes can happen at any time of year and occur at any time of day or night, but most tornadoes occur between 4–9 p.m. Tornadoes (with winds up to about 300 mph) can destroy all but the best-built man-made structures.', 11),
(12, 'NT-12', 1, 'Tsunamis', 'All tsunamis are potentially dangerous, even though they may not damage every coastline they strike. A tsunami can strike anywhere along most of the US coastline. The most destructive tsunamis have occurred along the coasts of California, Oregon, Washington, Alaska and Hawaii.', 12),
(13, 'NT-13', 1, 'Volcanoes', 'While volcanoes are geographically fixed objects, volcanic fallout can have significant downwind impacts for thousands of miles. Far outside of the blast zone, volcanoes can significantly damage or degrade transportation systems and also cause electrical grids to fail.', 13),
(14, 'NT-14', 1, 'Winter Storms & Extreme Cold', 'Winter storms is a broad category of meteorological events that include events that range from ice storms, to heavy snowfall, to unseasonably (e.g., record breaking) cold temperatures. Winter storms can significantly impact business operations and transportation systems over a wide geographic region.', 14),
(15, 'MT-1', 2, 'Civil or Political Unrest', 'Civil or political unrest can be singular or wide-spread events that can be unexpected and unpredictable. These events can occur anywhere, at any time.', 15),
(16, 'MT-2', 2, 'Hacking & Other Cybersecurity Crimes', 'Unlike physical threats that prompt immediate action (e.g., \\\"stop, drop, and roll\\\" in the event of a fire), cyber incidents are often difficult to identify as the incident is occurring. Detection generally occurs after the incident has occurred, with the exception of \\\"denial of service\\\" attacks. The spectrum of cybersecurity risks is limitless and threats can have wide-ranging effects on the individual, organizational, geographic, and national levels.', 16),
(17, 'MT-3', 2, 'Hazardous Materials Emergencies', 'Hazardous materials emergencies are focused on accidental disasters that occur in industrialized nations. These incidents can range from industrial chemical spills to groundwater contamination.', 17),
(18, 'MT-4', 2, 'Nuclear, Biological and Chemical (NBC) Weapons', 'The use of NBC weapons are in the possible arsenals of international terrorists and it must be a consideration. Terrorist use of a “dirty bomb” — is considered far more likely than use of a traditional nuclear explosive device. This may be a combination a conventional explosive device with radioactive / chemical / biological material and be designed to scatter lethal and sub-lethal amounts of material over a wide area.', 18),
(19, 'MT-5', 2, 'Physical Crime', 'Physical crime includes \\\"traditional\\\" crimes of opportunity. These incidents can range from theft, to vandalism, riots, looting, arson and other forms of criminal activities.', 19),
(20, 'MT-6', 2, 'Terrorism & Armed Attacks', 'Armed attacks, regardless of the motivation of the attacker, can impact a businesses. Scenarios can range from single actors (e.g., \\\"disgruntled\\\" employee) all the way to a coordinated terrorist attack by multiple assailants. These incidents can range from the use of blade weapons (e.g., knives), blunt objects (e.g., clubs), to firearms and explosives.', 20),
(21, 'MT-7', 2, 'Utility Service Disruption', 'Utility service disruptions are focused on the sustained loss of electricity, Internet, natural gas, water, and/or sanitation services. These incidents can have a variety of causes but  directly impact the fulfillment of utility services that your business needs to operate.', 21);

-- --------------------------------------------------------

--
-- Table structure for table `threat_groupings`
--

CREATE TABLE `threat_groupings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `threat_groupings`
--

INSERT INTO `threat_groupings` (`id`, `name`) VALUES
(1, 'Natural Threat'),
(2, 'Man-Made Threat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `lockout` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'grc',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_password_change_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` bigint UNSIGNED NOT NULL,
  `lang` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `multi_factor` int NOT NULL DEFAULT '1',
  `ldap_department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change_password` tinyint(1) NOT NULL DEFAULT '0',
  `custom_display_settings` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  `job_id` bigint UNSIGNED DEFAULT NULL,
  `custom_plan_mitigation_display_settings` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n',
  `custom_perform_reviews_display_settings` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n',
  `custom_reviewregularly_display_settings` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["days_open","1"]],"review_colums":[["management_review","0"],["review_date","0"],["next_step","0"],["next_review_date","1"],["comments","0"]]}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `enabled`, `lockout`, `type`, `username`, `name`, `email`, `salt`, `password`, `last_login`, `last_password_change_date`, `role_id`, `lang`, `admin`, `multi_factor`, `ldap_department`, `change_password`, `custom_display_settings`, `department_id`, `manager_id`, `job_id`, `custom_plan_mitigation_display_settings`, `custom_perform_reviews_display_settings`, `custom_reviewregularly_display_settings`) VALUES
(1, 1, 0, 'grc', 'admin', 'Admin', 'admin@gmail.com', 'qCJpnAe5S6k61Pqh3SFG', '$2y$10$ZpMbfthFKqmSnwPrS0sbPeOFiOOMncIgxUUIiKdXqPzs7ky0thxve', '2022-01-17 09:00:33', '2017-01-08 09:58:20', 1, NULL, 1, 1, NULL, 0, '[\\\"id\\\",\\\"subject\\\",\\\"calculated_risk\\\",\\\"submission_date\\\",\\\"mitigation_planned\\\",\\\"management_review\\\"]', NULL, NULL, NULL, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}', '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"submission_date\\\",\\\"1\\\"]],\\\"mitigation_colums\\\":[[\\\"mitigation_planned\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"1\\\"]]}\\n', '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"days_open\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"0\\\"],[\\\"review_date\\\",\\\"0\\\"],[\\\"next_step\\\",\\\"0\\\"],[\\\"next_review_date\\\",\\\"1\\\"],[\\\"comments\\\",\\\"0\\\"]]}');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `notification_id` bigint UNSIGNED NOT NULL,
  `is_read` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_histories`
--

CREATE TABLE `user_pass_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `salt` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_reuse_histories`
--

CREATE TABLE `user_pass_reuse_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `counts` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_to_teams`
--

CREATE TABLE `user_to_teams` (
  `user_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `validation_files`
--

CREATE TABLE `validation_files` (
  `id` bigint UNSIGNED NOT NULL,
  `mitigation_id` bigint UNSIGNED NOT NULL,
  `control_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int NOT NULL,
  `content` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vulnerabilities`
--

CREATE TABLE `vulnerabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cve` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `severity` enum('Critical','High','Medium','Low','Informational') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recommendation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Open','In Progress','Closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `update_status_date` timestamp NULL DEFAULT NULL,
  `update_status_user` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_answers_assessment_id_foreign` (`assessment_id`),
  ADD KEY `assessment_answers_assessment_scoring_id_foreign` (`assessment_scoring_id`);

--
-- Indexes for table `assessment_answers_to_assets`
--
ALTER TABLE `assessment_answers_to_assets`
  ADD UNIQUE KEY `assessment_answer_asset_unique` (`assessment_answer_id`,`asset_id`),
  ADD KEY `assessment_answers_to_assets_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `assessment_answers_to_asset_groups`
--
ALTER TABLE `assessment_answers_to_asset_groups`
  ADD UNIQUE KEY `assessment_answer_asset_group_unique` (`assessment_answer_id`,`asset_group_id`),
  ADD KEY `assessment_answers_to_asset_groups_asset_group_id_foreign` (`asset_group_id`);

--
-- Indexes for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_questions_assessment_id_foreign` (`assessment_id`);

--
-- Indexes for table `assessment_scorings`
--
ALTER TABLE `assessment_scorings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `A_S_C_I_A_S_id_foreign` (`assessment_scoring_id`),
  ADD KEY `A_S_C_I_C_R_id_foreign` (`contributing_risk_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `assets_asset_value_id_foreign` (`asset_value_id`),
  ADD KEY `assets_location_id_foreign` (`location_id`);

--
-- Indexes for table `assets_asset_groups`
--
ALTER TABLE `assets_asset_groups`
  ADD UNIQUE KEY `asset_asset_group_unique` (`asset_id`,`asset_group_id`),
  ADD KEY `assets_asset_groups_asset_group_id_foreign` (`asset_group_id`);

--
-- Indexes for table `asset_asset_groups`
--
ALTER TABLE `asset_asset_groups`
  ADD UNIQUE KEY `asset_asset_group_unique` (`asset_id`,`asset_group_id`),
  ADD KEY `asset_asset_groups_asset_group_id_foreign` (`asset_group_id`);

--
-- Indexes for table `asset_groups`
--
ALTER TABLE `asset_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_unique` (`name`);

--
-- Indexes for table `asset_values`
--
ALTER TABLE `asset_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_vulnerabilities`
--
ALTER TABLE `asset_vulnerabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_vulnerabilities_asset_id_foreign` (`asset_id`),
  ADD KEY `asset_vulnerabilities_vulnerability_id_foreign` (`vulnerability_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_requests`
--
ALTER TABLE `change_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `change_requests_created_by_foreign` (`created_by`);

--
-- Indexes for table `close_reasons`
--
ALTER TABLE `close_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closures`
--
ALTER TABLE `closures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `closures_risk_id_foreign` (`risk_id`),
  ADD KEY `closures_user_id_foreign` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `compliance_files`
--
ALTER TABLE `compliance_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contributing_risks`
--
ALTER TABLE `contributing_risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contributing_risks_impacts_contributing_risks_id_foreign` (`contributing_risks_id`);

--
-- Indexes for table `contributing_risks_likelihoods`
--
ALTER TABLE `contributing_risks_likelihoods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_classes`
--
ALTER TABLE `control_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_desired_maturities`
--
ALTER TABLE `control_desired_maturities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_maturities`
--
ALTER TABLE `control_maturities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_owners`
--
ALTER TABLE `control_owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_phases`
--
ALTER TABLE `control_phases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_priorities`
--
ALTER TABLE `control_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_types`
--
ALTER TABLE `control_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_risk_model_values`
--
ALTER TABLE `custom_risk_model_values`
  ADD UNIQUE KEY `impact_likelihood_unique` (`impact_id`,`likelihood_id`),
  ADD KEY `custom_risk_model_values_likelihood_id_foreign` (`likelihood_id`);

--
-- Indexes for table `cvss_scorings`
--
ALTER TABLE `cvss_scorings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_classifications`
--
ALTER TABLE `data_classifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date_formats`
--
ALTER TABLE `date_formats`
  ADD PRIMARY KEY (`value`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_parent_id_foreign` (`parent_id`),
  ADD KEY `departments_color_id_foreign` (`color_id`),
  ADD KEY `departments_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `department_colors`
--
ALTER TABLE `department_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_document_type_foreign` (`document_type`),
  ADD KEY `documents_privacy_foreign` (`privacy`),
  ADD KEY `documents_document_owner_foreign` (`document_owner`),
  ADD KEY `documents_document_reviewer_foreign` (`document_reviewer`),
  ADD KEY `documents_created_by_foreign` (`created_by`);

--
-- Indexes for table `document_exceptions`
--
ALTER TABLE `document_exceptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_exceptions_statuses`
--
ALTER TABLE `document_exceptions_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_notes`
--
ALTER TABLE `document_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_notes_user_id_foreign` (`user_id`),
  ADD KEY `document_notes_document_id_foreign` (`document_id`);

--
-- Indexes for table `document_note_files`
--
ALTER TABLE `document_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_note_files_user_id_foreign` (`user_id`),
  ADD KEY `document_note_files_document_id_foreign` (`document_id`);

--
-- Indexes for table `document_statuses`
--
ALTER TABLE `document_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dynamic_saved_selections_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_login_attempts_user_id_foreign` (`user_id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_parent_id_unique` (`order`,`parent_id`),
  ADD KEY `families_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `file_tasks`
--
ALTER TABLE `file_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_tasks_task_id_foreign` (`task_id`);

--
-- Indexes for table `file_types`
--
ALTER TABLE `file_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `file_type_extensions`
--
ALTER TABLE `file_type_extensions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `frameworks`
--
ALTER TABLE `frameworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `framework_controls`
--
ALTER TABLE `framework_controls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_controls_family_foreign` (`family`),
  ADD KEY `framework_controls_control_owner_foreign` (`control_owner`),
  ADD KEY `framework_controls_desired_maturity_foreign` (`desired_maturity`),
  ADD KEY `framework_controls_control_priority_foreign` (`control_priority`),
  ADD KEY `framework_controls_control_class_foreign` (`control_class`),
  ADD KEY `framework_controls_control_maturity_foreign` (`control_maturity`),
  ADD KEY `framework_controls_control_phase_foreign` (`control_phase`),
  ADD KEY `framework_controls_control_type_foreign` (`control_type`),
  ADD KEY `framework_controls_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_mappings_framework_control_id_foreign` (`framework_control_id`),
  ADD KEY `framework_control_mappings_framework_id_foreign` (`framework_id`);

--
-- Indexes for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_tests_framework_control_id_foreign` (`framework_control_id`),
  ADD KEY `FK_framework_control_test_tester` (`tester`);

--
-- Indexes for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_audits_test_id_foreign` (`test_id`),
  ADD KEY `framework_control_test_audits_framework_control_id_foreign` (`framework_control_id`),
  ADD KEY `FK_framework_control_test_audit_tester` (`tester`);

--
-- Indexes for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_comments_test_audit_id_foreign` (`test_audit_id`);

--
-- Indexes for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_results_test_audit_id_foreign` (`test_audit_id`),
  ADD KEY `framework_control_test_results_test_result_foreign` (`test_result`);

--
-- Indexes for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_results_to_risks_test_results_id_foreign` (`test_results_id`),
  ADD KEY `framework_control_test_results_to_risks_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `framework_control_to_frameworks`
--
ALTER TABLE `framework_control_to_frameworks`
  ADD PRIMARY KEY (`control_id`,`framework_id`),
  ADD KEY `framework_id` (`framework_id`,`control_id`);

--
-- Indexes for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_type_mappings_control_id_foreign` (`control_id`),
  ADD KEY `framework_control_type_mappings_control_type_id_foreign` (`control_type_id`);

--
-- Indexes for table `framework_families`
--
ALTER TABLE `framework_families`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_families_framework_id_foreign` (`framework_id`),
  ADD KEY `framework_families_family_id_foreign` (`family_id`),
  ADD KEY `framework_families_parent_family_id_foreign` (`parent_family_id`);

--
-- Indexes for table `framework_icons`
--
ALTER TABLE `framework_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impacts`
--
ALTER TABLE `impacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_to_teams`
--
ALTER TABLE `items_to_teams`
  ADD UNIQUE KEY `item_team_unique` (`item_id`,`team_id`,`type`),
  ADD KEY `item_type` (`item_id`,`type`),
  ADD KEY `team_type` (`team_id`,`type`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jobs_code_unique` (`code`);

--
-- Indexes for table `kpis`
--
ALTER TABLE `kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpis_department_id_foreign` (`department_id`),
  ADD KEY `kpis_created_by_foreign` (`created_by`);

--
-- Indexes for table `kpi_assessments`
--
ALTER TABLE `kpi_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpi_assessments_kpi_id_foreign` (`kpi_id`),
  ADD KEY `kpi_assessments_created_by_foreign` (`created_by`),
  ADD KEY `kpi_assessments_action_by_foreign` (`action_by`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likelihoods`
--
ALTER TABLE `likelihoods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mgmt_reviews_risk_id_foreign` (`risk_id`),
  ADD KEY `mgmt_reviews_review_foreign` (`review`),
  ADD KEY `mgmt_reviews_reviewer_foreign` (`reviewer`),
  ADD KEY `mgmt_reviews_next_step_id_foreign` (`next_step_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitigations`
--
ALTER TABLE `mitigations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitigations_planning_strategy_foreign` (`planning_strategy`),
  ADD KEY `mitigations_mitigation_effort_foreign` (`mitigation_effort`),
  ADD KEY `mitigations_mitigation_owner_foreign` (`mitigation_owner`),
  ADD KEY `mitigations_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitigation_accept_users_risk_id_foreign` (`risk_id`),
  ADD KEY `mitigation_accept_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `mitigation_efforts`
--
ALTER TABLE `mitigation_efforts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitigation_to_controls`
--
ALTER TABLE `mitigation_to_controls`
  ADD PRIMARY KEY (`mitigation_id`,`control_id`),
  ADD KEY `control_id` (`control_id`,`mitigation_id`);

--
-- Indexes for table `mitigation_to_teams`
--
ALTER TABLE `mitigation_to_teams`
  ADD PRIMARY KEY (`mitigation_id`,`team_id`),
  ADD KEY `team_id` (`team_id`,`mitigation_id`);

--
-- Indexes for table `next_steps`
--
ALTER TABLE `next_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_risks`
--
ALTER TABLE `pending_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pending_risks_assessment_id_foreign` (`assessment_id`),
  ADD KEY `pending_risks_assessment_answer_id_foreign` (`assessment_answer_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `permissions_subgroup_id_foreign` (`subgroup_id`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_to_permission_groups_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_to_permission_groups_permission_group_id_foreign` (`permission_group_id`);

--
-- Indexes for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_to_users_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_to_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `planning_strategies`
--
ALTER TABLE `planning_strategies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacies`
--
ALTER TABLE `privacies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_pending_risks`
--
ALTER TABLE `questionnaire_pending_risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regulations`
--
ALTER TABLE `regulations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residual_risk_scoring_histories_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_levels`
--
ALTER TABLE `review_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risks`
--
ALTER TABLE `risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risks_control_id_foreign` (`control_id`),
  ADD KEY `risks_source_id_foreign` (`source_id`),
  ADD KEY `risks_category_id_foreign` (`category_id`),
  ADD KEY `risks_owner_id_foreign` (`owner_id`),
  ADD KEY `risks_manager_id_foreign` (`manager_id`),
  ADD KEY `risks_mitigation_id_foreign` (`mitigation_id`),
  ADD KEY `risks_project_id_foreign` (`project_id`),
  ADD KEY `status` (`status`),
  ADD KEY `regulation` (`regulation`),
  ADD KEY `mgmt_review` (`mgmt_review`),
  ADD KEY `close_id` (`close_id`),
  ADD KEY `submitted_by` (`submitted_by`);

--
-- Indexes for table `risks_to_assets`
--
ALTER TABLE `risks_to_assets`
  ADD UNIQUE KEY `risk_id` (`risk_id`,`asset_id`),
  ADD KEY `asset_id` (`asset_id`,`risk_id`);

--
-- Indexes for table `risks_to_asset_groups`
--
ALTER TABLE `risks_to_asset_groups`
  ADD UNIQUE KEY `risk_asset_group_unique` (`risk_id`,`asset_group_id`),
  ADD KEY `asset_group_id` (`asset_group_id`,`risk_id`);

--
-- Indexes for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_catalogs_risk_grouping_id_foreign` (`risk_grouping_id`),
  ADD KEY `risk_catalogs_risk_function_id_foreign` (`risk_function_id`);

--
-- Indexes for table `risk_functions`
--
ALTER TABLE `risk_functions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_groupings`
--
ALTER TABLE `risk_groupings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_levels`
--
ALTER TABLE `risk_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_levels_review_level_id_foreign` (`review_level_id`);

--
-- Indexes for table `risk_models`
--
ALTER TABLE `risk_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_scorings`
--
ALTER TABLE `risk_scorings`
  ADD KEY `risk_scorings_id_foreign` (`id`),
  ADD KEY `calculated_risk` (`calculated_risk`);

--
-- Indexes for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_scoring_contributing_impacts_risk_scoring_id_foreign` (`risk_scoring_id`),
  ADD KEY `risk_scoring_contributing_impacts_contributing_risk_id_foreign` (`contributing_risk_id`);

--
-- Indexes for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risk_scoring_histories_risk_id_foreign` (`risk_id`);

--
-- Indexes for table `risk_to_additional_stakeholders`
--
ALTER TABLE `risk_to_additional_stakeholders`
  ADD PRIMARY KEY (`risk_id`,`user_id`),
  ADD KEY `user_id` (`user_id`,`risk_id`);

--
-- Indexes for table `risk_to_locations`
--
ALTER TABLE `risk_to_locations`
  ADD PRIMARY KEY (`risk_id`,`location_id`),
  ADD KEY `location_id` (`location_id`,`risk_id`);

--
-- Indexes for table `risk_to_teams`
--
ALTER TABLE `risk_to_teams`
  ADD PRIMARY KEY (`risk_id`,`team_id`),
  ADD KEY `team_id` (`team_id`,`risk_id`);

--
-- Indexes for table `risk_to_technologies`
--
ALTER TABLE `risk_to_technologies`
  ADD PRIMARY KEY (`risk_id`,`technology_id`),
  ADD KEY `technology_id` (`technology_id`,`risk_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_responsibilities_role_id_foreign` (`role_id`),
  ADD KEY `role_responsibilities_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `scoring_methods`
--
ALTER TABLE `scoring_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security_awarenesses`
--
ALTER TABLE `security_awarenesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awarenesses_privacy_foreign` (`privacy`),
  ADD KEY `security_awarenesses_file_id_foreign` (`file_id`),
  ADD KEY `security_awarenesses_owner_foreign` (`owner`),
  ADD KEY `security_awarenesses_reviewer_foreign` (`reviewer`),
  ADD KEY `security_awarenesses_created_by_foreign` (`created_by`);

--
-- Indexes for table `security_awareness_exams`
--
ALTER TABLE `security_awareness_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_exams_security_awareness_id_foreign` (`security_awareness_id`);

--
-- Indexes for table `security_awareness_exam_answers`
--
ALTER TABLE `security_awareness_exam_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_exam_answers_foreign` (`security_awareness_exams_id`),
  ADD KEY `security_awareness_exam_answers_examinee_foreign` (`examinee`);

--
-- Indexes for table `security_awareness_exam_questions`
--
ALTER TABLE `security_awareness_exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_exam_options_foreign` (`security_awareness_exams_id`);

--
-- Indexes for table `security_awareness_notes`
--
ALTER TABLE `security_awareness_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_notes_user_id_foreign` (`user_id`),
  ADD KEY `security_awareness_notes_security_awareness_id_foreign` (`security_awareness_id`);

--
-- Indexes for table `security_awareness_note_files`
--
ALTER TABLE `security_awareness_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_awareness_note_files_user_id_foreign` (`user_id`),
  ADD KEY `security_awareness_note_files_security_awareness_id_foreign` (`security_awareness_id`);

--
-- Indexes for table `service_descriptions`
--
ALTER TABLE `service_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_descriptions_route_unique` (`route`),
  ADD UNIQUE KEY `service_descriptions_key_unique` (`key`),
  ADD UNIQUE KEY `service_descriptions_name_key_unique` (`name_key`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sources`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subgroups`
--
ALTER TABLE `subgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subgroups_permission_group_id_foreign` (`permission_group_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_unique` (`tag`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_created_by_foreign` (`created_by`),
  ADD KEY `tasks_action_by_foreign` (`action_by`);

--
-- Indexes for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_notes_user_id_foreign` (`user_id`),
  ADD KEY `task_notes_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_note_files`
--
ALTER TABLE `task_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_note_files_user_id_foreign` (`user_id`),
  ADD KEY `task_note_files_task_id_foreign` (`task_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_vulnerabilities`
--
ALTER TABLE `team_vulnerabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_vulnerabilities_team_id_foreign` (`team_id`),
  ADD KEY `team_vulnerabilities_vulnerability_id_foreign` (`vulnerability_id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_unique` (`name`);

--
-- Indexes for table `test_statuses`
--
ALTER TABLE `test_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `threat_catalogs_threat_grouping_id_foreign` (`threat_grouping_id`);

--
-- Indexes for table `threat_groupings`
--
ALTER TABLE `threat_groupings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_manager_id_foreign` (`manager_id`),
  ADD KEY `users_job_id_foreign` (`job_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notifications_notification_id_foreign` (`notification_id`);

--
-- Indexes for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pass_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pass_reuse_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_to_teams`
--
ALTER TABLE `user_to_teams`
  ADD PRIMARY KEY (`user_id`,`team_id`),
  ADD KEY `team_id` (`team_id`,`user_id`);

--
-- Indexes for table `validation_files`
--
ALTER TABLE `validation_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `validation_files_mitigation_id_foreign` (`mitigation_id`);

--
-- Indexes for table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vulnerabilities_update_status_user_foreign` (`update_status_user`),
  ADD KEY `vulnerabilities_created_by_foreign` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_scorings`
--
ALTER TABLE `assessment_scorings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_groups`
--
ALTER TABLE `asset_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_values`
--
ALTER TABLE `asset_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `asset_vulnerabilities`
--
ALTER TABLE `asset_vulnerabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `change_requests`
--
ALTER TABLE `change_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `close_reasons`
--
ALTER TABLE `close_reasons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `closures`
--
ALTER TABLE `closures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_files`
--
ALTER TABLE `compliance_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributing_risks`
--
ALTER TABLE `contributing_risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributing_risks_likelihoods`
--
ALTER TABLE `contributing_risks_likelihoods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_classes`
--
ALTER TABLE `control_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `control_desired_maturities`
--
ALTER TABLE `control_desired_maturities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `control_maturities`
--
ALTER TABLE `control_maturities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `control_owners`
--
ALTER TABLE `control_owners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_phases`
--
ALTER TABLE `control_phases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_priorities`
--
ALTER TABLE `control_priorities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_types`
--
ALTER TABLE `control_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cvss_scorings`
--
ALTER TABLE `cvss_scorings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_classifications`
--
ALTER TABLE `data_classifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_colors`
--
ALTER TABLE `department_colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `document_exceptions`
--
ALTER TABLE `document_exceptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_exceptions_statuses`
--
ALTER TABLE `document_exceptions_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_notes`
--
ALTER TABLE `document_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_note_files`
--
ALTER TABLE `document_note_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_statuses`
--
ALTER TABLE `document_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `file_tasks`
--
ALTER TABLE `file_tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_types`
--
ALTER TABLE `file_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `file_type_extensions`
--
ALTER TABLE `file_type_extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `frameworks`
--
ALTER TABLE `frameworks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `framework_controls`
--
ALTER TABLE `framework_controls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1114;

--
-- AUTO_INCREMENT for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_families`
--
ALTER TABLE `framework_families`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `framework_icons`
--
ALTER TABLE `framework_icons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `impacts`
--
ALTER TABLE `impacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpis`
--
ALTER TABLE `kpis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_assessments`
--
ALTER TABLE `kpi_assessments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `likelihoods`
--
ALTER TABLE `likelihoods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `mitigations`
--
ALTER TABLE `mitigations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mitigation_efforts`
--
ALTER TABLE `mitigation_efforts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `next_steps`
--
ALTER TABLE `next_steps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_risks`
--
ALTER TABLE `pending_risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `planning_strategies`
--
ALTER TABLE `planning_strategies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `privacies`
--
ALTER TABLE `privacies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionnaire_pending_risks`
--
ALTER TABLE `questionnaire_pending_risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regulations`
--
ALTER TABLE `regulations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_levels`
--
ALTER TABLE `review_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risks`
--
ALTER TABLE `risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `risk_functions`
--
ALTER TABLE `risk_functions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risk_groupings`
--
ALTER TABLE `risk_groupings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `risk_levels`
--
ALTER TABLE `risk_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `risk_models`
--
ALTER TABLE `risk_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `scoring_methods`
--
ALTER TABLE `scoring_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `security_awarenesses`
--
ALTER TABLE `security_awarenesses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_awareness_exams`
--
ALTER TABLE `security_awareness_exams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_awareness_exam_answers`
--
ALTER TABLE `security_awareness_exam_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_awareness_exam_questions`
--
ALTER TABLE `security_awareness_exam_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_awareness_notes`
--
ALTER TABLE `security_awareness_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_awareness_note_files`
--
ALTER TABLE `security_awareness_note_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_descriptions`
--
ALTER TABLE `service_descriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subgroups`
--
ALTER TABLE `subgroups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_notes`
--
ALTER TABLE `task_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_note_files`
--
ALTER TABLE `task_note_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_vulnerabilities`
--
ALTER TABLE `team_vulnerabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_statuses`
--
ALTER TABLE `test_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `threat_groupings`
--
ALTER TABLE `threat_groupings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `validation_files`
--
ALTER TABLE `validation_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  ADD CONSTRAINT `assessment_answers_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`),
  ADD CONSTRAINT `assessment_answers_assessment_scoring_id_foreign` FOREIGN KEY (`assessment_scoring_id`) REFERENCES `assessment_scorings` (`id`);

--
-- Constraints for table `assessment_answers_to_assets`
--
ALTER TABLE `assessment_answers_to_assets`
  ADD CONSTRAINT `assessment_answers_to_assets_assessment_answer_id_foreign` FOREIGN KEY (`assessment_answer_id`) REFERENCES `assessment_answers` (`id`),
  ADD CONSTRAINT `assessment_answers_to_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_answers_to_asset_groups`
--
ALTER TABLE `assessment_answers_to_asset_groups`
  ADD CONSTRAINT `assessment_answers_to_asset_groups_assessment_answer_id_foreign` FOREIGN KEY (`assessment_answer_id`) REFERENCES `assessment_answers` (`id`),
  ADD CONSTRAINT `assessment_answers_to_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`);

--
-- Constraints for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD CONSTRAINT `assessment_questions_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`);

--
-- Constraints for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  ADD CONSTRAINT `A_S_C_I_A_S_id_foreign` FOREIGN KEY (`assessment_scoring_id`) REFERENCES `assessment_scorings` (`id`),
  ADD CONSTRAINT `A_S_C_I_C_R_id_foreign` FOREIGN KEY (`contributing_risk_id`) REFERENCES `contributing_risks` (`id`);

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_asset_value_id_foreign` FOREIGN KEY (`asset_value_id`) REFERENCES `asset_values` (`id`),
  ADD CONSTRAINT `assets_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `assets_asset_groups`
--
ALTER TABLE `assets_asset_groups`
  ADD CONSTRAINT `assets_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`),
  ADD CONSTRAINT `assets_asset_groups_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_asset_groups`
--
ALTER TABLE `asset_asset_groups`
  ADD CONSTRAINT `asset_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_asset_groups_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_vulnerabilities`
--
ALTER TABLE `asset_vulnerabilities`
  ADD CONSTRAINT `asset_vulnerabilities_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `asset_vulnerabilities_vulnerability_id_foreign` FOREIGN KEY (`vulnerability_id`) REFERENCES `vulnerabilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `change_requests`
--
ALTER TABLE `change_requests`
  ADD CONSTRAINT `change_requests_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `closures`
--
ALTER TABLE `closures`
  ADD CONSTRAINT `closures_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `closures_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  ADD CONSTRAINT `contributing_risks_impacts_contributing_risks_id_foreign` FOREIGN KEY (`contributing_risks_id`) REFERENCES `contributing_risks` (`id`);

--
-- Constraints for table `custom_risk_model_values`
--
ALTER TABLE `custom_risk_model_values`
  ADD CONSTRAINT `custom_risk_model_values_impact_id_foreign` FOREIGN KEY (`impact_id`) REFERENCES `impacts` (`id`),
  ADD CONSTRAINT `custom_risk_model_values_likelihood_id_foreign` FOREIGN KEY (`likelihood_id`) REFERENCES `likelihoods` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `department_colors` (`id`),
  ADD CONSTRAINT `departments_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_document_owner_foreign` FOREIGN KEY (`document_owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_document_reviewer_foreign` FOREIGN KEY (`document_reviewer`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_document_type_foreign` FOREIGN KEY (`document_type`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `documents_privacy_foreign` FOREIGN KEY (`privacy`) REFERENCES `privacies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_notes`
--
ALTER TABLE `document_notes`
  ADD CONSTRAINT `document_notes_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `document_note_files`
--
ALTER TABLE `document_note_files`
  ADD CONSTRAINT `document_note_files_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_note_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  ADD CONSTRAINT `dynamic_saved_selections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  ADD CONSTRAINT `failed_login_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `families`
--
ALTER TABLE `families`
  ADD CONSTRAINT `families_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `families` (`id`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `file_tasks`
--
ALTER TABLE `file_tasks`
  ADD CONSTRAINT `file_tasks_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_controls`
--
ALTER TABLE `framework_controls`
  ADD CONSTRAINT `framework_controls_control_class_foreign` FOREIGN KEY (`control_class`) REFERENCES `control_classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_maturity_foreign` FOREIGN KEY (`control_maturity`) REFERENCES `control_maturities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_owner_foreign` FOREIGN KEY (`control_owner`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_phase_foreign` FOREIGN KEY (`control_phase`) REFERENCES `control_phases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_priority_foreign` FOREIGN KEY (`control_priority`) REFERENCES `control_priorities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_type_foreign` FOREIGN KEY (`control_type`) REFERENCES `control_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_desired_maturity_foreign` FOREIGN KEY (`desired_maturity`) REFERENCES `control_desired_maturities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_family_foreign` FOREIGN KEY (`family`) REFERENCES `families` (`id`),
  ADD CONSTRAINT `framework_controls_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `framework_controls` (`id`);

--
-- Constraints for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  ADD CONSTRAINT `framework_control_mappings_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `framework_control_mappings_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`);

--
-- Constraints for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  ADD CONSTRAINT `FK_framework_control_test_tester` FOREIGN KEY (`tester`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `framework_control_tests_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  ADD CONSTRAINT `FK_framework_control_test_audit_tester` FOREIGN KEY (`tester`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `framework_control_test_audits_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_control_test_audits_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `framework_control_tests` (`id`);

--
-- Constraints for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  ADD CONSTRAINT `framework_control_test_comments_test_audit_id_foreign` FOREIGN KEY (`test_audit_id`) REFERENCES `framework_control_test_audits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  ADD CONSTRAINT `framework_control_test_results_test_audit_id_foreign` FOREIGN KEY (`test_audit_id`) REFERENCES `framework_control_test_audits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_control_test_results_test_result_foreign` FOREIGN KEY (`test_result`) REFERENCES `test_results` (`id`);

--
-- Constraints for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  ADD CONSTRAINT `framework_control_test_results_to_risks_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `framework_control_test_results_to_risks_test_results_id_foreign` FOREIGN KEY (`test_results_id`) REFERENCES `framework_control_test_results` (`id`);

--
-- Constraints for table `framework_control_to_frameworks`
--
ALTER TABLE `framework_control_to_frameworks`
  ADD CONSTRAINT `framework_control_to_frameworks_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `framework_control_to_frameworks_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`);

--
-- Constraints for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  ADD CONSTRAINT `framework_control_type_mappings_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `framework_control_type_mappings_control_type_id_foreign` FOREIGN KEY (`control_type_id`) REFERENCES `control_types` (`id`);

--
-- Constraints for table `framework_families`
--
ALTER TABLE `framework_families`
  ADD CONSTRAINT `framework_families_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`),
  ADD CONSTRAINT `framework_families_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_families_parent_family_id_foreign` FOREIGN KEY (`parent_family_id`) REFERENCES `families` (`id`);

--
-- Constraints for table `items_to_teams`
--
ALTER TABLE `items_to_teams`
  ADD CONSTRAINT `items_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kpis_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `kpi_assessments`
--
ALTER TABLE `kpi_assessments`
  ADD CONSTRAINT `kpi_assessments_action_by_foreign` FOREIGN KEY (`action_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kpi_assessments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kpi_assessments_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`);

--
-- Constraints for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  ADD CONSTRAINT `mgmt_reviews_next_step_id_foreign` FOREIGN KEY (`next_step_id`) REFERENCES `next_steps` (`id`),
  ADD CONSTRAINT `mgmt_reviews_review_foreign` FOREIGN KEY (`review`) REFERENCES `reviews` (`id`),
  ADD CONSTRAINT `mgmt_reviews_reviewer_foreign` FOREIGN KEY (`reviewer`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mgmt_reviews_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mitigations`
--
ALTER TABLE `mitigations`
  ADD CONSTRAINT `mitigations_mitigation_effort_foreign` FOREIGN KEY (`mitigation_effort`) REFERENCES `mitigation_efforts` (`id`),
  ADD CONSTRAINT `mitigations_mitigation_owner_foreign` FOREIGN KEY (`mitigation_owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mitigations_planning_strategy_foreign` FOREIGN KEY (`planning_strategy`) REFERENCES `planning_strategies` (`id`),
  ADD CONSTRAINT `mitigations_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  ADD CONSTRAINT `mitigation_accept_users_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mitigation_accept_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mitigation_to_controls`
--
ALTER TABLE `mitigation_to_controls`
  ADD CONSTRAINT `mitigation_to_controls_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `mitigation_to_controls_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mitigation_to_teams`
--
ALTER TABLE `mitigation_to_teams`
  ADD CONSTRAINT `mitigation_to_teams_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mitigation_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `pending_risks`
--
ALTER TABLE `pending_risks`
  ADD CONSTRAINT `pending_risks_assessment_answer_id_foreign` FOREIGN KEY (`assessment_answer_id`) REFERENCES `assessment_answers` (`id`),
  ADD CONSTRAINT `pending_risks_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_subgroup_id_foreign` FOREIGN KEY (`subgroup_id`) REFERENCES `subgroups` (`id`);

--
-- Constraints for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  ADD CONSTRAINT `permission_to_permission_groups_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`),
  ADD CONSTRAINT `permission_to_permission_groups_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  ADD CONSTRAINT `permission_to_users_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_to_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  ADD CONSTRAINT `residual_risk_scoring_histories_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risks`
--
ALTER TABLE `risks`
  ADD CONSTRAINT `risks_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `risks_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `framework_controls` (`id`),
  ADD CONSTRAINT `risks_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `risks_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`),
  ADD CONSTRAINT `risks_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `risks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `risks_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`);

--
-- Constraints for table `risks_to_assets`
--
ALTER TABLE `risks_to_assets`
  ADD CONSTRAINT `risks_to_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risks_to_assets_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risks_to_asset_groups`
--
ALTER TABLE `risks_to_asset_groups`
  ADD CONSTRAINT `risks_to_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`),
  ADD CONSTRAINT `risks_to_asset_groups_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  ADD CONSTRAINT `risk_catalogs_risk_function_id_foreign` FOREIGN KEY (`risk_function_id`) REFERENCES `risk_functions` (`id`),
  ADD CONSTRAINT `risk_catalogs_risk_grouping_id_foreign` FOREIGN KEY (`risk_grouping_id`) REFERENCES `risk_groupings` (`id`);

--
-- Constraints for table `risk_levels`
--
ALTER TABLE `risk_levels`
  ADD CONSTRAINT `risk_levels_review_level_id_foreign` FOREIGN KEY (`review_level_id`) REFERENCES `review_levels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_scorings`
--
ALTER TABLE `risk_scorings`
  ADD CONSTRAINT `risk_scorings_id_foreign` FOREIGN KEY (`id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  ADD CONSTRAINT `risk_scoring_contributing_impacts_contributing_risk_id_foreign` FOREIGN KEY (`contributing_risk_id`) REFERENCES `contributing_risks` (`id`),
  ADD CONSTRAINT `risk_scoring_contributing_impacts_risk_scoring_id_foreign` FOREIGN KEY (`risk_scoring_id`) REFERENCES `risk_scorings` (`id`);

--
-- Constraints for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  ADD CONSTRAINT `risk_scoring_histories_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_to_additional_stakeholders`
--
ALTER TABLE `risk_to_additional_stakeholders`
  ADD CONSTRAINT `risk_to_additional_stakeholders_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risk_to_additional_stakeholders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `risk_to_locations`
--
ALTER TABLE `risk_to_locations`
  ADD CONSTRAINT `risk_to_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `risk_to_locations_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `risk_to_teams`
--
ALTER TABLE `risk_to_teams`
  ADD CONSTRAINT `risk_to_teams_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risk_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `risk_to_technologies`
--
ALTER TABLE `risk_to_technologies`
  ADD CONSTRAINT `risk_to_technologies_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risk_to_technologies_technology_id_foreign` FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`id`);

--
-- Constraints for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  ADD CONSTRAINT `role_responsibilities_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_responsibilities_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `security_awarenesses`
--
ALTER TABLE `security_awarenesses`
  ADD CONSTRAINT `security_awarenesses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `security_awarenesses_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`),
  ADD CONSTRAINT `security_awarenesses_owner_foreign` FOREIGN KEY (`owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `security_awarenesses_privacy_foreign` FOREIGN KEY (`privacy`) REFERENCES `privacies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `security_awarenesses_reviewer_foreign` FOREIGN KEY (`reviewer`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `security_awareness_exams`
--
ALTER TABLE `security_awareness_exams`
  ADD CONSTRAINT `security_awareness_exams_security_awareness_id_foreign` FOREIGN KEY (`security_awareness_id`) REFERENCES `security_awarenesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_awareness_exam_answers`
--
ALTER TABLE `security_awareness_exam_answers`
  ADD CONSTRAINT `security_awareness_exam_answers_examinee_foreign` FOREIGN KEY (`examinee`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `security_awareness_exam_answers_foreign` FOREIGN KEY (`security_awareness_exams_id`) REFERENCES `security_awareness_exams` (`id`);

--
-- Constraints for table `security_awareness_exam_questions`
--
ALTER TABLE `security_awareness_exam_questions`
  ADD CONSTRAINT `security_awareness_exam_options_foreign` FOREIGN KEY (`security_awareness_exams_id`) REFERENCES `security_awareness_exams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_awareness_notes`
--
ALTER TABLE `security_awareness_notes`
  ADD CONSTRAINT `security_awareness_notes_security_awareness_id_foreign` FOREIGN KEY (`security_awareness_id`) REFERENCES `security_awarenesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `security_awareness_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_awareness_note_files`
--
ALTER TABLE `security_awareness_note_files`
  ADD CONSTRAINT `security_awareness_note_files_security_awareness_id_foreign` FOREIGN KEY (`security_awareness_id`) REFERENCES `security_awarenesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `security_awareness_note_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subgroups`
--
ALTER TABLE `subgroups`
  ADD CONSTRAINT `subgroups_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_action_by_foreign` FOREIGN KEY (`action_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD CONSTRAINT `task_notes_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_note_files`
--
ALTER TABLE `task_note_files`
  ADD CONSTRAINT `task_note_files_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_note_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_vulnerabilities`
--
ALTER TABLE `team_vulnerabilities`
  ADD CONSTRAINT `team_vulnerabilities_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `team_vulnerabilities_vulnerability_id_foreign` FOREIGN KEY (`vulnerability_id`) REFERENCES `vulnerabilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  ADD CONSTRAINT `threat_catalogs_threat_grouping_id_foreign` FOREIGN KEY (`threat_grouping_id`) REFERENCES `threat_groupings` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `users_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `users_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  ADD CONSTRAINT `user_pass_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  ADD CONSTRAINT `user_pass_reuse_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_to_teams`
--
ALTER TABLE `user_to_teams`
  ADD CONSTRAINT `user_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `user_to_teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `validation_files`
--
ALTER TABLE `validation_files`
  ADD CONSTRAINT `validation_files_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`);

--
-- Constraints for table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  ADD CONSTRAINT `vulnerabilities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vulnerabilities_update_status_user_foreign` FOREIGN KEY (`update_status_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
