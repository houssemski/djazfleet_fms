<?php

$this->request->data['Car']['circulation_date'] = $this->Time->format($this->request->data['Car']['circulation_date'], '%d-%m-%Y');
$this->request->data['Car']['date_approval'] = $this->Time->format($this->request->data['Car']['date_approval'], '%d-%m-%Y');
$this->request->data['Car']['purchase_date'] = $this->Time->format($this->request->data['Car']['purchase_date'], '%d-%m-%Y');
$this->request->data['Car']['reception_date'] = $this->Time->format($this->request->data['Car']['reception_date'], '%d-%m-%Y');
$this->request->data['Car']['credit_date'] = $this->Time->format($this->request->data['Car']['credit_date'], '%d-%m-%Y');
$this->request->data['Car']['date_planned_end'] = $this->Time->format($this->request->data['Car']['date_planned_end'], '%d-%m-%Y');
$this->request->data['Car']['date_real_end'] = $this->Time->format($this->request->data['Car']['date_real_end'], '%d-%m-%Y');
?><h4 class="page-title"> <?=__('Save copy'); ?></h4>
<?php $this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end(); ?>
<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Car', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Purchase / Credit') ?></a></li>
                    <li><a href="#tab_3" data-toggle="tab"><?= __('Performance / Consumption') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                       // echo $this->Form->input('id');
                        if ($autocode==0){
                            echo "<div class='form-group'>" . $this->Form->input('code', array(
                                    'placeholder' => __('Enter code'),
                                    'label' => __('Code'),
                                    'value'=>'',
                                    'class' => 'form-control',
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The code must be unique") . '</label></div>', true)
                                )) . "</div>";
                        }
                        echo "<div class='form-group input-button' id='parcs'>" . $this->Form->input('parc_id', array(
                                'label' => __('Parc'),
                                'class' => 'form-control',
                                'empty' =>''
                            )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalParc">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapParc"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addParc"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayParc", 'escape' => false, "title" => __("Add Parc"))); ?>

                        </div>
                        <div style="clear:both"></div>
                       <?php  echo "<div class='form-group input-button' id='departments'>" . $this->Form->input('department_id', array(
                                'label' => __('Department'),
                                'class' => 'form-control',
                                'empty' =>''
                            )) . "</div>";?>

                            <!-- overlayed element -->
                       <div id="dialogModalDepartment">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapDepartment"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addDepartment"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayDepartment", 'escape' => false, "title" => __("Add Department"))); ?>

                        </div>
                        <div style="clear:both"></div>
                       <?php  echo "<div class='form-group input-button' id='marks'>" . $this->Form->input('mark_id', array(
                                'label' => __('Mark'),
                                'class' => 'form-control',
                                'id' => 'mark',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModal">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrap"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addMark"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => __("Add Mark"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button'><span id='model'>" . $this->Form->input('carmodel_id', array(
                                'label' => __('Model'),
                                'default' => $this->request->data['Car']['carmodel_id'],
                                'class' => 'form-control',
                            )) . "</span></div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalModel">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapModel"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addModel"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayModel", 'escape' => false, "title" => __("Add model"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <br/>
                        <?php
                    
                        echo "<div class='form-group input-button' id='carcategories'>" . $this->Form->input('car_category_id', array(
                                'label' => __('Car category'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalCategory">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapCategory"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addCategory"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCategory", 'escape' => false, "title" => __("Add Car Category"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button' id='cartypes'>" . $this->Form->input('car_type_id', array(
                                'label' => __('Car type'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalType">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapType"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addType"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayType", 'escape' => false, "title" => __("Add Car Type"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button' id='fuels'>" . $this->Form->input('fuel_id', array(
                                'label' => __('Fuel'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalFuel">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapFuel"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addFuel"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayFuel", 'escape' => false, "title" => __("Add Fuel"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                          echo "<div class='form-group audiv1'>" . $this->Form->input('fuel_gpl', array(
                                'label' => __('Fuel GPL'),
                                'id' => 'fuel_gpl',
                            )) . "</div>"; ?>
                            <div style="clear:both"></div>
                 <?php       echo "<div class='form-group'>" . $this->Form->input('nbplace', array(
                                'placeholder' => __('Enter place number'),
                                'label' => __('Place number'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('nbdoor', array(
                                'label' => __('Door number'),
                                'placeholder' => __('Enter door number'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('immatr_prov', array(
                                'placeholder' => __('Enter provisional registration'),
                                'label' => __('Provisional registration'),
                                'value' => '',
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('immatr_def', array(
                                'label' => __('Final registration'),
                                'placeholder' => __('Enter final registration'),
                                'value' => '',
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('chassis', array(
                                'label' => __('Chassis'),
                                'placeholder' => __('Enter chassis'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group color2'>" . $this->Form->input('color2', array(
                                'label' => __('Color'),
                                'placeholder' => __('Enter color'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group my-colorpicker colorpicker-element color'>" . $this->Form->input('color', array(
                                'label' => __('Color'),
                                'placeholder' => __('Select color'),
                                'class' => 'form-control',
                            )) . "<div class='input-group-addon coloraddon'>
                        <i style='background-color: rgb(255, 255, 255);'></i>
                        </div></div>";
                        echo "<div class='form-group'>" . $this->Form->input('circulation_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Circulation date') . '</label><div class="input-group date"><label for="CarCirculationDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'circulationdate',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('date_approval', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Final registration date') . '</label><div class="input-group date"><label for="CarCirculationDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'approvaldate',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('radio_code', array(
                                'label' => __('Radio code'),
                                'placeholder' => __('Enter radio code'),
                                'class' => 'form-control',
                            )) . "</div>";



 $Dir_yellowcard='yellowcards';
            $id_dialog= 'dialogModalDir';
            $id_input= 'yellowcard';

                ?>
                    <div id="dialogModalDir">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapDir"></div>
                        </div> 

<?php 
            
           
              echo "<div class='col-sm-3 yellowcarddiv' id='yellowcard'>" . $this->Form->input('yellow_card_dir', array(
                        'label' => __('Yellow Card'),
                        'readonly' => true,
                        
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "cars", "action" => "openDir",$Dir_yellowcard,$id_dialog,$id_input),
                                        array("class" => "btn btn-default overlayDir", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>'; ?>


            

	
	 <!-- COMPONENT START -->
    <div class="form-group1">
        <div class="input-group "  id='yellow-file' >
          
             <?php      echo "<div class='form-groupee' style='Display:none;'>" . $this->Form->input('yellow_card', array(
                                'label' => __('Yellow Card'),
                                'class' => 'form-cont',
								'id'=>'yellow_card',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='yellow';
							echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('file_yellow', array(
                        'label' => __('Yellow Card'),
                        'readonly' => true,
                        'id'=>'file_yellow',
						'value'=>$this->request->data['Car']['yellow_card'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
					echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile_yellow',
                        )). '</div>';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='yellow-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>


   
   <?php          $Dir_greycard='greycards';
             $id_dialog= 'dialogModalDirGrey';
            $id_input= 'greycard';

                ?>
                    <div id="dialogModalDirGrey">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapDirGrey"></div>
                        </div> 

<?php 
            
           
              echo "<div class='col-sm-3 yellowcarddiv' id='greycard'>" . $this->Form->input('grey_card_dir', array(
                        'label' => __('Grey Card'),
                        'readonly' => true,
                        
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "cars", "action" => "openDir",$Dir_greycard,$id_dialog,$id_input),
                                        array("class" => "btn btn-default overlayDirGrey", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>'; ?>

 <!-- COMPONENT START -->
    <div class="form-group1">
        <div class="input-group "  id='grey-file' >
          
             <?php      echo "<div class='form-groupee' style='Display:none;'>" . $this->Form->input('grey_card', array(
                                'label' => __('Grey Card'),
                                'class' => 'form-cont',
								'id'=>'grey_card',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='grey';
							echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('file_grey', array(
                        'label' => __('Grey Card'),
                        'readonly' => true,
                        'id'=>'file_grey',
						'value'=>$this->request->data['Car']['grey_card'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
					echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile_grey',
                        )). '</div>';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='grey-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	
	
	
	
	
	
    <!-- COMPONENT END -->
      <!-- COMPONENT START -->
      <div class="form-group1">
        <div class="input-group "  id='picture1-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('picture1', array(
                        'label' => __('Picture'),
                        'readonly' => true,
                        'id'=>'picture1',
						'type'=>'file',
						'onchange'=>'javascript:verif_ext_attachment(1,this.id)',
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('file1', array(
                        'label' => __('picture1'),
                        'readonly' => true,
                        'id'=>'file1',
						'value'=>$this->request->data['Car']['picture1'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='picture1';
                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile1',
                        )). '</div>'; ?>
			<span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='picture1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	<div style="clear:both;"></div>

	  <!-- COMPONENT END -->
      <!-- COMPONENT START -->
      <div class="form-group1">
        <div class="input-group "  id='picture2-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('picture2', array(
                        'label' => __('Picture2'),
                        'readonly' => true,
                        'id'=>'picture2',
						'type'=>'file',
						'onchange'=>'javascript:verif_ext_attachment(1,this.id)',
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('file2', array(
                        'label' => __('picture2'),
                        'readonly' => true,
                        'id'=>'file2',
						'value'=>$this->request->data['Car']['picture2'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='picture2';
                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile2',
                        )). '</div>'; ?>
			<span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='picture2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	<div style="clear:both;"></div>
    <!-- COMPONENT END -->

	<!-- COMPONENT START -->
      <div class="form-group1">
        <div class="input-group "  id='picture3-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('picture3', array(
                        'label' => __('Picture3'),
                        'readonly' => true,
                        'id'=>'picture3',
						'type'=>'file',
						'onchange'=>'javascript:verif_ext_attachment(1,this.id)',
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('file3', array(
                        'label' => __('picture3'),
                        'readonly' => true,
                        'id'=>'file3',
						'value'=>$this->request->data['Car']['picture3'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='picture3';
                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile3',
                        )). '</div>'; ?>
			<span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='picture3-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	<div style="clear:both;"></div>
    <!-- COMPONENT END -->
	
	<!-- COMPONENT START -->
      <div class="form-group1">
        <div class="input-group "  id='picture4-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('picture4', array(
                        'label' => __('Picture'),
                        'readonly' => true,
                        'id'=>'picture4',
						'type'=>'file',
						'onchange'=>'javascript:verif_ext_attachment(1,this.id)',
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('file4', array(
                        'label' => __('picture4'),
                        'readonly' => true,
                        'id'=>'file4',
						'value'=>$this->request->data['Car']['picture4'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='picture4';
                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile4',
                        )). '</div>'; ?>
  <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='picture4-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	<div style="clear:both;"></div>
    <!-- COMPONENT END -->
	
	
	





                   









                       
                <?php        echo "<div class='form-group'>" . $this->Form->input('note', array(
                                'label' => __('Note'),
                                'placeholder' => __('Enter note'),
                                'class' => 'form-control',
                            )) . "</div>";

               /* echo "<div class='form-group audiv1'>" . $this->Form->input('visible_site', array(
                                'label' => __('Visible on the website'),
                                
                                'class' => 'form-control',
                            )) . "</div>";*/


                        ?>




                    </div>
                    <div class="tab-pane" id="tab_2">
                        <?php
                        echo "<div class='form-group input-button' id='suppliers'>" . $this->Form->input('supplier_id', array(
                                'label' => __('Supplier'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <div id="dialogModalSupplier">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapSupplier"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addSupplier"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlaySupplier",
                                            'escape' => false, "title" => __("Add supplier"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                       echo "<div class='form-group input-button' id='acquisitions'>" . $this->Form->input('acquisition_type_id', array(
                                'label' => __('Acquisition type'),
                                'id' =>"acquisition",
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <div id="dialogModalAcquisition">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAcquisition"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "cars", "action" => "addAcquisitionType"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayAcquisition",
                                            'escape' => false, "title" => __("Add Acquisition Type"))); ?>

                        </div>
                        <div style="clear:both"></div>

                    <?php 
                                
                        
                        
                        echo "<div id='interval_achat_leasing'>";
                        echo "<div class='form-group'>" . $this->Form->input('purchase_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Purchase date') .
                                    '</label><div class="input-group date"><label for="CarPurchasingDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'purchase_date',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('purchasing_price', array(
                                'label' => __('Purchasing price'),
                                'placeholder' => __('Enter purchasing price'),
                                'class' => 'form-control',
                            )) . "</div>";
                             echo "<div class='form-group'>" . $this->Form->input('current_price', array(
                                'label' => __('Current price'),
                                'placeholder' => __('Enter current price'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "</div >";

                        echo "<div id='num_cont'>";
                        echo "<div class='form-group'>" . $this->Form->input('num_contract', array(
                                'label' => __('Number contract'),
                                'placeholder' => __('Enter number contract'),
                                'class' => 'form-control',
								'id' => 'num_contract',
                            )) . "</div>";
                         echo "<div class='form-group'>" . $this->Form->input('reception_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Reception date') .
                                    '</label><div class="input-group date"><label for="CarReceptionDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'reception_date',
                            )) . "</div>";
                        echo "</div>";
                         
                            echo "<div id='interval_location'>";
                              
                           
                            
                             echo "<div class='form-group'>" . $this->Form->input('date_planned_end', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Planned end date') .
                                    '</label><div class="input-group date"><label for="CarPlannedEndDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'planned_end_date',
                            )) . "</div>";

                            echo "<div class='form-group'>" . $this->Form->input('date_real_end', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Real end date') .
                                    '</label><div class="input-group date"><label for="CarRealEndDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'real_end_date',
                            )) . "</div>";

                             

                            echo "</div>";

                            
                             echo "<div id='interval_leasing'>";
                             

                              
                        echo "<div class='form-group'>" . $this->Form->input('credit_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Credit date') .
                                    '</label><div class="input-group date"><label for="CarCreditDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'credit_date',
                            )) . "</div>";
                       
                        echo "<div class='form-group'>" . $this->Form->input('credit_duration', array(
                                'label' => __('Credit duration'),
                                'placeholder' => __('Enter credit duration in month'),
                                'class' => 'form-control',
                            )) . "</div>";
                          

                             echo "</div>";
                             echo "<div id='interval_leasing_location'>";
                            echo "<div class='form-group'>" . $this->Form->input('monthly_payment', array(
                                'label' => __('Monthly payment'),
                                'placeholder' => __('Enter monthly payment'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "</div>";
                             
                             echo "<div class='form-group'>" . $this->Form->input('nb_year_amortization', array(
                                'label' => __('Nb year amortization'),
                                'placeholder' => __('Enter Nb year amortization'),
                                'class' => 'form-control',
                            )) . "</div>";
                             echo "<div class='form-group'>" . $this->Form->input('amortization_amount', array(
                                'label' => __('Amortization amount'),
                                'placeholder' => __('Enter amortization amount'),
                                'class' => 'form-control',
                            )) . "</div>";
                             echo "<div class='form-group'>" . $this->Form->input('amortization_km', array(
                                'label' => __('Amortization km'),
                                'placeholder' => __('Enter amortization km'),
                                'class' => 'form-control',
                            )) . "</div>";
							
							
							
                     /*   echo "<div class='form-group'>" . $this->Form->input('purchasing_attachment', array(
                                'label' => __('Attachment'),
                                'class' => 'form-control filestyle',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";*/
                        ?>
						                <!-- COMPONENT START -->
      <div class="form-group1">
        <div class="input-group "  id='attachment-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('purchasing_attachment', array(
                        'label' => __('Attachment'),
                        'readonly' => true,
                        'id'=>'purchasing_attachment',
						'type'=>'file',
						
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='col-sm-3 yellowcarddiv' >" . $this->Form->input('purchasing', array(
                        'label' => __('Attachment'),
                        'readonly' => true,
                        'id'=>'purchasing',
						'value'=>$this->request->data['Car']['purchasing_attachment'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='attachment';
                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'uppurchasing',
                        )). '</div>'; ?>
			<span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	<div style="clear:both;"></div>


	
	  <!-- COMPONENT END -->
						
						
						
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('max_speed', array(
                                'label' => __('Max Speed')." (Km/h)",
                                'placeholder' => __('Enter max speed'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('reservoir', array(
                                'label' => __('Reservoir')." (L)",
                                'placeholder' => __('Enter capacity reservoir in liter'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('min_consumption', array(
                                'label' => __('Min consumption')." "."(L/100Km)",
                                'placeholder' => __('Enter min consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('max_consumption', array(
                                'label' => __('Max consumption')." "."(L/100Km)",
                                'placeholder' => __('Enter max consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                              echo "<div id='gpl'><div class='form-group' >" . $this->Form->input('reservoir_gpl', array(
                                'label' => __('Reservoir GPL') . " (L)",
                                'placeholder' => __('Enter capacity reservoir in liter'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('min_consumption_gpl', array(
                                'label' => __('Min consumption GPL') . " " . "(L/100Km)",
                                'placeholder' => __('Enter min consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('max_consumption_gpl', array(
                                'label' => __('Max consumption GPL') . " " . "(L/100Km)",
                                'placeholder' => __('Enter max consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div></div>";
                             echo "<div class='form-group'>" . $this->Form->input('limit_consumption', array(
                                'label' => __('Limit consumption') . " " . "(Km)",
                                'placeholder' => __('Enter limit consumption (Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                             echo "<div class='form-group'>" . $this->Form->input('coupon_consumption', array(
                                'label' => __('Monthly consumption of coupons') ,
                                'placeholder' => __('Enter monthly consumption of coupons'),
                                'class' => 'form-control',
                            )) . "</div>";
                             echo "<div class='form-group'>" . $this->Form->input('power_car', array(
                                'label' => __('Power car'),
                                'placeholder' => __('Enter power car'),
                                'class' => 'form-control',
                            )) . "</div>";
                        ?>
                    </div>
                </div>
            </div>
			<div class='progress-div' id="progress-div">
                <div class= 'progress-bar' id="progress-bar">
                    <div id="progress-status1">0 %</div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary',
                'label' => __('Submit'),
                'type' => 'submit',
                'id'=>'boutonValider',
                'div' => false
            )); ?>
            <?php echo $this->Form->submit(__('Cancel'), array(
                'name' => 'cancel',
                'class' => 'btn btn-primary cancelbtn',
                'label' => __('Cancel'),
                'type' => 'submit',
                'div' => false,
                'formnovalidate' => true
            )); ?>
        </div>
    </div>

</div>

<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>
<script type="text/javascript">     $(document).ready(function() {      });
    $( document ).ready(function(){
        jQuery("#circulationdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#approvaldate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#purchase_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#credit_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#reception_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#planned_end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#real_end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        if( jQuery('#fuel_gpl').is(':checked')) {

            jQuery('#gpl').css("display", "block");
        } else {

            jQuery('#gpl').css("display", "none");
        }

        jQuery('#fuel_gpl').on('ifClicked', function (event) {

            if (jQuery('#fuel_gpl').prop('checked')) {

                jQuery('#gpl').css("display", "none");
            } else {
                jQuery('#gpl').css("display", "block");
            }

        });
        if (jQuery('#acquisition').val()>0){

            if(jQuery('#acquisition').val()==2 || jQuery('#acquisition').val()==3) {
                jQuery('#interval_location').css("display", "block");
                jQuery('#purchase_date').val('');
                jQuery('#purchasing_price').val('');
                jQuery('#current_price').val('');
                jQuery('#interval_achat_leasing').css("display", "none");

                jQuery('#interval_leasing_location').css("display", "block");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery('#num_cont').css("display", "block");
            }
            if(jQuery('#acquisition').val()==1 ) {
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery('#monthly_payment').val('');
                jQuery('#interval_leasing_location').css("display", "none");
                jQuery('#num_cont').css("display", "block");
            }
            if(jQuery('#acquisition').val()==4 ) {
                jQuery('#interval_leasing').css("display", "block");
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery('#num_cont').css("display", "block");
                jQuery('#interval_leasing_location').css("display", "block");
            }



        } else {
            jQuery('#credit_date').val('');
            jQuery('#credit_duration').val('');
            jQuery('#interval_leasing').css("display", "none");
            jQuery('#purchase_date').val('');
            jQuery('#purchasing_price').val('');
            jQuery('#current_price').val('');
            jQuery('#interval_achat_leasing').css("display", "none");
            jQuery('#planned_end_date').val('');
            jQuery('#real_end_date').val('');
            jQuery('#interval_location').css("display", "none");
            jQuery('#num_contract').val('');
            jQuery('#reception_date').val('');
            jQuery('#num_cont').css("display", "none");
            jQuery('#monthly_payment').val('');
            jQuery('#interval_leasing_location').css("display", "none");

        }

        jQuery('#acquisition').change(function () {
            if(jQuery('#acquisition').val()==2 || jQuery('#acquisition').val()==3) {
                jQuery('#interval_location').css("display", "block");
                jQuery('#purchase_date').val('');
                jQuery('#purchasing_price').val('');
                jQuery('#current_price').val('');
                jQuery('#interval_achat_leasing').css("display", "none");

                jQuery('#interval_leasing_location').css("display", "block");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery('#num_cont').css("display", "block");
            }
            if(jQuery('#acquisition').val()==1 ) {
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery('#monthly_payment').val('');
                jQuery('#interval_leasing_location').css("display", "none");
                jQuery('#num_cont').css("display", "block");
            }
            if(jQuery('#acquisition').val()==4 ) {
                jQuery('#interval_leasing').css("display", "block");
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery('#num_cont').css("display", "block");
                jQuery('#interval_leasing_location').css("display", "block");
            }
        });

        $("#upfile1").click(function () {
            $("#picture1").trigger('click');
        });

        $("#picture1").change(function () {

            $("#file1").val($("#picture1").val());

        });

        $("#upfile2").click(function () {
            $("#picture2").trigger('click');

        });

        $("#picture2").change(function () {

            $("#file2").val($("#picture2").val());

        });

        $("#upfile3").click(function () {
            $("#picture3").trigger('click');

        });

        $("#picture3").change(function () {

            $("#file3").val($("#picture3").val());

        });

        $("#upfile4").click(function () {
            $("#picture4").trigger('click');

        });

        $("#picture4").change(function () {

            $("#file4").val($("#picture4").val());

        });

        $("#upfile_grey").click(function () {
            $("#grey_card").trigger('click');

        });

        $("#grey_card").change(function () {

            $("#file_grey").val($("#grey_card").val());

        });

        $("#upfile_yellow").click(function () {
            $("#yellow_card").trigger('click');

        });

        $("#yellow_card").change(function () {

            $("#file_yellow").val($("#yellow_card").val());

        });

        $("#uppurchasing").click(function () {
            $("#purchasing_attachment").trigger('click');

        });

        $("#purchasing_attachment").change(function () {

            $("#purchasing").val($("#purchasing_attachment").val());

        });

        jQuery('#mark').change(function () {
            // alert('test');
            jQuery('#model').load('<?php echo $this->Html->url('/cars/getModels/')?>' + $(this).val());
        });

        jQuery("#dialogModal").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlay").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrap').load(jQuery(this).attr("href"));  //load content from href of link
            jQuery('#dialogModal').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
            jQuery('#dialogModal').dialog('open');  //open the dialog
        });

        jQuery("#dialogModalModel").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayModel").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapModel').load(jQuery(this).attr("href"));  //load content from href of link
            jQuery('#dialogModalModel').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
            jQuery('#dialogModalModel').dialog('open');  //open the dialog
        });

        jQuery("#dialogModalCategory").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayCategory").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCategory').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCategory').dialog('open');
        });

        jQuery("#dialogModalType").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayType").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapType').load(jQuery(this).attr("href"));
            jQuery('#dialogModalType').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalType').dialog('open');
        });

        jQuery("#dialogModalFuel").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayFuel").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapFuel').load(jQuery(this).attr("href"));
            jQuery('#dialogModalFuel').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalFuel').dialog('open');
        });
        jQuery("#dialogModalParc").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayParc").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapParc').load(jQuery(this).attr("href"));
            jQuery('#dialogModalParc').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalParc').dialog('open');
        });
        jQuery("#dialogModalSupplier").dialog({
            autoOpen: false,
            height: 480,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery("#dialogModalDepartment").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayDepartment").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapDepartment').load(jQuery(this).attr("href"));
            jQuery('#dialogModalDepartment').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalDepartment').dialog('open');


        });
        jQuery(".overlaySupplier").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapSupplier').load(jQuery(this).attr("href"));
            jQuery('#dialogModalSupplier').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalSupplier').dialog('open');
        });
        jQuery(".my-colorpicker").colorpicker();

        jQuery("#dialogModalAcquisition").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayAcquisition").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAcquisition').load(jQuery(this).attr("href"));
            jQuery('#dialogModalAcquisition').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAcquisition').dialog('open');
        });



        jQuery("#dialogModalDir").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayDir").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapDir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalDir').dialog('open');
        });


        jQuery("#dialogModalDirGrey").dialog({
            autoOpen: false,
            height: 500,
            width: 700,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayDirGrey").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapDirGrey').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDirGrey').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalDirGrey').dialog('open');
        });


        Array.prototype.inArray = function (value)
        {
            // Returns true if the passed value is found in the
            // array. Returns false if it is not.
            var i;
            for (i=0; i < this.length; i++)
            {
                if (this[i] == value)
                {
                    return true;
                }
            }
            return false;
        };

        $('#CarEditForm').submit(function(e) {


            e.preventDefault();

            $(this).ajaxSubmit({

                beforeSubmit: function() {

                    $("#progress-bar").width('0%');

                },

                uploadProgress: function (event, position, total, percentComplete){
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>');

                }
                ,

                success:function (){

                    window.location = '<?php echo $this->Html->url('/cars/index')?>' ;
                },
                resetForm: true
            });
            return false;





        });

    });





    	function delete_file(id) {
		//alert(id);
		
    $("#"+''+id+''+"-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                
                $(this).find("#"+''+id+''+"-btn").click(function(){
                    element.val(null);
                    $(this).parents("#"+''+id+''+"-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents("#"+''+id+''+"-file").prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}



function verif_ext_attachment (img,id)  {
	
	pic1=jQuery('#'+id).val();
	pic1=pic1.split('.');
	
	if (img==1){
	
		  var typeArr= ['jpg', 'jpeg', 'gif','png', 'pdf'];
//use of inArray
			if(!typeArr.inArray(pic1[1])) {
				msg = '<?php echo __('Only gif, png, jpg and jpeg images are allowed!')?>';
				alert(msg);
				jQuery('#'+id).val('');	
			}
	}
}






</script>

<?php $this->end(); ?>
