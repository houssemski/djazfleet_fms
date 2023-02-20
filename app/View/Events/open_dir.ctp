<?php

foreach ($array_fichier as $array_fichier) {
//echo '<div class="col-sm-3 browsecar"><a  onclick="upload_picture(\''.$array_fichier.'\');" ><img class = "picture_dir" src="../attachments/'.$dir.'/'. $array_fichier .'"/></a><a  onclick="upload_picture(\''.$array_fichier.'\');" ><h3 class="titre_picture"> ' . $array_fichier .'</h3></a></div>';
echo '<div class="col-sm-3 browsecar"><a  onclick="upload_picture(\''.$array_fichier.'\');" >';
 $ext = substr(strtolower(strrchr($array_fichier, '.')), 1);
                 $arr_ext = array('jpg', 'jpeg', 'gif','png');
                 if (in_array($ext, $arr_ext)) {
echo $this->Html->image('/attachments/'.$dir.'/'. $array_fichier,  array('class' => 'picture_dir' ));
}else  { if ($ext=='pdf') {

echo $this->Html->image('/img/pdf-icon.png',  array('class' => 'pdf_dir' ));

} else {

if ($ext=='tif') {

echo $this->Html->image('/img/tiff-icon.jpg',  array('class' => 'pdf_dir' ));

}

}


}
echo '</a><a  onclick="upload_picture(\''.$array_fichier.'\');" ><h3 class="titre_picture"> ' . $array_fichier .'</h3></a></div>';

}
    
    

    ?>





<script type="text/javascript">     $(document).ready(function() {      });
 function upload_picture (name) {
 
 var name = name.replace(/ /g, '||||');
 
 
 var dir = <?php echo json_encode($id_dialog); ?>

 var dir1 = <?php echo json_encode($id_input); ?>
 

        jQuery("#"+''+dir+''+"").dialog('close');   //close containing dialog         
   
            jQuery("#"+''+dir1+''+"").load("<?php echo $this->Html->url('/events/uploadPicture/')?>" +name+'/'+dir1);
       }


    
</script>

