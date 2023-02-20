
<div class="main-body">
    <div class="page-wrapper">

        <!--    Content section    -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card list-card">

                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="<?= $tableId ?>" class="table table-striped table-bordered nowrap" >
                                    <thead>
                                    <tr>
                                        <?php
                                        $c = 0;
                                        foreach ($columns as $column) {
                                            if($column[2] != 'CONCAT' && isset($column[3])){
                                                $minWidth = $column[3];
                                            }else{
                                                $minWidth = 0;
                                            }


                                            echo "<th style='min-width: '" . $minWidth . ">" . __("$column[3]") . "</th>";

                                            $c++;
                                        }
                                        ?>
                                        <?php if($action != 'addFromSheetRide' && $action != 'addFromCustomerOrder' && $action != 'addFromPreinvoice' && $action != 'viewDetail'){ ?>
                                            <th class="actions-th"><?= _('Actions') ?></th>
                                        <?php } ?>

                                    </tr>
                                    </thead>
                                    <thead>

                                    <tr class="filters">
                                        <?php
                                        $i = 0;
                                        foreach ($columns as $column) {

                                            if ($column[4] == 'datetime' || $column[4] == 'date') {
                                                $class = " date-index";
                                            } else {
                                                $class = "";
                                            }
                                            echo '<td><input type="text" data-column="' . $i . '" class="form-control search-txt' . $class . '"></td>';


                                            $i++;
                                        }
                                          if($action != 'addFromSheetRide' && $action !='addFromCustomerOrder' && $action != 'addFromPreinvoice' && $action != 'viewDetail') {
                                              echo '<td></td>';
                                          }
                                        ?>


                                    </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    End content section    -->
    </div>
</div>
<!--    DataTables Script    -->

