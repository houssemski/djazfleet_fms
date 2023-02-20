<script>
    let i = 1;
    jQuery(document).ready(function () {
        jQuery('.select2').select2();
        jQuery(".time").inputmask("h:s", {"placeholder": "hh:mm"});
        jQuery('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
        });
        jQuery('#add-stop').click(function () {
            let nextStopNb = parseInt(jQuery('#next-stop-nb').val());
            console.log('click');
            jQuery('<tr></tr>').attr({
                id: 'stop-' + nextStopNb
            }).appendTo("#table-stops");
            jQuery("#stop-"+nextStopNb).load("<?php echo $this->Html->url(array('plugin' => 'BusRoutes', 'controller' => 'CustomRoutes', 'action' => 'addStop' ))?>/"+nextStopNb,function () {
                jQuery('#stop-select-'+nextStopNb).select2();
                nextStopNb++;
                jQuery('#next-stop-nb').val(nextStopNb);
            });
        });

        jQuery(document).on('change','[id^=stop-select-]',function () {
            let busStopId = jQuery(this).val();
            let stopOrder = jQuery(this).data('stopOrder');
            jQuery.ajax({
                type: "GET",
                url: "<?php echo $this->Html->url('/BusRoutes/BusRouteStops/getBusStopGeoFenceId') ?>",
                data: {
                    BusStopId: busStopId
                },
                dataType: "json",
                async: false,
                success: function(data) {
                    jQuery('#geo-fence-id-'+stopOrder).val(data);
                }
            });
        });

        jQuery(document).on('click','.generate',function () {
            let rotationNumber = jQuery(this).data('rotationNb');
            let busRouteId = jQuery(this).data('busRouteId');
            let rotationsToGenerate = jQuery('#rotations-to-generate-'+rotationNumber).val();
            if (isNaN(rotationsToGenerate) || rotationsToGenerate === ''){
                alert('Veuillez entrer le nembre de rotation agénérer');
                jQuery('#rotations-to-generate-'+rotationNumber).focus();
            }else{
                let url = "<?php echo $this->Html->url(array('plugin' => 'BusRoutes', 'controller' => 'CustomRoutes', 'action' => 'addRotationsAjax' ))?>/"+rotationNumber + '/' + busRouteId + '/' +rotationsToGenerate;
                jQuery('#rotation-'+rotationNumber).load(url,function () {
                    jQuery(".time").inputmask("h:s", {"placeholder": "hh:mm"});
                    jQuery('input[type="checkbox"]').iCheck({
                        checkboxClass: 'icheckbox_flat-red',
                    });
                });
            }
        });

        jQuery('#add-rotation').click(function () {
            let nbRotations = jQuery('#nb-rotations').val();
            let busRouteId = jQuery(this).data('busRouteId');
            nbRotations++;
            jQuery('<div></div>').attr({
                id: 'rotations-' + nbRotations
            }).appendTo("#rotations-container");
            let url = "<?php echo $this->Html->url(array('plugin' => 'BusRoutes', 'controller' => 'CustomRoutes', 'action' => 'addRotationAjax' ))?>/"+nbRotations + '/' + busRouteId ;
            jQuery('#rotations-'+nbRotations).load(url);
            jQuery('#nb-rotations').val(nbRotations);
        })
    });

    function deleteStop(elem){
        let stopNumber = elem.data('stopNumber');
        jQuery('#stop-'+stopNumber).remove();
    }

    function deleteStopInEdit(elem){
        let stopId = elem.data('stopId');
        let geoFenceId = elem.data('stopGeoFenceId');
        jQuery('<input/>').attr({
            name : 'stops_to_delete['+i+']',
            value : stopId,
            type : 'hidden'
        }).appendTo("#table-stops");
        jQuery('<input/>').attr({
            name : 'geo_fences_to_delete['+i+']',
            value : geoFenceId,
            type : 'hidden'
        }).appendTo("#table-stops");
        i++;
        deleteStop(elem);

    }

    function deleteRotationInEdit(elem){
        let i = elem.data('iCtr');
        let j = elem.data('jCtr');
        let rotationNumber = elem.data('rotationCtr');
        let departureRotationId = elem.data('departureRotationId');
        let arraivalRotationId = elem.data('arrivalRotationId');
        jQuery('<input/>').attr({
            name : 'BusRouteRotation[BusRotationToDelete][' + rotationNumber +''+i+''+ j + '0]',
            value : departureRotationId,
            type : 'hidden'
        }).appendTo("#table-stops");
        jQuery('<input/>').attr({
            name : 'BusRouteRotation[BusRotationToDelete][' + rotationNumber +''+i+''+ j + '1]',
            value : arraivalRotationId,
            type : 'hidden'
        }).appendTo("#table-stops");
        jQuery('#row-'+ rotationNumber + '-' + i + '-' + j).remove();
        jQuery('#delete-rotation-'+ rotationNumber + '-' + i + '-' + (j-1)).show();
        console.log(rotationNumber + '-' + i + '-' + j);
    }

    function deleteRotation(elem){
        let i = elem.data('iCtr');
        let j = elem.data('jCtr');
        let rotationNumber = elem.data('rotationCtr');
        jQuery('#row-'+ rotationNumber + '-' + i + '-' + j).remove();
        jQuery('#delete-rotation-'+ rotationNumber + '-' + i + '-' + (j-1)).show();
    }

    function deleteRotationInEdit(elem) {
        let rotationNumber = elem.data('rotationNb');
        let rotationId = elem.data('rotationId');
        jQuery('<input/>').attr({
            name : 'BusRouteRotation[RotationToDelete][' + rotationNumber + ']',
            value : rotationId,
            type : 'hidden'
        }).appendTo("#table-stops");
        jQuery('#tab-rotation-'+ rotationNumber).remove();
    }

    function deleteRotation(elem) {
        let rotationNumber = elem.data('rotationNb');
        jQuery('#tab-rotation-'+ rotationNumber).remove();
        let nbRotations = jQuery('#nb-rotations').val();
        nbRotations--;
        jQuery('#nb-rotations').val(nbRotations);
     }

</script>