<?php
//echo $this->element('sql_dump'); ?>

<style>
    .actions {
        width: 80px;
    }
</style>

<h4 class="page-title"> <?= __('Workshops (Entry - Exit)'); ?></h4>
<div class="box-body">

    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>
            <a class="collapsed grp_actions_icon fltr" data-toggle="collapse" data-parent="#" href="#grp_actions">
                <i class="fa fa-toggle-down"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Events', array(
                        'url' => array(
                            'action' => 'getEntryExitWorkshops'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                        <input name="conditions" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions)); ?>">
                        <input name="conditions_car" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                        <input name="conditions_customer" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                        <?php
                        echo $this->Form->input('event_type_id', array(
                            'label' => __('Type'),
                            'class' => 'form-filter',
                            'id' => 'type',
                            'empty' => ''
                        ));

                        echo $this->Form->input('workshop_id', array(
                            'label' => __('Workshop'),
                            'class' => 'form-filter',
                            'id' => 'type',
                            'empty' => ''
                        ));



                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('mechanician_id', array(
                            'label' => __("Mechanic"),
                            'class' => 'form-filter',
                            'options'=>$mechanicians,
                            'empty' => ''
                        ));

                        if ($hasParc) {
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
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


                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('workshop_entry_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Entry date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate',
                        ));
                        echo $this->Form->input('workshop_exit_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Exit date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate',
                        ));



                        if ($isSuperAdmin) {
                            echo "<div style='clear:both; padding-top: 40px;'></div>";

                            echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>' . __("  Administrative filter") . '</a></div>';

                            ?>


                            <div id="demo" class="collapse">
                                <div style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>

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
                                    'id' => 'startdatecreat',
                                ));
                                echo $this->Form->input('created1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddatecreat',
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
                                <div style='clear:both; padding-top: 10px;'></div>
                            </div>

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


    <!--startprint-->
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Events', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <input name="conditions" type="hidden" value="<?php echo base64_encode(serialize($conditions)); ?>">
                    <input name="conditions_car" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                    <input name="conditions_customer" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                    <?php
                    echo $this->Form->input('validated', array(
                        'value' => '1',
                        'type' => 'hidden',

                    ));
                    echo $this->Form->input('request', array(

                        'type' => 'hidden',

                    ));
                    ?>

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
                                <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('events/index');">
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
                            <th style="width: 10px">
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i></button>
                            </th>
                            <th><?php echo $this->Paginator->sort('EventType.name', __('Type')); ?></th>
                            <th><?php echo $this->Paginator->sort('Carmodel.name', __('Car')); ?></th>
                            <th><?php echo $this->Paginator->sort('Customer.first_name', __("Mecanicien")); ?></th>
                            <th><?php echo $this->Paginator->sort('Workshop.name', __("Workshop")); ?></th>
                            <th class="dtm"><?php echo $this->Paginator->sort('workshop_entry_date', __('Workshop entry date')); ?></th>
                            <th class="dtm"><?php echo $this->Paginator->sort('workshop_exit_date', __('Workshop exit date')); ?></th>


                        </tr>
                        </thead>


                        <tbody id="listeDiv">
                        <?php
                        $event_types = array();
                        $i = 0;

                        foreach ($events as $event) {
                            $i++;

                            if ($i < count($events)) {
                                if ($events[$i]['Event']['id'] == $event['Event']['id']) {
                                    $event_types[] = $event['EventType']['name'];
                                } else {
                                    $event_types[] = $event['EventType']['name'];

                                    ?>

                                    <tr
                                        id="row<?= $event['Event']['id'] ?>">
                                        <td class='case'>

                                            <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $event['Event']['id'] ?> >
                                        </td>
                                        <td>
                                            <?php
                                            $nbEvent= count($event_types);

                                            $j = 1;
                                            foreach ($event_types as $event_type) {
                                                if ($j == $nbEvent) {
                                                    echo $event_type;
                                                } else {
                                                    echo $event_type . ' - ';
                                                }
                                                $j++;
                                            } ?>
                                        </td>
                                        <td> <?php if ($param == 1) {
                                                echo $event['Car']['code'] . " - " . $event['Carmodel']['name'];
                                            } else if ($param == 2) {
                                                echo $event['Car']['immatr_def'] . " - " . $event['Carmodel']['name'];
                                            } ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $event['Workshop']['name'] ;
                                            ?>
                                        </td>
                                        <td>


                                            <?php
                                            if ($event['Event']['workshop_entry_date'] != NULL) {
                                                echo h($this->Time->format($event['Event']['workshop_entry_date'], '%d-%m-%Y %H:%M'));
                                            } ?>


                                        </td>
                                        <td>

                                            <?php
                                            if ($event['Event']['workshop_exit_date'] != NULL) {
                                                echo h($this->Time->format($event['Event']['workshop_exit_date'], '%d-%m-%Y %H:%M'));
                                            } ?>


                                        </td>



                                    </tr>

                                    <?php  $event_id = $event['Event']['id'];
                                    $event_types = array();
                                }


                            } else {
                                $event_types[] = $event['EventType']['name'];

                                ?>


                                <tr  id="row<?= $event['Event']['id'] ?>">
                                    <td class='case'>

                                        <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $event['Event']['id'] ?> >
                                    </td>
                                    <td>
                                        <?php
                                        $nbEvent= count($event_types);

                                        $j=1;
                                        foreach ($event_types as $event_type) {
                                            if($j==$nbEvent){
                                                echo $event_type;
                                            }else {
                                                echo $event_type.' - ';
                                            }
                                            $j++;
                                        }
                                        ?>
                                    </td>
                                    <td> <?php if ($param==1){
                                            echo $event['Car']['code']." - ".$event['Carmodel']['name'];
                                        } else if ($param==2) {
                                            echo $event['Car']['immatr_def']." - ".$event['Carmodel']['name'];
                                        } ?>
                                    </td>
                                    <td>


                                        <?php

                                        echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];
                                        ?>
                                    </td>
                                    <td>


                                        <?php

                                        echo $event['Workshop']['name'] ;
                                        ?>
                                    </td>
                                    <td>


                                        <?php
                                        if ($event['Event']['workshop_entry_date'] != NULL) {
                                            echo h($this->Time->format($event['Event']['workshop_entry_date'], '%d-%m-%Y %H:%M'));
                                        } ?>



                                    </td>
                                    <td>

                                        <?php
                                        if ($event['Event']['workshop_exit_date'] != NULL) {
                                            echo h($this->Time->format($event['Event']['workshop_exit_date'], '%d-%m-%Y %H:%M'));
                                        } ?>



                                    </td>



                                </tr>






                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <div id="pagination">
                        <?php $nb_row = $this->params['paging']['EventEventType']['pageCount'];
                        if ($nb_row > 1) {
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
            </div>
        </div>
    </div>
</div>

<div class="card-box">
    <ul class="list-group m-b-0 user-list">
        <?php
        ?>
    </ul>
</div>
<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('jquery.number.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery('#incident').css('display', 'none');
        jQuery('#type').change(function () {
            if (jQuery('#type').val() == 11) {
                jQuery('#incident').css('display', 'block');
            } else  jQuery('#incident').css('display', 'none');

        })


        jQuery('#link_search_advanced').click(function () {
            if (jQuery('#filters').is(':visible')) {
                jQuery('#filters').slideUp("slow", function () {
                });
            } else {
                jQuery('#filters').slideDown("slow", function () {
                });
            }
        });
        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery('#file_events').change(function () {

            var $form = jQuery('#EventImportForm');
            var formdata = (window.FormData) ? new FormData($form[0]) : null;
            var data = (formdata !== null) ? formdata : $form.serialize();


            jQuery.ajax({//FormID - id of the form.
                type: "POST",
                url: "<?php echo $this->Html->url('/events/import')?>",
                contentType: false, // obligatoire pour de l'upload
                processData: false, // obligatoire pour de l'upload
                dataType: 'json', // selon le retour attendu

                data: data,
                success: function (json) {

                    //window.location = '<?php echo $this->Html->url('/cars')?>' ;
                }

            });
        });

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

        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $url .= "/car:".$this->params['named']['car'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $url .= "/customer:".$this->params['named']['customer'];
        }
        if (isset($this->params['named']['group']) && !empty($this->params['named']['group'])) {
            $url .= "/group:".$this->params['named']['group'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $url .= "/user:".$this->params['named']['user'];
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $url .= "/modified_id:".$this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:".$this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:".$this->params['named']['created1'];
        }

        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $url .= "/modified:".$this->params['named']['modified'];
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $url .= "/modified1:".$this->params['named']['modified1'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:".$this->params['named']['type'];
        }
        if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
            $url .= "/interfering:".$this->params['named']['interfering'];
        }
        if (isset($this->params['named']['date']) && !empty($this->params['named']['date'])) {
            $url .= "/date:".$this->params['named']['date'];
        }
        if (isset($this->params['named']['nextdate']) && !empty($this->params['named']['nextdate'])) {
            $url .= "/nextdate:".$this->params['named']['nextdate'];
        }
        if (isset($this->params['named']['pay_customer']) && !empty($this->params['named']['pay_customer'])) {
            $url .= "/pay_customer:".$this->params['named']['pay_customer'];
        }
        if (isset($this->params['named']['refund']) && !empty($this->params['named']['refund'])) {
            $url .= "/refund:".$this->params['named']['refund'];
        }
        if (isset($this->params['named']['validated']) && !empty($this->params['named']['validated'])) {
            $url .= "/validated:".$this->params['named']['validated'];
        }
        if (isset($this->params['named']['request']) && !empty($this->params['named']['request'])) {
            $url .= "/request:".$this->params['named']['request'];
        }
        ?>

        window.location = '<?php echo $this->Html->url('/events/export/')?>' + 'all_search' + '<?php echo $url;?>';



    }

    function slctlimitChanged() {
        <?php
        $url = "";

        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $url .= "/car:".$this->params['named']['car'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $url .= "/customer:".$this->params['named']['customer'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $url .= "/user:".$this->params['named']['user'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:".$this->params['named']['type'];
        }
        if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
            $url .= "/interfering:".$this->params['named']['interfering'];
        }
        if (isset($this->params['named']['date']) && !empty($this->params['named']['date'])) {
            $url .= "/date:".$this->params['named']['date'];
        }
        if (isset($this->params['named']['nextdate']) && !empty($this->params['named']['nextdate'])) {
            $url .= "/nextdate:".$this->params['named']['nextdate'];
        }
        ?>

        window.location = '<?php echo $this->Html->url('/events/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
    }



</script>

    <script type="text/javascript">

        $(document).ready(function () {



            $('.panel-group').on('hidden.bs.collapse', toggleIcon);
            $('.panel-group').on('shown.bs.collapse', toggleIcon);
        });
        // Show the text box on click

    </script>

<?php $this->end(); ?>
