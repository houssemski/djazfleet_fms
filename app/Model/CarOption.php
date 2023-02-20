<?php
App::uses('AppModel', 'Model');
/**
 * CarOption Model
 *
 */
class CarOption extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	/**
	 * get Car Options
	 *
	 * @param string $typeSelect
	 *
	 * @return array $carOptions
	 */
	public function getCarOptions($typeSelect = null) {
		if(empty($typeSelect)){
			$typeSelect = 'list';
		}
		$carOptions = $this->find(
			$typeSelect,
			array(
				'order' => array('CarOption.code ASC, CarOption.name ASC'),
				'recursive' => -1
			)
		);
		return $carOptions;
	}
}
