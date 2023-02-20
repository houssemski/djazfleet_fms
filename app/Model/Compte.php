<?php

App::uses('AppModel', 'Model');
/**
 * Model Model
 *
 * @property Mark $Mark
 */
class Compte extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'num_compte';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'num_compte' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => false,
                'required' => true,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Payment' => array(
            'className' => 'Payment',
            'foreignKey' => 'compte_id',
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
     * @param null $compteId
     * @param null $amount
     * @param null $precedentCompteId
     * @param null $precedentAmount
     */

    public function updateCompteDebit(
        $compteId = null,
        $amount = null,
        $precedentCompteId = null,
        $precedentAmount = null
    ) {

        if (!empty($precedentCompteId)) {
            $precedentCompte = $this->find('first',
                array('conditions' => array('Compte.id' => $precedentCompteId), 'fields' => array('id', 'amount')));
            if (!empty($precedentCompte)) {

                $precedentExistAmount = $precedentCompte['Compte']['amount'];
                $precedentExistAmount = $precedentExistAmount + $precedentAmount;
                $this->id = $precedentCompte['Compte']['id'];
                $this->saveField('amount', $precedentExistAmount);

            }
        }
        if ($amount > 0) {

            $compte = $this->find('first',
                array('conditions' => array('Compte.id' => $compteId), 'fields' => array('id', 'amount')));
            if (!empty($compte)) {
                $existAmount = $compte['Compte']['amount'];
                $existAmount = $existAmount - $amount;
                $this->id = $compte['Compte']['id'];
                $this->saveField('amount', $existAmount);

            }
        }

    }


    public function updateCompteCredit(
        $compteId = null,
        $amount = null,
        $precedentCompteId = null,
        $precedentAmount = null
    ) {
        if (!empty($precedentCompteId)) {
            $precedentCompte = $this->find('first',
                array('conditions' => array('Compte.id' => $precedentCompteId), 'fields' => array('id', 'amount')));
            
			if (!empty($precedentCompte)) {

                $precedentExistAmount = $precedentCompte['Compte']['amount'];
                $precedentExistAmount = $precedentExistAmount - $precedentAmount;
                $this->id = $precedentCompte['Compte']['id'];
                $this->saveField('amount', $precedentExistAmount);

            }
        }

        if ($amount > 0) {

            $compte = $this->find('first',
                array('conditions' => array('Compte.id' => $compteId), 'fields' => array('id', 'amount')));
            if (!empty($compte)) {
                $existAmount = $compte['Compte']['amount'];
                $existAmount = $existAmount + $amount;
                $this->id = $compte['Compte']['id'];
                $this->saveField('amount', $existAmount);

            }
        }

    }
	
	function getCompteType($compteId){
		$compte = $this->find('first',
                array(
				'recursive'=>-1,
				'conditions' => array('Compte.id' => $compteId), 'fields' => array('id', 'type_id')));
     
	$compteTypeId = $compte['Compte']['type_id'];
	return $compteTypeId;
	}



}
