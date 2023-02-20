<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?php
if ($this->request->data['Supplier']['type'] == 0) {
    ?><h4 class="page-title"> <?= __('Edit Supplier'); ?></h4>

<?php
} else {
    ?><h4 class="page-title"> <?= __('Edit client'); ?></h4>

<?php } ?>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('Supplier', array('onsubmit' => 'javascript:disable();')); ?>

        <div class="box-body">

            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Information fiscale') ?></a></li>
                    <?php if ($this->request->data['Supplier']['type'] == 1) { ?>
                        <li><a href="#tab_3" data-toggle="tab"><?= __('Attachments') ?></a></li>
                        <li><a href="#tab_4" data-toggle="tab"><?= __('Other addresses') ?></a></li>
                    <?php } ?>
                        <li><a href="#tab_5" data-toggle="tab"><?= __('Contact person') ?></a></li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo $this->Form->input('id');

                        if ($code != '0' && $this->request->data['Supplier']['code'] != '') {
                            echo "<div id ='code_div' class='form-group'>" . $this->Form->input('code', array(
                                    'label' => __('Code'),
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'placeholder' => __('Enter code'),
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group'>" . $this->Form->input('code', array(
                                    'label' => __('Code'),
                                    'placeholder' => __('Enter code'),
                                    'class' => 'form-control',
                                    'id' => 'ref',
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The code must be unique") . '</label></div>', true)
                                )) . "</div>";
                        }

                        echo "<div class='form-group'>" . $this->Form->input('type', array(
                                'label' => __('type'),
                                'type' => 'hidden',
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('name', array(
                                'label' => __('Name'),
                                'class' => 'form-control',
                            )) . "</div>";


                        echo "<div class='form-group'>" . $this->Form->input('social_reason', array(
                                'label' => __('Social reason').' '.'('.__('Commercial name').')',
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('legal_form_id', array(
                                'label' => __('Legal form'),
                                'class' => 'form-control select2',
                                'empty'=>''
                            )) . "</div>";

                        if ($this->request->data['Supplier']['type'] == 1) {
                            echo "<div class='form-group'>" . $this->Form->input('parent_id', array(
                                    'label' => __('Parent'),
                                    'class' => 'form-control select-search-client-initial',
                                    'options'=>$supplier,
                                    'value'=>$this->request->data['Supplier']['parent_id'],
                                    'empty'=>''
                                )) . "</div>";
                        }else {
                            echo "<div class='form-group'>" . $this->Form->input('parent_id', array(
                                    'label' => __('Parent'),
                                    'class' => 'form-control select-search-supplier',
                                    'options'=>$supplier,
                                    'value'=>$this->request->data['Supplier']['parent_id'],
                                    'empty'=>''
                                )) . "</div>";
                        }

                        if ($this->request->data['Supplier']['type'] == 1) {
                            echo "<div class='form-group'>" . $this->Form->input('service_id', array(
                                    'label' => __('Service'),
                                    'class' => 'form-control select-search',
                                    'empty'=>''
                                )) . "</div>";
                        }

                        echo "<div id='interval2'>";
                        echo '<div class="lbl_type">' . __("Type");
                        echo "</div>";
                        $options = array('1' => __('Internal'), '2' => __('External'));

                        $attributes = array('legend' => false);
                        echo $this->Form->radio('internal_external', $options, $attributes) . "</div><br/>";

                        echo "<div class='form-group col-sm-4 clear-none p-l-0' id='category-div'>" . $this->Form->input('supplier_category_id', array(
                                'label' => __('Category'),
                                'class' => 'form-control select2',
                                'empty'=>''
                            )) . "</div>";
                        ?>
                        <div class="btn-group quick-actions">
                            <div id="dialogModalCategory">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapCategory"></div>
                            </div>
                            <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add', true),
                                        array("controller" => "supplierCategories", "action" => "addCategory", $this->params['pass']['0'] ),
                                        array(
                                            "class" => "btn overlayCategory",
                                            'escape' => false,
                                            "title" => __("Add Category")
                                        )); ?>
                                </li>
                                <li>
                                    <a href="#" class="btn overlayEditCategory" title="Edit">
                                        <i class="fa fa-edit m-r-5"></i><?= __("Edit") ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php
                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        if ($this->Session->read('Auth.User.profile_id') == ProfilesEnum::client) {

                            if ($this->request->data['Supplier']['type'] == SupplierTypesEnum::customer) {
                                echo '<div class="hidden">';
                                echo "<br>";
                                echo "<div id='interval2'>";
                                echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Final customer");
                                echo "</div>";
                                $options = array('1' => __('Yes'), '2' => __('No'), '3' => __('Final and initial customer'));


                                echo $this->Form->radio('final_customer', $options, $attributes) . "</div>";
                                echo "<br>";
                                echo '</div>';
                                ?>
                                <div style="clear:both"></div>

                                <div id='initial_customer'>

                                    <?php
                                    echo "<div class='form-group'>" . $this->Form->input('FinalSupplierInitialSupplier.initial_supplier_id', array(
                                            'label' => __('Initial customer'),
                                            'empty' => __('Select initial customer'),
                                            'options' => $initialSuppliers,
                                            'value' => $supplierId,
                                            'required' => true,
                                            'id' => 'initial_supplier_id',
                                            'type' => 'hidden',
                                            'class' => 'form-control',
                                        )) . "</div>"; ?>
                                </div>

                            <?php
                            }

                        } else {
                            if ($this->request->data['Supplier']['type'] == SupplierTypesEnum::customer) {
                                echo "<br>";
                                echo "<div id='interval2'>";
                                echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Final customer");
                                echo "</div>";
                                $options = array('1' => __('Yes'), '2' => __('No'), '3' => __('Final and initial customer'));
                                $attributes = array('legend' => false);
                                echo $this->Form->radio('final_customer', $options, $attributes) . "</div>";
                                echo "<br>";
                                ?>

                                <div style="clear:both"></div>
                                <?php
                                if ($this->request->data['Supplier']['final_customer'] == 1 || $this->request->data['Supplier']['final_customer'] == 3) {
                                    ?>
                                    <div id='initial_customer'>

                                        <?php
                                        if($this->request->data['Supplier']['final_customer'] == 1){
                                            echo "<div class='form-group'>" . $this->Form->input('FinalSupplierInitialSupplier.initial_supplier_id', array(
                                                    'label' => __('Initial customer'),
                                                    'empty' => '',
                                                    'options' => $initialSuppliers,
                                                    'required' => true,
                                                    'multiple' => 'multiple',
                                                    'id' => 'initial_supplier_id',
                                                    'value' => $finalSupplierInitialSuppliers,
                                                    'class' => 'form-control select2',
                                                )) . "</div>";
                                        }else {
                                            echo "<div class='form-group'>" . $this->Form->input('FinalSupplierInitialSupplier.initial_supplier_id', array(
                                                    'label' => __('Initial customer'),
                                                    'empty' => '',
                                                    'options' => $initialSuppliers,
                                                    //'required' => true,
                                                    'multiple' => 'multiple',
                                                    'id' => 'initial_supplier_id',
                                                    'value' => $finalSupplierInitialSuppliers,
                                                    'class' => 'form-control select2',
                                                )) . "</div>";
                                        }
                                        ?>
                                    </div>
                                <?php } else { ?>
                                    <div id='initial_customer'>
                                        <?php echo "<div class='form-group'>" . $this->Form->input('Supplier.automatic_order_validation', array(
                                                'label' => __('Automatic order validation'),
                                                'class' => 'form-control',
                                            )) . "</div>"; ?>
                                    </div>

                                <?php
                                }

                            }
                        }
                        echo "<br>";
                        echo "<div id='interval2'>";
                        echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Special");
                        echo "</div>";
                        $options = array('1' => __('No'), '2' => __('Yes'), '3' => __('Both'));

                        $attributes = array('legend' => false);
                        echo $this->Form->radio('is_special', $options, $attributes) . "</div>";
                        echo "<br>";?>
                        <div style="clear:both"></div>
                        <?php

                        echo "<div class='form-group'>" . $this->Form->input('adress', array(
                                'label' => __('Address'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('adress_map', array(
                                'label' => __('Address'),
                                'class' => 'form-control',
                                'id' => "addresspicker0"
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('latlng', array(
                                'type' => 'hidden',
                                'id' => "latlng0"
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('latitude', array(
                                'label' => __(''),
                                'placeholder' => __(''),
                                'class' => 'form-control',
                                'id' => 'latitude0',
                                'type' => 'hidden',
                                'empty' => ''
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('longitude', array(
                                'label' => __(''),
                                'placeholder' => __(''),
                                'class' => 'form-control',
                                'id' => 'longitude0',
                                'type' => 'hidden',
                                'empty' => ''
                            )) . "</div>";
                        ?>
                   <!--     <div id="map" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div> -->
                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('tel', array(
                                'label' => __('Tel'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('note', array(
                                'label' => __('Note'),
                                'class' => 'form-control',
                            )) . "</div>";
                        ?>
                    </div>
                    <div class="tab-pane " id="tab_2">
                        <?php echo "<div class='form-group'>" . $this->Form->input('rc', array(
                                'label' => __('RC'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('if', array(
                                'label' => __('IF'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('ai', array(
                                'label' => __('AI'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('nis', array(
                                'label' => __('NIS'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('cb', array(
                                'label' => __('CB'),
                                'class' => 'form-control',
                            )) . "</div>";

                        ?>
                    </div>
                    <?php if ($this->request->data['Supplier']['type'] == 1) { ?>
                        <div class="tab-pane " id="tab_3">
                            <?php
                            $i = 0;
                            foreach ($attachmentTypes as $attachmentType) {
                                if (isset($supplierAttachmentTypes[$i]) && ($supplierAttachmentTypes[$i]['SupplierAttachmentType']['attachment_type_id'] == $attachmentType['AttachmentType']['id'])) {
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                                            'label' => $attachmentType['AttachmentType']['name'],
                                            'class' => 'form-control ',
                                            'checked' => true,
                                            'type' => 'checkbox',
                                            'empty' => ''
                                        )) . "</div>";
                                    $i++;
                                } else {
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                                            'label' => $attachmentType['AttachmentType']['name'],
                                            'class' => 'form-control ',
                                            'type' => 'checkbox',
                                            'empty' => ''
                                        )) . "</div>";
                                }
                            }

                            ?>
                        </div>


                    <div class="tab-pane " id="tab_4">

                        <div id="SupplierAddress">
                            <?php
                            if (!empty($supplierAddresses)) {
                                $i = 1;
                                foreach ($supplierAddresses as $supplierAddress) {
                                    ?>
                                    <div id="SupplierAddress<?php echo $i ?>">
                                        <button style="float: right;" name="remove"
                                                id="removeAddress<?php echo $i ?>"
                                                onclick="removeAddress(this.id);"
                                                class="btn btn-danger btn_remove">X
                                        </button>
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.' . $i . '.code', array(
                                                'label' => __('Code'),
                                                'class' => 'form-control',
                                                'value' => $supplierAddress['SupplierAddress']['code'],
                                                'id' => ''
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.' . $i . '.address', array(
                                                'label' => __('Address'),
                                                'class' => 'form-control',
                                                'value' => $supplierAddress['SupplierAddress']['address'],
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.' . $i . '.address_map', array(
                                                'label' => __('Address'),
                                                'class' => 'form-control',
                                                'value' => $supplierAddress['SupplierAddress']['address'],
                                                'id' => 'addresspicker' . $i
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.' . $i . '.latitude', array(
                                                'class' => 'form-control',
                                                'type' => 'hidden',
                                                'value' => $supplierAddress['SupplierAddress']['latitude'],
                                                'id' => 'latitude' . $i
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.' . $i . '.longitude', array(
                                                'type' => 'hidden',
                                                'class' => 'form-control',
                                                'value' => $supplierAddress['SupplierAddress']['longitude'],
                                                'id' => 'longitude' . $i
                                            )) . "</div>";


                                        ?>
                                        <div id="map<?php echo $i ?>"
                                             style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.' . $i . '.latlng', array(
                                                'type' => 'hidden',
                                                'class' => 'form-control',
                                                'value' => $supplierAddress['SupplierAddress']['latlng'],
                                                'id' => 'latlng' . $i
                                            )) . "</div>";
                                        ?>
                                    </div>


                                    <?php $i++;
                                }
                                echo "<div class='form-group'>" . $this->Form->input('nb_address', array(
                                        'label' => false,
                                        'value' => $i,
                                        'type' => 'hidden',
                                        'id' => 'nb_address',
                                    )) . "</div>";
                            } else {
                                echo "<div class='form-group'>" . $this->Form->input('nb_address', array(
                                        'label' => false,
                                        'value' => 1,
                                        'type' => 'hidden',
                                        'id' => 'nb_address',
                                    )) . "</div>"; ?>
                                <div id="SupplierAddress1">
                                    <?php
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.1.code', array(
                                            'label' => __('Code'),
                                            'class' => 'form-control',
                                            'id' => ''
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.1.address', array(
                                            'label' => __('Address'),
                                            'class' => 'form-control',
                                        )) . "</div>";

                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.1.address_map', array(
                                            'label' => __('Address'),
                                            'class' => 'form-control',
                                            'id' => 'addresspicker1'
                                        )) . "</div>";

                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.1.latitude', array(
                                            'class' => 'form-control',
                                            'type' => 'hidden',
                                            'id' => 'latitude1'
                                        )) . "</div>";

                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.1.longitude', array(
                                            'type' => 'hidden',
                                            'class' => 'form-control',
                                            'id' => 'longitude1'
                                        )) . "</div>";


                                    ?>
                                    <div id="map1"
                                         style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
                                    <?php
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierAddress.1.latlng', array(
                                            'type' => 'hidden',
                                            'class' => 'form-control',
                                            'id' => 'latlng1'
                                        )) . "</div>";
                                    ?>
                                </div>
                            <?php
                            }

                            ?>

                        </div>


                        <br>
                        <button style="float: right;" type='button' name='add' id='add' class='btn btn-success'
                                onclick='addOtherAddress()'><?= __('Add more') ?></button>
                        <br>
                        <br>


                    </div>

                    <?php } ?>

                    <div class="tab-pane " id="tab_5">
                        <div id="SupplierContact">
                            <?php
                            if (!empty($supplierContacts)) {
                                $i = 1;
                                foreach ($supplierContacts as $supplierContact) {
                                    ?>
                                    <div id="SupplierContact<?php echo $i ?>">
                                        <button style="float: right;" name="remove"
                                                id="removeContact<?php echo $i;?>"
                                                onclick="removeContact(this.id);"
                                                class="btn btn-danger btn_remove">X
                                        </button>
                                        <?php
                                        echo "<div class='form-group'>" . $this->Form->input('SupplierContact.' . $i . '.contact', array(
                                                'label' => __('Contact person'),
                                                'class' => 'form-control',
                                                'value' => $supplierContact['SupplierContact']['contact'],
                                                'id' => 'contact' . $i
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('SupplierContact.' . $i . '.function', array(
                                                'label' => __('Function'),
                                                'class' => 'form-control',
                                                'value' => $supplierContact['SupplierContact']['function'],
                                                'id' => 'function' . $i
                                            )) . "</div>";
                                        echo "<div class='form-group'>" . $this->Form->input('SupplierContact.' . $i . '.email1', array(
                                                'label' => __('Email 1'),
                                                'class' => 'form-control',
                                                'value' => $supplierContact['SupplierContact']['email1'],
                                                'id' => 'email' . $i
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('SupplierContact.' . $i . '.email2', array(
                                                'label' => __('Email 2'),
                                                'class' => 'form-control',
                                                'value' => $supplierContact['SupplierContact']['email2'],
                                                'id' => 'email' . $i
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('SupplierContact.' . $i . '.email3', array(
                                                'label' => __('Email 3'),
                                                'class' => 'form-control',
                                                'value' => $supplierContact['SupplierContact']['email3'],
                                                'id' => 'email' . $i
                                            )) . "</div>";

                                        echo "<div class='form-group'>" . $this->Form->input('SupplierContact.' . $i . '.tel', array(
                                                'label' => __('Phone'),
                                                'class' => 'form-control',
                                                'value' => $supplierContact['SupplierContact']['tel'],
                                                'id' => 'tel' . $i
                                            )) . "</div>";
                                        ?>
                                    </div>

                                    <?php  $i++;
                                }

                                echo "<div class='form-group'>" . $this->Form->input('nb_contact', array(
                                        'label' => false,
                                        'value' => $i,
                                        'type' => 'hidden',
                                        'id' => 'nb_contact',
                                    )) . "</div>";
                            } else {
                                echo "<div class='form-group'>" . $this->Form->input('nb_contact', array(
                                        'label' => false,
                                        'value' => 1,
                                        'type' => 'hidden',
                                        'id' => 'nb_contact',
                                    )) . "</div>"; ?>
                                <div id="SupplierContact1">
                                    <?php
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierContact.1.contact', array(
                                            'label' => __('Contact person'),
                                            'class' => 'form-control',
                                            'id' => 'contact1'
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierContact.1.function', array(
                                            'label' => __('Function'),
                                            'class' => 'form-control',
                                            'id' => 'function1'
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierContact.1.email1', array(
                                            'label' => __('Email 1'),
                                            'class' => 'form-control',
                                            'id' => 'email1'
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('SupplierContact.1.email2', array(
                                            'label' => __('Email 2'),
                                            'class' => 'form-control',
                                            'id' => 'email2'
                                        )) . "</div>";

                                    echo "<div class='form-group'>" . $this->Form->input('SupplierContact.1.email3', array(
                                            'label' => __('Email 3'),
                                            'class' => 'form-control',
                                            'id' => 'email3'
                                        )) . "</div>";

                                    echo "<div class='form-group'>" . $this->Form->input('SupplierContact.1.tel', array(
                                            'label' => __('Phone'),
                                            'class' => 'form-control',
                                            'id' => 'tel1'
                                        )) . "</div>";
                                    ?>
                                </div>


                            <?php
                            }
                            ?>

                        </div>
                        <br>
                        <button style="float: right;" type='button' name='add' id='add' class='btn btn-success'
                                onclick='addOtherContact()'><?= __('Add more') ?></button>
                        <br>
                        <br>


                    </div>
                </div>

            </div>

        </div>


        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id' => 'boutonValider',
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

    $(document).ready(function () {

        jQuery("#dialogModalCategory").dialog({
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

        jQuery(".overlayCategory").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
            var categoryDiv = jQuery('#dialogModalCategory');
            categoryDiv.dialog('option', 'title', jQuery(this).attr("title"));
            categoryDiv.dialog('open');
        });

        jQuery(".overlayEditCategory").click(function (event) {

            event.preventDefault();
            var type = jQuery("#type").val();
            var categoryId = jQuery("#SupplierSupplierCategoryId").val();

            if (categoryId > 0) {
                var categoryDiv = jQuery('#dialogModalCategory');
                categoryDiv.dialog('option', 'title', jQuery(this).attr("title"));
                categoryDiv.dialog('open');
                jQuery('#contentWrapCategory').load("<?php echo $this->Html->url('/supplierCategories/editCategory/')?>" + categoryId +'/'+type );
            }
        });



       /* google.maps.event.addDomListener(window, 'load', initialize(14, "map", "0"));
        var nb_address = jQuery("#nb_address").val();

        for (var i = 1; i <= nb_address; i++) {
            var map = 'map' + i;
            google.maps.event.addDomListener(window, 'load', initialize(14, map, i));
        }*/

        jQuery('#SupplierFinalCustomer1').change(function () {
            var supplierId = jQuery('#SupplierId').val();
            jQuery("#code_div").load('<?php echo $this->Html->url('/suppliers/getCodeCustomer/')?>' + 1 +'/'+supplierId, function () {

            });
            jQuery("#initial_customer").load('<?php echo $this->Html->url('/suppliers/getInitialCustomer/')?>' + 1, function () {
                jQuery('.select2').select2();
                jQuery('#initial_supplier_id').parent('.input.select').addClass('required');

            });
        });
        jQuery('#SupplierFinalCustomer2').change(function () {
            var supplierId = jQuery('#SupplierId').val();
            var code = jQuery('#code').val();
            jQuery("#code_div").load('<?php echo $this->Html->url('/suppliers/getCodeCustomer/')?>' + 2 +'/' + supplierId, function () {
            });
            jQuery("#initial_customer").load('<?php echo $this->Html->url('/suppliers/getInitialCustomer/')?>' + 2, function () {
                jQuery('.select2').select2();
            });
        });

        jQuery('#SupplierFinalCustomer3').change(function () {
            var supplierId = jQuery('#SupplierId').val();
            var code = jQuery('#code').val();
            jQuery("#code_div").load('<?php echo $this->Html->url('/suppliers/getCodeCustomer/')?>' + 2 +'/'+ supplierId, function () {

            });
            jQuery("#initial_customer").load('<?php echo $this->Html->url('/suppliers/getInitialCustomer/')?>' + 3, function () {
                jQuery('.select2').select2();
                //jQuery('#initial_supplier_id').parent('.input.select').addClass('required');

            });
        });
    });
    function addOtherContact() {
        var i = jQuery("#nb_contact").val();
        i++;
        $('#SupplierContact').append('<div id="SupplierContact' + i + '"></div>');
        jQuery("#nb_contact").val(i);
        jQuery("#SupplierContact" + '' + i + '').load('<?php echo $this->Html->url('/suppliers/addOtherContact/')?>' + i, function () {

        });
    }

    function addOtherAddress() {
        var i = jQuery("#nb_address").val();
        i++;
        $('#SupplierAddress').append('<div id="SupplierAddress' + i + '"></div>');
        jQuery("#nb_address").val(i);
        jQuery("#SupplierAddress" + '' + i + '').load('<?php echo $this->Html->url('/suppliers/addOtherAddress/')?>' + i, function () {
            var map = 'map' + i;
            google.maps.event.addDomListener(window, 'load', initialize(14, map, i));
        });
    }

    //fonction appelé plus bas, ouvre un marqueur et recadre la carte aux coordonnées indiquées pour la cartes donnée
    function traiteAdresse(marker, latLng, infowindow, map, i) {
        //recadre et zomme sur les coordonnées latLng
        map.setCenter(latLng);
        map.setZoom(14);
        //on stocke nos nouvelles coordonée dans le champs correspondant
        var latlongdef = latLng.toString();
        latlongdef = latlongdef.substring(1);
        latlongdef = latlongdef.substring(0, latlongdef.length - 1);
        latlongdef = latlongdef.split(",");
        var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
        lat = parseFloat(latlongdef[0]);
        lng = parseFloat(latlongdef[1]);
        jQuery('#latitude' + '' + i + '').val(lat);
        jQuery('#longitude' + '' + i + '').val(lng);
        document.getElementById('latlng' + '' + i + '').value = latLng;
        //on va rechercher les information sur l'adresse correspondant à ces coordonnées
        geocoder.geocode({
            'latLng': latLng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse complète

                    //document.getElementById("addresspicker"+ '' + i + '').value = results[0].formatted_address;

                    var nb_el = results[0].address_components.length;
                    //et ses différentes composantes séparément

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
    function initialize(zoom, carte, i) {
        geocoder = new google.maps.Geocoder();
        //par d�faut on prend les coordonn�es entr� dans notre champs latlng
        var latlongdef = document.getElementById('latlng' + '' + i + '').value;

        if (latlongdef == '') {
            var latlng = new google.maps.LatLng(36.75218210858053, 3.0426488148193584);
        }

        else {
            latlongdef = latlongdef.substring(1);
             latlongdef = latlongdef.substring(0,latlongdef.length-1) ;
             latlongdef=latlongdef.split(",");
             var latlng = new google.maps.LatLng(latlongdef[0],latlongdef[1]);
        }
        //on initialise notre carte
        var options = {
            center: latlng,
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById(carte), options);
        //on indique que notre champ addresspicker doit proposer les adresses existantes
        var input = document.getElementById('addresspicker' + '' + i + '');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        //mise en place du marqueur
        var infowindow = new google.maps.InfoWindow();

        var icoParc = {
            //path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
            //url:'http://image.flaticon.com/icons/svg/190/190290.svg',
            url: 'http://image.flaticon.com/icons/svg/204/204314.svg',
            fillColor: '#FF0000',
            //fillOpacity: .3,
            //  anchor: new google.maps.Point(0,0),
            strokeWeight: 0,
            scale: 0.1,
            scaledSize: new google.maps.Size(32, 32)
        }
        var marker = new google.maps.Marker({
            map: map
            //icon: icoParc
        });
        //d�placable
        marker.setDraggable(true);
        marker.setPosition(latlng);
        //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
        google.maps.event.addListener(marker, 'dragend', function (event) {
            traiteAdresse(marker, event.latLng, infowindow, map, i);
        });

        //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            infowindow.close();
            var place = autocomplete.getPlace();
            marker.setPosition(place.geometry.location);
            traiteAdresse(marker, place.geometry.location, infowindow, map, i);
        });
    }

    function removeAddress(id) {
        var i = id.substring(id.length - 1, id.length);

        $('#SupplierAddress' + '' + i + '').remove();
    }
    function removeContact(id) {
        var i = id.substring(id.length - 1, id.length);
        $('#SupplierContact' + '' + i + '').remove();
    }


</script>
<?php $this->end(); ?>
    

