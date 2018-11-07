$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("button[name=reset]").on('click', function () {
        $("input").val('');
        $("#new-success").hide();
        $("#new-danger").hide();
    })

    /*
     * On form submit, add the new product
     */
    $("#new-product-form").on("submit", function (e) {
        $("#new-success").hide();
        $("#new-danger").hide();
        e.preventDefault();
        var data = $(this).serialize();
        var self = this;

        $.ajax({
            'url': '/products/add',
            'method': 'POST',
            'data': data,
            success: function (output) {
                $("input").val('');
                $("#notification_success").html("Product added successfully!");
                $("#new-success").show();
                product_table.ajax.reload();
            }, error: function (error) {
                console.log('error', error);
                var response = $.parseJSON(error.responseText);
                var errorMessage = '';
                if ((typeof response.message === 'string') || response.message instanceof String) {
                    errorMessage = response.message;
                } else {
                    $.each(response.message, function (key, value) {
                        errorMessage += value + '<br>';
                    });
                }
                $("#notification_error").html(errorMessage);
                $("#new-danger").show();
            }
        });
    })

    /*
     * Load the table with fresh content from file
     */
    var product_table = $('#product_table').DataTable({
        ajax: {
            'url': '/products',
            'method': 'GET',
            dataSrc: function (result) {
                var response = result['inventory']
                var output = [];
                for (var i = 0; i < response.length; i++) {
                    output[i] = new Array();
                    output[i][0] = i;
                    output[i][1] = response[i].product_name;
                    output[i][2] = response[i].quantity;
                    output[i][3] = response[i].price;
                    output[i][4] = response[i].total_value;
                    output[i][5] = response[i].date_time;
                    output[i][6] = "<a href='#' class='editProduct' id='" + (response[i].product_name) + "'>Edit</a>";
                }
                return output;
            }
        }
    }).draw();

    /*
     * To show the values in modal to edit a product
     */
    $(document).on('click', ".editProduct", function (e) {
        e.preventDefault();
        $("#edit-danger").hide();
        var product_name = $(this).attr('id');
        $.ajax({
            'url': '/product/show/' + product_name,
            'method': 'GET',
            success: function (output) {
                //show modal
                $("input[name='old_product_name']").val(output.product.product_name);
                $("input[name='edit_product_name']").val(output.product.product_name);
                $("input[name='edit_quantity']").val(output.product.quantity);
                $("input[name='edit_price']").val(output.product.price);
                $("#editModal").modal("show");
            }, error: function (error) {
                console.log('error', error);
            }
        });
    });

    /*
     * To update the values of existing product
     */
    $("#edit-product-form").on('submit', function (e) {
        e.preventDefault();
        $("#edit-danger").hide();
        var data = $(this).serialize();
        $.ajax({
            'url': '/product/edit/',
            'method': 'POST',
            'data': data,
            success: function (output) {
                $("#editModal").modal("hide");
                $("#notification_success").html("Product edited successfully!");
                $("#new-success").show();
                product_table.ajax.reload();
            }, error: function (error) {
                console.log('error', error);
                var response = $.parseJSON(error.responseText);
                var errorMessage = '';
                if ((typeof response.message === 'string') || response.message instanceof String) {
                    errorMessage = response.message;
                } else {
                    $.each(response.message, function (key, value) {
                        errorMessage += value + '<br>';
                    });
                }
                $("#edit_notification_error").html(errorMessage);
                $("#edit-danger").show();
            }
        });
    });

});