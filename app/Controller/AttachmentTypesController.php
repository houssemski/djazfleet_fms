<?php

/**
 * CarTypes Controller
 *
 * @property AttachmentType $AttachmentType
 * @property Section $Section
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class AttachmentTypesController extends AppController
{

    public $components = array('Paginator', 'Session');

    public $uses = array('AttachmentType', 'Section');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->setTimeActif();
        $user_id = $this->Auth->user('id');
        $result = $this->verifyUserPermission(SectionsEnum::type_piece_jointe_client, $user_id, ActionsEnum::view,
            "AttachmentTypes", null, "AttachmentType", null);
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();

        switch ($result) {
            case 1 :
                $conditions = null;
                break;
            case 2 :
                $conditions = array('AttachmentType.user_id ' => $user_id);
                break;
            case 3 :
                $conditions = array('AttachmentType.user_id !=' => $user_id);
                break;

            default:
                $conditions = null;
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('AttachmentType.sub_module_id' => 'ASC'),
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'fields' => array(
                'AttachmentType.name',
                'AttachmentType.id',
                'AttachmentType.created',
                'AttachmentType.modified',
                'Section.name'
            ),
            'joins' => array(
                array(
                    'table' => 'sections',
                    'type' => 'left',
                    'alias' => 'Section',
                    'conditions' => array('Section.id = AttachmentType.section_id')
                ),
            )
        );


        $this->AttachmentType->recursive = -1;
        $this->set('attachmentTypes', $this->Paginator->paginate());
        $this->set(compact('limit'));
    }

    public function search()
    {
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('AttachmentType.name' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('attachmentTypes',
                $this->Paginator->paginate('AttachmentType', array("LOWER(AttachmentType.name) LIKE" => "%$keyword%")));
        } else {
            $this->AttachmentType->recursive = -1;
            $this->set('attachmentTypes', $this->Paginator->paginate());
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
        if (!$this->AttachmentType->exists($id)) {
            throw new NotFoundException(__('Invalid') . ' ' . __('type'));
        }
        $options = array('conditions' => array('AttachmentType.' . $this->AttachmentType->primaryKey => $id));
        $this->set('attachmentType', $this->AttachmentType->find('first', $options));
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
        $this->verifyUserPermission(SectionsEnum::type_piece_jointe_client, $user_id, ActionsEnum::add,
            "AttachmentTypes", null, "AttachmentType", null);
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->AttachmentType->create();
            $this->request->data['AttachmentType']['user_id'] = $this->Session->read('Auth.User.id');

            if ($this->AttachmentType->save($this->request->data)) {
                $this->Flash->success(__('The type') . ' ' . __('has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The type') . ' ' . __('could not be saved. Please, try again.'));
            }
        }
        $sections = $this->Section->getSections();
        $this->set(compact('sections'));
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
        $this->verifyUserPermission(SectionsEnum::type_piece_jointe_client, $user_id, ActionsEnum::edit,
            "AttachmentTypes", $id, "AttachmentType", null);
        if (!$this->AttachmentType->exists($id)) {
            throw new NotFoundException(__('Invalid') . ' ' . __('type'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->success(__('Changes were not saved.') . ' ' . __('Type') . ' ' . __(' cancelled.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['AttachmentType']['last_modifier_id'] = $this->Session->read('Auth.User.id');
            $section = $this->Section->getSectionById($this->request->data['AttachmentType']['section_id']);
            $sectionId = $section['Section']['id'];
            $name = $this->request->data['AttachmentType']['id'];
            if ($id != 1 && $id != 2 && $id != 3 && $id != 4 && $id != 5 && $id != 6 && $id != 7 && $id != 8 && $id != 9 && $id != 10 && $id != 11 && $this->AttachmentType->save($this->request->data)) {
                $dossier = 'attachments/' . $sectionId . '/' . $name;
                if (is_dir($dossier)) {
                } else {
                    mkdir($dossier);
                }

                $this->Flash->success(__('The type') . ' ' . __('has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The type') . ' ' . __('could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('AttachmentType.' . $this->AttachmentType->primaryKey => $id));
            $this->request->data = $this->AttachmentType->find('first', $options);
            $sections = $this->Section->getSections();
            $this->set(compact('sections'));
        }
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
        $this->verifyUserPermission(SectionsEnum::type_piece_jointe_client, $user_id, ActionsEnum::delete,
            "AttachmentTypes", $id, "AttachmentType", null);
        $this->AttachmentType->id = $id;
        if (!$this->AttachmentType->exists()) {
            throw new NotFoundException(__('Invalid') . ' ' . __('type'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($id != 1 && $id != 2 && $id != 3 && $id != 4 && $id != 5 && $id != 6 && $id != 7 && $id != 8 && $id != 9 && $id != 10 && $id != 11 && $this->AttachmentType->delete()) {
            $this->Flash->success(__('The type') . ' ' . __('has been deleted.'));
        } else {
            $this->Flash->error(__('The type') . ' ' . __('could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteTypes()
    {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id = $this->Auth->user('id');
        $this->verifyUserPermission(SectionsEnum::type_piece_jointe_client, $user_id, ActionsEnum::delete,
            "AttachmentTypes", $id, "AttachmentType", null);

        $this->AttachmentType->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->AttachmentType->delete()) {
            echo json_encode(array("response" => "true"));
        } else {
            echo json_encode(array("response" => "false"));
        }
    }

    private function verifyDependences($id)
    {

    }


}