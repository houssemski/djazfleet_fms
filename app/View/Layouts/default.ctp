<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php  if(Configure::read("gestion_commercial") == '1') { ?>
    <meta name="description" content="UTRANX THEME">
    <meta name="author" content="Coderthemes">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" >
    	<?php   if(Configure::read("engin") == '1') {  ?>
		<link rel="shortcut icon" href="img/favicon_engines.ico">
		<?php   }elseif (Configure::read("djazfleet") == '1' ||
            Configure::read("logistia") == '1' || Configure::read("engin") == '1') {
    	    ?>
            <link rel="shortcut icon">
            <?php
        }else {  ?>
		<link rel="shortcut icon" href="img/favicon.ico">
		  <?php    } ?>
    <?php   if(Configure::read("engin") == '1') {  ?>
            <title>Engines</title>
    <?php   }elseif (Configure::read("djazfleet") == '1'){?>
            <title>Djezfleet gestion de parc</title>
        <?php }elseif (Configure::read("logistia") == '1'){?>
            <title>LOGISTIA</title>
        <?php }else {  ?>
            <title>UtranX</title>
        <?php    }
        ?>

    <?php } else { ?>
        <meta name="description" content="UTRANX THEME">
        <meta name="author" content="Coderthemes">
        <?php
        if (Configure::read("djazfleet") == '1'){
        ?>
            <title>Djezfleet gestion de parc</title>
            <?php
        }elseif (Configure::read("logistia") == '1'){?>
            <title>LOGISTIA</title>
        <?php }else{
            ?>
        <title>UtranX</title>
            <?php
        }
            ?>
    <?php } ?>
 <?php
 /*

 */
 include("ctp/index.ctp");
 include("ctp/script.ctp");
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('core');
    echo $this->Html->css('components');
    echo $this->Html->css('icons');
    echo $this->Html->css('pages');
    if (Configure::read('parc_master') == '1'){
        echo $this->Html->css('parc_master');
    }elseif (Configure::read('logistia') == '1'){
        echo $this->Html->css('logistia');
    } elseif (Configure::read('djazfleet') == '1'){
        echo $this->Html->css('djazfleet');
    }
    echo $this->Html->css('menu');
    echo $this->Html->css('responsive');
    echo $this->Html->css('jquery-ui');
    echo $this->Html->css('custombox/dist/custombox.min');
    //echo $this->Html->css('style_partners');
    echo $this->fetch('meta');
    echo $this->fetch('css');

    echo $this->Html->script('jquery.min');
 echo $this->Html->script('modernizr.min');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('detect');
    echo $this->Html->script('fastclick');
    echo $this->Html->script('jquery.slimscroll');
    echo $this->Html->script('jquery.blockUI');
    echo $this->Html->script('waves');
    echo $this->Html->script('wow.min');
    echo $this->Html->script('jquery.nicescroll');
    echo $this->Html->script('jquery.scrollTo.min');
    echo $this->Html->script('jquery.core');
    echo $this->Html->script('jquery-ui-1.10.3.min');
    echo $this->Html->script('plugins/jquery-knob/jquery.knob');
    echo $this->Html->script('plugins/raphael/raphael-min');
    echo $this->Html->script('plugins/custombox/dist/custombox.min.js');
    echo $this->Html->script('plugins/custombox/dist/legacy.min.js');

    echo $this->fetch('script');

    ?>


