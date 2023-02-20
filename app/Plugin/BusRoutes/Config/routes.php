<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/BusRoutes/CustomRoutes/index', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'index'));
Router::connect('/BusRoutes/CustomRoutes/add', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'add'));
Router::connect('/BusRoutes/CustomRoutes/addStop/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'addStop'));
Router::connect('/BusRoutes/CustomRoutes/edit/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'edit'));
Router::connect('/BusRoutes/CustomRoutes/delete/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'delete'));
Router::connect('/BusRoutes/CustomRoutes/deleteRoutes/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'deleteRoutes'));
Router::connect('/BusRoutes/CustomRoutes/deleteRoutes/', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'deleteRoutes'));
Router::connect('/BusRoutes/CustomRoutes/deleteRoutes', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'deleteRoutes'));
Router::connect('/BusRoutes/CustomRoutes/view/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'view'));
Router::connect('/BusRoutes/CustomRoutes/synchronizeGeoFencesAlerts', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'synchronizeGeoFencesAlerts'));
Router::connect('/BusRoutes/BusRouteStops/index', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'index'));
Router::connect('/BusRoutes/BusRouteStops/add', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'add'));
Router::connect('/BusRoutes/BusRouteStops/edit/*', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'edit'));
Router::connect('/BusRoutes/BusRouteStops/view/*', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'view'));
Router::connect('/BusRoutes/BusRouteStops/delete/*', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'delete'));
Router::connect('/BusRoutes/BusRouteStops/deleteStops/*', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'deleteStops'));
Router::connect('/BusRoutes/BusRouteStops/deleteStops/', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'deleteStops'));
Router::connect('/BusRoutes/BusRouteStops/deleteStops', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'deleteStops'));
Router::connect('/BusRoutes/BusRouteStops/getBusStopGeoFenceId/*', array('plugin' => 'BusRoutes' , 'controller' => 'BusRouteStops', 'action' => 'getBusStopGeoFenceId'));
Router::connect('/BusRoutes/CustomRoutes/addRotationsAjax/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'addRotationsAjax'));
Router::connect('/BusRoutes/CustomRoutes/addRotationAjax/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'addRotationAjax'));
Router::connect('/BusRoutes/CustomRoutes/generateReport/*', array('plugin' => 'BusRoutes' , 'controller' => 'CustomRoutes', 'action' => 'generateReport'));