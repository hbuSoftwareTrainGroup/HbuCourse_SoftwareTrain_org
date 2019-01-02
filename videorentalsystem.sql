/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : videorentalsystem

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-01-02 22:20:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_account
-- ----------------------------
DROP TABLE IF EXISTS `admin_account`;
CREATE TABLE `admin_account` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_account
-- ----------------------------

-- ----------------------------
-- Table structure for compact_disk
-- ----------------------------
DROP TABLE IF EXISTS `compact_disk`;
CREATE TABLE `compact_disk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) DEFAULT NULL COMMENT '影碟位置',
  `price` double(10,2) DEFAULT NULL COMMENT '价格',
  `video_name` varchar(255) DEFAULT NULL COMMENT '影碟名称',
  `lead_actor` varchar(255) DEFAULT NULL COMMENT '主演',
  `stock` int(5) DEFAULT NULL COMMENT '现存张数',
  `input_goods` int(5) DEFAULT NULL COMMENT '进货张数',
  `serial_number` varchar(255) DEFAULT NULL COMMENT '影碟编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of compact_disk
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `deposit` double(10,2) DEFAULT NULL COMMENT '押金',
  `user_id` int(5) DEFAULT NULL COMMENT '用户表中的id',
  `compact_disk_id` int(5) DEFAULT NULL COMMENT '影碟表中的id',
  `receipt_id` varchar(255) DEFAULT NULL COMMENT '发票号',
  `state` int(1) DEFAULT NULL COMMENT '0-未归还;1-已归还',
  `rental` double(10,2) DEFAULT NULL COMMENT '租金',
  `rental_date` datetime DEFAULT NULL COMMENT '出租日期',
  `return_date` datetime DEFAULT NULL COMMENT '归还日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for user_account
-- ----------------------------
DROP TABLE IF EXISTS `user_account`;
CREATE TABLE `user_account` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_account
-- ----------------------------