</head>
<?php
if ($this->params['action'] == "login") {
    $class_body = "account-pages";
} else if($this->params['action'] == "personalTransportDashboard"){
    $class_body = "personal-transport-dashboard";
}else{
    $class_body = "";
}
?>
<body class="<?= $class_body; ?>">
<!-- Navigation Bar-->
<header id="topnav">
    <div class="container container-green container-white">

        <!-- LOGO -->
        <div class="topbar-left">
            <?php
            $profileId = $this->Session->read('Auth.User.profile_id');
            if(Configure::read("transport_personnel") == '1' &&
                $this->request->params['action'] =='personalTransportDashboard'
            ){
                echo $this->Html->link(
                    "",
                    "#",
                    array('escape' => false, 'class' => 'logo'));

            }else{
                if ($profileId != ProfilesEnum::client) { ?>

                    <?php if(Configure::read("gestion_commercial") == '1') {
                        if (Configure::read("djazfleet") == '1'){ ?>
                            <?= $this->Html->link(
                                "",
                                array('controller' => 'pages', 'action' => 'display'),
                                array('escape' => false, 'class' => 'logo_djazfleet')
                            ); ?>
                        <?php }elseif(Configure::read("logistia") == '1') {  ?>
                            <?= $this->Html->link(
                                "",
                                array('controller' => 'pages', 'action' => 'display'),
                                array('escape' => false, 'class' => 'logo_logistia')
                            ); ?>
                        <?php    }elseif(Configure::read("engin") == '1') {  ?>
                            <?= $this->Html->link(
                                "",
                                array('controller' => 'pages', 'action' => 'display'),
                                array('escape' => false, 'class' => 'logo_engin')
                            ); ?>
                        <?php    }else { ?>
                            <?= $this->Html->link(
                                "",
                                array('controller' => 'pages', 'action' => 'display'),
                                array('escape' => false, 'class' => 'logo')
                            ); ?>
                        <?php  }
                        ?>

                    <?php  }else {  ?>
                        <?php if (Configure::read("parc_master") == '1'){ ?>
                            <?= $this->Html->link(
                            "",
                            array('controller' => 'pages', 'action' => 'display'),
                            array('escape' => false, 'class' => 'logo_parc_master' )
                        ); ?>
                        <?php }elseif (Configure::read("logistia") == '1'){ ?>
                            <?= $this->Html->link(
                                "",
                                array('controller' => 'pages', 'action' => 'display'),
                                array('escape' => false, 'class' => 'logo_logistia' )
                            ); ?>
                        <?php }else{?>
                            <?= $this->Html->link(
                                "",
                                array('controller' => 'pages', 'action' => 'display'),
                                array('escape' => false, 'class' => 'logo')
                            ); ?>
                            <?php } ?>

                    <?php  } ?>
                <?php } else { ?>
                    <?= $this->Html->link(
                        "",
                        array('controller' => 'transport_bills', 'action' => 'index', 0),
                        array('escape' => false, 'class' => 'logo')
                    ); ?>
                <?php }
            } ?>

            <a class="button-toggle-nav inline-block ml-20 pull-left" href="javascript:void(0);">
                <i class="zmdi zmdi-menu ti-align-right"></i>
            </a>
        </div>
        <!-- End Logo container-->
        <div class="menu-extras">

            <ul class="nav navbar-nav navbar-right pull-right">

                <li class="user-box fullscreen">
                    <a id="btnFullscreen" class="nav-link">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
                <?php

                $nbNotifications = $this->Session->read("nbNotifications");

                if ($nbNotifications > 0) {
                    ?>
                    <li onclick="showNotifications()" class="li-notification right-bar-toggle">
                        <!-- Notification -->
                        <div class="notification-box"  style="cursor: pointer;">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a  class="right-bar-toggle">
                                        <i class="fa  fa-tasks"></i>
                                    </a>

                                    <div class="noti-dot">
                                        <span class="pulse-green"><span class="count-notif"><?= $nbNotifications ?></span></span>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <!-- End Notification bar -->
                    </li>
                    <?php }
                    $nbComplaintNotifications = $this->Session->read("nbComplaintNotifications");
                    if ($nbComplaintNotifications > 0) {
                    ?>
                    <li onclick="showComplaintNotifications()" class="li-complaint-notification right-bar-toggle">
                        <!-- Notification -->
                        <div class="notification-box"  style="cursor: pointer;">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a  class="right-bar-toggle">
                                        <i class="fa  fa-tasks"></i>
                                    </a>

                                    <div class="noti-dot">
                                        <span class="pulse-green"><span class="count-notif"><?= $nbComplaintNotifications ?></span></span>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <!-- End Notification bar -->
                    </li>
                    <?php  }  ?>
                <?php
                    if ($profileId != ProfilesEnum::client) {
                    $nbAlerts = $this->Session->read("nbAlerts");
                    if ($nbAlerts > 0) {
                        ?>
                        <li onclick="showAlerts()" class="right-bar-toggle">
                            <!-- Notification -->
                            <div class="notification-box"  style="cursor: pointer;">
                                <ul class="list-inline m-b-0">
                                    <li>
                                        <a onclick="showAlerts()" class="right-bar-toggle">
                                            <i class="fa fa-bell-o"></i>
                                        </a>

                                        <div class="noti-dot">
                                            <span class="dot"></span>
                                            <span class="pulse"><span class="count-notif"><?= $nbAlerts ?></span></span>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                            <!-- End Notification bar -->
                        </li>
                    <?php }    }?>



                <li class="dropdown user-box">
                    <a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown"
                       aria-expanded="true">

                        <?php
                        $picture = $this->Session->read('Auth.User.picture');
                        if (isset($picture) && !empty($picture)) {
                            echo $this->Html->image('users/' . $this->Session->read('Auth.User.picture'),
                                array(
                                    'alt' => "user-img",
                                    'class' => "img-circle user-img",
                                ));
                        } else {
                            if(Configure::read("parc_master") == '1'){
                                echo $this->Html->image('logo_parc_master.gif',
                                    array(
                                        'alt' => "user-img",
                                        'class' => "img-circle user-img parc-master-user",
                                    ));
                            }elseif(Configure::read("logistia") == '1'){
                                echo $this->Html->image('logo_logistia.png',
                                    array(
                                        'alt' => "user-img",
                                        'class' => "img-circle user-img",
                                    ));
                            }elseif(Configure::read("engin") == '1'){
                            echo $this->Html->image('logo_engines.png',
                                array(
                                    'alt' => "user-img",
                                    'class' => "img-circle user-img",
                                ));
                        }else {
                            echo $this->Html->image('logo_utranx.png',
                                array(
                                    'alt' => "user-img",
                                    'class' => "img-circle user-img",
                                ));
                        }
                        } ?>
                        <?php
                        if (Configure::read('parc_master') != '1' && Configure::read('logistia') != '1' ){
                        ?>
                        <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                        <?php } ?>
                    </a>

                    <ul class="dropdownmenu">
                        <li>
                            <div class="user-name">
                                <?= $this->Session->read('Auth.User.first_name') . " " . $this->Session->read('Auth.User.last_name'); ?>
                            </div>
                        </li>
                        <?php if (($this->Session->read('Auth.User.role_id') == 3) ||
                            ($this->Session->read('Auth.User.profile_id') == 1)
                        ) {
                            ?>

                            <li>
                                <?= $this->Html->link(
                                    '<i class="ti-lock m-r-5"></i>' . __("Users"),
                                    array('controller' => 'users', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>

                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="ti-user m-r-5"></i>' . __("Profiles"),
                                    array('controller' => 'profiles', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>


                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="ti-settings m-r-5"></i>' . __("Parameters"),
                                    array('controller' => 'parameters', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>


                            </li>

                        <?php }else{ ?>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="ti-user m-r-5"></i>' . __("Profile"),
                                    array(
                                            'controller' => 'users',
                                        'action' => 'edit',
                                        $this->Session->read('Auth.User.id')),
                                    array('escape' => false)
                                ); ?>


                            </li>
                        <?php } ?>

                        <li>
                            <?= $this->Html->link(
                                '<i class="ti-power-off m-r-5"></i>' . __("Logout"),
                                array('controller' => 'users', 'action' => 'logout'),
                                array('escape' => false)
                            ); ?>

                        </li>
                    </ul>
                </li>

            </ul>
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>
    </div>
</header>
<!-- End Navigation Bar-->

<div class="container-fluid" id="container-fluid" name="container-fluid">
    <?php  if(Configure::read("transport_personnel") == '1' &&
    $this->request->params['action'] =='personalTransportDashboard'
    ){ ?>
    <div class="side-menu-fixed" style="display: block; width: 400px ;">
    <?php } else { ?>
    <div class="side-menu-fixed slide-menu">
    <?php } ?>

        <div class="scrollarea scrollbar side-menu-bg container-green container-white">
            <div class="scrollarea-content saidbar">

                <?php
                if(Configure::read("transport_personnel") == '1' &&
                    $this->request->params['action'] =='personalTransportDashboard'
                ){
                    echo  $this->element('menu_customer_personal_transport');
                }else {
                    if (Configure::read("gestion_commercial") == '1') {
                        echo  $this->element('menu_utranx');
                    }else {
                        echo  $this->element('menu_fms');
                    }
                }

                ?>
            </div>

        </div>
    </div>
    <div class="wrapper">
        <div class="container" id="container" name="container">
            <div id="content"  name="content">

                <?php echo $this->Flash->render(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>


        </div>
        <!-- end container -->


        <!-- ./wrapper -->
        <?php if ($profileId != ProfilesEnum::client) { ?>
        <!-- Right Sidebar -->
            <div id ='alerts'>
            </div>


        <?php } ?>


        <div id="notifications">


        </div>

        <div id ='complaint-notifications'>

        </div>

    </div>
    <!-- Footer -->
    <footer class="footer text-right" style="text-align: center">
        <div class="container">
            <div class="row">
                <div>
				<?php if(Configure::read("gestion_commercial") == '1') {
                if(Configure::read("engin") == '1') { ?>
                    <p><a class="aiparc" href="#"
                          target="_blank"> Engines Soft </a> v 2.7.0.2 Copyright &nbsp;&copy;
                        2015 -
                        2022&nbsp&nbsp;

                    </p>
                <?php  }else {
                if(Configure::read("transport_personnel") == '1') {
                    ?>

                    <p><a class="aiparc" href=""
                          target="_blank"> GARMIN </a> v 2.7.0.2 Copyright &nbsp;&copy;
                        2015 -
                        2022&nbsp&nbsp;

                    </p>

                    <?php
                }elseif(Configure::read("djazfleet") == '1') {
                        ?>

                        <p><a class="aiparc" href=""
                              target="_blank" > Djazfleet gestion de parc  </a> v 2.7.0.2 Copyright &nbsp;&copy;
                            2015 -
                            2022&nbsp&nbsp;

                        </p>

                        <?php
                    }elseif(Configure::read("logistia") == '1') {
                    ?>

                    <p><a class="aiparc" href=""
                          target="_blank" style="color:#053369!important;"> LOGISTIA  </a> v 2.7.0.2 Copyright &nbsp;&copy;
                        2015 -
                        2022&nbsp&nbsp;
                    </p>

                    <?php
                }else { ?>

                    <p><a class="aiparc" href="#"
                          target="_blank"> UtranX </a> v 2.7.0.2 Copyright &nbsp;&copy;
                        2015 -
                        2022&nbsp&nbsp;

                    </p>

               <?php }

                }
				    ?>

				<?php } else { ?>
				 <p><a class="aiparc" href="#"
                          target="_blank"> UtranX </a> 2.7.0.2 Copyright &nbsp;&copy;
                        2015 -
                        2022&nbsp&nbsp;

                    </p>
				 <?php } ?>
                </div>

            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <?php
    echo $this->Html->script('jquery.app'); ?>

    <script>
        var elem = document.documentElement;
        jQuery("#btnFullscreen").click(function () {

            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { /* Firefox */
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE/Edge */
                elem.msRequestFullscreen();
            }
        });
        function showAlerts() {
            closeRightBar();
            jQuery('#notifications').load('<?php echo $this->Html->url('/alerts/getAlerts')?>', function () {
            });
        }


        function showNotifications() {

            closeRightBar();
            jQuery('#notifications').load('<?php echo $this->Html->url('/notifications/getNotificationsByUser')?>');
        }
        function showComplaintNotifications() {
            closeRightBar();
            jQuery('#notifications').load('<?php echo $this->Html->url('/notifications/getComplaintNotificationsByUser')?>');
        }

        function closeRightBar(){
            $(".right-bar").toggle();
            $('.wrapper').toggleClass('right-bar-enabled');
        }
    </script>


    <div id="dialogModalPayments">
        <div id="contentWrapPayment"></div>
    </div>

</body>
</html>
