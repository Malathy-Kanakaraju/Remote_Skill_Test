$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("button[name=reset]").on('click', function () {
        $("input").val('');
        $(".alert-success").hide();
        $(".alert-danger").hide();
    })

    $("#new-product-form").on("submit", function (e) {
        $(".alert-success").hide();
        $(".alert-danger").hide();
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
                $(".alert-success").show();
                product_table.ajax.reload();
            }, error: function (error) {
                //console.log('error', error);
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
                $(".alert-danger").show();
            }
        });
    })

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
                    output[i][6] = "<a href='/editProduct/" + (response[i].product_name) + "'>Edit</a>";
                }
                return output;
            }
        }
    }).draw();
});