<?php

App::uses('AppController', 'Controller');

/**
 * EventTypes Controller
 *
 * @property EventType $EventType
 * @property EventEventType $EventEventType
 * @property InterferingType $InterferingType
 * @property InterferingTypeEventType $InterferingTypeEventType
 * @property EventTypeCategory $EventTypeCategory
 * @property EventTypeCategoryEventType $EventTypeCategoryEventType
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class EventTypesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array(
        'EventType',
        'EventEventType',
        'InterferingTypeEventType',
        'EventTypeCategoryEventType',
        'EventTypeCategory',
        'InterferingType'
    );
    var $helpers = array('Xls');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::type_evenement, $user_id, ActionsEnum::view, "EventTypes",
            null, "EventType", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        //Parametrer la pagination

        switch ($result) {
            case 1 :

                $conditions = array('EventType.id > ' => 0);
                break;
            case 2 :
                $conditions = array('EventType.id > ' => 0, 'EventType.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('EventType.id > ' => 0, 'EventType.user_id !=' => $user_id);
                break;

            default:
                $conditions = array('EventType.id > ' => 0);;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('EventType.code' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring'
        );


        /*$this->paginate = array(
            'limit' => $limit,
            'order' => array('EventType.code' => 'ASC'),
            'paramType' => 'querystring'
        );*/
        $this->EventType->recursive = 0;
        $this->set('eventTypes', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    /**
     * index method
     *
     * @return void
     */
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
            'order' => array('EventType.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('eventTypes', $this->Paginator->paginate('EventType', array(
                'OR' => array(
                    "LOWER(EventType.code) LIKE" => "%$keyword%",
                    "LOWER(EventType.name) LIKE" => "%$keyword%"
                )
            )));
        } else {
            $this->EventType->recursive = 0;
            $this->set('eventTypes', $this->Paginator->paginate());
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
    public function view($id = null)
    {
        $this->setTimeActif();
        if (!$this->EventType->exists($id)) {
            throw new NotFoundException(__('Invalid event type'));
        }
        $options = array('conditions' => array('EventType.' . $this->EventType->primaryKey => $id));
        $eventType = $this->EventType->find('first', $options);

        $this->set('eventType', $eventType);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {


        $this->setTimeActif();

        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_evenement, $user_id, ActionsEnum::add, "EventTypes", null,
            "EventType", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if (isset($this->request->data['EventType']['date'])) {

        }

        if ($this->request->is('post')) {

            $this->EventType->create();
            $this->request->data['EventType']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->EventType->save($this->request->data)) {
                $this->Flash->success(__('The event type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The event type could not be saved. Please, try again.'));
            }
        }
        $eventTypeCategories = $this->EventTypeCategory->getEventTypeCategories();
        $interferingTypes = $this->InterferingType->getInterferingTypes();
        $this->set(compact('eventTypeCategories', 'interferingTypes'));

    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_evenement, $user_id, ActionsEnum::edit, "EventTypes", $id,
            "EventType", null);
        if (!$this->EventType->exists($id)) {
            throw new NotFoundException(__('Invalid event type'));
        }
        if ($this->request->is(array('post', 'put'))) {


            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }


            $this->request->data['EventType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($id != 1 && $id != 2 && $id != 3 && $id != 5 && $id != 11 && $id != 12 && $this->EventType->save($this->request->data)) {
                $this->Flash->success(__('The event type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {

                if ($id == 1 || $id == 2 || $id == 3 || $id == 5 || $id == 11 || $id == 12) {


                    if ($id == 1) {
                        if ($this->request->data['EventType']['name'] == 'Vidange') {

                            $this->EventType->save($this->request->data);
                            $this->Flash->success(__('The event type has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } elseif ($id == 2) {

                        if ($this->request->data['EventType']['name'] == 'Assurance') {
                            $this->EventType->save($this->request->data);
                            $this->Flash->success(__('The event type has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } elseif ($id == 3) {
                        if ($this->request->data['EventType']['name'] == 'Controle Technique') {
                            $this->EventType->save($this->request->data);
                            $this->Flash->success(__('The event type has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } elseif ($id == 5) {
                        if ($this->request->data['EventType']['name'] == 'Vignette') {
                            $this->EventType->save($this->request->data);
                            $this->Flash->success(__('The event type has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } elseif ($id == 11) {

                        if ($this->request->data['EventType']['name'] == 'Sinistre') {


                            $this->EventType->save($this->request->data);
                            $this->Flash->success(__('The event type has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    } elseif ($id == 12) {

                        if ($this->request->data['EventType']['name'] == 'Contravention') {


                            $this->EventType->save($this->request->data);
                            $this->Flash->success(__('The event type has been saved.'));
                            $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Changes were not saved. Event type cancelled.'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }


                }

                $this->Flash->error(__('The event type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('EventType.' . $this->EventType->primaryKey => $id));
            $this->request->data = $this->EventType->find('first', $options);
            // $this->is_opened("EventType",'EventTypes','event type',$id);
            $selectedInterferingTypes = $this->InterferingTypeEventType->find('list', array(
                'fields' => array('interfering_type_id'),
                'conditions' => array('InterferingTypeEventType.event_type_id' => $id)
            ));
            $selectedEventTypeCategories = $this->EventTypeCategoryEventType->find('list', array(
                'fields' => array('event_type_category_id'),
                'conditions' => array('EventTypeCategoryEventType.event_type_id' => $id)
            ));
        }
        $eventTypeCategories = $this->EventTypeCategory->getEventTypeCategories();
        $interferingTypes = $this->InterferingType->getInterferingTypes();
        $this->set(compact('eventTypeCategories', 'interferingTypes', 'selectedInterferingTypes',
                'selectedEventTypeCategories'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_evenement, $user_id, ActionsEnum::delete, "EventTypes", $id,
            "EventType", null);
        $this->EventType->id = $id;
        if (!$this->EventType->exists()) {
            throw new NotFoundException(__('Invalid event type'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id != 1 && $id != 2 && $id != 3 && $id != 5 && $id != 11 && $id != 12 && $this->EventType->delete()) {
            $this->Flash->success(__('The event type has been deleted.'));
        } else {
            $this->Flash->error(__('The event type could not be deleted. Please, try again.'));
        }

        $this->redirect(array('action' => 'index'));
    }

    public function deleteeventtypes()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_evenement, $user_id, ActionsEnum::delete, "EventTypes", $id,
            "EventType", null);
        if ($id != 1 && $id != 2 && $id != 3 && $id != 5 && $id != 11 && $id != 12) {
            $this->EventType->id = $id;
            $this->verifyDependences($id);
            $this->request->allowMethod('post', 'delete');
            if ($this->EventType->delete()) {
                echo json_encode(array("response" => "true"));
            } else {
                echo json_encode(array("response" => "false"));
            }
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->EventEventType->getEventIds($id, 'first');
        if (!empty($result)) {
            $this->Flash->error(__('The event type could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $result = $this->EventTypeCategoryEventType->getEventTypeCategoryByEventType($id);
        if(!empty($result)){
            $this->EventTypeCategoryEventType->deleteAll(array(
                'EventTypeCategoryEventType.event_type_id'=>$id),false);
        }
        $result = $this->InterferingTypeEventType->getInterferingTypeByEventType($id);
        if(!empty($result)){
            $this->InterferingTypeEventType->deleteAll(array(
                'InterferingTypeEventType.event_type_id'=>$id),false);
        }
    }

    function getNamedates()
    {
        $this->setTimeActif();
        $this->layout = 'ajax';

        $this->set('result', $this->EventType->find('all'));


        if (isset($this->request->data['EventType']['date'])) {
            $datesav = $this->request->data['EventType']['date'];
            $this->set('datesav', $datesav);
        }


    }

    function getNamekms()
    {
        $this->setTimeActif();

        $this->layout = 'ajax';

        $this->set('result', $this->EventType->find('all'));

    }

    function getInputAlert($typeAlert=null){
        $this->setTimeActif();

        $this->layout = 'ajax';

        $this->set('typeAlert', $typeAlert);
    }
}
