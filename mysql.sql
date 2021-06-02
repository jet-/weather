CREATE TABLE `temperatures` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `temperature` double NOT NULL,
  `humidity` varchar(20) NOT NULL,
  `dateMeasured` date NOT NULL,
  `hourMeasured` int(128) NOT NULL,
  `pressure` varchar(10) DEFAULT NULL,
  `time` char(19) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35261 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
