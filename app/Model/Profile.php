<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 24/11/2015
 * Time: 14:39
 */
App::uses('AppModel', 'Model');
class Profile extends AppModel {
    public $displayField = 'name';

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
    );
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'profile_id',
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
     * Get user profiles
     *
     * @param string $typeSelect
     *
     * @return array $userProfiles
     */
    public function getUserProfiles($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $userProfiles = $this->find(
            $typeSelect,
            array(
                'order' => array('Profile.name ASC'),
                'recursive' => -1
            )
        );
        return $userProfiles;
    }

    public function getParentProfileByProfileId($profileId = null){
        $parent = NULL;
        $profile = $this->find('first',
            array(
            'conditions'=>array('Profile.id'=>$profileId),
            'fields'=>array('Profile.parent_id'),
            'recursive'=>-1
        ));
        if(!empty($profile)){
            $parent = $profile['Profile']['parent_id'];
        }

        return $parent;
    }

}