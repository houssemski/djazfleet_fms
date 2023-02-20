<?php
/**
 * @var array $wilayas
 */
?>
<h4 class="page-title"> <?=__('Edit bus stop');?></h4>
<div class="box" >
    <div class="edit form card-box p-b-0" >
        <?php echo $this->Form->create('BusRoutes.BusRouteStop' , array('enctype' => 'multipart/form-data')); ?>
        <div class="box-body">
            <?php
            echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'placeholder'=>__('Enter name'),
                    'class' => 'form-control',
                    'id'=>"addresspicker"
                ))."</div>";
            echo "<div class='form-group' id='wilayas'>".$this->Form->input('department_id', array(
                    'label' => __('Name').' '.__('Wilaya'),
                    'empty'=>__('Select wilaya'),
                    'class' => 'form-control select2',
                    'options' => $wilayas,
                    'id'=>'wilaya'
                ))."</div>";
            echo "<div class='form-group'>".$this->Form->input('lat', array(
                    'label' => __('Latitude'),
                    'class' => 'form-control',
                    'id'=>"latitude"
                ))."</div>";
            echo "<div class='form-group'>".$this->Form->input('lng', array(
                    'label' => __('Longitude'),
                    'class' => 'form-control',
                    'id'=>"longitude"
                ))."</div>";
            echo $this->Form->input('geo_fence_id', array(
                'label' => false,
                'type'=> 'hidden',
            ));
            ?>
            <div style="clear:both"></div>
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
