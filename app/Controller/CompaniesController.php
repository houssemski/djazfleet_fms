<?php

App::uses('AppController', 'Controller');

/**
 * Companies Controller
 *
 * @property Company $Company
 * @property PaginatorComponent $Paginator
 */
class CompaniesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');


    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = 1)
    {
        $this->setTimeActif();
        if (!$this->Company->exists($id)) {
            throw new NotFoundException(__('Invalid company'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
                $this->Flash->error(__('Changes were not saved. Company cancelled.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
            $this->verifyAttachment('Company', 'logo', 'logo/', 'edit', 1, 0, null, true);
            $this->verifyAttachment('Company', 'stamp_image', 'cachet/', 'edit', 1, 0, null, true);
            if ($this->Company->save($this->request->data)) {
                $this->Flash->success(__('The company has been saved.'));
                return $this->redirect(array('controller' => 'parameters', 'action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
            $this->request->data = $this->Company->find('first', $options);
        }
        $legalForms = $this->Company->LegalForm->find('list');
        $this->set(compact('legalForms'));
    }
}
