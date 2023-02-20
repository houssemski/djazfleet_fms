INSERT INTO `sub_modules` (`id`, `code`, `name`, `module_id`, `created`, `modified`) VALUES ('49', 'supplier', 'Fournisseur', '12', '2022-04-07 13:16:01', '2022-04-07 13:16:01');
UPDATE `sections` SET `sub_module_id` = '49' WHERE `sections`.`id` = 13;
