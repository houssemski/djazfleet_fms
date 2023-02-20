<?php

class UserFixture extends CakeTestFixture
{

// Optionel
// Définir cette propriété pour charger les fixtures dans une source
// de données de test différente
    public $useDbConfig = 'utranx_test';
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'first_name' => array('type' => 'string', 'length' => 150, 'null' => false),
        'last_name' => array('type' => 'string', 'length' => 150, 'null' => false),
        'email' => array('type' => 'string', 'length' => 150, 'null' => true),
        'username' => array('type' => 'string', 'length' => 150, 'null' => false),
        'password' => array('type' => 'string', 'length' => 150, 'null' => false),
        'secret_password' => array('type' => 'string', 'length' => 150, 'null' => false),
        'picture' => array('type' => 'string', 'length' => 255, 'null' => true),
        'supplier_id' => array('type' => 'smallinteger', 'default' => 'NULL', 'null' => true),
        'role_id' => array('type' => 'smallinteger', 'default' => 'NULL', 'null' => true),
        'car_id' => array('type' => 'integer', 'default' => 'NULL', 'null' => true),
        'language_id' => array('type' => 'smallinteger', 'default' => 'NULL', 'null' => true),
        'limit' => array('type' => 'integer', 'default' => 'NULL', 'null' => true),
        'profile_id' => array('type' => 'tinyinteger', 'default' => 'NULL', 'null' => true),
        'receive_alert' => array('type' => 'tinyinteger', 'default' => '0', 'null' => true),
        'created' => 'datetime',
        'updated' => 'datetime',
        'time_actif' => 'datetime',
        'last_visit_date' => 'datetime'
    );
    public function init() {
        $this->$records = array(
            array(
                'id' => 4,
                'first_name' => 'admin',
                'last_name' => 'admin',
                'username' => 'admin',
                'picture' => NULL,
                'email' => 'admin@admin.com',
                'password' => 'a92e2954f6d23740928b7fe56b07bd0a1efe5463',
                'secret_password' => '',
                'supplier_id' => NULL,
                'role_id' => 3,
                'picture' => 'logo.png',
                'car_id' => 1,
                'language_id' => NULL,
                'limit' => 25,
                'receive_alert' => 1,
                'time_actif' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
                'last_visit_date' => date('Y-m-d H:i:s')
            ),
        );
        parent::init();
    }

}