<?php

foreach ($array_fichier as $array_fichier) {
//echo '<div class="col-sm-3 browsecar"><a  onclick="upload_picture(\''.$array_fichier.'\');" ><img class = "picture_dir" src="../attachments/'.$dir.'/'. $array_fichier .'"/></a><a  onclick="upload_picture(\''.$array_fichier.'\');" ><h3 class="titre_picture"> ' . $array_fichier .'</h3></a></div>';
echo '<div class="item"><a  onclick="upload_picture(\''.$array_fichier.'\');" >';
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
echo '</a><a  onclick="upload_picture(\''.$array_fichier.'\');" ><span class="titre_picture1"> ' . $array_fichier .'</span></a></div>';

}
        
echo '<div style="clear:both"></div></br></br>';

echo '<div class="trans">'.__("  Transfert des fichiers"). '</div>';
echo '</br>';
echo $this->Form->create('Car', array('enctype' => 'multipart/form-data'));
echo "<div >" . $this->Form->input('folder', array(
                                'label' => '',
								'value' =>$dir,
								'id' => 'folder',
                                'empty' => ''
                            )) . "</div>"; 
        echo "<div >" . $this->Form->input('file', array(
                                'label' => '',
                             
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
echo '</br>';
//echo $this->Html->link(__('Add event'), 'javascript:UploadFile();' , array('escape' => false )); 

echo '<a  onclick="UploadFile();" >' . __("Submit") .'</a>';

?>


<script type="text/javascript">     $(document).ready(function() {      });

 function upload_picture (name) {
 var name = name.replace(/ /g, '||||');
 var dir = <?php echo json_encode($id_dialog); ?>

 var dir1 = <?php echo json_encode($id_input); ?>
 
        jQuery("#"+''+dir+''+"").dialog('close');   //close containing dialog         
   
            jQuery("#"+''+dir1+''+"").load("<?php echo $this->Html->url('/cars/uploadPicture/')?>" + name+ '/'+ dir1);
       }



function UploadFile () {
	
	var $form = jQuery('#CarOpenDirForm');
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();

		
	 jQuery.ajax({//FormID - id of the form.
        type: "POST",
        url: "<?php echo $this->Html->url('/cars/upload')?>",
       contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', // selon le retour attendu
			
            data: data,
        success: function (json) {
                    if (json.response === "true") {
                        alert('ok');
                    } else alert('okddd');
				}
    });
}
</script>


