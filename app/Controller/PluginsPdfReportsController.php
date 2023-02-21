<?php

App::uses('AppController', 'Controller');

/**
 * EventTypes Controller
 *
 * @property Absence $Absence
 * @property Customer $Customer
 * @property AbsenceReason $AbsenceReason
 * @property PaginatorComponent $Paginator
 * @property PaginatorComponent $paginate
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property FlashComponent $Flash
 * @property CakeRequest $params
 */
class PluginsPdfReportsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Security');
    public $uses = array(
        'Absence',
        'Customer',
        'AbsenceReason',
        'BusRoutes.BusRotation',
        'BusRoutes.BusRotationSchedule',
        'BusRoutes.BusRotationWeekDay',
        'BusRoutes.BusRoute',
        'BusRoutes.BusRouteRotation',
        'BusRoutes.BusRouteStop',
        'BusRoutes.BusStop',
        'BusRoutes.GeofencesAlert',
    );
    var $helpers = array('Xls', 'Tinymce');



    public function rotationByDate($busRouteId){

    }

}
