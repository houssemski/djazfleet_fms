<?php

App::uses('AppModel', 'Model');

/**
 * OptionReservation Model
 *
 */
class UserParc extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'user_parc';

    public function addUserParcs($parcs, $userId)
    {
        foreach ($parcs as $parc) {
            $this->create();
            $data = array();
            $data['UserParc']['user_id'] = $userId;
            $data['UserParc']['parc_id'] = $parc;
            $this->save($data);
        }
    }

    public function getUserParcAssociationByParcIdAndUsersId($parcId, $userId)
    {
        return $this->find('all', array(
            'conditions' => array(
                'UserParc.user_id =' => $userId,
                'UserParc.parc_id =' => $parcId,
            )
        ));
    }
}
