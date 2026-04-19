-- ============================================================
-- MediCare Plus: Ambulance Booking Feature
-- Run this in phpMyAdmin on your `myhmsdb` database
-- ============================================================

CREATE TABLE IF NOT EXISTS `ambulancetb` (
  `id`              INT(11)      NOT NULL AUTO_INCREMENT,
  `caller_name`     VARCHAR(60)  NOT NULL,
  `contact`         VARCHAR(15)  NOT NULL,
  `pickup_address`  VARCHAR(255) NOT NULL,
  `drop_location`   VARCHAR(255) NOT NULL,
  `emergency_type`  VARCHAR(50)  NOT NULL,
  `patient_condition` VARCHAR(300) NOT NULL,
  `booked_at`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status`          ENUM('Pending','Dispatched','Completed','Cancelled')
                                 NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
