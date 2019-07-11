<section class="account-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Your Account</h2>
    <h5 class="sub-title">Welcome back <?php echo $username; ?></h5>
    

</section>

<section id="account">
    <div class="container">
        <div class="row">
                <div class="col-sm-6 col-md-3">
                    <a href="<?php echo base_url; ?>/index.php/account/profile">
                        <div class="box profile">
                            <hr />
                            <P>Profile</p>
                            <i class="fa fa-user"></i>
                            <button>Update</button>
                        </div>
                    </a>
                </div>
                <div class=" col-sm-6 col-md-3">
                    <a href="<?php echo base_url; ?>/index.php/account/orders">
                        <div class="box orders">
                            <hr />
                            <P>Orders</p>
                            <i class="fa fa-box-open"></i>
                            <div class="count"><?php echo $orders_count; ?></div>
                        </div>
                    </a>
                </div>
                <div class=" col-sm-6 col-md-3">
                    <a href="<?php echo base_url; ?>/index.php/account/invoice">
                        <div class="box invoice">
                            <hr />
                            <P>Invoice</p>
                            <i class="fab fa-cc-mastercard"></i>
                            <div class="count"><?php echo $invoice_count; ?></div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3">
                    <a href="<?php echo base_url; ?>/index.php/account/reviews">
                        <div class="box review">
                            <hr />
                            <P>Reviews</p>
                            <i class="fa fa-thumbs-up"></i>
                            <div class="count"><?php echo $reviews_count; ?></div>
                        </div>
                    </a>
                </div>
            </div>
    </div>
</section>