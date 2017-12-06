/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100128
 Source Host           : localhost:3306
 Source Schema         : webchat

 Target Server Type    : MySQL
 Target Server Version : 100128
 File Encoding         : 65001

 Date: 06/12/2017 22:25:39
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
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contacts
-- ----------------------------
INSERT INTO `contacts` VALUES (19, 'Nishant', 'Talekar', '8425892298', '1166372912.png', 'nishant@grr.la', 16);
INSERT INTO `contacts` VALUES (20, 'Vikas', 'Talekar', '8976897898', '1166372961.png', 'vikas@grr.la', 16);
INSERT INTO `contacts` VALUES (21, 'Prashant', 'Talekar', '6789567856', '1166372995.png', 'prashant@grr.la', 16);
INSERT INTO `contacts` VALUES (22, 'Dinesh', 'Ghule', '8425892298', '1166373102.png', 'dineshghule321@gmail.com', 17);
INSERT INTO `contacts` VALUES (23, 'Nishant', 'Talekar', '5678899990', '1166373127.png', 'nishant@grr.la', 17);
INSERT INTO `contacts` VALUES (24, 'Prashant', 'Talekar', '6789898978', '1166373158.png', 'prashant@grr.la', 17);

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
  `shared_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`from_user_id`) USING BTREE,
  INDEX `to_user_id`(`to_user_id`) USING BTREE,
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 166 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES (162, 17, 'Hi Vikas', '2017-12-06 17:32:54', 16, '17,16', NULL);
INSERT INTO `message` VALUES (163, 16, 'Hello Dinesh', '2017-12-06 17:33:12', 17, '16,17', NULL);
INSERT INTO `message` VALUES (164, 17, '', '2017-12-06 17:34:13', 16, '17,16', '1166373253.jpg');
INSERT INTO `message` VALUES (165, 16, 'good', '2017-12-06 17:37:55', 17, '16,17', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (16, 'dineshghule321@gmail.com', '5e05dc4868319188af64f6c812773332', '4woB2IrxMeBYujf', '2017-12-06 22:25:13', NULL, '1', '2017-12-06 17:27:35', NULL, '2017-12-06 17:55:13');
INSERT INTO `users` VALUES (17, 'vikas@grr.la', '79fff41eb274a574b4d282d55bcb30ad', 'P4BEXv2vW43r2WC', '2017-12-06 22:25:21', NULL, '1', '2017-12-06 17:30:58', NULL, '2017-12-06 17:55:21');
INSERT INTO `users` VALUES (18, 'nishant@grr.la', 'a2657885997aaec27355123bced30012', 'IB7PpQzif5KDhuV', '2017-12-06 17:27:00', NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (19, 'prashant@grr.la', 'abe0a9f33e098cc3462d11accfa22f6c', 'UtmYlxHINGA1cz3', '2017-12-06 17:27:25', NULL, '1', NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
