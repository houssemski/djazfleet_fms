<?php
App::uses('AppModel', 'Model');
/**
 * Parameter Model
 *
 */
class Option extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $useTable = 'options';
	public $displayField = 'name';

}
