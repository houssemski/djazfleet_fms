CREATE TABLE IF NOT EXISTS `transport_bill_detailed_rides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ristourne_%` double DEFAULT '0' COMMENT 'Remise',
  `detail_ride_id` int(11) DEFAULT NULL COMMENT 'Trajets',
  `supplier_final_id` smallint(5) UNSIGNED DEFAULT NULL,
  `transport_bill_id` int(11) NOT NULL,
  `unit_price` double NOT NULL COMMENT 'Prix unitaire',
  `nb_trucks` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Nombre de camion',
  `nb_trucks_validated` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Nombre de camion validé',
  `price_ht` double NOT NULL COMMENT 'prix hors taxe',
  `tva_id` tinyint(2) NOT NULL,
  `price_ttc` double NOT NULL COMMENT 'Prix TTC',
  `ristourne_val` double DEFAULT '0' COMMENT 'valeur de remise ',
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `status_id` tinyint(2) NOT NULL DEFAULT '1',
  `approved` tinyint(2) NOT NULL DEFAULT '4' COMMENT 'approuvé préfecture',
  `is_open` tinyint(4) NOT NULL DEFAULT '0',
  `date_open` datetime DEFAULT NULL,
  `last_opener` int(11) DEFAULT NULL COMMENT 'dernière ouverture',
  `sheet_ride_detail_ride_id` int(11) DEFAULT NULL COMMENT 'identifiant de détail mission',
  `user_id` int(11) NOT NULL,
  `delivery_with_return` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'livraison avec retour',
  `ride_category_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'identifiant de catégorie trajet',
  `type_price` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'type de prix',
  `from_customer_order` tinyint(2) NOT NULL DEFAULT '1',
  `departure_destination_id` smallint(6) DEFAULT NULL,
  `arrival_destination_id` smallint(6) DEFAULT NULL,
  `car_type_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `type_ride` tinyint(2) NOT NULL DEFAULT '1',
  `lot_id` int(11) DEFAULT '1',
  `type_pricing` tinyint(2) NOT NULL DEFAULT '1',
  `tonnage_id` smallint(5) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `cancel_cause_id` smallint(5) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `car_id` mediumint(8) DEFAULT NULL,
  `nb_hours` smallint(2) DEFAULT NULL,
  `programming_date` date DEFAULT NULL,
  `charging_time` time DEFAULT NULL,
  `unloading_date` datetime DEFAULT NULL,
  `observation_order` varchar(225) COLLATE utf8_bin DEFAULT NULL,
  `sheet_ride_id` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=348 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;