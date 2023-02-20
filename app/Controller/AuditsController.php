<?php

/**
 
 * @author kahina
 */
class AuditsController extends AppController
{
public $components = array('Paginator', 'Session');

    public function index() {

    

        $this->paginate = array(
            'limit' => 2,
          
            
            'paramType' => 'querystring'
        );
        $this->Audit->recursive = 1;
        $this->set('audits', $this->Paginator->paginate('Audit'));
       


        


    }
    
}