<?php
App::uses('AppController', 'Controller');
/**
 * Payments Controller
 *

* @property Compte $Compte
* @property Payment $Payment
 *
 *  */
class ComptesController extends AppController {

    public $components = array('Paginator', 'Session','Security');
    public $uses = array(
        'Compte',
        'Payment',

    );
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.index')==0){
                $this->Flash->error(__("You don't have permission to consult."));
                return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));

            }else {
                $this->Auth->allow();
                $comptes = $this->Cafyb->getAllComptes();

                $separatorAmount = $this->getSeparatorAmount();
                $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

                $this->set(compact( 'separatorAmount', 'comptes','limit'));


            }
        }else {
            $user_id=$this->Auth->user('id');
            $result = $this->verifyUserPermission(SectionsEnum::compte_tresorerie, $user_id, ActionsEnum::view, "Comptes", null, "Compte" ,null);
            $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

            switch($result) {
                case 1 :
                    $conditions=null;
                    break;
                case 2 :
                    $conditions=array('Compte.user_id '=>$user_id);
                    break;
                case 3 :
                    $conditions=array('Compte.user_id !='=>$user_id);
                    break;

                default:
                    $conditions=null;
            }
            $this->paginate = array(
                'limit' => $limit,
                'order' => array('Compte.num_compte' => 'ASC'),
                'conditions'=>$conditions,
                'paramType' => 'querystring'
            );


            $this->Compte->recursive = 0;
            $this->set('comptes', $this->Paginator->paginate());
            $separatorAmount = $this->getSeparatorAmount();
            $this->set(compact('limit','separatorAmount'));
        }

    }

    public function search() {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Compte.num_compte' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('comptes', $this->Paginator->paginate('Compte', array("LOWER(Compte.num_compte) LIKE" => "%$keyword%",
                )));
        } else {
            $this->Compte->recursive = 0;
            $this->set('comptes', $this->Paginator->paginate());
        }
        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('limit','separatorAmount'));
        $this->render();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            $compte = $this->Cafyb->getCompteById($id);
            $this->set(compact('compte'));
        }else {
            $this->setTimeActif();
            if (!$this->Compte->exists($id)) {
                throw new NotFoundException(__('Invalid compte'));
            }
            $options = array('conditions' => array('Compte.' . $this->Compte->primaryKey => $id));
            $this->set('compte', $this->Compte->find('first', $options));
        }

        $separatorAmount = $this->getSeparatorAmount();
        $this->set(compact('separatorAmount'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.add')==0){
                $this->Flash->error(__("You don't have permission to add."));
                return $this->redirect(array('controller' => 'comptes', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                if ($this->request->is('post')) {
                    $compte = $this->request->data['Compte'];
                    $this->Cafyb->addCompte($compte);

                }

            }
        }else {
            $this->setTimeActif();
            $user_id=$this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::compte_tresorerie, $user_id, ActionsEnum::add, "Comptes", null, "Compte" ,null);
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            if ($this->request->is('post')) {
                $this->Compte->create();
                $this->request->data['Compte']['user_id'] = $this->Session->read('Auth.User.id');
                $this->createDateFromDate('Compte', 'creation_date');
                if ($this->Compte->save($this->request->data)) {
                    $this->Flash->success(__('The compte has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The compte could not be saved. Please, try again.'));
                }
            }
        }

    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.edit')==0){
                $this->Flash->error(__("You don't have permission to edit."));
                return $this->redirect(array('controller' => 'comptes', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                if ($this->request->is(array('post', 'put'))) {
                    $compte = $this->request->data['Compte'];
                    $this->Cafyb->editCompte($compte);

                }else {
                    $compte = $this->Cafyb->getCompteById($id);
                    $this->set(compact('compte'));
                }

            }
        }else {
            $this->setTimeActif();
            $user_id=$this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::compte_tresorerie, $user_id, ActionsEnum::edit, "Comptes", $id, "Compte" ,null);
            if (!$this->Compte->exists($id)) {
                throw new NotFoundException(__('Invalid Group'));
            }
            if ($this->request->is(array('post', 'put'))) {
                if (isset($this->request->data['cancel'])) {
                    $this->Flash->error(__('Changes were not saved. Compte cancelled.'));
                    $this->redirect(array('action' => 'index'));
                }
                $this->request->data['Compte']['last_modifier_id'] = $this->Session->read('Auth.User.id');
                $this->request->data['Compte']['user_id'] = $this->Session->read('Auth.User.id');
                $this->createDateFromDate('Compte', 'creation_date');
                if ($this->Compte->save($this->request->data)) {
                    $this->Flash->success(__('The compte has been saved.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The compte could not be saved. Please, try again.'));
                }
            } else {
                $options = array('conditions' => array('Compte.' . $this->Compte->primaryKey => $id));
                $this->request->data = $this->Compte->find('first', $options);
            }
        }



    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }

        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.delete')==0){
                $this->Flash->error(__("You don't have permission to delete."));
                return $this->redirect(array('controller' => 'comptes', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                $this->Cafyb->deleteCompte($id);


            }
        }else {

            $this->setTimeActif();
            $user_id=$this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::compte_tresorerie, $user_id, ActionsEnum::delete, "Comptes", $id, "Compte" ,null);
            $this->Compte->id = $id;
            if (!$this->Compte->exists()) {
                throw new NotFoundException(__('Invalid compte'));
            }
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if ($this->Compte->delete()) {
                $this->Flash->success(__('The compte has been deleted.'));
            } else {
                $this->Flash->error(__('The compte could not be deleted. Please, try again.'));
            }
        }

        $this->redirect(array('action' => 'index'));
    }
    public function deleteComptes() {
        $tresorerie = $this->hasModuleTresorerie();
        if($tresorerie==0){
            return $this->redirect('/');
        }
        if (Configure::read("cafyb") == '1') {
            if($this->Session->read('Permission.compte.delete')==0){
                $this->Flash->error(__("You don't have permission to delete."));
                return $this->redirect(array('controller' => 'comptes', 'action' => 'index'));

            }else {
                $this->Auth->allow();
                $id = filter_input(INPUT_POST, "id");
                $this->Cafyb->deleteCompte($id);


            }
        }else {
            $this->setTimeActif();
            $this->autoRender = false;
            $id = filter_input(INPUT_POST, "id");
            $user_id=$this->Auth->user('id');
            $this->verifyUserPermission(SectionsEnum::compte_tresorerie, $user_id, ActionsEnum::delete, "Comptes", $id, "Compte" ,null);

            $this->Compte->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Compte->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }
        }



    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Payment');
        $result = $this->Payment->find('first', array("conditions" => array("compte_id =" => $id)));

        if (!empty($result)) {
            $this->Flash->success(__('The compte could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

    }

    /**
     * @param null $id
     */
    public function recalculateBalance($id = null){

        $totalCashing =0;
        $totalDisbursement =0;
        $cashingPayments = $this->Payment->getPaymentsByConditions(array('Payment.compte_id'=>$id, 'Payment.transact_type_id'=>1));
        if(!empty($cashingPayments)){
            foreach ($cashingPayments as $cashingPayment){
                $totalCashing = $totalCashing +$cashingPayment['Payment']['amount'];
            }
        }

        $disbursementPayments = $this->Payment->getPaymentsByConditions(array('Payment.compte_id'=>$id, 'Payment.transact_type_id'=>2));
        if(!empty($disbursementPayments)){
            foreach ($disbursementPayments as $disbursementPayment){
                $totalDisbursement = $totalDisbursement +$disbursementPayment['Payment']['amount'];
            }
        }

        $balance = $totalCashing - $totalDisbursement;
        $this->Compte->id = $id;
        if($this->Compte->saveField('amount',$balance)){
            $this->Flash->success(__('Balance has been recalculed.'));
        }else {
            $this->Flash->error(__('Balance could not be recalculed. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));

    }

}