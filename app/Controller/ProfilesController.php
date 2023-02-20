<?php
App::uses('AppController', 'Controller');
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 24/11/2015
 * Time: 14:39
 */
class ProfilesController extends AppController {
    public $uses = array('Profile','Module','SubModule','Section','SectionAction','AccessPermission','Action');
    public $components = array('Paginator', 'Session');
    var $helpers = array('Xls');

    public function index() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Profile.id' => 'ASC'),
            'paramType' => 'querystring'
        );
        $this->Profile->recursive = 0;
        $this->set('profiles', $this->Paginator->paginate('Profile'));
        $this->set(compact('limit'));
    }

    public function search() {
        $this->setTimeActif();
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        if (isset($this->request->data['keyword'])) {
            $this->setFilterUrl($this->request->params['controller'],
                $this->request->params['action'], $this->request->data['keyword']);
        }
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('Profile.code' => 'ASC'),
            'paramType' => 'querystring'
        );
        if (isset($this->params['named']['keyword'])) {
            $keyword = trim(strtolower($this->params['named']['keyword']));
            $this->set('profiles', $this->Paginator->paginate('Parc', array('OR' => array(
                "LOWER(Profile.code) LIKE" => "%$keyword%",
                "LOWER(Profile.name) LIKE" => "%$keyword%"))));
        } else {
            $this->Profile->recursive = 0;
            $this->set('profiles', $this->Paginator->paginate());
        }
        $this->set(compact('limit'));
        $this->render();
    }


    public function view($id = null) {
        $this->setTimeActif();
        if (!$this->Profile->exists($id)) {
            throw new NotFoundException(__('Invalid profile'));
        }
        $options = array('conditions' => array('Profile.' . $this->Profile->primaryKey => $id));
        $this->set('profile', $this->Profile->find('first', $options));
    }
    public function add() {
        $this->setTimeActif();
        if (isset($this->request->data['cancel'])) {
            $this->Flash->error(__('Adding was cancelled.'));
            $this->redirect(array('controller' => 'users','action' => 'index'));
        }
        if ($this->request->is('post')) {
            $this->Profile->create();
            if ($this->Profile->save($this->request->data)) {
                $profile_id = $this->Profile->getInsertID();
                $this->loadModel('AccessPermission');
                $subModuleId = $this->request->data['AccessPermission']['sub_module_id'];
                $sections = $this->Section->find('list');
                $countSections = count ($sections);
                $this->AccessPermission->deleteAll(array(
                    'AccessPermission.profile_id'=>$profile_id),false);
                for ($i = 1; $i <= $countSections; $i++) {
                    if (!empty($this->request->data['AccessPermission'][$i])) {

                        foreach($this->request->data['AccessPermission'][$i] as $key => $value){
                            $this->AccessPermission->create();
                            $data = array();

                            $data['AccessPermission']['section_id'] =$i  ;
                            $data['AccessPermission']['action_id'] = $key;
                            $data['AccessPermission']['profile_id'] = $profile_id;

                            $this->AccessPermission->save($data);
                        }
                    }
                }

                $this->Flash->success(__('The profile has been saved.'));

                $this->redirect(array('action' => 'index'));
            } else {
               $this->Flash->error(__('The profile could not be saved. Please, try again.'));

            }

        }

        $modules = $this->Module->find('list');
        $subModules = $this->SubModule->find('list');
        $sections = $this->Section->find('list');
        $profiles = $this->Profile->find('list');
        $this->set(compact( 'actions','rubrics','modules','subModules','sections' ,'profiles'));



    }


    public function edit($id = null) {
        $this->setTimeActif();
        if (!$this->Profile->exists($id)) {
            throw new NotFoundException(__('Invalid Profile'));
        }
      /*  if($id==11){
            $this->Flash->success(__('This profile can not be modified.'));
            $this->redirect(array('controller' => 'profiles','action' => 'index'));
        }*/
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['cancel'])) {
               $this->Flash->error(__('Adding was cancelled.'));
                $this->redirect(array('controller' => 'profiles','action' => 'index'));
            }
            $this->Profile->read(null, $id);
            $this->Profile->id = $id;
            if ( $this->Profile->save($this->request->data)) {
                $this->loadModel('AccessPermission');
                $sections = $this->Section->find('all',array(
                    'recursive'=>-1,
                    'fields'=>array('Section.id')
                ));
                $subModules = $this->request->data['Profile']['submodules'];
                $subModuleIds = explode(",", $subModules);
                $modifiedSections =  $this->Section->find('all',array(
                    'recursive'=>-1,
                    'fields'=>array('Section.id'),
                    'conditions'=>array('Section.sub_module_id'=>$subModuleIds)
                ));
                foreach($modifiedSections as $modifiedSection){
                    $this->AccessPermission->deleteAll(array(
                        'AccessPermission.profile_id'=>$id, 'AccessPermission.section_id'=>$modifiedSection['Section']['id']),false);
                }
                foreach($sections as $section){
                    $i = $section['Section']['id'];
                    if (!empty($this->request->data['AccessPermission'][$i])) {
                        foreach($this->request->data['AccessPermission'][$i] as $key => $value){
                            $this->AccessPermission->create();
                            $data = array();
                            $data['AccessPermission']['section_id'] =$i  ;
                            $data['AccessPermission']['action_id'] = $key;
                            $data['AccessPermission']['profile_id'] = $id;
                            $this->AccessPermission->save($data);
                        }
                    }
                }
                $moduleId = $this->request->data['Profile']['module_id'];
                $subModuleId = $this->request->data['AccessPermission']['sub_module_id'];
                $this->Flash->success(__('The profile has been saved.'));

                $this->redirect(array('action' => 'edit',$id, '?' => array(
                    'moduleId' => $moduleId,
                    'subModuleId' => $subModuleId
                )));

            } else {
                $this->Flash->error(__('The Profile could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }


        } else {
           if (isset($this->request->query['moduleId']) && isset($this->request->query['subModuleId'])){
               $this->set('moduleId', $this->request->query['moduleId']);
               $this->set('subModuleId', $this->request->query['subModuleId']);
           }
            $options = array('conditions' => array('Profile.' . $this->Profile->primaryKey => $id));
            $this->request->data = $this->Profile->find('first', $options);
            $accessPermissions = $this->AccessPermission->find('all', array(
                'recursive'=>-1,
                'conditions' => array('AccessPermission.profile_id' => $id),
            ));
            $this->set(compact('accessPermissions'));

        }
        $actions = $this->Action->find('list',array('conditions'=>array('Action.to_display'=>1)));

        $modules = $this->Module->find('list');
        $subModules = $this->SubModule->find('list');
        $sections = $this->Section->find('list');
		$profiles = $this->Profile->find('list');
        $this->set(compact( 'actions','modules','subModules','sections','profiles'));
    }




    public function delete($id = null) {
        $this->setTimeActif();
        $this->Profile->id = $id;
        if (!$this->Profile->exists()) {
            throw new NotFoundException(__('Invalid Profile'));
        }
        if($id == 1 || $id == 2 || $id == 3  || $id == 4 || $id == 5 ||$id == 6 ||$id == 7 ||$id == 8 ||$id == 9 ||$id == 10 || $id==11){
            $this->Flash->success(__('This profile can be deleted.'));

            $this->redirect(array('controller' => 'profiles','action' => 'index'));
        }
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if ( $this->Profile->delete()) {
            $this->Flash->success(__('The profile has been deleted.'));

        } else {
            $this->Flash->error(__('The profile could not be deleted. Please, try again.'));

        }
        $this->redirect(array('action' => 'index'));
    }


    public function deleteProfiles() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
       // $user_id=$this->Auth->user('id');
        //$this->verifyPermissions(6,$user_id,6,"Parcs", $id,"Parc");
        // if () {

        $this->Profile->id = $id;
        $this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        if($id != 1 && $id != 2 && $id != 3 && $id != 4 && $id != 5 && $id != 6 && $id != 7 && $id != 8 && $id != 9 && $id != 10 && $id != 11 && $this->Profile->delete()){
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
        /*}else{
            echo json_encode(array("response" => "false"));
        }*/
    }

    private function verifyDependences($id){
        $this->setTimeActif();
        $profiles = $this->User->find('all', 
				array(
					'conditions' => 
							array( 
								'User.profile_id ='=>$id
								), 
					'recursive'=>-1
					)
					);
        if (!empty($profiles)){
             $this->Flash->success(__('The profile could not be deleted. Please remove dependencies in advance.'));
            $this->redirect(array('action' => 'index'));
        }

        $rights = $this->AccessPermission->find('first', 
					array(
						"conditions" => 
								array(
									"AccessPermission.profile_id =" => $id
									)));
        if (!empty($rights)) {
            $this->AccessPermission->deleteAll(array('AccessPermission.profile_id'=>$id),false);

        }
    }

    function export() {
        $this->setTimeActif();
        $Profiles = $this->Profile->find('all', array(
            'order' => 'Profile.name asc',
            'recursive' => -1
        ));
        $this->set('models', $Profiles);
    }
	
	
	function getSubModuleSByModule($moduleId=null) {
		
		   $this->settimeactif();
        $this->layout = 'ajax';
        $this->set('moduleId', $moduleId);
        if ($moduleId != null) {

            $this->layout = 'ajax';
            $this->set('subModules', $this->SubModule->find('list', array(
                'conditions' => array('SubModule.module_id' => $moduleId),
               
               
            )));

        } else {
            $this->set('subModules', null);
        }
	}	
	
	
	function getSectionsBySubModule($subModuleId=null) {
		
		$this->settimeactif();
        $this->layout = 'ajax';
		
        $this->set('subModuleId', $subModuleId);
        if ($subModuleId != null) {

            $this->layout = 'ajax';
			$sections = $this->Section->find('list', array(
                'conditions' => array('Section.sub_module_id' => $subModuleId),
            ));
			
            $this->set('sections',$sections);

        } else {
            $this->set('sections', null);
        }
	}
	
	function getSectionActionsBySection ($sectionId = null){
		
		$this->settimeactif();
        $this->layout = 'ajax';
		
        $this->set('sectionId', $sectionId);
        if ($sectionId != null) {

            $this->layout = 'ajax';
			$sectionActions = $this->SectionAction->find('list', array(
                'conditions' => array('SectionAction.section_id' => $sectionId),
            ));
			
            $this->set('sections',$sectionActions);

        } else {
            $this->set('sections', null);
        }
	}

	function getSectionActionsBySubModule ($moduleId = null, $subModuleId = null , $profileId = null){

		$this->settimeactif();
        $this->layout = 'ajax';
        $this->set('subModuleId', $subModuleId);
        $this->set('moduleId', $moduleId);
        if ($subModuleId != null) {

            $this->layout = 'ajax';
			$sections = $this->Section->find('all', array('recursive'=>-1,
				'fields'=>array('Section.id','Section.name'),
                'conditions' => array('Section.sub_module_id' => $subModuleId),
            ));
			
			$actions = $this->Action->find('all', array('recursive'=>-1,
                'fields'=>array('Action.id','Action.name'),
                'conditions'=>array('Action.to_display'=>1)
                ));
			$sectionAction1s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>1),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction2s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>2),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction3s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>3),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction4s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>4),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction5s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>5),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction6s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>6),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction7s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>7),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));

            $sectionAction8s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>8),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction9s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>9),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction10s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>10),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction11s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>11),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction12s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>12),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction13s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>13),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction14s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>14),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			
			$sectionAction15s = $this->SectionAction->find('all', array(
				'recursive'=>-1,
				
                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>15),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));
			$sectionAction16s = $this->SectionAction->find('all', array(
				'recursive'=>-1,

                'conditions' => array('Section.sub_module_id' => $subModuleId, 'SectionAction.action_id'=>20),
				  'joins'=> array(
                    array(
                        'table' => 'sections',
                        'type' => 'left',
                        'alias' => 'Section',
                        'conditions' => array('Section.id = SectionAction.section_id')
                    )
                )
            ));




            if($profileId!= null){
				
              
                $accessPermission1s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>1,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission2s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>2,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission3s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>3,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission4s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>4,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission5s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>5,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission6s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>6,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission7s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>7,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission8s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>8,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission9s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>9,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission10s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>10,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission11s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>11,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
				$accessPermission12s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>12,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));


				$accessPermission13s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>13,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));$accessPermission14s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>14,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
                $accessPermission15s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' => 
						array(
							'Section.sub_module_id' => $subModuleId, 
							'AccessPermission.action_id'=>15,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)		
                ));
                $accessPermission16s = $this->AccessPermission->find('all', array(
                    'recursive'=>-1,
                    'conditions' =>
						array(
							'Section.sub_module_id' => $subModuleId,
							'AccessPermission.action_id'=>20,
							'AccessPermission.profile_id' => $profileId
							),
					'joins'=> array(
						array(
							'table' => 'sections',
							'type' => 'left',
							'alias' => 'Section',
							'conditions' => array('Section.id = AccessPermission.section_id')
						)
					)
                ));


                $this->set(compact('accessPermission1s','accessPermission2s','accessPermission3s',
				'accessPermission4s','accessPermission5s','accessPermission6s','accessPermission7s',
				'accessPermission8s','accessPermission9s','accessPermission10s','accessPermission11s',
				'accessPermission12s','accessPermission13s','accessPermission14s','accessPermission15s','accessPermission16s'));
            }

            $this->set(compact('sections','actions','sectionAction1s' ,'sectionAction2s',
			'sectionAction3s','sectionAction4s','sectionAction5s','sectionAction6s','sectionAction7s',
			'sectionAction8s','sectionAction9s','sectionAction10s','sectionAction11s','sectionAction12s',
			'sectionAction13s','sectionAction14s','sectionAction15s','sectionAction16s','profileId'));

        } else {
            $this->set('sections', null);
        }
	}


    function addSectionActions(){

        $sections = $this->Section->find('all', array('recursive'=>-1,
            'fields'=>array('Section.id','Section.name','Section.code'),
        ));
        $actions = $this->Action->find('all', array('recursive'=>-1,
            'fields'=>array('Action.id','Action.name','Action.code'),
            'conditions'=>array('Action.to_display'=>1)));
        foreach($sections as $section){
            foreach($actions as $action){
                $this->loadModel('SectionAction');
                $this->SectionAction->create();
                $data = array();
                $data['SectionAction']['section_id'] =$section['Section']['id'];
                $data['SectionAction']['code_section'] =$section['Section']['code'];
                $data['SectionAction']['action_id'] = $action['Action']['id'];
                $data['SectionAction']['code_action'] = $action['Action']['code'];
                $data['SectionAction']['value'] = 0;
                $this->SectionAction->save($data);

            }
        }
    }

    function addSectionActionsByActionId($actionId = null){

        $sections = $this->Section->find('all', array('recursive'=>-1,
            'fields'=>array('Section.id','Section.name','Section.code'),
        ));

        foreach($sections as $section){

                $this->loadModel('SectionAction');
                $this->SectionAction->create();
                $data = array();
                $data['SectionAction']['section_id'] =$section['Section']['id'];
                $data['SectionAction']['code_section'] =$section['Section']['code'];
                $data['SectionAction']['action_id'] = $actionId;
                $data['SectionAction']['code_action'] ='';
                $data['SectionAction']['value'] = 0;
                $this->SectionAction->save($data);


        }
    }
}
