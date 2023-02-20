<script>
    jQuery(document).ready(function () {
        jQuery('#order_type').change(function () {
            let selectedType = jQuery(this).val();
            let tvaElements = jQuery("[id^=tva]");
            if (selectedType === '2'){
                tvaElements.each(function (el) {
                    jQuery(this).val("3");
                    jQuery(this).trigger("change");
                });
            }else{
                tvaElements.each(function (el) {
                    jQuery(this).val("1");
                    jQuery(this).trigger("change");
                });
            }
        });
    });
</script>