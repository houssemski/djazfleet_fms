
<?php echo "</br>";
echo "</br>"; ?>
<table id="datatable-responsive   module-sub-module-<?php echo $moduleId?>-<?php echo $subModuleId?>" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%"  style="margin-top: 20px;">
	<thead>
	<tr>
            <th > <?php echo __('Interface/ Action'); ?></th>
			<?php foreach($actions as $action ) {?>
			<th><?php echo $action['Action']['name'] ;?>
                <button type="button" id ='checkbox<?php echo $action['Action']['id']; echo $subModuleId?>' class="btn btn-default btn-sm checkbox-toggle">
					<i class="fa fa-square-o"></i>
					</button>
           
            </th>
			<?php }?>
           
	</tr>
	</thead>
	<tbody>
	<?php 
        $sel1=array();
        foreach ($sectionAction1s as $select):
            $sel1[]= $select['SectionAction']['section_id'];
            $val1[]= $select['SectionAction']['value'];
        endforeach;

        $sel2=array();
        foreach ($sectionAction2s as $select):
            $sel2[]= $select['SectionAction']['section_id'];
			$val2[]= $select['SectionAction']['value'];
        endforeach;

        $sel3=array();
        foreach ($sectionAction3s as $select):
            $sel3[]= $select['SectionAction']['section_id'];
            $val3[]= $select['SectionAction']['value'];
        endforeach;

        $sel4=array();
        foreach ($sectionAction4s as $select):
            $sel4[]= $select['SectionAction']['section_id'];
            $val4[]= $select['SectionAction']['value'];
        endforeach;

        $sel5=array();
        foreach ($sectionAction5s as $select):
            $sel5[]= $select['SectionAction']['section_id'];
            $val5[]= $select['SectionAction']['value'];
        endforeach;

        $sel6=array();
        foreach ($sectionAction6s as $select):
            $sel6[]= $select['SectionAction']['section_id'];
			$val6[]= $select['SectionAction']['value'];
        endforeach;

        $sel7=array();
        foreach ($sectionAction7s as $select):
            $sel7[]= $select['SectionAction']['section_id'];
			$val7[]= $select['SectionAction']['value'];
        endforeach;

		$sel8=array();
        foreach ($sectionAction8s as $select):
            $sel8[]= $select['SectionAction']['section_id'];
			$val8[]= $select['SectionAction']['value'];
        endforeach;

		$sel9=array();
        foreach ($sectionAction9s as $select):
            $sel9[]= $select['SectionAction']['section_id'];
			$val9[]= $select['SectionAction']['value'];
        endforeach;

		$sel10=array();
        foreach ($sectionAction10s as $select):
            $sel10[]= $select['SectionAction']['section_id'];
			$val10[]= $select['SectionAction']['value'];
        endforeach;

        $sel11=array();
        foreach ($sectionAction11s as $select):
            $sel11[]= $select['SectionAction']['section_id'];
			$val11[]= $select['SectionAction']['value'];
        endforeach;

        $sel12=array();
        foreach ($sectionAction12s as $select):
            $sel12[]= $select['SectionAction']['section_id'];
			$val12[]= $select['SectionAction']['value'];
        endforeach;

        $sel13=array();
        foreach ($sectionAction13s as $select):
            $sel13[]= $select['SectionAction']['section_id'];
			$val13[]= $select['SectionAction']['value'];
        endforeach; 
		
		$sel14=array();
        foreach ($sectionAction14s as $select):
            $sel14[]= $select['SectionAction']['section_id'];
			$val14[]= $select['SectionAction']['value'];
        endforeach; 
		
		$sel15=array();
        foreach ($sectionAction15s as $select):
            $sel15[]= $select['SectionAction']['section_id'];
			$val15[]= $select['SectionAction']['value'];
        endforeach;

        $sel16=array();
        foreach ($sectionAction16s as $select):
            $sel16[]= $select['SectionAction']['section_id'];
			$val16[]= $select['SectionAction']['value'];
        endforeach;
		
		if($profileId != null){
			$selPermission1=array();
			foreach ($accessPermission1s as $select):

				$selPermission1[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;
			
			$selPermission2=array();
			foreach ($accessPermission2s as $select):
				$selPermission2[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission3=array();
			foreach ($accessPermission3s as $select):
				$selPermission3[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission4=array();
			foreach ($accessPermission4s as $select):
				$selPermission4[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission5=array();
			foreach ($accessPermission5s as $select):
				$selPermission5[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission6=array();
			foreach ($accessPermission6s as $select):
				$selPermission6[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;
			
			$selPermission7=array();
			foreach ($accessPermission7s as $select):
				$selPermission7[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission8=array();
			foreach ($accessPermission8s as $select):
				$selPermission8[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission9=array();
			foreach ($accessPermission9s as $select):
				$selPermission9[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission10=array();
			foreach ($accessPermission10s as $select):
				$selPermission10[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission11=array();
			foreach ($accessPermission11s as $select):
				$selPermission11[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission12=array();
			foreach ($accessPermission12s as $select):
				$selPermission12[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission13=array();
			foreach ($accessPermission13s as $select):
				$selPermission13[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission14=array();
			foreach ($accessPermission14s as $select):
				$selPermission14[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;	
			
			$selPermission15=array();
			foreach ($accessPermission15s as $select):
				$selPermission15[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;

			$selPermission16=array();
			foreach ($accessPermission16s as $select):
				$selPermission16[$select['AccessPermission']['section_id']]= $select['AccessPermission']['section_id'];
			endforeach;
			
		}
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
    $f = 0;
    $g = 0;
    $h = 0;
    $i = 0;
    $j = 0;
    $k = 0;
    $l = 0;
    $m = 0;
    $n = 0;
    $o = 0;
    $p = 0;


	foreach ($sections as $section): ?>
	<tr >
            <td> <?php echo h($section['Section']['name']); ?></td>
			<td> <?php

                if($val1[$a]==1){
					
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][1]';

                     if(isset($selPermission1[$section['Section']['id']]) && !empty($selPermission1[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id1<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id1<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
				
			<?php }
                $a ++;
                ?>
				</td>
			
			<td> <?php


                if($val2[$b]==1){

                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][2]';
                    ?>
                    <?php if(isset($selPermission2[$section['Section']['id']]) && !empty($selPermission2[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id2<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id2<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }

                $b ++;
                ?></td>

            <td> <?php

                if($val3[$c]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][3]';
                    ?>
                     <?php if(isset($selPermission3[$section['Section']['id']]) && !empty($selPermission3[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id3<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id3<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }

                $c ++;
                ?></td>
			
			<td> <?php

                if($val4[$d]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][4]';
                    ?>
                     <?php if(isset($selPermission4[$section['Section']['id']]) && !empty($selPermission4[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id4<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id4<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $d ++;

                ?></td>
			
			<td> <?php


                if($val5[$e]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][5]';
                    ?>

                     <?php if(isset($selPermission5[$section['Section']['id']]) && !empty($selPermission5[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id5<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id5<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $e ++;

                ?></td>
			
			<td> <?php
                if($val6[$f]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][6]';

                    ?>
                     <?php if(isset($selPermission6[$section['Section']['id']]) && !empty($selPermission6[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id6<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id6<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }

                $f ++;
                ?></td>
			
			<td> <?php

                if($val7[$g]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][7]';
                    ?>
                     <?php if(isset($selPermission7[$section['Section']['id']]) && !empty($selPermission7[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id7<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id7<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $g ++;

                ?></td>
			
			<td> <?php


                if($val8[$h]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][8]';
                    ?>

                     <?php if(isset($selPermission8[$section['Section']['id']]) && !empty($selPermission8[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id8<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id8<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			<?php }

                $h ++;
                ?></td>
			
			<td> <?php if($val9[$i]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][9]';
                    ?>

                     <?php if(isset($selPermission9[$section['Section']['id']]) && !empty($selPermission9[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id9<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id9<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }

                $i ++;
                ?></td>
			
			<td> <?php if($val10[$j]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][10]';
                    ?>

                     <?php if(isset($selPermission10[$section['Section']['id']]) && !empty($selPermission10[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id10<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id10<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $j ++;


                ?></td>
			
			<td> <?php if($val11[$k]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][11]';
                    ?>

                     <?php if(isset($selPermission11[$section['Section']['id']]) && !empty($selPermission11[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id11<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id11<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $k ++;

                ?></td>
			
			<td> <?php if($val12[$l]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][12]';
                    ?>

                     <?php if(isset($selPermission12[$section['Section']['id']]) && !empty($selPermission12[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id12<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id12<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $l ++;

                ?></td>
			
			<td> <?php if($val13[$m]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][13]';
                    ?>
                     <?php if(isset($selPermission13[$section['Section']['id']]) && !empty($selPermission13[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id13<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id13<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $m ++;

                ?></td>
			<td> <?php if($val14[$n]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][14]';
                    ?>
                     <?php if(isset($selPermission14[$section['Section']['id']]) && !empty($selPermission14[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id14<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id14<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $n ++;
                ?></td>
			
			<td> <?php if($val15[$o]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][15]';
                    ?>
                     <?php if(isset($selPermission15[$section['Section']['id']]) && !empty($selPermission15[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id15<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id15<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>
			
			<?php }
                $o ++;
                ?></td>

            <td> <?php
                if($val16[$p]==1){
                    $name = 'data[AccessPermission]['. $section['Section']['id'] .'][20]';
                    ?>
                     <?php if(isset($selPermission16[$section['Section']['id']]) && !empty($selPermission16[$section['Section']['id']])) {?>
						<input id="idCheck" type="checkbox" checked='checked' class = 'id16<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } else {?>
						<input id="idCheck" type="checkbox" class = 'id16<?php echo $subModuleId?>' name=<?php echo $name?>>
					<?php } ?>

			<?php }
                $p ++;
                ?></td>
			








	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
        
        
		
		