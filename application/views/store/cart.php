<section class="cart-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Your Cart</h2>
    <h5 class="sub-title">You currently have <?php echo '<span class="item-no">'.count($this->session->cart).'</span>'; ?> item(s) in your cart.</h5>
    

</section>

<section>
    <div class="container-fluid back-shop">
        <i class="fa fa-caret-left"></i><a href="<?php echo base_url.'/index.php/store'?>"> Continue Shopping</a>
    </div>
<div class="container">
    <div class="row">
        <div class=" col-sm-12 col-md-8 cart-items">
            <div class="cart-head">
                <span>ITEMS (<?php echo '<span class="item-no">'.count($this->session->cart).'</span>'; ?>)</span>
            </div>
            <?php 
                $total_price = 0;
                if($cart_items != false)
                {

                    foreach($cart_items as $cart_products)
                    { 
                        $url_name = str_replace(" ", "-", $cart_products['product_name']);
                        ?>
                        <div class="row item">
                            <div class="col-md-3">
                                <div class="box">
                                    <img src="<?php echo $cart_products['product_image_url']; ?>"  alt="No Image" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <p class="name"><?php echo $cart_products['product_name']; ?></p>
                                    <div class="detail">
                                        <label>Owner:</label><span class="owner"><?php echo $cart_products['owner']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label>Weight:</label><span class="weight"><?php echo $cart_products['weight']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label>Qty:</label><span class="quantity"><?php echo $this->session->cart[$cart_products['id']]['quantity']; ?></span>
                                    </div>
                                    <div class="detail">
                                        <label>Unit Price: </label><span class="detail"><span> &#8358;</span><?php echo $cart_products['price']; ?></span>
                                    </div>
                                    <div class="buttons">
                                        <button status="0" id="<?php echo $cart_products['id']; ?>" price="<?php echo $cart_products['price']*$this->session->cart[$cart_products['id']]['quantity']; ?>" class="remove_cart">Remove</button>
                                        <a href="<?php echo base_url.'/index.php/store/view_product/'.$url_name; ?>"><button>Edit</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p class="per-total-price"><span>&#8358;</span><?php echo $cart_products['price']*$this->session->cart[$cart_products['id']]['quantity']; ?> </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $total_price += $cart_products['price'] * $this->session->cart[$cart_products['id']]['quantity'];
                    }
                }
                ?> 
        </div>
            
        <div class=" col-sm-12 col-md-4 cart-summary">
            <div class = "box">
                <div>
                    <h3>Order summary</h3>
                </div>
                <p class="text-muted">Delivery and additional costs are calculated based on the values you have entered.</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Order subtotal</td>
                                <th><span>&#8358;</span><?php echo '<span class="sub-total">'.$total_price.'</span>'; ?></th>
                            </tr>
                            <tr>
                                <td>Delivery and handling</td>
                                <th>Free<?php $delivery = 0 ?></th>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <th><span>&#8358;</span><?php echo '<span class="total">'.($total_price + $delivery).'</span>'; ?></th>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?php echo base_url.'/index.php/store/checkout'?>"><button class="checkout" <?php if(count($this->session->cart) == 0){echo 'disabled'; } ?>> checkout </button></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
//session_destroy();
//print_r($_SESSION['cart']);
//$_SESSION['cart']['8']['quantity'] = '34';
//unset($_SESSION['wishlist'])?>
