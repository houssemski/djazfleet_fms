<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>


<div class="box-body main">
    <?php ?><h4 class="page-title"> <?= $supplier['Supplier']['name']; ?></h4>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?php
                                echo $this->Html->link(
                                    '<i class="  fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                    array('action' => 'edit', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5"
                                    )
                                );

                            echo $this->Form->postLink(
                                '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
                                array('action' => 'delete', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                array(
                                    'escape' => false,
                                    'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"
                                ),
                                __('Are you sure you want to delete this element ?')); ?>

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
                <li><a href="#tab_2" data-toggle="tab"><?= __('Informations fiscales') ?></a></li>
                <?php if ($supplier['Supplier']['type'] == 1) { ?>
                    <li><a href="#tab_3" data-toggle="tab"><?= __('Attachments') ?></a></li>

                    <li><a href="#tab_4" data-toggle="tab"><?= __('Other addresses') ?></a></li>
                    <li><a href="#tab_5" data-toggle="tab"><?= __('Contact person') ?></a></li>
                    <?php switch ($supplier['Supplier']['final_customer']) {
                        case 1 :
                            ?>
                            <li><a href="#tab_6" data-toggle="tab"><?= __('Initial customer') ?></a></li>
                            <?php    break;
                        case 2 :
                            ?>
                            <li><a href="#tab_6" data-toggle="tab"><?= __('Final customer') ?></a></li>
                            <?php    break;
                        case 3 :
                            ?>
                            <li><a href="#tab_6" data-toggle="tab"><?= __('Initial / Final customer') ?></a></li>
                            <?php    break;
                            ?>


                        <?php
                    } ?>
                <?php } ?>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php if (!empty($supplier['Supplier']['code'])) { ?>

                        <dt><?php echo __('Code'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['code']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <dt><?php echo __('Name'); ?></dt>
                    <dd>
                        <?php echo h($supplier['Supplier']['name']); ?>
                        &nbsp;
                    </dd>
                    <br/>
                    <?php if (!empty($supplier['Supplier']['social_reason'])) { ?>

                        <dt><?php echo __('Social reason'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['social_reason']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['supplier_category_id'])) { ?>

                        <dt><?php echo __('Category'); ?></dt>
                        <dd>
                            <?php echo h($supplier['SupplierCategory']['name']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>



                    <?php if (!empty($supplier['Supplier']['adress'])) { ?>

                        <dt><?php echo __('Adress'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['adress']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['tel'])) { ?>

                        <dt><?php echo __('Tél.'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['tel']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>



                    <?php  echo "<div class='form-group'>" . $this->Form->input('latlng', array(
                            'type' => 'hidden',
                            'value' => $supplier['Supplier']['latlng'],
                            'id' => "latlng"
                        )) . "</div>";
                    ?>
                    <div id="map" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
                    <div style="clear: both"></div>
                    <?php if (!empty($supplier['Supplier']['contact'])) { ?>

                        <dt><?php echo __('Contact'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['contact']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>

                    <?php if (!empty($supplier['Supplier']['email'])) { ?>

                        <dt><?php echo __('Email'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['email']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['tel'])) { ?>

                        <dt><?php echo __('Phone'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['tel']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['note'])) { ?>

                        <dt><?php echo __('Note'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['note']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>

                </div>
                <div class="tab-pane " id="tab_2">
                    <?php if (!empty($supplier['Supplier']['rc'])) { ?>

                        <dt><?php echo __('RC'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['rc']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['if'])) { ?>

                        <dt><?php echo __('IF'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['if']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['ai'])) { ?>

                        <dt><?php echo __('AI'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['ai']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['nis'])) { ?>

                        <dt><?php echo __('NIS'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['nis']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (!empty($supplier['Supplier']['cb'])) { ?>

                        <dt><?php echo __('CB'); ?></dt>
                        <dd>
                            <?php echo h($supplier['Supplier']['cb']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>


                </div>

                <?php if ($supplier['Supplier']['type'] == 1) { ?>


                    <div class="tab-pane " id="tab_3">


                        <table class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo $this->Paginator->sort('name', __('Type')); ?></th>
                            </tr>
                            <tbody>
                            <?php
                            foreach ($supplierAttachmentTypes as $supplierAttachmentType) {
                                ?>
                                <tr>
                                    <td><?php echo h($supplierAttachmentType['AttachmentType']['name']); ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                            </thead>

                        </table>


                    </div>
                    <div class="tab-pane " id="tab_4">
                        <table class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                                <th><?php echo $this->Paginator->sort('address', __('Address')); ?></th>
                            </tr>
                            <tbody>
                            <?php
                            foreach ($supplierAddresses as $supplierAddresse) {
                                ?>
                                <tr>
                                    <td><?php echo h($supplierAddresse['SupplierAddress']['code']); ?></td>
                                    <td><?php echo h($supplierAddresse['SupplierAddress']['address']); ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                            </thead>

                        </table>
                    </div>
                    <div class="tab-pane " id="tab_5">
                        <table class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo $this->Paginator->sort('contact', __('Contact')); ?></th>
                                <th><?php echo $this->Paginator->sort('function', __('Function')); ?></th>
                                <th><?php echo $this->Paginator->sort('email1', __('Email 1')); ?></th>
                                <th><?php echo $this->Paginator->sort('email2', __('Email 2')); ?></th>
                                <th><?php echo $this->Paginator->sort('email3', __('Email 3')); ?></th>
                                <th><?php echo $this->Paginator->sort('tel', __('Tel')); ?></th>
                            </tr>
                            <tbody>
                            <?php
                            foreach ($supplierContacts as $supplierContact) {
                                ?>
                                <tr>
                                    <td><?php echo h($supplierContact['SupplierContact']['contact']); ?></td>
                                    <td><?php echo h($supplierContact['SupplierContact']['function']); ?></td>
                                    <td><?php echo h($supplierContact['SupplierContact']['email1']); ?></td>
                                    <td><?php echo h($supplierContact['SupplierContact']['email2']); ?></td>
                                    <td><?php echo h($supplierContact['SupplierContact']['email3']); ?></td>
                                    <td><?php echo h($supplierContact['SupplierContact']['tel']); ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                            </thead>

                        </table>
                    </div>
                    <div class="tab-pane " id="tab_6">
                        <?php

                        switch ($supplier['Supplier']['final_customer']) {
                            case 1:
                                ?>
                                <dt><?php echo __('Initial customer'); ?></dt>

                                <dd>

                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                                            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        foreach ($initialSuppliers as $initialSupplier) {
                                            ?>
                                            <tr>
                                                <td><?php echo h($initialSupplier['InitialSupplier']['code']); ?></td>
                                                <td><?php echo h($initialSupplier['InitialSupplier']['name']); ?></td>
                                            </tr>
                                        <?php
                                        }

                                        ?>

                                        </tbody>
                                        </thead>

                                    </table>
                                    <?php
                                    if ($this->params['paging']['FinalSupplierInitialSupplier']['pageCount'] > 1) {
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

                                </dd>
                                <?php
                                break;

                            case 2:
                                ?>
                                <dt><?php echo __('Final customer'); ?></dt>
                                <?= $this->Html->link(
                                '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                                array('controller' => 'suppliers', 'action' => 'add',$supplier['Supplier']['type'], $supplier['Supplier']['id']),
                                array('target' => '_blank','escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                            ); ?>

                                <dd>
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                                            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        foreach ($finalSuppliers as $finalSupplier) {
                                            ?>
                                            <tr>
                                                <td><?php echo h($finalSupplier['FinalSupplier']['code']); ?></td>
                                                <td><?php echo h($finalSupplier['FinalSupplier']['name']); ?></td>
                                            </tr>
                                        <?php
                                        }

                                        ?>

                                        </tbody>
                                        </thead>

                                    </table>

                                    <?php
                                    if ($this->params['paging']['FinalSupplierInitialSupplier']['pageCount'] > 1) {
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
                                </dd>
                                <?php
                                break;

                            case 3:
                                ?>
                                <dt><?php echo __('Initial customer'); ?></dt>

                                <dd>
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                                            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        foreach ($initialSuppliers as $initialSupplier) {
                                            ?>
                                            <tr>
                                                <td><?php echo h($initialSupplier['InitialSupplier']['code']); ?></td>
                                                <td><?php echo h($initialSupplier['InitialSupplier']['name']); ?></td>
                                            </tr>
                                        <?php
                                        }

                                        ?>

                                        </tbody>
                                        </thead>

                                    </table>
                                    <?php
                                    if ($this->params['paging']['FinalSupplierInitialSupplier']['pageCount'] > 1) {
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

                                </dd>
                                <br/>

                                <dt><?php echo __('Final customer'); ?></dt>

                                <?= $this->Html->link(
                                '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                                array('controller' => 'suppliers', 'action' => 'add',$supplier['Supplier']['type'], $supplier['Supplier']['id']),
                                array('target' => '_blank','escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                                ); ?>

                                <dd>
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                                            <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        foreach ($finalSuppliers as $finalSupplier) {
                                            ?>
                                            <tr>
                                                <td><?php echo h($finalSupplier['FinalSupplier']['code']); ?></td>
                                                <td><?php echo h($finalSupplier['FinalSupplier']['name']); ?></td>
                                            </tr>
                                        <?php
                                        }

                                        ?>

                                        </tbody>
                                        </thead>

                                    </table>
                                    <?php
                                    if ($this->params['paging']['FinalSupplierInitialSupplier']['pageCount'] > 1) {
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
                                </dd>
                                <?php
                                break;
                        } ?>

                        <br/>
                    </div>


                <?php } ?>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', initialize(14, "map"));

    });


    //fonction appel� plus bas, ouvre un marqueur et recadre la carte aux coordonn�es indiqu�es pour la cartes donn�e
    function traiteAdresse(marker, latLng, infowindow, map) {
        //recadre et zomme sur les coordonn�es latLng

        map.setCenter(latLng);
        map.setZoom(14);
        var latlongdef = latLng.toString();
        latlongdef = latlongdef.substring(1);
        latlongdef = latlongdef.substring(0, latlongdef.length - 1);
        latlongdef = latlongdef.split(",");
        var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
        lat = parseFloat(latlongdef[0]);
        lng = parseFloat(latlongdef[1]);
        jQuery('#latitude').val(lat);
        jQuery('#longitude').val(lng);
        //on stocke nos nouvelles coordon�e dans le champs correspondant
        document.getElementById('latlng').value = latLng;
        //on va rechercher les information sur l'adresse correspondant � ces coordonn�es
        geocoder.geocode({
            'latLng': latLng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse compl�te
                    document.getElementById("addresspicker").value = results[0].formatted_address;

                    var nb_el = results[0].address_components.length;
                    //et ses diff�rentes composantes s�par�ment

                    infowindow.open(map, marker);
                } else {
                    alert("No results found");
                }
            } else {
                alert("Geocoder failed due to: " + status);
            }
        });
    }
    //fonction initialisant la carte
    function initialize(zoom, carte) {
        geocoder = new google.maps.Geocoder();
        //par d�faut on prend les coordonn�es entr� dans notre champs latlng
        var latlongdef = document.getElementById('latlng').value;
        if (latlongdef == '') {
            var latlng = new google.maps.LatLng(36.75218210858053, 3.0426488148193584);
        }
        else {
            latlongdef = latlongdef.substring(1);

            latlongdef = latlongdef.substring(0, latlongdef.length - 1);

            latlongdef = latlongdef.split(",");
            var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
        }


        //on initialise notre carte
        var options = {
            center: latlng,
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById(carte), options);
        //on indique que notre champ addresspicker doit proposer les adresses existantes
        var input = document.getElementById('addresspicker');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        //mise en place du marqueur
        var infowindow = new google.maps.InfoWindow();

        var icoParc = {
            //path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
            //url:'http://image.flaticon.com/icons/svg/190/190290.svg',
            url: 'http://image.flaticon.com/icons/svg/204/204314.svg',
            fillColor: '#FF0000',
            //fillOpacity: .3,
            //  anchor: new google.maps.Point(0,0),
            strokeWeight: 0,
            scale: 0.1,
            scaledSize: new google.maps.Size(32, 32)
        }
        var marker = new google.maps.Marker({
            map: map,
            icon: icoParc
        });
        //d�placable
        marker.setDraggable(true);
        marker.setPosition(latlng);
        //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
        /*    google.maps.event.addListener(marker, 'dragend', function(event) {
         traiteAdresse(marker, event.latLng, infowindow, map);
         }); */

        //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
        /*   google.maps.event.addListener(autocomplete, 'place_changed', function() {
         infowindow.close();
         var place = autocomplete.getPlace();
         marker.setPosition(place.geometry.location);
         traiteAdresse(marker, place.geometry.location, infowindow, map);
         });*/
    }

</script>
<?php $this->end(); ?>