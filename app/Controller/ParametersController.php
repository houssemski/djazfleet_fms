<?php

App::uses('AppController', 'Controller');

/**
 * Parameters Controller
 *
 * @property Parameter $Parameter
 * @property CarType $CarType
 * @property AttachmentType $AttachmentType
 * @property ParameterAttachmentType $ParameterAttachmentType
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
include("Enum.php");
include("TaxInformationsEnum.php");
class ParametersController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array(
        'Parameter',
        'Company',
        'Language',
        'Nationality',
        'Currency',
        'Destination',
        'CarType',
        'MissionCostParameter',
        'AttachmentType'
    );

    /**
     * index method
     *
     * @return void
     */
    public function releasenotes()
    {
    }
    public function index()
    {

        $this->setTimeActif();
        if($this->Auth->user('profile_id') != ProfilesEnum::admin){
            $this->verifySuperAdministrator('Users');
        }
        $this->request->data = $this->Company->find('first');
        $legalForms = $this->Company->LegalForm->find('list');
        // Créer un tableau associatif des alertes : Parameter.id comme clé et Parameter comme valeur
        $this->request->data['Parameter'] = Hash::combine($this->Parameter->find('all', array(
            'conditions' => array('type_id = ' => 1),
            'recursive' => -1
        )), '{n}.Parameter.id', '{n}.Parameter');

        $languages = $this->Language->find('list');
        $currencies = $this->Currency->find('list');
        $countries = $this->Nationality->find('list');
        $parameter = $this->Parameter->find('all', array(
            'recursive' => -1,
            'conditions' => array('code' => array(8, 9, 10, 12, 14, 15, 19, 20, 23, 26,31)),
            'order' => array('code' => 'ASC')
        ));

        $selectedLanguage = $parameter[0]['Parameter']['val'];
        $selectedCurrency = $parameter[1]['Parameter']['val'];
        $selectedCountry = $parameter[10]['Parameter']['val'];

        $this->request->data['Parameter']['coupon_price'] = $parameter[2]['Parameter']['val'];

        $this->request->data['Parameter']['auto_car'] = $parameter[3]['Parameter']['auto_car'];
        $this->request->data['Parameter']['sizes_car'] = $parameter[3]['Parameter']['sizes_car'];
        $this->request->data['Parameter']['auto_conductor'] = $parameter[3]['Parameter']['auto_conductor'];
        $this->request->data['Parameter']['sizes_conductor'] = $parameter[3]['Parameter']['sizes_conductor'];
        $this->request->data['Parameter']['param_car'] = $parameter[3]['Parameter']['name_car'];
        $this->request->data['Parameter']['param_coupon'] = $parameter[3]['Parameter']['param_coupon'];
        $this->request->data['Parameter']['affectation_mode'] = $parameter[3]['Parameter']['affectation_mode'];
        $this->request->data['Parameter']['reference_auto_client_initial'] = $parameter[3]['Parameter']['reference_auto_client_initial'];
        $this->request->data['Parameter']['reference_sizes_client_initial'] = $parameter[3]['Parameter']['reference_sizes_client_initial'];
        $this->request->data['Parameter']['reference_client_initial'] = $parameter[3]['Parameter']['reference_client_initial'];
        $this->request->data['Parameter']['next_reference_client_initial'] = $parameter[3]['Parameter']['next_reference_client_initial'];
        $this->request->data['Parameter']['reference_auto_client_final'] = $parameter[3]['Parameter']['reference_auto_client_final'];
        $this->request->data['Parameter']['reference_sizes_client_final'] = $parameter[3]['Parameter']['reference_sizes_client_final'];
        $this->request->data['Parameter']['reference_client_final'] = $parameter[3]['Parameter']['reference_client_final'];
        $this->request->data['Parameter']['next_reference_client_final'] = $parameter[3]['Parameter']['next_reference_client_final'];
        $this->request->data['Parameter']['reference_auto_supplier'] = $parameter[3]['Parameter']['reference_auto_supplier'];
        $this->request->data['Parameter']['reference_sizes_supplier'] = $parameter[3]['Parameter']['reference_sizes_supplier'];
        $this->request->data['Parameter']['reference_supplier'] = $parameter[3]['Parameter']['reference_supplier'];
        $this->request->data['Parameter']['next_reference_supplier'] = $parameter[3]['Parameter']['next_reference_supplier'];

        $this->request->data['Parameter']['reference_auto_affectation'] = $parameter[3]['Parameter']['reference_auto_affectation'];
        $this->request->data['Parameter']['reference_sizes_affectation'] = $parameter[3]['Parameter']['reference_sizes_affectation'];
        $this->request->data['Parameter']['date_suffixe_affectation'] = $parameter[3]['Parameter']['date_suffixe_affectation'];
        $this->request->data['Parameter']['reference_affectation'] = $parameter[3]['Parameter']['reference_affectation'];
        $this->request->data['Parameter']['reference_auto_event'] = $parameter[3]['Parameter']['reference_auto_event'];
        $this->request->data['Parameter']['reference_auto_intervention_request'] = $parameter[3]['Parameter']['reference_auto_intervention_request'];
        $this->request->data['Parameter']['reference_sizes_event'] = $parameter[3]['Parameter']['reference_sizes_event'];
        $this->request->data['Parameter']['date_suffix_event'] = $parameter[3]['Parameter']['date_suffix_event'];
        $this->request->data['Parameter']['abbreviation_location_event'] = $parameter[3]['Parameter']['abbreviation_location_event'];
        $this->request->data['Parameter']['event'] = $parameter[3]['Parameter']['event'];
        $this->request->data['Parameter']['intervention_request'] = $parameter[3]['Parameter']['intervention_request'];
        $this->request->data['Parameter']['next_reference_event'] = $parameter[3]['Parameter']['next_reference_event'];
        $this->request->data['Parameter']['next_reference_intervention_request'] = $parameter[3]['Parameter']['next_reference_intervention_request'];

        $this->request->data['Parameter']['fuellog_coupon'] = $parameter[3]['Parameter']['fuellog_coupon'];
        $this->request->data['Parameter']['balance_car'] = $parameter[3]['Parameter']['balance_car'];
        $this->request->data['Parameter']['tank_spacies'] = $parameter[3]['Parameter']['tank_spacies'];
        $this->request->data['Parameter']['consumption_coupon'] = $parameter[3]['Parameter']['consumption_coupon'];
        $this->request->data['Parameter']['consumption_spacies'] = $parameter[3]['Parameter']['consumption_spacies'];
        $this->request->data['Parameter']['consumption_tank'] = $parameter[3]['Parameter']['consumption_tank'];
        $this->request->data['Parameter']['consumption_card'] = $parameter[3]['Parameter']['consumption_card'];
        $this->request->data['Parameter']['priority'] = $parameter[3]['Parameter']['priority'];

        $this->request->data['Parameter']['select_coupon'] = $parameter[3]['Parameter']['select_coupon'];
        $this->request->data['Parameter']['automatic_card_assignment'] = $parameter[3]['Parameter']['automatic_card_assignment'];
        $this->request->data['Parameter']['departure_tank_state'] = $parameter[3]['Parameter']['departure_tank_state'];
        $this->request->data['Parameter']['arrival_tank_state'] = $parameter[3]['Parameter']['arrival_tank_state'];
        $this->request->data['Parameter']['take_account_departure_tank'] = $parameter[3]['Parameter']['take_account_departure_tank'];
        $this->request->data['Parameter']['card_amount_verification'] = $parameter[3]['Parameter']['card_amount_verification'];
        $this->request->data['Parameter']['default_consumption_method'] = $parameter[3]['Parameter']['default_consumption_method'];

        $this->request->data['Parameter']['use_priority'] = $parameter[3]['Parameter']['use_priority'];

        $this->request->data['Parameter']['reference_dd_auto'] = $parameter[3]['Parameter']['reference_dd_auto'];
        $this->request->data['Parameter']['reference_fp_auto'] = $parameter[3]['Parameter']['reference_fp_auto'];
        $this->request->data['Parameter']['reference_bc_auto'] = $parameter[3]['Parameter']['reference_bc_auto'];
        $this->request->data['Parameter']['reference_fr_auto'] = $parameter[3]['Parameter']['reference_fr_auto'];
        $this->request->data['Parameter']['reference_mi_auto'] = $parameter[3]['Parameter']['reference_mi_auto'];
        $this->request->data['Parameter']['reference_pf_auto'] = $parameter[3]['Parameter']['reference_pf_auto'];
        $this->request->data['Parameter']['reference_fa_auto'] = $parameter[3]['Parameter']['reference_fa_auto'];
        $this->request->data['Parameter']['reference_av_auto'] = $parameter[3]['Parameter']['reference_av_auto'];
        $this->request->data['Parameter']['reference_ds_auto'] = $parameter[3]['Parameter']['reference_ds_auto'];

        $this->request->data['Parameter']['reference_sizes'] = $parameter[3]['Parameter']['reference_sizes'];
        $this->request->data['Parameter']['date_suffixe'] = $parameter[3]['Parameter']['date_suffixe'];
        $this->request->data['Parameter']['abbreviation_location'] = $parameter[3]['Parameter']['abbreviation_location'];
        $this->request->data['Parameter']['demande_devis'] = $parameter[3]['Parameter']['demande_devis'];
        $this->request->data['Parameter']['devis'] = $parameter[3]['Parameter']['devis'];
        $this->request->data['Parameter']['commande'] = $parameter[3]['Parameter']['commande'];
        $this->request->data['Parameter']['feuille_route'] = $parameter[3]['Parameter']['feuille_route'];
        $this->request->data['Parameter']['prefacture'] = $parameter[3]['Parameter']['prefacture'];
        $this->request->data['Parameter']['facture'] = $parameter[3]['Parameter']['facture'];
        $this->request->data['Parameter']['avoir_vente'] = $parameter[3]['Parameter']['avoir_vente'];
        $this->request->data['Parameter']['bordereau_envoi'] = $parameter[3]['Parameter']['bordereau_envoi'];

        $this->request->data['Parameter']['next_reference_demande_devis'] = $parameter[3]['Parameter']['next_reference_demande_devis'];
        $this->request->data['Parameter']['next_reference_devis'] = $parameter[3]['Parameter']['next_reference_devis'];
        $this->request->data['Parameter']['next_reference_commande'] = $parameter[3]['Parameter']['next_reference_commande'];
        $this->request->data['Parameter']['next_reference_feuille_route'] = $parameter[3]['Parameter']['next_reference_feuille_route'];
        $this->request->data['Parameter']['next_reference_prefacture'] = $parameter[3]['Parameter']['next_reference_prefacture'];
        $this->request->data['Parameter']['next_reference_facture'] = $parameter[3]['Parameter']['next_reference_facture'];
        $this->request->data['Parameter']['next_reference_avoir_vente'] = $parameter[3]['Parameter']['next_reference_avoir_vente'];
        $this->request->data['Parameter']['next_reference_bordereau_envoi'] = $parameter[3]['Parameter']['next_reference_bordereau_envoi'];

        $this->request->data['Parameter']['type_ride'] = $parameter[3]['Parameter']['type_ride'];
        $this->request->data['Parameter']['synchronization_fr_bc'] = $parameter[3]['Parameter']['synchronization_fr_bc'];
        $this->request->data['Parameter']['nb_trucks_modifiable'] = $parameter[3]['Parameter']['nb_trucks_modifiable'];
        $this->request->data['Parameter']['default_nb_trucks'] = $parameter[3]['Parameter']['default_nb_trucks'];
        $this->request->data['Parameter']['type_ride_used_first'] = $parameter[3]['Parameter']['type_ride_used_first'];
        $this->request->data['Parameter']['param_price_night'] = $parameter[3]['Parameter']['param_price_night'];
        $this->request->data['Parameter']['type_pricing'] = $parameter[3]['Parameter']['type_pricing'];
        $this->request->data['Parameter']['param_price'] = $parameter[3]['Parameter']['param_price'];
        $this->request->data['Parameter']['transformation_closed_mission'] = $parameter[3]['Parameter']['transformation_closed_mission'];
        $this->request->data['Parameter']['use_ride_category'] = $parameter[3]['Parameter']['use_ride_category'];
        $this->request->data['Parameter']['display_mission_cost'] = $parameter[3]['Parameter']['display_mission_cost'];
        $this->request->data['Parameter']['param_mission_cost'] = $parameter[3]['Parameter']['param_mission_cost'];
        $this->request->data['Parameter']['sheet_ride_name'] = $parameter[3]['Parameter']['sheet_ride_name'];
        $this->request->data['Parameter']['sheet_ride_with_mission'] = $parameter[3]['Parameter']['sheet_ride_with_mission'];
        $this->request->data['Parameter']['default_status'] = $parameter[3]['Parameter']['default_status'];
        $this->request->data['Parameter']['destination_required'] = $parameter[3]['Parameter']['destination_required'];
        $this->request->data['Parameter']['calcul_by_maps'] = $parameter[3]['Parameter']['calcul_by_maps'];
        $this->request->data['Parameter']['car_customer_out_park'] = $parameter[3]['Parameter']['car_customer_out_park'];
        $this->request->data['Parameter']['car_subcontracting'] = $parameter[3]['Parameter']['car_subcontracting'];
        $this->request->data['Parameter']['subcontractor_cost_percentage'] = $parameter[3]['Parameter']['subcontractor_cost_percentage'];
        $this->request->data['Parameter']['marchandise_required'] = $parameter[3]['Parameter']['marchandise_required'];
        $this->request->data['Parameter']['use_purchase_bill'] = $parameter[3]['Parameter']['use_purchase_bill'];
        $this->request->data['Parameter']['loading_time'] = $parameter[3]['Parameter']['loading_time'];
        $this->request->data['Parameter']['unloading_time'] = $parameter[3]['Parameter']['unloading_time'];
        $this->request->data['Parameter']['maximum_driving_time'] = $parameter[3]['Parameter']['maximum_driving_time'];
        $this->request->data['Parameter']['break_time'] = $parameter[3]['Parameter']['break_time'];
        $this->request->data['Parameter']['additional_time_allowed'] = $parameter[3]['Parameter']['additional_time_allowed'];


        $this->request->data['Parameter']['reference_so_auto'] = $parameter[3]['Parameter']['reference_so_auto'];
        $this->request->data['Parameter']['reference_re_auto'] = $parameter[3]['Parameter']['reference_re_auto'];
        $this->request->data['Parameter']['reference_rs_auto'] = $parameter[3]['Parameter']['reference_rs_auto'];
        $this->request->data['Parameter']['reference_pi_auto'] = $parameter[3]['Parameter']['reference_pi_auto'];
        $this->request->data['Parameter']['reference_cn_auto'] = $parameter[3]['Parameter']['reference_cn_auto'];
        $this->request->data['Parameter']['reference_do_auto'] = $parameter[3]['Parameter']['reference_do_auto'];
        $this->request->data['Parameter']['reference_rc_auto'] = $parameter[3]['Parameter']['reference_rc_auto'];
        $this->request->data['Parameter']['reference_eo_auto'] = $parameter[3]['Parameter']['reference_eo_auto'];
        $this->request->data['Parameter']['reference_xo_auto'] = $parameter[3]['Parameter']['reference_xo_auto'];
        $this->request->data['Parameter']['reference_ro_auto'] = $parameter[3]['Parameter']['reference_ro_auto'];
        $this->request->data['Parameter']['reference_ri_auto'] = $parameter[3]['Parameter']['reference_ri_auto'];
        $this->request->data['Parameter']['reference_tr_auto'] = $parameter[3]['Parameter']['reference_tr_auto'];
        $this->request->data['Parameter']['reference_pr_auto'] = $parameter[3]['Parameter']['reference_pr_auto'];
        $this->request->data['Parameter']['reference_ar_auto'] = $parameter[3]['Parameter']['reference_ar_auto'];


        $this->request->data['Parameter']['reference_bill_sizes'] = $parameter[3]['Parameter']['reference_bill_sizes'];
        $this->request->data['Parameter']['date_bill_suffixe'] = $parameter[3]['Parameter']['date_bill_suffixe'];
        $this->request->data['Parameter']['abbreviation_bill_location'] = $parameter[3]['Parameter']['abbreviation_bill_location'];
        $this->request->data['Parameter']['supplier_order'] = $parameter[3]['Parameter']['supplier_order'];
        $this->request->data['Parameter']['receipt'] = $parameter[3]['Parameter']['receipt'];
        $this->request->data['Parameter']['return_supplier'] = $parameter[3]['Parameter']['return_supplier'];
        $this->request->data['Parameter']['purchase_invoice'] = $parameter[3]['Parameter']['purchase_invoice'];
        $this->request->data['Parameter']['credit_note'] = $parameter[3]['Parameter']['credit_note'];
        $this->request->data['Parameter']['delivery_order'] = $parameter[3]['Parameter']['delivery_order'];
        $this->request->data['Parameter']['return_customer'] = $parameter[3]['Parameter']['return_customer'];
        $this->request->data['Parameter']['entry_order'] = $parameter[3]['Parameter']['entry_order'];
        $this->request->data['Parameter']['exit_order'] = $parameter[3]['Parameter']['exit_order'];
        $this->request->data['Parameter']['renvoi_order'] = $parameter[3]['Parameter']['renvoi_order'];
        $this->request->data['Parameter']['reintegration_order'] = $parameter[3]['Parameter']['reintegration_order'];
        $this->request->data['Parameter']['transfer_receipt'] = $parameter[3]['Parameter']['transfer_receipt'];
        $this->request->data['Parameter']['product_request'] = $parameter[3]['Parameter']['product_request'];
        $this->request->data['Parameter']['purchase_request'] = $parameter[3]['Parameter']['purchase_request'];


        $this->request->data['Parameter']['next_reference_supplier_order'] = $parameter[3]['Parameter']['next_reference_supplier_order'];
        $this->request->data['Parameter']['next_reference_receipt'] = $parameter[3]['Parameter']['next_reference_receipt'];
        $this->request->data['Parameter']['next_reference_return_supplier'] = $parameter[3]['Parameter']['next_reference_return_supplier'];
        $this->request->data['Parameter']['next_reference_purchase_invoice'] = $parameter[3]['Parameter']['next_reference_purchase_invoice'];
        $this->request->data['Parameter']['next_reference_credit_note'] = $parameter[3]['Parameter']['next_reference_credit_note'];
        $this->request->data['Parameter']['next_reference_delivery_order'] = $parameter[3]['Parameter']['next_reference_delivery_order'];
        $this->request->data['Parameter']['next_reference_return_customer'] = $parameter[3]['Parameter']['next_reference_return_customer'];
        $this->request->data['Parameter']['next_reference_entry_order'] = $parameter[3]['Parameter']['next_reference_entry_order'];
        $this->request->data['Parameter']['next_reference_exit_order'] = $parameter[3]['Parameter']['next_reference_exit_order'];
        $this->request->data['Parameter']['next_reference_renvoi_order'] = $parameter[3]['Parameter']['next_reference_renvoi_order'];
        $this->request->data['Parameter']['next_reference_reintegration_order'] = $parameter[3]['Parameter']['next_reference_reintegration_order'];
        $this->request->data['Parameter']['next_reference_transfer_receipt'] = $parameter[3]['Parameter']['next_reference_transfer_receipt'];
        $this->request->data['Parameter']['next_reference_product_request'] = $parameter[3]['Parameter']['next_reference_product_request'];
        $this->request->data['Parameter']['next_reference_purchase_request'] = $parameter[3]['Parameter']['next_reference_purchase_request'];


        $this->request->data['Parameter']['reference_product_auto'] = $parameter[3]['Parameter']['reference_product_auto'];
        $this->request->data['Parameter']['reference_product_sizes'] = $parameter[3]['Parameter']['reference_product_sizes'];
        $this->request->data['Parameter']['next_reference_product'] = $parameter[3]['Parameter']['next_reference_product'];
        $this->request->data['Parameter']['is_multi_warehouses'] = $parameter[3]['Parameter']['is_multi_warehouses'];

        $this->request->data['Parameter']['negative_account'] = $parameter[3]['Parameter']['negative_account'];
        $this->request->data['Parameter']['attachment_display_sheet_ride'] = $parameter[3]['Parameter']['attachment_display_sheet_ride'];
        $this->request->data['Parameter']['is_sheet_ride_required_for_consumption'] = $parameter[3]['Parameter']['is_sheet_ride_required_for_consumption'];

        if($this->request->data['Parameter']['attachment_display_sheet_ride'] ==2){
            $this->loadModel('AttachmentType');
            $this->loadModel('ParameterAttachmentType');
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
            $parameterAttachmentTypes = $this->ParameterAttachmentType->getParameterAttachmentTypes();
        }else {
            $attachmentTypes = array();
            $parameterAttachmentTypes = array();
        }


        $this->set(compact('attachmentTypes','parameterAttachmentTypes'));



        $this->request->data['Parameter']['entete_pdf'] = $parameter[3]['Parameter']['entete_pdf'];
        $this->request->data['Parameter']['choice_reporting'] = $parameter[3]['Parameter']['choice_reporting'];
        $this->request->data['Parameter']['reports_path_pdf'] = $parameter[3]['Parameter']['reports_path_pdf'];
        $this->request->data['Parameter']['reports_path_jasper'] = $parameter[3]['Parameter']['reports_path_jasper'];
        $this->request->data['Parameter']['username_jasper'] = $parameter[3]['Parameter']['username_jasper'];
        $this->request->data['Parameter']['password_jasper'] = $parameter[3]['Parameter']['password_jasper'];
        $this->request->data['Parameter']['tomcat_path'] = $parameter[3]['Parameter']['tomcat_path'];
        $this->request->data['Parameter']['mission_order_model'] = $parameter[3]['Parameter']['mission_order_model'];
        $this->request->data['Parameter']['commercial_document_model'] = $parameter[3]['Parameter']['commercial_document_model'];
        $this->request->data['Parameter']['synchronization_km'] = $parameter[3]['Parameter']['synchronization_km'];
        $this->request->data['Parameter']['header_synchronization'] = $parameter[3]['Parameter']['header_synchronization'];
        $this->request->data['Parameter']['url_synchronization'] = $parameter[3]['Parameter']['url_synchronization'];

        $this->request->data['Parameter']['save_bdd_path'] = $parameter[3]['Parameter']['save_bdd_path'];
        $this->request->data['Parameter']['signature_mission_order'] = $parameter[3]['Parameter']['signature_mission_order'];
        $this->request->data['Parameter']['observation1'] = $parameter[3]['Parameter']['observation1'];
        $this->request->data['Parameter']['observation2'] = $parameter[3]['Parameter']['observation2'];
        $this->request->data['Parameter']['depot'] = $parameter[4]['Parameter']['depot'];
        $this->request->data['Parameter']['year_contract'] = $parameter[6]['Parameter']['val'];
        $this->request->data['Parameter']['company'] = $parameter[7]['Parameter']['company'];
        $this->request->data['Parameter']['email3'] = $parameter[7]['Parameter']['email3'];
        $this->request->data['Parameter']['job'] = $parameter[7]['Parameter']['job'];
        $this->request->data['Parameter']['monthly_payroll'] = $parameter[7]['Parameter']['monthly_payroll'];
        $this->request->data['Parameter']['note'] = $parameter[7]['Parameter']['note'];
        $this->request->data['Parameter']['declaration_date'] = $parameter[7]['Parameter']['declaration_date'];
        $this->request->data['Parameter']['affiliate'] = $parameter[7]['Parameter']['affiliate'];
        $this->request->data['Parameter']['ccp'] = $parameter[7]['Parameter']['ccp'];
        $this->request->data['Parameter']['bank_account'] = $parameter[7]['Parameter']['bank_account'];
        $this->request->data['Parameter']['identity_card'] = $parameter[7]['Parameter']['identity_card'];
        $this->request->data['Parameter']['passport'] = $parameter[7]['Parameter']['passport'];
        $this->request->data['Parameter']['totaux_dashbord'] = $parameter[7]['Parameter']['totaux_dashbord'];
        $this->request->data['Parameter']['difference_allowed'] = $parameter[8]['Parameter']['val'];
        $missionCostParameters = $this->MissionCostParameter->getMissionCostParameters($parameter[3]['Parameter']['param_mission_cost']);

        $this->hasPurchaseBill();

        $destinations = $this->Destination->find('list');
        $carTypes = $this->CarType->getCarTypes();
        $this->set(compact('legalForms',
            'languages', 'carTypes',
            'currencies','countries', 'missionCostParameters',
            'selectedLanguage',
            'selectedCurrency',
            'selectedCountry',
            'destinations'));

    }
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit()
    {
        $this->setTimeActif();
        $this->verifySuperAdministrator('Users');
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Alerts cancelled.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }

            if ($this->Parameter->saveAll($this->request->data['Parameter'])) {
                $this->Flash->success(__('Alerts have been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The parameter could not be saved. Please, try again.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }


    public function gedit()
    {
        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(8, 9,31)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
                $parameter[0]['Parameter']['val'] = (int)$this->request->data['Parameter']['language'];
                $this->Parameter->save($parameter[0]);
                $parameter[1]['Parameter']['val'] = (int)$this->request->data['Parameter']['currency'];
                $this->Parameter->save($parameter[1]);
                $parameter[2]['Parameter']['val'] = isset($this->request->data['Parameter']['country']) ? (int) $this->request->data['Parameter']['country'] : '';
                $this->Parameter->save($parameter[2]);
                $language = $this->Language->find(
                    'first',
                    array(
                        'recursive' => -1,
                        'conditions' => array('id' => (int)$parameter[0]['Parameter']['val'])
                    )
                );
                $currency = $this->Currency->find(
                    'first',
                    array(
                        'recursive' => -1,
                        'conditions' => array('id' => (int)$parameter[1]['Parameter']['val'])
                    )
                );


                $this->Session->write('User.language', $language['Language']['abr']);
                $this->Session->write('currency', $currency['Currency']['abr']);
                $this->Session->write('currencyName', $currency['Currency']['name']);

                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }
    public function cedit()
    {
        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(10, 23)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
                $parameter[0]['Parameter']['val'] = (int)$this->request->data['Parameter']['coupon_price'];
                $parameter[1]['Parameter']['val'] = (int)$this->request->data['Parameter']['difference_allowed'];
                $this->Parameter->save($parameter[0]);
                $this->Parameter->save($parameter[1]);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }
    public function codeedit()
    {
        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter[0]['Parameter']['auto'] = (int)$this->request->data['Parameter']['auto'];
                $parameter[0]['Parameter']['size'] = (int)$this->request->data['Parameter']['sizes'];
                $parameter[0]['Parameter']['name_car'] = (int)$this->request->data['Parameter']['param_car'];
                $parameter[0]['Parameter']['param_coupon'] = (int)$this->request->data['Parameter']['param_coupon'];

                $this->Parameter->save($parameter[0]);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function variousedit()
    {
        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter[0]['Parameter']['affectation_mode'] = (int)$this->request->data['Parameter']['affectation_mode'];
                $parameter[0]['Parameter']['fuellog_coupon'] = (int)$this->request->data['Parameter']['fuellog_coupon'];
                $parameter[0]['Parameter']['balance_car'] = (int)$this->request->data['Parameter']['balance_car'];
                $parameter[0]['Parameter']['tank_spacies'] = (int)$this->request->data['Parameter']['tank_spacies'];
                $parameter[0]['Parameter']['consumption_coupon'] = $this->request->data['Parameter']['consumption_coupon'];
                $parameter[0]['Parameter']['consumption_tank'] = $this->request->data['Parameter']['consumption_tank'];
                $parameter[0]['Parameter']['consumption_spacies'] = $this->request->data['Parameter']['consumption_spacies'];
                $parameter[0]['Parameter']['priority'] = $this->request->data['Parameter']['priority'];
                $this->Parameter->save($parameter[0]);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function parameterTransport()
    {
        $this->setTimeActif();
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
				if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['reference_dd_auto'] = (int)$this->request->data['Parameter']['reference_dd_auto'];
                }
				$parameter['Parameter']['reference_fp_auto'] = (int)$this->request->data['Parameter']['reference_fp_auto'];
                $parameter['Parameter']['reference_bc_auto'] = (int)$this->request->data['Parameter']['reference_bc_auto'];
                if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['reference_fr_auto'] = (int)$this->request->data['Parameter']['reference_fr_auto'];
					$parameter['Parameter']['reference_mi_auto'] = (int)$this->request->data['Parameter']['reference_mi_auto'];
					$parameter['Parameter']['reference_pf_auto'] = (int)$this->request->data['Parameter']['reference_pf_auto'];
                }
				$parameter['Parameter']['reference_fa_auto'] = (int)$this->request->data['Parameter']['reference_fa_auto'];
				$parameter['Parameter']['reference_av_auto'] = (int)$this->request->data['Parameter']['reference_av_auto'];
				$parameter['Parameter']['reference_ds_auto'] = (int)$this->request->data['Parameter']['reference_ds_auto'];

				$parameter['Parameter']['reference_sizes'] = (int)$this->request->data['Parameter']['reference_sizes'];
                $parameter['Parameter']['date_suffixe'] = (int)$this->request->data['Parameter']['date_suffixe'];
                $parameter['Parameter']['abbreviation_location'] = (int)$this->request->data['Parameter']['abbreviation_location'];
                if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['demande_devis'] = $this->request->data['Parameter']['demande_devis'];
				}
				$parameter['Parameter']['devis'] = $this->request->data['Parameter']['devis'];
                $parameter['Parameter']['commande'] = $this->request->data['Parameter']['commande'];
                if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['feuille_route'] = $this->request->data['Parameter']['feuille_route'];
					$parameter['Parameter']['prefacture'] = $this->request->data['Parameter']['prefacture'];
                }
				$parameter['Parameter']['facture'] = $this->request->data['Parameter']['facture'];
				$parameter['Parameter']['avoir_vente'] = $this->request->data['Parameter']['avoir_vente'];
				$parameter['Parameter']['bordereau_envoi'] = $this->request->data['Parameter']['bordereau_envoi'];

				if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['next_reference_demande_devis'] = $this->request->data['Parameter']['next_reference_demande_devis'];
                }
				$parameter['Parameter']['next_reference_devis'] = $this->request->data['Parameter']['next_reference_devis'];
                $parameter['Parameter']['next_reference_commande'] = $this->request->data['Parameter']['next_reference_commande'];
                if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['next_reference_feuille_route'] = $this->request->data['Parameter']['next_reference_feuille_route'];
					$parameter['Parameter']['next_reference_prefacture'] = $this->request->data['Parameter']['next_reference_prefacture'];
                }
				
				$parameter['Parameter']['next_reference_facture'] = $this->request->data['Parameter']['next_reference_facture'];
				$parameter['Parameter']['next_reference_avoir_vente'] = $this->request->data['Parameter']['next_reference_avoir_vente'];
				$parameter['Parameter']['next_reference_bordereau_envoi'] = $this->request->data['Parameter']['next_reference_bordereau_envoi'];

				if(Configure::read("gestion_commercial") == '1' ) {
					$parameter['Parameter']['type_ride'] = (int)$this->request->data['Parameter']['type_ride'];
					$parameter['Parameter']['synchronization_fr_bc'] = (int)$this->request->data['Parameter']['synchronization_fr_bc'];
					$parameter['Parameter']['nb_trucks_modifiable'] = (int)$this->request->data['Parameter']['nb_trucks_modifiable'];
					$parameter['Parameter']['default_nb_trucks'] = (int)$this->request->data['Parameter']['default_nb_trucks'];
					$parameter['Parameter']['type_ride_used_first'] = (int)$this->request->data['Parameter']['type_ride_used_first'];
					$parameter['Parameter']['param_price_night'] = (int)$this->request->data['Parameter']['param_price_night'];
					$parameter['Parameter']['type_pricing'] = (int)$this->request->data['Parameter']['type_pricing'];
					$parameter['Parameter']['param_price'] = (int)$this->request->data['Parameter']['param_price'];
					$parameter['Parameter']['transformation_closed_mission'] = (int)$this->request->data['Parameter']['transformation_closed_mission'];
					$parameter['Parameter']['use_ride_category'] = $this->request->data['Parameter']['use_ride_category'];
					$parameter['Parameter']['display_mission_cost'] = $this->request->data['Parameter']['display_mission_cost'];
					$parameter['Parameter']['param_mission_cost'] = $this->request->data['Parameter']['param_mission_cost'];
					if (!empty($this->request->data['MissionCostParameter'])) {
						$missionCostParameters = $this->request->data['MissionCostParameter'];
						$this->MissionCostParameter->addMissionCostParameter($missionCostParameters,
							$parameter['Parameter']['param_mission_cost']);
					}
					$parameter['Parameter']['sheet_ride_name'] = $this->request->data['Parameter']['sheet_ride_name'];
					$parameter['Parameter']['sheet_ride_with_mission'] = $this->request->data['Parameter']['sheet_ride_with_mission'];
					$parameter['Parameter']['default_status'] = $this->request->data['Parameter']['default_status'];
					$parameter['Parameter']['destination_required'] = $this->request->data['Parameter']['destination_required'];
					$parameter['Parameter']['calcul_by_maps'] = $this->request->data['Parameter']['calcul_by_maps'];
					$parameter['Parameter']['car_customer_out_park'] = $this->request->data['Parameter']['car_customer_out_park'];
					$parameter['Parameter']['car_subcontracting'] = $this->request->data['Parameter']['car_subcontracting'];
					$parameter['Parameter']['subcontractor_cost_percentage'] = $this->request->data['Parameter']['subcontractor_cost_percentage'];
					$parameter['Parameter']['marchandise_required'] = $this->request->data['Parameter']['marchandise_required'];
					$parameter['Parameter']['use_purchase_bill'] = $this->request->data['Parameter']['use_purchase_bill'];
					$parameter['Parameter']['loading_time'] = (float)$this->request->data['Parameter']['loading_time'];
					$parameter['Parameter']['unloading_time'] = (float)$this->request->data['Parameter']['unloading_time'];
					$parameter['Parameter']['maximum_driving_time'] = (float)$this->request->data['Parameter']['maximum_driving_time'];
					$parameter['Parameter']['break_time'] = (float)$this->request->data['Parameter']['break_time'];
					$parameter['Parameter']['additional_time_allowed'] = (float)$this->request->data['Parameter']['additional_time_allowed'];
					
				}

				$this->Parameter->save($parameter);
                $useRideCategory = $this->useRideCategory();
                $this->getNameSheetRide();
                $this->addCarsSubcontracting();
                $this->Session->write('useRideCategory', $useRideCategory);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function parameterBill()
    {
        $this->setTimeActif();
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
                $parameter['Parameter']['reference_so_auto'] = (int)$this->request->data['Parameter']['reference_so_auto'];
                $parameter['Parameter']['reference_re_auto'] = (int)$this->request->data['Parameter']['reference_re_auto'];
                $parameter['Parameter']['reference_rs_auto'] = (int)$this->request->data['Parameter']['reference_rs_auto'];
                $parameter['Parameter']['reference_pi_auto'] = (int)$this->request->data['Parameter']['reference_pi_auto'];
                $parameter['Parameter']['reference_cn_auto'] = (int)$this->request->data['Parameter']['reference_cn_auto'];
                $parameter['Parameter']['reference_do_auto'] = (int)$this->request->data['Parameter']['reference_do_auto'];
                $parameter['Parameter']['reference_rc_auto'] = (int)$this->request->data['Parameter']['reference_rc_auto'];
                $parameter['Parameter']['reference_eo_auto'] = (int)$this->request->data['Parameter']['reference_eo_auto'];
                $parameter['Parameter']['reference_xo_auto'] = (int)$this->request->data['Parameter']['reference_xo_auto'];
                $parameter['Parameter']['reference_ro_auto'] = (int)$this->request->data['Parameter']['reference_ro_auto'];
                $parameter['Parameter']['reference_ri_auto'] = (int)$this->request->data['Parameter']['reference_ri_auto'];
                $parameter['Parameter']['reference_tr_auto'] = (int)$this->request->data['Parameter']['reference_tr_auto'];


                $parameter['Parameter']['reference_bill_sizes'] = (int)$this->request->data['Parameter']['reference_bill_sizes'];
                $parameter['Parameter']['date_bill_suffixe'] = (int)$this->request->data['Parameter']['date_bill_suffixe'];
                $parameter['Parameter']['abbreviation_bill_location'] = (int)$this->request->data['Parameter']['abbreviation_bill_location'];
                $parameter['Parameter']['supplier_order'] = $this->request->data['Parameter']['supplier_order'];
                $parameter['Parameter']['receipt'] = $this->request->data['Parameter']['receipt'];
                $parameter['Parameter']['return_supplier'] = $this->request->data['Parameter']['return_supplier'];
                $parameter['Parameter']['purchase_invoice'] = $this->request->data['Parameter']['purchase_invoice'];
                $parameter['Parameter']['credit_note'] = $this->request->data['Parameter']['credit_note'];
                $parameter['Parameter']['delivery_order'] = $this->request->data['Parameter']['delivery_order'];
                $parameter['Parameter']['return_customer'] = $this->request->data['Parameter']['return_customer'];
                $parameter['Parameter']['entry_order'] = $this->request->data['Parameter']['entry_order'];
                $parameter['Parameter']['exit_order'] = $this->request->data['Parameter']['exit_order'];
                $parameter['Parameter']['renvoi_order'] = $this->request->data['Parameter']['renvoi_order'];
                $parameter['Parameter']['reintegration_order'] = $this->request->data['Parameter']['reintegration_order'];
                $parameter['Parameter']['transfer_receipt'] = $this->request->data['Parameter']['transfer_receipt'];


                $parameter['Parameter']['next_reference_supplier_order'] = $this->request->data['Parameter']['next_reference_supplier_order'];
                $parameter['Parameter']['next_reference_receipt'] = $this->request->data['Parameter']['next_reference_receipt'];
                $parameter['Parameter']['next_reference_return_supplier'] = $this->request->data['Parameter']['next_reference_return_supplier'];
                $parameter['Parameter']['next_reference_purchase_invoice'] = $this->request->data['Parameter']['next_reference_purchase_invoice'];
                $parameter['Parameter']['next_reference_credit_note'] = $this->request->data['Parameter']['next_reference_credit_note'];
                $parameter['Parameter']['next_reference_delivery_order'] = $this->request->data['Parameter']['next_reference_delivery_order'];
                $parameter['Parameter']['next_reference_return_customer'] = $this->request->data['Parameter']['next_reference_return_customer'];
                $parameter['Parameter']['next_reference_entry_order'] = $this->request->data['Parameter']['next_reference_entry_order'];
                $parameter['Parameter']['next_reference_exit_order'] = $this->request->data['Parameter']['next_reference_exit_order'];
                $parameter['Parameter']['next_reference_renvoi_order'] = $this->request->data['Parameter']['next_reference_renvoi_order'];
                $parameter['Parameter']['next_reference_reintegration_order'] = $this->request->data['Parameter']['next_reference_reintegration_order'];
                $parameter['Parameter']['next_reference_transfer_receipt'] = $this->request->data['Parameter']['next_reference_transfer_receipt'];


                $parameter['Parameter']['reference_product_auto'] = (int)$this->request->data['Parameter']['reference_product_auto'];
                $parameter['Parameter']['reference_product_sizes'] = (int)$this->request->data['Parameter']['reference_product_sizes'];
                $parameter['Parameter']['next_reference_product'] = (int)$this->request->data['Parameter']['next_reference_product'];
                $parameter['Parameter']['is_multi_warehouses'] = (int)$this->request->data['Parameter']['is_multi_warehouses'];


                $this->Parameter->save($parameter);
                $useRideCategory = $this->useRideCategory();
                $multiWarehouses = $this->isMultiWarehouses();



                $this->Session->write('useRideCategory', $useRideCategory);
                $this->Session->write('multiWarehouses', $multiWarehouses);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function parameterProcurement()
    {
        $this->setTimeActif();
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {

                $parameter['Parameter']['reference_pr_auto'] = (int)$this->request->data['Parameter']['reference_pr_auto'];
                $parameter['Parameter']['reference_ar_auto'] = (int)$this->request->data['Parameter']['reference_ar_auto'];

                $parameter['Parameter']['product_request'] = $this->request->data['Parameter']['product_request'];
                $parameter['Parameter']['purchase_request'] = $this->request->data['Parameter']['purchase_request'];


                $parameter['Parameter']['next_reference_product_request'] = $this->request->data['Parameter']['next_reference_product_request'];
                $parameter['Parameter']['next_reference_purchase_request'] = $this->request->data['Parameter']['next_reference_purchase_request'];


              $this->Parameter->save($parameter);
                $useRideCategory = $this->useRideCategory();



                $this->Session->write('useRideCategory', $useRideCategory);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }



    public function contractedit()
    {
        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(19)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {


                $parameter[0]['Parameter']['val'] = (int)$this->request->data['Parameter']['year_contract'];
                $this->Parameter->save($parameter[0]);
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function depotedit()
    {
        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(14)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
                $parameter[0]['Parameter']['depot'] = (int)$this->request->data['Parameter']['depot'];

                $this->Parameter->save($parameter[0]);
                $this->ProductDepot();
                $this->Flash->success(__('Parameters have been saved.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function download()
    {
        // check mysqli extension installed
        if (!function_exists('mysqli_connect')) {
            die(' This scripts need mysql extension to be running properly ! please resolve!!');
        }

        $fields = get_class_vars('DATABASE_CONFIG');

        $host = $fields['default']['host'];
        $port = $fields['default']['port'];
        $user = $fields['default']['login'];
        $pass = $fields['default']['password'];
        $name = $fields['default']['database'];

        $mysqli = @new mysqli($host, $user, $pass, $name, $port);

        if ($mysqli->connect_error) {
            $this->Flash->error($mysqli->connect_error);
            $this->redirect(array('action' => 'index'));
        }

        $dir = 'SAVE_BDD/' . $name;
        $fileName = date("l") . '.sql.gz';
        $fullName = 'SAVE_BDD/' . $name . '/' . date("l") . '.sql.gz';
        $res = true;
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 755)) {
                $this->Flash->error(__('Could not create backup directory. Please make sure you have set Directory on 755 or 777 for a while.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        if ($res) {
            if (!$mysqli->error) {
                $sql = "SHOW TABLES";
                $show = $mysqli->query($sql);
                while ($r = $show->fetch_array()) {
                    $tables[] = $r[0];
                }
                if (!empty($tables)) {
                    //cycle through
                    $return = '';
                    foreach ($tables as $table) {
                        $result = $mysqli->query('SELECT * FROM ' . $table);
                        $num_fields = $result->field_count;
                        $row2 = $mysqli->query('SHOW CREATE TABLE ' . $table);
                        $row2 = $row2->fetch_row();
                        $return .=
                            "\n
-- ---------------------------------------------------------
--
-- Table structure for table : `{$table}`
--
-- ---------------------------------------------------------
" . $row2[1] . ";\n";
                        for ($i = 0; $i < $num_fields; $i++) {
                            $n = 1;
                            while ($row = $result->fetch_row()) {

                                if ($n++ == 1) { # set the first statements
                                    $return .=
                                        "
--
-- Dumping data for table `{$table}`
--
";
                                    /**
                                     * Get structural of fields each tables
                                     */
                                    $array_field = array(); #reset ! important to resetting when loop
                                    while ($field = $result->fetch_field()) # get field
                                    {
                                        $array_field[] = '`' . $field->name . '`';

                                    }
                                    $array_f[$table] = $array_field;
                                    // $array_f = $array_f;
                                    # endwhile
                                    $array_field = implode(', ', $array_f[$table]); #implode arrays
                                    $return .= "INSERT INTO `{$table}` ({$array_field}) VALUES\n(";
                                } else {
                                    $return .= '(';
                                }
                                for ($j = 0; $j < $num_fields; $j++) {

                                    $row[$j] = str_replace('\'', '\'\'', preg_replace("/\n/", "\\n", $row[$j]));
                                    if (isset($row[$j])) {
                                        $return .= is_numeric($row[$j]) ? $row[$j] : '\'' . $row[$j] . '\'';
                                    } else {
                                        $return .= '\'\'';
                                    }
                                    if ($j < ($num_fields - 1)) {
                                        $return .= ', ';
                                    }
                                }
                                $return .= "),\n";
                            }
                            # check matching
                            @preg_match("/\),\n/", $return, $match, false, -3); # check match
                            if (isset($match[0])) {
                                $return = substr_replace($return, ";\n", -2);
                            }
                        }

                        $return .= "\n";
                    }
                    $return =
                        "-- ---------------------------------------------------------
--
-- SIMPLE SQL Dump
--
-- IntelliX Web
--
-- Host Connection Info: " . $mysqli->host_info . "
-- Generation Time: " . date('F d, Y \a\t H:i A ( e )') . "
-- PHP Version: " . PHP_VERSION . "
--
-- ---------------------------------------------------------\n\n
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
SET FOREIGN_KEY_CHECKS=0;
" . $return . "
SET FOREIGN_KEY_CHECKS = 1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
# end values result
                    @ini_set('zlib.output_compression', 'Off');
                    $gzipoutput = gzencode($return, 9);
                    if (!@ file_put_contents($fullName, $gzipoutput)) { # 9 as compression levels
                        # if could not put file , automaticly you will get the file as downloadable
                        // various headers, those with # are mandatory
                        header('Content-Type: application/x-gzip'); // change it to mimetype
                        header("Content-Description: File Transfer");
                        header('Content-Encoding: gzip'); #
                        header('Content-Length: ' . strlen($gzipoutput)); #
                        header('Content-Disposition: attachment; filename="' . $fileName . '"');
                        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
                        header('Connection: Keep-Alive');
                        header("Content-Transfer-Encoding: binary");
                        header('Expires: 0');
                        header('Pragma: no-cache');

                        echo $gzipoutput;
                    }
                } else {
                    $this->Flash->error(__('Error when executing database query to export.' . $mysqli->error));
                    $this->redirect(array('action' => 'index'));
                }

            }
        } else {
            $this->Flash->error(__('Wrong mysqli input.'));
            $this->redirect(array('action' => 'index'));
        }

        if ($mysqli && !$mysqli->error) {
            @$mysqli->close();
        } else {
            $this->Flash->error(__('MySql error.'));
            $this->redirect(array('action' => 'index'));
        }




        $this->set('fullName', $fullName);
        $this->set('fileName', $fileName);


        /*
		
    
        foreach($tables as $table)
        {
            $result = mysql_query('SELECT * FROM '.$table);
            $num_fields = mysql_num_fields($result);
            $return.= 'DROP TABLE '.$table.';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";
            for ($i = 0; $i < $num_fields; $i++)
            {
                while($row = mysql_fetch_row($result))
                {
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j < $num_fields; $j++)
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j < ($num_fields-1)) { $return.= ','; }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n\n";
        }
        $fl=date("l").'.sql';
        $dossier = 'SAVE_BDD/'.$name;
        if(is_dir($dossier)){

        } else{
            mkdir($dossier);
        }
        $handle = fopen('SAVE_BDD/'.$name.'/'.$fl,'w+');
        fwrite($handle,$return);
        fclose($handle);
        $this->set('fl', $fl);
        $this->set('name', $name);
		*/

    }

 public function fichierTxt()
    {
        $lettres = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            '1','2','3','4','5','6','7','8','9','0');
        $return = '';
        $name = 'dictionnaire_password';

       // for($i = 1; $i<=35; $i ++){
            $mot = $lettres[0]  ;

            foreach ($lettres as $lettre){
                if(count($mot)==5){
                    $return .= $mot;
                    $return .="\n\n\n";
                    $mot= '';
                }else {
                    $mot = $mot.$lettre;

                }
            }
      
        //}

        $fl='dictionnaire_password.txt';
        $dossier = 'SAVE_BDD/'.$name;
        if(is_dir($dossier)){

        } else{
            mkdir($dossier);
        }
        $handle = fopen('SAVE_BDD/'.$name.'/'.$fl,'w+');
        fwrite($handle,$return);
        fclose($handle);
        $this->set('fl', $fl);
        $this->set('name', $name);


    }


    public function ParameterCar()
    {


        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter[0]['Parameter']['auto_car'] = (int)$this->request->data['Parameter']['auto_car'];
                $parameter[0]['Parameter']['sizes_car'] = (int)$this->request->data['Parameter']['sizes_car'];
                $parameter[0]['Parameter']['name_car'] = (int)$this->request->data['Parameter']['param_car'];

                $this->Parameter->save($parameter[0]);
                $this->Flash->success(__('Parameters have been saved.'));

            }

            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(19)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {

                $parameter[0]['Parameter']['val'] = (int)$this->request->data['Parameter']['year_contract'];
                $this->Parameter->save($parameter[0]);
                $this->Flash->success(__('Parameters have been saved.'));
            }
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }


    }

    public function ParameterConductor()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter[0]['Parameter']['auto_conductor'] = (int)$this->request->data['Parameter']['auto_conductor'];
                $parameter[0]['Parameter']['sizes_conductor'] = (int)$this->request->data['Parameter']['sizes_conductor'];
                $this->Parameter->save($parameter[0]);


            }


            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(20)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
                $parameter['Parameter']['company'] = (int)$this->request->data['Parameter']['company'];
                $parameter['Parameter']['email3'] = (int)$this->request->data['Parameter']['email3'];
                $parameter['Parameter']['job'] = (int)$this->request->data['Parameter']['job'];
                $parameter['Parameter']['monthly_payroll'] = (int)$this->request->data['Parameter']['monthly_payroll'];
                $parameter['Parameter']['note'] = (int)$this->request->data['Parameter']['note'];
                $parameter['Parameter']['declaration_date'] = (int)$this->request->data['Parameter']['declaration_date'];
                $parameter['Parameter']['affiliate'] = (int)$this->request->data['Parameter']['affiliate'];
                $parameter['Parameter']['ccp'] = (int)$this->request->data['Parameter']['ccp'];
                $parameter['Parameter']['bank_account'] = (int)$this->request->data['Parameter']['bank_account'];
                $parameter['Parameter']['identity_card'] = (int)$this->request->data['Parameter']['identity_card'];
                $parameter['Parameter']['passport'] = (int)$this->request->data['Parameter']['passport'];

                $this->Parameter->save($parameter);


            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }


    }


    public function ParameterAffectation()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter['Parameter']['reference_auto_affectation'] = (int)$this->request->data['Parameter']['reference_auto_affectation'];
                $parameter['Parameter']['reference_sizes_affectation'] = (int)$this->request->data['Parameter']['reference_sizes_affectation'];
                $parameter['Parameter']['date_suffixe_affectation'] = (int)$this->request->data['Parameter']['date_suffixe_affectation'];
                $parameter['Parameter']['reference_affectation'] = $this->request->data['Parameter']['reference_affectation'];
                $parameter['Parameter']['affectation_mode'] = (int)$this->request->data['Parameter']['affectation_mode'];
                $this->Parameter->save($parameter);

            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }


    }

    public function ParameterClient()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter['Parameter']['reference_auto_client_initial'] = (int)$this->request->data['Parameter']['reference_auto_client_initial'];
                $parameter['Parameter']['reference_sizes_client_initial'] = (int)$this->request->data['Parameter']['reference_sizes_client_initial'];
                $parameter['Parameter']['reference_client_initial'] = $this->request->data['Parameter']['reference_client_initial'];
                $parameter['Parameter']['next_reference_client_initial'] = $this->request->data['Parameter']['next_reference_client_initial'];
                $parameter['Parameter']['reference_auto_client_final'] = (int)$this->request->data['Parameter']['reference_auto_client_final'];
                $parameter['Parameter']['reference_sizes_client_final'] = (int)$this->request->data['Parameter']['reference_sizes_client_final'];
                $parameter['Parameter']['reference_client_final'] = $this->request->data['Parameter']['reference_client_final'];
                $parameter['Parameter']['next_reference_client_final'] = $this->request->data['Parameter']['next_reference_client_final'];
                $this->Parameter->save($parameter);

            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }


    }

    public function ParameterSupplier()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter['Parameter']['reference_auto_supplier'] = (int)$this->request->data['Parameter']['reference_auto_supplier'];
                $parameter['Parameter']['reference_sizes_supplier'] = (int)$this->request->data['Parameter']['reference_sizes_supplier'];
                $parameter['Parameter']['reference_supplier'] = $this->request->data['Parameter']['reference_supplier'];
                $parameter['Parameter']['next_reference_supplier'] = $this->request->data['Parameter']['next_reference_supplier'];
                $this->Parameter->save($parameter);

            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }


    }


    public function ParameterConsumption()
    {


        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {

                $parameter['Parameter']['fuellog_coupon'] = (int)$this->request->data['Parameter']['fuellog_coupon'];
                $parameter['Parameter']['balance_car'] = (int)$this->request->data['Parameter']['balance_car'];
                $parameter['Parameter']['tank_spacies'] = (int)$this->request->data['Parameter']['tank_spacies'];
                $parameter['Parameter']['consumption_coupon'] = $this->request->data['Parameter']['consumption_coupon'];
                $parameter['Parameter']['consumption_tank'] = $this->request->data['Parameter']['consumption_tank'];
                $parameter['Parameter']['consumption_spacies'] = $this->request->data['Parameter']['consumption_spacies'];
                $parameter['Parameter']['consumption_card'] = $this->request->data['Parameter']['consumption_card'];
                $parameter['Parameter']['priority'] = $this->request->data['Parameter']['priority'];

                $parameter['Parameter']['select_coupon'] = (int)$this->request->data['Parameter']['select_coupon'];
                $parameter['Parameter']['automatic_card_assignment'] = (int)$this->request->data['Parameter']['automatic_card_assignment'];
                $parameter['Parameter']['departure_tank_state'] = (int)$this->request->data['Parameter']['departure_tank_state'];
                $parameter['Parameter']['arrival_tank_state'] = (int)$this->request->data['Parameter']['arrival_tank_state'];
                $parameter['Parameter']['take_account_departure_tank'] = (int)$this->request->data['Parameter']['take_account_departure_tank'];
                $parameter['Parameter']['card_amount_verification'] = (int)$this->request->data['Parameter']['card_amount_verification'];
                $parameter['Parameter']['default_consumption_method'] = (int)$this->request->data['Parameter']['default_consumption_method'];
                $parameter['Parameter']['use_priority'] = (int)$this->request->data['Parameter']['use_priority'];
                $parameter['Parameter']['is_sheet_ride_required_for_consumption'] = (int)$this->request->data['Parameter']['is_sheet_ride_required_for_consumption'];
                $this->Parameter->save($parameter);

            }

            $parameter = $this->Parameter->find('all', array(
                'recursive' => -1,
                'conditions' => array('code' => array(10, 23)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {
                $parameter[0]['Parameter']['val'] = (int)$this->request->data['Parameter']['coupon_price'];
                $parameter[1]['Parameter']['val'] = (int)$this->request->data['Parameter']['difference_allowed'];
                $this->Parameter->save($parameter[0]);
                $this->Parameter->save($parameter[1]);

            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }

    }


    public function ParameterEvent()
    {


        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter['Parameter']['reference_auto_event'] = (int)$this->request->data['Parameter']['reference_auto_event'];
                $parameter['Parameter']['reference_auto_intervention_request'] = (int)$this->request->data['Parameter']['reference_auto_intervention_request'];
                $parameter['Parameter']['reference_sizes_event'] = (int)$this->request->data['Parameter']['reference_sizes_event'];
                $parameter['Parameter']['date_suffix_event'] = (int)$this->request->data['Parameter']['date_suffix_event'];
                $parameter['Parameter']['abbreviation_location_event'] = (int)$this->request->data['Parameter']['abbreviation_location_event'];
                $parameter['Parameter']['event'] = $this->request->data['Parameter']['event'];
                $parameter['Parameter']['intervention_request'] = $this->request->data['Parameter']['intervention_request'];
                $parameter['Parameter']['next_reference_event'] = $this->request->data['Parameter']['next_reference_event'];
                $parameter['Parameter']['next_reference_intervention_request'] = $this->request->data['Parameter']['next_reference_intervention_request'];


                $this->Parameter->save($parameter);

            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }

    }


    public function ParameterVarious()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {
                $parameter['Parameter']['negative_account'] = (int)$this->request->data['Parameter']['negative_account'];
                $parameter['Parameter']['attachment_display_sheet_ride'] = (int)$this->request->data['Parameter']['attachment_display_sheet_ride'];
                if($parameter['Parameter']['attachment_display_sheet_ride']==2){
                    if (!empty($this->request->data['ParameterAttachmentType'])) {
                        $this->addParameterAttachmentTypes($this->request->data['ParameterAttachmentType']);
                    }
                }
                $this->Parameter->save($parameter);

            }

            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }


    }



    public function ParameterPrinting()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));


            if (!empty($parameter)) {

                $parameter['Parameter']['entete_pdf'] = (int)$this->request->data['Parameter']['entete_pdf'];
                $parameter['Parameter']['signature_mission_order'] = $this->request->data['Parameter']['signature_mission_order'];
                $parameter['Parameter']['observation1'] = $this->request->data['Parameter']['observation1'];
                $parameter['Parameter']['observation2'] = $this->request->data['Parameter']['observation2'];
                $parameter['Parameter']['choice_reporting'] = $this->request->data['Parameter']['choice_reporting'];
                $parameter['Parameter']['reports_path_pdf'] = $this->request->data['Parameter']['reports_path_pdf'];
                $parameter['Parameter']['reports_path_jasper'] = $this->request->data['Parameter']['reports_path_jasper'];
                $parameter['Parameter']['username_jasper'] = $this->request->data['Parameter']['username_jasper'];
                $parameter['Parameter']['password_jasper'] = $this->request->data['Parameter']['password_jasper'];
                $parameter['Parameter']['tomcat_path'] = $this->request->data['Parameter']['tomcat_path'];
                $parameter['Parameter']['mission_order_model'] = $this->request->data['Parameter']['mission_order_model'];
                $parameter['Parameter']['commercial_document_model'] = $this->request->data['Parameter']['commercial_document_model'];
                $parameter['Parameter']['synchronization_km'] = $this->request->data['Parameter']['synchronization_km'];
                $parameter['Parameter']['header_synchronization'] = $this->request->data['Parameter']['header_synchronization'];
                $parameter['Parameter']['url_synchronization'] = $this->request->data['Parameter']['url_synchronization'];

                $this->Parameter->save($parameter);

            }
            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function ParameterDatabase()
    {

        $this->setTimeActif();

        if ($this->request->is(array('post', 'put'))) {

            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $parameter = $this->Parameter->find('first', array(
                'recursive' => -1,
                'conditions' => array('code' => array(12)),
                'order' => array('code' => 'ASC')
            ));
            if (!empty($parameter)) {

                $parameter['Parameter']['save_bdd_path'] = $this->request->data['Parameter']['save_bdd_path'];
                $this->Parameter->save($parameter);

            }
            $this->Flash->success(__('Parameters have been saved.'));
            $this->redirect(array('action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
        }
    }

    public function getMissionCostParameters($i = null, $paramMissionCost = null)
    {
        $this->layout = 'ajax';
        $this->set(compact('i', 'paramMissionCost'));
    }

    public function addMissionCostParameterDiv($i = null)
    {
        $this->layout = 'ajax';
        $carTypes = $this->CarType->getCarTypes();
        $this->set(compact('i', 'carTypes'));
    }

    public function resetMissionCostParameter($paramMissionCost = null)
    {
        $this->layout = 'ajax';
        $carTypes = $this->CarType->getCarTypes();
        $missionCostParameters = $this->MissionCostParameter->getMissionCostParameters($paramMissionCost);
        $this->set(compact('paramMissionCost', 'carTypes', 'missionCostParameters'));
    }
    public function getAttachmentTypes($attachmentDisplaySheetRide = null){
        $this->layout = 'ajax';
        if($attachmentDisplaySheetRide ==2){
            $this->loadModel('AttachmentType');
            $this->loadModel('ParameterAttachmentType');
            $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
            $parameterAttachmentTypes = $this->ParameterAttachmentType->getParameterAttachmentTypes();
        }else {
            $attachmentTypes = array();
            $parameterAttachmentTypes = array();
        }


        $this->set(compact('attachmentTypes','parameterAttachmentTypes'));
    }

    public function addParameterAttachmentTypes($parameterAttachmentTypes)
    {
        $this->loadModel('ParameterAttachmentType');

        $this->loadModel('AttachmentType');
        $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::mission, "all");
        foreach ($attachmentTypes as $attachmentType) {
            $this->ParameterAttachmentType->deleteAll(array('ParameterAttachmentType.attachment_type_id'=>$attachmentType['AttachmentType']['id']), false);
            if (($parameterAttachmentTypes[$attachmentType['AttachmentType']['id']] == 1)) {

                $this->ParameterAttachmentType->create();
                $attachment = array();
                $attachment['ParameterAttachmentType']['attachment_type_id'] = $attachmentType['AttachmentType']['id'];
                $attachment['ParameterAttachmentType']['user_id'] = $this->Session->read('Auth.User.id');
                $this->ParameterAttachmentType->save($attachment);
            }
        }

    }


}
