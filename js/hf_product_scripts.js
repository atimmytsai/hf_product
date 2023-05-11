jQuery(document).ready(function($) {
    var categorySelect = $('#category-filter');
    var materialSelect = $('#material-filter');
    var voltageSelect = $('#voltage-filter');
    var output = $('#hf-product-list');

    var updateProducts = function() {
        var category = categorySelect.val();
        var material = materialSelect.val();
        var voltage = voltageSelect.val();

        $.ajax({
            url: hf_ajax_object.ajaxurl,
            //hf_ajax_object.ajaxurl
            //ajaxurl
            type: 'POST',
            data: {
                action: 'hf_product_filter',
                category: category,
                material: material,
                voltage: voltage
            },
            beforeSend: function() {
                output.html('<p>Loading products...</p>');
            },
            success: function(data) {
                output.html(data.data.products);
            },
            error: function(xhr, status, error) {
                output.html('<p>Error: ' + error + '</p>');
            }
        });
    }

    categorySelect.add(materialSelect).add(voltageSelect).on('change', function() {
        updateProducts();
    });

    // Update filter options dynamically
    var updateFilterOptions = function() {
        var category = categorySelect.val();
        var material = materialSelect.val();
        var voltage = voltageSelect.val();

        $.ajax({
            url: hf_ajax_object.ajaxurl,
            //ajaxurl
            type: 'POST',
            data: {
                action: 'hf_update_filter_options',
                category: category,
                material: material,
                voltage: voltage
            },
            success: function(data) {
                categorySelect.html(data.data.category_options);
                materialSelect.html(data.data.material_options);
                voltageSelect.html(data.data.voltage_options);
                updateProducts(); // Update products when filter options are updated
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    };

    // Call the updateFilterOptions function on page load
    updateFilterOptions();
});