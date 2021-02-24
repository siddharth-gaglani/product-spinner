<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lets Spin</title>
        <!-- Latest compiled and minified CSS -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <style>
            .spin-image img{
                max-width:100%;
                max-height:100%;
            }
            .product_count{
                position:absolute;
                top:0;
                left:0;
                border:1px solid #111;
                border-radius: 50% 50%;
                width:20px;
                height:20px;
            }


            .rotate { 
                -moz-animation: 1s rotate infinite linear  ;
                -moz-transform-origin: 50% 50%; 
                -webkit-animation: 1s rotate infinite linear  ;
                -webkit-transform-origin: 50% 50%;  
            }

            @-moz-keyframes rotate {
                0    { -moz-transform: rotate(0); } 
            100% { -moz-transform: rotate(360deg); }  
            }

            @-webkit-keyframes rotate {
                0%    { -webkit-transform: rotate(0); }
            100% { -webkit-transform: rotate(360deg); } 
            }
        </style>
        <script>
            var BASE_URL = "<?php echo site_url() . "/"; ?>";
            var URL = "<?php echo base_url() . "/"; ?>";
        </script>
    </head>
    <body>
        <div class="container" >
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="direction: rtl">
                    Hi <?php echo $this->session->userdata('name') ?> <a href="<?php echo site_url('login/logout') ?>">Logout</a>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 id="info">Try your luck to buy a product</h1>
                    <h3>You have <span id="total_points"><?php echo $user_details['total_points'] ?></span> points.</h3>
                </div>
            </div>
            <br/>
            <?php $count = 0; ?>
            <div class="row text-center">
                <?php for ($i = 0; $i < $meta['total_images']; $i++) { ?>
                    <?php $count++; ?>
                    <div class="col-xs-4 col-md-4 col-lg-4 col-sm-4">
                        <div class="spin-image">
                            <img class="spin-image-tag" id="image<?php echo $i; ?>" src="<?php echo base_url('assets/images/spin_images/default.png') ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <br/>
            <br/>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div id="points_earned"></div>
                    <button id="spin-now" class="btn btn-primary btn-lg">Spin Now</button>
                </div>
            </div>
            <br/><br/><br/>
            <div class="row all_products text-center <?php echo $user_details['total_points'] == 0 ? 'hide' : '' ?>">
                <h1>Product List</h1>
                <?php if ($products != false) { ?>
                    <?php foreach ($products as $product) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" >
                            <div class="product_block" style="position:relative">
                                <span class="product_count"><?php echo $user_products != false && array_key_exists($product['id'], $user_products) ? sizeof($user_products[$product['id']]) : '0' ?></span>
                                <img class="product_image" src="<?php echo base_url($product['product_image_location']); ?>">
                                <br/>
                                Points Required: <?php echo $product['points_required']; ?>
                                <br/>
                                <div class="message"></div>
                                <button data-product-id="<?php echo $product['id'] ?>" class="redeem" class="btn btn-primary btn-sm">Redeem</button>

                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.27/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets/js/app.js') ?>"></script>
    </body>
</html>
