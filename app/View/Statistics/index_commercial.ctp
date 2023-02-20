<?php

?><h4 class="page-title"> <?=__('Statistics'); ?></h4>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="boxstat box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?=__('Business management')?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped stats">
                        <tbody>
                        <tr>
                            <td><?= $this->Html->link("> " . __('Realized turnover per month'), array('action' => 'realizedTurnoverByMonth')); ?></td>
                        </tr>

                        <tr>
                            <td><?= $this->Html->link("> " . __('Invoiced turnover per month'), array('action' => 'invoicedTurnoverByMonth')); ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->



        </div><!-- /.col (LEFT) -->

    </div><!-- /.row -->

</section><!-- /.content -->

