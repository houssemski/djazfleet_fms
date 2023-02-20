<?php
App::uses('BusRoutesAppController', 'BusRoutes.Controller');
/**
 * BusRouteStops Controller
 * @property BusRouteStop $BusRouteStop
 * @property PaginatorComponent $paginate
 * @property Wilaya $Wilaya
 * @property SaveBusStopsGeoFencesComponent $SaveBusStopsGeoFences
 */
class BusRouteStopsController extends BusRoutesAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public $uses = array(
        'BusRouteStop',
        'Wilaya'
    );

    public $components = array(
        'BusRoutes.SaveBusRoutes',
        'BusRoutes.GetGeoFencesAlerts',
        'BusRoutes.SaveBusStopsGeoFences',
        'Paginator'
    );

    public function view($id){
        $busRouteStop = $this->BusRouteStop->find('first',array(
            'conditions' => array(
                'BusRouteStop.id' => $id
            )
        ));
        $this->set(compact('busRouteStop'));
    }

	public function index(){
        $limit = isset($this->params['pass']['0']) ? $this->getLimit($this->params['pass']['0']) : $this->getLimit();
        $this->paginate = array(
            'limit' => $limit,
            'order' => array('BusRouteStop.route_title' => 'ASC'),
            'paramType' => 'querystring',
            'fields' => array(
                'BusRouteStop.id',
                'BusRouteStop.name',
                'BusRouteStop.lat',
                'BusRouteStop.lng',
            ),
            'recursive' => -1,
        );

        //Parametrer la pagination


        $this->set('busRouteStops', $this->Paginator->paginate('BusRouteStop'));
        $this->set(compact('limit'));
    }

	public function add(){
        if ($this->request->is('post')){
            $this->BusRouteStop->create();
            $result = $this->BusRouteStop->save($this->request->data);
            if ($result){
                $this->SaveBusStopsGeoFences->addBusStopsGeoFencesInDjazFleet($this->request->data,$result['BusRouteStop']['id']);
                $this->Flash->success(__('The bus stop has been saved.'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Flash->error(__('The bus stop could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $wilayas = $this->Wilaya->getWilayaList();
        $this->set(compact('wilayas'));
    }

    public function edit($id){
	    $busRouteStop = $this->BusRouteStop->find('first',array(
	        'conditions' => array(
                'BusRouteStop.id' => $id
            )
        ));
        if ($this->request->is(array('post', 'put'))){
            $this->BusRouteStop->id = $id;
            $result = $this->BusRouteStop->save($this->request->data);
            if ($result){
                $this->SaveBusStopsGeoFences->editBusStopsGeoFencesInDjazFleet($result);
                $this->Flash->success(__('The bus stop has been saved.'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Flash->error(__('The bus stop could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->request->data = $busRouteStop;
        $wilayas = $this->Wilaya->getWilayaList();
        $this->set(compact('busRouteStop','wilayas'));
    }

    public function delete($id = null) {
        $this->setTimeActif();

        $this->BusRouteStop->id = $id;
        if (!$this->BusRouteStop->exists()) {
            throw new NotFoundException(__('Invalid bus route'));
        }
        //$this->verifyDependences($id);
        $this->request->allowMethod('post', 'delete');
        $busRouteStop = $this->BusRouteStop->find('first',array(
            'conditions' => array('BusRouteStop.id' => $id)
        ));
        if ($this->BusRouteStop->delete($id)) {
            $this->SaveBusStopsGeoFences->destroyBusStopGeoFenceInDjazFleet($busRouteStop['BusRouteStop']['geo_fence_id']);
            $this->Flash->success(__('The bus stop has been deleted.'));
        } else {

            $this->Flash->error(__('The bus stop could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function deleteStops() {
        $this->setTimeActif();
        $this->autoRender = false;
        $id = filter_input(INPUT_POST, "id");
        $user_id=$this->Auth->user('id');
        $this->BusRouteStop->id = $id;
        $busRouteStop = $this->BusRouteStop->find('first',array(
            'conditions' => array('BusRouteStop.id' => $id)
        ));
        $this->request->allowMethod('post', 'delete');
        if($this->BusRouteStop->delete($id)){
            $this->SaveBusStopsGeoFences->destroyBusStopGeoFenceInDjazFleet($busRouteStop['BusRouteStop']['geo_fence_id']);
            echo json_encode(array("response" => "true"));
        }else{
            echo json_encode(array("response" => "false"));
        }
    }

    public function getBusStopGeoFenceId(){
        $this->autoRender = false;
        $busStopId = $this->request->query('BusStopId');
        $busStop = $this->BusRouteStop->find('first',array(
            'conditions' => array(
                'BusRouteStop.id' => $busStopId
            )
        ));
        $geoFenceId = $busStop['BusRouteStop']['geo_fence_id'];

        echo json_encode($geoFenceId);
        exit;
    }
}
