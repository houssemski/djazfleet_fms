

function upload()
{
	$('#progress .bar').html('0%');
	$('#progress .bar').width('0%');
	
	$('#CarTypeAddForm').submit();
	
	setTimeout('checkProgress()',800);
}


function checkProgress()
{
	$.get('<?php echo $this->Html->url('/carTypes/progress')?>',function(data)
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