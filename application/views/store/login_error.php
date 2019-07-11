<section class="cart-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Checkout</h2>
    <h5 class="sub-title">You currently have <?php echo '<span class="item-no">'.count($this->session->cart).'</span>'; ?> item(s) in your cart.</h5>
    

</section>

<section>
    <div class=" col-10 col-md-4 login-error " >
        <h6>Unable to view page, user not logged in! <br/> Please click <a href="javascript:void(0)" onclick="login()">here</a> to login.</h6>
    </div>
</section>