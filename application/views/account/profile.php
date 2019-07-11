<section class="account-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Your Details</h2>
    <h5 class="sub-title">Review and update your personal and shipping details</h5>
    

</section>

<section class="profile">
    <div class="container">
    <?php 
        if(isset($info)){echo '<p>'.$info.'</p>';}  
        $attributes = array('class' => 'details-form');
        echo form_open('account/profile/', $attributes);
    ?>
        <div class="row">
            <div class="col-md-6">
                <button type="sumbit" class="btn btn-primary btn-sm">Update</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
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
                        <div class="form-group">
                            <div class="text-danger"><?php echo form_error('old_password');?></div>
                            <div class="text-danger"><?php echo form_error('password');?></div>
                            <input type="button" class="btn btn-secondary password_change btn-sm" value="Change Password" />
                            <div class="password_change_block"><br>
                                <input type="password" name="old_password" class="form-control password" value="<?php  echo ''; ?>" id="password" placeholder="Enter old password"/><br/>
                                <input type="password" name="password" class="form-control password" value="<?php echo ''; ?>" id="password" placeholder="Enter new password"/>
                                <input type="button" class="btn btn-link btn-sm show_password" value="show"/>
                                <input type="button" class="btn btn-link btn-sm hide_password" value="hide"/>
                                <input type="button" class="btn btn-link btn-sm cancel_password_change" value="Cancel"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkout-data">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <button type="sumbit" class="btn btn-primary btn-sm">Update</button>
        </div>
        </form>
    </div>
</section>