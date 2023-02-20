<?php
/**
 * @var array $busRoute
 * @var array $busStops
 * @var array $checkPointsArray
 */

?>

<style>
    .main-progress-div{
        width: 100%;
        height: 50vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    ul{
        display: flex;
        margin-top: 50px;
    }

    ul li{
        list-style: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    ul li .p-icon{
        font-size: 35px;
        color: #ff4732;
        margin: 0 60px;
    }
    ul li .p-time{
        font-size: 10px;
        font-weight: 600;
        color: #ff4732;
    }

    ul li .p-time2{
        font-size: 10px;
        font-weight: 600;
        color: #ffffff;
    }

    ul li .p-title{
        font-size: 12px;
        font-weight: 700;
        color: #ff4732;
    }
    ul li .p-title2{
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
    }

    ul li .p-text{
        font-size: 18px;
        font-weight: 600;
        color: #ff4732;
    }
    ul li .progress-step .uil{
        display: none;
    }

    ul li .progress-step{
        margin: 12px 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: rgba(68,68,68,0.781);
        display: grid;
        place-items : center;
        color:#fff;
        position: relative;
        cursor: pointer;
    }
    ul li .progress-step p {
        font-size: 14px;
    }

    .progress-step::after{
        content: ' ';
        position: absolute;
        width: 125px;
        height: 5px;
        background-color: rgba(68,68,68,0.781);
        right: 30px;
    }
    .stop-1::after{
        width: 0;
        height: 0;
    }
    ul li .active{
        background-color: #ff4732;
    }

    li .active::after{
        background-color: #ff4732;
    }

    ul li .active p{
        display: none;
    }

    ul li .active .uil{
        display: flex;
        font-size: 20px;
    }
</style>

<div class="box">
    <h4 class="page-title"> <?= __('View sheet ride (travel)'); ?></h4>
    <div class="edit form card-box p-b-0">


        <div class="box-body" >

            <table class="table table-bordered " id='table-stops'>

                <tr>
                    <td rowspan="100" ><?php echo __('Travel'); ?></td>
                    <td colspan="2"><?php echo __('Car'); ?> </td>
                    <td >
                        <?= $busRoute['BusRoute']['route_title'] ?>
                    </td>
                    <td>
                        <?= $busRoute['Car']['immatr_def'].' / '.$busRoute['CarModel']['name'] ?>
                    </td>
                    <td>
                        <?= $busRoute['Customers']['first_name'] .' '. $busRoute['Customers']['last_name'] ?>
                    </td>
                </tr>
                <?php foreach ($busStops as $stop){ ?>
                    <tr>
                        <td colspan="2"> <?php echo __('Stop'); ?>  </td>
                        <td>
                            <?= $stop['BusRouteStop']['name'] ?>
                        </td>
                        <td>
                            lng : <?= $stop['BusRouteStop']['lng'] ?>
                        </td>
                        <td>
                            lat : <?= $stop['BusRouteStop']['lat'] ?>
                        </td>
                    </tr>
                <?php } ?>

            </table>
            <?= $this->Html->link(
                '<i   class="fa fa-newspaper-o" aria-hidden="true"></i>'.__('Generate report'),
                array('plugin' => 'BusRoutes','controller' => 'CustomRoutes','action' => 'generateReport', $busRoute['Car']['tracker_id']),
                array('escape' => false , 'class'=>'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5','target' => '_blank')
            ); ?>
            <br>

            <?php
            foreach ($checkPointsArray as $item){
            ?>

            <div class="main-progress-div">
                <ul>
                  <?php
                  $i = 1;
                  foreach ($item as $value){
                      if (!empty($value['arrival_time'])){
                          $time =  $this->Time->format($value['arrival_time'],'%H:%M');
                          $timestamp = strtotime($time) + 60*60;
                          $time = date('H:i', $timestamp);
                      }else{
                          $time = 'N/A';
                      }

                      ?>
                      <li>
                          <i class="p-icon uil uil-map-marker" ></i>
                          <div class="<?= $value['active'] ? "active" : ''  ?> progress-step stop-<?= $i ?>">
                              <p></p>
                              <i class="uil uil-check" ></i>
                          </div>
                          <p class="p-text"><?= $value['stop_name'] ?></p>
                          <p class="p-title"><?= __('Arrival time') ?></p>
                          <p class="p-time"><?= $time   ?></p>
                          <?php
                          if (isset($value['expected_arrival_time'])){
                          ?>
                              <p class="p-title"><?= __('Expected arrival time') ?></p>
                              <p class="p-time"><?= $this->Time->format($value['expected_arrival_time'],'%H:%M')  ?></p>
                          <?php
                          }else{
                          ?>
                              <p class="p-title2"><?= __('Expected arrival time') ?></p>
                              <p class="p-time2"><?= 'blank'  ?></p>
                          <?php
                          }
                          ?>

                      </li>
                    <?php $i++;}?>
                </ul>

            </div>
            <?php
            }
            ?>

            <div class="main-progress-div" style="display: none">
                <ul>
                    <li>
                        <i class="p-icon uil uil-map-marker" ></i>
                        <div class="active progress-step one">
                            <p></p>
                            <i class="uil uil-check" ></i>
                        </div>
                        <p class="p-text">Postion</p>
                    </li>
                    <li>
                        <i class="p-icon uil uil-map-marker" ></i>
                        <div class="active progress-step two">
                            <p></p>
                            <i class="uil uil-check" ></i>
                        </div>
                        <p class="p-text">Postion</p>
                    </li>
                    <li>
                        <i class="p-icon uil uil-map-marker" ></i>
                        <div class="progress-step three">
                            <p></p>
                            <i class="uil uil-check" ></i>
                        </div>
                        <p class="p-text">Postion</p>
                    </li>
                </ul>
            </div>
        </div>

    </div>

</div>

<script>
    jQuery(document).ready(function () {
        setTimeout(function(){
            location.reload();
        }, 20000);
    });
    const one = document.querySelector(".one");
    const two = document.querySelector(".two");
    const three = document.querySelector(".three");
</script>