<?php
class RubricsController extends AppController {

    public $components = array('Paginator', 'Session');

    public $uses = array('Rubric');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');
        $result=1;
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch($result) {
            case 1 :
                $conditions=null;
                break;
            case 2 :
                $conditions=array('Rubric.user_id '=>$user_id);
                break;
            case 3 :
                $conditions=array('Rubric.user_id !='=>$user_id);
                break;

            default:
                $conditions=null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Rubric.name' => 'ASC'),
            'conditions'=>$conditions,
            'paramType' => 'querystring'
        );


        $this->Rubric->recursive = -1;
        $this->set('rubrics', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search() {
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Rubric.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('rubrics', $this->Paginator->paginate('Rubric', array("LOWER(Rubric.name) LIKE" => "%$keyword%")));
        } else {
            $this->Rubric->recursive = -1;
            $this->set('rubrics', $this->Paginator->paginate());
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
        if (!$this->Rubric->exists($id)) {
            throw new NotFoundException(__('Invalid').' '. __('rubric'));
        }
        $options = array('conditions' => array('Rubric.' . $this->Rubric->primaryKey => $id));
        $this->set('rubric', $this->Rubric->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');

        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Rubric->create();
            $this->request->data['Rubric']['user_id'] = $this->Session->read('Auth.User.id');
            $name = $this->request->data['Rubric']['id'];
            if ($this->Rubric->save($this->request->data)) {
                $dossier = 'attachments/' . $name;
                if (is_dir($dossier)) {

                } else {
                    mkdir($dossier);
                }
                $this->Flash->success(__('The rubric').' '. __('has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The rubric').' '. __('could not be saved. Please, try again.'));
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
        $this->setTimeActif();

        $user_id=$this->Auth->user('id');

        if (!$this->Rubric->exists($id)) {
            throw new NotFoundException(__('Invalid').' '. __('rubric'));
        }
        if ( $this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved.').' '. __('Rubric').' '. __(' cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Rubric']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $name = $this->request->data['Rubric']['id'] ;
            if ($id!= 1 && $id!= 2 &&$id!= 3 &&$id!= 4 &&$id!= 5 &&$id!= 6 &&$id!= 7 && $id!= 8 &&$id!= 9 &&$id!= 10 &&$id!= 11 && $this->Rubric->save($this->request->data)) {
                $dossier = 'attachments/' . $name;
                if (is_dir($dossier)) {

                } else {
                    mkdir($dossier);
                }

                $this->Flash->success(__('The rubric').' '. __('has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The rubric').' '. __('could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Rubric.' . $this->Rubric->primaryKey => $id));
            $this->request->data = $this->Rubric->find('first', $options);

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
        $this->setTimeActif();
        $user_id=$this->Auth->user('id');

        $this->Rubric->id = $id;
        if (!$this->Rubric->exists()) {
            throw new NotFoundException(__('Invalid').' '. __('rubric'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id!= 1 && $id!= 2 &&$id!= 3 &&$id!= 4 &&$id!= 5 &&$id!= 6 &&$id!= 7 && $id!= 8 &&$id!= 9 &&$id!= 10 &&$id!= 11 && $this->Rubric->delete()) {
            $this->Flash->success(__('The rubric').' '. __('has been deleted.'));
        } else {
            $this->Flash->success(__('The rubric').' '. __('could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }
    public function deleteRubrics() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');

        $this->Rubric->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($this->Rubric->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }







}