<?php

use App\View\AppView;

/**
 * @var AppView $this
 * @var string $entityName
 * @var string $actionName
 * @var string $action
 * @var string $controllerName
 * @var array $documentTypesEnum
 * @var int $documentTypeId
 */
echo $this->Html->css('sweetalert2.min');
echo $this->Html->script('sweetalert2.min');

?>
<!-- Sign in modal start -->
<div class="modal" id="form-modal-add-serial-numbers" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= __('Serial numbers')  ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            echo $this->Form->create(null, array(
                'class' => 'modal-form-add-serial-numbers'
                )
            );

            ?>
            <div class="modal-body p-b-0">

                <div id="serial-numbers-table">

                </div>


            </div>
            <div id="modal-select-info">
                <!-- Used to track the neighboring select -->
                <span class="hidden" id="modal-select-id"></span>
                <span class="hidden modal-select-row-number"></span>
            </div>

            <div class="modal-footer">

                <?= $this->Form->button(__('Submit'), array(
                    'class' => 'btn btn-primary',
                    'id' => 'batch-add-serial-number-submit',
                )) ?>


                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('Cancel') ?></button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<!-- Sign in modal end -->
<?= $this->Html->script('sweetalert2.min') ?>
<script>
    jQuery("#batch-add-serial-number-submit").on('click', function(e) {

        e.preventDefault();
        var form = jQuery(".modal-form-add-serial-numbers");
        var lineNumber = jQuery("#lineNumber").val();

        var nbSerialNumbers = jQuery('#nb-serial-' + lineNumber).val();
        var serialNumbers = getSerialNumbers(nbSerialNumbers, lineNumber);
        var serialNumberIds = getSerialNumberIds(nbSerialNumbers, lineNumber);
        var serialNumberLabels = getSerialNumberLabels(nbSerialNumbers, lineNumber);
        var serialNumberExpirationDates = getSerialNumberExpirationDates(nbSerialNumbers, lineNumber);
        var loadUrl = '<?php echo $this->Html->url("loadSerialNumberInputs"
        ); ?>' + "/" + lineNumber + "/" + serialNumbers + "/" + serialNumberIds + "/" + serialNumberLabels+ "/" + serialNumberExpirationDates;


        jQuery('#serial-number-inputs-' + lineNumber).load(loadUrl, function() {
            /* REINITIALIZATION */
            jQuery('#form-modal-add-serial-numbers').modal('hide');
        });

    });




    function checkIfSerialNumberIsDeliveredToSupplier(serialNumberId, thirdPartyId, lineNumber, i) {
        jQuery.ajax({
            type: 'GET',
            url: "<?=  $this->Html->url('checkIfSerialNumberIsDeliveredToSupplierAjax') ?>",
            data: {
                serialNumberId: serialNumberId,
                thirdPartyId: thirdPartyId
            },
            dataType: "json",
            async: false,

            success: function(data) {

                if (data.response === 'true') {
                    checkSerialNumberGuarantee(serialNumberId, data.documentDate);

                    jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.id));
                } else {
                    Swal.fire({
                        icon: 'warning',
                        text: '<?= __("This client does not have a delivery note with this serial number.") ?>',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                        jQuery('.modal').css('z-index', '999999');
                        jQuery('#serial-' + lineNumber + '-' + i).val('');
                        jQuery('#label-serial-' + lineNumber + '-' + i).val('');
                    }
                });
                }

            },
            error: function(error) {}
        });
    }

    function addSerialNumber(serialNumber, productId, lineNumber, i, label) {
        jQuery.ajax({
            type: 'GET',
            dataType: "json",
            url: "<?=  $this->Html->url(array('controller'=>'serialNumbers','action'=>'addSerialNumberAjax')) ?>",
            data: {
                serialNumber: serialNumber,
                productId: productId,
                label: label
            },

            success: function(data) {
                if (data.response === 'true') {

                    jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.id));
                }
            },
            error: function(error) {}
        });
    }

    function updateSerialNumber(serialNumber, productId, lineNumber, i, serialNumberId) {

        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "<?=  $this->Html->url(array('controller'=>'serialNumbers','action'=>'updateSerialNumberAjax')) ?>",
            data: {
                serialNumber: serialNumber,
                productId: productId,
                serialNumberId: serialNumberId
            },

            success: function(data) {
                if (data.response === 'true') {

                    jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.id));
                }
            },
            error: function(error) {}
        });
    }

    function deleteSerialNumber(serialNumberId) {
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "<?=  $this->Html->url(array('controller'=>'serialNumbers','action'=>'deleteSerialNumberAjax')) ?>",
            data: {
                serialNumberId: serialNumberId
            },

            success: function(data) {
                if (data.response === 'true') {
                    Swal.fire({
                        icon: 'success',
                        text: '<?= __("The serial number has been deleted.") ?>',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                        jQuery('.modal').css('z-index', '999999');

                    }
                });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        text: '<?= __("The serial number could not be deleted. Please, try again.") ?>',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                        jQuery('.modal').css('z-index', '999999');

                    }
                });
                }
            },
            error: function(error) {}
        });
    }

    function checkSerialNumberGuarantee(serialNumberId, documentDate) {
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: "<?= $this->Html->url(array('controller'=>'serialNumbers','action'=>'checkSerialNumberGuaranteeAjax')) ?>",
            data: {
                serialNumberId: serialNumberId,
                documentDate: documentDate
            },

            success: function(data) {
                if (data.response === 'true') {

                    Swal.fire({
                        icon: 'success',
                        text: '<?= __("The product is still in warranty period.") ?>',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                        jQuery('.modal').css('z-index', '999999');

                    }
                });

                } else {

                    Swal.fire({
                        icon: 'warning',
                        text: '<?= __("The product has exceeded the warranty period.") ?>',
                        showConfirmButton: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                        jQuery('.modal').css('z-index', '999999');

                    }
                });

                }
            },
            error: function(error) {}
        });
    }

    function checkIfSerialNumberExist(lineNumber, i) {

        var modalElement= jQuery('.modal');
        var serialNumber = jQuery('#serial-' + lineNumber + '-' + i).val();
        var serialNumberId = jQuery('#serial-id-' + lineNumber + '-' + i).val();
        var productId = jQuery('#product' + lineNumber).val();

        if (serialNumber === '' && typeof serialNumberId !== 'undefined' && serialNumberId !== '') {
            jQuery('.modal').css('z-index', 'auto');
            Swal.fire({
                text: '<?= __("Do you want to delete this serial number.") ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= __("Delete it") ?>',
                cancelButtonText: '<?= __("Cancel") ?>',

            }).then((result) => {
                if (result.isConfirmed) {
                deleteSerialNumber(serialNumberId);
            } else {
                jQuery('.modal').css('z-index', '999999');
            }
        })

        } else {
            jQuery.ajax({
                type: 'GET',
                url: "<?= $this->Html->url(array('controller'=>'serialNumbers', 'action'=>'checkIfSerialNumberExistAjax')) ?>",
                data: {
                    serialNumber: serialNumber,
                    productId: productId
                },
                dataType: "json",

                success: function(data) {

                    if (data.response === "true") {

                        modalElement.css('z-index', 'auto');
                        if (data.isUsed === true) {
                            <?php if ($type == BillTypesEnum::return_customer) { ?>
                            var thirdPartyId = jQuery('#client').val();
                            if (thirdPartyId !== '') {
                                checkIfSerialNumberIsDeliveredToSupplier(data.serialNumberId, thirdPartyId, lineNumber, i);
                            } else {
                                alert('<?= __("Please select a client") ?>');
                                jQuery('#serial-' + lineNumber + '-' + i).val('');
                                jQuery('#label-serial-' + lineNumber + '-' + i).val('');
                                modalElement.css('z-index', '999999');
                            }
                            <?php } else { ?>
                            Swal.fire({
                                icon: 'warning',
                                text: '<?= __("The serial number is already used") ?>',
                                showConfirmButton: true,

                            }).then((result) => {
                                if (result.isConfirmed) {
                                modalElement.css('z-index', '999999');
                                jQuery('#serial-' + lineNumber + '-' + i).val('');
                                jQuery('#label-serial-' + lineNumber + '-' + i).val('');

                            }
                        });
                            <?php } ?>

                        } else {
                            <?php if ($type == BillTypesEnum::return_customer) { ?>
                            Swal.fire({
                                icon: 'success',
                                text: '<?= __("The serial number is available, it can not be used in return customer note.") ?>',
                                showConfirmButton: true,

                            }).then((result) => {
                                if (result.isConfirmed) {

                                modalElement.css('z-index', '999999');
                                jQuery('#serial-' + lineNumber + '-' + i).val('');
                                jQuery('#label-serial-' + lineNumber + '-' + i).val('');

                            }
                        });

                            <?php } else {
                               if(
                            $type == BillTypesEnum::delivery_order ||
                            $type == BillTypesEnum::exit_order
                               ) {
                                ?>
                            jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.serialNumberId));
                            jQuery('#label-serial-' + lineNumber + '-' + i).val(data.label);

                            Swal.fire({
                                icon: 'success',
                                text: '<?= __("The serial number is available") ?>',
                                showConfirmButton: true,

                            }).then((result) => {
                                if (result.isConfirmed) {
                                jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.serialNumberId));
                                jQuery('#label-serial-' + lineNumber + '-' + i).val(data.label);

                                modalElement.css('z-index', '999999');

                            }
                        });

                            <?php
                            } else { ?>

                            jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.serialNumberId));
                            jQuery('#label-serial-' + lineNumber + '-' + i).val(data.label);

                            Swal.fire({
                                icon: 'warning',
                                text: '<?= __("The serial number already exists") ?>',
                                showConfirmButton: true,

                            }).then((result) => {
                                if (result.isConfirmed) {

                                    jQuery('#serial-id-' + lineNumber + '-' + i).val('');
                                    jQuery('#label-serial-' + lineNumber + '-' + i).val('');
                                    jQuery('#serial-' + lineNumber + '-' + i).val('');

                                    modalElement.css('z-index', '999999');

                                }
                            });

                      <?php  }
                               } ?>
                        }
                    } else {
                        <?php if (
                        $type == BillTypesEnum::delivery_order ||
                        $type == BillTypesEnum::exit_order
                        ) { ?>
                        jQuery('.modal').css('z-index', 'auto');
                        if (typeof serialNumberId !== 'undefined' && serialNumberId !== '') {

                                Swal.fire({
                                    text: '<?= __("The serial number do not exist") ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '<?= __("Update it") ?>',
                                    cancelButtonText: '<?= __("Cancel") ?>',

                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    modalElement.css('z-index', '999999');
                                    updateSerialNumber(serialNumber, productId, lineNumber, i, serialNumberId);
                                } else {
                                    modalElement.css('z-index', '999999');
                                }
                            })

                        } else {
                                Swal.fire({
                                    text: '<?= __("The serial number do not exist") ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '<?= __("Create it") ?>',
                                    cancelButtonText: '<?= __("Cancel") ?>',

                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    modalElement.css('z-index', '999999');
                                    addSerialNumber(serialNumber, productId, lineNumber, i);
                                } else {
                                    modalElement.css('z-index', '999999');
                                }
                            })

                        }
                        <?php } ?>
                    }
                    //dataTable.columns.adjust().draw();
                },
                error: function(error) {}
            });
        }
    }

    function checkIfLabelSerialNumberExist(lineNumber, i){
        var modalElement= jQuery('.modal');
        var label = jQuery('#label-serial-' + lineNumber + '-' + i).val();
        var productId = jQuery('#product' + lineNumber).val();
        jQuery.ajax({
            type: 'GET',
            url: "<?= $this->Html->url(array('controller'=>'serialNumbers','action'=>'checkIfLabelSerialNumberExistAjax')) ?>",
            data: {
                label: label,
                productId: productId
            },
            dataType: "json",

            success: function (data) {
                if (data.response === "true") {
                    if (data.isUsed === true) {
                        modalElement.css('z-index', 'auto');
                        Swal.fire({
                            icon: 'warning',
                            text: '<?= __("The serial number is already used") ?>',
                            showConfirmButton: true,

                        }).then((result) => {
                            if (result.isConfirmed) {
                            modalElement.css('z-index', '999999');
                            jQuery('#serial-' + lineNumber + '-' + i).val('');
                            jQuery('#label-serial-' + lineNumber + '-' + i).val('');

                        }
                    });
                    } else {
                        modalElement.css('z-index', 'auto');
                        Swal.fire({
                            icon: 'success',
                            text: '<?= __("The serial number is available") ?>',
                            showConfirmButton: true,

                        }).then((result) => {
                            if (result.isConfirmed) {
                            jQuery('#serial-id-' + lineNumber + '-' + i).val(parseInt(data.serialNumberId));
                            jQuery('#serial-' + lineNumber + '-' + i).val(data.serial);
                            modalElement.css('z-index', '999999');
                        }
                    });
                    }
                }

            }
        })
    }


</script>
