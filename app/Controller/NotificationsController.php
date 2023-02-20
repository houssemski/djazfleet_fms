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
class NotificationsController extends AppController
{

    public function index() {
        $roleId = $this->Auth->user('role_id');
        $sectionIds = array();
        $supplierId = Null;
        if($roleId!=3){
            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }

            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');
            }
            $userRights = $this->AccessPermission->getPermissionBySubModule(45,$profileId);
            if(!empty($userRights)){
                foreach ($userRights as $userRight){
                    $sectionIds[]= $userRight['Section']['id'];
                }
            }

        }else {
            $sectionIds = $this->Section->getSectionsBySubModule(45);
        }

        $notifications = $this->Notification->getNotificationsByUser($sectionIds,$supplierId);
        $this->set(compact('notifications'));
    }

    public function getNotificationsByUser(){
        $this->layout = 'ajax';
        $roleId = $this->Auth->user('role_id');
        $sectionIds = array();
        $supplierId = Null;
        if($roleId!=3){
            $profileId = $this->Auth->user('profile_id');
            $parentId = $this->Profile->getParentProfileByProfileId($profileId);
            if ($parentId != Null) {
                $profileId = $parentId;
            }

            if ($profileId == ProfilesEnum::client) {
                $supplierId = $this->Auth->user('supplier_id');
            }
            $userRights = $this->AccessPermission->getPermissionBySubModule(45,$profileId);
            if(!empty($userRights)){
                foreach ($userRights as $userRight){
                    $sectionIds[]= $userRight['Section']['id'];
                }
            }

        }else {
            $sectionIds = $this->Section->getSectionsBySubModule(45);
        }

        $notifications = $this->Notification->getNotificationsByUser($sectionIds,$supplierId);
        $this->set(compact('notifications'));
    }
    public function getComplaintNotificationsByUser(){
        $this->layout = 'ajax';
        $roleId = $this->Auth->user('role_id');
        $sectionIds = array();
        if($roleId!=3){
            $profileId = $this->Auth->user('profile_id');
            $userRights = $this->AccessPermission->getPermissionBySubModule(45,$profileId);
            if(!empty($userRights)){
                foreach ($userRights as $userRight){
                    $sectionIds[]= $userRight['Section']['id'];
                }
            }

        }else {
            $sectionIds = $this->Section->getSectionsBySubModule(45);
        }

        $notifications = $this->Notification->getComplaintNotificationsByUser($sectionIds);
        $this->set(compact('notifications'));
    }

    public function getNbNotificationsByUser(){
        $this->layout = 'ajax';
        $roleId = $this->Auth->user('role_id');
        $sectionIds = array();
        if($roleId!=3){
            $profileId = $this->Auth->user('profile_id');
            $userRights = $this->AccessPermission->getPermissionBySubModule(45,$profileId);
            if(!empty($userRights)){
                foreach ($userRights as $userRight){
                    $sectionIds[]= $userRight['Section']['id'];
                }
            }

        }else {
            $sectionIds = $this->Section->getSectionsBySubModule(45);
        }

        $nbNotifications = $this->Notification->getNbNotificationsByUser($sectionIds);
        $this->Session->write("nbNotifications", $nbNotifications[0][0]['nbNotifications']);
        $this->set('nbNotifications', $nbNotifications[0][0]['nbNotifications']) ;
    }
    public function getNbComplaintNotificationsByUser(){
        $this->layout = 'ajax';
        $roleId = $this->Auth->user('role_id');
        $sectionIds = array();
        if($roleId!=3){
            $profileId = $this->Auth->user('profile_id');
            $userRights = $this->AccessPermission->getPermissionBySubModule(45,$profileId);
            if(!empty($userRights)){
                foreach ($userRights as $userRight){
                    $sectionIds[]= $userRight['Section']['id'];
                }
            }

        }else {
            $sectionIds = $this->Section->getSectionsBySubModule(45);
        }

        $nbNotifications = $this->Notification->getNbComplaintNotificationsByUser($sectionIds);
        $this->Session->write("nbComplaintNotifications", $nbNotifications[0][0]['nbNotifications']);
        $this->set('nbComplaintNotifications', $nbNotifications[0][0]['nbNotifications']) ;
    }

    public function disableNotifications($id,$type){
        $notifications = $this->Notification->find('all',array(
            'recursive'=>-1,
            'conditions'=>array('Notification.'.$type.'_id'=>$id)
        ));
        if(!empty($notifications)){
            foreach ($notifications as $notification){
                $this->Notification->id = $notification['Notification']['id'];
                $this->Notification->saveField('read_notif', 1);
            }
        }
        $this->getNbNotificationsByUser();
        $this->redirect(array('controller'=>$type.'s','action' => 'view',$id));



    }
}