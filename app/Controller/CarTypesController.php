<?php

App::uses('AppController', 'Controller');

/**
 * CarTypes Controller
 *
 * @property CarType $CarType
 * @property CarTypeCarCategory $CarTypeCarCategory
 * @property CarCategory $CarCategory
 * @property AttachmentType $AttachmentType
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class CarTypesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    var $helpers = array('Xls');
    public $uses = array('CarType', 'CarTypeCarCategory', 'AttachmentType', 'CarCategory');

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
        $result = $this->verifyUserPermission(SectionsEnum::type_vehicule, $user_id, ActionsEnum::view, "CarTypes",
            null, "CarType", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('CarType.user_id ' => $user_id);

                break;
            case 3 :
                $conditions = array('CarType.user_id !=' => $user_id);

                break;

            default:
                $conditions = null;
        }

        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CarType.code' => 'ASC', 'CarType.name' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'CarType.id',
                'CarType.code',
                'CarType.name',
                'CarCategory.name',
                'CarCategory.id',
                'CarType.created',
                'CarType.modified',
                'CarType.average_speed'
            ),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('CarType.id = CarTypeCarCategory.car_type_id')
                ),
                array(
                    'table' => 'car_categories',
                    'type' => 'left',
                    'alias' => 'CarCategory',
                    'conditions' => array('CarTypeCarCategory.car_category_id = CarCategory.id')
                )
            )

        );
        $carTypes = $this->Paginator->paginate('CarTypeCarCategory');

        $this->set('carTypes', $carTypes);

        $this->set(compact('limit'));
    }

    /**
     * search method
     *
     * @return void
     */
    public function search()
    {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl("CarTypes",
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('CarType.code' => 'ASC', 'CarType.name' => 'ASC'),
            'paramType' => 'querystring',
            'fields' => array(
                'CarType.id',
                'CarType.code',
                'CarType.name',
                'CarCategory.name',
                'CarCategory.id',
                'CarType.created',
                'CarType.modified',
                'CarType.average_speed'
            ),
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'car_types',
                    'type' => 'left',
                    'alias' => 'CarType',
                    'conditions' => array('CarType.id = CarTypeCarCategory.car_type_id')
                ),
                array(
                    'table' => 'car_categories',
                    'type' => 'left',
                    'alias' => 'CarCategory',
                    'conditions' => array('CarTypeCarCategory.car_category_id = CarCategory.id')
                )
            )
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('carTypes', $this->Paginator->paginate('CarTypeCarCategory', array(
                'OR' => array(
                    "LOWER(CarType.code) LIKE" => "%$keyword%",
                    "LOWER(CarType.name) LIKE" => "%$keyword%",
                    "LOWER(CarCategory.name) LIKE" => "%$keyword%",
                    "LOWER(CarType.average_speed) LIKE" => "%$keyword%",
                    "LOWER(CarType.created) LIKE" => "%$keyword%",
                    "LOWER(CarType.modified) LIKE" => "%$keyword%",
                )
            )));
        } else {
            $this->CarType->recursive = -1;
            $this->set('carTypes', $this->Paginator->paginate('CarTypeCarCategory'));
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
        if (!$this->CarType->exists($id)) {
            throw new NotFoundException(__('Invalid car type'));
        }
        $options = array('conditions' => array('CarType.' . $this->CarType->primaryKey => $id));
        $this->set('carType', $this->CarType->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::type_vehicule, $user_id, ActionsEnum::add, "CarTypes", null,
            "CarType", null);
        if ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Adding was cancelled.'));
                $this->layout = 'ajax';
                $this->redirect(array('action' => 'index'));
            }

            $this->CarType->create();
            $this->request->data['CarType']['user_id'] = $this->Session->read('Auth.User.id');
            $carCategoryIds = $this->request->data['CarTypeCarCategory']['car_category_id'];
            $this->verifyAttachment('CarType', 'picture', 'img/car_types/', 'add', 0, 0, null);
            if ($this->CarType->save($this->request->data)) {
                $carTypeId = $this->CarType->getInsertID();
                foreach ($carCategoryIds as $carCategoryId) {
                    $this->CarTypeCarCategory->create();
                    $data = array();
                    $data['CarTypeCarCategory']['car_type_id'] = $carTypeId;
                    $data['CarTypeCarCategory']['car_category_id'] = $carCategoryId;
                    $this->CarTypeCarCategory->save($data);
                }

                $this->Flash->success(__('The car type has been saved.'));
                $this->redirect(array('action' => 'index'));

            } else {
                $this->Flash->error(__('The car type could not be saved. Please, try again.'));
            }


        }
        $carCategories = $this->CarCategory->getCarCategories();
        $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::type_vehicule, 'all');

        $this->set(compact('carCategories', 'attachmentTypes', 'attachments'));
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
        $this->verifyUserPermission(SectionsEnum::type_vehicule, $user_id, ActionsEnum::edit, "CarTypes", $id,
            "CarType", null);
        if (!$this->CarType->exists($id)) {
            throw new NotFoundException(__('Invalid car type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Car type cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['CarType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            if ($this->request->data['CarType']['picture']['tmp_name'] != '') {
                $this->verifyAttachment('CarType', 'picture', 'img/car_types/', 'edit', 0, 0, $id);
            }
            if ($this->CarType->save($this->request->data)) {
                $this->CarTypeCarCategory->deleteAll(['CarTypeCarCategory.car_type_id' => $id], false);
                foreach ($this->request->data['CarTypeCarCategory']['car_category_id'] as $car_category_id) {
                    $this->CarTypeCarCategory->create();
                    $data = array();
                    $data['CarTypeCarCategory']['car_type_id'] = $id;
                    $data['CarTypeCarCategory']['car_category_id'] = $car_category_id;
                    $this->CarTypeCarCategory->save($data);
                }

                $this->Flash->success(__('The car type has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The car type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CarType.' . $this->CarType->primaryKey => $id));
            $this->request->data = $this->CarType->find('first', $options);
            $carCategoriesSelected = $this->CarTypeCarCategory->getCarTypeCarCategories($id);

            $this->set(compact('carCategoriesSelected'));
        }

        $carCategories = $this->CarCategory->getCarCategories();

        $attachmentTypes = $this->AttachmentType->getAttachmentTypeBySectionId(SectionsEnum::type_vehicule, 'all');
        $this->set(compact('carCategories', 'attachmentTypes'));
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
        $this->verifyUserPermission(SectionsEnum::type_vehicule, $user_id, ActionsEnum::delete, "CarTypes", $id,
            "CarType", null);
        $this->CarType->id = $id;
        if (!$this->CarType->exists()) {
            throw new NotFoundException(__('Invalid car type'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CarType->delete()) {
            $this->Flash->success(__('The car type has been deleted.'));
        } else {
            $this->Flash->error(__('The car type could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteCarTypes()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');

        $id = filter_input(INPUT_POST, "id");
        $this->verifyUserPermission(SectionsEnum::type_vehicule, $user_id, ActionsEnum::delete, "CarTypes", $id,
            "CarType", null);
        $this->CarType->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->CarType->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    /**
     * @param $id
     * @return void
     */
    private function verifyDependences($id)
    {
        $this->setTimeActif();
        $result = $this->CarType->Car->find('first', array("conditions" => array("CarType.id =" => $id)));
        if (!empty($result)) {
            $this->Flash->error(__('The car type could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->CarTypeCarCategory->deleteAll(['CarTypeCarCategory.car_type_id' => $id], false);
    }

    function export()
    {
        $this->setTimeActif();
        $carTypes = $this->CarType->getCarTypes(2);
        $this->set('models', $carTypes);
    }

    public function getCartTypesByCategoryAjax(){
        $this->autoRender = false;
        $carCategoryId = $this->request->query('carCategoryId');
        $response = []; 
        if(!empty($carCategoryId) && is_numeric($carCategoryId)){ 
            $carTypes = $this->CarType->getCarTypeByConditions(array(
                'CarTypeCarCategory.car_category_id' => $carCategoryId
            ));
            foreach($carTypes as $carTypeId => $carType){
                $response [] = array(
                    'id' => $carTypeId,  
                    'text' => $carType
                );
            }
        }
        echo json_encode($response);
        exit;
    }


}
