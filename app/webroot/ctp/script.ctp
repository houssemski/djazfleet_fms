<?php
$this->start('css');
echo $this->Html->css('select2/select2.min');
echo $this->Html->css('bootstrap-datetimepicker.min');

$this->end();
$this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>

<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
    <script type="text/javascript">

        jQuery(function () {
            $("input[type='number']").bind("input", function () {
                if(jQuery(this).val() !=''){
                    if ($.isNumeric(jQuery(this).val()) == false) {
                        alert('Veuillez saisir un nombre');
                        jQuery(this).val('');
                        jQuery(this).focus();
                    }
                }
            });

            $(".select2").select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true

            });


            $(".select-popup").select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true
            });
            $(".select-search").select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true

            });

            $('#ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/rides/getRidesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });

            $('.select-search-detail-ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });


            $('.select-search-destination').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });

            $('.select-search-sheet').select2({
                            ajax: {
                                url: "<?php echo $this->Html->url('/sheetRides/getSheetRidesByKeyWord')?>",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        q: $.trim(params.term)
                                    };
                                },
                                processResults: function (data, page) {
                                    return {results: data};
                                },
                                cache: true
                            },
                            minimumInputLength: 3

                        });



            $('.select-search-client').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getClientsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });

            $('.select-search-client-initial').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });


            $('.select-search-client-initial-category').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            categoryId : jQuery('#category').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });


            $('.select-search-client-final').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId :jQuery('#client').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });

            $('.select-search-mission').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/sheetRideDetailRides/getMissionsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
            if(jQuery('#cars').val()){
                var carId = jQuery('#cars').val();
            }else {
                var carId='';
            }
            if(jQuery('#car_type').val()){
                var carTypeId = jQuery('#car_type').val();
            }else {
                var carTypeId='';
            }



            $('.select-search-car').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/cars/getCarsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        console.log('term');
                        console.log(params.term);
                        console.log();
                        return {
                            q: params.term.trim(),
                            controller :jQuery('#controller').val(),
                            action :jQuery('#current_action').val(),
                            carId : carId,
                            carTypeId : carTypeId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });


            if(jQuery('#customers').val()){
                var customerId = jQuery('#customers').val();
            }else {
                var customerId='';
            }

            $('.select-search-customer').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/customers/getCustomersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller :jQuery('#controller').val(),
                            action :jQuery('#current_action').val(),
                            customerId : customerId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });



            $('.select-search-supplier').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
            $('.select-search-subcontractor').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getSubcontractorsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });




            $('.select-search-conveyor').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/customers/getConveyorsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller :jQuery('#controller').val(),
                            action :jQuery('#current_action').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });




            if(jQuery('#remorques').val()){
                var remorqueId = jQuery('#remorques').val();
            }else {
                var remorqueId='';
            }
            $('.select-search-remorque').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/cars/getRemorquesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller :jQuery('#controller').val(),
                            action :jQuery('#current_action').val(),
                            remorqueId : remorqueId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });

            jQuery(".date").datetimepicker({

                format: 'DD/MM/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }


            });

            $('.date').click(function () {
                var popup = $(this).offset();
                var popupTop = popup.left;
                $('.bootstrap-datetimepicker-widget').css({
                    'bottom': 10,
                    'left': 10,
                    'height': 250,
                    'top': 38,
                    'z-index': 99999,
                    'background-color': '#fff',
                    'font-size': 11


                });
            });

            jQuery("li.view-link").tooltip({
                tooltipClass: "tooltip-view-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.edit-link").tooltip({
                tooltipClass: "tooltip-edit-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.delete-link").tooltip({
                tooltipClass: "tooltip-delete-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.mail-link").tooltip({
                tooltipClass: "tooltip-mail-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery(".transport-bil-actions li.mail-link").tooltip({
                tooltipClass: "tooltip-small-mail-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.parameter-mail-link").tooltip({
                tooltipClass: "tooltip-parameter-mail-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.lock-link").tooltip({
                tooltipClass: "tooltip-lock-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.unlock-link").tooltip({
                tooltipClass: "tooltip-unlock-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.pv-reception-link").tooltip({
                tooltipClass: "tooltip-pv-reception-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.pv-restitution-link").tooltip({
                tooltipClass: "tooltip-pv-restitution-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.decharge-link").tooltip({
                tooltipClass: "tooltip-decharge-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });

            jQuery("li.localisation-link").tooltip({
                tooltipClass: "tooltip-localisation-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.attachments-link").tooltip({
                tooltipClass: "tooltip-attachments-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-attachments-link").tooltip({
                tooltipClass: "tooltip-missing-attachments-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-passport-link").tooltip({
                tooltipClass: "tooltip-missing-passport-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-driver-license-link").tooltip({
                tooltipClass: "tooltip-missing-driver-license-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-identity-card-link").tooltip({
                tooltipClass: "tooltip-missing-identity-card-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-image-link").tooltip({
                tooltipClass: "tooltip-missing-image-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });

            jQuery("li.missing-attachments-grey-link").tooltip({
                tooltipClass: "tooltip-missing-attachments-grey-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-attachments-yellow-link").tooltip({
                tooltipClass: "tooltip-missing-attachments-yellow-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.missing-attachments-pictures-link").tooltip({
                tooltipClass: "tooltip-missing-attachments-pictures-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.print-link").tooltip({
                tooltipClass: "tooltip-print-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.duplicate-link").tooltip({
                tooltipClass: "tooltip-duplicate-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });
            jQuery("li.revive-link").tooltip({
                tooltipClass: "tooltip-revive-styling",
                show: {
                    effect: "slideDown",
                    delay: 250
                },
                position: {
                    my: "left top",
                    at: "left bottom"
                }

            });

        });
        function disable() {
            var bouton = document.getElementById('boutonValider');  // Et on DECLARE les variables avec var.
            bouton.disabled = "disabled";
            bouton.value = "Envoi...";
        }

    </script>

<?php $this->end(); ?>