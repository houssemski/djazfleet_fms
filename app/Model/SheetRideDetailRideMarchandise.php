<?php

App::uses('AppModel', 'Model');

/**
 * OptionReservation Model
 *
 */
class SheetRideDetailRideMarchandise extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */


        public $validate = array(
            'sheet_ride_detail_ride_id' => array(
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

    public $validate_add_sheet_ride_detail_ride = array(

        'sheet_ride_detail_ride_id' => array(
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

   public $belongsTo = array(
        'Marchandise' => array(
            'className' => 'Marchandise',
            'foreignKey' => 'marchandise_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'sheet_ride_detail_ride_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function saveMarchandises($sheetRideDetailRideMarchandises, $sheet_ride_detail_ride_id)
    {
        foreach ($sheetRideDetailRideMarchandises as $sheetRideDetailRideMarchandise) {


            if (!empty($sheetRideDetailRideMarchandise['marchandise_id'])) {
                $marchandies = array();
                if (!empty($sheetRideDetailRideMarchandise['id'])) {
                    $marchandies['SheetRideDetailRideMarchandise']['id'] = $sheetRideDetailRideMarchandise['id'];;
                } else {
                    $this->create();
                }
                $marchandies['SheetRideDetailRideMarchandise']['sheet_ride_detail_ride_id'] = $sheet_ride_detail_ride_id;
                $marchandies['SheetRideDetailRideMarchandise']['marchandise_id'] = $sheetRideDetailRideMarchandise['marchandise_id'];
                $marchandies['SheetRideDetailRideMarchandise']['quantity'] = $sheetRideDetailRideMarchandise['quantity'];


                $this->save($marchandies);
            }

        }
    }


}