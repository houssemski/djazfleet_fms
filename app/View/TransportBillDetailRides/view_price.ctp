<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
    <thead>
    <tr>

        <th><?=$this->Paginator->sort('reference',__('Reference'))?></th>
        <th><?=$this->Paginator->sort('detail_ride_id',__('Rides'))?></th>

        <th><?=$this->Paginator->sort('unit_price',__('Unit price'))?></th>
        <th><?=$this->Paginator->sort('ristourne_%',__('Ristourne'))?></th>
        <th><?=$this->Paginator->sort('nb_trucks',__('Number of trucks'))?></th>

        <th><?=$this->Paginator->sort('price_ht',__('Price HT'))?></th>
        <th><?=$this->Paginator->sort('tva_id',__('TVA'))?></th>
        <th><?=$this->Paginator->sort('price_ttc',__('Price TTC'))?></th>



    </tr>
    </thead>

    <tbody >

        <tr>

            <td>
                <?=  $transportBillDetailRide['TransportBillDetailRides']['reference']?>
            </td>
            <td><?=  $transportBillDetailRide['DepartureDestination']['name'].'-'.$transportBillDetailRide['ArrivalDestination']['name'].'-'.$transportBillDetailRide['CarType']['name'];?></td>



            <td><?=  number_format($transportBillDetailRide['TransportBillDetailRides']['unit_price'], 2, ",", $separatorAmount)?></td>
            <td><?=  $transportBillDetailRide['TransportBillDetailRides']['ristourne_%']?></td>
            <td><?=  $transportBillDetailRide['TransportBillDetailRides']['nb_trucks']?></td>

            <td><?=  number_format($transportBillDetailRide['TransportBillDetailRides']['price_ht'], 2, ",", $separatorAmount)?></td>
            <td><?=  $transportBillDetailRide['Tva']['name']?></td>
            <td><?=  number_format($transportBillDetailRide['TransportBillDetailRides']['price_ttc'], 2, ",", $separatorAmount)?></td>





        </tr>


    </tbody>

</table>



