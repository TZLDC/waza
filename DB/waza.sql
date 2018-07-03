SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT 'ユーザー名',
  `mobile` char(16) NOT NULL DEFAULT '' COMMENT '電話番号',
  `email` varchar(100) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '3' COMMENT '性别 1-男 2-女 3-未知',
  `duedate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '閲覧期限',
  `authcode` varchar(32) NOT NULL DEFAULT '' COMMENT '認証コード',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `language` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Japanese1:Chinese2.traditional Chinese3:English4.Korean',
  `sendMail` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nationality` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ユーザ';

DROP TABLE IF EXISTS `tb_user_img`;
CREATE TABLE `tb_user_img` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT 'ユーザーID',
  `imgid` int(10) NOT NULL DEFAULT '0' COMMENT '関連写真ID',
  `img` varchar(128) NOT NULL DEFAULT '' COMMENT '写真path',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sort` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `iname` varchar(255) NOT NULL DEFAULT '' COMMENT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='写真';

DROP TABLE IF EXISTS `tb_user_video`;
CREATE TABLE `tb_user_video` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT 'ユーザーID',
  `video` varchar(128) NOT NULL DEFAULT '' COMMENT '動画合成path',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='動画合成';


ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tb_user_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `k_userid` (`userid`);

ALTER TABLE `tb_user_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `k_userid` (`userid`);


ALTER TABLE `tb_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_user_img`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_user_video`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
