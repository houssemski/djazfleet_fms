<?php

App::uses('AppController', 'Controller');

/**
 * FuelLogs Controller
 *
 * @property FuelLog $FuelLog
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FuelLogsController extends AppController
{

    public $components = array('Paginator', 'Session', 'Security');
    var $helpers = array('Xls');


    public function index()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carnet_carburant, $user_id, ActionsEnum::view, "FuelLogs", null,
            "FuelLog",null);

        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $fuellogs = $this->FuelLog->getFuelLogs();


        $this->set('fuellogs', $fuellogs);
        $hasTreasuryModule = $this->hasModuleTresorerie();
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('limit','hasTreasuryModule','separatorAmount'));

    }

    public function search()
    {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('FuelLog.serial_number' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('fuels', $this->Paginator->paginate('FuelLog', array(
                "LOWER(FuelLog.serial_number) LIKE" => "%$keyword%")));
        } else {
            $this->FuelLog->recursive = 0;
            $this->set('fuellogs', $this->Paginator->paginate());
        }
        $hasTreasuryModule = $this->hasModuleTresorerie();
        $this->set(compact('limit','hasTreasuryModule'));
        $this->render();
    }

    public function View($id = null)
    {
        $this->setTimeActif();
        if (!$this->FuelLog->exists($id)) {
            throw new NotFoundException(__('Invalid fuel log '));
        }
        $options = array('conditions' => array('FuelLog.' . $this->FuelLog->primaryKey => $id));
        $this->set('fuellog', $this->FuelLog->find('first', $options));
    }

    public function add()
    {
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carnet_carburant, $user_id, ActionsEnum::add, "FuelLogs", null,
            "FuelLog",null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->FuelLog->create();
            $this->request->data['FuelLog']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['FuelLog']['price_remaining'] = $this->request->data['FuelLog']['price'];
            $this->createDatetimeFromDate('FuelLog', 'date');

            if ($this->request->data['FuelLog']['last_number_coupon'] < $this->request->data['FuelLog']['first_number_coupon']) {

                $this->Flash->error(__('The fuel log could not be saved. Number of coupons are not sequential.'));
            } else {

                if (empty($this->request->data['FuelLog']['price_coupon'])) {


                    $parameter = $this->Parameter->find('first', array('recursive' => -1,
                        'conditions' => array('code' => 10)));

                    $this->request->data['FuelLog']['price_coupon'] = $parameter['Parameter']['val'];

                }

                if ($this->FuelLog->save($this->request->data)) {
                    $this->Flash->success(__('The fuel log has been saved.'));
                    $nb_coupons = ($this->request->data['FuelLog']['last_number_coupon'] - $this->request->data['FuelLog']['first_number_coupon']) + 1;
                    $fuellog_id = $this->FuelLog->getInsertID();
                    $this->FuelLog->Id = $fuellog_id;

                    for ($i = 0; $i < $nb_coupons; $i++) {
                        $this->loadModel('Coupon');
                        $this->Coupon->create();
                        $data = array();


                        $size = strlen($this->request->data['FuelLog']['first_number_coupon']);

                        $num_coupon = $this->request->data['FuelLog']['first_number_coupon'] + $i;
                        if (!empty($this->request->data['FuelLog']['price_coupon'])) {

                            $price_coupon = $this->request->data['FuelLog']['price_coupon'];
                        } else {
                            $parameter = $this->Parameter->find('first', array('recursive' => -1,
                                'conditions' => array('code' => 10)));

                            $price_coupon = $parameter['Parameter']['val'];

                        }

                        $size_coupon = strlen((string)$num_coupon);

                        if ($size > $size_coupon) {
                            $size = $size - $size_coupon;
                            for ($j = 1; $j <= $size; $j++) {
                                $num_coupon = '0' . $num_coupon;
                            }
                        }


                        $data['Coupon']['serial_number'] = $num_coupon;

                        $data['Coupon']['user_id'] = $this->Session->read('Auth.User.id');
                        $data['Coupon']['price_coupon'] = $price_coupon;
                        $data['Coupon']['fuel_log_id'] = $fuellog_id;
                        $this->Coupon->save($data);

                    }


                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                }

            }
        }

    }

    public function edit($id = null)
    {
        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carnet_carburant, $user_id, ActionsEnum::edit, "FuelLogs", $id,
            "FuelLog",null);
        if (!$this->FuelLog->exists($id)) {
            throw new NotFoundException(__('Invalid fuel log'));
        }
        $fuellog = $this->FuelLog->find('first', array('conditions' => array('FuelLog.' . $this->FuelLog->primaryKey => $id)));
        $first_number_coupon = $fuellog['FuelLog']['first_number_coupon'];
        $last_number_coupon = $fuellog['FuelLog']['last_number_coupon'];

        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Fuel log cancelled.'));
                $this->redirect(array('action' => 'index'));
            }

            $this->request->data['FuelLog']['modified_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['FuelLog']['is_open'] = 0;
            $this->createDatetimeFromDate('FuelLog', 'date');
            if (empty($this->request->data['FuelLog']['price_coupon'])) {


                $parameter = $this->Parameter->find('first', array('recursive' => -1,
                    'conditions' => array('code' => 10)));

                $this->request->data['FuelLog']['price_coupon'] = $parameter['Parameter']['val'];

            }

            if (($first_number_coupon == $this->request->data['FuelLog']['first_number_coupon']) && ($last_number_coupon == $this->request->data['FuelLog']['last_number_coupon'])) {

                if ($this->FuelLog->save($this->request->data)) {
                    $this->Flash->success(__('The fuel log has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                }
            } else {


                if (($first_number_coupon != $this->request->data['FuelLog']['first_number_coupon']) && ($last_number_coupon != $this->request->data['FuelLog']['last_number_coupon'])) {

                    $this->loadModel('Coupon');
                    $coupons_first = $this->Coupon->find('first', array('conditions' => array('fuel_log_id' => $id, 'used' => 1), 'order' => 'serial_number ASC'));

                    $coupons_last = $this->Coupon->find('first', array('conditions' => array('fuel_log_id' => $id, 'used' => 1), 'order' => 'serial_number DESC'));

                    if (empty($coupons_first) && empty($coupons_last)) {

                        if ($this->FuelLog->save($this->request->data)) {

                            $this->updateCoupons($this->request->data['FuelLog']['first_number_coupon'], $first_number_coupon, $id, 0);
                            $this->updateCoupons($last_number_coupon, $this->request->data['FuelLog']['last_number_coupon'], $id, 1);
                            $this->Flash->success(__('The fuel log has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                        }


                    } elseif (!empty($coupons_first) && empty($coupons_last)) {

                        $coupon_first_id = $coupons_first['Coupon']['id'];
                        $serial_number_first = $coupons_first['Coupon']['serial_number'];
                        if (($this->request->data['FuelLog']['first_number_coupon'] < $serial_number_first)) {


                            if ($this->FuelLog->save($this->request->data)) {

                                $this->updateCoupons($this->request->data['FuelLog']['first_number_coupon'], $first_number_coupon, $id, 0);
                                $this->updateCoupons($last_number_coupon, $this->request->data['FuelLog']['last_number_coupon'], $id, 1);
                                $this->Flash->success(__('The fuel log has been saved.'));
                                $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                            }

                        } else {

                            $this->Flash->error(__('The fuel log could not be saved. Coupons of this fuel log are already used.'));


                        }

                    } elseif (empty($coupons_first) && !empty($coupons_last)) {

                        $serial_number_last = $coupons_last['Coupon']['serial_number'];
                        if (($this->request->data['FuelLog']['last_number_coupon'] > $serial_number_last)) {


                            if ($this->FuelLog->save($this->request->data)) {


                                $this->updateCoupons($last_number_coupon, $this->request->data['FuelLog']['last_number_coupon'], $id, 1);
                                $this->updateCoupons($this->request->data['FuelLog']['first_number_coupon'], $first_number_coupon, $id, 0);
                                $this->Flash->success(__('The fuel log has been saved.'));
                                $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                            }

                        } else {

                            $this->Flash->error(__('The fuel log could not be saved. Coupons of this fuel log are already used.'));


                        }

                    } else {


                        $coupon_first_id = $coupons_first['Coupon']['id'];
                        $serial_number_first = $coupons_first['Coupon']['serial_number'];
                        $coupon_last_id = $coupons_last['Coupon']['id'];
                        $serial_number_last = $coupons_last['Coupon']['serial_number'];

                        if (($this->request->data['FuelLog']['first_number_coupon'] < $serial_number_first) && ($this->request->data['FuelLog']['last_number_coupon'] > $serial_number_last)) {


                            if ($this->FuelLog->save($this->request->data)) {

                                $this->updateCoupons($this->request->data['FuelLog']['first_number_coupon'], $first_number_coupon, $id, 0);
                                $this->updateCoupons($last_number_coupon, $this->request->data['FuelLog']['last_number_coupon'], $id, 1);
                                $this->Flash->success(__('The fuel log has been saved.'));
                                $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                            }

                        } else {
                            $this->Flash->error(__('The fuel log could not be saved. Coupons of this fuel log are already used.'));


                        }


                    }

                } else {

                    if ($first_number_coupon != $this->request->data['FuelLog']['first_number_coupon']) {
                        $this->loadModel('Coupon');
                        $coupons = $this->Coupon->find('first', array('conditions' => array('fuel_log_id' => $id, 'used' => 1), 'order' => 'serial_number ASC'));
                        if (!empty($coupons)) {
                            $coupon_id = $coupons['Coupon']['id'];
                            $serial_number = $coupons['Coupon']['serial_number'];
                            if (($this->request->data['FuelLog']['first_number_coupon'] < $serial_number)) {


                                if ($this->FuelLog->save($this->request->data)) {

                                    $this->updateCoupons($this->request->data['FuelLog']['first_number_coupon'], $first_number_coupon, $id, 0);
                                    $this->Flash->success(__('The fuel log has been saved.'));
                                    $this->redirect(array('action' => 'index'));
                                } else {
                                    $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                                }

                            } else {
                                $this->Flash->error(__('The fuel log could not be saved. Coupons of this fuel log are already used.'));

                            }
                        } else {

                            if ($this->FuelLog->save($this->request->data)) {

                                $this->updateCoupons($this->request->data['FuelLog']['first_number_coupon'], $first_number_coupon, $id, 0);
                                $this->Flash->success(__('The fuel log has been saved.'));
                                $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                            }
                        }

                    }


                    if ($last_number_coupon != $this->request->data['FuelLog']['last_number_coupon']) {
                        $this->loadModel('Coupon');
                        $coupons = $this->Coupon->find('first', array('conditions' => array('fuel_log_id' => $id, 'used' => 1), 'order' => 'serial_number DESC'));
                        if (!empty($coupons)) {
                            $coupon_id = $coupons['Coupon']['id'];
                            $serial_number = $coupons['Coupon']['serial_number'];
                            if (($this->request->data['FuelLog']['last_number_coupon'] > $serial_number)) {


                                if ($this->FuelLog->save($this->request->data)) {


                                    $this->updateCoupons($last_number_coupon,
                                        $this->request->data['FuelLog']['last_number_coupon'], $id, 1);
                                    $this->Flash->success(__('The fuel log has been saved.'));
                                    $this->redirect(array('action' => 'index'));
                                } else {
                                    $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                                }

                            } else {
                                $this->Flash->success(__('The fuel log could not be saved. Coupons of this fuel log are already used.'));


                            }
                        } else {

                            if ($this->FuelLog->save($this->request->data)) {

                                $this->updateCoupons($last_number_coupon,
                                    $this->request->data['FuelLog']['last_number_coupon'], $id, 1);
                                $this->Flash->success(__('The fuel log has been saved.'));
                                $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Flash->error(__('The fuel log could not be saved. Please, try again.'));
                            }
                        }

                    }


                }


            }


        } else {
            $options = array('conditions' => array('FuelLog.' . $this->FuelLog->primaryKey => $id));
            $this->request->data = $this->FuelLog->find('first', $options);
        }
        $this->isOpenedByOtherUser("FuelLog", 'FuelLogs', 'fuel log', $id);

    }


    public function updateCoupons($serial_number1 = null, $serial_number2 = null, $fuellog_id = null, $first_last = null)
    {


        if ($serial_number1 < $serial_number2) {

            $nb_coupons = $serial_number2 - $serial_number1;


            for ($i = 0; $i < $nb_coupons; $i++) {
                $this->loadModel('Coupon');
                $this->Coupon->create();
                $data = array();
                $size = strlen($serial_number1);
                if ($first_last == 1) $num_coupon = $serial_number1 + $i + 1;
                else $num_coupon = $serial_number1 + $i;
                $size_coupon = strlen((string)$num_coupon);
                if ($size > $size_coupon) {
                    $size = $size - $size_coupon;
                    for ($j = 1; $j <= $size; $j++) {
                        $num_coupon = '0' . $num_coupon;
                    }
                }
                $data['Coupon']['serial_number'] = $num_coupon;

                $data['Coupon']['user_id'] = $this->Session->read('Auth.User.id');
                $data['Coupon']['fuel_log_id'] = $fuellog_id;

                $this->Coupon->save($data);

            }

        }


        if ($serial_number1 > $serial_number2) {
            $nb_coupons = $serial_number1 - $serial_number2;
            if ($first_last == 1) $nb_coupons++;

            for ($i = 0; $i < $nb_coupons; $i++) {
                $this->loadModel('Coupon');

                $size = strlen($serial_number2);
                if ($first_last == 1) $num_coupon = $serial_number2 + $i + 1;
                else $num_coupon = $serial_number2 + $i;
                $size_coupon = strlen((string)$num_coupon);
                if ($size > $size_coupon) {
                    $size = $size - $size_coupon;
                    for ($j = 1; $j <= $size; $j++) {
                        $num_coupon = '0' . $num_coupon;
                    }
                }

                $coupons = $this->Coupon->find('first', array('conditions' => array('serial_number' => $num_coupon)));
                $coupon_id = $coupons['Coupon']['id'];

                $this->Coupon->delete($coupon_id);


            }

        }


    }

    public function delete($id = null)
    {

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carnet_carburant, $user_id, ActionsEnum::delete, "FuelLogs", $id,
            "FuelLog" ,null);
        $this->FuelLog->id = $id;
        if (!$this->FuelLog->exists()) {
            throw new NotFoundException(__('Invalid fuel log'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->FuelLog->delete()) {
            $this->Flash->success(__('The fuel log has been deleted.'));
        } else {
            $this->Flash->error(__('The fuel log could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deletefuellogs()
    {
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");

        $this->FuelLog->id = $id;
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::carnet_carburant, $user_id, ActionsEnum::delete, "FuelLogs", $id,
            "FuelLog" ,null);
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->FuelLog->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }

    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $this->loadModel('Coupon');
        $result = $this->Coupon->find('all', array("conditions" => array("Coupon.fuel_log_id =" => $id, 'Coupon.used' => 1)));
        if (!empty($result)) {
            $this->Flash->error(__('The fuel log could not be deleted. Coupons of this fuel log are already used.'));
            $this->redirect(array('action' => 'index'));
        } else {
            $coupons = $this->Coupon->find('all', array('conditions' => array('fuel_log_id' => $id, 'used' => 0)));
            if (!empty($coupons)) {

                $this->Coupon->deleteAll(array('Coupon.fuel_log_id' => $id), false);

            }

        }
    }

    function export()
    {
        $this->setTimeActif();
        $fuels = $this->FuelLog->find('all', array(
            'order' => 'FuelLog.serial_number asc',
            'recursive' => -1
        ));
        $this->set('models', $fuels);
    }


}