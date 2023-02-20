<?php
App::uses('AppModel', 'Model');
/**
 * FuelLog Model
 *
 *
 */
class FuelCard extends AppModel
{


    public $displayField = 'reference';

    public $validate = array(
        'reference' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public $hasMany = array(
        'FuelCardAffectation' => array(
            'className' => 'FuelCardAffectation',
            'foreignKey' => 'fuel_card_id',
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
        'FuelCardMouvement' => array(
            'className' => 'FuelCardMouvement',
            'foreignKey' => 'fuel_card_id',
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

    );

	public function getCardById($fuelCardId = null){
		$card = $this->find(
            'first',
            array(
                'conditions' => array('FuelCard.id' => $fuelCardId),
                'recursive' => -1,
                'fields' => array('FuelCard.id', 'FuelCard.reference', 'FuelCard.amount')
            )
        );
        return $card;
	}

public function decreaseSpeciesCard($fuelCardId = null, $speciesCard = null){
			$fuelCard = $this->getCardById($fuelCardId);
			$amount = $fuelCard['FuelCard']['amount']- $speciesCard;
			$this->id = $fuelCardId;
			$this->saveField('amount', $amount);
	}
	
	public function increaseSpeciesCard($fuelCardId = null, $speciesCard = null){
			$fuelCard = $this->getCardById($fuelCardId);
			$amount = $fuelCard['FuelCard']['amount']+ $speciesCard;
			$this->id = $fuelCardId;
			$this->saveField('amount', $amount);
	}




}