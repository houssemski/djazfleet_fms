<?php
App::uses('AppModel', 'Model');
/**
 * Mark Model
 *
 * @property Car $Car
 */
class AccessPermission extends AppModel {

    public $belongsTo = array(


        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => 'profile_id'
        ),
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'section_id'
        ),
        'Action' => array(
            'className' => 'Action',
            'foreignKey' => 'action_id'
        ),

    );


    /**
     * avoir les droit d'accès pour la transformation d'une demande devis à un devis
     * @param null $sectionId
     * @param null $actionId
     * @param $profileId
     * @return int
     */

    public function getPermissionTransformQuoteRequestToQuote($sectionId= null, $actionId = null, $profileId= null, $roleId = null)
    {

        if ($roleId != 3) {
            $userRights = $this->find('first',
                array(
                    'recursive'=>-1,
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'section_id' => $sectionId,
                            'action_id' => $actionId
                        )
                )
            );

            if(!empty($userRights)){
                return 1;
            }else {
                return 0;
            }
        }else return 1;
    }

    /**
     * avoir les droit daccès pour la transmission d'une commande client
     */
    public function getPermissionTransmitCustomerOrder($sectionId= null, $actionId = null, $profileId = null , $roleId = null){
        if ($roleId != 3) {
            $userRights = $this->find('first',
                array(
                    'recursive'=>-1,
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'section_id' => $sectionId,
                            'action_id' => $actionId
                        )
                )
            );
            if(!empty($userRights)){
                return 1;
            }else {
                return 0;
            }
        }else return 1;
    }
    /**
     * connaitre les droit dacces pour la transformation d'un devis à une commande
     * @param null $sectionId
     * @param null $actionId
     * @param $profileId
     * @return int
     */
    public function getPermissionTransformQuoteToOrder($sectionId= null, $actionId = null, $profileId = null, $roleId = null)
    {

        if ($roleId != 3) {
            $userRights = $this->find('first',
                array(
                    'recursive'=>-1,
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'section_id' => $sectionId,
                            'action_id' => $actionId
                        )
                )
            );

            if(!empty($userRights)){
                return 1;
            }else {
                return 0;
            }
        }else return 1;
    }

    /**
     * savoir les droit dacces pout la transformation d'une prefacture à une facture
     * @param null $sectionId
     * @param null $actionId
     * @param $profileId
     * @return int
     */
    public function getPermissionTransformPreinvoiceToInvoice($sectionId= null, $actionId = null, $profileId = null, $roleId= null)
    {

        if ($roleId != 3) {
            $userRights = $this->find('first',
                array(
                    'recursive'=>-1,
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'section_id' => $sectionId,
                            'action_id' => $actionId
                        )
                )
            );

            if(!empty($userRights)){
                return 1;
            }else {
                return 0;
            }
        }else return 1;
    }

    /**
     * @param null $sectionId
     * @param null $actionId
     * @param null $profileId
     * @param null $roleId
     * @return int
     * return permission en prendre en compte les param section , action,  profil et role.
     */

    public function getPermissionWithParams($sectionId= null, $actionId = null, $profileId = null , $roleId = null){
        if ($roleId != 3) {
            $userRights = $this->find('first',
                array(
                    'recursive'=>-1,
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'section_id' => $sectionId,
                            'action_id' => $actionId
                        )
                )
            );
            if(!empty($userRights)){
                return 1;
            }else {
                return 0;
            }
        }else return 1;
    }

    public function getPermissionBySubModule($subModuleId= null, $profileId = null){

            $userRights = $this->find('all',
                array(
                    'recursive'=>-1,
                    'fields'=>array('Section.id'),
                    'conditions' =>
                        array(
                            'profile_id' => $profileId,
                            'sub_module_id' => $subModuleId,
                        ),
                    'joins' => array(
                        array(
                            'table' => 'sections',
                            'type' => 'left',
                            'alias' => 'Section',
                            'conditions' => array('AccessPermission.section_id = Section.id')
                        )
                        )
                    ,
                )
            );
            return $userRights;


    }




}