/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100128
 Source Host           : localhost:3306
 Source Schema         : contact_book

 Target Server Type    : MySQL
 Target Server Version : 100128
 File Encoding         : 65001

 Date: 06/12/2017 13:50:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts`  (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `moblie_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `photo_path` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(22) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contacts
-- ----------------------------
INSERT INTO `contacts` VALUES (12, 'Rahull', 'Shinde', '8425892298', '1166333509.png', 'rahul@grr.la', 10);
INSERT INTO `contacts` VALUES (13, 'Dinesh', 'Ghule', '8975907465', '1166333616.png', 'dineshghule321@gmail.com', 12);
INSERT INTO `contacts` VALUES (14, 'Vikas', 'Talekar', '8425892298', '1166333750.png', 'vikas@grr.la', 10);
INSERT INTO `contacts` VALUES (15, 'John', 'Joreden', '8975907465', '1166339222.png', 'john@grr.la', 10);

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(255) NULL DEFAULT NULL,
  `msg` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `to_user_id` int(11) NULL DEFAULT NULL,
  `meta` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`from_user_id`) USING BTREE,
  INDEX `to_user_id`(`to_user_id`) USING BTREE,
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 136 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES (119, 10, 'hiii', '2017-12-06 06:32:30', 12, '10,12');
INSERT INTO `message` VALUES (120, 12, 'hello rahul', '2017-12-06 06:33:56', 10, '12,10');
INSERT INTO `message` VALUES (121, 10, 'How are you Dinesh', '2017-12-06 06:34:16', 12, '10,12');
INSERT INTO `message` VALUES (122, 12, 'you fool', '2017-12-06 06:34:33', 10, '12,10');
INSERT INTO `message` VALUES (123, 12, 'ok bye', '2017-12-06 08:12:19', 10, '12,10');
INSERT INTO `message` VALUES (124, 10, 'haha', '2017-12-06 08:12:36', 12, '10,12');
INSERT INTO `message` VALUES (125, 10, 'ffr', '2017-12-06 08:16:10', 12, '10,12');
INSERT INTO `message` VALUES (126, 10, 'ka?', '2017-12-06 08:16:20', 12, '10,12');
INSERT INTO `message` VALUES (127, 10, 'à¤¦à¤¿à¤¨à¥‡à¤¶', '2017-12-06 08:17:11', 12, '10,12');
INSERT INTO `message` VALUES (128, 12, 'à¤¦à¤¿à¤¨à¥‡à¤¶va', '2017-12-06 08:17:31', 10, '12,10');
INSERT INTO `message` VALUES (129, 10, 'bar', '2017-12-06 08:22:12', 12, '10,12');
INSERT INTO `message` VALUES (130, 10, 'hhi', '2017-12-06 08:31:52', 12, '10,12');
INSERT INTO `message` VALUES (131, 10, 'hello', '2017-12-06 08:31:58', 12, '10,12');
INSERT INTO `message` VALUES (132, 10, 'hiikk', '2017-12-06 08:33:13', 12, '10,12');
INSERT INTO `message` VALUES (133, 10, 'hii', '2017-12-06 09:11:59', 11, '10,11');
INSERT INTO `message` VALUES (134, 10, 'hiii', '2017-12-06 09:12:12', 14, '10,14');
INSERT INTO `message` VALUES (135, 10, 'rr', '2017-12-06 09:12:44', 12, '10,12');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int(22) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `passwordHash` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `auth_token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `creation_date` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `profile_pic_path` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `last_login_time` timestamp(0) NULL DEFAULT NULL,
  `last_logout_time` timestamp(0) NULL DEFAULT NULL,
  `last_activity_time` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (10, 'dineshghule321@gmail.com', '5e05dc4868319188af64f6c812773332', 'oOTENNUzlEQkTH9', '2017-12-06 13:49:33', NULL, '1', '2017-12-06 09:10:32', '2017-12-06 09:10:22', '2017-12-06 09:19:33');
INSERT INTO `users` VALUES (11, 'john@grr.la', '330f7d3bb1c57bf17f8274952d399afa', 'Pe22kyNglwOHgDA', '2017-12-06 06:27:51', NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (12, 'rahul@grr.la', '94199c541ea4da7766b7a22c337d4cbb', 'apSa0iZKYDJGPC5', '2017-12-06 13:39:48', NULL, '1', '2017-12-06 08:23:18', '2017-12-06 08:23:05', '2017-12-06 09:09:48');
INSERT INTO `users` VALUES (13, 'nilesh@grr.la', 'cf4260c69d4a571d8df3667fe8f1b6a6', 'IYkmK5fFdlZE4oC', '2017-12-06 06:28:30', NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (14, 'vikas@grr.la', '79fff41eb274a574b4d282d55bcb30ad', '3AN1R2jWLy6aixS', '2017-12-06 06:28:45', NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (15, 'nishant@grr.la', 'a2657885997aaec27355123bced30012', 'U9D0Vk1BLFCXLPy', '2017-12-06 06:29:06', NULL, '1', NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
