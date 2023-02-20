<?php
class RestMessagesController extends AppController {
public $uses = array('Message');
public $helpers = array('Html', 'Form');
public $components = array('RequestHandler');


public function index() {
$messages = $this->Message->find('all',array('conditions' => array('Message.status_id'=>array(2)),
    'recursive'=>-1,
    'fields' => array('Message.id','Message.mobile','Message.body')));


$this->set(array(
'messages' => $messages,
'_serialize' => array('messages')
));


}

    public function edit($id) {

        $this->Message->id = $id;
        if ($this->Message->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}