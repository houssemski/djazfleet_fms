<h4 class="page-title"> <?=__('Fuel card affectations'); ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>'.__('Add'),
                                array('action' => 'add'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>'.__('Delete'),
                                'javascript:submitDeleteForm("/fuelCardAffectations/deleteFuelCardAffectations/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected affectations ?')); ?>

                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->Form->input('controller', array(
        'id'=>'controller',
        'value'=>   $this->request->params['controller'],
        'type'=>'hidden'
    )); ?>

    <?= $this->Form->input('action', array(
        'id'=>'action',
        'value'=>   'liste',
        'type'=>'hidden'
    )); ?>
    

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('fuelCardAffectations/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                            </select>&nbsp; <?= __('records per page') ?>

                        </label>
                    </div>


                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('FuelCardAffectation.reference', __('Reference')); ?></th>
                        <th><?php echo $this->Paginator->sort('fuel_card_id', __('Fuel card')); ?></th>
                        <th><?php echo $this->Paginator->sort('car_id', __('Car')); ?></th>
                        <th><?php echo $this->Paginator->sort('start_date', __('Start date')); ?></th>
                        <th><?php echo $this->Paginator->sort('end_date', __('End date')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="listeDiv">
                 <?php
                 $cars=array();
                 $i=0;
                 foreach ($fuelCardAffectations as $fuelCardAffectation) {
                     $i++;

                     if ($i < count($fuelCardAffectations)) {
                         if ($fuelCardAffectations[$i]['FuelCardAffectation']['id'] == $fuelCardAffectation['FuelCardAffectation']['id']) {
                             if ($param == 1) {
                                 $cars[] = $fuelCardAffectation['Car']['code'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                             } else if ($param == 2) {
                                 $cars[] = $fuelCardAffectation['Car']['immatr_def'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                             }

                         } else {
                             if ($param == 1) {
                                 $cars[] = $fuelCardAffectation['Car']['code'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                             } else if ($param == 2) {
                                 $cars[] = $fuelCardAffectation['Car']['immatr_def'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                             }

                             ?>

                             <tr id="row<?= $fuelCardAffectation['FuelCardAffectation']['id'] ?>">
                                 <td>
                                     <input id="idCheck" type="checkbox" class='id'
                                            value=<?php echo $fuelCardAffectation['FuelCardAffectation']['id'] ?>>
                                 </td>
                                 <td><?php echo $fuelCardAffectation['FuelCardAffectation']['reference'] ?> </td>
                                 <td>
                                     <?php echo $fuelCardAffectation['FuelCard']['reference'] ?>
                                 </td>
                                 <td>
                                     <?php
                                     $nbCar = count($cars);

                                     $j = 1;
                                     foreach ($cars as $car) {
                                         if ($j == $nbCar) {
                                             echo $car;
                                         } else {
                                             echo $car . ' / ';
                                         }
                                         $j++;
                                     } ?>
                                 </td>
                                 <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['start_date'], '%d-%m-%Y')) ?></td>
                                 <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['end_date'], '%d-%m-%Y')) ?></td>
                                 <td class="actions">
                                     <div  class="btn-group ">
                                         <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                             <i class="fa fa-list fa-inverse"></i>
                                         </a>
                                         <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                             <span class="caret"></span>
                                         </button>

                                         <ul class="dropdown-menu" style="min-width: 70px;">

                                             <li>
                                                 <?= $this->Html->link(
                                                     '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                     array('action' => 'View',$fuelCardAffectation['FuelCardAffectation']['id']),
                                                     array('escape' => false, 'class'=>'btn btn-success')
                                                 ); ?>
                                             </li>

                                             <li>
                                                 <?= $this->Html->link(
                                                     '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                     array('action' => 'Edit', $fuelCardAffectation['FuelCardAffectation']['id']),
                                                     array('escape' => false , 'class'=>'btn btn-primary')
                                                 ); ?>
                                             </li>


                                             <li>
                                                 <?php
                                                 echo $this->Form->postLink(
                                                     '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                     array('action' => 'delete', $fuelCardAffectation['FuelCardAffectation']['id']),
                                                     array('escape' => false , 'class'=>'btn btn-danger'),
                                                     __('Are you sure you want to delete %s?',$fuelCardAffectation['FuelCardAffectation']['reference'])); ?>
                                             </li>
                                         </ul>
                                     </div>




                                 </td>


                             </tr>

                             <?php  $fuelCardAffectationId = $fuelCardAffectation['FuelCardAffectation']['id'];
                             $cars = array();
                         }


                     } else {
                         if ($param == 1) {
                             $cars[] = $fuelCardAffectation['Car']['code'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                         } else if ($param == 2) {
                             $cars[] = $fuelCardAffectation['Car']['immatr_def'] . " - " . $fuelCardAffectation['Carmodel']['name'];
                         }

                         ?>


                         <tr id="row<?= $fuelCardAffectation['FuelCardAffectation']['id'] ?>">
                             <td class='case'>

                                 <input id="idCheck" type="checkbox" class='id'
                                        value=<?php echo $fuelCardAffectation['FuelCardAffectation']['id'] ?>>
                             </td>
                             <td><?php echo $fuelCardAffectation['FuelCardAffectation']['reference'] ?> </td>
                             <td> <?php echo $fuelCardAffectation['FuelCard']['reference'] ?> </td>
                             <td><?php
                                 $nbCar = count($cars);

                                 $j = 1;
                                 foreach ($cars as $car) {
                                     if ($j == $nbCar) {
                                         echo $car;
                                     } else {
                                         echo $car . ' / ';
                                     }
                                     $j++;
                                 } ?>

                             </td>
                             <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['start_date'], '%d-%m-%Y')) ?></td>
                             <td> <?php echo h($this->Time->format($fuelCardAffectation['FuelCardAffectation']['end_date'], '%d-%m-%Y')) ?></td>
                             <td class="actions">
                                 <div  class="btn-group ">
                                     <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                         <i class="fa fa-list fa-inverse"></i>
                                     </a>
                                     <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                         <span class="caret"></span>
                                     </button>

                                     <ul class="dropdown-menu" style="min-width: 70px;">

                                         <li>
                                             <?= $this->Html->link(
                                                 '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                 array('action' => 'View',$fuelCardAffectation['FuelCardAffectation']['id']),
                                                 array('escape' => false, 'class'=>'btn btn-success')
                                             ); ?>
                                         </li>

                                         <li>
                                             <?= $this->Html->link(
                                                 '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                 array('action' => 'Edit', $fuelCardAffectation['FuelCardAffectation']['id']),
                                                 array('escape' => false , 'class'=>'btn btn-primary')
                                             ); ?>
                                         </li>


                                         <li>
                                             <?php
                                             echo $this->Form->postLink(
                                                 '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                 array('action' => 'delete', $fuelCardAffectation['FuelCardAffectation']['id']),
                                                 array('escape' => false , 'class'=>'btn btn-danger'),
                                                 __('Are you sure you want to delete %s?',$fuelCardAffectation['FuelCardAffectation']['reference'])); ?>
                                         </li>
                                     </ul>
                                 </div>
                             </td>


                         </tr>





                     <?php
                     }
                 }

                 ?>



                    </tbody>
                </table>

                <div id="pagination" class="pull-right">
                    <?php
                    if($this->params['paging']['FuelCardCar']['pageCount'] > 1){
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>	</p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
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
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div><!-- /.modal -->

<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function() {      });








</script>
<?php $this->end(); ?>
