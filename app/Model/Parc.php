<?php
App::uses('AppModel', 'Model');
/**
 * Parc Model
 *
 */
class Parc extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'parc_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'parc_id',
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
     * Get all parcs
     *
     * @param string $typeSelect
     * @param int|null $recursive
     *
     * @return array $parcs
     */
    public function getParcs($typeSelect, $recursive = null)
    {

        if (isset($recursive) && !empty($recursive)) {
            $parcs = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Parc.id != 0',
                    'order' => 'Parc.code ASC, Parc.name ASC',
                    'recursive' => $recursive
                )
            );
        } else {
            $parcs = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Parc.id != 0',
                    'order' => 'Parc.code ASC, Parc.name ASC',
                    'recursive' => '-1'
                )
            );
        }
        return $parcs;
    }

    /**
     * Get parcs by ids
     *
     * @param array $ids
     *
     * @return array $parcs
     */
    public function getParcByIds($ids, $typeSelect = 'list')
    {
        $parcs = $this->find(
            $typeSelect,
            array(
                'order' => 'Parc.code ASC, Parc.name ASC',
                'conditions' => array('Parc.id' => $ids),
                'recursive' => -1
            )
        );
        return $parcs;
    }

    /**
     * Get parc by id
     *
     * @param int $id
     *
     * @return array $parc
     */
    public function getParcById($id)
    {
        $parc = $this->find(
            'all',
            array(
                'conditions' => array('Parc.id' => $id),
                'recursive' => -1
            )
        );
        return $parc;
    }
}
