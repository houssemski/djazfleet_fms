<?php if (isset($_GET['page'])) { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'value' =>  $_GET['page'],
        'type' => 'hidden'
    )); ?>
    <?php
    $page = $_GET['page'];
} else { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'type' => 'hidden'
    )); ?>
    <?php
    $page = 1;
}
$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
$url = base64_encode(serialize($uriParts[0]));
$controller = $this->request->params['controller'];
?>
<?= $this->Form->input('url', array(
    'id' => 'url',
    'value' => base64_encode(serialize($uriParts[0])),
    'type' => 'hidden'
)); ?>

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">

    <tbody>
    <?php
    foreach ($sheetRides as $sheetRide): ?>
        <tr id="row<?= $sheetRide['SheetRide']['id'] ?>">
            <td onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'>
                <input id="idCheck" type="checkbox" class='id' value=<?php echo $sheetRide['SheetRide']['id'] ?>>
            </td>
            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                ><?php echo h($sheetRide['SheetRide']['reference']); ?>&nbsp;</td>
            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                > <?php if ($param == 1) {
                    echo $sheetRide['Car']['code'] . " - " . $sheetRide['Carmodel']['name'];
                } else if ($param == 2) {
                    echo $sheetRide['Car']['immatr_def'] . " - " . $sheetRide['Carmodel']['name'];
                } ?>

            </td>
            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                ><?php echo h($sheetRide['Customer']['first_name'] . ' - ' . $sheetRide['Customer']['last_name']); ?>
                &nbsp;</td>

            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                ><?php echo h($this->Time->format($sheetRide['SheetRide']['start_date'], '%d-%m-%Y %H:%M')); ?>
                &nbsp;</td>
            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                ><?php echo h($this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                &nbsp;</td>
            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                ><?php echo h($this->Time->format($sheetRide['SheetRide']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                &nbsp;</td>
            <td
                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                >
                <?php switch ($sheetRide['SheetRide']['status_id']) {
                    /*
                    1: feuille de route planifi�
                    2: feuille de route en cours
                    3: feuille de route retour au parc
                    4: feuille de route clotur�e
                    */
                    case 1:
                        echo '<span class="label label-warning">';
                        echo __('Planned') . "</span>";
                        break;
                    case 2:
                        echo '<span class="label label-danger">';
                        echo __('In progress') . "</span>";
                        break;
                    case 3:
                        echo '<span class="label label-primary">';
                        echo h(__('Return to park')) . "</span>";
                        break;
                    case 4:
                        echo '<span class="label label-success">';
                        echo __('Closed') . "</span>";
                        break;

                } ?>

            </td>

            <?php if ($isAgent) { ?>
                <td class="actions">
                    <div class='edit-link' title=<?= __('Edit') ?>>
                        <?= $this->Html->link(
                            '<i class="fa fa-edit"></i>',
                            array('action' => 'Edit', $sheetRide['SheetRide']['id']),
                            array('escape' => false, 'class' => 'btn btn-primary')
                        ); ?>
                    </div>

                    <div class='edit-link' title=<?= __('Print') ?>>
                        <?php switch ($reportingChoosed) {
                            case 1:
                                ?>
                                <?= $this->Html->link(
                                '<i class="fa fa-print"></i>',
                                array('action' => 'view_pdf', 'ext' => 'pdf', $sheetRide['SheetRide']['id']),
                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                            ); ?>
                                <?php
                                break;

                            case 2:
                                ?>
                                <?= $this->Html->link(
                                '<i class="fa fa-print"></i>',
                                array('action' => 'pdfReports', $sheetRide['SheetRide']['id']),
                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                            ); ?>
                                <?php
                                break;
                            case 3:
                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                if($sheetRide['SheetRide']['car_subcontracting']==1){
                                    $link = $reportsPathJasper . '/subcontracting_sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                }else {
                                    $link = $reportsPathJasper . '/sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                }
                                ?>
                                <a href="<?php echo $link ?>" target="_blank"
                                   class="btn btn-warning"><i class="fa fa-print"></i></a>
                                <?php    break;
                                ?>
                            <?php
                        } ?>


                    </div>
                </td>
            <?php } else { 
			if($currentAction == 'getSheetsToEdit'){ ?>
			
			 <td class="actions">
                 <?= $this->Html->link(
                     '<i class="fa fa-edit"></i>',
                     array('action' => 'Edit', $sheetRide['SheetRide']['id'],$controller, $url, $page, $transportBillDetailRideId, $observationId),
                     array('escape' => false, 'class' => 'btn btn-primary')
                 ); ?>
             </td>
			<?php }else {
			
			?>
                <td class="actions">
                    <div class="btn-group ">
                        <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                            <i class="fa fa-list fa-inverse"></i>
                        </a>
                        <button href="#" data-toggle="dropdown"
                                class="btn btn-info dropdown-toggle share">
                            <span class="caret"></span>
                        </button>

                        <ul class="dropdown-menu" style="min-width: 70px;">

                            <li class='view-link' title=<?= __('View') ?>>
                                <?= $this->Html->link(
                                    '<i   class="fa fa-eye"></i>',
                                    array('action' => 'View', $sheetRide['SheetRide']['id']),
                                    array('escape' => false, 'class' => 'btn btn-success')
                                ); ?>
                            </li>
                            <li>
                                <?php if ($client_i2b == 1) {
                                    echo '<li class = "localisation-link" title="' . __('Localisation') . '">';
                                    ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-map-marker"></i>',
                                        array('controller' => 'cars', 'action' => 'ViewPosition', $sheetRide['SheetRide']['car_id']),
                                        array('escape' => false, 'class' => 'btn btn-inverse')
                                    ); ?>
                                    <?php
                                    echo '</li>';
                                } ?>

                            <li class='edit-link' title=<?= __('Edit') ?>>
                                <?= $this->Html->link(
                                    '<i class="fa fa-edit"></i>',
                                    array('action' => 'Edit', $sheetRide['SheetRide']['id']),
                                    array('escape' => false, 'class' => 'btn btn-primary')
                                ); ?>
                            </li>
                            <li class='edit-link' title=<?= __('Print') ?>>
                                <?php switch ($reportingChoosed) {
                                    case 1:
                                        ?>
                                        <?= $this->Html->link(
                                        '<i class="fa fa-print"></i>',
                                        array('action' => 'view_pdf', 'ext' => 'pdf', $sheetRide['SheetRide']['id']),
                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                    ); ?>
                                        <?php
                                        break;

                                    case 2:
                                        ?>
                                        <?= $this->Html->link(
                                        '<i class="fa fa-print"></i>',
                                        array('action' => 'pdfReports', $sheetRide['SheetRide']['id']),
                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                    ); ?>
                                        <?php
                                        break;
                                    case 3:
                                        $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                        $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                        $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                        if($sheetRide['SheetRide']['car_subcontracting']==1){
                                            $link = $reportsPathJasper . '/subcontracting_sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                        }else {
                                            $link = $reportsPathJasper . '/sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                        }
                                        ?>
                                        <a href="<?php echo $link ?>" target="_blank"
                                           class="btn btn-warning"><i class="fa fa-print"></i></a>
                                        <?php    break;
                                        ?>
                                    <?php
                                } ?>


                            </li>

                            <li class='delete-link' title=<?= __('Delete') ?>>
                                <?php
                                echo $this->Form->postLink(
                                    '<i class="fa fa-trash-o"></i>',
                                    array('action' => 'delete', $sheetRide['SheetRide']['id']),
                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                    __('Are you sure you want to delete %s?', $sheetRide['SheetRide']['reference'])); ?>
                            </li>
                        </ul>
                    </div>
                </td>

            <?php } ?>
			<?php } ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['SheetRide']['pageCount'] > 1) {
        ?>
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>    </p>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-left">
                <?php
                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                echo $this->Paginator->numbers(array(
                    'tag' => 'li',
                    'first' => false,
                    'last' => false,
                    'separator' => '',
                    'currentTag' => 'a'));
                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                ?>
            </ul>
        </div>
    <?php } ?>
</div>