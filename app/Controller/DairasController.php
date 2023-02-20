<?php

App::uses('AppController', 'Controller');

/**
 * Daira Controller
 *
 * @property Daira $Daira
 * @property Wilaya $Wilaya
 * @property Destination $Destination
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class DairasController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');
    public $uses = array('Daira', 'Wilaya');
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::daira, $user_id, ActionsEnum::view, "Dairas", null, "Daira" ,null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                    $conditions=array('Daira.user_id '=>$user_id);
                break;
            case 3 :
                    $conditions=array('Daira.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        //Parametrer la pagination
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Daira.code' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );
        $this->Daira->recursive = 0;
        $this->set('dairas', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'], 
                    $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Daira.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('dairas', $this->Paginator->paginate('Daira', array('OR' => array(
                            "LOWER(Daira.code) LIKE" => "%$keyword%",
                            "LOWER(Daira.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Daira->recursive = 0;
            $this->set('dairas', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
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
        $this->setTimeActif();
        if (!$this->Daira->exists($id)) {
            throw new NotFoundException(__('Invalid daira'));
        }
        $options = array('conditions' => array('Daira.' . $this->Daira->primaryKey => $id));
        $this->set('daira', $this->Daira->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::daira, $user_id, ActionsEnum::add, "Dairas", null, "Daira" ,null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Daira->create();
            $this->request->data['Daira']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->Daira->save($this->request->data)) {
                $this->Flash->success(__('The daira has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The daira could not be saved. Please, try again.'));
            }
        }
        $wilayas= $this->Wilaya->getWilayaList();
        $this->set('wilayas',$wilayas);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::daira, $user_id, ActionsEnum::edit, "Dairas", $id, "Daira" ,null);
        if (!$this->Daira->exists($id)) {
            throw new NotFoundException(__('Invalid daira'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Daira cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Daira']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->Daira->save($this->request->data)) {
                $this->Flash->success(__('The daira has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The daira could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Daira.' . $this->Daira->primaryKey => $id));
            $this->request->data = $this->Daira->find('first', $options);
        }
        $wilayas= $this->Wilaya->getWilayaList();
        $this->set('wilayas',$wilayas);
    }


    public function import()
    {
        if (!empty($this->request->data['Daira']['file_csv']['tmp_name'])) {

            if (is_uploaded_file($this->request->data['Daira']['file_csv']['tmp_name'])) {
                $fichier = $this->request->data['Daira']['file_csv']['name'];
                $ext = substr(strtolower(strrchr($fichier, '.')), 1);
                if ($ext == 'csv') {
                    if ($fichier) {
                        $fp = fopen($this->request->data['Daira']['file_csv']['tmp_name'], "r");

                    } else {

                        echo('fichier introuvable');
                        exit();
                    }
                    $cpt = 0;
                    while (!feof($fp)) {

                        $ligne = fgets($fp, 4096);
                        if (count(explode(";", $ligne)) > 1) {

                            $liste = explode(";", $ligne);
                        } else {

                            $liste = explode(",", $ligne);
                        }
                        filter_input(INPUT_POST, 'file_csv');
                        $liste[0] = (isset($liste[0])) ? $liste[0] : Null;
                        $liste[1] = (isset($liste[1])) ? $liste[1] : Null;
                        $liste[2] = (isset($liste[2])) ? $liste[2] : Null;

                        $code = $liste[0];
                        $name = $liste[1];
                        $wilayaName = $liste[2];




                        if ($cpt > 0) {
                            $wilayaId = $this->getWilayaIdByName($wilayaName);
                            if($wilayaId>0){
                            $this->Daira->create();
                            if (!empty($code)) {
                                $this->request->data['Daira']['code'] = $code;
                            }
                            $this->request->data['Daira']['name'] = $name;
                            $this->request->data['Daira']['wilaya_id'] = $wilayaId;
                            $this->request->data['Daira']['user_id'] = $this->Session->read('Auth.User.id');
                            $this->Daira->save($this->request->data);
                            }

                        }
                        $cpt++;


                    }

                    fclose($fp);
                    echo json_encode(array("response" => "true"));
                    $this->Flash->success(__('The file has been successfully imported'));

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('The file must be in csv format'));
                    $this->redirect(array('action' => 'index'));
                }
            }
        }

    }

    public function getWilayaIdByName($wilayaNameImported)
    {

        $wilayaId = 0;
        $wilayaNameImported = trim($wilayaNameImported);
        $wilayaNameImported = strtolower($wilayaNameImported);
        $wilayas = $this->Wilaya->getWilayaList(null, 'all');
        foreach ($wilayas as $wilaya) {
            $wilayaName = strtolower($wilaya['Wilaya']['name']);
            if ($wilayaNameImported == $wilayaName) {
                $wilayaId = $wilaya['Wilaya']['id'];
                return $wilayaId;
            }
        }
        return $wilayaId;
    }
    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::daira, $user_id, ActionsEnum::delete, "Dairas", $id, "Daira" ,null);
        $this->Daira->id = $id;
        if (!$this->Daira->exists()) {
            throw new NotFoundException(__('Invalid daira'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Daira->delete()) {
                $this->Flash->success(__('The daira has been deleted.'));
        } else {
                $this->Flash->error(__('The daira could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteDairans() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::daira, $user_id, ActionsEnum::delete, "Dairas", $id, "Daira" ,null);

            $this->Daira->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if($this->Daira->delete()){
                echo json_encode(array("response" => "true"));
            }else{
                echo json_encode(array("response" => "false"));
            }

    }
    private function verifyDependences($id){
        $this->setTimeActif();
        $this->loadModel('Destination');
        $result = $this->Destination->getDestinationsByDaira($id, 'first');
        if (!empty($result)) {
            $this->Flash->error(__('The daira could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        } 
    }

    function addWilaya()
    {
        $this->settimeactif();
        $this->layout = 'popup';
        $this->set('saved', false); //false by default - controls closure of overlay in which this is opened
        if (!empty($this->request->data)) {
            $this->Wilaya->create();
            if ($this->Wilaya->save($this->request->data)) {
                $this->set('saved', true); //only set true if data saves OK
                $wilaya_id = $this->Wilaya->getLastInsertId();
                $this->set('wilaya_id', $wilaya_id);
            }
        }
    }

    function getWilayas()
    {
        $this->settimeactif();
        $this->layout = 'ajax';
        $wilayas = $this->Wilaya->getWilayaList(null, 'all');
        $this->set('selectbox', $wilayas);
        $this->set('selectedid', $this->params['pass']['0']);
    }

}
