<?php
App::uses('AppController', 'Controller');
/**
 * Marks Controller
 *
 * @property Mark $Mark
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RolesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->setTimeActif();
		$this->Role->recursive = 0;
		$this->set('roles', $this->Paginator->paginate());
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
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
		$this->set('role', $this->Role->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $this->setTimeActif();
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Flash->success(__('The Role has been saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->success(__('The Role could not be saved. Please, try again.'));
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
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid Role'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Role->save($this->request->data)) {
				$this->Flash->success(__('The Role has been saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->success(__('The Role could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
			$this->request->data = $this->Role->find('first', $options);
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
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid Role'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Role->delete()) {
			$this->Flash->success(__('The Role has been deleted.'));
		} else {
			$this->Flash->success(__('The Role could not be deleted. Please, try again.'));
		}
		$this->redirect(array('action' => 'index'));
	}

}
