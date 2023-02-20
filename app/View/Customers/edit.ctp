
<?php
if(isset($this->request->data['Customer']['birthday']) && !empty($this->request->data['Customer']['birthday'])){
    $this->request->data['Customer']['birthday'] = $this->Time->format($this->request->data['Customer']['birthday'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['identity_card_date1']) && !empty($this->request->data['Customer']['identity_card_date1'])){
    $this->request->data['Customer']['identity_card_date1'] = $this->Time->format($this->request->data['Customer']['identity_card_date1'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['driver_license_date2']) && !empty($this->request->data['Customer']['driver_license_date2'])){
    $this->request->data['Customer']['driver_license_date2'] = $this->Time->format($this->request->data['Customer']['driver_license_date2'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['driver_license_expires_date3']) && !empty($this->request->data['Customer']['driver_license_expires_date3'])){
    $this->request->data['Customer']['driver_license_expires_date3'] = $this->Time->format($this->request->data['Customer']['driver_license_expires_date3'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['driver_license_expires_date4']) && !empty($this->request->data['Customer']['driver_license_expires_date4'])){
    $this->request->data['Customer']['driver_license_expires_date4'] = $this->Time->format($this->request->data['Customer']['driver_license_expires_date4'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['driver_license_expires_date5']) && !empty($this->request->data['Customer']['driver_license_expires_date5'])){
    $this->request->data['Customer']['driver_license_expires_date5'] = $this->Time->format($this->request->data['Customer']['driver_license_expires_date5'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['driver_license_expires_date6']) && !empty($this->request->data['Customer']['driver_license_expires_date6'])){
    $this->request->data['Customer']['driver_license_expires_date6'] = $this->Time->format($this->request->data['Customer']['driver_license_expires_date6'], '%d-%m-%Y');
}


if(isset($this->request->data['Customer']['passport_date']) && !empty($this->request->data['Customer']['passport_date'])){
    $this->request->data['Customer']['passport_date'] = $this->Time->format($this->request->data['Customer']['passport_date'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['entry_date']) && !empty($this->request->data['Customer']['entry_date'])){
    $this->request->data['Customer']['entry_date'] = $this->Time->format($this->request->data['Customer']['entry_date'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['declaration_date']) && !empty($this->request->data['Customer']['declaration_date'])){
    $this->request->data['Customer']['declaration_date'] = $this->Time->format($this->request->data['Customer']['declaration_date'], '%d-%m-%Y');
}
if(isset($this->request->data['Customer']['exit_date']) && !empty($this->request->data['Customer']['exit_date'])){
    $this->request->data['Customer']['exit_date'] = $this->Time->format($this->request->data['Customer']['exit_date'], '%d-%m-%Y');
}

	?><h4 class="page-title"> <?=__('Edit employee');?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<div class="box">
    <div class="edit form card-box p-b-0">

<?php echo $this->Form->create('Customer', array('enctype'=>'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">

            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
					
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Administratif information') ?></a></li>
					
                    <li><a href="#tab_3" data-toggle="tab"><?= __('Official documents') ?></a></li>
                    <li ><a href="#tab_4" data-toggle="tab"><?= __('Additional Information') ?></a></li>
					
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
	<?php
		echo $this->Form->input('id');
        if ($autocode==0){
            echo "<div class='form-group'>" . $this->Form->input('code', array(
                    'placeholder' => __('Enter code'),
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The code must be unique") . '</label></div>', true)
                )) . "</div>";
        }else {
            echo "<div class='form-group'>" . $this->Form->input('code', array(
                    'placeholder' => __('Enter code'),
                    'label' => __('Code'),
                    'readonly'=>true,
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The code must be unique") . '</label></div>', true)
                )) . "</div>";
        }
             
				echo "<div class='form-group input-button' id='categories'>" . $this->Form->input('customer_category_id', array(
                    'label' => __('Category'),
                    'class' => 'form-control select3',
                    'empty' => ''
                )) . "</div>";  ?>
				
			 <!-- overlayed element -->
            <div id="dialogModal">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrap"></div>
            </div>
            <div class="popupactions">

                        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "customers", "action" => "addcategory"),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => __('Add')." ".lcfirst(__("Conductor"))." ".__('Category'))); ?>

            </div>
            <div style="clear:both"></div>
				
				
			<?php
           
              echo "<div class='form-group input-button' id='groups'>" . $this->Form->input('customer_group_id', array(
                    'label' => __('Group'),
                    'class' => 'form-control select3',
                    'empty' => ''
                )) . "</div>"; ?>
            
            <!-- overlayed element -->
            <div id="dialogModalGroup">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapGroup"></div>
            </div>
            <div class="popupactions">

                        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "customers", "action" => "addCustomerGroup"),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayGroup", 'escape' => false, "title" => __("Add Group"))); ?>

            </div>
            
            
            <div style="clear:both"></div>
            <?php echo "<div class='form-group input-button' id='zones'>" . $this->Form->input('zone_id', array(
                    'label' => __('Zone'),
                    'class' => 'form-control select3',
                    'empty' => ''
                )) . "</div>"; ?>
            <!-- overlayed element -->
            <div id="dialogModalZone">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapZone"></div>
            </div>
            <div class="popupactions">

                        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "customers", "action" => "addZone"),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayZone", 'escape' => false, "title" => __("Add Zone"))); ?>

            </div>
            <div style="clear:both"></div>
                
                <div id='parc-div'>
            <?php echo "<div class='form-group input-button' id='parcs'>" . $this->Form->input('parc_id', array(
                                'label' => __('Parc'),
                                'class' => 'form-control select3',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalParc">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapParc"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "customers", "action" => "addParc"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayParc", 'escape' => false, "title" => __("Add Parc"))); ?>

                        </div>
                        <div style="clear:both"></div>
			</div>
			
		<?php 
		   echo "<div class='form-group'>" . $this->Form->input('first_name', array(
                    'label' => __('First name'),
                    'placeholder' => __('Enter first name'),
                    'class' => 'form-control',
					'id'=>'first_name',
                    'empty' => ''
                )) . "</div>"; ?>
				
			<div id='info-conductor'>
            <?php echo "<div class='form-group'>" . $this->Form->input('last_name', array(
                    'label' => __('Last name'),
                    'placeholder' => __('Enter last name'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
              echo "<div class='form-group'>" . $this->Form->input('birthday', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Birthday') . '</label><div class="input-group date"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'birthday',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('birthplace', array(
                    'label' => __('Birthplace'),
                    'placeholder' => __('Enter birthplace'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
              
           echo "<div class='form-group'>" . $this->Form->input('blood_group', array(
                    'label' => __('Blood group'),
                    'placeholder' => __('Enter blood group'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
                       
  if (!$hidden_information['Parameter']['company']) {
   echo "<div class='form-group'>" . $this->Form->input('company', array(
                    'label' => __('Company'),
                    'placeholder' => __('Enter company'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
		}
            echo "<div class='form-group input-button' id='departments'>" . $this->Form->input('department_id', array(
                    'label' => __('Department'),
                    'id'=>'department',
                    'class' => 'form-control select3',
                    'empty' => ''
                )) . "</div>";?>
                 <!-- overlayed element -->
                       <div id="dialogModalDepartment">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapDepartment"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "customers", "action" => "addDepartment"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayDepartment", 'escape' => false, "title" => __("Add Department"))); ?>

                        </div>
                        <div style="clear:both"></div>


                <div id ='services'></div>

        <?php   echo "<div class='form-group'>" . $this->Form->input('adress', array(
                    'label' => __('Address'),
                    'placeholder' => __('Enter address'),
                    'class' => 'form-control',
                   // 'id'=>"addresspicker",
                    'empty' => ''
                )) . "</div>";  


      echo "<div class='form-group'>" . $this->Form->input('tel', array(
                    'label' => __('Phone'),
                    'placeholder' => __('Enter phone'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('mobile', array(
                    'label' => __('Mobile'),
                    'placeholder' => __('Enter mobile'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('email1', array(
                    'label' => __('Email 1'),
                    'placeholder' => __('Enter email 1'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('email2', array(
                    'label' => __('Email 2'),
                    'placeholder' => __('Enter email 2'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
             if (!$hidden_information['Parameter']['email3']) {
            echo "<div class='form-group'>" . $this->Form->input('email3', array(
                    'label' => __('Email 3'),
                    'placeholder' => __('Enter email 3'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
                }
            echo "<div class='form-group'>" . $this->Form->input('adress_family', array(
                    'label' => __('Address family'),
                    'placeholder' => __('Enter address'),
                    'class' => 'form-control',
                    
                    'empty' => ''
                )) . "</div>";
             echo "<div class='form-group'>" . $this->Form->input('tel_family', array(
                    'label' => __('Tel family'),
                    'placeholder' => __('Enter tel'),
                    'class' => 'form-control',
                    
                    'empty' => ''
                )) . "</div>";
          
             if (!$hidden_information['Parameter']['job']) {
            echo "<div class='form-group'>" . $this->Form->input('job', array(
                    'label' => __('Job'),
                    'placeholder' => __('Enter job'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
                }
            echo "<div class='form-group'>" . $this->Form->input('nationality_id', array(
                    'label' => __('Nationality'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            if (!$hidden_information['Parameter']['monthly_payroll']) {
            echo "<div class='form-group'>" . $this->Form->input('monthly_payroll', array(
                    'label' => __('Monthly payroll'),
                    'placeholder' => __('Enter monthly payroll'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
                }
              
           
            ?>
 <?php if (!$hidden_information['Parameter']['note']) {
            echo "<div class='form-group'>" . $this->Form->input('note', array(
                    'label' => __('Note'),
                    'placeholder' => __('Enter note'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
           } ?>
                                 
   <!-- COMPONENT START -->

        <div  id='image-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('image', array(
                        'label' => __('Picture'),
                        'readonly' => true,
                        'id'=>'image',
						'type'=>'file',
						'onchange'=>'javascript:verif_ext_attachment(1,this.id)',
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='form-group input-button4' >" . $this->Form->input('file', array(
                        'label' => __('Picture'),
                        'readonly' => true,
                        'id'=>'file',
						'value'=>$this->request->data['Customer']['image'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='image';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upfile',
                        )). '</div>'; ?>
			<span class='popupactions'>
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='image-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>


	
	  <!-- COMPONENT END -->
	</div>
	
	

    </div>

     <div class="tab-pane" id="tab_2">
            <?php 
            echo "<div class='form-group'>" . $this->Form->input('entry_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Entry date') .
                                    '</label><div class="input-group date"><label for="CarEntryDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'entry_date',
                            )) . "</div>";

                if (!$hidden_information['Parameter']['declaration_date']) {
                  echo "<div class='form-group'>" . $this->Form->input('declaration_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Declaration date') .
                                    '</label><div class="input-group date"><label for="CarDeclarationDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'declaration_date',
                            )) . "</div>";
                }
                  echo "<div class='form-group'>" . $this->Form->input('exit_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Exit date') .
                                    '</label><div class="input-group date"><label for="CarExitDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'exit_date',
                            )) . "</div>";
                            if (!$hidden_information['Parameter']['affiliate']) {
                           echo "<div class='form-group input-button' id ='affiliates'>" . $this->Form->input('affiliate_id', array(
                                'label' => __('Affiliate'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>"; ?>
							
							 <!-- overlayed element -->
                        <div id="dialogModalAffiliate">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAffiliate"></div>
                        </div>
                        <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "customers", "action" => "addAffiliate"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayAffiliate", 'escape' => false, "title" => __("Add Affiliate"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                            }
                             if (!$hidden_information['Parameter']['ccp']) {
                             echo "<div class='form-group'>" . $this->Form->input('ccp', array(
                                'label' => __('N&ordm; CCP'),
                                'placeholder' => __('Enter postal ccount'),
                                'class' => 'form-control',
                            )) . "</div>";
                            }
                            if (!$hidden_information['Parameter']['bank_account']) {
                              echo "<div class='form-group'>" . $this->Form->input('bank_account', array(
                                'label' => __('N&ordm; bank account'),
                                'placeholder' => __('Enter bank account'),
                                'class' => 'form-control',
                            )) . "</div>";
                            }
            ?>






            </div>
            <div class="tab-pane" id="tab_3">
            <?php 
             if (!$hidden_information['Parameter']['identity_card']) {
            echo "<div class='form-group'>" . $this->Form->input('identity_card_nu', array(
                    'label' => __('Identity card number'),
                    'placeholder' => __('Enter identity card number'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('identity_card_by', array(
                    'label' => __('Delivered by'),
                    'placeholder' => __('Enter delivered by'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('identity_card_date', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Delivery date') . '</label><div class="input-group date"><label for="deliverydate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'deliveryidentity',
                )) . "</div>";?>
    
     <!-- COMPONENT START -->

        <div   id='identity1-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('identity_card_scan1', array(
                        'label' => __('Identity card front'),
                        'readonly' => true,
                        'id'=>'identity1',
						'type'=>'file',
						
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='input-button4' >" . $this->Form->input('identity1_file', array(
                        'label' => __('Identity card front'),
                        'readonly' => true,
                        'id'=>'identity1_file',
						'value'=>$this->request->data['Customer']['identity_card_scan1'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='identity1';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upidentity1_file',
                        )). '</div>'; ?>
			<span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='identity1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>
	  <!-- COMPONENT END -->
      
     <!-- COMPONENT START -->

        <div   id='identity2-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('identity_card_scan2', array(
                        'label' => __('Identity card back'),
                        'readonly' => true,
                        'id'=>'identity2',
						'type'=>'file',
						
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
           
              echo "<div class='input-button4' >" . $this->Form->input('identity2_file', array(
                        'label' => __('Identity card back'),
                        'readonly' => true,
                        'id'=>'identity2_file',
						'value'=>$this->request->data['Customer']['identity_card_scan2'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='identity2';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upidentity2_file',
                        )). '</div>'; ?>
			<span  class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='identity2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>
	  <!-- COMPONENT END -->

<?php }?>






      <?php      echo "<div class='form-group'>" . $this->Form->input('driver_license_nu', array(
                    'label' => __('Driver license number'),
                    'placeholder' => __('Enter driver license number'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
                $options= array('1'=>__("Category A"),'2'=>__("Category B"),'3'=>__("Category C"),'4'=>__("Category D"),'5'=>__("Category E"),'6'=>__("Category F"));
                 echo "<div class='form-group'>" . $this->Form->input('driver_license_category', array(
                    'label' => __('Driver license category'),
                    'empty' => '',
                    'type'=>'select',
                    'multiple' => 'checkbox',
                    'options'=>$options,
                    'class' => ''
                    
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('driver_license_by', array(
                    'label' => __('Delivered by'),
                    'placeholder' => __('Enter delivered by'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('driver_license_date', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Delivery date') . '</label><div class="input-group date"><label for="deliverydate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'delivery',
                )) . "</div>";
           	for ($i = 1; $i<=6 ; $i++ )	 {	
			echo "<div id = 'div-expiration$i'>";	
            echo "<div class='form-group'>" . $this->Form->input('driver_license_expires_date'.$i, array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' .__('License driver').' '. __($options[$i]).' '.__('Expiration date') .'</label><div class="input-group date"><label for="expirationdate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'expiration'.$i,
                )) . "</div>";
			
			echo "</div>";
		} 
				
				
				?>



  

    <!-- COMPONENT START -->

        <div   id='driver1-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('driver_license_scan1', array(
                        'label' => __('Driver license front'),
                        'readonly' => true,
                        'id'=>'driver1',
						'type'=>'file',
                        'class' => 'form-control',
                    )) . '</div>';
           
              echo "<div class='input-button4' >" . $this->Form->input('driver1_file', array(
                        'label' => __('Driver license front'),
                        'readonly' => true,
                        'id'=>'driver1_file',
						'value'=>$this->request->data['Customer']['driver_license_scan1'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='driver1';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'updriver1_file',
                        )). '</div>'; ?>
			<span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='driver1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>
	  <!-- COMPONENT END -->


       <!-- COMPONENT START -->

        <div   id='driver2-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('driver_license_scan2', array(
                        'label' => __('Driver license back'),
                        'readonly' => true,
                        'id'=>'driver2',
						'type'=>'file',
                        'class' => 'form-control',
                    )) . '</div>';
           
              echo "<div class='input-button4' >" . $this->Form->input('driver2_file', array(
                        'label' => __('Driver license back'),
                        'readonly' => true,
                        'id'=>'driver2_file',
						'value'=>$this->request->data['Customer']['driver_license_scan2'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='driver2';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'updriver2_file',
                        )). '</div>'; ?>
			<span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='driver2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>
	  <!-- COMPONENT END -->







        <?php 

		

        if (!$hidden_information['Parameter']['passport']) {
             echo "<div class='form-group'>" . $this->Form->input('passport_nu', array(
                    'label' => __('Passport number'),
                    'placeholder' => __('Enter passport number'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('passport_by', array(
                    'label' => __('Delivered by'),
                    'placeholder' => __('Enter delivered by'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('passport_date', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Delivery date') . '</label><div class="input-group date"><label for="deliverydate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'deliverypassport',
                )) . "</div>";
             ?>
              

     <!-- COMPONENT START -->

        <div   id='passport-file' >

      <?php 
            echo "<div style='Display:none;'>" . $this->Form->input('passport_scan', array(
                        'label' => __('Passport'),
                        'readonly' => true,
                        'id'=>'passport',
						'type'=>'file',
                        'class' => 'form-control',
                    )) . '</div>';
           
              echo "<div class='input-button4' >" . $this->Form->input('passport_file', array(
                        'label' => __('Passport'),
                        'readonly' => true,
                        'id'=>'passport_file',
						'value'=>$this->request->data['Customer']['passport_scan'],
                        'class' => 'form-control',
                        
                        
                    )) . '</div>';
                    $input='passport';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        
                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'uppassport_file',
                        )). '</div>'; ?>
			<span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='passport-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>


            <div   id='chifa-file' >

      <?php
            echo "<div style='Display:none;'>" . $this->Form->input('chifa_card', array(
                        'label' => __('Chifa card'),
                        'readonly' => true,
                        'id'=>'chifa',
						'type'=>'file',
                        'class' => 'form-control',
                    )) . '</div>';

              echo "<div class='input-button4' >" . $this->Form->input('chifa_file', array(
                        'label' => __('Chifa card'),
                        'readonly' => true,
                        'id'=>'chifa_file',
						'value'=>$this->request->data['Customer']['chifa_card'],
                        'class' => 'form-control',


                    )) . '</div>';
                    $input='chifa';
                    echo "<div class='button-file'>" .$this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                        'javascript:;',
                    array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'upchifa_file',
                        )). '</div>'; ?>
			<span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='passport-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>

	<div style="clear:both;"></div>
	  <!-- COMPONENT END -->

      <?php }?>
            </div>


                    <div class="tab-pane" id="tab_4">
                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('maximum_driving_time', array(
                                'label' => __('Maximum driving time').' ('.__('Hour').(')'),
                                'class' => 'form-control',

                                'empty' => ''
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('break_time', array(
                                'label' => __('Break time').' ('.__('Hour').(')'),
                                'class' => 'form-control',

                                'empty' => ''
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('authorized', array(
                                'label' => __('Authorized'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('uuid', array(
                                'label' => __("UUID"),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                        ?>
                    </div >









                </div>
			  
			  
			  
			  
            </div>
        </div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id'=>'boutonValider',
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

</div>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        jQuery("#birthday").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#delivery").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#deliveryidentity").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#deliverypassport").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#entry_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#exit_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#declaration_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		for(i =1; i<= 6; i++){
			jQuery("#expiration"+i).inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		}

        jQuery('#department').change(function () {
            if (jQuery(this).val() > 0) {
                jQuery('#services').load('<?php echo $this->Html->url('/customers/getServicesByDepartment/')?>' + jQuery(this).val(), function(){
                    jQuery('.select2').select2();
                });
            }
        });
        if(jQuery('#department').val()>0){
            jQuery('#services').load('<?php echo $this->Html->url('/customers/getServicesByDepartment/')?>' + jQuery(this).val(), function(){
                jQuery('.select2').select2();
            });
        }
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

        $("#upfile").click(function () {
            $("#image").trigger('click');

        });

        $("#image").change(function () {

            $("#file").val($("#image").val());

        });

        $("#upidentity1_file").click(function () {
            $("#identity1").trigger('click');

        });

        $("#identity1").change(function () {

            $("#identity1_file").val($("#identity1").val());

        });


        $("#upidentity2_file").click(function () {
            $("#identity2").trigger('click');

        });

        $("#identity2").change(function () {

            $("#identity2_file").val($("#identity2").val());

        });


        $("#updriver1_file").click(function () {
            $("#driver1").trigger('click');

        });

        $("#driver1").change(function () {

            $("#driver1_file").val($("#driver1").val());

        });


        $("#updriver2_file").click(function () {
            $("#driver2").trigger('click');

        });

        $("#driver2").change(function () {

            $("#driver2_file").val($("#driver2").val());

        });

        $("#uppassport_file").click(function () {
            $("#passport").trigger('click');

        });

        $("#passport").change(function () {

            $("#passport_file").val($("#passport").val());

        });


        $("#upchifa_file").click(function () {
            $("#chifa").trigger('click');

        });

        $("#chifa").change(function () {

            $("#chifa_file").val($("#chifa").val());

        });

        jQuery("#dialogModal").dialog({
            autoOpen: false,
            height: 400,
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
        jQuery("#dialogModalZone").dialog({
            autoOpen: false,
            height: 300,
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
        jQuery(".overlayZone").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapZone').load(jQuery(this).attr("href"));  //load content from href of link
            jQuery('#dialogModalZone').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
            jQuery('#dialogModalZone').dialog('open');  //open the dialog
        });
        jQuery("#dialogModalGroup").dialog({
            autoOpen: false,
            height: 300,
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
        jQuery(".overlayGroup").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapGroup').load(jQuery(this).attr("href"));  //load content from href of link
            jQuery('#dialogModalGroup').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
            jQuery('#dialogModalGroup').dialog('open');  //open the dialog
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
		
		jQuery("#dialogModalAffiliate").dialog({
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
	jQuery(".overlayAffiliate").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapAffiliate').load(jQuery(this).attr("href"));
            jQuery('#dialogModalAffiliate').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAffiliate').dialog('open');
        });
    });


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

  	function delete_file(id) {
		
		
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


    

</script>

        <?php $this->end(); ?>
