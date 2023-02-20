   <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    
                    <tbody>
                    <?php
                    $cars=array();
                    $i=0;
                    foreach ($carTypes as $carType) {
                        $i++;
                        if ($i < count($carTypes)) {
                            if ($carTypes[$i]['CarType']['id'] == $carType['CarType']['id']) {
                                $categories[] = $carType['CarCategory']['name'] ;
                            } else {
                                $categories[] = $carType['CarCategory']['name'] ;
                                ?>
                                <tr id="row<?= $carType['CarType']['id'] ?>">
                                    <td>
                                        <input id="idCheck" type="checkbox" class='id'
                                               value=<?php echo $carType['CarType']['id'] ?>>
                                    </td>
                                    <td><?php echo $carType['CarType']['code'] ?> </td>
                                    <td>
                                        <?php echo $carType['CarType']['name'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        $nbCategory = count($categories);
                                        $j = 1;
                                        foreach ($categories as $category) {
                                            if ($j == $nbCategory) {
                                                echo $category;
                                            } else {
                                                echo $category . ' / ';
                                            }
                                            $j++;
                                        } ?>
                                    </td>
                                    <td> <?php echo $carType['CarType']['average_speed'] ?></td>
                                    <td> <?php h($this->Time->format($carType['CarType']['created'], '%d-%m-%Y')) ?></td>
                                    <td> <?php h($this->Time->format($carType['CarType']['modified'], '%d-%m-%Y')) ?></td>
                                    <td class="actions">
                                        <div  class="btn-group ">
                                            <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                <i class="fa fa-list fa-inverse"></i>
                                            </a>
                                            <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                                <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu" style="min-width: 70px;">

                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                        array('action' => 'View', $carType['CarType']['id']),
                                                        array('escape' => false, 'class'=>'btn btn-success')
                                                    ); ?>
                                                </li>

                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                        array('action' => 'Edit', $carType['CarType']['id'] ),
                                                        array('escape' => false , 'class'=>'btn btn-primary')
                                                    ); ?>
                                                </li>


                                                <li>
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                        array('action' => 'delete', $carType['CarType']['id']),
                                                        array('escape' => false , 'class'=>'btn btn-danger'),
                                                        __('Are you sure you want to delete %s?',$carType['CarType']['name'])); ?>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>


                                </tr>

                                <?php  $carTypeId = $carType['CarType']['id'];
                                $categories = array();
                            }


                        } else {

                            $categories[] = $carType['CarCategory']['name'] ;


                            ?>


                            <tr id="row<?= $carType['CarType']['id'] ?>">
                                <td class='case'>

                                    <input id="idCheck" type="checkbox" class='id'
                                           value=<?php echo $carType['CarType']['id'] ?>>
                                </td>
                                <td><?php echo $carType['CarType']['code'] ?> </td>
                                <td> <?php echo $carType['CarType']['name'] ?> </td>
                                <td><?php
                                    $nbCategory = count($categories);

                                    $j = 1;
                                    foreach ($categories as $category) {
                                        if ($j == $nbCategory) {
                                            echo $category;
                                        } else {
                                            echo $category . ' / ';
                                        }
                                        $j++;
                                    } ?>

                                </td>
                                <td> <?php echo $carType['CarType']['average_speed'] ?></td>
                                <td> <?php h($this->Time->format($carType['CarType']['created'], '%d-%m-%Y')) ?></td>
                                <td> <?php h($this->Time->format($carType['CarType']['modified'], '%d-%m-%Y')) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(
                                        '<i class="  fa fa-eye m-r-5"></i>',
                                        array('action' => 'View', $carType['CarType']['id']),
                                        array('escape' => false)
                                    ); ?>

                                    <?= $this->Html->link(
                                        '<i class="  fa fa-edit m-r-5"></i>',
                                        array('action' => 'Edit', $carType['CarType']['id']),
                                        array('escape' => false)
                                    ); ?>
                                    <?php echo $this->Form->postLink(
                                        '<i class=" fa fa-trash-o m-r-5"></i>',
                                        array('action' => 'Delete', $carType['CarType']['id']),
                                        array('escape' => false),
                                        __('Are you sure you want to delete %s?', $carType['CarType']['name'])); ?>
                                </td>


                            </tr>





                        <?php
                        }
                    }

                    ?>


                    </tbody>


                </table>
   <div id ='pageCount' class="hidden">
                <?php
if($this->params['paging']['CarTypeCarCategory']['pageCount'] > 1){
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
       </div>