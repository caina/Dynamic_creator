/*
 Navicat Premium Data Transfer

 Source Server         : ibr
 Source Server Type    : MySQL
 Source Server Version : 50532
 Source Host           : mysql.connectivearts.com.br
 Source Database       : connectivearts05

 Target Server Type    : MySQL
 Target Server Version : 50532
 File Encoding         : utf-8

 Date: 08/08/2013 09:54:59 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `bf_activities`
-- ----------------------------
DROP TABLE IF EXISTS `bf_activities`;
CREATE TABLE `bf_activities` (
  `activity_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `activity` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted` tinyint(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_activities`
-- ----------------------------
BEGIN;
INSERT INTO `bf_activities` VALUES ('1', '1', 'logged in from: 187.54.154.67', 'users', '2013-08-01 16:41:12', '0'), ('2', '1', 'logged in from: 179.187.27.21', 'users', '2013-08-02 14:45:37', '0'), ('3', '1', 'Created Module: itinerary : 179.187.27.21', 'modulebuilder', '2013-08-02 15:37:39', '0'), ('4', '1', 'Migrate Type: itinerary_ to Version: 1 from: 179.187.27.21', 'migrations', '2013-08-02 15:49:32', '0'), ('5', '1', 'modified user: douglas@mbr.mx', 'users', '2013-08-02 15:50:27', '0'), ('6', '1', 'Deleted Module: itinerary : 179.187.27.21', 'builder', '2013-08-02 16:06:58', '0'), ('7', '1', 'Created Module: Guide : 179.187.27.21', 'modulebuilder', '2013-08-02 16:09:25', '0'), ('8', '1', 'Migrate Type: guide_ to Version: 2 from: 179.187.27.21', 'migrations', '2013-08-02 16:09:32', '0'), ('9', '1', 'logged in from: 179.187.26.94', 'users', '2013-08-03 14:40:53', '0'), ('10', '1', 'logged out from: 179.187.26.94', 'users', '2013-08-03 14:42:17', '0'), ('11', '1', 'logged in from: 177.156.58.101', 'users', '2013-08-05 08:46:21', '0'), ('12', '1', 'Created record with ID: 3 : 177.134.56.229', 'guide', '2013-08-05 18:32:41', '0'), ('13', '1', 'Created record with ID: 4 : 177.134.56.229', 'guide', '2013-08-05 18:32:53', '0'), ('14', '1', 'logged in from: 187.113.219.174', 'users', '2013-08-06 08:57:56', '0'), ('15', '1', 'logged in from: 177.204.159.210', 'users', '2013-08-06 13:37:50', '0'), ('16', '1', 'Created record with ID: 5 : 177.204.159.210', 'guide', '2013-08-06 13:38:08', '0'), ('17', '1', 'Updated record with ID: 4 : 177.204.159.210', 'guide', '2013-08-06 17:44:30', '0'), ('18', '1', 'Updated record with ID: 4 : 177.204.159.210', 'guide', '2013-08-06 17:44:37', '0'), ('19', '1', 'Updated record with ID: 4 : 177.204.159.210', 'guide', '2013-08-06 17:44:46', '0'), ('20', '1', 'Updated record with ID: 5 : 177.204.159.210', 'guide', '2013-08-06 17:48:29', '0'), ('21', '1', 'Created record with ID: 6 : 177.204.159.210', 'guide', '2013-08-06 17:48:38', '0'), ('22', '1', 'Updated record with ID: 6 : 177.204.159.210', 'guide', '2013-08-06 17:48:51', '0'), ('23', '1', 'Updated record with ID: 6 : 177.204.159.210', 'guide', '2013-08-06 17:51:28', '0'), ('24', '1', 'Created record with ID: 7 : 177.204.159.210', 'guide', '2013-08-06 18:31:30', '0'), ('25', '1', 'Created record with ID: 8 : 177.204.159.210', 'guide', '2013-08-06 18:31:36', '0'), ('26', '1', 'Created record with ID: 9 : 177.204.159.210', 'guide', '2013-08-06 18:31:50', '0'), ('27', '1', 'Updated record with ID: 8 : 177.204.159.210', 'guide', '2013-08-06 18:31:56', '0'), ('28', '1', 'Updated record with ID: 8 : 177.204.159.210', 'guide', '2013-08-06 18:32:07', '0'), ('29', '1', 'Updated record with ID: 8 : 177.204.159.210', 'guide', '2013-08-06 18:32:15', '0'), ('30', '1', 'Created record with ID: 10 : 187.113.246.58', 'guide', '2013-08-07 10:06:01', '0'), ('31', '1', 'logged out from: 187.113.246.58', 'users', '2013-08-07 10:34:35', '0'), ('32', '1', 'logged in from: 187.113.246.58', 'users', '2013-08-07 10:34:48', '0'), ('33', '1', 'logged in from: 187.113.246.58', 'users', '2013-08-07 10:39:05', '0');
COMMIT;

-- ----------------------------
--  Table structure for `bf_email_queue`
-- ----------------------------
DROP TABLE IF EXISTS `bf_email_queue`;
CREATE TABLE `bf_email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_email` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `alt_message` text,
  `max_attempts` int(11) NOT NULL DEFAULT '3',
  `attempts` int(11) NOT NULL DEFAULT '0',
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `date_published` datetime DEFAULT NULL,
  `last_attempt` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bf_guide`
-- ----------------------------
DROP TABLE IF EXISTS `bf_guide`;
CREATE TABLE `bf_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `user_id` bigint(11) NOT NULL,
  `foto_capa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_guide`
-- ----------------------------
BEGIN;
INSERT INTO `bf_guide` VALUES ('10', 'aaa', '1', '');
COMMIT;

-- ----------------------------
--  Table structure for `bf_login_attempts`
-- ----------------------------
DROP TABLE IF EXISTS `bf_login_attempts`;
CREATE TABLE `bf_login_attempts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `login` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bf_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `bf_permissions`;
CREATE TABLE `bf_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') DEFAULT 'active',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_permissions`
-- ----------------------------
BEGIN;
INSERT INTO `bf_permissions` VALUES ('1', 'Site.Signin.Allow', 'Allow users to login to the site', 'active'), ('2', 'Site.Content.View', 'Allow users to view the Content Context', 'active'), ('3', 'Site.Reports.View', 'Allow users to view the Reports Context', 'active'), ('4', 'Site.Settings.View', 'Allow users to view the Settings Context', 'active'), ('5', 'Site.Developer.View', 'Allow users to view the Developer Context', 'active'), ('6', 'Bonfire.Roles.Manage', 'Allow users to manage the user Roles', 'active'), ('7', 'Bonfire.Users.Manage', 'Allow users to manage the site Users', 'active'), ('8', 'Bonfire.Users.View', 'Allow users access to the User Settings', 'active'), ('9', 'Bonfire.Users.Add', 'Allow users to add new Users', 'active'), ('10', 'Bonfire.Database.Manage', 'Allow users to manage the Database settings', 'active'), ('11', 'Bonfire.Emailer.Manage', 'Allow users to manage the Emailer settings', 'active'), ('12', 'Bonfire.Logs.View', 'Allow users access to the Log details', 'active'), ('13', 'Bonfire.Logs.Manage', 'Allow users to manage the Log files', 'active'), ('14', 'Bonfire.Emailer.View', 'Allow users access to the Emailer settings', 'active'), ('15', 'Site.Signin.Offline', 'Allow users to login to the site when the site is offline', 'active'), ('16', 'Bonfire.Permissions.View', 'Allow access to view the Permissions menu unders Settings Context', 'active'), ('17', 'Bonfire.Permissions.Manage', 'Allow access to manage the Permissions in the system', 'active'), ('18', 'Bonfire.Roles.Delete', 'Allow users to delete user Roles', 'active'), ('19', 'Bonfire.Modules.Add', 'Allow creation of modules with the builder.', 'active'), ('20', 'Bonfire.Modules.Delete', 'Allow deletion of modules.', 'active'), ('21', 'Permissions.Administrator.Manage', 'To manage the access control permissions for the Administrator role.', 'active'), ('22', 'Permissions.Editor.Manage', 'To manage the access control permissions for the Editor role.', 'active'), ('24', 'Permissions.User.Manage', 'To manage the access control permissions for the User role.', 'active'), ('25', 'Permissions.Developer.Manage', 'To manage the access control permissions for the Developer role.', 'active'), ('27', 'Activities.Own.View', 'To view the users own activity logs', 'active'), ('28', 'Activities.Own.Delete', 'To delete the users own activity logs', 'active'), ('29', 'Activities.User.View', 'To view the user activity logs', 'active'), ('30', 'Activities.User.Delete', 'To delete the user activity logs, except own', 'active'), ('31', 'Activities.Module.View', 'To view the module activity logs', 'active'), ('32', 'Activities.Module.Delete', 'To delete the module activity logs', 'active'), ('33', 'Activities.Date.View', 'To view the users own activity logs', 'active'), ('34', 'Activities.Date.Delete', 'To delete the dated activity logs', 'active'), ('35', 'Bonfire.UI.Manage', 'Manage the Bonfire UI settings', 'active'), ('36', 'Bonfire.Settings.View', 'To view the site settings page.', 'active'), ('37', 'Bonfire.Settings.Manage', 'To manage the site settings.', 'active'), ('38', 'Bonfire.Activities.View', 'To view the Activities menu.', 'active'), ('39', 'Bonfire.Database.View', 'To view the Database menu.', 'active'), ('40', 'Bonfire.Migrations.View', 'To view the Migrations menu.', 'active'), ('41', 'Bonfire.Builder.View', 'To view the Modulebuilder menu.', 'active'), ('42', 'Bonfire.Roles.View', 'To view the Roles menu.', 'active'), ('43', 'Bonfire.Sysinfo.View', 'To view the System Information page.', 'active'), ('44', 'Bonfire.Translate.Manage', 'To manage the Language Translation.', 'active'), ('45', 'Bonfire.Translate.View', 'To view the Language Translate menu.', 'active'), ('46', 'Bonfire.UI.View', 'To view the UI/Keyboard Shortcut menu.', 'active'), ('47', 'Bonfire.Update.Manage', 'To manage the Bonfire Update.', 'active'), ('48', 'Bonfire.Update.View', 'To view the Developer Update menu.', 'active'), ('49', 'Bonfire.Profiler.View', 'To view the Console Profiler Bar.', 'active'), ('50', 'Bonfire.Roles.Add', 'To add New Roles', 'active'), ('51', 'Site.Roteiros.View', 'Allow user to view the Roteiros Context.', 'active'), ('56', 'Guide.Roteiros.View', '', 'active'), ('57', 'Guide.Roteiros.Create', '', 'active'), ('58', 'Guide.Roteiros.Edit', '', 'active'), ('59', 'Guide.Roteiros.Delete', '', 'active');
COMMIT;

-- ----------------------------
--  Table structure for `bf_role_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `bf_role_permissions`;
CREATE TABLE `bf_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_role_permissions`
-- ----------------------------
BEGIN;
INSERT INTO `bf_role_permissions` VALUES ('1', '1'), ('1', '2'), ('1', '3'), ('1', '4'), ('1', '5'), ('1', '6'), ('1', '7'), ('1', '8'), ('1', '9'), ('1', '10'), ('1', '11'), ('1', '12'), ('1', '13'), ('1', '14'), ('1', '15'), ('1', '16'), ('1', '17'), ('1', '18'), ('1', '19'), ('1', '20'), ('1', '21'), ('1', '22'), ('1', '24'), ('1', '25'), ('1', '27'), ('1', '28'), ('1', '29'), ('1', '30'), ('1', '31'), ('1', '32'), ('1', '33'), ('1', '34'), ('1', '35'), ('1', '36'), ('1', '37'), ('1', '38'), ('1', '39'), ('1', '40'), ('1', '41'), ('1', '42'), ('1', '43'), ('1', '44'), ('1', '45'), ('1', '46'), ('1', '47'), ('1', '48'), ('1', '49'), ('1', '50'), ('1', '51'), ('1', '56'), ('1', '57'), ('1', '58'), ('2', '1'), ('2', '2'), ('2', '3'), ('2', '51'), ('4', '1'), ('6', '1'), ('6', '2'), ('6', '3'), ('6', '4'), ('6', '5'), ('6', '6'), ('6', '7'), ('6', '8'), ('6', '9'), ('6', '10'), ('6', '11'), ('6', '12'), ('6', '13'), ('6', '49'), ('6', '51');
COMMIT;

-- ----------------------------
--  Table structure for `bf_roles`
-- ----------------------------
DROP TABLE IF EXISTS `bf_roles`;
CREATE TABLE `bf_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(60) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `login_destination` varchar(255) NOT NULL DEFAULT '/',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `default_context` varchar(255) NOT NULL DEFAULT 'content',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_roles`
-- ----------------------------
BEGIN;
INSERT INTO `bf_roles` VALUES ('1', 'Administrator', 'Has full control over every aspect of the site.', '0', '0', '', '0', 'content'), ('2', 'Editor', 'Can handle day-to-day management, but does not have full power.', '0', '1', '', '0', 'content'), ('4', 'User', 'This is the default user with access to login.', '1', '0', '', '0', 'content'), ('6', 'Developer', 'Developers typically are the only ones that can access the developer tools. Otherwise identical to Administrators, at least until the site is handed off.', '0', '1', '', '0', 'content');
COMMIT;

-- ----------------------------
--  Table structure for `bf_schema_version`
-- ----------------------------
DROP TABLE IF EXISTS `bf_schema_version`;
CREATE TABLE `bf_schema_version` (
  `type` varchar(40) NOT NULL,
  `version` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_schema_version`
-- ----------------------------
BEGIN;
INSERT INTO `bf_schema_version` VALUES ('app_', '0'), ('core', '34'), ('guide_', '2');
COMMIT;

-- ----------------------------
--  Table structure for `bf_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `bf_sessions`;
CREATE TABLE `bf_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bf_settings`
-- ----------------------------
DROP TABLE IF EXISTS `bf_settings`;
CREATE TABLE `bf_settings` (
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `unique - name` (`name`),
  KEY `index - name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `bf_settings`
-- ----------------------------
BEGIN;
INSERT INTO `bf_settings` VALUES ('auth.allow_name_change', 'core', '1'), ('auth.allow_register', 'core', '1'), ('auth.allow_remember', 'core', '1'), ('auth.do_login_redirect', 'core', '1'), ('auth.login_type', 'core', 'email'), ('auth.name_change_frequency', 'core', '1'), ('auth.name_change_limit', 'core', '1'), ('auth.password_force_mixed_case', 'core', '0'), ('auth.password_force_numbers', 'core', '0'), ('auth.password_force_symbols', 'core', '0'), ('auth.password_min_length', 'core', '8'), ('auth.password_show_labels', 'core', '0'), ('auth.remember_length', 'core', '1209600'), ('auth.use_extended_profile', 'core', '0'), ('auth.use_usernames', 'core', '1'), ('auth.user_activation_method', 'core', '0'), ('form_save', 'core.ui', 'ctrl+s/⌘+s'), ('goto_content', 'core.ui', 'alt+c'), ('mailpath', 'email', '/usr/sbin/sendmail'), ('mailtype', 'email', 'text'), ('protocol', 'email', 'mail'), ('sender_email', 'email', 'douglas@mbr.mx'), ('site.languages', 'core', 'a:3:{i:0;s:7:\"english\";i:1;s:10:\"portuguese\";i:2;s:7:\"persian\";}'), ('site.list_limit', 'core', '25'), ('site.show_front_profiler', 'core', '1'), ('site.show_profiler', 'core', '1'), ('site.status', 'core', '1'), ('site.system_email', 'core', 'douglas@mbr.mx'), ('site.title', 'core', 'ibr Turismo'), ('smtp_host', 'email', ''), ('smtp_pass', 'email', ''), ('smtp_port', 'email', ''), ('smtp_timeout', 'email', ''), ('smtp_user', 'email', ''), ('updates.bleeding_edge', 'core', '1'), ('updates.do_check', 'core', '1');
COMMIT;

-- ----------------------------
--  Table structure for `bf_user_cookies`
-- ----------------------------
DROP TABLE IF EXISTS `bf_user_cookies`;
CREATE TABLE `bf_user_cookies` (
  `user_id` bigint(20) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_user_cookies`
-- ----------------------------
BEGIN;
INSERT INTO `bf_user_cookies` VALUES ('1', 'ZpSneL2Un8vOMEJTmwjoyJgFBbL3diYuFUtoPvmRyWBNCgnOBx0aqHDvQpMmCLIKXRVVVTsoZb2AHA1b6mg5hRVeZSe8Bf98juoESN8JL8YxaqB93kLWLc0z1M3LavLi', '2013-08-07 10:34:48');
COMMIT;

-- ----------------------------
--  Table structure for `bf_user_meta`
-- ----------------------------
DROP TABLE IF EXISTS `bf_user_meta`;
CREATE TABLE `bf_user_meta` (
  `meta_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) NOT NULL DEFAULT '',
  `meta_value` text,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_user_meta`
-- ----------------------------
BEGIN;
INSERT INTO `bf_user_meta` VALUES ('1', '1', 'state', 'SC'), ('2', '1', 'country', 'US'), ('3', '1', 'type', 'small');
COMMIT;

-- ----------------------------
--  Table structure for `bf_users`
-- ----------------------------
DROP TABLE IF EXISTS `bf_users`;
CREATE TABLE `bf_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '4',
  `email` varchar(120) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password_hash` varchar(40) NOT NULL,
  `reset_hash` varchar(40) DEFAULT NULL,
  `salt` varchar(7) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(40) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_message` varchar(255) DEFAULT NULL,
  `reset_by` int(10) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT '',
  `display_name_changed` date DEFAULT NULL,
  `timezone` char(4) NOT NULL DEFAULT 'UM6',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activate_hash` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `bf_users`
-- ----------------------------
BEGIN;
INSERT INTO `bf_users` VALUES ('1', '1', 'douglas@mbr.mx', 'douglas@mbr.mx', 'dd447fd1be69591211d8be471af0245d9e05d697', null, '4sW1IqC', '2013-08-07 10:39:05', '187.113.246.58', '0000-00-00 00:00:00', '0', '0', null, null, '', null, 'UM6', 'english', '1', '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
