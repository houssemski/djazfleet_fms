<script>
    function handleCatgeoryChange(event, element, targetElementId) {
        let selectedCategory = jQuery(element).val();
        let carTypesRelatedToCategory = getCarTypesByCategoryAjax(selectedCategory);
        jQuery('#' + targetElementId).empty().select2({
            data: carTypesRelatedToCategory
        });
    }

    function getCarTypesByCategoryAjax(selectedCategory) {
        let carTypesRelatedToCategory = [];
        jQuery.ajax({
            type: "GET",
            url: "<?php echo $this->Html->url('/carTypes/getCartTypesByCategoryAjax') ?>",
            data: {
                carCategoryId: selectedCategory
            },
            dataType: "json",
            async: false,
            success: function(data) {
                carTypesRelatedToCategory = data;
            }
        });
        return carTypesRelatedToCategory;
    }
</script>