<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Remote Skills Test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Datatables library -->
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" >
        <link rel="stylesheet" href="css/product.css" >
        <script src="js/product.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <h1 class="text-center">Remote skills test</h1>
            <div class=" col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Product</div>
                    <div class="panel-content"><br>
                        <form class="form-horizontal" id="new-product-form" >
                            <div class="form-group">
                                <label for="product_name" class="control-label col-sm-4">Product Name:</label>
                                <div class="col-sm-6"><input name="product_name" required="required" type="text" class="form-control"></div>
                            </div><br>
                            <div class="form-group">
                                <label for="quantity" class="control-label col-sm-4">Quantity in stock:</label>
                                <div class="col-sm-2"><input name="quantity" required="required" type="number" class="form-control"></div>
                            </div><br>
                            <div class="form-group">
                                <label for="price" class="control-label col-sm-4">Price per item (in $):</label>
                                <div class="col-sm-2"><input name="price" required="required" step="0.01" type="number" class="form-control"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6 text-center"><button class="btn btn-default" name="reset" type="button">Reset</button></div>
                                <div class="col-sm-6 text-center"><button class="btn btn-primary" name="submit" type="submit">Submit</button></div>
                            </div><br>
                        </form>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="row alert alert-success collapse" style="font-size:18px"><strong><span class="help-block text-center" id="notification_success"></span></strong></div>
                                <div class="row alert alert-danger collapse" style="font-size:18px"><strong><span class="help-block text-center" id="notification_error"></span></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 col-sm-offset-2">
                <h2>Product Inventory</h2>
                <table class="display table table-bordered table-striped" width="100%" id="product_table">
                    <thead>
                        <tr>
                            <th>SNO</th>
                            <th>Product Name</th>
                            <th>Quantity in stock</th>
                            <th>Price per item (in $)</th>
                            <th>Total value number</th>
                            <th>Submitted Date & Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>