<section class="cart-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Checkout</h2>
    <h5 class="sub-title">You currently have <?php echo '<span class="item-no">'.count($this->session->cart).'</span>'; ?> item(s) in your cart.</h5>
    

</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <?php 
                if(isset($info)){echo '<p>'.$info.'</p>';}  
                $attributes = array('class' => 'checkout-form');
                echo form_open('store/checkout/', $attributes);
            ?>
                <div class="checkout-data">
                    <div class="box">
                        <h4 class="title">Personal Data</h4>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('first_name');?></div>
                            <label for="first_name"> First Name* </label>
                            <input type="text" name="first_name" class="form-control" value="<?php if(set_value('first_name')){echo set_value('first_name');}else{ echo $first_name;}?>" id="first_name" placeholder="Enter First Name"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('last_name');?></div>
                            <label for="last_name"> Last Name* </label>
                            <input type="text" name="last_name" class="form-control" value="<?php if(set_value('last_name')){echo set_value('last_name');}else{ echo $last_name;}?>" id="last_name" placeholder="Enter Last Name"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('user_name');?></div>
                            <label for="user_name"> User Name* <i>(user name can not be edited)</i></label>
                            <input type="text" name="user_name" readonly class="form-control" value="<?php echo $user_name;?>" id="user_name" placeholder="Enter UserName"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('display_name');?></div>
                            <label for="display_name"> Display Name* <i>(required)</i>  </label>
                            <input type="text" name="display_name" class="form-control" value="<?php if(set_value('display_name')){echo set_value('display_name');}else{ echo $display_name;}?>" id="display_name" placeholder="Enter Display Name"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('email');?></div>
                            <label for="email"> Email Address* </label>
                            <input type="email" name="email" class="form-control" value="<?php if(set_value('email')){echo set_value('email');}else{ echo $user_email;}?>" id="email" placeholder="Enter Email Address"/>
                        </div>
                    </div>
                    <div class="box">
                        <div class="form-group">
                        <h4 class="title">Delivery Address</h4>
                            <label for="country"> Country* </label>
                            <input type="text" class="form-control" name="country" id="country" value="Nigeria" readonly />
                            <input type="hidden" name="country_code" class="form-control" value="+234" id="country_code"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('phone');?></div>
                            <label for="phone" style="display:block"> Phone Number* </label>
                            <input type="tel" name="phone" class="form-control phone" value="<?php if(set_value('phone')){echo set_value('phone');}else{ echo $user_phone;} ?>" id="phone" placeholder=""/>
                            <input type="text" name="phone_code" readonly="readonly" class="form-control phone_code" value="" id="phone_code"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('home');?></div>
                            <label for="home"> Address* </label>
                            <input type="text" name="home" class="form-control" value="<?php if(set_value('home')){echo set_value('home');}else{ echo $home;} ?>" id="home" placeholder="Enter your address"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('state');?></div>
                            <label for="state"> State* </label>
                            <input type="text" name="state" class="form-control" value="<?php if(set_value('state')){echo set_value('state');}else{ echo $state;} ?>" id="state" placeholder="Enter Your State"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('city');?></div>
                            <label for="city"> City/LGA* </label>
                            <input type="text" name="city" class="form-control" value="<?php if(set_value('city')){echo set_value('city');}else{ echo $city;} ?>" id="city" placeholder="Enter your City"/>
                        </div>
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('postal_code');?></div>
                            <label for="postal_code"> Postal Code* </label>
                            <input type="text" name="postal_code" class="form-control" value="<?php if(set_value('postal_code')){echo set_value('postal_code');}else{ echo $postal_code;}?>" id="postal_code" placeholder="Enter Your Postal Code"/>
                        </div>
                        <div class="form-group">
                            <label for="description"> Order note </label>
                            <textarea class="form-control" name="description" placeholder="Enter short note here....."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-sm-12 offset-md-1 col-md-4">
                <div class="payment-review">
                    <div class="box">
                        <h4 class="title">Payment & Review</h4>
                        <?php 
                            $total_price = 0;
                            if($cart_items != false)
                            {
                                foreach($cart_items as $cart_products)
                                {
                                    echo '<div class="item">';
                                    echo '<span class="name">'.$cart_products['product_name'].'</span>';
                                    echo '<span class="quantity">'.$this->session->cart[$cart_products['id']]['quantity'].'x</span>';
                                    echo '<span class="price"><span>&#8358;</span>'.$cart_products['price']*$this->session->cart[$cart_products['id']]['quantity'].'</span>';
                                    echo '</div>';
                                    $total_price += $cart_products['price'] * $this->session->cart[$cart_products['id']]['quantity'];
                                }
                            }
                        ?>
                        <div><span class="delivery-title">Delivery and handling </span> <span class="delivery-fee"> Free<?php $delivery = 0 ?></span></div>
                        <div class="total"> 
                            <span class="total-title">Total</span>
                            <span class="total-fee">&#8358;<?php echo $total_price + $delivery ?></span>
                        </div>  
                        
                        
                        <h5 class="title">Mode of payment</h5>
                        <div class="custom-control custom-radio">
                            <input type="radio" checked class="custom-control-input" id="paystack" name="payment" value="paystack">
                            <label class="custom-control-label" for="paystack"><img src="<?php echo base_url; ?>/images/paystack-logo.png" height="25" alt="Paystack (Web pay)"/></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="bank" name="payment" value="bank">
                            <label class="custom-control-label" for="bank"><img src="<?php echo base_url; ?>/images/atm-bank.png" height="30" alt="ATM/Bank Transaction"/></label>
                        </div>
                        <div class="text-danger"><?php echo form_error('payment');?></div>
                    </div>
                    <button type="submit" name="submit" class="checkout-btn">checkout <span><i class="fa fa-arrow-circle-right"></i></span></span></button>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>
<?php //print_r($_SESSION['cart']);
//$_SESSION['cart']['8']['quantity'] = '34';
//unset($_SESSION['wishlist'])?>
