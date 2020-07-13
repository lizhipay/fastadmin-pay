CREATE TABLE `__PREFIX__lizhifu_channel`  (
  `id` int(0) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `createtime` int(0) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(0) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态:0=停用,1=启用',
  `sort` int(0) UNSIGNED NOT NULL COMMENT '排序：越小排在越前面',
  `name` varchar(22) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '通道名称',
  `code` int(0) UNSIGNED NOT NULL COMMENT '通道编号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE,
  INDEX `sort`(`sort`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

CREATE TABLE `__PREFIX__lizhifu_order`  (
  `id` int(0) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `createtime` int(0) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `paytime` int(0) UNSIGNED NULL DEFAULT NULL COMMENT '支付时间',
  `updatetime` int(0) UNSIGNED NULL DEFAULT NULL COMMENT '更新时间',
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '状态:0=未支付,1=已支付',
  `trade_no` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `amount` decimal(10, 3) UNSIGNED NOT NULL COMMENT '下单金额',
  `channel_id` int(0) UNSIGNED NOT NULL COMMENT '支付通道ID',
  `user_id` int(0) UNSIGNED NOT NULL COMMENT '下单用户',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `trade_no`(`trade_no`) USING BTREE,
  INDEX `channel_id`(`channel_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;