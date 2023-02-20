
      <form id="upload_form"  method="post" enctype="multipart/form-data" target="result_frame">
        
        <input type="hidden" name="<?php echo ini_get('session.upload_progress.name');?>"  value="progression" />
        
        <input type="file" name="file" id="file">
          
       <button id="submit-button" class="btn btn-primary" onclick="upload()">Upload</button>
        
      </form>
      
      
      <div id="progress" class="progress progress-success progress-striped" style="width:700px;">
        
        <div class="bar"></div>
        
      </div>
      
      <iframe id="result_frame" name="result_frame" style="border:none;width:400px;height:400px;" frameBorder="0" scrolling="no"></iframe>

 <?php $this->start('script'); ?>
<!-- InputMask -->

<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">     $(document).ready(function() {      });
	$( document ).ready(function(){

	});

      function upload() {
	$('#progress .bar').html('0%');
	$('#progress .bar').width('0%');
	
	$('#upload_form').submit();
	
	setTimeout('checkProgress()',1500);
}


function checkProgress() {
	$.get('<?php echo $this->Html->url('/cars/progress')?>',function(data)
	{
		var percentage = data +'%';
		
		$('#progress .bar').html(percentage);
		$('#progress .bar').width(percentage);
		
		if(data<100)
		{
			setTimeout('checkProgress()',500);
		}
	});
}


</script>
<?php $this->end(); ?>