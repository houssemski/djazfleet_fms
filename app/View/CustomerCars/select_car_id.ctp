

<?php

if($carWithType == 0){ ?>

  <div id="flashMessage" class="message">
      <div class="alert alert-danger alert-dismissable">
          <i class="fa fa-ban"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo __('No car in the chosen type, select another car') ?>
      </div>
  </div>
    <br><br><br>
<?php }
echo $this->Form->create('CustomerCar', array('onsubmit'=> 'javascript:disable();'));

echo "<div class='form-group'>" . $this->Form->input('car_id', array(
    'label' => __('Car'),
    'class' => 'form-control select2',
    'empty' => ''
    )) . "</div>";

echo "<br/><br/>";
echo $this->Form->submit(__('Save'), array(
'name' => 'ok',
'class' => 'btn btn-primary',
'label' => __('Save'),
'type' => 'submit',
    'id'=>'boutonValider',
'div' => false
));



echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page
?>
<?php die(); ?>