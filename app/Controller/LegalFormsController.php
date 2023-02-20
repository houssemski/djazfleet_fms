<?php
App::uses('AppController', 'Controller');
/**
 * LegalForms Controller
 *
 * @property LegalForm $LegalForm
 * @property PaginatorComponent $Paginator
 */
class LegalFormsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->setTimeActif();
		$this->LegalForm->recursive = 0;
		$this->set('legalForms', $this->Paginator->paginate());
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
		if (!$this->LegalForm->exists($id)) {
			throw new NotFoundException(__('Invalid legal form'));
		}
		$options = array('conditions' => array('LegalForm.' . $this->LegalForm->primaryKey => $id));
		$this->set('legalForm', $this->LegalForm->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $this->setTimeActif();
		if ($this->request->is('post')) {
			$this->LegalForm->create();
			if ($this->LegalForm->save($this->request->data)) {
				return $this->flash(__('The legal form has been saved.'), array('action' => 'index'));
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
		if (!$this->LegalForm->exists($id)) {
			throw new NotFoundException(__('Invalid legal form'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LegalForm->save($this->request->data)) {
				return $this->flash(__('The legal form has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('LegalForm.' . $this->LegalForm->primaryKey => $id));
			$this->request->data = $this->LegalForm->find('first', $options);
           // $this->is_opened("LegalForm",'LegalForms','legal form',$id);
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
		$this->LegalForm->id = $id;
		if (!$this->LegalForm->exists()) {
			throw new NotFoundException(__('Invalid legal form'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->LegalForm->delete()) {
			return $this->flash(__('The legal form has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The legal form could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}
}
