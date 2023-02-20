<?php
App::uses('AppModel', 'Model');
/**
 * Parameter Model
 *
 */
class Parameter extends AppModel {

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
		'val' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
	 * Get parameter values by code and fields
	 * @param string $paramCode
	 * @param array $fields
	 * @param array|null $order
	 * @return array $paramValues
	 */
	public function getParamValByCode($paramCode, $fields, $order = null)
	{
		if(empty($order)){
			$order = array('code' => 'ASC');
		}
		$paramValues = $this->find(
			'first',
			array(
				'conditions' => array('code' => $paramCode),
				'fields' => $fields,
				'order' => $order
			)
		);
		return $paramValues;
	}

	/**
	 * Get code parameter value
	 * @param null
	 * @return int|float|string $parameterValue
	 */
	public function getCodesParameterVal($fieldName)
	{
		$param = $this->find(
			'first',
			array(
				'conditions' => array('code' => ParametersEnum::codes),
				'fields' => array($fieldName)
			)
		);
		$parameterValue = $param['Parameter'][$fieldName];
		return $parameterValue;
	}

	/**
	 * get code's type and size
	 * @param rebric's name
	 * @return array $codeParameter .
	 */
	public function getCodeTypeAndSize($name)
	{
		$codeParameter = $this->find(
			'first',
			array(
				'conditions' => array('code' => ParametersEnum::codes, 'auto_' . $name => 1),
				'fields' => array('auto_' . $name, 'sizes_' . $name)
			)
		);

		return $codeParameter;
	}
	/**
	 * get code's type and size And Prefix
	 * @param rebric's name
	 * @return array $codeParameter .
	 */
	public function getCodeTypeAndSizeAndPrefix($name)
	{
		$codeParameter = $this->find(
			'first',
			array(
				'conditions' => array('code' => ParametersEnum::codes, 'auto_' . $name => 1),
				'fields' => array('reference_auto_' . $name, 'reference_sizes_' . $name, 'reference_' . $name)
			)
		);

		return $codeParameter;
	}

	/**
	 * Get transport bill reference infos
	 * @param database reference automatic field's name
	 * @return array $codeParameter .
	 */
	public function getTransportBillReferenceInfos($dbRefAutoFieldName)
	{
		$referenceParameterFields = $this->find(
			'first',
			array(
			    'recursive'=>-1,
				'conditions' => array('code' => ParametersEnum::codes, $dbRefAutoFieldName => 2),
				'fields' => array(
					'id',
					'reference_sizes',
					'reference_sizes_event',
					'date_suffixe',
					'abbreviation_location',
					'abbreviation_location_event',
					'reference_bill_sizes',
					'date_bill_suffixe',
					'date_suffix_event',
					'abbreviation_bill_location',
					'demande_devis',
					'devis',
					'commande',
					'feuille_route',
					'prefacture',
					'facture',
					'avoir_vente',
					'bordereau_envoi',
					'supplier_order',
					'receipt',
					'return_supplier',
					'purchase_invoice',
					'credit_note',
					'delivery_order',
					'return_customer',
					'entry_order',
					'exit_order',
					'renvoi_order',
					'reintegration_order',
					'transfer_receipt',
					'product_request',
					'purchase_request',
					'intervention_request',
					'event',
					'next_reference_demande_devis',
					'next_reference_devis',
					'next_reference_commande',
					'next_reference_feuille_route',
					'next_reference_prefacture',
					'next_reference_facture',
					'next_reference_avoir_vente',
					'next_reference_bordereau_envoi',
					'next_reference_supplier_order',
					'next_reference_receipt',
					'next_reference_return_supplier',
					'next_reference_purchase_invoice',
					'next_reference_credit_note',
					'next_reference_delivery_order',
					'next_reference_return_customer',
					'next_reference_entry_order',
					'next_reference_exit_order',
					'next_reference_renvoi_order',
					'next_reference_reintegration_order',
					'next_reference_transfer_receipt',
					'next_reference_product_request',
					'next_reference_purchase_request',
                    'next_reference_intervention_request',
                    'next_reference_event',

					
				)
			)
		);

		return $referenceParameterFields;
	}


