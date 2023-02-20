<?php

App::uses('AppController', 'Controller');

/**
 * AcquisitionTypes Controller
 *
 * @property AcquisitionType $AcquisitionType
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class AlertsController extends AppController
{
    public function getAlerts(){
        $this->layout = 'ajax';
        $profileId = $this->Auth->user('profile_id');

        $roleId = $this->Auth->user('role_id');
        $permissionsAlertCommerciales = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_commerciales,  ActionsEnum::view, $profileId , $roleId);
        $permissionsAlertAdministratives = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_administratives_juridiques,  ActionsEnum::view, $profileId , $roleId);
        $permissionsAlertMaintenances = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_maintenances,  ActionsEnum::view, $profileId , $roleId);
        $permissionsAlertConsommations = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_consommations,  ActionsEnum::view, $profileId , $roleId);
        $permissionsAlertParcs = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_parcs,  ActionsEnum::view, $profileId , $roleId);
        $permissionsAlertStock = $this->AccessPermission->getPermissionWithParams(SectionsEnum::alertes_stock,  ActionsEnum::view, $profileId , $roleId);

        $assuranceAlerts = array();
        $controlAlerts= array();
        $vidangeAlerts= array();
        $kmAlerts= array();
        $vignetteAlerts= array();
        $dateAlerts= array();
        $vidangeHourAlerts= array();
        $kmContractAlerts= array();
        $dateContractAlerts= array();
        $driverLicenseAlerts= array();
        $consumptionAlerts= array();
        $couponAlerts= array();
        $amortissementAlerts= array();
        $productMinAlerts= array();
        $productMaxAlerts= array();
        $minCouponAlerts= array();
        $deadlineAlerts= array();
        if($permissionsAlertCommerciales){
            $deadlineAlerts = $this->Alert->getDeadlineAlerts(ParametersEnum::echeance);
        }
        $authenticatedUserId = $this->Auth->user('id');
        if (!$this->IsAdministrator){
            $userParcsIds = $this->getParcsUserIdsArray($authenticatedUserId);
        }else{
            $userParcsIds = array();
        }
        if($permissionsAlertAdministratives){
            /*$assuranceAlerts = $this->Alert->getAssuranceAlerts(ParametersEnum::assurance);
            $controlAlerts = $this->Alert->getControlAlerts(ParametersEnum::controle_technique);
            $vignetteAlerts = $this->Alert->getVignetteAlerts(ParametersEnum::vignette);*/
            $administrativeAlerts = $this->Alert->getAlertsWithCategories(array(8),$userParcsIds);

            $driverLicenseAlerts = $this->Alert->getDriverLicenseAlerts(ParametersEnum::expiration_permis, $userParcsIds);
        }
        if($permissionsAlertMaintenances){
            /*$vidangeAlerts = $this->Alert->getVidangeAlerts(ParametersEnum::vidange);
            $kmAlerts = $this->Alert->getKmAlerts(ParametersEnum::avec_km);
            $dateAlerts = $this->Alert->getDateAlerts(ParametersEnum::avec_date);
            $vidangeHourAlerts = $this->Alert->getVidangeHourAlerts(ParametersEnum::vidange_engins);*/
            $maintenanceAlerts = $this->Alert->getAlertsWithCategories(array(4,5,6,7),$userParcsIds);
        }
        if($permissionsAlertConsommations){
            $consumptionAlerts = $this->Alert->getNbKmConsumptionAlerts(ParametersEnum::limite_mensuelle_consommation);
            $couponAlerts = $this->Alert->getCouponConsumptionAlerts(ParametersEnum::coupon_consumption);
            $minCouponAlerts = $this->Alert->getMinCouponAlerts(ParametersEnum::nb_minimum_bons);
        }
        if($permissionsAlertParcs){
            $kmContractAlerts = $this->Alert->getKmContractAlerts(ParametersEnum::km_restant_contrat);
            $dateContractAlerts = $this->Alert->getDateContractAlerts(ParametersEnum::contrat_vehicule);
            $amortissementAlerts = $this->Alert->getAmortissementAlerts(ParametersEnum::amortissement);
        }

        if($permissionsAlertStock){
            $productMinAlerts = $this->Alert->getProductMinAlerts(ParametersEnum::product_min);
            $productMaxAlerts = $this->Alert->getProductMaxAlerts(ParametersEnum::product_max);
            $expirationDateAlerts = $this->Alert->getExpirationDateSerialNumberAlerts(ParametersEnum::expiration_date);

        }


        $this->set(compact('administrativeAlerts','maintenanceAlerts','kmContractAlerts','dateContractAlerts',
            'driverLicenseAlerts','consumptionAlerts','couponAlerts','amortissementAlerts',
            'productMinAlerts','productMaxAlerts','minCouponAlerts','deadlineAlerts','expirationDateAlerts'));
    }
}