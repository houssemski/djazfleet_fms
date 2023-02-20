<style>
    .actions {
        width: 100px;
    }
</style>

<h4 class="page-title"> <?= __('Search'); ?></h4>

<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">


        <div class="panel">
            <div class="panel-heading" style="background-color: #435966; color: #fff;">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#" href="#one">
                        <?php echo __('Search') ?>
                    </a>
                </h4>
            </div>
            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Cars', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>


                    <div class="filters" id="filters">
                        <input name="conditions" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_index)); ?>">
                        <?php


                        echo $this->Form->input('mark_id', array(
                            'label' => __('Mark'),
                            'class' => 'form-filter select2',
                            'id' => 'mark_filter',
                            'empty' => ''
                        ));
                        echo "<span id='model'>" . $this->Form->input('carmodel_id', array(
                                'label' => __('Model'),
                                'class' => 'form-filter select2',
                                'empty' => ''
                            )) . "</span>";
                        echo $this->Form->input('car_category_id', array(
                            'label' => __('Category'),
                            'class' => 'form-filter select2',
                            'id' => 'category',
                            'empty' => '',
                            'onchange' => 'javascript:handleCatgeoryChange(event, this, "type")'
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('car_type_id', array(
                            'label' => __('Type'),
                            'class' => 'form-filter select2',
                            'id' => 'type',
                            'empty' => ''
                        ));
                        echo $this->Form->input('fuel_id', array(
                            'label' => __('Fuel'),
                            'class' => 'form-filter',
                            'id' => 'fuel',
                            'empty' => ''
                        ));
                        echo $this->Form->input('car_status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-filter last',
                            'id' => 'status',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        $options = array('1' => __('Au parc'), '2' => __('En mission'), '3' => __('Retour au parc'));
                        echo $this->Form->input('mission', array(
                            'label' => __('Car mission'),
                            'options' => $options,
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        $options = array('1' => __('Acquisition'), '2' => __('Offshore'));
                        echo $this->Form->input('car_parc', array(
                            'label' => __('Car'),
                            'options' => $options,
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        if ($hasParc) {

                            echo $this->Form->input('parc_id', array(
                                'label' => __('Parc'),
                                'class' => 'form-filter',
                                'id' => 'parc',

                                'empty' => ''
                            ));


                        } else {
                            if ($nb_parcs > 0) {
                                echo $this->Form->input('parc_id', array(
                                    'label' => __('Parc'),
                                    'class' => 'form-filter',
                                    'id' => 'parc',
                                    'type' => 'select',
                                    'options' => $parcs,
                                    'empty' => ''
                                ));
                            }


                        }
                        if ($isSuperAdmin) {
                            echo "<div style='clear:both; padding-top: 40px;'></div>";

                            echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>' . __("  Administrative filter") . '</a></div>';

                            ?>
                            <div id="demo" class="collapse">
                                <div
                                    style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>
                                <?php
                                echo $this->Form->input('profile_id', array(
                                    'label' => __('Profile'),
                                    'class' => 'form-filter',
                                    'empty' => ''
                                ));
                                echo "<div style='clear:both; padding-top: 10px;'></div>";

                                echo $this->Form->input('user_id', array(
                                    'label' => __('Created by'),
                                    'class' => 'form-filter',
                                    'empty' => ''
                                ));


                                echo $this->Form->input('created', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'startdate',
                                ));
                                echo $this->Form->input('created1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddate',
                                ));
                                echo "<div style='clear:both; padding-top: 10px;'></div>";
                                echo $this->Form->input('modified_id', array(
                                    'options' => $users,
                                    'label' => __('Modified by'),
                                    'class' => 'form-filter',
                                    'empty' => ''
                                ));

                                echo $this->Form->input('modified', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'startdatemodifie',
                                ));
                                echo $this->Form->input('modified1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddatemodifie',
                                ));
                                ?>

                            </div>
                            <div style='clear:both; padding-top: 10px;'></div>
                        <?php } ?>
                        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>

                    <?php echo $this->Form->end(); ?>


                </div>

            </div>
        </div>
        <!-- end of panel -->


    </div>
    <!-- end of #bs-collapse  -->


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), '#',

                                    array(
                                        'escape' => false,
                                        'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5 data-toggle="dropdown"',
                                        'data-toggle' => 'dropdown'
                                    )) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Add car'), array('action' => 'add', 1), array('escape' => false)) ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(__('Add trailer'), array('action' => 'add', 1, 3), array('escape' => false)) ?>
                                    </li>

                                    <li>
                                        <?= $this->Html->link(__('Add event'), 'javascript:addMultipleEvent();',
                                            array('escape' => false, 'id' => 'event_car')) ?>
                                    </li>
                                </ul>

                            </div>

                            <?php if ($client_i2b == 1) { ?>
                                <?= $this->Html->link('<i class="fa fa-refresh m-r-5"></i>' . __('Synchronize'), array('action' => 'km_cars'),

                                    array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5")) ?>

                            <?php } else { ?>

                                <?= $this->Html->link('<i class="fa fa-refresh m-r-5"></i><span>' . __('Synchronize') . '</span>', array('action' => 'km_cars'),

                                    array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5", 'disabled' => 'true')) ?>

                            <?php } ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("cars/deletecars/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected cars ?')); ?>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                    'javascript:exportData("cars/export/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("cars/export/all");') ?>
                                    </li>
                                </ul>
                            </div>


                            <div class="btn-group ">

                                <button type="button"

                                        class='btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5'
                                        data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-download-alt m-r-5"></i>
                                    <?= __('Import');

                                    ?>

                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu imp" role="menu">
                                    <li>
                                        <div class="timeline-body">
                                            <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/vehicules.csv', array('class' => 'titre')); ?>
                                            <br/>

                                            <form id='CarImportForm' action='cars/import' method='post'
                                                  enctype='multipart/form-data' novalidate='novalidate'>

                                                <?php echo "<div class='form-group'>" . $this->Form->input('Car.file_csv', array(
                                                        'label' => __('File .csv'),
                                                        'class' => '',
                                                        'type' => 'file',
                                                        //'id' =>'file_cars',
                                                        'placeholder' => __('Choose file .csv'),
                                                        'empty' => __('Choose file .csv'),
                                                    )) . "</div>"; ?>
                                                <div class='timeline-footer'>

                                                    <?php

                                                    echo $this->Form->submit(__('Import'), array(
                                                        'name' => 'ok',
                                                        'class' => 'btn btn-inverse btn-xs',
                                                        'label' => __('Import'),
                                                        'type' => 'submit',

                                                        'div' => false
                                                    )) ?>
                                                </div>
                                            </form>
                                        </div>


                                    </li>
                                </ul>

                            </div>

                            <?= $this->Html->link('<i class="fa fa-print m-r-5 "></i>' . __('Print'),
                                'javascript:imprime_bloc("titre", "impression");',
                                array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5")); ?>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="fa fa-print m-r-5"></i>' . __('Print'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Simplified journal'), 'javascript:printSimplifiedJournal();') ?>
                                    </li>
                                </ul>
                            </div>


                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Cars', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <input name="conditions" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_index)); ?>">

                </label>
                <?php echo $this->Form->end(); ?>
                <?= $this->Form->input('controller', array(
                    'id' => 'controller',
                    'value' => $this->request->params['controller'],
                    'type' => 'hidden'
                )); ?>

                <?= $this->Form->input('action', array(
                    'id' => 'action',
                    'value' => 'liste',
                    'type' => 'hidden'
                )); ?>


                <div id="impression">
                    <div class="bloc-limit btn-group pull-left">
                        <div>
                            <label>
                                <?php
                                if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                                ?>
                                <select name="slctlimit" id="slctlimit" onchange="slctlimitChangedSearch('cars/index');">
                                    <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                    <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                    <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                    <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100
                                    </option>
                                </select>&nbsp; <?= __('records per page') ?>

                            </label>
                        </div>
                    </div>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th>
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                            class="fa fa-square-o"></i></button>
                            </th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('Km') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Category') ?></th>
                            <th><?= __('Fuel') ?></th>
                            <th><?= __('IM.D') ?></th>
                            <th><?= __('Chassis') ?></th>
                            <th><?= __('Color') ?></th>
                            <?php if ($balance_car == 2) { ?>
                                <th><?= __('Balance car') ?></th>
                            <?php } ?>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Statut mission') ?></th>
                            <th><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody id="listeDiv">
                        <?php foreach ($cars as $car): ?>
                            <tr id="row<?= $car['Car']['id'] ?>">

                                <td>
                                    <input id="idCheck" type="checkbox" class='id'
                                           value=<?php echo $car['Car']['id'] ?>>
                                </td>

                                <td><?php echo h($car['Car']['code']); ?>&nbsp;</td>

                                <td><?php
                                    if (!empty($car['Mark']['logo'])) {
                                        echo $this->Html->image('/mark/' . h($car['Mark']['logo']),
                                            array(
                                                'class' => 'mark_logo',
                                                'alt' => 'Logo'
                                            ));
                                    }
                                    if (isset($car['Car']['picture1']) && !empty($car['Car']['picture1'])) {
                                        ?>
                                        <a style="color: #ed1e24;"
                                           href="<?php echo $this->Html->url(array('action' => 'view', $car['Car']['id'])); ?>"
                                           class="infobulle"> <?php echo "  " . h($car['Carmodel']['name']); ?>
                                            <span><img
                                                    src="attachments/picturescar/<?php echo h($car['Car']['picture1']); ?>"/></span>
                                        </a>
                                    <?php
                                    } else {
                                        echo "  " . h($car['Carmodel']['name']);
                                        ?>
                                    <?php } ?>
                                </td>

                                <td class="right alert-km"><?php if ($car['Car']['km'] > 0) echo h(number_format($car['Car']['km'], 2, ",", ".")); else echo h(number_format($car['Car']['km_initial'], 2, ",", ".")); ?></td>

                                <td style="text-align: center">
                                    <?php
                                    $file_dir = WWW_ROOT . 'img/pictureCarType/' . $car['CarType']['id'] . '.png';
                                    if (!empty($car['CarType']['id']) && file_exists($file_dir)) {
                                        echo $this->Html->image('/img/pictureCarType/' . $car['CarType']['id'] . '.png',
                                            array(
                                                'class' => 'car_type',
                                                'alt' => 'carType'
                                            ));
                                    }
                                    echo "<p>".$car['CarType']['name']."</p>";
                                    ?>
                                </td>
                                <td><?php echo h($car['CarCategory']['name']); ?>&nbsp;</td>
                                <td><?php echo h($car['Fuel']['name']); ?>&nbsp;</td>
                                <td><?php echo h($car['Car']['immatr_def']); ?>&nbsp;</td>
                                <td><?php echo h($car['Car']['chassis']); ?>&nbsp;</td>
                                <td><?php echo h($car['Car']['color2']); ?>&nbsp;</td>
                                <?php if ($balance_car == 2) { ?>
                                    <td><?php echo h(number_format($car['Car']['balance'], 2, ",", ".")); ?>&nbsp;</td>
                                <?php } ?>
                                <td>
                                    <?php


                                    echo '<span class="label" style=background-color:' . $car['CarStatus']['color'];
                                    '';
                                    if($car['CarStatus']['id']==25){
                                        echo ";>" . h($car['CarStatus']['name']) .' - '.h($this->Time->format($car['Car']['start_date'], '%d/%m/%Y')).' - '.h($this->Time->format($car['Car']['end_date'], '%d/%m/%Y')) . "</span>";
                                    }else {
                                        echo ";>" . h($car['CarStatus']['name']) . "</span>";
                                    }

                                /*    if ($car['Car']['car_status_id'] == 1) {
                                        echo '<span class="label label-success">';
                                    } elseif ($car['Car']['car_status_id'] == 6) {
                                        echo '<span class="label label-danger">';
                                    } else {
                                        echo '<span class="label label-primary">';
                                    }
                                    echo h($car['CarStatus']['name']) . "</span>";*/
                                ?>&nbsp;
                            </td>
                            <td style='text-align: center;'>
                                <?php
                                switch ($car['Car']['in_mission']) {

                                    case 0:
                                        echo __('Au parc');
                                        break;

                                    case 1:
                                        echo __('En mission');
                                        break;

                                    case 2:
                                        echo __('Retour au parc');
                                        break;

                                }


                                ?>

                            </td>

                            <td class="actions">

                                    <div class="btn-group ">
                                        <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                            <i class="fa fa-list fa-inverse"></i>
                                        </a>
                                        <button href="#" data-toggle="dropdown"
                                                class="btn btn-info dropdown-toggle share">
                                            <span class="caret"></span>
                                        </button>

                                    <ul class="dropdown-menu" style="min-width: 70px;">

                                        <li class='view-link' title='<?= __('View') ?>'>
                                            <?= $this->Html->link(
                                                '<i   class="fa fa-eye"></i>',
                                                array('action' => 'View', $car['Car']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <?php if ($client_i2b == 1) {
                                            echo '<li class = "localisation-link" title="' . __('Localisation') . '">';
                                            ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-map-marker"></i>',
                                                array('action' => 'viewPosition', $car['Car']['id']),
                                                array('escape' => false, 'class' => 'btn btn-inverse')
                                            ); ?>
                                            <?php     echo '</li>';
                                        } ?>

                                        <li class='edit-link' title='<?= __('Edit') ?>'>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                array('action' => 'Edit', $car['Car']['id'], $car['CarCategory']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>

                                        <?php if ((isset($car['Car']['yellow_card']) && !empty($car['Car']['yellow_card'])) && (isset($car['Car']['grey_card']) && !empty($car['Car']['grey_card']))
                                            && ((isset($car['Car']['picture1']) && !empty($car['Car']['picture1'])) || (isset($car['Car']['picture2']) && !empty($car['Car']['picture2'])) ||
                                                (isset($car['Car']['picture3']) && !empty($car['Car']['picture3'])) || (isset($car['Car']['picture4']) && !empty($car['Car']['picture4'])))
                                        ) {
                                            echo '<li class = "attachments-link" title="' . __('Attachments') . '">';
                                            echo $this->Html->link(
                                                '<i class="fa fa-paperclip"></i>',
                                                array('action' => 'View', $car['Car']['id']),
                                                array('escape' => false, 'class' => 'btn btn-warning')
                                            );
                                        } else {
                                            if (empty($car['Car']['yellow_card']) && empty($car['Car']['grey_card']) && empty($car['Car']['picture1']) &&
                                                empty($car['Car']['picture2']) && empty($car['Car']['picture3']) && empty($car['Car']['picture4'])
                                            ) {
                                                echo '<li class = "missing-attachments-link" title="' . __('Missing attachments') . '">';
                                                echo $this->Html->link(
                                                    '<i class="fa fa-unlink"></i>',

                                                    array('action' => 'Edit', $car['Car']['id'], $car['CarCategory']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-warning')

                                                );
                                            } elseif (empty($car['Car']['grey_card'])) {
                                                echo '<li class = "missing-attachments-grey-link" title="' . __('Missing attachments grey card') . '">';
                                                echo $this->Html->link(
                                                    '<i class="fa fa-unlink"></i>',

                                                    array('action' => 'Edit', $car['Car']['id'], $car['CarCategory']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-warning')

                                                );
                                            } elseif (empty($car['Car']['yellow_card']) && empty($car['Car']['grey_card'])) {
                                                echo '<li class = "missing-attachments-yellow-link" title="' . __('Missing attachments yellow card and grey card') . '">';
                                                echo $this->Html->link(
                                                    '<i class="fa fa-unlink"></i>',

                                                    array('action' => 'Edit', $car['Car']['id'], $car['CarCategory']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-warning')

                                                    );
                                                } elseif (empty($car['Car']['picture1']) || empty($car['Car']['picture2']) || empty($car['Car']['picture3']) || empty($car['Car']['picture4'])) {
                                                    echo '<li class = "missing-attachments-pictures-link" title="' . __('Missing attachments pictures') . '">';
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-unlink"></i>',
                                                        array('action' => 'Edit', $car['Car']['id'], $car['CarCategory']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-warning')
                                                    );
                                                }
                                            } ?>
                                            </li>

                                            <?php
                                            if ($car['Car']['locked'] == 1) {
                                                echo '<li class = "unlock-link" title="' . __('Unlock') . '">';
                                                echo $this->Html->link(
                                                    '<i class="fa  fa-lock"></i>',
                                                    array('action' => 'unlock', $car['Car']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-purple')
                                                );
                                            } else {
                                                echo '<li class = "lock-link" title="' . __('Lock') . '">';
                                                echo $this->Html->link(
                                                    '<i class="fa  fa-unlock"></i>',
                                                    array('action' => 'lock', $car['Car']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-purple')
                                                );
                                            }?>
                                        </li>
                                        <li class='delete-link' title='<?= __('Delete') ?>'>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o"></i>',
                                                array('action' => 'delete', $car['Car']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $car['Carmodel']['name'])); ?>
                                        </li>


                                    </ul>
                                </div>


                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div id="pagination" class="pull-right">
                        <?php if ($this->params['paging']['Car']['pageCount'] > 1) {
                            ?>
                            <p>
                                <?php
                                echo $this->Paginator->counter(array(
                                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                                ));
                                ?>    </p>
                            <div class="box-footer clearfix">
                                <ul class="pagination pagination-sm no-margin pull-left">
                                    <?php
                                    echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                    echo $this->Paginator->numbers(array(
                                        'tag' => 'li',
                                        'first' => false,
                                        'last' => false,
                                        'separator' => '',
                                        'currentTag' => 'a'));
                                    echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!--endprint-->
            </div>
        </div>
    </div>
</div>


<div class="card-box">


    <h4 class="header-title m-t-0 m-b-30"><a href="#total" data-toggle="collapse"><i
                class="zmdi zmdi-notifications-none m-r-5"></i> <?php echo __('Totals') ?></h4>

    <div id="total" class="collapse">
        <ul class="list-group m-b-0 user-list">

            <?php
            $url = "";
            foreach ($carStatuses as $carStatuse) {
                $found = false;
                foreach ($totals as $total) {
                    if ($carStatuse == $total['CarStatus']['name']) {


                        $url .= "/status:" . $total['Car']['car_status_id'] . "/conditions:" . base64_encode(serialize($conditions));


                        echo " <li class='list-group-item'>
            <a href='cars/search/$limit/$url' class='user-list-item'>
            <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong> " . $total['CarStatus']['name'] . "</strong> : " . $total[0]['total'] . "";

                        if ($total[0]['total'] > 1) echo " " . __('Cars') . "</span>
                </div>
            </a>
        </li>";

                        else echo " " . __('Car') . "</span>
                </div>
            </a>
        </li>";
                        $url = "";
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    echo "<li class='list-group-item'>
            <a href='#' class='user-list-item'>
            <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong>" . $carStatuse . "</strong> : 0 " . __('Car') . "</span>
                </div>
            </a>
        </li>";
                }
            } ?>


        </ul>

    </div>

</div>


<br>
<br>

<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->element('Script/Cars/car-list-tools'); ?>

<script type="text/javascript"> 
    $(document).ready(function () {
        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery('#mark').change(function () {
            // alert('test');
            jQuery('#model').load('<?php echo $this->Html->url('/cars/getModelsFilters/')?>' + $(this).val());
        });
        jQuery('#link_search_advanced').click(function () {
            if (jQuery('#filters').is(':visible')) {
                jQuery('#filters').slideUp("slow", function () {
                });
            } else {
                jQuery('#filters').slideDown("slow", function () {
                });
            }
        });
	$(function () {
        $("#code").keypress(function (e) {
            if (e.which == 13) {

                jQuery('#listeDiv').load('<?php echo $this->Html->url('/cars/liste/')?>' + $("#code").val(), function () {

                });
            }
        });
    })


        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
        }

        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    });

    function exportAllData() {
        <?php
        $url = "";
        if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
            $url .= "/keyword:" . $this->params['named']['keyword'];
        }
        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $url .= "/mark:" . $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $url .= "/model:" . $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:" . $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $url .= "/fuel:" . $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $url .= "/parc:" . $this->params['named']['parc'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $url .= "/user:" . $this->params['named']['user'];
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $url .= "/modified_id:" . $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:" . $this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:" . $this->params['named']['created1'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $url .= "/modified:" . $this->params['named']['modified'];
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $url .= "/modified1:" . $this->params['named']['modified1'];
        }
        ?>
        window.location = '<?php echo $this->Html->url('/cars/export/')?>' + 'all_search' + '<?php echo $url;?>';

    }


    function addMultipleEvent() {
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());

        });
        if (myCheckboxes.length > 0) {
            window.location = '<?php echo $this->Html->url('/events/addMultipleEvent/')?>' + myCheckboxes;
        }
        else {
            <?php
            $url = "";

            if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
                $url .= "/mark:" . $this->params['named']['mark'];
            }
            if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
                $url .= "/model:" . $this->params['named']['model'];
            }
            if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
                $url .= "/category:" . $this->params['named']['category'];
            }
            if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
                $url .= "/type:" . $this->params['named']['type'];
            }
            if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
                $url .= "/fuel:" . $this->params['named']['fuel'];
            }
            if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
                $url .= "/status:" . $this->params['named']['status'];
            }
            if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
                $url .= "/parc:" . $this->params['named']['parc'];
            }
            if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
                $url .= "/user:" . $this->params['named']['user'];
            }
            if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
                $url .= "/modified_id:" . $this->params['named']['modified_id'];
            }
            if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
                $url .= "/created:" . $this->params['named']['created'];
            }
            if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
                $url .= "/created1:" . $this->params['named']['created1'];
            }
            if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
                $url .= "/modified:" . $this->params['named']['modified'];
            }
            if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
                $url .= "/modified1:" . $this->params['named']['modified1'];
            }
            ?>
            window.location = '<?php echo $this->Html->url('/events/addMultipleEvent/')?>' + 'all' + '<?php echo $url;?>';


        }


    }

	function printSimplifiedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#mark_filter').val();
        conditions[1] = jQuery('#CarsCarmodelId').val();
        conditions[2] = jQuery('#category').val();
        conditions[3] = jQuery('#type').val();
        conditions[4] = jQuery('#fuel').val();
        conditions[5] = jQuery('#status').val();
        conditions[6] = jQuery('#CarsMission').val();
        conditions[7] = jQuery('#CarsCarParc').val();
        conditions[8] = jQuery('#parc').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'),
         array('target' => '_blank' ))?>';
        var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
        '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
        '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }
	
    function slctlimitChangedSearch() {
        <?php
        $url = "";

        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $url .= "/mark:" . $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $url .= "/model:" . $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:" . $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $url .= "/fuel:" . $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:" . $this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:" . $this->params['named']['created1'];
        }

        if (isset($this->params['named']['conditions']) && !empty($this->params['named']['conditions'])) {
            $url .= "/conditions:" . base64_encode(serialize($conditions_index));
        }
        ?>
        window.location = '<?php echo $this->Html->url('/cars/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
    }


</script>
<?php $this->end(); ?>