	/**
	 * Get product reference infos
	 * @param database reference automatic field's name
	 * @return array $codeParameter .
	 */
	public function getProductCodeInfos($dbRefAutoFieldName)
	{
		$referenceParameterFields = $this->find(
			'first',
			array(
				'conditions' => array('code' => ParametersEnum::codes, $dbRefAutoFieldName => 2),
				'fields' => array(
					'id',
					'reference_product_sizes',
					'next_reference_product',
				)
			)
		);

		return $referenceParameterFields;
	}

	public function getCodeInfos($dbRefAutoFieldName)
	{
		$codeParameterFields = $this->find(
			'first',
			array(
				'conditions' => array('code' => ParametersEnum::codes, $dbRefAutoFieldName => 2),
				'fields' => array(
					'id',
					'reference_sizes_supplier',
					'reference_supplier',
					'next_reference_supplier',
                    'reference_sizes_client_initial',
					'reference_client_initial',
					'next_reference_client_initial',
                    'reference_sizes_client_final',
					'reference_client_final',
					'next_reference_client_final',
				)
			)
		);

		return $codeParameterFields;
	}




	/**
	 * Get reference infos
	 * @param $rubricName rubric's name : affectation | reservation | event
	 * @return array $codeParameter .
	 */
	public function getReferenceInfos($rubricName , $prefix =0)
	{
		
		if( $prefix ==1) {
			$referenceParameterFields = $this->find(
			'first',
			array(
				'conditions' => array('code' => 12, 'reference_auto_' . $rubricName => 2),
				'fields' => array(
					'reference_sizes_' . $rubricName,
					'reference_' . $rubricName
				)
			)
		);
		}else {
			$referenceParameterFields = $this->find(
			'first',
			array(
				'conditions' => array('code' => 12, 'reference_auto_' . $rubricName => 2),
				'fields' => array(
					'reference_sizes_' . $rubricName,
					'date_suffixe_' . $rubricName,
					'reference_' . $rubricName
				)
			)
		);
		}
		

		return $referenceParameterFields;
	}

	/**
	 * get Fields to be hidden
	 * @param void
	 *
	 * @return array $hidden_fields
	 */

	public function getFieldsToHide()
	{
		$hidden_fields = $this->find(
			'first',
			array(
				'recursive' => -1,
				'fields' => array(
					'company',
					'email3',
					'job',
					'monthly_payroll',
					'cost_center',
					'note',
					'declaration_date',
					'affiliate',
					'ccp',
					'bank_account',
					'identity_card',
					'passport',
					'totaux_dashbord'
				),
				'conditions' => array('code' => array(ParametersEnum::input_hidden))
			)
		);

		return $hidden_fields;
	}
	public function getInformationJasperReport(){

		$parameter = $this->find(
			'first',
			array(
				'conditions' => array('code' => 12),
				'fields' => array(
					'reports_path_jasper','username_jasper','password_jasper'
				)
			)
		);

		return $parameter;

	}

	/**
	 * @param null $type
	 */
	public function setNextTransportReferenceNumber($type= null){
		switch ($type) {
			case TransportBillTypesEnum::quote_request :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_dd_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_demande_devis'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_demande_devis',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::quote :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_fp_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_devis'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_devis',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_bc_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_commande'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_commande',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::sheet_ride :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_fr_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_feuille_route'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_feuille_route',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::pre_invoice :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_pf_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_prefacture'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_prefacture',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::invoice :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_fa_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_facture'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_facture',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::credit_note :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_av_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_avoir_vente'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_avoir_vente',$nextNumber);
				}
				break;

