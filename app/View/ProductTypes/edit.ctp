<?php

?><h4 class="page-title"> <?=__('Edit type'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('ProductType', array('onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
	<?php
		echo $this->Form->input('id');

		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
                    ))."</div>"; ?>

       <br/><br/>
            <input
                   class="input-radio" type="radio"
                   name="data[ProductType][relation_with_park]"
                   value=1 <?php if($this->request->data['ProductType']['relation_with_park']==1)  { ?> checked='checked' <?php } ?>>
            <span class="label-radio"><?php echo __('Relation with park') ?></span>
        <input
                class="input-radio" type="radio"
                name="data[ProductType][relation_with_park]"
                value=2 <?php if($this->request->data['ProductType']['relation_with_park']==2)  { ?> checked='checked' <?php } ?>>
        <span class="label-radio"> <?php echo __('Relation with transit') ?></span>
        <input
                class="input-radio" type="radio"
                name="data[ProductType][relation_with_park]"
                value=3 <?php if($this->request->data['ProductType']['relation_with_park']==3)  { ?> checked='checked' <?php } ?>>
        <span class="label-radio"> <?php echo __('Any relation') ?></span><br/><br/>
        <?php
    echo "<div class='form-group '>" . $this->Form->input('ProductTypeFactor.factor_id', array(
            'label' => __('Factors'),
            'empty' => '',
            'multiple'=>true,
            'id' => 'factor',
            'selected'=>$selectedProductTypeFactorIds,
            'class' => 'form-control select-search',
        )) . "</div>";
                    ?>
                
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
