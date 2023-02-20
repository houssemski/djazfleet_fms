
<?php
$contraventionTypes = array(

'1'=>'Arrêt ou stationnement dangereux',
'2'=>'Conduite en sens opposé à la circulation',
'3'=>'Défaut au gabarit des véhicules, à l’installation des dispositifs d’éclairage et de signalisation des véhicules',
'4'=>'Défaut sur le véhicule',
'5'=>'Empiètement d’une ligne continue',
'6'=>'Franchissement d’une ligne continue',
'7'=>'Manœuvres interdites sur autoroutes et routes express',
'8'=>'Non port de la ceinture de sécurité',
'9'=>'Non respect de la charge maximale par essieu',
'10'=>'Non respect de la distance légale entre les véhicules',
'11'=>'Non respect de la priorité de passage des piétons au niveau des passages protégés',
'12'=>'Non respect des bonnes règles de conduite',
'13'=>'Non respect des dispositions relatives aux intersections de routes et à la priorité de passage',
'14'=>'Non respect des règles de limitations de vitesse',
'15'=>'Non respect des règles d’installation, de spécifications, de fonctionnement et de la maintenance du chrono tachygraphe',
'16'=>'Non respect des règles relatives aux freins des véhicules à moteur et à l’attelage des remorques et des semi-remorques',
'17'=>'Usage manuel du téléphone portable',

);
if ($id!=null) {
echo "<div class='form-group'>" . $this->Form->input('Event.place', array(
                    'label' => __('Address'),
                    'placeholder' => __('Enter address'),
                    'class' => 'form-control',
                    'value' =>$localisation['Event']['place'],
                    'id'=>"addresspicker",
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>".$this->Form->input('Event.latlng', array(
             'type' => 'hidden',
             'value' =>$localisation['Event']['latlng'],
             'id'=>"latlng"
             ))."</div>";
           
	?>
    
              
           
<div id="map" style="float:left;height:500px;width:100%;margin-bottom:10px;"></div>
<div id='reason-payed'>
<?php echo "<div class='form-group' >" . $this->Form->input('Event.contravention_type_id', array(
                    'label' => __('Contravention type'),
                    'class' => 'form-control select2',
                    'options'=>$contraventionTypes,
                    'value' =>$localisation['Event']['contravention_type_id'],
                    'empty' =>'',
                    'id' => 'contravention_type',
                )) . "</div>";
			
			echo "<div id='interval4'>";
            echo '<div class="lbl1" style="display: inline; margin-left: 5px;font-weight: bold;">'.__("Driving licence withdrawal");
            echo "</div>";			
			$options=array('1'=>__('Yes'),'2'=>__('No'));
            $attributes=array('legend'=>false ,  'value' => $localisation['Event']['driving_licence_withdrawal']);
            echo  $this->Form->radio('Event.driving_licence_withdrawal',$options,$attributes) . "</div><br/>";

            echo "<div id='interval4'>";
            echo '<div class="lbl1" style="display: inline; margin-left: 5px;font-weight: bold;">'.__("Payed");
            echo "</div>";
			$options=array('1'=>__('Yes'),'2'=>__('No'));
            $attributes=array('legend'=>false ,  'value' => $localisation['Event']['payed']);
            echo  $this->Form->radio('Event.payed',$options,$attributes) . "</div>"; ?>
</div>
            <div style="clear:both"></div>	
          <?php  } else {


            echo "<div class='form-group'>" . $this->Form->input('Event.place', array(
                    'label' => __('Address'),
                    'placeholder' => __('Enter address'),
                    
                    'class' => 'form-control',
                    'id'=>"addresspicker",
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>".$this->Form->input('Event.latlng', array(
             'type' => 'hidden',
             
             'id'=>"latlng"
             ))."</div>";
           
	?>
    
              
           
<div id="map" style="float:left;height:500px;width:100%;margin-bottom:10px;"></div>
<div id='reason-payed'>
<?php echo "<div class='form-group' >" . $this->Form->input('Event.contravention_type_id', array(
                    'label' => __('Contravention type'),
                    'class' => 'form-control select2',
                    'options'=>$contraventionTypes,
                    'empty' => '',
                    'id' => 'contravention_type',
                )) . "</div>";

echo "<div id='interval4'>";
echo '<div class="lbl1" style="display: inline; margin-left: 5px;font-weight: bold;">'.__("Driving licence withdrawal");
echo "</div>";
$options=array('1'=>__('Yes'),'2'=>__('No'));
$attributes=array('legend'=>false );
echo  $this->Form->radio('Event.driving_licence_withdrawal',$options,$attributes) . "</div><br/>";
echo "<div id='interval4'>";
echo '<div class="lbl1" style="display: inline; margin-left: 5px;font-weight: bold;">'.__("Payed");
echo "</div>";			
$options=array('1'=>__('Yes'),'2'=>__('No'));
            $attributes=array('legend'=>false);
            echo  $this->Form->radio('Event.payed',$options,$attributes) . "</div>"; ?>
</div>
            <div style="clear:both"></div>		


<?php } ?>