			case TransportBillTypesEnum::dispatch_slip :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_ds_auto');
				if(!empty($referenceParameterFields)) {
				$number = $referenceParameterFields['Parameter']['next_reference_bordereau_envoi'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_bordereau_envoi',$nextNumber);
				}
				break;
		}

	}

    /**
     *  created : 19/03/2019
     */
	public function setNextProductCodeNumber(){
				$referenceParameterFields = $this->getProductCodeInfos('reference_product_auto');
				if(!empty($referenceParameterFields)) {
                    $number = $referenceParameterFields['Parameter']['next_reference_product'];
                    $nextNumber = (int)$number+1;
                    $this->id = $referenceParameterFields['Parameter']['id'];
                    $this->saveField('next_reference_product',$nextNumber);
                }
	}

    /**
     * @param $dbFieldName
     * created : 24/03/2019
     */
	public function setNextCodeNumber($dbFieldName){
        $nextNumber = 0;
				$referenceParameterFields = $this->getCodeInfos('reference_auto_'.$dbFieldName);
				if(!empty($referenceParameterFields)) {
                    $number = $referenceParameterFields['Parameter']['next_reference_'.$dbFieldName];
                    $nextNumber = (int)$number+1;
                    $this->id = $referenceParameterFields['Parameter']['id'];
                    $this->saveField('next_reference_'.$dbFieldName,$nextNumber);
                }
                return $nextNumber;
	}

	public function setNextBillReferenceNumber($type= null){
		switch ($type) {
			case BillTypesEnum::supplier_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_so_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_supplier_order'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_supplier_order',$nextNumber);
				}
				break;

			case BillTypesEnum::receipt :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_re_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_receipt'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_receipt',$nextNumber);
				}
				break;

			case BillTypesEnum::return_supplier :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_rs_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_return_supplier'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_return_supplier',$nextNumber);
				}
				break;

			case BillTypesEnum::purchase_invoice :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_pi_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_purchase_invoice'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_purchase_invoice',$nextNumber);
				}
				break;

			case BillTypesEnum::credit_note :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_cn_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_credit_note'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_credit_note',$nextNumber);
				}
				break;

			case BillTypesEnum::delivery_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_do_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_delivery_order'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_delivery_order',$nextNumber);
				}
				break;

			case BillTypesEnum::return_customer :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_rc_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_return_customer'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_return_customer',$nextNumber);
				}
				break;

			case BillTypesEnum::entry_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_eo_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_entry_order'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_entry_order',$nextNumber);
				}
				break;

			case BillTypesEnum::exit_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_xo_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_exit_order'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_exit_order',$nextNumber);
				}
				break;

			case BillTypesEnum::renvoi_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_ro_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_renvoi_order'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_renvoi_order',$nextNumber);
				}
				break;

			case BillTypesEnum::reintegration_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_ri_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_reintegration_order'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_reintegration_order',$nextNumber);
				}
				break;
			case BillTypesEnum::quote :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_fp_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_devis'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_devis',$nextNumber);			
				}
				break;
			case BillTypesEnum::customer_order :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_bc_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_commande'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_commande',$nextNumber);			
				}
				
				break;
			case BillTypesEnum::sales_invoice :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_fa_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_facture'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_facture',$nextNumber);		
				}
				break;
			case BillTypesEnum::sale_credit_note :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_av_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_avoir_vente'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_avoir_vente',$nextNumber);
				}
				break;

			case BillTypesEnum::product_request :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_pr_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_product_request'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_product_request',$nextNumber);
				}
				break;

			case BillTypesEnum::purchase_request :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_ar_auto');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_purchase_request'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_purchase_request',$nextNumber);
				}
				break;
		}
	}


	public function setNextEventReferenceNumber($type= null){
		switch ($type) {
			case 'event' :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_auto_event');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_event'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_event',$nextNumber);
				}
				break;

			case 'intervention_request' :
				$referenceParameterFields = $this->getTransportBillReferenceInfos('reference_auto_intervention_request');
				if(!empty($referenceParameterFields)){
				$number = $referenceParameterFields['Parameter']['next_reference_intervention_request'];
				$nextNumber = (int)$number+1;
				$this->id = $referenceParameterFields['Parameter']['id'];
				$this->saveField('next_reference_intervention_request',$nextNumber);
				}
				break;


		}
	}

}
