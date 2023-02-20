-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 06 Janvier 2020 à 09:31
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `utranx_intellix`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_param_val_by_code` (IN `parameters_enum` INT, OUT `driver_license_exp_param` INT)  BEGIN

    SELECT val into driver_license_exp_param

    FROM parameters

    WHERE code = parameters_enum;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_assurance_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE param_val DATETIME;

	CALL  get_param_val_by_code(1, @assurance_exp_param);

	SET param_val = NOW() + INTERVAL @assurance_exp_param DAY;

	DELETE FROM alerts where alert_type_id = 1;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id FROM event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_date <= param_val &&  
        EventEventType.event_type_id = 2 &&
        EventType.alert_activate = 1 &&
        Event.alert != 2 &&
        Car.car_status_id != 27
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (1, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_car_amortization_alert` ()  NO SQL
BLOCK1: BEGIN

	CALL  get_param_val_by_code(26, @km_amortization_exp_param);

	DELETE FROM alerts where alert_type_id = 26;

	BLOCK2: BEGIN

		DECLARE car_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE car_id INT;
		DECLARE car_list CURSOR FOR SELECT Car.id
        FROM car as Car
        WHERE 
        Car.amortization_km <= @km_amortization_exp_param + Car.km 			&& Car.alert_amortization != 2 && Car.car_status_id != 27
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							car_list_isdone = TRUE;

    	OPEN car_list;

   		loop_List: LOOP
      		FETCH car_list INTO car_id;
      		IF car_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (26, car_id); 
            
   		END LOOP loop_List;

   		CLOSE car_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_coupon_consumption_limit_alert` ()  NO SQL
BLOCK1: BEGIN


	DELETE FROM alerts where alert_type_id = 27;

	BLOCK2: BEGIN

		DECLARE car_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE car_id INT;
        DECLARE nb_coupons INT;
		DECLARE car_list CURSOR FOR SELECT Car.id, 							SUM(coupons_number) as nb_coupons
        From sheet_rides as SheetRide
        LEFT JOIN car as Car ON (SheetRide.car_id = Car.id)
        WHERE month(real_end_date)= month(now()) && 						year(real_end_date)= year(now()) && Car.alert != 2
        group by car_id, month(real_end_date), Car.coupon_consumption
        having nb_coupons >= Car.coupon_consumption
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							car_list_isdone = TRUE;

    	OPEN car_list;

   		loop_List: LOOP
      		FETCH car_list INTO car_id, nb_coupons;
      		IF car_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (27, car_id); 
            
   		END LOOP loop_List;

   		CLOSE car_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_coupon_stock_alert` ()  NO SQL
BLOCK1: BEGIN

	CALL  get_param_val_by_code(15, @coupon_stock_param);

	DELETE FROM alerts where alert_type_id = 15;

	BLOCK2: BEGIN

		DECLARE coupon_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE nb_coupons INT;
        DECLARE coupons_used INT;
		DECLARE coupon_list CURSOR FOR 
        select COUNT(serial_number) as nb_coupons, (select 					count(used) from coupons where used=1) as coupons_used
        From coupons as Coupon
        having (nb_coupons-coupons_used) <= @coupon_stock_param
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							coupon_list_isdone = TRUE;

    	OPEN coupon_list;

   		loop_List: LOOP
      		FETCH coupon_list INTO nb_coupons, coupons_used;
      		IF coupon_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (15, 1); 
            
   		END LOOP loop_List;

   		CLOSE coupon_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_date_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE param_val DATETIME;

	CALL  get_param_val_by_code(6, @date_exp_param);

	SET param_val = NOW() + INTERVAL @date_exp_param DAY;

	DELETE FROM alerts where alert_type_id = 6;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id FROM event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_date <= param_val &&  
        EventEventType.event_type_id != 2 &&
        EventEventType.event_type_id != 3 &&
        EventEventType.event_type_id != 5 &&
        EventType.alert_activate = 1 &&
        Event.alert != 2 &&
        Car.car_status_id != 27
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (6, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_date_contract_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE limited_date DATETIME;

	CALL  get_param_val_by_code(22, @contract_date_remaining_param);
    
    SET limited_date = NOW() + INTERVAL @contract_date_remaining_param DAY;

	DELETE FROM alerts where alert_type_id = 22;

	BLOCK2: BEGIN

		DECLARE car_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE car_id INT;
		DECLARE car_list CURSOR FOR SELECT Car.id
        FROM car as Car
        LEFT JOIN leasings as Leasing ON Leasing.car_id = Car.id
        WHERE (Leasing.end_date <= limited_date && 								Leasing.alert_date != 2);
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							car_list_isdone = TRUE;

    	OPEN car_list;

   		loop_List: LOOP
      		FETCH car_list INTO car_id;
      		IF car_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (22, car_id); 
            
   		END LOOP loop_List;

   		CLOSE car_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_deadline_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE param_val DATETIME;

	CALL  get_param_val_by_code(30, @deadline_exp_param);

	SET param_val = NOW() + INTERVAL @deadline_exp_param DAY;

	DELETE FROM alerts where alert_type_id = 30;

	BLOCK2: BEGIN

		DECLARE invoice_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE deadline_id INT;
		DECLARE invoice_list CURSOR FOR SELECT id FROM deadlines
       
		WHERE deadline_date <= param_val ;
     
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							invoice_list_isdone = TRUE;

    	OPEN invoice_list;

   		loop_List: LOOP
      		FETCH invoice_list INTO deadline_id;
      		IF invoice_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (30, deadline_id); 
            
   		END LOOP loop_List;

   		CLOSE invoice_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_drivers_license_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE param_val DATETIME;

	CALL  get_param_val_by_code(5, @driver_license_exp_param);

	SET param_val = NOW() + INTERVAL @driver_license_exp_param DAY;

	DELETE FROM alerts where alert_type_id = 5;

	BLOCK2: BEGIN

		DECLARE customer_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE customer_id INT;
		DECLARE customer_list CURSOR FOR SELECT id FROM customers 			WHERE ((alert != 2) && (exit_date IS NULL || exit_date >= NOW()) && (driver_license_expires_date1 <= param_val || 
        driver_license_expires_date2 <= param_val ||
        driver_license_expires_date3 <= param_val ||
        driver_license_expires_date4 <= param_val ||
        driver_license_expires_date5 <= param_val ||
        driver_license_expires_date6 <= param_val));
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							customer_list_isdone = TRUE;

    	OPEN customer_list;

   		loop_List: LOOP
      		FETCH customer_list INTO customer_id;
      		IF customer_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (5, customer_id); 
            
   		END LOOP loop_List;

   		CLOSE customer_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_km_alert` ()  NO SQL
BLOCK1: BEGIN

	CALL  get_param_val_by_code(7, @km_alert_param);

	DELETE FROM alerts where alert_type_id = 7;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id
        FROM event AS Event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_km <= @km_alert_param + Car.km && 					Event.alert != 2 && 	
        EventEventType.event_type_id != 1 &&
        EventType.alert_activate = 1 &&
        car_status_id != 27;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (7, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_km_contract_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE km_remainig INT;

	CALL  get_param_val_by_code(21, @contract_km_remaining_param);

	DELETE FROM alerts where alert_type_id = 21;

	BLOCK2: BEGIN

		DECLARE car_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE car_id INT;
		DECLARE car_list CURSOR FOR SELECT Car.id, ((Leasing.km_year* (FLOOR(TIMESTAMPDIFF(DAY , Leasing.reception_date, Leasing.end_date)/30)/12))-(Car.km - Leasing.reception_date)) as km_remainig 
        FROM car as Car
        LEFT JOIN leasings as Leasing ON Leasing.car_id = Car.id
        WHERE (Leasing.acquisition_type_id = 2 or 							Leasing.acquisition_type_id = 3) && 								Leasing.reception_date<=CURDATE() && 								Leasing.end_date>=CURDATE()
        having km_remainig <= @contract_km_remaining_param;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							car_list_isdone = TRUE;

    	OPEN car_list;

   		loop_List: LOOP
      		FETCH car_list INTO car_id, km_remainig;
      		IF car_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (21, car_id); 
            
   		END LOOP loop_List;

   		CLOSE car_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_monthly_limit_consumption_alert` ()  NO SQL
BLOCK1: BEGIN

	CALL  get_param_val_by_code(13, @consumption_monthly_limit_param);

	DELETE FROM alerts where alert_type_id = 26;

	BLOCK2: BEGIN

		DECLARE car_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE car_id INT;
		DECLARE car_list CURSOR FOR SELECT Car.id
        FROM car as Car
        WHERE 
        Car.amortization_km <= @km_amortization_exp_param + Car.km 			&& Car.alert_amortization != 2 && Car.car_status_id != 27
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							car_list_isdone = TRUE;

    	OPEN car_list;

   		loop_List: LOOP
      		FETCH car_list INTO car_id;
      		IF car_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (26, car_id); 
            
   		END LOOP loop_List;

   		CLOSE car_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_oil_change_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE km_remainig INT;

	CALL  get_param_val_by_code(4, @oil_change_param);

	DELETE FROM alerts where alert_type_id = 4;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id
        FROM event AS Event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_km <= @oil_change_param + Car.km && 				Event.alert != 2 && 												EventType.alert_activate = 1 &&
        car_status_id != 27;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (4, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_oil_change_by_hours_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE km_remainig INT;

	CALL  get_param_val_by_code(24, @oil_change_by_hours_param);

	DELETE FROM alerts where alert_type_id = 24;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id
        FROM event AS Event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE 
        Event.next_km <= CAST(@oil_change_by_hours_param AS UNSIGNED) 		  + Car.hours && Event.alert != 2 && 									EventType.alert_activate = 1 &&
        car_status_id != 27 && EventEventType.event_type_id = 10;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (24, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_product_max_alert` ()  NO SQL
BLOCK1: BEGIN


	DELETE FROM alerts where alert_type_id = 29;

	BLOCK2: BEGIN

		DECLARE product_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE product_id INT;
		DECLARE product_list CURSOR FOR SELECT product.id
        From products as Product
        WHERE quantity >= quantity_max
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							product_list_isdone = TRUE;

    	OPEN product_list;

   		loop_List: LOOP
      		FETCH product_list INTO product_id;
      		IF product_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (29, product_id); 
            
   		END LOOP loop_List;

   		CLOSE product_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_product_min_alert` ()  NO SQL
BLOCK1: BEGIN


	DELETE FROM alerts where alert_type_id = 28;

	BLOCK2: BEGIN

		DECLARE product_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE product_id INT;
		DECLARE product_list CURSOR FOR SELECT product.id
        From products as Product
        WHERE quantity <= quantity_min
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							product_list_isdone = TRUE;

    	OPEN product_list;

   		loop_List: LOOP
      		FETCH product_list INTO product_id;
      		IF product_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (28, product_id); 
            
   		END LOOP loop_List;

   		CLOSE product_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_technical_control_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE param_val DATETIME;

	CALL  get_param_val_by_code(2, @technical_control_exp_param);

	SET param_val = NOW() + INTERVAL @technical_control_exp_param DAY;

	DELETE FROM alerts where alert_type_id = 2;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id FROM event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_date <= param_val &&  
        EventEventType.event_type_id = 3 &&
        EventType.alert_activate = 1 &&
        Event.alert != 2 &&
        Car.car_status_id != 27
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (2, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_vidange_alert` ()  NO SQL
BLOCK1: BEGIN

	CALL  get_param_val_by_code(4, @vidange_alert_param);

	DELETE FROM alerts where alert_type_id = 7;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id
        FROM event AS Event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_km <= @vidange_alert_param + Car.km && 					Event.alert != 2 && 	
        EventEventType.event_type_id != 1 &&
        EventType.alert_activate = 1 &&
        car_status_id != 27;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (4, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_vignette_alert` ()  NO SQL
BLOCK1: BEGIN

	DECLARE param_val DATETIME;

	CALL  get_param_val_by_code(3, @vignette_exp_param);

	SET param_val = NOW() + INTERVAL @vignette_exp_param DAY;

	DELETE FROM alerts where alert_type_id = 3;

	BLOCK2: BEGIN

		DECLARE event_list_isdone BOOLEAN DEFAULT FALSE;
		DECLARE event_id INT;
		DECLARE event_list CURSOR FOR SELECT Event.id FROM event
        LEFT JOIN car AS Car ON (Event.car_id = Car.id)
        LEFT JOIN event_event_types AS EventEventType ON 					(EventEventType.event_id = Event.id)
        LEFT JOIN event_types AS EventType ON 								(EventEventType.event_type_id = EventType.id)
        WHERE Event.next_date <= param_val &&  
        EventEventType.event_type_id = 5 &&
        EventType.alert_activate = 1 &&
        Event.alert != 2 &&
        Car.car_status_id != 27
        ;
    
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET 							event_list_isdone = TRUE;

    	OPEN event_list;

   		loop_List: LOOP
      		FETCH event_list INTO event_id;
      		IF event_list_isdone THEN
         		LEAVE loop_List;
      		END IF;

            INSERT INTO alerts(alert_type_id, object_id) VALUES (3, event_id); 
            
   		END LOOP loop_List;

   		CLOSE event_list;
   
   END BLOCK2;

END BLOCK1$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `code` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `absence_reason_id` smallint(5) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_bin,
  `attachment` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `absence_reasons`
--

CREATE TABLE `absence_reasons` (
  `id` smallint(5) NOT NULL,
  `code` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `access_permissions`
--

CREATE TABLE `access_permissions` (
  `id` int(11) NOT NULL,
  `section_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT ' Identifiant de la section',
  `action_id` smallint(5) UNSIGNED DEFAULT NULL,
  `profile_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `access_permissions`
--

INSERT INTO `access_permissions` (`id`, `section_id`, `action_id`, `profile_id`) VALUES
(27, 77, 1, 11),
(28, 77, 3, 11),
(29, 77, 4, 11),
(30, 77, 6, 11),
(31, 77, 8, 11),
(32, 77, 12, 11),
(33, 77, 13, 11),
(34, 77, 15, 11),
(36, 84, 1, 11),
(37, 86, 1, 11),
(38, 87, 1, 11),
(39, 90, 1, 11),
(238, 79, 1, 11),
(239, 80, 1, 11),
(240, 73, 1, 11),
(241, 73, 3, 11),
(242, 73, 4, 11),
(243, 73, 6, 11),
(244, 73, 8, 11),
(245, 73, 11, 11),
(246, 73, 12, 11),
(247, 73, 13, 11),
(248, 73, 14, 11),
(249, 73, 15, 11),
(250, 74, 1, 11),
(251, 75, 1, 11),
(252, 76, 1, 11),
(942, 86, 1, 5),
(1141, 68, 1, 10),
(1142, 68, 2, 10),
(1966, 77, 1, 5),
(1967, 77, 2, 5),
(1968, 77, 3, 5),
(1969, 77, 4, 5),
(1970, 77, 8, 5),
(1971, 77, 12, 5),
(1972, 77, 13, 5),
(1973, 77, 14, 5),
(1974, 77, 15, 5),
(1975, 78, 1, 5),
(1976, 79, 1, 5),
(1977, 79, 2, 5),
(1978, 79, 3, 5),
(1979, 79, 4, 5),
(1980, 79, 8, 5),
(1981, 79, 12, 5),
(1982, 79, 13, 5),
(1983, 79, 14, 5),
(1984, 79, 15, 5),
(1985, 80, 1, 5),
(1986, 81, 1, 5),
(1987, 82, 1, 5),
(1988, 83, 1, 5),
(1989, 114, 1, 5),
(1999, 112, 1, 5),
(2022, 57, 1, 6),
(2023, 57, 2, 6),
(2024, 57, 3, 6),
(2025, 57, 4, 6),
(2026, 57, 8, 6),
(2027, 57, 12, 6),
(2028, 57, 13, 6),
(2029, 57, 14, 6),
(2030, 57, 15, 6),
(2031, 58, 1, 6),
(2032, 58, 2, 6),
(2033, 58, 3, 6),
(2034, 58, 4, 6),
(2035, 58, 8, 6),
(2036, 58, 12, 6),
(2037, 58, 13, 6),
(2038, 58, 14, 6),
(2039, 58, 15, 6),
(2040, 59, 1, 6),
(2041, 59, 2, 6),
(2042, 59, 3, 6),
(2043, 59, 4, 6),
(2044, 59, 8, 6),
(2045, 59, 12, 6),
(2046, 59, 13, 6),
(2047, 59, 14, 6),
(2048, 59, 15, 6),
(2252, 50, 1, 8),
(2253, 50, 2, 8),
(2254, 50, 3, 8),
(2255, 50, 4, 8),
(2256, 50, 8, 8),
(2257, 50, 12, 8),
(2258, 50, 13, 8),
(2259, 50, 14, 8),
(2260, 50, 15, 8),
(2261, 51, 1, 8),
(2262, 51, 2, 8),
(2263, 51, 3, 8),
(2264, 51, 4, 8),
(2265, 51, 8, 8),
(2266, 51, 12, 8),
(2267, 51, 13, 8),
(2268, 51, 14, 8),
(2269, 51, 15, 8),
(2270, 52, 1, 8),
(2271, 52, 2, 8),
(2272, 52, 3, 8),
(2273, 52, 4, 8),
(2274, 52, 8, 8),
(2275, 52, 12, 8),
(2276, 52, 13, 8),
(2277, 52, 14, 8),
(2278, 52, 15, 8),
(2279, 53, 1, 8),
(2280, 53, 2, 8),
(2281, 53, 3, 8),
(2282, 53, 4, 8),
(2283, 53, 8, 8),
(2284, 53, 12, 8),
(2285, 53, 13, 8),
(2286, 53, 14, 8),
(2287, 53, 15, 8),
(2717, 125, 1, 2),
(2718, 125, 2, 2),
(2719, 125, 11, 2),
(2720, 125, 12, 2),
(2721, 125, 13, 2),
(2722, 125, 14, 2),
(2723, 125, 15, 2),
(3427, 39, 1, 6),
(3428, 39, 2, 6),
(3429, 39, 3, 6),
(3430, 39, 4, 6),
(3431, 39, 13, 6),
(3432, 39, 14, 6),
(3433, 39, 15, 6),
(3890, 32, 1, 1),
(3891, 32, 2, 1),
(3892, 32, 3, 1),
(3893, 32, 4, 1),
(3894, 32, 5, 1),
(3895, 32, 6, 1),
(3896, 32, 7, 1),
(3897, 32, 8, 1),
(3898, 32, 9, 1),
(3899, 32, 10, 1),
(3900, 32, 11, 1),
(3901, 32, 12, 1),
(3902, 32, 13, 1),
(3903, 32, 14, 1),
(3904, 32, 15, 1),
(3905, 33, 1, 1),
(3906, 33, 2, 1),
(3907, 33, 3, 1),
(3908, 33, 4, 1),
(3909, 33, 5, 1),
(3910, 33, 6, 1),
(3911, 33, 7, 1),
(3912, 33, 8, 1),
(3913, 33, 9, 1),
(3914, 33, 10, 1),
(3915, 33, 11, 1),
(3916, 33, 12, 1),
(3917, 33, 13, 1),
(3918, 33, 14, 1),
(3919, 33, 15, 1),
(3920, 34, 1, 1),
(3921, 34, 2, 1),
(3922, 34, 3, 1),
(3923, 34, 4, 1),
(3924, 34, 5, 1),
(3925, 34, 6, 1),
(3926, 34, 7, 1),
(3927, 34, 8, 1),
(3928, 34, 9, 1),
(3929, 34, 10, 1),
(3930, 34, 11, 1),
(3931, 34, 12, 1),
(3932, 34, 13, 1),
(3933, 34, 14, 1),
(3934, 34, 15, 1),
(3935, 35, 1, 1),
(3936, 35, 2, 1),
(3937, 35, 3, 1),
(3938, 35, 4, 1),
(3939, 35, 5, 1),
(3940, 35, 6, 1),
(3941, 35, 7, 1),
(3942, 35, 8, 1),
(3943, 35, 9, 1),
(3944, 35, 10, 1),
(3945, 35, 11, 1),
(3946, 35, 12, 1),
(3947, 35, 13, 1),
(3948, 35, 14, 1),
(3949, 35, 15, 1),
(3950, 36, 1, 1),
(3951, 36, 2, 1),
(3952, 36, 3, 1),
(3953, 36, 4, 1),
(3954, 36, 5, 1),
(3955, 36, 6, 1),
(3956, 36, 7, 1),
(3957, 36, 8, 1),
(3958, 36, 9, 1),
(3959, 36, 10, 1),
(3960, 36, 11, 1),
(3961, 36, 12, 1),
(3962, 36, 13, 1),
(3963, 36, 14, 1),
(3964, 36, 15, 1),
(3965, 115, 1, 1),
(3966, 115, 2, 1),
(3967, 115, 3, 1),
(3968, 115, 4, 1),
(3969, 115, 5, 1),
(3970, 115, 6, 1),
(3971, 115, 7, 1),
(3972, 115, 8, 1),
(3973, 115, 9, 1),
(3974, 115, 10, 1),
(3975, 115, 11, 1),
(3976, 115, 12, 1),
(3977, 115, 13, 1),
(3978, 115, 14, 1),
(3979, 115, 15, 1),
(3980, 124, 1, 1),
(3981, 124, 2, 1),
(3982, 124, 3, 1),
(3983, 124, 4, 1),
(3984, 124, 5, 1),
(3985, 124, 6, 1),
(3986, 124, 7, 1),
(3987, 124, 8, 1),
(3988, 124, 9, 1),
(3989, 124, 10, 1),
(3990, 124, 11, 1),
(3991, 124, 12, 1),
(3992, 124, 13, 1),
(3993, 124, 14, 1),
(3994, 124, 15, 1),
(3995, 126, 1, 1),
(3996, 126, 2, 1),
(3997, 126, 3, 1),
(3998, 126, 4, 1),
(3999, 126, 5, 1),
(4000, 126, 6, 1),
(4001, 126, 7, 1),
(4002, 126, 8, 1),
(4003, 126, 9, 1),
(4004, 126, 10, 1),
(4005, 126, 11, 1),
(4006, 126, 12, 1),
(4007, 126, 13, 1),
(4008, 126, 14, 1),
(4009, 126, 15, 1),
(4010, 127, 1, 1),
(4011, 127, 2, 1),
(4012, 127, 3, 1),
(4013, 127, 4, 1),
(4014, 127, 5, 1),
(4015, 127, 6, 1),
(4016, 127, 7, 1),
(4017, 127, 8, 1),
(4018, 127, 9, 1),
(4019, 127, 10, 1),
(4020, 127, 11, 1),
(4021, 127, 12, 1),
(4022, 127, 13, 1),
(4023, 127, 14, 1),
(4024, 127, 15, 1),
(4025, 1, 1, 9),
(4026, 1, 2, 9),
(4027, 1, 3, 9),
(4028, 1, 4, 9),
(4029, 1, 5, 9),
(4030, 1, 6, 9),
(4031, 1, 7, 9),
(4032, 1, 8, 9),
(4033, 1, 9, 9),
(4034, 1, 10, 9),
(4035, 1, 11, 9),
(4036, 1, 12, 9),
(4037, 1, 13, 9),
(4038, 1, 14, 9),
(4039, 1, 15, 9),
(4040, 2, 1, 9),
(4041, 3, 1, 9),
(4042, 4, 1, 9),
(4043, 4, 2, 9),
(4044, 4, 3, 9),
(4045, 4, 4, 9),
(4046, 4, 5, 9),
(4047, 4, 6, 9),
(4048, 4, 7, 9),
(4049, 4, 8, 9),
(4050, 4, 9, 9),
(4051, 4, 10, 9),
(4052, 4, 11, 9),
(4053, 4, 12, 9),
(4054, 4, 13, 9),
(4055, 4, 14, 9),
(4056, 4, 15, 9),
(4057, 5, 1, 9),
(4058, 5, 2, 9),
(4059, 5, 3, 9),
(4060, 5, 4, 9),
(4061, 5, 5, 9),
(4062, 5, 6, 9),
(4063, 5, 7, 9),
(4064, 5, 8, 9),
(4065, 5, 9, 9),
(4066, 5, 10, 9),
(4067, 5, 11, 9),
(4068, 5, 12, 9),
(4069, 5, 13, 9),
(4070, 5, 14, 9),
(4071, 5, 15, 9),
(4072, 6, 1, 9),
(4073, 6, 2, 9),
(4074, 6, 3, 9),
(4075, 6, 4, 9),
(4076, 6, 5, 9),
(4077, 6, 6, 9),
(4078, 6, 7, 9),
(4079, 6, 8, 9),
(4080, 6, 9, 9),
(4081, 6, 10, 9),
(4082, 6, 11, 9),
(4083, 6, 12, 9),
(4084, 6, 13, 9),
(4085, 6, 14, 9),
(4086, 6, 15, 9),
(4087, 7, 1, 9),
(4088, 7, 2, 9),
(4089, 7, 3, 9),
(4090, 7, 4, 9),
(4091, 7, 5, 9),
(4092, 7, 6, 9),
(4093, 7, 7, 9),
(4094, 7, 8, 9),
(4095, 7, 9, 9),
(4096, 7, 10, 9),
(4097, 7, 11, 9),
(4098, 7, 12, 9),
(4099, 7, 13, 9),
(4100, 7, 14, 9),
(4101, 7, 15, 9),
(4102, 8, 1, 9),
(4103, 8, 2, 9),
(4104, 8, 3, 9),
(4105, 8, 4, 9),
(4106, 8, 5, 9),
(4107, 8, 6, 9),
(4108, 8, 7, 9),
(4109, 8, 8, 9),
(4110, 8, 9, 9),
(4111, 8, 10, 9),
(4112, 8, 11, 9),
(4113, 8, 12, 9),
(4114, 8, 13, 9),
(4115, 8, 14, 9),
(4116, 8, 15, 9),
(4117, 9, 1, 9),
(4118, 9, 2, 9),
(4119, 9, 3, 9),
(4120, 9, 4, 9),
(4121, 9, 5, 9),
(4122, 9, 6, 9),
(4123, 9, 7, 9),
(4124, 9, 8, 9),
(4125, 9, 9, 9),
(4126, 9, 10, 9),
(4127, 9, 11, 9),
(4128, 9, 12, 9),
(4129, 9, 13, 9),
(4130, 9, 14, 9),
(4131, 9, 15, 9),
(4132, 10, 1, 9),
(4133, 10, 2, 9),
(4134, 10, 3, 9),
(4135, 10, 4, 9),
(4136, 10, 5, 9),
(4137, 10, 6, 9),
(4138, 10, 7, 9),
(4139, 10, 8, 9),
(4140, 10, 9, 9),
(4141, 10, 10, 9),
(4142, 10, 11, 9),
(4143, 10, 12, 9),
(4144, 10, 13, 9),
(4145, 10, 14, 9),
(4146, 10, 15, 9),
(4147, 11, 1, 9),
(4148, 11, 2, 9),
(4149, 11, 3, 9),
(4150, 11, 4, 9),
(4151, 11, 5, 9),
(4152, 11, 6, 9),
(4153, 11, 7, 9),
(4154, 11, 8, 9),
(4155, 11, 9, 9),
(4156, 11, 10, 9),
(4157, 11, 11, 9),
(4158, 11, 12, 9),
(4159, 11, 13, 9),
(4160, 11, 14, 9),
(4161, 11, 15, 9),
(4162, 12, 1, 9),
(4163, 12, 2, 9),
(4164, 12, 3, 9),
(4165, 12, 4, 9),
(4166, 12, 5, 9),
(4167, 12, 6, 9),
(4168, 12, 7, 9),
(4169, 12, 8, 9),
(4170, 12, 9, 9),
(4171, 12, 10, 9),
(4172, 12, 11, 9),
(4173, 12, 12, 9),
(4174, 12, 13, 9),
(4175, 12, 14, 9),
(4176, 12, 15, 9),
(4177, 13, 1, 9),
(4178, 13, 2, 9),
(4179, 13, 3, 9),
(4180, 13, 4, 9),
(4181, 13, 5, 9),
(4182, 13, 6, 9),
(4183, 13, 7, 9),
(4184, 13, 8, 9),
(4185, 13, 9, 9),
(4186, 13, 10, 9),
(4187, 13, 11, 9),
(4188, 13, 12, 9),
(4189, 13, 13, 9),
(4190, 13, 14, 9),
(4191, 13, 15, 9),
(4192, 14, 1, 9),
(4193, 14, 2, 9),
(4194, 14, 3, 9),
(4195, 14, 4, 9),
(4196, 14, 5, 9),
(4197, 14, 6, 9),
(4198, 14, 7, 9),
(4199, 14, 8, 9),
(4200, 14, 9, 9),
(4201, 14, 10, 9),
(4202, 14, 11, 9),
(4203, 14, 12, 9),
(4204, 14, 13, 9),
(4205, 14, 14, 9),
(4206, 14, 15, 9),
(4498, 84, 1, 5),
(4499, 84, 3, 5),
(4500, 84, 4, 5),
(4501, 84, 6, 5),
(4502, 84, 8, 5),
(4503, 84, 12, 5),
(4504, 84, 13, 5),
(4505, 84, 14, 5),
(4506, 84, 15, 5),
(4507, 85, 1, 5),
(4508, 113, 1, 5),
(4509, 137, 1, 5),
(4510, 137, 4, 5),
(4511, 137, 6, 5),
(4512, 137, 12, 5),
(4513, 137, 13, 5),
(4514, 137, 14, 5),
(4515, 137, 15, 5),
(4786, 20, 1, 2),
(4787, 20, 2, 2),
(4788, 20, 3, 2),
(4789, 20, 4, 2),
(4790, 20, 8, 2),
(4791, 20, 12, 2),
(4792, 20, 13, 2),
(4793, 20, 14, 2),
(4794, 20, 15, 2),
(4795, 21, 1, 2),
(4796, 21, 2, 2),
(4797, 21, 3, 2),
(4798, 21, 4, 2),
(4799, 21, 8, 2),
(4800, 21, 12, 2),
(4801, 21, 13, 2),
(4802, 21, 14, 2),
(4803, 21, 15, 2),
(4860, 32, 1, 7),
(4861, 32, 2, 7),
(4862, 32, 3, 7),
(4863, 32, 4, 7),
(4864, 32, 6, 7),
(4865, 32, 8, 7),
(4866, 32, 12, 7),
(4867, 32, 13, 7),
(4868, 32, 14, 7),
(4869, 32, 15, 7),
(4870, 33, 1, 7),
(4871, 33, 2, 7),
(4872, 33, 3, 7),
(4873, 33, 4, 7),
(4874, 33, 6, 7),
(4875, 33, 8, 7),
(4876, 33, 12, 7),
(4877, 33, 13, 7),
(4878, 33, 14, 7),
(4879, 33, 15, 7),
(4880, 34, 1, 7),
(4881, 34, 2, 7),
(4882, 34, 3, 7),
(4883, 34, 4, 7),
(4884, 34, 6, 7),
(4885, 34, 8, 7),
(4886, 34, 12, 7),
(4887, 34, 13, 7),
(4888, 34, 14, 7),
(4889, 34, 15, 7),
(4890, 35, 1, 7),
(4891, 35, 2, 7),
(4892, 35, 3, 7),
(4893, 35, 4, 7),
(4894, 35, 6, 7),
(4895, 35, 8, 7),
(4896, 35, 12, 7),
(4897, 35, 13, 7),
(4898, 35, 14, 7),
(4899, 35, 15, 7),
(4900, 36, 1, 7),
(4901, 36, 2, 7),
(4902, 36, 3, 7),
(4903, 36, 4, 7),
(4904, 36, 6, 7),
(4905, 36, 8, 7),
(4906, 36, 12, 7),
(4907, 36, 13, 7),
(4908, 36, 14, 7),
(4909, 36, 15, 7),
(4910, 115, 1, 7),
(4911, 115, 2, 7),
(4912, 115, 3, 7),
(4913, 115, 4, 7),
(4914, 115, 6, 7),
(4915, 115, 8, 7),
(4916, 115, 12, 7),
(4917, 115, 13, 7),
(4918, 115, 14, 7),
(4919, 115, 15, 7),
(4920, 124, 1, 7),
(4921, 124, 2, 7),
(4922, 124, 3, 7),
(4923, 124, 4, 7),
(4924, 124, 6, 7),
(4925, 124, 8, 7),
(4926, 124, 12, 7),
(4927, 124, 13, 7),
(4928, 124, 14, 7),
(4929, 124, 15, 7),
(4930, 126, 1, 7),
(4931, 126, 2, 7),
(4932, 126, 3, 7),
(4933, 126, 4, 7),
(4934, 126, 6, 7),
(4935, 126, 8, 7),
(4936, 126, 12, 7),
(4937, 126, 13, 7),
(4938, 126, 14, 7),
(4939, 126, 15, 7),
(4940, 127, 1, 7),
(4941, 127, 2, 7),
(4942, 127, 3, 7),
(4943, 127, 4, 7),
(4944, 127, 6, 7),
(4945, 127, 8, 7),
(4946, 127, 12, 7),
(4947, 127, 13, 7),
(4948, 127, 14, 7),
(4949, 127, 15, 7),
(5584, 90, 1, 1),
(5585, 90, 11, 1),
(5586, 90, 13, 1),
(5587, 90, 14, 1),
(5588, 90, 15, 1),
(5589, 91, 1, 1),
(5590, 134, 1, 1),
(5591, 134, 2, 1),
(5592, 134, 13, 1),
(5593, 134, 15, 1),
(5594, 95, 1, 1),
(5595, 95, 13, 1),
(5596, 95, 14, 1),
(5597, 95, 15, 1),
(5874, 134, 1, 3),
(5875, 134, 2, 3),
(6422, 73, 1, 1),
(6423, 73, 11, 1),
(6424, 73, 13, 1),
(6425, 73, 14, 1),
(6426, 73, 15, 1),
(6427, 74, 1, 1),
(6428, 75, 1, 1),
(6429, 76, 1, 1),
(6430, 110, 1, 1),
(6431, 110, 3, 1),
(6432, 110, 11, 1),
(6433, 110, 13, 1),
(6960, 39, 1, 7),
(6961, 39, 3, 7),
(7078, 77, 1, 6),
(7079, 77, 2, 6),
(7080, 77, 3, 6),
(7081, 77, 4, 6),
(7082, 77, 11, 6),
(7083, 77, 15, 6),
(7084, 78, 1, 6),
(7085, 112, 1, 6),
(7118, 79, 1, 6),
(7119, 79, 3, 6),
(7120, 79, 14, 6),
(7121, 79, 15, 6),
(7122, 80, 1, 6),
(7123, 81, 1, 6),
(7124, 82, 1, 6),
(7125, 83, 1, 6),
(7126, 114, 1, 6),
(7676, 50, 1, 7),
(7677, 50, 2, 7),
(7678, 50, 3, 7),
(7679, 50, 4, 7),
(7680, 50, 5, 7),
(7681, 50, 6, 7),
(7682, 50, 7, 7),
(7683, 50, 8, 7),
(7684, 50, 9, 7),
(7685, 50, 10, 7),
(7686, 50, 11, 7),
(7687, 50, 12, 7),
(7688, 50, 13, 7),
(7689, 50, 14, 7),
(7690, 50, 15, 7),
(7691, 51, 1, 7),
(7692, 51, 2, 7),
(7693, 51, 3, 7),
(7694, 51, 4, 7),
(7695, 51, 5, 7),
(7696, 51, 6, 7),
(7697, 51, 7, 7),
(7698, 51, 8, 7),
(7699, 51, 9, 7),
(7700, 51, 10, 7),
(7701, 51, 11, 7),
(7702, 51, 12, 7),
(7703, 51, 13, 7),
(7704, 51, 14, 7),
(7705, 51, 15, 7),
(7706, 52, 1, 7),
(7707, 52, 2, 7),
(7708, 52, 3, 7),
(7709, 52, 4, 7),
(7710, 52, 5, 7),
(7711, 52, 6, 7),
(7712, 52, 7, 7),
(7713, 52, 8, 7),
(7714, 52, 9, 7),
(7715, 52, 10, 7),
(7716, 52, 11, 7),
(7717, 52, 12, 7),
(7718, 52, 13, 7),
(7719, 52, 14, 7),
(7720, 52, 15, 7),
(7721, 53, 1, 7),
(7722, 53, 2, 7),
(7723, 53, 3, 7),
(7724, 53, 4, 7),
(7725, 53, 5, 7),
(7726, 53, 6, 7),
(7727, 53, 7, 7),
(7728, 53, 8, 7),
(7729, 53, 9, 7),
(7730, 53, 10, 7),
(7731, 53, 11, 7),
(7732, 53, 12, 7),
(7733, 53, 13, 7),
(7734, 53, 14, 7),
(7735, 53, 15, 7),
(7736, 54, 1, 7),
(7737, 54, 2, 7),
(7738, 54, 3, 7),
(7739, 54, 4, 7),
(7740, 54, 5, 7),
(7741, 54, 6, 7),
(7742, 54, 7, 7),
(7743, 54, 8, 7),
(7744, 54, 9, 7),
(7745, 54, 10, 7),
(7746, 54, 11, 7),
(7747, 54, 12, 7),
(7748, 54, 13, 7),
(7749, 54, 14, 7),
(7750, 54, 15, 7),
(7751, 55, 1, 7),
(7752, 55, 2, 7),
(7753, 55, 3, 7),
(7754, 55, 4, 7),
(7755, 55, 5, 7),
(7756, 55, 6, 7),
(7757, 55, 10, 7),
(7758, 55, 12, 7),
(7759, 55, 13, 7),
(7760, 55, 14, 7),
(7761, 55, 15, 7),
(7877, 57, 1, 9),
(7878, 57, 3, 9),
(7879, 58, 1, 9),
(7880, 58, 3, 9),
(7881, 59, 1, 9),
(7882, 59, 3, 9),
(7883, 60, 1, 9),
(7884, 60, 3, 9),
(7885, 60, 4, 9),
(7886, 60, 13, 9),
(7887, 60, 14, 9),
(7888, 60, 15, 9),
(7889, 61, 1, 9),
(7890, 61, 3, 9),
(7891, 61, 4, 9),
(7892, 61, 13, 9),
(7893, 61, 14, 9),
(7894, 61, 15, 9),
(7895, 62, 1, 9),
(7896, 62, 3, 9),
(7897, 62, 4, 9),
(7898, 62, 13, 9),
(7899, 62, 14, 9),
(7900, 62, 15, 9),
(7901, 63, 1, 9),
(7902, 63, 3, 9),
(7903, 63, 4, 9),
(7904, 63, 13, 9),
(7905, 63, 14, 9),
(7906, 63, 15, 9),
(7907, 64, 1, 9),
(7908, 64, 3, 9),
(7909, 64, 4, 9),
(7910, 64, 13, 9),
(7911, 64, 14, 9),
(7912, 64, 15, 9),
(7913, 65, 1, 9),
(7914, 65, 3, 9),
(7915, 65, 4, 9),
(7916, 65, 13, 9),
(7917, 65, 14, 9),
(7918, 65, 15, 9),
(7919, 66, 1, 9),
(7920, 66, 3, 9),
(7921, 66, 4, 9),
(7922, 66, 13, 9),
(7923, 66, 14, 9),
(7924, 66, 15, 9),
(7925, 68, 1, 9),
(7926, 68, 2, 9),
(7927, 68, 3, 9),
(7928, 68, 4, 9),
(7929, 68, 5, 9),
(7930, 68, 10, 9),
(7931, 68, 11, 9),
(7932, 68, 12, 9),
(7933, 68, 13, 9),
(7934, 68, 14, 9),
(7935, 68, 15, 9),
(7936, 69, 1, 9),
(7937, 69, 2, 9),
(7938, 69, 3, 9),
(7939, 69, 4, 9),
(7940, 69, 5, 9),
(7941, 69, 10, 9),
(7942, 69, 11, 9),
(7943, 69, 12, 9),
(7944, 69, 13, 9),
(7945, 69, 14, 9),
(7946, 69, 15, 9),
(7947, 70, 1, 9),
(7948, 70, 2, 9),
(7949, 70, 3, 9),
(7950, 70, 4, 9),
(7951, 70, 5, 9),
(7952, 70, 10, 9),
(7953, 70, 11, 9),
(7954, 70, 12, 9),
(7955, 70, 13, 9),
(7956, 70, 14, 9),
(7957, 70, 15, 9),
(7958, 71, 1, 9),
(7996, 87, 1, 1),
(7997, 87, 2, 1),
(7998, 87, 3, 1),
(7999, 87, 4, 1),
(8000, 87, 5, 1),
(8001, 87, 10, 1),
(8002, 87, 13, 1),
(8003, 87, 14, 1),
(8004, 87, 15, 1),
(8005, 88, 1, 1),
(8006, 89, 1, 1),
(8044, 68, 1, 7),
(8045, 68, 2, 7),
(8046, 68, 3, 7),
(8047, 68, 4, 7),
(8048, 68, 5, 7),
(8049, 68, 6, 7),
(8050, 68, 8, 7),
(8051, 68, 10, 7),
(8052, 68, 12, 7),
(8053, 68, 13, 7),
(8054, 68, 14, 7),
(8055, 68, 15, 7),
(8056, 69, 1, 7),
(8057, 69, 2, 7),
(8058, 69, 3, 7),
(8059, 69, 4, 7),
(8060, 69, 5, 7),
(8061, 69, 6, 7),
(8062, 69, 8, 7),
(8063, 69, 10, 7),
(8064, 69, 12, 7),
(8065, 69, 13, 7),
(8066, 69, 14, 7),
(8067, 69, 15, 7),
(8068, 70, 1, 7),
(8069, 70, 2, 7),
(8070, 70, 3, 7),
(8071, 70, 4, 7),
(8072, 70, 5, 7),
(8073, 70, 6, 7),
(8074, 70, 8, 7),
(8075, 70, 10, 7),
(8076, 70, 12, 7),
(8077, 70, 13, 7),
(8078, 70, 14, 7),
(8079, 70, 15, 7),
(8080, 71, 1, 7),
(8081, 1, 1, 7),
(8082, 1, 2, 7),
(8083, 1, 3, 7),
(8084, 1, 4, 7),
(8085, 1, 5, 7),
(8086, 1, 10, 7),
(8087, 1, 11, 7),
(8088, 1, 12, 7),
(8089, 1, 13, 7),
(8090, 1, 14, 7),
(8091, 1, 15, 7),
(8092, 2, 1, 7),
(8093, 3, 1, 7),
(8094, 4, 1, 7),
(8095, 4, 2, 7),
(8096, 4, 3, 7),
(8097, 4, 4, 7),
(8098, 4, 5, 7),
(8099, 4, 10, 7),
(8100, 4, 11, 7),
(8101, 4, 12, 7),
(8102, 4, 13, 7),
(8103, 4, 14, 7),
(8104, 4, 15, 7),
(8105, 5, 1, 7),
(8106, 5, 2, 7),
(8107, 5, 3, 7),
(8108, 5, 4, 7),
(8109, 5, 5, 7),
(8110, 5, 10, 7),
(8111, 5, 11, 7),
(8112, 5, 12, 7),
(8113, 5, 13, 7),
(8114, 5, 14, 7),
(8115, 5, 15, 7),
(8116, 6, 1, 7),
(8117, 6, 2, 7),
(8118, 6, 3, 7),
(8119, 6, 4, 7),
(8120, 6, 5, 7),
(8121, 6, 10, 7),
(8122, 6, 11, 7),
(8123, 6, 12, 7),
(8124, 6, 13, 7),
(8125, 6, 14, 7),
(8126, 6, 15, 7),
(8127, 7, 1, 7),
(8128, 7, 2, 7),
(8129, 7, 3, 7),
(8130, 7, 4, 7),
(8131, 7, 5, 7),
(8132, 7, 10, 7),
(8133, 7, 11, 7),
(8134, 7, 12, 7),
(8135, 7, 13, 7),
(8136, 7, 14, 7),
(8137, 7, 15, 7),
(8138, 8, 1, 7),
(8139, 8, 2, 7),
(8140, 8, 3, 7),
(8141, 8, 4, 7),
(8142, 8, 5, 7),
(8143, 8, 10, 7),
(8144, 8, 11, 7),
(8145, 8, 12, 7),
(8146, 8, 13, 7),
(8147, 8, 14, 7),
(8148, 8, 15, 7),
(8149, 9, 1, 7),
(8150, 9, 2, 7),
(8151, 9, 3, 7),
(8152, 9, 4, 7),
(8153, 9, 5, 7),
(8154, 9, 10, 7),
(8155, 9, 11, 7),
(8156, 9, 12, 7),
(8157, 9, 13, 7),
(8158, 9, 14, 7),
(8159, 9, 15, 7),
(8160, 10, 1, 7),
(8161, 10, 2, 7),
(8162, 10, 3, 7),
(8163, 10, 4, 7),
(8164, 10, 5, 7),
(8165, 10, 10, 7),
(8166, 10, 11, 7),
(8167, 10, 12, 7),
(8168, 10, 13, 7),
(8169, 10, 14, 7),
(8170, 10, 15, 7),
(8171, 11, 1, 7),
(8172, 11, 2, 7),
(8173, 11, 3, 7),
(8174, 11, 4, 7),
(8175, 11, 5, 7),
(8176, 11, 10, 7),
(8177, 11, 11, 7),
(8178, 11, 12, 7),
(8179, 11, 13, 7),
(8180, 11, 14, 7),
(8181, 11, 15, 7),
(8182, 12, 1, 7),
(8183, 12, 2, 7),
(8184, 12, 3, 7),
(8185, 12, 4, 7),
(8186, 12, 5, 7),
(8187, 12, 10, 7),
(8188, 12, 11, 7),
(8189, 12, 12, 7),
(8190, 12, 13, 7),
(8191, 12, 14, 7),
(8192, 12, 15, 7),
(8193, 13, 1, 7),
(8194, 13, 2, 7),
(8195, 13, 3, 7),
(8196, 13, 4, 7),
(8197, 13, 5, 7),
(8198, 13, 10, 7),
(8199, 13, 11, 7),
(8200, 13, 12, 7),
(8201, 13, 13, 7),
(8202, 13, 14, 7),
(8203, 13, 15, 7),
(8204, 14, 1, 7),
(8205, 14, 2, 7),
(8206, 14, 3, 7),
(8207, 14, 4, 7),
(8208, 14, 5, 7),
(8209, 14, 10, 7),
(8210, 14, 11, 7),
(8211, 14, 12, 7),
(8212, 14, 13, 7),
(8213, 14, 14, 7),
(8214, 14, 15, 7),
(8215, 15, 1, 7),
(8216, 15, 2, 7),
(8217, 15, 3, 7),
(8218, 15, 4, 7),
(8219, 15, 5, 7),
(8220, 15, 10, 7),
(8221, 15, 12, 7),
(8222, 15, 13, 7),
(8223, 15, 14, 7),
(8224, 15, 15, 7),
(8225, 16, 1, 7),
(8226, 16, 15, 7),
(8227, 17, 1, 7),
(8228, 18, 1, 7),
(8229, 18, 2, 7),
(8230, 18, 3, 7),
(8231, 18, 4, 7),
(8232, 18, 5, 7),
(8233, 18, 10, 7),
(8234, 18, 12, 7),
(8235, 18, 13, 7),
(8236, 18, 14, 7),
(8237, 18, 15, 7),
(8238, 19, 1, 7),
(8239, 19, 2, 7),
(8240, 19, 3, 7),
(8241, 19, 4, 7),
(8242, 19, 5, 7),
(8243, 19, 10, 7),
(8244, 19, 12, 7),
(8245, 19, 13, 7),
(8246, 19, 14, 7),
(8247, 19, 15, 7),
(8302, 84, 1, 2),
(8303, 84, 2, 2),
(8304, 84, 3, 2),
(8305, 84, 4, 2),
(8306, 84, 5, 2),
(8307, 84, 7, 2),
(8308, 84, 10, 2),
(8309, 84, 11, 2),
(8310, 84, 12, 2),
(8311, 84, 13, 2),
(8312, 84, 14, 2),
(8313, 84, 15, 2),
(8314, 85, 1, 2),
(8315, 113, 1, 2),
(8316, 137, 1, 2),
(8317, 137, 2, 2),
(8318, 137, 4, 2),
(8319, 137, 5, 2),
(8320, 137, 7, 2),
(8321, 137, 10, 2),
(8322, 137, 11, 2),
(8323, 137, 12, 2),
(8324, 137, 13, 2),
(8325, 137, 14, 2),
(8326, 137, 15, 2),
(8327, 50, 1, 2),
(8328, 50, 2, 2),
(8329, 50, 3, 2),
(8330, 50, 4, 2),
(8331, 50, 6, 2),
(8332, 50, 10, 2),
(8333, 50, 11, 2),
(8334, 50, 12, 2),
(8335, 50, 13, 2),
(8336, 50, 14, 2),
(8337, 50, 15, 2),
(8338, 51, 1, 2),
(8339, 51, 2, 2),
(8340, 51, 3, 2),
(8341, 51, 4, 2),
(8342, 51, 6, 2),
(8343, 51, 10, 2),
(8344, 51, 11, 2),
(8345, 51, 12, 2),
(8346, 51, 13, 2),
(8347, 51, 14, 2),
(8348, 51, 15, 2),
(8349, 52, 1, 2),
(8350, 52, 2, 2),
(8351, 52, 3, 2),
(8352, 52, 4, 2),
(8353, 52, 6, 2),
(8354, 52, 10, 2),
(8355, 52, 11, 2),
(8356, 52, 12, 2),
(8357, 52, 13, 2),
(8358, 52, 14, 2),
(8359, 52, 15, 2),
(8360, 53, 1, 2),
(8361, 53, 2, 2),
(8362, 53, 3, 2),
(8363, 53, 4, 2),
(8364, 53, 6, 2),
(8365, 53, 10, 2),
(8366, 53, 11, 2),
(8367, 53, 12, 2),
(8368, 53, 13, 2),
(8369, 53, 14, 2),
(8370, 53, 15, 2),
(8371, 54, 1, 2),
(8372, 54, 2, 2),
(8373, 54, 3, 2),
(8374, 54, 4, 2),
(8375, 54, 6, 2),
(8376, 54, 10, 2),
(8377, 54, 11, 2),
(8378, 54, 12, 2),
(8379, 54, 13, 2),
(8380, 54, 14, 2),
(8381, 54, 15, 2),
(8382, 55, 1, 2),
(8383, 55, 2, 2),
(8384, 55, 3, 2),
(8385, 55, 4, 2),
(8386, 55, 5, 2),
(8387, 55, 6, 2),
(8388, 55, 8, 2),
(8389, 55, 10, 2),
(8390, 55, 12, 2),
(8391, 55, 13, 2),
(8392, 55, 14, 2),
(8393, 55, 15, 2),
(8505, 84, 1, 6),
(8506, 84, 2, 6),
(8507, 84, 3, 6),
(8508, 84, 4, 6),
(8509, 84, 5, 6),
(8510, 84, 6, 6),
(8511, 84, 7, 6),
(8512, 84, 8, 6),
(8513, 84, 9, 6),
(8514, 84, 10, 6),
(8515, 84, 11, 6),
(8516, 84, 12, 6),
(8517, 84, 13, 6),
(8518, 84, 14, 6),
(8519, 84, 15, 6),
(8520, 85, 1, 6),
(8521, 113, 1, 6),
(8522, 137, 1, 6),
(8523, 137, 2, 6),
(8524, 137, 4, 6),
(8525, 137, 5, 6),
(8526, 137, 6, 6),
(8527, 137, 7, 6),
(8528, 137, 8, 6),
(8529, 137, 9, 6),
(8530, 137, 10, 6),
(8531, 137, 11, 6),
(8532, 137, 12, 6),
(8533, 137, 13, 6),
(8534, 137, 14, 6),
(8535, 137, 15, 6),
(8536, 86, 1, 6),
(8537, 68, 1, 1),
(8538, 68, 2, 1),
(8539, 68, 3, 1),
(8540, 68, 4, 1),
(8541, 68, 5, 1),
(8542, 68, 6, 1),
(8543, 68, 7, 1),
(8544, 68, 8, 1),
(8545, 68, 9, 1),
(8546, 68, 10, 1),
(8547, 68, 11, 1),
(8548, 68, 12, 1),
(8549, 68, 13, 1),
(8550, 68, 14, 1),
(8551, 68, 15, 1),
(8552, 69, 1, 1),
(8553, 69, 2, 1),
(8554, 69, 3, 1),
(8555, 69, 4, 1),
(8556, 69, 5, 1),
(8557, 69, 6, 1),
(8558, 69, 7, 1),
(8559, 69, 8, 1),
(8560, 69, 9, 1),
(8561, 69, 10, 1),
(8562, 69, 11, 1),
(8563, 69, 12, 1),
(8564, 69, 13, 1),
(8565, 69, 14, 1),
(8566, 69, 15, 1),
(8567, 70, 1, 1),
(8568, 70, 2, 1),
(8569, 70, 3, 1),
(8570, 70, 4, 1),
(8571, 70, 5, 1),
(8572, 70, 6, 1),
(8573, 70, 7, 1),
(8574, 70, 8, 1),
(8575, 70, 9, 1),
(8576, 70, 10, 1),
(8577, 70, 11, 1),
(8578, 70, 12, 1),
(8579, 70, 13, 1),
(8580, 70, 14, 1),
(8581, 70, 15, 1),
(8582, 71, 1, 1),
(8830, 84, 1, 1),
(8831, 84, 2, 1),
(8832, 84, 3, 1),
(8833, 84, 4, 1),
(8834, 84, 5, 1),
(8835, 84, 6, 1),
(8836, 84, 7, 1),
(8837, 84, 10, 1),
(8838, 84, 11, 1),
(8839, 84, 12, 1),
(8840, 84, 13, 1),
(8841, 84, 14, 1),
(8842, 84, 15, 1),
(8843, 85, 1, 1),
(8844, 113, 1, 1),
(8845, 137, 1, 1),
(8846, 137, 2, 1),
(8847, 137, 4, 1),
(8848, 137, 5, 1),
(8849, 137, 6, 1),
(8850, 137, 7, 1),
(8851, 137, 10, 1),
(8852, 137, 11, 1),
(8853, 137, 12, 1),
(8854, 137, 13, 1),
(8855, 137, 14, 1),
(8856, 137, 15, 1),
(8857, 86, 1, 1),
(10021, 50, 1, 6),
(10022, 50, 2, 6),
(10023, 50, 3, 6),
(10024, 50, 4, 6),
(10025, 50, 5, 6),
(10026, 50, 10, 6),
(10027, 50, 14, 6),
(10028, 50, 15, 6),
(10029, 51, 1, 6),
(10030, 51, 2, 6),
(10031, 51, 3, 6),
(10032, 51, 4, 6),
(10033, 51, 5, 6),
(10034, 51, 10, 6),
(10035, 51, 14, 6),
(10036, 51, 15, 6),
(10037, 52, 1, 6),
(10038, 52, 2, 6),
(10039, 52, 3, 6),
(10040, 52, 4, 6),
(10041, 52, 5, 6),
(10042, 52, 10, 6),
(10043, 52, 14, 6),
(10044, 52, 15, 6),
(10045, 53, 1, 6),
(10046, 53, 2, 6),
(10047, 53, 3, 6),
(10048, 53, 4, 6),
(10049, 53, 5, 6),
(10050, 53, 10, 6),
(10051, 53, 14, 6),
(10052, 53, 15, 6),
(10053, 54, 1, 6),
(10054, 54, 2, 6),
(10055, 54, 3, 6),
(10056, 54, 4, 6),
(10057, 54, 5, 6),
(10058, 54, 10, 6),
(10059, 54, 14, 6),
(10060, 54, 15, 6),
(10061, 55, 1, 6),
(10062, 55, 2, 6),
(10063, 55, 3, 6),
(10064, 55, 4, 6),
(10065, 55, 5, 6),
(10066, 55, 6, 6),
(10067, 55, 10, 6),
(10068, 55, 12, 6),
(10069, 55, 13, 6),
(10070, 55, 14, 6),
(10071, 55, 15, 6),
(10094, 87, 1, 5),
(10095, 87, 2, 5),
(10096, 87, 3, 5),
(10097, 87, 4, 5),
(10098, 87, 8, 5),
(10099, 87, 12, 5),
(10100, 87, 13, 5),
(10101, 87, 14, 5),
(10102, 87, 15, 5),
(10103, 88, 1, 5),
(10104, 89, 1, 5),
(10151, 73, 1, 5),
(10152, 73, 2, 5),
(10153, 73, 3, 5),
(10154, 73, 4, 5),
(10155, 73, 5, 5),
(10156, 73, 6, 5),
(10157, 73, 8, 5),
(10158, 73, 12, 5),
(10159, 73, 13, 5),
(10160, 73, 14, 5),
(10161, 73, 15, 5),
(10162, 74, 1, 5),
(10163, 75, 1, 5),
(10164, 76, 1, 5),
(10165, 76, 2, 5),
(10166, 76, 3, 5),
(10167, 76, 4, 5),
(10168, 76, 5, 5),
(10169, 76, 6, 5),
(10170, 110, 1, 5),
(10171, 110, 2, 5),
(10172, 110, 3, 5),
(10173, 110, 4, 5),
(10174, 110, 5, 5),
(10175, 110, 6, 5),
(10176, 90, 1, 5),
(10177, 90, 2, 5),
(10178, 90, 3, 5),
(10179, 90, 4, 5),
(10180, 90, 5, 5),
(10181, 90, 8, 5),
(10182, 90, 12, 5),
(10183, 90, 13, 5),
(10184, 90, 14, 5),
(10185, 90, 15, 5),
(10186, 91, 1, 5),
(10190, 142, 1, 5),
(10191, 142, 2, 5),
(10192, 142, 3, 5),
(10193, 142, 4, 5),
(10194, 142, 5, 5),
(10195, 142, 15, 5),
(10261, 104, 1, 6),
(10262, 105, 1, 6),
(10263, 107, 1, 6),
(10264, 109, 1, 6),
(10533, 1, 1, 1),
(10534, 1, 2, 1),
(10535, 1, 3, 1),
(10536, 1, 4, 1),
(10537, 1, 5, 1),
(10538, 1, 6, 1),
(10539, 1, 7, 1),
(10540, 1, 8, 1),
(10541, 1, 9, 1),
(10542, 1, 10, 1),
(10543, 1, 11, 1),
(10544, 1, 12, 1),
(10545, 1, 13, 1),
(10546, 1, 14, 1),
(10547, 1, 15, 1),
(10548, 2, 1, 1),
(10549, 3, 1, 1),
(10550, 4, 1, 1),
(10551, 4, 2, 1),
(10552, 4, 3, 1),
(10553, 4, 4, 1),
(10554, 4, 5, 1),
(10555, 4, 6, 1),
(10556, 4, 7, 1),
(10557, 4, 8, 1),
(10558, 4, 9, 1),
(10559, 4, 10, 1),
(10560, 4, 11, 1),
(10561, 4, 12, 1),
(10562, 4, 13, 1),
(10563, 4, 14, 1),
(10564, 4, 15, 1),
(10565, 5, 1, 1),
(10566, 5, 2, 1),
(10567, 5, 3, 1),
(10568, 5, 4, 1),
(10569, 5, 5, 1),
(10570, 5, 6, 1),
(10571, 5, 7, 1),
(10572, 5, 8, 1),
(10573, 5, 9, 1),
(10574, 5, 10, 1),
(10575, 5, 11, 1),
(10576, 5, 12, 1),
(10577, 5, 13, 1),
(10578, 5, 14, 1),
(10579, 5, 15, 1),
(10580, 6, 1, 1),
(10581, 6, 2, 1),
(10582, 6, 3, 1),
(10583, 6, 4, 1),
(10584, 6, 5, 1),
(10585, 6, 6, 1),
(10586, 6, 7, 1),
(10587, 6, 8, 1),
(10588, 6, 9, 1),
(10589, 6, 10, 1),
(10590, 6, 11, 1),
(10591, 6, 12, 1),
(10592, 6, 13, 1),
(10593, 6, 14, 1),
(10594, 6, 15, 1),
(10595, 7, 1, 1),
(10596, 7, 2, 1),
(10597, 7, 3, 1),
(10598, 7, 4, 1),
(10599, 7, 5, 1),
(10600, 7, 6, 1),
(10601, 7, 7, 1),
(10602, 7, 8, 1),
(10603, 7, 9, 1),
(10604, 7, 10, 1),
(10605, 7, 11, 1),
(10606, 7, 12, 1),
(10607, 7, 13, 1),
(10608, 7, 14, 1),
(10609, 7, 15, 1),
(10610, 8, 1, 1),
(10611, 8, 2, 1),
(10612, 8, 3, 1),
(10613, 8, 4, 1),
(10614, 8, 5, 1),
(10615, 8, 6, 1),
(10616, 8, 7, 1),
(10617, 8, 8, 1),
(10618, 8, 9, 1),
(10619, 8, 10, 1),
(10620, 8, 11, 1),
(10621, 8, 12, 1),
(10622, 8, 13, 1),
(10623, 8, 14, 1),
(10624, 8, 15, 1),
(10625, 9, 1, 1),
(10626, 9, 2, 1),
(10627, 9, 3, 1),
(10628, 9, 4, 1),
(10629, 9, 5, 1),
(10630, 9, 6, 1),
(10631, 9, 7, 1),
(10632, 9, 8, 1),
(10633, 9, 9, 1),
(10634, 9, 10, 1),
(10635, 9, 11, 1),
(10636, 9, 12, 1),
(10637, 9, 13, 1),
(10638, 9, 14, 1),
(10639, 9, 15, 1),
(10640, 10, 1, 1),
(10641, 10, 2, 1),
(10642, 10, 3, 1),
(10643, 10, 4, 1),
(10644, 10, 5, 1),
(10645, 10, 6, 1),
(10646, 10, 7, 1),
(10647, 10, 8, 1),
(10648, 10, 9, 1),
(10649, 10, 10, 1),
(10650, 10, 11, 1),
(10651, 10, 12, 1),
(10652, 10, 13, 1),
(10653, 10, 14, 1),
(10654, 10, 15, 1),
(10655, 11, 1, 1),
(10656, 11, 2, 1),
(10657, 11, 3, 1),
(10658, 11, 4, 1),
(10659, 11, 5, 1),
(10660, 11, 6, 1),
(10661, 11, 7, 1),
(10662, 11, 8, 1),
(10663, 11, 9, 1),
(10664, 11, 10, 1),
(10665, 11, 11, 1),
(10666, 11, 12, 1),
(10667, 11, 13, 1),
(10668, 11, 14, 1),
(10669, 11, 15, 1),
(10670, 12, 1, 1),
(10671, 12, 2, 1),
(10672, 12, 3, 1),
(10673, 12, 4, 1),
(10674, 12, 5, 1),
(10675, 12, 6, 1),
(10676, 12, 7, 1),
(10677, 12, 8, 1),
(10678, 12, 9, 1),
(10679, 12, 10, 1),
(10680, 12, 11, 1),
(10681, 12, 12, 1),
(10682, 12, 13, 1),
(10683, 12, 14, 1),
(10684, 12, 15, 1),
(10685, 13, 1, 1),
(10686, 13, 2, 1),
(10687, 13, 3, 1),
(10688, 13, 4, 1),
(10689, 13, 5, 1),
(10690, 13, 6, 1),
(10691, 13, 7, 1),
(10692, 13, 8, 1),
(10693, 13, 9, 1),
(10694, 13, 10, 1),
(10695, 13, 11, 1),
(10696, 13, 12, 1),
(10697, 13, 13, 1),
(10698, 13, 14, 1),
(10699, 13, 15, 1),
(10700, 14, 1, 1),
(10701, 14, 2, 1),
(10702, 14, 3, 1),
(10703, 14, 4, 1),
(10704, 14, 5, 1),
(10705, 14, 6, 1),
(10706, 14, 7, 1),
(10707, 14, 8, 1),
(10708, 14, 9, 1),
(10709, 14, 10, 1),
(10710, 14, 11, 1),
(10711, 14, 12, 1),
(10712, 14, 13, 1),
(10713, 14, 14, 1),
(10714, 14, 15, 1),
(10813, 15, 1, 2),
(10814, 15, 2, 2),
(10815, 15, 3, 2),
(10816, 15, 4, 2),
(10817, 15, 5, 2),
(10818, 15, 8, 2),
(10819, 15, 10, 2),
(10820, 15, 12, 2),
(10821, 15, 13, 2),
(10822, 15, 14, 2),
(10823, 15, 15, 2),
(10824, 16, 1, 2),
(10825, 16, 15, 2),
(10826, 17, 1, 2),
(10827, 18, 1, 2),
(10828, 18, 2, 2),
(10829, 18, 3, 2),
(10830, 18, 4, 2),
(10831, 18, 5, 2),
(10832, 18, 8, 2),
(10833, 18, 10, 2),
(10834, 18, 12, 2),
(10835, 18, 13, 2),
(10836, 18, 14, 2),
(10837, 18, 15, 2),
(10838, 19, 1, 2),
(10839, 19, 2, 2),
(10840, 19, 3, 2),
(10841, 19, 4, 2),
(10842, 19, 5, 2),
(10843, 19, 8, 2),
(10844, 19, 10, 2),
(10845, 19, 12, 2),
(10846, 19, 13, 2),
(10847, 19, 14, 2),
(10848, 19, 15, 2),
(10947, 15, 1, 6),
(10948, 16, 1, 6),
(10949, 17, 1, 6),
(10950, 18, 1, 6),
(10951, 19, 1, 6),
(10952, 21, 1, 6),
(10953, 21, 3, 6),
(10954, 104, 1, 1),
(10955, 105, 1, 1),
(10956, 106, 1, 1),
(10957, 107, 1, 1),
(10958, 108, 1, 1),
(10959, 109, 1, 1),
(10960, 136, 1, 1),
(11052, 104, 1, 2),
(11053, 105, 1, 2),
(11054, 107, 1, 2),
(11055, 136, 1, 2),
(11121, 97, 1, 6),
(11122, 97, 2, 6),
(11123, 97, 3, 6),
(11124, 97, 4, 6),
(11125, 97, 5, 6),
(11126, 97, 10, 6),
(11127, 97, 15, 6),
(11134, 99, 1, 6),
(11135, 100, 1, 6),
(11136, 98, 1, 6),
(11137, 98, 2, 6),
(11138, 98, 3, 6),
(11139, 98, 4, 6),
(11140, 98, 14, 6),
(11141, 98, 15, 6),
(11142, 1, 1, 6),
(11143, 1, 2, 6),
(11144, 1, 3, 6),
(11145, 1, 4, 6),
(11146, 1, 10, 6),
(11147, 1, 11, 6),
(11148, 1, 12, 6),
(11149, 1, 13, 6),
(11150, 1, 14, 6),
(11151, 1, 15, 6),
(11152, 2, 1, 6),
(11153, 3, 1, 6),
(11154, 4, 1, 6),
(11155, 4, 2, 6),
(11156, 4, 3, 6),
(11157, 4, 4, 6),
(11158, 4, 10, 6),
(11159, 4, 11, 6),
(11160, 4, 12, 6),
(11161, 4, 13, 6),
(11162, 4, 14, 6),
(11163, 4, 15, 6),
(11164, 5, 1, 6),
(11165, 5, 2, 6),
(11166, 5, 3, 6),
(11167, 5, 4, 6),
(11168, 5, 10, 6),
(11169, 5, 11, 6),
(11170, 5, 12, 6),
(11171, 5, 13, 6),
(11172, 5, 14, 6),
(11173, 5, 15, 6),
(11174, 6, 1, 6),
(11175, 6, 2, 6),
(11176, 6, 3, 6),
(11177, 6, 4, 6),
(11178, 6, 10, 6),
(11179, 6, 11, 6),
(11180, 6, 12, 6),
(11181, 6, 13, 6),
(11182, 6, 14, 6),
(11183, 6, 15, 6),
(11184, 7, 1, 6),
(11185, 7, 2, 6),
(11186, 7, 3, 6),
(11187, 7, 4, 6),
(11188, 7, 10, 6),
(11189, 7, 11, 6),
(11190, 7, 12, 6),
(11191, 7, 13, 6),
(11192, 7, 14, 6),
(11193, 7, 15, 6),
(11194, 8, 1, 6),
(11195, 8, 2, 6),
(11196, 8, 3, 6),
(11197, 8, 4, 6),
(11198, 8, 10, 6),
(11199, 8, 11, 6),
(11200, 8, 12, 6),
(11201, 8, 13, 6),
(11202, 8, 14, 6),
(11203, 8, 15, 6),
(11204, 9, 1, 6),
(11205, 9, 2, 6),
(11206, 9, 3, 6),
(11207, 9, 4, 6),
(11208, 9, 10, 6),
(11209, 9, 11, 6),
(11210, 9, 12, 6),
(11211, 9, 13, 6),
(11212, 9, 14, 6),
(11213, 9, 15, 6),
(11214, 10, 1, 6),
(11215, 10, 2, 6),
(11216, 10, 3, 6),
(11217, 10, 4, 6),
(11218, 10, 10, 6),
(11219, 10, 11, 6),
(11220, 10, 12, 6),
(11221, 10, 13, 6),
(11222, 10, 14, 6),
(11223, 10, 15, 6),
(11224, 11, 1, 6),
(11225, 11, 2, 6),
(11226, 11, 3, 6),
(11227, 11, 4, 6),
(11228, 11, 10, 6),
(11229, 11, 11, 6),
(11230, 11, 12, 6),
(11231, 11, 13, 6),
(11232, 11, 14, 6),
(11233, 11, 15, 6),
(11234, 12, 1, 6),
(11235, 12, 2, 6),
(11236, 12, 3, 6),
(11237, 12, 4, 6),
(11238, 12, 10, 6),
(11239, 12, 11, 6),
(11240, 12, 12, 6),
(11241, 12, 13, 6),
(11242, 12, 14, 6),
(11243, 12, 15, 6),
(11244, 13, 1, 6),
(11245, 13, 2, 6),
(11246, 13, 3, 6),
(11247, 13, 4, 6),
(11248, 13, 10, 6),
(11249, 13, 11, 6),
(11250, 13, 12, 6),
(11251, 13, 13, 6),
(11252, 13, 14, 6),
(11253, 13, 15, 6),
(11254, 14, 1, 6),
(11255, 14, 2, 6),
(11256, 14, 3, 6),
(11257, 14, 4, 6),
(11258, 14, 10, 6),
(11259, 14, 11, 6),
(11260, 14, 12, 6),
(11261, 14, 13, 6),
(11262, 14, 14, 6),
(11263, 14, 15, 6),
(11376, 32, 1, 3),
(11377, 32, 2, 3),
(11378, 32, 3, 3),
(11379, 32, 4, 3),
(11380, 32, 5, 3),
(11381, 32, 6, 3),
(11382, 32, 7, 3),
(11383, 32, 10, 3),
(11384, 32, 11, 3),
(11385, 32, 12, 3),
(11386, 32, 13, 3),
(11387, 32, 14, 3),
(11388, 32, 15, 3),
(11389, 33, 1, 3),
(11390, 33, 2, 3),
(11391, 33, 3, 3),
(11392, 33, 4, 3),
(11393, 33, 5, 3),
(11394, 33, 6, 3),
(11395, 33, 7, 3),
(11396, 33, 10, 3),
(11397, 33, 11, 3),
(11398, 33, 12, 3),
(11399, 33, 13, 3),
(11400, 33, 14, 3),
(11401, 33, 15, 3),
(11402, 34, 1, 3),
(11403, 34, 2, 3),
(11404, 34, 3, 3),
(11405, 34, 4, 3),
(11406, 34, 5, 3),
(11407, 34, 6, 3),
(11408, 34, 7, 3),
(11409, 34, 10, 3),
(11410, 34, 11, 3),
(11411, 34, 12, 3),
(11412, 34, 13, 3),
(11413, 34, 14, 3),
(11414, 34, 15, 3),
(11415, 35, 1, 3),
(11416, 35, 2, 3),
(11417, 35, 3, 3),
(11418, 35, 4, 3),
(11419, 35, 5, 3),
(11420, 35, 6, 3),
(11421, 35, 7, 3),
(11422, 35, 10, 3),
(11423, 35, 11, 3),
(11424, 35, 12, 3),
(11425, 35, 13, 3),
(11426, 35, 14, 3),
(11427, 35, 15, 3),
(11428, 36, 1, 3),
(11429, 36, 2, 3),
(11430, 36, 3, 3),
(11431, 36, 4, 3),
(11432, 36, 5, 3),
(11433, 36, 6, 3),
(11434, 36, 7, 3),
(11435, 36, 10, 3),
(11436, 36, 11, 3),
(11437, 36, 12, 3),
(11438, 36, 13, 3),
(11439, 36, 14, 3),
(11440, 36, 15, 3),
(11441, 115, 1, 3),
(11442, 115, 2, 3),
(11443, 115, 3, 3),
(11444, 115, 4, 3),
(11445, 115, 5, 3),
(11446, 115, 6, 3),
(11447, 115, 7, 3),
(11448, 115, 10, 3),
(11449, 115, 11, 3),
(11450, 115, 12, 3),
(11451, 115, 13, 3),
(11452, 115, 14, 3),
(11453, 115, 15, 3),
(11454, 124, 1, 3),
(11455, 124, 2, 3),
(11456, 124, 3, 3),
(11457, 124, 4, 3),
(11458, 124, 5, 3),
(11459, 124, 6, 3),
(11460, 124, 7, 3),
(11461, 124, 10, 3),
(11462, 124, 11, 3),
(11463, 124, 12, 3),
(11464, 124, 13, 3),
(11465, 124, 14, 3),
(11466, 124, 15, 3),
(11467, 126, 1, 3),
(11468, 126, 2, 3),
(11469, 126, 3, 3),
(11470, 126, 4, 3),
(11471, 126, 5, 3),
(11472, 126, 6, 3),
(11473, 126, 7, 3),
(11474, 126, 10, 3),
(11475, 126, 11, 3),
(11476, 126, 12, 3),
(11477, 126, 13, 3),
(11478, 126, 14, 3),
(11479, 126, 15, 3),
(11480, 127, 1, 3),
(11481, 127, 2, 3),
(11482, 127, 3, 3),
(11483, 127, 4, 3),
(11484, 127, 5, 3),
(11485, 127, 6, 3),
(11486, 127, 7, 3),
(11487, 127, 10, 3),
(11488, 40, 1, 3),
(11489, 40, 2, 3),
(11490, 40, 3, 3),
(11491, 40, 4, 3),
(11492, 40, 8, 3),
(11493, 40, 11, 3),
(11494, 40, 12, 3),
(11495, 40, 13, 3),
(11496, 40, 14, 3),
(11497, 40, 15, 3),
(11498, 41, 1, 3),
(11499, 41, 2, 3),
(11500, 41, 3, 3),
(11501, 41, 4, 3),
(11502, 41, 8, 3),
(11503, 41, 11, 3),
(11504, 41, 12, 3),
(11505, 41, 13, 3),
(11506, 41, 14, 3),
(11507, 41, 15, 3),
(11508, 42, 1, 3),
(11509, 42, 2, 3),
(11510, 42, 3, 3),
(11511, 42, 4, 3),
(11512, 42, 8, 3),
(11513, 42, 11, 3),
(11514, 42, 12, 3),
(11515, 42, 13, 3),
(11516, 42, 14, 3),
(11517, 42, 15, 3),
(11518, 43, 1, 3),
(11519, 43, 2, 3),
(11520, 43, 3, 3),
(11521, 43, 4, 3),
(11522, 43, 8, 3),
(11523, 43, 11, 3),
(11524, 43, 12, 3),
(11525, 43, 13, 3),
(11526, 43, 14, 3),
(11527, 43, 15, 3),
(11528, 44, 1, 3),
(11529, 44, 2, 3),
(11530, 44, 3, 3),
(11531, 44, 4, 3),
(11532, 44, 8, 3),
(11533, 44, 11, 3),
(11534, 44, 12, 3),
(11535, 44, 13, 3),
(11536, 44, 14, 3),
(11537, 44, 15, 3),
(11538, 45, 1, 3),
(11539, 45, 2, 3),
(11540, 45, 3, 3),
(11541, 45, 4, 3),
(11542, 45, 8, 3),
(11543, 45, 11, 3),
(11544, 45, 12, 3),
(11545, 45, 13, 3),
(11546, 45, 14, 3),
(11547, 45, 15, 3),
(11548, 46, 1, 3),
(11549, 46, 2, 3),
(11550, 46, 3, 3),
(11551, 46, 4, 3),
(11552, 46, 8, 3),
(11553, 46, 11, 3),
(11554, 46, 12, 3),
(11555, 46, 13, 3),
(11556, 46, 14, 3),
(11557, 46, 15, 3),
(11558, 47, 1, 3),
(11559, 47, 2, 3),
(11560, 47, 3, 3),
(11561, 47, 4, 3),
(11562, 47, 8, 3),
(11563, 47, 11, 3),
(11564, 47, 12, 3),
(11565, 47, 13, 3),
(11566, 47, 14, 3),
(11567, 47, 15, 3),
(11568, 48, 1, 3),
(11569, 48, 2, 3),
(11570, 48, 3, 3),
(11571, 48, 4, 3),
(11572, 48, 8, 3),
(11573, 48, 11, 3),
(11574, 48, 12, 3),
(11575, 48, 13, 3),
(11576, 48, 14, 3),
(11577, 48, 15, 3),
(11578, 37, 1, 3),
(11579, 37, 2, 3),
(11580, 37, 3, 3),
(11581, 37, 4, 3),
(11582, 37, 11, 3),
(11583, 37, 12, 3),
(11584, 37, 13, 3),
(11585, 37, 14, 3),
(11586, 37, 15, 3),
(11587, 38, 1, 3),
(11588, 38, 2, 3),
(11589, 38, 3, 3),
(11590, 38, 4, 3),
(11591, 38, 11, 3),
(11592, 38, 12, 3),
(11593, 38, 13, 3),
(11594, 38, 14, 3),
(11595, 38, 15, 3),
(11596, 128, 1, 3),
(11597, 128, 2, 3),
(11598, 128, 3, 3),
(11599, 128, 4, 3),
(11600, 128, 11, 3),
(11601, 128, 12, 3),
(11602, 128, 13, 3),
(11603, 128, 14, 3),
(11604, 128, 15, 3),
(11605, 129, 1, 3),
(11606, 129, 2, 3),
(11607, 129, 3, 3),
(11608, 129, 4, 3),
(11609, 129, 11, 3),
(11610, 129, 12, 3),
(11611, 129, 13, 3),
(11612, 129, 14, 3),
(11613, 129, 15, 3),
(11614, 130, 1, 3),
(11615, 130, 2, 3),
(11616, 130, 3, 3),
(11617, 130, 4, 3),
(11618, 130, 11, 3),
(11619, 130, 12, 3),
(11620, 130, 13, 3),
(11621, 130, 14, 3),
(11622, 130, 15, 3),
(11623, 131, 1, 3),
(11624, 131, 2, 3),
(11625, 131, 3, 3),
(11626, 131, 4, 3),
(11627, 131, 11, 3),
(11628, 131, 12, 3),
(11629, 131, 13, 3),
(11630, 131, 14, 3),
(11631, 131, 15, 3),
(11632, 132, 1, 3),
(11633, 132, 2, 3),
(11634, 132, 3, 3),
(11635, 132, 4, 3),
(11636, 132, 11, 3),
(11637, 132, 12, 3),
(11638, 132, 13, 3),
(11639, 132, 14, 3),
(11640, 132, 15, 3),
(11641, 133, 1, 3),
(11642, 133, 2, 3),
(11643, 133, 3, 3),
(11644, 133, 4, 3),
(11645, 133, 11, 3),
(11646, 133, 12, 3),
(11647, 133, 13, 3),
(11648, 133, 14, 3),
(11649, 133, 15, 3),
(11650, 55, 1, 3),
(11651, 55, 2, 3),
(11652, 39, 1, 3),
(11653, 39, 2, 3),
(11654, 39, 3, 3),
(11655, 39, 4, 3),
(11656, 39, 8, 3),
(11657, 39, 11, 3),
(11658, 39, 12, 3),
(11659, 39, 13, 3),
(11660, 39, 14, 3),
(11661, 39, 15, 3),
(11662, 68, 1, 6),
(11663, 68, 2, 6),
(11664, 68, 3, 6),
(11665, 68, 4, 6),
(11666, 68, 5, 6),
(11667, 68, 8, 6),
(11668, 68, 10, 6),
(11669, 68, 12, 6),
(11670, 68, 13, 6),
(11671, 68, 14, 6),
(11672, 68, 15, 6),
(11673, 69, 1, 6),
(11674, 69, 2, 6),
(11675, 69, 3, 6),
(11676, 69, 4, 6),
(11677, 69, 5, 6),
(11678, 69, 8, 6),
(11679, 69, 10, 6),
(11680, 69, 12, 6),
(11681, 69, 13, 6),
(11682, 69, 14, 6),
(11683, 69, 15, 6),
(11684, 70, 1, 6),
(11685, 70, 2, 6),
(11686, 70, 3, 6),
(11687, 70, 4, 6),
(11688, 70, 5, 6),
(11689, 70, 8, 6),
(11690, 70, 10, 6),
(11691, 70, 12, 6),
(11692, 70, 13, 6),
(11693, 70, 14, 6),
(11694, 70, 15, 6),
(11695, 71, 1, 6),
(11741, 104, 1, 5),
(11742, 106, 1, 5),
(11743, 109, 1, 5),
(11744, 39, 1, 5),
(11745, 39, 2, 5),
(11746, 39, 3, 5),
(11747, 39, 4, 5),
(11748, 39, 5, 5),
(11749, 39, 13, 5),
(11750, 39, 14, 5),
(11751, 39, 15, 5),
(11752, 134, 1, 5),
(11753, 134, 2, 5),
(11754, 134, 3, 5),
(11755, 134, 4, 5),
(11756, 134, 5, 5),
(11757, 134, 13, 5),
(11758, 134, 14, 5),
(11759, 134, 15, 5),
(11760, 135, 1, 5),
(11761, 135, 2, 5),
(11762, 135, 3, 5),
(11763, 135, 4, 5),
(11764, 135, 5, 5),
(11765, 135, 13, 5),
(11766, 135, 14, 5),
(11767, 135, 15, 5),
(11771, 60, 1, 2),
(11772, 60, 2, 2),
(11773, 60, 3, 2),
(11774, 60, 12, 2),
(11775, 60, 14, 2),
(11776, 60, 15, 2),
(11777, 61, 1, 2),
(11778, 61, 2, 2),
(11779, 61, 3, 2),
(11780, 61, 12, 2),
(11781, 61, 14, 2),
(11782, 61, 15, 2),
(11783, 62, 1, 2),
(11784, 62, 2, 2),
(11785, 62, 3, 2),
(11786, 62, 12, 2),
(11787, 62, 14, 2),
(11788, 62, 15, 2),
(11789, 63, 1, 2),
(11790, 63, 2, 2),
(11791, 63, 3, 2),
(11792, 63, 12, 2),
(11793, 63, 14, 2),
(11794, 63, 15, 2),
(11795, 64, 1, 2),
(11796, 64, 2, 2),
(11797, 64, 3, 2),
(11798, 64, 12, 2),
(11799, 64, 14, 2),
(11800, 64, 15, 2),
(11801, 65, 1, 2),
(11802, 65, 2, 2),
(11803, 65, 3, 2),
(11804, 65, 12, 2),
(11805, 65, 14, 2),
(11806, 65, 15, 2),
(11807, 66, 1, 2),
(11808, 66, 2, 2),
(11809, 66, 3, 2),
(11810, 66, 12, 2),
(11811, 66, 14, 2),
(11812, 66, 15, 2),
(11813, 68, 1, 2),
(11814, 68, 2, 2),
(11815, 68, 3, 2),
(11816, 68, 4, 2),
(11817, 68, 5, 2),
(11818, 68, 8, 2),
(11819, 68, 10, 2),
(11820, 68, 12, 2),
(11821, 68, 13, 2),
(11822, 68, 14, 2),
(11823, 68, 15, 2),
(11824, 69, 1, 2),
(11825, 69, 2, 2),
(11826, 69, 3, 2),
(11827, 69, 4, 2),
(11828, 69, 5, 2),
(11829, 69, 8, 2),
(11830, 69, 10, 2),
(11831, 69, 12, 2),
(11832, 69, 13, 2),
(11833, 69, 14, 2),
(11834, 69, 15, 2),
(11835, 70, 1, 2),
(11836, 70, 2, 2),
(11837, 70, 3, 2),
(11838, 70, 4, 2),
(11839, 70, 5, 2),
(11840, 70, 8, 2),
(11841, 70, 10, 2),
(11842, 70, 12, 2),
(11843, 70, 13, 2),
(11844, 70, 14, 2),
(11845, 70, 15, 2),
(11846, 71, 1, 2),
(11847, 60, 1, 6),
(11848, 60, 2, 6),
(11849, 60, 3, 6),
(11850, 60, 4, 6),
(11851, 60, 12, 6),
(11852, 60, 13, 6),
(11853, 60, 14, 6),
(11854, 60, 15, 6),
(11855, 61, 1, 6),
(11856, 61, 2, 6),
(11857, 61, 3, 6),
(11858, 61, 4, 6),
(11859, 61, 12, 6),
(11860, 61, 13, 6),
(11861, 61, 14, 6),
(11862, 61, 15, 6),
(11863, 62, 1, 6),
(11864, 62, 2, 6),
(11865, 62, 3, 6),
(11866, 62, 4, 6),
(11867, 62, 12, 6),
(11868, 62, 13, 6),
(11869, 62, 14, 6),
(11870, 62, 15, 6),
(11871, 63, 1, 6),
(11872, 63, 2, 6),
(11873, 63, 3, 6),
(11874, 63, 4, 6),
(11875, 63, 12, 6),
(11876, 63, 13, 6),
(11877, 63, 14, 6),
(11878, 63, 15, 6),
(11879, 64, 1, 6),
(11880, 64, 2, 6),
(11881, 64, 3, 6),
(11882, 64, 4, 6),
(11883, 64, 12, 6),
(11884, 64, 13, 6),
(11885, 64, 14, 6),
(11886, 64, 15, 6),
(11887, 65, 1, 6),
(11888, 65, 2, 6),
(11889, 65, 3, 6),
(11890, 65, 4, 6),
(11891, 65, 12, 6),
(11892, 65, 13, 6),
(11893, 65, 14, 6),
(11894, 65, 15, 6),
(11895, 66, 1, 6),
(11896, 66, 2, 6),
(11897, 66, 3, 6),
(11898, 66, 4, 6),
(11899, 66, 12, 6),
(11900, 66, 13, 6),
(11901, 66, 14, 6),
(11902, 66, 15, 6),
(11967, 28, 1, 5),
(11968, 28, 2, 5),
(11969, 28, 3, 5),
(11970, 28, 4, 5),
(11971, 28, 13, 5),
(11972, 28, 14, 5),
(11973, 28, 15, 5),
(11974, 29, 1, 5),
(11975, 29, 2, 5),
(11976, 29, 3, 5),
(11977, 29, 4, 5),
(11978, 29, 13, 5),
(11979, 29, 14, 5),
(11980, 29, 15, 5),
(11981, 30, 1, 5),
(11982, 30, 2, 5),
(11983, 30, 3, 5),
(11984, 30, 4, 5),
(11985, 30, 13, 5),
(11986, 30, 14, 5),
(11987, 30, 15, 5),
(11988, 31, 1, 5),
(11989, 31, 2, 5),
(11990, 31, 3, 5),
(11991, 31, 4, 5),
(11992, 31, 13, 5),
(11993, 31, 14, 5),
(11994, 31, 15, 5),
(11995, 37, 1, 5),
(11996, 37, 2, 5),
(11997, 37, 3, 5),
(11998, 37, 4, 5),
(11999, 37, 5, 5),
(12000, 37, 13, 5),
(12001, 37, 14, 5),
(12002, 37, 15, 5),
(12003, 38, 1, 5),
(12004, 38, 2, 5),
(12005, 38, 3, 5),
(12006, 38, 4, 5),
(12007, 38, 5, 5),
(12008, 38, 13, 5),
(12009, 38, 14, 5),
(12010, 38, 15, 5),
(12011, 128, 1, 5),
(12012, 128, 2, 5),
(12013, 128, 3, 5),
(12014, 128, 4, 5),
(12015, 128, 5, 5),
(12016, 128, 13, 5),
(12017, 128, 14, 5),
(12018, 128, 15, 5),
(12019, 129, 1, 5),
(12020, 129, 2, 5),
(12021, 129, 3, 5),
(12022, 129, 4, 5),
(12023, 129, 5, 5),
(12024, 129, 13, 5),
(12025, 129, 14, 5),
(12026, 129, 15, 5),
(12027, 130, 1, 5),
(12028, 130, 2, 5),
(12029, 130, 3, 5),
(12030, 130, 4, 5),
(12031, 130, 5, 5),
(12032, 130, 13, 5),
(12033, 130, 14, 5),
(12034, 130, 15, 5),
(12035, 131, 1, 5),
(12036, 131, 2, 5),
(12037, 131, 3, 5),
(12038, 131, 4, 5),
(12039, 131, 5, 5),
(12040, 131, 13, 5),
(12041, 131, 14, 5),
(12042, 131, 15, 5),
(12043, 132, 1, 5),
(12044, 132, 2, 5),
(12045, 132, 3, 5),
(12046, 132, 4, 5),
(12047, 132, 5, 5),
(12048, 132, 13, 5),
(12049, 132, 14, 5),
(12050, 132, 15, 5),
(12051, 133, 1, 5),
(12052, 133, 2, 5),
(12053, 133, 3, 5),
(12054, 133, 4, 5),
(12055, 133, 5, 5),
(12056, 133, 13, 5),
(12057, 133, 14, 5),
(12058, 133, 15, 5),
(12618, 1, 1, 2),
(12619, 1, 2, 2),
(12620, 1, 3, 2),
(12621, 1, 4, 2),
(12622, 1, 5, 2),
(12623, 1, 10, 2),
(12624, 1, 11, 2),
(12625, 1, 12, 2),
(12626, 1, 13, 2),
(12627, 1, 14, 2),
(12628, 1, 15, 2),
(12629, 2, 1, 2),
(12630, 3, 1, 2),
(12631, 4, 1, 2),
(12632, 4, 2, 2),
(12633, 4, 3, 2),
(12634, 4, 4, 2),
(12635, 4, 5, 2),
(12636, 4, 10, 2),
(12637, 4, 11, 2),
(12638, 4, 12, 2),
(12639, 4, 13, 2),
(12640, 4, 14, 2),
(12641, 4, 15, 2),
(12642, 5, 1, 2),
(12643, 5, 2, 2),
(12644, 5, 3, 2),
(12645, 5, 4, 2),
(12646, 5, 5, 2),
(12647, 5, 10, 2),
(12648, 5, 11, 2),
(12649, 5, 12, 2),
(12650, 5, 13, 2),
(12651, 5, 14, 2),
(12652, 5, 15, 2),
(12653, 6, 1, 2),
(12654, 6, 2, 2),
(12655, 6, 3, 2),
(12656, 6, 4, 2),
(12657, 6, 5, 2),
(12658, 6, 10, 2),
(12659, 6, 11, 2),
(12660, 6, 12, 2),
(12661, 6, 13, 2),
(12662, 6, 14, 2),
(12663, 6, 15, 2),
(12664, 7, 1, 2),
(12665, 7, 2, 2),
(12666, 7, 3, 2),
(12667, 7, 4, 2),
(12668, 7, 5, 2),
(12669, 7, 10, 2),
(12670, 7, 11, 2),
(12671, 7, 12, 2),
(12672, 7, 13, 2),
(12673, 7, 14, 2),
(12674, 7, 15, 2),
(12675, 8, 1, 2),
(12676, 8, 2, 2),
(12677, 8, 3, 2),
(12678, 8, 4, 2),
(12679, 8, 5, 2),
(12680, 8, 10, 2),
(12681, 8, 11, 2),
(12682, 8, 12, 2),
(12683, 8, 13, 2),
(12684, 8, 14, 2),
(12685, 8, 15, 2),
(12686, 9, 1, 2),
(12687, 9, 2, 2),
(12688, 9, 3, 2),
(12689, 9, 4, 2),
(12690, 9, 5, 2),
(12691, 9, 10, 2),
(12692, 9, 11, 2),
(12693, 9, 12, 2),
(12694, 9, 13, 2),
(12695, 9, 14, 2),
(12696, 9, 15, 2),
(12697, 10, 1, 2),
(12698, 10, 2, 2),
(12699, 10, 3, 2),
(12700, 10, 4, 2),
(12701, 10, 5, 2),
(12702, 10, 10, 2),
(12703, 10, 11, 2),
(12704, 10, 12, 2),
(12705, 10, 13, 2),
(12706, 10, 14, 2),
(12707, 10, 15, 2),
(12708, 11, 1, 2),
(12709, 11, 2, 2),
(12710, 11, 3, 2),
(12711, 11, 4, 2),
(12712, 11, 5, 2),
(12713, 11, 10, 2),
(12714, 11, 11, 2),
(12715, 11, 12, 2),
(12716, 11, 13, 2),
(12717, 11, 14, 2),
(12718, 11, 15, 2),
(12719, 12, 1, 2),
(12720, 12, 2, 2),
(12721, 12, 3, 2),
(12722, 12, 4, 2),
(12723, 12, 5, 2),
(12724, 12, 10, 2),
(12725, 12, 11, 2),
(12726, 12, 12, 2),
(12727, 12, 13, 2),
(12728, 12, 14, 2),
(12729, 12, 15, 2),
(12730, 13, 1, 2),
(12731, 13, 2, 2),
(12732, 13, 3, 2),
(12733, 13, 4, 2),
(12734, 13, 5, 2),
(12735, 13, 10, 2),
(12736, 13, 11, 2),
(12737, 13, 12, 2),
(12738, 13, 13, 2),
(12739, 13, 14, 2),
(12740, 13, 15, 2),
(12741, 14, 1, 2),
(12742, 14, 2, 2),
(12743, 14, 3, 2),
(12744, 14, 4, 2),
(12745, 14, 5, 2),
(12746, 14, 10, 2),
(12747, 14, 11, 2),
(12748, 14, 12, 2),
(12749, 14, 13, 2),
(12750, 14, 14, 2),
(12751, 14, 15, 2),
(12752, 143, 1, 2),
(12753, 143, 2, 2),
(12754, 143, 3, 2),
(12755, 143, 11, 2),
(12756, 143, 14, 2),
(12757, 143, 15, 2),
(12758, 144, 1, 2),
(12759, 144, 2, 2),
(12760, 144, 3, 2),
(12761, 144, 11, 2),
(12762, 144, 13, 2),
(12763, 144, 14, 2),
(12764, 144, 15, 2),
(12765, 143, 1, 3),
(12766, 143, 2, 3),
(12767, 143, 3, 3),
(12768, 143, 11, 3),
(12769, 143, 14, 3),
(12770, 143, 15, 3),
(12771, 144, 1, 3),
(12772, 144, 2, 3),
(12773, 144, 3, 3),
(12774, 144, 11, 3),
(12775, 144, 14, 3),
(12776, 144, 15, 3),
(12777, 143, 1, 5),
(12778, 143, 2, 5),
(12779, 143, 3, 5),
(12780, 143, 14, 5),
(12781, 143, 15, 5),
(12782, 144, 1, 5),
(12783, 144, 2, 5),
(12784, 144, 3, 5),
(12785, 144, 13, 5),
(12786, 144, 14, 5),
(12787, 144, 15, 5),
(12788, 143, 1, 8),
(12789, 143, 2, 8),
(12790, 143, 3, 8),
(12791, 143, 13, 8),
(12792, 143, 14, 8),
(12793, 143, 15, 8),
(12794, 144, 1, 8),
(12795, 144, 2, 8),
(12796, 144, 3, 8),
(12797, 144, 13, 8),
(12798, 144, 14, 8),
(12799, 144, 15, 8),
(12817, 143, 1, 6),
(12818, 143, 3, 6),
(12819, 143, 14, 6),
(12820, 143, 15, 6),
(12821, 144, 1, 6),
(12822, 144, 3, 6),
(12823, 144, 15, 6),
(12853, 29, 1, 3),
(12854, 29, 2, 3),
(12855, 29, 3, 3),
(12856, 29, 14, 3),
(12857, 29, 15, 3),
(12858, 30, 1, 3),
(12859, 30, 2, 3),
(12860, 30, 3, 3),
(12861, 30, 14, 3),
(12862, 30, 15, 3),
(12863, 31, 1, 3),
(12864, 31, 2, 3),
(12865, 31, 3, 3),
(12866, 31, 14, 3),
(12867, 31, 15, 3);

-- --------------------------------------------------------

--
-- Structure de la table `acquisition_types`
--

CREATE TABLE `acquisition_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(45) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `location` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL COMMENT 'utilisateur',
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `acquisition_types`
--

INSERT INTO `acquisition_types` (`id`, `code`, `name`, `location`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '01', 'Achat', 0, '2016-07-26 10:07:39', '2016-07-28 10:24:07', 4, 4),
(2, '02', 'LCD', 0, '2016-07-26 10:07:52', '2016-07-28 10:57:16', 4, 4),
(3, '03', 'LLD', 0, '2016-07-26 10:08:04', '2016-07-28 10:57:24', 4, 4),
(4, '04', 'Leasing', 0, '2016-07-26 10:08:23', '2016-07-28 10:57:31', 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE `actions` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `actions`
--

INSERT INTO `actions` (`id`, `code`, `name`) VALUES
(1, 'view', 'Consultation'),
(2, 'view_other', 'Consultation des éléments des autres utilisateurs '),
(3, 'add', 'Ajout'),
(4, 'edit', 'Modification'),
(5, 'edit_other', 'Modification des éléments des autres utilisateurs '),
(6, 'delete', 'Suppression '),
(7, 'delete_other', 'Suppression des éléments des autres utilisateurs'),
(8, 'lock', 'Verrouillage '),
(9, 'lock_other', 'Verrouillage des éléments des autres utilisateurs'),
(10, 'view_other_parc', 'Consultation des éléments des autres parcs'),
(11, 'audit', 'Voir audit'),
(12, 'search', 'Recherche'),
(13, 'export', 'Exportation'),
(14, 'import', 'Importation'),
(15, 'printing', 'Impression'),
(20, 'edit_input_locked', 'Modification des champs verrouillés');

-- --------------------------------------------------------

--
-- Structure de la table `affectationpvs`
--

CREATE TABLE `affectationpvs` (
  `id` int(11) NOT NULL,
  `grey_card` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'Carte grise',
  `assurance` tinyint(2) NOT NULL DEFAULT '0',
  `controle_technique` tinyint(2) NOT NULL DEFAULT '0',
  `carnet_entretien` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'Carnet entretien',
  `carnet_bord` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'Carnet de bord',
  `vignette` tinyint(2) NOT NULL DEFAULT '0',
  `vignette_ct` tinyint(2) NOT NULL DEFAULT '0',
  `procuration` tinyint(2) NOT NULL DEFAULT '0',
  `roue_secours` tinyint(2) NOT NULL DEFAULT '0',
  `cric` tinyint(2) NOT NULL DEFAULT '0',
  `tapis` tinyint(2) NOT NULL DEFAULT '0',
  `manivelle` tinyint(2) NOT NULL DEFAULT '0',
  `boite_pharmacie` tinyint(2) NOT NULL DEFAULT '0',
  `triangle` tinyint(2) NOT NULL DEFAULT '0',
  `gilet` tinyint(2) NOT NULL DEFAULT '0',
  `double_cle` tinyint(2) NOT NULL DEFAULT '0',
  `sieges` smallint(2) NOT NULL DEFAULT '0',
  `dashboard` smallint(1) NOT NULL DEFAULT '0' COMMENT 'tableau de bord',
  `moquette` smallint(1) NOT NULL DEFAULT '0',
  `tapis_interieur` smallint(1) NOT NULL DEFAULT '0',
  `customer_car_id` int(11) NOT NULL COMMENT 'identifiant  conducteur',
  `reception` tinyint(1) NOT NULL DEFAULT '0',
  `obs_customer` text COLLATE utf8_bin COMMENT 'Observation conducteur',
  `obs_chef` text COLLATE utf8_bin COMMENT 'Observation Chef de parc',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` date NOT NULL COMMENT 'créé',
  `modified` date NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` smallint(2) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL COMMENT 'utilisateur',
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `affiliates`
--

INSERT INTO `affiliates` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '01', 'ANEM', '2016-05-11 10:20:01', '2016-07-26 10:24:44', 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `alert_type_id` int(11) NOT NULL,
  `object_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `alert_types`
--

CREATE TABLE `alert_types` (
  `id` smallint(3) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `section_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `alert_types`
--

INSERT INTO `alert_types` (`id`, `code`, `name`, `section_id`) VALUES
(1, 'assurance', 'assurance', 119),
(2, 'controle_technique', 'controle technique', 119),
(3, 'vignette', 'vignette', 119),
(4, 'vidange', 'vidange', 120),
(5, 'expiration_permis', 'expiration permis', 119),
(6, 'avec_date', 'evenement avec date', 120),
(7, 'avec_km', 'evenement avec km', 120),
(13, 'limite_mensuelle_consommation', 'limite mensuelle consommation', 121),
(15, 'nb_minimum_bons', 'nombre minimum de bons', 121),
(21, 'km_restant_contrat', 'km restant du contrat', 122),
(22, 'contrat_vehicule', 'contrat vehicule', 122),
(24, 'vidange_engins', 'vidange des engins', 120),
(26, 'amortissement', 'amortissement', 122),
(27, 'coupon_consumption', 'consommation des bons', 121),
(28, 'product_min', 'quantité min produit', 123),
(29, 'product_max', 'quantité max produit', 123),
(30, 'echeance_facture', 'echeance facture', 118),
(31, 'echeance_paiement', 'echeance paiement', 118);

-- --------------------------------------------------------

--
-- Structure de la table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `attachment_number` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `article_id` int(11) NOT NULL,
  `attachment_type_id` smallint(5) UNSIGNED NOT NULL COMMENT ' Identifiant du type de pièce jointe',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `attachment_types`
--

CREATE TABLE `attachment_types` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `section_id` smallint(5) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `attachment_types`
--

INSERT INTO `attachment_types` (`id`, `name`, `section_id`, `user_id`, `last_modifier_id`, `created`, `modified`) VALUES
(1, 'Carte jaune', 1, 1, 0, '2018-02-04 11:40:15', '2018-02-04 11:40:15'),
(2, 'Catre grise', 1, 1, 0, '2018-02-04 11:40:24', '2018-02-04 11:40:24'),
(3, 'Photo avant', 1, 1, 0, '2018-02-04 11:40:42', '2018-02-04 11:40:42'),
(4, 'Photo arrière', 1, 1, 0, '2018-02-04 11:44:15', '2018-02-04 11:44:15'),
(5, 'Photo gauche', 1, 1, 0, '2018-02-04 11:44:26', '2018-02-04 11:44:26'),
(6, 'Photo droite', 1, 1, 0, '2018-02-04 11:44:39', '2018-02-04 11:44:39'),
(7, ' Carte d\'identité  resto', 22, 1, 0, '2018-02-04 11:45:19', '2018-02-04 11:45:19'),
(8, ' Carte d\'identité  verso', 22, 1, 0, '2018-02-04 11:45:28', '2018-02-04 11:45:28'),
(9, ' Permis de conduire recto', 22, 1, 0, '2018-02-04 11:45:46', '2018-02-04 11:45:46'),
(10, ' Permis de conduire verso', 22, 1, 0, '2018-02-04 11:45:56', '2018-02-04 11:45:56'),
(11, 'Passeport', 22, 1, 0, '2018-02-04 11:46:09', '2018-02-04 11:46:09'),
(12, 'Photo initiale 1', 15, 1, 0, '2018-02-04 11:46:47', '2018-02-04 11:46:47'),
(13, 'Photo initiale 2', 15, 1, 0, '2018-02-04 11:46:55', '2018-02-04 11:46:55'),
(14, 'Photo initiale 3', 15, 1, 0, '2018-02-04 11:47:03', '2018-02-04 11:47:03'),
(15, 'Photo initiale 4', 15, 1, 0, '2018-02-04 11:47:12', '2018-02-04 11:47:12'),
(16, 'Photo finale 1', 15, 1, 0, '2018-02-04 11:47:26', '2018-02-04 11:47:26'),
(17, 'Photo finale 2', 15, 1, 0, '2018-02-04 11:47:43', '2018-02-04 11:47:43'),
(18, 'Photo finale 3', 15, 1, 0, '2018-02-04 11:47:51', '2018-02-04 11:47:51'),
(19, 'Photo finale 4', 15, 1, 0, '2018-02-04 11:47:59', '2018-02-04 11:47:59'),
(20, 'Photo conducteur', 22, 1, 0, '2018-02-04 11:48:22', '2018-02-04 11:48:22'),
(21, 'Pièce jointe ', 53, 1, 0, '2018-02-04 11:49:33', '2018-02-04 11:49:33'),
(22, 'Ordre de Mission', 69, 1, 0, '2018-02-04 14:01:05', '2018-02-04 14:01:05'),
(23, 'Bon de Commande', 69, 1, 0, '2018-02-04 14:01:19', '2018-02-04 14:01:19'),
(24, 'Bon de Livraison', 69, 1, 0, '2018-02-04 14:01:36', '2018-02-04 14:01:36'),
(25, 'Bon de Consignation Emballage', 69, 1, 0, '2018-02-04 14:01:51', '2018-02-04 14:01:51'),
(26, 'Bon de Retour Emballage', 69, 1, 0, '2018-02-04 14:02:11', '2018-02-04 14:02:11'),
(27, 'Facture', 69, 1, 0, '2018-02-04 14:02:27', '2018-02-04 14:02:27'),
(28, 'Bon d’autorisation retour marchandise', 69, 1, 0, '2018-02-04 14:02:58', '2018-02-04 14:02:58'),
(29, 'Photo avant', 8, 1, 1, '2018-02-04 14:42:32', '2018-02-04 15:49:01'),
(30, 'Photo arrière', 8, 1, 0, '2018-02-04 14:42:47', '2018-02-04 14:42:47'),
(31, 'Photo gauche', 8, 1, 0, '2018-02-04 14:43:13', '2018-02-04 14:43:13'),
(32, 'Photo droite', 8, 1, 0, '2018-02-04 14:43:25', '2018-02-04 14:43:25'),
(33, 'Pièce jointe', 54, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `audits`
--

CREATE TABLE `audits` (
  `id` int(11) NOT NULL,
  `rubric_id` tinyint(3) UNSIGNED NOT NULL,
  `article_id` int(11) NOT NULL COMMENT 'identifiant d''article',
  `user_id` int(11) NOT NULL,
  `action_id` smallint(5) UNSIGNED NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `autorisations`
--

CREATE TABLE `autorisations` (
  `id` int(11) NOT NULL,
  `customer_car_id` int(11) NOT NULL COMMENT 'identifiant conducteur',
  `authorization_from` datetime NOT NULL COMMENT 'autorisation de (...)',
  `authorization_to` datetime NOT NULL COMMENT 'autorisation à (...)',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `type` tinyint(2) NOT NULL COMMENT 'type de bons ',
  `total_ht` double NOT NULL,
  `total_ttc` double NOT NULL,
  `total_tva` double NOT NULL,
  `ristoune` double DEFAULT NULL COMMENT 'Remise',
  `supplier_id` smallint(5) UNSIGNED DEFAULT '0' COMMENT 'Fournisseur',
  `event_id` int(11) DEFAULT NULL,
  `ride_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `status_payment` tinyint(1) NOT NULL DEFAULT '1',
  `payment_type` tinyint(2) DEFAULT NULL COMMENT 'type de paiement',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `modified_id` int(11) NOT NULL DEFAULT '0',
  `transport_bill_category_id` smallint(5) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8_bin,
  `sheet_ride_detail_ride_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `designation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `amount_remaining` double DEFAULT NULL,
  `payment_method` tinyint(2) DEFAULT NULL,
  `stamp` double DEFAULT NULL,
  `ristourne_val` double DEFAULT NULL,
  `ristourne_percentage` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `bill_products`
--

CREATE TABLE `bill_products` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL COMMENT '(identifiant de la pièce(bon d''entrée / bon sortie/ commande client..)',
  `lot_id` int(11) NOT NULL COMMENT 'identifiant du produit',
  `quantity` double NOT NULL,
  `unit_price` double NOT NULL,
  `price_ht` double NOT NULL COMMENT 'prix hors taxe',
  `price_ttc` double NOT NULL COMMENT 'Prix TTC',
  `price_tva` double NOT NULL COMMENT 'prix tva',
  `ristourne_val` double DEFAULT NULL COMMENT 'valeur de remise',
  `ristourne_%` double DEFAULT NULL,
  `tva_id` tinyint(2) NOT NULL,
  `designation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `order_bill_product` smallint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `bill_services`
--

CREATE TABLE `bill_services` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `service_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `cake_sessions`
--

CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cake_sessions`
--

INSERT INTO `cake_sessions` (`id`, `data`, `expires`) VALUES
('0j66nt8ivqhj52609c5774bin5', 'Config|a:3:{s:9:\"userAgent\";s:32:\"7e44aa1ca64dde44ca4644f9a824d797\";s:4:\"time\";i:1578240346;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:21:{s:2:\"id\";s:1:\"1\";s:10:\"first_name\";s:10:\"superadmin\";s:11:\"supplier_id\";N;s:10:\"service_id\";N;s:9:\"last_name\";s:10:\"superadmin\";s:5:\"email\";N;s:8:\"username\";s:10:\"superadmin\";s:15:\"secret_password\";s:0:\"\";s:7:\"created\";s:19:\"2016-08-16 16:32:18\";s:8:\"modified\";s:19:\"2020-01-02 15:57:41\";s:7:\"picture\";s:0:\"\";s:7:\"role_id\";s:1:\"3\";s:6:\"car_id\";s:1:\"9\";s:11:\"language_id\";N;s:5:\"limit\";s:2:\"25\";s:10:\"profile_id\";N;s:15:\"last_visit_date\";s:19:\"2020-01-02 10:55:00\";s:10:\"time_actif\";s:19:\"2020-01-02 15:57:00\";s:13:\"receive_alert\";b:0;s:20:\"receive_notification\";b:0;s:7:\"Profile\";a:5:{s:2:\"id\";N;s:4:\"name\";N;s:9:\"parent_id\";N;s:7:\"created\";N;s:8:\"modified\";N;}}}nbAlerts|i:0;nbNotifications|s:1:\"0\";User|a:1:{s:8:\"language\";s:3:\"fre\";}currency|s:2:\"DA\";currencyName|s:6:\"Dinars\";useRideCategory|s:1:\"1\";nameSheetRide|s:17:\"Feuilles de route\";hasSaleModule|s:1:\"1\";tresorerie|s:1:\"1\";stock|s:1:\"1\";offShore|s:1:\"1\";settleMissions|s:1:\"2\";usePurchaseBill|s:1:\"1\";carSubcontracting|s:1:\"2\";_Token|a:5:{s:3:\"key\";s:40:\"22d05958b3c0f24553bf3e6a0aeb65f1f185ef04\";s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}s:10:\"csrfTokens\";a:4:{s:40:\"2ce90645dfabc93ad3c0fef5a16c2d84139d65e5\";i:1578234939;s:40:\"b567822668a3b70b7687ba498d2e7f0c8b1a84a4\";i:1578234940;s:40:\"eed74e58d27d329646136676e22c85f8288d3f6c\";i:1578234944;s:40:\"22d05958b3c0f24553bf3e6a0aeb65f1f185ef04\";i:1578234947;}}Message|a:0:{}profileId|N;', 1578240347),
('agr1i6sqc2lql314juat2bhhh6', 'Config|a:3:{s:9:\"userAgent\";s:32:\"7e44aa1ca64dde44ca4644f9a824d797\";s:4:\"time\";i:1578306591;s:9:\"countdown\";i:10;}_Token|a:5:{s:3:\"key\";s:40:\"6da2fd80eaacbfea7b570424f40844767250c15b\";s:18:\"allowedControllers\";a:0:{}s:14:\"allowedActions\";a:0:{}s:14:\"unlockedFields\";a:0:{}s:10:\"csrfTokens\";a:8:{s:40:\"9bd144f8808b8911912ab36b8c054d3c5aec48ad\";i:1578300949;s:40:\"ce41453dfe5276298f41e47b02b31f0ccd32ca2b\";i:1578300951;s:40:\"01d70499058d37484176117f6bfc3fff07f9bc4a\";i:1578300966;s:40:\"ef1ebd8d6979cdbe741b2c486cc6c78e40419d04\";i:1578300984;s:40:\"c5cc065a06235c267b5de590a9cd431d860f08ed\";i:1578300988;s:40:\"60dc20b2efd2dc0e8b714716f691e0684c2c1f3d\";i:1578301033;s:40:\"5b8d25c56e0aa005910a4228b939f2160069a88a\";i:1578301187;s:40:\"6da2fd80eaacbfea7b570424f40844767250c15b\";i:1578301191;}}Message|a:1:{s:4:\"auth\";a:4:{s:7:\"message\";s:44:\"Nom d\'utilisateur ou mot de passe incorrect.\";s:3:\"key\";s:4:\"auth\";s:7:\"element\";s:13:\"Flash/default\";s:6:\"params\";a:0:{}}}Auth|a:1:{s:4:\"User\";a:21:{s:2:\"id\";s:1:\"1\";s:10:\"first_name\";s:10:\"superadmin\";s:11:\"supplier_id\";N;s:10:\"service_id\";N;s:9:\"last_name\";s:10:\"superadmin\";s:5:\"email\";N;s:8:\"username\";s:10:\"superadmin\";s:15:\"secret_password\";s:0:\"\";s:7:\"created\";s:19:\"2016-08-16 16:32:18\";s:8:\"modified\";s:19:\"2020-01-05 15:05:44\";s:7:\"picture\";s:0:\"\";s:7:\"role_id\";s:1:\"3\";s:6:\"car_id\";s:1:\"9\";s:11:\"language_id\";N;s:5:\"limit\";s:2:\"25\";s:10:\"profile_id\";N;s:15:\"last_visit_date\";s:19:\"2020-01-05 10:51:00\";s:10:\"time_actif\";s:19:\"2020-01-05 15:05:00\";s:13:\"receive_alert\";b:0;s:20:\"receive_notification\";b:0;s:7:\"Profile\";a:5:{s:2:\"id\";N;s:4:\"name\";N;s:9:\"parent_id\";N;s:7:\"created\";N;s:8:\"modified\";N;}}}nbAlerts|i:0;nbNotifications|s:1:\"0\";User|a:1:{s:8:\"language\";s:3:\"fre\";}currency|s:2:\"DA\";currencyName|s:6:\"Dinars\";useRideCategory|s:1:\"1\";nameSheetRide|s:17:\"Feuilles de route\";hasSaleModule|s:1:\"1\";tresorerie|s:1:\"1\";stock|s:1:\"1\";offShore|s:1:\"1\";settleMissions|s:1:\"2\";usePurchaseBill|s:1:\"1\";carSubcontracting|s:1:\"2\";profileId|N;', 1578306591);

-- --------------------------------------------------------

--
-- Structure de la table `cancel_causes`
--

CREATE TABLE `cancel_causes` (
  `id` smallint(5) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `cancel_causes`
--

INSERT INTO `cancel_causes` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(2, '001', 'Véhicule en panne', '2019-03-20 17:06:19', '2019-03-20 17:06:19', 1, 0),
(3, '002', 'chauffeur malade', '2019-03-26 16:11:32', '2019-03-26 16:11:32', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `car`
--

CREATE TABLE `car` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `carmodel_id` smallint(5) UNSIGNED DEFAULT NULL,
  `nbplace` tinyint(2) UNSIGNED DEFAULT NULL COMMENT 'Nombre de place',
  `nbdoor` tinyint(2) UNSIGNED DEFAULT NULL COMMENT ' Nombre de porte',
  `immatr_prov` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT ' Immatriculation provisoire',
  `immatr_def` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Immatriculation définitive',
  `chassis` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `color` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Couleur',
  `color2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `circulation_date` datetime DEFAULT NULL,
  `date_approval` datetime DEFAULT NULL COMMENT 'Date de l''immatriculation définitive ',
  `radio_code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL COMMENT 'date d''achat',
  `purchasing_price` decimal(11,2) DEFAULT NULL COMMENT ' Prix ​​d''achat',
  `current_price` decimal(11,2) DEFAULT NULL COMMENT ' Prix actuel',
  `reception_date` datetime DEFAULT NULL,
  `credit_date` datetime DEFAULT NULL,
  `monthly_payment` decimal(11,2) DEFAULT NULL COMMENT 'Paiement mensuel',
  `credit_duration` tinyint(3) UNSIGNED DEFAULT NULL COMMENT ' Durée de crédit ',
  `num_contract` varchar(25) COLLATE utf8_bin DEFAULT NULL COMMENT 'Numéro de contrat',
  `nb_year_amortization` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Années de l''amortissement',
  `amortization_amount` decimal(11,2) DEFAULT NULL COMMENT 'Montant de l''amortissement',
  `purchasing_attachment` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'pièce jointe d''achat',
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Fournisseur',
  `max_speed` smallint(3) DEFAULT NULL COMMENT 'Vitesse max (Km/h)',
  `average_speed` smallint(3) DEFAULT NULL COMMENT 'Vitesse moyenne (Km/h)',
  `volume_palette` smallint(5) UNSIGNED DEFAULT NULL,
  `reservoir` smallint(4) DEFAULT NULL,
  `reservoir_state` tinyint(3) UNSIGNED NOT NULL COMMENT ' état du réservoir',
  `reservoir_gpl` smallint(4) DEFAULT NULL,
  `min_consumption` decimal(5,2) DEFAULT NULL COMMENT ' Consommation minimale(L/100Km)	',
  `max_consumption` decimal(5,2) DEFAULT NULL COMMENT 'Consommation Max(L/100Km)	',
  `min_consumption_gpl` decimal(8,2) DEFAULT NULL,
  `max_consumption_gpl` decimal(8,2) DEFAULT NULL,
  `note` mediumtext COLLATE utf8_bin,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `car_status_id` tinyint(4) DEFAULT '1' COMMENT 'état du véhicule ',
  `mark_id` tinyint(3) UNSIGNED NOT NULL,
  `car_type_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL COMMENT 'modifié',
  `car_category_id` smallint(5) UNSIGNED DEFAULT NULL,
  `fuel_id` tinyint(4) DEFAULT NULL COMMENT 'identifiant  de carburant',
  `fuel_gpl` tinyint(1) DEFAULT NULL COMMENT 'carburant gpl',
  `km` float DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `place` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `last_fuel_level` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `last_date_synchronization` datetime DEFAULT NULL,
  `km_initial` float NOT NULL DEFAULT '0',
  `yellow_card` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT ' carte jaune',
  `grey_card` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT 'carte grise',
  `parc_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'verrouillé  ',
  `picture1` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' Image 1',
  `picture2` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' Image 2',
  `picture3` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' Image 3',
  `picture4` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' Image 4',
  `attachment1` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' pièce jointe1',
  `attachment2` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' pièce jointe 2',
  `attachment3` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT ' pièce jointe 3',
  `attachment4` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment5` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `department_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `send_mail` tinyint(4) DEFAULT '0' COMMENT ' envoyer un mail',
  `alert` tinyint(2) NOT NULL DEFAULT '0',
  `alert_amortization` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `limit_consumption` mediumint(6) UNSIGNED DEFAULT NULL COMMENT 'Limite de consommation(Km) ',
  `power_car` smallint(6) DEFAULT NULL COMMENT 'Puissance véhicule',
  `acquisition_type_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'identification du type d''acquisition',
  `amortization_km` decimal(10,2) DEFAULT NULL,
  `coupon_consumption` decimal(5,0) DEFAULT NULL COMMENT 'Consommation mensuelle des bons ',
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  `date_open` datetime DEFAULT NULL,
  `last_opener` int(11) DEFAULT NULL COMMENT 'dernière ouverture',
  `visible_site` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'site visible',
  `date_planned_end` date DEFAULT NULL,
  `date_real_end` date DEFAULT NULL,
  `in_mission` tinyint(2) NOT NULL DEFAULT '0',
  `empty_weight` decimal(6,2) DEFAULT NULL COMMENT 'Poids vide',
  `balance` double NOT NULL DEFAULT '0',
  `vidange_hour` tinyint(1) NOT NULL DEFAULT '0',
  `affectation` tinyint(1) NOT NULL DEFAULT '0',
  `hours` float DEFAULT NULL COMMENT 'heures',
  `car_group_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `charge_utile` double DEFAULT NULL,
  `poids_total_charge` double DEFAULT NULL,
  `car_parc` tinyint(2) NOT NULL DEFAULT '1',
  `nb_palette` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Nombre de palette ',
  `archived_date` date DEFAULT NULL,
  `company_membership` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `capacity1` double DEFAULT NULL,
  `capacity2` double DEFAULT NULL,
  `capacity3` double DEFAULT NULL,
  `capacity4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `carmodels`
--

CREATE TABLE `carmodels` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `mark_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'identifiant marque',
  `consumption_01` decimal(8,2) DEFAULT NULL COMMENT ' consommation 01',
  `consumption_02` decimal(8,2) DEFAULT NULL COMMENT ' consommation 02',
  `consumption_03` decimal(8,2) DEFAULT NULL COMMENT ' consommation 03',
  `consumption_04` decimal(8,2) DEFAULT NULL COMMENT ' consommation 04',
  `consumption_05` decimal(8,2) DEFAULT NULL COMMENT ' consommation 05',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `carmodels`
--

INSERT INTO `carmodels` (`id`, `code`, `name`, `mark_id`, `consumption_01`, `consumption_02`, `consumption_03`, `consumption_04`, `consumption_05`, `created`, `modified`, `user_id`) VALUES
(16, '', '145', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(17, '', '146', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(18, '', '147', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(19, '', '155', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(20, '', '156', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(21, '', '156 SW', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(22, '', '159 ', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(23, '', '159 SW', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(24, '', '164', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(25, '', '166', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(26, '', '33', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(27, '', '75', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(28, '', '8C', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(29, '', '90', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(30, '', 'ALFA GT', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(31, '', 'ALFASUD', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(32, '', 'ALFETTA', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(33, '', 'BRERA', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(34, '', 'CROSSWAGON', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(35, '', 'GIULIA', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(36, '', 'GIULIETTA', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(37, '', 'GT', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(38, '', 'GTV', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(39, '', 'MITO', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(40, '', 'RZ', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(41, '', 'SPIDER', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(42, '', 'SPORTWAGON', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(43, '', 'SPRINT', 5, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(46, '', 'HI-TOPIC', 8, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(47, '', 'ROCSTA ', 8, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(48, '', 'TOWNER', 8, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(49, '', 'AR1', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(50, '', 'DB', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(51, '', 'DB7', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(52, '', 'DB9', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(53, '', 'DBS', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(54, '', 'LAGONDA', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(55, '', 'V12 VANQUISH', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(56, '', 'V8', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(57, '', 'VANQUISH', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(58, '', 'VANTAGE', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(59, '', 'VIRAGE', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(60, '', 'VOLANTE', 9, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(61, '', '100', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(62, '', 'A1', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(63, '', 'A2', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2016-11-24 10:30:19', 0),
(64, '', 'A3', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(65, '', 'A3 CABRIOLET', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(66, '', 'A3 SPORTBACK', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(67, '', 'A4', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(68, '', 'A4 AVANT', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(69, '', 'A4 CABRIOLET', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(70, '', 'A5', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(71, '', 'A5 CABRIOLET', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(72, '', 'A6', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(73, '', 'A6 ALLROAD', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(74, '', 'A6 AVANT', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(75, '', 'A6 QUATTRO', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(76, '', 'A8', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(77, '', 'ALLROAD', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(78, '', 'AUDI 80 ', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(79, '', 'AUDI 80 CABRIOLET ', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(80, '', 'Q5', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(81, '', 'Q7', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(82, '', 'R8', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(83, '', 'RS4', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(84, '', 'S2 COUPE', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(85, '', 'S3', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(86, '', 'S4', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(87, '', 'S4 CABRIO', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(88, '', 'S5', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(89, '', 'S6 ', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(90, '', 'S8 ', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(91, '', 'TT', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(92, '', 'TT CABRIOLET', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(93, '', 'TT COUPE', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(94, '', 'TT RS ', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(95, '', 'TT RS COUPE', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(96, '', 'TTS S', 10, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(97, '', '2600', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(98, '', 'ESTATE', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(99, '', 'HEALEY', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(100, '', 'MAESTRO', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(101, '', 'METRO', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(102, '', 'MINI', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(103, '', 'MINI MOKE', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(104, '', 'MK', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(105, '', 'MONTEGO', 11, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(107, '', 'A 1000', 13, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(108, '', 'A 112', 13, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(109, '', 'STELLINA', 13, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(110, '', 'Y10', 13, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(111, '', 'ARNAGE', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(112, '', 'AZURE', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(113, '', 'BROOKLANDS', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(114, '', 'CONTINENTAL', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(115, '', 'EIGHT', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(116, '', 'FLYING SPUR', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(117, '', 'MULSANNE', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(118, '', 'TURBO R', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(119, '', 'TURBO RT', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(120, '', 'TURBO S', 14, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(122, '', '1 DSL', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(123, '', '1 HATCH', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(124, '', '1502', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(125, '', '2002', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(126, '', '2500', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(127, '', 'ALPINA ', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(128, '', 'ROADSTER S', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(129, '', 'SERIE 1', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(130, '', 'SERIE 1 CABRIOLET', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(131, '', 'SERIE 1 COUPE', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(132, '', 'SERIE 1 HATCH', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(133, '', 'SERIE 1 SPORTS', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(134, '', 'SERIE 3', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(135, '', 'SERIE 3 CABRIOLET', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(136, '', 'SERIE 3 COMPACT', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(137, '', 'SERIE 3 COUPE', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(138, '', 'SERIE 3 TOURING', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(139, '', 'SERIE 5', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(140, '', 'SERIE 5 TOURING', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(141, '', 'SERIE 6', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(142, '', 'SERIE 6 CABRIOLET', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(143, '', 'SERIE 6 COUPE', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(144, '', 'SERIE 7', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(145, '', 'SERIE 8', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(146, '', 'SERIE M', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(147, '', 'SERIE M CABRIOLET', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(148, '', 'SERIE M COUPE', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(149, '', 'SERIE X', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(150, '', 'SERIE Z', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(151, '', 'SERIE1', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(152, '', 'X3', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(153, '', 'X5', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(154, '', 'X6', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(155, '', 'Z1', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(156, '', 'Z3', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(157, '', 'Z3 COUPE', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(158, '', 'Z4', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(159, '', 'Z4 COUPE', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(160, '', 'Z8', 16, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(161, '', 'BC3', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(162, '', 'BS2', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(163, '', 'BS4', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(164, '', 'BS6', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(165, '', 'GRANSE', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(166, '', 'JINBEI', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(167, '', 'ZHONGHUA', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(168, '', 'ZUNCHI', 18, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(169, '', 'EB 110', 19, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(170, '', 'VEYRON', 19, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(181, '', 'F1', 21, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(182, '', 'F3', 21, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(183, '', 'F3 R', 21, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(184, '', 'F6', 21, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(185, '', 'F8', 21, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(186, '', 'ALLANTE', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(187, '', 'BLS', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(188, '', 'BLS WAGON', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(189, '', 'CTS', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(190, '', 'DEVILLE', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(191, '', 'ELDORADO', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(192, '', 'ESCALADE', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(193, '', 'FLEETWOOD STRETCH', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(194, '', 'SEDAN VILLE', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(195, '', 'SEVILLE', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(196, '', 'SRX', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(197, '', 'STS', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(198, '', 'XLR', 22, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(204, '', '2500', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(205, '', 'ALERO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(206, '', 'ASTRO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(207, '', 'AVALANCHE', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(208, '', 'AVEO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(209, '', 'BEL AIR', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(210, '', 'BERETTA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(211, '', 'BLAZER', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(212, '', 'C10 PICK-UP', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(213, '', 'C1500', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(214, '', 'CAMARO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(215, '', 'CAPRICE', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(216, '', 'CAPTIVA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(217, '', 'CAVALIER', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(218, '', 'CELEBRITY', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(219, '', 'CHEVELLE', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(220, '', 'CHEVY VAN', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(221, '', 'CITATION', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(222, '', 'COLORADO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(223, '', 'CORSICA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(224, '', 'CORVETTE', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(225, '', 'CREW CAB', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(226, '', 'CRUZE', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(227, '', 'DIXIE VAN', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(228, '', 'EL CAMINO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(229, '', 'EPICA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(230, '', 'EQUINOX', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(231, '', 'EVANDA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(232, '', 'EXPRESS', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(233, '', 'G', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(234, '', 'HHR', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(235, '', 'IMPALA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(236, '', 'K1500', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(237, '', 'K30', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(238, '', 'KALOS', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(239, '', 'LACETTI', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(240, '', 'LUMINA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(241, '', 'MALIBU', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(242, '', 'MATIZ', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(243, '', 'MONTE CARLO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(244, '', 'NIVA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(245, '', 'NUBIRA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(246, '', 'REGENCY ', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(247, '', 'REZZO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(248, '', 'S-10', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(249, '', 'SILVERADO', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(250, '', 'SSR', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(251, '', 'SUBURBAN', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(252, '', 'TACUMA', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(253, '', 'TAHOE', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(254, '', 'T-BLAZER', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(255, '', 'TRAILBLAZER', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(256, '', 'TRANS SPORT', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(257, '', 'UPLANDER', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(258, '', 'VOLT', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(262, '', '300', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(263, '', '300 C', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(264, '', '300 C TOURING ', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(265, '', '300 M', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(266, '', '300 TOURING', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(267, '', 'ASPEN', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(268, '', 'BARON', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(269, '', 'BARON CAB', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(270, '', 'CROSSFIRE', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(271, '', 'DAYTONA', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(272, '', 'ES', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(273, '', 'GRAND VOYAGER', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(274, '', 'GS', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(275, '', 'GTS', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(276, '', 'JEEP CHEROKEE', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(277, '', 'LE BARON', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(278, '', 'NEON', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(279, '', 'NEW YORKER', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(280, '', 'PACIFICA', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(281, '', 'PLYMOUTH', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(282, '', 'PT CRUISER', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(283, '', 'SARATOGA', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(284, '', 'SEBRING', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(285, '', 'STRATUS', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(286, '', 'VALIANT', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(287, '', 'VIPER', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(288, '', 'VISION', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(289, '', 'VOYAGER', 27, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(290, '', '2 CV', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(291, '', 'AX', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(292, '', 'BERLINGO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(293, '', 'BERLINGO BREAK', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(294, '', 'BX', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(295, '', 'C1', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(296, '', 'C2', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(297, '', 'C3', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(298, '', 'C3 PICASSO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(299, '', 'C3 PLURIEL', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(300, '', 'C35', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(301, '', 'C4', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(302, '', 'C4 COUPE', 28, NULL, NULL, NULL, '400.00', '500.00', '2015-02-01 00:00:00', '2016-08-09 11:44:43', 0),
(303, '', 'C4 GRAND PICASSO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(304, '', 'C4 PICASSO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(305, '', 'C5', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(306, '', 'C5 TOURER', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(307, '', 'C6', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(308, '', 'C8', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(309, '', 'C-CROSSER', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(310, '', 'CX', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(311, '', 'DS', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(312, '', 'DS3', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(313, '', 'EVASION', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(314, '', 'GSA', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(315, '', 'JUMPER', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(316, '', 'JUMPY', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(317, '', 'LNA', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(318, '', 'LOMAX', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(319, '', 'NEMO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(320, '', 'SAXO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(321, '', 'SM', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(322, '', 'TRACTION', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(323, '', 'VISA', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(324, '', 'XANTIA', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(325, '', 'XM', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(326, '', 'XSARA', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(327, '', 'XSARA BREAK', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(328, '', 'XSARA PICASSO', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(329, '', 'ZX', 28, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(339, '', 'BERLINA', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(340, '', 'BREAK', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(341, '', 'DOUBLE CAB', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(342, '', 'DROP SIDE', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(343, '', 'DUSTER', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(344, '', 'LOGAN', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(345, '', 'NOVA', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(346, '', 'PICK UP', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(347, '', 'SANDERO', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(348, '', 'SOLENZA', 32, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(349, '', 'ARANOS', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(350, '', 'ESPERO', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(351, '', 'EVANDA', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(352, '', 'KALOS', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(353, '', 'KORANDO', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(354, '', 'LACETTI', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(355, '', 'LANOS', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(356, '', 'LEGANZA', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(357, '', 'MATIZ', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(358, '', 'MUSSO', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(359, '', 'NEXIA', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(360, '', 'NUBIRA', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(361, '', 'REZZO', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(362, '', 'TACUMA', 33, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(363, '', 'APPLAUSE', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(364, '', 'CHARADE', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(365, '', 'CHARMANT', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(366, '', 'COPEN', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(367, '', 'CUORE', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(368, '', 'DOMINO', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(369, '', 'EXTOL', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(370, '', 'FEROZA', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(371, '', 'FREECLIMBER', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(372, '', 'GRAN MOVE', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(373, '', 'HIJET', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(374, '', 'MATERIA', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(375, '', 'MOVE', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(376, '', 'ROCKY', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(377, '', 'SIRION', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(378, '', 'TAFT', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(379, '', 'TERIOS', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(380, '', 'TREVIS', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(381, '', 'VALERA', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(382, '', 'YRV', 34, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(383, '', 'SUPER EIGHT', 35, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(384, '', 'XJ', 35, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(389, '', 'AVENGER', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(390, '', 'CALIBER', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(391, '', 'CHALLENGER', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(392, '', 'CHARGER', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(393, '', 'CORONET', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(394, '', 'DAKOTA', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(395, '', 'DURANGO', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(396, '', 'GRAND CARAVAN', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(397, '', 'JOURNEY', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(398, '', 'MAGNUM', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(399, '', 'NEON', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(400, '', 'NITRO', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(401, '', 'RAM', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(402, '', 'RAM 1500', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(403, '', 'RAM 2500', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(404, '', 'STEALTH', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(405, '', 'STRATUS', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(406, '', 'VAN', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(407, '', 'VIPER', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(408, '', 'WC 52', 39, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(412, '', '195', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(413, '', '206', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(414, '', '208', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(415, '', '246', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(416, '', '250', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(417, '', '275', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(418, '', '288', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(419, '', '308', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(420, '', '328', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(421, '', '330', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(422, '', '348', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(423, '', '355 ', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(424, '', '360 ', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(425, '', '365', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(426, '', '400', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(427, '', '412', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(428, '', '456', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(429, '', '512', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(430, '', '550 ', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(431, '', '575', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(432, '', '599', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(433, '', '612 ', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(434, '', '750', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(435, '', 'CALIFORNIA', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(436, '', 'DAYTONA', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(437, '', 'DINO', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(438, '', 'ENZO', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(439, '', 'F355', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(440, '', 'F360', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(441, '', 'F40', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(442, '', 'F430', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(443, '', 'F50', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(444, '', 'F512', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(445, '', 'MONDIAL', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(446, '', 'SUPERAMERICA', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(447, '', 'TESTAROSSA', 42, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(448, '', '124', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(449, '', '126', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(450, '', '127', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(451, '', '130', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(452, '', '131', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(453, '', '242', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(454, '', '500', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(455, '', '600', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(456, '', 'ABARTH', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(457, '', 'BARCHETTA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(458, '', 'BRAVA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(459, '', 'BRAVO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(460, '', 'CAMPAGNOLA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(461, '', 'COUPE', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(462, '', 'CROMA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(463, '', 'DINO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(464, '', 'DOBLO ', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(465, '', 'DUNA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(466, '', 'FIORINO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(467, '', 'GRANDE PUNTO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(468, '', 'IDEA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(469, '', 'LINEA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(470, '', 'MAREA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(471, '', 'MAREA WEEK END', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(472, '', 'MARENGO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(473, '', 'MULTIPLA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(474, '', 'PALIO ', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(475, '', 'PANDA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(476, '', 'PENNY', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(477, '', 'PUNTO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(478, '', 'PUNTO EVO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(479, '', 'QUBO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(480, '', 'REGATA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(481, '', 'RITMO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(482, '', 'SEDICI', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(483, '', 'SEICENTO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(484, '', 'SPIDER EUROPA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(485, '', 'STILO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(486, '', 'STRADA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(487, '', 'TEMPRA', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(488, '', 'TIPO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(489, '', 'ULYSSE', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(490, '', 'UNO', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(491, '', 'X 1/9', 43, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(492, '', 'AEROSTAR', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(493, '', 'BRONCO', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(494, '', 'C', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(495, '', 'CAPRI', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(496, '', 'C-MAX', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(497, '', 'COUGAR', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(498, '', 'COURIER', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(499, '', 'CROWN', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(500, '', 'ECONOLINE', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(501, '', 'ECONOVAN', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(502, '', 'EDGE', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(503, '', 'ESCAPE', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(504, '', 'ESCORT', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(505, '', 'EXCURSION', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(506, '', 'EXPEDITION', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(507, '', 'EXPLORER', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(508, '', 'F 350', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(509, '', 'F100', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(510, '', 'F150', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(511, '', 'F250  ', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(512, '', 'FIESTA', 44, NULL, '400.00', NULL, '400.00', NULL, '2015-02-01 00:00:00', '2016-08-11 15:17:22', 0),
(513, '', 'FOCUS', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(514, '', 'FOCUS CC', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(515, '', 'FOCUS CLIPPER', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(516, '', 'FOCUS C-MAX', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(517, '', 'FOCUS SEDAN', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(518, '', 'FOCUS SW', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(519, '', 'FORD A ROADSTER', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(520, '', 'FREESTAR', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(521, '', 'FREESTYLE', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(522, '', 'FUSION', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(523, '', 'GALAXY', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(524, '', 'GRANADA', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(525, '', 'GT ', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(526, '', 'KA', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(527, '', 'KUGA', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(528, '', 'M', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(529, '', 'MAVERICK', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(530, '', 'MAX', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(531, '', 'MERCURY', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(532, '', 'MONDEO', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(533, '', 'MONDEO BREAK', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(534, '', 'MUSTANG', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(535, '', 'ORION', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(536, '', 'PROBE', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(537, '', 'PUMA', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(538, '', 'RANGER', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(539, '', 'SCORPIO', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(540, '', 'SIERRA', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(541, '', 'S-MAX', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0);
INSERT INTO `carmodels` (`id`, `code`, `name`, `mark_id`, `consumption_01`, `consumption_02`, `consumption_03`, `consumption_04`, `consumption_05`, `created`, `modified`, `user_id`) VALUES
(542, '', 'STREETKA', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(543, '', 'TAUNUS', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(544, '', 'TAURUS', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(545, '', 'THUNDERBIRD', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(546, '', 'TOURNEO', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(547, '', 'TOURNEO CONNECT', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(548, '', 'TRANSIT', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(549, '', 'TRANSIT CONNECT', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(550, '', 'TRANSIT KOMBI', 44, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(573, '', 'ACADIA', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(574, '', 'ANDERE - OTHERS', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(575, '', 'ENVOY', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(576, '', 'JIMMY', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(577, '', 'SAFARI', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(578, '', 'SAVANA', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(579, '', 'SIERRA', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(580, '', 'SONOMA', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(581, '', 'SYCLONE', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(582, '', 'TYPHOON', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(583, '', 'VANDURA', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(584, '', 'YUKON', 51, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(585, '', 'MIDI ', 52, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(586, '', 'ACCORD', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(587, '', 'ACCORD TOURER', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(588, '', 'BEAT', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(589, '', 'CIVIC', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(590, '', 'CONCERTO', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(591, '', 'CR V', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(592, '', 'CR Z', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(593, '', 'CRV', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(594, '', 'CRX', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(595, '', 'ELEMENT', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(596, '', 'FR V', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(597, '', 'HR V', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(598, '', 'INSIGHT', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(599, '', 'INTEGRA', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(600, '', 'JAZZ', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(601, '', 'LEGEND', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(602, '', 'NSX', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(603, '', 'ODYSSEY', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(604, '', 'PRELUDE', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(605, '', 'S 2000', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(606, '', 'SHUTTLE', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(607, '', 'STREAM', 53, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(609, '', 'H1', 55, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(610, '', 'H2', 55, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(611, '', 'H3', 55, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(612, '', 'ACCENT', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(613, '', 'ATOS', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(614, '', 'AZERA', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(615, '', 'COUPE', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(616, '', 'ELANTRA', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(617, '', 'EXCEL', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(618, '', 'GALLOPER', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(619, '', 'GETZ', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(620, '', 'GRANDEUR', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(621, '', 'H 100 ', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(622, '', 'H 200', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(623, '', 'H1', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(624, '', 'H-1', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(625, '', 'H-1 CARGO', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(626, '', 'H-1 STAREX', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(627, '', 'H-1 TRAVEL', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(628, '', 'HIGHWAY', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(629, '', 'I 10', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(630, '', 'I 20', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(631, '', 'I 30', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(632, '', 'I 30 VAN', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(633, '', 'I30', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(634, '', 'IX 35', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(635, '', 'IX55', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(636, '', 'LANTRA', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(637, '', 'MATRIX', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(638, '', 'PONY', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(639, '', 'SANTA FE', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(640, '', 'SANTA FE VAN', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(641, '', 'SANTAMO', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(642, '', 'SATELLITE', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(643, '', 'S-COUPE', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(644, '', 'SONATA', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(645, '', 'SONICA', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(646, '', 'TERRACAN', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(647, '', 'TRAJET', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(648, '', 'TUCSON', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(649, '', 'TUCSON VAN', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(650, '', 'XG 30', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(651, '', 'XG 350', 56, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(652, '', 'EX35', 57, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(653, '', 'EX37', 57, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(654, '', 'FX', 57, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(655, '', 'G37', 57, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(659, '', 'CAMPO', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(660, '', 'DLX', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(661, '', 'D-MAX', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(662, '', 'GEMINI', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(663, '', 'MIDI', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(664, '', 'PICK UP', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(665, '', 'RODEO', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(666, '', 'TROOPER', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(667, '', 'WFR', 59, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(670, '', 'MASSIF', 61, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(671, '', '420', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(672, '', 'DAIMLER', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(673, '', 'D-TYPE', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(674, '', 'E', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(675, '', 'MK II', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(676, '', 'SOVEREIGN', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(677, '', 'S-TYPE', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(678, '', 'TYPE', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(679, '', 'X TYPE', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(680, '', 'X300', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(681, '', 'XF ', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(682, '', 'XFR ', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(683, '', 'XJ', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(684, '', 'XJSC', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(685, '', 'XK ', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(686, '', 'XK CABRIOLET ', 62, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(691, '', 'CHEROKEE', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(692, '', 'CJ-5', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(693, '', 'CJ-7', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(694, '', 'CJ-8', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(695, '', 'COMANCHE', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(696, '', 'COMMANDER', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(697, '', 'COMPASS', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(698, '', 'GRAND CHEROKEE', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(699, '', 'PATRIOT', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(700, '', 'RENEGADE', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(701, '', 'WAGONEER', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(702, '', 'WILLYS', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(703, '', 'WRANGLER', 65, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(704, '', 'BESTA', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(705, '', 'CARENS', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(706, '', 'CARNIVAL', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(707, '', 'CEED', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(708, '', 'CEE\'D', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(709, '', 'CERATO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(710, '', 'CLARUS', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(711, '', 'ELAN', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(712, '', 'JOICE', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(713, '', 'LEO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(714, '', 'MAGENTIS', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(715, '', 'MENTOR', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(716, '', 'MOHAVE/BORREGO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(717, '', 'OPIRUS', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(718, '', 'PICANTO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(719, '', 'PREGIO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(720, '', 'PRIDE', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(721, '', 'PRO-CEED', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(722, '', 'REGIO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(723, '', 'RETONA', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(724, '', 'RIO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(725, '', 'ROADSTER', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(726, '', 'ROCSTA', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(727, '', 'SEPHIA', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(728, '', 'SHUMA', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(729, '', 'SORENTO', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(730, '', 'SOUL', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(731, '', 'SPORTAGE', 67, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(733, '', '110', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(734, '', '111', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(735, '', '112', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(736, '', '1200', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(737, '', '2107', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(738, '', 'ALEKO', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(739, '', 'C-CROSS', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(740, '', 'FORMA', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(741, '', 'KALINA', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(742, '', 'NIVA', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(743, '', 'NOVA', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(744, '', 'PRIORA', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(745, '', 'SAMARA', 69, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(746, '', 'COUNTACH', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(747, '', 'DIABLO', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(748, '', 'ESPADA', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(749, '', 'GALLARDO', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(750, '', 'GALLARDO ROADSTER ', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(751, '', 'JALPA', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(752, '', 'LM', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(753, '', 'MIURA', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(754, '', 'MURCIELAGO', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(755, '', 'MURCIELAGO ROADSTER', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(756, '', 'URRACO P250', 70, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(757, '', 'AURELIA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(758, '', 'BETA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(759, '', 'DEDRA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(760, '', 'DEDRA STATION WAGON', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(761, '', 'DELTA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(762, '', 'FLAMINA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(763, '', 'FULVIA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(764, '', 'GAMMA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(765, '', 'K', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(766, '', 'KAPPA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(767, '', 'LYBRA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(768, '', 'MUSA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(769, '', 'PHEDRA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(770, '', 'PRISMA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(771, '', 'STRATOS', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(772, '', 'THEMA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(773, '', 'THESIS', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(774, '', 'Y', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(775, '', 'Y10', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(776, '', 'YPSILON', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(777, '', 'Z', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(778, '', 'ZETA', 71, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(779, '', 'DEFENDER', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(780, '', 'DISCOVERY', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(781, '', 'FREELANDER', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(782, '', 'LRX', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(783, '', 'RANGE ROVER', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(784, '', 'SERIE 3', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(785, '', 'SPORT', 72, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(786, '', 'S', 73, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(787, '', 'SC2', 73, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(788, '', 'SC4', 73, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(790, '', 'ES 300', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(791, '', 'ES 350', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(792, '', 'GS', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(793, '', 'GS 300', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(794, '', 'GS 430', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(795, '', 'GS 450 H', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(796, '', 'GS 460', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(797, '', 'GX 470', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(798, '', 'IS ', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(799, '', 'IS 200', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(800, '', 'IS 220', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(801, '', 'IS 220D', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(802, '', 'IS 250', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(803, '', 'IS 300', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(804, '', 'IS 500', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(805, '', 'IS F', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(806, '', 'IS SEDAN', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(807, '', 'LS', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(808, '', 'LX ', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(809, '', 'RX 300', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(810, '', 'RX 330', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(811, '', 'RX 350', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(812, '', 'RX 400', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(813, '', 'SC 400', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(814, '', 'SC 430', 75, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(825, '', 'AVIATOR', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(826, '', 'CONTINENTAL', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(827, '', 'LS', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(828, '', 'MARK', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(829, '', 'NAVIGATOR', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(830, '', 'TOWN CAR', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(831, '', 'ZEPHYR', 77, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(832, '', '340 R', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(833, '', 'CORTINA', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(834, '', 'ELAN', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(835, '', 'ELISE', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(836, '', 'ELITE', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(837, '', 'ESPRIT', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(838, '', 'EUROPA', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(839, '', 'EXCEL', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(840, '', 'EXIGE', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(841, '', 'OMEGA', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(842, '', 'SUPER SEVEN', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(843, '', 'V8', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(844, '', 'VENTURI', 78, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(846, '', 'BOLERO', 80, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(847, '', 'CJ', 80, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(848, '', 'GOA', 80, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(849, '', 'JEEP', 80, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(855, '', '222 ', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(856, '', '224', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(857, '', '228', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(858, '', '3200 ', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(859, '', '418', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(860, '', '420', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(861, '', '4200', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(862, '', '422', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(863, '', '424', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(864, '', '430', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(865, '', 'BITURBO', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(866, '', 'COUPE', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(867, '', 'GHIBLI', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(868, '', 'GRANCABRIO', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(869, '', 'GRANSPORT', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(870, '', 'GRANTURISMO', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(871, '', 'INDY', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(872, '', 'KARIF', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(873, '', 'MC 12', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(874, '', 'MERAK', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(875, '', 'QUATTROPORTE', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(876, '', 'SHAMAL', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(877, '', 'SPYDER', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(878, '', 'TC', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(879, '', 'V8', 82, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(883, '', '121', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(884, '', '2', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(885, '', '3', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(886, '', '323', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(887, '', '5', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(888, '', '6', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(889, '', '6 SEDAN ', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(890, '', '626', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(891, '', '929', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(892, '', 'B 2500 ', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(893, '', 'B 2600', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(894, '', 'BT-50', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(895, '', 'CX-7', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(896, '', 'CX-9', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(897, '', 'DEMIO', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(898, '', 'E', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(899, '', 'MPV', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(900, '', 'MX-3', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(901, '', 'MX-5', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(902, '', 'MX-6', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(903, '', 'PICK UP', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(904, '', 'PREMACY', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(905, '', 'RX-6', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(906, '', 'RX-7', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(907, '', 'RX-8', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(908, '', 'SEDAN', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(909, '', 'TRIBUTE', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(910, '', 'XEDOS ', 85, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(911, '', 'CLASSE CLK COUPE', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(912, '', '190', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(913, '', '220 ', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(914, '', '250', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(915, '', '280 COUPE', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(916, '', '320 AMG ', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(917, '', 'CLASSE A', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(918, '', 'CLASSE B', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(919, '', 'CLASSE C', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(920, '', 'CLASSE C BREAK', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(921, '', 'CLASSE C COUPE', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(922, '', 'CLASSE CL', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(923, '', 'CLASSE CLC', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(924, '', 'CLASSE CLC COUPE', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(925, '', 'CLASSE CLK', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(926, '', 'CLASSE CLK CABRIO', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(927, '', 'CLASSE CLS', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(928, '', 'CLASSE D', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(929, '', 'CLASSE E', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(930, '', 'CLASSE E BREAK', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(931, '', 'CLASSE E CABRIO', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(932, '', 'CLASSE E COUPE', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(933, '', 'CLASSE G', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(934, '', 'CLASSE GL', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(935, '', 'CLASSE GLK', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(936, '', 'CLASSE M', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(937, '', 'CLASSE ML', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(938, '', 'CLASSE R', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(939, '', 'CLASSE S', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(940, '', 'CLASSE SL', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(941, '', 'CLASSE SLK', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(942, '', 'CLASSE SLK CABRIO', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(943, '', 'CLASSE SLR ', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(944, '', 'CLASSE V', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(945, '', 'SERIE ML', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(946, '', 'VANEO', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(947, '', 'VIANO', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(948, '', 'VITO', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(949, '', 'W123', 86, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(950, '', 'F', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(951, '', 'MGA', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(952, '', 'MGB', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(953, '', 'MGB', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(954, '', 'MGF', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(955, '', 'SINGER ', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(956, '', 'TD', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(957, '', 'TF', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(958, '', 'ZR', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(959, '', 'ZS', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(960, '', 'ZT', 87, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(961, '', '1000', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(962, '', '1300', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(963, '', 'BRITISH OPEN CLASSIC', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(964, '', 'CLUBMAN', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(965, '', 'COOPER', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(966, '', 'COOPER CABRIO', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(967, '', 'COOPER CLUBMAN', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(968, '', 'ONE', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(969, '', 'ONE CABRIO', 88, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(970, '', '3000 GT', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(971, '', 'CARISMA', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(972, '', 'COLT', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(973, '', 'COLT CZ3', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(974, '', 'COLT CZC', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(975, '', 'ECLIPSE', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(976, '', 'GALANT', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(977, '', 'GRANDIS', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(978, '', 'L200', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(979, '', 'LANCER', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(980, '', 'MONTERO', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(981, '', 'OUTLANDER', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(982, '', 'PAJERO', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(983, '', 'PAJERO COURT', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(984, '', 'PAJERO PININ', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(985, '', 'SPACE RUNNER', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(986, '', 'SPACE STAR', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(987, '', 'SPACE WAGON', 89, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(989, '', 'COWLEY', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(990, '', 'EIGHT', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(991, '', 'FOURTEEN', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(992, '', 'ISIS', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(993, '', 'MAJOR', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(994, '', 'MINOR', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(995, '', 'MINOR MM', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(996, '', 'OXFORD', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(997, '', 'OXFORD (BULLNOSE)', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(998, '', 'TEN', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(999, '', 'TWELVE', 91, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1000, '', '100 NX', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1001, '', '200 SX', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1002, '', '300 ZX', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1003, '', '350 Z', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1004, '', '350 Z CABRIO', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1005, '', '370 Z', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1006, '', 'ALMERA', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1007, '', 'ALMERA TINO', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1008, '', 'BLUEBIRD', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1009, '', 'CABSTAR', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1010, '', 'CUBE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1011, '', 'GT R 3 8', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1012, '', 'JUKE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1013, '', 'KING CAB', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1014, '', 'KING CABINE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1015, '', 'MAXIMA', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1016, '', 'MICRA', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1017, '', 'MICRA CC', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1018, '', 'MURANO', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1019, '', 'NAVARA', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1020, '', 'NOTE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1021, '', 'OUTLANDER', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1022, '', 'PATHFINDER', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1023, '', 'PATROL', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1024, '', 'PICK UP', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1025, '', 'PIXO', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1026, '', 'PRAIRIE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1027, '', 'PRIMERA', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1028, '', 'PRIMERA BREAK', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1029, '', 'QASHQAI', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1030, '', 'SERENA', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1031, '', 'SKYLINE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1032, '', 'SUNNY', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1033, '', 'TERRANO', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1034, '', 'TINO', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1035, '', 'TITAN', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1036, '', 'VANETTE', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1037, '', 'X-TRAIL', 92, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1038, '', 'AGILA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1039, '', 'ANTARA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1040, '', 'ASTRA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1041, '', 'ASTRA BREAK', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1042, '', 'ASTRA TWINTOP', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1043, '', 'CALIBRA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1044, '', 'CAMPO', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1045, '', 'COMBO ', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1046, '', 'COMMODORE', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1047, '', 'CORSA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1048, '', 'CORSA VAN', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1049, '', 'FRONTERA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1050, '', 'GT', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1051, '', 'INSIGNIA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1052, '', 'INSIGNIA TOURER', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1053, '', 'KADETT', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1054, '', 'KADETT CAB', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1055, '', 'MANTA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1056, '', 'MERIVA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1057, '', 'MONTEREY', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1058, '', 'MOVANO ', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1059, '', 'OMEGA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1060, '', 'OMEGA BREAK', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1061, '', 'SIGNUM', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1062, '', 'SINTRA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1063, '', 'SPEEDSTER', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1064, '', 'TIGRA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1065, '', 'TIGRA TWIN TOP', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1066, '', 'VECTRA ', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1067, '', 'VECTRA BREAK', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1068, '', 'VIVARO', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1069, '', 'ZAFIRA', 93, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1070, '', '1007', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1071, '', '104', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1072, '', '106', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1073, '', '107', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1074, '', '201', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1075, '', '203', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1076, '', '205', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1077, '', '206', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1078, '', '206 CABRIOLET', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1079, '', '206 SW', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1080, '', '207', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0);
INSERT INTO `carmodels` (`id`, `code`, `name`, `mark_id`, `consumption_01`, `consumption_02`, `consumption_03`, `consumption_04`, `consumption_05`, `created`, `modified`, `user_id`) VALUES
(1081, '', '207 CABRIOLET', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1082, '', '207 SW', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1083, '', '3008', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1084, '', '306', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1085, '', '306 BREAK', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1086, '', '306 CABRIOLET', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1087, '', '307', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1088, '', '307 CABRIOLET', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1089, '', '307 SW', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1090, '', '308', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1091, '', '308 CABRIOLET', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1092, '', '308 SW', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1093, '', '309', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1094, '', '4007', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1095, '', '405', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1096, '', '405 SW', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1097, '', '406', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1098, '', '407', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1099, '', '407 COUPE', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1100, '', '407 SW', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1101, '', '5008', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1117, '', '356 ', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1118, '', '911', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1119, '', '911 CABRIOLET', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1120, '', '911 TARGA', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1121, '', '912', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1122, '', '914 ', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1123, '', '914 CABRIO', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1124, '', '928', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1125, '', '944', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1126, '', '964', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1127, '', '968', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1128, '', '993', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1129, '', '996', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1130, '', '997 CABRIOLET', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1131, '', '997 TARGA ', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1132, '', 'BOXSTER', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1133, '', 'CAYENNE', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1134, '', 'CAYMAN', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1135, '', 'PANAMERA', 99, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1137, '', 'CLIO', 100, NULL, NULL, NULL, '630.00', NULL, '2015-02-01 00:00:00', '2016-11-05 16:29:39', 0),
(1138, '', 'CLIO GRANDTOUR', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1139, '', 'ESPACE', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1140, '', 'GRAND ESPACE', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1141, '', 'GRAND MODUS', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1142, '', 'GRAND SCENIC', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1143, '', 'KANGOO', 100, '150.00', NULL, NULL, '100.00', NULL, '2015-02-01 00:00:00', '2016-06-19 12:53:57', 0),
(1144, '', 'KOLEOS', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1145, '', 'LAGUNA', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1146, '', 'LAGUNA BREAK', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1147, '', 'LAGUNA COUPE', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1148, '', 'MASTER', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1149, '', 'MEGANE', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1150, '', 'MEGANE  CABRIOLET', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1151, '', 'MEGANE COUPE', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1152, '', 'MEGANE GRANDTOUR', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1153, '', 'MEGANE R26 ', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1154, '', 'MEGANE RS ', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1155, '', 'MEGANE SEDAN', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1156, '', 'MODUS', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1157, '', 'R19 ', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1158, '', 'R21', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1159, '', 'R25', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1160, '', 'R4', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1161, '', 'R5', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1162, '', 'R9', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1163, '', 'SAFRANE', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1164, '', 'SCENIC', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1165, '', 'SPIDER', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1166, '', 'TRAFIC', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1167, '', 'TWINGO', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1168, '', 'VEL SATIS', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1169, '', 'SERIE 2000', 101, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1170, '', 'CORNICHE CABRIOLET', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1171, '', 'PHANTOM', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1172, '', 'SILVER DAWN', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1173, '', 'SILVER SERAPH', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1174, '', 'SILVER SHADOW', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1175, '', 'SILVER SPIRIT', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1176, '', 'SILVER SPUR', 102, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1177, '', '111', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1178, '', '114', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1179, '', '115', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1180, '', '200', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1181, '', '214', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1182, '', '216', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1183, '', '218', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1184, '', '220', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1185, '', '2200', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1186, '', '25', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1187, '', '3500', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1188, '', '414', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1189, '', '416', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1190, '', '420', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1191, '', '45', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1192, '', '620', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1193, '', '75', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1194, '', '825', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1195, '', 'MINI', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1196, '', 'STREETWISE', 103, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1197, '', '900', 104, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1198, '', '9000', 104, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1199, '', '9-3', 104, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1200, '', '9-3 CABRIO', 104, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1201, '', '9-5', 104, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1202, '', '9-5 ESTATE', 104, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1208, '', '5008', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1209, '', 'ALHAMBRA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1210, '', 'ALTEA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1211, '', 'ALTEA FREETRACK', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1212, '', 'ALTEA XL', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1213, '', 'AROSA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1214, '', 'CORDOBA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1215, '', 'CORDOBA VARIO', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1216, '', 'EXEO', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1217, '', 'IBIZA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1218, '', 'INCA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1219, '', 'LEON', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1220, '', 'LEON SPORT', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1221, '', 'MARBELLA', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1222, '', 'TOLEDO', 106, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1223, '', 'FABIA', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1224, '', 'FABIA BREAK', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1225, '', 'FABIA COMBI', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1226, '', 'FABIA SPORT', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1227, '', 'FELICIA', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1228, '', 'FELICIA BREAK', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1229, '', 'OCTAVIA', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1230, '', 'OCTAVIA COMBI', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1231, '', 'OCTAVIA SCOUT', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1232, '', 'ROOMSTER', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1233, '', 'SUPERB', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1234, '', 'SUPERB ', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1235, '', 'YETI', 107, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1236, '', 'CROSSBLADE', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1237, '', 'FORFOUR', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1238, '', 'FORTWO', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1239, '', 'FORTWO CAB', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1240, '', 'FORTWO COUPE', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1241, '', 'ROADSTER', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1242, '', 'ROADSTER COUPE', 108, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1243, '', 'ACTYON', 109, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1244, '', 'KORANDO', 109, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1245, '', 'KYRON', 109, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1246, '', 'MUSSO', 109, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1247, '', 'REXTON', 109, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1248, '', 'RODIUS', 109, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1249, '', 'B9 TRIBECA', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1250, '', 'FORESTER', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1251, '', 'IMPREZA', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1252, '', 'JUSTY', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1253, '', 'LEGACY', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1254, '', 'OUTBACK BRK', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1255, '', 'SVX', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1256, '', 'TRIBECA', 110, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1257, '', 'ALTO', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1258, '', 'BALENO', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1259, '', 'GRAND VITARA', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1260, '', 'IGNIS', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1261, '', 'JIMNY', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1262, '', 'JIMNY CABRIOLET', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1263, '', 'LIANA', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1264, '', 'SAMURAI', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1265, '', 'SJ ', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1266, '', 'SPLASH', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1267, '', 'SWIFT', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1268, '', 'SWIFT SPORT', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1269, '', 'SX4', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1270, '', 'VITARA', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1271, '', 'WAGON R', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1272, '', 'X90', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1273, '', 'XL7', 111, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1275, '', '4-RUNNER', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1276, '', 'AURIS', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1277, '', 'AVENSIS', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1278, '', 'AVENSIS BREAK', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1279, '', 'AYGO', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1280, '', 'CAMRY', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1281, '', 'CARINA ', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1282, '', 'CELICA', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1283, '', 'COROLLA', 113, NULL, NULL, NULL, '700.00', NULL, '2015-02-01 00:00:00', '2016-05-10 13:23:54', 0),
(1284, '', 'COROLLA COUPE', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1285, '', 'COROLLA VERSO', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1286, '', 'FJ CRUISER', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1287, '', 'HI ACE', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1288, '', 'HIGHLANDER', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1289, '', 'HILUX', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1290, '', 'IQ', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1291, '', 'LAND CRUISER', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1292, '', 'MATRIX ', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1293, '', 'MR', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1294, '', 'PICNIC', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1295, '', 'PREVIA', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1296, '', 'PRIUS', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1297, '', 'RAV4', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1298, '', 'STARLET', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1299, '', 'SUPRA', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1300, '', 'TUNDRA', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1301, '', 'URBAN CRUISER', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1302, '', 'YARIS', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1303, '', 'YARIS VERSO', 113, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1310, '', 'BORA', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1311, '', 'CADDY', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1312, '', 'CALIFORNIA', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1313, '', 'CARAVELLE', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1314, '', 'COCCINELLE', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1315, '', 'CORRADO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1316, '', 'CROSS GOLF', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1317, '', 'CROSS POLO ', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1318, '', 'EOS', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1319, '', 'EOS CABRIO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1320, '', 'FOX', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1321, '', 'GOLF', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1322, '', 'GOLF BREAK', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1323, '', 'GOLF PLUS', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1324, '', 'JETTA', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1325, '', 'KARMANN', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1326, '', 'LUPO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1327, '', 'MULTIVAN', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1328, '', 'NEW BEETLE', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1329, '', 'NEW BEETLE CABRIO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1330, '', 'PASSAT', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1331, '', 'PASSAT CC SPORT ', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1332, '', 'PASSAT VARIANT', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1333, '', 'PHAETON', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1334, '', 'POLO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1335, '', 'ROUTAN ', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1336, '', 'SCIROCCO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1337, '', 'SHARAN', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1338, '', 'T5', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1339, '', 'TARO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1340, '', 'TIGUAN', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1341, '', 'TOUAREG', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1342, '', 'TOURAN', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1343, '', 'VENTO', 117, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1344, '', '440 GLE', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1345, '', 'AMAZON', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1346, '', 'C 70 CABRIO', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1347, '', 'C30', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1348, '', 'C30 COUPE ', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1349, '', 'C70', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1350, '', 'C70 CABRIOLET', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1351, '', 'P 1800 ', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1352, '', 'S 60 ', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1353, '', 'S40', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1354, '', 'S60', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1355, '', 'S80', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1356, '', 'V40', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1357, '', 'V50', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1358, '', 'V70', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1359, '', 'XC 60', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1360, '', 'XC 70', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1361, '', 'XC 90', 118, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1363, '', '504', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1364, '', '504 COUPE', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1365, '', '505', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1366, '', '508', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1367, '', '604', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1368, '', '605', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1369, '', '607', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1370, '', '806', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1371, '', '807', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1372, '', 'BIPPER', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1373, '', 'BIPPER TEPEE', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1374, '', 'BOXER', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1375, '', 'EXPERT', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1376, '', 'OUTDOOR', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1377, '', 'PARTNER', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1378, '', 'PARTNER TEPEE', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1379, '', 'RCZ', 94, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1380, '', '800', 120, NULL, NULL, NULL, NULL, NULL, '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0),
(1381, '', 'CLIO 4', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-08 15:29:03', '2015-02-08 15:29:03', 0),
(1382, '', 'Symbole', 100, NULL, NULL, NULL, NULL, NULL, '2015-02-10 10:57:15', '2015-02-10 10:57:15', 0),
(1383, '', 'Sail', 25, NULL, NULL, NULL, NULL, NULL, '2015-02-16 16:54:42', '2015-02-16 16:54:42', 0),
(1384, '', 'CLIO COMPUS', 100, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:08:43', '2016-11-06 12:30:30', 4),
(1385, '', '206+', 94, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:09:06', '2016-11-06 12:10:45', 4),
(1386, '', 'Berlingo  XTR', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:10:16', '2016-11-06 12:10:16', 4),
(1387, '', 'Berlingo  EXCLUSIF', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:11:09', '2016-11-06 12:11:09', 4),
(1388, '', 'Berlingo  Sensation', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:11:32', '2016-11-06 12:11:32', 4),
(1389, '', 'Berlingo  Vitamine', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:11:53', '2016-11-06 12:11:53', 4),
(1390, '', 'Berlingo LIVE', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:12:17', '2016-11-06 12:12:17', 4),
(1391, '', 'C4  1,6 HDI 92cv', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:12:49', '2016-11-06 12:12:49', 4),
(1392, '', 'DS4', 67, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:13:25', '2016-11-06 12:13:25', 4),
(1393, '', 'K2700', 67, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:13:50', '2016-11-06 12:13:50', 4),
(1394, '', 'H100 ', 56, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:15:06', '2016-11-06 12:15:06', 4),
(1395, '', 'C4  1,6 VTI 92cv', 28, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:16:56', '2016-11-06 12:16:56', 4),
(1396, '', 'SPARK LS', 25, NULL, NULL, NULL, NULL, NULL, '2016-11-06 12:17:25', '2016-11-06 12:17:25', 4),
(1397, '', 'Partner', 94, NULL, NULL, NULL, NULL, NULL, '2016-11-30 10:10:10', '2016-11-30 10:10:10', 0),
(1398, '', 'D Wide 18', 100, NULL, NULL, NULL, NULL, NULL, '2016-12-25 16:39:47', '2016-12-25 16:39:47', 0),
(1399, '', '440 dci', 100, NULL, NULL, NULL, NULL, NULL, '2017-02-14 07:16:17', '2017-02-14 07:16:17', 0),
(1400, '', '440 dci 4*6', 100, NULL, NULL, NULL, NULL, NULL, '2017-02-14 07:29:03', '2017-02-14 07:29:03', 0),
(1401, '', '440 dci 4*2', 100, NULL, NULL, NULL, NULL, NULL, '2017-02-14 07:29:21', '2017-02-14 07:29:21', 0),
(1402, '', '440 dci 4*2', 100, NULL, NULL, NULL, NULL, NULL, '2017-02-14 07:29:22', '2017-02-14 07:29:22', 0),
(1403, '', 'Krone', 100, NULL, NULL, NULL, NULL, NULL, '2017-02-14 09:01:58', '2017-02-14 09:01:58', 0),
(1404, '', 'Krone', 122, NULL, NULL, NULL, NULL, NULL, '2017-02-14 09:10:18', '2017-02-14 09:10:18', 0),
(1405, '', '440DXI', 100, NULL, NULL, NULL, NULL, NULL, '2017-03-16 08:01:33', '2017-03-16 08:01:33', 0),
(1406, '', 'REMORQUE', 121, NULL, NULL, NULL, NULL, NULL, '2017-07-04 13:49:15', '2017-07-04 13:49:15', 0),
(1407, '', '31', 33, NULL, NULL, NULL, NULL, NULL, '2017-08-05 08:50:57', '2017-08-05 08:50:57', 0),
(1408, '', 'PRENIUM 440', 100, NULL, NULL, NULL, NULL, NULL, '2017-08-07 09:26:29', '2017-08-07 09:26:29', 0),
(1409, '', 'PREMIUM 440', 100, NULL, NULL, NULL, '85.00', NULL, '2017-08-07 09:28:08', '2017-08-07 18:18:38', 0),
(1410, '', '700', 123, NULL, NULL, NULL, '85.00', NULL, '2017-08-07 10:58:36', '2017-08-07 18:38:52', 0),
(1412, '', '700', 123, NULL, NULL, NULL, NULL, NULL, '2017-08-07 12:26:48', '2017-08-07 12:26:48', 0),
(1413, '', 'PREMIUM 380', 100, NULL, NULL, NULL, '85.00', NULL, '2017-08-07 18:17:35', '2017-08-07 18:17:35', 4),
(1414, '', 'CAMC', 124, NULL, NULL, NULL, '85.00', NULL, '2017-08-07 18:37:12', '2017-08-07 18:37:12', 4),
(1415, '', 'PREMIUM 440', 100, NULL, NULL, NULL, NULL, NULL, '2017-08-07 18:53:04', '2017-08-07 18:53:04', 0),
(1416, '', 'Accent RB', 56, NULL, NULL, NULL, NULL, NULL, '2017-08-19 10:14:53', '2017-08-19 10:14:53', 0),
(1417, '', 'truck', 100, NULL, NULL, NULL, NULL, NULL, '2017-10-05 15:47:50', '2017-10-05 15:47:50', 0),
(1418, '', 'SD', 121, NULL, NULL, NULL, NULL, NULL, '2018-08-07 12:09:24', '2018-08-07 12:09:24', 1),
(1419, '', 'MILDLUM', 100, NULL, NULL, NULL, NULL, NULL, '2018-08-07 12:37:29', '2018-08-07 12:37:29', 1),
(1420, '', 'FMX 6X4', 118, NULL, NULL, NULL, NULL, NULL, '2018-08-07 12:40:39', '2018-08-07 12:40:39', 1),
(1421, '', 'T1000', 128, NULL, NULL, NULL, NULL, NULL, '2018-08-13 10:43:39', '2018-08-13 10:43:39', 0),
(1422, '', 'azerty', 8, NULL, NULL, NULL, NULL, NULL, '2018-08-13 10:51:35', '2018-08-13 10:51:35', 0),
(1423, '', '20', 127, NULL, NULL, NULL, NULL, NULL, '2019-02-17 10:18:24', '2019-02-17 10:18:24', 0);

-- --------------------------------------------------------

--
-- Structure de la table `car_car_statuses`
--

CREATE TABLE `car_car_statuses` (
  `id` mediumint(6) NOT NULL,
  `car_id` mediumint(8) UNSIGNED NOT NULL,
  `car_status_id` tinyint(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `car_categories`
--

CREATE TABLE `car_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `car_categories`
--

INSERT INTO `car_categories` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '001', 'Lourd', '2014-12-28 16:56:57', '2016-07-25 14:27:20', 0, 4),
(2, '002', 'Léger', '2015-01-25 11:14:51', '2016-07-25 14:27:30', 0, 4),
(3, '003', 'Remorque', '2018-06-07 15:21:10', '2018-06-07 15:21:10', 4, 0),
(4, '', 'exp', '2018-11-08 11:51:28', '2018-11-08 11:51:28', 0, 0),
(5, '', 'test', '2018-11-11 13:10:55', '2018-11-11 13:10:55', 0, 0),
(6, '', 'exp', '2018-11-11 13:11:27', '2018-11-11 13:11:27', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `car_groups`
--

CREATE TABLE `car_groups` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL COMMENT 'utilisateur',
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `car_groups`
--

INSERT INTO `car_groups` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'groupe1', '2018-12-15 14:03:36', '2018-12-15 14:03:36', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `car_options`
--

CREATE TABLE `car_options` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT 'prix',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `car_options`
--

INSERT INTO `car_options` (`id`, `code`, `name`, `price`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'Siège enfant', '2000.00', '2015-02-26 00:00:00', '2015-03-11 17:24:46', 0, 0),
(2, '', 'Glacière', NULL, '2015-04-08 18:44:21', '2015-04-08 18:44:21', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `car_options_customer_car`
--

CREATE TABLE `car_options_customer_car` (
  `id` int(11) NOT NULL,
  `customer_car_id` int(11) NOT NULL,
  `car_option_id` tinyint(3) UNSIGNED NOT NULL COMMENT ' identifiant  option voiture',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `car_statuses`
--

CREATE TABLE `car_statuses` (
  `id` tinyint(4) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `wording` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT 'libellé',
  `color` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `bookable` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'à réserver',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `car_statuses`
--

INSERT INTO `car_statuses` (`id`, `code`, `name`, `wording`, `color`, `bookable`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, 'dispo', 'Disponible', NULL, '#5cb85c', 1, '2014-12-28 18:41:27', '2015-01-25 16:44:58', 0, 0),
(6, 'rsv', 'Réservé ', NULL, '#d9534f', 0, '2015-02-04 14:10:25', '2015-02-04 14:18:13', 0, 0),
(8, 'panne', 'En panne', NULL, '#337ab7', 0, '2015-02-16 17:48:29', '2015-02-16 17:48:29', 0, 0),
(24, 'entretien', 'En entretien', NULL, '#f9a600', 0, '2016-07-31 12:31:28', '2016-07-31 12:31:28', 4, 0),
(25, 'réparation', 'En réparation', NULL, '#032580', 0, '2016-07-31 12:34:22', '2016-07-31 12:43:38', 4, 4),
(26, 'immobile', 'Immobilisé', NULL, '#8f8781', 0, '2016-07-31 12:38:53', '2016-07-31 12:45:04', 4, 4),
(27, 'archive', 'Archivé', NULL, '#cf1dc4', 0, '2017-04-09 10:45:59', '2017-04-09 10:46:19', 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `car_types`
--

CREATE TABLE `car_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `average_speed` smallint(6) DEFAULT NULL COMMENT 'vitesse moyenne',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `display_model_mission_order` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `car_types`
--

INSERT INTO `car_types` (`id`, `code`, `name`, `average_speed`, `created`, `modified`, `user_id`, `last_modifier_id`, `display_model_mission_order`) VALUES
(1, '002', 'Citadine', NULL, '2015-01-26 08:56:09', '2018-01-16 10:20:59', 4, 1, NULL),
(2, '004', 'Berline', NULL, '2015-01-26 09:10:40', '2018-01-16 10:17:13', 4, 1, NULL),
(3, '003', 'Caisse (fermée) ', NULL, '2018-08-07 10:25:26', '2019-03-11 15:34:32', 1, 1, NULL),
(7, '005', '4×4', NULL, '2015-01-26 09:12:24', '2018-01-16 10:17:07', 4, 1, NULL),
(10, '001', 'Camion semi-remorque', 60, '2017-02-12 00:00:00', '2018-02-14 16:36:34', 4, 1, NULL),
(11, '006', 'Camion citerne alimentaire ', NULL, '2017-02-12 00:00:00', '2018-01-16 10:17:20', 4, 1, NULL),
(16, '007', 'Camion porte conteneur', NULL, '2017-02-12 13:46:20', '2018-01-16 10:20:51', 4, 1, NULL),
(18, '008', 'Camion plateau', NULL, '2018-08-07 12:47:14', '2018-08-07 12:47:14', 1, 0, NULL),
(19, '009', 'Camion porteur à benne', NULL, '2018-08-07 12:47:33', '2018-08-07 12:47:33', 1, 0, NULL),
(20, '010', 'Camion', NULL, '2018-08-07 16:16:00', '2019-02-19 10:41:03', 1, 1, NULL),
(22, '011', 'Utilitaire', NULL, '2018-08-07 17:02:18', '2018-08-07 17:02:18', 1, 0, NULL),
(23, '012', 'Utilitaire', NULL, '2019-03-11 15:06:23', '2019-03-11 15:34:50', 1, 1, NULL),
(24, '013', 'Citerne carburant', NULL, '2019-03-11 15:06:51', '2019-03-11 15:36:49', 1, 1, NULL),
(25, '014', 'Plateau', NULL, '2019-03-11 15:07:23', '2019-03-11 15:35:32', 1, 1, NULL),
(26, '015', 'A benne', NULL, '2019-03-11 15:07:43', '2019-03-11 15:36:12', 1, 1, NULL),
(27, '016', 'Citerne alimentaire', NULL, '2019-03-11 15:37:24', '2019-03-11 15:37:24', 1, 0, NULL),
(28, '017', 'Toupie', NULL, '2019-03-11 15:40:49', '2019-03-11 15:40:49', 1, 0, NULL),
(29, '018', 'Transport de ciment', NULL, '2019-03-11 15:41:52', '2019-03-11 15:41:52', 1, 0, NULL),
(30, '019', 'Porte char', NULL, '2019-03-11 15:43:55', '2019-03-11 15:43:55', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `car_type_car_categories`
--

CREATE TABLE `car_type_car_categories` (
  `id` int(11) NOT NULL,
  `car_type_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'identifiant type de véhicule ',
  `car_category_id` smallint(5) UNSIGNED NOT NULL COMMENT 'identifiant type véhicule '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `car_type_car_categories`
--

INSERT INTO `car_type_car_categories` (`id`, `car_type_id`, `car_category_id`) VALUES
(12, 7, 2),
(13, 2, 2),
(14, 11, 1),
(15, 16, 1),
(16, 1, 2),
(40, 10, 1),
(48, 22, 2),
(49, 20, 1),
(55, 3, 3),
(56, 23, 3),
(57, 25, 3),
(58, 26, 3),
(59, 24, 3),
(60, 27, 3),
(61, 28, 3),
(62, 29, 3),
(63, 30, 3),
(64, 32, 3);

-- --------------------------------------------------------

--
-- Structure de la table `code_logs`
--

CREATE TABLE `code_logs` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `old_code` varchar(150) COLLATE utf8_bin NOT NULL,
  `new_code` varchar(150) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `category_company` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `adress` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `latlng` text COLLATE utf8_bin,
  `wilaya` int(11) DEFAULT NULL,
  `phone` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `fax` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `mobile` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `site_web` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `rc` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `ai` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `nif` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `social_capital` decimal(10,2) DEFAULT NULL,
  `cb` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `rib` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `legal_form_id` int(2) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `auto` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `company`
--

INSERT INTO `company` (`id`, `name`, `category_company`, `adress`, `latlng`, `wilaya`, `phone`, `fax`, `mobile`, `email`, `site_web`, `rc`, `ai`, `nif`, `social_capital`, `cb`, `rib`, `logo`, `legal_form_id`, `created`, `modified`, `auto`) VALUES
(1, 'SARL HABAT', NULL, 'Rue de la Z.A., Ouzellaguen, Algérie', '(36.5385217, 4.61832389999995)', 72, '034332885', '034332887', '0770829418', NULL, NULL, 'fgfgf', '4554545', 'zzzzzzzzzzz', '70000000.00', 'gtytytttyttyt', '888888888888888', '1434474356.jpeg.png', 5, '2015-02-23 00:00:00', '2019-02-18 15:53:45', 0);

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `num_compte` varchar(150) COLLATE utf8_bin NOT NULL,
  `type_id` tinyint(2) DEFAULT NULL,
  `rib` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `agency` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `amount` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT 'Montant',
  `user_id` int(11) NOT NULL COMMENT 'identifiant Utilisateurs ',
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `consumptions`
--

CREATE TABLE `consumptions` (
  `id` int(11) NOT NULL,
  `nb_coupon` tinyint(3) NOT NULL DEFAULT '0',
  `first_number_coupon` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `last_number_coupon` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `species` double DEFAULT NULL,
  `consumption_liter` float DEFAULT NULL,
  `tank_id` smallint(4) DEFAULT NULL,
  `species_card` double DEFAULT NULL,
  `fuel_card_id` int(11) DEFAULT NULL,
  `nb_liter` float DEFAULT NULL,
  `type_consumption_used` tinyint(2) DEFAULT NULL,
  `sheet_ride_id` int(11) NOT NULL,
  `consumption_date` datetime NOT NULL,
  `cost` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `contracts`
--

CREATE TABLE `contracts` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Fournisseur',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `contract_car_types`
--

CREATE TABLE `contract_car_types` (
  `id` int(11) NOT NULL,
  `contract_id` smallint(5) UNSIGNED NOT NULL,
  `detail_ride_id` int(11) NOT NULL COMMENT 'identifiant trajet',
  `price_ht` double NOT NULL,
  `price_return` double NOT NULL COMMENT 'Prix retour',
  `pourcentage_price_return` tinyint(2) DEFAULT NULL COMMENT 'Pourcentage de prix de retour (%)',
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'numéro de série',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `fuel_log_id` int(11) NOT NULL COMMENT 'identifiant du journal de carburant',
  `consumption_id` int(11) DEFAULT NULL COMMENT 'identifiant feuille de route'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `currencies`
--

CREATE TABLE `currencies` (
  `id` smallint(2) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `abr` varchar(10) COLLATE utf8_bin NOT NULL COMMENT 'abréviation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `abr`) VALUES
(1, 'Dinars', 'DA'),
(2, 'Euros', '€'),
(3, 'Dirham arocain', 'MAD');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(120) COLLATE utf8_bin DEFAULT NULL COMMENT 'prénom',
  `last_name` varchar(120) COLLATE utf8_bin DEFAULT NULL COMMENT 'nom',
  `company` varchar(120) COLLATE utf8_bin DEFAULT NULL COMMENT 'Enterprise',
  `rc` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `if` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ai` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `attachment_rc` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `attachment_if` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `attachment_ai` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `adress` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `latlng` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `mobile` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `email1` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `email2` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `email3` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `birthday` date DEFAULT NULL COMMENT ' date de naissance',
  `birthplace` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'lieu de naissance',
  `job` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `nationality_id` smallint(2) DEFAULT NULL,
  `identity_card_nu` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'numéro de carte d''identité',
  `identity_card_by` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `identity_card_date` datetime DEFAULT NULL,
  `identity_card_scan1` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `identity_card_scan2` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `driver_license_nu` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'Numéro permis de conduire',
  `driver_license_category` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `driver_license_by` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'Délivré par',
  `driver_license_date` datetime DEFAULT NULL,
  `driver_license_expires_date1` date DEFAULT NULL,
  `driver_license_expires_date2` date DEFAULT NULL,
  `driver_license_expires_date3` date DEFAULT NULL,
  `driver_license_expires_date4` date DEFAULT NULL,
  `driver_license_expires_date5` datetime DEFAULT NULL,
  `driver_license_expires_date6` date DEFAULT NULL,
  `driver_license_scan1` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `driver_license_scan2` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `blood_group` varchar(20) COLLATE utf8_bin NOT NULL,
  `passport_nu` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `passport_by` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `passport_date` datetime DEFAULT NULL,
  `passport_scan` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `chifa_card` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `monthly_payroll` decimal(8,2) DEFAULT NULL COMMENT 'la masse salariale mensuelle',
  `cost_center` decimal(8,2) DEFAULT NULL,
  `note` text COLLATE utf8_bin,
  `image` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL,
  `customer_category_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'catégorie conducteur',
  `customer_group_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'groupe de conducteur',
  `zone_id` smallint(6) DEFAULT NULL,
  `parc_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'verrouillé ',
  `service_id` smallint(6) DEFAULT NULL,
  `send_mail` tinyint(1) NOT NULL DEFAULT '0',
  `alert` smallint(1) NOT NULL DEFAULT '0',
  `entry_date` date DEFAULT NULL COMMENT 'Date d''entrée',
  `declaration_date` date DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `affiliate_id` smallint(2) DEFAULT NULL COMMENT 'Affiliation',
  `ccp` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `bank_account` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL DEFAULT '0',
  `date_open` datetime NOT NULL,
  `last_opener` int(11) DEFAULT NULL,
  `adress_family` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `tel_family` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `maximum_driving_time` float DEFAULT NULL COMMENT 'Temps maximum de conduite (Heure)',
  `break_time` float DEFAULT NULL COMMENT 'Temps de repos (Heure)',
  `in_mission` tinyint(2) NOT NULL DEFAULT '0',
  `authorized` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `customer_car`
--

CREATE TABLE `customer_car` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL,
  `car_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `car_type_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `remorque_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL COMMENT 'identifiant  conducteur',
  `customer_group_id` smallint(5) UNSIGNED DEFAULT NULL,
  `zone_id` smallint(6) DEFAULT NULL,
  `accompanist` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `departure_location` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'Lieu de départ',
  `return_location` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'Lieu d''arrivée',
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `end_real` datetime DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'payé',
  `cost_day` decimal(8,2) DEFAULT NULL COMMENT 'coût par jour',
  `date_payment` datetime DEFAULT NULL COMMENT 'date de paiement',
  `km` mediumint(6) DEFAULT NULL,
  `next_km` mediumint(6) DEFAULT NULL,
  `caution` decimal(8,2) DEFAULT NULL,
  `initiale_state` varchar(120) COLLATE utf8_bin NOT NULL COMMENT 'Etat initial',
  `finale_state` varchar(120) COLLATE utf8_bin NOT NULL COMMENT 'Etat final',
  `pictureinit1` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état initial 1',
  `pictureinit2` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état initial 2',
  `pictureinit3` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état initial 3',
  `pictureinit4` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état initial 4',
  `picturefinal1` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état final1',
  `picturefinal2` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l\\''état final2',
  `picturefinal3` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état final3',
  `picturefinal4` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'photos de l''état final4',
  `disabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'désactivée',
  `obs` tinytext COLLATE utf8_bin COMMENT 'observation',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'verrouille',
  `request` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'demande affectation ',
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `temporary` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'affectation temporaire ',
  `affectation` tinyint(1) NOT NULL DEFAULT '0',
  `is_open` tinyint(4) NOT NULL DEFAULT '0',
  `date_open` datetime NOT NULL,
  `last_opener` int(11) DEFAULT NULL,
  `first_name` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `driver_license_nu` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'Numéro permis de conduire',
  `driver_license_date` datetime DEFAULT NULL,
  `driver_license_scan1` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `driver_license_scan2` varchar(150) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `customer_categories`
--

CREATE TABLE `customer_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `discount_rate` smallint(2) DEFAULT NULL COMMENT 'taux de remise',
  `type` smallint(1) NOT NULL DEFAULT '0',
  `driver` tinyint(1) NOT NULL DEFAULT '1',
  `convoyeur` tinyint(1) NOT NULL DEFAULT '1',
  `commercial` tinyint(1) NOT NULL DEFAULT '1',
  `mechanician` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `dairas`
--

CREATE TABLE `dairas` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `wilaya_id` tinyint(3) UNSIGNED NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `dairas`
--

INSERT INTO `dairas` (`id`, `code`, `name`, `wilaya_id`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '9', 'Oujda-Angad', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(2, '10', 'Nador', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(3, '11', 'Driouch', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(4, '12', 'Jerada', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(5, '13', 'Berkan', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(6, '14', 'Taourirt', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(7, '15', 'Guercif', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(8, '16', 'Figuig', 2, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(9, '38', 'Casablanca', 6, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(10, '39', 'Mohammadia', 6, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(11, '40', 'El Jadida', 6, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(12, '41', 'Nouaceur', 6, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(13, '42', 'M?diouna', 6, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(14, '43', 'Benslimane', 6, '2020-01-05 13:59:40', '2020-01-05 13:59:40', 1, 0),
(15, '44', 'Berrechid', 6, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(16, '45', 'Settat', 6, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(17, '46', 'Sidi Bennour', 6, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(18, '47', 'Marrakech', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(19, '48', 'Chichaoua', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(20, '49', 'Al Haouz', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(21, '50', 'Kel?a des Sraghna', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(22, '51', 'Essaouira', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(23, '52', 'Rehamna', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(24, '53', 'Safi', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(25, '54', 'Youssoufia', 7, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(26, '60', 'Agadir Ida-Ou-Tanane', 9, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(27, '61', 'Inezgane-A?t Melloul', 9, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(28, '62', 'Chtouka-A?t Baha', 9, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(29, '63', 'Taroudannt', 9, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(30, '64', 'Tiznit', 9, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(31, '65', 'Tata', 9, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(32, '66', 'Guelmim', 10, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(33, '67', 'Assa-Zag', 10, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(34, '68', 'Tan-Tan', 10, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(35, '69', 'Sidi Ifni', 10, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0),
(36, '75', 'Aousserd?', 12, '2020-01-05 13:59:41', '2020-01-05 13:59:41', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `deadlines`
--

CREATE TABLE `deadlines` (
  `id` int(11) NOT NULL,
  `deadline_date` date NOT NULL,
  `percentage` float DEFAULT NULL,
  `value` float DEFAULT NULL,
  `transport_bill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `departments`
--

CREATE TABLE `departments` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

CREATE TABLE `depots` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `adress` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `destinations`
--

CREATE TABLE `destinations` (
  `id` smallint(6) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `daira_id` smallint(5) UNSIGNED NOT NULL,
  `wilaya_id` tinyint(3) UNSIGNED NOT NULL,
  `latlng` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `last_modifier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `destinations`
--

INSERT INTO `destinations` (`id`, `code`, `name`, `daira_id`, `wilaya_id`, `latlng`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '9', 'Oujda-Angad', 1, 2, NULL, '2020-01-05 14:27:12', '2020-01-05 14:27:12', 1, NULL),
(2, '10', 'Nador', 2, 2, NULL, '2020-01-05 14:27:12', '2020-01-05 14:27:12', 1, NULL),
(3, '11', 'Driouch', 3, 2, NULL, '2020-01-05 14:27:13', '2020-01-05 14:27:13', 1, NULL),
(4, '12', 'Jerada', 4, 2, NULL, '2020-01-05 14:27:13', '2020-01-05 14:27:13', 1, NULL),
(5, '13', 'Berkan', 5, 2, NULL, '2020-01-05 14:27:13', '2020-01-05 14:27:13', 1, NULL),
(6, '14', 'Taourirt', 6, 2, NULL, '2020-01-05 14:27:13', '2020-01-05 14:27:13', 1, NULL),
(7, '15', 'Guercif', 7, 2, NULL, '2020-01-05 14:27:13', '2020-01-05 14:27:13', 1, NULL),
(8, '16', 'Figuig', 8, 2, NULL, '2020-01-05 14:27:14', '2020-01-05 14:27:14', 1, NULL),
(9, '38', 'Casablanca', 9, 6, NULL, '2020-01-05 14:27:14', '2020-01-05 14:27:14', 1, NULL),
(10, '39', 'Mohammadia', 10, 6, NULL, '2020-01-05 14:27:14', '2020-01-05 14:27:14', 1, NULL),
(11, '40', 'El Jadida', 11, 6, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(12, '41', 'Nouaceur', 12, 6, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(13, '43', 'Benslimane', 14, 6, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(14, '44', 'Berrechid', 15, 6, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(15, '45', 'Settat', 16, 6, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(16, '46', 'Sidi Bennour', 17, 6, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(17, '47', 'Marrakech', 18, 7, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(18, '48', 'Chichaoua', 19, 7, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(19, '49', 'Al Haouz', 20, 7, NULL, '2020-01-05 14:27:15', '2020-01-05 14:27:15', 1, NULL),
(20, '51', 'Essaouira', 22, 7, NULL, '2020-01-05 14:27:16', '2020-01-05 14:27:16', 1, NULL),
(21, '52', 'Rehamna', 23, 7, NULL, '2020-01-05 14:27:16', '2020-01-05 14:27:16', 1, NULL),
(22, '53', 'Safi', 24, 7, NULL, '2020-01-05 14:27:16', '2020-01-05 14:27:16', 1, NULL),
(23, '54', 'Youssoufia', 25, 7, NULL, '2020-01-05 14:27:16', '2020-01-05 14:27:16', 1, NULL),
(24, '60', 'Agadir Ida-Ou-Tanane', 26, 9, NULL, '2020-01-05 14:27:16', '2020-01-05 14:27:16', 1, NULL),
(25, '63', 'Taroudannt', 29, 9, NULL, '2020-01-05 14:27:16', '2020-01-05 14:27:16', 1, NULL),
(26, '64', 'Tiznit', 30, 9, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL),
(27, '65', 'Tata', 31, 9, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL),
(28, '66', 'Guelmim', 32, 10, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL),
(29, '67', 'Assa-Zag', 33, 10, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL),
(30, '68', 'Tan-Tan', 34, 10, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL),
(31, '69', 'Sidi Ifni', 35, 10, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL),
(32, '75', 'Aousserd?', 36, 12, NULL, '2020-01-05 14:27:17', '2020-01-05 14:27:17', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `detail_payments`
--

CREATE TABLE `detail_payments` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `sheet_ride_detail_ride_id` int(11) DEFAULT NULL COMMENT 'identifiant mission',
  `transport_bill_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `payroll_amount` decimal(11,2) NOT NULL COMMENT 'montant payé',
  `amount_remaining` decimal(11,2) NOT NULL COMMENT 'Montant restan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `detail_rides`
--

CREATE TABLE `detail_rides` (
  `id` int(11) NOT NULL,
  `wording` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `ride_id` int(11) NOT NULL COMMENT 'identifiant trajet',
  `car_type_id` tinyint(3) UNSIGNED NOT NULL,
  `premium` decimal(10,2) DEFAULT NULL,
  `cost_truck_full` decimal(10,2) DEFAULT NULL COMMENT 'coût de camion complet',
  `cost_truck_empty` decimal(10,2) DEFAULT NULL COMMENT 'coût de mission camion vide',
  `duration_hour` int(6) NOT NULL DEFAULT '0' COMMENT 'Durée théorique (Heure)',
  `duration_day` int(6) NOT NULL DEFAULT '0' COMMENT 'Durée théorique (Jours)',
  `duration_minute` int(6) NOT NULL DEFAULT '0' COMMENT 'Durée théorique (Min)',
  `real_duration_day` int(6) NOT NULL DEFAULT '0' COMMENT 'Durée réel (Jours)',
  `real_duration_hour` int(6) NOT NULL DEFAULT '0' COMMENT 'Durée réel (Heure)',
  `real_duration_minute` int(6) NOT NULL DEFAULT '0' COMMENT 'Durée réel (Min)',
  `distance` int(5) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_bin,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT '1',
  `last_modifier_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `next_date` datetime DEFAULT NULL COMMENT 'prochaine date',
  `date3` datetime DEFAULT NULL,
  `km` mediumint(6) DEFAULT NULL,
  `next_km` mediumint(6) DEFAULT NULL COMMENT 'prochain km',
  `assurance_number` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `folder_number` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'numéro de dossier',
  `assurance_type` tinyint(2) DEFAULT NULL,
  `alert` tinyint(2) NOT NULL DEFAULT '0',
  `obs` text COLLATE utf8_bin COMMENT 'observation',
  `cost` decimal(11,2) DEFAULT '0.00' COMMENT 'coût',
  `refund_amount` decimal(11,2) DEFAULT '0.00' COMMENT 'Montant remboursement',
  `attachment1` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'pièce jointe',
  `attachment2` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment3` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment4` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment5` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `send_mail` tinyint(2) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'verrouillé ',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL,
  `interfering_id` mediumint(9) DEFAULT NULL COMMENT 'identifiant intervenant',
  `event_type_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `car_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL COMMENT 'Conducteur',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `request` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'demande de devis',
  `validated` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'validé',
  `transferred` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'transféré',
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  `date_open` datetime NOT NULL,
  `last_opener` int(11) DEFAULT NULL,
  `pay_customer` tinyint(1) DEFAULT NULL COMMENT 'Payé par le conducteur',
  `refund` tinyint(1) DEFAULT NULL COMMENT 'remboursement',
  `date_refund` date DEFAULT NULL COMMENT 'date remboursement',
  `place` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `latlng` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `contravention_type_id` smallint(3) DEFAULT NULL,
  `driving_licence_withdrawal` tinyint(2) NOT NULL DEFAULT '1',
  `payed` tinyint(2) NOT NULL DEFAULT '2',
  `severity_incident` tinyint(2) DEFAULT NULL COMMENT 'Gravité de l''incident',
  `multiple_event` tinyint(1) NOT NULL DEFAULT '0',
  `sinistre_type` tinyint(2) DEFAULT NULL,
  `dommages_corporels` tinyint(1) DEFAULT NULL,
  `internal_external` smallint(2) NOT NULL DEFAULT '2',
  `mechanician_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `event_category_interfering`
--

CREATE TABLE `event_category_interfering` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `event_type_category_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `interfering_id0` mediumint(9) DEFAULT NULL,
  `interfering_id1` mediumint(9) DEFAULT NULL,
  `interfering_id2` mediumint(9) DEFAULT NULL,
  `cost` decimal(11,2) DEFAULT '0.00' COMMENT 'coût ',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `event_event_types`
--

CREATE TABLE `event_event_types` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL COMMENT ' identifiant d''événement',
  `event_type_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `event_types`
--

CREATE TABLE `event_types` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `with_km` tinyint(1) DEFAULT '0' COMMENT 'avec km ',
  `with_date` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'avec date ',
  `alert_activate` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Alerte activée',
  `transact_type_id` tinyint(2) UNSIGNED NOT NULL COMMENT 'Type de transaction ',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `date` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `next_date` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `date3` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `km` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `next_km` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `many_interferings` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Plusieurs intervenants',
  `maintenance_activate` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' activer la maintenance',
  `alert_km` smallint(5) DEFAULT NULL,
  `alert_date` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `event_types`
--

INSERT INTO `event_types` (`id`, `code`, `name`, `with_km`, `with_date`, `alert_activate`, `transact_type_id`, `created`, `modified`, `user_id`, `last_modifier_id`, `date`, `next_date`, `date3`, `km`, `next_km`, `many_interferings`, `maintenance_activate`, `alert_km`, `alert_date`) VALUES
(0, 'sans', 'sans', 0, 0, 0, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL),
(1, '001', 'Vidange', 1, 1, 1, 2, '2015-01-26 15:27:06', '2018-02-28 15:50:29', 0, 1, 'Date vidange', '', '', '0', '15000', 1, 1, NULL, NULL),
(2, '002', 'Assurance', 0, 1, 1, 2, '2015-01-26 15:31:26', '2016-09-25 14:37:48', 0, 4, 'Date du contrat', 'Date prochaine', 'date 3', '', '', 0, 1, NULL, NULL),
(3, '003', 'Controle Technique', 0, 1, 1, 2, '2015-01-26 16:24:34', '2016-06-09 16:05:43', 0, 4, 'date controle', '', '', '', '', 0, 1, NULL, NULL),
(4, '004', 'Controle Gaz', 1, 0, 1, 2, '2015-01-26 16:24:59', '2016-06-09 16:06:20', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(5, '005', 'Vignette', 0, 1, 1, 2, '2015-01-26 16:25:40', '2016-06-09 16:06:40', 0, 4, 'date vignette', '', '', '', '', 0, 1, NULL, NULL),
(6, '006', 'Chaine de distribution', 1, 0, 1, 2, '2015-01-26 16:26:22', '2017-01-24 11:37:02', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(7, '008', 'Disque plateau', 1, 0, 1, 2, '2015-01-26 16:27:04', '2017-01-24 11:12:32', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(8, '009', 'Plaquette de frein', 1, 0, 1, 2, '2015-01-26 16:28:07', '2016-06-09 16:09:35', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(9, '010', 'Disque de frein', 1, 0, 1, 2, '2015-01-26 16:28:23', '2017-01-24 11:33:51', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(11, '011', 'Incident', 0, 1, 0, 2, '2015-01-26 16:29:31', '2016-06-09 16:23:41', 0, 4, 'Date accident', 'Date déclaration', 'Date rembourssement', '', '', 0, 1, NULL, NULL),
(12, '012', 'Contravention', 0, 1, 1, 2, '2016-07-28 16:36:32', '2016-07-28 18:01:07', 4, 4, 'Date contravention', '', '', '', '', 0, 1, NULL, NULL),
(13, '013', 'Vol', 0, 1, 1, 2, '2015-01-26 17:09:40', '2016-06-09 16:10:44', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(14, '014', 'Panne', 0, 1, 1, 2, '2015-01-26 17:10:59', '2016-06-09 16:11:15', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(15, '015', 'Fuite d\'huile', 0, 1, 1, 2, '2015-01-27 12:12:16', '2016-06-09 16:11:24', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(16, '016', 'Consommation d\'eau', 0, 1, 1, 2, '2015-01-27 12:12:34', '2016-06-09 16:11:39', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(18, '017', 'Filtre à huile', 1, 0, 1, 2, '2015-01-27 12:13:21', '2016-06-09 16:11:54', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(19, '018', 'Bougies d\'allumage', 1, 0, 1, 2, '2015-01-27 12:14:11', '2017-01-24 11:38:03', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL),
(23, '019', 'Autre', 0, 0, 1, 2, '2015-03-10 11:49:30', '2016-06-09 16:12:20', 0, 4, '', '', '', '', '', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `event_type_categories`
--

CREATE TABLE `event_type_categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `event_type_categories`
--

INSERT INTO `event_type_categories` (`id`, `code`, `name`, `created`, `modified`) VALUES
(4, '', 'Mécanique', '2015-03-15 00:00:00', '2015-03-15 00:00:00'),
(5, '', 'Electronique', '2015-03-16 00:00:00', '2015-03-16 00:00:00'),
(6, '', 'Electrique', '2015-03-16 00:00:00', '2015-03-16 00:00:00'),
(7, '', 'Tôlerie', '2015-03-16 00:00:00', '2015-03-16 00:00:00'),
(8, '', 'Autre', '2015-03-30 00:00:00', '2015-03-30 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `event_type_category_event_type`
--

CREATE TABLE `event_type_category_event_type` (
  `id` int(11) NOT NULL,
  `event_type_id` smallint(5) UNSIGNED NOT NULL,
  `event_type_category_id` tinyint(3) UNSIGNED NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `event_type_category_event_type`
--

INSERT INTO `event_type_category_event_type` (`id`, `event_type_id`, `event_type_category_id`, `created`, `modified`) VALUES
(5, 3, 4, '2016-06-09 16:05:43', '2016-06-09 16:05:43'),
(6, 4, 4, '2016-06-09 16:06:20', '2016-06-09 16:06:20'),
(7, 5, 8, '2016-06-09 16:06:40', '2016-06-09 16:06:40'),
(10, 8, 4, '2016-06-09 16:09:35', '2016-06-09 16:09:35'),
(13, 13, 8, '2016-06-09 16:10:44', '2016-06-09 16:10:44'),
(14, 14, 4, '2016-06-09 16:11:15', '2016-06-09 16:11:15'),
(15, 15, 4, '2016-06-09 16:11:24', '2016-06-09 16:11:24'),
(16, 16, 4, '2016-06-09 16:11:39', '2016-06-09 16:11:39'),
(17, 18, 4, '2016-06-09 16:11:54', '2016-06-09 16:11:54'),
(19, 23, 8, '2016-06-09 16:12:20', '2016-06-09 16:12:20'),
(24, 11, 4, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(25, 11, 5, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(26, 11, 6, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(27, 11, 7, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(30, 12, 8, '2016-07-28 18:01:07', '2016-07-28 18:01:07'),
(31, 2, 8, '2016-09-25 14:37:48', '2016-09-25 14:37:48'),
(32, 7, 4, '2017-01-24 11:12:32', '2017-01-24 11:12:32'),
(33, 9, 4, '2017-01-24 11:33:51', '2017-01-24 11:33:51'),
(36, 6, 4, '2017-01-24 11:37:03', '2017-01-24 11:37:03'),
(37, 6, 5, '2017-01-24 11:37:03', '2017-01-24 11:37:03'),
(38, 19, 6, '2017-01-24 11:38:03', '2017-01-24 11:38:03'),
(43, 1, 4, '2018-02-28 15:50:29', '2018-02-28 15:50:29'),
(47, 27, 4, '2018-12-05 10:16:17', '2018-12-05 10:16:17');

-- --------------------------------------------------------

--
-- Structure de la table `extinguishers`
--

CREATE TABLE `extinguishers` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `extinguisher_number` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'Numéro d''extincteur',
  `validity_day_date` date NOT NULL COMMENT 'Date de fin de validité',
  `volume` smallint(5) UNSIGNED DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL,
  `location_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `final_supplier_initial_suppliers`
--

CREATE TABLE `final_supplier_initial_suppliers` (
  `id` mediumint(9) NOT NULL,
  `initial_supplier_id` smallint(5) UNSIGNED NOT NULL,
  `final_supplier_id` smallint(5) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `fuels`
--

CREATE TABLE `fuels` (
  `id` tinyint(4) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `price` decimal(4,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `fuels`
--

INSERT INTO `fuels` (`id`, `code`, `name`, `price`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '04', 'Gazoil', '23.06', '2015-01-26 10:55:00', '2018-08-15 16:28:02', 0, 1),
(2, '01', 'Super', '41.67', '2015-01-26 10:55:15', '2015-04-13 15:19:29', 0, 0),
(3, '05', 'GPL', '9.00', '2015-01-26 10:55:25', '2015-04-13 15:19:51', 0, 0),
(4, '03', 'Sans plomb', '41.28', '2015-04-13 15:16:12', '2015-04-13 15:19:41', 0, 0),
(5, '02', 'Normal', '38.64', '2015-04-13 15:18:05', '2015-04-13 15:19:36', 0, 0),
(6, '06', 'sans carburant', NULL, '2016-11-03 10:51:45', '2016-11-03 10:51:45', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `fuel_cards`
--

CREATE TABLE `fuel_cards` (
  `id` int(11) NOT NULL,
  `reference` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `amount` double NOT NULL COMMENT 'Montant',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `fuel_card_affectations`
--

CREATE TABLE `fuel_card_affectations` (
  `id` int(11) NOT NULL,
  `reference` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `fuel_card_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `fuel_card_cars`
--

CREATE TABLE `fuel_card_cars` (
  `id` int(11) NOT NULL,
  `car_id` mediumint(8) UNSIGNED NOT NULL,
  `fuel_card_affectation_id` int(11) NOT NULL COMMENT 'affectation de carte de carburant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `fuel_card_mouvements`
--

CREATE TABLE `fuel_card_mouvements` (
  `id` int(11) NOT NULL,
  `fuel_card_id` int(11) NOT NULL COMMENT 'identifiant carte carburant',
  `amount` double NOT NULL COMMENT 'Montant',
  `transact_type_id` smallint(2) NOT NULL,
  `date_mouvement` date DEFAULT NULL COMMENT 'date de mouvement',
  `sheet_ride_id` int(11) DEFAULT NULL COMMENT 'identifiant de feuille de route',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `fuel_logs`
--

CREATE TABLE `fuel_logs` (
  `id` int(11) NOT NULL,
  `num_bill` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `num_fuellog` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT 'Numéro de carnet',
  `nb_fuellog` smallint(3) DEFAULT NULL COMMENT 'Nombre de carnets',
  `price_coupon` int(11) DEFAULT NULL COMMENT 'Prix du bon',
  `first_number_coupon` varchar(250) COLLATE utf8_bin NOT NULL COMMENT 'Premier numéro du bon',
  `last_number_coupon` varchar(250) COLLATE utf8_bin NOT NULL COMMENT 'Dernier numéro du bon',
  `date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL DEFAULT '0',
  `date_open` datetime NOT NULL,
  `last_opener` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `interferings`
--

CREATE TABLE `interferings` (
  `id` mediumint(9) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin NOT NULL,
  `name` varchar(120) COLLATE utf8_bin NOT NULL,
  `adress` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `note` text COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL,
  `interfering_type_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'identifiant Type d\\''intervenant',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `interfering_types`
--

CREATE TABLE `interfering_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(120) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `interfering_types`
--

INSERT INTO `interfering_types` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '05', 'Assurance', '2018-09-04 00:00:00', '2018-09-04 00:00:00', 4, 4),
(2, '02', 'Contrôle technique', '2015-01-27 14:23:17', '2015-01-27 14:23:17', 0, 0),
(3, '03', 'Concessionnaire  ', '2015-01-27 14:25:08', '2015-01-27 14:27:37', 0, 0),
(4, '04', 'Mécanicien', '2015-01-27 14:26:14', '2015-01-27 14:27:47', 0, 0),
(7, '06', 'Electricien', '2016-06-09 16:22:40', '2016-06-09 16:22:40', 4, 0),
(8, '07', 'Tolier', '2016-06-09 16:22:51', '2016-06-09 16:22:51', 4, 0),
(9, '01', 'Aide mécanicien', '2017-11-26 13:53:08', '2017-11-26 13:53:27', 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `interfering_type_event_type`
--

CREATE TABLE `interfering_type_event_type` (
  `id` int(11) NOT NULL,
  `event_type_id` smallint(5) UNSIGNED NOT NULL,
  `interfering_type_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'type d''interférence',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `interfering_type_event_type`
--

INSERT INTO `interfering_type_event_type` (`id`, `event_type_id`, `interfering_type_id`, `created`, `modified`) VALUES
(50, 3, 2, '2016-06-09 16:05:43', '2016-06-09 16:05:43'),
(51, 4, 3, '2016-06-09 16:06:20', '2016-06-09 16:06:20'),
(52, 4, 4, '2016-06-09 16:06:20', '2016-06-09 16:06:20'),
(57, 11, 3, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(58, 11, 4, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(59, 11, 7, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(60, 11, 8, '2016-06-09 16:23:41', '2016-06-09 16:23:41'),
(64, 2, 1, '2016-09-25 14:37:48', '2016-09-25 14:37:48'),
(65, 7, 4, '2017-01-24 11:12:32', '2017-01-24 11:12:32'),
(66, 9, 3, '2017-01-24 11:33:51', '2017-01-24 11:33:51'),
(69, 6, 3, '2017-01-24 11:37:02', '2017-01-24 11:37:02'),
(70, 6, 4, '2017-01-24 11:37:02', '2017-01-24 11:37:02'),
(78, 1, 3, '2018-02-28 15:50:29', '2018-02-28 15:50:29'),
(79, 1, 4, '2018-02-28 15:50:29', '2018-02-28 15:50:29'),
(80, 1, 9, '2018-02-28 15:50:29', '2018-02-28 15:50:29'),
(85, 27, 2, '2018-12-05 10:16:17', '2018-12-05 10:16:17');

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE `languages` (
  `id` smallint(2) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `abr` varchar(10) COLLATE utf8_bin NOT NULL COMMENT 'abréviation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `languages`
--

INSERT INTO `languages` (`id`, `name`, `abr`) VALUES
(1, 'Français', 'fre'),
(2, 'Anglais', 'eng');

-- --------------------------------------------------------

--
-- Structure de la table `leasings`
--

CREATE TABLE `leasings` (
  `id` int(11) NOT NULL,
  `car_id` mediumint(8) UNSIGNED NOT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Fournisseur',
  `acquisition_type_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `num_contract` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `reception_date` date NOT NULL COMMENT 'Date de réception',
  `end_date` date DEFAULT NULL COMMENT 'Date de retour prévue',
  `end_real_date` date DEFAULT NULL COMMENT 'Date de retour réelle',
  `reception_km` int(6) NOT NULL COMMENT 'Compteur /Km',
  `additional_franchise_km` int(6) DEFAULT NULL COMMENT 'Franchise Km Supplémentaires',
  `contract_km` int(6) DEFAULT NULL,
  `cost_km` decimal(11,4) NOT NULL COMMENT 'coût par km ',
  `amont_month` decimal(11,4) NOT NULL COMMENT 'Paiement mensuel',
  `km_year` int(6) NOT NULL,
  `attachment` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `send_mail_date` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'date d\\''envoi mail',
  `send_mail` tinyint(1) NOT NULL DEFAULT '0',
  `alert_date` smallint(1) NOT NULL DEFAULT '0',
  `alert` smallint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `legal_form`
--

CREATE TABLE `legal_form` (
  `id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `legal_form`
--

INSERT INTO `legal_form` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Personne physique', '0000-00-00 00:00:00', '2014-09-08 14:48:00'),
(2, 'EURL', '0000-00-00 00:00:00', NULL),
(3, 'SNC', '0000-00-00 00:00:00', NULL),
(4, 'SCS', '0000-00-00 00:00:00', NULL),
(5, 'SARL', '0000-00-00 00:00:00', NULL),
(6, 'SPA', '0000-00-00 00:00:00', NULL),
(7, 'SCA', '0000-00-00 00:00:00', NULL),
(9, 'Ets.', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE `locations` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status_synchronisation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `lots`
--

CREATE TABLE `lots` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `number` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `quantity` double NOT NULL,
  `purchase_price` decimal(11,2) DEFAULT NULL,
  `sale_price` decimal(11,2) DEFAULT NULL,
  `tva_id` tinyint(2) NOT NULL,
  `label` varchar(150) COLLATE utf8_bin NOT NULL,
  `lot_type_id` smallint(5) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `product_unit_id` smallint(5) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `lots`
--

INSERT INTO `lots` (`id`, `code`, `number`, `production_date`, `expiration_date`, `quantity`, `purchase_price`, `sale_price`, `tva_id`, `label`, `lot_type_id`, `product_id`, `blocked`, `product_unit_id`, `created`, `modified`, `user_id`, `modified_id`) VALUES
(1, '__', '__', NULL, NULL, 0, NULL, NULL, 1, '__', NULL, 1, 0, NULL, '0000-00-00 00:00:00', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `lot_types`
--

CREATE TABLE `lot_types` (
  `id` smallint(5) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(120) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `marchandises`
--

CREATE TABLE `marchandises` (
  `id` int(11) NOT NULL,
  `wording` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `marchandise_type_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `marchandise_unit_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'identifiant client ',
  `quantity_stock` int(6) DEFAULT NULL COMMENT 'Quantité stock',
  `quantity_min` int(6) DEFAULT NULL COMMENT 'Quantité minimum',
  `quantity_max` int(6) DEFAULT NULL,
  `weight` decimal(8,2) NOT NULL COMMENT 'Poids (Kg)',
  `weight_palette` int(6) NOT NULL COMMENT 'Poids/palette (Kg)',
  `weight_truck` int(6) NOT NULL COMMENT 'poids camion',
  `description` text COLLATE utf8_bin,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `marchandise_types`
--

CREATE TABLE `marchandise_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` date NOT NULL COMMENT 'créé',
  `modified` date NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `marchandise_types`
--

INSERT INTO `marchandise_types` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'Bois', '2016-12-16', '2016-12-16', 4, 4),
(2, '', 'Voyage', '2016-12-16', '2016-12-16', 4, 0),
(3, '', 'Conteneur', '2016-12-16', '2016-12-16', 4, 0),
(4, '', 'Boisson Gazeuse ', '2017-02-14', '2017-08-09', 4, 4),
(5, '', 'Eau Minérale ', '2017-02-14', '2017-08-09', 4, 4),
(6, '', 'Jus Ifruit', '2017-02-14', '2017-08-09', 4, 4),
(7, '', 'PATES', '2017-03-16', '2017-08-09', 4, 4),
(8, '', 'COUCHE BEBE', '2017-04-19', '2017-04-19', 4, 0),
(9, '', 'ELECTROMENAGER', '2017-05-10', '2017-05-10', 4, 0),
(10, '', 'Produit', '2018-08-14', '2018-08-14', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `marchandise_units`
--

CREATE TABLE `marchandise_units` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` date NOT NULL COMMENT 'créé',
  `modified` date NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `marchandise_units`
--

INSERT INTO `marchandise_units` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'Palettes ', '2017-02-14', '2017-02-14', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `marks`
--

CREATE TABLE `marks` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `logo` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `marks`
--

INSERT INTO `marks` (`id`, `code`, `name`, `logo`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(5, '', 'ALFA ROMEO', 'alfa-romeo-3d-logo-primary.jpg', '2015-02-01 00:00:00', '2015-04-01 10:20:21', 0, 0),
(8, '', 'ASIA', 'Asia_Motors_Logo.png', '2015-02-01 00:00:00', '2015-04-01 10:22:51', 0, 0),
(9, '', 'ASTON MARTIN', 'téléchargement (15).jpg', '2015-02-01 00:00:00', '2015-04-01 10:56:42', 0, 0),
(10, '', 'AUDI', 'Audi-Logo-old.png', '2015-02-01 00:00:00', '2015-04-01 10:25:12', 0, 0),
(11, '', 'AUSTIN', 'austin_logo.gif', '2015-02-01 00:00:00', '2015-04-01 10:57:18', 0, 0),
(13, '', 'AUTOBIANCHI', 'autobianchi-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:58:25', 0, 0),
(14, '', 'BENTLEY', 'téléchargement (16).jpg', '2015-02-01 00:00:00', '2015-04-01 10:58:44', 0, 0),
(16, '', 'BMW', 'bmw_logo_2.jpg', '2015-02-01 00:00:00', '2015-04-01 10:25:53', 0, 0),
(18, '', 'BRILLIANCE', 'brilliance-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:56:25', 0, 0),
(19, '', 'BUGATTI', 'Bugatti_logo.gif', '2015-02-01 00:00:00', '2015-04-01 10:59:10', 0, 0),
(21, '', 'BYD', '10050.png', '2015-02-01 00:00:00', '2015-04-01 10:27:00', 0, 0),
(22, '', 'CADILLAC', 'téléchargement (17).jpg', '2015-02-01 00:00:00', '2015-04-01 10:59:29', 0, 0),
(25, '', 'CHEVROLET', '3234_256x256.png', '2015-02-01 00:00:00', '2015-04-01 10:28:19', 0, 0),
(27, '', 'CHRYSLER', 'CHRYSLER-VECTORLOGO-DOT-BIZ-128x128.png', '2015-02-01 00:00:00', '2015-04-01 10:55:49', 0, 0),
(28, '', 'CITROEN', '5370-256x256x8.png', '2015-02-01 00:00:00', '2015-04-01 10:28:53', 0, 0),
(32, '', 'DACIA', 'dacia-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:29:32', 0, 0),
(33, '', 'DAEWOO', 'téléchargement.jpg', '2015-02-01 00:00:00', '2015-04-01 10:29:57', 0, 0),
(34, '', 'DAIHATSU', 'daihatsu_logo.gif', '2015-02-01 00:00:00', '2015-04-01 10:30:34', 0, 0),
(35, '', 'DAIMLER ', 'daimler-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:30:58', 0, 0),
(39, '', 'DODGE', 'téléchargement (18).jpg', '2015-02-01 00:00:00', '2015-04-01 11:00:40', 0, 0),
(42, '', 'FERRARI', 'thumb_ferrari-logo.jpg', '2015-02-01 00:00:00', '2015-04-01 10:31:27', 0, 0),
(43, '', 'FIAT', 'Fiat-logo.jpg', '2015-02-01 00:00:00', '2015-04-01 10:31:54', 0, 0),
(44, '', 'FORD', 'thumb_ford-logo.jpg', '2015-02-01 00:00:00', '2015-04-01 10:32:30', 0, 0),
(51, '', 'GMC', 'gmc-emblem.png', '2015-02-01 00:00:00', '2015-04-01 10:35:33', 0, 0),
(52, NULL, 'GME', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(53, '', 'HONDA', 'téléchargement (1).jpg', '2015-02-01 00:00:00', '2015-04-01 10:36:08', 0, 0),
(55, '', 'HUMMER', 'hummer-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:36:58', 0, 0),
(56, '', 'HYUNDAI', 'thumb.png', '2015-02-01 00:00:00', '2015-04-01 10:37:25', 0, 0),
(57, '', 'INFINITI', 'téléchargement (19).jpg', '2015-02-01 00:00:00', '2015-04-01 11:01:30', 0, 0),
(59, '', 'ISUZU', 'isuzu-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:38:08', 0, 0),
(61, '', 'IVECO', 'iveco-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:38:30', 0, 0),
(62, '', 'JAGUAR', 'jaguar_logo.jpg', '2015-02-01 00:00:00', '2015-04-01 10:39:02', 0, 0),
(65, '', 'JEEP', 'jeep-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:39:28', 0, 0),
(67, '', 'KIA', 'téléchargement (2).jpg', '2015-02-01 00:00:00', '2015-04-01 10:39:58', 0, 0),
(69, '', 'LADA', 'lada-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:40:19', 0, 0),
(70, '', 'LAMBORGHINI', 'téléchargement (3).jpg', '2015-02-01 00:00:00', '2015-04-01 10:41:03', 0, 0),
(71, '', 'LANCIA', 'téléchargement (4).jpg', '2015-02-01 00:00:00', '2015-04-01 10:41:38', 0, 0),
(72, '', 'LAND ROVER', 'land-rover-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:50:48', 0, 0),
(73, NULL, 'LANDWIND', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(75, '', 'LEXUS', '2174-256x256x8.png', '2015-02-01 00:00:00', '2015-04-01 10:42:44', 0, 0),
(77, NULL, 'LINCOLN', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(78, NULL, 'LOTUS', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(80, '', 'MAHINDRA', 'téléchargement (6).jpg', '2015-02-01 00:00:00', '2015-04-01 10:43:13', 0, 0),
(82, NULL, 'MASERATI', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(85, '', 'MAZDA', 'UserPhoto.jpg', '2015-02-01 00:00:00', '2015-04-01 10:43:53', 0, 0),
(86, '', 'MERCEDES', 'téléchargement (7).jpg', '2015-02-01 00:00:00', '2015-04-01 10:44:22', 0, 0),
(87, '', 'MG', '64_logo.png', '2015-02-01 00:00:00', '2015-04-01 10:44:51', 0, 0),
(88, '', 'MINI', 'mini-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:45:14', 0, 0),
(89, '', 'MITSUBISHI', 'téléchargement (8).jpg', '2015-02-01 00:00:00', '2015-04-01 10:45:59', 0, 0),
(91, NULL, 'MORRIS', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(92, '', 'NISSAN', 'téléchargement (9).jpg', '2015-02-01 00:00:00', '2015-04-01 10:46:26', 0, 0),
(93, '', 'OPEL', 'téléchargement (10).jpg', '2015-02-01 00:00:00', '2015-04-01 10:47:09', 0, 0),
(94, '', 'PEUGEOT', 'thumb_logo-peugeot.jpg', '2015-02-01 00:00:00', '2015-04-01 10:47:54', 0, 0),
(99, '', 'PORSCHE', 'téléchargement (11).jpg', '2015-02-01 00:00:00', '2015-04-01 10:48:22', 0, 0),
(100, '', 'RENAULT', 'thumb_logo-renault.jpg', '2015-02-01 00:00:00', '2015-04-01 10:48:57', 0, 0),
(101, NULL, 'ROCHET - SCHNEIDER ', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(102, '', 'ROLLS ROYCE', 'rolls-royce-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:49:44', 0, 0),
(103, '', 'ROVER', 'téléchargement (12).jpg', '2015-02-01 00:00:00', '2015-04-01 10:50:40', 0, 0),
(104, '', 'SAAB', 'téléchargement (13).jpg', '2015-02-01 00:00:00', '2015-04-01 10:51:23', 0, 0),
(106, '', 'SEAT', 'Seat_logo.png', '2015-02-01 00:00:00', '2015-04-01 10:51:45', 0, 0),
(107, '', 'SKODA', '86_logo.png', '2015-02-01 00:00:00', '2015-04-01 10:52:06', 0, 0),
(108, NULL, 'SMART', '', '2015-02-01 00:00:00', '2015-02-01 00:00:00', 0, 0),
(109, '', 'SSANGYONG', 'téléchargement (14).jpg', '2015-02-01 00:00:00', '2015-04-01 10:52:24', 0, 0),
(110, '', 'SUBARU', 'thumb_logo-subaru.jpg', '2015-02-01 00:00:00', '2015-04-01 10:52:55', 0, 0),
(111, '', 'SUZUKI', 'suzuki-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:53:19', 0, 0),
(113, '', 'TOYOTA', 'toyota-logo.jpg', '2015-02-01 00:00:00', '2015-04-01 10:53:46', 0, 0),
(117, '', 'VOLKSWAGEN', 'thumb_logo-vw.jpg', '2015-02-01 00:00:00', '2015-04-01 10:54:47', 0, 0),
(118, '', 'VOLVO', 'Volvo-logo-2014.png', '2015-02-01 00:00:00', '2015-04-01 10:55:21', 0, 0),
(120, '', 'MARUTI', 'maruti-logo.png', '2015-02-01 00:00:00', '2015-04-01 10:43:35', 0, 0),
(121, '', 'Krone', '', '2017-02-14 08:42:43', '2017-02-14 08:42:43', 0, 0),
(122, '', 'Krone', '', '2017-02-14 09:02:20', '2017-02-14 09:02:20', 0, 0),
(123, '', 'HINO', 'LOGO HINO.jpg', '2017-08-07 09:30:24', '2017-08-07 15:47:31', 0, 4),
(124, '', 'CAMC', 'LOGO CAMC.jpg', '2017-08-07 10:54:51', '2017-08-07 15:10:03', 0, 4),
(126, '', 'KRONE', '', '2017-10-16 13:09:09', '2017-10-16 13:09:09', 0, 0),
(127, '', 'TIRSAM', '', '2017-10-16 13:09:29', '2017-10-16 13:09:29', 0, 0),
(128, '', 'QQ', '', '2018-08-13 10:43:24', '2018-08-13 10:43:24', 0, 0),
(129, '', 'sans marque', '', '2016-11-03 10:49:21', '2016-11-03 10:49:21', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `medical_visits`
--

CREATE TABLE `medical_visits` (
  `id` int(11) NOT NULL,
  `visit_number` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `internal_external` tinyint(2) NOT NULL,
  `consulting_doctor` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `observation` text COLLATE utf8_bin,
  `attachment` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `mission_costs`
--

CREATE TABLE `mission_costs` (
  `id` int(11) NOT NULL,
  `detail_ride_id` int(11) NOT NULL COMMENT 'identifiant de trajet',
  `ride_category_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `cost_truck_full` decimal(10,2) DEFAULT NULL COMMENT 'coût de camion complet',
  `cost_truck_empty` decimal(10,2) DEFAULT NULL COMMENT 'coût de camion vide',
  `cost_day` decimal(11,2) DEFAULT NULL COMMENT 'coût par jour',
  `cost_destination` decimal(11,2) DEFAULT NULL COMMENT 'coût par destination  '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `mission_cost_parameters`
--

CREATE TABLE `mission_cost_parameters` (
  `id` tinyint(3) NOT NULL,
  `param_mission_cost` smallint(2) NOT NULL,
  `car_type_id` tinyint(3) NOT NULL,
  `mission_cost_day` float DEFAULT NULL,
  `mission_cost_truck_full` float DEFAULT NULL,
  `mission_cost_truck_empty` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `code`, `name`, `created`, `modified`) VALUES
(1, 'parc', 'Parc', '2016-09-25 00:00:00', '2016-09-25 00:00:00'),
(2, 'rh', 'RH', '2016-09-25 00:00:00', '2016-09-25 00:00:00'),
(3, 'stock', 'Stock', '2017-07-18 15:42:50', '2017-07-18 15:42:50'),
(4, 'evenement', 'Evènement', '2017-07-18 15:53:20', '2017-07-18 15:53:20'),
(5, 'planification', 'Planification', '2017-11-26 10:56:57', '2017-11-26 10:56:57'),
(6, 'ventes', 'Ventes', '2017-12-24 11:41:18', '2017-12-24 11:41:18'),
(7, 'tresorerie', 'Trésorerie', '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(8, 'affretement', 'Affrètement', '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(9, 'statistique', 'Statistique', '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(10, 'tableau_bord', 'Tableau de bord', '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(11, 'alertes', 'Alertes', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'achats', 'Achats', '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(13, 'approvisionnements', 'Approvisionnement', '2019-11-13 00:00:00', '2019-11-13 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `monthlykms`
--

CREATE TABLE `monthlykms` (
  `id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `km_1` int(6) DEFAULT NULL,
  `km_2` int(11) DEFAULT NULL,
  `km_3` int(11) DEFAULT NULL,
  `km_4` int(11) DEFAULT NULL,
  `km_5` int(11) DEFAULT NULL,
  `km_6` int(11) DEFAULT NULL,
  `km_7` int(11) DEFAULT NULL,
  `km_8` int(11) DEFAULT NULL,
  `km_9` int(11) DEFAULT NULL,
  `km_10` int(11) DEFAULT NULL,
  `km_11` int(11) DEFAULT NULL,
  `km_12` int(11) DEFAULT NULL,
  `car_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `movings`
--

CREATE TABLE `movings` (
  `id` int(11) NOT NULL,
  `reference` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `car_id` mediumint(8) UNSIGNED NOT NULL,
  `extinguisher_id` smallint(5) UNSIGNED NOT NULL COMMENT ' identifiant d''extincteur',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` smallint(3) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Afrique du Sud', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(2, 'Albanie', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(3, 'Algérie', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(4, 'Allemagne', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(5, 'Andorre', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(6, 'Angleterre', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(7, 'Angola', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(8, 'Arabie saoudite', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(9, 'Argentine', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(10, 'Australie', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(11, 'Autriche', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(12, 'Bahrein', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(13, 'Belgique', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(14, 'Bénin', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(15, 'Bosnie', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(16, 'Brésil', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(17, 'Burkina Faso', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(18, 'Cameroun', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(19, 'Canada', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(20, 'Cap  Vert', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(21, 'Chili', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(22, 'Chine', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(23, 'Congo', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(24, 'Côte d\'ivoire', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(25, 'Chypre', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(26, 'Danemark', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(27, 'Ecosse', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(28, 'Egypte', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(29, 'Emirats arabes unis', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(30, 'Espagne', '2015-03-22 14:44:21', '2015-03-22 14:44:21'),
(31, 'Maroc', '2020-01-02 14:59:09', '2020-01-02 14:59:09');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `transport_bill_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `transmitter_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `action_id` smallint(5) NOT NULL,
  `read_notif` tinyint(1) NOT NULL DEFAULT '0',
  `enter_index` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `observations`
--

CREATE TABLE `observations` (
  `id` int(11) NOT NULL,
  `transport_bill_detail_ride_id` int(11) NOT NULL,
  `customer_observation` varchar(225) COLLATE utf8_bin DEFAULT NULL,
  `cancel_cause_id` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `val` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'valeur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `options`
--

INSERT INTO `options` (`id`, `name`, `val`) VALUES
(1, 'type', 'parc'),
(2, 'code', 'com'),
(3, 'max_cars', '100'),
(4, 'version', 'local'),
(5, 'use_i2b', '1'),
(6, 'transport', '1'),
(7, 'gestion_commercial', '1'),
(8, 'tresorerie', '1'),
(9, 'stock', '1'),
(10, 'sous_traitance', '1'),
(11, 'temps_minimal_ouverture', '15');

-- --------------------------------------------------------

--
-- Structure de la table `parameters`
--

CREATE TABLE `parameters` (
  `id` int(11) NOT NULL,
  `code` smallint(2) DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `val` int(11) DEFAULT NULL,
  `type_id` smallint(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `auto_car` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Automatique',
  `sizes_car` int(6) NOT NULL COMMENT 'Taille',
  `auto_conductor` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'référence de conducteur automatique  ',
  `sizes_conductor` int(6) NOT NULL COMMENT 'Taille référence de conducteur automatique  ',
  `depot` tinyint(1) NOT NULL DEFAULT '0',
  `name_car` smallint(2) NOT NULL DEFAULT '1' COMMENT 'nom de véhicule',
  `param_coupon` smallint(2) NOT NULL DEFAULT '1' COMMENT 'Utilisation du code à barre',
  `affectation_mode` smallint(2) NOT NULL DEFAULT '2' COMMENT 'Mode d\\''affectation',
  `fuellog_coupon` smallint(2) NOT NULL DEFAULT '2' COMMENT 'Utilisation des carnets de bons',
  `tank_spacies` smallint(2) NOT NULL DEFAULT '1' COMMENT 'Utilisation de la citerne par espèce',
  `balance_car` smallint(2) NOT NULL DEFAULT '1' COMMENT 'Utilisation de solde véhicule',
  `consumption_coupon` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Consommation par bons',
  `consumption_spacies` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Consommation par espèces',
  `consumption_tank` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Consommation par citernes',
  `consumption_card` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Consommation par cartes',
  `priority` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'Utilisation de la priorité',
  `quantity_liter` int(11) NOT NULL,
  `company` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Société',
  `email3` tinyint(1) NOT NULL DEFAULT '0',
  `job` tinyint(1) NOT NULL DEFAULT '0',
  `monthly_payroll` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Masse salariale mensuelle',
  `cost_center` tinyint(1) NOT NULL DEFAULT '0',
  `note` tinyint(1) NOT NULL DEFAULT '0',
  `declaration_date` tinyint(1) NOT NULL DEFAULT '0',
  `affiliate` tinyint(1) NOT NULL DEFAULT '0',
  `ccp` tinyint(1) NOT NULL DEFAULT '0',
  `bank_account` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'compte bancaire',
  `identity_card` tinyint(1) NOT NULL DEFAULT '0',
  `passport` tinyint(1) NOT NULL DEFAULT '0',
  `totaux_dashbord` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'totaux de tableau bord ',
  `synchronization_fr_bc` smallint(2) NOT NULL DEFAULT '2',
  `nb_trucks_modifiable` smallint(2) NOT NULL DEFAULT '1',
  `default_nb_trucks` mediumint(4) NOT NULL,
  `type_ride` tinyint(2) NOT NULL DEFAULT '1',
  `type_ride_used_first` tinyint(2) NOT NULL DEFAULT '1',
  `param_price_night` smallint(2) NOT NULL DEFAULT '1',
  `type_pricing` smallint(2) NOT NULL DEFAULT '1',
  `param_price` smallint(2) NOT NULL DEFAULT '1',
  `entete_pdf` smallint(2) NOT NULL DEFAULT '1' COMMENT 'impression des fichiers pdf',
  `signature_mission_order` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'Signature de l''ordre de missio',
  `observation1` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `observation2` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `choice_reporting` smallint(2) NOT NULL DEFAULT '1' COMMENT 'Choix du reporting',
  `reports_path_rpt` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `reports_path_pdf` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `reports_path_jasper` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `username_jasper` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `password_jasper` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `tomcat_path` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `save_bdd_path` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `reference_required` smallint(2) NOT NULL DEFAULT '1',
  `reference_dd_auto` smallint(2) NOT NULL DEFAULT '1' COMMENT 'référence Demande de devis',
  `reference_fp_auto` smallint(2) NOT NULL DEFAULT '1' COMMENT 'référence devis',
  `reference_bc_auto` smallint(2) NOT NULL DEFAULT '1' COMMENT 'référence Commande client',
  `reference_fr_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_mi_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_pf_auto` smallint(2) NOT NULL DEFAULT '1' COMMENT 'référence préfecture',
  `reference_fa_auto` smallint(2) NOT NULL DEFAULT '1' COMMENT 'référence facture',
  `reference_av_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_sizes` int(6) NOT NULL COMMENT 'Taille de référence',
  `date_suffixe` smallint(2) DEFAULT NULL COMMENT 'Utiliser la date en (suffixe / préfixe',
  `abbreviation_location` smallint(2) NOT NULL DEFAULT '1',
  `demande_devis` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `devis` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `commande` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `feuille_route` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `prefacture` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `facture` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `avoir_vente` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `next_reference_demande_devis` int(11) DEFAULT '1',
  `next_reference_devis` int(11) DEFAULT '1',
  `next_reference_commande` int(11) DEFAULT '1',
  `next_reference_feuille_route` int(11) DEFAULT '1',
  `next_reference_prefacture` int(11) DEFAULT '1',
  `next_reference_facture` int(11) DEFAULT '1',
  `next_reference_avoir_vente` int(11) NOT NULL DEFAULT '1',
  `reference_auto_affectation` smallint(2) NOT NULL DEFAULT '1',
  `reference_sizes_affectation` int(6) NOT NULL,
  `date_suffixe_affectation` smallint(2) DEFAULT NULL,
  `reference_affectation` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `reference_auto_event` smallint(2) NOT NULL DEFAULT '1',
  `reference_sizes_event` int(6) NOT NULL,
  `date_suffixe_event` smallint(2) DEFAULT NULL,
  `reference_event` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `param_mission_cost` smallint(2) NOT NULL DEFAULT '3',
  `use_ride_category` smallint(1) NOT NULL DEFAULT '2',
  `display_mission_cost` smallint(2) NOT NULL DEFAULT '1' COMMENT 'Afficher frais de mission dans feuille de route',
  `mission_cost_truck_full` float DEFAULT NULL,
  `mission_cost_truck_empty` float DEFAULT NULL COMMENT 'coût de mission camion vide',
  `mission_cost_day` float DEFAULT NULL COMMENT 'Frais de mission par jour',
  `separator_amount` smallint(1) NOT NULL DEFAULT '1',
  `select_coupon` smallint(1) NOT NULL DEFAULT '1',
  `departure_tank_state` smallint(1) NOT NULL DEFAULT '2',
  `arrival_tank_state` smallint(1) NOT NULL DEFAULT '2',
  `use_priority` smallint(1) NOT NULL DEFAULT '2',
  `take_account_departure_tank` smallint(1) NOT NULL DEFAULT '2',
  `sheet_ride_name` varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 'Feuille de route' COMMENT 'Nom de feuille de route',
  `calcul_by_maps` smallint(2) NOT NULL DEFAULT '1',
  `car_customer_out_park` smallint(2) NOT NULL DEFAULT '2',
  `car_subcontracting` smallint(2) NOT NULL DEFAULT '1',
  `marchandise_required` smallint(2) NOT NULL DEFAULT '2',
  `loading_time` float DEFAULT NULL COMMENT 'Temps de chargement (Heure)',
  `unloading_time` float DEFAULT NULL COMMENT 'Temps de déchargement (Heure)',
  `maximum_driving_time` float DEFAULT NULL COMMENT 'Temps maximum de conduite (Heure)',
  `break_time` float DEFAULT NULL COMMENT 'Temps de repos (Heure)',
  `additional_time_allowed` float DEFAULT NULL COMMENT 'Temps supplémentaire permis (Heure)',
  `reference_auto_client_initial` smallint(2) DEFAULT NULL,
  `reference_sizes_client_initial` int(6) DEFAULT NULL,
  `reference_client_initial` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `next_reference_client_initial` int(11) DEFAULT '1',
  `reference_auto_client_final` smallint(2) DEFAULT NULL,
  `reference_sizes_client_final` int(6) DEFAULT NULL,
  `reference_client_final` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `next_reference_client_final` int(11) DEFAULT '1',
  `reference_auto_supplier` smallint(2) DEFAULT NULL,
  `reference_sizes_supplier` int(6) DEFAULT NULL,
  `reference_supplier` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `next_reference_supplier` int(11) DEFAULT '1',
  `reference_so_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_re_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_rs_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_pi_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_cn_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_do_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_rc_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_eo_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_xo_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_ro_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_ri_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_pr_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_ar_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_bill_sizes` int(6) NOT NULL,
  `date_bill_suffixe` smallint(2) DEFAULT NULL,
  `abbreviation_bill_location` smallint(2) NOT NULL DEFAULT '1',
  `supplier_order` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `receipt` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `return_supplier` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `purchase_invoice` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `credit_note` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `delivery_order` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `return_customer` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `entry_order` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `exit_order` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `renvoi_order` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `reintegration_order` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `product_request` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `purchase_request` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `next_reference_supplier_order` int(11) DEFAULT '1',
  `next_reference_receipt` int(11) DEFAULT '1',
  `next_reference_return_supplier` int(11) DEFAULT '1',
  `next_reference_purchase_invoice` int(11) DEFAULT '1',
  `next_reference_credit_note` int(11) DEFAULT '1',
  `next_reference_delivery_order` int(11) DEFAULT '1',
  `next_reference_return_customer` int(11) DEFAULT '1',
  `next_reference_entry_order` int(11) DEFAULT '1',
  `next_reference_exit_order` int(11) DEFAULT '1',
  `next_reference_renvoi_order` int(11) DEFAULT '1',
  `next_reference_reintegration_order` int(11) DEFAULT '1',
  `next_reference_product_request` int(11) DEFAULT '1',
  `next_reference_purchase_request` int(11) DEFAULT '1',
  `use_purchase_bill` smallint(2) NOT NULL DEFAULT '2',
  `reference_product_auto` smallint(2) NOT NULL DEFAULT '1',
  `reference_product_sizes` int(6) NOT NULL,
  `next_reference_product` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `parameters`
--

INSERT INTO `parameters` (`id`, `code`, `name`, `val`, `type_id`, `created`, `modified`, `auto_car`, `sizes_car`, `auto_conductor`, `sizes_conductor`, `depot`, `name_car`, `param_coupon`, `affectation_mode`, `fuellog_coupon`, `tank_spacies`, `balance_car`, `consumption_coupon`, `consumption_spacies`, `consumption_tank`, `consumption_card`, `priority`, `quantity_liter`, `company`, `email3`, `job`, `monthly_payroll`, `cost_center`, `note`, `declaration_date`, `affiliate`, `ccp`, `bank_account`, `identity_card`, `passport`, `totaux_dashbord`, `synchronization_fr_bc`, `nb_trucks_modifiable`, `default_nb_trucks`, `type_ride`, `type_ride_used_first`, `param_price_night`, `type_pricing`, `param_price`, `entete_pdf`, `signature_mission_order`, `observation1`, `observation2`, `choice_reporting`, `reports_path_rpt`, `reports_path_pdf`, `reports_path_jasper`, `username_jasper`, `password_jasper`, `tomcat_path`, `save_bdd_path`, `reference_required`, `reference_dd_auto`, `reference_fp_auto`, `reference_bc_auto`, `reference_fr_auto`, `reference_mi_auto`, `reference_pf_auto`, `reference_fa_auto`, `reference_av_auto`, `reference_sizes`, `date_suffixe`, `abbreviation_location`, `demande_devis`, `devis`, `commande`, `feuille_route`, `prefacture`, `facture`, `avoir_vente`, `next_reference_demande_devis`, `next_reference_devis`, `next_reference_commande`, `next_reference_feuille_route`, `next_reference_prefacture`, `next_reference_facture`, `next_reference_avoir_vente`, `reference_auto_affectation`, `reference_sizes_affectation`, `date_suffixe_affectation`, `reference_affectation`, `reference_auto_event`, `reference_sizes_event`, `date_suffixe_event`, `reference_event`, `param_mission_cost`, `use_ride_category`, `display_mission_cost`, `mission_cost_truck_full`, `mission_cost_truck_empty`, `mission_cost_day`, `separator_amount`, `select_coupon`, `departure_tank_state`, `arrival_tank_state`, `use_priority`, `take_account_departure_tank`, `sheet_ride_name`, `calcul_by_maps`, `car_customer_out_park`, `car_subcontracting`, `marchandise_required`, `loading_time`, `unloading_time`, `maximum_driving_time`, `break_time`, `additional_time_allowed`, `reference_auto_client_initial`, `reference_sizes_client_initial`, `reference_client_initial`, `next_reference_client_initial`, `reference_auto_client_final`, `reference_sizes_client_final`, `reference_client_final`, `next_reference_client_final`, `reference_auto_supplier`, `reference_sizes_supplier`, `reference_supplier`, `next_reference_supplier`, `reference_so_auto`, `reference_re_auto`, `reference_rs_auto`, `reference_pi_auto`, `reference_cn_auto`, `reference_do_auto`, `reference_rc_auto`, `reference_eo_auto`, `reference_xo_auto`, `reference_ro_auto`, `reference_ri_auto`, `reference_pr_auto`, `reference_ar_auto`, `reference_bill_sizes`, `date_bill_suffixe`, `abbreviation_bill_location`, `supplier_order`, `receipt`, `return_supplier`, `purchase_invoice`, `credit_note`, `delivery_order`, `return_customer`, `entry_order`, `exit_order`, `renvoi_order`, `reintegration_order`, `product_request`, `purchase_request`, `next_reference_supplier_order`, `next_reference_receipt`, `next_reference_return_supplier`, `next_reference_purchase_invoice`, `next_reference_credit_note`, `next_reference_delivery_order`, `next_reference_return_customer`, `next_reference_entry_order`, `next_reference_exit_order`, `next_reference_renvoi_order`, `next_reference_reintegration_order`, `next_reference_product_request`, `next_reference_purchase_request`, `use_purchase_bill`, `reference_product_auto`, `reference_product_sizes`, `next_reference_product`) VALUES
(1, 1, 'Assurance', 30, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(2, 2, 'Contrôle technique', 30, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(3, 3, 'Vignette', 15, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(4, 4, 'Vidange', 1000, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(5, 5, 'Expiration permis de conduire', 15, 1, '2016-01-20 00:00:00', '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(6, 6, 'Avec date', 15, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(7, 7, 'Avec km', 1000, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(8, 8, 'Langue', 1, 2, '2015-03-23 00:00:00', '2015-03-23 00:00:00', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(9, 9, 'currency', 1, 2, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(10, 10, 'coupon_price', 850, 3, '2015-04-13 00:00:00', '2015-04-13 00:00:00', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(11, 11, 'coupon_capacity', 0, 3, '2015-04-13 00:00:00', '2015-04-13 00:00:00', 1, 5, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(12, 12, 'codes', NULL, 0, '2016-01-06 00:00:00', '2019-12-31 15:10:57', 0, 4, 0, 3, 0, 1, 1, 2, 2, 1, 1, 1, 1, 1, 1, '3,2,4,1', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 3, 2, 2, 1, 2, 1, '', 'Observation chauffeur ', '', 1, NULL, '', 'http://localhost/transport/utranx/parameters', '', '', '', 'C:/Users/kahina/Documents/bejaia_logistique', 0, 2, 2, 2, 2, 2, 2, 2, 1, 5, 1, 1, 'DD', 'FP', 'BC', 'FR', 'PF', 'FA', NULL, 2, 8, 15, 26, 10, 20, 1, 2, 4, 1, '', 2, 4, 1, '', 1, 1, 2, 4, 1.5, 1000, 1, 2, 1, 3, 1, 2, 'Feuilles de route', 1, 1, 2, 2, 2, 4, 12, 8, 0, 2, 4, 'ci', 32, 2, 4, 'cl', 1, 2, 4, 'f', 6, 2, 2, 2, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 5, 1, 2, 'CF', 'BR', 'RF', 'FA', 'AA', 'BL', 'RC', 'BE', 'BS', 'BR', 'BI', NULL, NULL, 1, 3, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5, 3),
(13, 13, 'Limite mensuelle de consommation ', NULL, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(14, 14, 'depots', NULL, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(15, 15, 'Nombre minimum de bons', NULL, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(16, 16, 'liter_tank_1', NULL, 0, NULL, '2016-10-11 14:17:52', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(17, 17, 'liter_tank_2', NULL, 0, '2016-11-08 00:00:00', '2016-11-09 08:55:17', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(18, 18, 'liter_tank_3', NULL, 0, '2016-11-08 00:00:00', '2016-11-09 09:04:14', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(19, 19, 'year_contrat', 5, 0, NULL, '2016-11-10 11:31:27', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(20, 20, 'input_hidden', NULL, 0, NULL, '2016-11-13 09:32:12', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(21, 21, 'Km restant au contrat', 1000000, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(22, 22, 'Contrat véhicule', 30, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 0, 2, 2, 1, 1, 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(23, 23, 'difference_allowed', 1, 3, '2017-01-26 00:00:00', '2017-01-29 08:59:37', 0, 0, 0, 0, 0, 1, 1, 2, 2, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(24, 24, 'Vidange engins', 72, 1, '2017-02-20 12:00:00', '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 1, 2, 2, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(25, 25, 'spacie_tank', NULL, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 2, 2, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(26, 26, 'Amortissement ', 50, 1, NULL, '2018-06-04 15:02:41', 0, 0, 0, 0, 0, 1, 1, 2, 2, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(27, 30, 'Echéance', 15, 1, '2018-12-06 00:00:00', NULL, 0, 0, 0, 0, 0, 1, 1, 2, 2, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuilles de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, 0, 1),
(28, 31, 'country', 31, 2, NULL, '2020-01-02 14:24:02', 0, 0, 0, 0, 0, 1, 1, 2, 2, 1, 1, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 0, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, NULL, 1, 0, NULL, NULL, 3, 2, 1, NULL, NULL, NULL, 1, 1, 2, 2, 2, 2, 'Feuille de route', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `parcs`
--

CREATE TABLE `parcs` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `adress` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `latlng` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `reference` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `wording` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'Libellé',
  `receipt_date` date NOT NULL COMMENT 'date de paiement',
  `operation_date` date DEFAULT NULL,
  `value_date` date DEFAULT NULL,
  `amount` double NOT NULL COMMENT 'Montant',
  `payment_type` tinyint(2) NOT NULL COMMENT '''type de paiement',
  `payment_etat` tinyint(2) DEFAULT NULL,
  `payment_category_id` smallint(5) UNSIGNED DEFAULT NULL,
  `number_payment` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT ' numéro de paiement  ',
  `deadline_date` date DEFAULT NULL,
  `transact_type_id` tinyint(2) NOT NULL COMMENT ' type de transaction',
  `note` tinytext COLLATE utf8_bin,
  `car_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL,
  `interfering_id` mediumint(9) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL COMMENT 'identifiant Utilisateurs / Payeurs',
  `payment_association_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'Association de paiement',
  `compte_id` tinyint(3) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `payment_associations`
--

CREATE TABLE `payment_associations` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `payment_associations`
--

INSERT INTO `payment_associations` (`id`, `code`, `name`) VALUES
(1, NULL, 'Car'),
(2, NULL, 'Event'),
(3, NULL, 'Mission cost'),
(4, NULL, 'Invoice'),
(5, NULL, 'Offshore'),
(6, 'Preinvoice', 'Preinvoice'),
(7, NULL, 'Cashing'),
(8, NULL, 'Disbursement'),
(9, 'bills', 'Bills');

-- --------------------------------------------------------

--
-- Structure de la table `payment_categories`
--

CREATE TABLE `payment_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `payment_categories`
--

INSERT INTO `payment_categories` (`id`, `code`, `name`, `user_id`, `last_modifier_id`, `created`, `modified`) VALUES
(1, '001', 'Tous', 1, 0, '2019-04-29 16:48:31', '2019-04-29 16:48:31'),
(2, '002', 'Sans', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '003', 'test', 1, 0, '2019-06-08 10:59:24', '2019-06-08 10:59:24');

-- --------------------------------------------------------

--
-- Structure de la table `positions`
--

CREATE TABLE `positions` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `positions`
--

INSERT INTO `positions` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'gauche', '2016-06-23 16:21:35', '2016-06-23 16:21:35', 4, 0),
(2, '', 'droite', '2016-06-23 16:21:42', '2016-06-23 16:21:42', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `wording` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type_pricing` smallint(1) NOT NULL DEFAULT '1',
  `detail_ride_id` int(11) DEFAULT NULL COMMENT 'détail de trajet ',
  `tonnage_id` smallint(5) DEFAULT NULL,
  `km_from` int(11) DEFAULT NULL,
  `km_to` int(11) DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL,
  `supplier_category_id` smallint(5) UNSIGNED DEFAULT NULL,
  `service_id` smallint(6) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `price_categories`
--

CREATE TABLE `price_categories` (
  `id` smallint(2) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `price_categories`
--

INSERT INTO `price_categories` (`id`, `code`, `name`, `user_id`, `last_modifier_id`, `created`, `modified`) VALUES
(1, '001', 'public', 1, 1, '2018-12-19 11:14:11', '2018-12-19 11:19:26'),
(2, '', 'particuler', 1, 0, '2019-01-30 12:22:10', '2019-01-30 12:22:10'),
(3, '', 'professionel', 1, 0, '2019-01-30 12:22:20', '2019-01-30 12:22:20');

-- --------------------------------------------------------

--
-- Structure de la table `price_ride_categories`
--

CREATE TABLE `price_ride_categories` (
  `id` int(11) NOT NULL,
  `price_id` int(11) NOT NULL COMMENT 'identifiant prix',
  `ride_category_id` tinyint(3) UNSIGNED DEFAULT '0',
  `price_ht` double NOT NULL COMMENT 'prix hors taxe',
  `price_ht_night` double DEFAULT NULL COMMENT 'prix hors taxe nuit',
  `price_return` double NOT NULL DEFAULT '0' COMMENT 'prix de retour',
  `pourcentage_price_return` tinyint(3) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `reference` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `quantity` double NOT NULL,
  `quantity_min` double DEFAULT NULL COMMENT 'Quantité minimum',
  `quantity_max` double DEFAULT NULL COMMENT 'Quantité maximum',
  `product_category_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'type de produit',
  `depot_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `pmp` double NOT NULL COMMENT 'prix moyen pondéré',
  `last_purchase_price` double NOT NULL COMMENT 'dernier prix dachat',
  `tva_id` tinyint(2) NOT NULL,
  `product_mark_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'marque de produit',
  `picture` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `alert` tinyint(2) NOT NULL DEFAULT '0',
  `product_family_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `remark` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `product_unit_id` smallint(5) UNSIGNED DEFAULT NULL,
  `changeable_price` tinyint(1) NOT NULL DEFAULT '0',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `out_stock` tinyint(1) NOT NULL DEFAULT '0',
  `weight` double DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `image` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `emplacement` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `with_lot` tinyint(1) NOT NULL DEFAULT '0',
  `description2` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `code`, `reference`, `name`, `quantity`, `quantity_min`, `quantity_max`, `product_category_id`, `depot_id`, `description`, `pmp`, `last_purchase_price`, `tva_id`, `product_mark_id`, `picture`, `created`, `modified`, `user_id`, `modified_id`, `alert`, `product_family_id`, `remark`, `product_unit_id`, `changeable_price`, `blocked`, `out_stock`, `weight`, `volume`, `image`, `emplacement`, `with_lot`, `description2`) VALUES
(1, '001', '001', 'Transport', 0, NULL, NULL, NULL, NULL, '', 0, 0, 1, NULL, '', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `product_families`
--

CREATE TABLE `product_families` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `parent_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `product_families`
--

INSERT INTO `product_families` (`id`, `code`, `name`, `parent_id`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '001', 'Pneus', NULL, '2018-12-15 10:28:53', '2018-12-15 10:28:53', 1, 0),
(2, '002', 'Extincteur', NULL, '2018-12-15 10:30:30', '2018-12-15 10:30:30', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `product_marks`
--

CREATE TABLE `product_marks` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price_category_id` smallint(2) NOT NULL,
  `price_ht` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `product_units`
--

CREATE TABLE `product_units` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `profiles`
--

CREATE TABLE `profiles` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `parent_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `parent_id`, `created`, `modified`) VALUES
(1, 'Admin', NULL, '2016-09-25 00:00:00', '2016-09-25 00:00:00'),
(2, 'Chef de parc', NULL, '2016-09-25 00:00:00', '2016-09-25 00:00:00'),
(3, 'Gestionnaire de stock', NULL, '2016-09-25 00:00:00', '2016-09-25 00:00:00'),
(5, 'Agent commercial', NULL, '2017-07-18 15:42:50', '2017-07-18 15:42:50'),
(6, 'Programmateur ', NULL, '2017-07-18 15:53:20', '2017-07-18 15:53:20'),
(7, 'Chef d\'atelier', NULL, '2017-11-26 10:56:57', '2017-11-26 10:56:57'),
(8, 'Agent d\'administration', NULL, '2017-12-24 11:41:18', '2017-12-24 11:41:18'),
(10, 'Agent', NULL, '2018-09-02 11:42:30', '2018-09-02 11:42:30'),
(11, 'Client', NULL, '2018-09-02 11:45:13', '2018-09-02 11:45:13');

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `promotion_pourcentage` tinyint(3) UNSIGNED NOT NULL,
  `promotion_val` double NOT NULL,
  `promotion_return` double DEFAULT '0',
  `price_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `recharges`
--

CREATE TABLE `recharges` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `extinguisher_id` smallint(5) UNSIGNED NOT NULL,
  `recharge_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL COMMENT 'identifiant de modificateur',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `val` varchar(150) COLLATE utf8_bin NOT NULL COMMENT 'valeur',
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `reports`
--

INSERT INTO `reports` (`id`, `name`, `val`, `created`, `modified`) VALUES
(1, 'mission order customerCar', 'view_mission_transbechiri', '0000-00-00', '0000-00-00'),
(2, 'mission order sheetRide', 'view_mission', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `car_id` mediumint(8) UNSIGNED NOT NULL,
  `sheet_ride_detail_ride_id` int(11) NOT NULL COMMENT 'identifiant de mission ',
  `cost` decimal(11,2) NOT NULL,
  `amount_remaining` decimal(11,2) DEFAULT NULL COMMENT 'reste à payé ',
  `status` smallint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `rides`
--

CREATE TABLE `rides` (
  `id` int(11) NOT NULL,
  `wording` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `departure_destination_id` smallint(6) NOT NULL COMMENT 'destinations départ',
  `arrival_destination_id` smallint(6) NOT NULL COMMENT 'destination d''arrivée',
  `distance` int(5) NOT NULL,
  `duration` tinyint(2) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `actif` int(1) DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `ride_categories`
--

CREATE TABLE `ride_categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `ride_categories`
--

INSERT INTO `ride_categories` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(0, 'sans', 'sans', '2018-09-04 00:00:00', '2018-09-04 00:00:00', 4, 4),
(4, '', 'marchandise', '2017-09-06 14:13:18', '2017-09-06 14:13:18', 1, 0),
(5, '', 'conteneur', '2017-09-06 14:13:26', '2017-09-06 14:13:26', 1, 0),
(6, '', 'pieces de rechanges', '2017-11-22 11:29:52', '2017-11-22 11:29:52', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` smallint(2) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created`, `modified`) VALUES
(3, 'admin', '2015-01-20 00:00:00', '2015-01-20 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `rubrics`
--

CREATE TABLE `rubrics` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `rubrics`
--

INSERT INTO `rubrics` (`id`, `name`, `user_id`, `last_modifier_id`, `created`, `modified`) VALUES
(1, 'Véhicules', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Conducteurs', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Affectations', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Demandes d\'affectation', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Consommations', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'evenements', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'divers', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Stock', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Devis/ Facturation', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Feuille de route ', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Trésorie', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Missions', 1, 0, '2018-02-04 11:38:21', '2018-02-04 11:38:21'),
(13, 'Type véhicule', 1, 1, '2018-02-04 14:42:10', '2018-02-04 15:43:31');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `sub_module_id` tinyint(3) UNSIGNED NOT NULL,
  `has_attachments` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `sections`
--

INSERT INTO `sections` (`id`, `code`, `name`, `sub_module_id`, `has_attachments`, `created`, `modified`) VALUES
(1, 'vehicule', 'Véhicule', 1, 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(2, 'totaux_vehicule', 'Totaux', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(3, 'localisation_vehicule', 'Localisation', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(4, 'categorie_vehicule', 'Catégorie', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(5, 'marque_vehicule', 'Marque', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(6, 'modele_vehicule', 'Modèle', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(7, 'groupe_vehicule', 'Groupe', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(8, 'type_vehicule', 'Type', 1, 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(9, 'statut_vehicule', 'Statut', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(10, 'type_acquisition_vehicule', 'Type acquisition', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(11, 'carburant', 'Carburant', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(12, 'parc_vehicule', 'Parc', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(13, 'fournisseur', 'Fournisseur', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(14, 'remorque', 'Remorque', 1, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(15, 'affectation', 'Affectation', 2, 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(16, 'pv_affectation', 'PV ', 2, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(17, 'decharge_affectation', 'Décharge', 2, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(18, 'option_affectation', 'Option', 2, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(19, 'zone_affectation', 'Zone', 2, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(20, 'affectation_provisoire', 'Affectation provisoire', 3, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(21, 'demande_affectation', 'Demande d\'affectation', 4, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(22, 'employe', 'Employé', 5, 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(23, 'frais_mission', 'Frais de mission', 5, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(24, 'categorie_employee', 'Catégorie', 5, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(25, 'groupe_employe', 'Groupe', 5, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(26, 'affiliation_employe', 'Affiliation', 5, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(27, 'departement', 'Département', 5, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(28, 'carnet_carburant', 'Carnet carburant', 6, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(29, 'carte_carburant', 'Carte carburant', 6, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(30, 'affectation_carte_carburant', 'Affectation carte carburant', 6, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(31, 'citerne', 'Citerne', 6, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(32, 'produit', 'Produit', 7, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(33, 'type_produit', 'Type', 7, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(34, 'marque_produit', 'Marque', 7, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(35, 'tva_produit', 'TVA', 7, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(36, 'depot_produit', 'Dépôt', 7, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(37, 'bon_entree', 'Bon d\'entrée', 34, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(38, 'bon_sortie', 'Bon de sortie', 34, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(39, 'commande_fournisseur', 'Commande fournisseur', 35, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(40, 'pneu', 'Pneu', 8, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(41, 'marque_pneu', 'Marque', 8, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(42, 'position_pneu', 'Position', 8, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(43, 'emplacement_pneu', 'Emplacement', 8, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(44, 'deplacement_pneu', 'Déplacement', 8, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(45, 'verification_pneu', 'Vérification', 8, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(46, 'extincteur', 'Extincteur', 9, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(47, 'deplacement_extincteur', 'Déplacement', 9, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(48, 'recharge_extincteur', 'Recharge', 9, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(50, 'type_evenement', 'Type', 10, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(51, 'type_intervenant', 'Type intervenant', 10, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(52, 'intervenant', 'Intervenant', 10, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(53, 'administratif_evenement', 'Administratif/Juridique', 10, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(54, 'maintenance_evenement', 'Maintenance', 10, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(55, 'demande_intervention', 'Demande d\'intervention', 11, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(57, 'marchandise', 'Marchandise', 12, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(58, 'type_marchandise', 'Type', 12, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(59, 'unite_marchandise', 'Unité', 12, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(60, 'trajet', 'Trajet', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(61, 'villes_trajet', 'Villes', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(62, 'wilaya', 'Wilaya', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(63, 'daira', 'Daira', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(64, 'categorie_trajet', 'Catégorie', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(65, 'detail_trajet', 'Détail trajet', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(66, 'tarif_trajet', 'Tarif', 13, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(68, 'feuille_de_route', 'Feuille de route', 14, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(69, 'mission', 'Mission', 14, 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(70, 'piece_jointe_mission', 'Pièce jointe', 14, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(71, 'marchandise_mission', 'Marchandise', 14, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(73, 'client', 'Client', 15, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(74, 'importation_adresse_client', 'Importation adresse', 15, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(75, 'importation_contact_client', 'Importation contact', 15, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(76, 'categorie_client', 'Catégorie', 15, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(77, 'demande_de_devis', 'Demande de devis', 16, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(78, 'transformer_demande_devis', 'Transformer en devis', 16, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(79, 'devis', 'Devis', 17, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(80, 'transformer_devis', 'Transformer en commande', 17, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(81, 'relancer_devis', 'Relancer', 17, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(82, 'dupliquer_devis', 'Dupliquer', 17, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(83, 'envoyer_devis_mail', 'Envoyer email', 17, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(84, 'commande_client', 'Commande', 18, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(85, 'transformer_commande_client', 'Transformer', 18, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(86, 'detail_commande_client', 'Détail commande', 19, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(87, 'prefacture', 'Préfacture', 20, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(88, 'transformer_prefacture', 'Transformer', 20, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(89, 'paiement_prefacture', 'Paiement', 20, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(90, 'facture', 'Facture', 21, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(91, 'paiement_facture', 'Paiement', 21, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(92, 'encaissement', 'Encaissement', 22, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(93, 'decaissement', 'Décaissement', 23, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(94, 'virement', 'Virement', 24, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(95, 'journal_tresorerie', 'Journal', 25, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(96, 'compte_tresorerie', 'Compte', 26, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(97, 'contrat_affretement', 'Contrat', 27, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(98, 'ajout_vehicule_affretement', 'Ajout véhicule', 28, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(99, 'reservation_affretement', 'Réservation', 29, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(100, 'paiement_reservation_affretement', 'Paiement', 29, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(101, 'statistique_gestion_des_vehicules', 'Gestion des véhicules', 30, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(102, 'statistique_gestion_des_consommations', 'Gestion des consommations', 30, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(103, 'statistique_gestion_commerciale', 'Gestion commerciale', 30, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(104, 'commercial_tableau_bord', 'Commercial', 31, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(105, 'planification_tableau_bord', 'Planification', 31, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(106, 'finance_tableau_bord', 'Finance', 31, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(107, 'alertes_tableau_bord', 'Alertes', 31, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(108, 'liens_tableau_bord', 'Liens rapides', 31, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(109, 'evenements_tableau_bord', 'Evenements', 31, 0, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(110, 'type_piece_jointe_client', 'Type pièce jointe', 15, 0, '2018-08-12 00:00:00', '2018-08-12 00:00:00'),
(111, 'service', 'Service', 5, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'transmettre_commande_client', 'Transmettre la commande client', 18, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 'annuler_commande_client', 'Annuler la commande client', 18, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 'categorie_piece', 'Catégorie pièce', 17, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 'famille_produit', 'Famille produit', 7, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 'alertes_commerciales', 'Gestion commerciale', 32, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 'alertes_administratives_juridiques', 'Gestion administrative et juridique', 32, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 'alertes_maintenances', 'Alertes maintenances', 32, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 'alertes_consommations', 'Alertes consommations', 32, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 'alertes_parcs', 'Alertes parc', 32, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 'alertes_stock', 'Alertes stock', 32, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 'categorie_prix', 'Catégorie prix', 7, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 'visite_medicale', 'Visite médicale', 33, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 'product_unit', 'unité produit', 7, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(127, 'lot_type', 'Type lot', 7, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(128, 'bon_reception', 'Bon de réception', 34, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(129, 'bon_livraison', 'Bon de livraison', 34, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(130, 'retour_fournisseur', 'Retour fournisseur', 34, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(131, 'retour_client', 'Retour client', 34, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(132, 'bon_renvoi', 'Bon de renvoi', 34, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(133, 'bon_reintegration', 'Bon de réintegration', 34, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(134, 'facture_achat', 'Facture d\'achat', 36, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(135, 'avoir', 'Avoir sur achat', 37, 0, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(136, 'parc_tableau_bord', 'Parc', 31, 0, '2019-03-02 00:00:00', '2019-03-02 00:00:00'),
(137, 'causes_annulation', 'Cause d\'annulation', 18, 0, '2019-03-20 00:00:00', '2019-03-20 00:00:00'),
(138, 'avertissement', 'Avertissement', 38, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 'type_avertissement', 'Type avertissement', 38, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 'absence', 'Absence', 39, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'raison_absence', 'Raison dabsence', 39, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'avoir_vente', 'Avoir sur vente', 40, 0, '2019-04-17 00:00:00', '2019-04-17 00:00:00'),
(143, 'demande_produit', 'Demande produit', 41, 0, '2019-11-13 00:00:00', '2019-11-13 00:00:00'),
(144, 'demande_achat', 'Demande d\"achat', 42, 0, '2019-11-13 00:00:00', '2019-11-13 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `section_actions`
--

CREATE TABLE `section_actions` (
  `id` int(11) NOT NULL,
  `section_id` smallint(5) UNSIGNED NOT NULL,
  `code_section` varchar(150) COLLATE utf8_bin NOT NULL,
  `action_id` smallint(5) UNSIGNED NOT NULL,
  `code_action` varchar(150) COLLATE utf8_bin NOT NULL,
  `value` smallint(2) NOT NULL COMMENT 'valeur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `section_actions`
--

INSERT INTO `section_actions` (`id`, `section_id`, `code_section`, `action_id`, `code_action`, `value`) VALUES
(1, 1, 'vehicule', 1, 'view', 1),
(2, 1, 'vehicule', 2, 'view_other', 1),
(3, 1, 'vehicule', 3, 'add', 1),
(4, 1, 'vehicule', 4, 'edit', 1),
(5, 1, 'vehicule', 5, 'edit_other', 1),
(6, 1, 'vehicule', 6, 'delete', 1),
(7, 1, 'vehicule', 7, 'delete_other', 1),
(8, 1, 'vehicule', 8, 'lock', 1),
(9, 1, 'vehicule', 9, 'lock_other', 1),
(10, 1, 'vehicule', 10, 'view_other_parc', 1),
(11, 1, 'vehicule', 11, 'audit', 1),
(12, 1, 'vehicule', 12, 'search', 1),
(13, 1, 'vehicule', 13, 'export', 1),
(14, 1, 'vehicule', 14, 'import', 1),
(15, 1, 'vehicule', 15, 'print', 1),
(16, 2, 'totaux_vehicule', 1, 'view', 1),
(17, 2, 'totaux_vehicule', 2, 'view_other', 0),
(18, 2, 'totaux_vehicule', 3, 'add', 0),
(19, 2, 'totaux_vehicule', 4, 'edit', 0),
(20, 2, 'totaux_vehicule', 5, 'edit_other', 0),
(21, 2, 'totaux_vehicule', 6, 'delete', 0),
(22, 2, 'totaux_vehicule', 7, 'delete_other', 0),
(23, 2, 'totaux_vehicule', 8, 'lock', 0),
(24, 2, 'totaux_vehicule', 9, 'lock_other', 0),
(25, 2, 'totaux_vehicule', 10, 'view_other_parc', 0),
(26, 2, 'totaux_vehicule', 11, 'audit', 0),
(27, 2, 'totaux_vehicule', 12, 'search', 0),
(28, 2, 'totaux_vehicule', 13, 'export', 0),
(29, 2, 'totaux_vehicule', 14, 'import', 0),
(30, 2, 'totaux_vehicule', 15, 'print', 0),
(31, 3, 'localisation_vehicule', 1, 'view', 1),
(32, 3, 'localisation_vehicule', 2, 'view_other', 0),
(33, 3, 'localisation_vehicule', 3, 'add', 0),
(34, 3, 'localisation_vehicule', 4, 'edit', 0),
(35, 3, 'localisation_vehicule', 5, 'edit_other', 0),
(36, 3, 'localisation_vehicule', 6, 'delete', 0),
(37, 3, 'localisation_vehicule', 7, 'delete_other', 0),
(38, 3, 'localisation_vehicule', 8, 'lock', 0),
(39, 3, 'localisation_vehicule', 9, 'lock_other', 0),
(40, 3, 'localisation_vehicule', 10, 'view_other_parc', 0),
(41, 3, 'localisation_vehicule', 11, 'audit', 0),
(42, 3, 'localisation_vehicule', 12, 'search', 0),
(43, 3, 'localisation_vehicule', 13, 'export', 0),
(44, 3, 'localisation_vehicule', 14, 'import', 0),
(45, 3, 'localisation_vehicule', 15, 'print', 0),
(46, 4, 'categorie_vehicule', 1, 'view', 1),
(47, 4, 'categorie_vehicule', 2, 'view_other', 1),
(48, 4, 'categorie_vehicule', 3, 'add', 1),
(49, 4, 'categorie_vehicule', 4, 'edit', 1),
(50, 4, 'categorie_vehicule', 5, 'edit_other', 1),
(51, 4, 'categorie_vehicule', 6, 'delete', 1),
(52, 4, 'categorie_vehicule', 7, 'delete_other', 1),
(53, 4, 'categorie_vehicule', 8, 'lock', 1),
(54, 4, 'categorie_vehicule', 9, 'lock_other', 1),
(55, 4, 'categorie_vehicule', 10, 'view_other_parc', 1),
(56, 4, 'categorie_vehicule', 11, 'audit', 1),
(57, 4, 'categorie_vehicule', 12, 'search', 1),
(58, 4, 'categorie_vehicule', 13, 'export', 1),
(59, 4, 'categorie_vehicule', 14, 'import', 1),
(60, 4, 'categorie_vehicule', 15, 'print', 1),
(61, 5, 'marque_vehicule', 1, 'view', 1),
(62, 5, 'marque_vehicule', 2, 'view_other', 1),
(63, 5, 'marque_vehicule', 3, 'add', 1),
(64, 5, 'marque_vehicule', 4, 'edit', 1),
(65, 5, 'marque_vehicule', 5, 'edit_other', 1),
(66, 5, 'marque_vehicule', 6, 'delete', 1),
(67, 5, 'marque_vehicule', 7, 'delete_other', 1),
(68, 5, 'marque_vehicule', 8, 'lock', 1),
(69, 5, 'marque_vehicule', 9, 'lock_other', 1),
(70, 5, 'marque_vehicule', 10, 'view_other_parc', 1),
(71, 5, 'marque_vehicule', 11, 'audit', 1),
(72, 5, 'marque_vehicule', 12, 'search', 1),
(73, 5, 'marque_vehicule', 13, 'export', 1),
(74, 5, 'marque_vehicule', 14, 'import', 1),
(75, 5, 'marque_vehicule', 15, 'print', 1),
(76, 6, 'modele_vehicule', 1, 'view', 1),
(77, 6, 'modele_vehicule', 2, 'view_other', 1),
(78, 6, 'modele_vehicule', 3, 'add', 1),
(79, 6, 'modele_vehicule', 4, 'edit', 1),
(80, 6, 'modele_vehicule', 5, 'edit_other', 1),
(81, 6, 'modele_vehicule', 6, 'delete', 1),
(82, 6, 'modele_vehicule', 7, 'delete_other', 1),
(83, 6, 'modele_vehicule', 8, 'lock', 1),
(84, 6, 'modele_vehicule', 9, 'lock_other', 1),
(85, 6, 'modele_vehicule', 10, 'view_other_parc', 1),
(86, 6, 'modele_vehicule', 11, 'audit', 1),
(87, 6, 'modele_vehicule', 12, 'search', 1),
(88, 6, 'modele_vehicule', 13, 'export', 1),
(89, 6, 'modele_vehicule', 14, 'import', 1),
(90, 6, 'modele_vehicule', 15, 'print', 1),
(91, 7, 'groupe_vehicule', 1, 'view', 1),
(92, 7, 'groupe_vehicule', 2, 'view_other', 1),
(93, 7, 'groupe_vehicule', 3, 'add', 1),
(94, 7, 'groupe_vehicule', 4, 'edit', 1),
(95, 7, 'groupe_vehicule', 5, 'edit_other', 1),
(96, 7, 'groupe_vehicule', 6, 'delete', 1),
(97, 7, 'groupe_vehicule', 7, 'delete_other', 1),
(98, 7, 'groupe_vehicule', 8, 'lock', 1),
(99, 7, 'groupe_vehicule', 9, 'lock_other', 1),
(100, 7, 'groupe_vehicule', 10, 'view_other_parc', 1),
(101, 7, 'groupe_vehicule', 11, 'audit', 1),
(102, 7, 'groupe_vehicule', 12, 'search', 1),
(103, 7, 'groupe_vehicule', 13, 'export', 1),
(104, 7, 'groupe_vehicule', 14, 'import', 1),
(105, 7, 'groupe_vehicule', 15, 'print', 1),
(106, 8, 'type_vehicule', 1, 'view', 1),
(107, 8, 'type_vehicule', 2, 'view_other', 1),
(108, 8, 'type_vehicule', 3, 'add', 1),
(109, 8, 'type_vehicule', 4, 'edit', 1),
(110, 8, 'type_vehicule', 5, 'edit_other', 1),
(111, 8, 'type_vehicule', 6, 'delete', 1),
(112, 8, 'type_vehicule', 7, 'delete_other', 1),
(113, 8, 'type_vehicule', 8, 'lock', 1),
(114, 8, 'type_vehicule', 9, 'lock_other', 1),
(115, 8, 'type_vehicule', 10, 'view_other_parc', 1),
(116, 8, 'type_vehicule', 11, 'audit', 1),
(117, 8, 'type_vehicule', 12, 'search', 1),
(118, 8, 'type_vehicule', 13, 'export', 1),
(119, 8, 'type_vehicule', 14, 'import', 1),
(120, 8, 'type_vehicule', 15, 'print', 1),
(121, 9, 'statut_vehicule', 1, 'view', 1),
(122, 9, 'statut_vehicule', 2, 'view_other', 1),
(123, 9, 'statut_vehicule', 3, 'add', 1),
(124, 9, 'statut_vehicule', 4, 'edit', 1),
(125, 9, 'statut_vehicule', 5, 'edit_other', 1),
(126, 9, 'statut_vehicule', 6, 'delete', 1),
(127, 9, 'statut_vehicule', 7, 'delete_other', 1),
(128, 9, 'statut_vehicule', 8, 'lock', 1),
(129, 9, 'statut_vehicule', 9, 'lock_other', 1),
(130, 9, 'statut_vehicule', 10, 'view_other_parc', 1),
(131, 9, 'statut_vehicule', 11, 'audit', 1),
(132, 9, 'statut_vehicule', 12, 'search', 1),
(133, 9, 'statut_vehicule', 13, 'export', 1),
(134, 9, 'statut_vehicule', 14, 'import', 1),
(135, 9, 'statut_vehicule', 15, 'print', 1),
(136, 10, 'type_acquisition_vehicule', 1, 'view', 1),
(137, 10, 'type_acquisition_vehicule', 2, 'view_other', 1),
(138, 10, 'type_acquisition_vehicule', 3, 'add', 1),
(139, 10, 'type_acquisition_vehicule', 4, 'edit', 1),
(140, 10, 'type_acquisition_vehicule', 5, 'edit_other', 1),
(141, 10, 'type_acquisition_vehicule', 6, 'delete', 1),
(142, 10, 'type_acquisition_vehicule', 7, 'delete_other', 1),
(143, 10, 'type_acquisition_vehicule', 8, 'lock', 1),
(144, 10, 'type_acquisition_vehicule', 9, 'lock_other', 1),
(145, 10, 'type_acquisition_vehicule', 10, 'view_other_parc', 1),
(146, 10, 'type_acquisition_vehicule', 11, 'audit', 1),
(147, 10, 'type_acquisition_vehicule', 12, 'search', 1),
(148, 10, 'type_acquisition_vehicule', 13, 'export', 1),
(149, 10, 'type_acquisition_vehicule', 14, 'import', 1),
(150, 10, 'type_acquisition_vehicule', 15, 'print', 1),
(151, 11, 'carburant', 1, 'view', 1),
(152, 11, 'carburant', 2, 'view_other', 1),
(153, 11, 'carburant', 3, 'add', 1),
(154, 11, 'carburant', 4, 'edit', 1),
(155, 11, 'carburant', 5, 'edit_other', 1),
(156, 11, 'carburant', 6, 'delete', 1),
(157, 11, 'carburant', 7, 'delete_other', 1),
(158, 11, 'carburant', 8, 'lock', 1),
(159, 11, 'carburant', 9, 'lock_other', 1),
(160, 11, 'carburant', 10, 'view_other_parc', 1),
(161, 11, 'carburant', 11, 'audit', 1),
(162, 11, 'carburant', 12, 'search', 1),
(163, 11, 'carburant', 13, 'export', 1),
(164, 11, 'carburant', 14, 'import', 1),
(165, 11, 'carburant', 15, 'print', 1),
(166, 12, 'parc_vehicule', 1, 'view', 1),
(167, 12, 'parc_vehicule', 2, 'view_other', 1),
(168, 12, 'parc_vehicule', 3, 'add', 1),
(169, 12, 'parc_vehicule', 4, 'edit', 1),
(170, 12, 'parc_vehicule', 5, 'edit_other', 1),
(171, 12, 'parc_vehicule', 6, 'delete', 1),
(172, 12, 'parc_vehicule', 7, 'delete_other', 1),
(173, 12, 'parc_vehicule', 8, 'lock', 1),
(174, 12, 'parc_vehicule', 9, 'lock_other', 1),
(175, 12, 'parc_vehicule', 10, 'view_other_parc', 1),
(176, 12, 'parc_vehicule', 11, 'audit', 1),
(177, 12, 'parc_vehicule', 12, 'search', 1),
(178, 12, 'parc_vehicule', 13, 'export', 1),
(179, 12, 'parc_vehicule', 14, 'import', 1),
(180, 12, 'parc_vehicule', 15, 'print', 1),
(181, 13, 'fournisseur', 1, 'view', 1),
(182, 13, 'fournisseur', 2, 'view_other', 1),
(183, 13, 'fournisseur', 3, 'add', 1),
(184, 13, 'fournisseur', 4, 'edit', 1),
(185, 13, 'fournisseur', 5, 'edit_other', 1),
(186, 13, 'fournisseur', 6, 'delete', 1),
(187, 13, 'fournisseur', 7, 'delete_other', 1),
(188, 13, 'fournisseur', 8, 'lock', 1),
(189, 13, 'fournisseur', 9, 'lock_other', 1),
(190, 13, 'fournisseur', 10, 'view_other_parc', 1),
(191, 13, 'fournisseur', 11, 'audit', 1),
(192, 13, 'fournisseur', 12, 'search', 1),
(193, 13, 'fournisseur', 13, 'export', 1),
(194, 13, 'fournisseur', 14, 'import', 1),
(195, 13, 'fournisseur', 15, 'print', 1),
(196, 14, 'remorque', 1, 'view', 1),
(197, 14, 'remorque', 2, 'view_other', 1),
(198, 14, 'remorque', 3, 'add', 1),
(199, 14, 'remorque', 4, 'edit', 1),
(200, 14, 'remorque', 5, 'edit_other', 1),
(201, 14, 'remorque', 6, 'delete', 1),
(202, 14, 'remorque', 7, 'delete_other', 1),
(203, 14, 'remorque', 8, 'lock', 1),
(204, 14, 'remorque', 9, 'lock_other', 1),
(205, 14, 'remorque', 10, 'view_other_parc', 1),
(206, 14, 'remorque', 11, 'audit', 1),
(207, 14, 'remorque', 12, 'search', 1),
(208, 14, 'remorque', 13, 'export', 1),
(209, 14, 'remorque', 14, 'import', 1),
(210, 14, 'remorque', 15, 'print', 1),
(211, 15, 'affectation', 1, 'view', 1),
(212, 15, 'affectation', 2, 'view_other', 1),
(213, 15, 'affectation', 3, 'add', 1),
(214, 15, 'affectation', 4, 'edit', 1),
(215, 15, 'affectation', 5, 'edit_other', 1),
(216, 15, 'affectation', 6, 'delete', 1),
(217, 15, 'affectation', 7, 'delete_other', 1),
(218, 15, 'affectation', 8, 'lock', 1),
(219, 15, 'affectation', 9, 'lock_other', 1),
(220, 15, 'affectation', 10, 'view_other_parc', 1),
(221, 15, 'affectation', 11, 'audit', 1),
(222, 15, 'affectation', 12, 'search', 1),
(223, 15, 'affectation', 13, 'export', 1),
(224, 15, 'affectation', 14, 'import', 1),
(225, 15, 'affectation', 15, 'print', 1),
(226, 16, 'pv_affectation', 1, 'view', 1),
(227, 16, 'pv_affectation', 2, 'view_other', 0),
(228, 16, 'pv_affectation', 3, 'add', 0),
(229, 16, 'pv_affectation', 4, 'edit', 0),
(230, 16, 'pv_affectation', 5, 'edit_other', 0),
(231, 16, 'pv_affectation', 6, 'delete', 0),
(232, 16, 'pv_affectation', 7, 'delete_other', 0),
(233, 16, 'pv_affectation', 8, 'lock', 0),
(234, 16, 'pv_affectation', 9, 'lock_other', 0),
(235, 16, 'pv_affectation', 10, 'view_other_parc', 0),
(236, 16, 'pv_affectation', 11, 'audit', 0),
(237, 16, 'pv_affectation', 12, 'search', 0),
(238, 16, 'pv_affectation', 13, 'export', 0),
(239, 16, 'pv_affectation', 14, 'import', 0),
(240, 16, 'pv_affectation', 15, 'print', 1),
(241, 17, 'decharge_affectation', 1, 'view', 1),
(242, 17, 'decharge_affectation', 2, 'view_other', 0),
(243, 17, 'decharge_affectation', 3, 'add', 0),
(244, 17, 'decharge_affectation', 4, 'edit', 0),
(245, 17, 'decharge_affectation', 5, 'edit_other', 0),
(246, 17, 'decharge_affectation', 6, 'delete', 0),
(247, 17, 'decharge_affectation', 7, 'delete_other', 0),
(248, 17, 'decharge_affectation', 8, 'lock', 0),
(249, 17, 'decharge_affectation', 9, 'lock_other', 0),
(250, 17, 'decharge_affectation', 10, 'view_other_parc', 0),
(251, 17, 'decharge_affectation', 11, 'audit', 0),
(252, 17, 'decharge_affectation', 12, 'search', 0),
(253, 17, 'decharge_affectation', 13, 'export', 0),
(254, 17, 'decharge_affectation', 14, 'import', 0),
(255, 17, 'decharge_affectation', 15, 'print', 0),
(256, 18, 'option_affectation', 1, 'view', 1),
(257, 18, 'option_affectation', 2, 'view_other', 1),
(258, 18, 'option_affectation', 3, 'add', 1),
(259, 18, 'option_affectation', 4, 'edit', 1),
(260, 18, 'option_affectation', 5, 'edit_other', 1),
(261, 18, 'option_affectation', 6, 'delete', 1),
(262, 18, 'option_affectation', 7, 'delete_other', 1),
(263, 18, 'option_affectation', 8, 'lock', 1),
(264, 18, 'option_affectation', 9, 'lock_other', 1),
(265, 18, 'option_affectation', 10, 'view_other_parc', 1),
(266, 18, 'option_affectation', 11, 'audit', 1),
(267, 18, 'option_affectation', 12, 'search', 1),
(268, 18, 'option_affectation', 13, 'export', 1),
(269, 18, 'option_affectation', 14, 'import', 1),
(270, 18, 'option_affectation', 15, 'print', 1),
(271, 19, 'zone_affectation', 1, 'view', 1),
(272, 19, 'zone_affectation', 2, 'view_other', 1),
(273, 19, 'zone_affectation', 3, 'add', 1),
(274, 19, 'zone_affectation', 4, 'edit', 1),
(275, 19, 'zone_affectation', 5, 'edit_other', 1),
(276, 19, 'zone_affectation', 6, 'delete', 1),
(277, 19, 'zone_affectation', 7, 'delete_other', 1),
(278, 19, 'zone_affectation', 8, 'lock', 1),
(279, 19, 'zone_affectation', 9, 'lock_other', 1),
(280, 19, 'zone_affectation', 10, 'view_other_parc', 1),
(281, 19, 'zone_affectation', 11, 'audit', 1),
(282, 19, 'zone_affectation', 12, 'search', 1),
(283, 19, 'zone_affectation', 13, 'export', 1),
(284, 19, 'zone_affectation', 14, 'import', 1),
(285, 19, 'zone_affectation', 15, 'print', 1),
(286, 20, 'affectation_provisoire', 1, 'view', 1),
(287, 20, 'affectation_provisoire', 2, 'view_other', 1),
(288, 20, 'affectation_provisoire', 3, 'add', 1),
(289, 20, 'affectation_provisoire', 4, 'edit', 1),
(290, 20, 'affectation_provisoire', 5, 'edit_other', 1),
(291, 20, 'affectation_provisoire', 6, 'delete', 1),
(292, 20, 'affectation_provisoire', 7, 'delete_other', 1),
(293, 20, 'affectation_provisoire', 8, 'lock', 1),
(294, 20, 'affectation_provisoire', 9, 'lock_other', 1),
(295, 20, 'affectation_provisoire', 10, 'view_other_parc', 1),
(296, 20, 'affectation_provisoire', 11, 'audit', 1),
(297, 20, 'affectation_provisoire', 12, 'search', 1),
(298, 20, 'affectation_provisoire', 13, 'export', 1),
(299, 20, 'affectation_provisoire', 14, 'import', 1),
(300, 20, 'affectation_provisoire', 15, 'print', 1),
(301, 21, 'demande_affectation', 1, 'view', 1),
(302, 21, 'demande_affectation', 2, 'view_other', 1),
(303, 21, 'demande_affectation', 3, 'add', 1),
(304, 21, 'demande_affectation', 4, 'edit', 1),
(305, 21, 'demande_affectation', 5, 'edit_other', 1),
(306, 21, 'demande_affectation', 6, 'delete', 1),
(307, 21, 'demande_affectation', 7, 'delete_other', 1),
(308, 21, 'demande_affectation', 8, 'lock', 1),
(309, 21, 'demande_affectation', 9, 'lock_other', 1),
(310, 21, 'demande_affectation', 10, 'view_other_parc', 1),
(311, 21, 'demande_affectation', 11, 'audit', 1),
(312, 21, 'demande_affectation', 12, 'search', 1),
(313, 21, 'demande_affectation', 13, 'export', 1),
(314, 21, 'demande_affectation', 14, 'import', 1),
(315, 21, 'demande_affectation', 15, 'print', 1),
(316, 22, 'employe', 1, 'view', 1),
(317, 22, 'employe', 2, 'view_other', 1),
(318, 22, 'employe', 3, 'add', 1),
(319, 22, 'employe', 4, 'edit', 1),
(320, 22, 'employe', 5, 'edit_other', 1),
(321, 22, 'employe', 6, 'delete', 1),
(322, 22, 'employe', 7, 'delete_other', 1),
(323, 22, 'employe', 8, 'lock', 1),
(324, 22, 'employe', 9, 'lock_other', 1),
(325, 22, 'employe', 10, 'view_other_parc', 1),
(326, 22, 'employe', 11, 'audit', 1),
(327, 22, 'employe', 12, 'search', 1),
(328, 22, 'employe', 13, 'export', 1),
(329, 22, 'employe', 14, 'import', 1),
(330, 22, 'employe', 15, 'print', 1),
(331, 23, 'frais_mission', 1, 'view', 1),
(332, 23, 'frais_mission', 2, 'view_other', 1),
(333, 23, 'frais_mission', 3, 'add', 1),
(334, 23, 'frais_mission', 4, 'edit', 1),
(335, 23, 'frais_mission', 5, 'edit_other', 1),
(336, 23, 'frais_mission', 6, 'delete', 1),
(337, 23, 'frais_mission', 7, 'delete_other', 1),
(338, 23, 'frais_mission', 8, 'lock', 1),
(339, 23, 'frais_mission', 9, 'lock_other', 1),
(340, 23, 'frais_mission', 10, 'view_other_parc', 1),
(341, 23, 'frais_mission', 11, 'audit', 1),
(342, 23, 'frais_mission', 12, 'search', 1),
(343, 23, 'frais_mission', 13, 'export', 1),
(344, 23, 'frais_mission', 14, 'import', 1),
(345, 23, 'frais_mission', 15, 'print', 1),
(346, 24, 'categorie_employee', 1, 'view', 1),
(347, 24, 'categorie_employee', 2, 'view_other', 1),
(348, 24, 'categorie_employee', 3, 'add', 1),
(349, 24, 'categorie_employee', 4, 'edit', 1),
(350, 24, 'categorie_employee', 5, 'edit_other', 1),
(351, 24, 'categorie_employee', 6, 'delete', 1),
(352, 24, 'categorie_employee', 7, 'delete_other', 1),
(353, 24, 'categorie_employee', 8, 'lock', 1),
(354, 24, 'categorie_employee', 9, 'lock_other', 1),
(355, 24, 'categorie_employee', 10, 'view_other_parc', 1),
(356, 24, 'categorie_employee', 11, 'audit', 1),
(357, 24, 'categorie_employee', 12, 'search', 1),
(358, 24, 'categorie_employee', 13, 'export', 1),
(359, 24, 'categorie_employee', 14, 'import', 1),
(360, 24, 'categorie_employee', 15, 'print', 1),
(361, 25, 'groupe_employe', 1, 'view', 1),
(362, 25, 'groupe_employe', 2, 'view_other', 1),
(363, 25, 'groupe_employe', 3, 'add', 1),
(364, 25, 'groupe_employe', 4, 'edit', 1),
(365, 25, 'groupe_employe', 5, 'edit_other', 1),
(366, 25, 'groupe_employe', 6, 'delete', 1),
(367, 25, 'groupe_employe', 7, 'delete_other', 1),
(368, 25, 'groupe_employe', 8, 'lock', 1),
(369, 25, 'groupe_employe', 9, 'lock_other', 1),
(370, 25, 'groupe_employe', 10, 'view_other_parc', 1),
(371, 25, 'groupe_employe', 11, 'audit', 1),
(372, 25, 'groupe_employe', 12, 'search', 1),
(373, 25, 'groupe_employe', 13, 'export', 1),
(374, 25, 'groupe_employe', 14, 'import', 1),
(375, 25, 'groupe_employe', 15, 'print', 1),
(376, 26, 'affiliation_employe', 1, 'view', 1),
(377, 26, 'affiliation_employe', 2, 'view_other', 1),
(378, 26, 'affiliation_employe', 3, 'add', 1),
(379, 26, 'affiliation_employe', 4, 'edit', 1),
(380, 26, 'affiliation_employe', 5, 'edit_other', 1),
(381, 26, 'affiliation_employe', 6, 'delete', 1),
(382, 26, 'affiliation_employe', 7, 'delete_other', 1),
(383, 26, 'affiliation_employe', 8, 'lock', 1),
(384, 26, 'affiliation_employe', 9, 'lock_other', 1),
(385, 26, 'affiliation_employe', 10, 'view_other_parc', 1),
(386, 26, 'affiliation_employe', 11, 'audit', 1),
(387, 26, 'affiliation_employe', 12, 'search', 1),
(388, 26, 'affiliation_employe', 13, 'export', 1),
(389, 26, 'affiliation_employe', 14, 'import', 1),
(390, 26, 'affiliation_employe', 15, 'print', 1),
(391, 27, 'departement', 1, 'view', 1),
(392, 27, 'departement', 2, 'view_other', 1),
(393, 27, 'departement', 3, 'add', 1),
(394, 27, 'departement', 4, 'edit', 1),
(395, 27, 'departement', 5, 'edit_other', 1),
(396, 27, 'departement', 6, 'delete', 1),
(397, 27, 'departement', 7, 'delete_other', 1),
(398, 27, 'departement', 8, 'lock', 1),
(399, 27, 'departement', 9, 'lock_other', 1),
(400, 27, 'departement', 10, 'view_other_parc', 1),
(401, 27, 'departement', 11, 'audit', 1),
(402, 27, 'departement', 12, 'search', 1),
(403, 27, 'departement', 13, 'export', 1),
(404, 27, 'departement', 14, 'import', 1),
(405, 27, 'departement', 15, 'print', 1),
(406, 28, 'carnet_carburant', 1, 'view', 1),
(407, 28, 'carnet_carburant', 2, 'view_other', 1),
(408, 28, 'carnet_carburant', 3, 'add', 1),
(409, 28, 'carnet_carburant', 4, 'edit', 1),
(410, 28, 'carnet_carburant', 5, 'edit_other', 1),
(411, 28, 'carnet_carburant', 6, 'delete', 1),
(412, 28, 'carnet_carburant', 7, 'delete_other', 1),
(413, 28, 'carnet_carburant', 8, 'lock', 1),
(414, 28, 'carnet_carburant', 9, 'lock_other', 1),
(415, 28, 'carnet_carburant', 10, 'view_other_parc', 1),
(416, 28, 'carnet_carburant', 11, 'audit', 1),
(417, 28, 'carnet_carburant', 12, 'search', 1),
(418, 28, 'carnet_carburant', 13, 'export', 1),
(419, 28, 'carnet_carburant', 14, 'import', 1),
(420, 28, 'carnet_carburant', 15, 'print', 1),
(421, 29, 'carte_carburant', 1, 'view', 1),
(422, 29, 'carte_carburant', 2, 'view_other', 1),
(423, 29, 'carte_carburant', 3, 'add', 1),
(424, 29, 'carte_carburant', 4, 'edit', 1),
(425, 29, 'carte_carburant', 5, 'edit_other', 1),
(426, 29, 'carte_carburant', 6, 'delete', 1),
(427, 29, 'carte_carburant', 7, 'delete_other', 1),
(428, 29, 'carte_carburant', 8, 'lock', 1),
(429, 29, 'carte_carburant', 9, 'lock_other', 1),
(430, 29, 'carte_carburant', 10, 'view_other_parc', 1),
(431, 29, 'carte_carburant', 11, 'audit', 1),
(432, 29, 'carte_carburant', 12, 'search', 1),
(433, 29, 'carte_carburant', 13, 'export', 1),
(434, 29, 'carte_carburant', 14, 'import', 1),
(435, 29, 'carte_carburant', 15, 'print', 1),
(436, 30, 'affectation_carte_carburant', 1, 'view', 1),
(437, 30, 'affectation_carte_carburant', 2, 'view_other', 1),
(438, 30, 'affectation_carte_carburant', 3, 'add', 1),
(439, 30, 'affectation_carte_carburant', 4, 'edit', 1),
(440, 30, 'affectation_carte_carburant', 5, 'edit_other', 1),
(441, 30, 'affectation_carte_carburant', 6, 'delete', 1),
(442, 30, 'affectation_carte_carburant', 7, 'delete_other', 1),
(443, 30, 'affectation_carte_carburant', 8, 'lock', 1),
(444, 30, 'affectation_carte_carburant', 9, 'lock_other', 1),
(445, 30, 'affectation_carte_carburant', 10, 'view_other_parc', 1),
(446, 30, 'affectation_carte_carburant', 11, 'audit', 1),
(447, 30, 'affectation_carte_carburant', 12, 'search', 1),
(448, 30, 'affectation_carte_carburant', 13, 'export', 1),
(449, 30, 'affectation_carte_carburant', 14, 'import', 1),
(450, 30, 'affectation_carte_carburant', 15, 'print', 1),
(451, 31, 'citerne', 1, 'view', 1),
(452, 31, 'citerne', 2, 'view_other', 1),
(453, 31, 'citerne', 3, 'add', 1),
(454, 31, 'citerne', 4, 'edit', 1),
(455, 31, 'citerne', 5, 'edit_other', 1),
(456, 31, 'citerne', 6, 'delete', 1),
(457, 31, 'citerne', 7, 'delete_other', 1),
(458, 31, 'citerne', 8, 'lock', 1),
(459, 31, 'citerne', 9, 'lock_other', 1),
(460, 31, 'citerne', 10, 'view_other_parc', 1),
(461, 31, 'citerne', 11, 'audit', 1),
(462, 31, 'citerne', 12, 'search', 1),
(463, 31, 'citerne', 13, 'export', 1),
(464, 31, 'citerne', 14, 'import', 1),
(465, 31, 'citerne', 15, 'print', 1),
(466, 32, 'produit', 1, 'view', 1),
(467, 32, 'produit', 2, 'view_other', 1),
(468, 32, 'produit', 3, 'add', 1),
(469, 32, 'produit', 4, 'edit', 1),
(470, 32, 'produit', 5, 'edit_other', 1),
(471, 32, 'produit', 6, 'delete', 1),
(472, 32, 'produit', 7, 'delete_other', 1),
(473, 32, 'produit', 8, 'lock', 1),
(474, 32, 'produit', 9, 'lock_other', 1),
(475, 32, 'produit', 10, 'view_other_parc', 1),
(476, 32, 'produit', 11, 'audit', 1),
(477, 32, 'produit', 12, 'search', 1),
(478, 32, 'produit', 13, 'export', 1),
(479, 32, 'produit', 14, 'import', 1),
(480, 32, 'produit', 15, 'print', 1),
(481, 33, 'type_produit', 1, 'view', 1),
(482, 33, 'type_produit', 2, 'view_other', 1),
(483, 33, 'type_produit', 3, 'add', 1),
(484, 33, 'type_produit', 4, 'edit', 1),
(485, 33, 'type_produit', 5, 'edit_other', 1),
(486, 33, 'type_produit', 6, 'delete', 1),
(487, 33, 'type_produit', 7, 'delete_other', 1),
(488, 33, 'type_produit', 8, 'lock', 1),
(489, 33, 'type_produit', 9, 'lock_other', 1),
(490, 33, 'type_produit', 10, 'view_other_parc', 1),
(491, 33, 'type_produit', 11, 'audit', 1),
(492, 33, 'type_produit', 12, 'search', 1),
(493, 33, 'type_produit', 13, 'export', 1),
(494, 33, 'type_produit', 14, 'import', 1),
(495, 33, 'type_produit', 15, 'print', 1),
(496, 34, 'marque_produit', 1, 'view', 1),
(497, 34, 'marque_produit', 2, 'view_other', 1),
(498, 34, 'marque_produit', 3, 'add', 1),
(499, 34, 'marque_produit', 4, 'edit', 1),
(500, 34, 'marque_produit', 5, 'edit_other', 1),
(501, 34, 'marque_produit', 6, 'delete', 1),
(502, 34, 'marque_produit', 7, 'delete_other', 1),
(503, 34, 'marque_produit', 8, 'lock', 1),
(504, 34, 'marque_produit', 9, 'lock_other', 1),
(505, 34, 'marque_produit', 10, 'view_other_parc', 1),
(506, 34, 'marque_produit', 11, 'audit', 1),
(507, 34, 'marque_produit', 12, 'search', 1),
(508, 34, 'marque_produit', 13, 'export', 1),
(509, 34, 'marque_produit', 14, 'import', 1),
(510, 34, 'marque_produit', 15, 'print', 1),
(511, 35, 'tva_produit', 1, 'view', 1),
(512, 35, 'tva_produit', 2, 'view_other', 1),
(513, 35, 'tva_produit', 3, 'add', 1),
(514, 35, 'tva_produit', 4, 'edit', 1),
(515, 35, 'tva_produit', 5, 'edit_other', 1),
(516, 35, 'tva_produit', 6, 'delete', 1),
(517, 35, 'tva_produit', 7, 'delete_other', 1),
(518, 35, 'tva_produit', 8, 'lock', 1),
(519, 35, 'tva_produit', 9, 'lock_other', 1),
(520, 35, 'tva_produit', 10, 'view_other_parc', 1),
(521, 35, 'tva_produit', 11, 'audit', 1),
(522, 35, 'tva_produit', 12, 'search', 1),
(523, 35, 'tva_produit', 13, 'export', 1),
(524, 35, 'tva_produit', 14, 'import', 1),
(525, 35, 'tva_produit', 15, 'print', 1),
(526, 36, 'depot_produit', 1, 'view', 1),
(527, 36, 'depot_produit', 2, 'view_other', 1),
(528, 36, 'depot_produit', 3, 'add', 1),
(529, 36, 'depot_produit', 4, 'edit', 1),
(530, 36, 'depot_produit', 5, 'edit_other', 1),
(531, 36, 'depot_produit', 6, 'delete', 1),
(532, 36, 'depot_produit', 7, 'delete_other', 1),
(533, 36, 'depot_produit', 8, 'lock', 1),
(534, 36, 'depot_produit', 9, 'lock_other', 1),
(535, 36, 'depot_produit', 10, 'view_other_parc', 1),
(536, 36, 'depot_produit', 11, 'audit', 1),
(537, 36, 'depot_produit', 12, 'search', 1),
(538, 36, 'depot_produit', 13, 'export', 1),
(539, 36, 'depot_produit', 14, 'import', 1),
(540, 36, 'depot_produit', 15, 'print', 1),
(541, 37, 'bon_entree', 1, 'view', 1),
(542, 37, 'bon_entree', 2, 'view_other', 1),
(543, 37, 'bon_entree', 3, 'add', 1),
(544, 37, 'bon_entree', 4, 'edit', 1),
(545, 37, 'bon_entree', 5, 'edit_other', 1),
(546, 37, 'bon_entree', 6, 'delete', 1),
(547, 37, 'bon_entree', 7, 'delete_other', 1),
(548, 37, 'bon_entree', 8, 'lock', 1),
(549, 37, 'bon_entree', 9, 'lock_other', 1),
(550, 37, 'bon_entree', 10, 'view_other_parc', 1),
(551, 37, 'bon_entree', 11, 'audit', 1),
(552, 37, 'bon_entree', 12, 'search', 1),
(553, 37, 'bon_entree', 13, 'export', 1),
(554, 37, 'bon_entree', 14, 'import', 1),
(555, 37, 'bon_entree', 15, 'print', 1),
(556, 38, 'bon_sortie', 1, 'view', 1),
(557, 38, 'bon_sortie', 2, 'view_other', 1),
(558, 38, 'bon_sortie', 3, 'add', 1),
(559, 38, 'bon_sortie', 4, 'edit', 1),
(560, 38, 'bon_sortie', 5, 'edit_other', 1),
(561, 38, 'bon_sortie', 6, 'delete', 1),
(562, 38, 'bon_sortie', 7, 'delete_other', 1),
(563, 38, 'bon_sortie', 8, 'lock', 1),
(564, 38, 'bon_sortie', 9, 'lock_other', 1),
(565, 38, 'bon_sortie', 10, 'view_other_parc', 1),
(566, 38, 'bon_sortie', 11, 'audit', 1),
(567, 38, 'bon_sortie', 12, 'search', 1),
(568, 38, 'bon_sortie', 13, 'export', 1),
(569, 38, 'bon_sortie', 14, 'import', 1),
(570, 38, 'bon_sortie', 15, 'print', 1),
(571, 39, 'commande_fournisseur', 1, 'view', 1),
(572, 39, 'commande_fournisseur', 2, 'view_other', 1),
(573, 39, 'commande_fournisseur', 3, 'add', 1),
(574, 39, 'commande_fournisseur', 4, 'edit', 1),
(575, 39, 'commande_fournisseur', 5, 'edit_other', 1),
(576, 39, 'commande_fournisseur', 6, 'delete', 1),
(577, 39, 'commande_fournisseur', 7, 'delete_other', 1),
(578, 39, 'commande_fournisseur', 8, 'lock', 1),
(579, 39, 'commande_fournisseur', 9, 'lock_other', 1),
(580, 39, 'commande_fournisseur', 10, 'view_other_parc', 1),
(581, 39, 'commande_fournisseur', 11, 'audit', 1),
(582, 39, 'commande_fournisseur', 12, 'search', 1),
(583, 39, 'commande_fournisseur', 13, 'export', 1),
(584, 39, 'commande_fournisseur', 14, 'import', 1),
(585, 39, 'commande_fournisseur', 15, 'print', 1),
(586, 40, 'pneu', 1, 'view', 1),
(587, 40, 'pneu', 2, 'view_other', 1),
(588, 40, 'pneu', 3, 'add', 1),
(589, 40, 'pneu', 4, 'edit', 1),
(590, 40, 'pneu', 5, 'edit_other', 1),
(591, 40, 'pneu', 6, 'delete', 1),
(592, 40, 'pneu', 7, 'delete_other', 1),
(593, 40, 'pneu', 8, 'lock', 1),
(594, 40, 'pneu', 9, 'lock_other', 1),
(595, 40, 'pneu', 10, 'view_other_parc', 1),
(596, 40, 'pneu', 11, 'audit', 1),
(597, 40, 'pneu', 12, 'search', 1),
(598, 40, 'pneu', 13, 'export', 1),
(599, 40, 'pneu', 14, 'import', 1),
(600, 40, 'pneu', 15, 'print', 1),
(601, 41, 'marque_pneu', 1, 'view', 1),
(602, 41, 'marque_pneu', 2, 'view_other', 1),
(603, 41, 'marque_pneu', 3, 'add', 1),
(604, 41, 'marque_pneu', 4, 'edit', 1),
(605, 41, 'marque_pneu', 5, 'edit_other', 1),
(606, 41, 'marque_pneu', 6, 'delete', 1),
(607, 41, 'marque_pneu', 7, 'delete_other', 1),
(608, 41, 'marque_pneu', 8, 'lock', 1),
(609, 41, 'marque_pneu', 9, 'lock_other', 1),
(610, 41, 'marque_pneu', 10, 'view_other_parc', 1),
(611, 41, 'marque_pneu', 11, 'audit', 1),
(612, 41, 'marque_pneu', 12, 'search', 1),
(613, 41, 'marque_pneu', 13, 'export', 1),
(614, 41, 'marque_pneu', 14, 'import', 1),
(615, 41, 'marque_pneu', 15, 'print', 1),
(616, 42, 'position_pneu', 1, 'view', 1),
(617, 42, 'position_pneu', 2, 'view_other', 1),
(618, 42, 'position_pneu', 3, 'add', 1),
(619, 42, 'position_pneu', 4, 'edit', 1),
(620, 42, 'position_pneu', 5, 'edit_other', 1),
(621, 42, 'position_pneu', 6, 'delete', 1),
(622, 42, 'position_pneu', 7, 'delete_other', 1),
(623, 42, 'position_pneu', 8, 'lock', 1),
(624, 42, 'position_pneu', 9, 'lock_other', 1),
(625, 42, 'position_pneu', 10, 'view_other_parc', 1),
(626, 42, 'position_pneu', 11, 'audit', 1),
(627, 42, 'position_pneu', 12, 'search', 1),
(628, 42, 'position_pneu', 13, 'export', 1),
(629, 42, 'position_pneu', 14, 'import', 1),
(630, 42, 'position_pneu', 15, 'print', 1),
(631, 43, 'emplacement_pneu', 1, 'view', 1),
(632, 43, 'emplacement_pneu', 2, 'view_other', 1),
(633, 43, 'emplacement_pneu', 3, 'add', 1),
(634, 43, 'emplacement_pneu', 4, 'edit', 1),
(635, 43, 'emplacement_pneu', 5, 'edit_other', 1),
(636, 43, 'emplacement_pneu', 6, 'delete', 1),
(637, 43, 'emplacement_pneu', 7, 'delete_other', 1),
(638, 43, 'emplacement_pneu', 8, 'lock', 1),
(639, 43, 'emplacement_pneu', 9, 'lock_other', 1),
(640, 43, 'emplacement_pneu', 10, 'view_other_parc', 1),
(641, 43, 'emplacement_pneu', 11, 'audit', 1),
(642, 43, 'emplacement_pneu', 12, 'search', 1),
(643, 43, 'emplacement_pneu', 13, 'export', 1),
(644, 43, 'emplacement_pneu', 14, 'import', 1),
(645, 43, 'emplacement_pneu', 15, 'print', 1),
(646, 44, 'deplacement_pneu', 1, 'view', 1),
(647, 44, 'deplacement_pneu', 2, 'view_other', 1),
(648, 44, 'deplacement_pneu', 3, 'add', 1),
(649, 44, 'deplacement_pneu', 4, 'edit', 1),
(650, 44, 'deplacement_pneu', 5, 'edit_other', 1),
(651, 44, 'deplacement_pneu', 6, 'delete', 1),
(652, 44, 'deplacement_pneu', 7, 'delete_other', 1),
(653, 44, 'deplacement_pneu', 8, 'lock', 1),
(654, 44, 'deplacement_pneu', 9, 'lock_other', 1),
(655, 44, 'deplacement_pneu', 10, 'view_other_parc', 1),
(656, 44, 'deplacement_pneu', 11, 'audit', 1),
(657, 44, 'deplacement_pneu', 12, 'search', 1),
(658, 44, 'deplacement_pneu', 13, 'export', 1),
(659, 44, 'deplacement_pneu', 14, 'import', 1),
(660, 44, 'deplacement_pneu', 15, 'print', 1),
(661, 45, 'verification_pneu', 1, 'view', 1),
(662, 45, 'verification_pneu', 2, 'view_other', 1),
(663, 45, 'verification_pneu', 3, 'add', 1),
(664, 45, 'verification_pneu', 4, 'edit', 1),
(665, 45, 'verification_pneu', 5, 'edit_other', 1),
(666, 45, 'verification_pneu', 6, 'delete', 1),
(667, 45, 'verification_pneu', 7, 'delete_other', 1),
(668, 45, 'verification_pneu', 8, 'lock', 1),
(669, 45, 'verification_pneu', 9, 'lock_other', 1),
(670, 45, 'verification_pneu', 10, 'view_other_parc', 1),
(671, 45, 'verification_pneu', 11, 'audit', 1),
(672, 45, 'verification_pneu', 12, 'search', 1),
(673, 45, 'verification_pneu', 13, 'export', 1),
(674, 45, 'verification_pneu', 14, 'import', 1),
(675, 45, 'verification_pneu', 15, 'print', 1),
(676, 46, 'extincteur', 1, 'view', 1),
(677, 46, 'extincteur', 2, 'view_other', 1),
(678, 46, 'extincteur', 3, 'add', 1),
(679, 46, 'extincteur', 4, 'edit', 1),
(680, 46, 'extincteur', 5, 'edit_other', 1),
(681, 46, 'extincteur', 6, 'delete', 1),
(682, 46, 'extincteur', 7, 'delete_other', 1),
(683, 46, 'extincteur', 8, 'lock', 1),
(684, 46, 'extincteur', 9, 'lock_other', 1),
(685, 46, 'extincteur', 10, 'view_other_parc', 1),
(686, 46, 'extincteur', 11, 'audit', 1),
(687, 46, 'extincteur', 12, 'search', 1),
(688, 46, 'extincteur', 13, 'export', 1),
(689, 46, 'extincteur', 14, 'import', 1),
(690, 46, 'extincteur', 15, 'print', 1),
(691, 47, 'deplacement_extincteur', 1, 'view', 1),
(692, 47, 'deplacement_extincteur', 2, 'view_other', 1),
(693, 47, 'deplacement_extincteur', 3, 'add', 1),
(694, 47, 'deplacement_extincteur', 4, 'edit', 1),
(695, 47, 'deplacement_extincteur', 5, 'edit_other', 1),
(696, 47, 'deplacement_extincteur', 6, 'delete', 1),
(697, 47, 'deplacement_extincteur', 7, 'delete_other', 1),
(698, 47, 'deplacement_extincteur', 8, 'lock', 1),
(699, 47, 'deplacement_extincteur', 9, 'lock_other', 1),
(700, 47, 'deplacement_extincteur', 10, 'view_other_parc', 1),
(701, 47, 'deplacement_extincteur', 11, 'audit', 1),
(702, 47, 'deplacement_extincteur', 12, 'search', 1),
(703, 47, 'deplacement_extincteur', 13, 'export', 1),
(704, 47, 'deplacement_extincteur', 14, 'import', 1),
(705, 47, 'deplacement_extincteur', 15, 'print', 1),
(706, 48, 'recharge_extincteur', 1, 'view', 1),
(707, 48, 'recharge_extincteur', 2, 'view_other', 1),
(708, 48, 'recharge_extincteur', 3, 'add', 1),
(709, 48, 'recharge_extincteur', 4, 'edit', 1),
(710, 48, 'recharge_extincteur', 5, 'edit_other', 1),
(711, 48, 'recharge_extincteur', 6, 'delete', 1),
(712, 48, 'recharge_extincteur', 7, 'delete_other', 1),
(713, 48, 'recharge_extincteur', 8, 'lock', 1),
(714, 48, 'recharge_extincteur', 9, 'lock_other', 1),
(715, 48, 'recharge_extincteur', 10, 'view_other_parc', 1),
(716, 48, 'recharge_extincteur', 11, 'audit', 1),
(717, 48, 'recharge_extincteur', 12, 'search', 1),
(718, 48, 'recharge_extincteur', 13, 'export', 1),
(719, 48, 'recharge_extincteur', 14, 'import', 1),
(720, 48, 'recharge_extincteur', 15, 'print', 1),
(736, 50, 'type_evenement', 1, 'view', 1),
(737, 50, 'type_evenement', 2, 'view_other', 1),
(738, 50, 'type_evenement', 3, 'add', 1),
(739, 50, 'type_evenement', 4, 'edit', 1),
(740, 50, 'type_evenement', 5, 'edit_other', 1),
(741, 50, 'type_evenement', 6, 'delete', 1),
(742, 50, 'type_evenement', 7, 'delete_other', 1),
(743, 50, 'type_evenement', 8, 'lock', 1),
(744, 50, 'type_evenement', 9, 'lock_other', 1),
(745, 50, 'type_evenement', 10, 'view_other_parc', 1),
(746, 50, 'type_evenement', 11, 'audit', 1),
(747, 50, 'type_evenement', 12, 'search', 1),
(748, 50, 'type_evenement', 13, 'export', 1),
(749, 50, 'type_evenement', 14, 'import', 1),
(750, 50, 'type_evenement', 15, 'print', 1),
(751, 51, 'type_intervenant', 1, 'view', 1),
(752, 51, 'type_intervenant', 2, 'view_other', 1),
(753, 51, 'type_intervenant', 3, 'add', 1),
(754, 51, 'type_intervenant', 4, 'edit', 1),
(755, 51, 'type_intervenant', 5, 'edit_other', 1),
(756, 51, 'type_intervenant', 6, 'delete', 1),
(757, 51, 'type_intervenant', 7, 'delete_other', 1),
(758, 51, 'type_intervenant', 8, 'lock', 1),
(759, 51, 'type_intervenant', 9, 'lock_other', 1),
(760, 51, 'type_intervenant', 10, 'view_other_parc', 1),
(761, 51, 'type_intervenant', 11, 'audit', 1),
(762, 51, 'type_intervenant', 12, 'search', 1),
(763, 51, 'type_intervenant', 13, 'export', 1),
(764, 51, 'type_intervenant', 14, 'import', 1),
(765, 51, 'type_intervenant', 15, 'print', 1),
(766, 52, 'intervenant', 1, 'view', 1),
(767, 52, 'intervenant', 2, 'view_other', 1),
(768, 52, 'intervenant', 3, 'add', 1),
(769, 52, 'intervenant', 4, 'edit', 1),
(770, 52, 'intervenant', 5, 'edit_other', 1),
(771, 52, 'intervenant', 6, 'delete', 1),
(772, 52, 'intervenant', 7, 'delete_other', 1),
(773, 52, 'intervenant', 8, 'lock', 1),
(774, 52, 'intervenant', 9, 'lock_other', 1),
(775, 52, 'intervenant', 10, 'view_other_parc', 1),
(776, 52, 'intervenant', 11, 'audit', 1),
(777, 52, 'intervenant', 12, 'search', 1),
(778, 52, 'intervenant', 13, 'export', 1),
(779, 52, 'intervenant', 14, 'import', 1),
(780, 52, 'intervenant', 15, 'print', 1),
(781, 53, 'administratif_evenement', 1, 'view', 1),
(782, 53, 'administratif_evenement', 2, 'view_other', 1),
(783, 53, 'administratif_evenement', 3, 'add', 1),
(784, 53, 'administratif_evenement', 4, 'edit', 1),
(785, 53, 'administratif_evenement', 5, 'edit_other', 1),
(786, 53, 'administratif_evenement', 6, 'delete', 1),
(787, 53, 'administratif_evenement', 7, 'delete_other', 1),
(788, 53, 'administratif_evenement', 8, 'lock', 1),
(789, 53, 'administratif_evenement', 9, 'lock_other', 1),
(790, 53, 'administratif_evenement', 10, 'view_other_parc', 1),
(791, 53, 'administratif_evenement', 11, 'audit', 1),
(792, 53, 'administratif_evenement', 12, 'search', 1),
(793, 53, 'administratif_evenement', 13, 'export', 1),
(794, 53, 'administratif_evenement', 14, 'import', 1),
(795, 53, 'administratif_evenement', 15, 'print', 1),
(796, 54, 'maintenance_evenement', 1, 'view', 1),
(797, 54, 'maintenance_evenement', 2, 'view_other', 1),
(798, 54, 'maintenance_evenement', 3, 'add', 1),
(799, 54, 'maintenance_evenement', 4, 'edit', 1),
(800, 54, 'maintenance_evenement', 5, 'edit_other', 1),
(801, 54, 'maintenance_evenement', 6, 'delete', 1),
(802, 54, 'maintenance_evenement', 7, 'delete_other', 1),
(803, 54, 'maintenance_evenement', 8, 'lock', 1),
(804, 54, 'maintenance_evenement', 9, 'lock_other', 1),
(805, 54, 'maintenance_evenement', 10, 'view_other_parc', 1),
(806, 54, 'maintenance_evenement', 11, 'audit', 1),
(807, 54, 'maintenance_evenement', 12, 'search', 1),
(808, 54, 'maintenance_evenement', 13, 'export', 1),
(809, 54, 'maintenance_evenement', 14, 'import', 1),
(810, 54, 'maintenance_evenement', 15, 'print', 1),
(811, 55, 'demande_intervention', 1, 'view', 1),
(812, 55, 'demande_intervention', 2, 'view_other', 1),
(813, 55, 'demande_intervention', 3, 'add', 1),
(814, 55, 'demande_intervention', 4, 'edit', 1),
(815, 55, 'demande_intervention', 5, 'edit_other', 1),
(816, 55, 'demande_intervention', 6, 'delete', 1),
(817, 55, 'demande_intervention', 7, 'delete_other', 1),
(818, 55, 'demande_intervention', 8, 'lock', 1),
(819, 55, 'demande_intervention', 9, 'lock_other', 1),
(820, 55, 'demande_intervention', 10, 'view_other_parc', 1),
(821, 55, 'demande_intervention', 11, 'audit', 1),
(822, 55, 'demande_intervention', 12, 'search', 1),
(823, 55, 'demande_intervention', 13, 'export', 1),
(824, 55, 'demande_intervention', 14, 'import', 1),
(825, 55, 'demande_intervention', 15, 'print', 1),
(826, 57, 'marchandise', 1, 'view', 1),
(827, 57, 'marchandise', 2, 'view_other', 1),
(828, 57, 'marchandise', 3, 'add', 1),
(829, 57, 'marchandise', 4, 'edit', 1),
(830, 57, 'marchandise', 5, 'edit_other', 1),
(831, 57, 'marchandise', 6, 'delete', 1),
(832, 57, 'marchandise', 7, 'delete_other', 1),
(833, 57, 'marchandise', 8, 'lock', 1),
(834, 57, 'marchandise', 9, 'lock_other', 1),
(835, 57, 'marchandise', 10, 'view_other_parc', 1),
(836, 57, 'marchandise', 11, 'audit', 1),
(837, 57, 'marchandise', 12, 'search', 1),
(838, 57, 'marchandise', 13, 'export', 1),
(839, 57, 'marchandise', 14, 'import', 1),
(840, 57, 'marchandise', 15, 'print', 1),
(841, 58, 'type_marchandise', 1, 'view', 1),
(842, 58, 'type_marchandise', 2, 'view_other', 1),
(843, 58, 'type_marchandise', 3, 'add', 1),
(844, 58, 'type_marchandise', 4, 'edit', 1),
(845, 58, 'type_marchandise', 5, 'edit_other', 1),
(846, 58, 'type_marchandise', 6, 'delete', 1),
(847, 58, 'type_marchandise', 7, 'delete_other', 1),
(848, 58, 'type_marchandise', 8, 'lock', 1),
(849, 58, 'type_marchandise', 9, 'lock_other', 1),
(850, 58, 'type_marchandise', 10, 'view_other_parc', 1),
(851, 58, 'type_marchandise', 11, 'audit', 1),
(852, 58, 'type_marchandise', 12, 'search', 1),
(853, 58, 'type_marchandise', 13, 'export', 1),
(854, 58, 'type_marchandise', 14, 'import', 1),
(855, 58, 'type_marchandise', 15, 'print', 1),
(856, 59, 'unite_marchandise', 1, 'view', 1),
(857, 59, 'unite_marchandise', 2, 'view_other', 1),
(858, 59, 'unite_marchandise', 3, 'add', 1),
(859, 59, 'unite_marchandise', 4, 'edit', 1),
(860, 59, 'unite_marchandise', 5, 'edit_other', 1),
(861, 59, 'unite_marchandise', 6, 'delete', 1),
(862, 59, 'unite_marchandise', 7, 'delete_other', 1),
(863, 59, 'unite_marchandise', 8, 'lock', 1),
(864, 59, 'unite_marchandise', 9, 'lock_other', 1),
(865, 59, 'unite_marchandise', 10, 'view_other_parc', 1),
(866, 59, 'unite_marchandise', 11, 'audit', 1),
(867, 59, 'unite_marchandise', 12, 'search', 1),
(868, 59, 'unite_marchandise', 13, 'export', 1),
(869, 59, 'unite_marchandise', 14, 'import', 1),
(870, 59, 'unite_marchandise', 15, 'print', 1),
(871, 60, 'trajet', 1, 'view', 1),
(872, 60, 'trajet', 2, 'view_other', 1),
(873, 60, 'trajet', 3, 'add', 1),
(874, 60, 'trajet', 4, 'edit', 1),
(875, 60, 'trajet', 5, 'edit_other', 1),
(876, 60, 'trajet', 6, 'delete', 1),
(877, 60, 'trajet', 7, 'delete_other', 1),
(878, 60, 'trajet', 8, 'lock', 1),
(879, 60, 'trajet', 9, 'lock_other', 1),
(880, 60, 'trajet', 10, 'view_other_parc', 1),
(881, 60, 'trajet', 11, 'audit', 1),
(882, 60, 'trajet', 12, 'search', 1),
(883, 60, 'trajet', 13, 'export', 1),
(884, 60, 'trajet', 14, 'import', 1),
(885, 60, 'trajet', 15, 'print', 1),
(886, 61, 'villes_trajet', 1, 'view', 1),
(887, 61, 'villes_trajet', 2, 'view_other', 1),
(888, 61, 'villes_trajet', 3, 'add', 1),
(889, 61, 'villes_trajet', 4, 'edit', 1),
(890, 61, 'villes_trajet', 5, 'edit_other', 1),
(891, 61, 'villes_trajet', 6, 'delete', 1),
(892, 61, 'villes_trajet', 7, 'delete_other', 1),
(893, 61, 'villes_trajet', 8, 'lock', 1),
(894, 61, 'villes_trajet', 9, 'lock_other', 1),
(895, 61, 'villes_trajet', 10, 'view_other_parc', 1),
(896, 61, 'villes_trajet', 11, 'audit', 1),
(897, 61, 'villes_trajet', 12, 'search', 1),
(898, 61, 'villes_trajet', 13, 'export', 1),
(899, 61, 'villes_trajet', 14, 'import', 1),
(900, 61, 'villes_trajet', 15, 'print', 1),
(901, 62, 'wilaya', 1, 'view', 1),
(902, 62, 'wilaya', 2, 'view_other', 1),
(903, 62, 'wilaya', 3, 'add', 1),
(904, 62, 'wilaya', 4, 'edit', 1),
(905, 62, 'wilaya', 5, 'edit_other', 1),
(906, 62, 'wilaya', 6, 'delete', 1),
(907, 62, 'wilaya', 7, 'delete_other', 1),
(908, 62, 'wilaya', 8, 'lock', 1),
(909, 62, 'wilaya', 9, 'lock_other', 1),
(910, 62, 'wilaya', 10, 'view_other_parc', 1),
(911, 62, 'wilaya', 11, 'audit', 1),
(912, 62, 'wilaya', 12, 'search', 1),
(913, 62, 'wilaya', 13, 'export', 1),
(914, 62, 'wilaya', 14, 'import', 1),
(915, 62, 'wilaya', 15, 'print', 1),
(916, 63, 'daira', 1, 'view', 1),
(917, 63, 'daira', 2, 'view_other', 1),
(918, 63, 'daira', 3, 'add', 1),
(919, 63, 'daira', 4, 'edit', 1),
(920, 63, 'daira', 5, 'edit_other', 1),
(921, 63, 'daira', 6, 'delete', 1),
(922, 63, 'daira', 7, 'delete_other', 1),
(923, 63, 'daira', 8, 'lock', 1),
(924, 63, 'daira', 9, 'lock_other', 1),
(925, 63, 'daira', 10, 'view_other_parc', 1),
(926, 63, 'daira', 11, 'audit', 1),
(927, 63, 'daira', 12, 'search', 1),
(928, 63, 'daira', 13, 'export', 1),
(929, 63, 'daira', 14, 'import', 1),
(930, 63, 'daira', 15, 'print', 1),
(931, 64, 'categorie_trajet', 1, 'view', 1),
(932, 64, 'categorie_trajet', 2, 'view_other', 1),
(933, 64, 'categorie_trajet', 3, 'add', 1),
(934, 64, 'categorie_trajet', 4, 'edit', 1),
(935, 64, 'categorie_trajet', 5, 'edit_other', 1),
(936, 64, 'categorie_trajet', 6, 'delete', 1),
(937, 64, 'categorie_trajet', 7, 'delete_other', 1),
(938, 64, 'categorie_trajet', 8, 'lock', 1),
(939, 64, 'categorie_trajet', 9, 'lock_other', 1),
(940, 64, 'categorie_trajet', 10, 'view_other_parc', 1),
(941, 64, 'categorie_trajet', 11, 'audit', 1),
(942, 64, 'categorie_trajet', 12, 'search', 1),
(943, 64, 'categorie_trajet', 13, 'export', 1),
(944, 64, 'categorie_trajet', 14, 'import', 1),
(945, 64, 'categorie_trajet', 15, 'print', 1),
(946, 65, 'detail_trajet', 1, 'view', 1),
(947, 65, 'detail_trajet', 2, 'view_other', 1),
(948, 65, 'detail_trajet', 3, 'add', 1),
(949, 65, 'detail_trajet', 4, 'edit', 1),
(950, 65, 'detail_trajet', 5, 'edit_other', 1),
(951, 65, 'detail_trajet', 6, 'delete', 1),
(952, 65, 'detail_trajet', 7, 'delete_other', 1),
(953, 65, 'detail_trajet', 8, 'lock', 1),
(954, 65, 'detail_trajet', 9, 'lock_other', 1),
(955, 65, 'detail_trajet', 10, 'view_other_parc', 1),
(956, 65, 'detail_trajet', 11, 'audit', 1),
(957, 65, 'detail_trajet', 12, 'search', 1),
(958, 65, 'detail_trajet', 13, 'export', 1),
(959, 65, 'detail_trajet', 14, 'import', 1),
(960, 65, 'detail_trajet', 15, 'print', 1),
(961, 66, 'tarif_trajet', 1, 'view', 1),
(962, 66, 'tarif_trajet', 2, 'view_other', 1),
(963, 66, 'tarif_trajet', 3, 'add', 1),
(964, 66, 'tarif_trajet', 4, 'edit', 1),
(965, 66, 'tarif_trajet', 5, 'edit_other', 1),
(966, 66, 'tarif_trajet', 6, 'delete', 1),
(967, 66, 'tarif_trajet', 7, 'delete_other', 1),
(968, 66, 'tarif_trajet', 8, 'lock', 1),
(969, 66, 'tarif_trajet', 9, 'lock_other', 1),
(970, 66, 'tarif_trajet', 10, 'view_other_parc', 1),
(971, 66, 'tarif_trajet', 11, 'audit', 1),
(972, 66, 'tarif_trajet', 12, 'search', 1),
(973, 66, 'tarif_trajet', 13, 'export', 1),
(974, 66, 'tarif_trajet', 14, 'import', 1),
(975, 66, 'tarif_trajet', 15, 'print', 1),
(976, 68, 'feuille_de_route', 1, 'view', 1),
(977, 68, 'feuille_de_route', 2, 'view_other', 1),
(978, 68, 'feuille_de_route', 3, 'add', 1),
(979, 68, 'feuille_de_route', 4, 'edit', 1),
(980, 68, 'feuille_de_route', 5, 'edit_other', 1),
(981, 68, 'feuille_de_route', 6, 'delete', 1),
(982, 68, 'feuille_de_route', 7, 'delete_other', 1),
(983, 68, 'feuille_de_route', 8, 'lock', 1),
(984, 68, 'feuille_de_route', 9, 'lock_other', 1),
(985, 68, 'feuille_de_route', 10, 'view_other_parc', 1),
(986, 68, 'feuille_de_route', 11, 'audit', 1),
(987, 68, 'feuille_de_route', 12, 'search', 1),
(988, 68, 'feuille_de_route', 13, 'export', 1),
(989, 68, 'feuille_de_route', 14, 'import', 1),
(990, 68, 'feuille_de_route', 15, 'print', 1),
(991, 69, 'mission', 1, 'view', 1),
(992, 69, 'mission', 2, 'view_other', 1),
(993, 69, 'mission', 3, 'add', 1),
(994, 69, 'mission', 4, 'edit', 1),
(995, 69, 'mission', 5, 'edit_other', 1),
(996, 69, 'mission', 6, 'delete', 1),
(997, 69, 'mission', 7, 'delete_other', 1),
(998, 69, 'mission', 8, 'lock', 1),
(999, 69, 'mission', 9, 'lock_other', 1),
(1000, 69, 'mission', 10, 'view_other_parc', 1),
(1001, 69, 'mission', 11, 'audit', 1),
(1002, 69, 'mission', 12, 'search', 1),
(1003, 69, 'mission', 13, 'export', 1),
(1004, 69, 'mission', 14, 'import', 1),
(1005, 69, 'mission', 15, 'print', 1),
(1006, 70, 'piece_jointe_mission', 1, 'view', 1),
(1007, 70, 'piece_jointe_mission', 2, 'view_other', 1),
(1008, 70, 'piece_jointe_mission', 3, 'add', 1),
(1009, 70, 'piece_jointe_mission', 4, 'edit', 1),
(1010, 70, 'piece_jointe_mission', 5, 'edit_other', 1),
(1011, 70, 'piece_jointe_mission', 6, 'delete', 1),
(1012, 70, 'piece_jointe_mission', 7, 'delete_other', 1),
(1013, 70, 'piece_jointe_mission', 8, 'lock', 1),
(1014, 70, 'piece_jointe_mission', 9, 'lock_other', 1),
(1015, 70, 'piece_jointe_mission', 10, 'view_other_parc', 1),
(1016, 70, 'piece_jointe_mission', 11, 'audit', 1),
(1017, 70, 'piece_jointe_mission', 12, 'search', 1),
(1018, 70, 'piece_jointe_mission', 13, 'export', 1),
(1019, 70, 'piece_jointe_mission', 14, 'import', 1),
(1020, 70, 'piece_jointe_mission', 15, 'print', 1),
(1021, 71, 'marchandise_mission', 1, 'view', 1),
(1022, 71, 'marchandise_mission', 2, 'view_other', 0),
(1023, 71, 'marchandise_mission', 3, 'add', 0),
(1024, 71, 'marchandise_mission', 4, 'edit', 0),
(1025, 71, 'marchandise_mission', 5, 'edit_other', 0),
(1026, 71, 'marchandise_mission', 6, 'delete', 0),
(1027, 71, 'marchandise_mission', 7, 'delete_other', 0),
(1028, 71, 'marchandise_mission', 8, 'lock', 0),
(1029, 71, 'marchandise_mission', 9, 'lock_other', 0),
(1030, 71, 'marchandise_mission', 10, 'view_other_parc', 0),
(1031, 71, 'marchandise_mission', 11, 'audit', 0),
(1032, 71, 'marchandise_mission', 12, 'search', 0),
(1033, 71, 'marchandise_mission', 13, 'export', 0),
(1034, 71, 'marchandise_mission', 14, 'import', 0),
(1035, 71, 'marchandise_mission', 15, 'print', 0),
(1036, 73, 'client', 1, 'view', 1),
(1037, 73, 'client', 2, 'view_other', 1),
(1038, 73, 'client', 3, 'add', 1),
(1039, 73, 'client', 4, 'edit', 1),
(1040, 73, 'client', 5, 'edit_other', 1),
(1041, 73, 'client', 6, 'delete', 1),
(1042, 73, 'client', 7, 'delete_other', 1),
(1043, 73, 'client', 8, 'lock', 1),
(1044, 73, 'client', 9, 'lock_other', 1),
(1045, 73, 'client', 10, 'view_other_parc', 1),
(1046, 73, 'client', 11, 'audit', 1),
(1047, 73, 'client', 12, 'search', 1),
(1048, 73, 'client', 13, 'export', 1),
(1049, 73, 'client', 14, 'import', 1),
(1050, 73, 'client', 15, 'print', 1),
(1051, 74, 'importation_adresse_client', 1, 'view', 1),
(1052, 74, 'importation_adresse_client', 2, 'view_other', 0),
(1053, 74, 'importation_adresse_client', 3, 'add', 0),
(1054, 74, 'importation_adresse_client', 4, 'edit', 0),
(1055, 74, 'importation_adresse_client', 5, 'edit_other', 0),
(1056, 74, 'importation_adresse_client', 6, 'delete', 0),
(1057, 74, 'importation_adresse_client', 7, 'delete_other', 0),
(1058, 74, 'importation_adresse_client', 8, 'lock', 0),
(1059, 74, 'importation_adresse_client', 9, 'lock_other', 0),
(1060, 74, 'importation_adresse_client', 10, 'view_other_parc', 0),
(1061, 74, 'importation_adresse_client', 11, 'audit', 0),
(1062, 74, 'importation_adresse_client', 12, 'search', 0),
(1063, 74, 'importation_adresse_client', 13, 'export', 0),
(1064, 74, 'importation_adresse_client', 14, 'import', 0),
(1065, 74, 'importation_adresse_client', 15, 'print', 0),
(1066, 75, 'importation_contact_client', 1, 'view', 1),
(1067, 75, 'importation_contact_client', 2, 'view_other', 0),
(1068, 75, 'importation_contact_client', 3, 'add', 0),
(1069, 75, 'importation_contact_client', 4, 'edit', 0),
(1070, 75, 'importation_contact_client', 5, 'edit_other', 0),
(1071, 75, 'importation_contact_client', 6, 'delete', 0),
(1072, 75, 'importation_contact_client', 7, 'delete_other', 0),
(1073, 75, 'importation_contact_client', 8, 'lock', 0),
(1074, 75, 'importation_contact_client', 9, 'lock_other', 0),
(1075, 75, 'importation_contact_client', 10, 'view_other_parc', 0),
(1076, 75, 'importation_contact_client', 11, 'audit', 0),
(1077, 75, 'importation_contact_client', 12, 'search', 0),
(1078, 75, 'importation_contact_client', 13, 'export', 0),
(1079, 75, 'importation_contact_client', 14, 'import', 0),
(1080, 75, 'importation_contact_client', 15, 'print', 0),
(1081, 76, 'categorie_client', 1, 'view', 1),
(1082, 76, 'categorie_client', 2, 'view_other', 1),
(1083, 76, 'categorie_client', 3, 'add', 1),
(1084, 76, 'categorie_client', 4, 'edit', 1),
(1085, 76, 'categorie_client', 5, 'edit_other', 1),
(1086, 76, 'categorie_client', 6, 'delete', 1),
(1087, 76, 'categorie_client', 7, 'delete_other', 1),
(1088, 76, 'categorie_client', 8, 'lock', 1),
(1089, 76, 'categorie_client', 9, 'lock_other', 1),
(1090, 76, 'categorie_client', 10, 'view_other_parc', 1),
(1091, 76, 'categorie_client', 11, 'audit', 1),
(1092, 76, 'categorie_client', 12, 'search', 1),
(1093, 76, 'categorie_client', 13, 'export', 1),
(1094, 76, 'categorie_client', 14, 'import', 1),
(1095, 76, 'categorie_client', 15, 'print', 1),
(1096, 77, 'demande_de_devis', 1, 'view', 1),
(1097, 77, 'demande_de_devis', 2, 'view_other', 1),
(1098, 77, 'demande_de_devis', 3, 'add', 1),
(1099, 77, 'demande_de_devis', 4, 'edit', 1),
(1100, 77, 'demande_de_devis', 5, 'edit_other', 1),
(1101, 77, 'demande_de_devis', 6, 'delete', 1),
(1102, 77, 'demande_de_devis', 7, 'delete_other', 1),
(1103, 77, 'demande_de_devis', 8, 'lock', 1),
(1104, 77, 'demande_de_devis', 9, 'lock_other', 1),
(1105, 77, 'demande_de_devis', 10, 'view_other_parc', 1),
(1106, 77, 'demande_de_devis', 11, 'audit', 1),
(1107, 77, 'demande_de_devis', 12, 'search', 1),
(1108, 77, 'demande_de_devis', 13, 'export', 1),
(1109, 77, 'demande_de_devis', 14, 'import', 1),
(1110, 77, 'demande_de_devis', 15, 'print', 1),
(1111, 78, 'transformer_demande_devis', 1, 'view', 1),
(1112, 78, 'transformer_demande_devis', 2, 'view_other', 0),
(1113, 78, 'transformer_demande_devis', 3, 'add', 0),
(1114, 78, 'transformer_demande_devis', 4, 'edit', 0),
(1115, 78, 'transformer_demande_devis', 5, 'edit_other', 0),
(1116, 78, 'transformer_demande_devis', 6, 'delete', 0),
(1117, 78, 'transformer_demande_devis', 7, 'delete_other', 0),
(1118, 78, 'transformer_demande_devis', 8, 'lock', 0),
(1119, 78, 'transformer_demande_devis', 9, 'lock_other', 0),
(1120, 78, 'transformer_demande_devis', 10, 'view_other_parc', 0),
(1121, 78, 'transformer_demande_devis', 11, 'audit', 0),
(1122, 78, 'transformer_demande_devis', 12, 'search', 0);
INSERT INTO `section_actions` (`id`, `section_id`, `code_section`, `action_id`, `code_action`, `value`) VALUES
(1123, 78, 'transformer_demande_devis', 13, 'export', 0),
(1124, 78, 'transformer_demande_devis', 14, 'import', 0),
(1125, 78, 'transformer_demande_devis', 15, 'print', 0),
(1126, 79, 'devis', 1, 'view', 1),
(1127, 79, 'devis', 2, 'view_other', 1),
(1128, 79, 'devis', 3, 'add', 1),
(1129, 79, 'devis', 4, 'edit', 1),
(1130, 79, 'devis', 5, 'edit_other', 1),
(1131, 79, 'devis', 6, 'delete', 1),
(1132, 79, 'devis', 7, 'delete_other', 1),
(1133, 79, 'devis', 8, 'lock', 1),
(1134, 79, 'devis', 9, 'lock_other', 1),
(1135, 79, 'devis', 10, 'view_other_parc', 1),
(1136, 79, 'devis', 11, 'audit', 1),
(1137, 79, 'devis', 12, 'search', 1),
(1138, 79, 'devis', 13, 'export', 1),
(1139, 79, 'devis', 14, 'import', 1),
(1140, 79, 'devis', 15, 'print', 1),
(1141, 80, 'transformer_devis', 1, 'view', 1),
(1142, 80, 'transformer_devis', 2, 'view_other', 0),
(1143, 80, 'transformer_devis', 3, 'add', 0),
(1144, 80, 'transformer_devis', 4, 'edit', 0),
(1145, 80, 'transformer_devis', 5, 'edit_other', 0),
(1146, 80, 'transformer_devis', 6, 'delete', 0),
(1147, 80, 'transformer_devis', 7, 'delete_other', 0),
(1148, 80, 'transformer_devis', 8, 'lock', 0),
(1149, 80, 'transformer_devis', 9, 'lock_other', 0),
(1150, 80, 'transformer_devis', 10, 'view_other_parc', 0),
(1151, 80, 'transformer_devis', 11, 'audit', 0),
(1152, 80, 'transformer_devis', 12, 'search', 0),
(1153, 80, 'transformer_devis', 13, 'export', 0),
(1154, 80, 'transformer_devis', 14, 'import', 0),
(1155, 80, 'transformer_devis', 15, 'print', 0),
(1156, 81, 'relancer_devis', 1, 'view', 1),
(1157, 81, 'relancer_devis', 2, 'view_other', 0),
(1158, 81, 'relancer_devis', 3, 'add', 0),
(1159, 81, 'relancer_devis', 4, 'edit', 0),
(1160, 81, 'relancer_devis', 5, 'edit_other', 0),
(1161, 81, 'relancer_devis', 6, 'delete', 0),
(1162, 81, 'relancer_devis', 7, 'delete_other', 0),
(1163, 81, 'relancer_devis', 8, 'lock', 0),
(1164, 81, 'relancer_devis', 9, 'lock_other', 0),
(1165, 81, 'relancer_devis', 10, 'view_other_parc', 0),
(1166, 81, 'relancer_devis', 11, 'audit', 0),
(1167, 81, 'relancer_devis', 12, 'search', 0),
(1168, 81, 'relancer_devis', 13, 'export', 0),
(1169, 81, 'relancer_devis', 14, 'import', 0),
(1170, 81, 'relancer_devis', 15, 'print', 0),
(1171, 82, 'dupliquer_devis', 1, 'view', 1),
(1172, 82, 'dupliquer_devis', 2, 'view_other', 0),
(1173, 82, 'dupliquer_devis', 3, 'add', 0),
(1174, 82, 'dupliquer_devis', 4, 'edit', 0),
(1175, 82, 'dupliquer_devis', 5, 'edit_other', 0),
(1176, 82, 'dupliquer_devis', 6, 'delete', 0),
(1177, 82, 'dupliquer_devis', 7, 'delete_other', 0),
(1178, 82, 'dupliquer_devis', 8, 'lock', 0),
(1179, 82, 'dupliquer_devis', 9, 'lock_other', 0),
(1180, 82, 'dupliquer_devis', 10, 'view_other_parc', 0),
(1181, 82, 'dupliquer_devis', 11, 'audit', 0),
(1182, 82, 'dupliquer_devis', 12, 'search', 0),
(1183, 82, 'dupliquer_devis', 13, 'export', 0),
(1184, 82, 'dupliquer_devis', 14, 'import', 0),
(1185, 82, 'dupliquer_devis', 15, 'print', 0),
(1186, 83, 'envoyer_devis_mail', 1, 'view', 1),
(1187, 83, 'envoyer_devis_mail', 2, 'view_other', 0),
(1188, 83, 'envoyer_devis_mail', 3, 'add', 0),
(1189, 83, 'envoyer_devis_mail', 4, 'edit', 0),
(1190, 83, 'envoyer_devis_mail', 5, 'edit_other', 0),
(1191, 83, 'envoyer_devis_mail', 6, 'delete', 0),
(1192, 83, 'envoyer_devis_mail', 7, 'delete_other', 0),
(1193, 83, 'envoyer_devis_mail', 8, 'lock', 0),
(1194, 83, 'envoyer_devis_mail', 9, 'lock_other', 0),
(1195, 83, 'envoyer_devis_mail', 10, 'view_other_parc', 0),
(1196, 83, 'envoyer_devis_mail', 11, 'audit', 0),
(1197, 83, 'envoyer_devis_mail', 12, 'search', 0),
(1198, 83, 'envoyer_devis_mail', 13, 'export', 0),
(1199, 83, 'envoyer_devis_mail', 14, 'import', 0),
(1200, 83, 'envoyer_devis_mail', 15, 'print', 0),
(1201, 84, 'commande_client', 1, 'view', 1),
(1202, 84, 'commande_client', 2, 'view_other', 1),
(1203, 84, 'commande_client', 3, 'add', 1),
(1204, 84, 'commande_client', 4, 'edit', 1),
(1205, 84, 'commande_client', 5, 'edit_other', 1),
(1206, 84, 'commande_client', 6, 'delete', 1),
(1207, 84, 'commande_client', 7, 'delete_other', 1),
(1208, 84, 'commande_client', 8, 'lock', 1),
(1209, 84, 'commande_client', 9, 'lock_other', 1),
(1210, 84, 'commande_client', 10, 'view_other_parc', 1),
(1211, 84, 'commande_client', 11, 'audit', 1),
(1212, 84, 'commande_client', 12, 'search', 1),
(1213, 84, 'commande_client', 13, 'export', 1),
(1214, 84, 'commande_client', 14, 'import', 1),
(1215, 84, 'commande_client', 15, 'print', 1),
(1216, 85, 'transformer_commande_client', 1, 'view', 1),
(1217, 85, 'transformer_commande_client', 2, 'view_other', 0),
(1218, 85, 'transformer_commande_client', 3, 'add', 0),
(1219, 85, 'transformer_commande_client', 4, 'edit', 0),
(1220, 85, 'transformer_commande_client', 5, 'edit_other', 0),
(1221, 85, 'transformer_commande_client', 6, 'delete', 0),
(1222, 85, 'transformer_commande_client', 7, 'delete_other', 0),
(1223, 85, 'transformer_commande_client', 8, 'lock', 0),
(1224, 85, 'transformer_commande_client', 9, 'lock_other', 0),
(1225, 85, 'transformer_commande_client', 10, 'view_other_parc', 0),
(1226, 85, 'transformer_commande_client', 11, 'audit', 0),
(1227, 85, 'transformer_commande_client', 12, 'search', 0),
(1228, 85, 'transformer_commande_client', 13, 'export', 0),
(1229, 85, 'transformer_commande_client', 14, 'import', 0),
(1230, 85, 'transformer_commande_client', 15, 'print', 0),
(1231, 86, 'detail_commande_client', 1, 'view', 1),
(1232, 86, 'detail_commande_client', 2, 'view_other', 0),
(1233, 86, 'detail_commande_client', 3, 'add', 0),
(1234, 86, 'detail_commande_client', 4, 'edit', 0),
(1235, 86, 'detail_commande_client', 5, 'edit_other', 0),
(1236, 86, 'detail_commande_client', 6, 'delete', 0),
(1237, 86, 'detail_commande_client', 7, 'delete_other', 0),
(1238, 86, 'detail_commande_client', 8, 'lock', 0),
(1239, 86, 'detail_commande_client', 9, 'lock_other', 0),
(1240, 86, 'detail_commande_client', 10, 'view_other_parc', 0),
(1241, 86, 'detail_commande_client', 11, 'audit', 0),
(1242, 86, 'detail_commande_client', 12, 'search', 0),
(1243, 86, 'detail_commande_client', 13, 'export', 0),
(1244, 86, 'detail_commande_client', 14, 'import', 0),
(1245, 86, 'detail_commande_client', 15, 'print', 0),
(1246, 87, 'prefacture', 1, 'view', 1),
(1247, 87, 'prefacture', 2, 'view_other', 1),
(1248, 87, 'prefacture', 3, 'add', 1),
(1249, 87, 'prefacture', 4, 'edit', 1),
(1250, 87, 'prefacture', 5, 'edit_other', 1),
(1251, 87, 'prefacture', 6, 'delete', 1),
(1252, 87, 'prefacture', 7, 'delete_other', 1),
(1253, 87, 'prefacture', 8, 'lock', 1),
(1254, 87, 'prefacture', 9, 'lock_other', 1),
(1255, 87, 'prefacture', 10, 'view_other_parc', 1),
(1256, 87, 'prefacture', 11, 'audit', 1),
(1257, 87, 'prefacture', 12, 'search', 1),
(1258, 87, 'prefacture', 13, 'export', 1),
(1259, 87, 'prefacture', 14, 'import', 1),
(1260, 87, 'prefacture', 15, 'print', 1),
(1261, 88, 'transformer_prefacture', 1, 'view', 1),
(1262, 88, 'transformer_prefacture', 2, 'view_other', 0),
(1263, 88, 'transformer_prefacture', 3, 'add', 0),
(1264, 88, 'transformer_prefacture', 4, 'edit', 0),
(1265, 88, 'transformer_prefacture', 5, 'edit_other', 0),
(1266, 88, 'transformer_prefacture', 6, 'delete', 0),
(1267, 88, 'transformer_prefacture', 7, 'delete_other', 0),
(1268, 88, 'transformer_prefacture', 8, 'lock', 0),
(1269, 88, 'transformer_prefacture', 9, 'lock_other', 0),
(1270, 88, 'transformer_prefacture', 10, 'view_other_parc', 0),
(1271, 88, 'transformer_prefacture', 11, 'audit', 0),
(1272, 88, 'transformer_prefacture', 12, 'search', 0),
(1273, 88, 'transformer_prefacture', 13, 'export', 0),
(1274, 88, 'transformer_prefacture', 14, 'import', 0),
(1275, 88, 'transformer_prefacture', 15, 'print', 0),
(1276, 89, 'paiement_prefacture', 1, 'view', 1),
(1277, 89, 'paiement_prefacture', 2, 'view_other', 0),
(1278, 89, 'paiement_prefacture', 3, 'add', 0),
(1279, 89, 'paiement_prefacture', 4, 'edit', 0),
(1280, 89, 'paiement_prefacture', 5, 'edit_other', 0),
(1281, 89, 'paiement_prefacture', 6, 'delete', 0),
(1282, 89, 'paiement_prefacture', 7, 'delete_other', 0),
(1283, 89, 'paiement_prefacture', 8, 'lock', 0),
(1284, 89, 'paiement_prefacture', 9, 'lock_other', 0),
(1285, 89, 'paiement_prefacture', 10, 'view_other_parc', 0),
(1286, 89, 'paiement_prefacture', 11, 'audit', 0),
(1287, 89, 'paiement_prefacture', 12, 'search', 0),
(1288, 89, 'paiement_prefacture', 13, 'export', 0),
(1289, 89, 'paiement_prefacture', 14, 'import', 0),
(1290, 89, 'paiement_prefacture', 15, 'print', 0),
(1291, 90, 'facture', 1, 'view', 1),
(1292, 90, 'facture', 2, 'view_other', 1),
(1293, 90, 'facture', 3, 'add', 1),
(1294, 90, 'facture', 4, 'edit', 1),
(1295, 90, 'facture', 5, 'edit_other', 1),
(1296, 90, 'facture', 6, 'delete', 1),
(1297, 90, 'facture', 7, 'delete_other', 1),
(1298, 90, 'facture', 8, 'lock', 1),
(1299, 90, 'facture', 9, 'lock_other', 1),
(1300, 90, 'facture', 10, 'view_other_parc', 1),
(1301, 90, 'facture', 11, 'audit', 1),
(1302, 90, 'facture', 12, 'search', 1),
(1303, 90, 'facture', 13, 'export', 1),
(1304, 90, 'facture', 14, 'import', 1),
(1305, 90, 'facture', 15, 'print', 1),
(1306, 91, 'paiement_facture', 1, 'view', 1),
(1307, 91, 'paiement_facture', 2, 'view_other', 0),
(1308, 91, 'paiement_facture', 3, 'add', 0),
(1309, 91, 'paiement_facture', 4, 'edit', 0),
(1310, 91, 'paiement_facture', 5, 'edit_other', 0),
(1311, 91, 'paiement_facture', 6, 'delete', 0),
(1312, 91, 'paiement_facture', 7, 'delete_other', 0),
(1313, 91, 'paiement_facture', 8, 'lock', 0),
(1314, 91, 'paiement_facture', 9, 'lock_other', 0),
(1315, 91, 'paiement_facture', 10, 'view_other_parc', 0),
(1316, 91, 'paiement_facture', 11, 'audit', 0),
(1317, 91, 'paiement_facture', 12, 'search', 0),
(1318, 91, 'paiement_facture', 13, 'export', 0),
(1319, 91, 'paiement_facture', 14, 'import', 0),
(1320, 91, 'paiement_facture', 15, 'print', 0),
(1321, 92, 'encaissement', 1, 'view', 1),
(1322, 92, 'encaissement', 2, 'view_other', 1),
(1323, 92, 'encaissement', 3, 'add', 1),
(1324, 92, 'encaissement', 4, 'edit', 1),
(1325, 92, 'encaissement', 5, 'edit_other', 1),
(1326, 92, 'encaissement', 6, 'delete', 1),
(1327, 92, 'encaissement', 7, 'delete_other', 1),
(1328, 92, 'encaissement', 8, 'lock', 1),
(1329, 92, 'encaissement', 9, 'lock_other', 1),
(1330, 92, 'encaissement', 10, 'view_other_parc', 1),
(1331, 92, 'encaissement', 11, 'audit', 1),
(1332, 92, 'encaissement', 12, 'search', 1),
(1333, 92, 'encaissement', 13, 'export', 1),
(1334, 92, 'encaissement', 14, 'import', 1),
(1335, 92, 'encaissement', 15, 'print', 1),
(1336, 93, 'decaissement', 1, 'view', 1),
(1337, 93, 'decaissement', 2, 'view_other', 1),
(1338, 93, 'decaissement', 3, 'add', 1),
(1339, 93, 'decaissement', 4, 'edit', 1),
(1340, 93, 'decaissement', 5, 'edit_other', 1),
(1341, 93, 'decaissement', 6, 'delete', 1),
(1342, 93, 'decaissement', 7, 'delete_other', 1),
(1343, 93, 'decaissement', 8, 'lock', 1),
(1344, 93, 'decaissement', 9, 'lock_other', 1),
(1345, 93, 'decaissement', 10, 'view_other_parc', 1),
(1346, 93, 'decaissement', 11, 'audit', 1),
(1347, 93, 'decaissement', 12, 'search', 1),
(1348, 93, 'decaissement', 13, 'export', 1),
(1349, 93, 'decaissement', 14, 'import', 1),
(1350, 93, 'decaissement', 15, 'print', 1),
(1351, 94, 'virement', 1, 'view', 0),
(1352, 94, 'virement', 2, 'view_other', 0),
(1353, 94, 'virement', 3, 'add', 1),
(1354, 94, 'virement', 4, 'edit', 0),
(1355, 94, 'virement', 5, 'edit_other', 0),
(1356, 94, 'virement', 6, 'delete', 0),
(1357, 94, 'virement', 7, 'delete_other', 0),
(1358, 94, 'virement', 8, 'lock', 0),
(1359, 94, 'virement', 9, 'lock_other', 0),
(1360, 94, 'virement', 10, 'view_other_parc', 0),
(1361, 94, 'virement', 11, 'audit', 0),
(1362, 94, 'virement', 12, 'search', 0),
(1363, 94, 'virement', 13, 'export', 0),
(1364, 94, 'virement', 14, 'import', 0),
(1365, 94, 'virement', 15, 'print', 0),
(1366, 95, 'journal_tresorerie', 1, 'view', 1),
(1367, 95, 'journal_tresorerie', 2, 'view_other', 1),
(1368, 95, 'journal_tresorerie', 3, 'add', 1),
(1369, 95, 'journal_tresorerie', 4, 'edit', 1),
(1370, 95, 'journal_tresorerie', 5, 'edit_other', 1),
(1371, 95, 'journal_tresorerie', 6, 'delete', 1),
(1372, 95, 'journal_tresorerie', 7, 'delete_other', 1),
(1373, 95, 'journal_tresorerie', 8, 'lock', 1),
(1374, 95, 'journal_tresorerie', 9, 'lock_other', 1),
(1375, 95, 'journal_tresorerie', 10, 'view_other_parc', 1),
(1376, 95, 'journal_tresorerie', 11, 'audit', 1),
(1377, 95, 'journal_tresorerie', 12, 'search', 1),
(1378, 95, 'journal_tresorerie', 13, 'export', 1),
(1379, 95, 'journal_tresorerie', 14, 'import', 1),
(1380, 95, 'journal_tresorerie', 15, 'print', 1),
(1381, 96, 'compte_tresorerie', 1, 'view', 1),
(1382, 96, 'compte_tresorerie', 2, 'view_other', 1),
(1383, 96, 'compte_tresorerie', 3, 'add', 1),
(1384, 96, 'compte_tresorerie', 4, 'edit', 1),
(1385, 96, 'compte_tresorerie', 5, 'edit_other', 1),
(1386, 96, 'compte_tresorerie', 6, 'delete', 1),
(1387, 96, 'compte_tresorerie', 7, 'delete_other', 1),
(1388, 96, 'compte_tresorerie', 8, 'lock', 1),
(1389, 96, 'compte_tresorerie', 9, 'lock_other', 1),
(1390, 96, 'compte_tresorerie', 10, 'view_other_parc', 1),
(1391, 96, 'compte_tresorerie', 11, 'audit', 1),
(1392, 96, 'compte_tresorerie', 12, 'search', 1),
(1393, 96, 'compte_tresorerie', 13, 'export', 1),
(1394, 96, 'compte_tresorerie', 14, 'import', 1),
(1395, 96, 'compte_tresorerie', 15, 'print', 1),
(1396, 97, 'contrat_affretement', 1, 'view', 1),
(1397, 97, 'contrat_affretement', 2, 'view_other', 1),
(1398, 97, 'contrat_affretement', 3, 'add', 1),
(1399, 97, 'contrat_affretement', 4, 'edit', 1),
(1400, 97, 'contrat_affretement', 5, 'edit_other', 1),
(1401, 97, 'contrat_affretement', 6, 'delete', 1),
(1402, 97, 'contrat_affretement', 7, 'delete_other', 1),
(1403, 97, 'contrat_affretement', 8, 'lock', 1),
(1404, 97, 'contrat_affretement', 9, 'lock_other', 1),
(1405, 97, 'contrat_affretement', 10, 'view_other_parc', 1),
(1406, 97, 'contrat_affretement', 11, 'audit', 1),
(1407, 97, 'contrat_affretement', 12, 'search', 1),
(1408, 97, 'contrat_affretement', 13, 'export', 1),
(1409, 97, 'contrat_affretement', 14, 'import', 1),
(1410, 97, 'contrat_affretement', 15, 'print', 1),
(1411, 98, 'ajout_vehicule_affretement', 1, 'view', 1),
(1412, 98, 'ajout_vehicule_affretement', 2, 'view_other', 1),
(1413, 98, 'ajout_vehicule_affretement', 3, 'add', 1),
(1414, 98, 'ajout_vehicule_affretement', 4, 'edit', 1),
(1415, 98, 'ajout_vehicule_affretement', 5, 'edit_other', 1),
(1416, 98, 'ajout_vehicule_affretement', 6, 'delete', 1),
(1417, 98, 'ajout_vehicule_affretement', 7, 'delete_other', 1),
(1418, 98, 'ajout_vehicule_affretement', 8, 'lock', 1),
(1419, 98, 'ajout_vehicule_affretement', 9, 'lock_other', 1),
(1420, 98, 'ajout_vehicule_affretement', 10, 'view_other_parc', 1),
(1421, 98, 'ajout_vehicule_affretement', 11, 'audit', 1),
(1422, 98, 'ajout_vehicule_affretement', 12, 'search', 1),
(1423, 98, 'ajout_vehicule_affretement', 13, 'export', 1),
(1424, 98, 'ajout_vehicule_affretement', 14, 'import', 1),
(1425, 98, 'ajout_vehicule_affretement', 15, 'print', 1),
(1426, 99, 'reservation_affretement', 1, 'view', 1),
(1427, 99, 'reservation_affretement', 2, 'view_other', 0),
(1428, 99, 'reservation_affretement', 3, 'add', 0),
(1429, 99, 'reservation_affretement', 4, 'edit', 0),
(1430, 99, 'reservation_affretement', 5, 'edit_other', 0),
(1431, 99, 'reservation_affretement', 6, 'delete', 0),
(1432, 99, 'reservation_affretement', 7, 'delete_other', 0),
(1433, 99, 'reservation_affretement', 8, 'lock', 0),
(1434, 99, 'reservation_affretement', 9, 'lock_other', 0),
(1435, 99, 'reservation_affretement', 10, 'view_other_parc', 0),
(1436, 99, 'reservation_affretement', 11, 'audit', 0),
(1437, 99, 'reservation_affretement', 12, 'search', 0),
(1438, 99, 'reservation_affretement', 13, 'export', 0),
(1439, 99, 'reservation_affretement', 14, 'import', 0),
(1440, 99, 'reservation_affretement', 15, 'print', 0),
(1441, 100, 'paiement_reservation_affretement', 1, 'view', 1),
(1442, 100, 'paiement_reservation_affretement', 2, 'view_other', 0),
(1443, 100, 'paiement_reservation_affretement', 3, 'add', 0),
(1444, 100, 'paiement_reservation_affretement', 4, 'edit', 0),
(1445, 100, 'paiement_reservation_affretement', 5, 'edit_other', 0),
(1446, 100, 'paiement_reservation_affretement', 6, 'delete', 0),
(1447, 100, 'paiement_reservation_affretement', 7, 'delete_other', 0),
(1448, 100, 'paiement_reservation_affretement', 8, 'lock', 0),
(1449, 100, 'paiement_reservation_affretement', 9, 'lock_other', 0),
(1450, 100, 'paiement_reservation_affretement', 10, 'view_other_parc', 0),
(1451, 100, 'paiement_reservation_affretement', 11, 'audit', 0),
(1452, 100, 'paiement_reservation_affretement', 12, 'search', 0),
(1453, 100, 'paiement_reservation_affretement', 13, 'export', 0),
(1454, 100, 'paiement_reservation_affretement', 14, 'import', 0),
(1455, 100, 'paiement_reservation_affretement', 15, 'print', 0),
(1456, 101, 'statistique_gestion_des_vehicules', 1, 'view', 1),
(1457, 101, 'statistique_gestion_des_vehicules', 2, 'view_other', 0),
(1458, 101, 'statistique_gestion_des_vehicules', 3, 'add', 0),
(1459, 101, 'statistique_gestion_des_vehicules', 4, 'edit', 0),
(1460, 101, 'statistique_gestion_des_vehicules', 5, 'edit_other', 0),
(1461, 101, 'statistique_gestion_des_vehicules', 6, 'delete', 0),
(1462, 101, 'statistique_gestion_des_vehicules', 7, 'delete_other', 0),
(1463, 101, 'statistique_gestion_des_vehicules', 8, 'lock', 0),
(1464, 101, 'statistique_gestion_des_vehicules', 9, 'lock_other', 0),
(1465, 101, 'statistique_gestion_des_vehicules', 10, 'view_other_parc', 0),
(1466, 101, 'statistique_gestion_des_vehicules', 11, 'audit', 0),
(1467, 101, 'statistique_gestion_des_vehicules', 12, 'search', 0),
(1468, 101, 'statistique_gestion_des_vehicules', 13, 'export', 0),
(1469, 101, 'statistique_gestion_des_vehicules', 14, 'import', 0),
(1470, 101, 'statistique_gestion_des_vehicules', 15, 'print', 0),
(1471, 102, 'statistique_gestion_des_consommations', 1, 'view', 1),
(1472, 102, 'statistique_gestion_des_consommations', 2, 'view_other', 0),
(1473, 102, 'statistique_gestion_des_consommations', 3, 'add', 0),
(1474, 102, 'statistique_gestion_des_consommations', 4, 'edit', 0),
(1475, 102, 'statistique_gestion_des_consommations', 5, 'edit_other', 0),
(1476, 102, 'statistique_gestion_des_consommations', 6, 'delete', 0),
(1477, 102, 'statistique_gestion_des_consommations', 7, 'delete_other', 0),
(1478, 102, 'statistique_gestion_des_consommations', 8, 'lock', 0),
(1479, 102, 'statistique_gestion_des_consommations', 9, 'lock_other', 0),
(1480, 102, 'statistique_gestion_des_consommations', 10, 'view_other_parc', 0),
(1481, 102, 'statistique_gestion_des_consommations', 11, 'audit', 0),
(1482, 102, 'statistique_gestion_des_consommations', 12, 'search', 0),
(1483, 102, 'statistique_gestion_des_consommations', 13, 'export', 0),
(1484, 102, 'statistique_gestion_des_consommations', 14, 'import', 0),
(1485, 102, 'statistique_gestion_des_consommations', 15, 'print', 0),
(1486, 103, 'statistique_gestion_commerciale', 1, 'view', 1),
(1487, 103, 'statistique_gestion_commerciale', 2, 'view_other', 0),
(1488, 103, 'statistique_gestion_commerciale', 3, 'add', 0),
(1489, 103, 'statistique_gestion_commerciale', 4, 'edit', 0),
(1490, 103, 'statistique_gestion_commerciale', 5, 'edit_other', 0),
(1491, 103, 'statistique_gestion_commerciale', 6, 'delete', 0),
(1492, 103, 'statistique_gestion_commerciale', 7, 'delete_other', 0),
(1493, 103, 'statistique_gestion_commerciale', 8, 'lock', 0),
(1494, 103, 'statistique_gestion_commerciale', 9, 'lock_other', 0),
(1495, 103, 'statistique_gestion_commerciale', 10, 'view_other_parc', 0),
(1496, 103, 'statistique_gestion_commerciale', 11, 'audit', 0),
(1497, 103, 'statistique_gestion_commerciale', 12, 'search', 0),
(1498, 103, 'statistique_gestion_commerciale', 13, 'export', 0),
(1499, 103, 'statistique_gestion_commerciale', 14, 'import', 0),
(1500, 103, 'statistique_gestion_commerciale', 15, 'print', 0),
(1501, 104, 'commercial_tableau_bord', 1, 'view', 1),
(1502, 104, 'commercial_tableau_bord', 2, 'view_other', 0),
(1503, 104, 'commercial_tableau_bord', 3, 'add', 0),
(1504, 104, 'commercial_tableau_bord', 4, 'edit', 0),
(1505, 104, 'commercial_tableau_bord', 5, 'edit_other', 0),
(1506, 104, 'commercial_tableau_bord', 6, 'delete', 0),
(1507, 104, 'commercial_tableau_bord', 7, 'delete_other', 0),
(1508, 104, 'commercial_tableau_bord', 8, 'lock', 0),
(1509, 104, 'commercial_tableau_bord', 9, 'lock_other', 0),
(1510, 104, 'commercial_tableau_bord', 10, 'view_other_parc', 0),
(1511, 104, 'commercial_tableau_bord', 11, 'audit', 0),
(1512, 104, 'commercial_tableau_bord', 12, 'search', 0),
(1513, 104, 'commercial_tableau_bord', 13, 'export', 0),
(1514, 104, 'commercial_tableau_bord', 14, 'import', 0),
(1515, 104, 'commercial_tableau_bord', 15, 'print', 0),
(1516, 105, 'planification_tableau_bord', 1, 'view', 1),
(1517, 105, 'planification_tableau_bord', 2, 'view_other', 0),
(1518, 105, 'planification_tableau_bord', 3, 'add', 0),
(1519, 105, 'planification_tableau_bord', 4, 'edit', 0),
(1520, 105, 'planification_tableau_bord', 5, 'edit_other', 0),
(1521, 105, 'planification_tableau_bord', 6, 'delete', 0),
(1522, 105, 'planification_tableau_bord', 7, 'delete_other', 0),
(1523, 105, 'planification_tableau_bord', 8, 'lock', 0),
(1524, 105, 'planification_tableau_bord', 9, 'lock_other', 0),
(1525, 105, 'planification_tableau_bord', 10, 'view_other_parc', 0),
(1526, 105, 'planification_tableau_bord', 11, 'audit', 0),
(1527, 105, 'planification_tableau_bord', 12, 'search', 0),
(1528, 105, 'planification_tableau_bord', 13, 'export', 0),
(1529, 105, 'planification_tableau_bord', 14, 'import', 0),
(1530, 105, 'planification_tableau_bord', 15, 'print', 0),
(1531, 106, 'finance_tableau_bord', 1, 'view', 1),
(1532, 106, 'finance_tableau_bord', 2, 'view_other', 0),
(1533, 106, 'finance_tableau_bord', 3, 'add', 0),
(1534, 106, 'finance_tableau_bord', 4, 'edit', 0),
(1535, 106, 'finance_tableau_bord', 5, 'edit_other', 0),
(1536, 106, 'finance_tableau_bord', 6, 'delete', 0),
(1537, 106, 'finance_tableau_bord', 7, 'delete_other', 0),
(1538, 106, 'finance_tableau_bord', 8, 'lock', 0),
(1539, 106, 'finance_tableau_bord', 9, 'lock_other', 0),
(1540, 106, 'finance_tableau_bord', 10, 'view_other_parc', 0),
(1541, 106, 'finance_tableau_bord', 11, 'audit', 0),
(1542, 106, 'finance_tableau_bord', 12, 'search', 0),
(1543, 106, 'finance_tableau_bord', 13, 'export', 0),
(1544, 106, 'finance_tableau_bord', 14, 'import', 0),
(1545, 106, 'finance_tableau_bord', 15, 'print', 0),
(1546, 107, 'alertes_tableau_bord', 1, 'view', 1),
(1547, 107, 'alertes_tableau_bord', 2, 'view_other', 0),
(1548, 107, 'alertes_tableau_bord', 3, 'add', 0),
(1549, 107, 'alertes_tableau_bord', 4, 'edit', 0),
(1550, 107, 'alertes_tableau_bord', 5, 'edit_other', 0),
(1551, 107, 'alertes_tableau_bord', 6, 'delete', 0),
(1552, 107, 'alertes_tableau_bord', 7, 'delete_other', 0),
(1553, 107, 'alertes_tableau_bord', 8, 'lock', 0),
(1554, 107, 'alertes_tableau_bord', 9, 'lock_other', 0),
(1555, 107, 'alertes_tableau_bord', 10, 'view_other_parc', 0),
(1556, 107, 'alertes_tableau_bord', 11, 'audit', 0),
(1557, 107, 'alertes_tableau_bord', 12, 'search', 0),
(1558, 107, 'alertes_tableau_bord', 13, 'export', 0),
(1559, 107, 'alertes_tableau_bord', 14, 'import', 0),
(1560, 107, 'alertes_tableau_bord', 15, 'print', 0),
(1561, 108, 'liens_tableau_bord', 1, 'view', 1),
(1562, 108, 'liens_tableau_bord', 2, 'view_other', 0),
(1563, 108, 'liens_tableau_bord', 3, 'add', 0),
(1564, 108, 'liens_tableau_bord', 4, 'edit', 0),
(1565, 108, 'liens_tableau_bord', 5, 'edit_other', 0),
(1566, 108, 'liens_tableau_bord', 6, 'delete', 0),
(1567, 108, 'liens_tableau_bord', 7, 'delete_other', 0),
(1568, 108, 'liens_tableau_bord', 8, 'lock', 0),
(1569, 108, 'liens_tableau_bord', 9, 'lock_other', 0),
(1570, 108, 'liens_tableau_bord', 10, 'view_other_parc', 0),
(1571, 108, 'liens_tableau_bord', 11, 'audit', 0),
(1572, 108, 'liens_tableau_bord', 12, 'search', 0),
(1573, 108, 'liens_tableau_bord', 13, 'export', 0),
(1574, 108, 'liens_tableau_bord', 14, 'import', 0),
(1575, 108, 'liens_tableau_bord', 15, 'print', 0),
(1576, 109, 'evenements_tableau_bord', 1, 'view', 1),
(1577, 109, 'evenements_tableau_bord', 2, 'view_other', 0),
(1578, 109, 'evenements_tableau_bord', 3, 'add', 0),
(1579, 109, 'evenements_tableau_bord', 4, 'edit', 0),
(1580, 109, 'evenements_tableau_bord', 5, 'edit_other', 0),
(1581, 109, 'evenements_tableau_bord', 6, 'delete', 0),
(1582, 109, 'evenements_tableau_bord', 7, 'delete_other', 0),
(1583, 109, 'evenements_tableau_bord', 8, 'lock', 0),
(1584, 109, 'evenements_tableau_bord', 9, 'lock_other', 0),
(1585, 109, 'evenements_tableau_bord', 10, 'view_other_parc', 0),
(1586, 109, 'evenements_tableau_bord', 11, 'audit', 0),
(1587, 109, 'evenements_tableau_bord', 12, 'search', 0),
(1588, 109, 'evenements_tableau_bord', 13, 'export', 0),
(1589, 109, 'evenements_tableau_bord', 14, 'import', 0),
(1590, 109, 'evenements_tableau_bord', 15, 'print', 0),
(1591, 110, '', 1, '', 1),
(1592, 110, '', 2, '', 1),
(1593, 110, '', 3, '', 1),
(1594, 110, '', 4, '', 1),
(1595, 110, '', 5, '', 1),
(1596, 110, '', 6, '', 1),
(1597, 110, '', 7, '', 1),
(1598, 110, '', 8, '', 1),
(1599, 110, '', 9, '', 1),
(1600, 110, '', 10, '', 1),
(1601, 110, '', 11, '', 1),
(1602, 110, '', 12, '', 1),
(1603, 110, '', 13, '', 1),
(1604, 110, '', 14, '', 1),
(1605, 110, '', 15, '', 1),
(1606, 111, 'service', 1, 'view', 1),
(1607, 111, '', 2, '', 1),
(1608, 111, '', 3, '', 1),
(1609, 111, '', 3, '', 1),
(1610, 111, '', 4, '', 1),
(1611, 111, '', 5, '', 1),
(1612, 111, '', 6, '', 1),
(1613, 111, '', 7, '', 1),
(1614, 111, '', 8, '', 1),
(1615, 111, '', 9, '', 1),
(1616, 111, '', 10, '', 1),
(1617, 111, '', 11, '', 1),
(1618, 111, '', 12, '', 1),
(1619, 111, '', 13, '', 1),
(1620, 111, '', 14, '', 1),
(1621, 111, '', 15, '', 1),
(1622, 112, 'service', 1, 'view', 1),
(1623, 112, '', 2, '', 0),
(1624, 112, '', 3, '', 0),
(1625, 112, '', 3, '', 0),
(1626, 112, '', 4, '', 0),
(1627, 112, '', 5, '', 0),
(1628, 112, '', 6, '', 0),
(1629, 112, '', 7, '', 0),
(1630, 112, '', 8, '', 0),
(1631, 112, '', 9, '', 0),
(1632, 112, '', 10, '', 0),
(1633, 112, '', 11, '', 0),
(1634, 112, '', 12, '', 0),
(1635, 112, '', 13, '', 0),
(1636, 112, '', 14, '', 0),
(1637, 112, '', 15, '', 0),
(1638, 113, '', 1, '', 1),
(1639, 113, '', 2, '', 0),
(1640, 113, '', 3, '', 0),
(1641, 113, '', 3, '', 0),
(1642, 113, '', 4, '', 0),
(1643, 113, '', 5, '', 0),
(1644, 113, '', 6, '', 0),
(1645, 113, '', 7, '', 0),
(1646, 113, '', 8, '', 0),
(1647, 113, '', 9, '', 0),
(1648, 113, '', 10, '', 0),
(1649, 113, '', 11, '', 0),
(1650, 113, '', 12, '', 0),
(1651, 113, '', 13, '', 0),
(1652, 113, '', 14, '', 0),
(1653, 113, '', 15, '', 0),
(1654, 114, '', 1, '', 1),
(1655, 114, '', 2, '', 0),
(1656, 114, '', 3, '', 0),
(1657, 114, '', 3, '', 0),
(1658, 114, '', 4, '', 0),
(1659, 114, '', 5, '', 0),
(1660, 114, '', 6, '', 0),
(1661, 114, '', 7, '', 0),
(1662, 114, '', 8, '', 0),
(1663, 114, '', 9, '', 0),
(1664, 114, '', 10, '', 0),
(1665, 114, '', 11, '', 0),
(1666, 114, '', 12, '', 0),
(1667, 114, '', 13, '', 0),
(1668, 114, '', 14, '', 0),
(1669, 114, '', 15, '', 0),
(1670, 115, '', 1, '', 1),
(1671, 115, '', 2, '', 1),
(1672, 115, '', 3, '', 1),
(1673, 115, '', 3, '', 1),
(1674, 115, '', 4, '', 1),
(1675, 115, '', 5, '', 1),
(1676, 115, '', 6, '', 1),
(1677, 115, '', 7, '', 1),
(1678, 115, '', 8, '', 1),
(1679, 115, '', 9, '', 1),
(1680, 115, '', 10, '', 1),
(1681, 115, '', 11, '', 1),
(1682, 115, '', 12, '', 1),
(1683, 115, '', 13, '', 1),
(1684, 115, '', 14, '', 1),
(1685, 115, '', 15, '', 1),
(1686, 118, '', 1, 'view', 1),
(1687, 118, '', 2, 'view_other', 0),
(1688, 118, '', 3, 'add', 0),
(1689, 118, '', 4, 'edit', 0),
(1690, 118, '', 5, 'edit_other', 0),
(1691, 118, '', 6, 'delete', 0),
(1692, 118, '', 7, 'delete_other', 0),
(1693, 118, '', 8, 'lock', 0),
(1694, 118, '', 9, 'lock_other', 0),
(1695, 118, '', 10, 'view_other_parc', 0),
(1696, 118, '', 11, 'audit', 0),
(1697, 118, '', 12, 'search', 0),
(1698, 118, '', 13, 'export', 0),
(1699, 118, '', 14, 'import', 0),
(1700, 118, '', 15, 'print', 0),
(1701, 119, '', 1, 'view', 1),
(1702, 119, '', 2, 'view_other', 0),
(1703, 119, '', 3, 'add', 0),
(1704, 119, '', 4, 'edit', 0),
(1705, 119, '', 5, 'edit_other', 0),
(1706, 119, '', 6, 'delete', 0),
(1707, 119, '', 7, 'delete_other', 0),
(1708, 119, '', 8, 'lock', 0),
(1709, 119, '', 9, 'lock_other', 0),
(1710, 119, '', 10, 'view_other_parc', 0),
(1711, 119, '', 11, 'audit', 0),
(1712, 119, '', 12, 'search', 0),
(1713, 119, '', 13, 'export', 0),
(1714, 119, '', 14, 'import', 0),
(1715, 119, '', 15, 'print', 0),
(1716, 120, '', 1, 'view', 1),
(1717, 120, '', 2, 'view_other', 0),
(1718, 120, '', 3, 'add', 0),
(1719, 120, '', 4, 'edit', 0),
(1720, 120, '', 5, 'edit_other', 0),
(1721, 120, '', 6, 'delete', 0),
(1722, 120, '', 7, 'delete_other', 0),
(1723, 120, '', 8, 'lock', 0),
(1724, 120, '', 9, 'lock_other', 0),
(1725, 120, '', 10, 'view_other_parc', 0),
(1726, 120, '', 11, 'audit', 0),
(1727, 120, '', 12, 'search', 0),
(1728, 120, '', 13, 'export', 0),
(1729, 120, '', 14, 'import', 0),
(1730, 120, '', 15, 'print', 0),
(1731, 121, '', 1, 'view', 1),
(1732, 121, '', 2, 'view_other', 0),
(1733, 121, '', 3, 'add', 0),
(1734, 121, '', 4, 'edit', 0),
(1735, 121, '', 5, 'edit_other', 0),
(1736, 121, '', 6, 'delete', 0),
(1737, 121, '', 7, 'delete_other', 0),
(1738, 121, '', 8, 'lock', 0),
(1739, 121, '', 9, 'lock_other', 0),
(1740, 121, '', 10, 'view_other_parc', 0),
(1741, 121, '', 11, 'audit', 0),
(1742, 121, '', 12, 'search', 0),
(1743, 121, '', 13, 'export', 0),
(1744, 121, '', 14, 'import', 0),
(1745, 121, '', 15, 'print', 0),
(1791, 122, '', 1, 'view', 1),
(1792, 122, '', 2, 'view_other', 0),
(1793, 122, '', 3, 'add', 0),
(1794, 122, '', 4, 'edit', 0),
(1795, 122, '', 5, 'edit_other', 0),
(1796, 122, '', 6, 'delete', 0),
(1797, 122, '', 7, 'delete_other', 0),
(1798, 122, '', 8, 'lock', 0),
(1799, 122, '', 9, 'lock_other', 0),
(1800, 122, '', 10, 'view_other_parc', 0),
(1801, 122, '', 11, 'audit', 0),
(1802, 122, '', 12, 'search', 0),
(1803, 122, '', 13, 'export', 0),
(1804, 122, '', 14, 'import', 0),
(1805, 122, '', 15, 'print', 0),
(1806, 123, '', 1, 'view', 1),
(1807, 123, '', 2, 'view_other', 0),
(1808, 123, '', 3, 'add', 0),
(1809, 123, '', 4, 'edit', 0),
(1810, 123, '', 5, 'edit_other', 0),
(1811, 123, '', 6, 'delete', 0),
(1812, 123, '', 7, 'delete_other', 0),
(1813, 123, '', 8, 'lock', 0),
(1814, 123, '', 9, 'lock_other', 0),
(1815, 123, '', 10, 'view_other_parc', 0),
(1816, 123, '', 11, 'audit', 0),
(1817, 123, '', 12, 'search', 0),
(1818, 123, '', 13, 'export', 0),
(1819, 123, '', 14, 'import', 0),
(1820, 123, '', 15, 'print', 0),
(1821, 124, '', 1, 'view', 1),
(1822, 124, '', 2, 'view_other', 1),
(1823, 124, '', 3, 'add', 1),
(1824, 124, '', 4, 'edit', 1),
(1825, 124, '', 5, 'edit_other', 1),
(1826, 124, '', 6, 'delete', 1),
(1827, 124, '', 7, 'delete_other', 1),
(1828, 124, '', 8, 'lock', 1),
(1829, 124, '', 9, 'lock_other', 1),
(1830, 124, '', 10, 'view_other_parc', 1),
(1831, 124, '', 11, 'audit', 1),
(1832, 124, '', 12, 'search', 1),
(1833, 124, '', 13, 'export', 1),
(1834, 124, '', 14, 'import', 1),
(1835, 124, '', 15, 'print', 1),
(1836, 125, '', 1, '', 1),
(1837, 125, '', 2, '', 1),
(1838, 125, '', 3, '', 1),
(1839, 125, '', 3, '', 1),
(1840, 125, '', 4, '', 1),
(1841, 125, '', 5, '', 1),
(1842, 125, '', 6, '', 1),
(1843, 125, '', 7, '', 1),
(1844, 125, '', 8, '', 1),
(1845, 125, '', 9, '', 1),
(1846, 125, '', 10, '', 1),
(1847, 125, '', 11, '', 1),
(1848, 125, '', 12, '', 1),
(1849, 125, '', 13, '', 1),
(1850, 125, '', 14, '', 1),
(1851, 125, '', 15, '', 1),
(1852, 126, '', 1, '', 1),
(1853, 126, '', 2, '', 1),
(1854, 126, '', 3, '', 1),
(1855, 126, '', 3, '', 1),
(1856, 126, '', 4, '', 1),
(1857, 126, '', 5, '', 1),
(1858, 126, '', 6, '', 1),
(1859, 126, '', 7, '', 1),
(1860, 126, '', 8, '', 1),
(1861, 126, '', 9, '', 1),
(1862, 126, '', 10, '', 1),
(1863, 126, '', 11, '', 1),
(1864, 126, '', 12, '', 1),
(1865, 126, '', 13, '', 1),
(1866, 126, '', 14, '', 1),
(1867, 126, '', 15, '', 1),
(1868, 127, '', 1, '', 1),
(1869, 127, '', 2, '', 1),
(1870, 127, '', 3, '', 1),
(1871, 127, '', 3, '', 1),
(1872, 127, '', 4, '', 1),
(1873, 127, '', 5, '', 1),
(1874, 127, '', 6, '', 1),
(1875, 127, '', 7, '', 1),
(1876, 127, '', 8, '', 1),
(1877, 127, '', 9, '', 1),
(1878, 127, '', 10, '', 1),
(1879, 127, '', 11, '', 1),
(1880, 127, '', 12, '', 1),
(1881, 127, '', 13, '', 1),
(1882, 127, '', 14, '', 1),
(1883, 127, '', 15, '', 1),
(1884, 128, '', 1, '', 1),
(1885, 128, '', 2, '', 1),
(1886, 128, '', 3, '', 1),
(1887, 128, '', 3, '', 1),
(1888, 128, '', 4, '', 1),
(1889, 128, '', 5, '', 1),
(1890, 128, '', 6, '', 1),
(1891, 128, '', 7, '', 1),
(1892, 128, '', 8, '', 1),
(1893, 128, '', 9, '', 1),
(1894, 128, '', 10, '', 1),
(1895, 128, '', 11, '', 1),
(1896, 128, '', 12, '', 1),
(1897, 128, '', 13, '', 1),
(1898, 128, '', 14, '', 1),
(1899, 128, '', 15, '', 1),
(1900, 129, '', 1, '', 1),
(1901, 129, '', 2, '', 1),
(1902, 129, '', 3, '', 1),
(1903, 129, '', 3, '', 1),
(1904, 129, '', 4, '', 1),
(1905, 129, '', 5, '', 1),
(1906, 129, '', 6, '', 1),
(1907, 129, '', 7, '', 1),
(1908, 129, '', 8, '', 1),
(1909, 129, '', 9, '', 1),
(1910, 129, '', 10, '', 1),
(1911, 129, '', 11, '', 1),
(1912, 129, '', 12, '', 1),
(1913, 129, '', 13, '', 1),
(1914, 129, '', 14, '', 1),
(1915, 129, '', 15, '', 1),
(1916, 130, '', 1, '', 1),
(1917, 130, '', 2, '', 1),
(1918, 130, '', 3, '', 1),
(1919, 130, '', 3, '', 1),
(1920, 130, '', 4, '', 1),
(1921, 130, '', 5, '', 1),
(1922, 130, '', 6, '', 1),
(1923, 130, '', 7, '', 1),
(1924, 130, '', 8, '', 1),
(1925, 130, '', 9, '', 1),
(1926, 130, '', 10, '', 1),
(1927, 130, '', 11, '', 1),
(1928, 130, '', 12, '', 1),
(1929, 130, '', 13, '', 1),
(1930, 130, '', 14, '', 1),
(1931, 130, '', 15, '', 1),
(1932, 131, '', 1, '', 1),
(1933, 131, '', 2, '', 1),
(1934, 131, '', 3, '', 1),
(1935, 131, '', 3, '', 1),
(1936, 131, '', 4, '', 1),
(1937, 131, '', 5, '', 1),
(1938, 131, '', 6, '', 1),
(1939, 131, '', 7, '', 1),
(1940, 131, '', 8, '', 1),
(1941, 131, '', 9, '', 1),
(1942, 131, '', 10, '', 1),
(1943, 131, '', 11, '', 1),
(1944, 131, '', 12, '', 1),
(1945, 131, '', 13, '', 1),
(1946, 131, '', 14, '', 1),
(1947, 131, '', 15, '', 1),
(1948, 132, '', 1, '', 1),
(1949, 132, '', 2, '', 1),
(1950, 132, '', 3, '', 1),
(1951, 132, '', 3, '', 1),
(1952, 132, '', 4, '', 1),
(1953, 132, '', 5, '', 1),
(1954, 132, '', 6, '', 1),
(1955, 132, '', 7, '', 1),
(1956, 132, '', 8, '', 1),
(1957, 132, '', 9, '', 1),
(1958, 132, '', 10, '', 1),
(1959, 132, '', 11, '', 1),
(1960, 132, '', 12, '', 1),
(1961, 132, '', 13, '', 1),
(1962, 132, '', 14, '', 1),
(1963, 132, '', 15, '', 1),
(1964, 133, '', 1, '', 1),
(1965, 133, '', 2, '', 1),
(1966, 133, '', 3, '', 1),
(1967, 133, '', 3, '', 1),
(1968, 133, '', 4, '', 1),
(1969, 133, '', 5, '', 1),
(1970, 133, '', 6, '', 1),
(1971, 133, '', 7, '', 1),
(1972, 133, '', 8, '', 1),
(1973, 133, '', 9, '', 1),
(1974, 133, '', 10, '', 1),
(1975, 133, '', 11, '', 1),
(1976, 133, '', 12, '', 1),
(1977, 133, '', 13, '', 1),
(1978, 133, '', 14, '', 1),
(1979, 133, '', 15, '', 1),
(1980, 134, '', 1, '', 1),
(1981, 134, '', 2, '', 1),
(1982, 134, '', 3, '', 1),
(1983, 134, '', 3, '', 1),
(1984, 134, '', 4, '', 1),
(1985, 134, '', 5, '', 1),
(1986, 134, '', 6, '', 1),
(1987, 134, '', 7, '', 1),
(1988, 134, '', 8, '', 1),
(1989, 134, '', 9, '', 1),
(1990, 134, '', 10, '', 1),
(1991, 134, '', 11, '', 1),
(1992, 134, '', 12, '', 1),
(1993, 134, '', 13, '', 1),
(1994, 134, '', 14, '', 1),
(1995, 134, '', 15, '', 1),
(1996, 135, '', 1, '', 1),
(1997, 135, '', 2, '', 1),
(1998, 135, '', 3, '', 1),
(1999, 135, '', 3, '', 1),
(2000, 135, '', 4, '', 1),
(2001, 135, '', 5, '', 1),
(2002, 135, '', 6, '', 1),
(2003, 135, '', 7, '', 1),
(2004, 135, '', 8, '', 1),
(2005, 135, '', 9, '', 1),
(2006, 135, '', 10, '', 1),
(2007, 135, '', 11, '', 1),
(2008, 135, '', 12, '', 1),
(2009, 135, '', 13, '', 1),
(2010, 135, '', 14, '', 1),
(2011, 135, '', 15, '', 1),
(2012, 136, '', 1, '', 1),
(2013, 136, '', 2, '', 0),
(2014, 136, '', 3, '', 0),
(2015, 136, '', 3, '', 0),
(2016, 136, '', 4, '', 0),
(2017, 136, '', 5, '', 0),
(2018, 136, '', 6, '', 0),
(2019, 136, '', 7, '', 0),
(2020, 136, '', 8, '', 0),
(2021, 136, '', 9, '', 0),
(2022, 136, '', 10, '', 0),
(2023, 136, '', 11, '', 0),
(2024, 136, '', 12, '', 0),
(2025, 136, '', 13, '', 0),
(2026, 136, '', 14, '', 0),
(2027, 136, '', 15, '', 0),
(2028, 137, '', 1, '', 1),
(2029, 137, '', 2, '', 1),
(2030, 137, '', 3, '', 1),
(2031, 137, '', 3, '', 1),
(2032, 137, '', 4, '', 1),
(2033, 137, '', 5, '', 1),
(2034, 137, '', 6, '', 1),
(2035, 137, '', 7, '', 1),
(2036, 137, '', 8, '', 1),
(2037, 137, '', 9, '', 1),
(2038, 137, '', 10, '', 1),
(2039, 137, '', 11, '', 1),
(2040, 137, '', 12, '', 1),
(2041, 137, '', 13, '', 1),
(2042, 137, '', 14, '', 1),
(2043, 137, '', 15, '', 1),
(2044, 138, '', 1, '', 1),
(2045, 138, '', 2, '', 1),
(2046, 138, '', 3, '', 1),
(2047, 138, '', 3, '', 1),
(2048, 138, '', 4, '', 1),
(2049, 138, '', 5, '', 1),
(2050, 138, '', 6, '', 1),
(2051, 138, '', 7, '', 1),
(2052, 138, '', 8, '', 1),
(2053, 138, '', 9, '', 1),
(2054, 138, '', 10, '', 1),
(2055, 138, '', 11, '', 1),
(2056, 138, '', 12, '', 1),
(2057, 138, '', 13, '', 1),
(2058, 138, '', 14, '', 1),
(2059, 138, '', 15, '', 1),
(2060, 139, '', 1, '', 1),
(2061, 139, '', 2, '', 1),
(2062, 139, '', 3, '', 1),
(2063, 139, '', 3, '', 1),
(2064, 139, '', 4, '', 1),
(2065, 139, '', 5, '', 1),
(2066, 139, '', 6, '', 1),
(2067, 139, '', 7, '', 1),
(2068, 139, '', 8, '', 1),
(2069, 139, '', 9, '', 1),
(2070, 139, '', 10, '', 1),
(2071, 139, '', 11, '', 1),
(2072, 139, '', 12, '', 1),
(2073, 139, '', 13, '', 1),
(2074, 139, '', 14, '', 1),
(2075, 139, '', 15, '', 1),
(2076, 140, '', 1, '', 1),
(2077, 140, '', 2, '', 1),
(2078, 140, '', 3, '', 1),
(2079, 140, '', 3, '', 1),
(2080, 140, '', 4, '', 1),
(2081, 140, '', 5, '', 1),
(2082, 140, '', 6, '', 1),
(2083, 140, '', 7, '', 1),
(2084, 140, '', 8, '', 1),
(2085, 140, '', 9, '', 1),
(2086, 140, '', 10, '', 1),
(2087, 140, '', 11, '', 1),
(2088, 140, '', 12, '', 1),
(2089, 140, '', 13, '', 1),
(2090, 140, '', 14, '', 1),
(2091, 140, '', 15, '', 1),
(2092, 141, '', 1, '', 1),
(2093, 141, '', 2, '', 1),
(2094, 141, '', 3, '', 1),
(2095, 141, '', 3, '', 1),
(2096, 141, '', 4, '', 1),
(2097, 141, '', 5, '', 1),
(2098, 141, '', 6, '', 1),
(2099, 141, '', 7, '', 1),
(2100, 141, '', 8, '', 1),
(2101, 141, '', 9, '', 1),
(2102, 141, '', 10, '', 1),
(2103, 141, '', 11, '', 1),
(2104, 141, '', 12, '', 1),
(2105, 141, '', 13, '', 1),
(2106, 141, '', 14, '', 1),
(2107, 141, '', 15, '', 1),
(2108, 142, '', 1, '', 1),
(2109, 142, '', 2, '', 1),
(2110, 142, '', 3, '', 1),
(2111, 142, '', 3, '', 1),
(2112, 142, '', 4, '', 1),
(2113, 142, '', 5, '', 1),
(2114, 142, '', 6, '', 1),
(2115, 142, '', 7, '', 1),
(2116, 142, '', 8, '', 1),
(2117, 142, '', 9, '', 1),
(2118, 142, '', 10, '', 1),
(2119, 142, '', 11, '', 1),
(2120, 142, '', 12, '', 1),
(2121, 142, '', 13, '', 1),
(2122, 142, '', 14, '', 1),
(2123, 142, '', 15, '', 1),
(2124, 143, '', 1, '', 1),
(2125, 143, '', 2, '', 1),
(2126, 143, '', 3, '', 1),
(2127, 143, '', 3, '', 1),
(2128, 143, '', 4, '', 1),
(2129, 143, '', 5, '', 1),
(2130, 143, '', 6, '', 1),
(2131, 143, '', 7, '', 1),
(2132, 143, '', 8, '', 1),
(2133, 143, '', 9, '', 1),
(2134, 143, '', 10, '', 1),
(2135, 143, '', 11, '', 1),
(2136, 143, '', 12, '', 1),
(2137, 143, '', 13, '', 1),
(2138, 143, '', 14, '', 1),
(2139, 143, '', 15, '', 1),
(2140, 144, '', 1, '', 1),
(2141, 144, '', 2, '', 1),
(2142, 144, '', 3, '', 1),
(2143, 144, '', 3, '', 1),
(2144, 144, '', 4, '', 1),
(2145, 144, '', 5, '', 1),
(2146, 144, '', 6, '', 1),
(2147, 144, '', 7, '', 1),
(2148, 144, '', 8, '', 1),
(2149, 144, '', 9, '', 1),
(2150, 144, '', 10, '', 1),
(2151, 144, '', 11, '', 1),
(2152, 144, '', 12, '', 1),
(2153, 144, '', 13, '', 1),
(2154, 144, '', 14, '', 1),
(2155, 144, '', 15, '', 1),
(2156, 1, 'vehicule', 20, '', 0),
(2157, 2, 'totaux_vehicule', 20, '', 0),
(2158, 3, 'localisation_vehicule', 20, '', 0),
(2159, 4, 'categorie_vehicule', 20, '', 0),
(2160, 5, 'marque_vehicule', 20, '', 0),
(2161, 6, 'modele_vehicule', 20, '', 0),
(2162, 7, 'groupe_vehicule', 20, '', 0),
(2163, 8, 'type_vehicule', 20, '', 0),
(2164, 9, 'statut_vehicule', 20, '', 0),
(2165, 10, 'type_acquisition_vehicule', 20, '', 0),
(2166, 11, 'carburant', 20, '', 0),
(2167, 12, 'parc_vehicule', 20, '', 0),
(2168, 13, 'fournisseur', 20, '', 0),
(2169, 14, 'remorque', 20, '', 0),
(2170, 15, 'affectation', 20, '', 0),
(2171, 16, 'pv_affectation', 20, '', 0),
(2172, 17, 'decharge_affectation', 20, '', 0),
(2173, 18, 'option_affectation', 20, '', 0),
(2174, 19, 'zone_affectation', 20, '', 0),
(2175, 20, 'affectation_provisoire', 20, '', 0),
(2176, 21, 'demande_affectation', 20, '', 0),
(2177, 22, 'employe', 20, '', 0),
(2178, 23, 'frais_mission', 20, '', 0),
(2179, 24, 'categorie_employee', 20, '', 0),
(2180, 25, 'groupe_employe', 20, '', 0),
(2181, 26, 'affiliation_employe', 20, '', 0),
(2182, 27, 'departement', 20, '', 0),
(2183, 28, 'carnet_carburant', 20, '', 0),
(2184, 29, 'carte_carburant', 20, '', 0),
(2185, 30, 'affectation_carte_carburant', 20, '', 0),
(2186, 31, 'citerne', 20, '', 0),
(2187, 32, 'produit', 20, '', 0),
(2188, 33, 'type_produit', 20, '', 0),
(2189, 34, 'marque_produit', 20, '', 0),
(2190, 35, 'tva_produit', 20, '', 0),
(2191, 36, 'depot_produit', 20, '', 0),
(2192, 37, 'bon_entree', 20, '', 0),
(2193, 38, 'bon_sortie', 20, '', 0),
(2194, 39, 'commande_fournisseur', 20, '', 0),
(2195, 40, 'pneu', 20, '', 0),
(2196, 41, 'marque_pneu', 20, '', 0),
(2197, 42, 'position_pneu', 20, '', 0),
(2198, 43, 'emplacement_pneu', 20, '', 0),
(2199, 44, 'deplacement_pneu', 20, '', 0),
(2200, 45, 'verification_pneu', 20, '', 0),
(2201, 46, 'extincteur', 20, '', 0),
(2202, 47, 'deplacement_extincteur', 20, '', 0),
(2203, 48, 'recharge_extincteur', 20, '', 0),
(2204, 50, 'type_evenement', 20, '', 0),
(2205, 51, 'type_intervenant', 20, '', 0),
(2206, 52, 'intervenant', 20, '', 0),
(2207, 53, 'administratif_evenement', 20, '', 0),
(2208, 54, 'maintenance_evenement', 20, '', 0),
(2209, 55, 'demande_intervention', 20, '', 0),
(2210, 57, 'marchandise', 20, '', 0),
(2211, 58, 'type_marchandise', 20, '', 0),
(2212, 59, 'unite_marchandise', 20, '', 0),
(2213, 60, 'trajet', 20, '', 0),
(2214, 61, 'villes_trajet', 20, '', 0),
(2215, 62, 'wilaya', 20, '', 0),
(2216, 63, 'daira', 20, '', 0),
(2217, 64, 'categorie_trajet', 20, '', 0),
(2218, 65, 'detail_trajet', 20, '', 0),
(2219, 66, 'tarif_trajet', 20, '', 0),
(2220, 68, 'feuille_de_route', 20, '', 1),
(2221, 69, 'mission', 20, '', 0),
(2222, 70, 'piece_jointe_mission', 20, '', 0),
(2223, 71, 'marchandise_mission', 20, '', 0),
(2224, 73, 'client', 20, '', 0),
(2225, 74, 'importation_adresse_client', 20, '', 0),
(2226, 75, 'importation_contact_client', 20, '', 0),
(2227, 76, 'categorie_client', 20, '', 0),
(2228, 77, 'demande_de_devis', 20, '', 0),
(2229, 78, 'transformer_demande_devis', 20, '', 0),
(2230, 79, 'devis', 20, '', 0),
(2231, 80, 'transformer_devis', 20, '', 0),
(2232, 81, 'relancer_devis', 20, '', 0),
(2233, 82, 'dupliquer_devis', 20, '', 0),
(2234, 83, 'envoyer_devis_mail', 20, '', 0),
(2235, 84, 'commande_client', 20, '', 1),
(2236, 85, 'transformer_commande_client', 20, '', 0),
(2237, 86, 'detail_commande_client', 20, '', 0),
(2238, 87, 'prefacture', 20, '', 0),
(2239, 88, 'transformer_prefacture', 20, '', 0),
(2240, 89, 'paiement_prefacture', 20, '', 0),
(2241, 90, 'facture', 20, '', 0),
(2242, 91, 'paiement_facture', 20, '', 0),
(2243, 92, 'encaissement', 20, '', 0),
(2244, 93, 'decaissement', 20, '', 0),
(2245, 94, 'virement', 20, '', 0),
(2246, 95, 'journal_tresorerie', 20, '', 0),
(2247, 96, 'compte_tresorerie', 20, '', 0),
(2248, 97, 'contrat_affretement', 20, '', 0),
(2249, 98, 'ajout_vehicule_affretement', 20, '', 0),
(2250, 99, 'reservation_affretement', 20, '', 0),
(2251, 100, 'paiement_reservation_affretement', 20, '', 0),
(2252, 101, 'statistique_gestion_des_vehicules', 20, '', 0),
(2253, 102, 'statistique_gestion_des_consommations', 20, '', 0),
(2254, 103, 'statistique_gestion_commerciale', 20, '', 0),
(2255, 104, 'commercial_tableau_bord', 20, '', 0),
(2256, 105, 'planification_tableau_bord', 20, '', 0),
(2257, 106, 'finance_tableau_bord', 20, '', 0),
(2258, 107, 'alertes_tableau_bord', 20, '', 0),
(2259, 108, 'liens_tableau_bord', 20, '', 0),
(2260, 109, 'evenements_tableau_bord', 20, '', 0),
(2261, 110, 'type_piece_jointe_client', 20, '', 0),
(2262, 111, 'service', 20, '', 0),
(2263, 112, 'transmettre_commande_client', 20, '', 0),
(2264, 113, 'annuler_commande_client', 20, '', 0),
(2265, 114, 'categorie_piece', 20, '', 0),
(2266, 115, 'famille_produit', 20, '', 0),
(2267, 118, 'alertes_commerciales', 20, '', 0),
(2268, 119, 'alertes_administratives_juridiques', 20, '', 0),
(2269, 120, 'alertes_maintenances', 20, '', 0),
(2270, 121, 'alertes_consommations', 20, '', 0),
(2271, 122, 'alertes_parcs', 20, '', 0),
(2272, 123, 'alertes_stock', 20, '', 0),
(2273, 124, 'categorie_prix', 20, '', 0),
(2274, 125, 'visite_medicale', 20, '', 0),
(2275, 126, 'product_unit', 20, '', 0),
(2276, 127, 'lot_type', 20, '', 0),
(2277, 128, 'bon_reception', 20, '', 0),
(2278, 129, 'bon_livraison', 20, '', 0),
(2279, 130, 'retour_fournisseur', 20, '', 0),
(2280, 131, 'retour_client', 20, '', 0),
(2281, 132, 'bon_renvoi', 20, '', 0),
(2282, 133, 'bon_reintegration', 20, '', 0),
(2283, 134, 'facture_achat', 20, '', 0),
(2284, 135, 'avoir', 20, '', 0),
(2285, 136, 'parc_tableau_bord', 20, '', 0),
(2286, 137, 'causes_annulation', 20, '', 0),
(2287, 138, 'avertissement', 20, '', 0),
(2288, 139, 'type_avertissement', 20, '', 0),
(2289, 140, 'absence', 20, '', 0),
(2290, 141, 'raison_absence', 20, '', 0),
(2291, 142, 'avoir_vente', 20, '', 0),
(2292, 143, 'demande_produit', 20, '', 0),
(2293, 144, 'demande_achat', 20, '', 0),
(2294, 1, 'vehicule', 0, '', 0),
(2295, 2, 'totaux_vehicule', 0, '', 0),
(2296, 3, 'localisation_vehicule', 0, '', 0),
(2297, 4, 'categorie_vehicule', 0, '', 0),
(2298, 5, 'marque_vehicule', 0, '', 0),
(2299, 6, 'modele_vehicule', 0, '', 0),
(2300, 7, 'groupe_vehicule', 0, '', 0),
(2301, 8, 'type_vehicule', 0, '', 0),
(2302, 9, 'statut_vehicule', 0, '', 0),
(2303, 10, 'type_acquisition_vehicule', 0, '', 0),
(2304, 11, 'carburant', 0, '', 0),
(2305, 12, 'parc_vehicule', 0, '', 0),
(2306, 13, 'fournisseur', 0, '', 0),
(2307, 14, 'remorque', 0, '', 0),
(2308, 15, 'affectation', 0, '', 0),
(2309, 16, 'pv_affectation', 0, '', 0),
(2310, 17, 'decharge_affectation', 0, '', 0),
(2311, 18, 'option_affectation', 0, '', 0),
(2312, 19, 'zone_affectation', 0, '', 0),
(2313, 20, 'affectation_provisoire', 0, '', 0),
(2314, 21, 'demande_affectation', 0, '', 0),
(2315, 22, 'employe', 0, '', 0),
(2316, 23, 'frais_mission', 0, '', 0),
(2317, 24, 'categorie_employee', 0, '', 0),
(2318, 25, 'groupe_employe', 0, '', 0),
(2319, 26, 'affiliation_employe', 0, '', 0),
(2320, 27, 'departement', 0, '', 0),
(2321, 28, 'carnet_carburant', 0, '', 0),
(2322, 29, 'carte_carburant', 0, '', 0),
(2323, 30, 'affectation_carte_carburant', 0, '', 0),
(2324, 31, 'citerne', 0, '', 0),
(2325, 32, 'produit', 0, '', 0),
(2326, 33, 'type_produit', 0, '', 0),
(2327, 34, 'marque_produit', 0, '', 0),
(2328, 35, 'tva_produit', 0, '', 0),
(2329, 36, 'depot_produit', 0, '', 0),
(2330, 37, 'bon_entree', 0, '', 0),
(2331, 38, 'bon_sortie', 0, '', 0),
(2332, 39, 'commande_fournisseur', 0, '', 0),
(2333, 40, 'pneu', 0, '', 0),
(2334, 41, 'marque_pneu', 0, '', 0),
(2335, 42, 'position_pneu', 0, '', 0),
(2336, 43, 'emplacement_pneu', 0, '', 0),
(2337, 44, 'deplacement_pneu', 0, '', 0),
(2338, 45, 'verification_pneu', 0, '', 0),
(2339, 46, 'extincteur', 0, '', 0),
(2340, 47, 'deplacement_extincteur', 0, '', 0),
(2341, 48, 'recharge_extincteur', 0, '', 0),
(2342, 50, 'type_evenement', 0, '', 0),
(2343, 51, 'type_intervenant', 0, '', 0),
(2344, 52, 'intervenant', 0, '', 0),
(2345, 53, 'administratif_evenement', 0, '', 0),
(2346, 54, 'maintenance_evenement', 0, '', 0),
(2347, 55, 'demande_intervention', 0, '', 0),
(2348, 57, 'marchandise', 0, '', 0),
(2349, 58, 'type_marchandise', 0, '', 0),
(2350, 59, 'unite_marchandise', 0, '', 0),
(2351, 60, 'trajet', 0, '', 0),
(2352, 61, 'villes_trajet', 0, '', 0),
(2353, 62, 'wilaya', 0, '', 0),
(2354, 63, 'daira', 0, '', 0),
(2355, 64, 'categorie_trajet', 0, '', 0),
(2356, 65, 'detail_trajet', 0, '', 0),
(2357, 66, 'tarif_trajet', 0, '', 0),
(2358, 68, 'feuille_de_route', 0, '', 0),
(2359, 69, 'mission', 0, '', 0),
(2360, 70, 'piece_jointe_mission', 0, '', 0),
(2361, 71, 'marchandise_mission', 0, '', 0),
(2362, 73, 'client', 0, '', 0),
(2363, 74, 'importation_adresse_client', 0, '', 0),
(2364, 75, 'importation_contact_client', 0, '', 0),
(2365, 76, 'categorie_client', 0, '', 0),
(2366, 77, 'demande_de_devis', 0, '', 0),
(2367, 78, 'transformer_demande_devis', 0, '', 0),
(2368, 79, 'devis', 0, '', 0),
(2369, 80, 'transformer_devis', 0, '', 0),
(2370, 81, 'relancer_devis', 0, '', 0),
(2371, 82, 'dupliquer_devis', 0, '', 0),
(2372, 83, 'envoyer_devis_mail', 0, '', 0),
(2373, 84, 'commande_client', 0, '', 0),
(2374, 85, 'transformer_commande_client', 0, '', 0),
(2375, 86, 'detail_commande_client', 0, '', 0),
(2376, 87, 'prefacture', 0, '', 0),
(2377, 88, 'transformer_prefacture', 0, '', 0),
(2378, 89, 'paiement_prefacture', 0, '', 0),
(2379, 90, 'facture', 0, '', 0),
(2380, 91, 'paiement_facture', 0, '', 0),
(2381, 92, 'encaissement', 0, '', 0),
(2382, 93, 'decaissement', 0, '', 0),
(2383, 94, 'virement', 0, '', 0),
(2384, 95, 'journal_tresorerie', 0, '', 0),
(2385, 96, 'compte_tresorerie', 0, '', 0),
(2386, 97, 'contrat_affretement', 0, '', 0),
(2387, 98, 'ajout_vehicule_affretement', 0, '', 0),
(2388, 99, 'reservation_affretement', 0, '', 0),
(2389, 100, 'paiement_reservation_affretement', 0, '', 0),
(2390, 101, 'statistique_gestion_des_vehicules', 0, '', 0),
(2391, 102, 'statistique_gestion_des_consommations', 0, '', 0),
(2392, 103, 'statistique_gestion_commerciale', 0, '', 0),
(2393, 104, 'commercial_tableau_bord', 0, '', 0),
(2394, 105, 'planification_tableau_bord', 0, '', 0),
(2395, 106, 'finance_tableau_bord', 0, '', 0),
(2396, 107, 'alertes_tableau_bord', 0, '', 0),
(2397, 108, 'liens_tableau_bord', 0, '', 0),
(2398, 109, 'evenements_tableau_bord', 0, '', 0),
(2399, 110, 'type_piece_jointe_client', 0, '', 0),
(2400, 111, 'service', 0, '', 0),
(2401, 112, 'transmettre_commande_client', 0, '', 0),
(2402, 113, 'annuler_commande_client', 0, '', 0),
(2403, 114, 'categorie_piece', 0, '', 0),
(2404, 115, 'famille_produit', 0, '', 0),
(2405, 118, 'alertes_commerciales', 0, '', 0),
(2406, 119, 'alertes_administratives_juridiques', 0, '', 0),
(2407, 120, 'alertes_maintenances', 0, '', 0),
(2408, 121, 'alertes_consommations', 0, '', 0),
(2409, 122, 'alertes_parcs', 0, '', 0),
(2410, 123, 'alertes_stock', 0, '', 0),
(2411, 124, 'categorie_prix', 0, '', 0),
(2412, 125, 'visite_medicale', 0, '', 0),
(2413, 126, 'product_unit', 0, '', 0),
(2414, 127, 'lot_type', 0, '', 0),
(2415, 128, 'bon_reception', 0, '', 0),
(2416, 129, 'bon_livraison', 0, '', 0),
(2417, 130, 'retour_fournisseur', 0, '', 0),
(2418, 131, 'retour_client', 0, '', 0),
(2419, 132, 'bon_renvoi', 0, '', 0),
(2420, 133, 'bon_reintegration', 0, '', 0),
(2421, 134, 'facture_achat', 0, '', 0),
(2422, 135, 'avoir', 0, '', 0),
(2423, 136, 'parc_tableau_bord', 0, '', 0),
(2424, 137, 'causes_annulation', 0, '', 0),
(2425, 138, 'avertissement', 0, '', 0),
(2426, 139, 'type_avertissement', 0, '', 0),
(2427, 140, 'absence', 0, '', 0),
(2428, 141, 'raison_absence', 0, '', 0),
(2429, 142, 'avoir_vente', 0, '', 0),
(2430, 143, 'demande_produit', 0, '', 0),
(2431, 144, 'demande_achat', 0, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` smallint(6) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `department_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'identifiant du département'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `sheet_rides`
--

CREATE TABLE `sheet_rides` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `start_date` datetime DEFAULT NULL COMMENT 'Date de départ prévue',
  `real_start_date` datetime DEFAULT NULL COMMENT 'Date de départ réelle',
  `end_date` datetime DEFAULT NULL COMMENT 'Date d\\''arrivée prévue',
  `real_end_date` datetime DEFAULT NULL COMMENT 'Date d\\''arrivée réelle',
  `km_departure` float DEFAULT NULL COMMENT 'Km de départ',
  `km_arrival` float DEFAULT NULL COMMENT 'Km d\\''arrivée',
  `km_arrival_estimated` float DEFAULT NULL COMMENT 'Km d\\''arrivée estimée',
  `car_type_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'identifiant de véhicule ',
  `car_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `remorque_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL COMMENT 'identifiant de Conducteur',
  `status_id` smallint(2) NOT NULL,
  `last_zone_id` smallint(6) DEFAULT NULL,
  `last_arrival_destination_id` smallint(6) DEFAULT NULL COMMENT 'destination de la dernière arrivée',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  `date_open` datetime DEFAULT NULL,
  `last_opener` int(11) DEFAULT NULL COMMENT 'dernière ouverture',
  `tank_departure` smallint(4) DEFAULT NULL COMMENT 'réservoir du départ',
  `tank_arrival` smallint(4) DEFAULT NULL COMMENT 'réservoir d''arrivée',
  `tank_arrival_estimated` smallint(4) DEFAULT NULL COMMENT 'réservoir d''arrivée estimée',
  `forecast` decimal(11,2) DEFAULT NULL COMMENT 'estimation',
  `forecast_state` tinyint(2) NOT NULL DEFAULT '0',
  `difference_estimated` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT 'différence d\\''estimation ',
  `difference_real` decimal(11,2) NOT NULL DEFAULT '0.00',
  `coupon_price` decimal(7,2) DEFAULT NULL COMMENT 'prix de bon',
  `cost` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT 'Coût',
  `estimated_cost` decimal(11,2) NOT NULL DEFAULT '0.00',
  `km_liter` float DEFAULT NULL,
  `car_subcontracting` smallint(2) NOT NULL DEFAULT '2',
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL,
  `car_name` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `remorque_name` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `customer_name` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `cancel_cause_id` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `sheet_ride_conveyors`
--

CREATE TABLE `sheet_ride_conveyors` (
  `id` int(11) NOT NULL,
  `sheet_ride_id` int(11) NOT NULL,
  `conveyor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `sheet_ride_detail_rides`
--

CREATE TABLE `sheet_ride_detail_rides` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'identifiant client ',
  `supplier_final_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'client final',
  `detail_ride_id` int(11) DEFAULT NULL,
  `sheet_ride_id` int(11) NOT NULL,
  `from_customer_order` tinyint(2) NOT NULL DEFAULT '1',
  `invoiced_ride` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'trajet facturé',
  `truck_full` tinyint(2) NOT NULL DEFAULT '2' COMMENT 'camion plein',
  `return_mission` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'mission de retour',
  `type_price` tinyint(2) NOT NULL DEFAULT '1',
  `planned_start_date` datetime DEFAULT NULL COMMENT 'date de début prévue',
  `real_start_date` datetime DEFAULT NULL COMMENT 'Date de départ réelle',
  `km_departure` float DEFAULT NULL COMMENT 'Km de départ',
  `planned_end_date` datetime DEFAULT NULL COMMENT 'Date d''arrivée prévue',
  `real_end_date` datetime DEFAULT NULL COMMENT 'Date d''arrivée réelle',
  `km_arrival_estimated` float DEFAULT NULL COMMENT 'Km d''arrivée estimée',
  `km_arrival` float DEFAULT NULL COMMENT 'Km d''arrivée',
  `transport_bill_detail_ride_id` int(11) DEFAULT NULL,
  `observation_id` int(11) DEFAULT NULL,
  `status_id` tinyint(2) NOT NULL DEFAULT '1',
  `attachment1` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'pièce jointe1',
  `attachment2` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment3` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment4` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `attachment5` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `tank_departure` smallint(4) DEFAULT NULL COMMENT ' réservoir du départ  ',
  `tank_arrival` smallint(4) DEFAULT NULL COMMENT 'réservoir d''arrivée',
  `tank_arrival_estimated` smallint(4) DEFAULT NULL COMMENT 'réservoir d''arrivée estimée',
  `ride_category_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `mission_cost` decimal(11,2) DEFAULT NULL COMMENT 'Frais de mission',
  `toll` decimal(11,2) DEFAULT NULL,
  `amount_remaining` decimal(11,2) DEFAULT NULL,
  `note` text COLLATE utf8_bin NOT NULL,
  `remaining_time` double NOT NULL DEFAULT '0' COMMENT 'temps restant',
  `departure_destination_id` smallint(6) DEFAULT NULL COMMENT 'point de départ',
  `arrival_destination_id` smallint(6) DEFAULT NULL COMMENT 'Point d''arrivée',
  `price` double DEFAULT '0',
  `type_ride` tinyint(2) NOT NULL DEFAULT '1',
  `source` tinyint(2) NOT NULL DEFAULT '1',
  `type_pricing` tinyint(2) NOT NULL DEFAULT '1',
  `tonnage_id` smallint(5) DEFAULT NULL,
  `cancel_cause_id` smallint(5) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `sheet_ride_detail_ride_marchandises`
--

CREATE TABLE `sheet_ride_detail_ride_marchandises` (
  `id` int(11) NOT NULL,
  `marchandise_id` int(11) NOT NULL COMMENT 'identifiant de marchandise',
  `sheet_ride_detail_ride_id` int(11) NOT NULL COMMENT 'identifiant détail mission',
  `quantity` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `shifting`
--

CREATE TABLE `shifting` (
  `id` int(11) NOT NULL,
  `shifting_date` date NOT NULL COMMENT 'Date de déplacement',
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `installed` tinyint(1) NOT NULL DEFAULT '0',
  `km` int(6) DEFAULT NULL,
  `car_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `tire_id` int(11) NOT NULL COMMENT 'identifiant pneu ',
  `position_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `location_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8_bin,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `statistics`
--

CREATE TABLE `statistics` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_bin NOT NULL,
  `created` varchar(250) COLLATE utf8_bin NOT NULL,
  `modified` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `sub_modules`
--

CREATE TABLE `sub_modules` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `module_id` tinyint(3) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `sub_modules`
--

INSERT INTO `sub_modules` (`id`, `code`, `name`, `module_id`, `created`, `modified`) VALUES
(1, 'vehicule', 'Véhicule', 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(2, 'affectation', 'Affectation', 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(3, 'affectation_provisoire', 'Affectation provisoire', 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(4, 'demande_affectation', 'Demande d\'affectation', 1, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(5, 'employe', 'Employé', 2, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(6, 'consommation', 'Consommation', 3, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(7, 'produit', 'Produit', 3, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(8, 'pneu', 'Pneus', 3, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(9, 'extincteur', 'Extincteur', 3, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(10, 'evenement', 'Evènement', 4, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(11, 'demande-intervention', 'Demande d\'intervention', 4, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(12, 'marchandise', 'Marchandise', 5, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(13, 'trajet', 'Trajet', 5, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(14, 'feuille_de_route', 'Feuille de route', 5, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(15, 'client', 'Client', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(16, 'demande_devis', 'Demande de devis', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(17, 'devis', 'Devis', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(18, 'commande_client', 'Commande', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(19, 'detail_commande_client', 'Détail commande', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(20, 'prefacture', 'Préfacture', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(21, 'facture', 'Facture', 6, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(22, 'encaissement', 'Encaissement', 7, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(23, 'decaissement', 'Décaissement', 7, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(24, 'virement', 'Virement', 7, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(25, 'journal_tresorerie', 'Journal', 7, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(26, 'compte_tresorerie', 'Compte', 7, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(27, 'contrat_affretement', 'Contrat', 8, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(28, 'ajout_vehicule_affretement', 'Ajout véhicule', 8, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(29, 'reservation_affretement', 'Réservation', 8, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(30, 'statistique', 'Statistique', 9, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(31, 'tableau_bord', 'Tableau de bord', 10, '2018-08-11 00:00:00', '2018-08-11 00:00:00'),
(32, 'alertes', 'Alertes', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'visite_medicale', 'Visite médicale', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'bons', 'Bons', 3, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(35, 'commande_fournisseur', 'Commande fournisseur', 12, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(36, 'facture_achat', 'Facture d\'achat', 12, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(37, 'avoir', 'Avoir sur achat', 12, '2019-02-21 00:00:00', '2019-02-21 00:00:00'),
(38, 'avertissement', 'Avertissement', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'absence', 'Absence', 2, '2019-04-09 00:00:00', '2019-04-09 00:00:00'),
(40, 'avoir_vente', 'Avoir sur vente', 6, '2019-04-17 00:00:00', '2019-04-17 00:00:00'),
(41, 'demande_produit', 'Demande produit', 13, '2019-11-13 00:00:00', '2019-11-13 00:00:00'),
(42, 'demande_achat', 'Demande d\"achat', 13, '2019-11-13 00:00:00', '2019-11-13 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `adress` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `code_address` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'Code existant dans la géolocalisation (synchronisation)',
  `latlng` text COLLATE utf8_bin,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tel` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `nb_cars` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Nombre de véhicule',
  `note` text COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `if` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ai` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `rc` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `nis` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `cb` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `social_reason` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'raison social',
  `legal_form_id` int(3) DEFAULT NULL,
  `supplier_category_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'identifiant de catégorie de fournisseur ou client',
  `town` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT 'ville',
  `state` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `contact` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `active` smallint(1) NOT NULL DEFAULT '1',
  `balance` double NOT NULL DEFAULT '0' COMMENT 'solde client',
  `final_customer` smallint(2) NOT NULL DEFAULT '2' COMMENT 'client final',
  `automatic_order_validation` tinyint(1) NOT NULL DEFAULT '0',
  `is_special` smallint(2) NOT NULL DEFAULT '1',
  `internal_external` smallint(2) NOT NULL DEFAULT '2',
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `suppliers`
--

INSERT INTO `suppliers` (`id`, `code`, `name`, `adress`, `code_address`, `latlng`, `latitude`, `longitude`, `tel`, `nb_cars`, `note`, `created`, `modified`, `user_id`, `last_modifier_id`, `type`, `if`, `ai`, `rc`, `nis`, `cb`, `social_reason`, `legal_form_id`, `supplier_category_id`, `town`, `state`, `email`, `contact`, `active`, `balance`, `final_customer`, `automatic_order_validation`, `is_special`, `internal_external`, `parent_id`) VALUES
(1, 'fournisseur_special', 'fournisseur spécial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, 0, 2, 2, NULL),
(2, 'client_special', 'client spécial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 2, 0, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `supplier_addresses`
--

CREATE TABLE `supplier_addresses` (
  `id` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8_bin NOT NULL,
  `address` varchar(100) COLLATE utf8_bin NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `latlng` text COLLATE utf8_bin NOT NULL,
  `supplier_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `supplier_attachment_types`
--

CREATE TABLE `supplier_attachment_types` (
  `id` int(11) NOT NULL,
  `supplier_id` smallint(5) UNSIGNED NOT NULL,
  `attachment_type_id` smallint(5) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `supplier_categories`
--

CREATE TABLE `supplier_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL COMMENT 'créé',
  `modified` datetime DEFAULT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `supplier_categories`
--

INSERT INTO `supplier_categories` (`id`, `code`, `name`, `type`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '01', 'Sous traitant', 0, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `supplier_contacts`
--

CREATE TABLE `supplier_contacts` (
  `id` int(11) NOT NULL,
  `contact` varchar(150) COLLATE utf8_bin NOT NULL,
  `function` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `email1` varchar(150) COLLATE utf8_bin NOT NULL,
  `email2` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `email3` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(150) COLLATE utf8_bin NOT NULL,
  `supplier_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `tanks`
--

CREATE TABLE `tanks` (
  `id` smallint(4) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `fuel_id` tinyint(4) NOT NULL,
  `capacity` double NOT NULL,
  `liter` float NOT NULL DEFAULT '0',
  `localisation` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `tank_operations`
--

CREATE TABLE `tank_operations` (
  `id` int(11) NOT NULL,
  `liter` decimal(11,2) NOT NULL,
  `tank_id` smallint(2) NOT NULL COMMENT 'réservoir',
  `date_add` datetime NOT NULL,
  `type` tinyint(1) NOT NULL,
  `sheet_ride_id` int(11) DEFAULT NULL COMMENT 'feuille de route',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `tires`
--

CREATE TABLE `tires` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `model` varchar(150) COLLATE utf8_bin NOT NULL,
  `tire_mark_id` smallint(5) UNSIGNED NOT NULL COMMENT 'identifiant  marques de pneus',
  `purchase_date` date DEFAULT NULL COMMENT 'Date d\\''achat',
  `cost` decimal(11,2) DEFAULT NULL COMMENT 'Coût',
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Fournisseur',
  `attachment` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `note` text COLLATE utf8_bin,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `tire_marks`
--

CREATE TABLE `tire_marks` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `tire_marks`
--

INSERT INTO `tire_marks` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'TRIANGLE', '2017-10-21 10:44:55', '2017-10-21 10:44:55', 4, 0),
(2, '', 'LIONSTON', '2017-10-21 10:45:17', '2017-10-21 10:45:17', 4, 0),
(3, '', 'BRIDGESTONE', '2017-10-21 10:45:31', '2017-10-21 10:45:58', 4, 4),
(4, '', 'MICHELIN', '2017-10-21 10:46:31', '2017-10-21 10:46:31', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tonnages`
--

CREATE TABLE `tonnages` (
  `id` smallint(5) NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `tonnages`
--

INSERT INTO `tonnages` (`id`, `code`, `name`, `user_id`, `modified_id`, `created`, `modified`) VALUES
(3, '001', '1,5 T', 1, 0, '2019-02-19 16:30:07', '2019-02-19 16:30:07');

-- --------------------------------------------------------

--
-- Structure de la table `transformations`
--

CREATE TABLE `transformations` (
  `id` int(11) NOT NULL,
  `origin_transport_bill_id` int(11) NOT NULL COMMENT 'des pièces( factures/devis..) d\\''origine',
  `new_transport_bill_id` int(11) NOT NULL COMMENT 'nouveau piéce ( facteur / préfecture / devis...)',
  `origin_type` int(4) NOT NULL,
  `new_type` int(4) NOT NULL,
  `category` smallint(2) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `transport_bills`
--

CREATE TABLE `transport_bills` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `type` tinyint(2) NOT NULL,
  `total_ht` double NOT NULL,
  `total_ttc` double NOT NULL,
  `total_tva` double NOT NULL,
  `amount_remaining` double DEFAULT NULL COMMENT 'montant qui reste a payé',
  `ristourne_val` double DEFAULT NULL COMMENT 'Remise',
  `ristourne_percentage` double DEFAULT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'identifiant client',
  `supplier_final_id` smallint(5) UNSIGNED DEFAULT NULL,
  `ride_id` int(11) DEFAULT NULL COMMENT 'identifiant trajet',
  `car_type_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `ride_category_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `nb_trucks` smallint(6) DEFAULT NULL COMMENT 'Nombre de camion',
  `total_weight` double DEFAULT NULL COMMENT 'poids total',
  `detail_ride_id` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `status_payment` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'Etat de payement ',
  `payment_type` tinyint(2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `modified_id` int(11) NOT NULL DEFAULT '0',
  `relance` tinyint(2) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `delivery_with_return` tinyint(1) NOT NULL DEFAULT '2' COMMENT 'livraison avec retour',
  `payment_method` tinyint(2) DEFAULT NULL,
  `stamp` double DEFAULT NULL,
  `note` text COLLATE utf8_bin,
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  `date_open` datetime DEFAULT NULL,
  `last_opener` int(11) DEFAULT NULL,
  `transport_bill_category_id` smallint(5) UNSIGNED DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `cancel_cause_id` smallint(5) DEFAULT NULL,
  `locked` smallint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `transport_bill_categories`
--

CREATE TABLE `transport_bill_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `transport_bill_categories`
--

INSERT INTO `transport_bill_categories` (`id`, `code`, `name`, `user_id`, `last_modifier_id`, `created`, `modified`) VALUES
(1, '001', 'archivée', 1, 0, '2018-10-30 09:36:42', '2018-10-30 09:36:42'),
(2, '002', 'Tous', 1, 0, '2019-05-05 15:08:24', '2019-05-05 15:08:24'),
(3, '003', 'Sans', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `transport_bill_detail_rides`
--

CREATE TABLE `transport_bill_detail_rides` (
  `id` int(11) NOT NULL,
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
  `cancel_cause_id` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

CREATE TABLE `tva` (
  `id` tinyint(2) NOT NULL,
  `code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `tva_val` decimal(2,2) NOT NULL COMMENT 'valeur TVA',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'identifiant de dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `tva`
--

INSERT INTO `tva` (`id`, `code`, `name`, `tva_val`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, NULL, '19%', '0.19', '2016-03-15 10:02:19', '2016-03-15 10:03:22', 4, 4),
(2, NULL, '9%', '0.09', '2016-03-15 10:17:11', '2016-03-15 10:17:11', 4, 0),
(3, NULL, '0%', '0.00', '2016-03-15 10:17:11', '2016-03-15 10:17:11', 4, 0),
(4, NULL, 'Sans', '0.00', '2016-03-15 10:17:24', '2016-03-15 10:17:24', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) COLLATE utf8_bin NOT NULL,
  `supplier_id` smallint(5) UNSIGNED DEFAULT NULL,
  `service_id` smallint(6) DEFAULT NULL,
  `last_name` varchar(150) COLLATE utf8_bin NOT NULL,
  `email` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'nom de utilisateur',
  `password` varchar(150) COLLATE utf8_bin NOT NULL,
  `secret_password` varchar(150) COLLATE utf8_bin NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'photo',
  `role_id` smallint(2) DEFAULT NULL COMMENT 'utilisateur est un super admin ou non',
  `car_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `language_id` smallint(2) DEFAULT NULL,
  `limit` smallint(3) DEFAULT NULL,
  `profile_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `last_visit_date` datetime DEFAULT NULL COMMENT 'date de la dernière visite',
  `time_actif` datetime NOT NULL,
  `receive_alert` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'recevoir une alerte',
  `receive_notification` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `supplier_id`, `service_id`, `last_name`, `email`, `username`, `password`, `secret_password`, `created`, `modified`, `picture`, `role_id`, `car_id`, `language_id`, `limit`, `profile_id`, `last_visit_date`, `time_actif`, `receive_alert`, `receive_notification`) VALUES
(0, '', NULL, NULL, '', NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, 0),
(1, 'superadmin', NULL, NULL, 'superadmin', NULL, 'superadmin', '3840024432f8f8a95812b82eacc2e8b944db17cb', '', '2016-08-16 16:32:18', '2020-01-06 09:29:47', '', 3, 9, NULL, 25, NULL, '2020-01-06 09:26:00', '2020-01-06 09:29:00', 0, 0),
(4, 'admin', NULL, NULL, 'admin', 'k_ouabou@esi.dz', 'admin', '8706e4cf731ef8c5e721bacb88eb1faba63048a5', 'admin', '2015-01-06 09:56:36', '2019-01-23 17:18:02', '12373336_10153746494919757_7369037261112741147_n.jpg', 3, 4, 1, 500, 1, '2019-01-23 17:17:00', '2019-01-23 17:18:00', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user_parc`
--

CREATE TABLE `user_parc` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'identifiant de utilisateur',
  `parc_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `verifications`
--

CREATE TABLE `verifications` (
  `id` int(11) NOT NULL,
  `reference` varchar(150) COLLATE utf8_bin NOT NULL,
  `tire_id` int(11) NOT NULL COMMENT 'identifiant de pneu',
  `date_verif` date NOT NULL COMMENT 'date de verification',
  `bande` int(6) NOT NULL COMMENT 'bande de roulement',
  `km` int(6) DEFAULT NULL,
  `wear` int(6) NOT NULL COMMENT 'usure',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `modified_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `warnings`
--

CREATE TABLE `warnings` (
  `id` int(11) NOT NULL,
  `code` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `warning_type_id` smallint(5) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_bin,
  `attachment` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `warning_types`
--

CREATE TABLE `warning_types` (
  `id` smallint(5) NOT NULL,
  `code` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `warning_types`
--

INSERT INTO `warning_types` (`id`, `code`, `name`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(3, '001', 'absence non justifiée', '2019-03-27 14:47:02', '2019-03-27 14:47:02', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `zone_id` smallint(6) DEFAULT NULL,
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

--
-- Contenu de la table `wilayas`
--

INSERT INTO `wilayas` (`id`, `code`, `name`, `zone_id`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '001', 'Tanger – Tétouan – Al Hoceima', NULL, '2020-01-05 12:23:32', '2020-01-05 12:23:32', 1, 0),
(2, '002', 'L\'oriental', NULL, '2020-01-05 12:23:49', '2020-01-05 12:23:49', 1, 0),
(3, '003', 'Fès - Meknès', NULL, '2020-01-05 12:24:06', '2020-01-05 12:24:06', 1, 0),
(4, '004', 'Rabat - Salé- Kénitra', NULL, '2020-01-05 12:24:24', '2020-01-05 12:24:24', 1, 0),
(5, '005', 'Béni Mellal- Khénifra', NULL, '2020-01-05 12:24:39', '2020-01-05 12:24:39', 1, 0),
(6, '006', 'Casablanca- Settat', NULL, '2020-01-05 12:24:52', '2020-01-05 12:24:52', 1, 0),
(7, '007', 'Marrakech - Safi', NULL, '2020-01-05 12:25:14', '2020-01-05 12:25:14', 1, 0),
(8, '008', 'Darâa - Tafilalet', NULL, '2020-01-05 12:25:34', '2020-01-05 12:25:34', 1, 0),
(9, '009', 'Souss - Massa', NULL, '2020-01-05 12:25:48', '2020-01-05 12:25:48', 1, 0),
(10, '010', 'Guelmim - Oued Noun', NULL, '2020-01-05 12:26:05', '2020-01-05 12:26:05', 1, 0),
(11, '011', 'Laâyoune - Sakia El Hamra', NULL, '2020-01-05 12:26:22', '2020-01-05 12:26:22', 1, 0),
(12, '012', 'Dakhla-Oued Eddahab', NULL, '2020-01-05 12:26:37', '2020-01-05 12:26:37', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

CREATE TABLE `zones` (
  `id` smallint(6) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `cost` decimal(11,2) DEFAULT NULL COMMENT 'frais de missions',
  `rotation_number` smallint(6) DEFAULT NULL COMMENT 'Nombre de rotation',
  `rotation_number_type` smallint(1) DEFAULT NULL COMMENT 'type Nombre de rotation:jour/semaine',
  `created` datetime NOT NULL COMMENT 'créé',
  `modified` datetime NOT NULL COMMENT 'modifié',
  `user_id` int(11) NOT NULL,
  `last_modifier_id` int(11) NOT NULL COMMENT 'dernier modificateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `zones`
--

INSERT INTO `zones` (`id`, `code`, `name`, `cost`, `rotation_number`, `rotation_number_type`, `created`, `modified`, `user_id`, `last_modifier_id`) VALUES
(1, '', 'Zone Est', NULL, NULL, NULL, '2015-04-25 13:35:00', '2015-04-25 13:35:47', 0, 0),
(2, '', 'Zone Ouest', NULL, NULL, NULL, '2015-04-25 13:35:11', '2015-04-25 13:35:11', 0, 0),
(3, '', 'Zone Centre', NULL, NULL, NULL, '2015-04-25 13:35:29', '2015-04-25 13:35:29', 0, 0),
(4, '', 'Zone Sud', NULL, NULL, NULL, '2016-12-25 16:41:50', '2016-12-25 16:41:50', 0, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_absence_customer` (`customer_id`),
  ADD KEY `fk_absence_absence_reason` (`absence_reason_id`);

--
-- Index pour la table `absence_reasons`
--
ALTER TABLE `absence_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `access_permissions`
--
ALTER TABLE `access_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_access_permission_section` (`section_id`),
  ADD KEY `fk_access_permission_action` (`action_id`),
  ADD KEY `fk_access_permission_profil` (`profile_id`);

--
-- Index pour la table `acquisition_types`
--
ALTER TABLE `acquisition_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `affectationpvs`
--
ALTER TABLE `affectationpvs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_affectationpv_customer_car` (`customer_car_id`),
  ADD KEY `fk_affectationpv_user1` (`user_id`),
  ADD KEY `fk_affectationpv_user2` (`last_modifier_id`);

--
-- Index pour la table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_affiliate_user1` (`user_id`),
  ADD KEY `fk_affiliate_user2` (`last_modifier_id`);

--
-- Index pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `alert_types`
--
ALTER TABLE `alert_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attachment_attachment_type` (`attachment_type_id`),
  ADD KEY `fk_attachment_user1` (`user_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Index pour la table `attachment_types`
--
ALTER TABLE `attachment_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attachment_type_user1` (`user_id`),
  ADD KEY `fk_attachment_type_user2` (`last_modifier_id`),
  ADD KEY `fk_attachment_type_section` (`section_id`);

--
-- Index pour la table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_rubric` (`rubric_id`),
  ADD KEY `fk_audit_user1` (`user_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `fk_audit_action` (`action_id`);

--
-- Index pour la table `autorisations`
--
ALTER TABLE `autorisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_autorisations_customer_car` (`customer_car_id`),
  ADD KEY `fk_autorisations_user` (`user_id`);

--
-- Index pour la table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bills_supplier` (`supplier_id`),
  ADD KEY `fk_bills_event` (`event_id`),
  ADD KEY `fk_bills_ride` (`ride_id`),
  ADD KEY `fk_bills_user1` (`user_id`),
  ADD KEY `fk_bills_user2` (`modified_id`),
  ADD KEY `type_bill` (`type`),
  ADD KEY `fk_bill_category` (`transport_bill_category_id`),
  ADD KEY `fk_bill_sheet_ride_detail_ride` (`sheet_ride_detail_ride_id`);

--
-- Index pour la table `bill_products`
--
ALTER TABLE `bill_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_bill_bill` (`bill_id`),
  ADD KEY `fk_product_bill_product` (`lot_id`),
  ADD KEY `fk_bill_product_tva` (`tva_id`);

--
-- Index pour la table `bill_services`
--
ALTER TABLE `bill_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bill_service_bill` (`bill_id`),
  ADD KEY `fk_bill_service_service` (`service_id`);

--
-- Index pour la table `cake_sessions`
--
ALTER TABLE `cake_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cancel_causes`
--
ALTER TABLE `cancel_causes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_car_supplier` (`supplier_id`),
  ADD KEY `fk_car_car_status` (`car_status_id`),
  ADD KEY `fk_car_car_type` (`car_type_id`),
  ADD KEY `fk_car_car_category` (`car_category_id`),
  ADD KEY `fk_car_fuel` (`fuel_id`),
  ADD KEY `fk_car_department` (`department_id`),
  ADD KEY `fk_car_acquisition_type` (`acquisition_type_id`),
  ADD KEY `fk_car_parc` (`parc_id`),
  ADD KEY `in_mission` (`in_mission`);

--
-- Index pour la table `carmodels`
--
ALTER TABLE `carmodels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_carmodel_mark` (`mark_id`),
  ADD KEY `fk_carmodel_user` (`user_id`);

--
-- Index pour la table `car_car_statuses`
--
ALTER TABLE `car_car_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `car_status_id` (`car_status_id`);

--
-- Index pour la table `car_categories`
--
ALTER TABLE `car_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_category_user1` (`user_id`),
  ADD KEY `car_category_user2` (`last_modifier_id`);

--
-- Index pour la table `car_groups`
--
ALTER TABLE `car_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_group_user1` (`user_id`),
  ADD KEY `car_group_user2` (`last_modifier_id`);

--
-- Index pour la table `car_options`
--
ALTER TABLE `car_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_option_user1` (`user_id`),
  ADD KEY `car_option_user2` (`last_modifier_id`);

--
-- Index pour la table `car_options_customer_car`
--
ALTER TABLE `car_options_customer_car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_car_options_customer_car_customer_car` (`customer_car_id`),
  ADD KEY `fk_car_options_customer_car_car_option` (`car_option_id`);

--
-- Index pour la table `car_statuses`
--
ALTER TABLE `car_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `car_types`
--
ALTER TABLE `car_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `car_type_car_categories`
--
ALTER TABLE `car_type_car_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_car_type` (`car_type_id`),
  ADD KEY `fk_car_category` (`car_category_id`);

--
-- Index pour la table `code_logs`
--
ALTER TABLE `code_logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_legal_form` (`legal_form_id`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consumptions`
--
ALTER TABLE `consumptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumption_sheet_ride` (`sheet_ride_id`),
  ADD KEY `fk_consumption_fuel_card` (`fuel_card_id`),
  ADD KEY `fk_consumption_tank` (`tank_id`);

--
-- Index pour la table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contract_supplier` (`supplier_id`),
  ADD KEY `fk_contract_user1` (`user_id`),
  ADD KEY `fk_contract_user2` (`last_modifier_id`);

--
-- Index pour la table `contract_car_types`
--
ALTER TABLE `contract_car_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contract_car_type_contract` (`contract_id`),
  ADD KEY `fk_contract_car_type_detail_ride` (`detail_ride_id`);

--
-- Index pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_coupons_fuellogs` (`fuel_log_id`),
  ADD KEY `fk_coupons_consumption` (`consumption_id`);

--
-- Index pour la table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_customer_nationality` (`nationality_id`),
  ADD KEY `fk_customer_customer_group` (`customer_group_id`),
  ADD KEY `fk_customer_zone` (`zone_id`),
  ADD KEY `fk_customer_parc` (`parc_id`),
  ADD KEY `fk_customer_user1` (`user_id`),
  ADD KEY `fk_customer_user2` (`modified_id`),
  ADD KEY `fk_customer_service` (`service_id`),
  ADD KEY `fk_customer_affiliate` (`affiliate_id`),
  ADD KEY `fk_customer_user3` (`last_opener`),
  ADD KEY `in_mission` (`in_mission`),
  ADD KEY `fk_customer_customer_categoy` (`customer_category_id`);

--
-- Index pour la table `customer_car`
--
ALTER TABLE `customer_car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_car_user1` (`user_id`),
  ADD KEY `fk_customer_car_user2` (`modified_id`),
  ADD KEY `fk_customer_car_car_type` (`car_type_id`),
  ADD KEY `fk_customer_car_remorque` (`remorque_id`),
  ADD KEY `fk_customer_car_customer` (`customer_id`),
  ADD KEY `fk_customer_car_customer_group` (`customer_group_id`),
  ADD KEY `fk_customer_car_zone` (`zone_id`),
  ADD KEY `fk_customer_car_user3` (`last_opener`),
  ADD KEY `fk_customer_car_car` (`car_id`);

--
-- Index pour la table `customer_categories`
--
ALTER TABLE `customer_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dairas`
--
ALTER TABLE `dairas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daira_wilaya` (`wilaya_id`);

--
-- Index pour la table `deadlines`
--
ALTER TABLE `deadlines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depots`
--
ALTER TABLE `depots`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_daira` (`daira_id`),
  ADD KEY `wilaya_id` (`wilaya_id`);

--
-- Index pour la table `detail_payments`
--
ALTER TABLE `detail_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_payment_payment` (`payment_id`);

--
-- Index pour la table `detail_rides`
--
ALTER TABLE `detail_rides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ride_id` (`ride_id`,`car_type_id`),
  ADD KEY `detail_ride_ride` (`ride_id`),
  ADD KEY `detail_ride_car_type` (`car_type_id`);

--
-- Index pour la table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_user1` (`user_id`),
  ADD KEY `fk_event_user2` (`modified_id`),
  ADD KEY `fk_event_interfering` (`interfering_id`),
  ADD KEY `fk_event_customer` (`customer_id`),
  ADD KEY `fk_event_user3` (`last_opener`),
  ADD KEY `fk_event_event_type` (`event_type_id`),
  ADD KEY `fk_event_car` (`car_id`),
  ADD KEY `fk_event_mechanician` (`mechanician_id`);

--
-- Index pour la table `event_category_interfering`
--
ALTER TABLE `event_category_interfering`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_category_interfering_event` (`event_id`),
  ADD KEY ` event_category_interfering_event_type_category` (`event_type_category_id`),
  ADD KEY `event_category_interfering_interfering0` (`interfering_id0`),
  ADD KEY `event_category_interfering_interfering1` (`interfering_id1`),
  ADD KEY `event_category_interfering_interfering2` (`interfering_id2`);

--
-- Index pour la table `event_event_types`
--
ALTER TABLE `event_event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_event_type_event` (`event_id`),
  ADD KEY `event_event_type_event_type` (`event_type_id`);

--
-- Index pour la table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `event_type_categories`
--
ALTER TABLE `event_type_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `event_type_category_event_type`
--
ALTER TABLE `event_type_category_event_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_type` (`event_type_id`),
  ADD KEY ` fk_event_type_category` (`event_type_category_id`);

--
-- Index pour la table `extinguishers`
--
ALTER TABLE `extinguishers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extinguisher_supplier` (`supplier_id`),
  ADD KEY `extinguisher_location` (`location_id`);

--
-- Index pour la table `final_supplier_initial_suppliers`
--
ALTER TABLE `final_supplier_initial_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `initial_supplier_id` (`initial_supplier_id`,`final_supplier_id`),
  ADD KEY `fk_initial_supplier` (`initial_supplier_id`),
  ADD KEY `fk_final_supplier` (`final_supplier_id`);

--
-- Index pour la table `fuels`
--
ALTER TABLE `fuels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fuel_cards`
--
ALTER TABLE `fuel_cards`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fuel_card_affectations`
--
ALTER TABLE `fuel_card_affectations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fuel_card_affectation_fuel_card` (`fuel_card_id`);

--
-- Index pour la table `fuel_card_cars`
--
ALTER TABLE `fuel_card_cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fuel_card_car_car` (`car_id`);

--
-- Index pour la table `fuel_card_mouvements`
--
ALTER TABLE `fuel_card_mouvements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fuel_card_mouvement_fuel_card` (`fuel_card_id`),
  ADD KEY `fk_fuel_card_mouvement_sheet_ride` (`sheet_ride_id`);

--
-- Index pour la table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `interferings`
--
ALTER TABLE `interferings`
  ADD PRIMARY KEY (`id`,`interfering_type_id`),
  ADD KEY `fk_interfering_interfering_type1_idx` (`interfering_type_id`);

--
-- Index pour la table `interfering_types`
--
ALTER TABLE `interfering_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `interfering_type_event_type`
--
ALTER TABLE `interfering_type_event_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_interfering_type` (`interfering_type_id`);

--
-- Index pour la table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `leasings`
--
ALTER TABLE `leasings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_leasing_car` (`car_id`),
  ADD KEY `fk_leasing_supplier` (`supplier_id`),
  ADD KEY `fk_leasing_acquisition_type` (`acquisition_type_id`);

--
-- Index pour la table `legal_form`
--
ALTER TABLE `legal_form`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lot_lot_type` (`lot_type_id`),
  ADD KEY `fk_lot_product_unit` (`product_unit_id`),
  ADD KEY `fk_lot_product` (`product_id`),
  ADD KEY `fk_lot_tva` (`tva_id`);

--
-- Index pour la table `lot_types`
--
ALTER TABLE `lot_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marchandises`
--
ALTER TABLE `marchandises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_marchandise_marchandise_type` (`marchandise_type_id`),
  ADD KEY `fk_marchandise_marchandise_unit` (`marchandise_unit_id`),
  ADD KEY `fk_marchandise_supplier` (`supplier_id`);

--
-- Index pour la table `marchandise_types`
--
ALTER TABLE `marchandise_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marchandise_units`
--
ALTER TABLE `marchandise_units`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mark_user1` (`user_id`),
  ADD KEY `mark_user2` (`last_modifier_id`);

--
-- Index pour la table `medical_visits`
--
ALTER TABLE `medical_visits`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_visit_customer` (`customer_id`);

--
-- Index pour la table `mission_costs`
--
ALTER TABLE `mission_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mission_cost_detail_ride` (`detail_ride_id`),
  ADD KEY `fk_mission_cost_ride_categorie` (`ride_category_id`);

--
-- Index pour la table `mission_cost_parameters`
--
ALTER TABLE `mission_cost_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `monthlykms`
--
ALTER TABLE `monthlykms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_monthlykm_car` (`car_id`);

--
-- Index pour la table `movings`
--
ALTER TABLE `movings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_moving_car` (`car_id`),
  ADD KEY `fk_moving_extinguisher` (`extinguisher_id`);

--
-- Index pour la table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notification_transport_bill` (`transport_bill_id`),
  ADD KEY `fk_notification_transmitter` (`transmitter_id`),
  ADD KEY `fk_notification_receiver` (`receiver_id`),
  ADD KEY `read_notif` (`read_notif`);

--
-- Index pour la table `observations`
--
ALTER TABLE `observations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_observation_transport_bill_detail_ride` (`transport_bill_detail_ride_id`),
  ADD KEY `fk_observation_cancel_cause` (`cancel_cause_id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parcs`
--
ALTER TABLE `parcs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_car` (`car_id`),
  ADD KEY `fk_payment_event` (`event_id`),
  ADD KEY `fk_payment_supplier` (`supplier_id`),
  ADD KEY `fk_payment_interfering` (`interfering_id`),
  ADD KEY `fk_payment_customer` (`customer_id`),
  ADD KEY `fk_payment_payment_association` (`payment_association_id`),
  ADD KEY `fk_payment_compte` (`compte_id`),
  ADD KEY `fk_payment_user1` (`user_id`),
  ADD KEY `fk_payment_user2` (`modified_id`),
  ADD KEY `fk_payment_payment_category` (`payment_category_id`);

--
-- Index pour la table `payment_associations`
--
ALTER TABLE `payment_associations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payment_categories`
--
ALTER TABLE `payment_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_price_detail_ride` (`detail_ride_id`),
  ADD KEY `fk_price_supplier` (`supplier_id`),
  ADD KEY `fk_price_supplier_category` (`supplier_category_id`),
  ADD KEY `fk_price_tonnage` (`tonnage_id`),
  ADD KEY `fk_price_service` (`service_id`);

--
-- Index pour la table `price_categories`
--
ALTER TABLE `price_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `price_ride_categories`
--
ALTER TABLE `price_ride_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_price_ride_category_price` (`price_id`),
  ADD KEY `fk_price_ride_category_ride_category` (`ride_category_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product_product_type` (`product_category_id`),
  ADD KEY `FK_products_depots` (`depot_id`),
  ADD KEY `fk_products_tva` (`tva_id`),
  ADD KEY `fk_products_product_mark` (`product_mark_id`),
  ADD KEY `fk_products_user1` (`user_id`),
  ADD KEY `fk_products_user2` (`modified_id`);

--
-- Index pour la table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_families`
--
ALTER TABLE `product_families`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_famille_parent` (`parent_id`);

--
-- Index pour la table `product_marks`
--
ALTER TABLE `product_marks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profile_parent` (`parent_id`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recharges`
--
ALTER TABLE `recharges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recharge_extinguisher` (`extinguisher_id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservation_sheet_ride_detail_ride` (`sheet_ride_detail_ride_id`);

--
-- Index pour la table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departure_destination_id` (`departure_destination_id`,`arrival_destination_id`),
  ADD KEY `fk_ride_destination1` (`departure_destination_id`),
  ADD KEY `fk_ride_destination2` (`arrival_destination_id`);

--
-- Index pour la table `ride_categories`
--
ALTER TABLE `ride_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rubrics`
--
ALTER TABLE `rubrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubric_user1` (`user_id`),
  ADD KEY `rubric_user2` (`last_modifier_id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_section_sub_module` (`sub_module_id`);

--
-- Index pour la table `section_actions`
--
ALTER TABLE `section_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_section_action_section` (`section_id`),
  ADD KEY `fk_section_action_action` (`action_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_department` (`department_id`);

--
-- Index pour la table `sheet_rides`
--
ALTER TABLE `sheet_rides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_sheet_ride_user1` (`user_id`),
  ADD KEY `fk_sheet_ride_car_type` (`car_type_id`),
  ADD KEY `fk_sheet_ride_customer` (`customer_id`),
  ADD KEY `fk_sheet_ride_last_opener` (`last_opener`),
  ADD KEY `fk_sheet_ride_car` (`car_id`),
  ADD KEY `fk_sheet_ride_remorque` (`remorque_id`),
  ADD KEY `fk_sheet_ride_user2` (`modified_id`),
  ADD KEY `fk_sheet_ride_zone` (`last_zone_id`),
  ADD KEY `fk_sheet_ride_destination` (`last_arrival_destination_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_sheet_ride_cancel_cause` (`cancel_cause_id`);

--
-- Index pour la table `sheet_ride_conveyors`
--
ALTER TABLE `sheet_ride_conveyors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sheet_ride_detail_rides`
--
ALTER TABLE `sheet_ride_detail_rides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sheet_ride_detail_rides_supplier2` (`supplier_final_id`),
  ADD KEY `fk_sheet_ride_detail_rides_ride_category` (`ride_category_id`),
  ADD KEY `fk_sheet_ride_detail_rides_supplier1` (`supplier_id`),
  ADD KEY `fk_sheet_ride_detail_rides_detail_ride` (`detail_ride_id`),
  ADD KEY `fk_sheet_ride_detail_rides_sheet_ride` (`sheet_ride_id`),
  ADD KEY `fk_sheet_ride_detail_rides_transport_bill_detail_ride` (`transport_bill_detail_ride_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_departure_destination` (`departure_destination_id`),
  ADD KEY `fk_arrival_destination` (`arrival_destination_id`),
  ADD KEY `fk_sheet_ride_detail_ride_observation` (`observation_id`),
  ADD KEY `fk_sheet_ride_detail_ride_tonnage` (`tonnage_id`),
  ADD KEY `status_id_2` (`status_id`),
  ADD KEY `fk_sheet_ride_detail_rides_cancel_cause` (`cancel_cause_id`);

--
-- Index pour la table `sheet_ride_detail_ride_marchandises`
--
ALTER TABLE `sheet_ride_detail_ride_marchandises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sheet_ride_detail_ride_marchandises_marchandise` (`marchandise_id`),
  ADD KEY `fk_sheet_ride_detail_ride_marchandises_sheet_ride_detail_ride` (`sheet_ride_detail_ride_id`);

--
-- Index pour la table `shifting`
--
ALTER TABLE `shifting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shifting_car` (`car_id`),
  ADD KEY `fk_shifting_tire` (`tire_id`),
  ADD KEY `fk_shifting_position` (`position_id`),
  ADD KEY `fk_shifting_location` (`location_id`);

--
-- Index pour la table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_module_module` (`module_id`);

--
-- Index pour la table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `fk_suppliers_user1` (`user_id`),
  ADD KEY `fk_suppliers_user2` (`last_modifier_id`),
  ADD KEY `fk_suppliers_suppliers_category` (`supplier_category_id`),
  ADD KEY `fk_supplier_parent` (`parent_id`);

--
-- Index pour la table `supplier_addresses`
--
ALTER TABLE `supplier_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_addresse_supplier` (`supplier_id`);

--
-- Index pour la table `supplier_attachment_types`
--
ALTER TABLE `supplier_attachment_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_attachment_type_supplier` (`supplier_id`),
  ADD KEY `fk_supplier_attachment_type_attachment_type` (`attachment_type_id`);

--
-- Index pour la table `supplier_categories`
--
ALTER TABLE `supplier_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_category_user1` (`user_id`),
  ADD KEY `fk_supplier_category_user2` (`last_modifier_id`);

--
-- Index pour la table `supplier_contacts`
--
ALTER TABLE `supplier_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_contact_supplier` (`supplier_id`);

--
-- Index pour la table `tanks`
--
ALTER TABLE `tanks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tank_operations`
--
ALTER TABLE `tank_operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tank_sheet_ride` (`sheet_ride_id`);

--
-- Index pour la table `tires`
--
ALTER TABLE `tires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tire_tires_mark` (`tire_mark_id`),
  ADD KEY `fk_tire_supplier` (`supplier_id`);

--
-- Index pour la table `tire_marks`
--
ALTER TABLE `tire_marks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tonnages`
--
ALTER TABLE `tonnages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transformations`
--
ALTER TABLE `transformations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transformation_transport_bill1` (`origin_transport_bill_id`),
  ADD KEY `fk_transformation_transport_bill2` (`new_transport_bill_id`);

--
-- Index pour la table `transport_bills`
--
ALTER TABLE `transport_bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_bill_supplier1` (`supplier_id`),
  ADD KEY `transport_bill_supplier2` (`supplier_final_id`),
  ADD KEY `transport_bill_ride` (`ride_id`),
  ADD KEY `transport_bill_car_type` (`car_type_id`),
  ADD KEY `transport_bill_ride_category` (`ride_category_id`),
  ADD KEY `transport_bill_detail_ride` (`detail_ride_id`),
  ADD KEY `transport_bill_user1` (`user_id`),
  ADD KEY `transport_bill_user2` (`modified_id`),
  ADD KEY `type` (`type`),
  ADD KEY `transport_bill_categories` (`transport_bill_category_id`),
  ADD KEY `type_2` (`type`),
  ADD KEY `status` (`status`),
  ADD KEY `transport_bill_cancel_cause` (`cancel_cause_id`);

--
-- Index pour la table `transport_bill_categories`
--
ALTER TABLE `transport_bill_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transport_bill_detail_rides`
--
ALTER TABLE `transport_bill_detail_rides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transport_bill_detail_ride_detail_ride` (`detail_ride_id`),
  ADD KEY `fk_transport_bill_detail_ride_transport_bill` (`transport_bill_id`),
  ADD KEY `fk_transport_bill_detail_ride_sheet_ride_detail_ride` (`sheet_ride_detail_ride_id`),
  ADD KEY `fk_transport_bill_detail_ride_user1` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_transport_bill_detail_ride_supplier_final` (`supplier_final_id`),
  ADD KEY `fk_transport_bill_detail_ride_car_type` (`car_type_id`),
  ADD KEY `fk_transport_bill_detail_ride_product` (`lot_id`),
  ADD KEY `fk_transport_bill_detail_ride_tonnage` (`tonnage_id`),
  ADD KEY `status_id_2` (`status_id`),
  ADD KEY `fk_transport_bill_detail_ride_cancel_cause` (`cancel_cause_id`);

--
-- Index pour la table `tva`
--
ALTER TABLE `tva`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_user_role_idx` (`role_id`),
  ADD KEY `limit` (`limit`),
  ADD KEY `fk_user_profil` (`profile_id`),
  ADD KEY `fk_user_supplier` (`supplier_id`),
  ADD KEY `fk_user_service` (`service_id`);

--
-- Index pour la table `user_parc`
--
ALTER TABLE `user_parc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_parc_user` (`user_id`),
  ADD KEY `fk_user_parc_parc` (`parc_id`);

--
-- Index pour la table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_verification_tire` (`tire_id`);

--
-- Index pour la table `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_warning_customer` (`customer_id`),
  ADD KEY `fk_warning_warning_type` (`warning_type_id`);

--
-- Index pour la table `warning_types`
--
ALTER TABLE `warning_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wilaya_zone` (`zone_id`);

--
-- Index pour la table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `absence_reasons`
--
ALTER TABLE `absence_reasons`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `access_permissions`
--
ALTER TABLE `access_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12868;
--
-- AUTO_INCREMENT pour la table `acquisition_types`
--
ALTER TABLE `acquisition_types`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `affectationpvs`
--
ALTER TABLE `affectationpvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `alert_types`
--
ALTER TABLE `alert_types`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `attachment_types`
--
ALTER TABLE `attachment_types`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `autorisations`
--
ALTER TABLE `autorisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `bill_products`
--
ALTER TABLE `bill_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `bill_services`
--
ALTER TABLE `bill_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `cancel_causes`
--
ALTER TABLE `cancel_causes`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `car`
--
ALTER TABLE `car`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `carmodels`
--
ALTER TABLE `carmodels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1424;
--
-- AUTO_INCREMENT pour la table `car_car_statuses`
--
ALTER TABLE `car_car_statuses`
  MODIFY `id` mediumint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `car_categories`
--
ALTER TABLE `car_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `car_groups`
--
ALTER TABLE `car_groups`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `car_options`
--
ALTER TABLE `car_options`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `car_options_customer_car`
--
ALTER TABLE `car_options_customer_car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `car_statuses`
--
ALTER TABLE `car_statuses`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `car_types`
--
ALTER TABLE `car_types`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `car_type_car_categories`
--
ALTER TABLE `car_type_car_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT pour la table `code_logs`
--
ALTER TABLE `code_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `consumptions`
--
ALTER TABLE `consumptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `contract_car_types`
--
ALTER TABLE `contract_car_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `customer_car`
--
ALTER TABLE `customer_car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `customer_categories`
--
ALTER TABLE `customer_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `dairas`
--
ALTER TABLE `dairas`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `deadlines`
--
ALTER TABLE `deadlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT pour la table `detail_payments`
--
ALTER TABLE `detail_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `detail_rides`
--
ALTER TABLE `detail_rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `event_category_interfering`
--
ALTER TABLE `event_category_interfering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `event_event_types`
--
ALTER TABLE `event_event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `event_type_categories`
--
ALTER TABLE `event_type_categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `event_type_category_event_type`
--
ALTER TABLE `event_type_category_event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT pour la table `extinguishers`
--
ALTER TABLE `extinguishers`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `final_supplier_initial_suppliers`
--
ALTER TABLE `final_supplier_initial_suppliers`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fuels`
--
ALTER TABLE `fuels`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `fuel_cards`
--
ALTER TABLE `fuel_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fuel_card_affectations`
--
ALTER TABLE `fuel_card_affectations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fuel_card_cars`
--
ALTER TABLE `fuel_card_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fuel_card_mouvements`
--
ALTER TABLE `fuel_card_mouvements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `interferings`
--
ALTER TABLE `interferings`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `interfering_types`
--
ALTER TABLE `interfering_types`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `interfering_type_event_type`
--
ALTER TABLE `interfering_type_event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT pour la table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `leasings`
--
ALTER TABLE `leasings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `legal_form`
--
ALTER TABLE `legal_form`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `lot_types`
--
ALTER TABLE `lot_types`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `marchandises`
--
ALTER TABLE `marchandises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `marchandise_types`
--
ALTER TABLE `marchandise_types`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `marchandise_units`
--
ALTER TABLE `marchandise_units`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT pour la table `medical_visits`
--
ALTER TABLE `medical_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `mission_costs`
--
ALTER TABLE `mission_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `mission_cost_parameters`
--
ALTER TABLE `mission_cost_parameters`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `monthlykms`
--
ALTER TABLE `monthlykms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `movings`
--
ALTER TABLE `movings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `observations`
--
ALTER TABLE `observations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `parcs`
--
ALTER TABLE `parcs`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `payment_associations`
--
ALTER TABLE `payment_associations`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `payment_categories`
--
ALTER TABLE `payment_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `price_categories`
--
ALTER TABLE `price_categories`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `price_ride_categories`
--
ALTER TABLE `price_ride_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `product_families`
--
ALTER TABLE `product_families`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `product_marks`
--
ALTER TABLE `product_marks`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `recharges`
--
ALTER TABLE `recharges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ride_categories`
--
ALTER TABLE `ride_categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `rubrics`
--
ALTER TABLE `rubrics`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT pour la table `section_actions`
--
ALTER TABLE `section_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2432;
--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sheet_rides`
--
ALTER TABLE `sheet_rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sheet_ride_conveyors`
--
ALTER TABLE `sheet_ride_conveyors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sheet_ride_detail_rides`
--
ALTER TABLE `sheet_ride_detail_rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sheet_ride_detail_ride_marchandises`
--
ALTER TABLE `sheet_ride_detail_ride_marchandises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `shifting`
--
ALTER TABLE `shifting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sub_modules`
--
ALTER TABLE `sub_modules`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `supplier_addresses`
--
ALTER TABLE `supplier_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `supplier_attachment_types`
--
ALTER TABLE `supplier_attachment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `supplier_categories`
--
ALTER TABLE `supplier_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `supplier_contacts`
--
ALTER TABLE `supplier_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tanks`
--
ALTER TABLE `tanks`
  MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tank_operations`
--
ALTER TABLE `tank_operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tires`
--
ALTER TABLE `tires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tire_marks`
--
ALTER TABLE `tire_marks`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `tonnages`
--
ALTER TABLE `tonnages`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `transformations`
--
ALTER TABLE `transformations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `transport_bills`
--
ALTER TABLE `transport_bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `transport_bill_categories`
--
ALTER TABLE `transport_bill_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `transport_bill_detail_rides`
--
ALTER TABLE `transport_bill_detail_rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tva`
--
ALTER TABLE `tva`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user_parc`
--
ALTER TABLE `user_parc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `warnings`
--
ALTER TABLE `warnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `warning_types`
--
ALTER TABLE `warning_types`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `wilayas`
--
ALTER TABLE `wilayas`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `fk_absence_absence_reason` FOREIGN KEY (`absence_reason_id`) REFERENCES `absence_reasons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_absence_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `access_permissions`
--
ALTER TABLE `access_permissions`
  ADD CONSTRAINT `fk_access_permission_action` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_access_permission_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `affectationpvs`
--
ALTER TABLE `affectationpvs`
  ADD CONSTRAINT `fk_affectationpv_customer_car` FOREIGN KEY (`customer_car_id`) REFERENCES `customer_car` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_affectationpv_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_affectationpv_user2` FOREIGN KEY (`last_modifier_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `affiliates`
--
ALTER TABLE `affiliates`
  ADD CONSTRAINT `fk_affiliate_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_affiliate_user2` FOREIGN KEY (`last_modifier_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `fk_attachment_attachment_type` FOREIGN KEY (`attachment_type_id`) REFERENCES `attachment_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_attachment_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `attachment_types`
--
ALTER TABLE `attachment_types`
  ADD CONSTRAINT `fk_attachment_type_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `fk_attachment_type_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_attachment_type_user2` FOREIGN KEY (`last_modifier_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `audits`
--
ALTER TABLE `audits`
  ADD CONSTRAINT `fk_audit_action` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_audit_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `autorisations`
--
ALTER TABLE `autorisations`
  ADD CONSTRAINT `fk_autorisations_customer_car` FOREIGN KEY (`customer_car_id`) REFERENCES `customer_car` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_autorisations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_rides` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`),
  ADD CONSTRAINT `fk_bill_category` FOREIGN KEY (`transport_bill_category_id`) REFERENCES `transport_bill_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bill_sheet_ride_detail_ride` FOREIGN KEY (`sheet_ride_detail_ride_id`) REFERENCES `sheet_ride_detail_rides` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bills_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bills_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bills_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bills_user2` FOREIGN KEY (`modified_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `bill_products`
--
ALTER TABLE `bill_products`
  ADD CONSTRAINT `fk_bill_product_lot` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bill_product_tva` FOREIGN KEY (`tva_id`) REFERENCES `tva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_bill_bill` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `bill_services`
--
ALTER TABLE `bill_services`
  ADD CONSTRAINT `fk_bill_service_bill` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bill_service_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `fk_car_acquisition_type` FOREIGN KEY (`acquisition_type_id`) REFERENCES `acquisition_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_car_category` FOREIGN KEY (`car_category_id`) REFERENCES `car_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_car_status` FOREIGN KEY (`car_status_id`) REFERENCES `car_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_car_type` FOREIGN KEY (`car_type_id`) REFERENCES `car_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_fuel` FOREIGN KEY (`fuel_id`) REFERENCES `fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_parc` FOREIGN KEY (`parc_id`) REFERENCES `parcs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `carmodels`
--
ALTER TABLE `carmodels`
  ADD CONSTRAINT `fk_carmodel_mark` FOREIGN KEY (`mark_id`) REFERENCES `marks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_carmodel_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `car_car_statuses`
--
ALTER TABLE `car_car_statuses`
  ADD CONSTRAINT `fk_car` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_status` FOREIGN KEY (`car_status_id`) REFERENCES `car_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `car_categories`
--
ALTER TABLE `car_categories`
  ADD CONSTRAINT `car_category_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `car_category_user2` FOREIGN KEY (`last_modifier_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `car_groups`
--
ALTER TABLE `car_groups`
  ADD CONSTRAINT `car_group_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `car_group_user2` FOREIGN KEY (`last_modifier_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `car_options`
--
ALTER TABLE `car_options`
  ADD CONSTRAINT `car_option_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `car_option_user2` FOREIGN KEY (`last_modifier_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `car_options_customer_car`
--
ALTER TABLE `car_options_customer_car`
  ADD CONSTRAINT `fk_car_options_customer_car_car_option` FOREIGN KEY (`car_option_id`) REFERENCES `car_options` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_car_options_customer_car_customer_car` FOREIGN KEY (`customer_car_id`) REFERENCES `customer_car` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_company_legal_form` FOREIGN KEY (`legal_form_id`) REFERENCES `legal_form` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_mechanician` FOREIGN KEY (`mechanician_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `section_actions`
--
ALTER TABLE `section_actions`
  ADD CONSTRAINT `fk_section_action_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Contraintes pour la table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_supplier_parent` FOREIGN KEY (`parent_id`) REFERENCES `suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_parc`
--
ALTER TABLE `user_parc`
  ADD CONSTRAINT `fk_user_parc_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
