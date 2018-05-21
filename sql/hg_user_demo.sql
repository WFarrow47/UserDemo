/*
 Navicat MySQL Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100132
 Source Host           : localhost:3306
 Source Schema         : hg_user_demo

 Target Server Type    : MySQL
 Target Server Version : 100132
 File Encoding         : 65001

 Date: 21/05/2018 15:33:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for accounts
-- ----------------------------
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `salt` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `uid` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `age` int(11) NULL DEFAULT NULL,
  `likes_coffee` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of accounts
-- ----------------------------
INSERT INTO `accounts` VALUES (1, 'admin', 'f557717120c6f241a006b07f31af5972d41d33996966d95f1288132dbdc19526', '6561318085afe0cc96f1148.95906720', 'ADM-001', 'John', 'Admin', 28, 1);

SET FOREIGN_KEY_CHECKS = 1;
