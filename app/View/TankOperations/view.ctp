
<div class="box-body">
<?php
?><h4 class="page-title"> <?=$tank['Tank']['id']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Liter'); ?></dt>
		<dd>
			<?php echo h($tank['Tank']['liter']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Tank'); ?></dt>
		<dd>
			<?php 
                switch($tank['Tank']['tank']) {
                case 1 :
                    echo __('Tank Gazoil') ;
                    break;
                case  2:
                    echo __('Tank Sans plamb');
                    break;
                case 3 :
                    echo __('Tank Super');
                    break;
                default:
                    echo  __('');
            }


            ?>
		</dd>

                 <dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php  echo h($this->Time->format($tank['Tank']['date_add'], '%d-%m-%Y ')); ?> 
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php if($tank['Tank']['type']==true)echo __('Consumption'); else echo __('Filling'); ?> 
			&nbsp;
		</dd>
		<dt><?php echo __('Car'); ?></dt>
		<dd>
			<?php if ($param==1){
                         echo $tank['Car']['code']." - ".$tank['Carmodel']['name']; 
                         } else if ($param==2) {
                         echo $tank['Car']['immatr_def']." - ".$tank['Carmodel']['name']; 
                            }?>
			&nbsp;
		</dd>
	</dl>
</div>