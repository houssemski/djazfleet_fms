<div class="box-body">
    <?php
    /** @var $product array */
    ?>
    <h4 class="page-title"> <?= $product['Product']['name']; ?></h4>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link(
                                '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                array('action' => 'Edit', $product['Product']['id']),
                                array(
                                    'escape' => false,
                                    'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5"
                                )
                            ); ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
                                array('action' => 'Delete', $product['Product']['id']),
                                array(
                                    'escape' => false,
                                    'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"
                                ),
                                __('Are you sure you want to delete %s?', $product['Product']['name'])); ?>

                            <div style="clear: both"></div>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>

    <div class="left_side card-box p-b-0">
        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                <li><a href="#tab_2" data-toggle="tab"><?= __('Prices') ?></a></li>
                <li><a href="#tab_3" data-toggle="tab"><?= __("Advanced information") ?></a></li>
                <li><a href="#tab_4" data-toggle="tab"><?= __("Attachments") ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <dl class="card-box">
                        <dt><?php echo __('Code'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['code']); ?>
                            &nbsp;
                        </dd>
                        <?php if (isset($product['Product']['reference']) && !empty($product['Product']['reference'])) { ?>
                            <dt><?php echo __('Reference'); ?></dt>
                            <dd>
                                <?php echo h($product['Product']['reference']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['ProductFamily']['name']) && !empty($product['ProductFamily']['name'])) {
                            ?>
                            <dt><?php echo __('Family'); ?></dt>
                            <dd>
                                <?php echo h($product['ProductFamily']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['ProductCategory']['name']) && !empty($product['ProductCategory']['name'])) {
                            ?>
                            <dt><?php echo __('Category'); ?></dt>
                            <dd>
                                <?php echo h($product['ProductCategory']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['ProductMark']['name']) && !empty($product['ProductMark']['name'])) {
                            ?>
                            <dt><?php echo __('Mark'); ?></dt>
                            <dd>
                                <?php echo h($product['ProductMark']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <dt><?php echo __('Name'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['name']); ?>
                            &nbsp;
                        </dd>
                        <?php
                        if (isset($product['Product']['remark']) && !empty($product['Product']['remark'])) {
                            ?>
                            <dt><?php echo __('Remark'); ?></dt>
                            <dd>
                                <?php echo h($product['Product']['remark']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['Tva']['name']) && !empty($product['Tva']['name'])) {
                            ?>
                            <dt><?php echo __('TVA'); ?></dt>
                            <dd>
                                <?php echo h($product['Tva']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['ProductUnit']['name']) && !empty($product['ProductUnit']['name'])) {
                            ?>
                            <dt><?php echo __('Unit'); ?></dt>
                            <dd>
                                <?php echo h($product['ProductUnit']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <dt><?php echo __('Changeable price'); ?></dt>
                        <dd>
                            <?php
                            if ($product['Product']['changeable_price']) {
                                echo __('YES');
                            } else {
                                echo __('NO');
                            }
                            ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Blocked'); ?></dt>
                        <dd>
                            <?php
                            if ($product['Product']['blocked']) {
                                echo __('YES');
                            } else {
                                echo __('NO');
                            }
                            ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Out stock'); ?></dt>
                        <dd>
                            <?php
                            if ($product['Product']['out_stock']) {
                                echo __('YES');
                            } else {
                                echo __('NO');
                            }
                            ?>
                            &nbsp;
                        </dd>
                    </dl>
                </div>
                <div class="tab-pane" id="tab_2">
                    <dl class="card-box">
                        <?php
                        if (isset($product['Product']['pmp']) && !empty($product['Product']['pmp'])) { ?>
                        <dt><?php echo __('PMP'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['pmp']); ?>
                            &nbsp;
                        </dd>
                        <?php
                        }
                        ?>

                    </dl>
                </div>
                <div class="tab-pane" id="tab_3">
                    <dl class="card-box">
                        <?php
                        if (isset($product['Product']['quantity']) && !empty($product['Product']['quantity'])) { ?>
                        <dt><?php echo __('Quantity'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['quantity']); ?>
                            &nbsp;
                        </dd>
                        <?php
                        }
                        if (isset($product['Product']['quantity_min']) && !empty($product['Product']['quantity_min'])) { ?>
                        <dt><?php echo __('Quantity min'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['quantity_min']); ?>
                            &nbsp;
                        </dd>
                        <?php
                        }
                        if (isset($product['Product']['quantity_max']) && !empty($product['Product']['quantity_max'])) { ?>
                        <dt><?php echo __('Quantity max'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['quantity_max']); ?>
                            &nbsp;
                        </dd>
                        <?php
                        }
                        if (isset($product['Product']['last_purchase_price']) && !empty($product['Product']['last_purchase_price'])) { ?>
                        <dt><?php echo __('Last purchase price'); ?></dt>
                        <dd>
                            <?php echo h($product['Product']['last_purchase_price']); ?>
                            &nbsp;
                        </dd>
                        <?php
                        }
                        if (isset($product['Product']['weight']) && !empty($product['Product']['weight'])) { ?>
                            <dt><?php echo __('Weight'); ?></dt>
                            <dd>
                                <?php echo h($product['Product']['weight']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['Product']['volume']) && !empty($product['Product']['volume'])) { ?>
                            <dt><?php echo __('Volume'); ?></dt>
                            <dd>
                                <?php echo h($product['Product']['volume']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['Product']['emplacement']) && !empty($product['Product']['emplacement'])) { ?>
                            <dt><?php echo __('Emplacement'); ?></dt>
                            <dd>
                                <?php echo h($product['Product']['emplacement']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($product['Product']['description']) && !empty($product['Product']['description'])) { ?>
                        <dt style="line-height: 1.5"><?php echo __('Description'); ?></dt>
                        <dd style="float: left;">
                            <?php
                            echo  $product['Product']['description'];
                             ?>
                            &nbsp;
                        </dd>
                            <div style="clear: both;"></div>
                        <?php
                        }
                        ?>
                    </dl>
                </div>
                <div class="tab-pane" id="tab_4">
                    <?php
                    if (isset($product['Product']['image']) && !empty($product['Product']['image'])) { ?>
                        <dt><?php echo __('Picture'); ?></dt>
                        <dd>
                            <?= $this->Html->Link($product['Product']['image'],
                                '/img/products/' . $product['Product']['image'],
                                array('class' => 'attachments', 'target' => '_blank')
                            ); ?>
                            &nbsp;
                        </dd>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>