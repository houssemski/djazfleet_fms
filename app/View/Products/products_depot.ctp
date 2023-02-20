<?php


?><h4 class="page-title"> <?=__('Products/Warehouse'); ?></h4>
<div class="box-body">




				
				
				
				


    <div class="row" style="clear:both">
       
        </div>




    </div>
    </br>
    </br>
     </br>
    </br>
<div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box p-b-0">
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="width: 10px">
                <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            </th>
            
            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
            <th><?php echo $this->Paginator->sort('product_type_id', __('Type')); ?></th>
            <th><?php echo $this->Paginator->sort('product_mark_id', __('Mark')); ?></th>
            <th><?php echo $this->Paginator->sort('quantity', __('Quantity')); ?></th>
            <th><?php echo $this->Paginator->sort('quantity_min', __('Quantity_min')); ?></th>
            <th><?php echo $this->Paginator->sort('quantity_max', __('Quantity_max')); ?></th>
            <th><?php echo $this->Paginator->sort('warehouse_id', __('Warehouse')); ?></th>
            
            
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): 



                ?>
        
            <tr class=""    id="row<?= $product['Product']['id'] ?>">
                <td>

                    <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $product['Product']['id'] ?> >
                </td>
               
                <td><?php echo h($product['Product']['code']); ?>&nbsp;</td>
                <td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
                <td><?php echo h($product['ProductCategory']['name']); ?>&nbsp;</td>
                <td><?php echo h($product['ProductMark']['name']); ?>&nbsp;</td>
                 <td><?php echo h($product['Product']['quantity']); ?>&nbsp;</td>
                 <td><?php echo h($product['Product']['quantity_min']); ?>&nbsp;</td>
                 <td><?php echo h($product['Product']['quantity_max']); ?>&nbsp;</td>
                
                <td><?php echo h($product['Warehouse']['name']); ?>&nbsp;</td>
               
                <td class="actions">
                    <?= $this->Html->link(
                        '<i class="  fa fa-eye m-r-5"></i>',
                        array('action' => 'view', $product['Product']['id']),
                        array('escape' => false)
                    ); ?>
                    <?= $this->Html->link(
                        '<i class="  fa fa-edit m-r-5"></i>',
                        array('action' => 'edit', $product['Product']['id']),
                        array('escape' => false)
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class=" fa fa-trash-o m-r-5"></i>',
                        array('action' => 'delete', $product['Product']['id']),
                        array('escape' => false),
                        __('Are you sure you want to delete %s?', $product['Product']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
</div>
</div>
</div>

<?php
if($this->params['paging']['Product']['pageCount'] > 1){
    ?>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-left">
            <?php
            echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array(
                'tag' => 'li',
                'first' => false,
                'last' => false,
                'separator' => '',
                'currentTag' => 'a'));
            echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
            ?>
        </ul>
    </div>
<?php } ?>

<?php $this->start('script'); ?>

<script type="text/javascript">     $(document).ready(function() {      });






	

</script>
<?php $this->end(); ?>



