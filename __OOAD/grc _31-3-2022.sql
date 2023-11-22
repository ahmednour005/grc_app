-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2022 at 01:29 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grc`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `name`, `created`) VALUES
(1, 'Critical Security Controls', '2016-03-04 03:21:27'),
(2, 'NIST 800-171', '2018-01-09 06:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers`
--

CREATE TABLE `assessment_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_risk` tinyint(1) NOT NULL DEFAULT 0,
  `risk_subject` blob NOT NULL,
  `risk_score` double(8,2) NOT NULL,
  `assessment_scoring_id` bigint(20) UNSIGNED NOT NULL,
  `risk_owner` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 999999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_answers`
--

INSERT INTO `assessment_answers` (`id`, `assessment_id`, `question_id`, `answer`, `submit_risk`, `risk_subject`, `risk_score`, `assessment_scoring_id`, `risk_owner`, `order`) VALUES
(1, 1, 1, 'Yes', 0, '', 0.00, 1, 0, 1),
(2, 1, 1, 'No', 1, 0x312e37373939393739333337363534452b313837, 10.00, 2, 0, 2),
(3, 1, 2, 'Yes', 0, '', 0.00, 3, 0, 1),
(4, 1, 2, 'No', 1, 0x494e46, 10.00, 4, 0, 2),
(5, 1, 3, 'Yes', 0, '', 0.00, 5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers_to_assets`
--

