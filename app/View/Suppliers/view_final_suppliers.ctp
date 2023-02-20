<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">
    <thead>
    <tr>

        <th><?php echo __('Code'); ?></th>
        <th><?php echo __('Name'); ?></th>
        <th><?php echo __('Address'); ?></th>
        <th><?php echo __('Phone'); ?></th>
        <th><?php echo __('Category'); ?></th>

        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody id="listeDiv">
    <?php foreach ($suppliers as $supplier): ?>
        <tr id="row<?= $supplier['Supplier']['id'] ?>">

            <td><?php echo h($supplier['Supplier']['code']); ?>&nbsp;</td>
            <td><?php echo h($supplier['Supplier']['name']); ?>&nbsp;</td>
            <td><?php echo h($supplier['Supplier']['adress']); ?>&nbsp;</td>
            <td><?php echo h($supplier['Supplier']['tel']); ?>&nbsp;</td>
            <td><?php echo h($supplier['SupplierCategory']['name']); ?>&nbsp;</td>

            <td class="actions">
                <div class="btn-group ">
                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                        <i class="fa fa-list fa-inverse"></i>
                    </a>
                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" style="min-width: 70px;">

                        <li>
                            <?php echo $this->Html->link(
                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                array('action' => 'View', $supplier['Supplier']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                array('action' => 'Edit', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>
                        <li>
                            <?php
                            if ($supplier['Supplier']['active'] == 1) {
                                echo $this->Html->link(
                                    '<i class=" fa  fa-check" title="' . __('Deactivate') . '"></i>',
                                    array('action' => 'inactif', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                    array('escape' => false, 'class' => 'btn btn-warding')
                                );
                            } else {
                                echo $this->Html->link(
                                    '<i class=" fa  fa-check" title="' . __('Actif') . '"></i>',
                                    array('action' => 'actif', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                    array('escape' => false, 'class' => 'btn btn-warding')
                                );
                            }
                            ?>
                        </li>
                        <li>
                            <?php  echo $this->Html->link(
                                '<i class=" fa fa-print m-r-5"title="' . __('Supplier card') . '"></i>',
                                array('action' => 'supplierCard', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                array('escape' => false, 'class' => 'btn btn-inverse')); ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                array('action' => 'Delete', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                array('escape' => false, 'class' => 'btn btn-danger'),
                                __('Are you sure you want to delete %s?', $supplier['Supplier']['name'])); ?>
                        </li>
                    </ul>
                </div>


            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
                
                
	