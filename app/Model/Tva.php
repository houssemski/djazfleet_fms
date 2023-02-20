<?php
App::uses('AppModel', 'Model');
/**
 * Tva Model
 *
 * @property Tva $Tva
 */
class Tva extends AppModel {

 public $useTable = 'tva';
    public $displayField = 'name';


     public $validate = array(
      
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'tva_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
      

    );

    /**
     * Get tva list
     *
     * @param array|null $fields
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $tvas
     */
    public function getTvas($fields = null, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = array('Tva.id', 'Tva.name');
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $tvas = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'order' => array('Tva.code ASC', 'Tva.name'),
                'recursive' => $recursive
            )
        );
        return $tvas;
    }

    /**
     * Get tva by id
     *
     * @param int $tvaId
     *
     * @return array $tva
     */
    public function getTvaById($tvaId)
    {
        $tva = $this->find(
            'first',
            array(
                'conditions' => array('Tva.id' => $tvaId)
            )
        );
        return $tva;
    }

    /**
     * Get tva value by id
     *
     * @param int $tvaId
     *
     * @return array $tva
     */
    public function getTvaValueById($tvaId)
    {
        $tva = $this->find(
            'first',
            array(
                'conditions' => array('Tva.id' => $tvaId)
            )
        );
        return $tva['Tva']['tva_val'];
    }

}