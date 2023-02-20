<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>
<style>

    .tab-content #tab1 .active, .tab-content #tab2 .active, .tab-content #tab3 .active, .tab-content #tab4 .active, .tab-content #tab5 .active, .tab-content #tab6 .active, .tab-content #tab7 .active, .tab-content #tab_5 .active, .tab-content #tab_1 .active, .tab-content #tab_3 .active, .tab-content #tab_6 .active, .tab-content #tab_8 .active, .tab-content #tab_9 .active {
        display: block;
    }

    .icheckbox_minimal {
        float: right;
        margin-right: 35px;
    }

    #ParameterVariouseditForm label {
        float: none;
    }

    #ParameterHiddeninformationForm label {
        float: none;
    }

    div[class*='col-'] {
        padding: 0 30px;
    }

    .wrap {
        box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.2), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
        border-radius: 4px;
    }

    a:focus,
    a:hover,
    a:active {
        outline: 0;
        text-decoration: none;
    }

    .panel {
        border-width: 0 0 1px 0;
        border-style: solid;
        border-color: #fff;
        background: none;
        box-shadow: none;
    }

    .panel:last-child {
        border-bottom: none;
    }

    .panel-group > .panel:first-child .panel-heading {
        border-radius: 4px 4px 0 0;
    }

    .panel-group .panel {
        border-radius: 0;
    }

    .panel-group .panel + .panel {
        margin-top: 0;
    }

    .panel-heading {
        background-color: #435966;
        border-radius: 0;
        border: none;
        color: #fff;
        padding: 0;
    }

    .panel-title a {
        display: block;
        color: #fff;
        padding: 15px;
        position: relative;
        font-size: 16px;
        font-weight: 400;
    }

    .panel-body {
        background: #fff;
    }

    .panel:last-child .panel-body {
        border-radius: 0 0 4px 4px;
    }

    .panel:last-child .panel-heading {
        border-radius: 0 0 4px 4px;
        transition: border-radius 0.3s linear 0.2s;
    }

    .panel:last-child .panel-heading.active {
        border-radius: 0;
        transition: border-radius linear 0s;
    }

    .panel-heading a:before {
        font-family: FontAwesome;
        content: '\f107';
        position: absolute;
        right: 5px;
        top: 10px;
        font-size: 24px;
        transition: all 0.5s;
        transform: scale(1);
    }

    .panel-heading.active a:before {
        content: '';
        transition: all 0.5s;
        transform: scale(0);
    }

    #bs-collapse .panel-heading a:after, #bs-collapse2 .panel-heading a:after, #bs-collapse3 .panel-heading a:after {
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        position: absolute;
        right: 5px;
        top: 10px;
        transform: scale(0);
        transition: all 0.5s;
    }

    #bs-collapse .panel-heading.active a:after, #bs-collapse2 .panel-heading.active a:after, #bs-collapse3 .panel-heading.active a:after {
        content: '\f106';
        transform: scale(1);
        transition: all 0.5s;
    }

    #ParameterParameterCarForm label, #ParameterParameterConductorForm label, 
	#ParameterParameterAffectationForm label, #ParameterParameterClientForm label,
	#ParameterParameterSupplierForm label,
    #ParameterParameterCustomerForm label, #ParameterParameterReservationForm label,
    #ParameterParameterEventForm label, #ParameterParameterTransportForm label,
	#ParameterParameterBillForm label, 
	#ParameterParameterPrintingForm label ,
	#ParameterParameterVariousForm label
    {
        width: 190px;
        float: left;
        margin-top: 5px;
    }

    #ParameterParameterConsumptionForm label {
        width: 450px;
        float: left;
        margin-top: 5px;
    }

    #twoconsumption label {
        float: none;
    }

    #threeconsumption label {
        width: 310px;
    }

    #threeconsumption input.form-control {
        width: 340px;
        display: inline;
    }

    #threeconsumption .form-group {
        max-width: 660px;
    }

    .input-inline {
        float: left;
        margin-right: 40px;
        margin-bottom: 15px;
    }

    #ParameterEditForm .form-control {
        width: 90%;
    }

    #ParameterEditForm .lab1 {
        width: 250px;
    }

    #ParameterEditForm .lab {
        display: inline-flex;

        margin-left: 64%;
        margin-top: 30px;
        font-weight: normal;
        position: absolute;
    }

    #MissionCost label {
        width: 350px;
        float: left;
        margin-top: 5px;

    }

</style>
<?php

