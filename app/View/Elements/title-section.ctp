<?php
/** @var string $entityName */
/** @var string $defaultDashboardAction */
/** @var string $action */
/** @var string $controllerName */
/** @var string $fullName */
/** @var int $id */
?>
<!--   Title section    -->
<div class="page-header">
    <div class="page-header-title">
        <h4>
            <?php
            if (strtolower($action) == 'index') {
                echo __("$controllerName");
            } elseif (strtolower($action) == 'view') {
                echo __("$entityName Detail");
            } else {
                echo __($action . ' ' . strtolower($entityName));
            }
            ?>
        </h4>
    </div>
    <div class="page-header-breadcrumb">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <?php
                echo $this->Html->link(
                    '<i class="icofont icofont-home"></i>',
                    [
                        'controller' => 'homes',
                        'action' => $defaultDashboardAction,
                    ],
                    [
                        'escapeTitle' => false,
                    ]
                )
                ?>

            </li>
            <li class="breadcrumb-item">
                <?php
                echo $this->Html->link(
                    __($controllerName),
                    [
                        'controller' => $controllerName,
                        'action' => 'index',
                    ]
                )
                ?>
            </li>
            <?php
            if (strtolower($action) != 'index')         :
                ?>
                <li class="breadcrumb-item">
                    <?php
                    if (isset($id)) {
                        echo $this->Html->link(
                            __($action . ' ' . strtolower($entityName)),
                            [
                                'controller' => $controllerName,
                                'action' => strtolower($action),
                                $id,
                            ]
                        );
                    } else {
                        echo $this->Html->link(
                            __($action . ' ' . strtolower($entityName)),
                            [
                                'controller' => $controllerName,
                                'action' => strtolower($action),
                            ]
                        );
                    }

                    ?>
                </li>
            <?php
            endif;
            ?>
        </ul>
    </div>
</div>
<!--    End title section    -->
<?php
if ((strtolower($action) == 'index' || strtolower($action) == 'view')) :
?>
<!--    Action buttons    -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <h5><?= __('Action Buttons') ?></h5>
                </div>
                <div class="card-header-right">
                    <?php if (strtolower($action) == 'index'): ?>
                        <i class="icofont icofont-rounded-down icon-up"></i>
                    <?php else : ?>
                        <i class="icofont icofont-rounded-down"></i>
                    <?php endif; ?>
                    <i class="icofont icofont-close-circled"></i>
                </div>
            </div>
            <?php if (strtolower($action) == 'index'): ?>
            <div class="card-block remove-label action-buttons-section" style="display: none">
                <?php else : ?>
                <div class="card-block remove-label action-buttons-section">
                    <?php endif; ?>
                    <?php
                    if ((strtolower($action) == 'index')) {
                        echo $this->Html->link(
                            '<i class="ion-plus-circled"></i>' . ' ' . __('Add'),
                            [
                                'controller' => $controllerName,
                                'action' => 'add',
                            ],
                            [
                                'escapeTitle' => false,
                                'class' => 'btn btn-info',
                            ]
                        );
                    }
                    if ((strtolower($action) == 'view')) {
                        echo $this->Html->link(
                            '<i class="ion-edit"></i>' . ' ' . __('Edit'),
                            [
                                'controller' => $controllerName,
                                'action' => 'edit',
                                $id,
                            ],
                            [
                                'escapeTitle' => false,
                                'class' => 'btn btn-info',
                            ]
                        );

                        echo $this->Form->postLink(
                            '<i class="ion-trash-a"></i>' . ' ' . __('Delete'),
                            [
                                'action' => 'delete',
                                $id,
                            ],
                            [
                                'confirm' => __('Are you sure you want to delete {0}?', $fullName),
                                'escapeTitle' => false,
                                'class' => 'btn btn-danger',
                            ]
                        );
                        if (!empty($picture)) {
                            echo "<a class='mytooltip tooltip-effect-8 f-right'>" .
                                $this->Html->image('../attachments/users/' . $picture, ['alt' => 'image', 'class' => 'f-right']) .
                                "<span class='tooltip-content4'>" .
                                $this->Html->image('../attachments/users/' . $picture, ['alt' => 'image', 'class' => 'tooltip-picture']) .
                                "</span></a>";
                        }
                    } else {
                        echo $this->Form->button(
                            '<i class="ion-trash-a"></i>' . ' ' . __('Delete'),
                            [
                                'class' => 'btn btn-danger',
                                'id' => 'batch-delete',
                            ]
                        );
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--    End Action buttons    -->
    <?php
    endif;
    ?>
