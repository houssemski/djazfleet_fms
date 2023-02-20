
<script>
    jQuery(document).on('click', '.batch-add-serial-number', function() {
        var lineNumber = this.getAttribute('line-number');

        launchAddSerialNumberModal(lineNumber);
    });
    jQuery(document).on('click', '.batch-enter-serial-number', function() {
        var lineNumber = this.getAttribute('line-number');
        launchAddSerialNumberModal(lineNumber);
    });

    jQuery(document).on('click', '.batch-edit-serial-number', function() {
        var lineNumber = this.getAttribute('line-number');;
        launchEditSerialNumberModal(lineNumber);
    });

    jQuery(document).on('click', '.batch-change-serial-number', function() {
        var lineNumber = this.getAttribute('line-number');
        launchEditSerialNumberModal(lineNumber);
    });

    function launchAddSerialNumberModal(lineNumber) {
        if (jQuery("#quantity-" + lineNumber).val() == 0 ||
            jQuery("#quantity-" + lineNumber).val() == '') {
            alert('<?= __('Quantity must be greater than 1') ?>');
        } else {
            var addSerialNumbersModal = jQuery('#form-modal-add-serial-numbers');
            var productQuantity = jQuery("#quantity-" + lineNumber).val();

            var modalBodyElement = jQuery('#form-modal-add-serial-numbers .modal-body #serial-numbers-table');
            var serialNumbers = getSerialNumbers(productQuantity, lineNumber);
            var serialNumberIds = getSerialNumberIds(productQuantity, lineNumber);
            var serialNumberLabels = getSerialNumberLabels(productQuantity, lineNumber);
            var serialNumberExpirationDates = getSerialNumberExpirationDates(productQuantity, lineNumber);

            var loadModalUrl = '<?php echo $this->Html->url( "ajaxAddSerialNumbers"
            ); ?>' + "/" + productQuantity + "/" + lineNumber + "/" + serialNumbers + "/" + serialNumberIds + "/" +serialNumberLabels+"/"+serialNumberExpirationDates;
            modalBodyElement.load(loadModalUrl, function() {
                /* REINITIALIZATION */
                addSerialNumbersModal.modal('show');

                for (var i = 1; i <= productQuantity; i++) {
                    jQuery("#expiration-date-" + '' + lineNumber + '-'+i).inputmask("date", {"placeholder": "dd/mm/yyyy"});
                }

            });
        }
    }

    function launchEditSerialNumberModal(lineNumber) {
        var billProductId = jQuery("#bill_product" + lineNumber).val();
        var addSerialNumbersModal = jQuery('#form-modal-add-serial-numbers');
        var productQuantity = jQuery("#quantity-" + lineNumber).val();
        var newSerialNumbers = getSerialNumbers(productQuantity, lineNumber);
        var serialNumberIds = getSerialNumberIds(productQuantity, lineNumber);
        var modalBodyElement = jQuery('#form-modal-add-serial-numbers .modal-body #serial-numbers-table');
        var newSerialNumberLabels = getSerialNumberLabels(productQuantity, lineNumber);
        var newSerialNumberExpirationDates = getSerialNumberExpirationDates(productQuantity, lineNumber);
        // If the user is authorized
        var loadModalUrl = '<?php echo $this->Html->url("ajaxEditSerialNumbers"
            ); ?>' + "/" + productQuantity + "/" + lineNumber + "/" + billProductId +
            "/" + newSerialNumbers + "/" + serialNumberIds + "/" +newSerialNumberLabels+"/"+newSerialNumberExpirationDates;

        modalBodyElement.load(loadModalUrl, function() {
            /* REINITIALIZATION */
            addSerialNumbersModal.modal('show');

            for (var i = 1; i <= productQuantity; i++) {
                jQuery("#expiration-date-" + '' + lineNumber + '-'+i).inputmask("date", {"placeholder": "dd/mm/yyyy"});
            }

        });
    }

    function getSerialNumbers(productQuantity, lineNumber) {

        var serialNumbers = [];
        for (var i = 1; i <= productQuantity; i++) {
            if (typeof jQuery("#serial-" + lineNumber + '-' + i).val() !== 'undefined' &&
                jQuery("#serial-" + lineNumber + '-' + i).val() !== ''
            ) {
                serialNumbers.push(jQuery("#serial-" + lineNumber + '-' + i).val());
            }
        }
        if (serialNumbers.length > 0) {
            return serialNumbers;
        } else {
            return null;
        }
    }

    function getSerialNumberIds(productQuantity, lineNumber) {
        var serialNumberIds = [];

        for (var i = 1; i <= productQuantity; i++) {
            if (typeof jQuery("#serial-id-" + lineNumber + '-' + i).val() !== 'undefined' &&
                jQuery("#serial-id-" + lineNumber + '-' + i).val() !== ''
            ) {
                serialNumberIds.push(jQuery("#serial-id-" + lineNumber + '-' + i).val());
            }
        }
        if (serialNumberIds.length > 0) {
            return serialNumberIds;
        } else {
            return null;
        }

    }

    function getSerialNumberLabels(productQuantity, lineNumber) {
        var serialNumberLabels = [];

        for (var i = 1; i <= productQuantity; i++) {
            if (typeof jQuery("#label-serial-" + lineNumber + '-' + i).val() !== 'undefined' &&
                jQuery("#label-serial-" + lineNumber + '-' + i).val() !== ''
            ) {
                serialNumberLabels.push(jQuery("#label-serial-" + lineNumber + '-' + i).val());
            }
        }
        if (serialNumberLabels.length > 0) {
            return serialNumberLabels;
        } else {
            return null;
        }

    }
    function getSerialNumberExpirationDates(productQuantity, lineNumber) {
        var serialNumberExpirationDates = [];

        for (var i = 1; i <= productQuantity; i++) {
            if (typeof jQuery("#expiration-date-" + lineNumber + '-' + i).val() !== 'undefined' &&
                jQuery("#expiration-date-" + lineNumber + '-' + i).val() !== ''
            ) {
                var myDate = jQuery("#expiration-date-" + lineNumber + '-' + i).val();
                myDate = myDate.split("/");
                var newDate = new Date( myDate[2], myDate[1] - 1, myDate[0]);

                newDate = Date.parse(newDate)/1000;
                serialNumberExpirationDates.push(newDate);
            }
        }
        if (serialNumberExpirationDates.length > 0) {
            return serialNumberExpirationDates;
        } else {
            return null;
        }


    }
</script>
