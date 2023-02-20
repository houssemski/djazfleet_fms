<div id="msg" name="msg"></div>
<div class="box-body main">
    <?php
    ?><h4 class="page-title"> <?= __("Sheet ride") . " " . $sheetRide['SheetRide']['reference']; ?></h4>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link(
                                '<i class="  fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                array('action' => 'Edit', $sheetRide['SheetRide']['id']),
                                array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                            ); ?>

                            <?= $this->Form->postLink(
                                '<i class=" fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
                                array('action' => 'Delete', $sheetRide['SheetRide']['id']),
                                array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
                                __('Are you sure you want to delete this Sheet ride?')); ?>

                            <div style="clear: both"></div>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="left_side card-box p-b-0">

        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                <li><a href="#tab_2" data-toggle="tab"><?= __('Ride information') ?></a></li>
                <li><a href="#tab_3" data-toggle="tab"><?= __('Consumption') ?></a></li>
                <li><a href="#tab_4" data-toggle="tab"><?= __('Attachments') ?></a></li>


            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <dl>
                        <?php
                        if (!empty($sheetRide['SheetRide']['reference'])) {
                            echo "<dt>" . __('Number sheet') . "</dt><dd>" . $sheetRide['SheetRide']['reference'] . "&nbsp;</dd><br/>";
                        }
                        ?>
                        <dt><?php echo __('Car'); ?></dt>
                        <dd>
                            <?php
                            if ($param==1){
                                echo $sheetRide['Carmodel']['name'] . " " . $sheetRide['Car']['code'];
                            }else {
                                echo $sheetRide['Carmodel']['name'] . " " . $sheetRide['Car']['immatr_def'];
                            }
                             ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Customer"); ?></dt>
                        <dd>
                            <?php

                            echo $sheetRide['Customer']['first_name'] . " " . $sheetRide['Customer']['last_name'];
                            ?>
                            &nbsp;
                        </dd>
                        <br/>

                        <?php

                        if (!empty($sheetRide['SheetRide']['start_date'])) {
                            ?>
                            <dt><?php echo __('Planned Departure date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($sheetRide['SheetRide']['start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php
                        }

                        if (!empty($sheetRide['SheetRide']['real_start_date'])) {
                            ?>
                            <dt><?php echo __('Real Departure date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php
                        }
                        if (!empty($sheetRide['SheetRide']['end_date'])) {
                            ?>
                            <dt><?php echo __('Planned Arrival date '); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($sheetRide['SheetRide']['end_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

                        <?php if (!empty($sheetRide['SheetRide']['real_end_date'])) { ?>
                            <dt><?php echo __('Real Arrival date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($sheetRide['SheetRide']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

                        <?php if (!empty($sheetRide['SheetRide']['km_departure'])) { ?>
                            <dt><?php echo __('Departure Km'); ?></dt>
                            <dd>

                                <?php echo h((number_format($sheetRide['SheetRide']['km_departure'], 2, ",", "."))); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

                        <?php if (!empty($sheetRide['SheetRide']['km_arrival'])) { ?>
                            <dt><?php echo __('Arrival Km'); ?></dt>
                            <dd>
                                <?php echo h((number_format($sheetRide['SheetRide']['km_arrival'], 2, ",", "."))); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>
                        <dt><?php echo __('Creator'); ?></dt>
                        <dd>
                            <?php echo h($sheetRide['User']['first_name'] . ' ' . $sheetRide['User']['last_name']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Created'); ?></dt>
                        <dd>
                            <?php echo  h($this->Time->format($sheetRide['SheetRide']['created'], '%d-%m-%Y'));?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Modifier'); ?></dt>
                        <dd>
                            <?php echo h($sheetRide['Modifier']['first_name'] . ' ' . $sheetRide['Modifier']['last_name']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Modified'); ?></dt>
                        <dd>
                            <?php echo  h($this->Time->format($sheetRide['SheetRide']['modified'], '%d-%m-%Y'));?>
                            &nbsp;
                        </dd>
                        <br/>
                    </dl>

                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <div class="col-lg-12">
                            <div class="card-box p-b-0">
                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                       width="80%">
                                    <thead>
                                    <tr>

                                        <th><?php echo $this->Paginator->sort('reference', __('Reference')); ?></th>
                                        <th><?php echo $this->Paginator->sort('detail_ride_id', __('Mission')); ?></th>
                                        <th><?php echo $this->Paginator->sort('invoiced_ride', __('Invoiced')); ?></th>
                                        <th><?php echo $this->Paginator->sort('sheetRideDetailRides.supplier_id', __('Initial customer')); ?></th>
                                        <th><?php echo $this->Paginator->sort('planned_start_date', __('Planned Departure date')); ?></th>
                                        <th><?php echo $this->Paginator->sort('real_start_date', __('Real Departure date')); ?></th>
                                        <th><?php echo $this->Paginator->sort('km_departure', __('Departure Km')); ?></th>
                                        <th><?php echo $this->Paginator->sort('sheetRideDetailRides.supplier_final_id', __('Final customer')); ?></th>
                                        <th><?php echo $this->Paginator->sort('planned_end_date', __('Planned Arrival date ')); ?></th>
                                        <th><?php echo $this->Paginator->sort('real_end_date', __('Real Arrival date')); ?></th>
                                        <th><?php echo $this->Paginator->sort('km_arrival', __('Arrival Km')); ?></th>
                                        <th><?php echo $this->Paginator->sort('status_id', __('Status')); ?></th>
                                        <th><?php echo $this->Paginator->sort('user_id', __('User')); ?></th>
                                        <th><?php echo $this->Paginator->sort('created', __('Created')); ?></th>
                                        <th><?php echo $this->Paginator->sort('modified_id', __('Modifier')); ?></th>
                                        <th><?php echo $this->Paginator->sort('modified', __('Modified')); ?></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <?php
                                        if(!empty($rides)){
                                        foreach ($rides as $ride) { ?>
                                    <tr>

                                        <td><?php echo $ride['reference'] ?></td>
                                        <td><?= $ride['departureDestinationName'] . '-' . $ride['arrivalDestinationName'] . '-' . $ride['carTypeName']; ?></td>
                                        <td><?php     if ($ride['invoiced_ride'] == 1) {
                                                echo '<i class="fa  fa-check green"</i>';
                                            } else {
                                                echo '<i class="fa  fa-times red" </i>';
                                            }?> </td>
                                        <td><?= $ride['Supplier'] ?></td>
                                        <td><?php echo h($this->Time->format($ride['planned_start_date'], '%d-%m-%Y %H:%M')); ?>
                                            &nbsp;</td>
                                        <td><?php echo h($this->Time->format($ride['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                            &nbsp;</td>
                                        <td><?php echo $ride['km_departure'] ?></td>
                                        <td><?= $ride['SupplierFinal'] ?></td>
                                        <td><?php echo h($this->Time->format($ride['planned_end_date'], '%d-%m-%Y %H:%M')); ?>
                                            &nbsp;</td>
                                        <td><?php echo h($this->Time->format($ride['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                                            &nbsp;</td>
                                        <td><?php echo $ride['km_arrival'] ?></td>
                                        <td>
                                            <?php switch ($ride['status_id']) {
                                                /*
                                                1: mission planifiée
                                                2: mission en cours
                                                3: mission cloturée
                                                4: mission préfacturée
                                                5: mission approuvée
                                                6: mission non approuvée
                                                7: mission facturée
                                                */
                                                case 1:
                                                    echo '<span class="label label-warning">';
                                                    echo __('Planned') . "</span>";
                                                    break;
                                                case 2:
                                                    echo '<span class="label label-danger">';
                                                    echo __('In progress') . "</span>";
                                                    break;
                                                case 3:
                                                    echo '<span class="label label-success">';
                                                    echo h(__('Closed')) . "</span>";
                                                    break;
                                                    break;
                                                case 4:
                                                    echo '<span class="label label-primary">';
                                                    echo h(__('Preinvoiced')) . "</span>";
                                                    break;
                                                case 5:
                                                    echo '<span class="label bg-olive">';
                                                    echo h(__('Approved')) . "</span>";
                                                    break;
                                                case 6:
                                                    echo '<span class="label bg-maroon">';
                                                    echo h(__('Not approved')) . "</span>";
                                                    break;
                                                case 7:
                                                    echo '<span class="label btn-bitbucket">';
                                                    echo h(__('Invoiced')) . "</span>";
                                                    break;

                                            } ?>

                                        </td>
                                        <td><?php echo $ride['user'] ?></td>
                                        <td><?php echo h($this->Time->format($ride['created'], '%d-%m-%Y %H:%M')); ?>
                                            &nbsp;</td>
                                        <td><?php echo $ride['modifier'] ?></td>
                                        <td><?php echo h($this->Time->format($ride['modified'], '%d-%m-%Y %H:%M')); ?>
                                            &nbsp;</td>

                                    </tr>
                                    <?php }
                                    }

                                    ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="tab-pane" id="tab_3">

                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <div class="col-lg-12">
                            <div class="card-box p-b-0">
                                <?php if (!empty($consumptions)) { ?>
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="80%">
                                        <thead>
                                        <tr>

                                            <th><?php echo $this->Paginator->sort('type_consumption_used', __('Consumption type')); ?></th>
                                            <th><?php echo $this->Paginator->sort('consumption_date', __('Consumption date')); ?></th>
                                            <th><?php echo $this->Paginator->sort('nb_coupon', __('Nb coupon')); ?></th>
                                            <th><?php echo $this->Paginator->sort('first_number_coupon', __('First number coupon')); ?></th>
                                            <th><?php echo $this->Paginator->sort('last_number_coupon', __('Last number coupon')); ?></th>
                                            <th><?php echo $this->Paginator->sort('', __('Serial numbers')); ?></th>
                                            <th><?php echo $this->Paginator->sort('species', __('Species')); ?></th>
                                            <th><?php echo $this->Paginator->sort('tank_id', __('Tank')); ?></th>
                                            <th><?php echo $this->Paginator->sort('consumption_liter', __('Consumption liter')); ?></th>
                                            <th><?php echo $this->Paginator->sort('fuel_card_id', __('Cards')); ?></th>
                                            <th><?php echo $this->Paginator->sort('species_card', __('Species card')); ?></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($consumptions as $consumption) { ?>
                                            <tr>
                                                <?php
                                                switch ($consumption['Consumption']['type_consumption_used']) {
                                                    case ConsumptionTypesEnum::coupon :
                                                        ?>
                                                        <td> <?php echo __('Coupons'); ?></td>
                                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?> </td>
                                                        <td><?php echo h($consumption['Consumption']['nb_coupon']); ?> </td>
                                                        <td><?php echo h($consumption['Consumption']['first_number_coupon']); ?></td>
                                                        <td><?php echo h($consumption['Consumption']['first_number_coupon']); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <?php break;
                                                    case ConsumptionTypesEnum::species:
                                                        ?>
                                                        <td> <?php echo __('Species'); ?></td>
                                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?php echo h($consumption['Consumption']['species']); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <?php break;
                                                    case ConsumptionTypesEnum::tank:
                                                        ?>
                                                        <td> <?php echo __('Tank'); ?></td>
                                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?php echo h($consumption['Tank']['name']); ?></td>
                                                        <td><?php echo h($consumption['Consumption']['consumption_liter']); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <?php break;
                                                    case ConsumptionTypesEnum::card:
                                                        ?>
                                                        <td> <?php echo __('Cards'); ?></td>
                                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?php echo h($consumption['FuelCard']['reference']); ?></td>
                                                        <td><?php echo h($consumption['Consumption']['species_card']); ?></td>
                                                        <?php break;
                                                }

                                                ?>


                                            </tr>

                                        <?php } ?>

                                        </tbody>
                                    </table>

                                <?php } ?>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="tab-pane" id="tab_4">

                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <div class="col-lg-12">
                            <div class="card-box p-b-0">
                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                       width="80%">
                                    <thead>
                                    <tr>

                                        <th><?php echo $this->Paginator->sort('reference', __('Reference').__(' mission')); ?></th>
                                        <th><?php echo $this->Paginator->sort('AttachmentType.name', __('Type')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Attachment.attachment_number', __('Number')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Attachment.name', __('Attachment')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Attachment.validation', __('Validation')); ?></th>



                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <?php
                                        $i =1;
                                        $nbAttachment = count($attachments);
                                        echo "<div class='form-group'>" . $this->Form->input('nb_attachment', array(
                                                'label' => '',
                                                'type' => 'hidden',
                                                'id' => 'nbAttachment',
                                                'value' => $nbAttachment,
                                            )) . "</div>";
                                        foreach ($attachments as $attachment) {

                                        $file='/attachments/missions/'. $attachment['Attachment']['attachment_type_id'].'/'. $attachment['Attachment']['name'];
                                            ?>
                                    <tr>
                                        <td><?php echo $attachment['SheetRideDetailRide']['reference'] ?></td>
                                        <td><?= $attachment['AttachmentType'] ['name'] ; ?></td>
                                        <td><?= $attachment['Attachment'] ['attachment_number'] ; ?></td>
                                        <td>
                                            <?= $this->Html->Link($attachment['Attachment']['name'],
                                                '/sheetRides/downloadAttachement?file='.$file.'&filename='.$attachment['Attachment']['name'],
                                                array('class' => 'attachments', 'target' => '_blank')
                                            ); ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo "<div class='form-group'>" . $this->Form->input('Attachment.'.$i.'.id', array(
                                                    'label' => '',
                                                    'type' => 'hidden',
                                                    'id' => 'attachment'.$i,
                                                    'value' => $attachment['Attachment']['id'],
                                                )) . "</div>";

                                            ?>
                                        <input
                                               class="input-radio" type="radio"
                                               name="data[Attachment][<?php echo $i; ?>][validation]"
                                               value=0 <?php if($attachment['Attachment']['validation']== 0) { ?> checked='checked' <?php } ?>  disabled="disabled">
                                        <span class="label-radio"><?php echo __('New attachment') ?></span>
                                        <input
                                               class="input-radio" type="radio"
                                               name="data[Attachment][<?php echo $i; ?>][validation]"
                                               value=2 <?php if($attachment['Attachment']['validation']== 1) { ?> checked='checked' <?php } ?>>
                                        <span class="label-radio"> <?php echo __('Attachment confirmed') ?></span>

                                        <input
                                               class="input-radio" type="radio"
                                               name="data[Attachment][<?php echo $i; ?>][validation]"
                                               value=1 <?php if($attachment['Attachment']['validation']== 2) { ?> checked='checked' <?php } ?>>
                                            <span class="label-radio"> <?php echo __('Redo the scan') ?></span>
                                        </td>

                                    <?php
                                        $i ++;

                                        } ?>
                                    </tr>
                                    </tbody>
                                </table>
                                <?php if(!empty($attachments)) { ?>
                                <button style="float: right;" type='button' name='add' id='add' class='btn btn-success'
                                        onclick='saveValidations()'><?= __('Save validation') ?></button>
                                <br/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<div style='clear:both; padding-top: 10px;'></div>

<?php $this->start('script'); ?>

<script type="text/javascript">


    $(document).ready(function () {

    });

    function saveValidations() {

        var nbAttachment = jQuery('#nbAttachment').val();
        var attachmentIds = new Array();
        var validations = new Array();
        for (var i=1; i<=nbAttachment ; i++){
            attachmentIds.push(jQuery('#attachment' + '' + i+ '').val());
            validations.push($("input[name='data[Attachment][" + i+ "][validation]']:checked").val())
        }



        jQuery.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url('/sheetRides/saveValidations/')?>",
            dataType: "json",
            data: { attachmentIds: JSON.stringify(attachmentIds),  validations: JSON.stringify(validations)},
            success: function (json) {
                if (json.response == "true") {

                    $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-success alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Validations has been saved.'); ?></div></div>');
                    scrollToAnchor('container-fluid');
                }
            }
        });
    }
</script>
<?php $this->end(); ?>