include("ctp/script.ctp");
?><h4 class="page-title"> <?= __('Parameters'); ?></h4>
<div class="box-body card-box p-b-0">
    <div class="nav-tabs-custom pdg_btm">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General') ?></a></li>
            <li><a href="#tab_2" data-toggle="tab"><?= __('Entreprise') ?></a></li>
            <li><a href="#tab_3" data-toggle="tab"><?= __('Alerts') ?></a></li>

            <li><a href="#tab_4" data-toggle="tab"><?= __('Car') ?></a></li>
            <li><a href="#tab_5" data-toggle="tab"><?= __('Conductor') ?></a></li>
            <li><a href="#tab_6" data-toggle="tab"><?= __('Client') ?></a></li>
            <li><a href="#tab_7" data-toggle="tab"><?= __('Supplier') ?></a></li>
            <li><a href="#tab_8" data-toggle="tab"><?= __('Affectation') ?></a></li>

            <li><a href="#tab_9" data-toggle="tab"><?= __('Consumption') ?></a></li>
            <li><a href="#tab_10" data-toggle="tab"><?= __('Event') ?></a></li>
            <li><a href="#tab_11" data-toggle="tab"><?= __('Procurement') ?></a></li>
            <li><a href="#tab_12" data-toggle="tab"><?= __('Stock') ?></a></li>

			<?php if(Configure::read("gestion_commercial") == '1') { ?>
				<li><a href="#tab_13" data-toggle="tab"><?= __('Transport') ?></a></li>

				<li><a href="#tab_14" data-toggle="tab"><?= __('Sales') ?></a></li>
            <?php } ?>
            <li><a href="#tab_15" data-toggle="tab"><?= __('Various') ?></a></li>
            
            <li><a href="#tab_16" data-toggle="tab"><?= __('Printing').' / '.__('Synchronization') ?></a></li>

            <li><a href="#tab_17" data-toggle="tab"><?= __('Database') ?></a></li>

            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'gedit'
                    )
                )); ?>
                <div class="box-body">
                    <br/>
                    <?php
                    echo "<div class='form-group'>" . $this->Form->input('country', array(
                            'label' => __('Country'),
                            'class' => 'form-control',
                            'default' => $selectedCountry
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('language', array(
                            'label' => __('Language'),
                            'class' => 'form-control',
                            'default' => $selectedLanguage
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('currency', array(
                            'label' => __('Currency'),
                            'class' => 'form-control',
                            'default' => $selectedCurrency
                        )) . "</div>";
                    ?>
                    <br/>

                    <div class="box-footer">
                        <?php echo $this->Form->submit(__('Submit'), array(
                            'name' => 'ok',
                            'class' => 'btn btn-primary btn-bordred  m-b-5',
                            'label' => __('Submit'),
                            'type' => 'submit',
                            'div' => false
                        )); ?>
                        <?php echo $this->Form->submit(__('Cancel'), array(
                            'name' => 'cancel',
                            'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                            'label' => __('Cancel'),
                            'type' => 'submit',
                            'div' => false,
                            'formnovalidate' => true
                        )); ?>
                    </div>
                </div>
                <?php
                echo $this->Form->end(); ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <?php


                $taxInformations = array(
                    3 => array(
                        "RC",
                        "NIF",
                        "AI",
						"NIS"
                    ),
                    31 => array(
                        "RC",
                        "IF",
                        "Patente",
                        "SS",
                        "ICE",
                    )
                );
                //Use array constant in PHP by using JSON decode

                echo $this->Form->create('Company', array(
                    'url' => array(
                        'controller' => 'companies',
                        'action' => 'edit'
                    ),
                    'enctype' => 'multipart/form-data'
                )); ?>
                <div class="box-body">
                    <br/>
                    <?php
                    echo $this->Form->input('id');
                    echo "<div class='form-group'>" . $this->Form->input('name', array(
                            'label' => __('Name'),
                            'value' => Configure::read("nameCompany"),
                            'readonly' => true,
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('category_company', array(
                            'label' => __('Category'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('adress', array(
                            'label' => __('Address'),
                            'class' => 'form-control',
                            'id' => "addresspicker"
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('latlng', array(
                            'type' => 'hidden',
                            'id' => "latlng"
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('wilaya', array(
                            'label' => __('Wilaya'),
                            'options' => $destinations,
                            'type' => 'select',
                            'empty' => '',
                            'class' => 'form-control select2',
                        )) . "</div>"; ?>
                    <div id="map" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>

                    <?php   echo "<div class='form-group'>" . $this->Form->input('phone', array(
                            'label' => __('Phone'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('fax', array(
                            'label' => __('Fax'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('mobile', array(
                            'label' => __('Mobile'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('email', array(
                            'label' => __('Email'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('site_web', array(
                            'label' => __('Site Web'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('legal_form_id', array(
                            'label' => __('Legal form'),
                            'class' => 'form-control select2',
                            'empty' => ''
                        )) . "</div>";

						if(!empty($taxInformations)){
						 echo "<div class='form-group'>" . $this->Form->input('rc', array(
                            'label' => isset($taxInformations[$selectedCountry][0]) ? $taxInformations[$selectedCountry][0] : 'RC',
                            'class' => 'form-control',
                        )) . "</div>";
						echo "<div class='form-group'>" . $this->Form->input('nif', array(
                            'label' => isset($taxInformations[$selectedCountry][1]) ? $taxInformations[$selectedCountry][1] : 'NIF',
                            'class' => 'form-control',
                        )) . "</div>";
						echo "<div class='form-group'>" . $this->Form->input('ai', array(
                            'label' => isset($taxInformations[$selectedCountry][2]) ? $taxInformations[$selectedCountry][2] : 'AI',
                            'class' => 'form-control',
                        )) . "</div>"; 
						echo "<div class='form-group'>" . $this->Form->input('nis', array(
                            'label' => isset($taxInformations[$selectedCountry][3]) ? $taxInformations[$selectedCountry][3] : 'Nis',
                            'class' => 'form-control',
                        )) . "</div>";
						}else {
					echo "<div class='form-group'>" . $this->Form->input('rc', array(
                            'label' => __('RC'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('nif', array(
                            'label' => __('NIF'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('ai', array(
                            'label' => __('AI'),
                            'class' => 'form-control',
                        )) . "</div>"; 
						
					echo "<div class='form-group'>" . $this->Form->input('nis', array(
                            'label' =>__('NIS'),
                            'class' => 'form-control',
                        )) . "</div>";
							
						}
                

                    echo "<div class='form-group'>" . $this->Form->input('social_capital', array(
                            'label' => __('Social capital'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('cb', array(
                            'label' => __('CB'),
                            'class' => 'form-control',
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('rib', array(
                            'label' => __('RIB'),
                            'class' => 'form-control',
                        )) . "</div>";

                    echo "<div class='form-group'>" . $this->Form->input('logo', array(
                            'label' => __('Logo'),
                            'class' => 'form-control',
                            'type' => 'file',
                            'empty' => ''
                        )) . "</div>";

                    echo "<div class='form-group'>" . $this->Form->input('stamp_image', array(
                            'label' => __('Stamp image'),
                            'class' => 'form-control',
                            'type' => 'file',
                            'empty' => ''
                        )) . "</div>";
                    ?>
                    <div class="box-footer">
                        <?php echo $this->Form->submit(__('Submit'), array(
                            'name' => 'ok',
                            'class' => 'btn btn-primary btn-bordred  m-b-5',
                            'label' => __('Submit'),
                            'type' => 'submit',
                            'div' => false
                        )); ?>
                        <?php echo $this->Form->submit(__('Cancel'), array(
                            'name' => 'cancel',
                            'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                            'label' => __('Cancel'),
                            'type' => 'submit',
                            'div' => false,
                            'formnovalidate' => true
                        )); ?>
                    </div>
                    <?php
                    echo $this->Form->end(); ?>
                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'edit'
                    )
                )); ?>
                <div class="box-body">
                    <br/>
                    <?php

                    for ($i = 1; $i <= 3; $i++) {
// Afficher les trois premières alertes avec date (Assurance, Contrôle technique, Vignette)
                        echo $this->Form->input('Parameter.' . $i . '.id');
                        echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                                'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Days') . "</div>",
                                'class' => 'form-control',

                            )) . "</div>";

                    }
                    $i = 4;
                    // Afficher Vidange
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Km') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";
                    $i = 24;
                    // Afficher Vidange engins
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Hours') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";
                    $i = 5;
                    // Afficher Expiration permis de conduire
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Days') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";


                    $i = 6;
                    // Afficher Avec date
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Days') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";
                    $i = 7;
                    // Afficher Avec km
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Km') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";
                    $i = 13;
                    // Afficher Limite mensuelle de consommation
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Km') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";

                    $i = 15;
                    // Afficher Nombre minimum de bons
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Coupon') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";

                    $i = 21;
                    // Afficher Km restant au contrat
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Km') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";

                    $i = 22;
                    // Afficher Contrat véhicule
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" . "<div class='lab'>" . __('Days') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";

                    $i = 26;
                    // Afficher amortissement
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" .
                                "<div class='lab'>" . __('Km') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";

                    $i = 27;
                    // Afficher parametre echeance
                    echo $this->Form->input('Parameter.' . $i . '.id');
                    echo "<div class='form-group'>" . $this->Form->input('Parameter.' . $i . '.val', array(
                            'label' => "<div class='lab1'>" . $this->request->data['Parameter'][$i]['name'] . "</div>" .
                                "<div class='lab'>" . __('Day') . "</div>",
                            'class' => 'form-control',

                        )) . "</div>";
                    ?>
                    <div class="box-footer">
                        <?php echo $this->Form->submit(__('Submit'), array(
                            'name' => 'ok',
                            'class' => 'btn btn-primary btn-bordred  m-b-5',
                            'label' => __('Submit'),
                            'type' => 'submit',
                            'div' => false
                        )); ?>
                        <?php echo $this->Form->submit(__('Cancel'), array(
                            'name' => 'cancel',
                            'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                            'label' => __('Cancel'),
                            'type' => 'submit',
                            'div' => false,
                            'formnovalidate' => true
                        )); ?>
                    </div>
                    <?php
                    echo $this->Form->end(); ?>
                </div>
                <!-- /.tab-pane -->
            </div>


            <div class="tab-pane" id="tab_4">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterCar'
                    )
                )); ?>
                <br/><br/>


                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#one">
                                            <?php echo __('Codification'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="one" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php    if ($this->request->data['Parameter']['auto_car'] == false) $selected = 0; else $selected = 1;
                                        echo "<div class='form-group '>" . $this->Form->input('auto_car', array(
                                                'label' => __('automatic'),
                                                'type' => 'select',
                                                'options' => array('0' => __('No'), '1' => __('Yes')),
                                                'class' => 'form-size',
                                                'selected' => $selected,
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('sizes_car', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('param_car', array(
                                                'label' => __('Name cars'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Code'), '2' => __('Immatriculation')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#two">
                                            <?php echo __('Leasing') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="two" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('year_contract', array(
                                                'label' => __('Year contract'),
                                                'placeholder' => __('Enter year contract'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";



                                        ?>
                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>


            </div>


            <div class="tab-pane" id="tab_5">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterConductor'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse2">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneconductor">
                                            <?php echo __('Codification'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneconductor" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php    if ($this->request->data['Parameter']['auto_conductor'] == false) $selected = 0; else $selected = 1;
                                        echo "<div class='form-group '>" . $this->Form->input('auto_conductor', array(
                                                'label' => __('automatic'),
                                                'type' => 'select',
                                                'options' => array('0' => __('No'), '1' => __('Yes')),
                                                'class' => 'form-size',
                                                'selected' => $selected,
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('sizes_conductor', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";



                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->


                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#threeconductor">
                                            <?php echo __('Optional information') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="threeconductor" class="panel-collapse collapse">
                                    <div class="panel-body">


                                        <br>
                                        <h4><?= __('Check the fields to be hidden') ?></h4>
                                        <br/>
                                        <?php  echo "<div class='form-group audiv'>" . $this->Form->input('company', array(
                                                'label' => __('Company'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";
                                        echo "<div class='form-group audiv'>" . $this->Form->input('email3', array(
                                                'label' => __('Email 3'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";
                                        echo "<div class='form-group audiv'>" . $this->Form->input('job', array(
                                                'label' => __('Job'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('monthly_payroll', array(
                                                'label' => __('Monthly payroll'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";


                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('note', array(
                                                'label' => __('Note'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('declaration_date', array(
                                                'label' => __('Declaration date'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('affiliate', array(
                                                'label' => __('Affiliate'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('ccp', array(
                                                'label' => __('N&ordm; CCP'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('bank_account', array(
                                                'label' => __('N&ordm; bank account'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";

                                        echo "<div class='form-group audiv'>" . $this->Form->input('identity_card', array(
                                                'label' => __('Identity card'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";
                                        echo "<div class='form-group audiv'>" . $this->Form->input('passport', array(
                                                'label' => __('Passport'),
                                                'class' => 'autochek',
                                            )) . "</div>";

                                        echo "</br>";


                                        echo "</br>";
                                        ?>


                                    </div>
                                </div>
                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>


            </div>
            <div class="tab-pane" id="tab_6">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterClient'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneaffectation">
                                            <?php echo __('Codification client initial'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php  echo "<div class='form-group '>" . $this->Form->input('reference_auto_client_initial', array(
                                                'label' => __('Automatic reference'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_sizes_client_initial', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_client_initial', array(
                                                'label' => __('Préfixe'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_client_initial', array(
                                                'label' => __('Next number').' '. __('client initial') ,
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";





                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoaffectation">
                                            <?php echo __('Codification client final') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoaffectation" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php

                                        echo "<div class='form-group '>" . $this->Form->input('reference_auto_client_final', array(
                                                'label' => __('Automatic reference'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_sizes_client_final', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_client_final', array(
                                                'label' => __('Préfixe'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_client_final', array(
                                                'label' => __('Next number').' '. __('client final') ,
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>

            <div class="tab-pane" id="tab_7">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterSupplier'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneaffectation">
                                            <?php echo __('Codification'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php  echo "<div class='form-group '>" . $this->Form->input('reference_auto_supplier', array(
                                                'label' => __('Automatic reference'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_sizes_supplier', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_supplier', array(
                                                'label' => __('Préfixe'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_supplier', array(
                                                'label' => __('Next number').' '. __('Supplier') ,
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";





                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>


            <div class="tab-pane" id="tab_8">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterAffectation'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneaffectation">
                                            <?php echo __('Codification'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php  echo "<div class='form-group '>" . $this->Form->input('reference_auto_affectation', array(
                                                'label' => __('Automatic reference'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_sizes_affectation', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('date_suffixe_affectation', array(
                                                'label' => __('Use date in'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Prefix'), '2' => __('Suffix')),
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_affectation', array(
                                                'label' => __('Reference'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";





                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoaffectation">
                                            <?php echo __('Affectation mode') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoaffectation" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php

                                        echo "<div class='form-group '>" . $this->Form->input('affectation_mode', array(
                                                'label' => __('Affectation mode'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Short duration'), '2' => __('Long duration')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>


            <div class="tab-pane" id="tab_9">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterConsumption'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">


                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoconsumption">
                                            <?php echo __('Various') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoconsumption" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <br/>
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('param_coupon', array(
                                                'label' => __('Use bar code'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group '>" . $this->Form->input('fuellog_coupon', array(
                                                'label' => __('Use of fuellog'),
                                                'type' => 'select',
                                                'options' => array('1' => __('By fuellog'), '2' => __('By coupon')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('select_coupon', array(
                                                'label' => __('Select coupon'),
                                                'type' => 'select',
                                                'options' => array('1' => __('One by one'), '2' => __('From number to other')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group'>" . $this->Form->input('automatic_card_assignment', array(
                                                'label' => __('Automatic card assignment'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('balance_car', array(
                                                'label' => __('Use of balance car'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('tank_spacies', array(
                                                'label' => __('Utilisation de la citèrne par espèce'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group '>" . $this->Form->input('departure_tank_state', array(
                                                'label' => __('Departure tank'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Full tank'), '2' => __('Tank of the previous mission'), '3' => __('Real tank')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('arrival_tank_state', array(
                                                'label' => __('Arrival tank'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Full tank'), '2' => __('Real tank'), '3' => __('Full at the park')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('take_account_departure_tank', array(
                                                'label' => __('Take into account tank state when estimate'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group '>" . $this->Form->input('card_amount_verification', array(
                                                'label' => __('Card amount verification'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        $options = array(
                                            '1' => __('Coupons'),
                                            '2' => __('Species'),
                                            '3' => __('Tank'),
                                            '4' => __('Cards')
                                        );

                                        echo "<div class='form-group '>" . $this->Form->input('default_consumption_method', array(
                                                'label' => __('Default consumption method'),
                                                'type' => 'select',
                                                'options' =>  $options,
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('is_sheet_ride_required_for_consumption', array(
                                                'label' => __('Sheet ride required'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Consumption management') . "</div>";
                                        echo "<div class='form-group audiv2'>" . $this->Form->input('consumption_coupon', array(
                                                'label' => __('Consumption coupon'),
                                                'id' => 'coupon',
                                                'class' => 'id',
                                            )) . "</div>";
                                        echo "<div class='form-group audiv2'>" . $this->Form->input('consumption_spacies', array(
                                                'label' => __('Consumption spacies'),
                                                'id' => 'spacies',
                                                'class' => 'id',
                                            )) . "</div>";
                                        echo "<div class='form-group audiv2'>" . $this->Form->input('consumption_tank', array(
                                                'label' => __('Consumption tank'),
                                                'id' => 'tank',
                                                'class' => 'id',
                                            )) . "</div>";

                                        echo "<div class='form-group audiv2'>" . $this->Form->input('consumption_card', array(
                                                'label' => __('Consumption card'),
                                                'id' => 'card',
                                                'class' => 'id',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('use_priority', array(
                                                'label' => __('Use priority'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'id' => 'use_priority',
                                                'empty' => ''
                                            )) . "</div>"; ?>

                                        <div id="priority_div">
                                            <?php echo "<div class='form-group ' style='font-weight: bold;'>" . __('Priority') . "</div>"; ?>
                                            <div class='col-sm-4'>
                                                <table class="table table-bordered " id='tab'>
                                                    <?php  echo "<div class='form-group audiv2'>" . $this->Form->input('priority', array(
                                                            'label' => __('priority'),
                                                            'id' => 'priority',
                                                            'type' => 'hidden',
                                                        )) . "</div>";


                                                    $options = array('1' => __('Tanks'), '2' => __('Coupons'), '3' => __('Species'), '4' => __('Cards'));
                                                    $priority = explode(',', $this->request->data['Parameter']['priority']);

                                                    $length = count($priority);

                                                    for ($i = 0; $i < $length; $i++) {
                                                        ?>

                                                        <tr id='<?php echo $priority[$i] ?>' class='tr_cons'>
                                                            <td><?php echo $options[$priority[$i]] ?>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="up"><i
                                                                        class="fa fa-chevron-circle-up"></i></a>

                                                            </td>
                                                            <td>
                                                                <a href="#" class="down"><i
                                                                        class="fa fa-chevron-circle-down"></i></a>
                                                            </td>
                                                        </tr>

                                                    <?php } ?>


                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#threeconsumption">
                                            <?php echo __('Consumption') . ' / ' . __('Coupon') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="threeconsumption" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <br/>
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('coupon_price', array(
                                                'label' => "<div class='lab1'>" . __('Coupon price') . "</div>" . "<div class='lab-currency'>" . $this->Session->read("currency") . "</div>",
                                                'placeholder' => __('Enter coupon price'),
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('difference_allowed', array(
                                                'label' => "<div class='lab1'>" . __('Difference allowed') . "</div>" . "<div class='lab-currency'>" . __('L/100Km') . "</div>",
                                                'placeholder' => __('Enter difference allowed'),
                                                'class' => 'form-control',
                                            )) . "</div>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>


            <div class="tab-pane" id="tab_10">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterEvent'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneevent">
                                            <?php echo __('Codification'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneevent" class="panel-collapse collapse in">
                                <!--    <div class="panel-body">
                                        <?php  echo "<div class='form-group '>" . $this->Form->input('reference_auto_event', array(
                                                'label' => __('Automatic reference'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_sizes_event', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('date_suffixe_event', array(
                                                'label' => __('Use date in'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Prefix'), '2' => __('Suffix')),
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group '>" . $this->Form->input('reference_event', array(
                                                'label' => __('Reference'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";





                                        ?>
                                    </div>-->


                                    <div class="panel-body">
                                        <?php

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_auto_event', array(
                                                'label' => __('Events'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_auto_intervention_request', array(
                                                'label' => __('Intervention requests'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group '>" . $this->Form->input('reference_sizes_event', array(
                                                'label' => __('Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='input-inline'>" . $this->Form->input('date_suffix_event', array(
                                                'label' => __('Use date in'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Prefix'), '2' => __('Suffix')),
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('abbreviation_location_event', array(
                                                'label' => __('Abbreviation'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Before date'), '2' => __('After date')),
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Use Type of files') . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('event', array(
                                                'label' => __('Events'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('intervention_request', array(
                                                'label' => __('Intervention requests'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";




                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Next number') . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_event', array(
                                                'label' => __('Events'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_intervention_request', array(
                                                'label' => __('Intervention requests'),
                                                'class' => 'form-size',
                                                'id' => 'devis',
                                                'empty' => ''
                                            )) . "</div>";


                                        ?>
                                    </div>


                                </div>

                            </div>
                            <!-- end of panel -->





                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>
			
			   <div class="tab-pane" id="tab_11">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'parameterProcurement'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneTransport">
                                            <?php echo __('Automatic reference'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneTransport" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_pr_auto', array(
                                                'label' => __('Product requests'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_ar_auto', array(
                                                'label' => __('Purchase requests'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

											


                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Use Type of files') . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('product_request', array(
                                                'label' => __('Product requests'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('purchase_request', array(
                                                'label' => __('Purchase requests'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";




                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Next number') . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_product_request', array(
                                                'label' => __('Product requests'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_purchase_request', array(
                                                'label' => __('Purchase requests'),
                                                'class' => 'form-size',
                                                'id' => 'devis',
                                                'empty' => ''
                                            )) . "</div>";


                                        ?>
                                    </div>

                                </div>

                            </div>
                            <!-- end of panel -->



                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>

           <div class="tab-pane" id="tab_12">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'parameterBill'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneTransport">
                                            <?php echo __('Automatic reference'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneTransport" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_so_auto', array(
                                                'label' => __('Supplier orders'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_re_auto', array(
                                                'label' => __('Receipts'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='input-inline'>" . $this->Form->input('reference_rs_auto', array(
                                                'label' => __('Return supplier'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_pi_auto', array(
                                                'label' => __('Purchase invoice'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_cn_auto', array(
                                                'label' => __('Credit note'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_do_auto', array(
                                                'label' => __('Delivery orders'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_rc_auto', array(
                                                'label' => __('Return customer'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


											echo "<div class='input-inline'>" . $this->Form->input('reference_eo_auto', array(
                                                'label' => __('Entry order'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


											echo "<div class='input-inline'>" . $this->Form->input('reference_xo_auto', array(
                                                'label' => __('Exit order'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

											echo "<div class='input-inline'>" . $this->Form->input('reference_ro_auto', array(
                                                'label' => __('Renvoi order'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


											echo "<div class='input-inline'>" . $this->Form->input('reference_ri_auto', array(
                                                'label' => __('Reintegration order'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

											echo "<div class='input-inline'>" . $this->Form->input('reference_tr_auto', array(
                                                'label' => __('Transfer receipt'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";




                                        echo "<div class='input-inline'>" . $this->Form->input('reference_bill_sizes', array(
                                                'label' => __('Reference Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('date_bill_suffixe', array(
                                                'label' => __('Use date in'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Prefix'), '2' => __('Suffix')),
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('abbreviation_bill_location', array(
                                                'label' => __('Abbreviation'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Before date'), '2' => __('After date')),
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Use Type of files') . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('supplier_order', array(
                                                'label' => __('Supplier orders'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('receipt', array(
                                                'label' => __('Receipts'),
                                                'class' => 'form-size',
                                                'id' => 'devis',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('return_supplier', array(
                                                'label' => __('Return supplier'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('purchase_invoice', array(
                                                'label' => __('Purchase invoice'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('credit_note', array(
                                                'label' => __('Credit note'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('delivery_order', array(
                                                'label' => __('Delivery orders'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('return_customer', array(
                                                'label' => __('Return customer'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('entry_order', array(
                                                'label' => __('Entry order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('exit_order', array(
                                                'label' => __('Exit order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('renvoi_order', array(
                                                'label' => __('Renvoi order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('reintegration_order', array(
                                                'label' => __('Reintegration order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
										echo "<div class='input-inline'>" . $this->Form->input('transfer_receipt', array(
                                                'label' => __('Transfer receipt'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Next number') . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_supplier_order', array(
                                                'label' => __('Supplier orders'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_receipt', array(
                                                'label' => __('Receipts'),
                                                'class' => 'form-size',
                                                'id' => 'devis',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_return_supplier', array(
                                                'label' => __('Return supplier'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_purchase_invoice', array(
                                                'label' => __('Purchase invoice'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_credit_note', array(
                                                'label' => __('Credit note'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_delivery_order', array(
                                                'label' => __('Delivery orders'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_return_customer', array(
                                                'label' => __('Return customer'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_entry_order', array(
                                                'label' => __('Entry order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_exit_order', array(
                                                'label' => __('Exit order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_renvoi_order', array(
                                                'label' => __('Renvoi order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_reintegration_order', array(
                                                'label' => __('Reintegration order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_transfer_receipt', array(
                                                'label' => __('Transfer receipt'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoStock">
                                            <?php echo __('Products'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoStock" class="panel-collapse collapse ">
                                    <div class="panel-body">
                                        <?php

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_product_auto', array(
                                                'label' => __('Automatic reference'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('reference_product_sizes', array(
                                                'label' => __('Reference Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_product', array(
                                                'label' => __('Next number').' '. __('product') ,
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('is_multi_warehouses', array(
                                                'label' => __('Multi warehouses'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>




            <?php if(Configure::read("gestion_commercial") == '1'
					|| Configure::read("gestion_commercial_standard") == '1'
			) { ?>
			
            <div class="tab-pane" id="tab_13">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'parameterTransport'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneTransport">
                                            <?php echo __('Automatic reference'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneTransport" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php
										if(Configure::read("gestion_commercial") == '1' ) {
                                        echo "<div class='input-inline'>" . $this->Form->input('reference_dd_auto', array(
                                                'label' => __('Request quotation'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";
											}
                                        echo "<div class='input-inline'>" . $this->Form->input('reference_fp_auto', array(
                                                'label' => __('Quotation'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='input-inline'>" . $this->Form->input('reference_bc_auto', array(
                                                'label' => __('Customer order'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";
										if(Configure::read("gestion_commercial") == '1' ) {
                                        echo "<div class='input-inline'>" . $this->Form->input('reference_fr_auto', array(
                                                'label' => __('Sheet ride'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_mi_auto', array(
                                                'label' => __('Mission'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('reference_pf_auto', array(
                                                'label' => __('Preinvoice'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
											}
                                        echo "<div class='input-inline'>" . $this->Form->input('reference_fa_auto', array(
                                                'label' => __('Invoice'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";  

										echo "<div class='input-inline'>" . $this->Form->input('reference_av_auto', array(
                                                'label' => __('Sale credit note'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
										echo "<div class='input-inline'>" . $this->Form->input('reference_ds_auto', array(
                                                'label' => __('Dispatch slip'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='input-inline'>" . $this->Form->input('reference_sizes', array(
                                                'label' => __('Reference Size'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('date_suffixe', array(
                                                'label' => __('Use date in'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Prefix'), '2' => __('Suffix')),
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('abbreviation_location', array(
                                                'label' => __('Abbreviation'),
                                                'class' => 'form-size',
                                                'type' => 'select',
                                                'options' => array('1' => __('Before date'), '2' => __('After date')),
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Use Type of files') . "</div>";
                                        
										if(Configure::read("gestion_commercial") == '1' ) {
										echo "<div class='input-inline'>" . $this->Form->input('demande_devis', array(
                                                'label' => __('Request quotation'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        }
										
										echo "<div class='input-inline'>" . $this->Form->input('devis', array(
                                                'label' => __('Quotation'),
                                                'class' => 'form-size',
                                                'id' => 'devis',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('commande', array(
                                                'label' => __('Customer order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
											
										if(Configure::read("gestion_commercial") == '1' ) {	
                                        echo "<div class='input-inline'>" . $this->Form->input('feuille_route', array(
                                                'label' => __('Sheet ride'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('prefacture', array(
                                                'label' => __('Preinvoice'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
											
											}
                                        echo "<div class='input-inline'>" . $this->Form->input('facture', array(
                                                'label' => __('Invoice'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";     
											
										echo "<div class='input-inline'>" . $this->Form->input('avoir_vente', array(
                                                'label' => __('Sale credit note'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('bordereau_envoi', array(
                                                'label' => __('Dispatch slip'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group ' style='font-weight: bold;'>" . __('Next number') . "</div>";
                                        
										if(Configure::read("gestion_commercial") == '1' ) {
										echo "<div class='input-inline'>" . $this->Form->input('next_reference_demande_devis', array(
                                                'label' => __('Request quotation'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
											
											}
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_devis', array(
                                                'label' => __('Quotation'),
                                                'class' => 'form-size',
                                                'id' => 'devis',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_commande', array(
                                                'label' => __('Customer order'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
											
										if(Configure::read("gestion_commercial") == '1' ) {	
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_feuille_route', array(
                                                'label' => __('Sheet ride'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_prefacture', array(
                                                'label' => __('Preinvoice'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
											
											}
                                        echo "<div class='input-inline'>" . $this->Form->input('next_reference_facture', array(
                                                'label' => __('Invoice'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";  
											
										echo "<div class='input-inline'>" . $this->Form->input('next_reference_avoir_vente', array(
                                                'label' => __('Sale credit note'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

										echo "<div class='input-inline'>" . $this->Form->input('next_reference_bordereau_envoi', array(
                                                'label' => __('Dispatch slip'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

					<?php	if(Configure::read("gestion_commercial") == '1' ) {	?>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoTransport">
                                            <?php echo __('Commercial') . ' / ' . __('Price') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoTransport" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('type_ride', array(
                                                'label' => __('Type ride'),
                                                'type' => 'select',
                                                'options' => array( '1' => __('Existing ride'), '2' => __('Personalized ride'), '3' => __('Both')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('type_ride_used_first', array(
                                                'label' => __('Type ride used first'),
                                                'type' => 'select',
                                                'options' => array( '1' => __('Existing ride'), '2' => __('Personalized ride')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('synchronization_fr_bc', array(
                                                'label' => __('Synchronization between FR and BC'),
                                                'type' => 'select',
                                                'options' => array( '1' => __('Automatic'), '2' => __('Manual')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group'>" . $this->Form->input('nb_trucks_modifiable', array(
                                                'label' => __('Truck number modifiable'),
                                                'type' => 'select',
                                                'options' => array( '1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('default_nb_trucks', array(
                                                'label' => __('Default truck number'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group'>" . $this->Form->input('param_price_night', array(
                                                'label' => __('Use night pricing'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('type_pricing', array(
                                                'label' => __('Type of pricing'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Pricing by ride'), '2' => __('Pricing by distance'), '3' => __('Both')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('param_price', array(
                                                'label' => __('possibility of prepayment'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('separator_amount', array(
                                                'label' => __('Separator of amount'),
                                                'type' => 'select',
                                                'options' => array('1' => __(' '), '2' => __(','), '3' => __('.')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('transformation_closed_mission', array(
                                                'label' => __('Transformation closed mission'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Invoice'), '2' => __('Préfacture')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        ?>
                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#threeTransport">
                                            <?php echo __('Rides') . ' / ' . __('Mission costs') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="threeTransport" class="panel-collapse collapse">
                                    <div class="panel-body" id="MissionCost">
                                        <?php
                                        $options = array('1' => __('No'), '2' => __('Yes'));
                                        echo "<div class='form-group'>" . $this->Form->input('use_ride_category', array(
                                                'label' => __('Use ride category'),
                                                'class' => 'form-size',
                                                'options' => $options,
                                                'empty' => ''
                                            )) . "</div>";
                                        $options = array('1' => __('No'), '2' => __('Yes'));
                                        echo "<div class='form-group'>" . $this->Form->input('display_mission_cost', array(
                                                'label' => __('Display mission cost in sheet ride'),
                                                'class' => 'form-size',
                                                'options' => $options,
                                                'empty' => ''
                                            )) . "</div>";
                                        $options = array('1' => __('With day'), '2' => __('With mission'), '3' => __('With distance'));
                                        echo "<div class='form-group'>" . $this->Form->input('param_mission_cost', array(
                                                'label' => __('Management parameter of missions cost'),
                                                'class' => 'form-size',
                                                'onchange' => 'javascript : resetMissionCostParameter();',
                                                'options' => $options,
                                                'empty' => ''
                                            )) . "</div>";
                                        ?>
                                        <?php if (!empty($missionCostParameters)) { ?>
                                            <div id="mission_cost_div">
                                                <?php
                                                $i = 1;
                                                $nbMissionCostParameters = count($missionCostParameters);
                                                foreach ($missionCostParameters as $missionCostParameter) {
                                                    ?>
                                                    <div id='mission_cost_div<?php echo $i ?>'>
                                                        <?php
                                                        echo "<div class='form-group col-sm-6' style='padding: 0px;'>" . $this->Form->input('MissionCostParameter.' . $i . '.car_type_id', array(
                                                                'label' => __('Car type'),
                                                                'class' => 'form-size ',
                                                                'options' => $carTypes,
                                                                'id' => 'car_type' . $i,
                                                                'value' => $missionCostParameter['MissionCostParameter']['car_type_id'],
                                                                'onchange' => 'javascript : getMissionCostParameters(this.id)',
                                                                'empty' => ''
                                                            )) . "</div>"; ?>
                                                        <div id='div-button'>
                                                            <button style="margin-top: 5px; width: 40px" type='button'
                                                                    name='add'
                                                                    id='<?php echo $nbMissionCostParameters; ?>'
                                                                    onclick='addMissionCostParameterDiv(this.id)'
                                                                    class='btn btn-success'>+
                                                            </button>

                                                        </div>
                                                        <div id='mission_cost<?php echo $i ?>'>
                                                            <?php
                                                            switch ($this->request->data['Parameter']['param_mission_cost']) {
                                                                case 1 :
                                                                    echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.' . $i . '.mission_cost_day', array(
                                                                            'label' => __('Mission cost per day'),
                                                                            'class' => 'form-size',
                                                                            'value' => $missionCostParameter['MissionCostParameter']['mission_cost_day'],
                                                                            'empty' => ''
                                                                        )) . "</div>";
                                                                    break;
                                                                case 2:
                                                                    break;
                                                                case 3 :
                                                                    echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.' . $i . '.mission_cost_truck_full', array(
                                                                            'label' => __('Coefficient mission cost truck full'),
                                                                            'class' => 'form-size',
                                                                            'value' => $missionCostParameter['MissionCostParameter']['mission_cost_truck_full'],
                                                                            'empty' => ''
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group'>" . $this->Form->input('MissionCostParameter.' . $i . '.mission_cost_truck_empty', array(
                                                                            'label' => __('Coefficient mission cost truck empty'),
                                                                            'value' => $missionCostParameter['MissionCostParameter']['mission_cost_truck_empty'],
                                                                            'class' => 'form-size'
                                                                        )) . "</div>";
                                                                    break;
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>

                                                    <?php
                                                    $i++;
                                                }?>
                                            </div>

                                        <?php } else { ?>
                                            <div id="mission_cost_div">
                                                <?php
                                                echo "<div class='form-group col-sm-6' style='padding: 0px;'>" . $this->Form->input('MissionCostParameter.1.car_type_id', array(
                                                        'label' => __('Car type'),
                                                        'class' => 'form-size ',
                                                        'options' => $carTypes,
                                                        'id' => 'car_type1',
                                                        'onchange' => 'javascript : getMissionCostParameters(this.id)',
                                                        'empty' => ''
                                                    )) . "</div>";
                                                ?>
                                                <div id='div-button'>
                                                    <button style="margin-top: 5px; width: 40px" type='button'
                                                            name='add'
                                                            id='1'
                                                            onclick='addMissionCostParameterDiv(this.id)'
                                                            class='btn btn-success'>+
                                                    </button>

                                                </div>
                                                <div id='mission_cost1'>

                                                </div>
                                            </div>
                                        <?php } ?>


                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#forTransport">
                                            <?php echo __('Sheet rides') . ' / ' . __('Missions') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="forTransport" class="panel-collapse collapse">
                                    <div class="panel-body" id="Mission">
                                        <?php

                                        echo "<div class='form-group'>" . $this->Form->input('sheet_ride_name', array(
                                                'label' => __('Sheet ride name'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('sheet_ride_with_mission', array(
                                                'label' => __('Sheet ride with mission'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Several missions'), '2' => __('No mission'), '3' => __('One mission')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        $options = array(
                                                '1'=>__('Planned'),
                                                '2'=>__('Ongoing'),
                                                '3'=>__('Closed'),
                                                '4'=>__('Status by date'),

                                                    );
                                        echo "<div class='form-group'>" . $this->Form->input('default_status', array(
                                                'label' => __('Default status'),
                                                'type' => 'select',
                                                'options' => $options,
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('destination_required', array(
                                                'label' => __('Destination required'),
                                                'type' => 'select',
                                                'options' => array(1 => __('Yes'), 2 => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('calcul_by_maps', array(
                                                'label' => __('Calculation by maps'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('car_customer_out_park', array(
                                                'label' => __('Display of cars/ drivers out off-park'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('car_subcontracting', array(
                                                'label' => __('Add cars of subcontractors'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('subcontractor_cost_percentage', array(
                                                'label' => __('Percentage of subcontractor cost'),
                                                'type' => 'number',
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('marchandise_required', array(
                                                'label' => __('Marchandise required'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";


                                        echo "<div class='form-group'>" . $this->Form->input('use_purchase_bill', array(
                                                'label' => __('Purchases bills managment'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Yes'), '2' => __('No')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('loading_time', array(
                                                'label' => __('Loading time') . ' (' . __('Hour') . (')'),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('unloading_time', array(
                                                'label' => __('Unloading time') . ' (' . __('Hour') . (')'),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('maximum_driving_time', array(
                                                'label' => __('Maximum driving time') . ' (' . __('Hour') . (')'),
                                                'class' => 'form-size',

                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('break_time', array(
                                                'label' => __('Break time') . ' (' . __('Hour') . (')'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('additional_time_allowed', array(
                                                'label' => __('Additional time allowed') . ' (' . __('Hour') . (')'),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";




                                        ?>
                                    </div>

                                </div>
                            </div>
                            <!-- end of panel -->

					<?php		} ?>
							
                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>

           
		   
			<?php } ?>
            <div class="tab-pane" id="tab_15">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterVarious'
                    )
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">

                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneaffectation">
                                            <?php echo __('Payments'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php
                                        echo "<div class='form-group '>" . $this->Form->input('negative_account', array(
                                                'label' => __('Negative accounts'),
                                                'type' => 'select',
                                                'options' => array('1' => __('No'), '2' => __('Yes')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";






                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoaffectation">
                                            <?php echo __('Attachments'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php
                                        echo "<div class='form-group '>" . $this->Form->input('attachment_display_sheet_ride', array(
                                                'label' => __('Attachments to display in sheet ride'),
                                                'type' => 'select',
                                                'id'=> 'attachment_display_sheet_ride',
                                                'onchange'=>'javascript: getAttachmentTypes();',
                                                'options' => array(
                                                        '1' => __('Attachments in suppliers'),
                                                        '2' => __('Attachments in parameters')),
                                                'class' => 'form-size',
                                                'empty' => ''
                                            )) . "</div>";
                                        ?>
                                        <div id='attachment_sheet_ride'>

                                            <?php
                                            if($this->request->data['Parameter']['attachment_display_sheet_ride'] ==2) {
                                                $i = 0;
                                                foreach ($attachmentTypes as $attachmentType) {
                                                    if (isset($parameterAttachmentTypes[$i]) && ($parameterAttachmentTypes[$i]['ParameterAttachmentType']['attachment_type_id'] == $attachmentType['AttachmentType']['id'])) {
                                                        echo "<div class='form-group'>" . $this->Form->input('ParameterAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                                                                'label' => $attachmentType['AttachmentType']['name'],
                                                                'class' => 'form-control ',
                                                                'checked' => true,
                                                                'type' => 'checkbox',
                                                                'empty' => ''
                                                            )) . "</div>";
                                                        $i++;
                                                    } else {
                                                        echo "<div class='form-group'>" . $this->Form->input('ParameterAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                                                                'label' => $attachmentType['AttachmentType']['name'],
                                                                'class' => 'form-control ',
                                                                'type' => 'checkbox',
                                                                'empty' => ''
                                                            )) . "</div>";
                                                    }
                                                }

                                            }


                                            ?>


                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>
			<div class="tab-pane" id="tab_16">
                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterPrinting'
                    ),
                    'enctype' => 'multipart/form-data'
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneaffectation">
                                            <?php echo __('Printing'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('entete_pdf', array(
                                                'label' => __('Print pdf files'),
                                                'type' => 'select',
                                                'options' => array('1' => __('With header'), '2' => __('Without header')),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                                'empty' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('signature_mission_order', array(
                                                'label' => __('Signature mission order'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('observation1', array(
                                                'label' => __('Observation 1'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('observation2', array(
                                                'label' => __('Observation 2'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";


                                        echo "<div class='form-group'>" . $this->Form->input('choice_reporting', array(
                                                'label' => __('Choice reporting'),
                                                'options' => array('1' => __('Pdf'), '2' => __('Crystal Reports'), '3' => __('Jasper Reports')),
                                                'empty' => "",
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('reports_path_rpt', array(
                                                'label' => __('Reports path .rpt'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                                'type' => "file",
                                                'id' => "FileUpload",
                                                'onchange' => "selectFolder(event)",
                                                'webkitdirectory' => '',
                                                'mozdirectory' => '',
                                                'msdirectory' => '',
                                                'odirectory' => '',
                                                'directory' => '',
                                                'multiple' => '',
                                            )) . "</div>";


                                        // echo $_SERVER['DOCUMENT_ROOT'];

                                        echo "<div class='form-group'>" . $this->Form->input('reports_path_pdf', array(
                                                'label' => __('Reports path .pdf'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('reports_path_jasper', array(
                                                'label' => __('Reports path .jasper'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('username_jasper', array(
                                                'label' => __('Username') . ' ' . ('jasper'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('password_jasper', array(
                                                'label' => __('Password') . ' ' . ('jasper'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";


                                        echo "<div class='form-group'>" . $this->Form->input('tomcat_path', array(
                                                'label' => __('Tomcat path'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('mission_order_model', array(
                                                'label' => __('Mission order model'),
                                                'options' => array('1' => __('Model'). 1, '2' => __('Model'). 2,'3' => __('Model'). 3),
                                                'empty' => "",
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('commercial_document_model', array(
                                                'label' => __('Commercial document model'),
                                                'options' => array('1' => __('Model'). 1, '2' => __('Model'). 2, '3' => __('Model'). 3),
                                                'empty' => "",
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        ?>
                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#twoaffectation">
                                            <?php echo __('Synchronization'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="twoaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('synchronization_km', array(
                                                'label' => __('Synchronization km'),
                                                'type' => 'select',
                                                'options' => array('1' => __('Km with synchronization'), '2' => __('Km car')),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                                'empty' => ''
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('header_synchronization', array(
                                                'label' => __('Header synchronization'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                                )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('url_synchronization', array(
                                                    'label' => __('Url synchronization'),
                                                    'style' => "width: 40%",
                                                    'class' => 'form-control',
                                                )) . "</div>";



                                        ?>

                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>

            <div class="tab-pane" id="tab_17">

                <?php echo $this->Form->create('Parameter', array(
                    'url' => array(
                        'action' => 'ParameterDatabase'
                    ),
                    'enctype' => 'multipart/form-data'
                )); ?>
                <br/><br/>

                <div class="box-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="panel-group wrap" id="bs-collapse3">

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#" href="#oneaffectation">
                                            <?php echo __('Database'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="oneaffectation" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php  echo "<div class='form-group'>" . $this->Form->input('save_bdd_path', array(
                                                'label' => __('Save bdd path'),
                                                'style' => "width: 40%",
                                                'class' => 'form-control',
                                            )) . "</div>"; ?>

                                        <br>

                                        <p class='db'> <?= __('Download a backup of your database ') ?>     <?= $this->Html->link('<i class="fa  fa-cloud-download"></i>' . __('Save data base'), array('action' => 'download'), array('escape' => false, 'class' => 'btn btn-act btn-primary ')) ?> </p>

                                    </div>
                                </div>

                            </div>
                            <!-- end of panel -->


                        </div>
                        <!-- end of #bs-collapse  -->


                        <div class="box-footer">
                            <?php echo $this->Form->submit(__('Submit'), array(
                                'name' => 'ok',
                                'class' => 'btn btn-primary btn-bordred  m-b-5',
                                'label' => __('Submit'),
                                'type' => 'submit',
                                'div' => false
                            )); ?>
                            <?php echo $this->Form->submit(__('Cancel'), array(
                                'name' => 'cancel',
                                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                                'label' => __('Cancel'),
                                'type' => 'submit',
                                'div' => false,
                                'formnovalidate' => true
                            )); ?>
                        </div>
                        <?php
                        echo $this->Form->end(); ?>
                    </div>
                    <div style="clear:both;"></div>


                </div>
            </div>
            <!-- /.tab-content -->

        </div>


        <?php $this->start('script'); ?>
        <!-- InputMask -->
        <?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
        <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
        <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
        <?= $this->Html->script('ExpandSelect_1.00'); ?>
        <?= $this->Html->script('jquery-2.1.1.min.js'); ?>
        <?= $this->Html->script('jquery.form.min.js'); ?>
        <?= $this->Html->script('maskedinput'); ?>

        <script type="text/javascript">

            //fonction appel� plus bas, ouvre un marqueur et recadre la carte aux coordonn�es indiqu�es pour la cartes donn�e
            function traiteAdresse(marker, latLng, infowindow, map) {
                //recadre et zomme sur les coordonn�es latLng

                map.setCenter(latLng);
                map.setZoom(14);
                var latlongdef = latLng.toString();
                latlongdef = latlongdef.substring(1);
                latlongdef = latlongdef.substring(0, latlongdef.length - 1);
                latlongdef = latlongdef.split(",");
                var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
                lat = parseFloat(latlongdef[0]);
                lng = parseFloat(latlongdef[1]);
                jQuery('#latitude').val(lat);
                jQuery('#longitude').val(lng);
                //on stocke nos nouvelles coordon�e dans le champs correspondant
                document.getElementById('latlng').value = latLng;
                //on va rechercher les information sur l'adresse correspondant � ces coordonn�es
                geocoder.geocode({
                    'latLng': latLng
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            infowindow.setContent(results[0].formatted_address);
                            //on stocke l'adresse compl�te
                            document.getElementById("addresspicker").value = results[0].formatted_address;

                            var nb_el = results[0].address_components.length;
                            //et ses diff�rentes composantes s�par�ment

                            infowindow.open(map, marker);
                        } else {
                            alert("No results found");
                        }
                    } else {
                        alert("Geocoder failed due to: " + status);
                    }
                });
            }
            //fonction initialisant la carte
            function initialize(zoom, carte) {
                geocoder = new google.maps.Geocoder();
                //par d�faut on prend les coordonn�es entr� dans notre champs latlng
                var latlongdef = document.getElementById('latlng').value;
                if (latlongdef == '') {
                    var latlng = new google.maps.LatLng(36.75218210858053, 3.0426488148193584);
                }
                else {
                    latlongdef = latlongdef.substring(1);

                    latlongdef = latlongdef.substring(0, latlongdef.length - 1);

                    latlongdef = latlongdef.split(",");
                    var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
                }


                //on initialise notre carte
                var options = {
                    center: latlng,
                    zoom: zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById(carte), options);
                //on indique que notre champ addresspicker doit proposer les adresses existantes
                var input = document.getElementById('addresspicker');
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);
                //mise en place du marqueur
                var infowindow = new google.maps.InfoWindow();


                var marker = new google.maps.Marker({
                    map: map

                });
                //d�placable
                marker.setDraggable(true);
                marker.setPosition(latlng);
                //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    traiteAdresse(marker, event.latLng, infowindow, map);
                });

                //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    infowindow.close();
                    var place = autocomplete.getPlace();
                    marker.setPosition(place.geometry.location);
                    traiteAdresse(marker, place.geometry.location, infowindow, map);
                });
            }

            function getMissionCostParameters(id) {

                var i = id.substring(id.length - 1, id.length);
                var paramMissionCost = jQuery('#ParameterParamMissionCost').val();

                jQuery('#mission_cost' + '' + i + '').load('<?php echo $this->Html->url('/parameters/getMissionCostParameters/')?>' + i + '/' + paramMissionCost, function () {

                });
            }

            function resetMissionCostParameter() {
                var paramMissionCost = jQuery('#ParameterParamMissionCost').val();
                jQuery("#mission_cost_div").load('<?php echo $this->Html->url('/parameters/resetMissionCostParameter/')?>' + paramMissionCost, function () {

                });
            }
            function addMissionCostParameterDiv(id) {
                var i = parseInt(id) + 1;
                jQuery("#mission_cost_div").append("<div id=mission_cost_div" + i + "></div>");
                jQuery('#mission_cost_div' + '' + i + '').load('<?php echo $this->Html->url('/parameters/addMissionCostParameterDiv/')?>' + i, function () {

                });
                $('#div-button').html('<button  style=" width: 40px;" name="add" id="' + i + '" onclick="addMissionCostParameterDiv(' + i + ');" class="btn btn-success">+</button>');


            }
            function getAttachmentTypes(){
                var attachmentDisplaySheetRide = jQuery('#attachment_display_sheet_ride').val();

                jQuery('#attachment_sheet_ride' ).load('<?php echo $this->Html->url('/parameters/getAttachmentTypes/')?>' + attachmentDisplaySheetRide, function () {

                });

            }

            $(document).ready(function () {

                google.maps.event.addDomListener(window, 'load', initialize(14, "map"));


                $(".up,.down").click(function () {
                    var row = $(this).parents("tr:first");

                    if ($(this).is(".up")) {

                        row.insertBefore(row.prev());

                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);
                        });

                        $('#priority').val(array_priority);
                    } else {

                        row.insertAfter(row.next());

                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);
                        });

                        $('#priority').val(array_priority);
                    }
                });

                jQuery('#coupon').change(function () {

                    if (!jQuery('#coupon').prop('checked')) {
                        // jQuery('#2').css('display','none');

                        jQuery('#2').remove();

                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);

                        });


                        $('#priority').val(array_priority);

                    } else {


                        $('#tab').append('<tr id="2" class="tr_cons"><td><?php echo __("Coupons")?></td><td ><a href="#" class="up upbon"  ><i  class="fa fa-chevron-circle-up"></i></a></td><td><a href="#" class="down downbon" ><i  class="fa fa-chevron-circle-down"></i></a></td></tr>');


                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);
                        });
                        $('#priority').val(array_priority);


                        $(".upbon").click(function () {

                            var row = $(this).parents("tr:first");


                            row.insertBefore(row.prev());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });

                        $(".downbon").click(function () {

                            var row = $(this).parents("tr:first");
                            row.insertAfter(row.next());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });
                    }
                });

                jQuery('#spacies').change(function () {

                    if (!jQuery('#spacies').prop('checked')) {

                        //jQuery('#3').css('display','none');
                        jQuery('#3').remove();
                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);

                        });
                        //array_priority.splice(array_priority.indexOf('3'), 1);
                        $('#priority').val(array_priority);
                    } else {
                        // jQuery('#3').show();;

                        $('#tab').append('<tr id="3" class="tr_cons"><td><?php echo __("Species")?></td><td ><a href="#" class="up upespece"  ><i  class="fa fa-chevron-circle-up"></i></a></td><td><a href="#" class="down downespece" ><i  class="fa fa-chevron-circle-down"></i></a></td></tr>');

                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);
                        });

                        $('#priority').val(array_priority);


                        $(".upespece").click(function () {

                            var row = $(this).parents("tr:first");


                            row.insertBefore(row.prev());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });

                        $(".downespece").click(function () {
                            var row = $(this).parents("tr:first");
                            row.insertAfter(row.next());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });
                            $('#priority').val(array_priority);
                        });

                    }

                });

                jQuery('#tank').change(function () {

                    if (!jQuery('#tank').prop('checked')) {

                        //jQuery('#1').css('display','none');
                        jQuery('#1').remove();
                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);

                        });
                        //array_priority.splice(array_priority.indexOf('1'), 1);
                        $('#priority').val(array_priority);
                    } else {
                        //jQuery('#1').show();
                        $('#tab').append('<tr id="1" class="tr_cons"><td><?php echo __("Tank")?></td><td ><a href="#" class="up upciterne"><i  class="fa fa-chevron-circle-up"></i></a></td><td><a href="#" class="down downciterne"><i  class="fa fa-chevron-circle-down"></i></a></td></tr>');
                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);
                        });

                        $('#priority').val(array_priority);


                        $(".upciterne").click(function () {

                            var row = $(this).parents("tr:first");


                            row.insertBefore(row.prev());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });

                        $(".downciterne").click(function () {

                            var row = $(this).parents("tr:first");
                            row.insertAfter(row.next());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });
                    }

                });

                jQuery('#card').change(function () {

                    if (!jQuery('#card').prop('checked')) {

                        //jQuery('#1').css('display','none');
                        jQuery('#4').remove();
                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);

                        });

                        $('#priority').val(array_priority);
                    } else {

                        $('#tab').append('<tr id="4" class="tr_cons"><td><?php echo __("Cards")?></td><td ><a href="#" class="up upciterne"><i  class="fa fa-chevron-circle-up"></i></a></td><td><a href="#" class="down downciterne"><i  class="fa fa-chevron-circle-down"></i></a></td></tr>');
                        var array_priority = [];
                        $('.tr_cons').each(function () {
                            array_priority.push(this.id);
                        });

                        jQuery('#priority').val(array_priority);


                        $(".upciterne").click(function () {

                            var row = $(this).parents("tr:first");


                            row.insertBefore(row.prev());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });

                        $(".downciterne").click(function () {

                            var row = $(this).parents("tr:first");
                            row.insertAfter(row.next());

                            var array_priority = [];
                            $('.tr_cons').each(function () {
                                array_priority.push(this.id);
                            });

                            $('#priority').val(array_priority);

                        });
                    }

                });

                $('.collapse.in').prev('.panel-heading').addClass('active');
                $('#accordion, #bs-collapse, #bs-collapse2, #bs-collapse3')
                    .on('show.bs.collapse', function (a) {
                        $(a.target).prev('.panel-heading').addClass('active');
                    })
                    .on('hide.bs.collapse', function (a) {
                        $(a.target).prev('.panel-heading').removeClass('active');
                    });

                if (jQuery('#use_priority').val() == 1) {

                    jQuery('#priority_div').css("display", "none");
                } else {
                    jQuery('#priority_div').css("display", "block");
                }
                jQuery('#use_priority').change(function () {
                    if (jQuery('#use_priority').val() == 1) {

                        jQuery('#priority_div').css("display", "none");
                    } else {
                        jQuery('#priority_div').css("display", "block");
                    }
                });
            });


        </script>



        <?php $this->end(); ?>
