<?php

if (isset($results) && !empty($results)) { 
foreach($results as $result){
   
    if ($result['EventType']['code'] == "002") { ?>
        <div class="form-group">
        <span id="model">
            <div class="input">
                <label for="AssuranceNumber"><?= __('Assurance number') ?></label>
                <input name="data[Event][assurance_number]" placeholder="<?= __('Enter assurance number') ?>"
                       class="form-control">
            </div>
</span>
        </div>
      <?php   $options=array('1'=>__('Public liability'),'2'=>__('Collision damage'),'3'=>__('All risks'));
            echo "<div class='form-group'>" . $this->Form->input('Event.assurance_type', array(
                    'label' => __('Assurance type'),
                    
                    'type'=>'select',
                    'options'=>$options,
                    'class' => 'form-control',
                  
                    'empty'=>__('Select assurance type'),
                    
                )) . "</div>";
     }
    if ($result['EventType']['with_km'] == 1 && $result['EventType']['with_date'] == 1) {


            $date= $result['EventType']['date'];
            $next_date= $result['EventType']['next_date'];
            $date3= $result['EventType']['date3'];

        ?>



        <div class="form-group">
        <span id="model">
            <div class="input text">
                <?php if ($date==null){?> <label><?= __('date') ?></label>
                <?php } else ?> <label><?=$date?></label>

                <div class="input-group date">
                    <label for="date"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="date"></label>
                    <input name="data[Event][date]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="date" type="text">
                </div>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input text">
                <?php if ($next_date==null){?> <label><?= __('Next date') ?></label>
                <?php } else ?> <label><?=$next_date?></label>

                <div class="input-group date">
                    <label for="next_date"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="next_date"></label>
                    <input name="data[Event][next_date]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="nextdate" type="text">
                </div>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input text">
                <?php if ($date3==null){?> <label><?= __('date3') ?></label>
                <?php } else ?> <label><?=$date3?></label>

                <div class="input-group date">
                    <label for="date3"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="date3"></label>
                    <input name="data[Event][date3]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="date3" type="text">
                </div>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input number">
                <label for="EventKm"><?= __('Km') ?></label>
                <?php if($editKmDate==1) {?>
                    <input name="data[Event][km]" placeholder="<?= __('Enter km') ?>"
                           value="<?php echo intval($km); ?>"
                           class="form-control" type="number" id="EventKm">
                <?php }else { ?>
                    <input name="data[Event][km]" placeholder="<?= __('Enter km') ?>"
                           readonly="readonly" value="<?php echo intval($km); ?>"
                           class="form-control" type="number" id="EventKm">
                <?php } ?>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input number">
                <label for="EventNextKm"><?= __('Next km') ?></label>
                <input name="data[Event][next_km]" placeholder="<?= __('Enter next km') ?>"
                       class="form-control" type="number" id="EventNextKm">
            </div>
        </span>
        </div>
        <script type="text/javascript">

            $(document).ready(function() {
                jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

            });

        </script>

    <?php
    } elseif ($result['EventType']['with_km'] == 1) {
        ?>
		  <div class="form-group">
        <span id="model">
            <div class="input text">
                 <label><?= __('Date event') ?></label>
               

                <div class="input-group date">
                    <label for="date"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="date"></label>
                    <input name="data[Event][date]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="date" type="text">
                </div>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input number">
                <label for="EventKm"><?= __('Km') ?></label>
                <?php if($editKmDate==1) {?>
                    <input name="data[Event][km]" placeholder="<?= __('Enter km') ?>"
                           value="<?php echo intval($km); ?>"
                           class="form-control" type="number" id="EventKm">
                <?php }else { ?>
                    <input name="data[Event][km]" placeholder="<?= __('Enter km') ?>"
                           readonly="readonly" value="<?php echo intval($km); ?>"
                           class="form-control" type="number" id="EventKm">
                <?php } ?>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input number">
                <label for="EventNextKm"><?= __('Next km') ?></label>
                <input name="data[Event][next_km]" placeholder="<?= __('Enter next km') ?>"
                       class="form-control" type="number" id="EventNextKm">
            </div>
        </span>
        </div>
		 <script type="text/javascript">
             $(document).ready(function() {
                 jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
             });

          
        </script>
    <?php
    } elseif ($result['EventType']['with_date'] == 1) {
        ?>
        <div class="form-group">
        <span id="model">

       <?php
       
            $date= $result['EventType']['date'];
            $next_date= $result['EventType']['next_date'];
            $date3= $result['EventType']['date3'];
       
        ?>
            <div class="input text">
                <?php if ($date==null){?> <label><?= __('date') ?></label>
                <?php } else ?> <label><?=$date?></label>

                <div class="input-group date">
                    <label for="date"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="date"></label>
                    <input name="data[Event][date]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="date" type="text">
                </div>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input text">
                <?php if ($next_date==null){?> <label><?= __('Next date') ?></label>
                <?php } else ?> <label><?=$next_date?></label>

                <div class="input-group date">
                    <label for="next_date"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="next_date"></label>
                    <input name="data[Event][next_date]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="nextdate" type="text">
                </div>
            </div>
        </span>
        </div>
        <div class="form-group">
        <span id="model">
            <div class="input text">
                <?php if ($date3==null){?> <label><?= __('date3') ?></label>
                <?php } else ?> <label><?=$date3?></label>

                <div class="input-group date">
                    <label for="date3"></label>

                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <label for="date3"></label>
                    <input name="data[Event][date3]" placeholder="dd/mm/yyyy"
                           class="form-control datemask" id="date3" type="text">
                </div>
            </div>
        </span>
        </div>
        <script type="text/javascript">

            $(document).ready(function() {
                jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

            });

        </script>
    <?php
    }   

    }
}
?>
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function() {      });



</script>
<?php $this->end(); ?>
