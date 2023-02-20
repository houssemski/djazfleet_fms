<div class="box-body">
<?php
?><h4 class="page-title"> <?=$marchandise['Marchandise']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($marchandise['Marchandise']['wording']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($marchandise['Marchandise']['name']); ?>
			&nbsp;
		</dd>


           <dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php 
            
                    echo h($marchandise['MarchandiseType']['name']);
                 ?>
			&nbsp;
		</dd>

             <dt><?php echo __('Unit'); ?></dt>
		<dd>
			<?php 
            
            echo h($marchandise['MarchandiseUnit']['name']);
                 ?>
			&nbsp;
		</dd>

               

		
	</dl>
</div>
