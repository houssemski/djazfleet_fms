

<div class="panel-body">
			<?php
			 "<div class='form-group'>" . $this->Form->input('num_payment', array(
								'label' =>'',
								'type' => 'hidden',
								'value' =>$nb_payment,
								'id' =>'num_payment',
								'empty' => ''
							)) . "</div>"; 
			echo "<div class='form-group'>" . $this->Form->input('Payment.'.$nb_payment .'.reference', array(
                                'label' => __('Reference'),
                                'placeholder' => __('Enter reference'),
                                'class' => 'form-control',
                            )) . "</div>";
                            $current_date=date("Y-m-d");
                         echo "<div class='form-group'>" . $this->Form->input('Payment.'.$nb_payment .'.receipt_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'value'=>$this->Time->format($current_date, '%d-%m-%Y'),
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Payment date') . '</label><div class="input-group date"><label for="CarPaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'receipt_date'.$nb_payment,
                            )) . "</div>";
             echo "<div class='form-group'>" . $this->Form->input('Payment.' . $nb_payment . '.compte_id', array(
                    'label' => __('Compte'),
                    'empty' => '',
                    'class' => 'form-control',
                )) . "</div>";
            if (Configure::read("cafyb") == '1') {
                $options = $paymentMethods ;
            }else {
                $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
            }

                            echo "<div class='form-group'>" . $this->Form->input('Payment.'.$nb_payment .'.payment_type', array(
                                'label' => __('Payment type'),
                                'empty' => '',
                                'type' =>'select',
                                'options' =>$options,
                                'class' => 'form-control',
                            )) . "</div>";
                             echo "<div class='form-group'>" . $this->Form->input('Payment.'.$nb_payment .'.amount', array(
                                'label' => __('Amount'),
                                'placeholder' => __('Enter amount'),
                                'type' => 'number',
                                'class' => 'form-control',
                            )) . "</div>";
                        
                              
                        echo "<div class='form-group'>" . $this->Form->input('Payment.'.$nb_payment .'.note', array(
                                'label' => __('Note'),
                                'rows'=>'6',
                                'cols'=>'30',
                                'placeholder' => __('Enter note'),
                                'class' => 'form-control',
                            )) . "</div>"; 
	  
	  ?>

	  </div>

      <?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function() {      });
    $( document ).ready(function(){
        var num_payment=parseFloat(jQuery('#num_payment').val());
        jQuery("#receipt_date"+''+num_payment+'').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });

    </script>

<?php $this->end(); ?>