CREATE TABLE `assessment_answers_to_assets` (
  `assessment_answer_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_answers_to_assets`
--

INSERT INTO `assessment_answers_to_assets` (`assessment_answer_id`, `asset_id`) VALUES
(2, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers_to_asset_groups`
--

CREATE TABLE `assessment_answers_to_asset_groups` (
  `assessment_answer_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_questions`
--

CREATE TABLE `assessment_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 999999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_questions`
--

INSERT INTO `assessment_questions` (`id`, `assessment_id`, `question`, `order`) VALUES
(1, 1, 'Do you actively manage (inventory, track, and correct) all hardware devices on the network so that only authorized devices are given access, and unauthorized and unmanaged devices are found and prevented from gaining access?', 1),
(2, 1, 'Do you actively manage (inventory, track, and correct) all software on the network so that only authorized software is installed and can execute, and that unauthorized and unmanaged software is found and prevented from installation or execution?', 2),
(3, 1, 'Do you establish, implement, and actively manage (track, report on, correct) the security configuration of laptops, servers, and workstations using a rigorous configuration management and change control process in order to prevent attackers from exploiting vulnerable services and settings?', 3),
(4, 1, 'Do you continuously acquire, assess, and take action on new information in order to identify vulnerabilities, remediate, and minimize the window of opportunity for attackers?', 4),
(5, 1, 'Do you have processes and tools to track/control/prevent/correct the use, assignment, and configuration of administrative privileges on computers, networks, and applications?', 5),
(6, 1, 'Do you collect, manage, and analyze audit logs of events that could help detect, understand, or recover from an attack?', 6),
(7, 1, 'Do you minimize the attack surface and the opportunities for attackers to manipulate human behavior through their interaction with web browsers and emails systems?', 7),
(8, 1, 'Do you control the installation, spread, and execution of malicious code at multiple points in the enterprise, while optimizing the use of automation to enable rapid updating of defense, data gathering, and corrective action?', 8),
(9, 1, 'Do you manage (track/control/correct) the ongoing operational use of ports, protocols, and services on networked devices in order to minimize windows of vulnerability available to attackers?', 9),
(10, 1, 'Do you have processes and tools to properly back up critical information with a proven methodology for timely recovery of it?', 10),
(11, 1, 'Do you establish, implement, and actively manage (track, report on, correct) the security configuration of network infrastructure devices using a rigorous configuration management and change control process in order to prevent attackers from exploiting vulnerable services and settings?', 11),
(12, 1, 'Do you detect/prevent/correct the flow of information transferring networks of different trust levels with a focus on security-damaging data?', 12),
(13, 1, 'Do you have processes and tools to prevent data exfiltration, mitigate the effects of exfiltrated data, and ensure the privacy and integrity of sensitive information?', 13),
(14, 1, 'Do you have processes and tools to track/control/prevent/correct secure access to critical assets (e.g., information, resources, systems) according to the formal determination of which persons, computers, and applications have a need and right to access these critical assets based on an approved classification?', 14),
(15, 1, 'Do you have processes and tools to track/control/prevent/correct the security use of wireless local area networks (LANS), access points, and wireless client systems?', 15),
(16, 1, 'Do you actively manage the life cycle of system and application accounts - their creation, use, dormancy, deletion - in order to minimize opportunities for attackers to leverage them?', 16),
(17, 1, 'Do all functional roles in the organization (prioritizing those mission-critical to the business and its security) identiy the specific knowledge, skills, and abilities needed to support defense of the enterprise; develop and execute an integrated plan to assess, identify gaps, and remediate through policy, organizational planning, training, and awareness programs?', 17),
(18, 1, 'Do you manage the security life cycle of all in-house developed and acquired software in order to prevent, detect, and correct security weaknesses?', 18),
(19, 1, 'Do you protect the organization\'s information, as well as its reputation, by developing and implementing an incident response infrastructure (e.g., plans, defined roles, training, communications, management oversight) for quickly discovering an attack and then effectively containing the damage, eradicating the attacker\'s presence, and restoring the integrity of the network and systems?', 19),
(20, 1, 'Do you test the overall strength of your organization\'s defenses (the technology, the processes, and the people) by simulating the objectives and actions of an attacker?', 20),
(21, 2, '(3.1.1) Do we limit information system access to authorized users, processes acting on behalf of authorized users, or devices? (including other information systems)', 999999),
(22, 2, '(3.1.2) Do we limit access to the types of transactions and functions that authorized users are permitted to execute?', 999999),
(23, 2, '(3.1.3.) Do we control CUI in accordance with approved authorizations?', 999999),
(24, 2, '(3.1.4) Do we keep duties of individuals separated to reduce the risk of malevolent activity without collusion?', 999999),
(25, 2, '(3.1.5) Do we employ the principle of least privilege, including specific security functions and privileged accounts?', 999999),
(26, 2, '(3.1.6) Do we disallow the organization to use non-privileged accounts or roles when accessing non-security functions?', 999999),
(27, 2, '(3.1.7) Do we prevent non-privileged users from executing privileged functions and audit the execution of such functions?', 999999),
(28, 2, '(3.1.8) Do we limit unsuccessful logon attempts?', 999999),
(29, 2, '(3.1.9) Do we provide privacy and security notices consistent with applicable CUI rules?', 999999),
(30, 2, '(3.1.10) Do we use session lock with pattern hiding displays to prevent access/viewing of data after a period of inactivity?', 999999),
(31, 2, '(3.1.11) Do we terminate a user session after a defined condition or time?', 999999),
(32, 2, '(3.1.12) Do we monitor and control remote access sessions?', 999999),
(33, 2, '(3.1.13) Do we employ cryptographic mechanisms to protect the confidentiality of remote access sessions?', 999999),
(34, 2, '(3.1.14) Do we route remote access through managed access control points?', 999999),
(35, 2, '(3.1.15) Does the system require authorization of remote execution of privileged commands and remote access to security relevant information?', 999999),
(36, 2, '(3.1.16) Do we authorize wireless access prior to allowing such connections?', 999999),
(37, 2, '(3.1.17) Do we protect wireless access using authentication and encryption?', 999999),
(38, 2, '(3.1.18) Do we have guidelines and procedures in place to restrict the operation and connection of mobile devices?', 999999),
(39, 2, '(3.1.19) Do we encrypt CUI on mobile devices?', 999999),
(40, 2, '(3.1.20) Do we verify and control/limit connections to and use of external information systems?', 999999),
(41, 2, '(3.1.21) Do we limit use of organizational portable storage devices on external information systems?', 999999),
(42, 2, '(3.1.22) Do we prohibit posting or processing control information on publicly accessible information systems?', 999999),
(43, 2, '(3.2.1) Do we ensure that managers, systems administrators, and users of organizational information systems are made aware of the security risks associated with their activities and of the applicable policies, standards, and procedures related to the security of organizational information systems?', 999999),
(44, 2, '(3.2.2) Do we Ensure that organizational personnel are adequately trained to carry out their assigned information security-related duties and responsibilities?', 999999),
(45, 2, '(3.2.3) Do we provide security awareness training on recognizing and reporting potential indicators of insider threats?', 999999),
(46, 2, '(3.3.1) Do you create, protect, and retain information system audit records to the extent needed to enable the monitoring, analysis, investigations, and reporting of unlawful, unauthorized, or inappropriate information system activity?', 999999),
(47, 2, '(3.3.2) Do we ensure that the actions of individual information system users can be uniquely traced to those users so they can be held accountable for their actions?', 999999),
(48, 2, '(3.3.3) Do we review and update audited events?', 999999),
(49, 2, '(3.3.4) Do we have alerts in the event of an audit process failure?', 999999),
(50, 2, '(3.3.5) Do we use automated mechanisms to integrate and correlate audit review, analysis, and reporting processes for investigation and response to indications of inappropriate, suspicious, or unusual activity?', 999999),
(51, 2, '(3.3.6) Do we provide audit reduction and report generation to support on-demand analysis and reporting?', 999999),
(52, 2, '(3.3.7) Do we provide an information system capability that compares and synchronizes internal system clocks with an authoritative source to generate time stamps for audit records?', 999999),
(53, 2, '(3.3.8) Do we protect audit information and audit tools from unauthorized access, modification, and deletion?', 999999),
(54, 2, '(3.3.9) Do we limit management of audit functionality to a subset of privileged users?', 999999),
(55, 2, '(3.4.1) Do we establish and maintain baseline configurations and inventories of organizational information systems (including hardware, software, firmware, and documentation) throughout the respective system development life cycles?', 999999),
(56, 2, '(3.4.2) Do we establish and enforce security configuration settings for information technology products employed in organizational information systems?', 999999),
(57, 2, '(3.4.3) Do we track, review, approve/disapprove, and audit changes to information systems?', 999999),
(58, 2, '(3.4.4) Do we analyze the security impact of changes prior to implementation?', 999999),
(59, 2, '(3.4.5) Do we define, document, approve, and enforce physical and logical access restrictions associated with changes to the information system?', 999999),
(60, 2, '(3.4.6) Do we employ the principle of least functionality by configuring the information system to provide only essential capabilities? ', 999999),
(61, 2, '(3.4.7) Do we restrict, disable, and prevent the use of nonessential programs, functions, ports, protocols, and services?', 999999),
(62, 2, '(3.4.8) Do we apply deny-by-exception (blacklist) policy to prevent the use of unauthorized software or deny-all, permit-by-exception (whitelisting) policy to allow the execution of authorized software?', 999999),
(63, 2, '(3.4.9) Do we control and monitor user-installed software?', 999999),
(64, 2, '(3.5.1) Do we identify information system users, processes acting on behalf of users, or devices?', 999999),
(65, 2, '(3.5.2) Do we authenticate (or verify) the identities of those users, processes, or devices, as a prerequisite to allowing access to organizational information systems?', 999999),
(66, 2, '(3.5.3) Do we use multi-factor authentication for local and network access to privileged accounts and for network access to non-privileged accounts?', 999999),
(67, 2, '(3.5.4) Do we employ replay-resistant authentication mechanisms for network access to privileged and non-privileged accounts?', 999999),
(68, 2, '(3.5.5) Do we prevent the reuse of identifiers for a defined period?', 999999),
(69, 2, '(3.5.6) Do we disable identifiers after a defined period of inactivity?', 999999),
(70, 2, '(3.5.7) Do we enforce a minimum password complexity and change of characters when new passwords are created?', 999999),
(71, 2, '(3.5.8) Do we prohibit password reuse for a specified number of generations?', 999999),
(72, 2, '(3.5.9) Do we allow temporary password use for system logons with an immediate change to a permanent password?', 999999),
(73, 2, '(3.5.10) Do we store and transmit only encrypted representation of passwords?', 999999),
(74, 2, '(3.5.11) Do we obscure feedback of authentication information?', 999999),
(75, 2, '(3.6.1) Have we established an operational incident handling capability for organizational information systems that includes adequate preparation, detection, analysis, containment, recovery, and user response activities?', 999999),
(76, 2, '(3.6.2) Do we track, document, and report incidents to appropriate officials and/or authorities both internal and external to the organizations? ', 999999),
(77, 2, '(3.6.3) Do we test the organizational incident response capability? ', 999999),
(78, 2, '(3.7.1) Do we perform maintenance on organizational information systems?', 999999),
(79, 2, '(3.7.2) Do we provide effective controls on the tools, techniques, mechanisms, and personnel used to conduct information system maintenance?', 999999),
(80, 2, '(3.7.3) Do we ensure equipment removed for off-site maintenance is sanitized of any CUI?', 999999),
(81, 2, '(3.7.4) Do we check media containing diagnostic and test programs for malicious code before the media are used in the information system?', 999999),
(82, 2, '(3.7.5) Do we require multifaction authentication to establish non-local maintenance sessions via external network connections when non-local maintenance is complete? ', 999999),
(83, 2, '(3.7.6) Do we supervise the maintenance activities of maintenance personnel without required access authorization?', 999999),
(84, 2, '(3.8.1) Do we protect (i.e., physically control and securely store) information system media  containing CUI, both paper and digital?', 999999),
(85, 2, '(3.8.2) Do we limit access to CUI on information system media to authorized users?', 999999),
(86, 2, '(3.8.3) Do we sanitize or destroy information system media containing CUI before disposal or release for reuse?', 999999),
(87, 2, '(3.8.4) Do we mark media with the necessary CUI markings and distribution limitations?', 999999),
(88, 2, '(3.8.5) Do we control access to media containing CUI and maintain accountability for media during transport outside of controlled areas?', 999999),
(89, 2, '(3.8.6) Do we implement cryptographic mechanisms to protect the confidentiality of CUI stored on digital media during transport unless otherwise protected by alternative physical safeguards?', 999999),
(90, 2, '(3.8.7) Do we control the use of removable media on information system components?', 999999),
(91, 2, '(3.8.8) Do we prohibit the use of portable storage devices when such devices have no identifiable owner?', 999999),
(92, 2, '(3.8.9) Do we protect the confidentiality of backup CUI as storage locations?', 999999),
(93, 2, '(3.9.1) Do we screen individuals prior to authorizing access to information systems containing CUI?', 999999),
(94, 2, '(3.9.2) Do we ensure that CUI and information systems containing CUI are protected during and after personnel actions such as terminations and transfers?', 999999),
(95, 2, '(3.10.1) Do we limit physical access to organizational information systems, equipment, and the respective operating environments to authorized individuals?', 999999),
(96, 2, '(3.10.2) Do we protect and monitor the physical facility and support infrastructure for those information systems?', 999999),
(97, 2, '(3.10.3) Do we escort visitors and monitor visitor activity?', 999999),
(98, 2, '(3.10.4) Do we maintain audit logs of physical access?', 999999),
(99, 2, '(3.10.5) Do we control and manage physical access devices?', 999999),
(100, 2, '(3.10.6) Do we enforce safeguarding measures for CUI at alternate work sites? (e.g. telework sites)', 999999),
(101, 2, '(3.11.1) Do we periodically assess the risk to organizational operations (including mission, functions, image, or reputation), organizational assets, and individuals, resulting from the operation of organizational information systems and the associated processing, storage, or transmission of CUI?', 999999),
(102, 2, '(3.11.2) Do we scan for vulnerabilities in the information system and applications periodically and when new vulnerabilities affecting the system are identified?', 999999),
(103, 2, '(3.11.3) Do we remediate vulnerabilities in accordance with assessments of risk?', 999999),
(104, 2, '(3.12.1) Do we periodically assess the security controls in organizational information systems to determine if the controls are effective in their application?', 999999),
(105, 2, '(3.12.2) Do we develop and implement plans of action designed to correct deficiencies and reduce or eliminate vulnerabilities in organizational information systems?', 999999),
(106, 2, '(3.12.3) Do we monitor information system security controls on an ongoing basis to ensure the continued effectiveness of the controls?', 999999),
(107, 2, '(3.13.1) Do we monitor, control, and protect organizational communications (i.e. information transmitted or received by organizational information systems) at the external boundaries and key internal boundaries of the information systems?', 999999),
(108, 2, '(3.13.2) Do we employ architectural designs, software development techniques, and systems engineering principles that promote effective information security within organizations information systems?', 999999),
(109, 2, '(3.13.3) Do we separate user functionality from information system management functionality?', 999999),
(110, 2, '(3.13.4) Do we prevent unauthorized and unintended information transfer via shared system resources?', 999999),
(111, 2, '(3.13.5) Do we implement subnetworks for publicly accessible system components that are physically or logically separated from internal networks?', 999999),
(112, 2, '(3.13.6) Do we deny network communications traffic by default and allow network communications by exception?', 999999),
(113, 2, '(3.13.7) Do we prevent remote devices from simultaneously establishing non-remote connections with the information system and communicating via some other connection to resources in external networks?', 999999),
(114, 2, '(3.13.8) Do we implement cryptographic mechanisms to prevent unauthorized disclosure of CUI during transmission unless otherwise protected by alternative physical safeguards?', 999999),
(115, 2, '(3.13.9) Do we terminate network connections associated with communications sessions at the end of the sessions or after a defined period of inactivity?', 999999),
(116, 2, '(3.13.10) Do we establish and manage cryptographic keys for cryptography employed in the information system?', 999999),
(117, 2, '(3.13.12) Do we prohibit remote activation of collaborative computing devices and provide indication of devices in use to users present at the device?', 999999),
(118, 2, '(3.13.13) Do we control and monitor the use of mobile code? ', 999999),
(119, 2, '(3.13.14) Do we control and monitor the use of voice over internet protocol (VOIP) technologies?', 999999),
(120, 2, '(3.13.15) Do we protect the authenticity of communications sessions?', 999999),
(121, 2, '(3.13.16) Do we protect the confidentiality of CUI at rest?', 999999),
(122, 2, '(3.14.1) Do we identify, report, and correct information and information system flaws in a timely manner?', 999999),
(123, 2, '(3.14.2) Do we provide protection from malicious code at appropriate locations within organizational information systems?', 999999),
(124, 2, '(3.14.3) Do we monitor information system security alerts and advisories and take appropriate actions in response?', 999999),
(125, 2, '(3.14.4) Do we update malicious code protection mechanisms when new releases are available?', 999999),
(126, 2, '(3.14.5) Do we perform periodic scans of the information system and real-time scans of files from external sources as files are downloaded, opened, or executed?', 999999),
(127, 2, '(3.14.6) Do we monitor the information system including inbound and outbound communications traffic, to detect attacks and indicators of potential attacks?', 999999),
(128, 2, '(3.14.7) Do we identify unauthorized use of the information system?', 999999);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scorings`
--

CREATE TABLE `assessment_scorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scoring_method` int(11) NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `CLASSIC_likelihood` double(8,2) NOT NULL DEFAULT 5.00,
  `CLASSIC_impact` double(8,2) NOT NULL DEFAULT 5.00,
  `CVSS_AccessVector` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_AccessComplexity` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `CVSS_Authentication` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_ConfImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_IntegImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_AvailImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_Exploitability` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_RemediationLevel` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ReportConfidence` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_CollateralDamagePotential` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_TargetDistribution` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ConfidentialityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_IntegrityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_AvailabilityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `DREAD_DamagePotential` int(11) NOT NULL DEFAULT 10,
  `DREAD_Reproducibility` int(11) NOT NULL DEFAULT 10,
  `DREAD_Exploitability` int(11) NOT NULL DEFAULT 10,
  `DREAD_AffectedUsers` int(11) NOT NULL DEFAULT 10,
  `DREAD_Discoverability` int(11) NOT NULL DEFAULT 10,
  `OWASP_SkillLevel` int(11) NOT NULL DEFAULT 10,
  `OWASP_Motive` int(11) NOT NULL DEFAULT 10,
  `OWASP_Opportunity` int(11) NOT NULL DEFAULT 10,
  `OWASP_Size` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfDiscovery` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfExploit` int(11) NOT NULL DEFAULT 10,
  `OWASP_Awareness` int(11) NOT NULL DEFAULT 10,
  `OWASP_IntrusionDetection` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfConfidentiality` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfIntegrity` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAvailability` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAccountability` int(11) NOT NULL DEFAULT 10,
  `OWASP_FinancialDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_ReputationDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_NonCompliance` int(11) NOT NULL DEFAULT 10,
  `OWASP_PrivacyViolation` int(11) NOT NULL DEFAULT 10,
  `Custom` double(8,2) NOT NULL DEFAULT 10.00,
  `Contributing_Likelihood` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_scorings`
--

INSERT INTO `assessment_scorings` (`id`, `scoring_method`, `calculated_risk`, `CLASSIC_likelihood`, `CLASSIC_impact`, `CVSS_AccessVector`, `CVSS_AccessComplexity`, `CVSS_Authentication`, `CVSS_ConfImpact`, `CVSS_IntegImpact`, `CVSS_AvailImpact`, `CVSS_Exploitability`, `CVSS_RemediationLevel`, `CVSS_ReportConfidence`, `CVSS_CollateralDamagePotential`, `CVSS_TargetDistribution`, `CVSS_ConfidentialityRequirement`, `CVSS_IntegrityRequirement`, `CVSS_AvailabilityRequirement`, `DREAD_DamagePotential`, `DREAD_Reproducibility`, `DREAD_Exploitability`, `DREAD_AffectedUsers`, `DREAD_Discoverability`, `OWASP_SkillLevel`, `OWASP_Motive`, `OWASP_Opportunity`, `OWASP_Size`, `OWASP_EaseOfDiscovery`, `OWASP_EaseOfExploit`, `OWASP_Awareness`, `OWASP_IntrusionDetection`, `OWASP_LossOfConfidentiality`, `OWASP_LossOfIntegrity`, `OWASP_LossOfAvailability`, `OWASP_LossOfAccountability`, `OWASP_FinancialDamage`, `OWASP_ReputationDamage`, `OWASP_NonCompliance`, `OWASP_PrivacyViolation`, `Custom`, `Contributing_Likelihood`) VALUES
(1, 5, 0.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.00, 0),
(2, 5, 10.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(3, 5, 0.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.00, 0),
(4, 5, 10.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10.00, 0),
(5, 5, 0.00, 5.00, 5.00, 'N', 'L', 'N', 'C', 'C', 'C', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 'ND', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scoring_contributing_impacts`
--

CREATE TABLE `assessment_scoring_contributing_impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_scoring_id` bigint(20) UNSIGNED NOT NULL,
  `contributing_risk_id` bigint(20) UNSIGNED NOT NULL,
  `impact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_value_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teams` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `ip`, `name`, `asset_value_id`, `location_id`, `teams`, `details`, `created`, `verified`, `start_date`, `expiration_date`) VALUES
(1, '127.0.0.1', 'Asset1', 1, 1, '1,4', 'Details asset 1', '2019-07-01 06:32:43', 1, '2022-07-02', '2022-07-03'),
(2, '127.0.0.2', 'Asset2', 2, 2, '1,4', 'Details asset 2', '2019-07-01 06:32:43', 1, '2022-07-03', '2022-07-04'),
(3, '127.0.0.3', 'Asset3', 3, 3, '1,4', 'Details asset 3', '2019-07-01 06:32:43', 1, '2022-07-04', '2022-07-05'),
(4, '127.0.0.4', 'Asset4', 4, 4, '1,4', 'Details asset 4', '2019-07-01 06:32:43', 1, '2022-07-05', '2022-07-06'),
(5, '127.0.0.5', 'Asset5', 5, 5, '1,4', 'Details asset 5', '2019-07-01 06:32:43', 1, '2022-07-06', '2022-07-07'),
(6, '127.0.0.6', 'Asset6', 6, 6, '1,4', 'Details asset 6', '2019-07-01 06:32:43', 1, '2022-07-07', '2022-07-08'),
(7, '127.0.0.7', 'Asset7', 7, 7, '1,4', 'Details asset 7', '2019-07-01 06:32:43', 1, '2022-07-08', '2022-07-09'),
(8, '127.0.0.8', 'Asset8', 8, 8, '1,4', 'Details asset 8', '2019-07-01 06:32:43', 1, '2022-07-09', '2022-07-10'),
(9, '127.0.0.9', 'Asset9', 9, 9, '1,4', 'Details asset 9', '2019-07-01 06:32:43', 1, '2022-07-10', '2022-07-11'),
(10, '127.0.0.10', 'Asset10', 10, 10, '1,4', 'Details asset 10', '2019-07-01 06:32:43', 1, '2022-07-01', '2022-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `assets_asset_groups`
--

CREATE TABLE `assets_asset_groups` (
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_groups`
--

CREATE TABLE `asset_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_values`
--

CREATE TABLE `asset_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_value` int(11) NOT NULL,
  `max_value` int(11) DEFAULT NULL,
  `valuation_level_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
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
(10, 900001, 1000000, '');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(46) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `description`, `subject_id`, `subject_type`, `user_id`, `properties`, `host`, `created_at`, `updated_at`) VALUES
(1, 'created', 1, 'App\\Models\\Location', 1, '{\"id\":1,\"name\":\"Location 1\"}', '127.0.0.1', '2022-03-31 12:28:44', '2022-03-31 12:28:44'),
(2, 'created', 2, 'App\\Models\\Location', 1, '{\"id\":2,\"name\":\"Location 2\"}', '127.0.0.1', '2022-03-31 12:28:44', '2022-03-31 12:28:44'),
(3, 'created', 3, 'App\\Models\\Location', 1, '{\"id\":3,\"name\":\"Location 3\"}', '127.0.0.1', '2022-03-31 12:28:44', '2022-03-31 12:28:44'),
(4, 'created', 4, 'App\\Models\\Location', 1, '{\"id\":4,\"name\":\"Location 4\"}', '127.0.0.1', '2022-03-31 12:28:44', '2022-03-31 12:28:44'),
(5, 'created', 5, 'App\\Models\\Location', 1, '{\"id\":5,\"name\":\"Location 5\"}', '127.0.0.1', '2022-03-31 12:28:45', '2022-03-31 12:28:45'),
(6, 'created', 6, 'App\\Models\\Location', 1, '{\"id\":6,\"name\":\"Location 6\"}', '127.0.0.1', '2022-03-31 12:28:45', '2022-03-31 12:28:45'),
(7, 'created', 7, 'App\\Models\\Location', 1, '{\"id\":7,\"name\":\"Location 7\"}', '127.0.0.1', '2022-03-31 12:28:45', '2022-03-31 12:28:45'),
(8, 'created', 8, 'App\\Models\\Location', 1, '{\"id\":8,\"name\":\"Location 8\"}', '127.0.0.1', '2022-03-31 12:28:45', '2022-03-31 12:28:45'),
(9, 'created', 9, 'App\\Models\\Location', 1, '{\"id\":9,\"name\":\"Location 9\"}', '127.0.0.1', '2022-03-31 12:28:45', '2022-03-31 12:28:45'),
(10, 'created', 10, 'App\\Models\\Location', 1, '{\"id\":10,\"name\":\"Location 10\"}', '127.0.0.1', '2022-03-31 12:28:45', '2022-03-31 12:28:45'),
(11, 'created', 1, 'App\\Models\\AssetValue', 1, '{\"id\":1,\"min_value\":0,\"max_value\":100000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:46', '2022-03-31 12:28:46'),
(12, 'created', 2, 'App\\Models\\AssetValue', 1, '{\"id\":2,\"min_value\":100001,\"max_value\":200000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:46', '2022-03-31 12:28:46'),
(13, 'created', 3, 'App\\Models\\AssetValue', 1, '{\"id\":3,\"min_value\":200001,\"max_value\":300000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:46', '2022-03-31 12:28:46'),
(14, 'created', 4, 'App\\Models\\AssetValue', 1, '{\"id\":4,\"min_value\":300001,\"max_value\":400000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:47', '2022-03-31 12:28:47'),
(15, 'created', 5, 'App\\Models\\AssetValue', 1, '{\"id\":5,\"min_value\":400001,\"max_value\":500000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:47', '2022-03-31 12:28:47'),
(16, 'created', 6, 'App\\Models\\AssetValue', 1, '{\"id\":6,\"min_value\":500001,\"max_value\":600000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:47', '2022-03-31 12:28:47'),
(17, 'created', 7, 'App\\Models\\AssetValue', 1, '{\"id\":7,\"min_value\":600001,\"max_value\":700000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:47', '2022-03-31 12:28:47'),
(18, 'created', 8, 'App\\Models\\AssetValue', 1, '{\"id\":8,\"min_value\":700001,\"max_value\":800000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:47', '2022-03-31 12:28:47'),
(19, 'created', 9, 'App\\Models\\AssetValue', 1, '{\"id\":9,\"min_value\":800001,\"max_value\":900000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:48', '2022-03-31 12:28:48'),
(20, 'created', 10, 'App\\Models\\AssetValue', 1, '{\"id\":10,\"min_value\":900001,\"max_value\":1000000,\"valuation_level_name\":\"\"}', '127.0.0.1', '2022-03-31 12:28:48', '2022-03-31 12:28:48'),
(21, 'created', 1, 'App\\Models\\Team', 1, '{\"id\":1,\"name\":\"Team 1\"}', '127.0.0.1', '2022-03-31 12:28:50', '2022-03-31 12:28:50'),
(22, 'created', 2, 'App\\Models\\Team', 1, '{\"id\":2,\"name\":\"Team 2\"}', '127.0.0.1', '2022-03-31 12:28:50', '2022-03-31 12:28:50'),
(23, 'created', 3, 'App\\Models\\Team', 1, '{\"id\":3,\"name\":\"Team 3\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(24, 'created', 4, 'App\\Models\\Team', 1, '{\"id\":4,\"name\":\"Team 4\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(25, 'created', 5, 'App\\Models\\Team', 1, '{\"id\":5,\"name\":\"Team 5\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(26, 'created', 6, 'App\\Models\\Team', 1, '{\"id\":6,\"name\":\"Team 6\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(27, 'created', 7, 'App\\Models\\Team', 1, '{\"id\":7,\"name\":\"Team 7\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(28, 'created', 8, 'App\\Models\\Team', 1, '{\"id\":8,\"name\":\"Team 8\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(29, 'created', 9, 'App\\Models\\Team', 1, '{\"id\":9,\"name\":\"Team 9\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(30, 'created', 10, 'App\\Models\\Team', 1, '{\"id\":10,\"name\":\"Team 10\"}', '127.0.0.1', '2022-03-31 12:28:51', '2022-03-31 12:28:51'),
(31, 'created', 11, 'App\\Models\\Team', 1, '{\"id\":11,\"name\":\"Team 11\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(32, 'created', 12, 'App\\Models\\Team', 1, '{\"id\":12,\"name\":\"Team 12\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(33, 'created', 13, 'App\\Models\\Team', 1, '{\"id\":13,\"name\":\"Team 13\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(34, 'created', 14, 'App\\Models\\Team', 1, '{\"id\":14,\"name\":\"Team 14\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(35, 'created', 15, 'App\\Models\\Team', 1, '{\"id\":15,\"name\":\"Team 15\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(36, 'created', 16, 'App\\Models\\Team', 1, '{\"id\":16,\"name\":\"Team 16\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(37, 'created', 17, 'App\\Models\\Team', 1, '{\"id\":17,\"name\":\"Team 17\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(38, 'created', 18, 'App\\Models\\Team', 1, '{\"id\":18,\"name\":\"Team 18\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(39, 'created', 19, 'App\\Models\\Team', 1, '{\"id\":19,\"name\":\"Team 19\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(40, 'created', 20, 'App\\Models\\Team', 1, '{\"id\":20,\"name\":\"Team 20\"}', '127.0.0.1', '2022-03-31 12:28:52', '2022-03-31 12:28:52'),
(41, 'created', 1, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.1\",\"name\":\"Asset1\",\"asset_value_id\":1,\"location_id\":1,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 1\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-02\",\"expiration_date\":\"2022-07-03\",\"id\":1}', '127.0.0.1', '2022-03-31 12:28:53', '2022-03-31 12:28:53'),
(42, 'created', 2, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.2\",\"name\":\"Asset2\",\"asset_value_id\":2,\"location_id\":2,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 2\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-03\",\"expiration_date\":\"2022-07-04\",\"id\":2}', '127.0.0.1', '2022-03-31 12:28:53', '2022-03-31 12:28:53'),
(43, 'created', 3, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.3\",\"name\":\"Asset3\",\"asset_value_id\":3,\"location_id\":3,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 3\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-04\",\"expiration_date\":\"2022-07-05\",\"id\":3}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(44, 'created', 4, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.4\",\"name\":\"Asset4\",\"asset_value_id\":4,\"location_id\":4,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 4\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-05\",\"expiration_date\":\"2022-07-06\",\"id\":4}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(45, 'created', 5, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.5\",\"name\":\"Asset5\",\"asset_value_id\":5,\"location_id\":5,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 5\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-06\",\"expiration_date\":\"2022-07-07\",\"id\":5}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(46, 'created', 6, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.6\",\"name\":\"Asset6\",\"asset_value_id\":6,\"location_id\":6,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 6\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-07\",\"expiration_date\":\"2022-07-08\",\"id\":6}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(47, 'created', 7, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.7\",\"name\":\"Asset7\",\"asset_value_id\":7,\"location_id\":7,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 7\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-08\",\"expiration_date\":\"2022-07-09\",\"id\":7}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(48, 'created', 8, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.8\",\"name\":\"Asset8\",\"asset_value_id\":8,\"location_id\":8,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 8\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-09\",\"expiration_date\":\"2022-07-010\",\"id\":8}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(49, 'created', 9, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.9\",\"name\":\"Asset9\",\"asset_value_id\":9,\"location_id\":9,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 9\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-010\",\"expiration_date\":\"2022-07-011\",\"id\":9}', '127.0.0.1', '2022-03-31 12:28:54', '2022-03-31 12:28:54'),
(50, 'created', 10, 'App\\Models\\Asset', 1, '{\"ip\":\"127.0.0.10\",\"name\":\"Asset10\",\"asset_value_id\":10,\"location_id\":10,\"teams\":[\"1\",\"4\"],\"details\":\"Details asset 10\",\"created\":\"2019-07-01 08:32:43\",\"verified\":1,\"start_date\":\"2022-07-01\",\"expiration_date\":\"2022-07-02\",\"id\":10}', '127.0.0.1', '2022-03-31 12:28:55', '2022-03-31 12:28:55'),
(51, 'created', 1, 'App\\Models\\CloseReason', 1, '{\"id\":1,\"name\":\"Rechazado\"}', '127.0.0.1', '2022-03-31 12:28:56', '2022-03-31 12:28:56'),
(52, 'created', 2, 'App\\Models\\CloseReason', 1, '{\"id\":2,\"name\":\"Totalmente Mitigada\"}', '127.0.0.1', '2022-03-31 12:28:56', '2022-03-31 12:28:56'),
(53, 'created', 3, 'App\\Models\\CloseReason', 1, '{\"id\":3,\"name\":\"Sistema Retirado\"}', '127.0.0.1', '2022-03-31 12:28:56', '2022-03-31 12:28:56'),
(54, 'created', 4, 'App\\Models\\CloseReason', 1, '{\"id\":4,\"name\":\"Cancelado\"}', '127.0.0.1', '2022-03-31 12:28:57', '2022-03-31 12:28:57'),
(55, 'created', 5, 'App\\Models\\CloseReason', 1, '{\"id\":5,\"name\":\"Demasiado Insignificante\"}', '127.0.0.1', '2022-03-31 12:28:57', '2022-03-31 12:28:57'),
(56, 'created', 1, 'App\\Models\\Category', 1, '{\"id\":1,\"name\":\"Gesti\\u00f3n de Acceso\"}', '127.0.0.1', '2022-03-31 12:28:57', '2022-03-31 12:28:57'),
(57, 'created', 2, 'App\\Models\\Category', 1, '{\"id\":2,\"name\":\"La Resistencia Ambiental\"}', '127.0.0.1', '2022-03-31 12:28:57', '2022-03-31 12:28:57'),
(58, 'created', 3, 'App\\Models\\Category', 1, '{\"id\":3,\"name\":\"Vigilancia\"}', '127.0.0.1', '2022-03-31 12:28:57', '2022-03-31 12:28:57'),
(59, 'created', 4, 'App\\Models\\Category', 1, '{\"id\":4,\"name\":\"Seguridad F\\u00edsica\"}', '127.0.0.1', '2022-03-31 12:28:58', '2022-03-31 12:28:58'),
(60, 'created', 5, 'App\\Models\\Category', 1, '{\"id\":5,\"name\":\"Politica y Procedimiento\"}', '127.0.0.1', '2022-03-31 12:28:58', '2022-03-31 12:28:58'),
(61, 'created', 6, 'App\\Models\\Category', 1, '{\"id\":6,\"name\":\"Gesti\\u00f3n de datos sensibles\"}', '127.0.0.1', '2022-03-31 12:28:58', '2022-03-31 12:28:58'),
(62, 'created', 7, 'App\\Models\\Category', 1, '{\"id\":7,\"name\":\"Gesti\\u00f3n de Tecnica de Vulnerabilidades\"}', '127.0.0.1', '2022-03-31 12:28:58', '2022-03-31 12:28:58'),
(63, 'created', 8, 'App\\Models\\Category', 1, '{\"id\":8,\"name\":\"Gesti\\u00f3n de Terceros\"}', '127.0.0.1', '2022-03-31 12:28:58', '2022-03-31 12:28:58'),
(64, 'created', 1, 'App\\Models\\PlanningStrategy', 1, '{\"id\":1,\"name\":\"Investigar\"}', '127.0.0.1', '2022-03-31 12:28:58', '2022-03-31 12:28:58'),
(65, 'created', 2, 'App\\Models\\PlanningStrategy', 1, '{\"id\":2,\"name\":\"Acceptado\"}', '127.0.0.1', '2022-03-31 12:28:59', '2022-03-31 12:28:59'),
(66, 'created', 3, 'App\\Models\\PlanningStrategy', 1, '{\"id\":3,\"name\":\"Mitigado\"}', '127.0.0.1', '2022-03-31 12:28:59', '2022-03-31 12:28:59'),
(67, 'created', 4, 'App\\Models\\PlanningStrategy', 1, '{\"id\":4,\"name\":\"Ver\"}', '127.0.0.1', '2022-03-31 12:28:59', '2022-03-31 12:28:59'),
(68, 'created', 5, 'App\\Models\\PlanningStrategy', 1, '{\"id\":5,\"name\":\"Transferencia\"}', '127.0.0.1', '2022-03-31 12:28:59', '2022-03-31 12:28:59'),
(69, 'created', 1, 'App\\Models\\ControlPhase', 1, '{\"id\":1,\"name\":\"Physical\"}', '127.0.0.1', '2022-03-31 12:29:01', '2022-03-31 12:29:01'),
(70, 'created', 2, 'App\\Models\\ControlPhase', 1, '{\"id\":2,\"name\":\"Procedural\"}', '127.0.0.1', '2022-03-31 12:29:01', '2022-03-31 12:29:01'),
(71, 'created', 3, 'App\\Models\\ControlPhase', 1, '{\"id\":3,\"name\":\"Technical\"}', '127.0.0.1', '2022-03-31 12:29:01', '2022-03-31 12:29:01'),
(72, 'created', 4, 'App\\Models\\ControlPhase', 1, '{\"id\":4,\"name\":\"Legal and Regulatory or Compliance\"}', '127.0.0.1', '2022-03-31 12:29:01', '2022-03-31 12:29:01'),
(73, 'created', 1, 'App\\Models\\ControlPriority', 1, '{\"id\":1,\"name\":\"P0\"}', '127.0.0.1', '2022-03-31 12:29:13', '2022-03-31 12:29:13'),
(74, 'created', 2, 'App\\Models\\ControlPriority', 1, '{\"id\":2,\"name\":\"P1\"}', '127.0.0.1', '2022-03-31 12:29:13', '2022-03-31 12:29:13'),
(75, 'created', 3, 'App\\Models\\ControlPriority', 1, '{\"id\":3,\"name\":\"P2\"}', '127.0.0.1', '2022-03-31 12:29:13', '2022-03-31 12:29:13'),
(76, 'created', 4, 'App\\Models\\ControlPriority', 1, '{\"id\":4,\"name\":\"P3\"}', '127.0.0.1', '2022-03-31 12:29:13', '2022-03-31 12:29:13'),
(77, 'created', 1, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":1,\"tester\":1,\"test_frequency\":3,\"last_date\":\"1973-01-08\",\"next_date\":\"2011-11-28\",\"name\":\"Control1 Audit (1)\",\"objective\":3,\"test_steps\":5,\"approximate_time\":4,\"expected_results\":9,\"framework_control_id\":1,\"desired_frequency\":3,\"status\":1,\"created_at\":\"2008-12-16\",\"id\":1}', '127.0.0.1', '2022-03-31 12:29:19', '2022-03-31 12:29:19'),
(78, 'created', 2, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":2,\"tester\":1,\"test_frequency\":7,\"last_date\":\"2016-08-15\",\"next_date\":\"2006-11-20\",\"name\":\"Control2 Audit (2)\",\"objective\":0,\"test_steps\":7,\"approximate_time\":1,\"expected_results\":0,\"framework_control_id\":2,\"desired_frequency\":8,\"status\":1,\"created_at\":\"2020-02-20\",\"id\":2}', '127.0.0.1', '2022-03-31 12:29:19', '2022-03-31 12:29:19'),
(79, 'created', 3, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":3,\"tester\":1,\"test_frequency\":5,\"last_date\":\"2015-05-18\",\"next_date\":\"2006-10-21\",\"name\":\"Control3 Audit (3)\",\"objective\":3,\"test_steps\":0,\"approximate_time\":1,\"expected_results\":9,\"framework_control_id\":3,\"desired_frequency\":7,\"status\":1,\"created_at\":\"2001-10-30\",\"id\":3}', '127.0.0.1', '2022-03-31 12:29:19', '2022-03-31 12:29:19'),
(80, 'created', 4, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":4,\"tester\":1,\"test_frequency\":0,\"last_date\":\"2002-08-18\",\"next_date\":\"2012-09-23\",\"name\":\"Control4 Audit (4)\",\"objective\":0,\"test_steps\":3,\"approximate_time\":5,\"expected_results\":8,\"framework_control_id\":4,\"desired_frequency\":3,\"status\":1,\"created_at\":\"2014-09-03\",\"id\":4}', '127.0.0.1', '2022-03-31 12:29:19', '2022-03-31 12:29:19'),
(81, 'created', 5, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":5,\"tester\":1,\"test_frequency\":9,\"last_date\":\"1975-01-12\",\"next_date\":\"2018-01-17\",\"name\":\"Control5 Audit (5)\",\"objective\":7,\"test_steps\":7,\"approximate_time\":1,\"expected_results\":3,\"framework_control_id\":5,\"desired_frequency\":5,\"status\":1,\"created_at\":\"1995-01-03\",\"id\":5}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(82, 'created', 6, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":6,\"tester\":1,\"test_frequency\":9,\"last_date\":\"2019-01-06\",\"next_date\":\"1979-03-22\",\"name\":\"Control6 Audit (6)\",\"objective\":7,\"test_steps\":6,\"approximate_time\":5,\"expected_results\":8,\"framework_control_id\":6,\"desired_frequency\":5,\"status\":1,\"created_at\":\"2016-12-04\",\"id\":6}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(83, 'created', 7, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":7,\"tester\":1,\"test_frequency\":1,\"last_date\":\"1975-07-17\",\"next_date\":\"2001-12-10\",\"name\":\"Control7 Audit (7)\",\"objective\":5,\"test_steps\":0,\"approximate_time\":5,\"expected_results\":2,\"framework_control_id\":7,\"desired_frequency\":0,\"status\":1,\"created_at\":\"2009-09-29\",\"id\":7}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(84, 'created', 8, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":8,\"tester\":1,\"test_frequency\":3,\"last_date\":\"2000-06-24\",\"next_date\":\"1995-04-23\",\"name\":\"Control8 Audit (8)\",\"objective\":4,\"test_steps\":1,\"approximate_time\":9,\"expected_results\":8,\"framework_control_id\":8,\"desired_frequency\":8,\"status\":1,\"created_at\":\"2018-04-15\",\"id\":8}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(85, 'created', 9, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":9,\"tester\":1,\"test_frequency\":7,\"last_date\":\"2020-01-20\",\"next_date\":\"2019-08-05\",\"name\":\"Control9 Audit (9)\",\"objective\":5,\"test_steps\":0,\"approximate_time\":2,\"expected_results\":2,\"framework_control_id\":9,\"desired_frequency\":9,\"status\":1,\"created_at\":\"1984-09-01\",\"id\":9}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(86, 'created', 10, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":10,\"tester\":1,\"test_frequency\":1,\"last_date\":\"2018-08-06\",\"next_date\":\"1971-05-29\",\"name\":\"Control10 Audit (10)\",\"objective\":2,\"test_steps\":1,\"approximate_time\":6,\"expected_results\":9,\"framework_control_id\":10,\"desired_frequency\":2,\"status\":1,\"created_at\":\"2007-01-17\",\"id\":10}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(87, 'created', 11, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":11,\"tester\":1,\"test_frequency\":4,\"last_date\":\"2012-08-05\",\"next_date\":\"1977-08-22\",\"name\":\"Control11 Audit (11)\",\"objective\":1,\"test_steps\":1,\"approximate_time\":1,\"expected_results\":8,\"framework_control_id\":11,\"desired_frequency\":7,\"status\":1,\"created_at\":\"2018-10-11\",\"id\":11}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(88, 'created', 12, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":12,\"tester\":1,\"test_frequency\":6,\"last_date\":\"2021-10-06\",\"next_date\":\"2005-08-23\",\"name\":\"Control12 Audit (12)\",\"objective\":9,\"test_steps\":7,\"approximate_time\":2,\"expected_results\":4,\"framework_control_id\":12,\"desired_frequency\":1,\"status\":1,\"created_at\":\"2019-05-31\",\"id\":12}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(89, 'created', 13, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":13,\"tester\":1,\"test_frequency\":0,\"last_date\":\"2002-09-25\",\"next_date\":\"1977-10-26\",\"name\":\"Control13 Audit (13)\",\"objective\":6,\"test_steps\":6,\"approximate_time\":4,\"expected_results\":1,\"framework_control_id\":13,\"desired_frequency\":4,\"status\":1,\"created_at\":\"2007-12-21\",\"id\":13}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(90, 'created', 14, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":14,\"tester\":1,\"test_frequency\":1,\"last_date\":\"1993-10-21\",\"next_date\":\"1988-12-01\",\"name\":\"Control14 Audit (14)\",\"objective\":6,\"test_steps\":9,\"approximate_time\":3,\"expected_results\":5,\"framework_control_id\":14,\"desired_frequency\":4,\"status\":1,\"created_at\":\"1994-06-27\",\"id\":14}', '127.0.0.1', '2022-03-31 12:29:20', '2022-03-31 12:29:20'),
(91, 'created', 15, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":15,\"tester\":1,\"test_frequency\":4,\"last_date\":\"1970-01-04\",\"next_date\":\"2018-11-21\",\"name\":\"Control15 Audit (15)\",\"objective\":9,\"test_steps\":2,\"approximate_time\":8,\"expected_results\":9,\"framework_control_id\":15,\"desired_frequency\":6,\"status\":1,\"created_at\":\"2014-04-28\",\"id\":15}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(92, 'created', 16, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":16,\"tester\":1,\"test_frequency\":9,\"last_date\":\"1990-04-19\",\"next_date\":\"2006-03-20\",\"name\":\"Control16 Audit (16)\",\"objective\":7,\"test_steps\":2,\"approximate_time\":4,\"expected_results\":1,\"framework_control_id\":16,\"desired_frequency\":0,\"status\":1,\"created_at\":\"1998-07-15\",\"id\":16}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(93, 'created', 17, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":17,\"tester\":1,\"test_frequency\":7,\"last_date\":\"2001-10-10\",\"next_date\":\"1997-05-09\",\"name\":\"Control17 Audit (17)\",\"objective\":6,\"test_steps\":2,\"approximate_time\":5,\"expected_results\":2,\"framework_control_id\":17,\"desired_frequency\":5,\"status\":1,\"created_at\":\"1976-01-14\",\"id\":17}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(94, 'created', 18, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":18,\"tester\":1,\"test_frequency\":3,\"last_date\":\"1999-04-04\",\"next_date\":\"1994-02-08\",\"name\":\"Control18 Audit (18)\",\"objective\":8,\"test_steps\":9,\"approximate_time\":1,\"expected_results\":1,\"framework_control_id\":18,\"desired_frequency\":0,\"status\":1,\"created_at\":\"2010-12-24\",\"id\":18}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(95, 'created', 19, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":19,\"tester\":1,\"test_frequency\":8,\"last_date\":\"1995-01-30\",\"next_date\":\"1994-08-28\",\"name\":\"Control19 Audit (19)\",\"objective\":0,\"test_steps\":4,\"approximate_time\":4,\"expected_results\":3,\"framework_control_id\":19,\"desired_frequency\":8,\"status\":1,\"created_at\":\"2015-03-14\",\"id\":19}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(96, 'created', 20, 'App\\Models\\FrameworkControlTestAudit', 1, '{\"test_id\":20,\"tester\":1,\"test_frequency\":2,\"last_date\":\"1978-03-09\",\"next_date\":\"2021-11-07\",\"name\":\"Control20 Audit (20)\",\"objective\":1,\"test_steps\":8,\"approximate_time\":9,\"expected_results\":2,\"framework_control_id\":20,\"desired_frequency\":3,\"status\":1,\"created_at\":\"1982-02-03\",\"id\":20}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(97, 'created', 1, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"2009-02-22\",\"user\":1,\"comment\":\"Assumenda cumque ipsum voluptas magnam quisquam et.\",\"id\":1}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(98, 'created', 2, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":10,\"date\":\"1995-09-06\",\"user\":1,\"comment\":\"Dolor sequi quo aut debitis aut dolores in sit.\",\"id\":2}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(99, 'created', 3, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":16,\"date\":\"1983-01-25\",\"user\":1,\"comment\":\"Alias non id autem.\",\"id\":3}', '127.0.0.1', '2022-03-31 12:29:21', '2022-03-31 12:29:21'),
(100, 'created', 4, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"1988-11-18\",\"user\":1,\"comment\":\"Qui est voluptatem sed quidem sapiente pariatur ullam aliquid.\",\"id\":4}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(101, 'created', 5, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":13,\"date\":\"2020-02-14\",\"user\":1,\"comment\":\"Et maxime dignissimos quaerat sapiente eos consequatur blanditiis.\",\"id\":5}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(102, 'created', 6, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"1988-03-13\",\"user\":1,\"comment\":\"Doloremque tenetur aut velit necessitatibus.\",\"id\":6}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(103, 'created', 7, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":17,\"date\":\"1985-03-11\",\"user\":1,\"comment\":\"Rerum quas harum a saepe harum magnam mollitia error.\",\"id\":7}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(104, 'created', 8, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":5,\"date\":\"2021-02-17\",\"user\":1,\"comment\":\"Enim veritatis et quo molestiae doloremque.\",\"id\":8}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(105, 'created', 9, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":11,\"date\":\"2007-09-10\",\"user\":1,\"comment\":\"Enim ea voluptatum sed dolorem ut numquam quibusdam.\",\"id\":9}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(106, 'created', 10, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"1981-10-01\",\"user\":1,\"comment\":\"Quisquam animi totam suscipit quos.\",\"id\":10}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(107, 'created', 11, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":18,\"date\":\"2010-05-14\",\"user\":1,\"comment\":\"Delectus autem provident veniam ipsam voluptatibus occaecati accusamus.\",\"id\":11}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(108, 'created', 12, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":13,\"date\":\"2011-09-08\",\"user\":1,\"comment\":\"Ut dolor ipsum alias et tempora eius repudiandae.\",\"id\":12}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(109, 'created', 13, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"2000-01-27\",\"user\":1,\"comment\":\"Pariatur aut eveniet assumenda dignissimos.\",\"id\":13}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(110, 'created', 14, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":5,\"date\":\"1975-03-16\",\"user\":1,\"comment\":\"Autem pariatur facere reprehenderit molestiae.\",\"id\":14}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(111, 'created', 15, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"1980-01-30\",\"user\":1,\"comment\":\"Amet tempora illo minus.\",\"id\":15}', '127.0.0.1', '2022-03-31 12:29:22', '2022-03-31 12:29:22'),
(112, 'created', 16, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":6,\"date\":\"1996-03-25\",\"user\":1,\"comment\":\"Nihil omnis numquam itaque expedita omnis qui molestiae.\",\"id\":16}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(113, 'created', 17, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":16,\"date\":\"1971-01-17\",\"user\":1,\"comment\":\"Culpa a maxime delectus corporis porro.\",\"id\":17}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(114, 'created', 18, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"1985-07-16\",\"user\":1,\"comment\":\"Occaecati perspiciatis laborum consequuntur ut animi minus quia.\",\"id\":18}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(115, 'created', 19, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":10,\"date\":\"1996-03-01\",\"user\":1,\"comment\":\"Quas iste assumenda quam qui omnis molestiae asperiores.\",\"id\":19}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(116, 'created', 20, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":20,\"date\":\"1982-06-09\",\"user\":1,\"comment\":\"Nam voluptas consequuntur perspiciatis tempora id neque.\",\"id\":20}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(117, 'created', 21, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"1975-06-07\",\"user\":1,\"comment\":\"Aut et deleniti quis.\",\"id\":21}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(118, 'created', 22, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"1996-12-12\",\"user\":1,\"comment\":\"Adipisci nihil similique optio deleniti minus.\",\"id\":22}', '127.0.0.1', '2022-03-31 12:29:23', '2022-03-31 12:29:23'),
(119, 'created', 23, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"1972-01-20\",\"user\":1,\"comment\":\"Sapiente provident minus ea eaque.\",\"id\":23}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(120, 'created', 24, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":5,\"date\":\"1990-05-03\",\"user\":1,\"comment\":\"Praesentium et repudiandae odit explicabo alias voluptates quas maiores.\",\"id\":24}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(121, 'created', 25, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"1999-02-09\",\"user\":1,\"comment\":\"Assumenda molestiae voluptas eum reiciendis ipsa doloribus voluptatum.\",\"id\":25}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(122, 'created', 26, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"1980-08-08\",\"user\":1,\"comment\":\"Et voluptas enim repellat quasi.\",\"id\":26}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(123, 'created', 27, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1988-05-19\",\"user\":1,\"comment\":\"Eum ipsam fugiat ullam numquam.\",\"id\":27}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(124, 'created', 28, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1986-10-15\",\"user\":1,\"comment\":\"Facere id ratione perspiciatis voluptatem laudantium animi autem sequi.\",\"id\":28}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(125, 'created', 29, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":7,\"date\":\"1976-06-27\",\"user\":1,\"comment\":\"At quasi qui saepe.\",\"id\":29}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(126, 'created', 30, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"2021-08-20\",\"user\":1,\"comment\":\"Ipsam sint qui doloremque eos architecto ratione ut tempora.\",\"id\":30}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(127, 'created', 31, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"2001-02-05\",\"user\":1,\"comment\":\"Ullam nihil voluptatibus dolor explicabo.\",\"id\":31}', '127.0.0.1', '2022-03-31 12:29:24', '2022-03-31 12:29:24'),
(128, 'created', 32, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":18,\"date\":\"2001-02-17\",\"user\":1,\"comment\":\"Aliquam hic praesentium deserunt delectus voluptatem dolor voluptatibus ipsa.\",\"id\":32}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(129, 'created', 33, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"2002-01-26\",\"user\":1,\"comment\":\"Eligendi laboriosam et minima possimus velit saepe voluptatem.\",\"id\":33}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(130, 'created', 34, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":13,\"date\":\"2013-02-11\",\"user\":1,\"comment\":\"Quae nisi sint error cupiditate.\",\"id\":34}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(131, 'created', 35, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"2005-09-18\",\"user\":1,\"comment\":\"Deserunt rerum reprehenderit officia voluptatem voluptates dolor.\",\"id\":35}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(132, 'created', 36, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"2012-06-26\",\"user\":1,\"comment\":\"Consequatur consectetur molestiae nesciunt vero.\",\"id\":36}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(133, 'created', 37, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":12,\"date\":\"1997-03-26\",\"user\":1,\"comment\":\"Officia laboriosam ipsa debitis enim ut eveniet at.\",\"id\":37}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(134, 'created', 38, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"2000-03-17\",\"user\":1,\"comment\":\"Minus ut aut quasi iusto ut unde.\",\"id\":38}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(135, 'created', 39, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":5,\"date\":\"1990-08-30\",\"user\":1,\"comment\":\"Aut laboriosam deserunt nihil perspiciatis molestiae.\",\"id\":39}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(136, 'created', 40, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":14,\"date\":\"2014-01-07\",\"user\":1,\"comment\":\"Repellat ullam et ipsa cumque voluptatem.\",\"id\":40}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(137, 'created', 41, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":5,\"date\":\"2010-05-03\",\"user\":1,\"comment\":\"Qui dolor accusantium quo ut et ipsum aut.\",\"id\":41}', '127.0.0.1', '2022-03-31 12:29:25', '2022-03-31 12:29:25'),
(138, 'created', 42, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":16,\"date\":\"1982-10-21\",\"user\":1,\"comment\":\"Sequi mollitia vitae autem est at nulla eius sequi.\",\"id\":42}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(139, 'created', 43, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":20,\"date\":\"2020-06-04\",\"user\":1,\"comment\":\"Ad sit aliquam veniam architecto id qui recusandae.\",\"id\":43}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(140, 'created', 44, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1990-01-08\",\"user\":1,\"comment\":\"Placeat expedita eligendi illo quos nihil.\",\"id\":44}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(141, 'created', 45, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"2001-09-06\",\"user\":1,\"comment\":\"Aut ipsam suscipit et sed harum.\",\"id\":45}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(142, 'created', 46, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"2018-08-16\",\"user\":1,\"comment\":\"Non impedit temporibus exercitationem.\",\"id\":46}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(143, 'created', 47, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"2014-12-28\",\"user\":1,\"comment\":\"Harum laboriosam odio fuga molestiae qui saepe.\",\"id\":47}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(144, 'created', 48, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":18,\"date\":\"1976-09-05\",\"user\":1,\"comment\":\"Ipsam aut quibusdam explicabo ratione cumque non.\",\"id\":48}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(145, 'created', 49, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"2004-07-06\",\"user\":1,\"comment\":\"At impedit praesentium sunt exercitationem tempora ut.\",\"id\":49}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(146, 'created', 50, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"2015-07-13\",\"user\":1,\"comment\":\"Aliquid doloremque voluptatem nobis est doloribus.\",\"id\":50}', '127.0.0.1', '2022-03-31 12:29:26', '2022-03-31 12:29:26'),
(147, 'created', 51, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":8,\"date\":\"2004-04-03\",\"user\":1,\"comment\":\"Quam vero minima at quaerat et eos excepturi pariatur.\",\"id\":51}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(148, 'created', 52, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":14,\"date\":\"2017-08-03\",\"user\":1,\"comment\":\"Illum sit commodi reprehenderit iusto aspernatur debitis omnis.\",\"id\":52}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(149, 'created', 53, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"2008-07-13\",\"user\":1,\"comment\":\"Qui officia vero ut ex aut.\",\"id\":53}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(150, 'created', 54, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"1998-08-07\",\"user\":1,\"comment\":\"Ut vel nihil dolorem consequatur unde sunt.\",\"id\":54}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(151, 'created', 55, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":17,\"date\":\"2000-06-22\",\"user\":1,\"comment\":\"Quia sed vitae esse eius modi aut.\",\"id\":55}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(152, 'created', 56, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1994-08-10\",\"user\":1,\"comment\":\"Quo soluta quas voluptate laudantium exercitationem et amet et.\",\"id\":56}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(153, 'created', 57, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":16,\"date\":\"1997-02-19\",\"user\":1,\"comment\":\"Ducimus et perspiciatis deserunt suscipit sequi.\",\"id\":57}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(154, 'created', 58, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":17,\"date\":\"1970-06-11\",\"user\":1,\"comment\":\"Neque dicta labore libero soluta ut tempora.\",\"id\":58}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(155, 'created', 59, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":14,\"date\":\"2011-05-14\",\"user\":1,\"comment\":\"Voluptas quia aut qui iste nihil et.\",\"id\":59}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(156, 'created', 60, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":18,\"date\":\"1976-04-15\",\"user\":1,\"comment\":\"Blanditiis enim quibusdam unde accusantium.\",\"id\":60}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(157, 'created', 61, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":6,\"date\":\"1993-05-08\",\"user\":1,\"comment\":\"In quae hic asperiores vitae facilis.\",\"id\":61}', '127.0.0.1', '2022-03-31 12:29:27', '2022-03-31 12:29:27'),
(158, 'created', 62, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":3,\"date\":\"1981-12-04\",\"user\":1,\"comment\":\"Molestiae natus maiores iure inventore tenetur sed aperiam.\",\"id\":62}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(159, 'created', 63, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":11,\"date\":\"1999-11-11\",\"user\":1,\"comment\":\"Inventore excepturi sunt officia facilis similique.\",\"id\":63}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(160, 'created', 64, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"2001-07-27\",\"user\":1,\"comment\":\"Molestiae suscipit eveniet sint dolorum itaque odit impedit.\",\"id\":64}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(161, 'created', 65, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":13,\"date\":\"2015-11-23\",\"user\":1,\"comment\":\"Voluptatem itaque veniam vel est laboriosam laudantium numquam.\",\"id\":65}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(162, 'created', 66, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":20,\"date\":\"1999-05-24\",\"user\":1,\"comment\":\"In quidem ut eum.\",\"id\":66}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(163, 'created', 67, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"2001-08-31\",\"user\":1,\"comment\":\"Dignissimos optio culpa mollitia voluptatibus quam.\",\"id\":67}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(164, 'created', 68, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1982-03-13\",\"user\":1,\"comment\":\"Molestiae saepe optio et officia eos.\",\"id\":68}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(165, 'created', 69, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":7,\"date\":\"2013-01-26\",\"user\":1,\"comment\":\"In veniam nulla temporibus quia voluptas laboriosam.\",\"id\":69}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(166, 'created', 70, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":15,\"date\":\"1994-01-28\",\"user\":1,\"comment\":\"Rerum et sed et voluptas id cumque ullam.\",\"id\":70}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(167, 'created', 71, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":7,\"date\":\"2020-10-06\",\"user\":1,\"comment\":\"In explicabo sed officia quibusdam aut aut quia.\",\"id\":71}', '127.0.0.1', '2022-03-31 12:29:28', '2022-03-31 12:29:28'),
(168, 'created', 72, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":10,\"date\":\"2021-04-14\",\"user\":1,\"comment\":\"In laudantium odit est optio quibusdam qui.\",\"id\":72}', '127.0.0.1', '2022-03-31 12:29:29', '2022-03-31 12:29:29'),
(169, 'created', 73, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":20,\"date\":\"1987-11-27\",\"user\":1,\"comment\":\"Beatae esse sed est.\",\"id\":73}', '127.0.0.1', '2022-03-31 12:29:29', '2022-03-31 12:29:29'),
(170, 'created', 74, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":8,\"date\":\"2010-11-12\",\"user\":1,\"comment\":\"Ex voluptatum itaque placeat et quas laudantium.\",\"id\":74}', '127.0.0.1', '2022-03-31 12:29:29', '2022-03-31 12:29:29'),
(171, 'created', 75, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":5,\"date\":\"1985-06-05\",\"user\":1,\"comment\":\"Optio quia neque aspernatur enim nihil id.\",\"id\":75}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(172, 'created', 76, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":11,\"date\":\"1997-12-23\",\"user\":1,\"comment\":\"Laborum recusandae aut odit qui repellendus perspiciatis unde.\",\"id\":76}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(173, 'created', 77, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"1990-05-18\",\"user\":1,\"comment\":\"Voluptas dolorem hic saepe ad.\",\"id\":77}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(174, 'created', 78, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":3,\"date\":\"1976-05-06\",\"user\":1,\"comment\":\"Cupiditate quia aut soluta asperiores.\",\"id\":78}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(175, 'created', 79, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":17,\"date\":\"2002-07-09\",\"user\":1,\"comment\":\"Natus reiciendis saepe laborum velit voluptatibus earum est.\",\"id\":79}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(176, 'created', 80, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":9,\"date\":\"1981-10-09\",\"user\":1,\"comment\":\"Asperiores velit sit est ipsum et aperiam ea error.\",\"id\":80}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(177, 'created', 81, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"1986-05-18\",\"user\":1,\"comment\":\"Quo reiciendis aspernatur architecto dolores alias dolorum debitis.\",\"id\":81}', '127.0.0.1', '2022-03-31 12:29:30', '2022-03-31 12:29:30'),
(178, 'created', 82, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1972-12-27\",\"user\":1,\"comment\":\"Et nobis reprehenderit atque et.\",\"id\":82}', '127.0.0.1', '2022-03-31 12:29:31', '2022-03-31 12:29:31'),
(179, 'created', 83, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":7,\"date\":\"2016-03-21\",\"user\":1,\"comment\":\"Omnis aliquid esse quas quia iusto ut.\",\"id\":83}', '127.0.0.1', '2022-03-31 12:29:31', '2022-03-31 12:29:31'),
(180, 'created', 84, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":20,\"date\":\"1999-07-14\",\"user\":1,\"comment\":\"Non aut autem mollitia delectus accusantium voluptatum doloremque.\",\"id\":84}', '127.0.0.1', '2022-03-31 12:29:31', '2022-03-31 12:29:31'),
(181, 'created', 85, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":19,\"date\":\"2015-06-04\",\"user\":1,\"comment\":\"Sint deserunt iste dignissimos.\",\"id\":85}', '127.0.0.1', '2022-03-31 12:29:31', '2022-03-31 12:29:31'),
(182, 'created', 86, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":3,\"date\":\"1979-07-08\",\"user\":1,\"comment\":\"Ullam sit esse excepturi maxime quasi ipsa ipsum consequatur.\",\"id\":86}', '127.0.0.1', '2022-03-31 12:29:31', '2022-03-31 12:29:31'),
(183, 'created', 87, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":11,\"date\":\"2003-04-11\",\"user\":1,\"comment\":\"Enim totam ut voluptatem quos et impedit animi velit.\",\"id\":87}', '127.0.0.1', '2022-03-31 12:29:31', '2022-03-31 12:29:31'),
(184, 'created', 88, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"1980-07-15\",\"user\":1,\"comment\":\"Quod facere nihil ipsum veniam esse nemo beatae qui.\",\"id\":88}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(185, 'created', 89, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":7,\"date\":\"2018-07-17\",\"user\":1,\"comment\":\"Voluptate eveniet ut quia aut temporibus eum aut.\",\"id\":89}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(186, 'created', 90, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":18,\"date\":\"2002-11-27\",\"user\":1,\"comment\":\"Quia provident ipsam aut est rerum impedit.\",\"id\":90}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(187, 'created', 91, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":10,\"date\":\"1978-07-31\",\"user\":1,\"comment\":\"Ut natus assumenda fuga amet aut.\",\"id\":91}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(188, 'created', 92, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":15,\"date\":\"1984-01-15\",\"user\":1,\"comment\":\"Eos delectus quaerat suscipit vel enim eos quia.\",\"id\":92}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(189, 'created', 93, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":1,\"date\":\"2013-10-29\",\"user\":1,\"comment\":\"Laboriosam culpa sint ut delectus corporis est.\",\"id\":93}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(190, 'created', 94, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":11,\"date\":\"1973-07-12\",\"user\":1,\"comment\":\"Beatae est eligendi sunt minus eos est.\",\"id\":94}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(191, 'created', 95, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":8,\"date\":\"2017-02-14\",\"user\":1,\"comment\":\"Nostrum consectetur porro atque libero fuga beatae.\",\"id\":95}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(192, 'created', 96, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":13,\"date\":\"1990-02-05\",\"user\":1,\"comment\":\"Est voluptas aut enim accusantium illo laudantium minus.\",\"id\":96}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(193, 'created', 97, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":4,\"date\":\"2015-10-25\",\"user\":1,\"comment\":\"Iste nobis optio et tempora quo quasi vel porro.\",\"id\":97}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(194, 'created', 98, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":18,\"date\":\"1994-04-04\",\"user\":1,\"comment\":\"Ea quia et deserunt id ipsa illum recusandae.\",\"id\":98}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(195, 'created', 99, 'App\\Models\\FrameworkControlTestComment', 1, '{\"test_audit_id\":2,\"date\":\"1986-07-31\",\"user\":1,\"comment\":\"Error quae aperiam blanditiis quia facilis aliquid corporis non.\",\"id\":99}', '127.0.0.1', '2022-03-31 12:29:32', '2022-03-31 12:29:32'),
(196, 'created', 1, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":1,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":1}', '127.0.0.1', '2022-03-31 12:29:33', '2022-03-31 12:29:33'),
(197, 'created', 2, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":2,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":2}', '127.0.0.1', '2022-03-31 12:29:33', '2022-03-31 12:29:33'),
(198, 'created', 3, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":3,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":3}', '127.0.0.1', '2022-03-31 12:29:33', '2022-03-31 12:29:33'),
(199, 'created', 4, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":4,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":4}', '127.0.0.1', '2022-03-31 12:29:33', '2022-03-31 12:29:33');
INSERT INTO `audit_logs` (`id`, `description`, `subject_id`, `subject_type`, `user_id`, `properties`, `host`, `created_at`, `updated_at`) VALUES
(200, 'created', 5, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":5,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":5}', '127.0.0.1', '2022-03-31 12:29:33', '2022-03-31 12:29:33'),
(201, 'created', 6, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":6,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":6}', '127.0.0.1', '2022-03-31 12:29:33', '2022-03-31 12:29:33'),
(202, 'created', 7, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":7,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":7}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(203, 'created', 8, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":8,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":8}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(204, 'created', 9, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":9,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":9}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(205, 'created', 10, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":10,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":10}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(206, 'created', 11, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":11,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":11}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(207, 'created', 12, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":12,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":12}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(208, 'created', 13, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":13,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":13}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(209, 'created', 14, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":14,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":14}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(210, 'created', 15, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":15,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":15}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(211, 'created', 16, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":16,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":16}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(212, 'created', 17, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":17,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":17}', '127.0.0.1', '2022-03-31 12:29:34', '2022-03-31 12:29:34'),
(213, 'created', 18, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":18,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":18}', '127.0.0.1', '2022-03-31 12:29:35', '2022-03-31 12:29:35'),
(214, 'created', 19, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":19,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":19}', '127.0.0.1', '2022-03-31 12:29:35', '2022-03-31 12:29:35'),
(215, 'created', 20, 'App\\Models\\FrameworkControlTestResult', 1, '{\"test_audit_id\":20,\"test_result\":\"\",\"summary\":\"\",\"test_date\":\"\",\"submitted_by\":\"\",\"submission_date\":\"\",\"last_updated\":\"\",\"id\":20}', '127.0.0.1', '2022-03-31 12:29:35', '2022-03-31 12:29:35'),
(216, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":1,\"team_id\":5,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(217, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":2,\"team_id\":3,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(218, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":3,\"team_id\":6,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(219, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":4,\"team_id\":8,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(220, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":5,\"team_id\":10,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(221, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":6,\"team_id\":9,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(222, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":7,\"team_id\":6,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(223, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":8,\"team_id\":3,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:36', '2022-03-31 12:29:36'),
(224, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":9,\"team_id\":9,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(225, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":10,\"team_id\":2,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(226, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":11,\"team_id\":1,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(227, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":12,\"team_id\":2,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(228, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":13,\"team_id\":8,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(229, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":14,\"team_id\":2,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(230, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":15,\"team_id\":6,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(231, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":16,\"team_id\":8,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:37', '2022-03-31 12:29:37'),
(232, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":17,\"team_id\":2,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:38', '2022-03-31 12:29:38'),
(233, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":18,\"team_id\":7,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:38', '2022-03-31 12:29:38'),
(234, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":19,\"team_id\":7,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:38', '2022-03-31 12:29:38'),
(235, 'created', 0, 'App\\Models\\ItemsToTeam', 1, '{\"type\":\"test\",\"item_id\":20,\"team_id\":7,\"id\":0}', '127.0.0.1', '2022-03-31 12:29:38', '2022-03-31 12:29:38'),
(236, 'created', 1, 'App\\Models\\NextStep', 1, '{\"id\":1,\"name\":\"Aceptada Hasta Proxima Revision\"}', '127.0.0.1', '2022-03-31 12:29:41', '2022-03-31 12:29:41'),
(237, 'created', 2, 'App\\Models\\NextStep', 1, '{\"id\":2,\"name\":\"Considerado por Proyecto\"}', '127.0.0.1', '2022-03-31 12:29:41', '2022-03-31 12:29:41'),
(238, 'created', 3, 'App\\Models\\NextStep', 1, '{\"id\":3,\"name\":\"Presentar como un Problema de Produccion\"}', '127.0.0.1', '2022-03-31 12:29:41', '2022-03-31 12:29:41'),
(239, 'created', 1, 'App\\Models\\Review', 1, '{\"id\":1,\"name\":\"Aprobar Riesgo\"}', '127.0.0.1', '2022-03-31 12:29:42', '2022-03-31 12:29:42'),
(240, 'created', 2, 'App\\Models\\Review', 1, '{\"id\":2,\"name\":\"Rechazar Riesgo y Cerca\"}', '127.0.0.1', '2022-03-31 12:29:42', '2022-03-31 12:29:42'),
(241, 'created', 1, 'App\\Models\\RiskFunction', 1, '{\"id\":1,\"name\":\"Identify\"}', '127.0.0.1', '2022-03-31 12:29:43', '2022-03-31 12:29:43'),
(242, 'created', 2, 'App\\Models\\RiskFunction', 1, '{\"id\":2,\"name\":\"Protect\"}', '127.0.0.1', '2022-03-31 12:29:43', '2022-03-31 12:29:43'),
(243, 'created', 3, 'App\\Models\\RiskFunction', 1, '{\"id\":3,\"name\":\"Detect\"}', '127.0.0.1', '2022-03-31 12:29:43', '2022-03-31 12:29:43'),
(244, 'created', 4, 'App\\Models\\RiskFunction', 1, '{\"id\":4,\"name\":\"Respond\"}', '127.0.0.1', '2022-03-31 12:29:43', '2022-03-31 12:29:43'),
(245, 'created', 5, 'App\\Models\\RiskFunction', 1, '{\"id\":5,\"name\":\"Recover\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(246, 'created', 1, 'App\\Models\\RiskGrouping', 1, '{\"id\":1,\"name\":\"Access Control\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(247, 'created', 2, 'App\\Models\\RiskGrouping', 1, '{\"id\":2,\"name\":\"Asset Management\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(248, 'created', 3, 'App\\Models\\RiskGrouping', 1, '{\"id\":3,\"name\":\"Business Continuity\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(249, 'created', 4, 'App\\Models\\RiskGrouping', 1, '{\"id\":4,\"name\":\"Exposure\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(250, 'created', 5, 'App\\Models\\RiskGrouping', 1, '{\"id\":5,\"name\":\"Governance\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(251, 'created', 6, 'App\\Models\\RiskGrouping', 1, '{\"id\":6,\"name\":\"Situational Awareness\"}', '127.0.0.1', '2022-03-31 12:29:44', '2022-03-31 12:29:44'),
(252, 'created', 7, 'App\\Models\\RiskGrouping', 1, '{\"id\":7,\"name\":\"Incident Response\"}', '127.0.0.1', '2022-03-31 12:29:45', '2022-03-31 12:29:45'),
(253, 'created', 1, 'App\\Models\\RiskCatalog', 1, '{\"id\":1,\"number\":\"R-AC-1\",\"risk_grouping_id\":1,\"name\":\"Inability to maintain individual accountability\",\"description\":\"There is a failure to maintain asset ownership and it is not possible to have non-repudiation of actions or inactions.\",\"risk_function_id\":2,\"order\":1}', '127.0.0.1', '2022-03-31 12:29:45', '2022-03-31 12:29:45'),
(254, 'created', 2, 'App\\Models\\RiskCatalog', 1, '{\"id\":2,\"number\":\"R-AC-2\",\"risk_grouping_id\":1,\"name\":\"Improper assignment of privileged risk_function_ids\",\"description\":\"There is a failure to implement least privileges.\",\"risk_function_id\":2,\"order\":2}', '127.0.0.1', '2022-03-31 12:29:45', '2022-03-31 12:29:45'),
(255, 'created', 3, 'App\\Models\\RiskCatalog', 1, '{\"id\":3,\"number\":\"R-AC-3\",\"risk_grouping_id\":1,\"name\":\"Privilege escalation\",\"description\":\"Access to privileged risk_function_ids is inadequate or cannot be controlled.\",\"risk_function_id\":2,\"order\":3}', '127.0.0.1', '2022-03-31 12:29:45', '2022-03-31 12:29:45'),
(256, 'created', 4, 'App\\Models\\RiskCatalog', 1, '{\"id\":4,\"number\":\"R-AC-4\",\"risk_grouping_id\":1,\"name\":\"Unauthorized access\",\"description\":\"Access is granted to unauthorized individuals, groups or services.\",\"risk_function_id\":2,\"order\":4}', '127.0.0.1', '2022-03-31 12:29:45', '2022-03-31 12:29:45'),
(257, 'created', 5, 'App\\Models\\RiskCatalog', 1, '{\"id\":5,\"number\":\"R-AM-1\",\"risk_grouping_id\":2,\"name\":\"Lost, damaged or stolen asset(s)\",\"description\":\"Asset(s) is\\/are lost, damaged or stolen.\",\"risk_function_id\":2,\"order\":5}', '127.0.0.1', '2022-03-31 12:29:45', '2022-03-31 12:29:45'),
(258, 'created', 6, 'App\\Models\\RiskCatalog', 1, '{\"id\":6,\"number\":\"R-AM-2\",\"risk_grouping_id\":2,\"name\":\"Loss of integrity through unauthorized changes \",\"description\":\"Unauthorized changes corrupt the integrity of the system \\/ application \\/ service.\",\"risk_function_id\":2,\"order\":6}', '127.0.0.1', '2022-03-31 12:29:46', '2022-03-31 12:29:46'),
(259, 'created', 7, 'App\\Models\\RiskCatalog', 1, '{\"id\":7,\"number\":\"R-BC-1\",\"risk_grouping_id\":3,\"name\":\"Business interruption \",\"description\":\"There is increased latency or a service outage that negatively impacts business operations.\",\"risk_function_id\":5,\"order\":7}', '127.0.0.1', '2022-03-31 12:29:46', '2022-03-31 12:29:46'),
(260, 'created', 8, 'App\\Models\\RiskCatalog', 1, '{\"id\":8,\"number\":\"R-BC-2\",\"risk_grouping_id\":3,\"name\":\"Data loss \\/ corruption \",\"description\":\"There is a failure to maintain the confidentiality of the data (compromise) or data is corrupted (loss).\",\"risk_function_id\":5,\"order\":8}', '127.0.0.1', '2022-03-31 12:29:46', '2022-03-31 12:29:46'),
(261, 'created', 12, 'App\\Models\\RiskCatalog', 1, '{\"id\":12,\"number\":\"R-BC-3\",\"risk_grouping_id\":3,\"name\":\"Reduction in productivity\",\"description\":\"User productivity is negatively affected by the incident.\",\"risk_function_id\":2,\"order\":12}', '127.0.0.1', '2022-03-31 12:29:46', '2022-03-31 12:29:46'),
(262, 'created', 13, 'App\\Models\\RiskCatalog', 1, '{\"id\":13,\"number\":\"R-EX-1\",\"risk_grouping_id\":4,\"name\":\"Loss of revenue \",\"description\":\"A financial loss occures from either a loss of clients or inability to generate future revenue.\",\"risk_function_id\":5,\"order\":13}', '127.0.0.1', '2022-03-31 12:29:46', '2022-03-31 12:29:46'),
(263, 'created', 14, 'App\\Models\\RiskCatalog', 1, '{\"id\":14,\"number\":\"R-EX-2\",\"risk_grouping_id\":4,\"name\":\"Cancelled contract\",\"description\":\"A contract is cancelled due to a violation of a contract clause.\",\"risk_function_id\":5,\"order\":14}', '127.0.0.1', '2022-03-31 12:29:46', '2022-03-31 12:29:46'),
(264, 'created', 15, 'App\\Models\\RiskCatalog', 1, '{\"id\":15,\"number\":\"R-EX-3\",\"risk_grouping_id\":4,\"name\":\"Diminished competitive advantage\",\"description\":\"The competitive advantage of the organization is jeapordized.\",\"risk_function_id\":5,\"order\":15}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(265, 'created', 16, 'App\\Models\\RiskCatalog', 1, '{\"id\":16,\"number\":\"R-EX-4\",\"risk_grouping_id\":4,\"name\":\"Diminished reputation \",\"description\":\"Negative publicity tarnishes the organization\'s reputation.\",\"risk_function_id\":5,\"order\":16}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(266, 'created', 17, 'App\\Models\\RiskCatalog', 1, '{\"id\":17,\"number\":\"R-EX-5\",\"risk_grouping_id\":4,\"name\":\"Fines and judgements\",\"description\":\"Legal and\\/or financial damages result from statutory \\/ regulatory \\/ contractual non-compliance.\",\"risk_function_id\":5,\"order\":17}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(267, 'created', 18, 'App\\Models\\RiskCatalog', 1, '{\"id\":18,\"number\":\"R-EX-6\",\"risk_grouping_id\":4,\"name\":\"Unmitigated vulnerabilities\",\"description\":\"Umitigated technical vulnerabilities exist without compensating controls or other mitigation actions.\",\"risk_function_id\":2,\"order\":18}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(268, 'created', 19, 'App\\Models\\RiskCatalog', 1, '{\"id\":19,\"number\":\"R-EX-7\",\"risk_grouping_id\":4,\"name\":\"System compromise\",\"description\":\"System \\/ application \\/ service is compromised affects its confidentiality, integrity,  availability and\\/or safety.\",\"risk_function_id\":2,\"order\":19}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(269, 'created', 20, 'App\\Models\\RiskCatalog', 1, '{\"id\":20,\"number\":\"R-BC-4\",\"risk_grouping_id\":3,\"name\":\"Information loss \\/ corruption or system compromise due to technical attack\",\"description\":\"Malware, phishing, hacking or other technical attacks compromise data, systems, applications or services.\",\"risk_function_id\":2,\"order\":20}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(270, 'created', 21, 'App\\Models\\RiskCatalog', 1, '{\"id\":21,\"number\":\"R-BC-5\",\"risk_grouping_id\":3,\"name\":\"Information loss \\/ corruption or system compromise due to non\\u2010technical attack \",\"description\":\"Social engineering, sabotage or other non-technical attack compromises data, systems, applications or services.\",\"risk_function_id\":2,\"order\":21}', '127.0.0.1', '2022-03-31 12:29:47', '2022-03-31 12:29:47'),
(271, 'created', 22, 'App\\Models\\RiskCatalog', 1, '{\"id\":22,\"number\":\"R-GV-1\",\"risk_grouping_id\":5,\"name\":\"Inability to support business processes\",\"description\":\"Implemented security \\/privacy practices are insufficient to support the organization\'s secure technologies & processes requirements.\",\"risk_function_id\":2,\"order\":1}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(272, 'created', 24, 'App\\Models\\RiskCatalog', 1, '{\"id\":24,\"number\":\"R-GV-4\",\"risk_grouping_id\":5,\"name\":\"Inadequate internal practices \",\"description\":\"Internal practices do not exist or are inadequate. Procedures fail to meet \\\\\\\"reasonable practices\\\\\\\" expected by industry standards.\",\"risk_function_id\":2,\"order\":4}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(273, 'created', 25, 'App\\Models\\RiskCatalog', 1, '{\"id\":25,\"number\":\"R-GV-5\",\"risk_grouping_id\":5,\"name\":\"Inadequate third-party practices\",\"description\":\"Third-party practices do not exist or are inadequate. Procedures fail to meet \\\\\\\"reasonable practices\\\\\\\" expected by industry standards.\",\"risk_function_id\":2,\"order\":5}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(274, 'created', 26, 'App\\Models\\RiskCatalog', 1, '{\"id\":26,\"number\":\"R-GV-3\",\"risk_grouping_id\":5,\"name\":\"Lack of roles & responsibilities\",\"description\":\"Documented security \\/ privacy roles & responsibilities do not exist or are inadequate.\",\"risk_function_id\":1,\"order\":3}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(275, 'created', 27, 'App\\Models\\RiskCatalog', 1, '{\"id\":27,\"number\":\"R-GV-2\",\"risk_grouping_id\":5,\"name\":\"Incorrect controls scoping\",\"description\":\"There is incorrect or inadequate controls scoping, which leads to a potential gap or lapse in security \\/ privacy controls coverage.\",\"risk_function_id\":1,\"order\":2}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(276, 'created', 28, 'App\\Models\\RiskCatalog', 1, '{\"id\":28,\"number\":\"R-GV-8\",\"risk_grouping_id\":5,\"name\":\"Illegal content or abusive action\",\"description\":\"There is abusive content \\/ harmful speech \\/ threats of violence \\/ illegal content that negatively affect business operations.\",\"risk_function_id\":1,\"order\":8}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(277, 'created', 29, 'App\\Models\\RiskCatalog', 1, '{\"id\":29,\"number\":\"R-SA-1\",\"risk_grouping_id\":6,\"name\":\"Inability to maintain situational awareness\",\"description\":\"There is an inability to detect incidents.\",\"risk_function_id\":3,\"order\":29}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(278, 'created', 30, 'App\\Models\\RiskCatalog', 1, '{\"id\":30,\"number\":\"R-SA-2\",\"risk_grouping_id\":6,\"name\":\"Lack of a security-minded workforce\",\"description\":\"The workforce lacks user-level understanding about security & privacy principles.\",\"risk_function_id\":2,\"order\":30}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(279, 'created', 31, 'App\\Models\\RiskCatalog', 1, '{\"id\":31,\"number\":\"R-GV-6\",\"risk_grouping_id\":5,\"name\":\"Lack of oversight of internal controls\",\"description\":\"There is a lack of due diligence \\/ due care in overseeing the organization\'s internal security \\/ privacy controls.\",\"risk_function_id\":1,\"order\":6}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(280, 'created', 32, 'App\\Models\\RiskCatalog', 1, '{\"id\":32,\"number\":\"R-GV-7\",\"risk_grouping_id\":5,\"name\":\"Lack of oversight of third-party controls\",\"description\":\"There is a lack of due diligence \\/ due care in overseeing security \\/ privacy controls operated by third-party service providers.\",\"risk_function_id\":1,\"order\":7}', '127.0.0.1', '2022-03-31 12:29:48', '2022-03-31 12:29:48'),
(281, 'created', 33, 'App\\Models\\RiskCatalog', 1, '{\"id\":33,\"number\":\"R-IR-1\",\"risk_grouping_id\":7,\"name\":\"Inability to investigate \\/ prosecute incidents\",\"description\":\"Response actions either corrupt evidence or impede the ability to prosecute incidents.\",\"risk_function_id\":4,\"order\":1}', '127.0.0.1', '2022-03-31 12:29:49', '2022-03-31 12:29:49'),
(282, 'created', 34, 'App\\Models\\RiskCatalog', 1, '{\"id\":34,\"number\":\"R-IR-2\",\"risk_grouping_id\":7,\"name\":\"Improper response to incidents\",\"description\":\"Response actions fail to act appropriately in a timely manner to properly address the incident.\",\"risk_function_id\":4,\"order\":2}', '127.0.0.1', '2022-03-31 12:29:49', '2022-03-31 12:29:49'),
(283, 'created', 35, 'App\\Models\\RiskCatalog', 1, '{\"id\":35,\"number\":\"R-IR-3\",\"risk_grouping_id\":7,\"name\":\"Ineffective remediation actions\",\"description\":\"There is no oversight to ensure remediation actions are correct and\\/or effective.\",\"risk_function_id\":2,\"order\":3}', '127.0.0.1', '2022-03-31 12:29:49', '2022-03-31 12:29:49'),
(284, 'created', 36, 'App\\Models\\RiskCatalog', 1, '{\"id\":36,\"number\":\"R-IR-4\",\"risk_grouping_id\":7,\"name\":\"Expense associated with managing a loss event\",\"description\":\"There are financial repercussions from responding to an incident or loss.\",\"risk_function_id\":4,\"order\":4}', '127.0.0.1', '2022-03-31 12:29:49', '2022-03-31 12:29:49'),
(285, 'created', 1, 'App\\Models\\Technology', 1, '{\"id\":1,\"name\":\"Todos\"}', '127.0.0.1', '2022-03-31 12:29:50', '2022-03-31 12:29:50'),
(286, 'created', 2, 'App\\Models\\Technology', 1, '{\"id\":2,\"name\":\"Anti-Virus\"}', '127.0.0.1', '2022-03-31 12:29:50', '2022-03-31 12:29:50'),
(287, 'created', 3, 'App\\Models\\Technology', 1, '{\"id\":3,\"name\":\"Backups\"}', '127.0.0.1', '2022-03-31 12:29:50', '2022-03-31 12:29:50'),
(288, 'created', 4, 'App\\Models\\Technology', 1, '{\"id\":4,\"name\":\"Blackberry\"}', '127.0.0.1', '2022-03-31 12:29:50', '2022-03-31 12:29:50'),
(289, 'created', 5, 'App\\Models\\Technology', 1, '{\"id\":5,\"name\":\"Citrix\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(290, 'created', 6, 'App\\Models\\Technology', 1, '{\"id\":6,\"name\":\"Datacenter\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(291, 'created', 7, 'App\\Models\\Technology', 1, '{\"id\":7,\"name\":\"Mail Routing\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(292, 'created', 8, 'App\\Models\\Technology', 1, '{\"id\":8,\"name\":\"Live Collaboration\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(293, 'created', 9, 'App\\Models\\Technology', 1, '{\"id\":9,\"name\":\"Mesajeria\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(294, 'created', 10, 'App\\Models\\Technology', 1, '{\"id\":10,\"name\":\"Mobile\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(295, 'created', 11, 'App\\Models\\Technology', 1, '{\"id\":11,\"name\":\"Network\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(296, 'created', 12, 'App\\Models\\Technology', 1, '{\"id\":12,\"name\":\"Power\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(297, 'created', 13, 'App\\Models\\Technology', 1, '{\"id\":13,\"name\":\"Remote Access\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(298, 'created', 14, 'App\\Models\\Technology', 1, '{\"id\":14,\"name\":\"SAN\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(299, 'created', 15, 'App\\Models\\Technology', 1, '{\"id\":15,\"name\":\"Telecom\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(300, 'created', 16, 'App\\Models\\Technology', 1, '{\"id\":16,\"name\":\"Unix\"}', '127.0.0.1', '2022-03-31 12:29:51', '2022-03-31 12:29:51'),
(301, 'created', 17, 'App\\Models\\Technology', 1, '{\"id\":17,\"name\":\"VMWare\"}', '127.0.0.1', '2022-03-31 12:29:52', '2022-03-31 12:29:52'),
(302, 'created', 18, 'App\\Models\\Technology', 1, '{\"id\":18,\"name\":\"Web\"}', '127.0.0.1', '2022-03-31 12:29:52', '2022-03-31 12:29:52'),
(303, 'created', 19, 'App\\Models\\Technology', 1, '{\"id\":19,\"name\":\"Windows\"}', '127.0.0.1', '2022-03-31 12:29:52', '2022-03-31 12:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `random_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `app_zip_file_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_zip_file_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Gestión de Acceso'),
(2, 'La Resistencia Ambiental'),
(3, 'Vigilancia'),
(4, 'Seguridad Física'),
(5, 'Politica y Procedimiento'),
(6, 'Gestión de datos sensibles'),
(7, 'Gestión de Tecnica de Vulnerabilidades'),
(8, 'Gestión de Terceros');

-- --------------------------------------------------------

--
-- Table structure for table `close_reasons`
--

CREATE TABLE `close_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `close_reasons`
--

INSERT INTO `close_reasons` (`id`, `name`) VALUES
(1, 'Rechazado'),
(2, 'Totalmente Mitigada'),
(3, 'Sistema Retirado'),
(4, 'Cancelado'),
(5, 'Demasiado Insignificante');

-- --------------------------------------------------------

--
-- Table structure for table `closures`
--

CREATE TABLE `closures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `closure_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `close_reason` int(11) NOT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_files`
--

CREATE TABLE `compliance_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` int(11) NOT NULL,
  `ref_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `content` longblob NOT NULL,
  `version` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks`
--

CREATE TABLE `contributing_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contributing_risks`
--

INSERT INTO `contributing_risks` (`id`, `subject`, `weight`) VALUES
(1, 'Safety', 0.25),
(2, 'SLA', 0.25),
(3, 'Financial', 0.25),
(4, 'Reputation', 0.25);

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks_impacts`
--

CREATE TABLE `contributing_risks_impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contributing_risks_id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contributing_risks_impacts`
--

INSERT INTO `contributing_risks_impacts` (`id`, `contributing_risks_id`, `value`, `name`) VALUES
(1, 1, 1, 'Insignificante'),
(2, 2, 1, 'Insignificante'),
(3, 3, 1, 'Insignificante'),
(4, 4, 1, 'Insignificante'),
(5, 1, 2, 'Menor'),
(6, 2, 2, 'Menor'),
(7, 3, 2, 'Menor'),
(8, 4, 2, 'Menor'),
(9, 1, 3, 'Moderado'),
(10, 2, 3, 'Moderado'),
(11, 3, 3, 'Moderado'),
(12, 4, 3, 'Moderado'),
(13, 1, 4, 'Mayor'),
(14, 2, 4, 'Mayor'),
(15, 3, 4, 'Mayor'),
(16, 4, 4, 'Mayor'),
(17, 1, 5, 'Extremo/Catastrofico'),
(18, 2, 5, 'Extremo/Catastrofico'),
(19, 3, 5, 'Extremo/Catastrofico'),
(20, 4, 5, 'Extremo/Catastrofico');

-- --------------------------------------------------------

--
-- Table structure for table `contributing_risks_likelihoods`
--

CREATE TABLE `contributing_risks_likelihoods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contributing_risks_likelihoods`
--

INSERT INTO `contributing_risks_likelihoods` (`id`, `value`, `name`) VALUES
(1, 1, 'Remota'),
(2, 2, 'Improbable'),
(3, 3, 'Creible'),
(4, 4, 'Probable'),
(5, 5, 'Casi Certero');

-- --------------------------------------------------------

--
-- Table structure for table `control_classes`
--

CREATE TABLE `control_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_maturities`
--

CREATE TABLE `control_maturities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `control_phases`
--

CREATE TABLE `control_phases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
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
  `impact` int(11) NOT NULL,
  `likelihood` int(11) NOT NULL,
  `value` double(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_risk_model_values`
--

INSERT INTO `custom_risk_model_values` (`impact`, `likelihood`, `value`) VALUES
(1, 1, 0.4),
(1, 2, 0.8),
(1, 3, 1.2),
(1, 4, 1.6),
(1, 5, 2.0),
(2, 1, 0.8),
(2, 2, 1.6),
(2, 3, 2.4),
(2, 4, 3.2),
(2, 5, 4.0),
(3, 1, 1.2),
(3, 2, 2.4),
(3, 3, 3.6),
(3, 4, 4.8),
(3, 5, 6.0),
(4, 1, 1.6),
(4, 2, 3.2),
(4, 3, 4.8),
(4, 4, 6.4),
(4, 5, 8.0),
(5, 1, 2.0),
(5, 2, 4.0),
(5, 3, 6.0),
(5, 4, 8.0),
(5, 5, 10.0);

-- --------------------------------------------------------

--
-- Table structure for table `cvss_scorings`
--

CREATE TABLE `cvss_scorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `metric_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrv_metric_name` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metric_value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrv_metric_value` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeric_value` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cvss_scorings`
--

INSERT INTO `cvss_scorings` (`id`, `metric_name`, `abrv_metric_name`, `metric_value`, `abrv_metric_value`, `numeric_value`) VALUES
(1, 'AccessComplexity', 'AC', 'Alto', 'H', 0.35),
(2, 'AccessComplexity', 'AC', 'Medio', 'M', 0.61),
(3, 'AccessComplexity', 'AC', 'Bajo', 'L', 0.71),
(4, 'AccessVector', 'AV', 'Local', 'L', 0.40),
(5, 'AccessVector', 'AV', 'Red Adyacente', 'A', 0.65),
(6, 'AccessVector', 'AV', 'Red', 'N', 1.00),
(7, 'Authentication', 'Au', 'Ninguno', 'N', 0.70),
(8, 'Authentication', 'Au', 'Instancia', 'S', 0.56),
(9, 'Authentication', 'Au', 'Multiples Instancias', 'M', 0.45),
(10, 'AvailabilityRequirement', 'AR', 'No definido', 'ND', 1.00),
(11, 'AvailabilityRequirement', 'AR', 'Bajo', 'L', 0.50),
(12, 'AvailabilityRequirement', 'AR', 'Medio', 'M', 1.00),
(13, 'AvailabilityRequirement', 'AR', 'Alto', 'H', 1.51),
(14, 'AvailImpact', 'A', 'Ninguno', 'N', 0.00),
(15, 'AvailImpact', 'A', 'Parcial', 'P', 0.28),
(16, 'AvailImpact', 'A', 'Completado', 'C', 0.66),
(17, 'CollateralDamagePotential', 'CDP', 'No definido', 'ND', 0.00),
(18, 'CollateralDamagePotential', 'CDP', 'Ninguno', 'N', 0.00),
(19, 'CollateralDamagePotential', 'CDP', 'BAjo (Baja Perdida)', 'L', 0.10),
(20, 'CollateralDamagePotential', 'CDP', 'Medio-Bajo', 'LM', 0.30),
(21, 'CollateralDamagePotential', 'CDP', 'Medio-Alto', 'MH', 0.40),
(22, 'CollateralDamagePotential', 'CDP', 'Alto', 'H', 0.50),
(23, 'ConfidentialityRequirement', 'CR', 'No definido', 'ND', 1.00),
(24, 'ConfidentialityRequirement', 'CR', 'Bajo', 'L', 0.50),
(25, 'ConfidentialityRequirement', 'CR', 'Medio', 'M', 1.00),
(26, 'ConfidentialityRequirement', 'CR', 'Alto', 'H', 1.51),
(27, 'ConfImpact', 'C', 'Ninguno', 'N', 0.00),
(28, 'ConfImpact', 'C', 'Parcial', 'P', 0.28),
(29, 'ConfImpact', 'C', 'Completado', 'C', 0.66),
(30, 'Exploitability', 'E', 'No definido', 'ND', 1.00),
(31, 'Exploitability', 'E', 'No comporbadas Estas Funciones', 'U', 0.85),
(32, 'Exploitability', 'E', 'Prueba de Concepto', 'POC', 0.90),
(33, 'Exploitability', 'E', 'Explotar Funciones Existentes', 'F', 0.95),
(34, 'Exploitability', 'E', 'Extendido', 'H', 1.00),
(35, 'IntegImpact', 'I', 'Ninguno', 'N', 0.00),
(36, 'IntegImpact', 'I', 'Parcial', 'P', 0.28),
(37, 'IntegImpact', 'I', 'Completado', 'C', 0.66),
(38, 'IntegrityRequirement', 'IR', 'No definido', 'ND', 1.00),
(39, 'IntegrityRequirement', 'IR', 'Bajo', 'L', 0.50),
(40, 'IntegrityRequirement', 'IR', 'Medio', 'M', 1.00),
(41, 'IntegrityRequirement', 'IR', 'Alto', 'H', 1.51),
(42, 'RemediationLevel', 'RL', 'No definido', 'ND', 1.00),
(43, 'RemediationLevel', 'RL', 'Arreglo', 'OF', 0.87),
(44, 'RemediationLevel', 'RL', 'Arreglo Temporal', 'TF', 0.90),
(45, 'RemediationLevel', 'RL', 'Solucion', 'W', 0.95),
(46, 'RemediationLevel', 'RL', 'No disponible', 'U', 1.00),
(47, 'ReportConfidence', 'RC', 'No definido', 'ND', 1.00),
(48, 'ReportConfidence', 'RC', 'Sin Confirmar', 'UC', 0.90),
(49, 'ReportConfidence', 'RC', 'No corroborada', 'UR', 0.95),
(50, 'ReportConfidence', 'RC', 'Confirmada', 'C', 1.00),
(51, 'TargetDistribution', 'TD', 'No definido', 'ND', 1.00),
(52, 'TargetDistribution', 'TD', 'Ninguno (0%)', 'N', 0.00),
(53, 'TargetDistribution', 'TD', 'Bajo (0-25%)', 'L', 0.25),
(54, 'TargetDistribution', 'TD', 'Medio (26-75%)', 'M', 0.75),
(55, 'TargetDistribution', 'TD', 'Alto (76-100%)', 'H', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `data_classifications`
--

CREATE TABLE `data_classifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
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
  `value` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `required_num_emplyees` int(11) DEFAULT NULL,
  `actual_num_emplyees` int(11) DEFAULT NULL,
  `color` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vision` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `mission` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectives` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsibilities` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `manager_id`, `parent_id`, `required_num_emplyees`, `actual_num_emplyees`, `color`, `vision`, `message`, `mission`, `objectives`, `responsibilities`, `created_at`, `updated_at`) VALUES
(1, 'الرئيس التنفيذى', '#000001', 2, NULL, NULL, NULL, '#39AEA9', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:22', '2022-03-31 12:28:26'),
(2, 'اﻹدارة العامة ﻷمن المعلومات', '#000002', 3, 1, NULL, NULL, '#A2D5AB', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:22', '2022-03-31 12:28:26'),
(3, 'نائب المدير العام', '#000003', 4, 2, NULL, NULL, '#557B83', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:22', '2022-03-31 12:28:26'),
(4, 'المكتب اﻹدارى', '#000004', 5, 2, 6, 1, '#46244C', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:22', '2022-03-31 12:28:26'),
(5, 'الحوكمة والمخاطر والالتزام', '#000005', 6, 2, 21, 2, '#C74B50', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:23', '2022-03-31 12:28:26'),
(6, 'المراقبة اﻷمنية والاستجابة والتحليل', '#000006', 7, 2, 43, 16, '#D49B54', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:23', '2022-03-31 12:28:26'),
(7, 'إدارة الحلول اﻷمنية', '#000007', 8, 2, 11, 5, '#712B75', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:23', '2022-03-31 12:28:26'),
(8, 'المعمارية والتخطيط', '#000008', 9, 2, 8, 0, '#332FD0', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:23', '2022-03-31 12:28:26'),
(9, 'الحوكمة', '#000009', 10, 5, NULL, 2, '#F0A500', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:26'),
(10, 'المخاطر', '#000010', 11, 5, NULL, 0, '#874356', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(11, 'الالتزام', '#000011', 12, 5, NULL, 0, '#019267', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(12, 'المراقبة اﻷمنية', '#000012', 13, 6, NULL, 9, '#9ADCFF', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(13, 'التحليل الرقمى والاستجابة للحوادث', '#000013', 14, 6, NULL, 3, '#008E89', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(14, 'المعلومات الاستخباراتية والتهديدات', '#000014', 15, 6, NULL, 2, '#313552', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(15, 'تحليل التهديدات والثغرات', '#000015', 16, 6, NULL, 2, '#FF5959', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27');
INSERT INTO `departments` (`id`, `name`, `code`, `manager_id`, `parent_id`, `required_num_emplyees`, `actual_num_emplyees`, `color`, `vision`, `message`, `mission`, `objectives`, `responsibilities`, `created_at`, `updated_at`) VALUES
(16, 'إدارة الضوابط التقنية اﻷمنية', '#000016', 17, 7, NULL, 4, '#161853', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(17, 'تطوير واختبار الحلول اﻷمنية', '#000017', 18, 7, NULL, 0, '#544179', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:27'),
(18, 'إدارة الهويات والصلاحيات', '#000018', 19, 7, NULL, 1, '#125C13', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:28'),
(19, 'التخطيط والتطوير', '#000019', 20, 8, NULL, 0, '#557B83', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:28'),
(20, 'المعمارية اﻷمنية', '#000020', 21, 8, NULL, 0, '#90AACB', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رؤية\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"رسالة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مهمة\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"أهداف\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '{\"ops\":[{\"attributes\":{\"color\":\"#5e5873\",\"bold\":true},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"},{\"attributes\":{\"color\":\"#5e5873\"},\"insert\":\"مسئوليات\"},{\"attributes\":{\"list\":\"bullet\"},\"insert\":\"\\n\"}]}', '2022-03-31 12:28:24', '2022-03-31 12:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL,
  `document_status` int(11) NOT NULL DEFAULT 1,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `creation_date` date NOT NULL,
  `last_review_date` date DEFAULT NULL,
  `review_frequency` int(11) NOT NULL DEFAULT 0,
  `next_review_date` date NOT NULL,
  `approval_date` date DEFAULT NULL,
  `control_ids` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `framework_ids` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_owner` int(11) NOT NULL DEFAULT 0,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approver` int(11) NOT NULL DEFAULT 0,
  `team_ids` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_exceptions`
--

CREATE TABLE `document_exceptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_document_id` int(11) DEFAULT NULL,
  `control_framework_id` int(11) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL DEFAULT '0000-00-00',
  `review_frequency` int(11) NOT NULL DEFAULT 0,
  `next_review_date` date NOT NULL DEFAULT '0000-00-00',
  `approval_date` date NOT NULL DEFAULT '0000-00-00',
  `approver` int(11) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `description` blob NOT NULL,
  `justification` blob NOT NULL,
  `file_id` int(11) NOT NULL,
  `associated_risks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_exceptions_statuses`
--

CREATE TABLE `document_exceptions_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_exceptions_statuses`
--

INSERT INTO `document_exceptions_statuses` (`id`, `name`) VALUES
(1, 'Open'),
(2, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `document_statuses`
--

CREATE TABLE `document_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Table structure for table `dynamic_saved_selections`
--

CREATE TABLE `dynamic_saved_selections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('private','public') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_display_settings` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_selection_settings` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_column_filters` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_login_attempts`
--

CREATE TABLE `failed_login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `name`) VALUES
(1, 'Ruthe Kohler Sr.'),
(2, 'Mr. Torrance Grimes I'),
(3, 'Alysa Buckridge'),
(4, 'Dr. Henri Corkery Sr.'),
(5, 'Roberta Nikolaus'),
(6, 'Griffin Nader'),
(7, 'Amelie Pfannerstill II'),
(8, 'Mrs. Eloisa Durgan'),
(9, 'Kyler Grady'),
(10, 'Caleb Tromp'),
(11, 'Mr. Rashawn Murazik'),
(12, 'Raphaelle Dooley'),
(13, 'Hillary Dach PhD'),
(14, 'Ronaldo Wunsch'),
(15, 'Ms. Maybell Pacocha DDS'),
(16, 'Prof. Myrl Robel'),
(17, 'Dr. Hubert Prohaska DDS'),
(18, 'Ricardo Bayer'),
(19, 'Genoveva Bednar'),
(20, 'Zora Orn Jr.');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `view_type` int(11) NOT NULL DEFAULT 1,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `content` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_types`
--

CREATE TABLE `file_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` blob DEFAULT NULL,
  `description` blob DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `order` int(11) DEFAULT NULL,
  `last_audit_date` date DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frameworks`
--

INSERT INTO `frameworks` (`id`, `parent`, `name`, `description`, `status`, `order`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `created_at`, `updated_at`) VALUES
(1, 0, 0x46656c746f6e204b73686c6572696e, 0x4e6f6e20617574656d206e65736369756e74206573742061757420617574206574206f66666963696120717561652e, 1, 1, '2011-10-02', '2005-05-12', 0, NULL, NULL),
(2, 0, 0x497361696168205a69656d65, 0x4e6f626973207665726974617469732073756e74207369742e, 1, 1, '1976-12-16', '1985-09-05', 0, NULL, NULL),
(3, 0, 0x4a616c796e204265696572, 0x4d6178696d652061757420706172696174757220647563696d757320617471756520657865726369746174696f6e656d20617471756520616e696d692e, 1, 1, '2008-01-15', '2002-06-24', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_controls`
--

CREATE TABLE `framework_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short_name` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_name` blob DEFAULT NULL,
  `description` blob DEFAULT NULL,
  `supplemental_guidance` blob DEFAULT NULL,
  `control_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control_status` tinyint(1) DEFAULT 1,
  `family` bigint(20) UNSIGNED DEFAULT NULL,
  `control_owner` bigint(20) UNSIGNED DEFAULT NULL,
  `desired_maturity` bigint(20) UNSIGNED DEFAULT NULL,
  `control_priority` bigint(20) UNSIGNED DEFAULT NULL,
  `control_class` bigint(20) UNSIGNED DEFAULT NULL,
  `control_maturity` bigint(20) UNSIGNED DEFAULT 1,
  `control_phase` bigint(20) UNSIGNED DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_audit_date` date DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `mitigation_percent` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1,
  `deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_controls`
--

INSERT INTO `framework_controls` (`id`, `short_name`, `long_name`, `description`, `supplemental_guidance`, `control_number`, `control_status`, `family`, `control_owner`, `desired_maturity`, `control_priority`, `control_class`, `control_maturity`, `control_phase`, `submission_date`, `last_audit_date`, `next_audit_date`, `desired_frequency`, `mitigation_percent`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Control1', 0x6c6f6e67206e616d6520436f6e74726f6c31, 0x497073616d206f63636165636174692076656c2071756962757364616d206175742e, 0x4e65736369756e7420656f7320657865726369746174696f6e656d2071756f642076656c69742e, 'quia', 1, 4, NULL, NULL, 2, 3, 1, 1, '1977-10-20 00:10:05', '2008-08-24', '2018-09-10', 4, 2, 4, 1, NULL, NULL),
(2, 'Control2', 0x6c6f6e67206e616d6520436f6e74726f6c32, 0x446f6c6f72756d2071756f73206175742076656c6974206f6d6e697320646f6c6f72656d206c61626f72652e, 0x44656c656374757320717569612071756920656e696d206d6f6c6c69746961206d6178696d652e, 'itaque', 1, 17, NULL, NULL, 2, 3, 6, 4, '1999-06-30 02:40:21', '2005-05-31', '1983-08-07', 7, 2, 0, 1, NULL, NULL),
(3, 'Control3', 0x6c6f6e67206e616d6520436f6e74726f6c33, 0x41757420696d706564697420766f6c75707461746962757320756c6c616d20756e646520726570656c6c656e64757320657865726369746174696f6e656d20646562697469732e, 0x566f6c757074617465206f6d6e6973206574207175616d2061757420726174696f6e652065787065646974612e, 'consequatur', 1, 10, NULL, NULL, 2, 1, 3, 2, '1985-04-22 06:02:14', '2013-02-28', '1997-04-30', 9, 5, 0, 1, NULL, NULL),
(4, 'Control4', 0x6c6f6e67206e616d6520436f6e74726f6c34, 0x4e6f6e206574206172636869746563746f20646f6c6f726520637570696469746174652e, 0x446f6c6f72656d2061757420757420617574656d206e656d6f207175696120726570756469616e64616520717569612e, 'praesentium', 1, 16, NULL, NULL, 3, 2, 5, 4, '1983-11-18 08:31:54', '1970-07-31', '1970-02-19', 3, 9, 8, 1, NULL, NULL),
(5, 'Control5', 0x6c6f6e67206e616d6520436f6e74726f6c35, 0x436f6e736563746574757220617574206170657269616d207665726974617469732065742e, 0x497461717565206f6d6e697320726174696f6e652071756f20736564207072616573656e7469756d2e, 'recusandae', 1, 4, NULL, NULL, 1, 2, 5, 1, '2006-09-04 06:57:03', '1980-04-14', '1995-10-01', 5, 5, 0, 1, NULL, NULL),
(6, 'Control6', 0x6c6f6e67206e616d6520436f6e74726f6c36, 0x506f72726f20656c6967656e64692065612065742071756920617574656d2076656c69742e, 0x51756920726570756469616e6461652071756920766f6c7570746174657320617471756520667567612073696e7420756c6c616d2e, 'necessitatibus', 1, 18, NULL, NULL, 4, 2, 6, 3, '1980-11-27 17:11:48', '1986-11-10', '1977-09-26', 4, 3, 6, 1, NULL, NULL),
(7, 'Control7', 0x6c6f6e67206e616d6520436f6e74726f6c37, 0x4576656e6965742071756f73206573742074656d706f72696275732e, 0x496e207365717569207175696120717569206e65736369756e742063756d2e, 'eum', 1, 4, NULL, NULL, 1, 2, 1, 4, '1978-03-26 21:58:20', '2013-02-07', '2019-11-09', 7, 6, 1, 1, NULL, NULL),
(8, 'Control8', 0x6c6f6e67206e616d6520436f6e74726f6c38, 0x426c616e64697469697320657420766974616520636f6e736571756174757220726572756d2e, 0x456e696d20706572666572656e64697320717569206163637573616d7573206f7074696f206e616d20717569732e, 'quia', 1, 10, NULL, NULL, 2, 2, 3, 1, '1975-01-26 09:43:15', '1994-02-19', '1980-07-09', 5, 1, 9, 1, NULL, NULL),
(9, 'Control9', 0x6c6f6e67206e616d6520436f6e74726f6c39, 0x4e6f6e20617373756d656e6461206f6666696369612071756f6420717569737175616d2065742e, 0x436f6e73656374657475722071756173692063756c706120697073756d20646f6c6f7220697073612065742e, 'suscipit', 1, 7, NULL, NULL, 1, 2, 1, 3, '2017-03-03 19:03:55', '1994-11-14', '1988-10-23', 4, 2, 6, 1, NULL, NULL),
(10, 'Control10', 0x6c6f6e67206e616d6520436f6e74726f6c3130, 0x52656d206e6968696c20686172756d2073697420766974616520766f6c7570746174652076697461652e, 0x566f6c7570746174656d20617574656d20726174696f6e652071756f7320706f7373696d75732073756e742065737420766f6c75707461732076697461652e, 'eius', 1, 5, NULL, NULL, 2, 3, 3, 4, '1975-07-14 08:27:05', '2003-11-09', '2004-09-19', 7, 6, 5, 1, NULL, NULL),
(11, 'Control11', 0x6c6f6e67206e616d6520436f6e74726f6c3131, 0x5665726f2076656c207175617320646f6c6f72756d2e, 0x44656c656374757320766f6c757074617320757420636f6e73657175756e747572206573742e, 'fuga', 1, 17, NULL, NULL, 4, 2, 6, 4, '2010-04-12 12:21:00', '1990-06-19', '1976-07-06', 1, 0, 4, 1, NULL, NULL),
(12, 'Control12', 0x6c6f6e67206e616d6520436f6e74726f6c3132, 0x456120657420766572697461746973206c61626f726520616420726570656c6c656e64757320656c6967656e64692e, 0x417373756d656e64612073757363697069742071756961206573742073656420636f6e73657175756e74757220717569737175616d20696d70656469742e, 'consequatur', 1, 17, NULL, NULL, 3, 1, 1, 2, '1978-05-05 08:15:35', '1996-09-28', '1998-05-05', 9, 0, 3, 1, NULL, NULL),
(13, 'Control13', 0x6c6f6e67206e616d6520436f6e74726f6c3133, 0x4e6f737472756d2076656c69742063756d717565206e6f6e207175616d2e, 0x4d6f6c65737469616520636f6e73657175617475722074656e65747572206675676961742065617175652065617175652e, 'rerum', 1, 12, NULL, NULL, 1, 1, 4, 3, '1991-05-30 11:19:41', '2013-02-05', '1983-05-19', 9, 2, 7, 1, NULL, NULL),
(14, 'Control14', 0x6c6f6e67206e616d6520436f6e74726f6c3134, 0x4574206f646974206869632076656c206170657269616d206d696e696d6120717569732e, 0x4e756c6c61206e6968696c20696420616220617574656d20706f7373696d75732e, 'sint', 1, 7, NULL, NULL, 3, 2, 6, 2, '2016-12-26 19:14:49', '1994-07-27', '2003-05-16', 4, 2, 4, 1, NULL, NULL),
(15, 'Control15', 0x6c6f6e67206e616d6520436f6e74726f6c3135, 0x42656174616520726572756d20636f7272757074692065617175652073696e742065742e, 0x4574206e6f6e206e6f6e20766f6c75707461732065742e, 'aut', 1, 10, NULL, NULL, 1, 3, 3, 3, '2014-03-03 05:07:49', '1991-08-05', '2016-09-04', 0, 1, 6, 1, NULL, NULL),
(16, 'Control16', 0x6c6f6e67206e616d6520436f6e74726f6c3136, 0x41757420636f6e736571756174757220667567697420766f6c7570746174656d20706172696174757220726570726568656e64657269742071756962757364616d2073696e742e, 0x4d6f6c65737469616520697073756d20656c6967656e64692063756c7061207175692075742061747175652071756964656d20657373652e, 'similique', 1, 17, NULL, NULL, 2, 1, 5, 2, '2004-03-06 03:52:31', '2001-07-21', '1995-10-10', 4, 1, 5, 1, NULL, NULL),
(17, 'Control17', 0x6c6f6e67206e616d6520436f6e74726f6c3137, 0x41757420726572756d206120616d657420717561732e, 0x4576656e6965742073656420696e76656e746f7265206e6f6e206c61626f72696f73616d2e, 'tempora', 1, 8, NULL, NULL, 4, 3, 1, 3, '2017-12-08 02:57:49', '2020-10-15', '1971-12-16', 0, 2, 3, 1, NULL, NULL),
(18, 'Control18', 0x6c6f6e67206e616d6520436f6e74726f6c3138, 0x53756e742065697573206f6d6e697320666163696c6973206375706964697461746520766f6c7570746174657320726174696f6e652064696374612e, 0x4e617475732076656c69742073757363697069742076656c20696d706564697420696e2065742061737065726e617475722e, 'officiis', 1, 8, NULL, NULL, 1, 3, 3, 1, '1999-06-29 18:08:34', '2005-08-17', '1974-05-06', 2, 3, 2, 1, NULL, NULL),
(19, 'Control19', 0x6c6f6e67206e616d6520436f6e74726f6c3139, 0x48696320737573636970697420616e696d69207369742069757265206164697069736369206175742e, 0x496c6c6f206572726f722073697420706c61636561742e, 'voluptate', 1, 3, NULL, NULL, 1, 3, 6, 3, '2003-05-10 07:17:07', '1995-11-23', '1973-03-11', 1, 2, 8, 1, NULL, NULL),
(20, 'Control20', 0x6c6f6e67206e616d6520436f6e74726f6c3230, 0x436f6d6d6f6469206675676974206175742071756f732e, 0x5175616d2076656c6974206e6968696c20667567612061757420717561732e, 'autem', 1, 1, NULL, NULL, 4, 1, 6, 1, '2011-09-16 02:08:36', '2010-04-20', '1971-05-19', 9, 8, 0, 1, NULL, NULL),
(21, 'Control21', 0x6c6f6e67206e616d6520436f6e74726f6c3231, 0x4574206e65736369756e742074656d706f726120696c6c6f2064656c6563747573206c696265726f2075742e, 0x517569207669746165207574206c696265726f2e, 'nulla', 1, 18, NULL, NULL, 4, 1, 6, 2, '1979-11-29 05:37:18', '1972-11-04', '1992-09-11', 1, 1, 6, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_mappings`
--

CREATE TABLE `framework_control_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `framework_control_id` bigint(20) UNSIGNED NOT NULL,
  `framework_id` bigint(20) UNSIGNED NOT NULL,
  `reference_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_mappings`
--

INSERT INTO `framework_control_mappings` (`id`, `framework_control_id`, `framework_id`, `reference_name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'voluptas', NULL, NULL),
(2, 2, 2, 'eaque', NULL, NULL),
(3, 3, 3, 'sed', NULL, NULL),
(4, 4, 1, 'esse', NULL, NULL),
(5, 5, 2, 'voluptatem', NULL, NULL),
(6, 6, 3, 'qui', NULL, NULL),
(7, 7, 1, 'quas', NULL, NULL),
(8, 8, 2, 'et', NULL, NULL),
(9, 9, 3, 'vel', NULL, NULL),
(10, 10, 1, 'dolorem', NULL, NULL),
(11, 11, 2, 'illum', NULL, NULL),
(12, 12, 3, 'aspernatur', NULL, NULL),
(13, 13, 1, 'sed', NULL, NULL),
(14, 14, 2, 'reiciendis', NULL, NULL),
(15, 15, 3, 'dignissimos', NULL, NULL),
(16, 16, 1, 'minima', NULL, NULL),
(17, 17, 2, 'modi', NULL, NULL),
(18, 18, 3, 'voluptatem', NULL, NULL),
(19, 19, 1, 'nesciunt', NULL, NULL),
(20, 20, 2, 'inventore', NULL, NULL),
(21, 21, 3, 'sapiente', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_tests`
--

CREATE TABLE `framework_control_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tester` int(11) DEFAULT NULL,
  `test_frequency` int(11) DEFAULT 0,
  `last_date` date DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_steps` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approximate_time` int(11) DEFAULT NULL,
  `expected_results` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework_control_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `additional_stakeholders` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_tests`
--

INSERT INTO `framework_control_tests` (`id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `additional_stakeholders`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2005-06-27', '1987-03-06', 'Control test 1', '6', '2', 3, '2', 1, 1, 1, '1', '1994-03-25 22:00:00', NULL),
(2, 1, 5, '2004-09-13', '1971-04-18', 'Control test 2', '6', '1', 1, '0', 2, 0, 1, '1', '2003-08-27 22:00:00', NULL),
(3, 1, 8, '1973-07-01', '1970-03-10', 'Control test 3', '8', '1', 9, '6', 3, 1, 1, '1', '2018-05-06 22:00:00', NULL),
(4, 1, 0, '1997-08-04', '1990-12-13', 'Control test 4', '9', '3', 2, '9', 4, 9, 1, '1', '2004-05-13 22:00:00', NULL),
(5, 1, 2, '1975-01-26', '1982-06-10', 'Control test 5', '5', '4', 7, '9', 5, 8, 1, '1', '1986-02-23 22:00:00', NULL),
(6, 1, 6, '1996-02-12', '1973-03-14', 'Control test 6', '9', '6', 2, '8', 6, 7, 1, '1', '1991-08-01 22:00:00', NULL),
(7, 1, 3, '1978-01-11', '1973-11-21', 'Control test 7', '8', '5', 4, '9', 7, 0, 1, '1', '1994-03-09 22:00:00', NULL),
(8, 1, 1, '2016-08-26', '2020-04-12', 'Control test 8', '1', '6', 0, '2', 8, 0, 1, '1', '2001-04-09 22:00:00', NULL),
(9, 1, 7, '1988-05-30', '2021-08-14', 'Control test 9', '8', '1', 5, '2', 9, 9, 1, '1', '2017-06-12 22:00:00', NULL),
(10, 1, 4, '2001-02-24', '2005-08-04', 'Control test 10', '1', '0', 6, '1', 10, 4, 1, '1', '1988-06-21 22:00:00', NULL),
(11, 1, 4, '1987-07-03', '1984-12-03', 'Control test 11', '7', '3', 8, '0', 11, 7, 1, '1', '1998-10-18 22:00:00', NULL),
(12, 1, 0, '1993-08-20', '1974-07-11', 'Control test 12', '3', '8', 1, '4', 12, 4, 1, '1', '2011-10-29 22:00:00', NULL),
(13, 1, 8, '1999-10-08', '2009-11-02', 'Control test 13', '9', '4', 6, '5', 13, 2, 1, '1', '2004-06-26 22:00:00', NULL),
(14, 1, 0, '2004-02-07', '1985-10-29', 'Control test 14', '6', '8', 2, '9', 14, 0, 1, '1', '1981-08-16 22:00:00', NULL),
(15, 1, 5, '1976-08-03', '2000-01-07', 'Control test 15', '4', '8', 3, '6', 15, 4, 1, '1', '1986-04-30 22:00:00', NULL),
(16, 1, 3, '2011-09-14', '1989-07-04', 'Control test 16', '7', '4', 9, '2', 16, 4, 1, '1', '1990-07-18 22:00:00', NULL),
(17, 1, 6, '1982-06-09', '1982-08-07', 'Control test 17', '9', '8', 9, '1', 17, 0, 1, '1', '2018-10-14 22:00:00', NULL),
(18, 1, 1, '2016-07-23', '2010-01-27', 'Control test 18', '4', '3', 2, '5', 18, 7, 1, '1', '1994-11-05 22:00:00', NULL),
(19, 1, 0, '1985-10-15', '2004-06-27', 'Control test 19', '8', '9', 2, '6', 19, 7, 1, '1', '1992-11-21 22:00:00', NULL),
(20, 1, 5, '2010-11-02', '1976-12-28', 'Control test 20', '0', '5', 3, '2', 20, 7, 1, '1', '1974-02-24 22:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_audits`
--

CREATE TABLE `framework_control_test_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `tester` int(11) DEFAULT NULL,
  `test_frequency` int(11) DEFAULT 0,
  `last_date` date DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `name` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_steps` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approximate_time` int(11) DEFAULT NULL,
  `expected_results` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework_control_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desired_frequency` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_audits`
--

INSERT INTO `framework_control_test_audits` (`id`, `test_id`, `tester`, `test_frequency`, `last_date`, `next_date`, `name`, `objective`, `test_steps`, `approximate_time`, `expected_results`, `framework_control_id`, `desired_frequency`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, '1973-01-08', '2011-11-28', 'Control1 Audit (1)', '3', '5', 4, '9', 1, 3, 1, '2008-12-15 22:00:00', NULL),
(2, 2, 1, 7, '2016-08-15', '2006-11-20', 'Control2 Audit (2)', '0', '7', 1, '0', 2, 8, 1, '2020-02-19 22:00:00', NULL),
(3, 3, 1, 5, '2015-05-18', '2006-10-21', 'Control3 Audit (3)', '3', '0', 1, '9', 3, 7, 1, '2001-10-29 22:00:00', NULL),
(4, 4, 1, 0, '2002-08-18', '2012-09-23', 'Control4 Audit (4)', '0', '3', 5, '8', 4, 3, 1, '2014-09-02 22:00:00', NULL),
(5, 5, 1, 9, '1975-01-12', '2018-01-17', 'Control5 Audit (5)', '7', '7', 1, '3', 5, 5, 1, '1995-01-02 22:00:00', NULL),
(6, 6, 1, 9, '2019-01-06', '1979-03-22', 'Control6 Audit (6)', '7', '6', 5, '8', 6, 5, 1, '2016-12-03 22:00:00', NULL),
(7, 7, 1, 1, '1975-07-17', '2001-12-10', 'Control7 Audit (7)', '5', '0', 5, '2', 7, 0, 1, '2009-09-28 22:00:00', NULL),
(8, 8, 1, 3, '2000-06-24', '1995-04-23', 'Control8 Audit (8)', '4', '1', 9, '8', 8, 8, 1, '2018-04-14 22:00:00', NULL),
(9, 9, 1, 7, '2020-01-20', '2019-08-05', 'Control9 Audit (9)', '5', '0', 2, '2', 9, 9, 1, '1984-08-31 22:00:00', NULL),
(10, 10, 1, 1, '2018-08-06', '1971-05-29', 'Control10 Audit (10)', '2', '1', 6, '9', 10, 2, 1, '2007-01-16 22:00:00', NULL),
(11, 11, 1, 4, '2012-08-05', '1977-08-22', 'Control11 Audit (11)', '1', '1', 1, '8', 11, 7, 1, '2018-10-10 22:00:00', NULL),
(12, 12, 1, 6, '2021-10-06', '2005-08-23', 'Control12 Audit (12)', '9', '7', 2, '4', 12, 1, 1, '2019-05-30 22:00:00', NULL),
(13, 13, 1, 0, '2002-09-25', '1977-10-26', 'Control13 Audit (13)', '6', '6', 4, '1', 13, 4, 1, '2007-12-20 22:00:00', NULL),
(14, 14, 1, 1, '1993-10-21', '1988-12-01', 'Control14 Audit (14)', '6', '9', 3, '5', 14, 4, 1, '1994-06-26 22:00:00', NULL),
(15, 15, 1, 4, '1970-01-04', '2018-11-21', 'Control15 Audit (15)', '9', '2', 8, '9', 15, 6, 1, '2014-04-27 22:00:00', NULL),
(16, 16, 1, 9, '1990-04-19', '2006-03-20', 'Control16 Audit (16)', '7', '2', 4, '1', 16, 0, 1, '1998-07-14 22:00:00', NULL),
(17, 17, 1, 7, '2001-10-10', '1997-05-09', 'Control17 Audit (17)', '6', '2', 5, '2', 17, 5, 1, '1976-01-13 22:00:00', NULL),
(18, 18, 1, 3, '1999-04-04', '1994-02-08', 'Control18 Audit (18)', '8', '9', 1, '1', 18, 0, 1, '2010-12-23 22:00:00', NULL),
(19, 19, 1, 8, '1995-01-30', '1994-08-28', 'Control19 Audit (19)', '0', '4', 4, '3', 19, 8, 1, '2015-03-13 22:00:00', NULL),
(20, 20, 1, 2, '1978-03-09', '2021-11-07', 'Control20 Audit (20)', '1', '8', 9, '2', 20, 3, 1, '1982-02-02 22:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_comments`
--

CREATE TABLE `framework_control_test_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_audit_id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_comments`
--

INSERT INTO `framework_control_test_comments` (`id`, `test_audit_id`, `date`, `user`, `comment`) VALUES
(1, 9, '2009-02-21 22:00:00', 1, 'Assumenda cumque ipsum voluptas magnam quisquam et.'),
(2, 10, '1995-09-05 22:00:00', 1, 'Dolor sequi quo aut debitis aut dolores in sit.'),
(3, 16, '1983-01-24 22:00:00', 1, 'Alias non id autem.'),
(4, 1, '1988-11-17 22:00:00', 1, 'Qui est voluptatem sed quidem sapiente pariatur ullam aliquid.'),
(5, 13, '2020-02-13 22:00:00', 1, 'Et maxime dignissimos quaerat sapiente eos consequatur blanditiis.'),
(6, 4, '1988-03-12 22:00:00', 1, 'Doloremque tenetur aut velit necessitatibus.'),
(7, 17, '1985-03-10 22:00:00', 1, 'Rerum quas harum a saepe harum magnam mollitia error.'),
(8, 5, '2021-02-16 22:00:00', 1, 'Enim veritatis et quo molestiae doloremque.'),
(9, 11, '2007-09-09 22:00:00', 1, 'Enim ea voluptatum sed dolorem ut numquam quibusdam.'),
(10, 1, '1981-09-30 22:00:00', 1, 'Quisquam animi totam suscipit quos.'),
(11, 18, '2010-05-13 22:00:00', 1, 'Delectus autem provident veniam ipsam voluptatibus occaecati accusamus.'),
(12, 13, '2011-09-07 22:00:00', 1, 'Ut dolor ipsum alias et tempora eius repudiandae.'),
(13, 1, '2000-01-26 22:00:00', 1, 'Pariatur aut eveniet assumenda dignissimos.'),
(14, 5, '1975-03-15 22:00:00', 1, 'Autem pariatur facere reprehenderit molestiae.'),
(15, 4, '1980-01-29 22:00:00', 1, 'Amet tempora illo minus.'),
(16, 6, '1996-03-24 22:00:00', 1, 'Nihil omnis numquam itaque expedita omnis qui molestiae.'),
(17, 16, '1971-01-16 22:00:00', 1, 'Culpa a maxime delectus corporis porro.'),
(18, 4, '1985-07-15 22:00:00', 1, 'Occaecati perspiciatis laborum consequuntur ut animi minus quia.'),
(19, 10, '1996-02-29 22:00:00', 1, 'Quas iste assumenda quam qui omnis molestiae asperiores.'),
(20, 20, '1982-06-08 22:00:00', 1, 'Nam voluptas consequuntur perspiciatis tempora id neque.'),
(21, 9, '1975-06-06 22:00:00', 1, 'Aut et deleniti quis.'),
(22, 4, '1996-12-11 22:00:00', 1, 'Adipisci nihil similique optio deleniti minus.'),
(23, 9, '1972-01-19 22:00:00', 1, 'Sapiente provident minus ea eaque.'),
(24, 5, '1990-05-02 22:00:00', 1, 'Praesentium et repudiandae odit explicabo alias voluptates quas maiores.'),
(25, 19, '1999-02-08 22:00:00', 1, 'Assumenda molestiae voluptas eum reiciendis ipsa doloribus voluptatum.'),
(26, 9, '1980-08-07 22:00:00', 1, 'Et voluptas enim repellat quasi.'),
(27, 2, '1988-05-18 22:00:00', 1, 'Eum ipsam fugiat ullam numquam.'),
(28, 2, '1986-10-14 22:00:00', 1, 'Facere id ratione perspiciatis voluptatem laudantium animi autem sequi.'),
(29, 7, '1976-06-26 22:00:00', 1, 'At quasi qui saepe.'),
(30, 2, '2021-08-19 22:00:00', 1, 'Ipsam sint qui doloremque eos architecto ratione ut tempora.'),
(31, 1, '2001-02-04 22:00:00', 1, 'Ullam nihil voluptatibus dolor explicabo.'),
(32, 18, '2001-02-16 22:00:00', 1, 'Aliquam hic praesentium deserunt delectus voluptatem dolor voluptatibus ipsa.'),
(33, 9, '2002-01-25 22:00:00', 1, 'Eligendi laboriosam et minima possimus velit saepe voluptatem.'),
(34, 13, '2013-02-10 22:00:00', 1, 'Quae nisi sint error cupiditate.'),
(35, 4, '2005-09-17 22:00:00', 1, 'Deserunt rerum reprehenderit officia voluptatem voluptates dolor.'),
(36, 4, '2012-06-25 22:00:00', 1, 'Consequatur consectetur molestiae nesciunt vero.'),
(37, 12, '1997-03-25 22:00:00', 1, 'Officia laboriosam ipsa debitis enim ut eveniet at.'),
(38, 19, '2000-03-16 22:00:00', 1, 'Minus ut aut quasi iusto ut unde.'),
(39, 5, '1990-08-29 22:00:00', 1, 'Aut laboriosam deserunt nihil perspiciatis molestiae.'),
(40, 14, '2014-01-06 22:00:00', 1, 'Repellat ullam et ipsa cumque voluptatem.'),
(41, 5, '2010-05-02 22:00:00', 1, 'Qui dolor accusantium quo ut et ipsum aut.'),
(42, 16, '1982-10-20 22:00:00', 1, 'Sequi mollitia vitae autem est at nulla eius sequi.'),
(43, 20, '2020-06-03 22:00:00', 1, 'Ad sit aliquam veniam architecto id qui recusandae.'),
(44, 2, '1990-01-07 22:00:00', 1, 'Placeat expedita eligendi illo quos nihil.'),
(45, 9, '2001-09-05 22:00:00', 1, 'Aut ipsam suscipit et sed harum.'),
(46, 1, '2018-08-15 22:00:00', 1, 'Non impedit temporibus exercitationem.'),
(47, 4, '2014-12-27 22:00:00', 1, 'Harum laboriosam odio fuga molestiae qui saepe.'),
(48, 18, '1976-09-04 22:00:00', 1, 'Ipsam aut quibusdam explicabo ratione cumque non.'),
(49, 4, '2004-07-05 22:00:00', 1, 'At impedit praesentium sunt exercitationem tempora ut.'),
(50, 19, '2015-07-12 22:00:00', 1, 'Aliquid doloremque voluptatem nobis est doloribus.'),
(51, 8, '2004-04-02 22:00:00', 1, 'Quam vero minima at quaerat et eos excepturi pariatur.'),
(52, 14, '2017-08-02 22:00:00', 1, 'Illum sit commodi reprehenderit iusto aspernatur debitis omnis.'),
(53, 1, '2008-07-12 22:00:00', 1, 'Qui officia vero ut ex aut.'),
(54, 9, '1998-08-06 22:00:00', 1, 'Ut vel nihil dolorem consequatur unde sunt.'),
(55, 17, '2000-06-21 22:00:00', 1, 'Quia sed vitae esse eius modi aut.'),
(56, 2, '1994-08-09 22:00:00', 1, 'Quo soluta quas voluptate laudantium exercitationem et amet et.'),
(57, 16, '1997-02-18 22:00:00', 1, 'Ducimus et perspiciatis deserunt suscipit sequi.'),
(58, 17, '1970-06-10 22:00:00', 1, 'Neque dicta labore libero soluta ut tempora.'),
(59, 14, '2011-05-13 22:00:00', 1, 'Voluptas quia aut qui iste nihil et.'),
(60, 18, '1976-04-14 22:00:00', 1, 'Blanditiis enim quibusdam unde accusantium.'),
(61, 6, '1993-05-07 22:00:00', 1, 'In quae hic asperiores vitae facilis.'),
(62, 3, '1981-12-03 22:00:00', 1, 'Molestiae natus maiores iure inventore tenetur sed aperiam.'),
(63, 11, '1999-11-10 22:00:00', 1, 'Inventore excepturi sunt officia facilis similique.'),
(64, 19, '2001-07-26 22:00:00', 1, 'Molestiae suscipit eveniet sint dolorum itaque odit impedit.'),
(65, 13, '2015-11-22 22:00:00', 1, 'Voluptatem itaque veniam vel est laboriosam laudantium numquam.'),
(66, 20, '1999-05-23 22:00:00', 1, 'In quidem ut eum.'),
(67, 1, '2001-08-30 22:00:00', 1, 'Dignissimos optio culpa mollitia voluptatibus quam.'),
(68, 2, '1982-03-12 22:00:00', 1, 'Molestiae saepe optio et officia eos.'),
(69, 7, '2013-01-25 22:00:00', 1, 'In veniam nulla temporibus quia voluptas laboriosam.'),
(70, 15, '1994-01-27 22:00:00', 1, 'Rerum et sed et voluptas id cumque ullam.'),
(71, 7, '2020-10-05 22:00:00', 1, 'In explicabo sed officia quibusdam aut aut quia.'),
(72, 10, '2021-04-13 22:00:00', 1, 'In laudantium odit est optio quibusdam qui.'),
(73, 20, '1987-11-26 22:00:00', 1, 'Beatae esse sed est.'),
(74, 8, '2010-11-11 22:00:00', 1, 'Ex voluptatum itaque placeat et quas laudantium.'),
(75, 5, '1985-06-04 22:00:00', 1, 'Optio quia neque aspernatur enim nihil id.'),
(76, 11, '1997-12-22 22:00:00', 1, 'Laborum recusandae aut odit qui repellendus perspiciatis unde.'),
(77, 19, '1990-05-17 22:00:00', 1, 'Voluptas dolorem hic saepe ad.'),
(78, 3, '1976-05-05 22:00:00', 1, 'Cupiditate quia aut soluta asperiores.'),
(79, 17, '2002-07-08 22:00:00', 1, 'Natus reiciendis saepe laborum velit voluptatibus earum est.'),
(80, 9, '1981-10-08 22:00:00', 1, 'Asperiores velit sit est ipsum et aperiam ea error.'),
(81, 19, '1986-05-17 22:00:00', 1, 'Quo reiciendis aspernatur architecto dolores alias dolorum debitis.'),
(82, 2, '1972-12-26 22:00:00', 1, 'Et nobis reprehenderit atque et.'),
(83, 7, '2016-03-20 22:00:00', 1, 'Omnis aliquid esse quas quia iusto ut.'),
(84, 20, '1999-07-13 22:00:00', 1, 'Non aut autem mollitia delectus accusantium voluptatum doloremque.'),
(85, 19, '2015-06-03 22:00:00', 1, 'Sint deserunt iste dignissimos.'),
(86, 3, '1979-07-07 22:00:00', 1, 'Ullam sit esse excepturi maxime quasi ipsa ipsum consequatur.'),
(87, 11, '2003-04-10 22:00:00', 1, 'Enim totam ut voluptatem quos et impedit animi velit.'),
(88, 4, '1980-07-14 22:00:00', 1, 'Quod facere nihil ipsum veniam esse nemo beatae qui.'),
(89, 7, '2018-07-16 22:00:00', 1, 'Voluptate eveniet ut quia aut temporibus eum aut.'),
(90, 18, '2002-11-26 22:00:00', 1, 'Quia provident ipsam aut est rerum impedit.'),
(91, 10, '1978-07-30 22:00:00', 1, 'Ut natus assumenda fuga amet aut.'),
(92, 15, '1984-01-14 22:00:00', 1, 'Eos delectus quaerat suscipit vel enim eos quia.'),
(93, 1, '2013-10-28 22:00:00', 1, 'Laboriosam culpa sint ut delectus corporis est.'),
(94, 11, '1973-07-11 22:00:00', 1, 'Beatae est eligendi sunt minus eos est.'),
(95, 8, '2017-02-13 22:00:00', 1, 'Nostrum consectetur porro atque libero fuga beatae.'),
(96, 13, '1990-02-04 22:00:00', 1, 'Est voluptas aut enim accusantium illo laudantium minus.'),
(97, 4, '2015-10-24 22:00:00', 1, 'Iste nobis optio et tempora quo quasi vel porro.'),
(98, 18, '1994-04-03 22:00:00', 1, 'Ea quia et deserunt id ipsa illum recusandae.'),
(99, 2, '1986-07-30 22:00:00', 1, 'Error quae aperiam blanditiis quia facilis aliquid corporis non.');

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_results`
--

CREATE TABLE `framework_control_test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_audit_id` bigint(20) UNSIGNED NOT NULL,
  `test_result` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_date` date NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submission_date` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `framework_control_test_results`
--

INSERT INTO `framework_control_test_results` (`id`, `test_audit_id`, `test_result`, `summary`, `test_date`, `submitted_by`, `submission_date`, `last_updated`) VALUES
(1, 1, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 4, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 6, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 7, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 8, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 9, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 10, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 11, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 12, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 13, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 14, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 15, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 16, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 17, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 18, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 19, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 20, '', '', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_test_results_to_risks`
--

CREATE TABLE `framework_control_test_results_to_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_results_id` bigint(20) UNSIGNED DEFAULT NULL,
  `risk_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_to_frameworks`
--

CREATE TABLE `framework_control_to_frameworks` (
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `framework_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `framework_control_type_mappings`
--

CREATE TABLE `framework_control_type_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `control_type_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `impacts`
--

CREATE TABLE `impacts` (
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `impacts`
--

INSERT INTO `impacts` (`name`, `value`) VALUES
('1', 0),
('2', 0),
('3', 0),
('4', 0),
('5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items_to_teams`
--

CREATE TABLE `items_to_teams` (
  `item_id` int(11) NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items_to_teams`
--

INSERT INTO `items_to_teams` (`item_id`, `team_id`, `type`) VALUES
(1, 5, 'test'),
(2, 3, 'test'),
(3, 6, 'test'),
(4, 8, 'test'),
(5, 10, 'test'),
(6, 9, 'test'),
(7, 6, 'test'),
(8, 3, 'test'),
(9, 9, 'test'),
(10, 2, 'test'),
(11, 1, 'test'),
(12, 2, 'test'),
(13, 8, 'test'),
(14, 2, 'test'),
(15, 6, 'test'),
(16, 8, 'test'),
(17, 2, 'test'),
(18, 7, 'test'),
(19, 7, 'test'),
(20, 7, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `description`, `code`, `created_at`, `updated_at`) VALUES
(1, 'CEO', 'This job for CEO', '#00001', '2022-03-31 12:28:24', '2022-03-31 12:28:24'),
(2, 'Department manager', 'This job for department manager', '#00003', '2022-03-31 12:28:24', '2022-03-31 12:28:24'),
(3, 'Job1', 'Job description1', '#11111', '2022-03-31 12:28:24', '2022-03-31 12:28:24'),
(4, 'Job2', 'Job description2', '#22222', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(5, 'Job3', 'Job description3', '#33333', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(6, 'Job4', 'Job description4', '#44444', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(7, 'Job5', 'Job description5', '#55555', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(8, 'Job6', 'Job description6', '#66666', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(9, 'Job7', 'Job description7', '#77777', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(10, 'Job8', 'Job description8', '#88888', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(11, 'Job9', 'Job description9', '#99999', '2022-03-31 12:28:25', '2022-03-31 12:28:25'),
(12, 'Job10', 'Job description10', '#101010101', '2022-03-31 12:28:25', '2022-03-31 12:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `full`) VALUES
(1, 'en', 'English'),
(2, 'bp', 'Brazilian Portuguese'),
(3, 'es', 'Espanol'),
(4, 'ar', 'Arabic'),
(5, 'ca', 'Catalan'),
(6, 'cs', 'Czech'),
(7, 'da', 'Danish'),
(8, 'de', 'German'),
(9, 'el', 'Greek'),
(10, 'fi', 'Finnish'),
(11, 'fr', 'French'),
(12, 'he', 'Hebrew'),
(13, 'hi', 'Hindi'),
(14, 'hu', 'Hungarian'),
(15, 'it', 'Italian'),
(16, 'ja', 'Japanese'),
(17, 'ko', 'Korean'),
(18, 'nl', 'Dutch'),
(19, 'no', 'Norwegian'),
(20, 'pl', 'Polish'),
(21, 'pt', 'Portuguese'),
(22, 'ro', 'Romanian'),
(23, 'ru', 'Russian'),
(24, 'sr', 'Serbian'),
(25, 'sv', 'Swedish'),
(26, 'tr', 'Turkish'),
(27, 'uk', 'Ukranian'),
(28, 'vi', 'Vietnamese'),
(29, 'zh-CN', 'Chinese Simplified'),
(30, 'zh-TW', 'Chinese Traditional'),
(31, 'bg', 'Bulgarian'),
(32, 'sk', 'Slovak'),
(33, 'mn', 'Mongolian'),
(34, 'si', 'Sinhala');

-- --------------------------------------------------------

--
-- Table structure for table `likelihoods`
--

CREATE TABLE `likelihoods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likelihoods`
--

INSERT INTO `likelihoods` (`id`, `name`) VALUES
(1, 'Remota'),
(2, 'Improbable'),
(3, 'Creible'),
(4, 'Probable'),
(5, 'Casi Certero');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'Location 1'),
(2, 'Location 2'),
(3, 'Location 3'),
(4, 'Location 4'),
(5, 'Location 5'),
(6, 'Location 6'),
(7, 'Location 7'),
(8, 'Location 8'),
(9, 'Location 9'),
(10, 'Location 10');

-- --------------------------------------------------------

--
-- Table structure for table `mgmt_reviews`
--

CREATE TABLE `mgmt_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `review` int(11) NOT NULL,
  `reviewer` int(11) NOT NULL,
  `next_step_id` bigint(20) UNSIGNED NOT NULL,
  `comments` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `next_review` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2022_02_16_001499_create_permission_groups_table', 1),
(2, '2022_02_16_001500_create_subgroups_table', 1),
(3, '2022_02_16_001501_create_permissions_table', 1),
(4, '2022_02_16_001503_create_permission_to_permission_groups_table', 1),
(5, '2022_02_16_001504_create_permission_to_users_table', 1),
(6, '2022_02_16_001509_create_roles_table', 1),
(7, '2022_02_16_001510_create_role_responsibilities_table', 1),
(8, '2022_02_16_001602_create_departments_table', 1),
(9, '2022_02_16_001603_create_jobs_table', 1),
(10, '2022_02_16_001700_create_users_table', 1),
(11, '2022_02_16_001702_add_manager_id_to_departments', 1),
(12, '2022_02_16_001703_add_user_id_to_permission_to_users', 1),
(13, '2022_02_16_001800_create_assessments_table', 1),
(14, '2022_02_16_001810_create_assessment_questions_table', 1),
(15, '2022_02_16_001811_create_contributing_risks_likelihood_table', 1),
(16, '2022_02_16_001812_create_scoring_methods_table', 1),
(17, '2022_02_16_001819_create_assessment_scorings_table', 1),
(18, '2022_02_16_001820_create_assessment_answers_table', 1),
(19, '2022_02_16_001830_create_asset_groups_table', 1),
(20, '2022_02_16_001840_create_assessment_answers_to_asset_groups_table', 1),
(21, '2022_02_16_001840_create_asset_values_table', 1),
(22, '2022_02_16_001840_create_locations_table', 1),
(23, '2022_02_16_001841_create_assets_table', 1),
(24, '2022_02_16_001850_create_assessment_answers_to_assets_table', 1),
(25, '2022_02_16_001851_create_contributing_risks_table', 1),
(26, '2022_02_16_001855_create_impacts_table', 1),
(27, '2022_02_16_001860_create_assessment_scoring_contributing_impacts_table', 1),
(28, '2022_02_16_091810_create_assets_asset_groups_table', 1),
(29, '2022_02_16_091811_create_projects_table', 1),
(30, '2022_02_16_091812_create_close_reasons_table', 1),
(31, '2022_02_16_091813_create_sources_table', 1),
(32, '2022_02_16_091814_create_categories_table', 1),
(33, '2022_02_16_091815_create_mitigation_efforts_table', 1),
(34, '2022_02_16_091815_create_planning_strategies_table', 1),
(35, '2022_02_16_091816_create_mitigations_table', 1),
(36, '2022_02_16_091818_create_risks_table', 1),
(37, '2022_02_16_091819_add_risk_id_to_mitigations_table', 1),
(38, '2022_02_16_091820_create_audit_logs_table', 1),
(39, '2022_02_16_091830_create_backups_table', 1),
(40, '2022_02_16_091860_create_closures_table', 1),
(41, '2022_02_16_091870_create_comments_table', 1),
(42, '2022_02_16_091880_create_compliance_files_table', 1),
(43, '2022_02_16_091890_create_contributing_risks_impact_table', 1),
(44, '2022_02_16_091905_create_control_classes_table', 1),
(45, '2022_02_16_091906_create_control_maturities_table', 1),
(46, '2022_02_16_091907_create_control_phases_table', 1),
(47, '2022_02_16_091908_create_control_priorities_table', 1),
(48, '2022_02_16_091909_create_likelihoods_table', 1),
(49, '2022_02_16_091910_create_custom_risk_model_values_table', 1),
(50, '2022_02_16_091911_create_cvss_scorings_table', 1),
(51, '2022_02_16_091912_create_data_classifications_table', 1),
(52, '2022_02_16_091913_create_date_formats_table', 1),
(53, '2022_02_16_091914_create_document_exceptions_table', 1),
(54, '2022_02_16_091915_create_document_exceptions_statuses_table', 1),
(55, '2022_02_16_091916_create_document_statuses_table', 1),
(56, '2022_02_16_091916_create_files_table', 1),
(57, '2022_02_16_091917_create_documents_table', 1),
(58, '2022_02_16_091918_create_dynamic_saved_selections_table', 1),
(59, '2022_02_16_091919_create_failed_login_attempts_table', 1),
(60, '2022_02_16_091920_create_families_table', 1),
(61, '2022_02_16_091921_create_fields_table', 1),
(62, '2022_02_16_091922_create_file_type_extensions_table', 1),
(63, '2022_02_16_091923_create_control_desired_maturities_table', 1),
(64, '2022_02_16_091923_create_control_owners_table', 1),
(65, '2022_02_16_091923_create_file_types_table', 1),
(66, '2022_02_16_091924_create_framework_controls_table', 1),
(67, '2022_02_16_091924_create_frameworks_table', 1),
(68, '2022_02_16_091925_create_framework_control_mappings_table', 1),
(69, '2022_02_16_091925_create_framework_control_tests_table', 1),
(70, '2022_02_16_091926_create_framework_control_test_audits_table', 1),
(71, '2022_02_16_091927_create_framework_control_test_comments_table', 1),
(72, '2022_02_16_091928_create_framework_control_test_results_table', 1),
(73, '2022_02_16_091929_create_framework_control_test_results_to_risks_table', 1),
(74, '2022_02_16_091931_create_control_types_table', 1),
(75, '2022_02_16_091931_create_framework_control_to_frameworks_table', 1),
(76, '2022_02_16_091932_create_framework_control_type_mappings_table', 1),
(77, '2022_02_16_091935_create_teams_table', 1),
(78, '2022_02_16_091936_create_items_to_teams_table', 1),
(79, '2022_02_16_091937_create_languages_table', 1),
(80, '2022_02_16_091939_create_next_steps_table', 1),
(81, '2022_02_16_091940_create_mgmt_reviews_table', 1),
(82, '2022_02_16_091941_create_mitigation_accept_users_table', 1),
(83, '2022_02_16_091943_create_mitigation_to_controls_table', 1),
(84, '2022_02_16_091944_create_mitigation_to_teams_table', 1),
(85, '2022_02_16_091947_create_password_resets_table', 1),
(86, '2022_02_16_091948_create_pending_risks_table', 1),
(87, '2022_02_16_091955_create_questionnaire_pending_risks_table', 1),
(88, '2022_02_16_091956_create_regulations_table', 1),
(89, '2022_02_16_091957_create_residual_risk_scoring_histories_table', 1),
(90, '2022_02_16_091958_create_reviews_table', 1),
(91, '2022_02_16_091959_create_review_levels_table', 1),
(92, '2022_02_16_092000_create_risk_functions_table', 1),
(93, '2022_02_16_092001_create_risk_groupings_table', 1),
(94, '2022_02_16_092002_create_risk_catalogs_table', 1),
(95, '2022_02_16_092003_create_risk_levels_table', 1),
(96, '2022_02_16_092004_create_risk_models_table', 1),
(97, '2022_02_16_092005_create_risk_scorings_table', 1),
(98, '2022_02_16_092006_create_risk_scoring_contributing_impacts_table', 1),
(99, '2022_02_16_092007_create_risk_scoring_histories_table', 1),
(100, '2022_02_16_092008_create_risk_to_additional_stakeholders_table', 1),
(101, '2022_02_16_092009_create_risk_to_locations_table', 1),
(102, '2022_02_16_092010_create_risk_to_teams_table', 1),
(103, '2022_02_16_092010_create_technologies_table', 1),
(104, '2022_02_16_092011_create_risk_to_technologies_table', 1),
(105, '2022_02_16_092013_create_risks_to_asset_groups_table', 1),
(106, '2022_02_16_092014_create_risks_to_assets_table', 1),
(107, '2022_02_16_092018_create_sessions_table', 1),
(108, '2022_02_16_092019_create_settings_table', 1),
(109, '2022_02_16_092021_create_statuses_table', 1),
(110, '2022_02_16_092022_create_tags_table', 1),
(111, '2022_02_16_092023_create_taggables_table', 1),
(112, '2022_02_16_092026_create_test_results_table', 1),
(113, '2022_02_16_092027_create_test_statuses_table', 1),
(114, '2022_02_16_092027_create_threat_groupings_table', 1),
(115, '2022_02_16_092028_create_threat_catalogs_table', 1),
(116, '2022_02_16_092031_create_user_pass_histories_table', 1),
(117, '2022_02_16_092032_create_user_pass_reuse_histories_table', 1),
(118, '2022_02_16_092033_create_user_to_teams_table', 1),
(119, '2022_02_16_092034_create_validation_files_table', 1),
(120, '2022_03_13_065913_create_tests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mitigations`
--

CREATE TABLE `mitigations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `planning_strategy` int(11) NOT NULL,
  `mitigation_effort` int(11) NOT NULL,
  `mitigation_cost` int(11) NOT NULL DEFAULT 1,
  `mitigation_owner` int(11) NOT NULL,
  `current_solution` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `security_requirements` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `security_recommendations` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitted_by` int(11) NOT NULL DEFAULT 1,
  `planning_date` date NOT NULL,
  `mitigation_percent` int(11) NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_accept_users`
--

CREATE TABLE `mitigation_accept_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_efforts`
--

CREATE TABLE `mitigation_efforts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `control_id` int(11) NOT NULL,
  `validation_details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation_owner` int(11) NOT NULL DEFAULT 0,
  `validation_mitigation_percent` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitigation_to_teams`
--

CREATE TABLE `mitigation_to_teams` (
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `next_steps`
--

CREATE TABLE `next_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `next_steps`
--

INSERT INTO `next_steps` (`id`, `name`) VALUES
(1, 'Aceptada Hasta Proxima Revision'),
(2, 'Considerado por Proyecto'),
(3, 'Presentar como un Problema de Produccion');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `username` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_risks`
--

CREATE TABLE `pending_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `assessment_answer_id` bigint(20) UNSIGNED NOT NULL,
  `subject` blob NOT NULL,
  `score` double(8,2) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `affected_assets` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subgroup_id` bigint(20) UNSIGNED NOT NULL,
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
(15, 'documentation.list', 'list', 3, NULL, NULL),
(16, 'documentation.view', 'view', 3, NULL, NULL),
(17, 'documentation.create', 'create', 3, NULL, NULL),
(18, 'documentation.update', 'update', 3, NULL, NULL),
(19, 'documentation.delete', 'delete', 3, NULL, NULL),
(20, 'documentation.print', 'print', 3, NULL, NULL),
(21, 'documentation.export', 'export', 3, NULL, NULL),
(22, 'exception.list', 'list', 4, NULL, NULL),
(23, 'exception.view', 'view', 4, NULL, NULL),
(24, 'exception.create', 'create', 4, NULL, NULL),
(25, 'exception.update', 'update', 4, NULL, NULL),
(26, 'exception.delete', 'delete', 4, NULL, NULL),
(27, 'exception.print', 'print', 4, NULL, NULL),
(28, 'exception.export', 'export', 4, NULL, NULL),
(29, 'riskmanagement.list', 'list', 5, NULL, NULL),
(30, 'riskmanagement.view', 'view', 5, NULL, NULL),
(31, 'riskmanagement.create', 'create', 5, NULL, NULL),
(32, 'riskmanagement.update', 'update', 5, NULL, NULL),
(33, 'riskmanagement.delete', 'delete', 5, NULL, NULL),
(34, 'riskmanagement.print', 'print', 5, NULL, NULL),
(35, 'riskmanagement.export', 'export', 5, NULL, NULL),
(36, 'projects.list', 'list', 6, NULL, NULL),
(37, 'projects.view', 'view', 6, NULL, NULL),
(38, 'projects.create', 'create', 6, NULL, NULL),
(39, 'projects.update', 'update', 6, NULL, NULL),
(40, 'projects.delete', 'delete', 6, NULL, NULL),
(41, 'projects.print', 'print', 6, NULL, NULL),
(42, 'projects.export', 'export', 6, NULL, NULL),
(43, 'compliance.list', 'list', 7, NULL, NULL),
(44, 'compliance.view', 'view', 7, NULL, NULL),
(45, 'compliance.create', 'create', 7, NULL, NULL),
(46, 'compliance.update', 'update', 7, NULL, NULL),
(47, 'compliance.delete', 'delete', 7, NULL, NULL),
(48, 'compliance.print', 'print', 7, NULL, NULL),
(49, 'compliance.export', 'export', 7, NULL, NULL),
(50, 'tests.list', 'list', 8, NULL, NULL),
(51, 'tests.view', 'view', 8, NULL, NULL),
(52, 'tests.create', 'create', 8, NULL, NULL),
(53, 'tests.update', 'update', 8, NULL, NULL),
(54, 'tests.delete', 'delete', 8, NULL, NULL),
(55, 'tests.print', 'print', 8, NULL, NULL),
(56, 'tests.export', 'export', 8, NULL, NULL),
(57, 'audits.list', 'list', 9, NULL, NULL),
(58, 'audits.view', 'view', 9, NULL, NULL),
(59, 'audits.create', 'create', 9, NULL, NULL),
(60, 'audits.update', 'update', 9, NULL, NULL),
(61, 'audits.delete', 'delete', 9, NULL, NULL),
(62, 'audits.print', 'print', 9, NULL, NULL),
(63, 'audits.export', 'export', 9, NULL, NULL),
(64, 'asset.list', 'list', 10, NULL, NULL),
(65, 'asset.view', 'view', 10, NULL, NULL),
(66, 'asset.create', 'create', 10, NULL, NULL),
(67, 'asset.update', 'update', 10, NULL, NULL),
(68, 'asset.delete', 'delete', 10, NULL, NULL),
(69, 'asset.print', 'print', 10, NULL, NULL),
(70, 'asset.export', 'export', 10, NULL, NULL),
(71, 'assessments.list', 'list', 11, NULL, NULL),
(72, 'assessments.view', 'view', 11, NULL, NULL),
(73, 'assessments.create', 'create', 11, NULL, NULL),
(74, 'assessments.update', 'update', 11, NULL, NULL),
(75, 'assessments.delete', 'delete', 11, NULL, NULL),
(76, 'assessments.print', 'print', 11, NULL, NULL),
(77, 'assessments.export', 'export', 11, NULL, NULL),
(78, 'roles.list', 'list', 12, NULL, NULL),
(79, 'roles.view', 'view', 12, NULL, NULL),
(80, 'roles.create', 'create', 12, NULL, NULL),
(81, 'roles.update', 'update', 12, NULL, NULL),
(82, 'roles.delete', 'delete', 12, NULL, NULL),
(83, 'roles.print', 'print', 12, NULL, NULL),
(84, 'roles.export', 'export', 12, NULL, NULL),
(85, 'values.list', 'list', 13, NULL, NULL),
(86, 'values.view', 'view', 13, NULL, NULL),
(87, 'values.create', 'create', 13, NULL, NULL),
(88, 'values.update', 'update', 13, NULL, NULL),
(89, 'values.delete', 'delete', 13, NULL, NULL),
(90, 'values.print', 'print', 13, NULL, NULL),
(91, 'values.export', 'export', 13, NULL, NULL),
(92, 'logs.list', 'list', 14, NULL, NULL),
(93, 'logs.view', 'view', 14, NULL, NULL),
(94, 'logs.create', 'create', 14, NULL, NULL),
(95, 'logs.update', 'update', 14, NULL, NULL),
(96, 'logs.delete', 'delete', 14, NULL, NULL),
(97, 'logs.print', 'print', 14, NULL, NULL),
(98, 'logs.export', 'export', 14, NULL, NULL),
(99, 'hierarchy.list', 'list', 15, NULL, NULL),
(100, 'hierarchy.view', 'view', 15, NULL, NULL),
(101, 'hierarchy.create', 'create', 15, NULL, NULL),
(102, 'hierarchy.update', 'update', 15, NULL, NULL),
(103, 'hierarchy.delete', 'delete', 15, NULL, NULL),
(104, 'hierarchy.print', 'print', 15, NULL, NULL),
(105, 'hierarchy.export', 'export', 15, NULL, NULL),
(106, 'department.list', 'list', 16, NULL, NULL),
(107, 'department.view', 'view', 16, NULL, NULL),
(108, 'department.create', 'create', 16, NULL, NULL),
(109, 'department.update', 'update', 16, NULL, NULL),
(110, 'department.delete', 'delete', 16, NULL, NULL),
(111, 'department.print', 'print', 16, NULL, NULL),
(112, 'department.export', 'export', 16, NULL, NULL),
(113, 'job.list', 'list', 17, NULL, NULL),
(114, 'job.view', 'view', 17, NULL, NULL),
(115, 'job.create', 'create', 17, NULL, NULL),
(116, 'job.update', 'update', 17, NULL, NULL),
(117, 'job.delete', 'delete', 17, NULL, NULL),
(118, 'job.print', 'print', 17, NULL, NULL),
(119, 'job.export', 'export', 17, NULL, NULL),
(120, 'employee.list', 'list', 18, NULL, NULL),
(121, 'employee.view', 'view', 18, NULL, NULL),
(122, 'employee.create', 'create', 18, NULL, NULL),
(123, 'employee.update', 'update', 18, NULL, NULL),
(124, 'employee.delete', 'delete', 18, NULL, NULL),
(125, 'employee.print', 'print', 18, NULL, NULL),
(126, 'employee.export', 'export', 18, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` blob NOT NULL,
  `order` int(11) NOT NULL
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
(6, 'Configure', '', 5),
(7, 'Hierarchy', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `permission_to_permission_groups`
--

CREATE TABLE `permission_to_permission_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `permission_group_id` bigint(20) UNSIGNED NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_to_users`
--

INSERT INTO `permission_to_users` (`id`, `permission_id`, `user_id`) VALUES
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
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1),
(38, 38, 1),
(39, 39, 1),
(40, 40, 1),
(41, 41, 1);

-- --------------------------------------------------------

--
-- Table structure for table `planning_strategies`
--

CREATE TABLE `planning_strategies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `consultant` int(11) DEFAULT NULL,
  `business_owner` int(11) DEFAULT NULL,
  `data_classification` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 999999,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_pending_risks`
--

CREATE TABLE `questionnaire_pending_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_tracking_id` int(11) NOT NULL,
  `questionnaire_scoring_id` int(11) NOT NULL,
  `subject` blob NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `asset` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regulations`
--

CREATE TABLE `regulations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regulations`
--

INSERT INTO `regulations` (`id`, `name`) VALUES
(1, 'PCI DSS 3.2'),
(2, 'Sarbanes-Oxley (SOX)'),
(3, 'HIPAA'),
(4, 'ISO 27001');

-- --------------------------------------------------------

--
-- Table structure for table `residual_risk_scoring_histories`
--

CREATE TABLE `residual_risk_scoring_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `residual_risk` double(8,2) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`) VALUES
(1, 'Aprobar Riesgo'),
(2, 'Rechazar Riesgo y Cerca');

-- --------------------------------------------------------

--
-- Table structure for table `review_levels`
--

CREATE TABLE `review_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_levels`
--

INSERT INTO `review_levels` (`id`, `value`, `name`) VALUES
(1, 90, 'Very High'),
(2, 90, 'High'),
(3, 180, 'Medium'),
(4, 360, 'Low'),
(5, 360, 'Insignificant');

-- --------------------------------------------------------

--
-- Table structure for table `risks`
--

CREATE TABLE `risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `regulation` int(11) DEFAULT NULL,
  `control_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `manager` int(11) NOT NULL,
  `assessment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `mgmt_review` int(11) NOT NULL DEFAULT 0,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `close_id` int(11) DEFAULT NULL,
  `submitted_by` int(11) NOT NULL DEFAULT 1,
  `risk_catalog_mapping` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `threat_catalog_mapping` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_group_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risks_to_assets`
--

CREATE TABLE `risks_to_assets` (
  `risk_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risks_to_asset_groups`
--

CREATE TABLE `risks_to_asset_groups` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `asset_group_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_catalogs`
--

CREATE TABLE `risk_catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_grouping_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk_function_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `value` decimal(3,1) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_levels`
--

INSERT INTO `risk_levels` (`value`, `name`, `color`, `display_name`) VALUES
('0.0', 'Low', 'yellow', 'Low'),
('4.0', 'Medium', 'orange', 'Medium'),
('7.0', 'High', 'orangered', 'High'),
('10.1', 'Very High', 'red', 'Very High');

-- --------------------------------------------------------

--
-- Table structure for table `risk_models`
--

CREATE TABLE `risk_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_models`
--

INSERT INTO `risk_models` (`id`, `name`) VALUES
(1, 'Probabilidad x Impacto + 2(Impacto)'),
(2, 'Probabilidad x Impacto + Impacto'),
(3, 'Probabilidad x Impacto'),
(4, 'Probabilidad x Impacto + Probabilidad'),
(5, 'Probabilidad x Impacto + 2(Probabilidad)'),
(6, 'Custom');

-- --------------------------------------------------------

--
-- Table structure for table `risk_scorings`
--

CREATE TABLE `risk_scorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scoring_method` int(11) NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `CLASSIC_likelihood` double(8,2) NOT NULL DEFAULT 5.00,
  `CLASSIC_impact` double(8,2) NOT NULL DEFAULT 5.00,
  `CVSS_AccessVector` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_AccessComplexity` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `CVSS_Authentication` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `CVSS_ConfImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_IntegImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_AvailImpact` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C',
  `CVSS_Exploitability` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_RemediationLevel` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ReportConfidence` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_CollateralDamagePotential` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_TargetDistribution` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_ConfidentialityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_IntegrityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `CVSS_AvailabilityRequirement` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ND',
  `DREAD_DamagePotential` int(11) NOT NULL DEFAULT 10,
  `DREAD_Reproducibility` int(11) NOT NULL DEFAULT 10,
  `DREAD_Exploitability` int(11) NOT NULL DEFAULT 10,
  `DREAD_AffectedUsers` int(11) NOT NULL DEFAULT 10,
  `DREAD_Discoverability` int(11) NOT NULL DEFAULT 10,
  `OWASP_SkillLevel` int(11) NOT NULL DEFAULT 10,
  `OWASP_Motive` int(11) NOT NULL DEFAULT 10,
  `OWASP_Opportunity` int(11) NOT NULL DEFAULT 10,
  `OWASP_Size` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfDiscovery` int(11) NOT NULL DEFAULT 10,
  `OWASP_EaseOfExploit` int(11) NOT NULL DEFAULT 10,
  `OWASP_Awareness` int(11) NOT NULL DEFAULT 10,
  `OWASP_IntrusionDetection` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfConfidentiality` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfIntegrity` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAvailability` int(11) NOT NULL DEFAULT 10,
  `OWASP_LossOfAccountability` int(11) NOT NULL DEFAULT 10,
  `OWASP_FinancialDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_ReputationDamage` int(11) NOT NULL DEFAULT 10,
  `OWASP_NonCompliance` int(11) NOT NULL DEFAULT 10,
  `OWASP_PrivacyViolation` int(11) NOT NULL DEFAULT 10,
  `Custom` double(8,2) NOT NULL DEFAULT 10.00,
  `Contributing_Likelihood` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_scoring_contributing_impacts`
--

CREATE TABLE `risk_scoring_contributing_impacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_scoring_id` bigint(20) UNSIGNED NOT NULL,
  `contributing_risk_id` bigint(20) UNSIGNED NOT NULL,
  `impact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_scoring_histories`
--

CREATE TABLE `risk_scoring_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `calculated_risk` double(8,2) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_additional_stakeholders`
--

CREATE TABLE `risk_to_additional_stakeholders` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_locations`
--

CREATE TABLE `risk_to_locations` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_teams`
--

CREATE TABLE `risk_to_teams` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk_to_technologies`
--

CREATE TABLE `risk_to_technologies` (
  `risk_id` bigint(20) UNSIGNED NOT NULL,
  `technology_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `role_responsibilities`
--

CREATE TABLE `role_responsibilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
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
(127, 2, 1),
(128, 2, 2),
(129, 2, 8),
(130, 2, 9),
(131, 2, 15),
(132, 2, 16),
(133, 2, 22),
(134, 2, 23),
(135, 2, 29),
(136, 2, 30),
(137, 2, 36),
(138, 2, 37),
(139, 2, 43),
(140, 2, 44),
(141, 2, 50),
(142, 2, 51),
(143, 2, 57),
(144, 2, 58),
(145, 2, 64),
(146, 2, 65),
(147, 2, 71),
(148, 2, 72),
(149, 2, 78),
(150, 2, 79),
(151, 2, 85),
(152, 2, 86),
(153, 2, 92),
(154, 2, 93),
(155, 2, 99),
(156, 2, 100),
(157, 2, 106),
(158, 2, 107),
(159, 2, 113),
(160, 2, 114),
(161, 2, 120),
(162, 2, 121);

-- --------------------------------------------------------

--
-- Table structure for table `scoring_methods`
--

CREATE TABLE `scoring_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scoring_methods`
--

INSERT INTO `scoring_methods` (`id`, `name`) VALUES
(1, 'Classic'),
(2, 'CVSS'),
(3, 'DREAD'),
(4, 'OWASP'),
(5, 'Custom'),
(6, 'Contributing Risk');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED DEFAULT NULL,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `access`, `data`) VALUES
('6bj9dpmvnspkije86u619fe0qs', 1642430487, 0x372e3731383637383738363935452b3330),
('8ok8njqcf5t63br81g8qr5p4p0', 1642430179, 0x494e46),
('midllcs1qvf6pf0h374i11ogrt', 1642432257, 0x494e46),
('rm67us66590qs0mf7fit2bbgpl', 1642431450, 0x494e46);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('alert_timeout', '5'),
('allow_owner_to_risk', '1'),
('allow_ownermanager_to_risk', '1'),
('allow_stakeholder_to_risk', '1'),
('allow_submitter_to_risk', '1'),
('allow_team_member_to_risk', '1'),
('auto_verify_new_assets', '0'),
('backup_auto', 'true'),
('backup_remove', '1'),
('backup_schedule', 'daily'),
('bootstrap_delivery_method', 'cdn'),
('closed_audit_status', '5'),
('content_security_policy', '0'),
('currency', '$'),
('db_version', '20211115-001'),
('debug_log_file', '/tmp/debug_log'),
('debug_logging', '0'),
('default_asset_valuation', '5'),
('default_current_maturity', '0'),
('default_date_format', 'MM/DD/YYYY'),
('default_desired_maturity', '3'),
('default_language', 'en'),
('default_risk_score', '10'),
('default_timezone', 'America/Chicago'),
('highcharts_delivery_method', 'cdn'),
('instance_id', 'WtrZ7UYyt7XdoRsTKftzHI9uv5mdXFKPCRcZf83ZoUYRu0pxXZ'),
('jquery_delivery_method', 'cdn'),
('max_upload_size', '5120000'),
('maximum_risk_subject_length', '300'),
('next_review_date_uses', 'InherentRisk'),
('NOTIFY_ADDITIONAL_STAKEHOLDERS', 'true'),
('pass_policy_alpha_required', '1'),
('pass_policy_attempt_lockout', '0'),
('pass_policy_attempt_lockout_time', '10'),
('pass_policy_digits_required', '1'),
('pass_policy_enabled', '1'),
('pass_policy_lower_required', '1'),
('pass_policy_max_age', '0'),
('pass_policy_min_age', '0'),
('pass_policy_min_chars', '8'),
('pass_policy_re_use_tracking', '0'),
('pass_policy_reuse_limit', '0'),
('pass_policy_special_required', '1'),
('pass_policy_upper_required', '1'),
('phpmailer_from_email', 'noreply@simplerisk.it'),
('phpmailer_from_name', 'SimpleRisk'),
('phpmailer_host', 'smtp1.example.com'),
('phpmailer_password', 'secret'),
('phpmailer_port', '587'),
('phpmailer_prepend', '[SIMPLERISK]'),
('phpmailer_replyto_email', 'noreply@simplerisk.it'),
('phpmailer_replyto_name', 'SimpleRisk'),
('phpmailer_smtpauth', 'false'),
('phpmailer_smtpautotls', 'true'),
('phpmailer_smtpsecure', 'none'),
('phpmailer_transport', 'sendmail'),
('phpmailer_username', 'user@example.com'),
('plan_projects_show_all', '0'),
('registration_registered', '0'),
('risk_appetite', '0'),
('risk_mapping_required', '0'),
('risk_model', '3'),
('session_absolute_timeout', '28800'),
('session_activity_timeout', '3600'),
('simplerisk_base_url', 'http://localhost:8000'),
('strict_user_validation', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE `sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`) VALUES
(1, 'Gente'),
(2, 'Proceso'),
(3, 'Sistema'),
(4, 'Externo');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Nuevo'),
(2, 'Mitigación de Planificación'),
(3, 'Gestión Comentado'),
(4, 'Cerrado'),
(5, 'Reabierto'),
(6, 'Sin Tratar'),
(7, 'Tratada');

-- --------------------------------------------------------

--
-- Table structure for table `subgroups`
--

CREATE TABLE `subgroups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subgroups`
--

INSERT INTO `subgroups` (`id`, `name`, `permission_group_id`, `created_at`, `updated_at`) VALUES
(1, 'Frameworks', 1, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(2, 'Controls', 1, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(3, 'Documentation', 1, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(4, 'Exception', 1, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(5, 'Risks', 2, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(6, 'Projects', 2, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(7, 'Compliance', 3, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(8, 'Tests', 3, '2022-03-31 12:28:05', '2022-03-31 12:28:05'),
(9, 'Audits', 3, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(10, 'Assets', 4, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(11, 'Assessments', 5, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(12, 'RoleManagement', 6, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(13, 'Add Values', 6, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(14, 'Audit Logs', 6, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(15, 'Hierarchy', 7, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(16, 'Department', 7, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(17, 'Job', 7, '2022-03-31 12:28:06', '2022-03-31 12:28:06'),
(18, 'Employee', 7, '2022-03-31 12:28:06', '2022-03-31 12:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taggables`
--

INSERT INTO `taggables` (`tag_id`, `taggable_id`, `taggable_type`) VALUES
(1, 1, 'App\\Models\\Asset'),
(2, 1, 'App\\Models\\Asset'),
(3, 1, 'App\\Models\\Asset'),
(4, 1, 'App\\Models\\Asset'),
(5, 1, 'App\\Models\\Asset'),
(2, 2, 'App\\Models\\Asset'),
(3, 3, 'App\\Models\\Asset'),
(4, 4, 'App\\Models\\Asset'),
(5, 5, 'App\\Models\\Asset'),
(6, 6, 'App\\Models\\Asset'),
(7, 7, 'App\\Models\\Asset'),
(8, 8, 'App\\Models\\Asset'),
(9, 9, 'App\\Models\\Asset'),
(10, 10, 'App\\Models\\Asset');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'Tag 1'),
(10, 'Tag 10'),
(2, 'Tag 2'),
(3, 'Tag 3'),
(4, 'Tag 4'),
(5, 'Tag 5'),
(6, 'Tag 6'),
(7, 'Tag 7'),
(8, 'Tag 8'),
(9, 'Tag 9');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`) VALUES
(1, 'Team 1'),
(2, 'Team 2'),
(3, 'Team 3'),
(4, 'Team 4'),
(5, 'Team 5'),
(6, 'Team 6'),
(7, 'Team 7'),
(8, 'Team 8'),
(9, 'Team 9'),
(10, 'Team 10'),
(11, 'Team 11'),
(12, 'Team 12'),
(13, 'Team 13'),
(14, 'Team 14'),
(15, 'Team 15'),
(16, 'Team 16'),
(17, 'Team 17'),
(18, 'Team 18'),
(19, 'Team 19'),
(20, 'Team 20');

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `name`, `background_class`) VALUES
(1, 'Pass', 'green-background'),
(2, 'Inconclusive', 'white-background'),
(3, 'Fail', 'red-background');

-- --------------------------------------------------------

--
-- Table structure for table `test_statuses`
--

CREATE TABLE `test_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `threat_grouping_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `lockout` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'simplerisk',
  `username` blob NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` blob NOT NULL,
  `salt` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` blob NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_password_change_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `multi_factor` int(11) NOT NULL DEFAULT 1,
  `change_password` tinyint(1) NOT NULL DEFAULT 0,
  `custom_display_settings` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `custom_plan_mitigation_display_settings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n',
  `custom_perform_reviews_display_settings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["submission_date","1"]],"mitigation_colums":[["mitigation_planned","1"]],"review_colums":[["management_review","1"]]}\n',
  `custom_reviewregularly_display_settings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{"risk_colums":[["id","1"],["risk_status","1"],["subject","1"],["calculated_risk","1"],["days_open","1"]],"review_colums":[["management_review","0"],["review_date","0"],["next_step","0"],["next_review_date","1"],["comments","0"]]}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `enabled`, `lockout`, `type`, `username`, `name`, `email`, `salt`, `password`, `last_login`, `last_password_change_date`, `role_id`, `lang`, `admin`, `multi_factor`, `change_password`, `custom_display_settings`, `department_id`, `manager_id`, `job_id`, `custom_plan_mitigation_display_settings`, `custom_perform_reviews_display_settings`, `custom_reviewregularly_display_settings`) VALUES
(1, 1, 0, 'simplerisk', 0x343138323936373139373236, 'Admin', 0x312e35363131383834373232303838452b3338, 'qCJpnAe5S6k61Pqh3SFG', 0x342e34313339353637303138353036452b313433, '2022-01-17 09:00:33', '2017-01-08 07:58:20', 1, NULL, 1, 1, 0, '[\\\"id\\\",\\\"subject\\\",\\\"calculated_risk\\\",\\\"submission_date\\\",\\\"mitigation_planned\\\",\\\"management_review\\\"]', NULL, NULL, 1, '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"submission_date\\\",\\\"1\\\"]],\\\"mitigation_colums\\\":[[\\\"mitigation_planned\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"1\\\"]]}\\n', '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"submission_date\\\",\\\"1\\\"]],\\\"mitigation_colums\\\":[[\\\"mitigation_planned\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"1\\\"]]}\\n', '{\\\"risk_colums\\\":[[\\\"id\\\",\\\"1\\\"],[\\\"risk_status\\\",\\\"1\\\"],[\\\"subject\\\",\\\"1\\\"],[\\\"calculated_risk\\\",\\\"1\\\"],[\\\"days_open\\\",\\\"1\\\"]],\\\"review_colums\\\":[[\\\"management_review\\\",\\\"0\\\"],[\\\"review_date\\\",\\\"0\\\"],[\\\"next_step\\\",\\\"0\\\"],[\\\"next_review_date\\\",\\\"1\\\"],[\\\"comments\\\",\\\"0\\\"]]}'),
(2, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير الرئيس التنفيذى', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 1, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(3, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير اﻹدارة العامة ﻷمن المعلومات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 2, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(4, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير نائب المدير العام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 3, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(5, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المكتب اﻹدارى', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 4, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(6, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير الحوكمة والمخاطر والالتزام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 5, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(7, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المراقبة اﻷمنية والاستجابة والتحليل', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 6, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(8, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير إدارة الحلول اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 7, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(9, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المعمارية والتخطيط', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 8, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(10, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير الحوكمة', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:26', 1, NULL, 0, 1, 0, '', 9, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(11, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المخاطر', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 10, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(12, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير الالتزام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 11, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(13, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المراقبة اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 12, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(14, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير التحليل الرقمى والاستجابة للحوادث', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 13, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(15, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المعلومات الاستخباراتية والتهديدات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 14, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(16, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير تحليل التهديدات والثغرات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 15, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(17, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير إدارة الضوابط التقنية اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 16, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(18, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير تطوير واختبار الحلول اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:27', 1, NULL, 0, 1, 0, '', 17, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(19, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير إدارة الهويات والصلاحيات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 18, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(20, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير التخطيط والتطوير', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 19, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(21, 1, 0, 'simplerisk', 0x343138323936373139373236, 'مدير المعمارية اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 20, NULL, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(22, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى الرئيس التنفيذى', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 1, 2, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(23, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى الرئيس التنفيذى', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 1, 2, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(24, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى اﻹدارة العامة ﻷمن المعلومات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 2, 3, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(25, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى اﻹدارة العامة ﻷمن المعلومات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 2, 3, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(26, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى نائب المدير العام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 3, 4, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(27, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى نائب المدير العام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 3, 4, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(28, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المكتب اﻹدارى', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 4, 5, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(29, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المكتب اﻹدارى', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 4, 5, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(30, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى الحوكمة والمخاطر والالتزام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 5, 6, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(31, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى الحوكمة والمخاطر والالتزام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 5, 6, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(32, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المراقبة اﻷمنية والاستجابة والتحليل', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 6, 7, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(33, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المراقبة اﻷمنية والاستجابة والتحليل', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 6, 7, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(34, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى إدارة الحلول اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 7, 8, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(35, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى إدارة الحلول اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:28', 1, NULL, 0, 1, 0, '', 7, 8, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(36, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المعمارية والتخطيط', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 8, 9, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(37, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المعمارية والتخطيط', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 8, 9, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(38, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى الحوكمة', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 9, 10, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(39, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى الحوكمة', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 9, 10, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(40, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المخاطر', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 10, 11, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(41, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المخاطر', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 10, 11, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(42, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى الالتزام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 11, 12, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(43, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى الالتزام', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 11, 12, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(44, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المراقبة اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 12, 13, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(45, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المراقبة اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 12, 13, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(46, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى التحليل الرقمى والاستجابة للحوادث', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 13, 14, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(47, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى التحليل الرقمى والاستجابة للحوادث', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 13, 14, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(48, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المعلومات الاستخباراتية والتهديدات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 14, 15, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}');
INSERT INTO `users` (`id`, `enabled`, `lockout`, `type`, `username`, `name`, `email`, `salt`, `password`, `last_login`, `last_password_change_date`, `role_id`, `lang`, `admin`, `multi_factor`, `change_password`, `custom_display_settings`, `department_id`, `manager_id`, `job_id`, `custom_plan_mitigation_display_settings`, `custom_perform_reviews_display_settings`, `custom_reviewregularly_display_settings`) VALUES
(49, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المعلومات الاستخباراتية والتهديدات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 14, 15, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(50, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى تحليل التهديدات والثغرات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 15, 16, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(51, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى تحليل التهديدات والثغرات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 15, 16, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(52, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى إدارة الضوابط التقنية اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 16, 17, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(53, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى إدارة الضوابط التقنية اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:29', 1, NULL, 0, 1, 0, '', 16, 17, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(54, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى تطوير واختبار الحلول اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 17, 18, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(55, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى تطوير واختبار الحلول اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 17, 18, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(56, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى إدارة الهويات والصلاحيات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 18, 19, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(57, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى إدارة الهويات والصلاحيات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 18, 19, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(58, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى التخطيط والتطوير', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 19, 20, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(59, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى التخطيط والتطوير', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 19, 20, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(60, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [2] فى المعمارية اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 20, 21, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(61, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [3] فى المعمارية اﻷمنية', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 20, 21, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}'),
(62, 1, 0, 'simplerisk', 0x343138323936373139373236, 'موظف  [4] فى اﻹدارة العامة ﻷمن المعلومات', 0x312e35363131383834373232303838452b3338, NULL, 0x342e34313339353637303138353036452b313433, NULL, '2022-03-31 11:28:30', 1, NULL, 0, 1, 0, '', 2, 24, 2, '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"submission_date\",\"1\"]],\"mitigation_colums\":[[\"mitigation_planned\",\"1\"]],\"review_colums\":[[\"management_review\",\"1\"]]}\n', '{\"risk_colums\":[[\"id\",\"1\"],[\"risk_status\",\"1\"],[\"subject\",\"1\"],[\"calculated_risk\",\"1\"],[\"days_open\",\"1\"]],\"review_colums\":[[\"management_review\",\"0\"],[\"review_date\",\"0\"],[\"next_step\",\"0\"],[\"next_review_date\",\"1\"],[\"comments\",\"0\"]]}');

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_histories`
--

CREATE TABLE `user_pass_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salt` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` blob NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_reuse_histories`
--

CREATE TABLE `user_pass_reuse_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `password` blob NOT NULL,
  `counts` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_to_teams`
--

CREATE TABLE `user_to_teams` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_to_teams`
--

INSERT INTO `user_to_teams` (`user_id`, `team_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `validation_files`
--

CREATE TABLE `validation_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mitigation_id` bigint(20) UNSIGNED NOT NULL,
  `control_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL,
  `content` longblob NOT NULL
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
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
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
  ADD UNIQUE KEY `impact_likelihood_unique` (`impact`,`likelihood`);

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
  ADD KEY `departments_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_file_id_foreign` (`file_id`);

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
-- Indexes for table `document_statuses`
--
ALTER TABLE `document_statuses`
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
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `framework_controls_control_phase_foreign` (`control_phase`);

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
  ADD KEY `framework_control_tests_framework_control_id_foreign` (`framework_control_id`);

--
-- Indexes for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `framework_control_test_audits_test_id_foreign` (`test_id`),
  ADD KEY `framework_control_test_audits_framework_control_id_foreign` (`framework_control_id`);

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
  ADD KEY `framework_control_test_results_test_audit_id_foreign` (`test_audit_id`);

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
  ADD KEY `risks_mitigation_id_foreign` (`mitigation_id`),
  ADD KEY `risks_project_id_foreign` (`project_id`),
  ADD KEY `status` (`status`),
  ADD KEY `regulation` (`regulation`),
  ADD KEY `source` (`source`),
  ADD KEY `category` (`category`),
  ADD KEY `owner` (`owner`),
  ADD KEY `manager` (`manager`),
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
-- Indexes for table `risk_models`
--
ALTER TABLE `risk_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk_scorings`
--
ALTER TABLE `risk_scorings`
  ADD PRIMARY KEY (`id`),
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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`name`);

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
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_manager_id_foreign` (`manager_id`),
  ADD KEY `users_job_id_foreign` (`job_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `assessment_scorings`
--
ALTER TABLE `assessment_scorings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assessment_scoring_contributing_impacts`
--
ALTER TABLE `assessment_scoring_contributing_impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `asset_groups`
--
ALTER TABLE `asset_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_values`
--
ALTER TABLE `asset_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `close_reasons`
--
ALTER TABLE `close_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `closures`
--
ALTER TABLE `closures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_files`
--
ALTER TABLE `compliance_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributing_risks`
--
ALTER TABLE `contributing_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contributing_risks_likelihoods`
--
ALTER TABLE `contributing_risks_likelihoods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `control_classes`
--
ALTER TABLE `control_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `control_desired_maturities`
--
ALTER TABLE `control_desired_maturities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_maturities`
--
ALTER TABLE `control_maturities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `control_owners`
--
ALTER TABLE `control_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_phases`
--
ALTER TABLE `control_phases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_priorities`
--
ALTER TABLE `control_priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_types`
--
ALTER TABLE `control_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cvss_scorings`
--
ALTER TABLE `cvss_scorings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `data_classifications`
--
ALTER TABLE `data_classifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_exceptions`
--
ALTER TABLE `document_exceptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_exceptions_statuses`
--
ALTER TABLE `document_exceptions_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_statuses`
--
ALTER TABLE `document_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dynamic_saved_selections`
--
ALTER TABLE `dynamic_saved_selections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_types`
--
ALTER TABLE `file_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `file_type_extensions`
--
ALTER TABLE `file_type_extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `frameworks`
--
ALTER TABLE `frameworks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `framework_controls`
--
ALTER TABLE `framework_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `framework_control_test_comments`
--
ALTER TABLE `framework_control_test_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `framework_control_test_results`
--
ALTER TABLE `framework_control_test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `framework_control_test_results_to_risks`
--
ALTER TABLE `framework_control_test_results_to_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `framework_control_type_mappings`
--
ALTER TABLE `framework_control_type_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `likelihoods`
--
ALTER TABLE `likelihoods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `mitigations`
--
ALTER TABLE `mitigations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mitigation_efforts`
--
ALTER TABLE `mitigation_efforts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `next_steps`
--
ALTER TABLE `next_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pending_risks`
--
ALTER TABLE `pending_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permission_to_permission_groups`
--
ALTER TABLE `permission_to_permission_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permission_to_users`
--
ALTER TABLE `permission_to_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `planning_strategies`
--
ALTER TABLE `planning_strategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionnaire_pending_risks`
--
ALTER TABLE `questionnaire_pending_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regulations`
--
ALTER TABLE `regulations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `residual_risk_scoring_histories`
--
ALTER TABLE `residual_risk_scoring_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_levels`
--
ALTER TABLE `review_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risks`
--
ALTER TABLE `risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `risk_functions`
--
ALTER TABLE `risk_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `risk_groupings`
--
ALTER TABLE `risk_groupings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `risk_models`
--
ALTER TABLE `risk_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `risk_scorings`
--
ALTER TABLE `risk_scorings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_scoring_contributing_impacts`
--
ALTER TABLE `risk_scoring_contributing_impacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk_scoring_histories`
--
ALTER TABLE `risk_scoring_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `scoring_methods`
--
ALTER TABLE `scoring_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subgroups`
--
ALTER TABLE `subgroups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test_statuses`
--
ALTER TABLE `test_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `threat_catalogs`
--
ALTER TABLE `threat_catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `threat_groupings`
--
ALTER TABLE `threat_groupings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user_pass_histories`
--
ALTER TABLE `user_pass_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pass_reuse_histories`
--
ALTER TABLE `user_pass_reuse_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `validation_files`
--
ALTER TABLE `validation_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `closures`
--
ALTER TABLE `closures`
  ADD CONSTRAINT `closures_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `closures_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `contributing_risks_impacts`
--
ALTER TABLE `contributing_risks_impacts`
  ADD CONSTRAINT `contributing_risks_impacts_contributing_risks_id_foreign` FOREIGN KEY (`contributing_risks_id`) REFERENCES `contributing_risks` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

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
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `framework_controls`
--
ALTER TABLE `framework_controls`
  ADD CONSTRAINT `framework_controls_control_class_foreign` FOREIGN KEY (`control_class`) REFERENCES `control_classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_maturity_foreign` FOREIGN KEY (`control_maturity`) REFERENCES `control_maturities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_owner_foreign` FOREIGN KEY (`control_owner`) REFERENCES `control_owners` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_phase_foreign` FOREIGN KEY (`control_phase`) REFERENCES `control_phases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_control_priority_foreign` FOREIGN KEY (`control_priority`) REFERENCES `control_priorities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_desired_maturity_foreign` FOREIGN KEY (`desired_maturity`) REFERENCES `control_desired_maturities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `framework_controls_family_foreign` FOREIGN KEY (`family`) REFERENCES `families` (`id`);

--
-- Constraints for table `framework_control_mappings`
--
ALTER TABLE `framework_control_mappings`
  ADD CONSTRAINT `framework_control_mappings_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `framework_control_mappings_framework_id_foreign` FOREIGN KEY (`framework_id`) REFERENCES `frameworks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_control_tests`
--
ALTER TABLE `framework_control_tests`
  ADD CONSTRAINT `framework_control_tests_framework_control_id_foreign` FOREIGN KEY (`framework_control_id`) REFERENCES `framework_controls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `framework_control_test_audits`
--
ALTER TABLE `framework_control_test_audits`
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
  ADD CONSTRAINT `framework_control_test_results_test_audit_id_foreign` FOREIGN KEY (`test_audit_id`) REFERENCES `framework_control_test_audits` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `items_to_teams`
--
ALTER TABLE `items_to_teams`
  ADD CONSTRAINT `items_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `mgmt_reviews`
--
ALTER TABLE `mgmt_reviews`
  ADD CONSTRAINT `mgmt_reviews_next_step_id_foreign` FOREIGN KEY (`next_step_id`) REFERENCES `next_steps` (`id`),
  ADD CONSTRAINT `mgmt_reviews_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `mitigations`
--
ALTER TABLE `mitigations`
  ADD CONSTRAINT `mitigations_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `mitigation_accept_users`
--
ALTER TABLE `mitigation_accept_users`
  ADD CONSTRAINT `mitigation_accept_users_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `mitigation_accept_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `mitigation_to_controls`
--
ALTER TABLE `mitigation_to_controls`
  ADD CONSTRAINT `mitigation_to_controls_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`);

--
-- Constraints for table `mitigation_to_teams`
--
ALTER TABLE `mitigation_to_teams`
  ADD CONSTRAINT `mitigation_to_teams_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`),
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
  ADD CONSTRAINT `residual_risk_scoring_histories_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `risks`
--
ALTER TABLE `risks`
  ADD CONSTRAINT `risks_mitigation_id_foreign` FOREIGN KEY (`mitigation_id`) REFERENCES `mitigations` (`id`),
  ADD CONSTRAINT `risks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `risks_to_assets`
--
ALTER TABLE `risks_to_assets`
  ADD CONSTRAINT `risks_to_assets_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `risks_to_assets_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `risks_to_asset_groups`
--
ALTER TABLE `risks_to_asset_groups`
  ADD CONSTRAINT `risks_to_asset_groups_asset_group_id_foreign` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`),
  ADD CONSTRAINT `risks_to_asset_groups_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `risk_catalogs`
--
ALTER TABLE `risk_catalogs`
  ADD CONSTRAINT `risk_catalogs_risk_function_id_foreign` FOREIGN KEY (`risk_function_id`) REFERENCES `risk_functions` (`id`),
  ADD CONSTRAINT `risk_catalogs_risk_grouping_id_foreign` FOREIGN KEY (`risk_grouping_id`) REFERENCES `risk_groupings` (`id`);

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
  ADD CONSTRAINT `risk_scoring_histories_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `risk_to_additional_stakeholders`
--
ALTER TABLE `risk_to_additional_stakeholders`
  ADD CONSTRAINT `risk_to_additional_stakeholders_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `risk_to_additional_stakeholders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `risk_to_locations`
--
ALTER TABLE `risk_to_locations`
  ADD CONSTRAINT `risk_to_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `risk_to_locations_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Constraints for table `risk_to_teams`
--
ALTER TABLE `risk_to_teams`
  ADD CONSTRAINT `risk_to_teams_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `risk_to_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `risk_to_technologies`
--
ALTER TABLE `risk_to_technologies`
  ADD CONSTRAINT `risk_to_technologies_risk_id_foreign` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `risk_to_technologies_technology_id_foreign` FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`id`);

--
-- Constraints for table `role_responsibilities`
--
ALTER TABLE `role_responsibilities`
  ADD CONSTRAINT `role_responsibilities_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_responsibilities_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `subgroups`
--
ALTER TABLE `subgroups`
  ADD CONSTRAINT `subgroups_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
