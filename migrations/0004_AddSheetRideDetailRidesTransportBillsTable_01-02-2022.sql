CREATE TABLE `utranx_trm`.`sheet_ride_detail_rides_transport_bills` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `sheet_ride_detail_ride_id` INT NOT NULL ,
  `transport_bill_id` INT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;