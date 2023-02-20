<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @property Car $Car
 * @property UserParc $UserParc
 * @property Customer $Customer
 * @property Event $Event
 */
class User extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $name = "User";
    public $displayField = 'username';

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->alias]['password'])) {

            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }


        return true;
    }

    /**
     * Validation rules
     *
     * @var array
     */


    public $validate = array(
        'first_name' => array(
            'required' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'last_name' => array(
            'required' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'email' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
            'email' => array(
                'rule' => array('email'),
            ),
        ),
        'username' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => false,
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'profile_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
            ),
        ),


    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        /* 'Role' => array(
             'className' => 'Role',
             'foreignKey' => 'role_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),*/

        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => 'profile_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )

    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'user_id',
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
        'Car2' => array(
            'className' => 'Car',
            'foreignKey' => 'modified_id',
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
            'foreignKey' => 'user_id',
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
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'user_id',
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
        'Audit' => array(
            'className' => 'Audit',
            'foreignKey' => 'user_id',
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
        'Tire' => array(
            'className' => 'Tire',
            'foreignKey' => 'user_id',
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
        'UserParc' => array(
            'className' => 'UserParc',
            'foreignKey' => 'user_id',
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
        'TransportBillDetailRides' => array(
            'className' => 'TransportBillDetailRides',
            'foreignKey' => 'user_id',
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

    public function afterSave($created, $parcs = Array())
    {
        if (!empty($this->data['User']['parcs'])) {
            $this->UserParc->deleteAll(array('UserParc.user_id' => $this->id), false);
            if (!empty($this->data['User']['parcs'][0])) {
                foreach ($this->data['User']['parcs'] as $parc) {
                    $this->UserParc->create();
                    $this->UserParc->save(array(
                        'user_id' => $this->id,
                        'parc_id' => $parc
                    ));
                }
            }
        }
        return true;
    }

    /**
     * Get users
     *
     * @param string $typeSelect
     *
     * @return array $users
     */
    public function getUsers($typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'list';
        }

        $users = $this->find(
            $typeSelect,
            array(
                'conditions' => array('User.id !=' => array(0, 1)),
                'order' => array('User.first_name ASC, User.last_name ASC'),
                'recursive' => -1
            )
        );
        return $users;
    }

    /**
     * Get user by id
     *
     * @param int $userId
     *
     * @return array $user
     */
    public function getUserById($userId)
    {
        $user = $this->find(
            'first',
            array(
                'conditions' => array('User.id' => $userId),
                'order' => array('User.first_name ASC, User.last_name ASC'),
                'recursive' => -1
            )
        );
        return $user;
    }

    public function getUserByForeignKey($id, $modelField){
        $user = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('User.id'),
                'recursive'=>-1
            ));
        return $user;
    }

    /**
     * @return array|null
     */
    public function getUsersReceiverClientNotifications(){
        $users = $this->find(
            'all',
            array(
                'conditions' => array(
                    'OR' => array(
                        array('User.profile_id' => ProfilesEnum::agent_commercial,
                            'User.receive_notification'=>1),
                        /*array('User.profile_id' => ProfilesEnum::client,
                            'User.receive_notification'=>1),*/
                        array( 'User.role_id'=>3)
                    )
                ),
                'fields'=>array('User.id'),
                'order' => array('User.first_name ASC, User.last_name ASC'),
                'recursive' => -1
            )
        );
        return $users;
    }

    /**
     * @return array|null
     */
    public function getUsersReceiverNotifications($serviceIds=null, $userId=null){
        if($serviceIds!=null){
            $users = $this->find(
                'all',
                array(
                    'conditions' => array(
                        'OR' => array(
                            array('User.service_id' => $serviceIds,
                                'User.receive_notification'=>1),
                            /*array('User.profile_id' => ProfilesEnum::client,
                                'User.receive_notification'=>1),*/
                            array( 'User.role_id'=>3)
                        )
                    ),
                    'fields'=>array('User.id'),
                    'order' => array('User.first_name ASC, User.last_name ASC'),
                    'recursive' => -1
                )
            );
        }else {
            $users = $this->find(
                'all',
                array(
                    'conditions' => array(
                        'OR' => array(
                            array('User.id' => $userId,
                                'User.receive_notification'=>1),
                            /*array('User.profile_id' => ProfilesEnum::client,
                                'User.receive_notification'=>1),*/
                            array( 'User.role_id'=>3)
                        )
                    ),
                    'fields'=>array('User.id'),
                    'order' => array('User.first_name ASC, User.last_name ASC'),
                    'recursive' => -1
                )
            );
        }

        return $users;
    }
    public function getUsersReceiverNotificationsByProfileId($profileIds=null){

            $users = $this->find(
                'all',
                array(
                    'conditions' => array(
                        'OR' => array(
                            array('User.profile_id' => $profileIds,
                                'User.receive_notification'=>1),
                            /*array('User.profile_id' => ProfilesEnum::client,
                                'User.receive_notification'=>1),*/
                            array( 'User.role_id'=>3)
                        )
                    ),
                    'fields'=>array('User.id'),
                    'order' => array('User.first_name ASC, User.last_name ASC'),
                    'recursive' => -1
                )
            );


        return $users;
    }

    public function getPlannersReceiverCommercialNotifications(){
        $users = $this->find(
            'all',
            array(
                'conditions' => array(
                    'OR' => array(
                        array('User.profile_id' => ProfilesEnum::planificateur,
                            'User.receive_notification'=>1),
                        /*array('User.profile_id' => ProfilesEnum::client,
                            'User.receive_notification'=>1),*/
                        array( 'User.role_id'=>3)
                    )
                ),
                'fields'=>array('User.id'),
                'order' => array('User.first_name ASC, User.last_name ASC'),
                'recursive' => -1
            )
        );
        return $users;
    }
    public function getCommercialsReceiverPlannerNotifications(){
        $users = $this->find(
            'all',
            array(
                'conditions' => array(
                    'OR' => array(
                        array('User.profile_id' => ProfilesEnum::agent_commercial,
                            'User.receive_notification'=>1),
                        /*array('User.profile_id' => ProfilesEnum::client,
                            'User.receive_notification'=>1),*/
                        array( 'User.role_id'=>3)
                    )
                ),
                'fields'=>array('User.id'),
                'order' => array('User.first_name ASC, User.last_name ASC'),
                'recursive' => -1
            )
        );
        return $users;
    }


    public function getUsersReceiverCommercialNotifications($supplierId){
        $users = $this->find(
            'all',
            array(
                'conditions' => array(
                    'OR' => array(
                        array('User.supplier_id' => $supplierId,
                            'User.receive_notification'=>1),
                        array( 'User.role_id'=>3)
                    )
                ),
                'fields'=>array('User.id'),
                'order' => array('User.first_name ASC, User.last_name ASC'),
                'recursive' => -1
            )
        );
        return $users;
    }
}
